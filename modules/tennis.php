<?php
	function tst_add_tennis_meta_fields( $sport_id, $sport ) {
    // Check post type for movie reviews
    if ( $sport->post_type == 'sport' ) {
		if ( isset( $_POST['tst_sport_module_path'] ) && $_POST['tst_sport_module_path'] == '/modules/tennis.php' ) {
            if(is_file(TEAMSTATTRACKER_DIR . esc_html( $_POST['tst_sport_module_path'] ))){
            	update_post_meta( $sport_id, 'individual', 'true' );
			}
        }
    }
}
add_action( 'save_post', 'tst_add_tennis_meta_fields', 11, 2 );
?>