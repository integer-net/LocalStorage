<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_LocalStorageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateAndSendTransportCookie()
    {
        $expectedTransportCookie = new IntegerNet_LocalStorage_TransportCookie(
            ['any_key' => 'any_value', 'other_key' => 'other_value']
        );
        $cookieSetterMock = $this->getMockForAbstractClass(IntegerNet_LocalStorage_CookieSetter::class);
        $cookieSetterMock->expects($this->once())->method('set')->with(
            $expectedTransportCookie
        );
        $localStorage = new IntegerNet_LocalStorage_LocalStorage($cookieSetterMock);
        $localStorage->addCookieItem('any_key', 'any_value');
        $localStorage->addCookieItem('other_key', 'other_value');
        $localStorage->sendCookie();
    }

    /**
     * @test
     */
    public function shouldCreateHtml()
    {
        $expectedHtml = '<div hidden aria-hidden="true" data-integernet_localstorage_key="any_key" class="integernet-localstorage-html">
any <strong>HTML</strong> value
<p>across multiple lines</p>
</div>
<div hidden aria-hidden="true" data-integernet_localstorage_key="other_key" class="integernet-localstorage-html">
42
</div>';
        $cookieSetterStub = $this->getMockForAbstractClass(IntegerNet_LocalStorage_CookieSetter::class);
        $localStorage = new IntegerNet_LocalStorage_LocalStorage($cookieSetterStub);
        $localStorage->addHtmlItem('any_key', 'any <strong>HTML</strong> value
<p>across multiple lines</p>');
        $localStorage->addHtmlItem('other_key', '42');

        $this->assertEquals($expectedHtml, $localStorage->getHtml());
    }

    /**
     * @test
     */
    public function shouldProvideItemInformation()
    {
        $cookieSetterStub = $this->getMockForAbstractClass(IntegerNet_LocalStorage_CookieSetter::class);
        $localStorage = new IntegerNet_LocalStorage_LocalStorage($cookieSetterStub);
        $this->assertFalse($localStorage->hasHtmlItems(), 'hasHtmlItems()');
        $this->assertFalse($localStorage->hasCookieItems(), 'hasCookieItems()');

        $localStorage->addCookieItem('key', 'value');
        $this->assertFalse($localStorage->hasHtmlItems(), 'hasHtmlItems() after cookie item added');
        $this->assertTrue($localStorage->hasCookieItems(), 'hasCookieItems() after cookie item added');

        $localStorage->addHtmlItem('key', 'value');
        $this->assertTrue($localStorage->hasHtmlItems(), 'hasHtmlItems() after both added');
        $this->assertTrue($localStorage->hasCookieItems(), 'hasCookieItems() after both added');
    }
}