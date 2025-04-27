<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$options = array( 
    'event' => array(
        'type'		 => 'box',
        'title'		 => __( 'Event', 'charitious' ),
        'options'	 => array(
            'show_featured_image'	 => array(
                'type'  => 'switch',
                'value' => false,
                'label' => __('Show Featured Image', 'charitious'),
                'left-choice' => array(
                    'value' => false,
                    'label' => __('Hide', 'charitious'),
                ),
                'right-choice' => array(
                    'value' => true,
                    'label' => __('Show', 'charitious'),
                ),
            ),
            'event_details_title'		 => array(
                'label'	 => __( 'Event Details Title', 'charitious' ),
                'desc'	 => __( 'Event Details', 'charitious' ),
                'value'	 => 'Event Details',
                'type'	 => 'text',
            ),
            'general'	 => array(
                'title'		 => __( 'General', 'charitious' ),
                'type'		 => 'tab',
                'options'	 => array(
                    'show_general_tab'	 => array(
                        'type'  => 'switch',
                        'value' => true,
                        'label' => __('Show General', 'charitious'),
                        'left-choice' => array(
                            'value' => false,
                            'label' => __('Hide', 'charitious'),
                        ),
                        'right-choice' => array(
                            'value' => true,
                            'label' => __('Show', 'charitious'),
                        ),
                    ),
                    'general-box' => array(
                        'title'		 => __( 'General Settings', 'charitious' ),
                        'type'		 => 'box',
                        'options'	 => array(
                            'event_organization'		 => array(
                                'label'	 => __( 'Organized by', 'charitious' ),
                                'desc'	 => __( 'Organization name', 'charitious' ),
                                'type'	 => 'text',
                            ),
                            'event_date'=>array(
                                'type'  => 'datetime-picker',
                                'value' => '',
                                'label' => __('Event Date', 'charitious'),
                                'desc'  => __('Enter your event date', 'charitious'),
                                'datetime-picker' => array(
                                    'format'        => 'Y/m/d', // Format datetime.
                                    'maxDate'       => false,  // By default there is not maximum date , set a date in the datetime format.
                                    'minDate'       => false,  // By default minimum date will be current day, set a date in the datetime format.
                                    'timepicker'    => false,   // Show timepicker.
                                    'datepicker'    => true,   // Show datepicker.
                                    'defaultTime'   => '12:00' // If the input value is empty, timepicker will set time use defaultTime.
                                ),
                            ),
                            'event_venue'		 => array(
                                'label'	 => __( 'Venue', 'charitious' ),
                                'desc'	 => __( 'Enter your event venue name', 'charitious' ),
                                'type'	 => 'textarea',
                            ),
                            'event_phone'		 => array(
                                'label'	 => __( 'Phone', 'charitious' ),
                                'desc'	 => __( 'Enter phone number', 'charitious' ),
                                'type'	 => 'text',
                            ),
                            'event_email'		 => array(
                                'label'	 => __( 'Email', 'charitious' ),
                                'desc'	 => __( 'Enter email address', 'charitious' ),
                                'type'	 => 'text',
                            ),
                            'open_hour'		 => array(
                                'label'	 => __( 'Open Hours', 'charitious' ),
                                'desc'	 => __( 'Enter Open Hours', 'charitious' ),
                                'type'	 => 'text',
                            ),
                        ),
                    ),
                )
            ),
            'facilities'	     => array(
                'title'		 => __( 'Facilities', 'charitious' ),
                'type'		 => 'tab',
                'options'	 => array(
                    'show_facilities_tab'	 => array(
                        'type'  => 'switch',
                        'value' => true,
                        'label' => __('Show Facilities Tab', 'charitious'),
                        'left-choice' => array(
                            'value' => false,
                            'label' => __('Hide', 'charitious'),
                        ),
                        'right-choice' => array(
                            'value' => true,
                            'label' => __('Show', 'charitious'),
                        ),
                    ),
                    'general-box2' => array(
                        'title'		 => __( 'Facilities Settings', 'charitious' ),
                        'type'		 => 'box',
                        'options'	 => array(
                            'event_desc'		 => array(
                                'label'	 => __( 'Description', 'charitious' ),
                                'desc'	 => __( 'Event Description', 'charitious' ),
                                'type'	 => 'textarea',
                            ),
                            'event_facilities'	 => array(
                                'type'				 => 'addable-popup',
                                'limit'				 => '5',
                                'add-button-text'	 => __( 'Add Facilities info', 'charitious' ),
                                'label'				 => esc_html__( 'Facilities info', 'charitious' ),
                                'desc'				 => esc_html__( 'Add Artists info', 'charitious' ),
                                'template'			 => '{{=title}}',
                                'popup-options'		 => array(
                                    'title'	 => array(
                                        'label'	 => esc_html__( 'Facilities', 'charitious' ),
                                        'value'	 => esc_html__( 'Assisting senior consultants in projects', 'charitious' ),
                                        'type'	 => 'text',
                                    ),
                                ),
                                'value'				 => array(
                                    0	 => array(
                                        'title'	 => 'Assisting senior consultants in projects:',
                                    ),
                                    1	 => array(
                                        'title'	 => 'Share best practices and knowledge.',
                                    ),
                                )
                            ),
                        )
                    ),
                )
            ),
            'map'	 => array(
                'title'		 => __( 'Map Locations', 'charitious' ),
                'type'		 => 'tab',
                'options'	 => array(
                    'show_map_tab'	 => array(
                        'type'  => 'switch',
                        'value' => true,
                        'label' => __('Show Map Tab', 'charitious'),
                        'left-choice' => array(
                            'value' => false,
                            'label' => __('Hide', 'charitious'),
                        ),
                        'right-choice' => array(
                            'value' => true,
                            'label' => __('Show', 'charitious'),
                        ),
                    ),
                    'general-box3' => array(
                        'title'		 => __( 'Map Settings', 'charitious' ),
                        'type'		 => 'box',
                        'options'	 => array(
                            'event_map'		 => array(
                                'label'	 => __( 'Place Name', 'charitious' ),
                                'desc'	 => __( 'Event Description', 'charitious' ),
                                'type'	 => 'text',
                            ),
                        )
                    ),
                )
            ),
            'contact'	 => array(
                'title'		 => __( 'Contact Form', 'charitious' ),
                'type'		 => 'tab',
                'options'	 => array(
                    'show_contact_tab'	 => array(
                        'type'  => 'switch',
                        'value' => true,
                        'label' => __('Show Contact Tab', 'charitious'),
                        'left-choice' => array(
                            'value' => false,
                            'label' => __('Hide', 'charitious'),
                        ),
                        'right-choice' => array(
                            'value' => true,
                            'label' => __('Show', 'charitious'),
                        ),
                    ),
                    'general-box4' => array(
                        'title'		 => __( 'Contact Form Settings', 'charitious' ),
                        'type'		 => 'box',
                        'options'	 => array(
                            'event_contact'		 => array(
                                'label'	 => __( 'Contact Form', 'charitious' ),
                                'desc'	 => __( 'Enter contact form 7 shortcode', 'charitious' ),
                                'type'	 => 'textarea',
                            ),
                        )
                    ),
                )
            ),
            'sponsor'	 => array(
                'title'		 => __( 'Sponsor', 'charitious' ),
                'type'		 => 'tab',
                'options'	 => array(
                    'show_sponsor_tab'	 => array(
                        'type'  => 'switch',
                        'value' => true,
                        'label' => __('Show Sponsor', 'charitious'),
                        'left-choice' => array(
                            'value' => false,
                            'label' => __('Hide', 'charitious'),
                        ),
                        'right-choice' => array(
                            'value' => true,
                            'label' => __('Show', 'charitious'),
                        ),
                    ),
                    'general-box5' => array(
                        'title'		 => __( 'Sponsor Settings', 'charitious' ),
                        'type'		 => 'box',
                        'options'	 => array(
                            'event_sponsor'		 => array(
                                'type'  => 'multi-upload',
                                'value' => array(

                                ),
                                'label' => __('Sponsor Logo', 'charitious'),
                                'desc'  => __('Upload your sponsor logo', 'charitious'),
                                'images_only' => true,
                            ),
                        )
                    ),
                )
            ),

            'features'	     => array(
                'title'		 => __( 'Features', 'charitious' ),
                'type'		 => 'tab',
                'options'	 => array(
                    'show_features_tab'	 => array(
                        'type'  => 'switch',
                        'value' => true,
                        'label' => __('Show Features', 'charitious'),
                        'left-choice' => array(
                            'value' => false,
                            'label' => __('Hide', 'charitious'),
                        ),
                        'right-choice' => array(
                            'value' => true,
                            'label' => __('Show', 'charitious'),
                        ),
                    ),
                    'general-box2' => array(
                        'title'		 => __( 'Features Settings', 'charitious' ),
                        'type'		 => 'box',
                        'options'	 => array(
                            'event_features'	 => array(
                                'type'				 => 'addable-popup',
                                'limit'				 => '5',
                                'add-button-text'	 => __( 'Add Features info', 'charitious' ),
                                'label'				 => esc_html__( 'Features info', 'charitious' ),
                                'desc'				 => esc_html__( 'Add Features info', 'charitious' ),
                                'template'			 => '{{=title}}',
                                'popup-options'		 => array(
                                    'title'	 => array(
                                        'label'	 => esc_html__( 'Features', 'charitious' ),
                                        'value'	 => esc_html__( 'Event Mission', 'charitious' ),
                                        'type'	 => 'text',
                                    ),
                                    'description'		 => array(
                                        'label'	 => __( 'Description', 'charitious' ),
                                        'desc'	 => __( 'Feature Description', 'charitious' ),
                                        'type'	 => 'textarea',
                                    ),
                                ),
                                'value'				 => array(
                                    0	 => array(
                                        'title'	 => 'Event Mission',
                                        'description'	 => 'Event Mission Description Here',
                                    ),
                                    1	 => array(
                                        'title'	 => 'Event Vission',
                                        'description'	 => 'Event Vission Description Here',
                                    ),
                                    2	 => array(
                                        'title'	 => 'Our Vission',
                                        'description'	 => 'Our Vission Description Here',
                                    ),
                                )
                            ),
                        )
                    ),
                )
            ),
            'services'	     => array(
                'title'		 => __( 'Services', 'charitious' ),
                'type'		 => 'tab',
                'options'	 => array(
                    'show_services_tab'	 => array(
                        'type'  => 'switch',
                        'value' => true,
                        'label' => __('Show Services', 'charitious'),
                        'left-choice' => array(
                            'value' => false,
                            'label' => __('Hide', 'charitious'),
                        ),
                        'right-choice' => array(
                            'value' => true,
                            'label' => __('Show', 'charitious'),
                        ),
                    ),
                    'general-box2' => array(
                        'title'		 => __( 'Services Settings', 'charitious' ),
                        'type'		 => 'box',
                        'options'	 => array(
                            'event_services'	 => array(
                                'type'				 => 'addable-popup',
                                'limit'				 => '5',
                                'add-button-text'	 => __( 'Add Services info', 'charitious' ),
                                'label'				 => esc_html__( 'Services info', 'charitious' ),
                                'desc'				 => esc_html__( 'Add Services info', 'charitious' ),
                                'template'			 => '{{=title}}',
                                'popup-options'		 => array(
                                    'title'	 => array(
                                        'label'	 => esc_html__( 'Title', 'charitious' ),
                                        'value'	 => esc_html__( 'Title Here', 'charitious' ),
                                        'type'	 => 'text',
                                    ),
                                    'icon'	 => array(
                                        'label'	 => esc_html__( 'Icon Class', 'charitious' ),
                                        'value'	 => esc_html__( 'icon-water color-orange', 'charitious' ),
                                        'type'	 => 'text',
                                    ),
                                ),
                                'value'				 => array(
                                    0	 => array(
                                        'title'	 => esc_html__( 'Title Here', 'charitious' ),
                                        'icon'	 => 'icon-water color-orange',
                                    ),
                                    1	 => array(
                                        'title'	 => esc_html__( 'Title Here', 'charitious' ),
                                        'icon'	 => 'icon-water color-orange',
                                    ),
                                    2	 => array(
                                        'title'	 => esc_html__( 'Title Here', 'charitious' ),
                                        'icon'	 => 'icon-water color-orange',
                                    ),
                                )
                            ),
                        )
                    ),
                )
            ),
        ),
    ),
);
