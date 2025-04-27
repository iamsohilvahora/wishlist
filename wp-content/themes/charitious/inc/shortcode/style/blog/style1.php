<div class="col-md-6 col-lg-<?php echo esc_attr($count_col);?>">
    <div class="xs-box-shadow xs-single-journal xs-single-journal-2">
        <?php if(has_post_thumbnail()): ?>
            <div class="entry-thumbnail ">
                <?php
                   echo wp_get_attachment_image(get_post_thumbnail_id( $wp_query->ID ), 'full', false, array(
                       'alt'  => get_the_title($wp_query->ID)
                   ));
                ?>
                <div class="post-author">
                    <span class="xs-round-avatar">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 55 );?>
                    </span>
                    <span class="author-name">
                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><?php esc_html_e('By ','charitious');?><?php echo get_the_author(); ?></a>
                    </span>
                </div>
            </div>
        <?php endif; ?>

        <div class="entry-header">
            <div class="entry-meta">
            <span class="date">
                <a href="<?php echo get_the_permalink();  ?>" rel="bookmark" class="entry-date">
                    <?php echo get_the_date('d F Y');?>
                </a>
            </span>
            </div>
            <h4 class="entry-title">
                <a href="<?php echo get_the_permalink();  ?>"><?php the_title(); ?></a>
            </h4>
        </div>
        <span class="xs-separetor"></span>
        <div class="post-meta">
            <?php if ( comments_open() ) { ?>
            <span class="comments-link">
                <i class="fa fa-comments-o"></i>
                <a href="<?php echo get_comments_link();?>"><?php echo esc_html($comments);?></a>
            </span>
            <?php } ?>
            <?php
            if(class_exists('Xs_Main')){ 
                $Xs_Main = Xs_Main::xs_get_instance();
            ?>
            <span class="view-link">
                <i class="fa fa-eye"></i>
                <a href="<?php echo get_the_permalink();  ?>"><?php echo esc_html($Xs_Main->getPostViews(get_the_ID()));?></a>
            </span>
            <?php } ?>
        </div>
    </div>
</div>