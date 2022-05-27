<?php

namespace RWP\Vendor\Composer\Installers;

class RoundcubeInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('plugin' => 'plugins/{$name}/');
    /**
     * Lowercase name and changes the name to a underscores
     *
     * @param  array $vars
     * @return array
     */
    public function inflectPackageVars($vars)
    {
        $vars['name'] = \strtolower(\str_replace('-', '_', $vars['name']));
        return $vars;
    }
}
