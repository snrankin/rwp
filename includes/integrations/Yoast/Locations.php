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
use RWP\Components\Location;
use RWP\Vendor\Illuminate\Support\Collection;
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
		$locations = rwp_get_option( 'locations' );

		if ( $locations->count() > 1 ) {
			$main_location = $locations->filter(function( $location ) {
				return $location->get( 'main_location' );
			});

			$locations = $locations->reject(function( $location ) {
				return $location->get( 'main_location' );
			});
			foreach ( $locations->all() as $key => $value ) {
				$data['department'][] = $this->setup_location( $value );
			}
			$main_location = $main_location->first()->all();
			$main_location = $this->setup_location( $main_location );
			$data = array_merge( $data, $main_location );
		} else {
			$value = $locations->first();
			$location = $this->setup_location( $value );
			$data = array_merge( $data, $location );
		}

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

		$phone = data_get( $location, 'phone' );

		if ( ! empty( $phone ) ) {
			$data['telephone'] = $phone;
		}

		return $data;

	}
}
