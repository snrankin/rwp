<?php

/** ============================================================================
 * RIESTER menu [@TODO Fill out summary for menu.php (no period for file headers)]
 *
 * [@TODO Fill out description for menu.php. (use period)]
 *
 * @link [@TODO Fill out url]
 *
 * @package WordPress
 * @subpackage RIESTER
 * @since RIESTER 0.1.0
 * ========================================================================== */

use RWP\Components\NavItem;

/**
 * Get menu by theme location or name of menu
 *
 * @var string    $menu
 *
 * @return WP_Term|false False if $menu param isn't supplied or term does not exist, menu object if successful.
 */

function rwp_get_menu($menu = '') {

	// Get the nav menu based on the theme_location.
	$locations = get_nav_menu_locations();

	if (!empty($menu) && rwp_array_has($menu, $locations)) {
		$menu = $locations[$menu];
	}

	// Get the nav menu based on the requested menu.
	$menu = wp_get_nav_menu_object($menu);

	return $menu;
}

function rwp_menu_args($args = []) {

	$custom_args  = [];

	$args = rwp_collection($args);

	// Get the nav menu based on the requested menu.

	$menu = '';
	if ($args->has('menu') && !empty($args->get('menu'))) {
		$menu = $args->get('menu');
	} else if ($args->has('theme_location') && !empty($args->get('theme_location'))) {
		$menu = $args->get('theme_location');
	}
	$menu_term = rwp_get_menu($menu);

	if ($menu_term->slug === 'primary_navigation') {
		$test = true;
	}

	$wp_defaults = rwp_collection([
		'menu'                 => '',
		'container'            => 'div',
		'container_class'      => '',
		'container_id'         => '',
		'container_aria_label' => '',
		'menu_class'           => 'menu',
		'menu_id'              => '',
		'echo'                 => true,
		'fallback_cb'          => 'wp_page_menu',
		'before'               => '',
		'after'                => '',
		'link_before'          => '',
		'link_after'           => '',
		'items_wrap'           => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'item_spacing'         => 'preserve',
		'depth'                => 0,
		'walker'               => '',
		'theme_location'       => '',
	]);

	$menu_fields = rwp_get_field('nav_options', $menu_term);

	$menu_class = rwp_get_option($menu_fields, 'menu_class', '', $menu_term);
	$container_class = rwp_get_option($menu_fields, 'container_class', '', $menu_term);

	if (rwp_is_collection($menu_fields)) {

		if ($menu_fields->has('toggle')) {
			$toggle = $menu_fields->pull('toggle')->all();
			if (rwp_array_has('button', $toggle)) {
				$toggle = $toggle['button'];
				$args->toggle = $toggle;
			}
		}


		$args = $args->merge($menu_fields);
	}

	$custom_args = $args->diffKeys($wp_defaults);

	if ($custom_args->isNotEmpty()) {
		$args = $args->forget($custom_args->keys()->all());
	}
	$args = $wp_defaults->replace($args);


	if ($args->has('menu_class') && !empty($args->get('menu_class'))) {

		$menu_class = rwp_merge_classes($args->get('menu_class'), $menu_class);
	}

	if ($args->has('container_class') && !empty($args->get('container_class'))) {

		$container_class = rwp_merge_classes($args->get('container_class'), $container_class);
	}

	$container_id = '';

	if ($args->has('container_id')) {

		$container_id = $args->pull('container_id');
	}

	if (empty($container_id)) {
		$container_id = '%1$s-wrapper';
	}

	if ($args->has('container_label')) {

		$container_label = $args->pull('container_aria_label');
	}

	if (empty($container_label) && rwp_object_has('name', $menu_term)) {
		$container_label = $menu_term->name;
	}

	$new_args = [
		'wp_menu'     => $menu_term,
		'list' => [
			'atts' => [
				'id'    => '%1$s',
				'class' => $menu_class
			]
		],
		'atts' => [
			'id' => $container_id,
			'class' => $container_class,
			'aria-label' => $container_label,
		]
	];


	if (!empty($custom_args)) {
		$new_args = rwp_merge_args($new_args, $custom_args->all());
	}


	// Adding Custom arguments for navwalker

	$new_args['menu'] = $menu_term;

	$menu = rwp_nav($new_args);

	$menu->list->addClass('%2$s', false);

	$start_tag = null;
	$end_tag = null;
	if ($args->get('items_wrap') !== false) {
		if ($args->get('container') !== false) {
			$start_tag = $menu->navStartTag();
			$end_tag = $menu->navEndTag();
		} else {
			$start_tag = $menu->list->startTag();
			$end_tag = $menu->list->endTag();
		}
	}

	$items_wrap = $start_tag . '%3$s' . $end_tag;

	$args->put('container_class', '');
	$args->put('menu_class', '');
	$args->put('container_id', '');
	$args->put('container', '');
	$args->put('items_wrap', $items_wrap);
	$args->put('walker', new \RWP\Components\NavWalker());
	$args->put('fallback_cb', '\RWP\Components\NavWalker::fallback');

	$args = $args->all();

	return $args;
}


