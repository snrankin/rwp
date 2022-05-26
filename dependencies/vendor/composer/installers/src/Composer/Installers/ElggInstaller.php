<?php

namespace RWP\Vendor\Composer\Installers;

class ElggInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('plugin' => 'mod/{$name}/');
}
