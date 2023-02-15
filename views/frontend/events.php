<?php

/**
 * IATEN_reservation_display_events
 * 
 * allows to display the list of events on a page (use the shortcode [event_list]).
 * @global post : post being processed
 * @param $post
 * @return void
 */
add_shortcode('events_list', 'IATEN_reservation_display_events');
$notspeci = IATEN_NOT_SPECIFY;

if(! function_exists('IATEN_reservation_display_events')){	

	function IATEN_reservation_display_events(){
		global $notspeci; 
		global $post;
		
		$args = [
			'post_type' 		=>	'event',
			'post_status'		=>	'publish',
			'post_per_page'		=>	7,
			'orderby'			=>	'event_begining_day', 
			'order'				=>	'DESC'
		];
		$query = new WP_Query($args);
		$content = '<div class = "events_containers">';
		if($query->have_posts()):
			while($query->have_posts()) :
				$query->the_post();
				$eventRepetition = get_post_meta($post->ID, 'is_repeat_event', true);
				$prefixe_date = $eventRepetition == "Every week" ? __("Start at ", 'instant-appointment') : __("The", 'instant-appointment') ;
				$date = empty(get_post_meta($post->ID, 'event_begining_day', true))? $notspeci : get_post_meta($post->ID, 'event_begining_day', true);
				$heure = empty(get_post_meta($post->ID, 'event_starting_hour', true))? "" : IATEN_AT.get_post_meta($post->ID, 'event_starting_hour', true);
				$adresse = empty(get_post_meta($post->ID, 'event_location', true))? $notspeci : get_post_meta($post->ID, 'event_location', true);
				$titre = get_the_title();

				$titre = strlen($titre) <= 25 ? $titre :substr($titre, 0, 22) ."...";
				$adresse = strlen($adresse) <= 30 ? $adresse :substr($adresse, 0, 28) ."...";
                $short_description = strlen(get_post_meta($post->ID, 'event_short_description', true)) <=170 ? get_post_meta($post->ID, 'event_short_description', true) : substr(get_post_meta($post->ID, 'event_short_description', true), 0, 170) ."...";
				
				$content .='
					<div class="events_container">
						<div class="events_image" style="background-image: url('.IATEN_reservation_event_featured_image().')"></div>
						<div class="events_detail">
							<span class="events_date"><i class="fa fa-clock-o"></i> '.esc_attr($prefixe_date).' '.esc_attr($date).' '.esc_attr($heure).'</span>
							<span class="events_title"><i class="fa fa-calendar"></i> '.esc_attr($titre).'</span>
							<span class="events_place"><i class="fa fa-map-marker"></i> '.esc_attr($adresse).'</span>
							<span class="events_description">'.esc_attr($short_description).'</span>
							
							<form class="events_action" action="'.esc_url(get_the_permalink()).'" id = "'.esc_url(get_the_permalink()).'">
								<button type="submit" form = "'.esc_url(get_the_permalink()).'"><i class="fa fa-star"></i>'. 
					__("Interessed ", 'instant-appointment')
					.'</button>
							</form>    
						</div>
					</div>
				';
			endwhile;
		else:
			esc_html_e('Sorry, nothing to display !', 'instant-appointment');
		endif;
		$content .= '</div>';
		return $content;
	}
}
