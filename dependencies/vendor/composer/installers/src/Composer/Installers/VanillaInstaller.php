<?php

namespace RWP\Vendor\Composer\Installers;

class VanillaInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('plugin' => 'plugins/{$name}/', 'theme' => 'themes/{$name}/');
}
