<?php
/**
 * sidebar.php
 *
 * The primary sidebar.
 */
?>
<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
	<aside class="sidebar-shop col-md-4 col-lg-3" role="complementary">
		<?php
		dynamic_sidebar( 'sidebar-3' );
		?>
	</aside> <!-- end sidebar -->
<?php endif; ?>