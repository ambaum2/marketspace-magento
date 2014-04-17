<?php
class MS_Deals_Block_Adminhtml_Memberdeals_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("deals_form", array("legend"=>Mage::helper("deals")->__("Item information")));

				
						$fieldset->addField("product_id", "text", array(
                            "label" => Mage::helper("deals")->__("Product Id"),
                            "class" => "required-entry",
                            "required" => true,
                            "name" => "product_id",
						));
					
						$fieldset->addField("user_id", "text", array(
                            "label" => Mage::helper("deals")->__("User Id"),
                            "class" => "required-entry",
                            "required" => true,
                            "name" => "user_id",
						));

                        $fieldset->addField("quantity", "text", array(
                            "label" => Mage::helper("deals")->__("Quantity"),
                            "class" => "required-entry",
                            "required" => true,
                            "name" => "quantity",
                        ));

						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('created', 'date', array(
                            'label'        => Mage::helper('deals')->__('Activated Date'),
                            'name'         => 'created',
                            "class" => "required-entry",
                            "required" => true,
                            'time' => true,
                            'image'        => $this->getSkinUrl('images/grid-cal.gif'),
                            'format'       => $dateFormatIso
						));
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('modified', 'date', array(
                            'label'        => Mage::helper('deals')->__('Modified Date'),
                            'name'         => 'modified',
                            "class" => "required-entry",
                            "required" => true,
                            'time' => true,
                            'image'        => $this->getSkinUrl('images/grid-cal.gif'),
                            'format'       => $dateFormatIso
						));

				if (Mage::getSingleton("adminhtml/session")->getMemberdealsData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getMemberdealsData());
					Mage::getSingleton("adminhtml/session")->setMemberdealsData(null);
				} 
				elseif(Mage::registry("memberdeals_data")) {
				    $form->setValues(Mage::registry("memberdeals_data")->getData());
				}
				return parent::_prepareForm();
		}
}
