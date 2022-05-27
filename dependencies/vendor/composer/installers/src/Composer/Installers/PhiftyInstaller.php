<?php

namespace RWP\Vendor\Composer\Installers;

class PhiftyInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('bundle' => 'bundles/{$name}/', 'library' => 'libraries/{$name}/', 'framework' => 'frameworks/{$name}/');
}
