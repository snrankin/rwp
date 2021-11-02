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

namespace RWP\Integrations\QM;

if ( class_exists( '\\QM_Output_Html' ) ) {

	class Output extends \QM_Output_Html {

		public function __construct( \QM_Collector $collector, $output, $title ) {
			parent::__construct( $collector );
			$this->output = $output;
			$this->title = $title;
			$this->id = \strtolower( \str_replace( ' ', '-', $title ) );
			\add_filter( 'qm/output/menus', array( $this, 'admin_menu' ), 101 );
			\add_filter( 'qm/output/title', array( $this, 'admin_title' ), 101 );
			\add_filter( 'qm/output/menu_class', array( $this, 'admin_class' ) );
		}
		/**
		 * Outputs data in the footer
		 */
		public function output() {
			if ( \is_array( $this->output ) ) {
				echo '<div class="qm" id="' . \esc_attr( $this->collector->id() ) . '">';
				echo '<table cellspacing="0"><tbody>';
				foreach ( $this->output as &$single ) {
					echo '<tr><td>' . $single . '</td></tr>'; // phpcs:ignore
				}
				echo '</tbody></table>';
				echo '</div>';
			}
		}
		/**
		 * Adds data to top admin bar
		 *
		 * @param array $title
		 *
		 * @return array
		 */
		public function admin_title( array $title ) {
			$data = $this->collector->get_data();
			if ( isset( $data['log'] ) ) {
				$title[] = $this->title . ' (' . \count( $data['log'] ) . ')';
			}
			return $title;
		}
		/**
		 * @param array $class
		 *
		 * @return array
		 */
		public function admin_class( array $class ) {
			$class[] = $this->id;
			return $class;
		}
		public function admin_menu( array $menu ) {
			$data = $this->collector->get_data();
			if ( isset( $data['log'] ) ) {
				$menu[] = $this->menu( array(
					'id' => $this->id,
					'href' => '#qm-' . \str_replace( '_', '-', $this->id ),
					'title' => $this->title . ' (' . \count( $data['log'] ) . ')',
				) );
			}
			return $menu;
		}
	}
}