function rwp_page_menu_args($args = []) {

	$defaults = rwp_collection([
		'container'    => true,
		'items_wrap'   => true,
	]);

	$wp_defaults = rwp_collection([
		'authors'      => '',
		'child_of'     => 0,
		'date_format'  => get_option('date_format'),
		'depth'        => 0,
		'echo'         => 0,
		'exclude_tree' => array(),
		'exclude'      => '',
		'exclude'      => array(),
		'hierarchical' => 1,
		'include'      => array(),
		'item_spacing' => 'preserve',
		'link_after'   => '',
		'link_before'  => '',
		'meta_key'     => '',
		'meta_value'   => '',
		'number'       => '',
		'offset'       => 0,
		'parent'       => -1,
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'show_date'    => '',
		'sort_column'  => 'menu_order, post_title',
		'sort_order'   => 'ASC',
		'toggle'       => [],
		'child_type'   => '',
		'title_li'     => '',
		'container'    => true,
		'items_wrap'   => true,
		'walker'       => new \RWP\Components\PageWalker(),
	]);

	$args = rwp_collection($args);

	$custom_args = $args->diffKeys($wp_defaults);

	if ($custom_args->isNotEmpty()) {
		$args->forget($custom_args->keys()->all());
	}

	$custom_args = $defaults->merge($custom_args);
	$args = $wp_defaults->merge($args);


	//$custom_args = $custom_args->all();
	$menu_id = 'page-menu';
	if ($args->has('menu_id') && !empty($args->get('menu_id'))) {
		$menu_id = $args->get('menu_id');
	} elseif ($args->has('child_of') && !empty($args->get('child_of'))) {
		if ($custom_args->has('menu_depth') && $custom_args->get('menu_depth') > 0) {
			$menu_id = 'submenu';
		}
		$menu_id .= '-' . $args->get('child_of');
	} else if ($args->has('parent') && !empty($args->get('parent'))) {
		$parent = $args->get('parent');

		if ($custom_args->has('menu_depth') && $custom_args->get('menu_depth') > 0) {
			$menu_id = 'submenu';
		}

		$menu_id .= '-' . rwp_id($parent);
	}
	$custom_args->put('id', $menu_id);



	// Adding Custom arguments for navwalker

	$menu = rwp_nav($custom_args->all());

	$start_tag = null;
	$end_tag = null;
	if ($custom_args->has('container') && $custom_args->get('container') !== false) {
		$start_tag = $menu->navStartTag();
		$end_tag = $menu->navEndTag();
	} else {
		$start_tag = $menu->list->startTag();
		$end_tag = $menu->list->endTag();
	}

	// $items_wrap = $start_tag . '%3$s' . $end_tag;

	$args->put('start_tag', $start_tag);
	$args->put('end_tag', $end_tag);


	$args = apply_filters('rwp_page_nav_args', $args);

	$args = $args->all();

	return $args;
}

function rwp_get_children_menu($parent = null, $args = []) {
	$parent = rwp_post_object($parent);

	if (!rwp_array_has('child_of', $args)) {
		$args['child_of'] = $parent['id'];
		$args['menu_parent'] = $parent['id'];
	}

	$args = rwp_page_menu_args($args);

	$menu = wp_list_pages($args);

	if (rwp_array_has('items_wrap', $args) && $args['items_wrap'] !== false) {
		$menu = $args['start_tag'] . $menu . $args['end_tag'];
	}

	return $menu;
}

function rwp_taxonomy_archive_link($taxonomy) {
	if (!in_array('post', $taxonomy->object_type, true) && !in_array('page', $taxonomy->object_type, true)) {
		foreach ($taxonomy->object_type as $object_type) {
			$_object_type = get_post_type_object($object_type);

			// Grab the first one.
			if (!empty($_object_type->has_archive)) {
				$posts_page = get_post_type_archive_link($object_type);
				break;
			}
		}
	}

	// Fallback for the 'All' link is the posts page.
	if (!$posts_page) {
		if ('page' === get_option('show_on_front') && get_option('page_for_posts')) {
			$posts_page = get_permalink(get_option('page_for_posts'));
		} else {
			$posts_page = home_url('/');
		}
	}

	return rwp_relative_url($posts_page);
}

