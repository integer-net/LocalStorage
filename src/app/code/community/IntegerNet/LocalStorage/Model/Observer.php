<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_Model_Observer
{
    /**
     * @see event controller_action_postdispatch
     */
    public function sendCookie()
    {
        Mage::helper('integernet_localstorage')->getLocalStorage()->sendCookie();
    }
}