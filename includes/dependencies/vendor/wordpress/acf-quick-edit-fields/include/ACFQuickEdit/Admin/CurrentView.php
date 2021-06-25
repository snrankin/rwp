<?php

/**
 *	@package ACFQuickEdit\Admin
 *	@version 1.0.0
 *	2018-09-22
 */
namespace RWP\Vendor\ACFQuickEdit\Admin;

if (!\defined('ABSPATH')) {
    die('FU!');
}
use RWP\Vendor\ACFQuickEdit\Ajax;
use RWP\Vendor\ACFQuickEdit\Asset;
use RWP\Vendor\ACFQuickEdit\Core;
use RWP\Vendor\ACFQuickEdit\Fields;
class CurrentView extends \RWP\Vendor\ACFQuickEdit\Core\Singleton
{
    private $_available_field_groups = null;
    private $object_kind = null;
    // post, term, user
    private $object_type = null;
    // post, term, user
    private $screen_param = [];
    // post_type|taxonomy
    private $field_group_filter = null;
    private $field_to_group = [];
    /**
     *	@inheritdoc
     */
    protected function __construct()
    {
        /**
         *	Setup object_kind, screen_param and object_type
         */
        if (wp_doing_ajax()) {
            // get content type by $_REQUEST['action']
            if (isset($_REQUEST['action'])) {
                $this->screen_param = $this->referer_params();
                if (\in_array($_REQUEST['action'], apply_filters('acf_quick_edit_post_ajax_actions', ['inline-save']))) {
                    $this->object_kind = 'post';
                } else {
                    if (\in_array($_REQUEST['action'], apply_filters('acf_quick_edit_term_ajax_actions', ['inline-save-tax']))) {
                        $this->object_kind = 'term';
                    }
                }
            }
        } else {
            $wp_screen = get_current_screen();
            if ('edit' === $wp_screen->base) {
                $this->object_kind = 'post';
                if (isset($_REQUEST['action']) && 'edit' === $_REQUEST['action']) {
                    // bulk edit save
                    // screen opts in $_REQUEST['_wp_http_referer'];
                    $this->screen_param = $this->referer_params();
                } else {
                    $this->screen_param = $this->get_params();
                }
            } else {
                if ('upload' === $wp_screen->base) {
                    $this->object_kind = 'post';
                    $this->screen_param = $this->get_params();
                } else {
                    if ('edit-tags' === $wp_screen->base) {
                        $this->object_kind = 'term';
                        $this->screen_param = $this->get_params();
                    } else {
                        if ('users' === $wp_screen->base) {
                            $this->object_kind = 'user';
                            $this->object_type = null;
                            $this->screen_param = $this->get_params();
                        }
                    }
                }
            }
        }
        // set screen param defaults
        if ($this->object_kind === 'post') {
            $this->screen_param = wp_parse_args($this->screen_param, ['post_type' => 'post']);
        } else {
            if ($this->object_kind === 'term') {
                $this->screen_param = wp_parse_args($this->screen_param, ['taxonomy' => 'post_tag']);
                // no post type on taxonomies!
                $this->screen_param = \array_diff_key($this->screen_param, ['post_type' => 0]);
            } else {
                if ($this->object_kind === 'user') {
                }
            }
        }
        $this->object_type = $this->get_object_type();
        // current taxonomy
    }
    /**
     *	@return string 'post', 'term', 'user'
     */
    public function get_object_kind()
    {
        return $this->object_kind;
    }
    /**
     *	@return string|null post type slug or taxonomy name. NULL on users screen
     */
    public function get_object_type()
    {
        if (\is_null($this->object_type) && 'user' !== $this->object_kind) {
            if ('term' === $this->object_kind) {
                $this->object_type = 'post_tag';
                foreach ($this->screen_param as $param => $value) {
                    if ('cat' === $param) {
                        $this->object_type = 'post_category';
                        break;
                    } else {
                        if ('tag' === $param) {
                            $this->object_type = 'post_tag';
                            break;
                        } else {
                            if ('taxonomy' === $param) {
                                $this->object_type = $value;
                            } else {
                                if (taxonomy_exists($param)) {
                                    $this->object_type = $param;
                                    break;
                                }
                            }
                        }
                    }
                }
            } else {
                if ('post' === $this->object_kind) {
                    $this->object_type = 'post';
                    foreach ($this->screen_param as $param => $value) {
                        if ('post_type' === $param) {
                            $this->object_type = $value;
                            break;
                        }
                    }
                }
            }
        }
        return $this->object_type;
    }
    /**
     *	Calculate field group filter for current screen
     *
     *	@return array filter for acf_getfield_groups
     */
    private function get_fieldgroup_filter()
    {
        if (\is_null($this->field_group_filter)) {
            $this->field_group_filter = [];
            foreach ($this->screen_param as $param => $value) {
                if ('post_type' === $param && !empty($value)) {
                    $this->field_group_filter['post_type'] = $value;
                } else {
                    if ('attachment-filter' === $param) {
                        $filtered_type = \urldecode($param);
                        $filtered_type = \substr($filtered_type, \strpos($filtered_type, ':') + 1);
                        $this->field_group_filter['attachment'] = $filtered_type;
                    } else {
                        if (\in_array($param, ['cat', 'tag']) && !empty($value)) {
                            // post_category
                            $this->field_group_filter['post_taxonomy'] = \sprintf('post_%s:%s', $param, $value);
                        } else {
                            if (taxonomy_exists($param) && !empty($value)) {
                                // post_taxonomy => <taxo>:<term_slug>
                                $this->field_group_filter['post_taxonomy'] = \sprintf('%s:%s', $param, $value);
                            } else {
                                if ('taxonomy' === $param && !empty($value)) {
                                    $this->field_group_filter['taxonomy'] = $value;
                                } else {
                                    if ('role' === $param && !empty($value)) {
                                        //*
                                        $this->field_group_filter[] = ['user_form' => 'all', 'user_role' => $value];
                                        $this->field_group_filter[] = ['user_form' => 'edit', 'user_role' => $value];
                                        /*/
                                        		$this->field_group_filter[] = array( 'user_role' => $value );
                                        		//*/
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ('user' === $this->object_kind && !\count($this->field_group_filter)) {
                $this->field_group_filter[] = ['user_form' => 'all'];
                $this->field_group_filter[] = ['user_form' => 'edit'];
            }
            add_filter('acf/location/rule_match/post_taxonomy', [$this, 'match_post_taxonomy'], 11, 3);
            add_filter('acf/location/rule_match/post_format', [$this, 'match_post_format'], 11, 3);
            add_filter('acf/location/rule_match/post_status', [$this, 'match_post_status'], 11, 3);
            add_filter('acf/location/rule_match/attachment', [$this, 'match_attachment'], 11, 3);
        }
        /*
        ACF get_field_groups filter:
        [ 'post_type' => 'post' ] --> matches post type
        [ [ 'post_type' => 'post' ] ] --> doesn't match anything
        [ 'post_type' => 'post', 'taxonomy' => 'post_tag' ] --> matches post type OR Taxo
        [ [ 'post_type' => 'post', 'taxonomy' => 'post_tag' ] ] --> matches post type AND Taxo
        */
        // if ( $this->is_assoc( $this->field_group_filter ) && count( $this->field_group_filter ) > 1 ) {
        // 	$this->field_group_filter = array( $this->field_group_filter );
        // }
        return apply_filters('acf_quick_edit_fields_group_filter', $this->field_group_filter);
    }
    /**
     *	Return field associated with current view
     *
     *	@param array $query Field properties
     *	@return array
     */
    public function get_fields($query = [])
    {
        $groups = $this->get_available_field_groups();
        $fields = [];
        foreach ($groups as $field_group) {
            $group_fields = acf_get_fields($field_group);
            $group_fields = $this->filter_fields($query, $group_fields);
            foreach ($group_fields as $field) {
                // map to group
                $this->field_to_group[$field['key']] = $field_group;
            }
            $fields = \array_merge($fields, $group_fields);
        }
        return $fields;
    }
    /**
     *	Return fields by properties
     *
     *	@param array $query Field properties
     *	@param array $fields
     *	@return array
     */
    private function filter_fields($query, $fields)
    {
        $found_fields = [];
        foreach ($fields as $field) {
            $match = \true;
            if ('group' === $field['type']) {
                $found_fields = \array_merge($found_fields, $this->filter_fields($query, $field['sub_fields']));
            }
            foreach ($query as $prop => $value) {
                if (\is_bool($value)) {
                    $value = \intval($value);
                }
                if (!isset($field[$prop]) || $field[$prop] !== $value) {
                    $match = \false;
                    break;
                }
            }
            if ($match) {
                $found_fields[] = $field;
            }
        }
        return $found_fields;
    }
    /**
     *	Return field groups relevant for the current view
     *
     *	@return array acf field gruops
     */
    private function get_available_field_groups()
    {
        global $typenow, $pagenow;
        if (\is_null($this->_available_field_groups)) {
            $filters = $this->get_fieldgroup_filter();
            $this->_available_field_groups = acf_get_field_groups($filters);
        }
        return $this->_available_field_groups;
    }
    /**
     *	Whether an arrays has string keys
     *
     *	@param array $arr
     *	@return boolean
     */
    private function is_assoc($arr)
    {
        if (!\is_array($arr)) {
            \trigger_error('Argument should be an array for is_assoc()', \E_USER_WARNING);
            return \false;
        }
        return \count(\array_filter(\array_keys($arr), 'is_string')) > 0;
    }
    /**
     *	Get field group of field
     *
     *	@param array $field ACF Field
     *	@return array ACF field group
     */
    public function get_group_of_field($field)
    {
        if (isset($this->field_to_group[$field['key']])) {
            return $this->field_to_group[$field['key']];
        }
    }
    /**
     *	@filter 'acf/location/rule_match/post_taxonomy'
     *	@return boolean Whether a field group rule matches
     */
    function match_post_taxonomy($match, $rule, $screen)
    {
        if (isset($screen['post_taxonomy'])) {
            // WP categories
            return $rule['operator'] == '==' && $rule['value'] == $screen['post_taxonomy'];
        }
        return $match;
    }
    /**
     *	@filter 'acf/location/rule_match/post_format'
     *	@return boolean Whether a field group rule matches
     */
    function match_post_format($match, $rule, $screen)
    {
        if (isset($screen['post_format'])) {
            return $rule['operator'] == '==' && $rule['value'] == $screen['post_format'];
        }
        return $match;
    }
    /**
     *	@filter 'acf/location/rule_match/post_status'
     *	@return boolean Whether a field group rule matches
     */
    function match_post_status($match, $rule, $options)
    {
        if (isset($screen['post_status'])) {
            return $rule['operator'] == '==' && $rule['value'] == $screen['post_status'];
        }
        return $match;
    }
    /**
     *	@filter 'acf/location/rule_match/attachment'
     *	@return boolean Whether a field group rule matches
     */
    function match_attachment($match, $rule, $options)
    {
        if (isset($screen['attachment'])) {
            return $rule['operator'] == '==' && $rule['value'] == $screen['attachment'];
        }
        return $match;
    }
    /**
     *	Set screen params from http referer (prefer _wp_http_referer)
     *
     *	@return array $_GET-Params of $_REQUEST['_wp_http_referer']
     */
    private function referer_params()
    {
        $url = \false;
        $filter = [];
        if (isset($_REQUEST['_wp_http_referer'])) {
            $url = wp_unslash($_REQUEST['_wp_http_referer']);
        } else {
            if (isset($_SERVER['HTTP_REFERER'])) {
                $url = wp_unslash($_SERVER['HTTP_REFERER']);
            }
        }
        if ($url) {
            \parse_str(\parse_url($url, \PHP_URL_QUERY), $filter);
        }
        return $filter;
    }
    /**
     *	Set screen params from $_GET
     *
     *	@return array $_GET-Params
     */
    private function get_params()
    {
        return $_GET;
    }
}
