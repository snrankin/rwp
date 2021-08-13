/**
 * ============================================================================
 * plugin
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

const rwp = window.rwp || {}; // eslint-disable-line

import utils from './util/utils';

Object.assign(rwp, utils);

window.rwp = {};

Object.assign(window.rwp, rwp);
