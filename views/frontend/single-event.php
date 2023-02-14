<?php 

    get_header(); 
    global $post;
    $limit_reservation_day = get_post_meta($post->ID, 'limit_date_schedule', true);
    $is_open = get_post_meta($post->ID, $day.'_is_open', true);
    $date = date('Y-m-d');
    $maximum_participant = get_post_meta($post->ID, 'event_limit_participants', true).__(" Participant(s) per session", 'instant-appointment');

    $eventRepetition = get_post_meta($post->ID, 'is_repeat_event', true);
    $prefixe_date = $eventRepetition == "Every week" ? "à partir du" : "Le" ;
    $begining_date = empty(get_post_meta($post->ID, 'event_begining_day', true))? IATEN_NOT_SPECIFY : get_post_meta($post->ID, 'event_begining_day', true);
    $ending_date = empty(get_post_meta($post->ID, 'event_ending_day', true))? IATEN_NOT_SPECIFY : get_post_meta($post->ID, 'event_ending_day', true);
    $heure_debut = empty(get_post_meta($post->ID, 'event_starting_hour', true))? "" : ' '.get_post_meta($post->ID, 'event_starting_hour', true);
    $heure_fin = empty(get_post_meta($post->ID, 'event_ending_hour', true))? "" : AT.get_post_meta($post->ID, 'event_ending_hour', true);
    $location = empty(get_post_meta($post->ID, 'event_location', true))? IATEN_NOT_SPECIFY : get_post_meta($post->ID, 'event_location', true);
    $adresse = empty(get_post_meta($post->ID, 'event_adress', true))? IATEN_NOT_SPECIFY : get_post_meta($post->ID, 'event_adress', true);
    $titre = get_the_title();
    $duree = ($eventRepetition == "Every week")? ' '.AT.get_post_meta($post->ID, 'session_duration', true)." Minutes" : 'De '.$heure_debut.' '.$heure_fin;
    
?>
<?php if(have_posts()):while(have_posts()): the_post(); ?> 
<div class="single-event_post">
    <div class="event_featured_image" style="background-image: url('<?php echo esc_html_( IATEN_reservation_event_featured_image());?>')"></div>
    <div class="single-event_title">
        <h2 id = "post-title" class="post-title" title="<?php the_ID(); ?>"><i class="fa fa-calendar "></i> <?php the_title(); ?></h2>
        <div class="single_event_details">
            <span class="event_begining_time"><?php echo esc_html($prefixe_date).' '.esc_html($begining_date).' '.AT.esc_html($heure_debut)?></span>
            <span class="event_duration"><i class="fa fa-clock-o"></i> <?php echo' '. esc_html($duree).' '?></span>
            <span class="event_location"><i class="fa fa-clock-o"></i><?php echo' '.esc_html($location).' ' ?></span>
            <span class="event_adress"><i class="fa fa-map-marker"></i><?php echo' '.esc_html($adresse).' '?></span>
            <span class="event_participant"><i class="fa fa-clock-o"></i><?php echo ' '.esc_html($maximum_participant).' '?></span>
            <span class="event_repetition"><i class="fa fa-clock-o"></i><?php echo' '.esc_html($eventRepetition).' '?></span>
        </div>
    </div>    
    <div class="single-event_calandar ">
        
        <?php   
            if (!empty($ending_date) && !empty($date) && $ending_date < $date){
                ?>
                    <div class="WR_event_frontend_form" id="WR_event_frontend_form_no_repeat">
                        <span class="event_error"><?php esc_html_e('Cet evenement est n est plus disponible !', 'instant-appointment') ?></span>
                    </div>    
                <?php
            }      
            else if($eventRepetition == "Every week"){
        ?>
          
        <div id="WR_event_frontend">
             
            <div id="WR_event_frontend_form" class="WR_event_frontend_form" style="display: none ;">
                <div id="current_hour">
                    <span></span>
                </div>
                <div class="single_event_form">
                    <input type="text" id="WReservation_client_name" placeholder="Enter your name">
                    <input type="email" id="WReservation_client_email" placeholder="Enter your email">
                    <input type="number" min="1" id="WReservation_client_participant" placeholder="Select partcipant(s)">
                    <input type="submit" id="WReservation_client_submit" value="<?php esc_html_e("Reserve Now !",'instant-appointment') ?>">
                    <span><i id="WReservation_maximum_participant"></i> <?php esc_html_e("Participant(s) expected to close the slot",'instant-appointment') ?></span>
                    <input id="return_to_crenaux" type="button" value="<?php esc_html_e("Return",'instant-appointment') ?>">
                </div>
            </div>

            <div id="WR_event_frontend_calandar" class = "event_calander"> </div>

        </div>

        <div class="WR_select_creno" id = "WR_select_creno" hidden>
            <div id = "WR_select_creno_details"></div>
            <input id="return_to_calandar" type="button" value="<?php esc_html_e("Return to calendar",'instant-appointment') ?>">
        </div>

        <?php }else{ 

            //Collecte des jours ouvrable de cette semaine la

            $days = array();
            foreach(IATEN_WEEK_DAYS as $day){
                if(get_post_meta($post->ID, $day.'_is_open', true) != "none"){
                    array_push($days, $day);
                }
            }

            
            $request = IATEN_reservation_plugin_db_get_participant($post->ID);
            $succes = intval($maximum_participant) - intval($request);

            $limit = date('Y-m-d', strtotime($date. " + ".$limit_reservation_day." day")  );

            if($limit <  $begining_date ){
                ?>
                <div class="WR_event_frontend_form" id="WR_event_frontend_form_no_repeat">
                    <span class="event_error"><?php esc_html_e("You cannot yet make reservation for this event",'instant-appointment') ?></span>
                </div>    
                <?php
            }
            else if (!empty($begining_date) && !empty($date) && $begining_date < $date){
                ?>
                <div class="WR_event_frontend_form" id="WR_event_frontend_form_no_repeat">
                    <span class="event_error"><?php esc_html_e("This event is no longer available",'instant-appointment') ?> </span>
                </div>    
                <?php
            }
            else if($succes <= 0 ){
                ?>
                <div class="WR_event_frontend_form" id="WR_event_frontend_form_no_repeat">
                    <span class="event_error"><?php esc_html_e("This event is full",'instant-appointment') ?> </span>
                </div>    
                <?php
            }else{
            ?>

            <div class="WR_event_frontend_form" id="WR_event_frontend_form_no_repeat">
                <h3><?php esc_html_e("Make a reservation",'instant-appointment') ?></h3>
                <div class="single_event_form">
                    <input type="text" id="WReservation_client_name" placeholder="Enter your name">
                    <input type="email" id="WReservation_client_email" placeholder="Enter your email">
                    <input type="number" min="1" id="WReservation_client_participant" placeholder="Select partcipant(s)">
                    <input type="submit" id="WReservation_client_simple_submit" value="<?php esc_html_e("Reserve Now !",'instant-appointment') ?>">      
                    <span><i id="WReservation_maximum_participant"></i> <?php esc_html_e("Participant(s) expected to close the slot",'instant-appointment') ?></span>
                </div>
            </div>

        <?php }} ?>     
        
        <div class="single-event_content">
            <?php the_content(); ?>

            <div class="WR_event_notification" > </div>
        </div> 
    </div>
 
</div>

<?php endwhile; ?>
<?php else: ?>
    <h1><?php esc_html_e('Sorry, nothing to dispay.', 'html5blank') ?></h1>    
<?php  endif; ?>
<?php get_footer();  ?>
