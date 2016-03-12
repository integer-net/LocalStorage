<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
interface IntegerNet_LocalStorage_CookieSetter
{
    /**
     * Set cookie with default configuration for path, domain and lifetime
     *
     * @param IntegerNet_LocalStorage_Cookie $cookie
     * @return void
     */
    public function set(IntegerNet_LocalStorage_Cookie $cookie);
}