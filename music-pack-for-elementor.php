<?php

/**
 * Plugin Name: Music Pack for Elementor
 * Plugin URI: https://musicpack.smartwpress.com/
 * Description: Music Pack for Elementor offers a complete set of tools for musicians websites. Includes custom post types, Elementor widgets and professionally designed Elementor templates.
 * Version: 1.6
 * Tested up to: 6.6
 * Elementor tested up to: 3.24.7
 * Author: SmartWPress
 * Author URI: https://www.smartwpress.com
 * Text Domain: music-pack
 * Domain Path: /languages
 * License: GNU General Public License version 2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( !function_exists( 'mpack_fs' ) ) {
    // Create a helper function for easy SDK access.
    function mpack_fs() {
        global $mpack_fs;
        if ( !isset( $mpack_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $mpack_fs = fs_dynamic_init( array(
                'id'              => '12071',
                'slug'            => 'music-pack-for-elementor',
                'premium_slug'    => 'music-pack-premium',
                'type'            => 'plugin',
                'public_key'      => 'pk_dcc1400d3fa2abbc1abd156958f50',
                'is_premium'      => false,
                'premium_suffix'  => 'PRO',
                'has_addons'      => false,
                'has_paid_plans'  => true,
                'trial'           => array(
                    'days'               => 7,
                    'is_require_payment' => false,
                ),
                'has_affiliation' => 'selected',
                'menu'            => array(
                    'slug'       => 'mpack-dashboard',
                    'first-path' => 'admin.php?page=mpack-dashboard',
                ),
                'is_live'         => true,
            ) );
        }
        return $mpack_fs;
    }

    // Init Freemius.
    mpack_fs();
    // Signal that SDK was initiated.
    do_action( 'mpack_fs_loaded' );
}
if ( !defined( 'MPACK_VERSION' ) ) {
    define( 'MPACK_VERSION', '1.6' );
}
if ( !defined( 'MPACK_DIR_PATH' ) ) {
    define( 'MPACK_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'MPACK_TEMPLATE_PATH' ) ) {
    define( 'MPACK_TEMPLATE_PATH', plugin_dir_path( __FILE__ ) . 'templates/' );
}
if ( !defined( 'MPACK_DIR_URL' ) ) {
    define( 'MPACK_DIR_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'MPACK_BASE' ) ) {
    define( 'MPACK_BASE', plugin_basename( __FILE__ ) );
}
if ( !defined( 'MPACK_PLUGIN_FILE' ) ) {
    define( 'MPACK_PLUGIN_FILE', __FILE__ );
}
require_once MPACK_DIR_PATH . 'classes/core/load-music-pack-for-elementor.php';