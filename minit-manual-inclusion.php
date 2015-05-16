<?php

/**
 * The Minit Manual Inclusion Plugin
 *
 * Use Minit only for manually whitelisted files.
 *
 * @package Minit_Manual_Inclusion
 * @subpackage Main
 */

/**
 * Plugin Name: Minit Manual Inclusion
 * Plugin URI:  http://blog.milandinic.com/wordpress/plugins/
 * Description: Use Minit only for manually whitelisted files.
 * Author:      Milan Dinić
 * Author URI:  http://blog.milandinic.com/
 * Version:     1.0-beta-1
 * License:     GPL
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Initialize Minit_Manual_Inclusion.
 *
 * Load class when all plugins are loaded
 * so that other plugins can overwrite it.
 *
 * @since 1.0
 */
function minit_manual_inclusion_load() {
	global $minit_manual_inclusion;

	if ( ! class_exists( 'Minit' ) ) {
		return;
	}

	require_once dirname( __FILE__ ) . '/inc/class-minit-manual-inclusion.php';

	$minit_manual_inclusion = new Minit_Manual_Inclusion;
}
add_action( 'plugins_loaded', 'minit_manual_inclusion_load' );
