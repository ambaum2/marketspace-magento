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
          $RateCalculate = new MS_Ship_Model_Rates;
          $RateInfo = $RateCalculate->get($request);
          if($RateInfo->display == 1) {
            $result = Mage::getModel('shipping/rate_result');  
            $method = Mage::getModel('shipping/rate_result_method');  
            $method->setCarrier($this->_code);  
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethod($this->_code);  
            $method->setMethodTitle($this->formatRateLineItems($RateInfo));//$this->getConfigData('name')
            $method->setPrice($RateInfo->price);
            $method->setCost($RateInfo->cost);
            $result->append($method);  
            return $result;
          } else {
            return false;
          }
        }
    /**
     * @TODO put into template...I concede that this is bad design
     * 
     */
    public function formatRateLineItems(MS_Ship_Model_Rates_Types $RateInfo) {
      $output = '<div class="table-responsive"><span>Shipping Cost</span>';
      $output .= '<table class="table"><thead><tr><th>Name</th><th>Quantity</th><th>Cost</th></tr></thead><tbody>';
      foreach($RateInfo->line_item_info as $key => $value) {
        $output .= '<tr><td>' . $value['label'] . "</td><td>" . $value['quantity'] . '</td><td>' . $value['price'] . "</td></tr>";
      }
      $output .= "</tbody></table></div>";
      return $output;
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
    