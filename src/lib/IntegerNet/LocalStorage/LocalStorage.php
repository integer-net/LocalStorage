<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_LocalStorage
{
    /**
     * @var IntegerNet_LocalStorage_CookieSetter
     */
    private $cookieSetter;
    /**
     * @var mixed[]
     */
    private $cookieItems = [];
    /**
     * @var string[]
     */
    private $htmlItems = [];

    const HTML_TEMPLATE =
<<<HTML
<div hidden aria-hidden="true" data-integernet_localstorage_key="{{key}}" class="integernet-localstorage-html">
{{value}}
</div>
HTML;

    /**
     * IntegerNet_LocalStorage_LocalStorage constructor.
     * @param IntegerNet_LocalStorage_CookieSetter $cookieSetter
     */
    public function __construct(IntegerNet_LocalStorage_CookieSetter $cookieSetter)
    {
        $this->cookieSetter = $cookieSetter;
    }

    /**
     * @param string $key
     * @param string $value should be valid HTML
     */
    public function addHtmlItem($key, $value)
    {
        $this->htmlItems[$key] = $value;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function addCookieItem($key, $value)
    {
        $this->cookieItems[$key] = $value;
    }

    /**
     * @return void
     */
    public function sendCookie()
    {
        if ($this->cookieItems) {
            $transportCookie = new IntegerNet_LocalStorage_TransportCookie($this->cookieItems);
            $this->cookieSetter->set($transportCookie);
        }
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        $html = [];
        foreach ($this->htmlItems as $key => $value) {
            $html[] = strtr(self::HTML_TEMPLATE, [
                '{{key}}'   => $key,
                '{{value}}' => $value,
            ]);
        }
        return join("\n", $html);;
    }

    public function hasHtmlItems()
    {
        return ! empty($this->htmlItems);
    }
    public function hasCookieItems()
    {
        return ! empty($this->cookieItems);
    }

}