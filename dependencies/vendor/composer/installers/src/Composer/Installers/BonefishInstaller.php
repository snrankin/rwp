<?php

namespace RWP\Vendor\Composer\Installers;

class BonefishInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('package' => 'Packages/{$vendor}/{$name}/');
}
