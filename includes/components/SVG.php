<?php
/** ============================================================================
 * SVG
 *
 * @package   RWP\/includes/components/SVG.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Components;

class SVG extends Element {
	/**
	 * @var string
	 */
	public $tag = 'svg';

	/**
	 * The array of default attributes
	 * @var array
	 */
	public $atts = array(
		'aria-hidden' => 'true',
		'role'        => 'img',
		'xmlns' => 'http://www.w3.org/2000/svg',
		'class' => array(
			'media-src',
			'media-svg',
		),
	);

	/**
	 * @var string $path The path to the file
	 */

	public $path;

	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void|self
	 */

	public function __construct( $args = array() ) {

		$file = $this->path;

		if ( is_numeric( $args ) && rwp_is_wp_image( $args ) ) {
			$file = get_attached_file( $args ); // Convert image id
			$args = array();
		} elseif ( is_string( $args ) && ! rwp_string_is_html( $args ) ) {
			/**
			 * Assuming the $args variable is a file path
			 */
			$file = $args;
			$args = array();
        } elseif ( rwp_array_has( 'path', $args ) ) {
			$file = $args['path'];
		}

		if ( ! empty( $file ) ) {
			$svg_file = simplexml_load_file( $file );

			if ( ! $svg_file ) {
				return;
			}

			$svg_file = rwp_xml_to_array( $svg_file );

			$width = data_get( $svg_file, 'atts.width', false );
			$height = data_get( $svg_file, 'atts.height', false );
			$view_box = data_get( $svg_file, 'atts.viewBox', false );

			if ( $view_box ) {
				$view_box = explode( ' ', $view_box );
				if ( ! $width ) {
					$width = $view_box[2];
				}
				if ( ! $height ) {
					$height = $view_box[3];
				}
			}

			if ( ! data_has( $args, 'atts.width' ) && ! empty( $width ) ) {
				data_set( $args, 'atts.width', $width );
			}

			if ( ! data_has( $args, 'atts.height' ) && ! empty( $height ) ) {
				data_set( $args, 'atts.height', $height );
			}

			foreach ( $svg_file['children'] as $path ) {
				$path = new Element( $path );
				$args['content'][] = $path->html();
			}

			$args = rwp_merge_args( $args, $svg_file );
		}

		parent::__construct( $args );
	}
}
