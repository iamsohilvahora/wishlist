<?php if ( !defined( 'FW' ) ) {	die( 'Forbidden' ); }

$options = array(
        'event_date_cat'=>array(
            'type'  => 'datetime-picker',
            'value' => '',
            'label' => __('Event Date', 'charitious'),
            'desc'  => __('Enter your event date', 'charitious'),
            'datetime-picker' => array(
                'format'        => 'Y/m/d',
                'maxDate'       => false,
                'minDate'       => false,
                'timepicker'    => false,
                'datepicker'    => true,
                'defaultTime'   => '12:00'
            ),
        ),
);
