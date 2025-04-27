<?php
if ( !defined( 'ABSPATH' ) )
    die( 'Direct access forbidden.' );
/**
 * Helper functions used all over the theme
 */

/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package xs
 */
/*
  Return
 *
 *  */

// simply echos the variable
function charitious_return( $s ) {
    return $s;
}

/*
 * FOR ONE PAGE Section
 * since 1.0
 */

function charitious_editor_data( $value ) {
    return wp_kses_post( $value );
}

// Gets unyson option data in safe mode
// since 1.0

function charitious_get_option( $k, $v = '', $m = 'theme-settings' ) {
    if ( defined( 'FW' ) ) {
        switch ( $m ) {
            case 'theme-settings':
                $v = fw_get_db_settings_option( $k );
                break;

            default:
                $v = '';
                break;
        }
    }
    return $v;
}

if ( !function_exists( 'xs_resize' ) ) {
    function xs_resize( $url, $width = false, $height = false, $crop = false ) {
        if(function_exists('fw_resize')){
            $fw_resize = FW_Resize::getInstance();
            $response  = $fw_resize->process( $url, $width, $height, $crop );
            return ( ! is_wp_error( $response ) && ! empty( $response['src'] ) ) ? $response['src'] : $url;
        }else{
            return $url;
        }

    }
}
// Gets unyson image url from option data in a much simple way
// sience 1.0

function charitious_get_image( $k, $v = '', $d = false ) {

    if ( $d == true ) {
        $attachment = $k;
    } else {
        $attachment = charitious_get_option( $k );
    }

    if ( isset( $attachment[ 'url' ] ) && !empty( $attachment ) ) {
        $v = $attachment[ 'url' ];
    }

    return $v;
}

/* Gets unyson image url from variable
 * sience 1.0
 * charitious_image($img, $alt )
 */

function charitious_image( $img, $alt, $v = '' ) {

    if ( isset( $img[ 'url' ] ) && !empty( $img ) ) {
        $i	 = $img[ 'url' ];
        $v	 = "<img src=" . $i . " alt=" . $alt . " />";
    }

    return $v;
}

// Gets original page ID/ Slug
// since 1.0

function charitious_main( $id, $name = true ) {
    if ( function_exists( 'icl_object_id' ) ) {
        $id = icl_object_id( $id, 'page', true, 'en' );
    }

    if ( $name === true ) {
        $post = get_post( $id );
        return $post->post_name;
    } else {
        return $id;
    }
}



// Gets post's meta data in a much simplier way.
// since 1.0

function charitious_get_post_meta( $id, $needle ) {
    $data = get_post_meta( $id, 'fw_options' );
    if ( is_array( $data ) && isset( $data[ 0 ][ 'page_sections' ] ) ) {
        $data = $data[ 0 ][ 'page_sections' ];

        if ( is_array( $data ) ) {
            return charitious_seekKey( $data, $needle );
        }
    }
}

// return the specific value from metabox
// ----------------------------------------------------------------------------------------
function charitious_meta_option( $postid, $key, $default_value = '' ) {
	if ( defined( 'FW' ) ) {
		$value = fw_get_db_post_option($postid, $key, $default_value);
	}
	return (!isset($value) || $value == '') ? $default_value :  $value;
}


/*
 * btn Function
 * since 1.0
 */
//btn function

if ( !function_exists( 'charitious_theme_button_class' ) ) :

    function charitious_theme_button_class( $style ) {
        /**
         * Display specific class for buttons - depends on theme
         */
        if ( $style == 'default' ) {
            echo 'btn btn-border';
        } elseif ( $style == 'primary' ) {
            echo 'btn btn-primary';
        } else {
            echo 'default';
        }
    }

endif;





/*
 * This fucntion for recent post shortcode.
 * people can select show from one category or from all category
 * since 1.0
 */

// term
if ( !function_exists( 'charitious_get_category_term_list' ) ) :

    function charitious_get_category_term_list() {
        /**
         * Return array of categories
         */
        $taxonomy	 = 'category';
        $args		 = array(
            'hide_empty' => true,
        );

        $terms		 = get_terms( $taxonomy, $args );
        $result		 = array();
        $result[ 0 ]	 = esc_html__( 'All Categories', 'charitious' );

        if ( !empty( $terms ) )
            foreach ( $terms as $term ) {
                $result[ $term->term_id ] = $term->name;
            }
        return $result;
    }

endif;



/*
 * Function for color RGB
 */

function charitious_color_rgb( $hex ) {
    $hex		 = preg_replace( "/^#(.*)$/", "$1", $hex );
    $rgb		 = array();
    $rgb[ 'r' ]	 = hexdec( substr( $hex, 0, 2 ) );
    $rgb[ 'g' ]	 = hexdec( substr( $hex, 2, 2 ) );
    $rgb[ 'b' ]	 = hexdec( substr( $hex, 4, 2 ) );

    $color_hex = $rgb[ "r" ] . ", " . $rgb[ "g" ] . ", " . $rgb[ "b" ];

    return $color_hex;
}

