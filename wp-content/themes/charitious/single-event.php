<?php
/**
 * single.php
 *
 * The template for displaying single posts.
 */
?>

<?php get_header(); ?>

<?php get_template_part( 'template-parts/header/content', 'blog-header' ) ?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $event_organization = '';
    $event_date = '';
    $event_venue = '';
    $event_phone = '';
    $event_email = '';
    $event_map = '';
    $event_contact = '';
    $event_desc = '';
    $event_facilities = '';
    $event_features = '';
    $event_services = '';
    $event_location = '';

    if ( defined( 'FW' ) ) {
        $event_organization = fw_get_db_post_option( get_the_ID(), 'event_organization' );
        $event_date = strtotime (fw_get_db_post_option( get_the_ID(), 'event_date' ));
        $event_date_main = fw_get_db_post_option( get_the_ID(), 'event_date' );
        $event_venue = fw_get_db_post_option( get_the_ID(), 'event_venue' );
        $event_phone = fw_get_db_post_option( get_the_ID(), 'event_phone' );
        $event_email = fw_get_db_post_option( get_the_ID(), 'event_email' );
        $event_map = fw_get_db_post_option( get_the_ID(), 'event_map' );
        $event_contact = fw_get_db_post_option( get_the_ID(), 'event_contact' );
        $event_sponsor = fw_get_db_post_option( get_the_ID(), 'event_sponsor' );
        $event_desc	= fw_get_db_post_option( get_the_ID(), 'event_desc' );
        $event_facilities = fw_get_db_post_option( get_the_ID(), 'event_facilities' );
        $event_features = fw_get_db_post_option( get_the_ID(), 'event_features' );
        $event_services = fw_get_db_post_option( get_the_ID(), 'event_services' );
        $event_location = fw_get_db_post_option( get_the_ID(), 'event_map' );
        $show_featured_image = fw_get_db_post_option( get_the_ID(), 'show_featured_image' );
        $event_details_title = fw_get_db_post_option( get_the_ID(), 'event_details_title' );
        $show_general_tab = fw_get_db_post_option( get_the_ID(), 'show_general_tab' );
        $show_facilities_tab = fw_get_db_post_option( get_the_ID(), 'show_facilities_tab' );
        $show_map_tab = fw_get_db_post_option( get_the_ID(), 'show_map_tab' );
        $show_contact_tab = fw_get_db_post_option( get_the_ID(), 'show_contact_tab' );
        $show_sponsor_tab = fw_get_db_post_option( get_the_ID(), 'show_sponsor_tab' );
        $show_features_tab = fw_get_db_post_option( get_the_ID(), 'show_features_tab' );
        $show_services_tab = fw_get_db_post_option( get_the_ID(), 'show_services_tab' );
    }
    ?>
    <main class="xs-all-content-wrapper">
    <div class="xs-content-section-padding xs-event-single" role="main">
        <div class="container">
            <div class="row">
            <?php if($show_featured_image): ?>
                <div class="col-md-12">
                    <?php if(has_post_thumbnail()): ?>
                        <div class="xs-event-banner">
                        <?php
                            echo wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'full', false, array(
                                'alt' => get_the_title()
                            ));
                         ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-8 xs-event-wraper">
                            <div class="xs-event-content">
                                <h4><?php echo esc_html($event_details_title); ?></h4>
                                <p><?php echo get_the_content(); ?></p>
                            </div>
                            <?php if($show_facilities_tab || $show_map_tab || $show_contact_tab): ?>
                            <div class="xs-horizontal-tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php if($show_facilities_tab): ?>
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#facilities" role="tab"><?php echo esc_html__('Facilities','charitious') ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if($show_map_tab): ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#mapLocation" role="tab"><?php echo esc_html__('Map Location','charitious') ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if($show_contact_tab): ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#contactUs" role="tab"><?php echo esc_html__('Contact us','charitious') ?></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <div class="tab-content">
                                    <?php if($show_facilities_tab): ?>
                                        <div class="tab-pane fade show active" id="facilities" role="tabpanel">
                                            <?php if(!empty($event_desc)):  ?>
                                                <p><?php echo esc_html($event_desc); ?></p>
                                            <?php endif; ?>

                                            <?php if(!empty($event_facilities) && is_array($event_facilities)):?>
                                                <ul class="xs-unorder-list circle green-icon">
                                                    <?php foreach( $event_facilities as $facilities ):?>
                                                        <li><?php echo esc_html($facilities['title']); ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($show_map_tab): ?>
                                        <div class="tab-pane fade" id="mapLocation" role="tabpanel">
                                        <div id="xs-event-map" class="xs-event-map" title="<?php echo esc_attr($event_location); ?>""></div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($show_contact_tab): ?>
                                        <div class="tab-pane fade" id="contactUs" role="tabpanel">
                                            <?php if(!empty($event_contact)): ?>
                                                <?php echo do_shortcode($event_contact); ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <?php endif; ?>
                            <?php if($show_features_tab): ?>
                                <?php if(!empty($event_features) && is_array($event_features)):?>
                                    <?php if($event_features[0]['title'] != ''): ?>
                                    <div class="row xs-mb-60">
                                        <div class="col-md-6 xs-about-feature">
                                            <h3><?php echo esc_html($event_features[0]['title']); ?></h3>
                                            <p><?php echo esc_html($event_features[0]['description']); ?></p>
                                        </div>
                                        <?php if($event_features[1]['title'] != ''): ?>
                                        <div class="col-md-6 xs-about-feature">
                                            <h3><?php echo esc_html($event_features[1]['title']); ?></h3>
                                            <p><?php echo esc_html($event_features[1]['description']); ?></p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($event_features[2]['title'] != ''): ?>
                                    <div class="xs-about-feature xs-mb-30">
                                        <h3><?php echo esc_html($event_features[1]['title']); ?></h3>
                                        <p><?php echo esc_html($event_features[1]['description']); ?></p>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($show_services_tab): ?>
                                <?php if(!empty($event_services) && is_array($event_services)):?>
                                    <div class="row">
                                        <?php foreach( $event_services as $service ):?>
                                            <div class="col-md-4">
                                                <div class="xs-service-promo">
                                                    <span class="<?php echo esc_attr($service['icon']); ?>"></span>
                                                    <h5><?php echo charitious_kses($service['title']); ?></h5>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            </div>


                                <div class="col-lg-4">
                                    <?php if($show_general_tab): ?>
                                        <div class="xs-event-schedule-widget">
                                            <div class="media xs-event-schedule">
                                                <div class="d-flex xs-evnet-meta-date">
                                                    <!--- This is event custom date.it's get from meta box.--->
                                                    <?php if(!empty($event_date)): ?>
                                                        <span class="xs-event-date"><?php echo date('d',$event_date); ?></span>
                                                        <span class="xs-event-month"><?php echo date('M',$event_date); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="media-body">
                                                    <h5><?php the_title();?></h5>
                                                </div>
                                            </div>
                                            <ul class="list-group xs-list-group">
                                                <?php if(!empty($speaker)): ?>
                                                    <li class="d-flex justify-content-between">
                                                        <?php echo esc_html__('Speaker:','charitious'); ?>
                                                        <span><?php echo esc_html($speaker); ?></span>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if(!empty($event_organization)): ?>
                                                    <li class="d-flex justify-content-between">
                                                        <?php echo esc_html__('Organized by:','charitious'); ?>
                                                        <span><?php echo esc_html($event_organization); ?></span>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if(!empty($event_time)): ?>
                                                    <li class="d-flex justify-content-between">
                                                        <?php echo esc_html__('Start:','charitious'); ?>
                                                        <span><?php echo esc_html($event_time); ?></span>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if(!empty($event_venue)): ?>
                                                    <li class="d-flex justify-content-between">
                                                        <?php echo esc_html__('Venue:','charitious'); ?>
                                                        <span><?php echo esc_html($event_venue); ?></span>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if(!empty($event_phone)): ?>
                                                    <li class="d-flex justify-content-between">
                                                        <?php echo esc_html__('Phone:','charitious'); ?>
                                                        <span><?php echo esc_html($event_phone); ?></span>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if(!empty($event_email)): ?>
                                                    <li class="d-flex justify-content-between">
                                                        <?php echo esc_html__('Email:','charitious'); ?>
                                                        <span><?php echo esc_html($event_email); ?></span>
                                                    </li>
                                                <?php endif; ?>

                                            </ul>
                                        </div>
                                        <?php if(!empty( $event_date)): ?>
                                            <div class="countdown-container xs-countdown-timer timer-style-2 xs-mb-30" data-countdown="<?php echo esc_attr($event_date_main); ?>"></div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if($show_sponsor_tab): ?>
                                        <?php $i = 0; ?>
                                        <?php if(!empty($event_sponsor) && is_array($event_sponsor)): ?>
                                            <div class="xs-event-schedule-widget">
                                                <h3 class="widget-title"><?php echo esc_html__('Event Sponsor','charitious') ?></h3>
                                                <ul class="xs-event-sponsor clearfix">
                                                    <?php foreach($event_sponsor as $sponsor): ?>
                                                        <?php
                                                        if($i == 4) break;
                                                        $thumbnail	 = $sponsor['attachment_id'];
                                                        ?>
                                                    <li><a href="#">
                                                    <?php
                                                       echo wp_get_attachment_image($thumbnail, 'full', false, array(
                                                        'alt' => get_the_title()
                                                       )); 
                                                    ?>
                                                    <?php $i++; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php endwhile; ?>
<?php get_footer(); ?>