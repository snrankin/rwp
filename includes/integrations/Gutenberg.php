<?php
/** ============================================================================
 * Gutenberg
 *
 * @package   RWP\/includes/integrations/Gutenberg.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations;

use RWP\Engine\Abstracts\Singleton;
use RWP\Components\Collection;

class Gutenberg extends Singleton {

	/**
	 * The registered blocks
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Collection $blocks
	 */

	protected $blocks;


	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {

		// \add_filter( 'block_categories', $this, 'add_block_category', 10, 2 );
		// \add_filter( 'render_block', $this, 'section_block_filter', 20, 2 );
		\add_action( 'init', array( $this, 'register_block_types' ) );

	}

	public function init_blocks() {

		if ( ! rwp_is_collection( $this->blocks ) ) {
			$this->blocks = rwp_collection();
		}

		/**
		 * @var false|Collection $manifest
		 */
		$manifest = rwp()->get( 'assets.manifest' );
		if ( rwp_is_collection( $manifest ) ) {
			$blocks_keys = $manifest->keys()->filter(function ( $key ) {
				return rwp_str_ends_with( $key, '.php' );
			})->transform(function ( $item ) {
				$item = rwp_basename( $item );
				return $item;
			})->unique()->all();

			$blocks_keys = $manifest->keys()->filter(function ( $key ) use ( $blocks_keys ) {
				$key = rwp_basename( $key );
				return in_array( $key, $blocks_keys );
			});
			$blocks = $manifest->only( $blocks_keys );
			$blocks = $blocks->groupBy(function ( $file, $key ) {
				$key = rwp_basename( $key );
				$this->unprefix( $key );
				return $key;
			});

			if ( $blocks->isNotEmpty() ) {
				$blocks->each(function ( $item, $block ) {

					$block = rwp()->unprefix( $block );
					/**
					 * @var Collection $item
					 */
					$css = $item->filter(function ( $key ) {
						return rwp_str_ends_with( $key, '.css' );
					})->first();
					$js = $item->filter(function ( $key ) {
						return rwp_str_ends_with( $key, '.js' );
					})->first();
					$php = $item->filter(function ( $key ) {
						return rwp_str_ends_with( $key, '.php' );
					})->first();

					if ( ! empty( $php ) ) {
						$folder = dirname( $php );
						$php = basename( $php );
						$files = rwp_get_plugin_file( $php, "assets/$folder" );
					} else {
						$files = array();
					}

					$block_name = rwp()->prefix( $block, '-', 'slug' );

					$block_args = array(
						'editor_script'   => $block_name,
						'apiVersion'      => 2,
						'files'    => [
							'script' => [
								'handle'   => $block,
							],
						],
					);

					if ( rwp_array_has( 'dependencies', $files ) ) {
						$block_args['files']['script']['deps'] = $files['dependencies'];
					}

					if ( ! empty( $css ) ) {
						$block_args['editor_style'] = $block_name;
						$block_args['files']['style'] = array(
							'handle'   => $block,
						);
					}

					if ( rwp_array_has( 'version', $files ) ) {
						$block_args['files']['script']['ver'] = $files['version'];
						if ( ! empty( $css ) ) {
							$block_args['files']['style']['ver'] = $files['version'];
						}
					}

					$this->blocks->put( rwp()->prefix( $block, '/', 'slug' ), $block_args );
				});
			}
		}
	}

	public function register_block_types() {
		$this->init_blocks();
		if ( $this->blocks->isNotEmpty() ) {
			$this->blocks->each(function ( $args, $block ) {
				$files = $args['files'];
				unset( $args['files'] );

				rwp()->register_script( $files['script'] );
				if ( rwp_array_has( 'style', $files ) ) {
					rwp()->register_style( $files['style'] );
				}

				register_block_type( $block, $args );
			});
		}
	}
}
