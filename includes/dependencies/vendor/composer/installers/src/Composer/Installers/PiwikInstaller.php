<?php

namespace Composer\Installers;

/**
 * Class PiwikInstaller
 *
 * @package Composer\Installers
 */
class PiwikInstaller extends \Composer\Installers\BaseInstaller {
    /**
     * @var array
     */
    protected $locations = array('plugin' => 'plugins/{$name}/');
    /**
     * Format package name to CamelCase
     * @param array $vars
     *
     * @return array
     */
    public function inflectPackageVars($vars) {
        $vars['name'] = \strtolower(\preg_replace('/(?<=\\w)([A-Z])/', 'RWP\\Vendor\\_\\1', $vars['name']));
        $vars['name'] = \str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = \str_replace(' ', '', \ucwords($vars['name']));
        return $vars;
    }
}