function rwp_term_menu_args($args = []) {

	$defaults = rwp_collection([
		'container'    => true,
		'items_wrap'   => true,
	]);

	$wp_defaults = rwp_collection([
		'child_of'            => 0,
		'current_category'    => 0,
		'depth'               => 0,
		'echo'                => 0,
		'exclude'             => '',
		'exclude_tree'        => '',
		'feed'                => '',
		'feed_image'          => '',
		'feed_type'           => '',
		'hide_empty'          => 1,
		'hide_title_if_empty' => false,
		'hierarchical'        => true,
		'order'               => 'ASC',
		'orderby'             => 'name',
		'separator'           => '',
		'show_count'          => 0,
		'show_option_all'     => '',
		'show_option_none'    => '',
		'style'               => 'list',
		'taxonomy'            => 'category',
		'title_li'            => '',
		'use_desc_for_title'  => 1,
		'toggle'              => [],
		'child_type'          => '',
		'container'           => true,
		'items_wrap'          => true,
		'walker'              => new \RWP\Components\CategoryWalker(),
	]);


	$args = rwp_collection($args);

	$custom_args = $args->diffKeys($wp_defaults);

	if ($custom_args->isNotEmpty()) {
		$args->forget($custom_args->keys()->all());
	}

	$custom_args = $defaults->merge($custom_args);
	$child_type = ($args->has('child_type') && !empty($args->get('child_type'))) ? $args->get('child_type') : '';
	if ($child_type) {
		$custom_args->put('child_type', $child_type);
	}
	$toggle = ($args->has('toggle') && !empty($args->get('toggle'))) ? $args->get('toggle') : '';

	$args = $wp_defaults->merge($args);

	$taxonomy = $args->get('taxonomy');

	if (!($taxonomy instanceof WP_Taxonomy)) {
		$taxonomy = get_taxonomy($taxonomy);
	}


	//$custom_args = $custom_args->all();
	$menu_id =  $taxonomy->name . '-term-list';
	if ($custom_args->has('menu_id') && !empty($custom_args->get('menu_id'))) {
		$menu_id = $custom_args->pull('menu_id');
	} elseif ($args->has('child_of') && !empty($args->get('child_of'))) {
		if ($custom_args->has('menu_depth') && $custom_args->get('menu_depth') > 0) {
			$menu_id = 'submenu';
		}
		$menu_id .= '-' . $args->get('child_of');
	} else if ($args->has('parent') && !empty($args->get('parent'))) {
		$parent = $args->get('parent');

		if ($custom_args->has('menu_depth') && $custom_args->get('menu_depth') > 0) {
			$menu_id = 'submenu';
		}

		$menu_id .= '-' . rwp_id($parent);
	}

	$custom_args->put('id', $menu_id);


	$title_li_start = '<li>';
	$title_li_end = '</li>';
	$show_all = '';
	$show_none = '';

	$subnav = null;

	$is_list_style = ($args->has('style') && $args->get('style') === 'list');
	$has_title_li = ($args->has('title_li') && !empty($args->get('title_li')));

	$title_li = $parent_nav = null;
	$menu = rwp_nav($custom_args->all());

	$submenu_id = '';

	if ($is_list_style && $has_title_li) {
		$parent_nav = rwp_nav($custom_args->all());
		$title_li = $args->pull('title_li');
		$args->put('title_li', '');
		$submenu_id = $taxonomy->name . '-submenu';
		$custom_args->put('id', $taxonomy->name . '-submenu');
		$custom_args->put('depth', 1);
		$menu = rwp_nav($custom_args->all());

		if (!rwp_array_has('target', $toggle)) {
			$toggle['target'] = $submenu_id . '-wrapper';
		}
	}

	$start_tag = null;
	$end_tag = null;



	if ($is_list_style) {
		if ($args->has('show_option_none') && !empty($args->get('show_option_none'))) {

			$show_none = $args->pull('show_option_none');
			if (is_string($show_none) && !preg_match('/\<li/', $show_none)) {

				$show_none = rwp_nav_item([
					'link' => [
						'text' => [
							'content' => $show_none,
						],
						'atts' => [
							'tag' => 'span'
						]
					],
					'atts' => [
						'class' => [
							$taxonomy->name . '-list-none'
						]
					],
				]);
				$show_none->removeNavAtts();
			} else if (is_object($show_none)) {
				$show_none->removeNavAtts();
			} else if (is_array($show_none)) {
				$show_none = rwp_nav_item($show_none);
				$show_none->removeNavAtts();
			}
			$args->put('show_option_none', '');
			$show_none->preBuild();
			$menu->addItem($show_none);
		}
		if ($args->has('show_option_all') && !empty($args->get('show_option_all'))) {
			$show_all = $args->pull('show_option_all');
			if (is_string($show_all) && !preg_match('/\<li/', $show_all)) {
				$show_all = rwp_nav_item([
					'link' => [
						'text' => [
							'content' => $show_all,
						],
						'atts' => [
							'href' => rwp_taxonomy_archive_link($taxonomy),

						]
					],
					'atts' => [
						'class' => [
							$taxonomy->name . '-list-all'
						]
					]
				]);
			} else if (is_array($show_all)) {
				$show_all = rwp_nav_item($show_all);
			}
			$args->put('show_option_all', '');
			$show_all->preBuild();
			$menu->addItem($show_all);
		}
		if ($has_title_li) {

			if (is_string($title_li) && !preg_match('/\<li/', $title_li)) {
				$title_li = rwp_nav_item([
					'link' => [
						'text' => [
							'content' => $title_li,
						],
						'atts' => [
							'tag' => 'span'
						]
					],
					'children' => $submenu_id . '-wrapper',
					'toggle' => $toggle,
					'atts' => [
						'class' => [
							'term-list-title'
						],
						'id' => $taxonomy->name . '-list-title'
					],
				]);



				$title_li->removeNavAtts();
			} else if (is_object($title_li)) {
				$title_li->removeNavAtts();
			} else if (is_array($title_li)) {
				$title_li = rwp_nav_item($title_li);
				$title_li->removeNavAtts();
			}
		} else {
			$title_li_start = '';
			$title_li_end = '';
		}
	}

	// Adding Custom arguments for navwalker

	if ($custom_args->has('container') && $custom_args->get('container') !== false) {
		$start_tag = $menu->__toString();
		$end_tag = $menu->navEndTag();
	} else {
		$start_tag  = $menu->list->__toString();
		$end_tag = $menu->list->endTag();
	}

	$start_tag = trim($start_tag);
	$start_tag = preg_replace("/\r|\n|\h{2,}|\t/", "", $start_tag);

	$end_tag = trim($end_tag);
	$end_tag = preg_replace("/\r|\n|\h{2,}|\t/", "", $end_tag);

	$start_tag = str_replace($end_tag, '', $start_tag);

	if ($title_li instanceof NavItem) {

		$title_li_start  = $title_li->startTag();
		$title_li_start .= $title_li->buildContent();
		$title_li_start .= $start_tag;
		$title_li_end    = $end_tag;
		$title_li_end   .= $title_li->endTag();

		$parent_nav->list->addContent($title_li_start);

		if ($custom_args->has('container') && $custom_args->get('container') !== false) {
			$start_tag = $parent_nav->__toString();
			$end_tag = $parent_nav->navEndTag();
		} else {
			$start_tag = $parent_nav->list->__toString();
			$end_tag = $parent_nav->list->endTag();
		}
		$start_tag = trim($start_tag);
		$start_tag = preg_replace("/\r|\n|\h{2,}|\t/", "", $start_tag);

		$end_tag = trim($end_tag);
		$end_tag = preg_replace("/\r|\n|\h{2,}|\t/", "", $end_tag);

		$start_tag = str_replace($end_tag, '', $start_tag);

		$end_tag = $title_li_end . $end_tag;
	}

	$args->put('start_tag', $start_tag);
	$args->put('end_tag', $end_tag);


	$args = apply_filters('rwp_term_nav_args', $args);

	$args = $args->all();

	return $args;
}

