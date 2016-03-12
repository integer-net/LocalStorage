<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */

/**
 * Represents the Cookie used to add items to the localstorage
 */
final class IntegerNet_LocalStorage_TransportCookie implements IntegerNet_LocalStorage_Cookie
{
    const TRANSPORT_COOKIE_NAME = 'integernet_localstorage';

    private $items = array();

    public function __construct($items = array())
    {
        $this->items = $items;
    }
    public function getName()
    {
        return self::TRANSPORT_COOKIE_NAME;
    }
    public function getValue()
    {
        $result = array();
        foreach ($this->items as $key => $value) {
            $result[] = array(
                'key' => $key,
                'value' => base64_encode($value),
            );
        }
        return json_encode($result);
    }
}