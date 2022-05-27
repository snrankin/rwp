<?php

namespace RWP\Vendor\Composer\Installers;

class ReIndexInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('theme' => 'themes/{$name}/', 'plugin' => 'plugins/{$name}/');
}
