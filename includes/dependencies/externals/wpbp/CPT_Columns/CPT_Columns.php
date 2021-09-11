<?php

namespace RWP\Vendor\WPBP\CPT_Columns;

/** ============================================================================
 * CPT_Columns
 *
 * Simple class to add remove and manage admin post columns
 *
 * Based on Ohad Raz - https://en.bainternet.info/custom-post-types-columns/
 *
 * - The classes read the meta field of the CPT ID and enable the sorting
 * - Makes it possible remove other columns
 * - Supports 5 type of object natively:
 *     1. Title,
 *     2. Thumbnail,
 *     3. Author,
 *     4. Custom taxonomy,
 *     5. Custom Field
 * - Add a filter cpt_columns_text_{column_name_id} in Title type
 * - prefix/suffix values are for all the objects except post_thumb
 * - New features by Mte90:
 *     - Fix for def value
 *     - New order columns value
 *     - Custom callback for the value
 *     - Support for author type
 *     - Support for sort for custom_value
 *
 * @package   RWP_Vendor\WPBP\CPT_Columns
 * @since     0.2.0
 * @version   0.1
 * @author    Ohad Raz <admin@bainternet.info>
 * @copyright 2013 Ohad Raz
 * @license   GPL-2.0+
 * ========================================================================== */
