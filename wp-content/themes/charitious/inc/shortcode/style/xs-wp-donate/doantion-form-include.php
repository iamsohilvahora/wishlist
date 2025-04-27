<?php
$feature = new \WfpFundraising\Apps\Featured(false);

$title_enable = isset($atts['title']) ? $atts['title'] : 'Yes';
$featured_enable = isset($atts['featured']) ? $atts['featured'] : 'Yes';
$categori_enable = isset($atts['category']) ? $atts['category'] : 'Yes';
$goal_enable = isset($atts['goal']) ? $atts['goal'] : 'Yes';

// Get gallery
$gallery_display = '';
$gallery_array = explode(',', get_post_meta($post->ID,'wfp_portfolio_gallery',true));

if (is_array($gallery_array) && sizeof($gallery_array)) {
	$gallery_display .= '<ul class="wfp-portfolio-gallery">';
	
	foreach ($gallery_array as $gallery_item) {
		$gallery_display .= '<li><a class="xs_popup_gallery" href="' . wp_get_attachment_url($gallery_item) . '">
		<img id="portfolio-item-' . $gallery_item . '" src="' . wp_get_attachment_thumb_url($gallery_item) . '">
		</a></li>';
	}
	$gallery_display .= '</ul>';
}

$categories = get_the_terms( $post->ID, 'wfp-categories' );

?>

<div class="wfp-modal-header">
	<?php
	if($categori_enable == 'Yes'):
		if ( ! empty( $categories ) ) {	
		$separator = "<span class='wfp-header-cat--separator'>-</span>";
		$outputCate = '';
	
		$array_keys = array_keys($categories);
        $last_key = end($array_keys);
		foreach( $categories as $key => $category ) {
			$outputCate .= '<a class="wfp-header-cat--link" href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'charitious' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>';

			if($key !== $last_key) {
				$outputCate .= $separator;
			}

		}
		
		?>
		<div class="wfp-header-cat"><?php echo charitious_kses($outputCate); ?></div>
		
	<?php } 
	endif;
	if($title_enable == 'Yes' && $modal_status == 'No'):
	?>
		<h4 class="wfp-post-title"><?php echo esc_html($post->post_title);?></h4>
	<?php
	endif;
	if( $featured_enable == 'Yes' ):?>
		<!-- Before Content-->		
		<?php do_action('wfp_single_thumbnil_before');?>

		<?php if( $feature->has_featured_video( $post->ID ) ) {?>
			<div class="wfp-feature-video">
				<?php echo charitious_kses( $feature->wfp_featured_video_iframe($post->ID));?>
			</div>
		<?php }else{?>
			<div class="wfp-post-image">
				<?php echo get_the_post_thumbnail($post->ID); ?>
			</div>
		<?php }?>

		<!-- After Content-->	
		<?php do_action('wfp_single_thumbnil_after');?>
	<?php endif;?>
	<!-- gallery image -->
</div>

<?php
// before content data
if(isset($formContentData->enable) && $formContentData->content_position == 'before-form'){
?>
<div class="wfdp-donation-content-data before-form">
	<?php echo charitious_kses($formContentData->content); ?>
</div>
<?php
}
// goal data show
if($goal_enable == 'Yes'):
	include( __DIR__ .'/goal-content.php');
endif;
?>


<?php
// amount content
include( __DIR__ .'/amount-content.php');


$enableDisplayField = ($form_styles == 'only_button' && $modal_status == 'No') ? 'xs-show-div-only-button__'.$post->ID.' xs-donate-hidden' : '';

// addition fees 
include( __DIR__ .'/fees-content.php');
if($gateCampaignData == 'default'){	
	// addition al filed content
	include( __DIR__ .'/filed-content.php');
	// payment content	
	include( __DIR__ .'/payment-content.php');
}	
?>

<?php
if(isset($formContentData->enable) && $formContentData->content_position == 'after-form'){
?>

	<div class="wfdp-donation-content-data before-form">
		<?php echo charitious_kses($formContentData->content); ?>
	</div>
<?php } ?>
