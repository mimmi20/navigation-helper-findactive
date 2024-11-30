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

namespace Mimmi20\NavigationHelper\FindActive;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Mimmi20\NavigationHelper\Accept\AcceptHelperInterface;
use Override;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

use function assert;

final class FindActiveFactory implements FactoryInterface
{
    /**
     * Create and return a navigation view helper instance.
     *
     * @param string            $requestedName
     * @param array<mixed>|null $options
     *
     * @throws ContainerExceptionInterface
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function __invoke(ContainerInterface $container, $requestedName, array | null $options = null): FindActive
    {
        assert($container instanceof ServiceLocatorInterface);
        $acceptHelper = $container->build(
            AcceptHelperInterface::class,
            [
                'authorization' => $options['authorization'] ?? null,
                'renderInvisible' => $options['renderInvisible'] ?? false,
                'role' => $options['role'] ?? null,
            ],
        );

        assert($acceptHelper instanceof AcceptHelperInterface);

        return new FindActive($acceptHelper);
    }
}
