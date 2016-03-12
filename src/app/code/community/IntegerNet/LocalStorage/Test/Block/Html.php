<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_Test_Block_Html extends EcomDev_PHPUnit_Test_Case
{
    const DEFAULT_CACHE_LIFETIME = 86400;

    /**
     * @test
     * @helper integernet_localstorage
     */
    public function shouldBeUncachedIfDataAdded()
    {
        /** @var IntegerNet_LocalStorage_Block_Html $block */
        $block = $this->app()->getLayout()->createBlock('integernet_localstorage/html');
        $this->assertEquals(self::DEFAULT_CACHE_LIFETIME, $block->getCacheLifetime(), 'Empty HTML Block should be cached');

        /** @var IntegerNet_LocalStorage_LocalStorage $localstorage */
        $localstorage = Mage::helper('integernet_localstorage')->getLocalStorage();
        $localstorage->addHtmlItem('cart', 'UPDATED CART HTML');

        $this->assertSame(null, $block->getCacheLifetime(), 'HTML block should be uncacheable if data has been added');
    }
}