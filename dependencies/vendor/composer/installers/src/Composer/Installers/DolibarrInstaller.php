<?php

namespace RWP\Vendor\Composer\Installers;

/**
 * Class DolibarrInstaller
 *
 * @package Composer\Installers
 * @author  Raphaël Doursenaud <rdoursenaud@gpcsolutions.fr>
 */
class DolibarrInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    //TODO: Add support for scripts and themes
    protected $locations = array('module' => 'htdocs/custom/{$name}/');
}
