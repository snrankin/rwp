<?php

namespace RWP\Vendor\Composer\Installers;

class DecibelInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    /** @var array */
    protected $locations = array('app' => 'app/{$name}/');
}
