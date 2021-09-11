<?php

namespace RWP\Vendor\Puc\DebugBar;

use RWP\Vendor\Puc\Theme\UpdateChecker;

class ThemePanel extends Panel {
	/**
	 * @var UpdateChecker
	 */
	protected $updateChecker;
	protected function displayConfigHeader() {
		$this->row('Theme directory', \htmlentities($this->updateChecker->directoryName));
		parent::displayConfigHeader();
	}
	protected function getUpdateFields() {
		return \array_merge(parent::getUpdateFields(), array('details_url'));
	}
}
