<?php

/** ============================================================================
 * Blocks
 *
 * @package RIESTERWP Plugin\/includes/core/Traits/Blocks.php
 * @version 0.1.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Traits;

use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Components\{Html, SchemaItem, Media, Grid, Row, Column};

trait Blocks {
	/**
	 * The registered blocks
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array|Collection $blocks
	 */

	protected $blocks = [];

	public function init_blocks() {

		/**
		 * @var false|Collection $manifest
		 */
		$manifest = $this->manifest;
		if ($manifest) {
			$blocks_keys = $manifest->keys()->filter(function ($key) {
				return rwp_str_ends_with($key, '.php');
			})->transform(function ($item) {
				$item = rwp_basename($item);
				return $item;
			})->all();
			$blocks_keys = $manifest->keys()->filter(function ($key) use ($blocks_keys) {
				$key = rwp_basename($key);
				return in_array($key, $blocks_keys);
			});
			$blocks = $manifest->only($blocks_keys);
			$blocks = $blocks->groupBy(function ($file, $key) {
				$key = rwp_basename($key);
				$this->unprefix($key);
				return $key;
			});

			if ($blocks->isNotEmpty()) {
				$blocks->each(function ($item, $block) {

					$block = $this->unprefix($block);
					/**
					 * @var Collection $item
					 */
					$css = $item->filter(function ($key) {
						return rwp_str_ends_with($key, '.css');
					})->first();
					$js = $item->filter(function ($key) {
						return rwp_str_ends_with($key, '.js');
					})->first();
					$php = $item->filter(function ($key) {
						return rwp_str_ends_with($key, '.php');
					})->first();

					if (!empty($php)) {
						$folder = dirname($php);
						$php = basename($php);
						$files = rwp_get_plugin_file($php, $this->assets_folder . $folder);
					} else {
						$files = array();
					}



					$block_name = $this->prefix($block, 'kebab');

					$block_args = array(
						'editor_script'   => $block_name,
						'apiVersion'      => 2,
						'files'    => [
							'script' => [
								'handle'   => $block,
							]
						]
					);

					if (rwp_array_has('dependencies', $files)) {
						$block_args['files']['script']['deps'] = $files['dependencies'];
					}

					if (!empty($css)) {
						$block_args['editor_style'] = $block_name;
						$block_args['files']['style'] = array(
							'handle'   => $block,
						);
					}


					if (rwp_array_has('version', $files)) {
						$block_args['files']['script']['ver'] = $files['version'];
						if (!empty($css)) {
							$block_args['files']['style']['ver'] = $files['version'];
						}
					}


					$this->blocks->put($this->prefix($block, 'slash'), $block_args);
				});
			}
		}
		$this->add_filter('block_categories', $this, 'add_block_category', 10, 2);
		$this->add_filter('render_block', $this, 'section_block_filter', 20, 2);
		$this->add_action('init', $this, 'register_block_types');
	}

	public function register_block_types() {
		if ($this->blocks->isNotEmpty()) {
			$this->blocks->each(function ($args, $block) {
				$files = $args['files'];
				unset($args['files']);
				$this->register_script($files['script']);
				if (rwp_array_has('style', $files)) {
					$this->register_style($files['style']);
				}

				register_block_type($block, $args);
			});
		}
	}

	public function section_block_filter($block_content, $block) {
		if ('rwp/section' !== $block['blockName']) {
			return $block_content;
		}
		if (!empty($block_content)) {
			$section = rwp_extract_html_atts($block_content);

			$sectionInner = rwp_extract_html_atts($section['content']);

			unset($section['content']);

			$section['inner'] = $sectionInner;

			if (rwp_array_has('bgImageId', $block['attrs']) && $block['attrs']['bgImageId'] != 0) {
				$section['background']['src'] = $block['attrs']['bgImageId'];
			}
			$section = rwp_section($section);
			$block_content = $section->__toString();
		}
		return $block_content;
	}

	public function add_block_category($categories, $post) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => $this->prefix,
					'title' => $this->name,
					'icon'  => $this->icon,
				),
			)
		);
	}
}
