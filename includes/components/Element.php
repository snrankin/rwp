<?php
/** ============================================================================
 * Element
 *
 * @package   RWP\/includes/components/Element.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use DOMException;
use DOMNode;
use DOMNodeList;
use Exception;
use ReflectionClass;
use RuntimeException;
use RWP\Vendor\Exceptions\Collection\EmptyException;
use RWP\Vendor\Symfony\Component\VarDumper\VarDumper;
use RWP\Vendor\Exceptions\Data\TypeException;
use RWP\Components\Collection;
use RWP\Components\Str;

class Element {

	/**
	 * @var string $tag The html element tag
	 */
	public $tag;

	/**
	 * @var Collection|array $atts The collection of atts
	 */
	public $atts;

	/**
	 * @var Collection|array $content Array of content nodes
	 */
	public $content;

	/**
	 * @var array $order Array that sets the order of the child nodes
	 */
	public $order = array();

	/**
	 * @var array $elements_map An array that maps order items into new Element classes
	 */
	public $elements_map = array();

	/**
	 * @var Html $html The html object class
	 */
	public $html;

	/**
     * @var array $html_methods The array of methods for manipulating the html
	 * @access private
     */
    private static $html_methods = [];

	/**
     * @var array $methods The current class' methods
	 * @access private
     */
    public static $methods = [];

	/**
	 * @var array $selfClosing An array of html elements that don't need an end tag
	 */

	protected const SELFCLOSING = [
		'area',
		'base',
		'br',
		'col',
		'embed',
		'hr',
		'img',
		'input',
		'link',
		'meta',
		'param',
		'source',
		'textarea',
		'track',
		'wbr',
	];

	/**
	 * Initialize the class
	 *
	 * @param mixed $args
	 *
	 * @return void
	 */
	public function __construct( $args = array() ) {

		self::mapApiMethods();

		$this->merge_args( $args );

		$this->content = new Collection( $this->content );

		$this->set_tag( $this->tag );

		$this->map_elements();

		try {
			if ( empty( $this->tag ) ) {
				$class = get_called_class();
				throw new EmptyException( __( 'There is no html tag set and there were no arguments passed, cannot initialize ', 'rwp' ) . $class );
			}
		} catch ( EmptyException $th ) {
			rwp_error( $th->getMessage() );
		}

	}

	/**
	 * Create an array of Element arguments from a string
	 *
	 * @param string $string
	 * @return array
	 * @throws RuntimeException
	 * @throws Exception
	 * @throws TypeException
	 */

	public function create_from_string( $string ) {

		$args = array(
			'tag'     => $this->tag,
			'atts'    => $this->get_atts(),
			'content' => array(),
		);
		$string = trim( $string );
		$string = \force_balance_tags( $string );
		if ( ! rwp_str_is_html( $string ) ) {
			$args['content'][] = $string;
		} else {
			$html = new Html( $string );
			$atts = $html->extractAll( true, true );
			$args = rwp_merge_args( $args, $atts );
		}

		return $args;
	}

	public function get_args() {
		return get_object_vars( $this );
	}

	/**
	 * Merge arguments into the current object
	 *
	 * @param mixed $args
	 * @param bool $overwrite
	 *
	 * @return void
	 */
	public function merge_args( $args, $overwrite = true ) {
		$properties = get_object_vars( $this );

		if ( is_string( $args ) ) {
			$args = $this->create_from_string( $args );
		}

		if ( is_object( $args ) ) {
			if ( $args instanceof Html ) {
				$args = $args->__toString();
				$args = $this->create_from_string( $args );

			} elseif ( $args instanceof Element || $args instanceof Collection ) {
				$args = rwp_object_to_array( $args );
			}
		}

		if ( is_array( $args ) ) {

			$properties = rwp_merge_args( $properties, $args );

			if ( rwp_array_has( 'order', $args ) ) {
				$properties['order'] = $args['order'];
			}

			foreach ( $properties as $key => $value ) {
				$this->set( $key, $value, $overwrite );
			}
		}
	}

	/**
	 * Map items into their respective classes
	 *
	 * @return void
	 */
	public function map_elements() {
		$elements_map = $this->get( 'elements_map', array() );

		if ( ! empty( $elements_map ) ) {
			foreach ( $elements_map as $item => $element ) {
				try {
					$element_class = __NAMESPACE__ . '\\' . $element;
					if ( class_exists( $element_class ) ) {
						if ( $this->has( $item ) ) {
							if ( ! ( $this->$item instanceof $element_class ) ) {
								$value = new $element_class( $this->$item );
								$this->set( $item, $value, true );
							}
						}
					} else {
						throw new \LogicException( "Unable to load class: $element_class" );
					}
				} catch ( \Throwable $th ) {
					rwp_error( $th );
				}
			}
		}
	}

	/**
	 * Add a content item key to the elements order
	 *
	 * @param mixed $key
	 * @param mixed|null $index
	 *
	 * @return void
	 */
	public function set_order( $key, $index = null, $position = null ) {
		$order = $this->order;

		if ( ! blank( $index ) && ! blank( $position ) ) {

			$current_index = array_search( $key, $order );

			$index = array_search( $index, $order );

			if ( false !== $current_index && false !== $index ) {
				if ( $current_index !== $index ) {
					$order = rwp_array_remove( $order, $key );

					if ( 'before' == $position ) {
						$index--;
					}
					$order = array_merge(
					array_slice( $order, 0, $index ),
					$key,
					array_slice( $order, $index )
					);
				}
			} else {
				rwp_array_insert( $order, $index, $key );
			}
		} else {
			if ( blank( $index ) || 'last' === $index ) {
				$order[] = $key;
			} else if ( 'first' === $index ) {
				array_unshift( $order, $key );
			} else {
				$current_order = array_search( $key, $order );
				if ( false !== $current_order ) {
					if ( $current_order !== $index ) {
						$order = rwp_array_remove( $order, $key );
						$order = array_merge(
						array_slice( $order, 0, $index ),
						$key,
						array_slice( $order, $index )
						);
					}
				} else {
					rwp_array_insert( $order, $index, $key );
				}
			}
		}

		$this->set( 'order', $order );
	}

	/**
	 * Add a content item key to the elements order
	 *
	 * @param string|int $key
	 *
	 * @return void
	 */
	public function remove_order_item( $key ) {
		$order = $this->order;

		if ( false !== array_search( $key, $order ) ) {
			$order = rwp_array_remove( $order, $key );
		}

		$this->set( 'order', $order );
	}


	/**
	 * Check if attribute exists in atts array
	 *
	 * @param string|string[]  $key
	 *
	 * @return bool
	 */

	public function has_attr( $key ) {
		return $this->exists( "atts.$key" );
	}

	/**
	 * Get Attribute
	 *
	 * @param string|string[]  $key
	 * @param mixed  $default The default value to set if the key doesn't exist
	 *
	 * @return mixed
	 */

	public function get_attr( $key, $default = null ) {
		return $this->get( "atts.$key", $default );
	}

	/**
	 * Check if attribute exists in atts array
	 *
	 * @param string|string[]  $key
	 *
	 * @return bool
	 */

	public function is_empty_attr( $key ) {
		if ( $this->has_attr( $key ) ) {
			$attr = $this->get_attr( $key );

			if ( rwp_attr_can_be_empty( $key ) || filled( $attr ) ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * Get All Attributes
	 *
	 * @return array
	 */

	public function get_atts() {
		$atts = $this->get( 'atts' );
		if ( rwp_is_collection( $atts ) ) {
			$atts = rwp_object_to_array( $atts );
		}
		return $atts;
	}

	/**
	 * Merge Attributes
	 *
	 * @param mixed $atts
	 * @param bool $overwrite
	 *
	 * @return void
	 * @throws Exception
	 */
	public function merge_atts( $atts, $overwrite = false ) {
		$defaults = $this->get_atts();
		if ( is_string( $atts ) && rwp_str_is_html( $atts ) ) {
			$html = new Html( $atts );
			$atts = $html->extractAll();
		}

		if ( is_object( $atts ) ) {
			$args = rwp_object_to_array( $atts );

			if ( rwp_array_has( 'atts', $args ) ) {
				$atts = $args['atts'];
			}
		}

		if ( $atts instanceof self ) {
			$atts = $atts->get_atts();
		}

		$atts = rwp_merge_args( $defaults, $atts );

		foreach ( $atts as $key => $value ) {
			if ( 'class' === $key || 'style' === $key ) {
				$this->set_attr( $key, $value, true ); // Always update the merged classes/styles
			} else {
				$this->set_attr( $key, $value, $overwrite );
			}
		}
	}

	/**
	 * Remove Attribute
	 *
	 * @param string|string[]  $key        The attribute(s) to remove
	 *
	 * @return void
	 */

	public function remove_attr( $key ) {
		$this->remove( "atts.$key", false, false );
	}

	/**
	 * Set an attribute
	 *
	 * @param  string|string[]  $key        The attribute(s) to set
	 * @param  mixed            $value      The attribute value(s) to set
	 * @param  bool             $overwrite  Should the existing value be
	 *                                      overwritten?
	 *
	 * @return void
	 */

	public function set_attr( $key, $value, $overwrite = false ) {
		$this->set( "atts.$key", $value, $overwrite );

	}

	/**
	 * Check if the item has a css class
	 *
	 * @param string|string[] $value
	 * @param string          $compare The compare operator for when the $value
	 *                                 is an array. Can be 'any' or 'all'
	 *
	 * @return bool
	 */

	public function has_class( $value, $compare = 'any' ) {

		if ( empty( $value ) || ! $this->has_attr( 'class' ) ) {
			return false;
		}

		if ( is_string( $value ) ) {
			$classes = $this->get_classes();

			if ( ! empty( preg_grep( '/' . preg_quote( $value, '/' ) . '/i', $classes ) ) ) {
				return true;
			} else {
				return false;
			}
		} elseif ( is_array( $value ) ) {
			$values = $value;
			$classes = array();
			foreach ( $values as $value ) {
				$classes[] = $this->has_class( $value );
			}
			if ( 'all' === $compare && in_array( false, $classes, true ) ) {
				return false; // Does not have all classes
			} elseif ( 'all' === $compare && ! in_array( false, $classes, true ) ) {
				return true; // Does have all classes
			} elseif ( 'any' === $compare && in_array( true, $classes, true ) ) {
				return true; // Has at least one of the classes
			} elseif ( 'any' === $compare && ! in_array( true, $classes, true ) ) {
				return false; // Has none of the classes
			}
		}
		return false;
	}

	/**
	 * Add a class to the element's attributes
	 *
	 * @param string|string[] $value
	 * @param bool            $filter
	 *
	 * @return void
	 */

	public function add_class( $value, $filter = true ) {
		if ( empty( $value ) ) {
			return;
		}

		if ( is_string( $value ) ) {
			if ( $this->has_class( $value ) ) {
				return;
			}
			if ( $filter ) {
				$value = \sanitize_html_class( $value );
			}
			$classes = $this->get_attr( 'class', array() );
			$classes = rwp_parse_classes( $classes, $value, $filter );
			$this->set( 'atts.class', $classes, true );
		} elseif ( is_array( $value ) ) {
			$values = $value;
			foreach ( $values as $value ) {
				$this->add_class( $value, $filter );
			}
		}
	}

	/**
	 * Remove a class
	 *
	 * @param string|string[]  $value      The attribute(s) to remove
	 *
	 * @return void
	 */

	public function remove_class( $value ) {
		if ( empty( $value ) || ! $this->has_attr( 'class' ) ) {
			return;
		}

		if ( is_string( $value ) ) {
			if ( ! $this->has_class( $value ) ) {
				return;
			}
			$classes = $this->get_classes();

			$classes = rwp_array_remove( $classes, $value );

			$this->set_attr( 'class', $classes, true );
		} elseif ( is_array( $value ) ) {
			$values = $value;
			foreach ( $values as $value ) {
				$this->remove_class( $value );
			}
		}
	}

	/**
	 * Get all element classes
	 *
	 * @return string[]
	 */
	public function get_classes() {
         $classes = $this->get_attr( 'class', array() );
		return rwp_parse_classes( $classes );
	}

	/**
	 * Check if an element has a specific style
	 *
	 * @param string|string[]  $key
	 * @return bool
	 */

	public function has_style( $key ) {
		return $this->has( "atts.style.$key" );
	}

	/**
	 * Get the value of a specific style, if it exists
	 *
	 * @param string|string[]  $key
	 * @param mixed            $default
	 * @return mixed
	 */

	public function get_style( $key, $default = null ) {
		return $this->get( "atts.style.$key", $default );
	}

	/**
	 * Set an inline style
	 *
	 * @param  string|string[]  $key        The style(s) to set
	 * @param  mixed            $value      The value(s) to set
	 * @param  bool             $overwrite  Should the existing value be
	 *                                      overwritten?
	 * @return void
	 */

	public function set_style( $key, $value, $overwrite = false ) {
		$this->set( "atts.style.$key", $value, $overwrite );
	}

	/**
	 * Remove an inline style
	 * @param string|string[]  $key        The style(s) to remove
	 * @return void
	 */

	public function remove_style( $key ) {
		$this->remove( "attr.style.$key", false, false );
	}

	/**
	 * Add a background to a specific element
	 *
	 * @param mixed $bg
	 * @param Element $parent_elem
	 * @param string $inner_elem
	 * @return void
	 */

	public static function add_background( $bg, $parent_elem ) {

		if ( ! blank( $bg ) ) {
			$bg_elem = new self(array(
				'tag' => 'div',
				'atts' => array(
					'class' => array(
						'bg-wrapper',
					),
				),
			));
			$lazysizes = rwp_get_option( 'modules.lazysizes.lazyload', false );

			$srcset = false;
			if ( is_numeric( $bg ) && wp_attachment_is_image( $bg ) ) {
				if ( $lazysizes ) {
					$srcset = wp_get_attachment_image_srcset( $bg, 'full' );
				}
				$bg = wp_get_attachment_image_url( $bg, 'full', false );
			}
			if ( $bg instanceof \WP_Post && wp_attachment_is_image( $bg ) ) {
				if ( $lazysizes ) {
					$srcset = wp_get_attachment_image_srcset( $bg->ID, 'full' );
				}
				$bg = wp_get_attachment_image_url( $bg->ID, 'full', false );
			}
			if ( is_string( $bg ) ) {
				if ( preg_match( '/\#(?<=#)[a-zA-Z0-9]{3,8}|rgba?\((?:(?:\d{1,3}|\.)\,?\s*)+\)|hsla?\((?:(?:\d{1,3}|\%|\.)\,?\s*)+\)|var\(--[^\)|\s]+\)/', $bg ) ) {
					$bg_elem->set_style( 'background-color', $bg );
				} else if ( rwp_str_starts_with( $bg, array( 'bg-' ) ) ) {
					$bg_elem->add_class( $bg );
				} else if ( rwp_is_url( $bg ) || rwp_is_relative_url( $bg ) ) {
					if ( $lazysizes ) {
						if ( $srcset ) {
							$bg_elem->set_attr( 'data-bgset', $srcset );

						} else {
							$bg_elem->set_attr( 'data-bgset', $bg );
						}
						$bg_elem->set_attr( 'data-sizes', 'auto' );
						$bg_elem->add_class( 'lazyload' );
					} else {
						$bg_elem->set_style( 'background-image', $bg );
					}
				}
            } else if ( $bg instanceof Element || rwp_str_is_html( $bg ) && $bg !== $bg_elem ) {
				$bg_elem = $bg;
			}
			$parent_elem->background = $bg_elem;
			$parent_elem->set_order( 'background', 'first' );
			$parent_elem->add_class( 'has-bg' );
		}
	}

	public function add_bg( $bg, $target = '' ) {

		if ( blank( $target ) ) {
			$target = $this;
		}

		if ( ! blank( $bg ) ) {
			$bg_elem = new self(array(
				'tag' => 'div',
				'atts' => array(
					'class' => array(
						'bg-wrapper',
					),
				),
			));
			$lazysizes = rwp_get_option( 'modules.lazysizes.lazyload', false );

			$srcset = false;
			if ( is_numeric( $bg ) && wp_attachment_is_image( $bg ) ) {
				if ( $lazysizes ) {
					$srcset = wp_get_attachment_image_srcset( $bg, 'full' );
				}
				$bg = wp_get_attachment_image_url( $bg, 'full', false );
			}
			if ( $bg instanceof \WP_Post && wp_attachment_is_image( $bg ) ) {
				if ( $lazysizes ) {
					$srcset = wp_get_attachment_image_srcset( $bg->ID, 'full' );
				}
				$bg = wp_get_attachment_image_url( $bg->ID, 'full', false );
			}
			if ( is_string( $bg ) ) {
				if ( preg_match( '/\#(?<=#)[a-zA-Z0-9]{3,8}|rgba?\((?:(?:\d{1,3}|\.)\,?\s*)+\)|hsla?\((?:(?:\d{1,3}|\%|\.)\,?\s*)+\)|var\(--[^\)|\s]+\)/', $bg ) ) {
					$bg_elem->set_style( 'background-color', $bg );
				} else if ( rwp_str_starts_with( $bg, array( 'bg-' ) ) ) {
					$bg_elem->add_class( $bg );
				} else if ( rwp_is_url( $bg ) || rwp_is_relative_url( $bg ) ) {
					if ( $lazysizes ) {
						if ( $srcset ) {
							$bg_elem->set_attr( 'data-bgset', $srcset );

						} else {
							$bg_elem->set_attr( 'data-bgset', $bg );
						}
						$bg_elem->set_attr( 'data-sizes', 'auto' );
						$bg_elem->add_class( 'lazyload' );
					} else {
						$bg_elem->set_style( 'background-image', $bg );
					}
				}
            } else if ( $bg instanceof Element || rwp_str_is_html( $bg ) && $bg !== $bg_elem ) {
				$bg_elem = $bg;
			}
			$target->background = $bg_elem;
			$target->set_order( 'background', 'first' );
			$target->add_class( 'has-bg' );
		}
	}

	/**
	 * Set a background on an element
	 * @param mixed $bg
	 * @param string $target
	 * @return void
	 */
	public function set_background( $bg = null, $target = '' ) {
		if ( blank( $bg ) && $this->has( 'background' ) ) {
			$bg = $this->background;
		}

		if ( blank( $target ) ) {
			$target = $this;
		}

		if ( ! blank( $bg ) ) {
			$bg_elem = new self(array(
				'tag' => 'div',
				'atts' => array(
					'class' => array(
						'bg-wrapper',
					),
				),
			));
			$lazysizes = rwp_get_option( 'modules.lazysizes.lazyload', false );

			$srcset = false;
			if ( is_numeric( $bg ) && wp_attachment_is_image( $bg ) ) {
				if ( $lazysizes ) {
					$srcset = wp_get_attachment_image_srcset( $bg, 'full' );
				}
				$bg = wp_get_attachment_image_url( $bg, 'full', false );
			}
			if ( $bg instanceof \WP_Post && wp_attachment_is_image( $bg ) ) {
				if ( $lazysizes ) {
					$srcset = wp_get_attachment_image_srcset( $bg->ID, 'full' );
				}
				$bg = wp_get_attachment_image_url( $bg->ID, 'full', false );
			}
			if ( is_string( $bg ) ) {
				if ( preg_match( '/\#(?<=#)[a-zA-Z0-9]{3,8}|rgba?\((?:(?:\d{1,3}|\.)\,?\s*)+\)|hsla?\((?:(?:\d{1,3}|\%|\.)\,?\s*)+\)|var\(--[^\)|\s]+\)/', $bg ) ) {
					$bg_elem->set_style( 'background-color', $bg );
				} else if ( rwp_str_starts_with( $bg, array( 'bg-' ) ) ) {
					$bg_elem->add_class( $bg );
				} else if ( rwp_is_url( $bg ) || rwp_is_relative_url( $bg ) ) {
					if ( $lazysizes ) {
						if ( $srcset ) {
							$bg_elem->set_attr( 'data-bgset', $srcset );

						} else {
							$bg_elem->set_attr( 'data-bgset', $bg );
						}
						$bg_elem->set_attr( 'data-sizes', 'auto' );
						$bg_elem->add_class( 'lazyload' );
					} else {
						$bg_elem->set_style( 'background-image', $bg );
					}
				}
            } else if ( $bg instanceof Element || rwp_str_is_html( $bg ) && $bg !== $bg_elem ) {
				$bg_elem = $bg;
			}
			$target->background = $bg_elem;
			$target->set_order( 'background', 'first' );
			$target->add_class( 'has-bg' );
		}

	}

	/**
	 * Check if content exists in content array
	 *
	 * @param string|string[]  $key
	 *
	 * @return bool
	 */

	public function has_content( $key = '' ) {
		if ( ! rwp_is_collection( $this->content ) ) {
			$this->content = rwp_collection( $this->content );
		}
		if ( blank( $key ) ) {
			return $this->content->isNotEmpty();
		} else {
			return $this->content->has( $key );
		}
	}

	/**
	 * Get Attribute
	 *
	 * @param string|string[]  $key
	 *
	 * @return mixed
	 */

	public function get_content( $key ) {
		return $this->get( "content.$key" );
	}

	/**
	 * Remove Attribute
	 *
	 * @param string|string[]  $key        The content key(s) to remove
	 *
	 * @return void
	 */

	public function remove_content( $key ) {
		$this->remove( "content.$key", true, false );
		$this->remove_order_item( $key );
	}

	/**
	 * Reset the content property to an empty collection
	 *
	 * @return void
	 */
	public function make_empty() {
		$this->content = new Collection();
	}

	/**
	 * Set content with a specific key
	 *
	 * @param  mixed  $value      The content value(s) to set
	 * @param  mixed  $key        The content key(s) to set
	 *
	 * @param  bool   $overwrite  Should the existing value be overwritten?
	 *
	 * @return void
	 */

	public function set_content( $value, $key = '', $overwrite = false ) {
		if ( ! rwp_is_collection( $this->content ) ) {
			$this->content = rwp_collection( $this->content );
		}

		if ( '' === $key || is_null( $key ) ) {
			$this->content->push( $value );
		} else {
			$this->set( "content.$key", $value, $overwrite );
		}

	}

	/**
	 * Set tag
	 *
	 * @param  string  $tag
	 *
	 * @return void
	 */

	public function set_tag( $tag ) {
		$this->set( 'tag', $tag, true );
		$tag = \force_balance_tags( '<' . \esc_attr( $this->tag ) . '>' );
		$this->html = new Html( $tag );
	}

	/**
	 * Function to run before building the Html class
	 *
	 * @return void
	 */

	public function setup_html() {}

	/**
	 * Take the content attribute and add it to the inner html of the element
	 * @return void
	 */

	public function setup_content() {
		if ( ! $this->is_self_closing() ) {

			if ( ! blank( $this->content ) ) {
				$content = $this->content;
				if ( is_array( $this->content ) ) {
					$content = rwp_collection( $content );
				}
				if ( rwp_is_collection( $content ) ) {

					$content = $content->transform( function( $node, $key ) {
						if ( is_object( $node ) && method_exists( $node, '__toString' ) ) {
							return $node->__toString();
						} else if ( is_string( $node ) ) {
							return $node;
						} else {
							return '';
						}
					} )->reject( function( $item ) {
						return blank( $item );
					});
					if ( ! empty( $this->order ) ) {
						$content = rwp_collection_sort_by_keys( $content, $this->order );
					}
					if ( $content->has( 'background' ) ) { // make sure background element is first item
						$bg = $content->pull( 'background' );
						$content->prepend( $bg );
					}
					$content = $content->join( '' );
				}

				$this->html->setInnerHtml( $content );
			}
		}
	}

	/**
	 * Make sure all sub elements specified in the order property are added to
	 * the content property
	 *
	 * @param mixed $elements
	 *
	 * @return void
	 */

	public function add_sub_elements( $elements = '', $target = '' ) {
		if ( empty( $target ) ) {
			$target = $this;
		}

		if ( empty( $elements ) ) {
			$elements = $target->order;
		}
		if ( ! blank( $elements ) ) {
			if ( is_string( $elements ) && $target->has( $elements ) ) {
				$key = $elements;
				$value = $target->get( $key );
				if ( is_object( $value ) && method_exists( $value, '__toString' ) ) {
					$value = $value->__toString();
				}
				if ( is_string( $value ) ) {
					$target->set_content( $value, $key, true );
				}
			} else if ( is_array( $elements ) ) {
				foreach ( $elements as $element ) {
					if ( is_string( $element ) ) {
						$target->add_sub_elements( $element );
					}
				}
			}
		}
	}

	/**
	 * Check if the current element is a self-closing element
	 *
	 * @return bool
	 */

	public function is_self_closing() {

		if ( ! $this->has( 'tag' ) ) {
			return false;
        }

		return in_array( $this->tag, $this::SELFCLOSING );
	}

	/**
	 * Build the Html class
	 *
	 * @return void
	 */

	public function build() {

		if ( ! empty( $this->tag ) ) {
			$this->set_tag( $this->tag );
			$this->setup_html();
			$this->add_sub_elements();
			$this->set_background();
			$this->setup_content();

			if ( ! blank( $this->atts ) ) {
				$this->html->setAllAttributes( $this->atts );
			}

			apply_filters( "rwp_{$this->tag}", $this->html, $this );
		}

	}

	/**
	 * Generates the inner content string
	 *
	 * @return string
	 */

	public function html() {
		$this->build();

		return $this->html->saveHTML();
	}

	/**
	 * Generates the html string and gets the inner content
	 *
	 * @return string
	 */

	public function content() {
		$this->build();

		return $this->html->getInnerHtml();
	}

	/**
	 * Get the starting tag of the element
	 * @param bool $include_content Include everything except for the end tag
	 *
	 * @return string
	 */

	public function start_tag( $include_content = false ) {
		$this->build();
		$html = $this->html;
		if ( ! $include_content ) {
			$html->makeEmpty();
		}
		$tag = $this->end_tag();

		$html = $html->__toString();

		if ( ! empty( $tag ) ) {
			$html = Str::replaceLast( $tag, '', $html );
		}
		return $html;
	}

	/**
	 * Get the ending tag (if the element needs one)
	 *
	 * @return string
	 */

	public function end_tag() {
		$self_closing = $this::SELFCLOSING;

		if ( ! $this->has( 'tag' ) ) {
			return '';
        }

		$tag = $this->tag;

		return ! in_array( $tag, $self_closing ) ? '</' . \esc_attr( $tag ) . '>' : '';
	}

	/**
	 * Beautify the html string
	 *
	 * @param array $options Options passed to PrettyMin::__construct()
	 * @return string
	 * @throws Exception
	 * @throws DOMException
	 */
	public function beautify( $options = array() ) {
		$this->build();
		$html = $this->html;

		$html = rwp_html_page( $html );

		$html->indent( $options );

		$html = $html->getBody()->saveHTML();

		$html = (string) preg_replace( array( "/\<body\>\n*/", "/\n*\<\/body\>/" ), '', $html );

		return $html;
	}



	/**
	 * Minify the html string
	 *
	 * @param array $options Options passed to PrettyMin::__construct()
	 * @return string
	 * @throws Exception
	 * @throws DOMException
	 */
	public function minify( $options = array() ) {
        $this->build();
		$html = $this->html;

		$html = rwp_html_page( $html );

		$html->minify( $options );

		$html = $html->getBody()->saveHTML();

		$html = (string) preg_replace( array( "/\<body\>\n*/", "/\n*\<\/body\>/" ), '', $html );

		return $html;
	}


	/**
	 * Determine if the given key exists and is not empty.
	 *
	 * @param  string|string[]  $key
	 *
	 * @return bool
	 */
	public function has( $key ) {
		return $this->exists( $key ) && filled( $this->get( $key ) );
	}

	/**
	 * Determine if the given key exists.
	 *
	 * @param  string|string[]  $key
	 *
	 * @return bool
	 */
	public function exists( $key ) {
		return \data_has( $this, $key );
	}

	/**
	 * Get an attribute from the html instance.
	 *
	 * @param  string|string[]  $key
	 * @param  mixed            $default
	 *
	 * @return mixed
	 */
	public function get( $key, $default = null ) {
		return \data_get( $this, $key, $default );
	}

	/**
	 * Set a property
	 *
	 * @param  string|string[]  $key        The key(s) to set
	 * @param  mixed            $value      The value(s) to set
	 * @param  bool             $overwrite  Should the existing value be
	 *                                      overwritten?
	 *
	 * @return mixed
	 */
	public function set( $key, $value, $overwrite = true ) {
		return \data_set( $this, $key, $value, $overwrite );
	}

	/**
	 * Unset the value at the given key.
	 *
	 * @param  string|string[]  $key
	 *
	 * @return void
	 */
	public function remove( $key ) {
		\data_remove( $this, $key );
	}

	/**
	 * Set the methods
	 * @return void
	 */
    final public static function mapApiMethods() {

        $class = \get_called_class();
		$html_class_methods = get_class_methods( Html::class );

		if ( empty( self::$html_methods ) ) {
			self::$html_methods = $html_class_methods;
		}

		self::$methods = get_class_methods( $class );

    }

	/**
	 * Get object info in a formatted way
	 * @param bool $qm Whether to add the variable to Query Monitor
	 * @return void|VarDumper
	 */

	public function debug( $qm = false ) {
		if ( $qm ) {
			rwp_log( $this );
		} else {
			return rwp_dump( $this );
		}

	}

	/**
	 * Output the object as an array
	 *
	 * @return array
	 */

	public function toArray() {
		return rwp_object_to_array( $this );
	}

	/**
	 * Handle dynamic calls to the html instance to set atts.
	 *
	 * @param mixed $method
	 * @param mixed $parameters
	 * @return void|mixed
	 */
	public function __call( $method, $parameters ) {

		$class = \get_called_class();
		$methods = get_class_methods( $class );

		try {
			if ( in_array( $method, self::$html_methods ) ) {
				return $this->html->$method( ...$parameters );
			} else if ( in_array( $method, $methods ) ) {
				return $this->$method( ...$parameters );
			} else {
				throw new \Exception( 'Endpoint "' . $method . '" does not exist' );
			}
		} catch ( \Throwable $th ) {
			rwp_error( $th );
		}
	}

	/**
	 * Dynamically retrieve the value of an attribute.
	 *
	 * @param  string|string[]  $key
	 * @return mixed
	 */
	public function __get( $key ) {
		return $this->get( $key );
	}

	/**
	 * Dynamically set the value of an attribute.
	 *
	 * @param  string|string[]  $key
	 * @param  mixed   $value
	 *
	 * @return void
	 */
	public function __set( $key, $value ) {
		$this->set( $key, $value );
	}

	/**
	 * Dynamically check if an attribute is set.
	 *
	 * @param  string|string[]  $key
	 *
	 * @return bool
	 */
	public function __isset( $key ) {
		return $this->exists( $key );
	}

	/**
	 * Dynamically unset an attribute.
	 *
	 * @param  string|string[]  $key
	 *
	 * @return void
	 */
	public function __unset( $key ) {
		$this->remove( $key );
	}

	/**
	 * Output the html string
	 *
	 * @return string
	 */

	public function __toString() {
		return $this->html();
	}

}
