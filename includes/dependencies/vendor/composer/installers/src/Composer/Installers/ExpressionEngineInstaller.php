<?php

namespace Composer\Installers;

use Composer\Package\PackageInterface;

class ExpressionEngineInstaller extends \Composer\Installers\BaseInstaller {
    protected $locations = array();
    private $ee2Locations = array('addon' => 'system/expressionengine/third_party/{$name}/', 'theme' => 'themes/third_party/{$name}/');
    private $ee3Locations = array('addon' => 'system/user/addons/{$name}/', 'theme' => 'themes/user/{$name}/');
    public function getInstallPath(\Composer\Package\PackageInterface $package, $frameworkType = '') {
        $version = "{$frameworkType}Locations";
        $this->locations = $this->{$version};
        return parent::getInstallPath($package, $frameworkType);
    }
}
