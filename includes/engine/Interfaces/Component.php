<?php
/** ============================================================================
 * ComponentInterface
 *
 * @package   RWP\/includes/engine/Interfaces/ComponentInterface.php
 * @since     0.9.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */

namespace RWP\Engine\Interfaces;

if ( ! \defined( 'ABSPATH' ) ) {
    die( 'FU!' );
}
interface Component {

    /**
     * Called on plugin activation
	 *
	 * @param bool $network_wide True if active in a multiste, false if classic
	 *                           site.
     *
     * @return array {
     *     @type bool     $success   Was the deactivation successful
	 *     @type string[] $messages  An array of messages
     * }
     */
    public function activate( $network_wide = false);

    /**
     * Called on plugin upgrade
	 *
     * @param  string  $new_version
     * @param  string  $old_version Version stored in the database
	 *
     * @return array {
     *    @type bool     $success   Was the upgrade successful
	 *    @type string[] $messages  An array of messages
     * }
     */

    public function upgrade( $new_version, $old_version);

    /**
     * Called on plugin deactivation
	 *
	 * @param bool $network_wide True if WPMU superadmin uses "Network
	 *                           Deactivate" action, false if WPMU is disabled
	 *                           or plugin is deactivated on an individual blog.
     * @return array {
     *     @type bool     $success   Was the deactivation successful
	 *     @type string[] $messages  An array of messages
     * }
     */
    public function deactivate( $network_wide = false );

    /**
     * Called on plugin uninstall
	 *
     * @return array {
     *     @type bool     $success   Was the uninstall successful
	 *     @type string[] $messages  An array of messages
     * }
     */
    public function uninstall();

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since 0.9.0
	 * @return array {
     *     @type bool     $success   Was the deactivation successful
	 *     @type string[] $messages  An array of messages
     * }
	 */

	public function single_activate();

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since 0.9.0
	 * @return array {
     *     @type bool     $success   Was the deactivation successful
	 *     @type string[] $messages  An array of messages
     * }
	 */
	public function single_deactivate();
}
