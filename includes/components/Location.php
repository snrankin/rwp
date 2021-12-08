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

use RWP\Components\Collection;

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
	 * @var Collection $weekday_order
	 */
	public static $weekday_order;

	/**
	 * @var array $order Array that sets the order of the child nodes
	 */

	public $order = array( 'title', 'address', 'phone', 'email', 'schedule' );

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

	/**
	 * @var array|string|Element $schedule The image content wrapper
	 */
	public $schedule = array(
		'tag' => 'div',
		'atts' => array(
			'class' => array(
				'location-schedules',
			),
		),
	);

	public $hours;

	/**
	 * @var string $day_separator
	 */
	public $day_separator = ':';

	/**
	 * @var string $time_separator
	 */
	public $time_separator = ' &ndash; ';

	/**
	 * @var string $day_format
	 */
	public $day_format = 'D';

	/**
	 * @var string $time_format
	 */
	public $time_format = 'g:i a';


	public function __construct( $location, $args = [] ) {

		parent::__construct( $args );

		if ( is_string( $location ) ) {
			$order = $this->order;
			if ( in_array( 'title', $order ) ) {
				$order = preg_replace( '/title/', 'label', $order );
			}

			$this->location = self::get_location_info( $location );
		}

		$this->day_separator = apply_filters( 'rwp_schedules_day_separator', $this->day_separator );
		$this->time_separator = apply_filters( 'rwp_schedules_time_separator', $this->time_separator );

		$this->day_format = apply_filters( 'rwp_schedules_day_format', $this->day_format );
		$this->time_format = apply_filters( 'rwp_schedules_time_format', $this->time_format );

		if ( empty( self::$weekday_order ) ) {
			$weekdays = rwp_collection(array(
				'Sunday',
				'Monday',
				'Tuesday',
				'Wednesday',
				'Thursday',
				'Friday',
				'Saturday',
			));

			$start_of_week_index = (int) get_option( 'start_of_week', 1 );

			if ( $start_of_week_index < 6 ) {

				$weekday = $weekdays->get( $start_of_week_index );

				$weekday_order_part_last = $weekdays->takeUntil( $weekday );
				$weekday_order_part_first = $weekdays->skipUntil( $weekday );
				self::$weekday_order = $weekday_order_part_first->merge( $weekday_order_part_last );
			}
		}

		$this->setup_hours();

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
				case 'schedule':
					$labels = $this->schedule->order;
					$this->set_schedule( $labels );
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

		$label = $this->location->get( 'label' );

		if ( is_array( $args ) && ! empty( $args ) ) {
			$defaults = $this->phone->toArray();
			$defaults = rwp_merge_args( $defaults, $args );

			$this->phone = new Element( $defaults );
		}

		$this->phone->set_content( $phone, 0 );

		if ( 'a' === $this->phone->tag ) {
			$link = rwp_output_href( $phone );
			$this->phone->set_attr( 'href', $link );
			$title = wp_sprintf( 'Call %s at %s', get_bloginfo( 'name' ), $phone );
			$title = apply_filters( 'rwp_phone_link_title', $title, $label );
			$this->phone->set_attr( 'title', $title );
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

		$label = $this->location->get( 'label' );

		if ( is_array( $args ) && ! empty( $args ) ) {
			$defaults = $this->email->toArray();
			$defaults = rwp_merge_args( $defaults, $args );

			$this->email = new Element( $defaults );
		}

		$this->email->set_content( $email, 0 );

		if ( 'a' === $this->email->tag ) {
			$link = rwp_output_href( $email );
			$this->email->set_attr( 'href', $link );
			$title = wp_sprintf( 'Email %s at %s', get_bloginfo( 'name' ), $email );
			$title = apply_filters( 'rwp_email_link_title', $title, $label );
			$this->email->set_attr( 'title', $title );
		}

	}

	public function setup_hours() {

		/**
		 * @var Collection $schedules
		 */
		$schedules = $this->location->get( 'schedules' );
		if ( ! rwp_is_collection( $schedules ) || $schedules->isEmpty() ) {
			return;
		}

		$this->hours = $schedules->transform( function( $schedule ) {
			$weekdays = self::$weekday_order;

			$hours = $schedule->get( 'hours' );

			$hours_order = rwp_collection();

			foreach ( $weekdays->all() as $weekday ) {
				$day_schedules = $hours->filter(function( $hour ) use ( $weekday ) {
					/**
					 * @var Collection $days
					 */
					$days = data_get( $hour, 'days', rwp_collection() );
					$day = $days->search( $weekday );

					if ( false !== $day ) {
						return true;
					} else {
						return false;
					}

				});

				if ( $day_schedules->isNotEmpty() ) {

					$day_schedules = $day_schedules->values()->all();

					$weekday_schedules = rwp_collection();

					foreach ( $day_schedules as $index => $day ) {
						$timezone = wp_timezone();
						$week_day = new \DateTime( $weekday, $timezone );
						$all_day = $day->get( 'all_day' );
						$type = $day->get( 'type' );
						$time = '';
						if ( ! $all_day ) {
							$start_time = data_get( $day, 'times.start' );
							$start_time = new \DateTime( $start_time, $timezone );

							$end_time = data_get( $day, 'times.end' );
							$end_time = new \DateTime( $end_time, $timezone );
							$time = array(
								'start' => $start_time,
								'end'  => $end_time,
							);
						} else {
							$all_day_text = __( 'All Day', 'rwp' );
							$all_day_text = rwp_change_case( $type . ' ' . $all_day_text, 'title' );
							$time = apply_filters( "rwp_all_day_text_{$type}", $all_day_text );
						}

						$weekday_schedules->put($index, array(
							'type' => $type,
							'day' => $week_day,
							'time' => $time,
						));

					}
					$hours_order->put( $weekday, $weekday_schedules );
				}
			}

			return $hours_order;
		} );

	}

	/**
	 *
	 * @param string|string[] $label
	 * @return void
	 */
	public function set_schedule( $label = '' ) {

		$day_format = $this->day_format;
		$time_format = $this->time_format;
		$combine = data_get( $this->schedule, 'combine', false );
		$add_label = data_get( $this->schedule, 'add_label', true );

		/**
		 * @var Collection $schedules
		 */
		$schedules = $this->get( 'hours' );
		if ( ! rwp_is_collection( $schedules ) || $schedules->isEmpty() ) {
			return;
		}

		if ( ! empty( $label ) ) {

			if ( is_string( $label ) && $schedules->has( $label ) ) {
				/**
				 * @var Collection $schedule
				 */
				$schedule = $schedules->get( $label );
				$schedule->transform(function( $day, $key ) use ( $time_format, $day_format ) {

					$times = array();

					if ( rwp_is_collection( $day ) ) {
						$day = $day->all();
					}

					foreach ( $day as $key => $item ) {
						$times[] = $item['time'];
						$weekday = $item['day'];
					}

					$times_output = $this->setup_times( $times, $time_format );

					if ( $weekday instanceof \DateTime ) {
						$weekday = $weekday->format( $day_format );
					}

					return array(
						'day'  => $weekday,
						'time' => $times_output,
					);

				});

				if ( $combine ) {
					$schedule = $schedule->groupBy( 'time', true )->values();
				} else {
					$schedule = $schedule->groupBy( 'day', true )->values();
				}

				$schedule_output = rwp_element( array(
					'tag' => 'div',
					'atts' => array(
						'class' => array(
							'schedule',
							rwp_change_case( $label ),
						),
					),
				) );

				if ( $add_label ) {
					$title = rwp_change_case( $label, 'title' );
					$this->schedule->set_content( '<span class="schedule-label">' . $title . '</span>' );
				}

				foreach ( $schedule->all() as $key => $group ) {
					/**
					 * @var Collection $group
					 */

					 $schedule_row = rwp_element( array(
						 'tag' => 'span',
						 'atts' => array(
							 'class' => array(
								 'schedule-row',
							 ),
						 ),
					 ) );

					/**
					 * @var array $item
					 */
					$item = $group->first();

					$time = $item['time'];

					/**
					 * @var Collection $group
					 */
					if ( 1 < $group->count() ) {
						$weekday = $group->keys()->join( ', ' );

					} else {
						$weekday = $item['day'];
					}

					$day_output = rwp_element( array(
						'tag' => 'span',
						'atts' => array(
							'class' => array(
								'schedule',
								'day',
							),
						),
					) );

					$day_output->set_content( $weekday );
					if ( ! empty( $this->day_separator ) ) {
						$day_separator = wp_sprintf( '<span class="schedule day-separator">%s</span>', $this->day_separator );
						$day_output->set_content( $day_separator );
					}

					$day_output = $day_output->html();

					$schedule_row->set_content( $day_output );
					$schedule_row->set_content( $time );

					$schedule_output->set_content( $schedule_row );

				}

				$this->schedule->set_content( $schedule_output );
			} elseif ( is_array( $label ) ) {
				foreach ( $label as $item ) {
					$this->set_schedule( $item );
				}
			}
		} else {
			$schedules->keys()->each(function( $schedule ) {
				$this->set_schedule( $schedule );
			});
		}
	}

	public function setup_times( $times, $time_format = 'g:i a' ) {

		$time_output = rwp_element( array(
			'tag' => 'span',
			'atts' => array(
				'class' => array(
					'schedule',
					'time-row',
				),
			),
		) );

		if ( wp_is_numeric_array( $times ) ) {
			foreach ( $times as $item ) {
				$this->setup_time( $time_output, $item, $time_format );
			}
		} else if ( is_array( $times ) && ! wp_is_numeric_array( $times ) ) {

			$this->setup_time( $time_output, $times, $time_format );
		}
		return $time_output->html();
	}

	public function setup_time( &$time_output, $time, $time_format = 'g:i a' ) {

		$time_block = rwp_element( array(
			'tag' => 'time',
			'atts' => array(
				'class' => array(
					'schedule',
					'time',
				),
			),
		) );

		$time_separator = ! empty( $this->time_separator ) ? wp_sprintf( '<span class="schedule time-separator">%s</span>', $this->time_separator ) : '';
		if ( is_array( $time ) ) {

			/**
			 * @var null|\DateTime $start_time
			 */
			$start_time = data_get( $time, 'start' );
			$start_time = ! empty( $start_time ) ? wp_sprintf( '<span class="schedule time start">%s</span>', $start_time->format( $time_format ) ) : $start_time;
			$time_block->set_content( $start_time );

			/**
			 * @var null|\DateTime $end_time
			 */
			$end_time = data_get( $time, 'end' );

			if ( ! empty( $time_separator ) && ! empty( $start_time ) && ! empty( $end_time ) ) {
				$time_block->set_content( $time_separator );
			}

			$end_time = ! empty( $end_time ) ? wp_sprintf( '<span class="schedule time end">%s</span>', $end_time->format( $time_format ) ) : $end_time;
			$time_block->set_content( $end_time );
		} else {
			$time = wp_sprintf( '<span class="schedule time all-day">%s</span>', $time );
			$time_block->set_content( $time );
		}

		$time_output->set_content( $time_block );
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
