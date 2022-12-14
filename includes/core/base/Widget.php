<?php

/** ============================================================================
 * WordPress Widgets Helper Class
 *
 * @link      https://github.com/WPBP/Widgets-Helper
 * @since     0.2.0
 * @version   0.9.02
 * @author    Matt Varone & riesurya & Mte90
 * ========================================================================== */

namespace RWP\Base;

if ( ! \defined( 'ABSPATH' ) ) {
    exit;
}

abstract class Widget extends \WP_Widget {

    public $classname;
    public $fields;
    public $width;
    public $height;
    public $slug;
    public $options;
    public $instance;

    /**
     * Create Widget
     *
     * Creates a new widget and sets it's labels, description, fields and options
     *
     * @access   public
     * @param    array
     * @return   void
     */
    public function create_widget( $args ) {
        // settings some defaults
        $defaults = array(
            'label'       => '',
            'description' => '',
            'slug'        => '',
            'classname'   => '',
            'width'       => array(),
            'height'      => array(),
            'fields'      => array(),
            'options'     => array(),
        );
        // parse and merge args with defaults
        $args = \wp_parse_args( $args, $defaults );
        // extract each arg to its own variable
        $label       = data_get( $args, 'label', '' );
        $description = data_get( $args, 'description', '' );
        $slug        = data_get( $args, 'slug', '' );
        $classname   = data_get( $args, 'classname', '' );
        $width       = data_get( $args, 'width', array() );
        $height      = data_get( $args, 'height', array() );
        $fields      = data_get( $args, 'fields', array() );
        $options     = data_get( $args, 'options', array() );

        // set the widget vars

        $this->classname = $slug;
        $this->fields    = $fields;
        $this->width     = $width;
        $this->height    = $height;

        if ( ! empty( $classname ) ) {
            $this->classname = $classname;
        }
        // Workaround for https://core.trac.wordpress.org/ticket/44098#comment:2
        if ( empty( $slug ) ) {
            $slug = \preg_replace( '/(wp_)?widget_/', '', \strtolower( \get_class( $this ) ) );
            $slug = \explode( '\\', $slug );
            $slug = \end( $slug );
        }
        $this->slug = $slug;
        // check options
        $this->options = array(
            'classname'   => $this->classname,
            'description' => $description,
        );
        if ( ! empty( $options ) ) {
            $this->options = \array_merge( $this->options, $options );
        }
        // call \WP_Widget to create the widget
        parent::__construct( $this->slug, $label, $this->options, $this->width, $this->height );
    }
    /**
     * Form
     *
     * Creates the settings form.
     *
     * @param    array
     * @return   void
     */
    public function form( $instance ) {
        $this->instance = $instance;
        echo $this->create_fields(); //phpcs:ignore
        \do_action( 'rwp_print_form' );
    }
    /**
     * Update Fields
     *
     * @param    array
     * @param    array
     * @return   array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $this->before_update_fields();
        foreach ( $this->fields as $key ) {
            $slug = $key['id'];
            if ( isset( $key['validate'] ) ) {
                if ( \false === $this->validate( $key['validate'], $new_instance[ $slug ] ) ) {
                    return $instance;
                }
            }
            $instance[ $slug ] = \wp_strip_all_tags( $new_instance[ $slug ] );
            if ( isset( $key['filter'] ) ) {
                $instance[ $slug ] = $this->filter( $key['filter'], $new_instance[ $slug ] );
            }
        }
        return $this->after_validate_fields( $instance );
    }
    /**
     * Before Validate Fields
     *
     * Allows to hook code on the update.
     *
     * @access   public
     * @param    string
     * @return   string
     */
    public function before_update_fields( $instance = '' ) {
        return $instance;
    }
    /**
     * After Validate Fields
     *
     * Allows to modify the output after validating the fields.
     *
     * @access   public
     * @param    string
     * @return   string
     */
    public function after_validate_fields( $instance = '' ) {
        return $instance;
    }
    /**
     * Validate
     *
     * @param    string
     * @param    string
     * @return   boolean
     */
    public function validate( $rules, $value ) {
        $rules = \explode( '|', $rules );
        if ( empty( $rules ) || \count( $rules ) < 1 ) {
            return \true;
        }
        foreach ( $rules as $rule ) {
            if ( \false === $this->do_validation( $rule, $value ) ) {
                return \false;
            }
        }
        return \true;
    }


