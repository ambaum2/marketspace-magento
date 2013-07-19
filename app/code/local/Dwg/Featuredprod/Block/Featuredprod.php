<?php
class Dwg_Featuredprod_Block_Featuredprod extends Mage_Core_Block_Template
{
	// output select menus for region
	// experience maker and category 
	// associated with the experience
	//  flow for catchall
	// region selected from list of all
	// regions. Experience makers
	// that have that region as a class 
	//  name are picked up with an event
	//  js. 
	
   // each region will need a select menu
   // of experience makers and the exp
   // makers a category menu. 
   
   //experience makers can belong to 
   // multiple regions but categories stay the same
   // get data from model
   public function getProducts() {
	//$productData = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*'); 
	//inner join products model vs featureprod to get featured products
	//need limit of 4
        //$productData->getSelect()->join(array('feat' => 'featuredprod'), 'e.entity_id = feat.entity_id',array('feat.status as feat_status','feat.feat_type','feat.featuredprod_id'));
//array('feat.status as feat_status','feat.feat_type','feat.featuredprod_id')
        //$collection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*');
        //echo $collection->getSelect()->join(array('feat' => 'featuredprod'), 'e.entity_id = feat.entity_id', array('feat.status as feat_status','feat.feat_type','feat.featuredprod_id'));

	//return $collection->getData();
   }
   
   public function productGrid() {
   	//$productData = $this->getProducts();
   	$_product =  Mage::getModel('catalog/product');//you should declare a singleton or object reference I believe
   	$productData = Mage::getModel('featuredprod/featuredprod')->getCollection()
             ->addFilter('feat_status',1)
             ->setOrder('feat_order','ASC')
             ->setPageSize(16)
             ->getData();
         if(count($productData)>0) {
         $output = "<h1 class='subtitle'><img src='/skin/frontend/default/default/images/es15/headline_featured_marketplace_products.png'></img></h1><ul class='products-grid'>";
   	foreach($productData as $prod) {
   		$_product =  Mage::getModel('catalog/product');//should use singleton or object reference I think need to experiment
   		$currProd = $_product->load($prod['entity_id']);
   	         $output .= "<li class='item'><a class='product-image' href='".$currProd->getProductUrl()."'>";
                 $output .= "<img src='".$this->helper('catalog/image')->init($currProd, 'thumbnail')->resize(135)."' ></img></a>";
                 $output .= "<a href='".$currProd->getProductUrl()."'<h2 class='product-name'>".$currProd->getName()."</h2></a></li>";
   	}
   	$output .= "</ul>";
         return $output;
         }
            	
   }
   
   
}
