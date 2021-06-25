<?php

namespace Composer\Installers;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements \Composer\Plugin\PluginInterface {
    private $installer;
    public function activate(\Composer\Composer $composer, \Composer\IO\IOInterface $io) {
        $this->installer = new \Composer\Installers\Installer($io, $composer);
        $composer->getInstallationManager()->addInstaller($this->installer);
    }
    public function deactivate(\Composer\Composer $composer, \Composer\IO\IOInterface $io) {
        $composer->getInstallationManager()->removeInstaller($this->installer);
    }
    public function uninstall(\Composer\Composer $composer, \Composer\IO\IOInterface $io) {
    }
}
