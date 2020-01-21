<?php
namespace App\Helpers;

use App\App;
use App\Models\Device;
use App\Models\DeviceSpecification;
use App\Models\EAN;
use App\Models\Product;
use App\Models\ProductSpecification;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;
use yii\db\Query;

class ListingHelper
{
    const PRODUCTS = 'products';
    const DEVICES = 'devices';
    const TEMPLATE_AMAZON = 'amazon_listing_template.xlsx';
    const FILETYPE = 'xlsx';
    const FILENAME = 'filename';
    const IDS = 'ids';
    
    const START_ROW = 4;
    const COLUMN_BROWSE_NODE = 'A';
    const COLUMN_SKU = 'B';
    const COLUMN_BARCODE = 'C';
    const COLUMN_BARCODE_TYPE = 'D';
    const COLUMN_PRODUCT_TITLE = 'E';
    const COLUMN_PRODUCT_BRAND = 'F';
    const COLUMN_MANUFACTURER = 'G';
    const COLUMN_PRODUCT_TYPE = 'H';
    const COLUMN_PRODUCT_PRICE = 'I';
    const COLUMN_QUANTITY = 'J';
    const COLUMN_MAIN_IMAGE = 'K';
    const COLUMN_SECONDARY_IMAGE_1 = 'L';
    const COLUMN_SECONDARY_IMAGE_2 = 'M';
    const COLUMN_SECONDARY_IMAGE_3 = 'N';
    const COLUMN_SECONDARY_IMAGE_4 = 'O';
    const COLUMN_SECONDARY_IMAGE_5 = 'P';
    const COLUMN_SECONDARY_IMAGE_6 = 'Q';
    const COLUMN_SECONDARY_IMAGE_7 = 'R';
    const COLUMN_SECONDARY_IMAGE_8 = 'S';
    const COLUMN_SWATCHES = 'T';
    const COLUMN_STATUS = 'U';
    const COLUMN_PARENT_SKU = 'V';
    const COLUMN_RELATIONSHIP = 'W';
    const COLUMN_VARIATION_THEME = 'X';
    const COLUMN_PRODCT_DESCRIPTION = 'Y';
    const COLUMN_PART_NUMBER = 'Z';
    const COLUMN_UPDATE_DELETE = 'AB';
    const COLUMN_BULLETPOINT_1 = 'AC';
    const COLUMN_BULLETPOINT_2 = 'AD';
    const COLUMN_BULLETPOINT_3 = 'AE';
    const COLUMN_BULLETPOINT_4 = 'AF';
    const COLUMN_BULLETPOINT_5 = 'AG';
    const COLUMN_KEYWORDS = 'AH';
    const COLUMN_SIZE_NAME = 'AY';
    const COLUMN_COMPATIBLE_DEVICE = 'BC';
    const COLUMN_PRODUCT_LENGTH = 'BD';
    const COLUMN_PRODUCT_LENGTH_MEASURE = 'BE';
    const COLUMN_CURRENCY = 'CC';
    const COLUMN_CONDITION_TYPE = 'CD';
    const COLUMN_NUMBER_OF_ITEMS = 'CK';
    const COLUMN_MERCHANT_TYPE = 'CV';
    
    const MACROS_DEVICE_BRAND = '{DEVICE_BRAND}';
    const MACROS_DEVICE_MODEL = '{DEVICE_MODEL}';
    const SKU_PREFIX = 'cha-';
    
    const ACTION_TYPE_UPDATE = 0;
    const ACTION_TYPE_DELET = 1;

    /** @var Spreadsheet|null */
    private $spreadsheet = null;
    
