<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__ . '/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('Page_For_Post_Type', false) && !interface_exists('Page_For_Post_Type', false) && !trait_exists('Page_For_Post_Type', false)) {
	spl_autoload_call('RWP\Vendor\Page_For_Post_Type');
}
if (!class_exists('PAnD', false) && !interface_exists('PAnD', false) && !trait_exists('PAnD', false)) {
	spl_autoload_call('RWP\Vendor\PAnD');
}

if (!class_exists('safe_svg_attributes', false) && !interface_exists('safe_svg_attributes', false) && !trait_exists('safe_svg_attributes', false)) {
    spl_autoload_call('RWP\Vendor\safe_svg_attributes');
}
if (!class_exists('safe_svg_tags', false) && !interface_exists('safe_svg_tags', false) && !trait_exists('safe_svg_tags', false)) {
    spl_autoload_call('RWP\Vendor\safe_svg_tags');
}
if (!class_exists('safe_svg', false) && !interface_exists('safe_svg', false) && !trait_exists('safe_svg', false)) {
    spl_autoload_call('RWP\Vendor\safe_svg');
}
if (!class_exists('Extended_Taxonomy_Admin', false) && !interface_exists('Extended_Taxonomy_Admin', false) && !trait_exists('Extended_Taxonomy_Admin', false)) {
	spl_autoload_call('RWP\Vendor\Extended_Taxonomy_Admin');
}
if (!class_exists('Walker_ExtendedTaxonomyRadios', false) && !interface_exists('Walker_ExtendedTaxonomyRadios', false) && !trait_exists('Walker_ExtendedTaxonomyRadios', false)) {
	spl_autoload_call('RWP\Vendor\Walker_ExtendedTaxonomyRadios');
}
if (!class_exists('Extended_CPT_Admin', false) && !interface_exists('Extended_CPT_Admin', false) && !trait_exists('Extended_CPT_Admin', false)) {
	spl_autoload_call('RWP\Vendor\Extended_CPT_Admin');
}
if (!class_exists('Extended_CPT_Rewrite_Testing', false) && !interface_exists('Extended_CPT_Rewrite_Testing', false) && !trait_exists('Extended_CPT_Rewrite_Testing', false)) {
	spl_autoload_call('RWP\Vendor\Extended_CPT_Rewrite_Testing');
}
if (!class_exists('Extended_Taxonomy_Rewrite_Testing', false) && !interface_exists('Extended_Taxonomy_Rewrite_Testing', false) && !trait_exists('Extended_Taxonomy_Rewrite_Testing', false)) {
	spl_autoload_call('RWP\Vendor\Extended_Taxonomy_Rewrite_Testing');
}
if (!class_exists('Walker_ExtendedTaxonomyDropdown', false) && !interface_exists('Walker_ExtendedTaxonomyDropdown', false) && !trait_exists('Walker_ExtendedTaxonomyDropdown', false)) {
	spl_autoload_call('RWP\Vendor\Walker_ExtendedTaxonomyDropdown');
}
if (!class_exists('Walker_ExtendedTaxonomyCheckboxes', false) && !interface_exists('Walker_ExtendedTaxonomyCheckboxes', false) && !trait_exists('Walker_ExtendedTaxonomyCheckboxes', false)) {
	spl_autoload_call('RWP\Vendor\Walker_ExtendedTaxonomyCheckboxes');
}
if (!class_exists('Extended_CPT', false) && !interface_exists('Extended_CPT', false) && !trait_exists('Extended_CPT', false)) {
	spl_autoload_call('RWP\Vendor\Extended_CPT');
}
if (!class_exists('Extended_Taxonomy', false) && !interface_exists('Extended_Taxonomy', false) && !trait_exists('Extended_Taxonomy', false)) {
	spl_autoload_call('RWP\Vendor\Extended_Taxonomy');
}
if (!class_exists('Extended_Rewrite_Testing', false) && !interface_exists('Extended_Rewrite_Testing', false) && !trait_exists('Extended_Rewrite_Testing', false)) {
	spl_autoload_call('RWP\Vendor\Extended_Rewrite_Testing');
}

