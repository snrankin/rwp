<?php

/** ============================================================================
 * Output
 *
 * @package   RWP\Integrations\QM\Output
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations\QM\Output;

class Info extends Output {

	/**
	 * Outputs data in the footer
	 */
	public function output() {

		$plugin = rwp();
		$context = rwp_post();

		$this->before_non_tabular_output();

		//echo '</div>';

		$plugin_col = '<section class="mw-lg-33"><h3>RWP Plugin Info</h3>' . rwp_dump( $plugin ) . '</section>';
		$plugin_col .= '<section class="mw-lg-33"><h3>Plugin Options</h3>' . rwp_dump( rwp_get_options() ) . '</section>';
		$plugin_col .= '<section class="mw-lg-33"><h3>Page Context</h3>' . rwp_dump( $context ) . '</section>';

		$plugin_col = rwp_element(array(
			'content' => $plugin_col,
			'tag'     => 'div',
			'atts'    => array(
				'class' => array(
					'qm-boxed',
				),
			),
		));

		$plugin_col = $plugin_col->html();

		echo $plugin_col; //phpcs:ignore

		$this->after_non_tabular_output();
	}

	/**
	 * @param array $class
	 *
	 * @return array
	 */
	public function admin_class( array $class ) {

		return $class;
	}


	/**
	 * Function for admin bar title
	 *
	 * @param array<string, mixed[]> $menu
	 * @return array<string, mixed[]>
	 */
	public function admin_menu( array $menu ) {
		$menu[] = $this->menu(array(
			'id'    => $this->id,
			'href'  => '#qm-' . $this->id,
			'title' => $this->title,
		));
		return $menu;
	}

	/**
	 * Adds data to top admin bar
	 *
	 * @param array $title
	 *
	 * @return array
	 */
	public function admin_title( array $title ) {

		return $title;
	}
}
