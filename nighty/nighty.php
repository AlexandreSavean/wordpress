<?php
/*
Plugin Name: Nighty
Plugin URI: http://wordpress.org/plugins/nighty/
Description: You want a night mode ? Deals with us. You can fully customise yours easly!
Author: ESGI groupe 
Version: 0.1
Author URI: https://myges.fr/
*/

/**
 * Database init with default value
 */
function plugin_nighty_init_database() {

	global $wpdb;

	$charset =  $wpdb->get_charset_collate() ;
	$table_name = $wpdb->prefix ."nighty_theme";

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name tinytext NOT NULL,
		body tinytext NOT NULL,
		header tinytext NOT NULL,
		nav tinytext NOT NULL,
		main tinytext NOT NULL,
		section tinytext NOT NULL,
		article tinytext NOT NULL,
		h1 tinytext NOT NULL,
		h2 tinytext NOT NULL,
		p tinytext NOT NULL,
		footer tinytext NOT NULL,
		PRIMARY KEY  (id)
	) $charset;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	$wpdb->insert(
		$table_name,
		array('default','#212121','#212121','#212121','#212121','#212121','#212121','#F1F1F1','#F1F1F1','#F1F1F1','#212121'
		)
	);
} 
add_action( 'init', 'plugin_nighty_init_database' );
 
/**
 * Activate the plugin.
 */
function plugin_nighty_init() { 
    // Trigger our function that init database
    plugin_nighty_init_database(); 
    // Clear the permalinks after the post type has been registered.
    flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'plugin_nighty_activate' );

/**
 * Deactivation hook.
 */
function plugin_nighty_deactivate() {
  
    // Clear the permalinks to remove our post type's rules from the database.
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'plugin_nighty_deactivate' );