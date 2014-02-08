<?php
 
class Dwg_Promotionsmgr_Adminhtml_PromotionsmgrController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('promotionsmgr/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        return $this;
    }   

    public function indexAction() {
        $this->_initAction();       
        $this->_addContent($this->getLayout()->createBlock('promotionsmgr/adminhtml_promotionsmgr'));
        $this->renderLayout();
    }
     public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $promotionsmgrId     = $this->getRequest()->getParam('id');
        $promotionsmgrModel  = Mage::getModel('promotionsmgr/promotionsmgr')->load($promotionsmgrId); //need to load your modules or 
        //whatever data model you want to prefill form and set correct form
 
        if ($promotionsmgrModel->getId() || $promotionsmgrId == 0) {
 
            Mage::register('promotionsmgr_data', $promotionsmgrModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('promotionsmgr/items');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('promotionsmgr/adminhtml_promotionsmgr_edit'))
                 ->_addLeft($this->getLayout()->createBlock('promotionsmgr/adminhtml_promotionsmgr_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('promotionsmgr')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
   /* SaveAction create new or edit existing records
      Eliminate redundency below with the saving records
      Should be able to combine most logic for save vs edit
   
   */
    public function saveAction()
    {
			if ( $this->getRequest()->getPost() ) {
				try {
				  $postData = $this->getRequest()->getPost(); //get post data
				  if(isset($_FILES['image_url']['name']) and (file_exists($_FILES['image_url']['tmp_name']))) { //must have uploaded a valid file
						$uploader = new Varien_File_Uploader('image_url');
						$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
					  $uploader->setAllowRenameFiles(false);
					  //setAllowRenameFiles(true) -> move your file in a folder the magento way
					  $uploader->setFilesDispersion(false);
					  $path = Mage::getBaseDir('media') . DS . "promotions" . DS; 
						$uploader->save($path, $_FILES['image_url']['name']);
						$data['image_url'] = $_FILES['image_url']['name'];
					}
	        if(empty($postData['promotionsmgr_id'])) { //if the item is not in table yet then we add a record.
	        $promotionsmgr = Mage::getModel('promotionsmgr/promotionsmgr');
	        $promotionsmgr->setStatus($postData['status'])
	            ->setPosition($postData['position'])
	            ->setItemOrder($postData['item_order'])
	            ->setRegion($postData['region'])
							//->setRegionName($this->getAttributeOptionName('escape_region',$postData['region']))
							->setCategoryId($postData['category_id'])
							->setCategoryName($this->getCategoryNameById($postData['category_id']))
							->setImageUrl($data['image_url'])
							->setGuideId($postData['guide_id'])
							->setProductId($postData['product_id'])
							->setLink($postData['link'])
							->setStartTime($postData['start_time'])
							->setEndTime($postData['end_time'])
							->setImageAltTag($postData['image_alt_tag'])
	            ->save();
	        } else { // edit the existing record
	        $promotionsmgr = Mage::getModel('promotionsmgr/promotionsmgr');
	        //this will update the db the setId is important here. We check if their is already a record in the table with that pk
	          $promotionsmgr->setId($this->getRequest()->getParam('promotionsmgr_id'))
	  					->setStatus($postData['status'])
	            ->setPosition($postData['position'])
	            ->setItemOrder($postData['item_order'])
	            ->setRegion($postData['region'])
							//->setRegionName($this->getAttributeOptionName('escape_region',$postData['region']))
							->setCategoryId($postData['category_id'])
							->setCategoryName($this->getCategoryNameById($postData['category_id']))
							->setLink($postData['link'])
							->setGuideId($postData['guide_id'])
							->setProductId($postData['product_id'])
							->setStartTime($postData['start_time'])
							->setEndTime($postData['end_time'])
							->setImageAltTag($postData['image_alt_tag']);
	          (!empty($data['image_url']) ? $promotionsmgr->setImageUrl($data['image_url']) : '');
	            $promotionsmgr->save();
	        }
	          Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved. Image at: ' . $path));
	          Mage::getSingleton('adminhtml/session')->setPromotionsmgrData(false);
						$this->_redirect('*/*/');
				    return;
	        } catch (Exception $e) {
	            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	            Mage::getSingleton('adminhtml/session')->setPromotionsmgrData($this->getRequest()->getPost());
	            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
	            return;
	        }
			}
    }
   
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('importedit/adminhtml_promotionsmgr_grid')->toHtml()
        );
    }
	
	//controller helper functions
	public function getAttributeOptionName($attribute,$optionId) {
		$attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product',$attribute);
 		$attributeModel = Mage::getModel('catalog/resource_eav_attribute')->load($attributeId);
		foreach($attributeModel->getSource()->getAllOptions(false) as $opt) {
			if($opt['value'] == $optionId) {
				return $opt['label'];
			}
		}
	}
	
	public function getCategoryNameById($categoryId) {
		$category = Mage::getModel('catalog/category')->load($categoryId);
		return $category->getName();
	}
}