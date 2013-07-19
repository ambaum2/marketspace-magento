<?php
 
class Dwg_Featuredprod_Adminhtml_FeaturedprodController extends Mage_Adminhtml_Controller_Action
{
 
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('featuredprod/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        return $this;
    }   
   
    public function indexAction() {
        $this->_initAction();       
        $this->_addContent($this->getLayout()->createBlock('featuredprod/adminhtml_featuredprod'));
        $this->renderLayout();
    }
 
    public function editAction()
    {
        $featuredprodId     = $this->getRequest()->getParam('id');
        $featuredprodModel  = Mage::getModel('catalog/product')->load($featuredprodId);
 
        if ($featuredprodModel->getId() || $featuredprodId == 0) {
 
            Mage::register('featuredprod_data', $featuredprodModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('featuredprod/items');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('featuredprod/adminhtml_featuredprod_edit'))
                 ->_addLeft($this->getLayout()->createBlock('featuredprod/adminhtml_featuredprod_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('featuredprod')->__('Item does not exist'));
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
                //when adding new table columns you may need to flush cache storage - even if caching disabled 
                if(empty($postData['featuredprod_id'])) { //if the item is not in table yet then we add a record.
                $featuredProd = Mage::getModel('featuredprod/featuredprod');
                $featuredProd->setFeatStatus($postData['status'])
                    ->setFeatType($postData['feat_type'])
                    ->setEntityId($postData['entity_id'])
                    ->setFeatOrder($postData['feat_order'])
                    ->save();
                } else { // edit the existing record
                $featuredProd = Mage::getModel('featuredprod/featuredprod');
                //this will update the db the setId is important here. We check if their is already a record in the table with that pk
                  $featuredProd->setId($this->getRequest()->getParam('featuredprod_id'))
                    ->setFeatStatus($postData['status'])
                    ->setFeatType($postData['feat_type'])
                    ->setEntityId($postData['entity_id'])
                    ->setFeatOrder($postData['feat_order'])
                    ->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFeaturedprodData(false);
 
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFeaturedprodData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        //$this->_redirect('*/*/');
    }
   
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('importedit/adminhtml_featuredprod_grid')->toHtml()
        );
    }
}