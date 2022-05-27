<?php

namespace RWP\Vendor\Composer\Installers;

class WolfCMSInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('plugin' => 'wolf/plugins/{$name}/');
}
