<?php

declare (strict_types=1);
namespace RWP\Vendor\OomphInc\ComposerInstallersExtender;

use RWP\Vendor\Composer\Composer;
use RWP\Vendor\Composer\IO\IOInterface;
use RWP\Vendor\Composer\Plugin\PluginInterface;
use RWP\Vendor\OomphInc\ComposerInstallersExtender\Installers\Installer;
class Plugin implements PluginInterface
{
    /**
     * {@inheritDoc}
     */
    public function activate(Composer $composer, IOInterface $io) : void
    {
        $installer = new Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($installer);
    }
    /**
     * {@inheritDoc}
     */
    public function deactivate(Composer $composer, IOInterface $io) : void
    {
    }
    /**
     * {@inheritDoc}
     */
    public function uninstall(Composer $composer, IOInterface $io) : void
    {
    }
}
