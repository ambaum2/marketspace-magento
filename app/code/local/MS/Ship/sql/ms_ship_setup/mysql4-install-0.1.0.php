<?php
//programmatically changed name of the setup folder from categoryattribute1394804358_setup to ms_ship_setup
$installer = $this;
$installer->startSetup();


$installer->addAttribute("catalog_product", "ms_shipping_type",  array(
    "type"     => "int",
    "backend"  => "",
    "frontend" => "",
    "group"    => "",
    "label"    => "Shipping Type",
    "input"    => "select",
    "class"    => "",
    "source"   => "ship/eav_entity_attribute_source_productshippingoptions",
    "global"   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    "visible"  => true,
    "required" => false,
    "user_defined"  => true, //true makes it not a system attribute so that it can be removed from sets
    "default" => "",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
	
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => "The shipping Type for marketspace ship module"

	));

$installer->addAttribute("catalog_product", "ms_shipping_cost",  array(
    "type"     => "varchar",
    "backend"  => "",
    "frontend" => "",
    "group"    => "",
    "label"    => "Shipping Cost",
    "input"    => "text",
    "class"    => "",
    "source"   => "",
    "global"   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    "visible"  => true,
    "required" => false,
    "user_defined"  => true,
    "default" => "",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
	
    "visible_on_front"  => false,
    "unique"     => false,
    "note"       => "The shipping cost if you filled out epr product, per order, or per product by weight above"

	));
 //@TODO don't hard code attribute set id possibly
$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ms_shipping_type');
$installer->addAttributeToSet('catalog_product', 9, "", $attribute['attribute_id']); //"" would be the group if you needed to define one
$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', 'ms_shipping_cost');
$installer->addAttributeToSet('catalog_product', 9, "", $attribute['attribute_id']);
$installer->endSetup();
	 