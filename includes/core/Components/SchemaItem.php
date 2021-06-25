<?php

namespace RWP\Components;

use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Components\{Html, Button};

class SchemaItem extends Html {

	public $order = [
		'address',
		'phone',
		'email',
		'fax',
		'hours'
	];

	public $items = [
		'address',
		'phone',
		'email',
		'fax',
		'hours',
		'social_profiles',
	];

	public $phone = [
		'label' => null,
		'link'  => true,
		'atts' => [
			'tag'   => 'span',
		]
	];

	public $fax = [
		'label' => null,
		'atts'  => [
			'tag' => 'span',
		]
	];

	public $address = [
		'label' => null,
		'link'  => true,
		'atts'  => [
			'tag' => 'address',
		]
	];

	public $email = [
		'label' => null,
		'link'  => true,
		'atts'  => [
			'tag' => 'span',
		]
	];

	public $wrapper = true;

	public $hours = [
		'label'              => null,
		'schedules'          => [],
		'type'               => 'open',
		'display'            => 'date_time',
		'separator'          => ': ',
		'time_args' => [
			'times'         => [],
			'format'        => 'g:ia',
			'separator'     => '&ndash;',
			'all_day'       => false,
			'all_day_label' => 'All Day',
			'atts' => [
				'tag' => 'span',
				'class' => ['times']
			]
		],
		'day_args' => [
			'days'           => [],
			'format'         => 'l',
			'separator'      => '&ndash;',
			'everyday_label' => 'Daily',
			'atts' => [
				'tag' => 'span',
				'class' => ['days']
			]
		],
		'atts'    => [
			'tag'   => 'span',
		]
	];

	public $location;

	public $atts = [
		'tag'   => 'div',
		'class' => [
			'schema-item'
		]
	];

	public function __construct($args = []) {

		parent::__construct($args);

		if (!empty($this->location)) {
			$this->addClass($this->location . '-info');
		} else {
			$this->addClass('company-info');
		}

		if (!empty($this->items)) {
			$items = [];
			foreach ($this->items as $item) {
				$items[$item] = $this->get_item_value($item);
			}
			$this->items = $items;
			$this->prepareItems();
		}
	}

	public function prepareItems() {

		foreach ($this->items as $type => $item) {

			if (!empty($item)) {

				switch ($type) {
					case 'address':
						$address = self::formatAddressHtml($item);
						$item = new Collection([$address->__toString()]);
						break;
					case 'hours':
						$item = $this::formatHours($item->all());
						$item = new Collection([$item->__toString()]);
						break;
					case 'social_profiles':
						$item = self::formatSocialLinks($item);
						$item = new Collection([$item->__toString()]);
						break;
					default:
						$item->transform(function ($v, $k) {
							if ($v['link']) {
								$v = new Button($v);
							} else {
								$v = new Html($v);
								$v->setAttr('tag', 'span');
								$v->removeAttr('href');
							}
							$v->addClasses([$k]);
							return $v->__toString();
						});

						break;
				}

				$this->items[$type] = $item->join('');
			}
		}
	}

	/**
	 * Function for format a string or an array into a specific array format (used)
	 * with other functions
	 */

	private static function addressArray($address = '') {
		if (empty($address)) {
			return;
		}

		$address_array = [];

		if (is_string($address)) {
			$street_regex = '/^\w+\s\w+\.?\s\w+\s\w*\.?/';
			$unit_regex = '/(?i)(\#|unit|ste|apt|bldg|floor|suite)\.?\s?\w*/';
			$state_regex = '/((A[LKSZR])|(C[AOT])|(D[EC])|(F[ML])|(G[AU])|(HI)|(I[DLNA])|(K[SY])|(LA)|(M[EHDAINSOT])|(N[EVHJMYCD])|(MP)|(O[HKR])|(P[WAR])|(RI)|(S[CD])|(T[NX])|(UT)|(V[TIA])|(W[AVIY]))/';
			$postal_regex = '/\d{5}-\d{4}|\d{5}|[A-Z]\d[A-Z] \d[A-Z]\d$/';
			preg_match($street_regex, $address, $street);
			preg_match($unit_regex, $address, $unit);
			preg_match($state_regex, $address, $region);
			preg_match($postal_regex, $address, $postal);
			$locality = str_replace($street[0], '', $address);
			$locality = str_replace($unit[0], '', $locality);
			$locality = str_replace($region[0], '', $locality);
			$locality = str_replace($postal[0], '', $locality);
			$locality = trim($locality, ', ');

			$address_array['street']   = trim($street[0], ', ');
			$address_array['unit']     = trim($unit[0], ', ');
			$address_array['locality'] = trim($locality, ', ');
			$address_array['region']   = trim($region[0], ', ');
			$address_array['postal']   = trim($postal[0], ', ');
		} else if (is_object($address)) {
			$address_array = rwp_object_to_array($address);
		} else if (is_array($address)) {
			$address_array = $address;
		}


		return $address_array;
	}

