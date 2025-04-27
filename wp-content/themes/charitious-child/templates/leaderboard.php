<?php
/*
Template Name: Leaderboard
*/

get_header(); // Get header.

$per_page = get_theme_mod('theme_ppp_setting', 10); // Default to 10 if not set - Number of creators per page

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; // Get current page number

$args = array(
    'role'     => 'creator', // Filter users by role
    'number'       => -1,        // No limit
    'meta_query'   => array(
        'relation' => 'AND',
        array(
            'key'     => 'pw_user_status',
            'value'   => 'approved',
            'compare' => '='
        ),
        array(
            'key'     => 'user_giftlist',
            'value'   => 'a:0:{}',
            'compare' => '!=',  // Ensure the 'user_giftlist' is not an empty array
        ),
        array(
            'key'     => 'giftlist_url',
            'value'   => '',
            'compare' => '!=',
        ),
        array(
            'key'     => 'creator_stripe_account_id',
            'value'   => '',
            'compare' => '!=',
        ),
        array(
            'key'     => 'creator_stripe_account_link',
            'value'   => '',
            'compare' => '!=',
        )
    )
);

// Initialize an array to store creators and their product order counts.
$users_with_orders = array();

$offset = ( $paged - 1 ) * $per_page; // offset

// Query the users
$users_query = new WP_User_Query( $args );
$users = $users_query->get_results();

$total_users = $users_query->get_total(); // Total number of users
$total_pages = ceil( ( $total_users )  / $per_page ); // Total number of pages

// By default monthly period
$period = "monthly";

// Loop through the fetched users
foreach ($users as $user) {
    // Count the total number of product orders each user received within the specified period
    $total_product_orders = get_total_product_orders($user->ID);

    // Store the user ID and their total product order count in the array
    $users_with_orders[$user->ID] = $total_product_orders;
}

// Sort the users array based on the total product order count in descending order
arsort($users_with_orders);

// Extract the sorted user IDs
$sorted_user_ids = array_keys($users_with_orders);

// Query parameter.
$args['orderby'] = "include";
$args['order'] = "ASC";
$args['include'] = $sorted_user_ids;

$args['number'] = $per_page;
$args['offset'] = $offset;

$users_query = new WP_User_Query( $args );
$users = $users_query->get_results();

if ( $users ) : ?>
    <div class="container" style="margin: 150px;">
        <div class="leaderboard-users">
            <h2 class="mt-4 mb-3">Active Users</h2>

            <!-- Search Box -->
            <div class="search-bar" class="mb-3">
                <div>
                    <input type="text" class="form-control m-0" id="searchBox" placeholder="Search for wisher...">
                </div>
            </div>

            <!-- Table of creators -->
            <table class="table table-hover">
                <tbody id="userList">
                    <?php
                    $counter = 0;
                    foreach ( $users as $user ) : ?>
                        <tr onclick="window.location='<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>'">   
                            <td><?php echo "#" . esc_html( ++$counter ); ?></td>
                            <td>
                                <div>
                                    <?php
                                    // Get profile image URL.
                                    $profile_image_url = get_user_meta($user->ID, 'profile_image', true);
                                    $attachment_id = attachment_url_to_postid( $profile_image_url );
                                    if (!empty($profile_image_url) && !empty($attachment_id)) : ?>
                                        <a href="javascript:void(0);"><img src="<?php echo esc_url($profile_image_url); ?>" alt="<?php echo esc_html( $user->display_name ); ?>" class="img-fluid" /></a>
                                    <?php else:
                                        $placeholder_img = get_option('charitious_theme_profile_image_setting'); // placeholder image ?>
                                        <a href="javascript:void(0);"><img src="<?php echo esc_url($placeholder_img); ?>" alt="<?php echo esc_html( $user->display_name ); ?>" class="img-fluid" /></a>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p><?php echo esc_html( $user->display_name ); ?></p>
                                    <?php
                                    // Get wisher url
                                    $giftlist_url = !empty(get_user_meta( $user->ID, 'giftlist_url', true )) ? get_user_meta( $user->ID, 'giftlist_url', true ) : $user->user_nicename;
                                    ?>
                                    <a href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>">
                                        <?php echo "@" . esc_html( $giftlist_url ); ?>
                                    </a>    
                                </div>
                            </td>
                            <!-- <td> -->
                                <!-- <p style="width: 100%"> -->
                                    <?php
                                        // Get gift according to order duration.
                                        // $total_gift = $users_with_orders[$user->ID];
                                        // echo esc_html( $total_gift ) . " gifts";
                                    ?>
                                <!-- </p> -->
                            <!-- </td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if($total_pages > 1): ?>
            <div class="pagination justify-content-center mt-4" data-current-page="<?php echo esc_attr( $paged ); ?>" data-total-pages="<?php echo esc_attr( $total_pages ); ?>">
                <?php if ( $paged > 1 ) : ?>
                    <li class="page-item"><a class="page-link creator-page" href="<?php echo get_pagenum_link( $paged - 1 ); ?>" data-page="<?php echo esc_attr( $paged - 1 ); ?>"><i class="fa fa-solid fa-chevron-left"></i></a></li>
                <?php else : ?>
                    <li class="page-item"><span class="page-link disabled"><i class="fa fa-solid fa-chevron-left"></i></span></li>
                <?php endif; ?>
                <?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
                    <li class="page-item <?php echo ( $paged === $i ) ? 'active' : ''; ?>"><a class="page-link creator-page" href="<?php echo get_pagenum_link( $i ); ?>" data-page="<?php echo esc_attr( $i ); ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
                <?php if ( $paged < $total_pages ) : ?>
                    <li class="page-item"><a class="page-link creator-page" href="<?php echo get_pagenum_link( $paged + 1 ); ?>" data-page="<?php echo esc_attr( $paged + 1 ); ?>"><i class="fa fa-solid fa-chevron-right"></i></a></li>
                <?php else : ?>
                    <li class="page-item"><span class="page-link disabled"><i class="fa fa-solid fa-chevron-right"></i></span></li>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Spinner -->
            <div id="spinner" class="d-none">
                <i class="fa fa-spinner fa-spin fa-3x" style="color: #007bff"></i>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="container">
        <p class="mt-4">No Creators Found.</p>
    </div>
<?php endif;

get_footer(); // Get footer.
