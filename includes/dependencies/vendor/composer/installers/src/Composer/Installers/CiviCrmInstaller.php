<?php

namespace RWP\Vendor\Composer\Installers;

class CiviCrmInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('ext' => 'ext/{$name}/');
}