/*
 * Section Edit option
 *
 * This function for show section edit option in every section in one page
 *
 * Since 1.0
 *  */

function charitious_edit_section() {
    ?>
    <div class="section-edit">
        <div class="container relative">
            <?php
            if ( is_user_logged_in() ) {
                edit_post_link( esc_html__( 'Edit', 'charitious' ), '', '' );
            }
            ?>
            <span class="section-abc"><?php echo esc_html( get_the_title() ); ?></span>
        </div>
    </div>
    <?php
}




// breadcrumbs

if ( !function_exists( 'charitious_get_breadcrumbs' ) ) {

    function charitious_get_breadcrumbs( $seperator = ' / ' ) {
        echo '<ul class="xs-breadcumb"><li class="badge badge-pill badge-primary">';
        if ( !is_home() ) {
            echo '<a href="';
            echo esc_url( get_home_url( '/' ) );
            echo '">';
            echo esc_html__( 'Home', 'charitious' );
            echo "</a>";
            if ( is_category() || is_single() ) {
                $category	 = get_the_category();
                $post		 = get_queried_object();
                $postType	 = get_post_type_object( get_post_type( $post ) );
                if ( !empty( $category ) ) {
                    echo esc_attr( $seperator );
                    echo esc_html( $category[ 0 ]->cat_name );
                } else if ( $postType ) {
                    echo esc_attr( $seperator );
                    echo esc_html( $postType->labels->singular_name );
                }
                if ( is_single() ) {
                    echo esc_attr( $seperator );
                    echo wp_trim_words( get_the_title(), 3 );
                }
            } elseif ( is_page() ) {
                echo esc_attr( $seperator );
                echo wp_trim_words( get_the_title(), 3 );
            }
        }
        if ( is_tag() ) {
            echo esc_attr( $seperator );
            single_tag_title();
        } elseif ( is_day() ) {
            echo esc_attr( $seperator );
            echo esc_html__( 'Blogs for', 'charitious' ) . " ";
            the_time( 'F jS, Y' );
        } elseif ( is_month() ) {
            echo esc_attr( $seperator );
            echo esc_html__( 'Blogs for', 'charitious' ) . " ";
            the_time( 'F, Y' );
        } elseif ( is_year() ) {
            echo esc_attr( $seperator );
            echo esc_html__( 'Blogs for', 'charitious' ) . " ";
            the_time( 'Y' );
        } elseif ( is_author() ) {
            echo esc_attr( $seperator );
            echo esc_html__( 'Author Blogs', 'charitious' );
        } elseif ( isset( $_GET[ 'paged' ] ) && !empty( $_GET[ 'paged' ] ) ) {
            echo esc_html__( 'Blogs', 'charitious' );
        } elseif ( is_search() ) {
            echo esc_attr( $seperator );
            echo  esc_html__( 'Search Result', 'charitious' );
        } elseif ( is_404() ) {
            echo esc_attr( $seperator );
            echo esc_html__( '404 Not Found', 'charitious' );
        }
        echo '</li></ul>';
    }

}


/*
 * WP Kses Allowed HTML Tags Array in function
 * @Since Version 0.1
 * @param ar
 * Use: charitious_kses($raw_string);
 * */

function charitious_kses( $raw ) {

    $allowed_tags = array(
        'a'								 => array(
            'class'	 => array(),
            'href'	 => array(),
            'rel'	 => array(),
            'title'	 => array(),
        ),
        'abbr'							 => array(
            'title' => array(),
        ),
        'b'								 => array(),
        'blockquote'					 => array(
            'cite' => array(),
        ),
        'cite'							 => array(
            'title' => array(),
        ),
        'code'							 => array(),
        'del'							 => array(
            'datetime'	 => array(),
            'title'		 => array(),
        ),
        'dd'							 => array(),
        'div'							 => array(
            'class'	 => array(),
            'title'	 => array(),
            'style'	 => array(),
        ),
        'dl'							 => array(),
        'dt'							 => array(),
        'em'							 => array(),
        'h1'							 => array(),
        'h2'							 => array(),
        'h3'							 => array(),
        'h4'							 => array(),
        'h5'							 => array(),
        'h6'							 => array(),
        'i'								 => array(
            'class' => array(),
        ),
        'img'							 => array(
            'alt'	 => array(),
            'class'	 => array(),
            'height' => array(),
            'src'	 => array(),
            'width'	 => array(),
        ),
        'li'							 => array(
            'class' => array(),
        ),
        'ol'							 => array(
            'class' => array(),
        ),
        'p'								 => array(
            'class' => array(),
        ),
        'q'								 => array(
            'cite'	 => array(),
            'title'	 => array(),
        ),
        'span'							 => array(
            'class'	 => array(),
            'title'	 => array(),
            'style'	 => array(),
        ),
        'strike'						 => array(),
        'br'							 => array(),
        'strong'						 => array(),
        'data-wow-duration'				 => array(),
        'data-wow-delay'				 => array(),
        'data-wallpaper-options'		 => array(),
        'data-stellar-background-ratio'	 => array(),
        'ul'							 => array(
            'class' => array(),
        ),
    );

    if ( function_exists( 'wp_kses' ) ) { // WP is here
        $allowed = wp_kses( $raw, $allowed_tags );
    } else {
        $allowed = $raw;
    }


    return $allowed;
}


