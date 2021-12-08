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

use RWP\Components\Collection;

class Column extends Element {

	/**
	 * @var string $tag The html element tag
	 */
	public $tag = 'div';

	/**
	 * @var Collection|array $atts The collection of atts
	 */
	public $atts = array(
		'class' => array(
            'col',
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
                'content-wrapper',
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
}