    /**
     * @param Product[] $products
     * @param string $newFilename
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function create(array $products, string $newFilename)
    {
        ini_set('max_execution_time', 0);
        $newFilename = empty($newFilename) ? date("Y-M-d-H-i-s", time()) . "." . ListingHelper::FILETYPE : $newFilename;
        $file = \Yii::getAlias('@trad3r_resources') . "/templates/" . self::TEMPLATE_AMAZON;
        if(is_file($file)) {
            $this->spreadsheet = IOFactory::load($file);
            $this->setFileProperties();
            
            foreach ($products as $product) {
                if($product->parent_id == Product::TYPE_INDIVIDUAL) {
                    $this->createIndividual($product);
                }
            }
            
            return $this->save($newFilename);
        }
        
        return false;
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
            $file = \Yii::getAlias("@out") . "/" . $newFilename;
            $writer->save($file);
        }catch(Exception $e){
            return false;    
        }
        
        return true;
    }

    private function createIndividual(Product $product)
    {
        $models = $this->getLinkedDevices($product->specifications->type->alias);
        
        $rowNumber = self::START_ROW;
        if($models){
            foreach ($models as $model) {
                $this->createRow($product, $model, $rowNumber);
                $rowNumber++;
            }
        }
    }

    /**
     * @param string $type
     * @return Device[]|null
     */
    private function getLinkedDevices(string $type)
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
                    ->andWhere(['ut.alias' => $type])
                ;
                break;
        }
        $query->limit(1);
        return $query->all();
    }

    private function createRow(Product $product, Device $device, $rowNumber)
    {
        /** @var DeviceSpecification $deviceSpecifications */
        $deviceSpecifications = $device->specifications;
        
        /** @var ProductSpecification $productSpecifications */
        $productSpecifications = $product->specifications;
        $newEan = $this->getNewEan("{$product->name} | {$device->brand->name} {$device->title}");
        
        $this->spreadsheet->setActiveSheetIndex(0)
            ->setCellValue(self::COLUMN_BROWSE_NODE . $rowNumber, $productSpecifications->browseNode->node)
            ->setCellValue(self::COLUMN_SKU . $rowNumber, $this->creatSku($productSpecifications->sku))
            ->setCellValue(self::COLUMN_BARCODE . $rowNumber, $newEan)
            ->setCellValue(self::COLUMN_BARCODE_TYPE . $rowNumber, $productSpecifications->barcodeType->type)
            ->setCellValue(self::COLUMN_PRODUCT_TITLE . $rowNumber, $this->changeMacros($product->name, $device))
            ->setCellValue(self::COLUMN_PRODUCT_BRAND . $rowNumber, $productSpecifications->productBrand->name)
            ->setCellValue(self::COLUMN_MANUFACTURER . $rowNumber, $productSpecifications->manufacturer->name)
            ->setCellValue(self::COLUMN_PRODUCT_TYPE . $rowNumber, $productSpecifications->browseNode->product_type)
            ->setCellValue(self::COLUMN_PRODUCT_PRICE . $rowNumber, PriceHelper::toFloat($productSpecifications->price))
            ->setCellValue(self::COLUMN_QUANTITY . $rowNumber, $productSpecifications->quantity)
            ->setCellValue(self::COLUMN_SWATCHES . $rowNumber, App::i()->getFile()->getFullUrl("/images/swatches/" . $productSpecifications->swatch->filename))
            ->setCellValue(self::COLUMN_PRODCT_DESCRIPTION . $rowNumber, $this->changeMacros($productSpecifications->description, $device))
            ->setCellValue(self::COLUMN_PART_NUMBER . $rowNumber, $this->creatSku($productSpecifications->sku))
            ->setCellValue(self::COLUMN_UPDATE_DELETE . $rowNumber, $this->actionType())
            ->setCellValue(self::COLUMN_BULLETPOINT_1 . $rowNumber, $productSpecifications->bulletpoint_1)
            ->setCellValue(self::COLUMN_BULLETPOINT_2 . $rowNumber, $productSpecifications->bulletpoint_2)
            ->setCellValue(self::COLUMN_BULLETPOINT_3 . $rowNumber, $productSpecifications->bulletpoint_3)
            ->setCellValue(self::COLUMN_BULLETPOINT_4 . $rowNumber, $productSpecifications->bulletpoint_4)
            ->setCellValue(self::COLUMN_BULLETPOINT_5 . $rowNumber, $productSpecifications->bulletpoint_5)
            ->setCellValue(self::COLUMN_KEYWORDS . $rowNumber, $this->changeMacros($productSpecifications->keywords, $device))
            ->setCellValue(self::COLUMN_COMPATIBLE_DEVICE . $rowNumber, "{$device->brand->name} {$device->title}")
            ->setCellValue(self::COLUMN_PRODUCT_LENGTH . $rowNumber, $productSpecifications->length)
            ->setCellValue(self::COLUMN_PRODUCT_LENGTH_MEASURE . $rowNumber, $productSpecifications->measureUnit->type)
            ->setCellValue(self::COLUMN_CURRENCY . $rowNumber, "EUR")
            ->setCellValue(self::COLUMN_CONDITION_TYPE . $rowNumber, "Neu")
            ->setCellValue(self::COLUMN_NUMBER_OF_ITEMS . $rowNumber, 1)
            ->setCellValue(self::COLUMN_MERCHANT_TYPE . $rowNumber, $productSpecifications->merchant->name)
        ;

    }

    private function getNewEan(string $comment)
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

    private function changeMacros(string $input, Device $device)
    {
        $output = $input;
        $output = str_replace(self::MACROS_DEVICE_BRAND, $device->brand->name, $output);
        $output = str_replace(self::MACROS_DEVICE_MODEL, $device->title, $output);
        
        return $output;
    }

    private function creatSku(string $sku)
    {
        return self::SKU_PREFIX . $sku;
    }

    private function actionType($type = self::ACTION_TYPE_UPDATE)
    {
        $types = [
            self::ACTION_TYPE_UPDATE => 'Aktualisierung',
            self::ACTION_TYPE_DELET => 'Löschung',
        ];
        
        return $types[$type];
    }


}