class CPT_Columns
{
    /**
     * $cpt_columns
     *
     * holds columns
     * @var array
     */
    public $cpt_columns = array();
    /**
     * $cpt_remove_columns
     *
     * holds columns to be removed
     * @var array
     */
    public $cpt_remove_columns = array();
    /**
     * $cpt_sortable_columns
     *
     * holds sortable columns
     * @var array
     */
    public $cpt_sortable_columns = array();
    /**
     * $cpt_name
     *
     * Holds custom post type name
     * @var string
     */
    public $cpt_name = '';
    /**
     * $replace
     *
     * Should coulmns be replace (true) or added (false)
     * @var boolean
     */
    public $replace = \false;
    /**
     * __construct
     *
     * @author Ohad Raz <admin@bainternet.info>
     * @since 0.1
     * @param string  $cpt     custom post type name
     * @param boolean $replace (optional) replace or add
     */
    function __construct($cpt = '', $replace = \false)
    {
        $this->cpt_name = $cpt;
        $this->replace = $replace;
        //add columns
         \add_filter("manage_{$cpt}_posts_columns", array($this, '_cpt_columns'), 50);
        //remove columns
         \add_filter("manage_{$cpt}_posts_columns", array($this, '_cpt_columns_remove'), 60);
        //display columns
         \add_action("manage_{$cpt}_posts_custom_column", array($this, '_cpt_custom_column'), 50, 2);
        //sortable columns
         \add_filter("manage_edit-{$cpt}_sortable_columns", array($this, "_sortable_columns"), 50);
        //sort order
         \add_filter('pre_get_posts', array($this, '_column_orderby'), 50);
    }
    /**
     * _cpt_columns
     *
     * @author Ohad Raz <admin@bainternet.info> & Mte90 <mte90net@gmail.com>
     * @since 0.2
     * @param  array $defaults
     * @return array
     */
    function _cpt_columns($defaults)
    {
        global $typenow;
        if ($this->cpt_name == $typenow) {
            $tmp = array();
            if ($this->replace) {
                foreach ($this->cpt_columns as $key => $args) {
                    $tmp[$key] = $args['label'];
                }
                return $tmp;
            } else {
                foreach ($this->cpt_columns as $key => $args) {
                    $tmp[$key] = $args['label'];
                    if (isset($args['order'])) {
                        $before = \array_slice($defaults, 0, $args['order']);
                        $after = \array_slice($defaults, $args['order']);
                        $return = \array_merge($before, (array) $tmp);
                        $defaults = \array_merge($return, $after);
                    } else {
                        $defaults = \array_merge($defaults, $tmp);
                    }
                    $tmp = array();
                }
            }
        }
        return $defaults;
    }
    /**
     * _cpt_columns_remove
     *
     * used to remove columns
     * @author Ohad Raz <admin@bainternet.info>
     * @since 0.1
     * @param  array $columns
     * @return array
     */
    function _cpt_columns_remove($columns)
    {
        foreach ($this->cpt_remove_columns as $key) {
            if (isset($columns[$key])) {
                unset($columns[$key]);
            }
        }
        return $columns;
    }
    /**
     * _sortable_columns
     *
     * sets sortable columns
     * @author Ohad Raz <admin@bainternet.info>
     * @since 0.1
     * @param  array $columns
     * @return array
     */
    function _sortable_columns($columns)
    {
        global $typenow;
        if ($this->cpt_name == $typenow) {
            foreach ($this->cpt_sortable_columns as $key => $args) {
                $columns[$key] = $key;
            }
        }
        return $columns;
    }
    /**
     * _cpt_custom_column
     *
     * calls  \do_column() when the column is set
     * @author Ohad Raz <admin@bainternet.info>
     * @since 0.1
     * @param  string $column_name column name
     * @param  int $post_id     post ID
     * @return void
     */
    function _cpt_custom_column($column_name, $post_id)
    {
        if (isset($this->cpt_columns[$column_name])) {
            $this->do_column($post_id, $this->cpt_columns[$column_name], $column_name);
        }
    }
    /**
     *  \do_column
     *
     * used to display the column
     * @author Ohad Raz <admin@bainternet.info>
     * @since 0.1
     * @param  int $post_id     	post ID
     * @param  array $column      	column args
     * @param  string $column_name 	column name
     * @return void
     */
    function do_column($post_id, $column, $column_name)
    {
        if (\in_array($column['type'], array('text', 'thumb', 'post_meta', 'custom_tax'))) {
            echo $column['prefix'];
        }
        switch ($column['type']) {
            case 'text':
                echo apply_filters('cpt_columns_text_' . $column_name, $column['text'], $post_id, $column, $column_name);
                break;
            case 'thumb':
                if (has_post_thumbnail($post_id)) {
                    the_post_thumbnail($column['size']);
                } else {
                    echo 'N/A';
                }
                break;
            case 'post_meta':
                $tmp =  \get_post_meta($post_id, $column['meta_key'], \true);
                echo !empty($tmp) ? $tmp : $column['def'];
                break;
            case 'author':
                $author_id =  \get_post_field('post_author', $post_id);
                $post_type =  \get_post_type($post_id);
                echo '<a href="' . admin_url() . 'edit.php?post_type=' . $post_type . '&author=' . $author_id . '">' .  \get_the_author_meta('user_nicename', $author_id) . '</a>';
                break;
            case 'custom_tax':
                $post_type =  \get_post_type($post_id);
                $terms =  \get_the_terms($post_id, $column['taxonomy']);
                if (!empty($terms)) {
                    foreach ($terms as $term) {
                        $href = "edit.php?post_type={$post_type}&{$column['taxonomy']}={$term->slug}";
                        $name =  \esc_html(sanitize_term_field('name', $term->name, $term->term_id, $column['taxonomy'], 'edit'));
                        $post_terms[] = "<a href='{$href}'>{$name}</a>";
                    }
                    echo \join(', ', $post_terms);
                } else {
                    echo '';
                }
                break;
            case 'custom_value':
                if (isset($column['callback'])) {
                    if (\is_callable($column['callback'])) {
                        echo \call_user_func($column['callback'], $post_id);
                    } else {
                        echo $column['callback'] . ' is not a callable object!';
                    }
                } else {
                    echo 'The \'callback\' parameter is not define!';
                }
                break;
        }
        if (\in_array($column['type'], array('text', 'thumb', 'post_meta', 'custom_tax'))) {
            echo $column['suffix'];
        }
    }
    /**
     * _column_orderby
     *
     * used to roder by meta keys
     * @author Ohad Raz <admin@bainternet.info>
     * @since 0.1
     * @param  object $query
     * @return void
     */
    function _column_orderby($query)
    {
        if (!is_admin()) {
            return;
        }
        $orderby = $query->get('orderby');
        if (!empty($orderby) && isset($this->cpt_sortable_columns[$orderby]) && $this->cpt_sortable_columns[$orderby]['type'] === 'custom_value') {
            $query->set('orderby', 'meta_value');
            //$query->set( 'meta_key', $this->cpt_sortable_columns[ $orderby ][ 'meta_key' ] );
            $query->set('meta_query', array('relation' => 'OR', array('key' => $this->cpt_sortable_columns[$orderby]['meta_key'], 'compare' => 'NOT EXISTS', 'value' => ''), array('key' => $this->cpt_sortable_columns[$orderby]['meta_key'], 'compare' => 'EXISTS')));
        } else {
            $keys = \array_keys((array) $this->cpt_sortable_columns);
            if (\in_array($orderby, $keys)) {
                //order by meta
                if ('post_meta' == $this->cpt_sortable_columns[$orderby]['type']) {
                    $query->set('meta_key', $orderby);
                    $query->set('orderby', $this->cpt_sortable_columns[$orderby]['orderby']);
                }
            }
        }
    }
    /**
     *  \add_column
     *
     * used to add column
     * @author Ohad Raz <admin@bainternet.info>
     * @since 0.1
     * @param string $key column id
     * @param array $args column arguments
     * @return void
     */
    function add_column($key, $args)
    {
        $def = array(
            'label' => 'column label',
            'size' => array('80', '80'),
            'taxonomy' => '',
            'meta_key' => '',
            'sortable' => \false,
            'text' => '',
            'type' => 'native',
            //'native','post_meta','custom_tax',text
            'orderby' => 'meta_value',
            'prefix' => '',
            'suffix' => '',
            'def' => '',
        );
        $this->cpt_columns[$key] = \array_merge($def, $args);
        if ($this->cpt_columns[$key]['sortable']) {
            $this->cpt_sortable_columns[$key] = $this->cpt_columns[$key];
        }
    }
    /**
     *  \remove_column
     *
     * Used to remove columns
     *
     * @author Ohad Raz <admin@bainternet.info>
     * @since 0.1
     * @param  string $key column key to be removed
     * @return void
     */
    function remove_column($key)
    {
        $this->cpt_remove_columns[] = $key;
    }
}
