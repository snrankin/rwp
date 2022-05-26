<?php

namespace RWP\Vendor\Composer\Installers;

class SMFInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('module' => 'Sources/{$name}/', 'theme' => 'Themes/{$name}/');
}
