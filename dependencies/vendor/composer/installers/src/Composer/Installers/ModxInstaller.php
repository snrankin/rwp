<?php

namespace RWP\Vendor\Composer\Installers;

/**
 * An installer to handle MODX specifics when installing packages.
 */
class ModxInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('extra' => 'core/packages/{$name}/');
}
