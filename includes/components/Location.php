<?php

/** ============================================================================
 * Card
 *
 * @package   RWP\/includes/components/Card.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection;

class Location extends Element {

	/**
	 * @var Collection $location The location data
	 */

	public $location;

	/**
	 * @var string $tag The html element tag
	 */
	public $tag = 'div';

	/**
	 * @var Collection|array $atts The collection of atts
	 */
	public $atts = array(
		'class' => array(
			'location',
		),
	);

	/**
	 * @var array $order Array that sets the order of the child nodes
	 */

	public $order = array( 'title', 'address', 'phone', 'email' );

	/**
	 * @var array|string|Element $title The header content wrapper
	 */
	public $title = array(
		'tag' => 'h4',
		'atts' => array(
			'class' => array(
				'location-title',
			),
			'itemprop' => 'name',
		),
	);

	/**
	 * @var array|string|Element $address The image content wrapper
	 */
	public $address = array(
		'tag' => 'address',
		'order' => array(
			'street',
			'locality',
			'province',
			'postal',
			'country',
		),
		'atts' => array(
			'class' => array(
				'location-address',
			),
			'itemscope' => '',
			'itemtype' => 'http://schema.org/PostalAddress',
		),
	);

	/**
	 * @var array|string|Element $phone The image content wrapper
	 */
	public $phone = array(
		'tag' => 'a',
		'atts' => array(
			'class' => array(
				'location-phone',
			),
		),
	);

	/**
	 * @var array|string|Element $email The image content wrapper
	 */
	public $email = array(
		'tag' => 'a',
		'atts' => array(
			'class' => array(
				'location-email',
			),
		),
	);


	public function __construct( $location, $args = [] ) {

		parent::__construct( $args );

		if ( is_string( $location ) ) {
			$order = preg_replace( '/title/', 'label', $this->order );
			$this->location = self::get_location_info( $location, $order );
		}

		$elements = $this->order;

		foreach ( $elements as $element ) {
			$this->$element = new Element( $this->$element );
			switch ( $element ) {
				case 'title':
					$this->set_title();
					break;
				case 'address':
					$this->set_address();
					break;
				case 'phone':
					$this->set_phone();
					break;
				case 'email':
					$this->set_email();
					break;
			}
		}
	}

	/**
	 * Get location information
	 *
	 * @param string $location
	 * @param string|string[] $info_parts
	 * @return Collection
	 */
	public static function get_location_info( $location = '', $info_parts = array() ) {
		/**
		 * @var Collection $locations
		 */
		$locations = rwp_get_option( 'locations' );

		$info = rwp_collection();

		if ( ! empty( $location ) ) {

			$info = $locations->get( $location );
		}

		if ( $info->isNotEmpty() ) {
			if ( ! empty( $info_parts ) ) {
				$info = $info->only( $info_parts );
			}
		}

		return $info;

	}

	/**
	 * Add a title
	 * @param string $title
	 * @param mixed $args
	 * @return void
	 */
	public function set_title( $title = '', $args = array() ) {

		if ( empty( $title ) ) {
			$title = $this->location->get( 'label' );
		}

		if ( is_array( $args ) && ! empty( $args ) ) {
			$defaults = $this->title->toArray();
			$defaults = rwp_merge_args( $title, $args );

			$this->title = new Element( $defaults );
		}

		$this->title->set_content( $title, 0 );

	}

	/**
	 * Set the address
	 *
	 * @param Html|string|array|Element  $address  The address value
	 *
	 */
	public function set_address( $address = '', $args = array() ) {

		$defaults = $this->address;

		$items = $defaults->order;

		$items_map = array(
			'name'        => 'street',
			'city'        => 'locality',
			'state_short' => 'province',
			'post_code'   => 'postal',
			'country'     => 'country',
		);

		array_filter( $items_map, function( $key ) use ( $items ) {
			return ( ! in_array( $key, $items ) );
		} );

		$defaults = $defaults->toArray();

		if ( empty( $address ) ) {
			$address = $this->location->get( 'address' );
		}

		if ( rwp_is_collection( $address ) ) {
			$address = $address->only( array_keys( $items_map ) );
			$address = $address->all();
		}

		$address = array_filter( $address, function( $key ) use ( $items_map ) {
			return ( ! in_array( $key, $items_map ) );
		} );

		if ( is_array( $args ) ) {
			$defaults = rwp_merge_args( $defaults, $args );

			$this->address = new Element( $defaults );
		}

		$line_1 = rwp_element( array(
			'tag' => 'span',
			'content' => array(
				'separator' => '<span class="address-item address-item-separator">,</span>',
			),
			'order' => array(
				'street',
				'separator',
			),
			'atts' => array(
				'class' => array(
					'address-line',
					'address-line-1',
				),
			),
		));

		$line_2 = rwp_element( array(
			'tag' => 'span',
			'order' => array(
				'locality',
				'province',
				'postal',
				'country',
			),
			'atts' => array(
				'class' => array(
					'address-line',
					'address-line-2',
				),
			),
		));

		foreach ( $address as $key => $value ) {
			$mapped_key = $items_map[ $key ];

			$item = rwp_element(array(
				'tag' => 'span',
				'content' => array(
					$value,
				),
				'atts' => array(
					'class' => array(
						'address-item',
						'address-item-' . $mapped_key,
					),
				),
			));

			if ( 'name' === $key ) {
				$item->set_attr( 'itemprop', 'streetAddress' );
				$value = $item->html();
				$line_1->set_content( $value, $mapped_key );

			} else {
				switch ( $key ) {
					case 'city':
						$item->set_attr( 'itemprop', 'addressLocality' );
						break;

					case 'state_short':
						$title = data_get( $this->location, 'address.state' );
						$item->set_tag( 'abbr' );
						$item->set_attr( 'title', $title );
						$item->set_attr( 'itemprop', 'addressRegion' );
						break;
					case 'post_code':
						$item->set_attr( 'itemprop', 'postalCode' );
						break;
					case 'country':
						$item->add_class( 'visually-hidden' );
						$item->set_attr( 'itemprop', 'addressCountry' );
						break;
				}

				$value = $item->html();

				$line_2->set_content( $value, $mapped_key );
			}
		}

		$line_1 = $line_1->html();
		$line_2 = $line_2->html();

		$this->address->set_content( $line_1, 'line_1' );

		$this->address->set_content( $line_2, 'line_2' );

		$this->address->set_order( 'line_1', 0 );
		$this->address->set_order( 'line_2', 1 );

	}

	/**
	 * Add a phone
	 * @param string $phone
	 * @param mixed $args
	 * @return void
	 */
	public function set_phone( $phone = '', $args = array() ) {

		if ( empty( $phone ) ) {
			$phone = $this->location->get( 'phone' );
		}

		if ( is_array( $args ) && ! empty( $args ) ) {
			$defaults = $this->phone->toArray();
			$defaults = rwp_merge_args( $phone, $args );

			$this->phone = new Element( $defaults );
		}

		$this->phone->set_content( $phone, 0 );

		if ( 'a' === $this->phone->tag ) {
			$link = rwp_output_href( $phone );
			$this->phone->set_attr( 'href', $link );
		}

	}

	/**
	 * Add a email
	 * @param string $email
	 * @param mixed $args
	 * @return void
	 */
	public function set_email( $email = '', $args = array() ) {

		if ( empty( $email ) ) {
			$email = $this->location->get( 'email' );
		}

		if ( is_array( $args ) && ! empty( $args ) ) {
			$defaults = $this->email->toArray();
			$defaults = rwp_merge_args( $email, $args );

			$this->email = new Element( $defaults );
		}

		$this->email->set_content( $email, 0 );

		if ( 'a' === $this->email->tag ) {
			$link = rwp_output_href( $email );
			$this->email->set_attr( 'href', $link );
		}

	}

	public function setup_html() {

		$label = $this->location->get( 'label' );

		$this->add_class( rwp_change_case( $label ) );
	}

	/**
	 * Output multiple locations
	 *
	 * @param array $locations
	 * @param array $args
	 * @return string
	 */
	public static function output_locations( $locations = array(), $args = array() ) {

		$output = '';

		if ( empty( $locations ) ) {
			$locations = rwp_get_option( 'locations' )->keys()->all();
		}
		if ( ! empty( $locations ) ) {
			foreach ( $locations as $location ) {
				$location = new self( $location, $args );

				$output .= $location->html();
			}
		}

		return $output;
	}
}
