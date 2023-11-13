<?php
/**
 * This file is part of the mimmi20/navigation-helper-findactive package.
 *
 * Copyright (c) 2021-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20Test\NavigationHelper\FindActive;

use Mimmi20\NavigationHelper\FindActive\FindActive;
use Mimmi20\NavigationHelper\FindActive\FindActiveInterface;
use Mimmi20\NavigationHelper\FindActive\Module;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

final class ModuleTest extends TestCase
{
    /** @throws Exception */
    public function testGetConfig(): void
    {
        $module = new Module();

        $config = $module->getConfig();

        self::assertIsArray($config);
        self::assertArrayHasKey('service_manager', $config);

        $dependencies = $config['service_manager'];
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

    /** @throws Exception */
    public function testGetModuleDependencies(): void
    {
        $module = new Module();

        $config = $module->getModuleDependencies();

        self::assertIsArray($config);
        self::assertCount(2, $config);
        self::assertArrayHasKey(0, $config);
        self::assertContains('Laminas\Navigation', $config);
        self::assertContains('Mimmi20\NavigationHelper\Accept', $config);
    }
}
