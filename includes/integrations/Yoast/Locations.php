<?php
/** ============================================================================
 * Locations
 *
 * @package   RWP\/includes/integrations/Yoast/Locations.php
 * @since     1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Integrations\Yoast;

use Yoast\WP\SEO\Generators\Schema\Organization;
use RWP\Components\Collection;
class Locations extends Organization {

    /**
     * Adds our Team Member's Person piece of the graph.
     *
     * @return array Person Schema markup.
     */
	public function generate() {
		$data = parent::generate();

		/**
		 * @var Collection $locations
		 */
		$locations = rwp_get_option( 'locations', rwp_collection() );

		if ( rwp_is_collection( $locations ) && $locations->isNotEmpty() ) {
			$main_location = $locations->filter( function( $location ) {
				return $location->get( 'main_location' );
			});
			$main_location = $main_location->first()->all();
			$main_location = $this->setup_location( $main_location );

			unset( $main_location['name'] );

			$locations = $locations->reject(function( $location ) {
				return $location->get( 'main_location' );
			});
			if ( $locations->isNotEmpty() ) {
				foreach ( $locations->all() as $key => $value ) {
					$data['department'][] = $this->setup_location( $value );
				}
			}
			$data = array_merge( $data, $main_location );
		}

		$data = apply_filters( 'rwp_yoast_locations', $data );

		return $data;
	}

	public function setup_location( $location ) {
		$label = data_get( $location, 'label' );
		$type = rwp_get_option( 'company_info.schema_type' );
		$data = array(
			'@type' => $type,
			'name' => $this->helpers->schema->html->smart_strip_tags( $this->context->company_name . ' - ' . $label ),
		);
		$street = data_get( $location, 'address.name' );
		$city = data_get( $location, 'address.city' );
		$state = data_get( $location, 'address.state_short' );
		$zip = data_get( $location, 'address.post_code' );
		$country = data_get( $location, 'address.country_short' );

		$address = array(
			'@type' => 'PostalAddress',
		);

		if ( ! empty( $street ) ) {
			$address['streetAddress'] = $street;
		}

		if ( ! empty( $city ) ) {
			$address['addressLocality'] = $city;
		}

		if ( ! empty( $state ) ) {
			$address['addressRegion'] = $state;
		}

		if ( ! empty( $zip ) ) {
			$address['postalCode'] = $zip;
		}

		if ( ! empty( $country ) ) {
			$address['addressCountry'] = $country;
		}

		if ( count( $address ) > 1 ) {
			$data['address'] = $address;
		}

		$lat = data_get( $location, 'address.lat' );
		$lng = data_get( $location, 'address.lng' );

		if ( ! empty( $lat ) && ! empty( $lng ) ) {
			$data['location'] = array(
				'@type' => 'Place',
				'geo' => array(
					'@type' => 'GeoCoordinates',
					'latitude' => $lat,
					'longitude' => $lng,
				),
			);
		}

		$map_url = data_get( $location, 'map_url.url' );

		if ( ! empty( $map_url ) ) {
			$data['hasMap'] = $map_url;
		}

		$page_url = data_get( $location, 'page_url.url' );

		if ( ! empty( $page_url ) ) {
			$data['url'] = $page_url;
		}

		$phone = data_get( $location, 'phone' );

		if ( ! empty( $phone ) ) {
			$data['telephone'] = $phone;
		}

		$email = data_get( $location, 'email' );

		if ( ! empty( $email ) ) {
			$data['email'] = $email;
		}

		/**
		 * @var Collection $schedules
		 */
		$schedules = data_get( $location, 'schedules', rwp_collection() );

		if ( rwp_is_collection( $schedules ) && $schedules->isNotEmpty() ) {
			$schedules = $schedules->filter(function( $schedule ) {
				return $schedule->get( 'add_to_schema' );
			});

			if ( $schedules->isNotEmpty() ) {
				$data['openingHoursSpecification'] = array();
				/**
				 * @var Collection $schedule
				 */
				$schedule = $schedules->first();

				if ( rwp_is_collection( $schedule ) && $schedule->isNotEmpty() ) {

					/**
					 * @var Collection $hours
					 */
					$hours = $schedule->get( 'hours' );

					$hours = $hours->where( 'type', '===', 'opened' );

					if ( rwp_is_collection( $hours ) && $hours->isNotEmpty() ) {

						foreach ( $hours->all() as $value ) {
							/**
							 * @var Collection $days
							 */
							$days = data_get( $value, 'days' );

							$all_day = data_get( $value, 'all_day', false );

							$times = data_get( $value, 'times', array() );

							$timezone = wp_timezone();

							$start_time = '';
							$end_time = '';

							if ( 1 == $days->count() ) {
								$days = $days->first();
							} else {
								$days = $days->all();
							}

							if ( ! $all_day ) {
								$start_time = data_get( $times, 'start' );
								$start_time = new \DateTime( $start_time, $timezone );
								$start_time = $start_time->format( 'H:i' );

								$end_time = data_get( $times, 'end' );
								$end_time = new \DateTime( $end_time, $timezone );
								$end_time = $end_time->format( 'H:i' );

							} else {
								$start_time = '00:00';
								$end_time = '23:59';
							}
							$data['openingHoursSpecification'][] = array(
								'@type' => 'OpeningHoursSpecification',
								'dayOfWeek' => $days,
								'opens' => $start_time,
								'closes' => $end_time,
							);
						}
					}
				}
			}
		}

		return $data;

	}
}
