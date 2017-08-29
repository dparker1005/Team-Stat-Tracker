<?php
/*
Plugin Name: Team Stat Tracker
Version: .1
*/

define('TEAMSTATTRACKER_DIR', dirname(__FILE__));
require_once(TEAMSTATTRACKER_DIR . '/includes/cpt_functions.php');

//require all modules used by sports
$sports = get_posts(array('post_type'=>'sport'));

foreach($sports as $sport){
	if(file_exists(TEAMSTATTRACKER_DIR . esc_html( get_post_meta( $sport->ID, 'module_path', true ) ))){
		require_once(TEAMSTATTRACKER_DIR . esc_html( get_post_meta( $sport->ID, 'module_path', true ) ));
	}
}

?>