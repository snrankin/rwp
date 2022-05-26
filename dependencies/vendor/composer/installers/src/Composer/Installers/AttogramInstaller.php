<?php

namespace RWP\Vendor\Composer\Installers;

class AttogramInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('module' => 'modules/{$name}/');
}
