<?php
function tst_add_fencing_meta_fields( $sport_id, $sport ) {
    // Check post type for movie reviews
    if ( $sport->post_type == 'sport' ) {
		if ( isset( $_POST['tst_sport_module_path'] ) && $_POST['tst_sport_module_path'] == '/modules/fencing.php' ) {
            if(is_file(TEAMSTATTRACKER_DIR . esc_html( $_POST['tst_sport_module_path'] ))){
            	update_post_meta( $sport_id, 'individual', 'true' );
			}
        }
    }
}
add_action( 'save_post', 'tst_add_fencing_meta_fields', 11, 2 );

function tst_fencing_tracker($atts, $content = null) {
    ?>
    <div id="app" style="align:center">
    	<div v-show="screen==0">
    		<table>
    			<tr>
    				<th>Bout Date</th>
    				<td><input name="tst_date" type="date" value="<?php echo date('Y-m-d'); ?>"></td>
    			</tr>
    			<tr>
    				<select name="tst_season_select">
						<?php
						$seasons = get_posts(array('post_type'=>'season'));
						// Generate all items of drop-down list
						foreach ( $seasons as $season ) {
							if(get_post_meta(get_post_meta($season->ID, 'sport_id', true), 'module_path', true)=='/modules/fencing.php'){
						?>
							<option value="<?php echo($season->ID); ?>">
							<?php echo($season->post_title); }} ?>
					</select>
    			</tr>
    			<tr>
    				<th>Weapon</th>
    				<td>
    					<select name="tst_weapon_select">
    						<option value="0">
							<option value="1">Sabre
							<option value="2">Foil
							<option value="3">Epee
						</select>
    				</td>
    			</tr>
    			<tr>
    				<th>Fencer 1 Name</th>
    				<th><input type="text" v-model="fencer1_name"></input></th>
    				<th>Fencer 1 School</th>
    				<th><input type="text" v-model="fencer1_school"></input></th>
    			</tr>
    			<tr>
    				<th>Fencer 2 Name</th>
    				<th><input type="text" v-model="fencer2_name"></input></th>
    				<th>Fencer 2 School</th>
    				<th><input type="text" v-model="fencer2_school"></input></th>
    			</tr>
    		</table>
    		<button @click="screen=1">Start Match</button>
    	</div>
    	<div v-show="screen==1">
		  <table style="text-align:center">
			<tr>
				<th><h2>{{fencer1_name}}</h2></th>
				<th></th>
				<th><h2>{{fencer2_name}}</h2></th>
			</tr>
			<tr>
				<td><h3>{{fencer1_school}}</h3></td>
				<td></td>
				<td><h3>{{fencer2_school}}</h3></td>
			</tr>
			<tr>
				<td><h2>{{ count_1 }}</h2></td>
				<td></td>
				<td><h2>{{ count_2 }}</h2></td>
			</tr>
			<tr>
				<td><h2><button @click="countUp(1)">+ Point</button></h2></td>
				<td><button @click="countUp(0)">No Point</button></h2></td></td>
				<td><h2><button @click="countUp(2)">+ Point</button></h2></td></h2></td>
			</tr>
		  </table>
		  <ol>
			<li v-for="(event, index) in events">
				{{ event.message }}{{ event.other }}
				<select v-model="event.action_id" v-if="event.scored>0">
					<option value="0">-</option>
					<option value="1">Straight Attack</option>
					<option value="2">Compound Attack</option>
					<option value="3">Counter-Attack</option>
					<option value="4">Parry-Riposte</option>
					<option value="5">Prise De Fer</option>
					<option value="6">Overtaking Tempo</option>
					<option value="7">Attack in Prep</option>
					<option value="8">Point in Line</option>
					<option value="9">Red Card</option>
					<option value="10">Referee Forgot Their Glasses</option>
				 </select>
				 <select v-model="event.action_id" v-if="event.scored==0">
					<option value="0">-</option>
					<option value="1">Simultaneous</option>
					<option value="2">Yellow Card</option>
				 </select>
				 <button @click="removeEvent(index)">X</button>
			</li>
		  </ol>
		  <button @click="screen=2">End Match</button>
		</div>
		<div v-show="screen==2">
    		<table style="text-align:center">
			<tr>
				<th><h2>{{fencer1_name}}</h2></th>
				<th></th>
				<th><h2>{{fencer2_name}}</h2></th>
			</tr>
			<tr>
				<td><h3>{{fencer1_school}}</h3></td>
				<td></td>
				<td><h3>{{fencer2_school}}</h3></td>
			</tr>
			<tr>
				<td><h2>{{ count_1 }}</h2></td>
				<td></td>
				<td><h2>{{ count_2 }}</h2></td>
			</tr>
			<tr>
				<td><input type="radio" name="winner" value="fencer_1">{{fencer1_name}} won</button></td>
				<td></td>
				<td><input type="radio" name="winner" value="fencer_2">{{fencer2_name}} won</button></td>
			</tr>
		  </table>
		  <ol>
			<li v-for="(event, index) in events">
				{{ event.message }}
				<select v-model="event.action_id" v-if="event.scored>0" disabled>
					<option value="0">-</option>
					<option value="1">Straight Attack</option>
					<option value="2">Compound Attack</option>
					<option value="3">Counter-Attack</option>
					<option value="4">Parry-Riposte</option>
					<option value="5">Prise De Fer</option>
					<option value="6">Overtaking Tempo</option>
					<option value="7">Attack in Prep</option>
					<option value="8">Point in Line</option>
					<option value="9">Red Card</option>
					<option value="10">Referee Forgot Their Glasses</option>
				 </select>
				 <select v-model="event.action_id" v-if="event.scored==0" disabled>
					<option value="0">-</option>
					<option value="1">Simultaneous</option>
					<option value="2">Yellow Card</option>
				 </select>
			</li>
		  </ol>
		  <button @click="screen=1">Edit Match</button>
		  <button @click="">Confirm Match</button>
    	</div>
    </div>
    <script src="https://unpkg.com/vue@2.0.3/dist/vue.js"></script>

  <script>
	var app = new Vue({
	  el: '#app',
	  data: {
		fencer1_name:"",
		fencer1_school:"",
		fencer2_name:"",
		fencer2_school:"",
		screen: 0,
		count_1: 0,
		count_2: 0,
		events: []
	  },
	  methods: {
		countUp: function(competitor) {
		  if(competitor == 1){
			this.count_1 += 1
			this.events.push({message: this.fencer1_name+' Scored', scored:1})
		  }
		  else if(competitor == 2){
			this.count_2 += 1
			this.events.push({message: this.fencer2_name+' Scored', scored:2})
		  }
		  else{
			this.events.push({message: 'Other Event', scored:0})
		  }
		},
		removeEvent: function(index) {
		  if(this.events[index].scored==1){
			this.count_1 -= 1
		  }
		  if(this.events[index].scored==2){
			this.count_2 -= 1
		  }
		  this.events.splice(index, 1)
		}
	  }
	})
  </script>
    
    
    <?php
    }
add_shortcode("tst_fencing_tracker", "tst_fencing_tracker");
?>