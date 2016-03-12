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
     * @test
     * @helper integernet_localstorage
     */
    public function shouldReturnGlobalInstance()
    {
        /** @var IntegerNet_LocalStorage_Helper_Data $helper */
        $helper = Mage::helper('integernet_localstorage');
        $localStorage = $helper->getLocalStorage();
        $this->assertInstanceOf(IntegerNet_LocalStorage_LocalStorage::class, $localStorage);

        $localStorageAgain = $helper->getLocalStorage();
        $this->assertSame($localStorage, $localStorageAgain, 'subsequent call should return same instance');
    }
}