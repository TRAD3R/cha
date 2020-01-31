<?php
namespace App\Helpers;

use App\App;
use App\Lib\Helpers\FileHelper;
use App\Models\Device;
use App\Models\DeviceSpecification;
use App\Models\EAN;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Repositories\DeviceRepository;
use App\Repositories\ProductRepository;
use App\Tables\ListingTableStructure;
use App\Tables\ProductTableStructure;
use App\Tables\XlsStructure;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;
use Yii;
use yii\db\Query;

class ListingHelper
{
    const PER_PAGE = 100;
    const PER_CICLE = 500; // Количество товаров для очередной записи в файл

    /** @var Query|null $query */
    private $query = null;
    
    const PRODUCTS = 'products';
    const DEVICES = 'devices';
    const LINES = 'lines';
    const TEMPLATE_AMAZON = 'amazon_listing_template.xlsx';
    const FILETYPE = 'xlsx';
    const FILENAME = 'filename';
    const IDS = 'ids';
    const PROGRESS_FILE = "/files/progress";

    private $currentRowNumber = 4;

    const MACROS_DEVICE_BRAND = '{DEVICE_BRAND}';
    const MACROS_DEVICE_MODEL = '{DEVICE_NAME}';
    const SKU_PREFIX = 'cha-';

    const ACTION_TYPE_UPDATE = 0;
    const ACTION_TYPE_DELETE = 1;

    /** @var Spreadsheet|null */
    private $spreadsheet = null;
    private $newFilename = null;
    
    /** @var \Box\Spout\Writer\XLSX\Writer|null  */
    private $writer = null;

    private static $progress = '0';
    private $actionType;
    private $errors = [];
    private $tempFile = "";
    private $csvRows = [];
    
    private $selectedDevices = [];       // id девайсов, которые выбрала Ира на странице
    
    private $totalGadgets = 1;
    private $finishedGadgets = 0;
    
    public function __construct($newFilename, $actionType = self::ACTION_TYPE_UPDATE)
    {
        $this->tempFile = Yii::getAlias("@Web") . "/files/temp.csv";
        $this->actionType = $actionType;

        $this->setProgress();
        $this->getFilename($newFilename);
    }

    /**
     * Проверка на уникальность имени файла
     *
     * @param string $filename
     *
     * @return boolean
     */
    public static function isUniqueFilename(string $filename)
    {
        $dir = Yii::getAlias("@out");

        return !is_file($dir . DIRECTORY_SEPARATOR . $filename);
    }

    /**
     * @return array
     */
    public static function getAllFiles()
    {
        $files = array_diff(scandir(Yii::getAlias("@out")), array('..', '.', '.gitignore'));
        
        $res = [];
        
        if($files){
            foreach ($files as $file) {
                $res[$file] = App::i()->getFile()->getFullUrl("/out/" . $file);
            }
        }
        return $res;
    }

    private function setProgress()
    {
        file_put_contents(Yii::getAlias("@Web") . self::PROGRESS_FILE, number_format($this->finishedGadgets / $this->totalGadgets * 100, 2));
    }
    
//    public function createDevices($deviceIds, string $newFilename, $actionType = self::ACTION_TYPE_UPDATE)
//    {
//        ini_set('max_execution_time', 0);
//
//        if($this->getFilename($newFilename)) {
//            
//            $this->selectedDevices = $deviceIds;
//            
//            $products = $this->getLinkedProducts($deviceIds);
//            return [
//                'status' => $this->save($newFilename),
//                'errors' => $this->errors
//            ];
//        }
//        
//    }

