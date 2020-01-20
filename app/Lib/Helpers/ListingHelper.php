<?php
namespace App\Helpers;

use App\App;
use App\Models\Product;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as Writer;

class ListingHelper
{
    const PRODUCTS = 'products';
    const DEVICES = 'devices';
    const TEMPLATE_AMAZON = 'amazon_listing_template.xlsx';
    const FILENAME = 'filename';
    const FILETYPE = 'xlsx';
    
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
        $file = \Yii::getAlias('@trad3r_resources') . "/templates/" . self::TEMPLATE_AMAZON;
        if(is_file($file)) {
            $this->spreadsheet = IOFactory::load($file);
            $this->setFileProperties();
            $this->spreadsheet->setActiveSheetIndex(0);
            
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
            ->setCreator(App::i()->getApp()->getUser()->email)
            ->setLastModifiedBy(App::i()->getApp()->getUser()->email)
            ->setTitle('Amazon listing')
        ;
    }

    private function save(string $newFilename)
    {
        try {
            $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
            $file = \Yii::getAlias("@out") . "/" . $newFilename . "." . self::FILETYPE;
            $writer->save($file);
        }catch(Exception $e){
            return false;    
        }
        
        return true;
    }

    private function createIndividual(Product $product)
    {
        
    }

    

}