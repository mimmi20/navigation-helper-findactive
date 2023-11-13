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

namespace Mimmi20\NavigationHelper\FindActive;

use Laminas\Navigation\AbstractContainer;
use Laminas\Navigation\Page\AbstractPage;
use Mezzio\Navigation\ContainerInterface;
use Mezzio\Navigation\Page\PageInterface;

interface FindActiveInterface
{
    /**
     * Finds the deepest active page in the given container
     *
     * @param AbstractContainer<AbstractPage>|ContainerInterface $container to search
     * @param int|null                                           $minDepth  [optional] minimum depth required for page to be valid.
     *                                                                      Default is to use {@link getMinDepth()}.
     *                                                                      A null value means no minimum depth required.
     * @param int|null                                           $maxDepth  [optional] maximum depth a page can have to be valid.
     *                                                                      Default is to use {@link getMaxDepth()}.
     *                                                                      A null value means no maximum depth required.
     *
     * @return array<string, AbstractPage|int|PageInterface|null> an associative array with the values 'depth' and 'page', or an empty array if not found
     * @phpstan-return array{page?: AbstractPage|PageInterface|null, depth?: int|null}
     *
     * @throws void
     */
    public function find(
        AbstractContainer | ContainerInterface $container,
        int | null $minDepth,
        int | null $maxDepth,
    ): array;
}
