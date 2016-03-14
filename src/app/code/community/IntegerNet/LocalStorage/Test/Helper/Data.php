<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var IntegerNet_LocalStorage_Helper_Data
     */
    private $helper;

    protected function setUp()
    {
        $this->helper = Mage::helper('integernet_localstorage');
    }
    /**
     * @test
     * @helper integernet_localstorage
     */
    public function shouldReturnGlobalInstance()
    {
        $localStorage = $this->helper->getLocalStorage();
        $this->assertInstanceOf(IntegerNet_LocalStorage_LocalStorage::class, $localStorage);

        $localStorageAgain = $this->helper->getLocalStorage();
        $this->assertSame($localStorage, $localStorageAgain, 'subsequent call should return same instance');
    }

}