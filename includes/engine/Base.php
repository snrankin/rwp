<?php
/** ============================================================================
 * Base skeleton of the plugin
 *
 * @package   RWP\Engine
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine;

use RWP\Vendor\Exceptions\Collection\KeyNotFoundException;

class Base {

	use Traits\Assets;

	/**
     * The current globally available container (if any).
     *
     * @var static
     */
    protected static $instance;

	/**
	 * @var array $settings The settings of the plugin.
	 */
	public $settings = array();

	/**
	 * @var array $options The user defined options.
	 */
	public $options = array();

	/**
	 * __construct
	 *
	 * A dummy constructor to ensure RWP is only setup once.
	 *
	 * @since   1.0.0
	 *
	 * @return  void
	 */
	public function __construct() {
		// Do nothing.
	}

	/** Initialize the class and get the plugin settings */
	public function initialize() {
		// Define constants.

		$this->settings = array(
			'name'        => __( 'RWP', 'rwp' ),
			'title'       => __( 'RIESTER Core Plugin', 'rwp' ),
			'slug'        => RWP_PLUGIN_TEXTDOMAIN,
			'version'     => RWP_PLUGIN_VERSION,
			'basename'    => RWP_PLUGIN_TEXTDOMAIN,
			'path'        => RWP_PLUGIN_ROOT,
			'file'        => RWP_PLUGIN_ABSOLUTE,
			'url'         => RWP_PLUGIN_URI,
			'capability'  => 'manage_options',
			'textdomain'  => RWP_PLUGIN_TEXTDOMAIN,
			'assets_dir'  => RWP_PLUGIN_ROOT . 'assets/',
			'assets_uri'  => RWP_PLUGIN_URI . 'assets/',
			'icon'        => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxNiAxNiIgd2lkdGg9IjFlbSIgaGVpZ2h0PSIxZW0iIGZpbGw9ImN1cnJlbnRDb2xvciI+PHBhdGggZD0iTTAgMHYxNmgxNlYwem05LjMzIDE0LjRMNy43NyA5LjFhOS40NyA5LjQ3IDAgMDEtMS4xMy4wNXY1LjI1aC0yLjJWMS42aDMuMDhjMi40NyAwIDMuNzIgMSAzLjcyIDMuNzggMCAyLjA1LS43OSAyLjg5LTEuNTQgMy4yMmwxLjg2IDUuOHoiLz48cGF0aCBkPSJNNy40MiAzLjQxaC0uNzh2My45M2guNzhjMS4xOCAwIDEuNjMtLjQ0IDEuNjMtMlM4LjYgMy40MSA3LjQyIDMuNDF6Ii8+PC9zdmc+',
		);

		$configs       = glob( RWP_PLUGIN_ROOT . '/config/*.php' );
		if ( $configs ) {
			foreach ( $configs as $config ) {
				$name                    = basename( $config, '.php' );
				$this->settings[ $name ] = require $config;
			}
		}
		$this->options = \rwp_get_options();

		$this->initialize_assets();

		$this->set( 'options.version', get_option( 'rwp-version' ) );

		$this::$instance = $this;

		return true;
	}

	/**
     * Get the globally available instance of the container.
     *
     * @return static
     */
    public static function instance() {
		if ( \is_null( static::$instance ) ) { // phpcs:ignore
            static::$instance = new static();  // phpcs:ignore
        }
        return static::$instance;
    }

	/**
     * Get plugin option.
     *
     * @param string $key     The name of the option (without the prefix)
     * @param mixed  $default The default value of the option
     *
     * @return mixed $option
     */
    public function get_option( $key, $default = null ) {
        $key = rwp_add_prefix( $key, 'options.' );
		return $this->get( $key, $default );
    }

    /**
     * Get plugin option.
     *
     * @see https://developer.wordpress.org/reference/functions/delete_option/
     *
     * @param string $name    The name of the option (without the prefix)
     *
     * @return bool
     *
     */
    public function delete_option( $name ) {
        $name = $this->prefix( $name ); // how it is stored in DB

        return delete_option( $name );
    }

    /**
     * Update plugin option.
     *
     * @link https://developer.wordpress.org/reference/functions/update_option/
     *
     * @param string $key       The key of the option (without the prefix)
     * @param mixed  $value     The default value of the option
	 * @param bool   $autoload  Optional. Whether to load the option when
	 *                          WordPress starts up.
     *
     * @return void
     */
    public function update_option( $key, $value, $autoload = true ) {
        $wp_key = $this->prefix( $key ); // how it is stored in DB

        update_option( $wp_key, $value, $autoload );

		$option_key = rwp_add_prefix( $key, 'options.' );

		$this->set( $option_key, $value );
    }

	/**
	 * Add plugin prefix to string
	 *
	 * @uses rwp_add_prefix()
	 * @uses rwp_change_case()
	 *
	 * @param string  $string     The string to prefix
	 * @param string  $separator  The string to add in between the prefix and
	 *                            the string. Defaults to '_'
	 * @param string  $case       The string case. @see rwp_change_case() for
	 *                            details
	 * @return string
	 */
    public function prefix( $string, $separator = '_', $case = '' ) {
		if ( 'title' === $case ) {
			$prefix = $this->get_setting( 'name' ) . $separator;
			$string = \rwp_add_prefix( $string, $prefix );
		} else {
			$prefix = $this->get_setting( 'slug' ) . $separator;
			$string = \rwp_add_prefix( $string, $prefix );
		}

		if ( ! empty( $case ) ) {
			$string = \rwp_change_case( $string, $case );
		}

        return $string;
    }

    /**
	 * Remove plugin prefix to string
	 *
	 * @uses rwp_remove_prefix()
	 *
	 * @param string  $string     The string to prefix
	 * @param string  $separator  The string to add in between the prefix and
	 *                            the string. Defaults to '_'
	 * @return string
	 */
    public function unprefix( $string, $separator = '_' ) {
        $prefix = $this->get_setting( 'slug' ) . $separator;
		return \rwp_remove_prefix( $string, $prefix );
    }

	/**
	 * define
	 *
	 * Defines a constant if doesnt already exist.
	 *
	 *
	 * @param string $name  The constant name.
	 * @param mixed  $value The constant value.
	 *
	 * @return void
	 */
	public function define( $name, $value = true ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Get a setting from the plugin instance.
	 *
	 * @param  string  $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	public function get_setting( $key, $default = null ) {
		$key = rwp_add_prefix( $key, 'settings.' );
		return $this->get( $key, $default );
	}

	/**
	 * Set a setting for the plugin instance.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function set_setting( $key, $value = null ) {
		$key = rwp_add_prefix( $key, 'settings.' );
		$this->set( $key, $value );
	}

	/**
	 * Get an attribute from the plugin instance.
	 *
	 * @param  string  $key
	 * @param  mixed   $default The default to use if the key is not found
	 * @return mixed   The value of the key if found else the default set
	 *
	 * @throws KeyNotFoundException Throws warning if the key does not exist
	 */
	public function get( $key, $default = null ) {
		$result = $default;
		try {
			$result = data_get( $this, $key, $default );
			if ( ! $result ) {
				throw new KeyNotFoundException( wp_sprintf( 'The key %s does not exist as a property of %s', $key, get_class() ) );
			}
		} catch ( KeyNotFoundException $th ) {
			rwp_error( $th->getMessage(), 'notice' );
		}

		return $result;

	}

	/**
     * Set an item on an array or object using dot notation.
     *
     * @param  string|array  $key
     * @param  mixed  $value
     * @param  bool  $overwrite
	 *
     * @return mixed
     */
	public function set( $key, $value, $overwrite = true ) {
		return data_set( $this, $key, $value, $overwrite );
	}

	/**
	 * Determine if the given offset exists.
	 *
	 * @param  string  $offset
	 * @return bool
	 *
	 * @throws KeyNotFoundException
	 */
	public function offsetExists( $offset ) {
		try {
			if ( rwp_object_has( $offset, $this ) ) {
				return true;
			} else {
				throw new KeyNotFoundException( wp_sprintf( 'The key %s does not exist as a property of %s', $offset, get_class() ) );
			}
		} catch ( KeyNotFoundException $th ) {
			rwp_error( $th->getMessage(), 'notice' );
		}

		return false;
	}
	/**
	 * Get the value for a given offset.
	 *
	 * @param  string  $offset
	 * @return mixed
	 */
	public function offsetGet( $offset ) {
		return $this->get( $offset );
	}
	/**
	 * Set the value at the given offset.
	 *
	 * @param  string  $offset
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet( $offset, $value ) {
		$this->$offset = $value;
	}
	/**
	 * Unset the value at the given offset.
	 *
	 * @param  string  $offset
	 * @return void
	 */
	public function offsetUnset( $offset ) {
		unset( $this->$offset );
	}
	/**
	 * Handle dynamic calls to the plugin instance to set attributes.
	 *
	 * @param  string  $method
	 * @param  array  $parameters
	 * @return $this
	 */
	public function __call( $method, $parameters ) {
		$this->$method = \count( $parameters ) > 0 ? $parameters[0] : \true;
		return $this;
	}
	/**
	 * Dynamically retrieve the value of an attribute.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get( $key ) {
		return $this->get( $key );
	}
	/**
	 * Dynamically set the value of an attribute.
	 *
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function __set( $key, $value ) {
		$this->set( $key, $value );
	}
	/**
	 * Dynamically check if an attribute is set.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function __isset( $key ) {
		return $this->offsetExists( $key );
	}
	/**
	 * Dynamically unset an attribute.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function __unset( $key ) {
		$this->offsetUnset( $key );
	}

}
