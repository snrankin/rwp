<?php
/** ============================================================================
 * Output
 *
 * @package   RWP\/includes/integrations/QM/Output.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations\QM\Output;

use RWP\Engine\Abstracts\DebugOutput;

class Info extends DebugOutput {

	/**
	 * Outputs data in the footer
	 */
	public function output() {

		$plugin = rwp();
		$context = rwp_post();

		$this->before_non_tabular_output();

		$plugin_col = '<section><h3>' . $plugin->get( 'title' ) . '</h3>' . rwp_dump( $plugin ) . '</section>';

		$context_col = '<section><h3>Page Context</h3>' . rwp_dump( $context ) . '</section>';

		$plugin_col = rwp_element( array( //phpcs:ignore
			'content' => $plugin_col . $context_col,
			'tag' => 'div',
			'atts' => array(
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
		$menu[] = $this->menu( array(
			'id' => $this->id,
			'href' => '#qm-' . $this->id,
			'title' => $this->title,
		) );
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
