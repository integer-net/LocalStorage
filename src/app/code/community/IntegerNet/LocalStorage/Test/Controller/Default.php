<?php
/**
 * integer_net Magento Module
 *
 * @category   IntegerNet
 * @package    IntegerNet_LocalStorage
 * @copyright  Copyright (c) 2016 integer_net GmbH (http://www.integer-net.de/)
 * @author     Fabian Schmengler <fs@integer-net.de>
 */
class IntegerNet_LocalStorage_Test_Controller_Default extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * @test
     * @helper integernet_localstorage
     * @loadFixture config
     */
    public function testHtmlBlock()
    {
        $dummyHtml = 'LOCALSTORAGE_HTML';
        $localstorageMock = $this->getMock(IntegerNet_LocalStorage_LocalStorage::class, array(), array(), '', false);
        $localstorageMock->expects($this->once())->method('getHtml')->willReturn($dummyHtml);
        $localstorageMock->expects($this->once())->method('sendCookie');
        /** @var IntegerNet_LocalStorage_Helper_Data|EcomDev_PHPUnit_Mock_Proxy $helperMock */
        $helperMock = $this->mockHelper('integernet_localstorage', ['getLocalStorage']);
        $helperMock->expects($this->atLeastOnce())->method('getLocalStorage')->willReturn($localstorageMock);
        $this->replaceByMock('helper', 'integernet_localstorage', $helperMock);

        $this->setCurrentStore(1);
        $this->dispatch('cms/index/index');
        $this->assertLayoutBlockActionInvoked('head', 'addJs', 'JavaScript added to head', ['integernet_localstorage/localstorage.js']);
        $this->assertLayoutBlockRendered('integernet_localstorage', 'Block should be rendered');
        $this->assertLayoutBlockParentEquals('integernet_localstorage', 'before_body_end', 'Block should be included at the bottom');
        $this->assertLayoutBlockRenderedContent('integernet_localstorage_html', $this->equalTo($dummyHtml), 'HTML block should be rendered');
        $this->assertLayoutBlockRenderedContent('integernet_localstorage_js_inline', $this->stringContains('new window.IntegernetLocalstorage()'), 'JavaScript block should be rendered');
    }

    /**
     * Overridden due to bug in EcomDev_PHPUnit 0.3.7 with wrong constant (TYPE_RENDERED)
     *
     * @param string $blockName
     * @param PHPUnit_Framework_Constraint $constraint
     * @param string $message
     */
    public static function assertLayoutBlockRenderedContent($blockName,
                                                            PHPUnit_Framework_Constraint $constraint, $message = '')
    {
        self::assertThatLayout(
            self::layoutBlock(
                $blockName,
                EcomDev_PHPUnit_Constraint_Layout_Block::TYPE_RENDERED_CONTENT,
                $constraint
            ),
            $message
        );
    }

}