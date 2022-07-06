<?php
/** ============================================================================
 * Context
 *
 * A single-class utility to check the current request context in WordPress sites.
 * Taken from Inpsyde\WpContext with a few modifications
 *
 * @package   RWP\/includes/engine/Context.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2022 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

declare(strict_types=1);

namespace RWP\Engine;

class Context implements \JsonSerializable {

	public const AJAX = 'ajax';
	public const BACKOFFICE = 'backoffice';
	public const CLI = 'wpcli';
	public const CORE = 'core';
	public const CRON = 'cron';
	public const FRONTOFFICE = 'frontoffice';
	public const ELEMENTOR = 'elementor';
	public const INSTALLING = 'installing';
	public const LOGIN = 'login';
	public const REST = 'rest';
	public const XML_RPC = 'xml-rpc';
	public const WP_ACTIVATE = 'wp-activate';

	private const ALL = [
		self::AJAX,
		self::BACKOFFICE,
		self::CLI,
		self::CORE,
		self::CRON,
		self::ELEMENTOR,
		self::FRONTOFFICE,
		self::INSTALLING,
		self::LOGIN,
		self::REST,
		self::XML_RPC,
		self::WP_ACTIVATE,

	];

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $action_callbacks = [];

    /**
     * @return Context
     */
	final public static function new(): Context {
		return new self( array_fill_keys( self::ALL, false ) );
	}

    /**
     * @return Context
     */
	final public static function determine(): Context {
		$installing = defined( 'WP_INSTALLING' ) && WP_INSTALLING;
		$xml_rpc = defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST;
		$is_core = defined( 'ABSPATH' );
		$is_cli = defined( 'WP_CLI' );
		$not_installing = $is_core && ! $installing;
		$is_ajax = $not_installing && wp_doing_ajax();
		$is_admin = $not_installing && is_admin() && ! $is_ajax;
		$is_cron = $not_installing && wp_doing_cron();
		$is_wp_activate = $installing && is_multisite() && self::is_wp_activate_request();

		$undetermined = $not_installing && ! $is_admin && ! $is_cron && ! $is_cli && ! $xml_rpc && ! $is_ajax;

		$is_rest = $undetermined && static::is_rest_request();
		$is_login = $undetermined && ! $is_rest && static::is_login_request();

		// When nothing else matches, we assume it is a front-office request.
		$is_front = $undetermined && ! $is_rest && ! $is_login;

		$is_elementor = false;

		if ( is_plugin_active( 'elementor/elementor.php' ) && class_exists( '\\Elementor\\Plugin' ) ) {
			$is_elementor = \Elementor\Plugin::$instance->preview->is_preview_mode();

		}

        /*
		* Note that when core is installing **only** `INSTALLING` will be true, not even `CORE`.
		* This is done to do as less as possible during installation, when most of WP does not act
		* as expected.
		*/

        $instance = new self(
		[
			self::AJAX => $is_ajax,
			self::BACKOFFICE => $is_admin,
			self::CLI => $is_cli,
			self::CORE => ( $is_core || $xml_rpc ) && ( ! $installing || $is_wp_activate ),
			self::CRON => $is_cron,
			self::ELEMENTOR => $is_elementor,
			self::FRONTOFFICE => $is_front,
			self::INSTALLING => $installing && ! $is_wp_activate,
			self::LOGIN => $is_login,
			self::REST => $is_rest,
			self::XML_RPC => $xml_rpc && ! $installing,
			self::WP_ACTIVATE => $is_wp_activate,
		]
		);

		$instance->add_action_hooks();

		return $instance;
    }

    /**
     * @return bool
     */
    private static function is_rest_request(): bool {
        if (
            ( defined( 'REST_REQUEST' ) && REST_REQUEST )
            || !empty($_GET['rest_route']) // phpcs:ignore
        ) {
            return true;
        }

        if ( ! get_option( 'permalink_structure' ) ) {
            return false;
        }

        /*
         * This is needed because, if called early, global $wp_rewrite is not defined but required
         * by get_rest_url(). WP will reuse what we set here, or in worst case will replace, but no
         * consequences for us in any case.
         */
        if ( empty( $GLOBALS['wp_rewrite'] ) ) {
            $GLOBALS['wp_rewrite'] = new \WP_Rewrite(); // phpcs:ignore
        }

        $current_path = trim( (string) parse_url( (string) add_query_arg( [] ), PHP_URL_PATH ), '/' ) . '/';
        $rest_path = trim( (string) parse_url( (string) get_rest_url(), PHP_URL_PATH ), '/' ) . '/';

        return strpos( $current_path, $rest_path ) === 0;
    }

    /**
     * @return bool
     */
    private static function is_login_request(): bool {
        if (!empty($_REQUEST['interim-login'])) { // phpcs:ignore
            return true;
        }

        return static::is_page_now( 'wp-login.php', wp_login_url() );
    }

    /**
     * @return bool
     */
    private static function is_wp_activate_request(): bool {
        return static::is_page_now( 'wp-activate.php', network_site_url( 'wp-activate.php' ) );
    }

    /**
     * @param string $page
     * @param string $url
     * @return bool
     */
    private static function is_page_now( string $page, string $url ): bool {
        $page_now = (string) ( $GLOBALS['pagenow'] ?? '' );
        if ( $page_now && ( basename( $page_now ) === $page ) ) {
            return true;
        }

        $current_path = (string) parse_url( add_query_arg( [] ), PHP_URL_PATH );
        $target_path = (string) parse_url( $url, PHP_URL_PATH );

        return trim( $current_path, '/' ) === trim( $target_path, '/' );
    }

    /**
     * @param array $data
     */
    private function __construct( array $data ) {
        $this->data = $data;
    }

    /**
     * @param string $context
     * @return Context
     */
    final public function force( string $context ): Context {
        if ( ! in_array( $context, self::ALL, true ) ) {
            throw new \LogicException( "'{$context}' is not a valid context." );
        }

        $this->remove_action_hooks();

        $data = array_fill_keys( self::ALL, false );
        $data[ $context ] = true;
        if ( ! in_array( $context, [ self::INSTALLING, self::CLI, self::CORE ], true ) ) {
            $data[ self::CORE ] = true;
        }

        $this->data = $data;

        return $this;
    }

    /**
     * @return Context
     */
    final public function with_cli(): Context {
        $this->data[ self::CLI ] = true;

        return $this;
    }

    /**
     * @param string $context
     * @param string ...$contexts
     * @return bool
     */
    final public function is( string $context, string ...$contexts ): bool {
        array_unshift( $contexts, $context );

        foreach ( $contexts as $context ) {
            if ( ( $this->data[ $context ] ?? null ) ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function is_core(): bool {
        return $this->is( self::CORE );
    }

    /**
     * @return bool
     */
    public function is_frontend(): bool {
        return $this->is( self::FRONTOFFICE );
    }

    /**
     * @return bool
     */
    public function is_backend(): bool {
        return $this->is( self::BACKOFFICE );
    }

	/**
     * @return bool
     */
    public function is_elementor(): bool {
        return $this->is( self::ELEMENTOR );
    }

    /**
     * @return bool
     */
    public function is_ajax(): bool {
        return $this->is( self::AJAX );
    }

    /**
     * @return bool
     */
    public function is_login(): bool {
        return $this->is( self::LOGIN );
    }

    /**
     * @return bool
     */
    public function is_rest(): bool {
        return $this->is( self::REST );
    }

    /**
     * @return bool
     */
    public function is_cron(): bool {
        return $this->is( self::CRON );
    }

    /**
     * @return bool
     */
    public function is_wp_cli(): bool {
        return $this->is( self::CLI );
    }

    /**
     * @return bool
     */
    public function is_xml_rpc(): bool {
        return $this->is( self::XML_RPC );
    }

    /**
     * @return bool
     */
    public function is_installing(): bool {
        return $this->is( self::INSTALLING );
    }

    /**
     * @return bool
     */
    public function is_wp_activate(): bool {
        return $this->is( self::WP_ACTIVATE );
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array {
        return $this->data;
    }

    /**
     * When context is determined very early we do our best to understand some context like
     * login, rest and front-office even if WordPress normally would require a later hook.
     * When that later hook happen, we change what we have determined, leveraging the more
     * "core-compliant" approach.
     *
     * @return void
     */
    private function add_action_hooks(): void {
        $this->action_callbacks = [
            'login_init' => function (): void {
                $this->reset_and_force( self::LOGIN );
            },
            'rest_api_init' => function (): void {
                $this->reset_and_force( self::REST );
            },
            'activate_header' => function (): void {
                $this->reset_and_force( self::WP_ACTIVATE );
            },
            'template_redirect' => function (): void {
                $this->reset_and_force( self::FRONTOFFICE );
            },
            'current_screen' => function ( \WP_Screen $screen ): void {
                $screen->in_admin() && $this->reset_and_force( self::BACKOFFICE );
            },
        ];

        foreach ( $this->action_callbacks as $action => $callback ) {
            add_action( $action, $callback, PHP_INT_MIN );
        }
    }

    /**
     * When "force" is called on an instance created via `determine()` we need to remove added hooks
     * or what we are forcing might be overridden.
     *
     * @return void
     */
    private function remove_action_hooks(): void {
        foreach ( $this->action_callbacks as $action => $callback ) {
            remove_action( $action, $callback, PHP_INT_MIN );
        }
        $this->action_callbacks = [];
    }

    /**
     * @param string $context
     * @return void
     */
    private function reset_and_force( string $context ): void {
        $cli = $this->is_wp_cli();
        $this->force( $context );
        $cli && $this->with_cli();
    }
}
