<?php
class Dwg_Adminhtml_Block_Widget_Grid_Column_Renderer_Expguide extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
         //$data = MyHelperClass::calculateSpecialDate($row->getData($this->getColumn()->getIndex()));
         $data =  $row->getData($this->getColumn()->getIndex());
          return "<a style='color:blue;font-weight:bolder' href='' class='exp_maker_box'>".$data."</a>";
    }
}