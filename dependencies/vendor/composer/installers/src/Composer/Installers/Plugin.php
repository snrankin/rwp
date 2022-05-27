<?php

namespace RWP\Vendor\Composer\Installers;

use RWP\Vendor\Composer\Composer;
use RWP\Vendor\Composer\IO\IOInterface;
use RWP\Vendor\Composer\Plugin\PluginInterface;
class Plugin implements \RWP\Vendor\Composer\Plugin\PluginInterface
{
    private $installer;
    public function activate(\RWP\Vendor\Composer\Composer $composer, \RWP\Vendor\Composer\IO\IOInterface $io)
    {
        $this->installer = new \RWP\Vendor\Composer\Installers\Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($this->installer);
    }
    public function deactivate(\RWP\Vendor\Composer\Composer $composer, \RWP\Vendor\Composer\IO\IOInterface $io)
    {
        $composer->getInstallationManager()->removeInstaller($this->installer);
    }
    public function uninstall(\RWP\Vendor\Composer\Composer $composer, \RWP\Vendor\Composer\IO\IOInterface $io)
    {
    }
}
