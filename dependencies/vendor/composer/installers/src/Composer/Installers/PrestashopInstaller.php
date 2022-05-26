<?php

namespace RWP\Vendor\Composer\Installers;

class PrestashopInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('module' => 'modules/{$name}/', 'theme' => 'themes/{$name}/');
}
