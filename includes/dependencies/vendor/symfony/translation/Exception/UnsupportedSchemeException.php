<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RWP\Vendor\Symfony\Component\Translation\Exception;

use RWP\Vendor\Symfony\Component\Translation\Bridge;
use RWP\Vendor\Symfony\Component\Translation\Provider\Dsn;

class UnsupportedSchemeException extends LogicException {
    private const SCHEME_TO_PACKAGE_MAP = ['crowdin' => ['class' => CrowdinProviderFactory::class, 'package' => 'symfony/crowdin-translation-provider'], 'loco' => ['class' => LocoProviderFactory::class, 'package' => 'symfony/loco-translation-provider'], 'lokalise' => ['class' => LokaliseProviderFactory::class, 'package' => 'symfony/lokalise-translation-provider']];
    public function __construct(Dsn $dsn, string $name = null, array $supported = []) {
        $provider = $dsn->getScheme();
        if (\false !== ($pos = \strpos($provider, '+'))) {
            $provider = \substr($provider, 0, $pos);
        }
        $package = self::SCHEME_TO_PACKAGE_MAP[$provider] ?? null;
        if ($package && !\class_exists($package['class'])) {
            parent::__construct(\sprintf('Unable to synchronize translations via "%s" as the provider is not installed; try running "composer require %s".', $provider, $package['package']));
            return;
        }
        $message = \sprintf('The "%s" scheme is not supported', $dsn->getScheme());
        if ($name && $supported) {
            $message .= \sprintf('; supported schemes for translation provider "%s" are: "%s"', $name, \implode('", "', $supported));
        }
        parent::__construct($message . '.');
    }
}
