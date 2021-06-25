<?php

/** ============================================================================
 * Lifecycle
 *
 * @package RWP\Traits\Lifecycle
 * @version 1.0.0
 * @author  RIESTER <wordpress@riester.com>
 * ========================================================================== */

namespace RWP\Traits;

trait Lifecycle {

    public function install() {
        //$this->add_tables();
        if ($this->is_upgrade()) {
            $this->upgrade();
        }

        // Record the installed version
        $this->save_version();

        // To avoid running install() more then once
        $this->mark_installed();
    }

    public function uninstall() {
        $this->remove_tables();
        $this->delete_options();
        $this->mark_uninstalled();
    }

    /**
     * Perform any version-upgrade activities prior to activation (e.g. database changes)
     * @return void
     */
    public function upgrade() {
    }

    /**
     * This class defines all code necessary to run during the plugin's activation.
     * @return void
     */
    public function activate() {
        $hook = $this->prefix('uninstall');
        register_uninstall_hook(RWP_PLUGIN_FILE, $hook);
        if (!$this->is_installed()) {
            $this->install();
        }
    }

    /**
     * This class defines all code necessary to run during the plugin's deactivation.
     * @return void
     */
    public function deactivate() {
    }



    /**
     * Convenience function for creating AJAX URLs.
     *
     * @param $actionName string the name of the ajax action registered in a call like
     * add_action('wp_ajax_actionName', array(&$this, 'functionName'));
     *     and/or
     * add_action('wp_ajax_nopriv_actionName', array(&$this, 'functionName'));
     *
     * If have an additional parameters to add to the Ajax call, e.g. an "id" parameter,
     * you could call this function and append to the returned string like:
     *    $url = $this->getAjaxUrl('myaction&id=') . urlencode($id);
     * or more complex:
     *    $url = sprintf($this->getAjaxUrl('myaction&id=%s&var2=%s&var3=%s'), urlencode($id), urlencode($var2), urlencode($var3));
     *
     * @return string URL that can be used in a web page to make an Ajax call to $this->functionName
     */
    public function getAjaxUrl($actionName) {
        return admin_url('admin-ajax.php') . '?action=' . $actionName;
    }

    /**
     * @return bool indicating if the plugin is installed already
     */
    public function is_installed() {
        return $this->get_option('installed', false) == true;
    }

    /**
     * Note in DB that the plugin is installed
     * @return null
     */
    protected function mark_installed() {
        return $this->update_option('installed', true);
    }

    /**
     * Note in DB that the plugin is uninstalled
     * @return bool returned form delete_option.
     * true implies the plugin was installed at the time of this call,
     * false implies it was not.
     */
    protected function mark_uninstalled() {
        return $this->delete_option('installed');
    }

    /**
     * Set a version string in the options. This is useful if you install upgrade and
     * need to check if an older version was installed to see if you need to do certain
     * upgrade housekeeping (e.g. changes to DB schema).
     * @return null
     */
    protected function get_version() {
        return $this->get_option('version');
    }

    /**
     * Useful when checking for upgrades, can tell if the currently installed version is earlier than the
     * newly installed code. This case indicates that an upgrade has been installed and this is the first time it
     * has been activated, so any upgrade actions should be taken.
     * @return bool true if the version saved in the options is earlier than the version declared in getVersion().
     * true indicates that new code is installed and this is the first time it is activated, so upgrade actions
     * should be taken. Assumes that version string comparable by version_compare, examples: '1', '1.1', '1.1.1', '2.0', etc.
     */
    public function is_upgrade() {

        $plugin_version = $this->version;
        $saved_version = $this->get_option('version', $this->version);
        if (version_compare($plugin_version, $saved_version, '<')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Record the installed version to options.
     * This helps track was version is installed so when an upgrade is installed, it should call this when finished
     * upgrading to record the new current version
     * @return void
     */
    protected function save_version() {
        return $this->update_option('version', $this->version);
    }
}
