<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Shopping cart controller
 */
require_once 'Mage/Checkout/controllers/CartController.php';
class YRS_CartitemDeletion_CartController extends Mage_Checkout_CartController
{
     /**
     * Update shopping cart data action
     */
    public function updatePostAction()
    {
        if (!$this->_validateFormKey()) {
            $this->_redirect('*/*/');
            return;
        }

        $updateAction = (string)$this->getRequest()->getParam('update_cart_action');

        switch ($updateAction) {
            case 'empty_cart':
                $this->_emptyShoppingCart();
                break;
            case 'update_qty':
                $this->_updateShoppingCart();
                break;
			case 'mass_deletion':
                $this->_massdeletionCart();
                break;
            default:
                $this->_updateShoppingCart();
        }

        $this->_goBack();
    }

	protected function _massdeletionCart()
	{
		if ($this->_validateFormKey()) {
			$cartData = $this->getRequest()->getPost('item_deletion');
            if (!empty($cartData))
			{
				foreach($cartData as $val)
				{
					// echo "<pre>";print_r($val);echo "</pre>";die;
					try {
						$this->_getCart()->removeItem($val)
							->save();
					} catch (Exception $e) {
						$this->_getSession()->addError($this->__('Cannot remove the item.'));
						Mage::logException($e);
					}
				}
            }
			else{
					$this->_getSession()->addError($this->__('Please Select atleast one item to delete .'));
				}
        } else {
            $this->_getSession()->addError($this->__('Cannot remove the item.'));
        }
		 $this->_redirectReferer(Mage::getUrl('*/*'));       
		
	}


}
