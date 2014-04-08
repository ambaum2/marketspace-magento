<?php
class MS_Members_Model_Observer
{

    public function catalogProductTypePrepare(Varien_Event_Observer $observer)
    {
        //Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
        //$user = $observer->getEvent()->getUser();
        //$user->doSomething();
    }
		
}
