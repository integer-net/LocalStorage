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
     * Maximum cookie length is 4096 bytes, we reserve 96 bytes for overhead
     */
    const SPLIT_LENGTH = 4000;

    /**
     * Set cookie with default configuration for path, domain and lifetime
     *
     * @param IntegerNet_LocalStorage_Cookie $cookie
     * @return void
     */
    public function set(IntegerNet_LocalStorage_Cookie $cookie)
    {
        $splitValues = str_split($cookie->getValue(), self::SPLIT_LENGTH);
        $suffix = '';
        $i = 0;
        foreach ($splitValues as $splitValue) {
            Mage::getSingleton('core/cookie')->set($cookie->getName() . $suffix, $splitValue);
            $suffix = '.' . (++$i);
        }
    }

}