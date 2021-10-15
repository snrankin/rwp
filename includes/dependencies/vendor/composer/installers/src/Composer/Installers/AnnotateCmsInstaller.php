<?php

namespace RWP\Vendor\Composer\Installers;

class AnnotateCmsInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('module' => 'addons/modules/{$name}/', 'component' => 'addons/components/{$name}/', 'service' => 'addons/services/{$name}/');
}
