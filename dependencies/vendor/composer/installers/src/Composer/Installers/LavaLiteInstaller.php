<?php

namespace RWP\Vendor\Composer\Installers;

class LavaLiteInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('package' => 'packages/{$vendor}/{$name}/', 'theme' => 'public/themes/{$name}/');
}