if (!class_exists('JsonException', false) && !interface_exists('JsonException', false) && !trait_exists('JsonException', false)) {
	spl_autoload_call('RWP\Vendor\JsonException');
}
if (!class_exists('ValueError', false) && !interface_exists('ValueError', false) && !trait_exists('ValueError', false)) {
	spl_autoload_call('RWP\Vendor\ValueError');
}
if (!class_exists('Attribute', false) && !interface_exists('Attribute', false) && !trait_exists('Attribute', false)) {
	spl_autoload_call('RWP\Vendor\Attribute');
}
if (!class_exists('UnhandledMatchError', false) && !interface_exists('UnhandledMatchError', false) && !trait_exists('UnhandledMatchError', false)) {
	spl_autoload_call('RWP\Vendor\UnhandledMatchError');
}
if (!class_exists('Stringable', false) && !interface_exists('Stringable', false) && !trait_exists('Stringable', false)) {
	spl_autoload_call('RWP\Vendor\Stringable');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('stripslashes_deep')) {
	function stripslashes_deep() {
		return \RWP\Vendor\stripslashes_deep(...func_get_args());
	}
}

if (!function_exists('get_page_for_post_type')) {
	function get_page_for_post_type() {
		return \RWP\Vendor\get_page_for_post_type(...func_get_args());
	}
}
if (!function_exists('wp_cache_remember')) {
	function wp_cache_remember() {
		return \RWP\Vendor\wp_cache_remember(...func_get_args());
	}
}


if (!function_exists('wp_cache_forget')) {
	function wp_cache_forget() {
		return \RWP\Vendor\wp_cache_forget(...func_get_args());
	}
}

if (!function_exists('remember_transient')) {
	function remember_transient() {
		return \RWP\Vendor\remember_transient(...func_get_args());
	}
}

if (!function_exists('forget_transient')) {
	function forget_transient() {
		return \RWP\Vendor\forget_transient(...func_get_args());
	}
}

if (!function_exists('remember_site_transient')) {
	function remember_site_transient() {
		return \RWP\Vendor\remember_site_transient(...func_get_args());
	}
}

if (!function_exists('forget_site_transient')) {
	function forget_site_transient() {
		return \RWP\Vendor\forget_site_transient(...func_get_args());
	}
}

if (!function_exists('sysexit')) {
	function sysexit() {
		return \RWP\Vendor\sysexit(...func_get_args());
	}
}

if (!function_exists('register_extended_post_type')) {
	function register_extended_post_type() {
		return \RWP\Vendor\register_extended_post_type(...func_get_args());
	}
}
if (!function_exists('register_extended_taxonomy')) {
	function register_extended_taxonomy() {
		return \RWP\Vendor\register_extended_taxonomy(...func_get_args());
	}
}

