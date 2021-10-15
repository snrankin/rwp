<?php

namespace RWP\Vendor\Composer\Installers;

class SyliusInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('theme' => 'themes/{$name}/');
}
