<?php

namespace RWP\Vendor\Composer\Installers;

class EliasisInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('component' => 'components/{$name}/', 'module' => 'modules/{$name}/', 'plugin' => 'plugins/{$name}/', 'template' => 'templates/{$name}/');
}
