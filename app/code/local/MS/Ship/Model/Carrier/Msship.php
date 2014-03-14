<?php  
    class MS_Ship_Model_Carrier_Msship     
		extends Mage_Shipping_Model_Carrier_Abstract
		implements Mage_Shipping_Model_Carrier_Interface
	{  
        protected $_code = 'msship';  
      
        /** 
        * Collect rates for this shipping method based on information in $request 
        * 
        * @param Mage_Shipping_Model_Rate_Request $data 
        * @return Mage_Shipping_Model_Rate_Result 
        */  
        public function collectRates(Mage_Shipping_Model_Rate_Request $request){
          $price = 0;
          $cost = 0;
          foreach ($request->getAllItems() as $_item) {
            if ($_item->getWeight() > $expressWeightThreshold) {
              //print "f off" . $_item['sku'];
              //print "<p>QTY" . $_item->getQty() . "</p>";
              //print "<p>Name: " . $_item->getName() . "</p>";
            }
          }  
          $result = Mage::getModel('shipping/rate_result');  
          $method = Mage::getModel('shipping/rate_result_method');  
          $method->setCarrier($this->_code);  
          $method->setCarrierTitle($this->getConfigData('title'));
          $method->setMethod($this->_code);  
          $method->setMethodTitle($this->getConfigData('name'));
          $method->setPrice($price);
          $method->setCost($cost);
          $result->append($method);  
          return $result;        
        }  

		/**
		 * Get allowed shipping methods
		 *
		 * @return array
		 */
		public function getAllowedMethods()
		{
			return array($this->_code=>$this->getConfigData('name'));
		}
  }  
    