    /**
     * @param Product[] $products
     * @param string $newFilename
     * @param int $actionType
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function createListing($products, $deviceIds = [])
    {
        ini_set('max_execution_time', 0);
        
        if($deviceIds) {
            $this->selectedDevices = is_array($deviceIds) ? $deviceIds : explode(",", $deviceIds);
        }
        
        foreach ($products as $product) {
            $deviceTypeIds = ProductRepository::getDeviceTypeIds($product);
            $devices = $this->getLinkedDevices($product->specifications->type->alias, $deviceTypeIds);

            if($product->parent_id == Product::TYPE_INDIVIDUAL) {
                $this->createIndividual($product, $devices);
            }else{
                $this->createVariation($product, $devices);
            }
        }

        return [
            'status' => $this->saveToXls(),
            'errors' => $this->errors
        ];
    }

    private function setFileProperties()
    {
        $this->spreadsheet->getProperties()
            ->setCreator(App::i()->getCurrentUser()->email)
            ->setLastModifiedBy(App::i()->getCurrentUser()->email)
            ->setTitle('Amazon listing')
        ;
    }

    private function saveToXls()
    {
        try {
            $reader = new Csv();
            /** Set CSV options */
            $reader
                ->setDelimiter("\t")
                ->setSheetIndex(0)
                    ;
            
