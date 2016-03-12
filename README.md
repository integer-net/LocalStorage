IntegerNet LocalStorage
=====================
Magento 1 extension: Provides an interface to pass data from the server to client side localstorage, to be used with full page cache, for example Varnish.

## Example Usage

Push updated cart item count in Magento observer:

```
    /**
     * @param Varien_Event_Observer $observer
     * @see event checkout_cart_save_after
     * @see event customer_login
     */
    public function updateCartLocalStorage(Varien_Event_Observer $observer)
    {
        /** @var Mage_Checkout_Model_Cart $cart */
        $cart = $observer->getData('cart');
        if (! $cart) {
            $cart = Mage::getSingleton('checkout/cart');
        }
        /** @var IntegerNet_LocalStorage_Helper_Data $helper */
        $helper = Mage::helper('integernet_localstorage');
        $helper->getLocalStorage()->addCookieItem('cart_item_count', $cart->getSummaryQty());
    }
```

Read item count from localstorage with JavaScript in template:

```
<a href="<?php echo Mage::getUrl('checkout/cart'); ?>" class="btn">
	<strong><?php echo Mage::helper('checkout')->__('Cart') ?></strong>
	<span><b id="minicart-item-count">0</b> <?php echo Mage::helper('checkout')->__('Items') ?></span>
</a>
<script type="text/javascript">
    IntegernetLocalstorage.callbacks.push(function(storage) {
        var count = storage.get('cart_item_count');
        if (count) {
            $('minicart-item-count').update(count);
        }
    });
</script>
```

## Tests

### PHP Unit Tests

Run in repository:

    phpunit

### JS Unit Tests

Open in browser:

[src/js/integernet_localstorage/localstorage_test.html](src/js/integernet_localstorage/localstorage_test.html)

### Integration Tests

Run in Magento root with EcomDev_PHPUnit:

    phpunit --group IntegerNet_LocalStorage

Support
-------
If you have any issues with this extension, open an issue on [GitHub](https://github.com/integer-net/DevDashboard/issues).

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developer
---------
Fabian Schmengler, integer\_net GmbH ([@fschmengler](https://twitter.com/fschmengler))

License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
Copyright (c) 2016 integer\_net GmbH
[http://www.integer-net.com](http://www.integer-net.com) ([@integer_net](https://twitter.com/integer_net))
