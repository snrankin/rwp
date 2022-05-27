<?php

namespace RWP\Vendor\Composer\Installers;

class EzPlatformInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('meta-assets' => 'web/assets/ezplatform/', 'assets' => 'web/assets/ezplatform/{$name}/');
}
