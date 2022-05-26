<?php

namespace RWP\Vendor\Composer\Installers;

class PuppetInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('module' => 'modules/{$name}/');
}
