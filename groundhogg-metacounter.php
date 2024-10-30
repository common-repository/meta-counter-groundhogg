<?php
/*
 * Plugin Name: Meta Counter For Groundhogg
 * Plugin URI:  https://www.affinityharmonics.com/elevate-your-brand
 * Description: Adds an action that lets you count any funnel step and stores it in a chosen meta field. 
 * Version: 1.0
 * Author: Affinity Design.
 * Author URI: https://affinitydesign.ca
 * Text Domain: groundhogg
 * Domain Path: /languages
 *
 * Meta Counter For Groundhogg is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Meta Counter For Groundhogg is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GROUNDHOGG_METACOUNTER_VERSION', '1.0' );
define( 'GROUNDHOGG_METACOUNTER_PREVIOUS_STABLE_VERSION', '0.3' );
define( 'GROUNDHOGG_METACOUNTER_NAME', 'Meta Counter' );

define( 'GROUNDHOGG_METACOUNTER__FILE__', __FILE__ );
define( 'GROUNDHOGG_METACOUNTER_PLUGIN_BASE', plugin_basename( GROUNDHOGG_METACOUNTER__FILE__ ) );
define( 'GROUNDHOGG_METACOUNTER_PATH', plugin_dir_path( GROUNDHOGG_METACOUNTER__FILE__ ) );

define( 'GROUNDHOGG_METACOUNTER_URL', plugins_url( '/', GROUNDHOGG_METACOUNTER__FILE__ ) );

define( 'GROUNDHOGG_METACOUNTER_ASSETS_PATH', GROUNDHOGG_METACOUNTER_PATH . 'assets/' );
define( 'GROUNDHOGG_METACOUNTER_ASSETS_URL', GROUNDHOGG_METACOUNTER_URL . 'assets/' );

add_action( 'plugins_loaded', function (){
    load_plugin_textdomain( GROUNDHOGG_METACOUNTER_TEXT_DOMAIN, false, basename( dirname( __FILE__ ) ) . '/languages' );
} );

define( 'GROUNDHOGG_METACOUNTER_TEXT_DOMAIN', 'groundhogg-metacounter' );

if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {
    add_action( 'admin_notices', function(){
        $message = sprintf( esc_html__( '%s requires PHP version %s+, plugin is currently NOT RUNNING.', 'groundhogg-metacounter' ), GROUNDHOGG_METACOUNTER_NAME, '5.6' );
        $html_message = sprintf( '<div class="notice notice-error">%s</div>', wpautop( $message ) );
        echo wp_kses_post( $html_message );
    } );
} elseif ( ! version_compare( get_bloginfo( 'version' ), '4.9', '>=' ) ) {
    add_action( 'admin_notices', function (){
        $message = sprintf( esc_html__( '%s requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'groundhogg-metacounter' ), GROUNDHOGG_METACOUNTER_NAME, '4.9' );
        $html_message = sprintf( '<div class="notice notice-error">%s</div>', wpautop( $message ) );
        echo wp_kses_post( $html_message );
    } );
} else {

    // Groundhogg is loaded, load now.
    if ( did_action( 'groundhogg/loaded' ) ){

        require GROUNDHOGG_METACOUNTER_PATH . 'includes/plugin.php';

    // Lazy load, wait for Groundhogg!
    } else {
        add_action('groundhogg/loaded', function () {
            require GROUNDHOGG_METACOUNTER_PATH . 'includes/plugin.php';
        });

        // Might not actually be loaded, so we'll check in later.
        add_action( 'admin_notices', function () {

            // Is not loaded!
            if ( ! defined( 'GROUNDHOGG_VERSION' ) ){
                $message = sprintf(esc_html__('Groundhogg is not currently active, it must be active for %s to work.', 'groundhogg-metacounter'), GROUNDHOGG_METACOUNTER_NAME );
                $html_message = sprintf('<div class="notice notice-warning">%s</div>', wpautop($message));
                echo wp_kses_post($html_message);
            }
        });
    }
}


