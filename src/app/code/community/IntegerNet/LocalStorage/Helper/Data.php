<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_localStorage;

    public function getLocalStorage()
    {
        if ($this->_localStorage === null) {
            $this->_localStorage = new IntegerNet_LocalStorage_LocalStorage(
                Mage::helper('integernet_localstorage/cookie')
            );
        }
        return $this->_localStorage;
    }
}