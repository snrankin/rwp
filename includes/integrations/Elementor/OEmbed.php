<?php
/** ============================================================================
 * OEmbed
 *
 * @package   RWP\Integrations\Elementor\OEmbed
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */
namespace RWP\Integrations\Elementor;

use RWP\Integrations\Elementor;
use RWP\Integrations\Bootstrap;
use Elementor\Element_Base;
use Elementor\Widget_Base;
use Elementor\Plugin as Elementor_Instance;
use Elementor\Controls_Manager as Controls_Manager;

class OEmbed extends Widget_Base { // phpcs:ignore

	/**
	 * Widget base constructor.
	 *
	 * Initializing the widget base class.
	 *
	 * @since 0.9.0
	 * @access public
	 *
	 * @throws \Exception If arguments are missing when initializing a full widget
	 *                   instance.
	 *
	 * @param array      $data Widget data. Default is an empty array.
	 * @param array|null $args Optional. Widget default arguments. Default is null.
	 */

	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );

		//rwp()->register_assets( 'elementor-o-embed' );
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve video widget name.
	 *
	 * @since 0.9.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'oembed';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve video widget title.
	 *
	 * @since 0.9.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'oEmbed', 'rwp' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve video widget icon.
	 *
	 * @since 0.9.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-youtube';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the video widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'video', 'player', 'embed', 'youtube', 'vimeo', 'dailymotion', 'wistia' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize
	 * the widget settings.
	 *
	 * @since 0.9.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_oembed',
			[
				'label' => esc_html__( 'oEmbed', 'rwp' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'url',
			[
				'label' => __( 'URL to embed', 'rwp' ),
				'type' => Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => __( 'https://your-link.com', 'rwp' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 0.9.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$html = wp_oembed_get( $settings['url'] );

		$this->add_render_attribute( 'video-wrapper', 'class', 'elementor-wrapper' );
		echo '<div ';
		$this->print_render_attribute_string( 'video-wrapper' );  // phpcs:ignore
		echo '>';
		echo ( $html ) ? $html : $settings['url']; // phpcs:ignore

		echo '</div>';

	}

}