/**
 *
 * Load Goggle Font
 * @since 1.0.0
 *
 */

function charitious_google_fonts_url()
{
    $fonts_url = '';
    $font_families = array();
    //Body Font
    $body_font = charitious_option('body_font', charitious_defaults('body_font'));
    if(!empty($body_font)){
        $body_families = isset($body_font['font-family']) ? $body_font['font-family'] : '';
        $body_variant = isset($body_font['variant']) ? $body_font['variant'] : '';
        $font_families[] = $body_families.":".$body_variant;
    }
    //Heading font
    if(!empty($head_font)){
        $head_font = charitious_option('heading_font', charitious_defaults('heading_font'));
        $head_families = isset($head_font['font-family']) ? $head_font['font-family'] : '';
        $head_variant = isset($head_font['variant']) ? $head_font['variant'] : '';
        $font_families[] = $head_families.":".$head_variant;
    }

    $font_families[] = 'Poppins:300,400,500,600,700|Roboto+Slab:400,700';

    if ($font_families) {
        $query_args = array(
            'family' => urlencode(implode('|', $font_families))
        );

        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}

/* 
* Elementor ID 
*/
 if ( !defined( 'ELEMENTOR_PARTNER_ID' ) ) { 
define( 'ELEMENTOR_PARTNER_ID', 2144 ); 
}


/**
 *
 * Get Catagories/Taxonomies List
 * @since 1.0.0
 *
 */

function xs_category_list_slug( $cat ='event_cat' ){
    $query_args = array(
        'orderby'       => 'ID',
        'order'         => 'DESC',
        'hide_empty'    => 1,
        'taxonomy'      => $cat
    );
 
    $categories = get_categories( $query_args );
 
    $options = array( 'all' => esc_html__('All Category', 'charitious'));
    if(is_array($categories) && count($categories) > 0){
        foreach($categories as $category){
            $options[$category->slug] = $category->name;
        }
        
        
    }
    return $options;
}

/**
 *
 * Get Catagories/Taxonomies List
 * @since 1.0.0
 *
 */

function xs_featured_product(){
    $query_args = array(
        'post_type'     => 'product',
        'tax_query'     => array(
            'relation'  => 'AND',
            array(
                'taxonomy'  => 'product_type',
                'field'     => 'slug',
                'terms'     => 'wp_fundraising',
            ),
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
            ),
        ),
        'posts_per_page' => -1,
    );
    $xs_query = new WP_Query($query_args);
    $options = array( esc_html__('0', 'charitious') => 'Select Product');
    if($xs_query->have_posts()):
        while ($xs_query->have_posts()) {
            $xs_query->the_post();
            $options[get_the_ID()] = get_the_title();
        }
        wp_reset_postdata();
        return $options;
    endif;

}

function charitious_option($option) {
    // Get options
    return get_theme_mod( $option, charitious_defaults($option) );
}

function charitious_defaults($options){

    $default = array(
        'body_font' => array(),
        'heading_font' => array(),
        'header_layout'  => '3',
        'show_login' => '',
        'charitious_dashbord' => '',
        'top_bar_email' => esc_html__( 'info@example.com', 'charitious' ),
        'show_border' => '',
        'page_sidebar' => 3,
        'blog_show_breadcrumb' => false,
        'page_show_breadcrumb' => true,
        'show_topbar' => false,
        'blog_sidebar' => 3,
        'blog_heading_title' => '',
        'blog_style' => 'style1',
        'blog_grid_column' => '4',
        'blog_single_sidebar' => 1,
        'blog_author'	=>	'',
        'show_author' => '',
        'show_social'	=> '',
        'show_category'=> 1,
        'show_comment'=> 1,
        'show_preloader' => '',
        'shop_heading_title' => esc_html__('Shopping Now','charitious'),
        'shop_grid_column' => 4,
        'shop_sidebar' =>1,
        'shop_show_breadcrumb' =>'',
        'donate_text' =>esc_html__("Donate Now","charitious"),
        'footer_style' =>"4",
        'facebook' => '#',
        'instagram' => '#',
        'twitter' => '#',
        'dribbble' => '#',
        'pinterest' => '#',
        'show_footer_logo' => false,
        'show_footer_widget' => false,
        'footer_widget_layout' => 4,
        'copyright_text' => esc_html__( 'Copyrights By © Xpeedstudio - 2021', 'charitious' ),
        'donate_btn_title' => esc_html__('Donate Now','charitious'),
        'donate_btn_link' => '#',
        'map_api' => 'AIzaSyCy7becgYuLwns3uumNm6WdBYkBpLfy44k',
    );

    if(!empty($default[$options])) return $default[$options];
}

