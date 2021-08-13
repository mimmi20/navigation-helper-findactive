<?php
/**
 * This file is part of the mimmi20/navigation-helper-findactive package.
 *
 * Copyright (c) 2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20Test\NavigationHelper\FindActive;

use Laminas\ServiceManager\ServiceLocatorInterface;
use Mezzio\GenericAuthorization\AuthorizationInterface;
use Mimmi20\NavigationHelper\Accept\AcceptHelperInterface;
use Mimmi20\NavigationHelper\FindActive\FindActive;
use Mimmi20\NavigationHelper\FindActive\FindActiveFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class FindActiveFactoryTest extends TestCase
{
    private FindActiveFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new FindActiveFactory();
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testInvocationWithoutOptions(): void
    {
        $options = [
            'authorization' => null,
            'renderInvisible' => false,
            'role' => null,
        ];

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $acceptHelper->expects(self::never())
            ->method('accept');

        $container = $this->getMockBuilder(ServiceLocatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::never())
            ->method('get');
        $container->expects(self::never())
            ->method('has');
        $container->expects(self::once())
            ->method('build')
            ->with(AcceptHelperInterface::class, $options)
            ->willReturn($acceptHelper);

        $helper = ($this->factory)($container, '');

        self::assertInstanceOf(FindActive::class, $helper);
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testInvocationWithOptions(): void
    {
        $auth            = $this->createMock(AuthorizationInterface::class);
        $renderInvisible = true;
        $role            = 'test-role';

        $options = [
            'authorization' => $auth,
            'renderInvisible' => $renderInvisible,
            'role' => $role,
        ];

        $acceptHelper = $this->getMockBuilder(AcceptHelperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $acceptHelper->expects(self::never())
            ->method('accept');

        $container = $this->getMockBuilder(ServiceLocatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::never())
            ->method('get');
        $container->expects(self::never())
            ->method('has');
        $container->expects(self::once())
            ->method('build')
            ->with(AcceptHelperInterface::class, $options)
            ->willReturn($acceptHelper);

        $helper = ($this->factory)(
            $container,
            '',
            $options
        );

        self::assertInstanceOf(FindActive::class, $helper);
    }
}
