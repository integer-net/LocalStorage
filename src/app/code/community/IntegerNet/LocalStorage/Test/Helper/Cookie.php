<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_Test_Helper_Cookie extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var IntegerNet_LocalStorage_Helper_Cookie
     */
    private $helper;

    protected function setUp()
    {
        $this->helper = Mage::helper('integernet_localstorage/cookie');
    }

    /**
     * @test
     * @singleton core/cookie
     * @helper integernet_localstorage/cookie
     */
    public function shouldSetCookie()
    {
        $inputKey = 'KEY';
        $inputValue = 'VALUE';
        $this->mockMageCookie()
            ->expects($this->once())
            ->method('set')
            ->with($inputKey, $inputValue);
        $this->helper->set($this->getCookieStub($inputKey, $inputValue));
    }
    /**
     * @test
     * @singleton core/cookie
     * @helper integernet_localstorage/cookie
     */
    public function shouldSplitCookieLargerThan4Kb()
    {
        $inputKey = 'KEY';
        $inputValue = str_repeat('Xo', (IntegerNet_LocalStorage_Helper_Cookie::SPLIT_LENGTH / 2) + 1);
        $expectedKeys = ['KEY', 'KEY.1'];
        $expectedValues = [str_repeat('Xo', IntegerNet_LocalStorage_Helper_Cookie::SPLIT_LENGTH / 2), 'Xo'];
        $this->mockMageCookie()
            ->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive(
                [$expectedKeys[0], $expectedValues[0]],
                [$expectedKeys[1], $expectedValues[1]]
            );
        $this->helper->set($this->getCookieStub($inputKey, $inputValue));
    }

    /**
     * @param $inputKey
     * @param $inputValue
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getCookieStub($inputKey, $inputValue)
    {
        $cookieStub = $this->getMockForAbstractClass(IntegerNet_LocalStorage_Cookie::class);
        $cookieStub->method('getName')->willReturn($inputKey);
        $cookieStub->method('getValue')->willReturn($inputValue);
        return $cookieStub;
    }

    /**
     * @return EcomDev_PHPUnit_Mock_Proxy
     */
    private function mockMageCookie()
    {
        $mageCookieMock = $this->getModelMock('core/cookie');
        $this->replaceByMock('singleton', 'core/cookie', $mageCookieMock);
        return $mageCookieMock;
    }
}