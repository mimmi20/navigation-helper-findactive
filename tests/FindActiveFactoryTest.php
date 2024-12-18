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

use AssertionError;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Mimmi20\Mezzio\GenericAuthorization\AuthorizationInterface;
use Mimmi20\NavigationHelper\Accept\AcceptHelperInterface;
use Mimmi20\NavigationHelper\FindActive\FindActive;
use Mimmi20\NavigationHelper\FindActive\FindActiveFactory;
use Override;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

final class FindActiveFactoryTest extends TestCase
{
    private FindActiveFactory $factory;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->factory = new FindActiveFactory();
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     */
    public function testInvocationWithoutOptions(): void
    {
        $options = [
            'authorization' => null,
            'renderInvisible' => false,
            'roles' => [],
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
     * @throws ContainerExceptionInterface
     */
    public function testInvocationWithOptions(): void
    {
        $auth            = $this->createMock(AuthorizationInterface::class);
        $renderInvisible = true;
        $roles           = ['test-role'];

        $options = [
            'authorization' => $auth,
            'renderInvisible' => $renderInvisible,
            'roles' => $roles,
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
            $options,
        );

        self::assertInstanceOf(FindActive::class, $helper);
    }

    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     */
    public function testInvocationWithAssertionError(): void
    {
        $auth            = $this->createMock(AuthorizationInterface::class);
        $renderInvisible = true;
        $roles           = ['test-role'];

        $options = [
            'authorization' => $auth,
            'renderInvisible' => $renderInvisible,
            'roles' => $roles,
        ];

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::never())
            ->method('get');
        $container->expects(self::never())
            ->method('has');

        $this->expectException(AssertionError::class);
        $this->expectExceptionCode(1);
        $this->expectExceptionMessage('assert($container instanceof ServiceLocatorInterface)');

        ($this->factory)(
            $container,
            '',
            $options,
        );
    }
}