            $spreadsheet = $reader->load($this->tempFile);
            $writer = new Xlsx($spreadsheet);
            $file = \Yii::getAlias("@out") . DIRECTORY_SEPARATOR . $this->newFilename;
            $writer->save($file);
        }catch(Exception $e){
            return false;
        }

        return true;
    }

    /**
     * @param Product $product
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    private function createIndividual(Product $product, $devices)
    {
        if($devices){
            $this->totalGadgets = count($devices) ?: 1;
            foreach ($devices as $model) {
                $this->createIndividualRow($product, $model);
                
                $this->finishedGadgets++;
                $this->setProgress();
                if($this->finishedGadgets % self::PER_CICLE == 0) {
                    $this->saveToCsv();
                }
            }
        }
    }

    /**
     * @param string $type
     * @return Device[]|null
     */
    private function getLinkedDevices(string $type = '', $deviceTypeIds)
    {
        $query = Device::find()
            ->alias('d')
            ->innerJoin('device_specifications ds', 'd.id = ds.device_id')
            ->where('1')
        ;

        switch ($type){
            case 'lightning':
            case 'microusb':
            case 'usb-c':
                $query
                    ->innerJoin('usb_type ut', "ut.id = ds.usb_type_id")
                    ->andWhere(['ut.alias' => $type, "ds.type_id" => $deviceTypeIds])
                ;
                break;
        }
        
        if($this->selectedDevices){
            $query->andWhere(['d.id' => $this->selectedDevices]);
        }
        $sql = $query->createCommand()->rawSql;
        
//        $query->limit(150);
        return $query->all();
    }

    /**
     * @param Product $product
     * @param Device $device
     * @param $rowNumber
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    private function createIndividualRow(Product $product, Device $device)
    {
        /** @var ProductSpecification $productSpecifications */
        $productSpecifications = $product->specifications;
        $newEan = $this->getNewEan("{$product->title} | {$device->brand->name} {$device->title}");

        $this->csvRows[] = [
            "A" => $productSpecifications->browseNode->node,
            "B" => $device->id,
            "C" => $newEan,
            "D" => $productSpecifications->barcodeType->type,
            "E" => $this->changeMacros($product->title, $device),
            "F" => $productSpecifications->productBrand->name,
            "G" => $productSpecifications->manufacturer->name,
            "H" => $productSpecifications->browseNode->product_type,
            "I" => PriceHelper::toFloat($productSpecifications->price),
            "J" => $productSpecifications->quantity,
            "K" => $this->getMainImage($device, $productSpecifications->sku),
            "L" => $this->getUsingImageUrl($productSpecifications->sku, 1),
            "M" => $this->getUsingImageUrl($productSpecifications->sku, 2),
            "N" => $this->getUsingImageUrl($productSpecifications->sku, 3),
            "O" => $this->getUsingImageUrl($productSpecifications->sku, 4),
            "P" => $this->getUsingImageUrl($productSpecifications->sku, 5),
            "Q" => $this->getUsingImageUrl($productSpecifications->sku, 6),
            "R" => $this->getUsingImageUrl($productSpecifications->sku, 7),
            "S" => $this->getUsingImageUrl($productSpecifications->sku, 8),
            "T" => $productSpecifications->swatch_id ? App::i()->getFile()->getFullUrl("/images/swatches/" . $productSpecifications->swatch->filename) : '',
            "U" => "",
            "V" => "",
            "W" => "",
            "X" => "",
            "Y" => $this->changeMacros($productSpecifications->description, $device),
            "Z" => $this->creatSku($productSpecifications->barcode, $device->id),
            "AA" => "",
            "AB" => $this->actionType(),
            "AC" => $productSpecifications->bulletpoint_1,
            "AD" => $productSpecifications->bulletpoint_2,
            "AE" => $productSpecifications->bulletpoint_3,
            "AF" => $productSpecifications->bulletpoint_4,
            "AG" => $productSpecifications->bulletpoint_5,
            "AH" => $this->changeMacros($productSpecifications->keywords, $device),
            "AI" => "",
            "AJ" => "",
            "AK" => "",
            "AL" => "",
            "AM" => "",
            "AN" => "",
            "AO" => "",
            "AP" => "",
            "AQ" => "",
            "AR" => "",
            "AS" => "",
            "AT" => "",
            "AU" => "",
            "AV" => "",
            "AW" => "",
            "AX" => "",
            "AY" => "",
            "AZ" => "",
            "BA" => "",
            "BB" => "",
            "BC" => "{$device->brand->name} {$device->title}",
            "BD" => $productSpecifications->length,
            "BE" => $productSpecifications->measureUnit->type,
            "BF" => "",
            "BG" => "",
            "BH" => "",
            "BI" => "",
            "BJ" => "",
            "BK" => "",
            "BL" => "",
            "BM" => "",
            "BN" => "",
            "BO" => "",
            "BP" => "",
            "BQ" => "",
            "BR" => "",
            "BS" => "",
            "BT" => "",
            "BU" => "",
            "BV" => "",
            "BW" => "",
            "BX" => "",
            "BY" => "",
            "BZ" => "",
            "CA" => "",
            "CB" => "",
            "CC" => "EUR",
            "CD" => "Neu",
            "CE" => "",
            "CF" => "",
            "CG" => "",
            "CH" => "",
            "CI" => "",
            "CJ" => "",
            "CK" => 1,
            "CL" => "",
            "CM" => "",
            "CN" => "",
            "CO" => "",
            "CP" => "",
            "CQ" => "",
            "CR" => "",
            "CS" => "",
            "CT" => "",
            "CU" => "",
            "CV" => $productSpecifications->merchant->name,
        ];
    }

    /**
     * @param Product $product
     * @param Device $device
     * @param $rowNumber
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function createParentRow(Product $product, Device $device)
    {
        /** @var ProductSpecification $productSpecifications */
        $productSpecifications = $product->specifications;

        $this->csvRows[] = [
            "A" => $productSpecifications->browseNode->node,
            "B" => $device->id,
            "C" => "",
            "D" => "",
            "E" => $this->changeMacros($product->title, $device),
            "F" => $productSpecifications->productBrand->name,
            "G" => $productSpecifications->manufacturer->name,
            "H" => $productSpecifications->browseNode->product_type,
            "I" => "",
            "J" => "",
            "K" => "",
            "L" => "",
            "M" => "",
            "N" => "",
            "O" => "",
            "P" => "",
            "Q" => "",
            "R" => "",
            "S" => "",
            "T" => "",
            "U" => XlsStructure::STATUS_PARENT,
            "V" => "",
            "W" => "",
            "X" => $productSpecifications->variationTheme->title,
            "Y" => "",
            "Z" => "",
            "AA" => "",
            "AB" => $this->actionType(),
            "AC" => "",
            "AD" => "",
            "AE" => "",
            "AF" => "",
            "AG" => "",
            "AH" => "",
            "AI" => "",
            "AJ" => "",
            "AK" => "",
            "AL" => "",
            "AM" => "",
            "AN" => "",
            "AO" => "",
            "AP" => "",
            "AQ" => "",
            "AR" => "",
            "AS" => "",
            "AT" => "",
            "AU" => "",
            "AV" => "",
            "AW" => "",
            "AX" => "",
            "AY" => "",
            "AZ" => "",
            "BA" => "",
            "BB" => "",
            "BC" => "",
            "BD" => "",
            "BE" => "",
            "BF" => "",
            "BG" => "",
            "BH" => "",
            "BI" => "",
            "BJ" => "",
            "BK" => "",
            "BL" => "",
            "BM" => "",
            "BN" => "",
            "BO" => "",
            "BP" => "",
            "BQ" => "",
            "BR" => "",
            "BS" => "",
            "BT" => "",
            "BU" => "",
            "BV" => "",
            "BW" => "",
            "BX" => "",
            "BY" => "",
            "BZ" => "",
            "CA" => "",
            "CB" => "",
            "CC" => "",
            "CD" => "",
            "CE" => "",
            "CF" => "",
            "CG" => "",
            "CH" => "",
            "CI" => "",
            "CJ" => "",
            "CK" => "",
            "CL" => "",
            "CM" => "",
            "CN" => "",
            "CO" => "",
            "CP" => "",
            "CQ" => "",
            "CR" => "",
            "CS" => "",
            "CT" => "",
            "CU" => "",
            "CV" => "",
        ];

    }

    /**
     * @param Product $product
     * @param Device $device
     * @param $rowNumber
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    private function createChildRow(Product $product, Device $device)
    {
        /** @var ProductSpecification $productSpecifications */
        $productSpecifications = $product->specifications;
        $newEan = $this->getNewEan("{$product->title} | {$device->brand->name} {$device->title}");

        $this->csvRows[] = [
            "A" => $product->parent->specifications->browseNode->node,
            "B" => $device->id,
            "C" => $newEan,
            "D" => $productSpecifications->barcodeType->type,
            "E" => $this->changeMacros($product->title, $device),
            "F" => $productSpecifications->productBrand->name,
            "G" => $productSpecifications->manufacturer->name,
            "H" => $product->parent->specifications->browseNode->product_type,
            "I" => PriceHelper::toFloat($productSpecifications->price),
            "J" => $productSpecifications->quantity,
            "K" => $this->getMainImage($device, $productSpecifications->sku),
            "L" => $this->getUsingImageUrl($productSpecifications->sku, 1),
            "M" => $this->getUsingImageUrl($productSpecifications->sku, 2),
            "N" => $this->getUsingImageUrl($productSpecifications->sku, 3),
            "O" => $this->getUsingImageUrl($productSpecifications->sku, 4),
            "P" => $this->getUsingImageUrl($productSpecifications->sku, 5),
            "Q" => $this->getUsingImageUrl($productSpecifications->sku, 6),
            "R" => $this->getUsingImageUrl($productSpecifications->sku, 7),
            "S" => $this->getUsingImageUrl($productSpecifications->sku, 8),
            "T" => $productSpecifications->swatch_id ? App::i()->getFile()->getFullUrl("/images/swatches/" . $productSpecifications->swatch->filename) : '',
            "U" => XlsStructure::STATUS_CHILD,
            "V" => self::SKU_PREFIX . $device->id,
            "W" => XlsStructure::RELATIONSHIP,
            "X" => $product->parent->specifications->variationTheme->title,
            "Y" => $this->changeMacros($productSpecifications->description, $device),
            "Z" => $this->creatSku($productSpecifications->barcode, $device->id),
            "AA" => "",
            "AB" => $this->actionType(),
            "AC" => $productSpecifications->bulletpoint_1,
            "AD" => $productSpecifications->bulletpoint_2,
            "AE" => $productSpecifications->bulletpoint_3,
            "AF" => $productSpecifications->bulletpoint_4,
            "AG" => $productSpecifications->bulletpoint_5,
            "AH" => $this->changeMacros($productSpecifications->keywords, $device),
            "AI" => "",
            "AJ" => "",
            "AK" => "",
            "AL" => "",
            "AM" => "",
            "AN" => "",
            "AO" => "",
            "AP" => "",
            "AQ" => "",
            "AR" => "",
            "AS" => "",
            "AT" => "",
            "AU" => "",
            "AV" => "",
            "AW" => "",
            "AX" => "",
            "AY" => "",
            "AZ" => "",
            "BA" => "",
            "BB" => "",
            "BC" => "{$device->brand->name} {$device->title}",
            "BD" => $productSpecifications->length,
            "BE" => $productSpecifications->measureUnit->type,
            "BF" => "",
            "BG" => "",
            "BH" => "",
            "BI" => "",
            "BJ" => "",
            "BK" => "",
            "BL" => "",
            "BM" => "",
            "BN" => "",
            "BO" => "",
            "BP" => "",
            "BQ" => "",
            "BR" => "",
            "BS" => "",
            "BT" => "",
            "BU" => "",
            "BV" => "",
            "BW" => "",
            "BX" => "",
            "BY" => "",
            "BZ" => "",
            "CA" => "",
            "CB" => "",
            "CC" => "EUR",
            "CD" => "Neu",
            "CE" => "",
            "CF" => "",
            "CG" => "",
            "CH" => "",
            "CI" => "",
            "CJ" => "",
            "CK" => 1,
            "CL" => "",
            "CM" => "",
            "CN" => "",
            "CO" => "",
            "CP" => "",
            "CQ" => "",
            "CR" => "",
            "CS" => "",
            "CT" => "",
            "CU" => "",
            "CV" => $product->parent->specifications->merchant->name,
        ];
    }

    private function getNewEan(string $comment = '')
    {
        $ean = EAN::findOne(['is_used' => false]);

        if($ean){
            $ean->comment = $comment;
            $ean->is_used = true;
            if($ean->save()) {
                return $ean->ean;
            }
        }

        return false;
    }

    /**
     * @param string $input
     * @param Device $device
     * @return string|string[]
     */
    private function changeMacros($input, Device $device)
    {
        $output = $input ?: '';
        $output = str_replace(self::MACROS_DEVICE_BRAND, $device->brand->name, $output);
        $output = str_replace(self::MACROS_DEVICE_MODEL, $device->title, $output);

        return $output;
    }

    private function actionType()
    {
        $types = [
            self::ACTION_TYPE_UPDATE => 'Aktualisierung',
            self::ACTION_TYPE_DELETE => 'Löschung',
        ];

        return $types[$this->actionType];
    }

    /**
     * @param Product $product
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    private function createVariation(Product $product, $devices)
    {
        $children = $product->children;

        if($devices){
            $this->totalGadgets = count($devices) ?: 1;
            foreach ($devices as $model) {
                $this->createParentRow($product, $model);
                $this->currentRowNumber++;
                foreach ($children as $child) {
                    $this->createChildRow($child, $model);
                    $this->currentRowNumber++;
                }

                $this->finishedGadgets++;
                $this->setProgress();

                if($this->finishedGadgets % self::PER_CICLE == 0) {
                    $this->saveToCsv();
                }
            }
        }
    }

    private function creatSku(string $barcode, int $id)
    {
        return $barcode . "-" . $id;
    }

    private function getMainImage(Device $device, string $sku)
    {
        $str = $device->specifications->type->type . "/" . $device->brand->name . "-" . $device->title . "-" . $sku;
        $str = strtolower($str);
        $filename = FileHelper::createFilename($str);
        
        if(!is_file(Yii::getAlias("@accessories") . "/" . $filename)){
            $this->errors[] = Yii::t('front', 'NOT_ISSET_FILE', ['filename' => "/images/accessories/" . $filename]);
            $filename = '';
        }
        return $filename;
    }

    private function getUsingImageUrl(string $sku, $num)
    {
        $filename = TextHelper::createUsingFilename($sku, $num);
        $filepath = "/images/accessories/usings/";

        $url = App::i()->getFile()->getFullUrl($filepath . $filename);
        
        if(!is_file(Yii::getAlias("@usings") . "/" . $filename)){
            $this->errors[] = Yii::t('front', 'NOT_ISSET_FILE', ['filename' => $filepath . $filename]);
            $url = '';
        }
        
        
        return $url;
        
    }

    private function addSort($params, $type)
    {
        $uniqParam = $type == 'ASC' ? 1 : 2;

        foreach ($params as $param) {
            switch ($param) {
                case ListingTableStructure::DATE_CREATED:
                    $this->query
                        ->addOrderBy("l.date_created $type");
                    break;
                case ListingTableStructure::TITLE:
                    $this->query
                        ->addOrderBy("l.title $type");
                    break;
            }
        }
    }

    /**
     * @param $newFilename
     */
    private function getFilename($newFilename)
    {
        $this->newFilename = empty($newFilename) ? date("Y-M-d-H-i-s", time()) . "." . ListingHelper::FILETYPE : $newFilename;
        $file = \Yii::getAlias('@trad3r_resources') . "/templates/" . self::TEMPLATE_AMAZON;
        
        $this->addHeaders();
    }

    private function addHeaders()
    {
        $headerRow1 = [
            "TemplateType=Custom",
            "Version=2017.0320",
            "Die oberen drei Zeilen sind nur zur Verwendung durch Amazon.de vorgesehen. Verändern oder löschen Sie die obersten drei Zeilen nicht.",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "Bilder",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "Varianten",
            "",
            "",
            "",
            "Grundlegende",
            "",
            "",
            "",
            "Artikelerkennungs",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "Ungruppiert",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "Abmessungen",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "Konformitäts",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "Versand",
            "",
            "",
            "",
            "",
            "",
            "",
            "Angebot"
        ];
        $headerRow2 = [
            "Kategorisierung des Produktes (Browse Node)",
            "Verkäufer-SKU",
            "Hersteller-Barcode  ",
            "Barcode-Typ",
            "Produktname",
            "Marke",
            "Hersteller",
            "Produkttyp",
            "Preis",
            "Anzahl",
            "URL Hauptbild",
            "URL Weiteres Produktbild",
            "URL Weiteres Produktbild",
            "URL Weiteres Produktbild",
            "URL Weiteres Produktbild",
            "URL Weiteres Produktbild",
            "URL Weiteres Produktbild",
            "URL Weiteres Produktbild",
            "URL Weiteres Produktbild",
            "URL Musterbild",
            "Variantenbestandteil",
            "SKU des übergeordneten Produkts",
            "Produktbeziehungs-Typ",
            "Varianten-Design",
            "Produktbeschreibung",
            "Hersteller-Teilenummer",
            "Hersteller-Modellnummer",
            "Update / Löschen",
            "Wesentliche Produktmerkmale",
            "Wesentliche Produktmerkmale",
            "Wesentliche Produktmerkmale",
            "Wesentliche Produktmerkmale",
            "Wesentliche Produktmerkmale",
            "Allgemeine Schlüsselwörter",
            "Allgemeine Schlüsselwörter",
            "Allgemeine Schlüsselwörter",
            "Allgemeine Schlüsselwörter",
            "Allgemeine Schlüsselwörter",
            "Platinum Keywords",
            "Platinum Keywords",
            "Platinum Keywords",
            "Platinum Keywords",
            "Platinum Keywords",
            "Produkt-Features",
            "Produkt-Features",
            "Produkt-Features",
            "Produkt-Features",
            "Produkt-Features",
            "Farbe",
            "Standardfarbe",
            "size_name",
            "Materialzusammensetzung",
            "Gehäusematerial",
            "Formfaktor",
            "Kompatible Geräte",
            "Länge des Produkts",
            "Maßeinheit für Länge des Produkts",
            "Höhe",
            "Länge",
            "Breite",
            "Maßeinheit der Artikelabmessungen",
            "Gewicht",
            "Maßeinheit des Artikelgewichts",
            "Versandgewicht",
            "Maßeinheit des auf der Webseite angegebenen Versandgewichts",
            "Herkunftsland",
            "Alterswarnung EU-Spielzeugrichtlinie",
            "Warnhinweis EU-Spielzeugrichtlinie",
            "Sprache EU-Spielzeugrichtlinie",
            "Rechtlicher Hinweis",
            "Sicherheitswarnung",
            "Datenblatt (zum Energielabel)",
            "Energielabel",
            "Versandzentrum-ID",
            "Höhe Produktverpackung",
            "Breite Produktverpackung",
            "Länge Produktverpackung",
            "Maßeinheit der Verpackungsmaße",
            "Paketgewicht",
            "Maßeinheit des Verpackungsgewichts",
            "Währung",
            "Zustandstyp des Angebots",
            "Zustandsbeschreibung",
            "Maximal bestellbare Menge",
            "Bearbeitungszeit der Bestellung",
            "Angebotspreis",
            "Startdatum für den Angebotspreis",
            "Enddatum für den Angebotspreis",
            "Anzahl Artikel",
            "SKU-Liste für Lieferung zum Wunschtermin",
            "Maximale Gesamtversandmenge",
            "Geschenknachricht verfügbar?",
            "Geschenkverpackung verfügbar",
            "Datum des Verkaufsstarts",
            "Release Datum",
            "Termin zur Nachbestellung",
            "Artikel Auslaufdatum",
            "Produkt-ID-Überschreibung",
            "Steuercode",
            "Verkäuferversandgruppe"
        ];
        $headerRow3 = [
            "recommended_browse_nodes",
            "item_sku",
            "external_product_id",
            "external_product_id_type",
            "item_name",
            "brand_name",
            "manufacturer",
            "feed_product_type",
            "standard_price",
            "quantity",
            "main_image_url",
            "other_image_url1",
            "other_image_url2",
            "other_image_url3",
            "other_image_url4",
            "other_image_url5",
            "other_image_url6",
            "other_image_url7",
            "other_image_url8",
            "swatch_image_url",
            "parent_child",
            "parent_sku",
            "relationship_type",
            "variation_theme",
            "product_description",
            "part_number",
            "model",
            "update_delete",
            "bullet_point1",
            "bullet_point2",
            "bullet_point3",
            "bullet_point4",
            "bullet_point5",
            "generic_keywords1",
            "generic_keywords2",
            "generic_keywords3",
            "generic_keywords4",
            "generic_keywords5",
            "platinum_keywords1",
            "platinum_keywords2",
            "platinum_keywords3",
            "platinum_keywords4",
            "platinum_keywords5",
            "special_features1",
            "special_features2",
            "special_features3",
            "special_features4",
            "special_features5",
            "color_name",
            "color_map",
            "size_name",
            "material_composition",
            "material_type",
            "form_factor",
            "compatible_devices",
            "item_display_length",
            "item_display_length_unit_of_measure",
            "item_height",
            "item_length",
            "item_width",
            "item_dimensions_unit_of_measure",
            "item_weight",
            "item_weight_unit_of_measure",
            "website_shipping_weight",
            "website_shipping_weight_unit_of_measure",
            "country_of_origin",
            "eu_toys_safety_directive_age_warning",
            "eu_toys_safety_directive_warning",
            "eu_toys_safety_directive_language",
            "legal_disclaimer_description",
            "safety_warning",
            "product_efficiency_image_url",
            "energy_efficiency_image_url",
            "fulfillment_center_id",
            "package_height",
            "package_width",
            "package_length",
            "package_dimensions_unit_of_measure",
            "package_weight",
            "package_weight_unit_of_measure",
            "currency",
            "condition_type",
            "condition_note",
            "max_order_quantity",
            "fulfillment_latency",
            "sale_price",
            "sale_from_date",
            "sale_end_date",
            "number_of_items",
            "delivery_schedule_group_id",
            "max_aggregate_ship_quantity",
            "offering_can_be_gift_messaged",
            "offering_can_be_giftwrapped",
            "product_site_launch_date",
            "merchant_release_date",
            "restock_date",
            "is_discontinued_by_manufacturer",
            "missing_keyset_reason",
            "product_tax_code",
            "merchant_shipping_group_name"
        ];
        
        $this->csvRows[] = $headerRow1;
        $this->csvRows[] = $headerRow2;
        $this->csvRows[] = $headerRow3;
        
        $this->saveToCsv(true);

    }

    /**
     * @param array $row
     */
    private function saveToCsv($isNew = false)
    {
        if($isNew){
            file_put_contents($this->tempFile, "");
        }
        
        foreach ($this->csvRows as $row) {
            $data = implode("\t", $row);
            file_put_contents($this->tempFile, $data . PHP_EOL, FILE_APPEND);
        }
        
        unset($this->csvRows);
        gc_collect_cycles();

    }
}