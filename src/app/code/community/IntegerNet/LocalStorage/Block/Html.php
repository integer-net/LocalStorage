<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_Block_Html extends Mage_Core_Block_Abstract
{
    const NO_CACHE = null;
    const CACHE_LIFETIME = 86400;

    /**
     * @return int
     */
    public function getCacheLifetime()
    {
        /** @var IntegerNet_LocalStorage_LocalStorage $localstorage */
        $localstorage = Mage::helper('integernet_localstorage')->getLocalStorage();
        if ($localstorage->hasHtmlItems()) {
            return self::NO_CACHE;
        }
        return self::CACHE_LIFETIME;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        return Mage::helper('integernet_localstorage')->getLocalStorage()->getHtml();
    }

}