if (!function_exists('findTranslationFiles')) {
	function findTranslationFiles() {
		return \RWP\Vendor\findTranslationFiles(...func_get_args());
	}
}
if (!function_exists('calculateTranslationStatus')) {
	function calculateTranslationStatus() {
		return \RWP\Vendor\calculateTranslationStatus(...func_get_args());
	}
}
if (!function_exists('printTranslationStatus')) {
	function printTranslationStatus() {
		return \RWP\Vendor\printTranslationStatus(...func_get_args());
	}
}
if (!function_exists('extractLocaleFromFilePath')) {
	function extractLocaleFromFilePath() {
		return \RWP\Vendor\extractLocaleFromFilePath(...func_get_args());
	}
}
if (!function_exists('extractTranslationKeys')) {
	function extractTranslationKeys() {
		return \RWP\Vendor\extractTranslationKeys(...func_get_args());
    }
}
if (!function_exists('findTransUnitMismatches')) {
    function findTransUnitMismatches() {
        return \RWP\Vendor\findTransUnitMismatches(...func_get_args());
	}
}
if (!function_exists('isTranslationCompleted')) {
    function isTranslationCompleted() {
        return \RWP\Vendor\isTranslationCompleted(...func_get_args());
    }
}
if (!function_exists('printTitle')) {
	function printTitle() {
		return \RWP\Vendor\printTitle(...func_get_args());
	}
}
if (!function_exists('printTable')) {
	function printTable() {
		return \RWP\Vendor\printTable(...func_get_args());
	}
}
if (!function_exists('textColorRed')) {
	function textColorRed() {
		return \RWP\Vendor\textColorRed(...func_get_args());
	}
}
if (!function_exists('textColorGreen')) {
	function textColorGreen() {
		return \RWP\Vendor\textColorGreen(...func_get_args());
	}
}
if (!function_exists('textColorNormal')) {
	function textColorNormal() {
		return \RWP\Vendor\textColorNormal(...func_get_args());
	}
}
if (!function_exists('dump')) {
	function dump() {
		return \RWP\Vendor\dump(...func_get_args());
	}
}
if (!function_exists('dd')) {
	function dd() {
		return \RWP\Vendor\dd(...func_get_args());
	}
}
if (!function_exists('trigger_deprecation')) {
	function trigger_deprecation() {
		return \RWP\Vendor\trigger_deprecation(...func_get_args());
    }
}
if (!function_exists('twig_raw_filter')) {
    function twig_raw_filter() {
        return \RWP\Vendor\twig_raw_filter(...func_get_args());
    }
}
if (!function_exists('twig_escape_filter')) {
    function twig_escape_filter() {
        return \RWP\Vendor\twig_escape_filter(...func_get_args());
    }
}
if (!function_exists('twig_convert_encoding')) {
    function twig_convert_encoding() {
        return \RWP\Vendor\twig_convert_encoding(...func_get_args());
    }
}
if (!function_exists('twig_escape_filter_is_safe')) {
    function twig_escape_filter_is_safe() {
        return \RWP\Vendor\twig_escape_filter_is_safe(...func_get_args());
    }
}
if (!function_exists('twig_template_from_string')) {
    function twig_template_from_string() {
        return \RWP\Vendor\twig_template_from_string(...func_get_args());
    }
}
if (!function_exists('twig_cycle')) {
    function twig_cycle() {
        return \RWP\Vendor\twig_cycle(...func_get_args());
    }
}
if (!function_exists('twig_random')) {
    function twig_random() {
        return \RWP\Vendor\twig_random(...func_get_args());
    }
}
if (!function_exists('twig_test_iterable')) {
    function twig_test_iterable() {
        return \RWP\Vendor\twig_test_iterable(...func_get_args());
    }
}
if (!function_exists('twig_to_array')) {
    function twig_to_array() {
        return \RWP\Vendor\twig_to_array(...func_get_args());
    }
}
if (!function_exists('twig_date_format_filter')) {
    function twig_date_format_filter() {
        return \RWP\Vendor\twig_date_format_filter(...func_get_args());
    }
}
if (!function_exists('twig_date_converter')) {
    function twig_date_converter() {
        return \RWP\Vendor\twig_date_converter(...func_get_args());
    }
}
if (!function_exists('twig_date_modify_filter')) {
    function twig_date_modify_filter() {
        return \RWP\Vendor\twig_date_modify_filter(...func_get_args());
    }
}
if (!function_exists('twig_replace_filter')) {
    function twig_replace_filter() {
        return \RWP\Vendor\twig_replace_filter(...func_get_args());
    }
}
if (!function_exists('twig_round')) {
    function twig_round() {
        return \RWP\Vendor\twig_round(...func_get_args());
    }
}
if (!function_exists('twig_number_format_filter')) {
    function twig_number_format_filter() {
        return \RWP\Vendor\twig_number_format_filter(...func_get_args());
    }
}
if (!function_exists('twig_urlencode_filter')) {
    function twig_urlencode_filter() {
        return \RWP\Vendor\twig_urlencode_filter(...func_get_args());
    }
}
if (!function_exists('twig_array_merge')) {
    function twig_array_merge() {
        return \RWP\Vendor\twig_array_merge(...func_get_args());
    }
}
if (!function_exists('twig_slice')) {
    function twig_slice() {
        return \RWP\Vendor\twig_slice(...func_get_args());
    }
}
if (!function_exists('twig_first')) {
    function twig_first() {
        return \RWP\Vendor\twig_first(...func_get_args());
    }
}
if (!function_exists('twig_last')) {
    function twig_last() {
        return \RWP\Vendor\twig_last(...func_get_args());
    }
}
if (!function_exists('twig_join_filter')) {
    function twig_join_filter() {
        return \RWP\Vendor\twig_join_filter(...func_get_args());
    }
}
if (!function_exists('twig_split_filter')) {
    function twig_split_filter() {
        return \RWP\Vendor\twig_split_filter(...func_get_args());
    }
}
if (!function_exists('_twig_default_filter')) {
    function _twig_default_filter() {
        return \RWP\Vendor\_twig_default_filter(...func_get_args());
    }
}
if (!function_exists('twig_test_empty')) {
    function twig_test_empty() {
        return \RWP\Vendor\twig_test_empty(...func_get_args());
    }
}
if (!function_exists('twig_get_array_keys_filter')) {
    function twig_get_array_keys_filter() {
        return \RWP\Vendor\twig_get_array_keys_filter(...func_get_args());
    }
}
if (!function_exists('twig_reverse_filter')) {
    function twig_reverse_filter() {
        return \RWP\Vendor\twig_reverse_filter(...func_get_args());
    }
}
if (!function_exists('twig_sort_filter')) {
    function twig_sort_filter() {
        return \RWP\Vendor\twig_sort_filter(...func_get_args());
    }
}
if (!function_exists('twig_in_filter')) {
    function twig_in_filter() {
        return \RWP\Vendor\twig_in_filter(...func_get_args());
    }
}
if (!function_exists('twig_compare')) {
    function twig_compare() {
        return \RWP\Vendor\twig_compare(...func_get_args());
    }
}
if (!function_exists('twig_trim_filter')) {
    function twig_trim_filter() {
        return \RWP\Vendor\twig_trim_filter(...func_get_args());
    }
}
if (!function_exists('twig_spaceless')) {
    function twig_spaceless() {
        return \RWP\Vendor\twig_spaceless(...func_get_args());
    }
}
if (!function_exists('twig_length_filter')) {
    function twig_length_filter() {
        return \RWP\Vendor\twig_length_filter(...func_get_args());
    }
}
if (!function_exists('twig_upper_filter')) {
    function twig_upper_filter() {
        return \RWP\Vendor\twig_upper_filter(...func_get_args());
    }
}
if (!function_exists('twig_lower_filter')) {
    function twig_lower_filter() {
        return \RWP\Vendor\twig_lower_filter(...func_get_args());
    }
}
if (!function_exists('twig_title_string_filter')) {
    function twig_title_string_filter() {
        return \RWP\Vendor\twig_title_string_filter(...func_get_args());
    }
}
if (!function_exists('twig_capitalize_string_filter')) {
    function twig_capitalize_string_filter() {
        return \RWP\Vendor\twig_capitalize_string_filter(...func_get_args());
    }
}
if (!function_exists('twig_call_macro')) {
    function twig_call_macro() {
        return \RWP\Vendor\twig_call_macro(...func_get_args());
    }
}
if (!function_exists('twig_ensure_traversable')) {
    function twig_ensure_traversable() {
        return \RWP\Vendor\twig_ensure_traversable(...func_get_args());
    }
}
if (!function_exists('twig_include')) {
    function twig_include() {
        return \RWP\Vendor\twig_include(...func_get_args());
    }
}
if (!function_exists('twig_source')) {
    function twig_source() {
        return \RWP\Vendor\twig_source(...func_get_args());
    }
}
if (!function_exists('twig_constant')) {
    function twig_constant() {
        return \RWP\Vendor\twig_constant(...func_get_args());
    }
}
if (!function_exists('twig_constant_is_defined')) {
    function twig_constant_is_defined() {
        return \RWP\Vendor\twig_constant_is_defined(...func_get_args());
    }
}
if (!function_exists('twig_array_batch')) {
    function twig_array_batch() {
        return \RWP\Vendor\twig_array_batch(...func_get_args());
    }
}
if (!function_exists('twig_get_attribute')) {
    function twig_get_attribute() {
        return \RWP\Vendor\twig_get_attribute(...func_get_args());
    }
}
if (!function_exists('twig_array_column')) {
    function twig_array_column() {
        return \RWP\Vendor\twig_array_column(...func_get_args());
    }
}
if (!function_exists('twig_array_filter')) {
    function twig_array_filter() {
        return \RWP\Vendor\twig_array_filter(...func_get_args());
    }
}
if (!function_exists('twig_array_map')) {
    function twig_array_map() {
        return \RWP\Vendor\twig_array_map(...func_get_args());
    }
}
if (!function_exists('twig_array_reduce')) {
    function twig_array_reduce() {
        return \RWP\Vendor\twig_array_reduce(...func_get_args());
    }
}
if (!function_exists('twig_var_dump')) {
    function twig_var_dump() {
        return \RWP\Vendor\twig_var_dump(...func_get_args());
	}
}
if (!function_exists('append_config')) {
	function append_config() {
		return \RWP\Vendor\append_config(...func_get_args());
	}
}
if (!function_exists('blank')) {
	function blank() {
		return \RWP\Vendor\blank(...func_get_args());
	}
}
if (!function_exists('class_basename')) {
	function class_basename() {
		return \RWP\Vendor\class_basename(...func_get_args());
	}
}
if (!function_exists('class_uses_recursive')) {
	function class_uses_recursive() {
		return \RWP\Vendor\class_uses_recursive(...func_get_args());
	}
}
if (!function_exists('trait_uses_recursive')) {
	function trait_uses_recursive() {
		return \RWP\Vendor\trait_uses_recursive(...func_get_args());
	}
}
if (!function_exists('e')) {
	function e() {
		return \RWP\Vendor\e(...func_get_args());
	}
}
if (!function_exists('env')) {
	function env() {
		return \RWP\Vendor\env(...func_get_args());
	}
}
if (!function_exists('filled')) {
	function filled() {
		return \RWP\Vendor\filled(...func_get_args());
	}
}
if (!function_exists('object_get')) {
	function object_get() {
		return \RWP\Vendor\object_get(...func_get_args());
	}
}
if (!function_exists('value')) {
	function value() {
		return \RWP\Vendor\value(...func_get_args());
	}
}
if (!function_exists('optional')) {
	function optional() {
		return \RWP\Vendor\optional(...func_get_args());
	}
}
if (!function_exists('preg_replace_array')) {
	function preg_replace_array() {
		return \RWP\Vendor\preg_replace_array(...func_get_args());
	}
}
if (!function_exists('retry')) {
	function retry() {
		return \RWP\Vendor\retry(...func_get_args());
	}
}
if (!function_exists('tap')) {
	function tap() {
		return \RWP\Vendor\tap(...func_get_args());
	}
}
if (!function_exists('throw_if')) {
	function throw_if() {
		return \RWP\Vendor\throw_if(...func_get_args());
	}
}
if (!function_exists('throw_unless')) {
	function throw_unless() {
		return \RWP\Vendor\throw_unless(...func_get_args());
	}
}
if (!function_exists('transform')) {
	function transform() {
		return \RWP\Vendor\transform(...func_get_args());
	}
}
if (!function_exists('windows_os')) {
	function windows_os() {
		return \RWP\Vendor\windows_os(...func_get_args());
	}
}
if (!function_exists('with')) {
	function with() {
		return \RWP\Vendor\with(...func_get_args());
	}
}
if (!function_exists('collect')) {
	function collect() {
		return \RWP\Vendor\collect(...func_get_args());
	}
}
if (!function_exists('data_fill')) {
	function data_fill() {
		return \RWP\Vendor\data_fill(...func_get_args());
	}
}
if (!function_exists('data_set')) {
	function data_set() {
		return \RWP\Vendor\data_set(...func_get_args());
	}
}
if (!function_exists('data_get')) {
	function data_get() {
		return \RWP\Vendor\data_get(...func_get_args());
	}
}
if (!function_exists('head')) {
	function head() {
		return \RWP\Vendor\head(...func_get_args());
	}
}
if (!function_exists('last')) {
	function last() {
        return \RWP\Vendor\last(...func_get_args());
    }
}
if (!function_exists('h')) {
    function h() {
        return \RWP\Vendor\h(...func_get_args());
    }
}
if (!function_exists('getExceptionMsg')) {
    function getExceptionMsg() {
        return \RWP\Vendor\getExceptionMsg(...func_get_args());
    }
}
if (!function_exists('sendPage')) {
    function sendPage() {
        return \RWP\Vendor\sendPage(...func_get_args());
	}
}

return $loader;
