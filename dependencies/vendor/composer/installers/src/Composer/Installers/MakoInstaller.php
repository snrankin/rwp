<?php

namespace RWP\Vendor\Composer\Installers;

class MakoInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('package' => 'app/packages/{$name}/');
}
