<?php

namespace RWP\Vendor\Composer\Installers;

class LithiumInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('library' => 'libraries/{$name}/', 'source' => 'libraries/_source/{$name}/');
}
