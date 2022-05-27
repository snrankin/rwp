<?php

namespace RWP\Vendor\Composer\Installers;

class ItopInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('extension' => 'extensions/{$name}/');
}
