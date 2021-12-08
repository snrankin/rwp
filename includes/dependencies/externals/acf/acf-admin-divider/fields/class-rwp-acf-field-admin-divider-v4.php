<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('rwp_acf_field_admin_divider') ) :


class rwp_acf_field_admin_divider extends acf_field {

	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options


	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/

	function __construct( $settings )
	{
		// vars
		$this->name = 'admin_divider';
		$this->label = __('Admin Divider');
		$this->category = __('Layout','rwp'); // Basic, Content, Choice, etc
		$this->defaults = array();

		// settings
		$this->settings = $settings;


		// do not delete!
    	parent::__construct();

	}



	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function create_field( $field )
	{
		// vars
		$atts = array();

		// return
		echo acf_esc_html( '<div' . acf_esc_attrs($atts) . '><hr></div>' ); //phpcs:ignore
	}

}


// initialize
new rwp_acf_field_admin_divider( $this->settings );


// class_exists check
endif;

?>