    /**
     * Filter
     *
     * @param mixed $filters
     * @param mixed $value
     * @return mixed
     */
    public function filter( $filters, $value ) {
        $filters = \explode( '|', $filters );
        if ( empty( $filters ) || \count( $filters ) < 1 ) {
            return $value;
        }
        foreach ( $filters as $filter ) {
            $value = $this->do_filter( $filter, $value );
        }
        return $value;
    }
    /**
     * Do Validation Rule
     *
     * @param    string
     * @param    string
     * @return   boolean
     */

    public function do_validation( $rule, $value = '' ) {
		if ( 'alpha' === $rule ) {
			return \ctype_alpha( $value );
		}
		if ( 'alpha_numeric' === $rule ) {
			return \ctype_alnum( $value );
		}
		if ( 'alpha_dash' === $rule ) {
			return \preg_match( '/^[a-z0-9-_]+$/', $value );
		}
		if ( 'numeric' === $rule ) {
			return \ctype_digit( $value );
		}
		if ( 'integer' === $rule ) {
			return (bool) \preg_match( '/^[\\-+]?[0-9]+$/', $value );
		}
		if ( 'boolean' === $rule ) {
			return \is_bool( $value );
		}
		if ( 'email' === $rule ) {
			return \is_email( $value );
		}
		if ( 'decimal' === $rule ) {
			return (bool) \preg_match( '/^[\\-+]?[0-9]+\\.[0-9]+$/', $value );
		}
		if ( 'natural' === $rule ) {
			return (bool) \preg_match( '/^[0-9]+$/', $value );
		}
		if ( 'natural_not_zero' === $rule ) {
			if ( 0 === $value || ! \preg_match( '/^[0-9]+$/', $value ) ) {
				return \false;
			}
			return \true;
		}
        if ( \method_exists( $this, $rule ) ) {
			return $this->{$rule}( $value );
		}
		return \false;
    }
    /**
     * Do Filter
     *
     * @param    string
     * @param    string
     * @return   boolean
     */
    public function do_filter( $filter, $value = '' ) {
        switch ( $filter ) {
            case 'strip_tags':
                $value = \strip_tags( $value ); // phpcs:ignore
                break;
            case 'wp_strip_all_tags':
                $value = \wp_strip_all_tags( $value );
                break;
            case 'esc_attr':
                $value = \esc_attr( $value );
                break;
            case 'esc_url':
                $value = \esc_url( $value );
                break;
            case 'esc_textarea':
                $value = \esc_textarea( $value );
                break;
            default:
                if ( \method_exists( $this, $filter ) ) {
                    $value = $this->{$filter}( $value );
                }
                break;
        }

		return $value;
    }
    /**
     * Create Fields
     *
     * Creates each field defined.
     *
     * @param    string
     * @return   string
     */
    public function create_fields( $out = '' ) {
        $out = $this->before_create_fields( $out );
        if ( ! empty( $this->fields ) ) {
            foreach ( $this->fields as $key ) {
                $out .= $this->create_field( $key );
            }
        }
        $out = $this->after_create_fields( $out );
        return $out;
    }
    /**
     * Before Create Fields
     *
     * Allows to modify code before creating the fields.
     *
     * @access   public
     * @param    string
     * @return   string
     */
    public function before_create_fields( $out = '' ) {
        return $out;
    }
    /**
     * After Create Fields
     *
     * Allows to modify code after creating the fields.
     *
     * @access   public
     * @param    string
     * @return   string
     */
    public function after_create_fields( $out = '' ) {
        return $out;
    }
    /**
     * Create Fields
     *

     * @param    string
     * @param    string
     * @return   string
     */
    public function create_field( $key, $out = '' ) {
        /* Set Defaults */
        $key['std'] = isset( $key['std'] ) ? $key['std'] : '';
        $slug = $key['id'];
        if ( isset( $this->instance[ $slug ] ) ) {
            $key['value'] = empty( $this->instance[ $slug ] ) ? '' : \wp_strip_all_tags( $this->instance[ $slug ] );
        } else {
            unset( $key['value'] );
        }
        /* Set field id and name  */
        $key['_id'] = $this->get_field_id( $slug );
        $key['_name'] = $this->get_field_name( $slug );
        /* Set field type */
        if ( ! isset( $key['type'] ) ) {
            $key['type'] = 'text';
        }
        /* Prefix method */
        $field_method = 'create_field_' . \str_replace( '-', '_', $key['type'] );
        /* Check for <p> Class */
        $p = isset( $key['class-p'] ) ? '<p class="' . $key['class-p'] . '">' : '<p>';
        /* Run method */
        if ( \method_exists( $this, $field_method ) ) {
            $out .= $p . $this->{$field_method}( $key ) . '</p>';
        }

        return $out;
    }
    /**
     * Field Text
     *

     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_text( $key, $out = '' ) {
        $out .= $this->create_field_label( $key['name'], $key['_id'] ) . '<br/>';
        $out .= '<input type="text" ';
        if ( isset( $key['class'] ) ) {
            $out .= 'class="' . \esc_attr( $key['class'] ) . '" ';
        }
        $value = isset( $key['value'] ) ? $key['value'] : $key['std'];
        $out .= 'id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '" value="' . \esc_attr( $value ) . '" ';
        if ( isset( $key['size'] ) ) {
            $out .= 'size="' . \esc_attr( $key['size'] ) . '" ';
        }
        $out .= ' />';
        if ( isset( $key['desc'] ) ) {
            $out .= '<br/><small class="description">' . \esc_html( $key['desc'] ) . '</small>';
        }
        return $out;
    }
    /**
     * Field Textarea
     *

     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_textarea( $key, $out = '' ) {
        $out .= $this->create_field_label( $key['name'], $key['_id'] ) . '<br/>';
        $out .= '<textarea ';
        if ( isset( $key['class'] ) ) {
            $out .= 'class="' . \esc_attr( $key['class'] ) . '" ';
        }
        if ( isset( $key['rows'] ) ) {
            $out .= 'rows="' . \esc_attr( $key['rows'] ) . '" ';
        }
        if ( isset( $key['cols'] ) ) {
            $out .= 'cols="' . \esc_attr( $key['cols'] ) . '" ';
        }
        $value = isset( $key['value'] ) ? $key['value'] : $key['std'];
        $out .= 'id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '">' . \esc_html( $value );
        $out .= '</textarea>';
        if ( isset( $key['desc'] ) ) {
            $out .= '<br/><small class="description">' . \esc_html( $key['desc'] ) . '</small>';
        }
        return $out;
    }
    /**
     * Field Checkbox
     *

     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_checkbox( $key, $out = '' ) {
        $out .= $this->create_field_label( $key['name'], $key['_id'] );
        $out .= ' <input type="checkbox" ';
        if ( isset( $key['class'] ) ) {
            $out .= 'class="' . \esc_attr( $key['class'] ) . '" ';
        }
        $out .= 'id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '" value="1" ';
        if ( ( isset( $key['value'] ) && 1 === $key['value'] ) || ( ! isset( $key['value'] ) && 1 === $key['std'] ) ) {
            $out .= ' checked="checked" ';
        }
        $out .= ' /> ';
        if ( isset( $key['desc'] ) ) {
            $out .= '<br/><small class="description">' . \esc_html( $key['desc'] ) . '</small>';
        }
        return $out;
    }
    /**
     * Field Select
     *
     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_select( $key, $out = '' ) {
        $out .= $this->create_field_label( $key['name'], $key['_id'] ) . '<br/>';
        $out .= '<select id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '" ';
        if ( isset( $key['class'] ) ) {
            $out .= 'class="' . \esc_attr( $key['class'] ) . '" ';
        }
        $out .= '> ';
        $selected = isset( $key['value'] ) ? $key['value'] : $key['std'];
        foreach ( $key['fields'] as $field => $option ) {
            $out .= '<option value="' . \esc_attr( $option['value'] ) . '" ';
            if ( esc_attr( $selected ) === $option['value'] ) {
                $out .= ' selected="selected" ';
            }
            $out .= '> ' . \esc_html( $option['name'] ) . '</option>';
        }
        $out .= ' </select> ';
        if ( isset( $key['desc'] ) ) {
            $out .= '<br/><small class="description">' . \esc_html( $key['desc'] ) . '</small>';
        }
        return $out;
    }
    /**
     * Field Select with Options Group
     *

     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_select_group( $key, $out = '' ) {
        $out .= $this->create_field_label( $key['name'], $key['_id'] ) . '<br/>';
        $out .= '<select id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '" ';
        if ( isset( $key['class'] ) ) {
            $out .= 'class="' . \esc_attr( $key['class'] ) . '" ';
        }
        $out .= '> ';
        $selected = isset( $key['value'] ) ? $key['value'] : $key['std'];
        foreach ( $key['fields'] as $group => $fields ) {
            $out .= '<optgroup label="' . $group . '">';
            foreach ( $fields as $field => $option ) {
                $out .= '<option value="' . \esc_attr( $option['value'] ) . '" ';
                if ( esc_attr( $selected ) === $option['value'] ) {
                    $out .= ' selected="selected" ';
                }
                $out .= '> ' . \esc_html( $option['name'] ) . '</option>';
            }
            $out .= '</optgroup>';
        }
        $out .= '</select>';
        if ( isset( $key['desc'] ) ) {
            $out .= '<br/><small class="description">' . \esc_html( $key['desc'] ) . '</small>';
        }
        return $out;
    }
    /**
     * Field Number
     *

     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_number( $key, $out = '' ) {
        $out .= $this->create_field_label( $key['name'], $key['_id'] ) . '<br/>';
        $out .= '<input type="number" ';
        if ( isset( $key['class'] ) ) {
            $out .= 'class="' . \esc_attr( $key['class'] ) . '" ';
        }
        $value = isset( $key['value'] ) ? $key['value'] : $key['std'];
        $out .= 'id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '" value="' . \esc_attr( $value ) . '" ';
        if ( isset( $key['size'] ) ) {
            $out .= 'size="' . \esc_attr( $key['size'] ) . '" ';
        }
        $out .= ' />';
        if ( isset( $key['desc'] ) ) {
            $out .= '<br/><small class="description">' . \esc_html( $key['desc'] ) . '</small>';
        }
        return $out;
    }
    /**
     * Field Label
     *

     * @param    string
     * @param    string
     * @return   string
     * @since    1.5
     */
    public function create_field_label( $name = '', $id = '' ) {
        return '<label for="' . \esc_attr( $id ) . '">' . \esc_html( $name ) . ':</label>';
    }
    /**
     * Field Taxonomy
     *

     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_taxonomy( $key, $out = '' ) {
        $out .= $this->create_field_label( $key['name'], $key['_id'] );
        // Build taxonomy selection boxes
        $taxes = \get_taxonomies( '', 'names' );
        $out .= '<div class="inright">';
        $out .= '<select id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '" ';
        $out .= '> ';
        $selected = isset( $key['value'] ) ? $key['value'] : $key['std'];
        foreach ( $taxes as $tax ) {
            if ( ( 'link_category' === $tax || 'nav_menu' === $tax || 'post_format' === $tax ) && ! isset( $options['post_format'] ) ) {
                continue;
            }
            $taxonomy = \get_taxonomy( $tax );
            $posttypes_obj = $taxonomy->object_type;
            foreach ( $posttypes_obj as $posttype_obj => $posttype ) {
                $out .= '<option value="' . \esc_attr( $taxonomy->name ) . '" ';
                if ( esc_attr( $selected ) === $taxonomy->name ) {
                    $out .= ' selected="selected" ';
                }
                $out .= '> ' . \esc_attr( $taxonomy->label ) . '</option>';
            }
        }
        $out .= ' </select> ';
        $out .= '</div>';
        if ( isset( $key['desc'] ) ) {
            $out .= '<p class="description"><small>' . \esc_html( $key['desc'] ) . '</small></p>';
        }
        return $out;
    }
    /**
     * Field Taxonomy Term
     *

     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_taxonomyterm( $key, $out = '' ) {
        $out .= $this->create_field_label( $key['name'], $key['_id'] );
        // Build taxonomy selection boxes
        $taxes = \get_taxonomies( '', 'names' );
        foreach ( $taxes as $tax ) {
            if ( $tax !== $key['taxonomy'] ) {
                continue;
            }
            $taxonomy = \get_taxonomy( $tax );
            $terms = \get_terms($taxonomy->name, array(
                'orderby' => 'name',
                'parent'  => 0,
            ));
            $out .= '<div class="inright">';
            $out .= '<select id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '" ';
            $out .= '> ';
            $selected = isset( $key['value'] ) ? $key['value'] : $key['std'];
            $out .= '<option value="any"';
            if ( esc_attr( $selected ) === 'any' ) {
                $out .= ' selected="selected" ';
            }
            $out .= '>Any Categories</option>';
            foreach ( $terms as $term ) {

                $out .= '<option value="' . \esc_attr( $term->slug ) . '" ';
                if ( esc_attr( $selected ) === $term->slug ) {
                    $out .= ' selected="selected" ';
                }
                $out .= '> ' . \esc_html( $term->name ) . ' </option>';
            }
            $subterms = \get_terms( $taxonomy->name, array( 'parent' => $term->term_id ) );
            foreach ( $subterms as $subterm ) {
                $out .= '<option value="' . \esc_attr( $subterm->slug ) . '" ';
                if ( esc_attr( $selected ) === $subterm->slug ) {
                    $out .= ' selected="selected" ';
                }
                $out .= '> - ' . \esc_html( $subterm->name ) . ' </option>';
            }
            $out .= ' </select> ';
            $out .= '</div>';
        }
        if ( isset( $key['desc'] ) ) {
            $out .= '<p class="description"><small>' . \esc_html( $key['desc'] ) . '</small></p>';
        }
        return $out;
    }
    /**
     * Pages Select
     *

     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_pages( $key, $out = '' ) {
        $out .= '<p>' . $this->create_field_label( $key['name'], $key['_id'] ) . '</p>';
        $out .= '<select id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '" ';
        if ( isset( $key['class'] ) ) {
            $out .= 'class="' . \esc_attr( $key['class'] ) . '" ';
        }
        $out .= '> ';
        $selected = isset( $key['value'] ) ? $key['value'] : $key['std'];
        $pages = \get_pages( 'sort_column=post_parent,menu_order' );
        foreach ( $pages as $page ) {
            $out .= '<option value="' . \esc_attr( $page->ID ) . '" ';
            if ( esc_attr( $selected ) === $page->ID ) {
                $out .= ' selected="selected" ';
            }
            $out .= '>' . \esc_html( $page->post_title ) . '</option>';
        }
        $out .= ' </select> ';
        if ( isset( $key['desc'] ) ) {
            $out .= '<p class="description"><small>' . \esc_html( $key['desc'] ) . '</small></p>';
        }
        return $out;
    }
    /**
     * Post Select from spesific taxonomy
     *

     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_posttype( $key, $out = '' ) {
        $out .= '<p>' . $this->create_field_label( $key['name'], $key['_id'] ) . '</p>';
        $out .= '<select size="1" id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '" ';
        if ( isset( $key['class'] ) ) {
            $out .= 'class="' . \esc_attr( $key['class'] ) . '" ';
        }
        $out .= '> ';
        $selected = isset( $key['value'] ) ? $key['value'] : $key['std'];
        $args = array(
            'post_type'      => $key['posttype'],
            'order'          => 'ASC',
            'orderby'        => 'title',
            'posts_per_page' => -1,
        );
        $options_posts_obj = \get_posts( $args );
        foreach ( $options_posts_obj as $field_id ) {
            $out .= '<option value="' . \esc_attr( $field_id->ID ) . '" ';
            if ( esc_attr( $selected ) === $field_id->ID ) {
                $out .= ' selected="selected" ';
            }
            $out .= '>' . \esc_html( $field_id->post_title ) . '</option>';
        }
        $out .= ' </select> ';
        if ( isset( $key['desc'] ) ) {
            $out .= '<p class="description"><small>' . \esc_html( $key['desc'] ) . '</small></p>';
        }
        return $out;
    }
    /**
     * Field Hidden Input
     *

     * @param    array
     * @param    string
     * @return   string
     */
    public function create_field_hidden( $key, $out = '' ) {
        $out .= '<input type="hidden" ';
        $value = isset( $key['value'] ) ? $key['value'] : $key['std'];
        $out .= 'id="' . \esc_attr( $key['_id'] ) . '" name="' . \esc_attr( $key['_name'] ) . '" value="' . \esc_attr( $value ) . '" ';
        $out .= ' />';
        return $out;
    }
}
