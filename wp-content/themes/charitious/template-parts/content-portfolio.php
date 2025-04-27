<?php
/**
 * content-portfolio.php
 *
 * The default template for displaying content.
 */
?>

<?php
$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), '');
$img = fw_resize($thumbnail[0], 750, 400);
?>
<?php
$gallery = fw_ext_portfolio_get_gallery_images();
if (!empty($gallery)):
    ?>
    <div class="portfolio-slider">
        <div class="flexportfolio flexslider">
    	<ul class="slides">
		<?php foreach ($gallery as $image) : ?>
		    <li>
            <?php
                   echo  wp_get_attachment_image($image['id'], array(780, 480), false, array(
                       'alt'  => get_the_title()
                   ));
            ?>
            </li>
		<?php endforeach ?>
    	</ul>

        </div>
    </div>
<?php else : 
         echo  wp_get_attachment_image($image['id'], array(780, 480), false, array(
             'alt'  => get_the_title()
            ));

endif; ?>