	/**
	 * Function for format a string or an array into a specific array format (used)
	 * with other functions
	 */

	public static function formatAddressString($address = '') {
		if (empty($address)) {
			return;
		}

		$ouput = '';

		$address = self::addressArray($address);

		$street = (!empty($address['unit'])) ? $address['street'] . ' ' . $address['unit'] : $address['street'];
		$ouput = $street . ' ' . $address['locality'] . ' ' . $address['region'] . ' ' . $address['postal'];

		return $ouput;
	}

	/**
	 * Function for format a string or an array into a specific array format (used)
	 * with other functions
	 */

	public static function formatAddressHtml($args) {
		$default = [
			'label' => null,
			'link'  => true,
			'atts'  => [
				'tag' => 'address',
			]
		];

		if (empty($args)) {
			return;
		}

		$args = rwp_merge_args($default, $args);

		$address = $args['address'];

		if (!($address instanceof Collection)) {
			$address = new Collection($address);
		}

		$address_line_1 = new Html([
			'order' => ['street', 'unit'],
			'atts'    => [
				'tag'   => 'span',
				'class' => [
					'address-line-1'
				]
			]
		]);
		$address_line_2 = new Html([
			'order' => ['locality', 'region', 'postal', 'country'],
			'atts'    => [
				'tag'   => 'span',
				'class' => [
					'address-line-2'
				]
			]
		]);

		$args['content'] = '';

		if ($address->has('street')) {
			$street = $address->get('street');
			$street = trim($street, " \t\n\r\0\x0B\,");
			$street    = Html::text([
				'content' => $street,
				'atts'    => [
					'tag'   => 'span',
					'class' => [
						'street'
					]
				]
			]);
			$address_line_1->addContent($street, 'street');
		}

		if ($address->has('unit')) {
			$unit = $address->get('unit');
			$unit = trim($unit, " \t\n\r\0\x0B\,");
			$unit      = Html::text([
				'content' => $unit,
				'atts'    => [
					'tag'   => 'span',
					'class' => [
						'unit'
					]
				]
			]);
			$address_line_1->addContent($unit, 'unit');
		}
		if ($address->has('locality')) {
			$locality = $address->get('locality');
			$locality = trim($locality, " \t\n\r\0\x0B\,");
			$locality  = Html::text([
				'content' => $locality . ',',
				'atts'    => [
					'tag'   => 'span',
					'class' => [
						'locality'
					]
				]
			]);
			$address_line_2->addContent($locality, 'locality');
		}
		if ($address->has('region')) {
			$region = $address->get('region');
			$region = trim($region, " \t\n\r\0\x0B\,");
			$region    = Html::text([
				'content' => $region,
				'atts'    => [
					'tag'   => 'span',
					'class' => [
						'region'
					]
				]
			]);
			$address_line_2->addContent($region, 'region');
		}
		if ($address->has('postal')) {
			$postal = $address->get('postal');
			$postal = trim($postal, " \t\n\r\0\x0B\,");
			$postal    =  Html::text([
				'content' => $postal,
				'atts'    => [
					'tag'   => 'span',
					'class' => [
						'postal'
					]
				]
			]);
			$address_line_2->addContent($postal, 'postal');
		}

		if ($address_line_1->hasContent()) {
			$args['content'] .= $address_line_1->__toString();
		}

		if ($address_line_2->hasContent()) {
			$args['content'] .= $address_line_2->__toString();
		}

		if ($args['link']) {
			if (empty($address['map_url'])) {
				$address['map_url'] = 'https://www.google.com/maps/search/?api=1&query=' . urlencode(self::formatAddressString($address));
			}
			$args['atts']['href'] = $address['map_url'];
			$output = Html::link($args);
		} else {
			$output = Html::make($args);
		}

		return $output;
	}

	public static function getLocation($location = null) {

		$company_info = rwp()->get_option('company_info');

		if ($company_info) {
			$locations = $company_info->get('locations');

			if ($locations->has($location)) {
				return $locations->get($location);
			} else {
				return $company_info;
			}
		}
	}

