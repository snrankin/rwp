<?php

namespace RWP\Vendor\Composer\Installers;

class ClanCatsFrameworkInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('ship' => 'CCF/orbit/{$name}/', 'theme' => 'CCF/app/themes/{$name}/');
}
