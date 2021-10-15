<?php

namespace RWP\Vendor\Composer\Installers;

class FuelInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('module' => 'fuel/app/modules/{$name}/', 'package' => 'fuel/packages/{$name}/', 'theme' => 'fuel/app/themes/{$name}/');
}
