<?php get_header(); ?>

<div class="blog" role="main">
    <?php if ( is_author() ) :
        $author = get_queried_object();
        $author_id = $author->ID;

        // Get the author's role based on the author ID
        $author_user = get_userdata( $author_id );

        // Check if the author has the 'creator' role
        if ( $author_user && in_array( 'creator', $author_user->roles ) ) { ?>
            <section id="main-container" class="blog main-container" role="main">
                <div class="container">
                <?php
                    // Proceed only if the user is approved
                    $user_approved = get_user_meta($author_id, 'pw_user_status', true);

                    // placeholder image
                    $placeholder_img = get_option('charitious_theme_image_setting');

                    if ($user_approved === 'approved') {
                        $current_user = wp_get_current_user();
                        // Validate giftlist URL
                        $giftlist_url = !empty(get_user_meta($author_id, 'giftlist_url', true )) ? get_user_meta($author_id, 'giftlist_url', true ) : "";

                        // Validate twitter_link
                        $twitter_link = !empty(get_user_meta($author_id, 'twitter_link', true )) ? get_user_meta($author_id, 'twitter_link', true ) : "";

                        // If we have access to /vendor/autoload.php then initialize it.
                        require_once(ABSPATH . 'vendor/autoload.php');

                        // Retrieve the Stripe secret key from the theme mod
                        $stripe_secret_key = get_theme_mod('stripe_secret_key', '');

                        // Set up Stripe client
                        if(!empty($stripe_secret_key)){
                            $stripe = new \Stripe\StripeClient($stripe_secret_key);
                        }

                        $has_error = false;
                        $error_msg = '';
                        $stripe_account_id = get_user_meta($author_id, 'creator_stripe_account_id', true);

                        if (!empty($stripe_account_id) && !empty($stripe_secret_key)) {
                            // Retrieve the account from Stripe
                            try {
                                $account = $stripe->accounts->retrieve($stripe_account_id, []);
                            } catch (\Stripe\Exception\ApiErrorException $e) {
                                $has_error = true;
                                $error_msg = $e->getMessage();
                            }
                        }

                        if(!empty($giftlist_url) && !empty($stripe_account_id) && !($account->requirements->currently_due || $account->requirements->past_due) && !$has_error) {
                            $args = array(
                                'post_type'      => 'product',
                                'author'         => $author_id,
                                'posts_per_page' => -1, // Show all products,
                                'orderby'        => 'menu_order',
                                'order'          => 'DESC',
                            );

                            $author_products = new WP_Query( $args );
                            
                            if ( $author_products->have_posts() ) : ?>
                                <div class="row mt-5">
                                    <div class="col-md-4 mb-5">
                                        <div class="wishlist-box">
                                        <?php
                                            $site_url = get_site_url();
                                            $total_amount = get_user_meta($author_id, 'total_amount', true);
                                            // $total_no_gift = get_user_meta($author_id, 'total_no_gift', true);
                                            // Count the total number of product orders each user received within the specified period
                                            $total_no_gift = get_total_product_orders($author_id);
                                            $giftlist_url = get_user_meta($author_id, 'giftlist_url', true);
                                            $description = get_user_meta($author_id, 'description', true);
                                            $twitter_link = get_user_meta($author_id, 'twitter_link', true);
                                            $instagram_link = get_user_meta($author_id, 'instagram_link', true);

                                            // Retrieve the user data to get the display name
                                            $user_data = get_userdata($author_id);
                                            $display_name = $user_data->display_name;

                                            $profile_image_url = get_user_meta( $author_id, 'profile_image', true );
                                            $attachment_id = attachment_url_to_postid( $profile_image_url );
                                            $placeholder_img_url = get_option('charitious_theme_profile_image_setting');
                                            if ( ! empty( $profile_image_url ) && ! empty( $attachment_id ) ) : ?>
                                            <div>
                                                <a href="<?php echo esc_url( $profile_image_url ); ?>" target="_blank"><img src="<?php echo esc_url( $profile_image_url ); ?>" alt="<?php echo esc_attr( wp_unslash( $display_name ) ); ?>" width="100" height="100" /></a>
                                            </div>
                                            <?php else: ?>
                                            <div>
                                                <a href="<?php echo esc_url( $placeholder_img_url ); ?>" target="_blank"><img src="<?php echo esc_url( $placeholder_img_url ); ?>" alt="<?php echo esc_attr( wp_unslash( $display_name ) ); ?>" width="100" height="100" /></a>
                                            </div>
                                            <?php endif; ?>
                                            <div>
                                                <?php
                                                if (!empty($display_name)) {
                                                    echo '<p class="wishlist-name"> ' . esc_html($display_name) .  '\'s GiftList</p>';
                                                }

                                                if (!empty($giftlist_url)) {
                                                    echo '<p class="wishlist-url"> <a href="' . esc_url($site_url . '/giftlist/' . $giftlist_url) . '">' . "@" . esc_html($giftlist_url) . '</a></p>';
                                                }
                                                ?>
                                            </div>
                                            <!-- <div> -->
                                                <?php
                                                // if (!empty($total_no_gift)) {
                                                //     echo '<p><strong>Total Gifts: </strong>' . esc_html($total_no_gift) . '</p>';
                                                // }
                                                ?>
                                            <!-- </div> -->
                                            <?php
                                                if (!empty($description)) {
                                                    echo '<p class="no-giftlist">' . esc_html($description) . '</p>';
                                                }
                                            ?>
                                            <div class="wishlist-social-icons">
                                                <?php
                                                if (!empty($twitter_link) || !empty($instagram_link)) {
                                                    echo "<p>Social Media</p>";
                                                }

                                                if (!empty($twitter_link)) {
                                                  echo '<p> <a href="' . esc_url($twitter_link) . '" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></p>';
                                                }

                                                if (!empty($instagram_link)) {
                                                  echo '<p> <a href="' . esc_url($instagram_link) . '" target="_blank"><i class="fa-brands fa-instagram"></i></a></p>';
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sorting -->
                                    <div class="col-md-8">
                                        <div class="sort-by mb-4">
                                            <?php 
                                                $sorting_options = array(
                                                  'menu_order' => 'Default',
                                                  'price-desc' => 'Price: High to Low',
                                                  'price' => 'Price: Low to High',
                                                  'date' => 'Most recent',
                                                  'date_asc' => 'Oldest',
                                                );
                                            ?>
                                            Sort by:
                                            <select class="product-sort" data-author="<?php echo $author_id; ?>">
                                              <?php foreach ($sorting_options as $key => $label) : ?>
                                                <option value="<?php echo $key; ?>" <?php selected( $selected_sort === $key ); ?>><?php echo $label; ?></option>
                                              <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- Product list -->
                                        <div class="row product-list mt-5">
                                            <?php 
                                            $custom_class = (in_array('creator', $current_user->roles)) ? "no-pointer" : "";
                                            while ( $author_products->have_posts() ) : $author_products->the_post(); ?>
                                                <div class="col-6 col-lg-4 mb-5 <?php echo $custom_class; ?>">
                                                    <div class="product-item">
                                                        <div data-toggle="modal" data-target="#product-details-modal-<?php echo get_the_ID(); ?>">
                                                        <?php
                                                            if ( has_post_thumbnail() ) {
                                                                // Get the URL of the post thumbnail
                                                                $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), '' );

                                                                // Check if the thumbnail URL is not empty
                                                                if ( ! empty( $thumbnail_url ) ) {
                                                                    // Output the image tag
                                                                    echo '<img src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( get_the_title() ) . '" class="img-fluid" />';
                                                                }
                                                            } else {
                                                                // Display placeholder image if featured image is not available ?>
                                                                <img src="<?php echo $placeholder_img; ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="img-fluid" />
                                                            <?php }
                                                            $title = get_the_title();
                                                            if ( ! empty( $title ) ) {
                                                                echo '<h3 class="mt-3">' . esc_html( $title ) . '</h3>';
                                                            }
                                                            global $product;
                                                            $price = $product->get_price_html();
                                                            if ( ! empty( $price ) ) {
                                                                echo '<p class="product-price">' . $price . '</p>';
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php
                                                            if ( ! in_array( 'creator', $current_user->roles ) ):
                                                                // Add Copy Link icon
                                                                echo '<i class="copy-link-btn fa fa-link fa-1x" data-product-id="' . get_the_ID() . '"></i>';
                                                            endif;
                                                        ?>
                                                    </div>
                                                    <?php if ( ! in_array( 'creator', $current_user->roles ) ): ?>
                                                    <div class="modal fade" id="product-details-modal-<?php echo get_the_ID(); ?>" tabindex="-1" aria-labelledby="product-details-modal-label" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="addGiftModalLabel">Add To Cart</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php
                                                                        if ( has_post_thumbnail() ) {
                                                                            // Get the URL of the post thumbnail
                                                                            $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), '' );

                                                                            // Check if the thumbnail URL is not empty
                                                                            if ( ! empty( $thumbnail_url ) ) {
                                                                                // Output the image tag
                                                                                echo '<img src="' . esc_url( $thumbnail_url ) . '" alt="' . esc_attr( get_the_title() ) . '" class="img-fluid" />';
                                                                            }
                                                                        } else {
                                                                            // Display placeholder image if featured image is not available ?>
                                                                            <img src="<?php echo $placeholder_img; ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="img-fluid" />
                                                                        <?php }
                                                                        $title = get_the_title();
                                                                        if ( ! empty( $title ) ) {
                                                                            echo '<h3 class="mt-3">' . esc_html( $title ) . '</h3>';
                                                                        }
                                                                        global $product;
                                                                        $price = $product->get_price_html();
                                                                        if ( ! empty( $price ) ) {
                                                                            echo '<p class="product-price">' . $price . '</p>';
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary add-to-cart-keep-shopping-btn" id="add-to-cart-keep-shopping-btn" data-product-id="<?php echo get_the_ID(); ?>">Add To Cart And Keep Shopping</button>
                                                                    <button type="button" class="btn btn-primary add-to-cart-checkout-btn" id="add-to-cart-checkout-btn" data-product-id="<?php echo get_the_ID(); ?>">Add To Cart And Checkout</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endwhile; ?>
                                        </div>
                                        <?php if ( ! in_array( 'creator', $current_user->roles ) ): ?>
                                        <div class="modal fade" id="product-details-modal" tabindex="-1" aria-labelledby="product-details-modal-label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content"></div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <p class="no-giftlist">This creator has no Giftlist yet.</p>
                            <?php endif; ?>

                            <?php wp_reset_postdata();
                        } else { 
                            if($has_error) {
                                echo ' <p style="margin-top: 100px;" class="no-giftlist">' . $error_msg . '</p>';
                            }
                            else { ?>
                                <p style="margin-top: 100px;" class="no-giftlist">Kindly complete your Profile Details & Setup Withdrawal Account to see your Giftlist.</p>
                        <?php } }
                    } 
                    else { ?>
                        <p style="margin-top: 100px;" class="no-giftlist">Once you are approve by admin, You can see your Giftlist here.</p>
                    <?php 
                    }
            } 
            else { ?>
                <section id="main-container" class="blog main-container" role="main">
                    <?php get_template_part('template-parts/header/content', 'blog-header')?>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8">
                                <?php if (have_posts()) : the_post(); ?>
                                      <header class="xs-page-header">
                                          <h2>
                                              <?php printf(esc_html__('All posts by %s.', 'charitious'), get_the_author()); ?>
                                          </h2>

                                          <?php
                                          // If the author bio exists, display it.
                                          if (get_the_author_meta('description')) {
                                              echo '<p>' . the_author_meta('description') . '</p>';
                                          }
                                          ?>

                                          <?php rewind_posts(); ?>
                                      </header>

                                      <?php while (have_posts()) : the_post(); ?>
                                          <?php get_template_part('template-parts/post/content', get_post_format()); ?>
                                      <?php endwhile; ?>

                                      <?php charitious_paging_nav(); ?>
                              <?php else : ?>
                                    <?php get_template_part('template-parts/post/content', 'none'); ?>
                              <?php endif; ?>
                            </div> <!-- end main-content -->

                            <?php get_sidebar(); ?>
                        </div>
            <?php } ?>
                </div> 
            </section> 
    <?php else : ?>
        <p class="no-giftlist">You're not on an author archive page.</p>
    <?php endif; ?>
    
</div> <!-- end main-content -->

<?php get_footer(); ?>
