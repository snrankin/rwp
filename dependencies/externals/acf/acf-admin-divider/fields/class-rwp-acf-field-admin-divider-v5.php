<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('rwp_acf_field_admin_divider') ) :


class rwp_acf_field_admin_divider extends acf_field {


	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct( $settings ) {

		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/

		$this->name = 'admin_divider';


		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/

		$this->label = __('Admin Divider', 'rwp');


		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/

		$this->category = 'layout';

		//$this->public = false;

		$this->show_in_rest = false;

		$this->defaults = array(
            'spacer'      => false,
        );

		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/

		$this->settings = $settings;


		// do not delete!
    	parent::__construct();

		 // Hooks
        add_filter('acfe/field_wrapper_attributes/type=admin_divider',    array($this, 'field_wrapper_attributes'), 10, 2);

	}

	function field_wrapper_attributes($wrapper, $field){

		if($field['spacer']){

            $wrapper['class'] .= ' acf-field-admin-spacer';

        }

        return $wrapper;

    }


	function render_field_settings($field){

        // endpoint
        acf_render_field_setting($field, array(
            'label'         => __('Make Spacer','acf'),
            'instructions'  => __('Remove the ' . esc_html( '<hr>' ), 'acf'),
            'name'          => 'spacer',
            'type'          => 'true_false',
            'ui'            => 1,
            'class'         => 'acf-field-admin-spacer',
        ));

    }

	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param   $field - an array holding all the field's data
	*
	*  @type    action
	*  @since   3.6
	*  @date    23/01/13
	*/

	function render_field( $field ) {

		if(!$field['spacer']){

            echo '<hr>';

        }
	}

	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function input_admin_enqueue_scripts() {

		// vars
		$url = $this->settings['url'];
		$version = $this->settings['version'];


		// register & include CSS
		wp_register_style('acf-field-admin-divider', "{$url}assets/css/input.css", array('acf-input'), $version);
		wp_enqueue_style('acf-field-admin-divider');

	}

	/*
	*  load_field()
	*
	*  This filter is appied to the $field after it is loaded from the database
	*
	*  @type    filter
	*  @since   3.6
	*  @date    23/01/13
	*
	*  @param   $field - the field array holding all the field options
	*
	*  @return  $field - the field array holding all the field options
	*/
	function load_field( $field ) {

		// remove name to avoid caching issue
		$field['name'] = '';

		// remove name to avoid caching issue
		$field['label'] = 'Divider';

		// remove instructions
		$field['instructions'] = '';

		// remove required to avoid JS issues
		$field['required'] = 0;

		// set value other than 'null' to avoid ACF loading / caching issue
		$field['value'] = false;

		// return
		return $field;
	}
}


// initialize
new rwp_acf_field_admin_divider( $this->settings );


// class_exists check
endif;

?>
