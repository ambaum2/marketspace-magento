<?php
 
class Dwg_Featuredprod_Block_Adminhtml_Featuredprod extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        //These properties are from the parent class
        $this->_controller = 'adminhtml_featuredprod';
        $this->_blockGroup = 'featuredprod';
        $this->_headerText = Mage::helper('featuredprod')->__('Item Manager');      
        parent::__construct();
        //_removeButton is called in the parent constructor so we have to remove it 
        // after the constructor is called. Notice the 'add' id is defined in the 
        // constructor - that is why it is hard coded here. I saw no way of dynamically
        // calling it
        $this->_removeButton('add');
        
    }
}