<?php
class YRS_CustomTab_Model_Observer {

    public function AddCustomTab($observer) {		
		$check_enable=Mage::helper('customtab')->EnableDisable();		
		if($check_enable==true)
		{
			$tabs = $observer->getTabs();
			$tabs->addTab('myextratab', array(
				'label'     => Mage::helper('catalog')->__('My Extra Tab'),
				'content'   => 'Here is the contents for my extra tab'
			)); 
			// Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl($url));
			// Mage::app()->getResponse()->sendResponse();
			// exit;
			
		}
        
    }	

}
?>