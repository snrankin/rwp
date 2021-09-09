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

use DOMNode;
use DOMNodeList;
use Exception;
use ReflectionClass;
use RuntimeException;
use RWP\Vendor\Exceptions\Collection\EmptyException;
use RWP\Vendor\Symfony\Component\VarDumper\VarDumper;
use RWP\Vendor\Exceptions\Data\TypeException;
use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Vendor\Illuminate\Support\Str;

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
	 * @var Html $html The html object class
	 */
	public $html;

	/**
     * @var array $html_methods The array of methods for manipulating the html
     */
    private $html_methods = [];

	/**
     * @var array $methods The current class' methods
     */
    private $methods = [];

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

		$class = get_class( $this );

		$this->mapApiMethods();

		if ( ! empty( $this->tag ) ) {
			if ( empty( $this->html ) ) {
				// create an empty element from the tag just to initialize the Html class
				$tag = \force_balance_tags( '<' . \esc_attr( $this->tag ) . '>' );
				$this->html = new Html( $tag );
			}
		}

		if ( is_string( $args ) ) {
			$args = $this->create_from_string( $args );
		}

		if ( is_array( $args ) ) {
			$tag = data_get( $args, 'tag', $this->tag );
			$html = data_get( $args, 'html', $this->html );
			$atts = data_get( $args, 'atts', array() );
			$content = data_get( $args, 'content', $this->content );

			if ( ! empty( $html ) && is_string( $html ) ) {
				// Get the atts from the starting element
				$html_atts = $this->create_from_string( $html );
				// Merge those atts into the incoming atts array
				$atts = rwp_merge_args( $html_atts['atts'], $atts );
				$html = new Html( $html );
			}

			$defaults = $this->atts;
			$atts = rwp_merge_args( $defaults, $atts );

			$args['html'] = $html;
			$args['atts'] = rwp_collection( $atts );

			if ( is_string( $content ) ) {
				$content = array( $content );
			}

			$args['content'] = $content;

			$properties = get_object_vars( $this );
			$properties = rwp_merge_args( $properties, $args );

			foreach ( $properties as $key => $value ) {
				$this->$key = $value;
			}

			if ( empty( $this->html ) ) {
				// create an empty element from the tag just to initialize the Html class
				$tag = \force_balance_tags( '<' . \esc_attr( $this->tag ) . '>' );
				$this->html = new Html( $tag );
			}
		}

		$this->content = new Collection( $this->content );

		try {
			if ( empty( $this->tag ) ) {
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
		$tag = 'div';
		$atts = array();
		$content = null;
		$string = \force_balance_tags( $string );
		if ( is_string( $string ) && ! rwp_string_is_html( $string ) ) {
			$content = $string;
		} else {
			$html = new Html( $string );
			// if ( ! empty( $this->tag ) ) {
			// 	$html = $html->filter( $this->tag )->__toString();
			// 	$html = new Html( $html );
			// }

			$atts = $html->extractAll( true, true );
			$tag = data_get( $atts, '_name' );
			unset( $atts['_name'] );

			$content = data_get( $atts, '_text' );
			unset( $atts['_text'] );

		}
		$args = array(
			'tag' => $tag,
			'atts' => $atts,
		);

		if ( ! empty( $content ) ) {
			$args['content'] = array(
				$content,
			);
		}

		return $args;
	}


	/**
	 * Check if attribute exists in atts array
	 *
	 * @param string|string[]  $key
	 *
	 * @return bool
	 */

	public function has_attr( $key ) {
		return $this->has( "atts.$key" );
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
	 * Remove Attribute
	 *
	 * @param string|string[]  $key        The attribute(s) to remove
	 *
	 * @return void
	 */

	public function remove_attr( $key ) {
		$this->remove( "atts.$key" );
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
		if ( 'class' === $key ) {
			$this->add_class( $value );
		} else {
			$this->set( "atts.$key", $value, $overwrite );
		}

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
			$classes = $this->get_attr( 'class', array() );

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
			$classes[] = $value;
			$this->set( 'atts.class', $classes, true );
		} elseif ( is_array( $value ) ) {
			$values = $value;
			foreach ( $values as $value ) {
				$this->add_class( $value );
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
			$classes = $this->get_attr( 'class', array() );

			$index = array_search( $value, $classes, true );
			if ( false !== $index ) {
				unset( $classes[ $index ] );
				$this->set_attr( 'class', $classes );
			}
		} elseif ( is_array( $value ) ) {
			$values = $value;
			foreach ( $values as $value ) {
				$this->remove_class( $value );
			}
		}
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
		$this->remove( "attr.style.$key" );
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
		$this->remove( "content.$key" );
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
			if ( $this->content->has( $key ) && true === $overwrite ) {
				$this->content->put( $key, $value );
			} else if ( ! $this->content->has( $key ) ) {
				$this->content->put( $key, $value );
			}
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
			$this->add_sub_elements();
			if ( ! blank( $this->content ) ) {
				$content = $this->content;
				if ( is_array( $this->content ) ) {
					$content = rwp_collection( $content );
				}
				if ( rwp_is_collection( $content ) ) {
					if ( ! empty( $this->order ) ) {

						$content = rwp_collection_sort_by_keys( $content, $this->order );
					}
					$content = $content->reject(function( $item ) {
						return blank( $item );
					})->transform( function( $node ) {
						if ( ( $node instanceof Html ) || ( $node instanceof \DOMNode ) || ( $node instanceof \DOMNodeList ) || ( $node instanceof Element ) ) {
							return $node->__toString();
						} else {
							return $node;
						}
					} )->filter(function( $node, $i ) {
						$is_valid = true;
						try {
							if ( ! is_string( $node ) ) {
								$is_valid = false;
								throw new TypeException( "Content node {$i} in Element ({$this->tag}) is not a string" );
							}
						} catch ( TypeException $th ) {
							rwp_error( $th );
						}
						return $is_valid;
					});
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

	public function add_sub_elements( $elements = '' ) {
		if ( empty( $elements ) ) {
			$elements = $this->order;
		}
		if ( ! empty( $elements ) ) {
			if ( is_string( $elements ) && $this->has( $elements ) ) {
				$this->set_content( $this->$elements, $elements );
			} else if ( is_array( $elements ) ) {
				foreach ( $elements as $element ) {
					$this->add_sub_elements( $element );
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
	 * Generates the html string
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
	 * Determine if the given key exists.
	 *
	 * @param  string|string[]  $key
	 *
	 * @return bool
	 */
	public function has( $key ) {
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
	 * Map all the methods from Html class to this class
	 *
	 * @return void
	 */

	private function mapApiMethods() {

        $html_class = new ReflectionClass( Html::class );

        foreach ( $html_class->getMethods() as $m ) {
            $this->html_methods[] = $m->name;
        }

		$current_class = new ReflectionClass( $this );

		foreach ( $current_class->getMethods() as $m ) {
            $this->methods[] = $m->name;
        }
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
	 * Handle dynamic calls to the html instance to set atts.
	 *
	 * @param mixed $method
	 * @param mixed $parameters
	 * @return void|mixed
	 */
	public function __call( $method, $parameters ) {

		try {
			if ( in_array( $method, $this->html_methods ) ) {
				return $this->html->$method( ...$parameters );
			} else if ( in_array( $method, $this->methods ) ) {
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
		return $this->has( $key );
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
