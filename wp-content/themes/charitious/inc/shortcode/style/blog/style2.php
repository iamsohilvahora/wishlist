<div class="col-lg-<?php echo esc_attr($count_col);?> col-md-6">
    <div class="xs-single-journal">
        <?php if(has_post_thumbnail()): ?>
            <div class="entry-thumbnail ">
                 <?php
                   echo wp_get_attachment_image(get_post_thumbnail_id( $wp_query->ID ), 'full', false, array(
                       'alt'  => get_the_title($wp_query->ID)
                   ));
                ?>
            </div>
        <?php endif; ?>
        <div class="entry-header">
            <div class="entry-meta">
                <span class="date">
                    <a href="#"  rel="bookmark" class="entry-date">
                        <strong><?php echo get_the_date('d');?></strong> <?php echo get_the_date('F');?>
                        
                    </a>
                </span>
            </div>
            
            <h4 class="entry-title">
                <a href="<?php echo get_the_permalink();  ?>"><?php the_title(); ?></a>
            </h4>
            <div class="post-meta">
                <span class="post-category">
                    <i class="icon-folder"></i><?php echo get_the_category_list( ', ' ); ?>
                </span>
            </div>
            <span class="xs-separetor"></span>
            <div class="post-author">
                <span class="xs-round-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 55 );?>
                </span>
                <span class="author-name">
                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><?php echo get_the_author(); ?></a>
                </span>
            </div>
        </div>
    </div>
</div>