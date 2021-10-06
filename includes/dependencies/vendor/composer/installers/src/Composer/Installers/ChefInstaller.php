<?php

namespace RWP\Vendor\Composer\Installers;

class ChefInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('cookbook' => 'Chef/{$vendor}/{$name}/', 'role' => 'Chef/roles/{$name}/');
}
