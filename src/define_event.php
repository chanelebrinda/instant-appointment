<?php
/**
 * IATEN_reservation_event_type_registering
 *
 * Register method to create the event post type.
 * @link https://developer.wordpress.org/reference/functions/register_post_type
 * @return void
 */

if(! function_exists('IATEN_reservation_event_type_registering')){
    add_action( 'init', 'IATEN_reservation_event_type_registering');

    function IATEN_reservation_event_type_registering(){
        register_post_type( 'event', [
            'public'                        =>  true,
            'publicly_queryable'            =>  true,
            'show_in_rest'                  =>  IATEN_ALLOW_GUTENBERG,
            'show_in_nav_menu'              =>  true,
            'show_in_admin_bar'             =>  true,
            'exclude_from_search'           =>  false,
            'show-ui'                       =>  true,
            'show_in_menu'                  =>  true,
            'menu_icon'                     =>  'dashicons-calendar-alt',
            'hierarchical'                  =>  false,
            'has_archive'                   =>  'Events',
            'query_var'                     =>  'event',
            'description'                   =>  true,
            'map_meta_cap'                  =>  true,
            'can_export'                    =>  true,

            // The rewrite handles the URL Structure

            'rewrite'                       =>  [
                'slug'                      =>  IATEN_MENU_SLUG,
                'with_front'                =>  false,
                'pages'                     =>  true,
                'feeds'                     =>  true
            ],
    
            //  Features the event tye support
    
            'support'                       =>  [ 
                'title', 
                'editor', 
                'thumbnail',
                'author', 
                'revisions', 
                'excerpt',
                'custom-fields',
                'revisions', 
                'trackbacks'
            ], 
    
            // Text Labels
    
            'labels'                        =>  [
                'name'                      =>  __('Events',  'instant-appointment'),
                'singular_name'             =>  __('Event',  'instant-appointment'),
                'add_new'                   =>  __('Add New', 'instant-appointment'),
                'add_new_item'              =>  __('Add New Event', 'instant-appointment'),
                'edit_item'                 =>  __('Edit Event', 'instant-appointment'),
                'new_item'                  =>  __('New Event', 'instant-appointment'),
                'view_item'                 =>  __('View Event', 'instant-appointment'),
                'view_items'                =>  __('View Events', 'instant-appointment'),
                'search_items'              =>  __('Search Events', 'instant-appointment'),
                'not_found'                 =>  __('Not events found.', 'instant-appointment'),
                'not-found_in_trash'        =>  __('Not events found in Trash', 'instant-appointment'),
                'all_items'                 =>  __('All Events', 'instant-appointment'),
                'archives'                  =>  __('Event Archive', 'instant-appointment'),
                'attributes'                =>  __('Event Attributes', 'instant-appointment'),
                'insert_into_item'          =>  __('Insert into event', 'instant-appointment'),
                'uploaded_to_this_item'     =>  __('Uploaded to this Event', 'instant-appointment'),
                'filter_items_list'         =>  __('Filter event list', 'instant-appointment'),
                'items_list_navigation'     =>  __('Events list navigation', 'instant-appointment'),
                'items_list'                =>  __('Events list', 'instant-appointment'),
                'item_published'            =>  __('Event published', 'instant-appointment'),
                'item_published_privately'  =>  __('Event published privately.', 'instant-appointment'),
                'item_reverted_to_draft'    =>  __('Event reverted to draft.', 'instant-appointment'),
                'item_scheduled'            =>  __('Event scheduled.', 'instant-appointment'),
                'item_updated'              =>  __('Event updated.' ,'instant-appointment')
            ], 
    
            // Stting up Event type capability
    
            'capability'                    =>  [
                'edit_post'                 =>  'edit_event',
                'read_post'                 =>  'read_event',
                'delete_post'               =>  'delete_event',
                'create_posts'              =>  'create_events',
                'edit_post'                 =>  'edit_event',
                'edit_others_posts'         =>  'edit_others_events',
                'edit_private_posts'        =>  'edit_private_events',
                'edit_published_posts'      =>  'edit_published_events',
                'publish_posts'             =>  'publish_events',
                'read_private_posts'        =>  'read_private_events',
                'read'                      =>  'read',
                'delete_posts'              =>  'delete_events',
                'delete_private_posts'      =>  'delete_private_events',
                'delete_published_posts'    =>  'delete_published_events',
                'delete_others_posts'       =>  'delete_others_events'
            ],
    
            // Setting up a Event type Taximonies 
    
            'taximonies'                    => [
                'category', 
                'post_tag'
            ]
        ]);
    }
}
