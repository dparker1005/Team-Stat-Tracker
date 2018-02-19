<?php
	function tst_get_teams_in_season($season_id){
		$arr_to_return = [];
		
	}
	add_action( 'wp_ajax_tst_get_teams_in_season', 'tst_get_teams_in_season' );
	
	function tst_get_players_in_team($team_id){
	
	}
	add_action( 'wp_ajax_tst_get_players_in_team', 'tst_get_players_in_team' );
?>