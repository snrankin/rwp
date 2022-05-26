<?php

namespace RWP\Vendor\Composer\Installers;

class AimeosInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('extension' => 'ext/{$name}/');
}