	public function get_item_value($item) {

		$location = $this->location;

		$item_args = [];
		$label = null;
		if ($this->hasArg($item)) {
			$item_args = $this->$item;
		}

		if (rwp_array_has('label', $item_args)) {
			$label = $item_args['label'];
			if (is_array($label)) {
				foreach ($label as $i => $label_text) {
					$label[$i] = rwp_change_case($label_text, 'snake');
				}
			} else {
				$label = rwp_change_case($label, 'snake');
			}
		}

		$locations = self::getLocation()->get('locations');

		if (empty($location)) {
			if (in_array($item, ['address', 'hours'])) {
				if ($locations instanceof Collection) {
					$location = self::getLocation()->get('locations')->first();
				}
			} else {
				$location = self::getLocation();
			}
		}

		if ($location instanceof Collection && $location->has($item)) {
			switch ($item) {
				case 'social_profiles':
					$item_args = array_merge($item_args, $location->get($item));
					break;
				case 'address':
					$item_args[$item] = $location->get($item);
					break;

				case 'hours':

					$item_info = $location->get($item);
					if (!empty($label)) {
						$item_info = $item_info->only($label);
					}

					foreach ($item_info->all() as $key => $value) {
						foreach ($value as $type => $schedule) {
							$item_args['schedules'][$type] = $schedule;
						}
					}
					$item_args = new Collection($item_args);

					break;
				default:
					$item_info = $location->get($item);
					if (!empty($label)) {
						$item_info = $item_info->only($label);
					}

					$merged_items = [];

					foreach ($item_info->all() as $key => $value) {
						$merged_items[$key] = rwp_merge_args($item_args, $value);
					}

					$item_args = new Collection($merged_items);
					break;
			}
			return $item_args;
		} else {
			return false;
		}
	}

	/**
	 * Output Info
	 *
	 * @param array $args
	 *
	 * ```
	 * $args = [
	 *   'location'   => '', // The location to get info from
	 *   'item'       => '', // The item to retrieve (ex: address, phone, email)
	 *   'label'      => '', // If there are multiple items under the item (ie multiple phone numbers) then reteive a certain one else get the default
	 *   'item_args'  => [], // The arguments to add to the item
	 * ];
	 *```
	 *
	 * @return Html
	 */

	public static function outputItemInfo($args = []) {
		if (empty($args)) return;

		$item_args = $html = null;

		extract($args);

		$content = null;

		if (empty($content)) return;

		$item_args['atts']['class'][] = 'schema-item';
		$item_args['atts']['class'][] = rwp_change_case($item);

		if ($item === 'address') {
			$item_args['address'] = $content;
			$item_args['atts']['tag'] = 'address';
			$html = self::formatAddressHtml($item_args);
		}
		if ($item === 'hours') {
			$item_args['schedules'] = $content;
			$html = self::formatHours($item_args);
		}

		if ($item === 'social_profiles') {
			$item_args['profiles'] = $content;
			$html = self::formatSocialLinks($item_args);
		}

		if ($item === 'email' || $item === 'phone') {
			if (is_array($content)) {
				foreach ($content as $key => $value) {
					$item_args['content'] = $value;
					if ($item_args['link']) {
						$html .= Html::link($item_args);
					} else {
						$html .= Html::text($item_args);
					}
				}
			} else {
				$item_args['content'] = $content;
				if ($item_args['link']) {
					$item_args['atts']['href'] = $content;
					$html .= Html::link($item_args);
				} else {
					$html .= Html::text($item_args);
				}
			}
		}

		if ($item === 'fax') {
			$item_args['content'] = $content;
			$html .= Html::text($item_args);
		}

		return $html;
	}


	public static function formatHours($args = []) {

		$type = $display = $separator = $time_args = $day_args = $atts = $schedules = null;

		extract($args);

		$time_type = $type;

		if (empty($schedules)) return;

		$output = new Html([
			'atts' => $atts
		]);

		if (is_object($schedules)) {
			$schedules  = rwp_object_to_array($schedules);
		}

		foreach ($schedules  as $day_type => $schedule) {

			foreach ($schedule as $slots) {

				$slot = new Html([
					'atts' => [
						'tag' => 'time',
						'class' => [
							'time-slot',
							$time_type,
						]
					]
				]);

				$times = '';

				$time_args['times'] = reset($slots[$time_type]);
				$time_args = self::formatTime($time_args);


				$day_args = $args['day_args'];
				$day_args['label'] = $args['type'];
				$day_args['days'] = $slots['days'];
				$days = self::formatDays($day_args);

				switch ($args['display']) {
					case 'time':

						$slot->addContent($times);
						break;
					case 'date':

						$slot->addContent($days);
						break;

					default:

						if ($days->content->isNotEmpty()) {
							$days->content->prepend(ucwords($label) . ' ');

							$slot->addContent($days, 'before');
						}

						if ($days->content->isNotEmpty() && $time_args->content->isNotEmpty()) {
							$separator = Html::icon([
								'content' => $args['separator'],
								'atts' => [
									'tag' => 'span',
									'class' => ['time', 'separator']
								]
							]);

							$slot->addContent($separator, 'content');
						}

						if ($time_args->content->isNotEmpty()) {
							$slot->addContent($time_args, 'after');
						}
						break;
				}

				$output->addContent($slot);
			}
		}
		return $output;
	}

