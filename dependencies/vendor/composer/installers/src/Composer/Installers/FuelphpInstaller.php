<?php

namespace RWP\Vendor\Composer\Installers;

class FuelphpInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('component' => 'components/{$name}/');
}
