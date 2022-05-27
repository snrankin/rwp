<?php

namespace RWP\Vendor\Composer\Installers;

class LaravelInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('library' => 'libraries/{$name}/');
}
