<?php

namespace RWP\Vendor\Composer\Installers;

class PantheonInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array('script' => 'web/private/scripts/quicksilver/{$name}', 'module' => 'web/private/scripts/quicksilver/{$name}');
}
