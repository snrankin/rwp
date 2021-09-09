<?php
/** ============================================================================
 * Column
 *
 * @package   RWP\/includes/components/Column.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

 namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection;

class Section extends Element {

	/**
	 * @var string $tag The html element tag
	 */
	public $tag = 'section';

	/**
	 * @var Collection|array $atts The collection of atts
	 */
	public $atts = array(
		'class' => array(
            'page-section',
		),
	);

	/**
	 * @var array $order Array that sets the order of the child nodes
	 */

    public $order = array( 'inner' );

	/**
	 * @var array|Element $inner The inner content wrapper
	 */
    public $inner = array(
		'tag' => 'div',
        'atts' => array(
            'class' => array(
                'section-inner',
			),
		),
	);

	/**
	 * @var mixed  $background  A background class, a css color, or an Image
	 *                          element
	 */
    public $background;


    public function __construct( $args = [] ) {

        parent::__construct( $args );

        $this->inner = new Element( $this->inner );

		if ( $this->content->isNotEmpty() ) {
            $this->inner->content = $this->content;
            $this->content = new Collection();
        }

    }

	public function add_content( $value, $key = '', $overwrite = false ) {
        $this->inner->set_content( $value, $key, $overwrite );
    }

	public function setup_html() {
		$this->setup_background();
	}

	/**
	 * Adds a css class, an inline style, or an background image
	 * @return void
	 */
	public function setup_background() {

		$lazysizes = rwp_get_option( 'modules.lazysizes.lazyload', false );

		$bg = $this->background;
		$srcset = false;

		if ( ! blank( $bg ) ) {
			if ( is_numeric( $bg ) ) {
				if ( $lazysizes ) {
					$srcset = wp_get_attachment_image_srcset( $bg, 'full' );
				}
				$bg = wp_get_attachment_image_url( $bg, 'full', false );
			}
			if ( is_string( $bg ) ) {
				if ( rwp_string_is_html( $bg ) ) {
					array_unshift( $this->order, 'background' );
				} else if ( rwp_str_starts_with( $bg, array( '#', 'rgb' ) ) ) {
					$this->inner->set_style( 'background-color', $bg );
				} else if ( rwp_str_starts_with( $bg, array( 'bg-' ) ) ) {
					$this->inner->add_class( $bg );
				} else if ( rwp_is_url( $bg ) || rwp_is_relative_url( $bg ) ) {
					if ( $lazysizes ) {
						if ( $srcset ) {
							$this->inner->set_attr( 'data-bgset', $srcset );

						} else {
							$this->inner->set_attr( 'data-bgset', $bg );
						}
						$this->inner->set_attr( 'data-sizes', 'auto' );
						$this->inner->add_class( 'lazyload' );
					} else {
						$this->inner->set_style( 'background-image', $bg );
					}
				}
            } else if ( $bg instanceof Element ) {
				array_unshift( $this->order, 'background' );
			}

			$this->inner->add_class( 'has-bg' );
		}
	}
}
