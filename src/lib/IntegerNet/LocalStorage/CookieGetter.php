<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */

//TODO use or remove
interface IntegerNet_LocalStorage_CookieGetter
{
    /**
     * Get cookie
     *
     * @param $name
     * @return mixed
     */
    public function get($name);
}