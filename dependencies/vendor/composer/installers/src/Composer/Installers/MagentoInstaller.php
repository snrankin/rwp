<?php

namespace RWP\Vendor\Composer\Installers;

class MagentoInstaller extends \RWP\Vendor\Composer\Installers\BaseInstaller
{
    protected $locations = array('theme' => 'app/design/frontend/{$name}/', 'skin' => 'skin/frontend/default/{$name}/', 'library' => 'lib/{$name}/');
}
