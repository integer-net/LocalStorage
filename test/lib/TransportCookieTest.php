<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_TransportCookieTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider dataValues
     */
    public function shouldAddEncodedValue($inputArray, $expectedCookieValue)
    {
        $cookieModel = new IntegerNet_LocalStorage_TransportCookie($inputArray);
        $this->assertEquals('integernet_localstorage', $cookieModel->getName());
        $this->assertEquals($expectedCookieValue, $cookieModel->getValue());
    }

    public static function dataValues()
    {
        return [
            'utf-8' => [
                ['key 1' => '<div id="cart">Updated Shopping Cart (möp)</div>'],
                "[{\"key\":\"key 1\",\"value\":\"PGRpdiBpZD0iY2FydCI+VXBkYXRlZCBTaG9wcGluZyBDYXJ0IChtw7ZwKTwvZGl2Pg==\"}]"
            ],
            'newline & semicolon' => [
                ['key 1' => "<p>\n\t;\n</p>"],
                "[{\"key\":\"key 1\",\"value\":\"PHA+Cgk7CjwvcD4=\"}]"
            ],
            'mulitiple keys' => [
                ['key 1' => 42, 'key 2' => "{ vs: 'freddy' }"],
                "[{\"key\":\"key 1\",\"value\":\"NDI=\"},{\"key\":\"key 2\",\"value\":\"eyB2czogJ2ZyZWRkeScgfQ==\"}]"
            ],
        ];
    }
}