/**
 *
 * Get Catagories/Taxonomies List
 * @since 1.0.0
 *
 */

function xs_category_list( $cat ){
    $query_args = array(
        'orderby'       => 'ID',
        'order'         => 'DESC',
        'hide_empty'    => 1,
        'taxonomy'      => $cat
    );

    $categories = get_categories( $query_args );
    $options = array( esc_html__('0', 'charitious') => 'All Category');
    if(is_array($categories) && count($categories) > 0){
        foreach ($categories as $cat){
            $options[$cat->term_id] = $cat->name;
        }
        return $options;
    }
}

function charitious_get_posts($post_type){
    $mega_menus = array();
    $args = array(
        'post_type' => $post_type,
    );
    $posts = get_posts($args);
    foreach ($posts as $post){
        $mega_menus[$post->post_name] = $post->post_title;
    }
    return $mega_menus;
}

function charitious_get_mega_item_child_slug($location, $option_id){

    $mega_item = '';
    $locations 	= get_nav_menu_locations();
    $menu 		= wp_get_nav_menu_object( $locations[$location] );
    $menuitems 	= wp_get_nav_menu_items( $menu->term_id );

    foreach ($menuitems as $menuitem){

        $id = $menuitem->ID;
        $mega_item = fw_ext_mega_menu_get_db_item_option($id, $option_id);

    }
    return $mega_item;
}

function charitious_get_post_content($title){
    $args = array(
        'title'        => $title,
        'post_type'   => 'mega_menu',
        'post_status' => 'publish',
        'numberposts' => 1
    );

    $the_query = new WP_Query( $args );
    $output = '';
    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();
            ob_start();
            the_content();
            $output = ob_get_clean();

        endwhile;
    endif;
    wp_reset_postdata();

    return $output;
}

function charitious_get_sell_price($xs_id){
    $xs_product = wc_get_product(get_the_id());
    $sale_price = get_post_meta( $xs_id, '_price', true);
    $regular_price = get_post_meta( $xs_id, '_regular_price', true);
    if (empty($regular_price)){ //then this is a variable product
        $available_variations = $xs_product->get_available_variations();
        $variation_id=$available_variations[0]['variation_id'];
        $variation= new WC_Product_Variation( $variation_id );
        $regular_price = $variation ->regular_price;
        $sale_price = $variation ->sale_price;
    }
    $sale = ceil(( ($regular_price - $sale_price) / $regular_price ) * 100);
    return $sale.'%';
}
function charitious_wc_get_product_list(){
        $query_args = array(
            'post_type'     => 'product',
            'posts_per_page' => -1,
        );
        $xs_query = new WP_Query($query_args);
        $options = array( esc_html__('0', 'charitious') => 'Select Product');
        if($xs_query->have_posts()):
            while ($xs_query->have_posts()) {
                $xs_query->the_post();
                $options[get_the_ID()] = get_the_title();
            }
            wp_reset_postdata();
            return $options;
        endif;
}

function charitious_rand_str($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//WP Fundraising Donation deleted method

function charitious_wfp_donate_table( $table = '' ) {
    $table_name = 'wdp_fundraising';
    global $wpdb;

    return empty( $table ) ? $wpdb->prefix .  $table_name : $wpdb->prefix . $table;
}

//WP Fundraising Donation deleted method

function charitious_wfp_get_sum($tableName = '', $sumFied = '', $queryData = '') {
    $tableName = charitious_wfp_donate_table($tableName);
    global $wpdb;
    $myrows = $wpdb->get_var($wpdb->prepare("SELECT SUM(%s) FROM `%s` WHERE 1 = 1 %s", $sumFied, $tableName, $queryData ));

    return $myrows;
}

//WP Fundraising Donation deleted method

function charitious_wfp_get_count($tableName = '', $sumFied = '*', $queryData = '') {
    $tableName = charitious_wfp_donate_table($tableName);
    global $wpdb;
    $myrows = $wpdb->get_var($wpdb->prepare("SELECT COUNT(%s) FROM `%s` WHERE 1 = 1 %s", $sumFied, $tableName, $queryData ));

    return $myrows;
}