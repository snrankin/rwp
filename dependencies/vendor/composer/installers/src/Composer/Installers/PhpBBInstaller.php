<?php

namespace RWP\Vendor\Composer\Installers;

class PhpBBInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('extension' => 'ext/{$vendor}/{$name}/', 'language' => 'language/{$name}/', 'style' => 'styles/{$name}/');
}