	public static function formatTime($args = []) {
		$defaults = [
			'times'          => [],
			'format'         => 'g:i a',
			'separator'      => '&ndash;',
			'allday'         => false,
			'allday_label'   => 'All Day',
			'atts' => [
				'tag' => 'span',
				'class' => ['times']
			]
		];

		$args = rwp_merge_args($defaults, $args);

		$formattedTime = Html::text(['atts' => $args['atts']]);

		if (is_array($args['times'])) {
			foreach ($args['times'] as $time) {
				$label = $time['closed'] ? 'closed' : 'open';
				$format = (isset($time['format']) && !empty($time['format'])) ? $time['format'] : $args['format'];
				$times = Html::text([
					'atts' => [
						'tag' => 'time',
						'class' => ['time', $label]
					]
				]);

				$time_atts = [
					'atts' => [
						'tag' => 'span',
					]
				];

				if (!$time['all_day']) {
					if (isset($time['start']) && !empty($time['start'])) {
						$start = Html::text($time_atts);
						$start->addContent(date($format, strtotime($time['start'])));
						$start->addClass('start');
						$times->addContent($start, 'before');
					}

					if (!empty($time['end']) && $time['end'] !== $time['start']) {
						$separator = Html::icon([
							'content' => $args['separator'],
							'atts' => [
								'tag' => 'span',
								'class' => ['separator']
							]
						]);

						$times->addContent($separator, 'content');

						$end = Html::text($time_atts);
						$end->addContent(date($format, strtotime($time['end'])));
						$end->addClass('end');
						$times->addContent($end, 'after');
					}
				} else {
					$all_day = Html::text($time_atts);
					$all_day->addContent($args['all_day_label']);
					$all_day->addClass('all-day');
					$times->addContent($all_day);
				}
				$formattedTime->addContent($times, $label);
			}
		}

		return $formattedTime;
	}

	public static function sortWeekdays(&$arr = [], $start = 0) {
		if (!is_array($arr) || wp_is_numeric_array($arr)) return $arr;
		$default_order = [
			'Sunday',
			'Monday',
			'Tuesday',
			'Wednesday',
			'Thursday',
			'Friday',
			'Saturday'
		];
		$start = intval($start);
		$start = $default_order[$start];
		$start = new \DateTimeImmutable($start);
		$order = [
			$start->format('l')
		];

		$arr = !empty($arr) ? $arr : $default_order;

		for ($d = 1; $d < 7; $d++) {
			$weekday = $start->add(new \DateInterval('P' . $d . 'D'));
			$order[] = $weekday->format('l');
		}

		foreach ($arr as $k => $v) {
			unset($arr[$k]);
			$k = date('l', strtotime($k));
			$arr[$k] = $v;
		}

		self::sortArrayByKeys($arr, $order);

		return $arr;
	}

