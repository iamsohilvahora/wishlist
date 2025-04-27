<?php
/**
 * footer.php
 *
 * The template for displaying the footer.
 */


$footer_logo = charitious_option('footer_logo');
$footer_columns = charitious_option( 'footer_widget_layout',charitious_defaults('footer_widget_layout') );

$show_footer_logo = charitious_option( 'show_footer_logo',charitious_defaults('show_footer_logo') );
$footer_style = charitious_option( 'footer_style',charitious_defaults('footer_style') );
$show_footer_widget = charitious_option( 'show_footer_widget',charitious_defaults('show_footer_widget') );
if($footer_columns == 1 ) {
    $widget_width = 12;
}elseif($footer_columns == 2 ) {
    $widget_width = 6;
}elseif($footer_columns == 3 ) {
    $widget_width = 4;
}elseif($footer_columns == 4 ) {
    $widget_width = 3;
}elseif($footer_columns == 5 ) {
    $widget_width = 2;
}elseif($footer_columns == 6 ) {
    $widget_width = 2;
}

?>
<footer class="xs-footer-section footer-v<?php echo esc_attr($footer_style);?>">
    <?php if($show_footer_widget): ?>
    <div class="container">
        <div class="xs-footer-top-layer">
            <div class="row">
                <?php for ($i = 1; $i <= $footer_columns ;$i++):
                    $widget_width = apply_filters( "charitious_footer_widget_{$i}_width", $widget_width );
                    ?>
                    <div class="col-md-<?php echo esc_attr($widget_width); ?>">
                        <?php
                        if(is_active_sidebar('footer-widget-'.$i)):
                            dynamic_sidebar('footer-widget-'.$i);
                        endif;
                        ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="container">
        <div class="xs-copyright">
            <div class="row">
                <div class="col-md-6">
                    <div class="xs-copyright-text">
                       <p><?php echo charitious_option('copyright_text',charitious_defaults('copyright_text')); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <nav class="xs-footer-menu">
                        <?php get_template_part( 'template-parts/footer/footer', 'nav' ); ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="xs-back-to-top-wraper">
        <a href="#" class="xs-back-to-top"><i class="fa fa-angle-up"></i></a>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>