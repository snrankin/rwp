<?php

namespace RWP\Vendor\Composer\Installers;

class DframeInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('module' => 'modules/{$vendor}/{$name}/');
}