	public static function formatDays($args = []) {
		$defaults = [
			'days'           => [],
			'format'         => 'F j, Y',
			'separator'      => '&ndash;',
			'everyday_label' => 'Daily',
			'atts' => [
				'tag' => 'span',
				'class' => ['days']
			]
		];

		$args = self::mergeAtts($defaults, $args);

		$formattedTime = Html::text(['atts' => $args['atts']]);

		$day_atts = [
			'atts' => [
				'tag' => 'span',
			]
		];

		$days = '';

		if (is_array($args['days'])) {
			if ($args['format'] === 'l' && count($args['days']) == 7) {
				$days = Html::text([
					'atts' => [
						'tag' => 'span',
						'class' => ['day', $args['label']]
					]
				]);
				$days->addContent($args['everyday_label']);
				$formattedTime->addContent($days);
			} else {
				foreach ($args['days'] as $i => $day) {
					$days = Html::text([
						'atts' => [
							'tag' => 'span',
							'class' => ['day', $args['label']]
						]
					]);

					$day_atts = [
						'atts' => [
							'tag' => 'span',
						]
					];
					$format = (isset($day['format']) && !empty($day['format'])) ? $day['format'] : $args['format'];
					if ($format === 'l') {
						$args['days'] = self::sortWeekdays($args['days'], get_option('start_of_week'));
						if (self::isSequential($args['days'])) {
							$start_day = reset($args['days']);

							if (!empty($start_day)) {
								$start = Html::text($day_atts);
								$start->addContent(date($format, strtotime($start_day)));
								$start->addClass('start');
								$days->addContent($start, 'before');
							}

							$end_day = end($args['days']);

							if (count($args['days']) > 1) {
								$separator = Html::icon([
									'content' => $args['separator'],
									'atts' => [
										'tag' => 'span',
										'class' => ['separator']
									]
								]);

								$days->addContent($separator, 'content');

								$end = Html::text($day_atts);
								$end->addContent(date($format, strtotime($end_day)));
								$end->addClass('end');
								$days->addContent($end, 'after');
							}
						} else {
							foreach ($args['days'] as $i => $day) {
								$args['days'][$i] = date($format, strtotime($day));
							}
							$days->addContent(explode(', ', $args['days']));
						}
					} else {

						if (isset($day['start']) && !empty($day['start'])) {
							$start = Html::text($day_atts);
							$start->addContent(date($format, strtotime($day['start'])));
							$start->addClass('start');
							$days->addContent($start, 'before');
						}

						if (!empty($day['end']) && $day['end'] !== $day['start']) {
							$separator = Html::icon([
								'content' => $args['separator'],
								'atts' => [
									'tag' => 'span',
									'class' => ['separator']
								]
							]);

							$days->addContent($separator, 'content');

							$end = Html::text($day_atts);
							$end->addContent(date($format, strtotime($day['end'])));
							$end->addClass('end');
							$days->addContent($end, 'after');
						}
					}
					$formattedTime->addContent($days);
				}
			}
		} else {
			$formattedTime->addContent(date($args['format'], strtotime($args['days'])));
		}

		return $formattedTime;
	}


	public static function formatSocialLinks($args = []) {

		$defaults = [
			'inline'   => true,
			'profiles' => [],
			'item_atts' => [
				'class' => [
					'social-profile',
				]
			],
			'atts' => [
				'class' => [
					'social-profiles',
				]
			]
		];
		$args = rwp_merge_args($defaults, $args);

		if (rwp_array_has('items', $args)) {
			$profiles = [];
			if ($args['items'] instanceof Collection) {
				$profiles = $args['items']->transform(function ($profile_args, $label) {
					if (!rwp_array_has('text', $profile_args)) {
						$profile_args['text']['content'] = $label;
						$profile_args['text']['screen_reader'] = true;
					}
					return $profile_args;
				});
			} else if (is_array($args['items'])) {
				foreach ($args['items'] as $label => $profile_args) {
					if (!rwp_array_has('text', $profile_args)) {
						$profile_args['text']['content'] = $label;
						$profile_args['text']['screen_reader'] = true;
					}
					$args['items'][$label] = $profile_args;
				}
				$profiles = new Collection($args['items']);
			}

			if (rwp_array_has('profiles', $args)) {
				$profiles = $profiles->only($args['profiles']);
				unset($args['profiles']);
			}

			$args['items'] = $profiles->all();
		}


		$list = Button::buttonGroup($args);

		$list->preBuild();

		return $list;
	}

	/**
	 * Schema Item shortcode processor
	 *
	 * @param array $atts The shortcode atts
	 * @param string $content The shortcode content (empty)
	 * @param string $tag The shortcode tag
	 *
	 * @return self
	 */

	public static function shortcode($atts, $content = '', $tag) {
		$defaults = [
			'class'    => '',
			'location' => '',
			'label'    => '',
			'link'     => 'true',
			'inline'   => 'true',
			'wrapper'  => 'true',
			'items'    => '',
		];

		$atts = rwp()::process_shortcode($atts, $defaults);

		if ($tag !== 'company_info') {
			$atts['items'] = [$tag];
			$atts[$tag] = [
				'label'   => $atts['label'],
				'link'    => $atts['link'],
				'inline'  => $atts['inline'],
				'atts'    => $atts['atts']
			];
			unset($atts['label']);
			unset($atts['link']);
			unset($atts['inline']);
			unset($atts['atts']);
			unset($atts['class']);
		} else {
			$atts['items'] = explode(', ', $atts['items']);
		}

		$item = new self($atts);


		return $item;
	}

	public function preBuild() {
		if (!empty($this->items)) {
			foreach ($this->items as $type => $item) {
				$this->addContent($item, $type);
			}
		}
	}

	public function __toString() {
		$this->preBuild();
		if ($this->wrapper) {
			return $this->build();
		} else {
			return self::buildContent($this);
		}
	}
}
