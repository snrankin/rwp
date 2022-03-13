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

use RWP\Vendor\Symfony\Component\VarDumper\VarDumper;
use RWP\Vendor\Symfony\Component\VarDumper\Dumper\HtmlDumper;
use RWP\Vendor\Symfony\Component\VarDumper\Cloner\VarCloner;
if ( class_exists( '\\QM_Output_Html' ) ) {

	class Info extends \QM_Output_Html {

		public function __construct( \QM_Collector $collector, $output = array(), $title = '' ) {
			parent::__construct( $collector );

			$this->title = $title;
			$this->output = $output;
			$this->id = rwp()->prefix( 'info' );

			add_filter( 'qm/output/menus', array( $this, 'admin_menu' ), 101 );

		}
		/**
		 * Outputs data in the footer
		 */
		public function output() {

			$plugin = rwp();

			$this->before_non_tabular_output();

			echo rwp_element( array( //phpcs:ignore
				'content' => array(
					'<h3>' . $plugin->get_setting( 'title' ) . '</h3>',
				),
				'tag' => 'section',
				'atts' => array(
					'class' => array(
						'plugin-title',
					),
				),
			));

			echo '</div>';

			echo '<div class="qm-boxed">';

			echo '<section class="plugin-settings"><h3>Plugin Settings</h3>';

			$dumper = new HtmlDumper();
			$cloner = new VarCloner();

			$dumper->dump( $cloner->cloneVar( $plugin ) );

			echo '</section>'; //phpcs:ignore

			$context_wrapper = rwp_element( array( //phpcs:ignore
				'content' => array(
					'<h3>Page Context</h3>',
				),
				'tag' => 'section',
				'atts' => array(
					'class' => array(
						'page-context',
					),
				),
			));

			ob_start();

			self::output_inner( rwp_post() );

			$context = ob_get_clean();

			$context_wrapper->set_content( $context );

			echo $context_wrapper; //phpcs:ignore

			$this->after_non_tabular_output();

		}

		public function admin_menu( array $menu ) {
			$data = $this->collector->get_data();
			if ( isset( $data['log'] ) ) {
				$menu[] = $this->menu( array(
					'id'    => $this->id,
					'href'  => '#qm-' . str_replace( '_', '-', $this->id ),
					'title' => $this->title,
				));
			}
			return $menu;
		}
	}
}
