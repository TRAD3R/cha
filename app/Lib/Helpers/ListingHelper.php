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
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;
use Yii;
use yii\db\Query;

class ListingHelper
{
    const PER_PAGE = 100;

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

    private static $progress = '0';
    private $actionType;
    private $errors = [];
    
    private $selectedDevices = [];       // id девайсов, которые выбрала Ира на странице

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

    private function setProgress(int $total, int $finished)
    {
        file_put_contents(Yii::getAlias("@Web") . self::PROGRESS_FILE, number_format($finished / $total * 100, 2));
    }

    public function getProgress()
    {
        return file_get_contents(Yii::getAlias("@Web") . self::PROGRESS_FILE);
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
    public function createListing($products, $newFilename, $actionType = self::ACTION_TYPE_UPDATE, $deviceIds = [])
    {
        ini_set('max_execution_time', 0);

        $this->actionType = $actionType;

        if($this->getFilename($newFilename)) {   
            
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
                'status' => $this->save($newFilename),
                'errors' => $this->errors
            ];
        }

        return [
            'status' => false,
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

    private function save(string $newFilename)
    {
        try {
            $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
            $file = \Yii::getAlias("@out") . DIRECTORY_SEPARATOR . $newFilename;
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
        $devicesFinished = 0;

        if($devices){
            foreach ($devices as $model) {
                $this->createIndividualRow($product, $model, $this->currentRowNumber);
                $this->currentRowNumber++;
                $devicesFinished++;
//                $this->setProgress($devices['total'], $devicesFinished);
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
    private function createIndividualRow(Product $product, Device $device, $rowNumber)
    {
        /** @var ProductSpecification $productSpecifications */
        $productSpecifications = $product->specifications;
        $newEan = $this->getNewEan("{$product->title} | {$device->brand->name} {$device->title}");

        $this->spreadsheet->setActiveSheetIndex(0)
            ->setCellValue(XlsStructure::COLUMN_BROWSE_NODE . $rowNumber, $productSpecifications->browseNode->node)
            ->setCellValue(XlsStructure::COLUMN_SKU . $rowNumber, $this->creatSku($productSpecifications->barcode, $device->id))
            ->setCellValue(XlsStructure::COLUMN_BARCODE . $rowNumber, $newEan)
            ->setCellValue(XlsStructure::COLUMN_BARCODE_TYPE . $rowNumber, $productSpecifications->barcodeType->type)
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_TITLE . $rowNumber, $this->changeMacros($product->title, $device))
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_BRAND . $rowNumber, $productSpecifications->productBrand->name)
            ->setCellValue(XlsStructure::COLUMN_MANUFACTURER . $rowNumber, $productSpecifications->manufacturer->name)
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_TYPE . $rowNumber, $productSpecifications->browseNode->product_type)
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_PRICE . $rowNumber, PriceHelper::toFloat($productSpecifications->price))
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_QUANTITY . $rowNumber, $productSpecifications->quantity)
            ->setCellValue(XlsStructure::COLUMN_MAIN_IMAGE . $rowNumber, $this->getMainImage($device, $productSpecifications->sku))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_1 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 1))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_2 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 2))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_3 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 3))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_4 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 4))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_5 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 5))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_6 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 6))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_7 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 7))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_8 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 18))
            ->setCellValue(XlsStructure::COLUMN_SWATCHES . $rowNumber, $productSpecifications->swatch_id ? App::i()->getFile()->getFullUrl("/images/swatches/" . $productSpecifications->swatch->filename) : '')
            ->setCellValue(XlsStructure::COLUMN_PRODCT_DESCRIPTION . $rowNumber, $this->changeMacros($productSpecifications->description, $device))
            ->setCellValue(XlsStructure::COLUMN_PART_NUMBER . $rowNumber, $this->creatSku($productSpecifications->barcode, $device->id))
            ->setCellValue(XlsStructure::COLUMN_UPDATE_DELETE . $rowNumber, $this->actionType())
            ->setCellValue(XlsStructure::COLUMN_BULLETPOINT_1 . $rowNumber, $productSpecifications->bulletpoint_1)
            ->setCellValue(XlsStructure::COLUMN_BULLETPOINT_2 . $rowNumber, $productSpecifications->bulletpoint_2)
            ->setCellValue(XlsStructure::COLUMN_BULLETPOINT_3 . $rowNumber, $productSpecifications->bulletpoint_3)
            ->setCellValue(XlsStructure::COLUMN_BULLETPOINT_4 . $rowNumber, $productSpecifications->bulletpoint_4)
            ->setCellValue(XlsStructure::COLUMN_BULLETPOINT_5 . $rowNumber, $productSpecifications->bulletpoint_5)
            ->setCellValue(XlsStructure::COLUMN_KEYWORDS . $rowNumber, $this->changeMacros($productSpecifications->keywords, $device))
            ->setCellValue(XlsStructure::COLUMN_COMPATIBLE_DEVICE . $rowNumber, "{$device->brand->name} {$device->title}")
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_LENGTH . $rowNumber, $productSpecifications->length)
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_LENGTH_MEASURE . $rowNumber, $productSpecifications->measureUnit->type)
            ->setCellValue(XlsStructure::COLUMN_CURRENCY . $rowNumber, "EUR")
            ->setCellValue(XlsStructure::COLUMN_CONDITION_TYPE . $rowNumber, "Neu")
            ->setCellValue(XlsStructure::COLUMN_NUMBER_OF_ITEMS . $rowNumber, 1)
            ->setCellValue(XlsStructure::COLUMN_MERCHANT_TYPE . $rowNumber, $productSpecifications->merchant->name)
        ;

    }

    /**
     * @param Product $product
     * @param Device $device
     * @param $rowNumber
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function createParentRow(Product $product, Device $device, $rowNumber)
    {
        /** @var ProductSpecification $productSpecifications */
        $productSpecifications = $product->specifications;

        $this->spreadsheet->setActiveSheetIndex(0)
            ->setCellValue(XlsStructure::COLUMN_BROWSE_NODE . $rowNumber, $productSpecifications->browseNode->node)
            ->setCellValue(XlsStructure::COLUMN_SKU . $rowNumber, self::SKU_PREFIX . $device->id)
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_TITLE . $rowNumber, $this->changeMacros($product->title, $device))
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_BRAND . $rowNumber, $product->children[0]->specifications->productBrand->name)
            ->setCellValue(XlsStructure::COLUMN_MANUFACTURER . $rowNumber, $product->children[0]->specifications->manufacturer->name)
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_TYPE . $rowNumber, $productSpecifications->browseNode->product_type)
            ->setCellValue(XlsStructure::COLUMN_STATUS . $rowNumber, XlsStructure::STATUS_PARENT)
            ->setCellValue(XlsStructure::COLUMN_VARIATION_THEME . $rowNumber, $productSpecifications->variationTheme->title)
            ->setCellValue(XlsStructure::COLUMN_UPDATE_DELETE . $rowNumber, $this->actionType())
        ;

    }

    /**
     * @param Product $product
     * @param Device $device
     * @param $rowNumber
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    private function createChildRow(Product $product, Device $device, $rowNumber)
    {
        /** @var ProductSpecification $productSpecifications */
        $productSpecifications = $product->specifications;
        $newEan = $this->getNewEan("{$product->title} | {$device->brand->name} {$device->title}");

        $this->spreadsheet->setActiveSheetIndex(0)
            ->setCellValue(XlsStructure::COLUMN_BROWSE_NODE . $rowNumber, $product->parent->specifications->browseNode->node)
            ->setCellValue(XlsStructure::COLUMN_SKU . $rowNumber, $this->creatSku($productSpecifications->barcode, $device->id))
            ->setCellValue(XlsStructure::COLUMN_BARCODE . $rowNumber, $newEan)
            ->setCellValue(XlsStructure::COLUMN_BARCODE_TYPE . $rowNumber, $productSpecifications->barcodeType->type)
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_TITLE . $rowNumber, $this->changeMacros($product->title, $device))
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_BRAND . $rowNumber, $productSpecifications->productBrand->name)
            ->setCellValue(XlsStructure::COLUMN_MANUFACTURER . $rowNumber, $productSpecifications->manufacturer->name)
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_TYPE . $rowNumber, $product->parent->specifications->browseNode->product_type)
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_PRICE . $rowNumber, PriceHelper::toFloat($productSpecifications->price))
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_QUANTITY . $rowNumber, $productSpecifications->quantity)
            ->setCellValue(XlsStructure::COLUMN_MAIN_IMAGE . $rowNumber, $this->getMainImage($device, $productSpecifications->sku))
            ->setCellValue(XlsStructure::COLUMN_SWATCHES . $rowNumber, App::i()->getFile()->getFullUrl("/images/swatches/" . $productSpecifications->swatch->filename))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_1 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 1))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_2 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 2))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_3 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 3))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_4 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 4))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_5 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 5))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_6 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 6))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_7 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 7))
            ->setCellValue(XlsStructure::COLUMN_SECONDARY_IMAGE_8 . $rowNumber, $this->getUsingImageUrl($productSpecifications->sku, 18))
            ->setCellValue(XlsStructure::COLUMN_STATUS . $rowNumber, XlsStructure::STATUS_CHILD)
            ->setCellValue(XlsStructure::COLUMN_PARENT_SKU . $rowNumber, self::SKU_PREFIX . $device->id)
            ->setCellValue(XlsStructure::COLUMN_RELATIONSHIP . $rowNumber, XlsStructure::RELATIONSHIP)
            ->setCellValue(XlsStructure::COLUMN_VARIATION_THEME . $rowNumber, $product->parent->specifications->variationTheme->title)
            ->setCellValue(XlsStructure::COLUMN_PRODCT_DESCRIPTION . $rowNumber, $this->changeMacros($productSpecifications->description, $device))
            ->setCellValue(XlsStructure::COLUMN_PART_NUMBER . $rowNumber, $this->creatSku($productSpecifications->barcode, $device->id))
            ->setCellValue(XlsStructure::COLUMN_UPDATE_DELETE . $rowNumber, $this->actionType())
            ->setCellValue(XlsStructure::COLUMN_BULLETPOINT_1 . $rowNumber, $productSpecifications->bulletpoint_1)
            ->setCellValue(XlsStructure::COLUMN_BULLETPOINT_2 . $rowNumber, $productSpecifications->bulletpoint_2)
            ->setCellValue(XlsStructure::COLUMN_BULLETPOINT_3 . $rowNumber, $productSpecifications->bulletpoint_3)
            ->setCellValue(XlsStructure::COLUMN_BULLETPOINT_4 . $rowNumber, $productSpecifications->bulletpoint_4)
            ->setCellValue(XlsStructure::COLUMN_BULLETPOINT_5 . $rowNumber, $productSpecifications->bulletpoint_5)
            ->setCellValue(XlsStructure::COLUMN_KEYWORDS . $rowNumber, $this->changeMacros($productSpecifications->keywords, $device))
            ->setCellValue(XlsStructure::COLUMN_COMPATIBLE_DEVICE . $rowNumber, "{$device->brand->name} {$device->title}")
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_LENGTH . $rowNumber, $productSpecifications->length)
            ->setCellValue(XlsStructure::COLUMN_PRODUCT_LENGTH_MEASURE . $rowNumber, $productSpecifications->measureUnit->type)
            ->setCellValue(XlsStructure::COLUMN_CURRENCY . $rowNumber, "EUR")
            ->setCellValue(XlsStructure::COLUMN_CONDITION_TYPE . $rowNumber, "Neu")
            ->setCellValue(XlsStructure::COLUMN_NUMBER_OF_ITEMS . $rowNumber, 1)
            ->setCellValue(XlsStructure::COLUMN_MERCHANT_TYPE . $rowNumber, $product->parent->specifications->merchant->name)
        ;

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
        $devicesFinished = 0;
        $children = $product->children;

        if($devices){
            foreach ($devices as $model) {
                $this->createParentRow($product, $model, $this->currentRowNumber);
                $this->currentRowNumber++;
                foreach ($children as $child) {
                    $this->createChildRow($child, $model, $this->currentRowNumber);
                    $this->currentRowNumber++;
                }

                $devicesFinished++;
//                $this->setProgress($devices['total'], $devicesFinished);
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

    private function getFilename(&$newFilename)
    {
        $newFilename = empty($newFilename) ? date("Y-M-d-H-i-s", time()) . "." . ListingHelper::FILETYPE : $newFilename;
        $file = \Yii::getAlias('@trad3r_resources') . "/templates/" . self::TEMPLATE_AMAZON;

        if(is_file($file)) {
            $this->spreadsheet = IOFactory::load($file);
            $this->setFileProperties();
            
            return true;
        }
        
        return false;
    }


}