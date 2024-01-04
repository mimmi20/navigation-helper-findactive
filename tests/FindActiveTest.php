<?php
/**
 * This file is part of the mimmi20/navigation-helper-findactive package.
 *
 * Copyright (c) 2021-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20Test\NavigationHelper\FindActive;

use Laminas\Navigation\Page\AbstractPage;
use Mimmi20\Mezzio\Navigation\Exception\InvalidArgumentException;
use Mimmi20\Mezzio\Navigation\Navigation;
use Mimmi20\Mezzio\Navigation\Page\PageInterface;
use Mimmi20\Mezzio\Navigation\Page\Uri;
use Mimmi20\NavigationHelper\Accept\AcceptHelperInterface;
use Mimmi20\NavigationHelper\FindActive\FindActive;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

final class FindActiveTest extends TestCase
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testFindActiveNoActivePages(): void
    {
        $container = new Navigation();

        $page = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page->expects(self::never())
            ->method('isVisible');
        $page->expects(self::never())
            ->method('getResource');
        $page->expects(self::never())
            ->method('getPrivilege');
        $page->expects(self::never())
            ->method('getParent');
        $page->expects(self::never())
            ->method('isActive');
        $page->expects(self::once())
            ->method('hashCode')
            ->willReturn('page');
        $page->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page->expects(self::once())
            ->method('setParent')
            ->with($container);

        $container->addPage($page);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $acceptHelper->expects(self::once())
            ->method('accept')
            ->with($page)
            ->willReturn(false);

        $helper = new FindActive($acceptHelper);

        self::assertSame([], $helper->find($container, 0, 42));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testFindActiveOneActivePage(): void
    {
        $container = new Navigation();

        $page = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page->expects(self::never())
            ->method('isVisible');
        $page->expects(self::never())
            ->method('getResource');
        $page->expects(self::never())
            ->method('getPrivilege');
        $page->expects(self::never())
            ->method('getParent');
        $page->expects(self::once())
            ->method('isActive')
            ->with(false)
            ->willReturn(true);
        $page->expects(self::once())
            ->method('hashCode')
            ->willReturn('page');
        $page->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page->expects(self::once())
            ->method('setParent')
            ->with($container);

        $container->addPage($page);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $acceptHelper->expects(self::once())
            ->method('accept')
            ->with($page)
            ->willReturn(true);

        $helper = new FindActive($acceptHelper);

        $expected = [
            'page' => $page,
            'depth' => 0,
        ];

        self::assertSame($expected, $helper->find($container, 0, 42));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Navigation\Exception\InvalidArgumentException
     */
    public function testFindActiveOneActivePage2(): void
    {
        $container = new \Laminas\Navigation\Navigation();

        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page->expects(self::never())
            ->method('isVisible');
        $page->expects(self::never())
            ->method('getResource');
        $page->expects(self::never())
            ->method('getPrivilege');
        $page->expects(self::never())
            ->method('getParent');
        $page->expects(self::once())
            ->method('isActive')
            ->with(false)
            ->willReturn(true);
        $page->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page->expects(self::once())
            ->method('setParent')
            ->with($container);

        $container->addPage($page);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $acceptHelper->expects(self::once())
            ->method('accept')
            ->with($page)
            ->willReturn(true);

        $helper = new FindActive($acceptHelper);

        $expected = [
            'page' => $page,
            'depth' => 0,
        ];

        self::assertSame($expected, $helper->find($container, 0, 42));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testFindActiveOneActivePageOutOfRange(): void
    {
        $container = new Navigation();

        $page = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page->expects(self::never())
            ->method('isVisible');
        $page->expects(self::never())
            ->method('getResource');
        $page->expects(self::never())
            ->method('getPrivilege');
        $page->expects(self::never())
            ->method('getParent');
        $page->expects(self::never())
            ->method('isActive');
        $page->expects(self::once())
            ->method('hashCode')
            ->willReturn('page');
        $page->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page->expects(self::once())
            ->method('setParent')
            ->with($container);

        $container->addPage($page);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $acceptHelper->expects(self::never())
            ->method('accept');

        $helper = new FindActive($acceptHelper);

        $expected = [];

        self::assertSame($expected, $helper->find($container, 2, 42));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Navigation\Exception\InvalidArgumentException
     */
    public function testFindActiveOneActivePageOutOfRange2(): void
    {
        $container = new \Laminas\Navigation\Navigation();

        $page = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page->expects(self::never())
            ->method('isVisible');
        $page->expects(self::never())
            ->method('getResource');
        $page->expects(self::never())
            ->method('getPrivilege');
        $page->expects(self::never())
            ->method('getParent');
        $page->expects(self::never())
            ->method('isActive');
        $page->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page->expects(self::once())
            ->method('setParent')
            ->with($container);

        $container->addPage($page);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $acceptHelper->expects(self::never())
            ->method('accept');

        $helper = new FindActive($acceptHelper);

        $expected = [];

        self::assertSame($expected, $helper->find($container, 2, 42));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testFindActiveOneActivePageRecursive(): void
    {
        $resource  = 'testResource';
        $privilege = 'testPrivilege';

        $parentPage = new Uri();
        $parentPage->setVisible(true);
        $parentPage->setResource($resource);
        $parentPage->setPrivilege($privilege);

        $page1 = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page1->expects(self::never())
            ->method('isVisible');
        $page1->expects(self::never())
            ->method('getResource');
        $page1->expects(self::never())
            ->method('getPrivilege');
        $page1->expects(self::once())
            ->method('getParent')
            ->willReturn($parentPage);
        $page1->expects(self::once())
            ->method('isActive')
            ->with(false)
            ->willReturn(true);
        $page1->expects(self::once())
            ->method('hashCode')
            ->willReturn('page1');
        $page1->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page1->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $page2 = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page2->expects(self::never())
            ->method('isVisible');
        $page2->expects(self::never())
            ->method('getResource');
        $page2->expects(self::never())
            ->method('getPrivilege');
        $page2->expects(self::never())
            ->method('getParent');
        $page2->expects(self::never())
            ->method('isActive');
        $page2->expects(self::once())
            ->method('hashCode')
            ->willReturn('page2');
        $page2->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page2->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $page3 = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page3->expects(self::never())
            ->method('isVisible');
        $page3->expects(self::never())
            ->method('getResource');
        $page3->expects(self::never())
            ->method('getPrivilege');
        $page3->expects(self::never())
            ->method('getParent');
        $page3->expects(self::never())
            ->method('isActive');
        $page3->expects(self::once())
            ->method('hashCode')
            ->willReturn('page3');
        $page3->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page3->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $parentPage->addPage($page1);
        $parentPage->addPage($page2);
        $parentPage->addPage($page3);

        $container = new Navigation();
        $container->addPage($parentPage);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher      = self::exactly(4);
        $acceptHelper->expects($matcher)
            ->method('accept')
            ->willReturnCallback(
                static function (AbstractPage | PageInterface $page, bool $recursive = true) use ($matcher, $page1, $page2, $page3, $parentPage): bool {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($page1, $page),
                        2 => self::assertSame($page2, $page),
                        3 => self::assertSame($page3, $page),
                        default => self::assertSame($parentPage, $page),
                    };

                    self::assertTrue($recursive);

                    return match ($matcher->numberOfInvocations()) {
                        2, 3 => false,
                        default => true,
                    };
                },
            );

        $helper = new FindActive($acceptHelper);

        $expected = [
            'page' => $parentPage,
            'depth' => 0,
        ];

        self::assertSame($expected, $helper->find($container, 0, 0));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testFindActiveOneActivePageRecursive2(): void
    {
        $resource  = 'testResource';
        $privilege = 'testPrivilege';

        $parentPage = new Uri();
        $parentPage->setVisible(true);
        $parentPage->setActive(true);
        $parentPage->setUri('parent');
        $parentPage->setResource($resource);
        $parentPage->setPrivilege($privilege);

        $page1 = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page1->expects(self::never())
            ->method('isVisible');
        $page1->expects(self::never())
            ->method('getResource');
        $page1->expects(self::never())
            ->method('getPrivilege');
        $page1->expects(self::once())
            ->method('getParent')
            ->willReturn($parentPage);
        $page1->expects(self::once())
            ->method('isActive')
            ->with(false)
            ->willReturn(true);
        $page1->expects(self::once())
            ->method('hashCode')
            ->willReturn('page1');
        $page1->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page1->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $page2 = new Uri();
        $page2->setActive(true);
        $page2->setUri('test2');

        $parentPage->addPage($page1);
        $parentPage->addPage($page2);

        $parentParentPage = new Uri();
        $parentParentPage->setVisible(true);
        $parentParentPage->setActive(true);
        $parentParentPage->setUri('parentParent');

        $parentParentParentPage = new Uri();
        $parentParentParentPage->setVisible(true);
        $parentParentParentPage->setActive(true);
        $parentParentParentPage->setUri('parentParentParent');

        $parentParentPage->addPage($parentPage);
        $parentParentParentPage->addPage($parentParentPage);

        $container = new Navigation();
        $container->addPage($parentParentParentPage);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher      = self::exactly(3);
        $acceptHelper->expects($matcher)
            ->method('accept')
            ->willReturnCallback(
                static function (AbstractPage | PageInterface $page, bool $recursive = true) use ($matcher, $page1, $page2, $parentPage): bool {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($page1, $page),
                        2 => self::assertSame($page2, $page),
                        default => self::assertSame($parentPage, $page),
                    };

                    self::assertTrue($recursive);

                    return true;
                },
            );

        $helper = new FindActive($acceptHelper);

        $expected = [];

        self::assertSame($expected, $helper->find($container, 2, 1));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testFindActiveOneActivePageRecursive3(): void
    {
        $resource  = 'testResource';
        $privilege = 'testPrivilege';

        $parentPage = new Uri();
        $parentPage->setVisible(true);
        $parentPage->setActive(true);
        $parentPage->setUri('parent');
        $parentPage->setResource($resource);
        $parentPage->setPrivilege($privilege);

        $page1 = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page1->expects(self::never())
            ->method('isVisible');
        $page1->expects(self::never())
            ->method('getResource');
        $page1->expects(self::never())
            ->method('getPrivilege');
        $page1->expects(self::once())
            ->method('getParent')
            ->willReturn(null);
        $page1->expects(self::once())
            ->method('isActive')
            ->with(false)
            ->willReturn(true);
        $page1->expects(self::once())
            ->method('hashCode')
            ->willReturn('page1');
        $page1->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page1->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $page2 = new Uri();
        $page2->setActive(true);
        $page2->setUri('test2');

        $parentPage->addPage($page1);
        $parentPage->addPage($page2);

        $parentParentPage = new Uri();
        $parentParentPage->setVisible(true);
        $parentParentPage->setActive(true);
        $parentParentPage->setUri('parentParent');

        $parentParentParentPage = new Uri();
        $parentParentParentPage->setVisible(true);
        $parentParentParentPage->setActive(true);
        $parentParentParentPage->setUri('parentParentParent');

        $parentParentPage->addPage($parentPage);
        $parentParentParentPage->addPage($parentParentPage);

        $container = new Navigation();
        $container->addPage($parentParentParentPage);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher      = self::exactly(5);
        $acceptHelper->expects($matcher)
            ->method('accept')
            ->willReturnCallback(
                static function (AbstractPage | PageInterface $page, bool $recursive = true) use ($matcher, $page1, $page2, $parentPage, $parentParentPage, $parentParentParentPage): bool {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($page1, $page),
                        2 => self::assertSame($page2, $page),
                        4 => self::assertSame($parentParentPage, $page),
                        5 => self::assertSame($parentParentParentPage, $page),
                        default => self::assertSame($parentPage, $page),
                    };

                    self::assertTrue($recursive);

                    return true;
                },
            );

        $helper = new FindActive($acceptHelper);

        $expected = [];

        self::assertSame($expected, $helper->find($container, -1, -1));
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testFindActiveOneActivePageRecursive4(): void
    {
        $resource  = 'testResource';
        $privilege = 'testPrivilege';

        $parentPage = new Uri();
        $parentPage->setVisible(true);
        $parentPage->setActive(true);
        $parentPage->setUri('parent');
        $parentPage->setResource($resource);
        $parentPage->setPrivilege($privilege);

        $page1 = $this->getMockBuilder(PageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page1->expects(self::never())
            ->method('isVisible');
        $page1->expects(self::never())
            ->method('getResource');
        $page1->expects(self::never())
            ->method('getPrivilege');
        $page1->expects(self::never())
            ->method('getParent');
        $page1->expects(self::once())
            ->method('isActive')
            ->with(false)
            ->willReturn(true);
        $page1->expects(self::once())
            ->method('hashCode')
            ->willReturn('page1');
        $page1->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page1->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $page2 = new Uri();
        $page2->setActive(true);
        $page2->setUri('test2');

        $parentPage->addPage($page1);
        $parentPage->addPage($page2);

        $parentParentPage = new Uri();
        $parentParentPage->setVisible(true);
        $parentParentPage->setActive(true);
        $parentParentPage->setUri('parentParent');

        $parentParentParentPage = new Uri();
        $parentParentParentPage->setVisible(true);
        $parentParentParentPage->setActive(true);
        $parentParentParentPage->setUri('parentParentParent');

        $parentParentPage->addPage($parentPage);
        $parentParentParentPage->addPage($parentParentPage);

        $container = new Navigation();
        $container->addPage($parentParentParentPage);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher      = self::exactly(5);
        $acceptHelper->expects($matcher)
            ->method('accept')
            ->willReturnCallback(
                static function (AbstractPage | PageInterface $page, bool $recursive = true) use ($matcher, $page1, $page2, $parentPage, $parentParentPage, $parentParentParentPage): bool {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($page1, $page),
                        2 => self::assertSame($page2, $page),
                        4 => self::assertSame($parentParentPage, $page),
                        5 => self::assertSame($parentParentParentPage, $page),
                        default => self::assertSame($parentPage, $page),
                    };

                    self::assertTrue($recursive);

                    return true;
                },
            );

        $helper = new FindActive($acceptHelper);

        $expected = [
            'page' => $page1,
            'depth' => 3,
        ];

        self::assertSame($expected, $helper->find($container, -1, 3));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Navigation\Exception\InvalidArgumentException
     */
    public function testFindActiveOneActivePageRecursive5(): void
    {
        $resource  = 'testResource';
        $privilege = 'testPrivilege';

        $parentPage = new \Laminas\Navigation\Page\Uri();
        $parentPage->setVisible(true);
        $parentPage->setActive(true);
        $parentPage->setUri('parent');
        $parentPage->setResource($resource);
        $parentPage->setPrivilege($privilege);

        $page1 = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page1->expects(self::never())
            ->method('isVisible');
        $page1->expects(self::never())
            ->method('getResource');
        $page1->expects(self::never())
            ->method('getPrivilege');
        $page1->expects(self::never())
            ->method('getParent');
        $page1->expects(self::once())
            ->method('isActive')
            ->with(false)
            ->willReturn(true);
        $page1->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page1->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $page2 = new \Laminas\Navigation\Page\Uri();
        $page2->setActive(true);
        $page2->setUri('test2');

        $parentPage->addPage($page1);
        $parentPage->addPage($page2);

        $parentParentPage = new \Laminas\Navigation\Page\Uri();
        $parentParentPage->setVisible(true);
        $parentParentPage->setActive(true);
        $parentParentPage->setUri('parentParent');

        $parentParentParentPage = new \Laminas\Navigation\Page\Uri();
        $parentParentParentPage->setVisible(true);
        $parentParentParentPage->setActive(true);
        $parentParentParentPage->setUri('parentParentParent');

        $parentParentPage->addPage($parentPage);
        $parentParentParentPage->addPage($parentParentPage);

        $container = new \Laminas\Navigation\Navigation();
        $container->addPage($parentParentParentPage);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher      = self::exactly(5);
        $acceptHelper->expects($matcher)
            ->method('accept')
            ->willReturnCallback(
                static function (AbstractPage | PageInterface $page, bool $recursive = true) use ($matcher, $page1, $page2, $parentPage, $parentParentPage, $parentParentParentPage): bool {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($page1, $page),
                        2 => self::assertSame($page2, $page),
                        4 => self::assertSame($parentParentPage, $page),
                        5 => self::assertSame($parentParentParentPage, $page),
                        default => self::assertSame($parentPage, $page),
                    };

                    self::assertTrue($recursive);

                    return true;
                },
            );

        $helper = new FindActive($acceptHelper);

        $expected = [
            'page' => $page1,
            'depth' => 3,
        ];

        self::assertSame($expected, $helper->find($container, -1, 3));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Navigation\Exception\InvalidArgumentException
     */
    public function testFindActiveOneActivePageRecursive6(): void
    {
        $resource  = 'testResource';
        $privilege = 'testPrivilege';

        $parentPage = new \Laminas\Navigation\Page\Uri();
        $parentPage->setVisible(true);
        $parentPage->setResource($resource);
        $parentPage->setPrivilege($privilege);

        $page1 = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page1->expects(self::never())
            ->method('isVisible');
        $page1->expects(self::never())
            ->method('getResource');
        $page1->expects(self::never())
            ->method('getPrivilege');
        $page1->expects(self::once())
            ->method('getParent')
            ->willReturn($parentPage);
        $page1->expects(self::once())
            ->method('isActive')
            ->with(false)
            ->willReturn(true);
        $page1->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page1->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $page2 = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page2->expects(self::never())
            ->method('isVisible');
        $page2->expects(self::never())
            ->method('getResource');
        $page2->expects(self::never())
            ->method('getPrivilege');
        $page2->expects(self::never())
            ->method('getParent');
        $page2->expects(self::never())
            ->method('isActive');
        $page2->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page2->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $page3 = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page3->expects(self::never())
            ->method('isVisible');
        $page3->expects(self::never())
            ->method('getResource');
        $page3->expects(self::never())
            ->method('getPrivilege');
        $page3->expects(self::never())
            ->method('getParent');
        $page3->expects(self::never())
            ->method('isActive');
        $page3->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page3->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $parentPage->addPage($page1);
        $parentPage->addPage($page2);
        $parentPage->addPage($page3);

        $container = new \Laminas\Navigation\Navigation();
        $container->addPage($parentPage);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher      = self::exactly(4);
        $acceptHelper->expects($matcher)
            ->method('accept')
            ->willReturnCallback(
                static function (AbstractPage | PageInterface $page, bool $recursive = true) use ($matcher, $page1, $page2, $page3, $parentPage): bool {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($page1, $page),
                        2 => self::assertSame($page2, $page),
                        3 => self::assertSame($page3, $page),
                        default => self::assertSame($parentPage, $page),
                    };

                    self::assertTrue($recursive);

                    return match ($matcher->numberOfInvocations()) {
                        2, 3 => false,
                        default => true,
                    };
                },
            );

        $helper = new FindActive($acceptHelper);

        $expected = [
            'page' => $parentPage,
            'depth' => 0,
        ];

        self::assertSame($expected, $helper->find($container, 0, 0));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Navigation\Exception\InvalidArgumentException
     */
    public function testFindActiveOneActivePageRecursive7(): void
    {
        $resource  = 'testResource';
        $privilege = 'testPrivilege';

        $parentPage = new \Laminas\Navigation\Page\Uri();
        $parentPage->setVisible(true);
        $parentPage->setActive(true);
        $parentPage->setUri('parent');
        $parentPage->setResource($resource);
        $parentPage->setPrivilege($privilege);

        $page1 = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page1->expects(self::never())
            ->method('isVisible');
        $page1->expects(self::never())
            ->method('getResource');
        $page1->expects(self::never())
            ->method('getPrivilege');
        $page1->expects(self::once())
            ->method('getParent')
            ->willReturn($parentPage);
        $page1->expects(self::once())
            ->method('isActive')
            ->with(false)
            ->willReturn(true);
        $page1->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page1->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $page2 = new \Laminas\Navigation\Page\Uri();
        $page2->setActive(true);
        $page2->setUri('test2');

        $parentPage->addPage($page1);
        $parentPage->addPage($page2);

        $parentParentPage = new \Laminas\Navigation\Page\Uri();
        $parentParentPage->setVisible(true);
        $parentParentPage->setActive(true);
        $parentParentPage->setUri('parentParent');

        $parentParentParentPage = new \Laminas\Navigation\Page\Uri();
        $parentParentParentPage->setVisible(true);
        $parentParentParentPage->setActive(true);
        $parentParentParentPage->setUri('parentParentParent');

        $parentParentPage->addPage($parentPage);
        $parentParentParentPage->addPage($parentParentPage);

        $container = new \Laminas\Navigation\Navigation();
        $container->addPage($parentParentParentPage);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher      = self::exactly(3);
        $acceptHelper->expects($matcher)
            ->method('accept')
            ->willReturnCallback(
                static function (AbstractPage | PageInterface $page, bool $recursive = true) use ($matcher, $page1, $page2, $parentPage): bool {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($page1, $page),
                        2 => self::assertSame($page2, $page),
                        default => self::assertSame($parentPage, $page),
                    };

                    self::assertTrue($recursive);

                    return true;
                },
            );

        $helper = new FindActive($acceptHelper);

        $expected = [];

        self::assertSame($expected, $helper->find($container, 2, 1));
    }

    /**
     * @throws Exception
     * @throws \Laminas\Navigation\Exception\InvalidArgumentException
     */
    public function testFindActiveOneActivePageRecursive8(): void
    {
        $resource  = 'testResource';
        $privilege = 'testPrivilege';

        $parentPage = new \Laminas\Navigation\Page\Uri();
        $parentPage->setVisible(true);
        $parentPage->setActive(true);
        $parentPage->setUri('parent');
        $parentPage->setResource($resource);
        $parentPage->setPrivilege($privilege);

        $page1 = $this->getMockBuilder(AbstractPage::class)
            ->disableOriginalConstructor()
            ->getMock();
        $page1->expects(self::never())
            ->method('isVisible');
        $page1->expects(self::never())
            ->method('getResource');
        $page1->expects(self::never())
            ->method('getPrivilege');
        $page1->expects(self::once())
            ->method('getParent')
            ->willReturn(null);
        $page1->expects(self::once())
            ->method('isActive')
            ->with(false)
            ->willReturn(true);
        $page1->expects(self::exactly(2))
            ->method('getOrder')
            ->willReturn(0);
        $page1->expects(self::once())
            ->method('setParent')
            ->with($parentPage);

        $page2 = new \Laminas\Navigation\Page\Uri();
        $page2->setActive(true);
        $page2->setUri('test2');

        $parentPage->addPage($page1);
        $parentPage->addPage($page2);

        $parentParentPage = new \Laminas\Navigation\Page\Uri();
        $parentParentPage->setVisible(true);
        $parentParentPage->setActive(true);
        $parentParentPage->setUri('parentParent');

        $parentParentParentPage = new \Laminas\Navigation\Page\Uri();
        $parentParentParentPage->setVisible(true);
        $parentParentParentPage->setActive(true);
        $parentParentParentPage->setUri('parentParentParent');

        $parentParentPage->addPage($parentPage);
        $parentParentParentPage->addPage($parentParentPage);

        $container = new \Laminas\Navigation\Navigation();
        $container->addPage($parentParentParentPage);

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $matcher      = self::exactly(5);
        $acceptHelper->expects($matcher)
            ->method('accept')
            ->willReturnCallback(
                static function (AbstractPage | PageInterface $page, bool $recursive = true) use ($matcher, $page1, $page2, $parentPage, $parentParentPage, $parentParentParentPage): bool {
                    match ($matcher->numberOfInvocations()) {
                        1 => self::assertSame($page1, $page),
                        2 => self::assertSame($page2, $page),
                        4 => self::assertSame($parentParentPage, $page),
                        5 => self::assertSame($parentParentParentPage, $page),
                        default => self::assertSame($parentPage, $page),
                    };

                    self::assertTrue($recursive);

                    return true;
                },
            );

        $helper = new FindActive($acceptHelper);

        $expected = [];

        self::assertSame($expected, $helper->find($container, -1, -1));
    }
}
