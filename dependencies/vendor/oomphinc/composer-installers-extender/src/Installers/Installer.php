<?php

declare (strict_types=1);
namespace RWP\Vendor\OomphInc\ComposerInstallersExtender\Installers;

use RWP\Vendor\Composer\Package\PackageInterface;
use RWP\Vendor\Composer\Installer\LibraryInstaller;
use RWP\Vendor\Composer\Installers\Installer as InstallerBase;
class Installer extends Installer
{
    /**
     * A list of installer types.
     *
     * @var array
     */
    protected $installerTypes;
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package) : string
    {
        $installer = new CustomInstaller($package, $this->composer, $this->io);
        $path = $installer->getInstallPath($package, $package->getType());
        return $path ?: LibraryInstaller::getInstallPath($package);
    }
    /**
     * {@inheritDoc}
     */
    public function supports($packageType) : bool
    {
        return \in_array($packageType, $this->getInstallerTypes());
    }
    /**
     * Get a list of custom installer types.
     *
     * @return array
     */
    public function getInstallerTypes() : array
    {
        if (!$this->installerTypes) {
            $extra = $this->composer->getPackage()->getExtra();
            $this->installerTypes = $extra['installer-types'] ?? [];
        }
        return $this->installerTypes;
    }
}
