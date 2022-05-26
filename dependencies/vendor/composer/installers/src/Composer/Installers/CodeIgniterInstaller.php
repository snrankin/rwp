<?php

namespace RWP\Vendor\Composer\Installers;

class CodeIgniterInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('library' => 'application/libraries/{$name}/', 'third-party' => 'application/third_party/{$name}/', 'module' => 'application/modules/{$name}/');
}
