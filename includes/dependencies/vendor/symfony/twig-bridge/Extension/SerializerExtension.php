<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Bridge\Twig\Extension;

use RWP\Vendor\Twig\Extension\AbstractExtension;
use RWP\Vendor\Twig\TwigFilter;

/**
 * @author Jesse Rushlow <jr@rushlow.dev>
 */
final class SerializerExtension extends Extension\AbstractExtension {
    public function getFilters(): array {
        return [new TwigFilter('serialize', [Bridge\Twig\Extension\SerializerRuntime::class, 'serialize'])];
    }
}
