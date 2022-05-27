<?php

namespace RWP\Vendor\Composer\Installers;

class RedaxoInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('addon' => 'redaxo/include/addons/{$name}/', 'bestyle-plugin' => 'redaxo/include/addons/be_style/plugins/{$name}/');
}
