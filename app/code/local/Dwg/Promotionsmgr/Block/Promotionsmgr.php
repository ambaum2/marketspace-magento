<?php
class Dwg_Promotionsmgr_Block_Promotionsmgr extends Mage_Core_Block_Template
{
/*
 * functions to control output of different promotion types
 * @todo create an interface to control this with polymorphism
 * @todo add a description in the promotionsmgr table and to the form for alt tags
 */
   public function promotionsRightPanel($categoryId,$region) {
   	$promotionsData = Mage::getModel('promotionsmgr/promotionsmgr')->getCollection();
		//get a max of two ordered by display order return as array
		$promotionsData->addFilter('region',$region)
			->addFilter('position','Right')
			->addFilter('status',1)
			->addFilter('category_id',$categoryId)
			->setOrder('display_order','ASC')
			->setPageSize(2)
			->getData();
		$output = "<div id='eslRightPanel'>";
		$i = 0;
		if($promotionsData->count() > 0) {
			foreach($promotionsData as $ad) {
				$output .= "<a href='".$ad['link']."' class='eslRightPanelAd'><img src='"
					. Mage::getBaseUrl('media') . DS . "promotions" . DS . $ad['image_url'] . "' width='200' height='175' /></a>"; 
				if($i == 0) {
					$output .= "<a class='eslRightPanelAd eslFacebook' href='http://www.facebook.com/pages/Escape-Locally-To-Southern-Illinois/192250210807163'>"
									. "<img src='/skin/frontend/default/default/images/es15/side2_fb1.png' />";
					$output .= "<a class='eslRightPanelAd eslFacebook' href='http://www.facebook.com/pages/Escape-Locally-To-Southern-Illinois/192250210807163'>"
									. "<img src='/skin/frontend/default/default/images/es15/side2_fb2.png' />";
					$output .= "<a class='eslRightPanelAd eslFacebook' href='/sendfriend/product/send/'>"
									. "<img src='/skin/frontend/default/default/images/es15/side2_email.png' />";
				}
				$i++;
			}
			$output .= "</div>";
			echo $output;	
		}
   }
	public function promotionsExperienceGuide($categoryId,$region) {
	   		$promotionsData = Mage::getModel('promotionsmgr/promotionsmgr')->getCollection();
			//get a max of two ordered by display order return as array
			$promotionsData->addFilter('region',$region)
				->addFilter('position','Experience Guide')
				->addFilter('status',1)
				->addFilter('category_id',$categoryId)
				->setOrder('display_order','ASC')
				->setPageSize(1)
				->getData();
			$guideArr = $promotionsData->toArray();
			$output = "";
			if($promotionsData->count() > 0) { //an experience guide is set
				$output = "<div id='headerExpMaker'>";
				$output .= "<a href='/contact?gid=".$guideArr['items'][0]['guide_id']."&cid=".$categoryId."'>";
				$currGuide = Mage::getModel('catalog/product')->load($guideArr['items'][0]['guide_id']);
				//$output .= $currGuide->getGuideImage() . "</a></div>";
				$output .= "<img src='".Mage::getBaseUrl('media') . DS . "promotions" . DS . $guideArr['items'][0]['image_url']."' /></a></div>";
			}
			return $output;
	}
	public function promotionsCategorySlideShow($categoryId, $region) {
	   		$promotionsData = Mage::getModel('promotionsmgr/promotionsmgr')->getCollection();
			//get a max of two ordered by display order return as array
			$promotionsData->addFilter('region',$region)
				->addFilter('position','Slide')
				->addFilter('status',1)
				->addFilter('category_id',$categoryId)
				->setOrder('display_order','ASC')
				->setPageSize(5) //max 5 slides @todo put in config settings or leave out
				->getData();
			//$slideShow = $promotionsData->toArray();
			$output = "";
			$imageMap = "";
			if($promotionsData->count() > 0) { //a slide show is set for this category
				// create markup for container, next/prev buttons and pics container @todo html should be cleaned up with a style sheet
				$output .= '<div class="slideshowContainer">
					<div class="nav" style="z-index: 100; top: 325px; left: 300px; position: relative; width: 100px;"><a id="prev" style="float: left;" href="#"><img src="/skin/frontend/default/default/images/es15/rotation_arrow_left.png" alt="" /></a><a id="slidePause" style="float: left;" href="#nav"><img src="/skin/frontend/default/default/images/es15/rotation_pause.png" alt="" /></a><a id="next" style="float: left;" href="#"><img src="/skin/frontend/default/default/images/es15/rotation_arrow_right.png" alt="" /></a></div>
					<div id="s5" class="pics" style="height: 413px;">';
				foreach($promotionsData as $s) { //output each slide from collection
					$output .= '<img usemap="#item'.$s["promotionsmgr_id"].'" 
						src="'. Mage::getBaseUrl('media') . DS . "promotions" . DS . $s["image_url"].'" alt="" />';
					$imageMap .= '<map name="#item'.$s["promotionsmgr_id"].'">
						<area shape="rect" coords="0,0,712,355" href="'.$s['link'].'" />
						<area shape="rect" coords="712,355,480,412" href="'.$s['credits_link'].'" target="_blank" />
						<area shape="rect" coords="0,355,480,412" href="'.$s['link'].'" /> 
					</map>';
				}
				$output .= "</div></div>";
			}
			return $output . $imageMap;
	}
	public function productGrid() {
		$_product =  Mage::getModel('catalog/product');//you should declare a singleton or object reference I believe
		$productData = Mage::getModel('promotionsmgr/promotionsmgr')->getCollection()
			->addFilter('position','featured')
			->addFilter('status', 1)
			->setOrder('order','ASC')
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
