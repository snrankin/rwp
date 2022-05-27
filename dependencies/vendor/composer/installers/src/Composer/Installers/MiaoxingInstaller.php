<?php

namespace RWP\Vendor\Composer\Installers;

class MiaoxingInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('plugin' => 'plugins/{$name}/');
}
