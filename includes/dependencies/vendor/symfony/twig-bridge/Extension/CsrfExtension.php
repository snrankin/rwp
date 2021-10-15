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
use RWP\Vendor\Twig\TwigFunction;

/**
 * @author Christian Flothmann <christian.flothmann@sensiolabs.de>
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
final class CsrfExtension extends Extension\AbstractExtension {
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array {
        return [new TwigFunction('csrf_token', [Bridge\Twig\Extension\CsrfRuntime::class, 'getCsrfToken'])];
    }
}
