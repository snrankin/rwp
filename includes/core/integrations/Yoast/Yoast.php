<?php

/** ============================================================================
 * Yoast SEO Customization
 *
 * @package   RWP\Integrations
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations\Yoast;

use RWP\Base\Singleton;

/**
 * Fake Pages inside WordPress
 */
class Yoast extends Singleton {

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		if ( ! function_exists( 'is_plugin_active' ) || ! is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
			return;
		}

		$this->init_seo();

		if ( rwp_get_option( 'modules.yoast.update_url', false ) ) {
			\add_filter( 'wpseo_schema_webpage_type', array( $this, 'update_page_type' ), 2, 1 );
		}

		if ( rwp_get_option( 'modules.yoast.bootstrap_breadcrumbs', false ) ) {
			//add_theme_support('yoast-seo-breadcrumbs');
			add_filter( 'wpseo_breadcrumb_links', array( $this, 'full_path' ), 5, 1 );
			add_filter('wpseo_breadcrumb_output_wrapper', function () {
				return 'ol';
			});
			add_filter('wpseo_breadcrumb_single_link_wrapper', function () {
				return 'li';
			});
			add_filter('wpseo_breadcrumb_output_class', function () {
				return 'breadcrumb';
			});
			add_filter('wpseo_breadcrumb_separator', function () {
				return '';
			});
			add_filter( 'wpseo_breadcrumb_single_link', array( $this, 'bootstrap_breadcrumbs' ), 20, 2 );
		}

		if ( rwp_get_option(
			'modules.yoast.bootstrap_faqs',
			false
		) ) {
			add_filter( 'render_block', array( $this, 'faq_accordion' ), 20, 2 );
		}

		/**
		 * Adds Schema pieces to our output.
		 *
		 * @param array                 $pieces  Graph pieces to output.
		 * @param \WPSEO_Schema_Context $context Object with context variables.
		 *
		 * @return array Graph pieces to output.
		 */

		add_filter('wpseo_schema_graph_pieces', function ( $pieces, $context ) {
			$organization = new Generators\Locations( $context );
			foreach ( $pieces as $key => $value ) {
				if ( $value instanceof \Yoast\WP\SEO\Generators\Schema\Organization ) {
					$pieces[ $key ] = $organization;
				}
			}

			return $pieces;
		}, 11, 2);

