<?php
/**
 * content-none.php
 */
?>

<div class="not-found">
    <h1><?php esc_html_e('Nothing found!', 'charitious'); ?></h1>
    <p><?php esc_html_e('It looks like nothing was found here. Maybe try a search?','charitious')?></p>
    <div class="search-forms"> <?php get_search_form(); ?></div>
</div> <!-- end not-found -->