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

use RWP\Vendor\Symfony\Component\Asset\Packages;
use RWP\Vendor\Twig\Extension\AbstractExtension;
use RWP\Vendor\Twig\TwigFunction;

/**
 * Twig extension for the Symfony Asset component.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
final class AssetExtension extends Extension\AbstractExtension {
    private $packages;
    public function __construct(Packages $packages) {
        $this->packages = $packages;
    }
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array {
        return [new TwigFunction('asset', [$this, 'getAssetUrl']), new TwigFunction('asset_version', [$this, 'getAssetVersion'])];
    }
    /**
     * Returns the public url/path of an asset.
     *
     * If the package used to generate the path is an instance of
     * UrlPackage, you will always get a URL and not a path.
     */
    public function getAssetUrl(string $path, string $packageName = null): string {
        return $this->packages->getUrl($path, $packageName);
    }
    /**
     * Returns the version of an asset.
     */
    public function getAssetVersion(string $path, string $packageName = null): string {
        return $this->packages->getVersion($path, $packageName);
    }
}
