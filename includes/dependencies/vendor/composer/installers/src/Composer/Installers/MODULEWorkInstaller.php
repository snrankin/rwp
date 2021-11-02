<?php

namespace RWP\Vendor\Composer\Installers;

class MODULEWorkInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('module' => 'modules/{$name}/');
}
