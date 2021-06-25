<?php

/** ============================================================================
 * Modules
 *
 * @package RIESTERWP Plugin\/includes/core/Modules.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */


namespace RWP\Traits;

use RWP\Vendor\Symfony\Component\Finder\Finder;

trait Modules {

	/**
	 * The modules that are availbe through `add_theme_support()`
	 *
	 * @var array|Collection $modules
	 */
	public $modules = [];

	public function init_modules() {

		$finder = new Finder();
		// @phpstan-ignore-next-line
		$finder->ignoreUnreadableDirs()->in($this->path . 'includes/core/Modules')->files()->name('*.php');

		// check if there are any search results
		if ($finder->hasResults()) {
			foreach ($finder as $file) {
				require_once $file->getRealPath();
			}
		}
	}

	public function get_module($module = '') {

		if ($this->modules->isEmpty()) {
			$this->register_modules();
		}

		if ($this->modules->has($module)) {
			return $this->modules->get($module);
		} else {
			return false;
		}
	}
}
