<?php
/**
 * 404.php
 *
 * The template for displaying 404 pages (Not Found).
 */
?>

<?php get_header(); ?>
<div class="blog" role="main">
    <?php get_template_part('template-parts/header/content', 'page-header')?>
    <div class="main-content blog-wrap error-page">
        <div class="container">
            <div class="error-page text-center">
                <div class="error-code">
                    <strong><?php esc_html_e('404', 'charitious') ?></strong>
                </div>
                <div class="error-message">
                    <h3><?php esc_html_e('Oops... Page Not Found!', 'charitious') ?></h3>
                </div>
                <div class="search-forms"> <?php get_search_form(); ?></div>
                <div class="error-body">
                    <?php esc_html_e('Try using the button below to go to main page of the site', 'charitious') ?>
                     <br>
                     <a href="<?php echo esc_url(home_url()) ?>" class="btn btn-primary solid blank"><i class="fa fa-arrow-circle-left">&nbsp;</i> <?php esc_html_e('Go to Home', 'charitious') ?></a>
                </div>
            </div>
        </div> 
    </div> <!-- end main-content -->
    <?php get_footer(); ?>