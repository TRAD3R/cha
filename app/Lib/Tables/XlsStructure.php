<?php


namespace App\Tables;


class XlsStructure
{
    const COLUMN_BROWSE_NODE = 'A';
    const COLUMN_SKU = 'B';
    const COLUMN_BARCODE = 'C';
    const COLUMN_BARCODE_TYPE = 'D';
    const COLUMN_PRODUCT_TITLE = 'E';
    const COLUMN_PRODUCT_BRAND = 'F';
    const COLUMN_MANUFACTURER = 'G';
    const COLUMN_PRODUCT_TYPE = 'H';
    const COLUMN_PRODUCT_PRICE = 'I';
    const COLUMN_PRODUCT_QUANTITY = 'J';
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
    
    const STATUS_PARENT = 'Parent';
    const STATUS_CHILD = 'Child';
    const RELATIONSHIP = 'Variation';
    
    public static function getParentColumns()
    {
        
    }

    public static function getChildColumns()
    {

    }

    public static function getIndividualColumns()
    {
        return [
            self::COLUMN_BROWSE_NODE,
            self::COLUMN_SKU,
            self::COLUMN_BARCODE,
            self::COLUMN_BARCODE_TYPE,
            self::COLUMN_PRODUCT_TITLE,
            self::COLUMN_PRODUCT_BRAND,
            self::COLUMN_MANUFACTURER,
            self::COLUMN_PRODUCT_TYPE,
            self::COLUMN_PRODUCT_PRICE,
            self::COLUMN_PRODUCT_QUANTITY,
            self::COLUMN_SWATCHES,
            self::COLUMN_PRODCT_DESCRIPTION,
            self::COLUMN_PART_NUMBER,
            self::COLUMN_UPDATE_DELETE,
            self::COLUMN_BULLETPOINT_1,
            self::COLUMN_BULLETPOINT_2,
            self::COLUMN_BULLETPOINT_3,
            self::COLUMN_BULLETPOINT_4,
            self::COLUMN_BULLETPOINT_5,
            self::COLUMN_KEYWORDS,
            self::COLUMN_SIZE_NAME,
            self::COLUMN_COMPATIBLE_DEVICE,
            self::COLUMN_PRODUCT_LENGTH,
            self::COLUMN_PRODUCT_LENGTH_MEASURE,
            self::COLUMN_CURRENCY,
            self::COLUMN_CONDITION_TYPE,
            self::COLUMN_NUMBER_OF_ITEMS,
            self::COLUMN_MERCHANT_TYPE,
        ];
    }
}