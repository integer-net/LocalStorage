<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_Helper_Cookie implements IntegerNet_LocalStorage_CookieSetter
{
    /**
     * Set cookie with default configuration for path, domain and lifetime
     *
     * @param IntegerNet_LocalStorage_Cookie $cookie
     * @return void
     */
    public function set(IntegerNet_LocalStorage_Cookie $cookie)
    {
        Mage::getSingleton('core/cookie')->set($cookie->getName(), $cookie->getValue());
    }

}