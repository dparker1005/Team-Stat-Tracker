<?php

//=====================================================
//SPORT CPT

function tst_create_sport_cpt() {  
  register_post_type( 'sport',
    array(
      'labels' => array(
        'name' => __( 'Sports','teamstattracker' ),
        'singular_name' => __( 'Sport','teamstattracker' ),
        'add_new_item' => __('Add New Sport','teamstattracker'),
        'edit_item' => __( 'Edit Sport','teamstattracker' ),
        'new_item' => __( 'New Sport','teamstattracker' ),
		'view_item' => __( 'View Sport','teamstattracker' ),
		'search_items' => __( 'Search Sports','teamstattracker' ),
		'not_found' => __( 'No Sports Found','teamstattracker' ),
		'not_found_in_trash' => __( 'No Sports Found In Trash','teamstattracker' ),
		'all_items' => __( 'All Sports','teamstattracker' ),
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
  remove_post_type_support( 'sport', 'editor' );
}
add_action('init','tst_create_sport_cpt');

function tst_create_sport_meta_box() {
    add_meta_box( 'tst_sport_meta_box',
        'Sport Details',
        'tst_display_sport_meta_box',
        'sport', 'normal', 'high'
    );
}
add_action( 'admin_init', 'tst_create_sport_meta_box' );

function tst_display_sport_meta_box( $sport ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    $module = esc_html( get_post_meta( $sport->ID, 'module_path', true ) );
    ?>
    <table>
		<tr>
			<td style="width: 100%">Module Path</td>
			<td><input type="text" size="80" name="tst_sport_module_path" value="<?php echo $module; ?>" /></td>
		</tr>
		<tr>
			<td style="width: 150px">Seasons:</td>
            <td>
            	<ul>
					<?php
 						$seasons = get_posts(array('post_type'=>'season'));
						// Generate all items of drop-down list
						foreach ( $seasons as $season ) {
							if(intval(get_post_meta($season->ID, 'sport_id', true))==$sport->ID){
								echo('<li>'.esc_html(get_the_title($season->ID)).'</li>');
							}
						}
						?>
  				</ul>
            </td>
        </tr>
    </table>
    <?php
}

function tst_add_sport_fields( $sport_id, $sport ) {
    // Check post type for movie reviews
    if ( $sport->post_type == 'sport' ) {
        // store data in post meta table if present in post data
        if ( isset( $_post['tst_sport_module_path'] ) && $_post['tst_sport_module_path'] != '' ) {
            update_post_meta( $sport_id, 'module_path', $_post['tst_sport_module_path'] );
        }
    }
}
add_action( 'save_post', 'tst_add_sport_fields', 10, 2 );

//=====================================================
//SEASON CPT

function tst_create_season_cpt() {  
  register_post_type( 'season',
    array(
      'labels' => array(
        'name' => __( 'Seasons','teamstattracker' ),
        'singular_name' => __( 'Season','teamstattracker' ),
        'add_new_item' => __('Add New Season','teamstattracker'),
        'edit_item' => __( 'Edit Season','teamstattracker' ),
        'new_item' => __( 'New Season','teamstattracker' ),
		'view_item' => __( 'View Season','teamstattracker' ),
		'search_items' => __( 'Search Seasons','teamstattracker' ),
		'not_found' => __( 'No Seasons Found','teamstattracker' ),
		'not_found_in_trash' => __( 'No Seasons Found In Trash','teamstattracker' ),
		'all_items' => __( 'All Seasons','teamstattracker' ),
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
  remove_post_type_support( 'season', 'editor' );
  remove_post_type_support('season', 'title');
}
add_action('init','tst_create_season_cpt');

function tst_create_season_meta_box() {
    add_meta_box( 'tst_season_meta_box',
        'Season Details',
        'tst_display_season_meta_box',
        'season', 'normal', 'high'
    );
    $sports = get_posts(array('post_type'=>'sport'));
}
add_action( 'admin_init', 'tst_create_season_meta_box' );

function tst_display_season_meta_box( $season ) {
	$name = esc_html( get_post_meta( $season->ID, 'name', true ) );
    $start_year = esc_html( get_post_meta( $season->ID, 'start_year', true ) );
    $end_year = esc_html( get_post_meta( $season->ID, 'end_year', true ) );
    $sport_id = intval( get_post_meta( $season->ID, 'sport_id', true ) );
    ?>
    <table>
    	<tr>
			<td style="width: 150px">Name</td>
            <td>
                <input type="text" size="80" name="tst_name" value="<?php echo $name; ?>" />
            </td>
        </tr>
		<tr>
			<td style="width: 150px">start Year</td>
            <td>
                <input type="text" size="80" name="tst_start_year" value="<?php echo $start_year; ?>" />
            </td>
        </tr>
        <tr>
			<td style="width: 150px">End Year</td>
            <td>
                <input type="text" size="80" name="tst_end_year" value="<?php echo $end_year; ?>" />
            </td>
        </tr>
        <tr>
			<td style="width: 150px">Sport</td>
            <td>
                <select style="width: 100px" name="tst_sport_select">
                <?php
 				$sports = get_posts(array('post_type'=>'sport'));
                // Generate all items of drop-down list
                foreach ( $sports as $sport ) {
                ?>
                    <option value="<?php echo($sport->ID); ?>" <?php echo selected( $sport->ID, $sport_id ); ?>>
                    <?php echo($sport->post_title); } ?>
                </select>
            </td>
        </tr>
        <tr>
			<td style="width: 150px">Teams:</td>
            <td>
            	<ul>
					<?php
 						$teams = get_posts(array('post_type'=>'team'));
						// Generate all items of drop-down list
						foreach ( $teams as $team ) {
							if(intval(get_post_meta($team->ID, 'season_id', true))==$season->ID){
								echo('<li>'.esc_html(get_post_meta($team->ID, 'name', true)).'</li>');
							}
						}
						?>
  				</ul>
            </td>
        </tr>
    </table>
    <?php
}

function tst_add_season_fields( $season_id, $season ) {
    // Check post type for movie reviews
    if ( $season->post_type == 'season' ) {
        // store data in post meta table if present in post data
        $new_post_title = '';
        $start_year = NULL;
        if ( isset( $_post['tst_name'] ) && $_post['tst_name'] != '' ) {
			update_post_meta( $season_id, 'name', $_post['tst_name'] );
			$new_post_title .= $_post['tst_name'];
		}
        if ( isset( $_post['tst_start_year'] ) && $_post['tst_start_year'] != '' ) {
            update_post_meta( $season_id, 'start_year', $_post['tst_start_year'] );
            $start_year = $_post['tst_start_year'];
            $new_post_title .= ' '.$_post['tst_start_year'];
        }
        if ( isset( $_post['tst_end_year'] ) && $_post['tst_end_year'] != '' ) {
            update_post_meta( $season_id, 'end_year', $_post['tst_end_year'] );
            if(!empty($start_year) && $start_year != $_post['tst_end_year']){
            	$new_post_title .= '-'.$_post['tst_end_year'];
            }
        }
        if ( isset( $_post['tst_sport_select'] ) && $_post['tst_sport_select'] != '' ) {
            update_post_meta( $season_id, 'sport_id', $_post['tst_sport_select'] );
			$new_post_title .= ', '.get_post(intval($_post['tst_sport_select']))->post_title;
        }
        remove_action( 'save_post', 'tst_add_season_fields', 10, 2 );
        wp_update_post(array('ID'=> $season_id, 'post_title'=>$new_post_title));
        add_action( 'save_post', 'tst_add_season_fields', 10, 2 );
    }
}
add_action( 'save_post', 'tst_add_season_fields', 10, 2 );

//=====================================================
//TEAM CPT

function tst_create_team_cpt() {  
  register_post_type( 'team',
    array(
      'labels' => array(
        'name' => __( 'Teams','teamstattracker' ),
        'singular_name' => __( 'Team','teamstattracker' ),
        'add_new_item' => __('Add New Team','teamstattracker'),
        'edit_item' => __( 'Edit Team','teamstattracker' ),
        'new_item' => __( 'New Team','teamstattracker' ),
		'view_item' => __( 'View Team','teamstattracker' ),
		'search_items' => __( 'Search Teams','teamstattracker' ),
		'not_found' => __( 'No Teams Found','teamstattracker' ),
		'not_found_in_trash' => __( 'No Teams Found In Trash','teamstattracker' ),
		'all_items' => __( 'All Teams','teamstattracker' ),
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
  remove_post_type_support( 'team', 'editor' );
  remove_post_type_support( 'team', 'title' );
}
add_action('init','tst_create_team_cpt');

function tst_create_team_meta_box() {
    add_meta_box( 'tst_team_meta_box',
        'Team Details',
        'tst_display_team_meta_box',
        'team', 'normal', 'high'
    );
}
add_action( 'admin_init', 'tst_create_team_meta_box' );

function tst_display_team_meta_box( $team ) {
    $name = esc_html( get_post_meta( $team->ID, 'name', true ) );
    $season_id = esc_html( get_post_meta( $team->ID, 'season_id', true ) );
    ?>
    <table>
    	<tr>
			<td style="width: 150px">Name</td>
            <td>
                <input type="text" size="80" name="tst_name" value="<?php echo $name; ?>" />
            </td>
        </tr>
         <tr>
			<td style="width: 150px">Season</td>
            <td>
                <select style="width: 100px" name="tst_season_select">
                <?php
 				$seasons = get_posts(array('post_type'=>'season'));
                // Generate all items of drop-down list
                foreach ( $seasons as $season ) {
                ?>
                    <option value="<?php echo($season->ID); ?>" <?php echo selected( $season->ID, $season_id ); ?>>
                    <?php echo($season->post_title); } ?>
                </select>
            </td>
        </tr>
        <tr>
			<td style="width: 150px">Players:</td>
            <td>
            	<ul>
					<?php
 						$players = get_posts(array('post_type'=>'player'));
						// Generate all items of drop-down list
						foreach ( $players as $player ) {
							if(in_array($team->ID, get_post_meta($player->ID, 'teams'))){
								echo('<li>'.esc_html(get_post_meta($player->ID, 'first_name', true).get_post_meta($player->ID, 'last_name', true)).'</li>');
							}
						}
						?>
  				</ul>
            </td>
        </tr>
    </table>
    <?php
}

function tst_add_team_fields( $team_id, $team ) {
    // Check post type for movie reviews
    $new_post_title = '';
    if ( $team->post_type == 'team' ) {
        // store data in post meta table if present in post data
        if ( isset( $_post['tst_name'] ) && $_post['tst_name'] != '' ) {
            update_post_meta( $team_id, 'name', $_post['tst_name'] );
            $new_post_title .= $_post['tst_name'];
        }
        if ( isset( $_post['tst_season_select'] ) && $_post['tst_season_select'] != '' ) {
            update_post_meta( $team_id, 'season_id', $_post['tst_season_select'] );
            $new_post_title .= ", " . get_the_title($_post['tst_season_select']);
        }
    	remove_action( 'save_post', 'tst_add_team_fields', 10, 2 );
        wp_update_post(array('ID'=> $team_id, 'post_title'=>$new_post_title));
        add_action( 'save_post', 'tst_add_team_fields', 10, 2 );
    }
}
add_action( 'save_post', 'tst_add_team_fields', 10, 2 );

//=====================================================
//PLAYER CPT

function tst_create_player_cpt() {  
  register_post_type( 'player',
    array(
      'labels' => array(
        'name' => __( 'Players','teamstattracker' ),
        'singular_name' => __( 'Player','teamstattracker' ),
        'add_new_item' => __('Add New Player','teamstattracker'),
        'edit_item' => __( 'Edit Player','teamstattracker' ),
        'new_item' => __( 'New Player','teamstattracker' ),
		'view_item' => __( 'View Player','teamstattracker' ),
		'search_items' => __( 'Search Players','teamstattracker' ),
		'not_found' => __( 'No Players Found','teamstattracker' ),
		'not_found_in_trash' => __( 'No Players Found In Trash','teamstattracker' ),
		'all_items' => __( 'All Players','teamstattracker' ),
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
  remove_post_type_support( 'player', 'editor' );
  remove_post_type_support( 'player', 'title' );
}
add_action('init','tst_create_player_cpt');

function tst_create_player_meta_box() {
    add_meta_box( 'tst_player_meta_box',
        'Player Details',
        'tst_display_player_meta_box',
        'player', 'normal', 'high'
    );
}
add_action( 'admin_init', 'tst_create_player_meta_box' );

function tst_display_player_meta_box( $player ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    $first_name = esc_html( get_post_meta( $player->ID, 'first_name', true ) );
    $last_name = esc_html( get_post_meta( $player->ID, 'last_name', true ) );
    $sport_id = intval( get_post_meta( $player->ID, 'sport_id', true ) );
    $teams = array();
    ?>
    <table>
        <tr>
            <td style="width: 100%">first Name</td>
            <td><input type="text" size="80" name="tst_first_name" value="<?php echo $first_name; ?>" /></td>
        </tr>
		<tr>
			<td style="width: 100%">last Name</td>
			<td><input type="text" size="80" name="tst_last_name" value="<?php echo $last_name; ?>" /></td>
		</tr>
		<tr>
			<td style="width: 150px">Sport</td>
            <td>
                <select style="width: 100px" name="tst_sport_select">
                <?php
 				$sports = get_posts(array('post_type'=>'sport'));
                // Generate all items of drop-down list
                foreach ( $sports as $sport ) {
                ?>
                    <option value="<?php echo($sport->ID); ?>" <?php echo selected( $sport->ID, $sport_id ); ?>>
                    <?php echo($sport->post_title); } ?>
                </select>
            </td>
        </tr>
		<tr>
        	<td style="width: 150px">Teams</td>
            <td>
                <input type="checkbox" name="gender" value="male"> Team1<br>
  				<input type="checkbox" name="gender" value="female"> Team2<br>
  				<input type="checkbox" name="gender" value="other"> Team3
            </td>
        </tr>
        <tr>
        	<td style="width: 150px">Matches</td>
            <td>
            	<ul>
					<li>Match1</li>
					<li>Match2</li>
					<li>Match3</li>
  				</ul>
            </td>
        </tr>
    </table>
    <?php
}

function tst_add_player_fields( $player_id, $player ) {
    // Check post type for movie reviews
    if ( $player->post_type == 'player' ) {
        $new_post_title = '';
        if ( isset( $_post['tst_first_name'] ) && $_post['tst_first_name'] != '' ) {
            update_post_meta( $player_id, 'first_name', $_post['tst_first_name'] );
            $new_post_title .= $_post['tst_first_name'];
        }
        if ( isset( $_post['tst_last_name'] ) && $_post['tst_last_name'] != '' ) {
            update_post_meta( $player_id, 'last_name', $_post['tst_last_name'] );
            $new_post_title .= " ".$_post['tst_last_name'];
        }
        if ( isset( $_post['tst_sport_select'] ) && $_post['tst_sport_select'] != '' ) {
            update_post_meta( $player_id, 'sport_id', $_post['tst_sport_select'] );
            $new_post_title .= ', '.esc_html(get_the_title($_post['tst_sport_select']));
        }
        remove_action( 'save_post', 'tst_add_player_fields', 10, 2 );
        wp_update_post(array('ID'=> $player_id, 'post_title'=>$new_post_title));
        add_action( 'save_post', 'tst_add_player_fields', 10, 2 );
    }
}
add_action( 'save_post', 'tst_add_player_fields', 10, 2 );

//=====================================================
//MATCH

function tst_create_match_cpt() {  
  register_post_type( 'match',
    array(
      'labels' => array(
        'name' => __( 'Matches','teamstattracker' ),
        'singular_name' => __( 'Match','teamstattracker' ),
        'add_new_item' => __('Add New Match','teamstattracker'),
        'edit_item' => __( 'Edit Match','teamstattracker' ),
        'new_item' => __( 'New Match','teamstattracker' ),
		'view_item' => __( 'View Match','teamstattracker' ),
		'search_items' => __( 'Search Matches','teamstattracker' ),
		'not_found' => __( 'No Matches Found','teamstattracker' ),
		'not_found_in_trash' => __( 'No Matches Found In Trash','teamstattracker' ),
		'all_items' => __( 'All Matches','teamstattracker' ),
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
  remove_post_type_support( 'match', 'editor' );
}
add_action('init','tst_create_match_cpt');

function tst_create_match_meta_box() {
    add_meta_box( 'tst_match_meta_box',
        'Match Details',
        'tst_display_match_meta_box',
        'match', 'normal', 'high'
    );
}
add_action( 'admin_init', 'tst_create_match_meta_box' );

function tst_display_match_meta_box( $match ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    $name = esc_html( get_post_meta( $match->ID, 'name', true ) );
    $module = esc_html( get_post_meta( $match->ID, 'module', true ) );
    ?>
    <table>

    </table>
    <?php
}

function tst_add_match_fields( $match_id, $match ) {
    // Check post type for movie reviews
    if ( $match->post_type == 'match' ) {
        // store data in post meta table if present in post data
        if ( isset( $_post['tst_match_name'] ) && $_post['tst_match_name'] != '' ) {
            update_post_meta( $match_id, 'name', $_post['tst_match_name'] );
        }
        if ( isset( $_post['tst_match_module'] ) && $_post['tst_match_module'] != '' ) {
            update_post_meta( $match_id, 'module', $_post['tst_match_module'] );
        }
    }
}
add_action( 'save_post', 'tst_add_match_fields', 10, 2 );

//=====================================================

?>