<?php
/** ============================================================================
 * Core
 *
 * @package   RWP\/includes/engine/Interfaces/CoreInterface.php
 * @since     1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 - 2021 RIESTER Advertising Agency
 * @license   GPL-2.0+
 * ========================================================================== */


namespace RWP\Engine\Interfaces;

if ( ! \defined( 'ABSPATH' ) ) {
    die( 'FU!' );
}
interface Core {

    /**
     *  @return string current plugin version
     */
    public function version();

    /**
     *  Return locations where to look for assets and map them to URLs.
     *
     *  @return string[] {
     *      @type string $asset_path => $asset_url,
     * }
     */
    public function get_asset_roots();
}
