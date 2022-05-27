<?php

namespace RWP\Vendor\Composer\Installers;

class PortoInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('container' => 'app/Containers/{$name}/');
}