function rwp_get_term_menu($taxonomy, $args = []) {

	$args['taxonomy'] = $taxonomy;

	$args = rwp_term_menu_args($args);

	$menu = wp_list_categories($args);
	if (rwp_array_has('items_wrap', $args) && $args['items_wrap'] !== false) {
		$menu = $args['start_tag'] . $menu . $args['end_tag'];
	}

	return $menu;
}

function rwp_get_terms($post = null, $taxonomy = '', $args = []) {

	$terms = get_the_terms($post, $taxonomy);

	if ($terms) {
		$defaults = [
			'atts' => [
				'class' => [
					'term-list',
					"$taxonomy-list"
				]
			],
			'item_atts' => [
				'atts' => [
					'class' => [
						'term-item',
						"$taxonomy-item"
					]
				]
			]
		];
		$args = rwp_merge_args($defaults, $args);
		$term_list = rwp_htmllist($args);

		foreach ($terms as $term) {
			$term_link = get_term_link($term, $taxonomy);
			$term_title = '<span class="term-text">' . $term->name . '</span>';
			if ($term_link) {
				$term_title = rwp_link([
					'content' => $term_title,
					'atts' => [
						'href' => rwp_relative_url($term_link),
						'class' => [
							'term-link'
						]
					]
				])->__toString();
			}
			$term_list->addItem([
				'content' => $term_title,
				'atts' => [
					'class' => [
						"term-$term->slug"
					]
				]
			]);
		}

		return $term_list;
	} else {
		return false;
	}
}
