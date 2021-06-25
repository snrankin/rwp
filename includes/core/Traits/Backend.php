<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.1.0
 *
 * @package    RWP
 * @subpackage RWP/admin
 */

namespace RWP\Traits;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    RWP
 * @subpackage RWP/admin
 * @author     Your Name <email@example.com>
 */

trait Backend {

    /**
     * The registered database tables
     *
     * @since    1.0.0
     * @access   protected
     * @var      array|Collection $tables
     */

    public $tables = [
        'plugin' => "id MEDIUMINT(9) NOT NULL AUTO_INCREMENT, PRIMARY KEY (id)",
        'acf'    => "id MEDIUMINT(9) NOT NULL AUTO_INCREMENT, item_id TINYBLOB, acf LONGTEXT NOT NULL, PRIMARY KEY (id)"
    ];


    public function backend_hooks() {
        $this->add_action('admin_enqueue_scripts', $this, 'backend_assets', 100);
        // $this->add_action('enqueue_block_editor_assets', $this, 'editor_assets', 100);
        //$this->add_filter('admin_body_class', $this, 'admin_page_template_body_class');
        // $this->add_action('admin_head', $this, 'admin_head');
        $this->add_action('admin_init', $this, 'backend_init');
        // $this->add_action('admin_menu', $this, 'admin_menu');
        // $this->add_action('admin_notices', $this, 'admin_notices');
    }

    public function backend_init() {
    }

    /**
     * Add tables to WordPress Database
     *
     * @link https://codex.wordpress.org/Creating_Tables_with_Plugins
     * @return void
     */
    protected function add_tables() {
        $this->tables->each(function ($sql, $name) {
            $this->add_db_table($name, $sql);
        });
    }

    public function row_exists($column, $operator = '=', $val = null, $format = '%s', $table) {
        $query_results = $this->get_results($column, $operator, $val, $format, $table);
        if (count($query_results) == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function get_results($column, $operator = '=', $val = null, $format = '%s', $table) {
        global $wpdb;
        $table = $this->table_prefix($table);
        $query = $wpdb->prepare(
            "SELECT * FROM $table WHERE $column $operator $format",
            $val
        );
        $results = $wpdb->get_results($query);
        return $results;
    }

    /**
     * Add tables to WordPress Database
     *
     * @link https://codex.wordpress.org/Creating_Tables_with_Plugins
     * @return void
     */
    protected function add_db_table($name, $sql) {
        global $wpdb;

        if (!$this->tables->has($name)) {
            $this->tables->put($name, $sql);
        }

        $table_name = $this->table_prefix($name);
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name ($sql) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * @see http://plugin.michael-simpson.com/?page_id=101
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function remove_tables() {
        $this->tables->keys->each(function ($name) {
            $this->remove_db_table($name);
        });
    }

    /**
     * @see http://plugin.michael-simpson.com/?page_id=101
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function remove_db_table($table) {
        global $wpdb;
        $tableName = $this->table_prefix($table);
        $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
    }

    public function table_prefix($string, $case = 'snake') {
        global $wpdb;
        $prefix = $wpdb->prefix . $this->prefix;
        $prefix = rwp_change_case($prefix, $case);
        $string = rwp_change_case($string, $case);
        $pattern = "/^({$prefix})[\-|\_|\s|\/]/";
        // If $string is already prefixed, it is not prefixed again, it is returned without change
        if (!preg_match($pattern, $string)) { // false but not 0

            switch ($case) {
                case 'snake':
                    $string = $prefix . '_' . $string;
                    $string = sanitize_key($string);
                    break;
                case 'kebab':
                    $string = $prefix . '-' . $string;
                    $string = sanitize_key($string);
                    break;
                case 'slash':
                    $string = $prefix . '/' . $string;
                    break;
                default:
                    $string = __($prefix . ' ' . $string, 'rwp');
                    break;
            }
        }
        return $string;
    }

    /**
     * Register the styles and scripts for the admin area.
     *
     * @since    0.1.0
     */
    public function backend_assets() {
        $this->register_assets('admin');
        $this->enqueue_assets('admin');
    }

    /**
     * Register the styles and scripts for the admin area.
     *
     * @since    0.1.0
     */
    public function editor_assets() {
        $this->register_assets('editor');
        $this->enqueue_assets('editor');
    }


    /**
     * A Role Option is an option defined in getOptionMetaData() as a choice of WP standard roles, e.g.
     * 'CanDoOperationX' => array('Can do Operation X', 'Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber')
     * The idea is use an option to indicate what role level a user must minimally have in order to do some operation.
     * So if a Role Option 'CanDoOperationX' is set to 'Editor' then users which role 'Editor' or above should be
     * able to do Operation X.
     * Also see: canUserDoRoleOption()
     * @param  $optionName
     * @return string role name
     */
    public function get_role_option($option_name) {
        $roleAllowed = $this->get_option($option_name);
        if (!$roleAllowed || $roleAllowed == '') {
            $roleAllowed = 'Administrator';
        }
        return $roleAllowed;
    }

    /**
     * Given a WP role name, return a WP capability which only that role and roles above it have
     * http://codex.wordpress.org/Roles_and_Capabilities
     * @param  $roleName
     * @return string a WP capability or '' if unknown input role
     */
    protected function role_capability($role) {
        switch ($role) {
            case 'Super Admin':
                return 'manage_options';
            case 'Admin':
            case 'Administrator':
                return 'manage_options';
            case 'Editor':
                return 'publish_pages';
            case 'Author':
                return 'publish_posts';
            case 'Contributor':
                return 'edit_posts';
            case 'Subscriber':
                return 'read';
            case 'Anyone':
                return 'read';
        }
        return '';
    }

    /**
     * @param  $optionName string name of a Role option (see comments in getRoleOption())
     * @return bool indicates if the user has adequate permissions
     */
    public function current_user_is($role) {
        if ('Anyone' == $role) {
            return true;
        }
        $capability = $this->role_capability($role);
        return current_user_can($capability);
    }

    public function options_init() {
    }



    /**
     * Creates HTML for the Administration page to set options for this plugin.
     * Override this method to create a customized page.
     * @return void
     */
    public function menu_init() {
        $page_title = __($this->name . ' Settings', 'rwp');
        $menu_title = $this->prefix('settings', 'title');
        $capability = $this->role_capability('Admin');
        $menu_slug  = $this->prefix('settings');
        $icon_url   = $this->icon;
        $function   = [$this, 'render_options_page'];
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url);

        if ($this->pages->isNotEmpty()) {
            $this->pages->each(function ($page) {
                $page = $this->init_page($page);
                add_submenu_page($page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['function']);
            });
        }
    }
}
