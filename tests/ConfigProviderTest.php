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

use Mimmi20\NavigationHelper\FindActive\ConfigProvider;
use Mimmi20\NavigationHelper\FindActive\FindActive;
use Mimmi20\NavigationHelper\FindActive\FindActiveInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class ConfigProviderTest extends TestCase
{
    private ConfigProvider $provider;

    protected function setUp(): void
    {
        $this->provider = new ConfigProvider();
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testReturnedArrayContainsDependencies(): void
    {
        $config = ($this->provider)();
        self::assertIsArray($config);
        self::assertCount(1, $config);
        self::assertArrayHasKey('dependencies', $config);

        $dependencies = $config['dependencies'];
        self::assertIsArray($dependencies);
        self::assertCount(2, $dependencies);
        self::assertArrayHasKey('factories', $dependencies);
        self::assertArrayHasKey('aliases', $dependencies);

        $factories = $dependencies['factories'];
        self::assertIsArray($factories);
        self::assertCount(1, $factories);
        self::assertArrayHasKey(FindActive::class, $factories);

        $aliases = $dependencies['aliases'];
        self::assertIsArray($aliases);
        self::assertCount(1, $aliases);
        self::assertArrayHasKey(FindActiveInterface::class, $aliases);
    }

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testReturnedArrayContainsDependencies2(): void
    {
        $dependencies = $this->provider->getDependencyConfig();
        self::assertIsArray($dependencies);
        self::assertCount(2, $dependencies);
        self::assertArrayHasKey('factories', $dependencies);
        self::assertArrayHasKey('aliases', $dependencies);

        $factories = $dependencies['factories'];
        self::assertIsArray($factories);
        self::assertCount(1, $factories);
        self::assertArrayHasKey(FindActive::class, $factories);

        $aliases = $dependencies['aliases'];
        self::assertIsArray($aliases);
        self::assertCount(1, $aliases);
        self::assertArrayHasKey(FindActiveInterface::class, $aliases);
    }
}