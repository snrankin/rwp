<?php

namespace RWP\Vendor\Composer\Installers;

class Redaxo5Installer extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('addon' => 'redaxo/src/addons/{$name}/', 'bestyle-plugin' => 'redaxo/src/addons/be_style/plugins/{$name}/');
}
