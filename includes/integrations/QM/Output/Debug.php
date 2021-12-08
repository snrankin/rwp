<?php
/** ============================================================================
 * Debug Output
 *
 * @package   RWP\Integrations\QM\Output
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations\QM\Output;

use RWP\Vendor\Symfony\Component\VarDumper\Dumper\HtmlDumper;
use RWP\Vendor\Symfony\Component\VarDumper\Cloner\VarCloner;

if ( class_exists( '\\QM_Output_Html' ) ) {

	class Debug extends \QM_Output_Html {

		public function __construct( \QM_Collector $collector, $output, $title ) {
			parent::__construct( $collector );
			$this->output = $output;
			$this->title = $title;
			$this->id = rwp_change_case( $title );
			\add_filter( 'qm/output/menus', array( $this, 'admin_menu' ), 101 );
			\add_filter( 'qm/output/title', array( $this, 'admin_title' ), 101 );
			\add_filter( 'qm/output/menu_class', array( $this, 'admin_class' ) );
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

		/**
		 * Outputs data in the footer
		 */
		public function output() {
			$this->before_tabular_output();

			$dumper = new HtmlDumper();
			$cloner = new VarCloner();

			$data = rwp_collection( $this->output );

			$groups = $data->groupBy( 'file', true );

			$files = $groups->keys()->transform( function( $file ) {
				return wp_basename( $file );
			})->all();

			echo '<table>';

			echo '<thead>';
			echo '<tr>';

			echo '<th scope="col">' . $this->build_filter( 'file', $files, esc_html__( 'File', 'rwp' ) ) . '</th>'; //phpcs:ignore
			echo '<th scope="col">' . esc_html__( 'Line', 'rwp' ) . '</th>';
			echo '<th scope="col">' . esc_html__( 'Log', 'rwp' ) . '</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';

			foreach ( $this->output as $value ) {
				$file = data_get( $value, 'file', '' );
				$line = data_get( $value, 'line', 0 );
				$variable = data_get( $value, 'variable' );

				echo '<tr>';

				echo '<td>';
				if ( ! empty( $file ) ) {
					$text = wp_basename( $file );
					echo $this->output_filename( $text, $file, $line ); //phpcs:ignore
				}
				echo '</td>';

				echo '<td>';
				echo esc_html( $line );
				echo '</td>';

				if ( is_array( $variable ) ) {
					echo '<td>';
					$dumper->dump( $cloner->cloneVar( $variable ) );
					echo '</td>';
				} elseif ( is_object( $variable ) ) {
					echo '<td>';
					$dumper->dump( $cloner->cloneVar( $variable ) );
					echo '</td>';
				} elseif ( is_bool( $variable ) ) {
					if ( $variable ) {
						echo '<td class="qm-true">true</td>';
					} else {
						echo '<td class="qm-false">false</td>';
					}
				} else {
					echo '<td>';
					$dumper->dump( $cloner->cloneVar( $variable ) );
					echo '</td>';
				}

				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
			$this->after_tabular_output();
		}
	}
}
