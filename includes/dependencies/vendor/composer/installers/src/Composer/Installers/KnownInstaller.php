<?php

namespace RWP\Vendor\Composer\Installers;

class KnownInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('plugin' => 'IdnoPlugins/{$name}/', 'theme' => 'Themes/{$name}/', 'console' => 'ConsolePlugins/{$name}/');
}
