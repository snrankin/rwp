<?php

namespace RWP\Vendor\Composer\Installers;

class ZendInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('library' => 'library/{$name}/', 'extra' => 'extras/library/{$name}/', 'module' => 'module/{$name}/');
}