		add_action('admin_init', function () {
			if ( post_type_exists( 'rwp_team_member' ) ) {
				\WPSEO_Options::set( 'schema-page-type-rwp_team_member', 'ProfilePage' );
			}
		}, 20);
	}

	public function init_seo() {
		if ( true === WP_DEBUG ) {
			\add_filter( 'yoast_seo_development_mode', '__return_true' );
		}
	}

	/**
	 * Updating Yoast breadcrumbs to include full path
	 * @link http://plugins.svn.wordpress.org/wordpress-seo/trunk/frontend/class-breadcrumbs.php
	 * @see http://wordpress.stackexchange.com/questions/100012/how-to-add-a-page-to-the-yoast-breadcrumbs
	 */

	public function full_path( $links ) {

		$ancestors = rwp_post_ancestors();

		if ( $ancestors->isNotEmpty() ) {

			$links = $ancestors->transform(function ( $item ) {
				if ( rwp_array_has( 'title', $item ) ) {
					$item['text'] = $item['title'];
				}
				return $item;
			})->all();
		}

		return $links;
	}

	public function bootstrap_breadcrumbs( $link_output, $link ) {

		$title = '';
		$href = '';
		$active = false;

		if ( rwp_array_has( 'text', $link ) ) {
			$title = $link['text'];
		}

		if ( rwp_array_has( 'url', $link ) ) {
			$href = rwp_relative_url( $link['url'] );
		}

		if ( preg_match( '/aria-current/', $link_output ) ) {
			$active = true;
		}

		if ( $active ) {
			$link_output = '<li class="breadcrumb-item active" aria-current="page">' . $title . '</li>';
		} else {
			$link_output = '<li class="breadcrumb-item"><a href="' . $href . '">' . $title . '</a></li>';
		}

		return $link_output;
	}

	public function update_page_type( $data ) {
		$current_url = data_get( $_SERVER, 'REQUEST_URI' );
		$slug        = wp_parse_url( $current_url, PHP_URL_PATH );
		$slug        = explode( '/', $slug );
		$slug        = reset( $slug );
		$schema_type = $data;
		if ( rwp_str_has( $current_url, 'faq' ) ) {
			$schema_type = 'FAQPage';
		} elseif ( rwp_str_has( $current_url, array( 'people', 'team' ) ) ) {
			if ( is_singular() ) {
				$schema_type = 'ProfilePage';
			} else {
				$schema_type = 'CollectionPage';
			}
		} elseif ( is_page() ) {
			if ( rwp_str_has( $slug, array( 'about' ) ) ) {
				$schema_type = 'AboutPage';
			} elseif ( rwp_str_has( $slug, array( 'contact' ) ) ) {
				$schema_type = 'ContactPage';
			} else {
				$schema_type = 'WebPage';
			}
		} elseif ( is_post_type_archive() ) {
			$schema_type = 'CollectionPage';
		} elseif ( is_singular() ) {
			if ( is_singular( 'post' ) ) {
				$schema_type = 'BlogPosting';
			} elseif ( is_singular( 'press' ) ) {
				$schema_type = 'NewsArticle';
			} elseif ( is_singular( 'rwp_team_member' ) ) {
				$schema_type = 'ProfilePage';
			} else {
				$schema_type = 'ItemPage';
			}
		} elseif ( is_search() ) {
			$schema_type = 'SearchResultsPage';
		} else {
			$schema_type = 'WebPage';
		}
		$data = [ $schema_type ];
		return $data;
	}

	public function faq_accordion( $block_content = '', $block = [] ) {
		if ( 'yoast/faq-block' !== $block['blockName'] ) {
			return $block_content;
		}
		if ( ! empty( $block_content ) ) {

			$questions_markup = rwp_extract_html_elements( $block_content, '.schema-faq-section' );

			$questions = $block['attrs']['questions'];

			if ( ! empty( $questions ) ) {
				$panels = rwp_element( rwp_extract_html_attributes( $block_content, '.schema-faq', true ) );
				$panels->add_class( array( 'accordion', 'accordion-flush' ) );
				foreach ( $questions as $i => $question ) {
					$markup = $questions_markup[ $i ];
					$panel_atts = rwp_extract_html_attributes( $markup, '.schema-faq-section', true );

					$title =
						rwp_extract_html_elements( $markup, '.schema-faq-question' );

					$title = rwp_html( $title[0] )->text();

					$title = rwp_button(array(

						'text' => $title,
						'atts' => array(
							'data-bs-toggle' => 'collapse',
							'data-bs-target' => '#' . $question['id'] . '-answer',
							'class'          => 'accordion-button collapsed',
							'aria-expanded'  => false,
							'aria-controls'  => $question['id'] . '-answer',
						),
					));

					$title->remove_class( 'btn' );

					$title = rwp_element(array(
						'tag'     => 'h3',
						'content' => $title->html(),
						'atts'    => array(
							'id'    => $question['id'] . '-question',
							'class' => 'accordion-header schema-faq-question',
						),
					))->html();

					$panel_atts['content'] = [ $title ];

					$answer =
						rwp_extract_html_elements( $markup, '.schema-faq-answer' );

					$answer = rwp_element(array(
						'tag'     => 'div',
						'content' => '<div class="accordion-body">' . $answer[0] . '</div>',
						'atts'    => array(
							'id'              => $question['id'] . '-answer',
							'class'           => 'accordion-collapse collapse',
							'aria-labelledby' => $question['id'] . '-question',
						),
					))->html();

					$panel_atts['content'][] = $answer;

					$panel = rwp_element( $panel_atts );

					$panel->add_class( 'accordion-item' );

					$panel = $panel->html();

					$panels->set_content( $panel );
				}
				$block_content = $panels->html();
			}
		}
		return $block_content;
	}
}
