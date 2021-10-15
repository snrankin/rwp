<?php

namespace RWP\Vendor\Composer\Installers;

class UserFrostingInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('sprinkle' => 'app/sprinkles/{$name}/');
}
