<?php
/** ============================================================================
 * Debug Output
 *
 * @package   RWP\Integrations\QM\Output
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine\Abstracts;

if ( ! \defined( 'ABSPATH' ) ) {
	die( 'FU!' );
}
use RWP\Components\Table;
use RWP\Components\TableSection;
use RWP\Components\TableRow;
use RWP\Components\TableCell;

abstract class DebugOutput extends \QM_Output_Html {

	public static $table_header = array();
	public static $table_footer = array();

	public $id;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var QM
	 */
	public $parent;

	public $output;

	public function __construct( \QM_Collector $collector, \RWP\Integrations\QM $parent, $id = '' ) {
		parent::__construct( $collector );
		$prefix = rwp()->get_namespace();

		$this->title = rwp_add_prefix( $id, $prefix . ' ' );
		$id = rwp()->prefix( $id );
		$this->id = $id;
		$this->parent = $parent;

		if ( rwp_array_has( $id, $this->parent->output ) && is_array( $this->parent->output[ $id ] ) ) {
			$this->output = $this->parent->output[ $id ];
		}

		\add_filter( 'qm/output/menus', array( $this, 'admin_menu' ), 101 );
		\add_filter( 'qm/output/title', array( $this, 'admin_title' ), 101 );
		\add_filter( 'qm/output/menu_class', array( $this, 'admin_class' ) );
	}

	public function name() {
        return $this->title;
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

	/**
	 * Function for admin bar title
	 *
	 * @param array<string, mixed[]> $menu
	 * @return array<string, mixed[]>
	 */
	public function admin_menu( array $menu ) {
		$data = $this->collector->get_data();
		if ( isset( $data['log'] ) ) {
			$menu[] = $this->menu( array(
				'id' => $this->id,
				'href' => '#qm-' . $this->id,
				'title' => $this->title . ' (' . \count( $data['log'] ) . ')',
			) );
		}
		return $menu;
	}

	/**
	 * Generate a table row
	 * @param mixed $var
	 * @return TableRow
	 */

	public static function table_row( $vars ) {
		$row = new TableRow();

		if ( is_array( $vars ) && ! empty( $vars ) ) {
			foreach ( $vars as $key => $var ) {
				$cell = new TableCell();

				if ( is_array( $var ) || is_object( $var ) ) {
					$cell->add_class( 'qm-collection' );

					$var = rwp_dump( $var );
				} else if ( is_bool( $var ) ) {
					$var = strval( $var );
					if ( $var ) {
						$var = 'true';
					} else {
						$var = 'false';
					}
					$cell->add_class( "qm-{$var}" );
				} else if ( rwp_str_is_html( $var ) && ! rwp_str_has( $var, 'qm-edit-link' ) ) {
					$cell->add_class( 'qm-html' );
					$var = '<code>' . nl2br( esc_html( $var ) ) . '</code>';

				} else {
					$var = '<code>' . strval( $var ) . '</code>';

				}
				$cell->set_content( $var );

				$row->add_cell( $cell, $key );
			}

			return $row;
		} else {
			return false;
		}

	}

	public static function table_header() {

		if ( ! empty( self::$table_header ) ) {
			$header = new TableSection( array( 'tag' => 'thead' ) );

			foreach ( self::$table_header as $column ) {

				$header->add_cell(array(
					'content' => $column,
					'tag' => 'th',
					'atts' => array(
						'scope' => 'col',
					),
				));

			}

			return $header;
		}
		return false;

	}

	public static function table_footer() {

		if ( ! empty( self::$table_footer ) ) {
			$footer = new TableSection( array( 'tag' => 'tfoot' ) );

			foreach ( self::$table_footer as $column ) {

				$footer->add_cell(array(
					'content' => $column,
				));

			}

			return $footer;
		}
		return false;

	}

	/**
	 * @param array<string, mixed> $vars
	 * @return void
	 */

	public static function debug_inner( $vars ) {
		$table = new Table();

		$header = self::table_header();

		$table->set( 'header', $header );

		foreach ( $vars as $key => $value ) {
			$value = self::table_row( $value );
			if ( $value ) {
				$table->add_row( $value );
			}
		}

		$footer = self::table_footer();

		$table->set( 'footer', $footer );

		$table = $table->html();

		echo $table; // phpcs:ignore
	}



}
