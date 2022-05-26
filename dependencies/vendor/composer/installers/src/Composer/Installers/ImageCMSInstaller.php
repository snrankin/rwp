<?php

namespace RWP\Vendor\Composer\Installers;

class ImageCMSInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('template' => 'templates/{$name}/', 'module' => 'application/modules/{$name}/', 'library' => 'application/libraries/{$name}/');
}
