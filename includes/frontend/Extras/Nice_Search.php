<?php
/** ============================================================================
 * Nice_Search
 *
 * @package   RWP\/includes/frontend/Extras/Nice_Search.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Frontend\Extras;

use RWP\Engine\Abstracts\Singleton;
use RWP\Components\Html;

class Nice_Search extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( rwp_get_option( 'modules.enable_nice_search', false ) ) {
			add_action( 'template_redirect', array( $this, 'redirect' ) );
			add_filter( 'wpseo_json_ld_search_url', array( $this, 'rewrite' ) );
		}

		if ( rwp_get_option( 'modules.bootstrap.search', false ) ) {
			\add_filter( 'get_search_form', array( $this, 'bootstrap_search' ), 10, 1 );
		}
	}

	/**
	 * Redirects search results from /?s=query to /search/query/, converts %20 to +
	 * @return void
	 */

	public function redirect() {
		global $wp_rewrite;
		if ( ! isset( $wp_rewrite ) || ! is_object( $wp_rewrite ) || ! $wp_rewrite->get_search_permastruct() ) {
			return;
		}

		$search_base = $wp_rewrite->search_base;
		if ( is_search() && ! is_admin() && strpos( $_SERVER['REQUEST_URI'], "/{$search_base}/" ) === false && strpos( $_SERVER['REQUEST_URI'], '&' ) === false ) { //phpcs:ignore
			wp_redirect( get_search_link() );
			exit();
		}
	}

	/**
	 * Updates Yoast SEO meta for searches
	 *
	 * @param mixed $url
	 * @return mixed
	 */

	public function rewrite( $url ) {
		return str_replace( '/?s=', '/search/', $url );
	}

	/**
	 * Converts the default Wordpress Search Form to a Bootstrap 5 form
	 *
	 * @param string $form
	 *
	 * @return string
	 */
	public function bootstrap_search( $form ) {

		$form = rwp_html( $form );

		$label = '<label class="visually-hidden" for="s">' . $form->filter( 'label > span' )->text() . '</label>';

		$input = $form->filter( 'input.search-field' )->addClass( 'form-control' )->saveHTML();

		$btn = $form->filter( 'input.search-submit' )->saveHTML();

		$btn = rwp_input_to_button( $btn );

		$btn = $btn->html();

		$form->makeEmpty();

		$form->append( $label )->append( $input )->append( $btn );

		/**
		 * Filters the search form output
		 *
		 * Should return an Html class
		 *
		 * @var Html $form
		 */
		$form = apply_filters( 'rwp_search_form_html', $form );

		/**
		 * @var Html $form
		 */

		return $form->saveHTML();
	}

}
