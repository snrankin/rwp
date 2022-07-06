<?php
/** ============================================================================
 * Request
 *
 * @package   RWP\/includes/engine/Traits/Request.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2022 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

 namespace RWP\Engine\Traits;

use RWP\Engine\Context;

trait Request {
	/**
	 * @var Context
	 */
	public $context;

	/**
	 *
	 * @var string Current Context
	 */
	public $request;

	/**
	 * What type of request is this?
	 *
	 * @since 0.9.0
	 * @param  string $type admin, ajax, cron, cli, amp or frontend.
	 * @return bool
	 */
	public function request_is( string $type ) {
		if ( $this->context instanceof Context ) {
			switch ( $type ) {
				case 'backend':
                    return $this->context->is_backend();

				case 'ajax':
                    return $this->context->is_ajax();

				case 'installing_wp':
                    return $this->context->is_installing();

				case 'rest':
                    return $this->context->is_rest();

				case 'cron':
                    return $this->context->is_cron();

				case 'frontend':
                    return $this->context->is_frontend();

				case 'elementor':
                    return $this->context->is_elementor();

				case 'cli':
                    return $this->context->is_wp_cli();

				default:
					\_doing_it_wrong( __METHOD__, \esc_html( \sprintf( 'Unknown request type: %s', $type ) ), '0.9.0' );

                    return false;
			}
		} else {
			return false;
		}

	}

	/**
	 * Returns context
	 * @return string
	 */
	public function request() {
		if ( $this->context->is_backend() ) {
			return 'backend';
		}

		if ( $this->context->is_ajax() ) {
			return 'ajax';
		}
		if ( $this->context->is_installing() ) {
			return 'installing_wp';
		}
		if ( $this->context->is_rest() ) {
			return 'rest';
		}
		if ( $this->context->is_cron() ) {
			return 'cron';
		}
		if ( $this->context->is_frontend() ) {
			return 'frontend';
		}
		if ( $this->context->is_elementor() ) {
			return 'elementor';
		}
		if ( $this->context->is_wp_cli() ) {
			return 'cli';
		}

        return '';

	}
}
