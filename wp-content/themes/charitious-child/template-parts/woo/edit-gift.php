<?php
// Check if the product_id variable is set in the $args array
if ( isset( $args['product_id'] ) ) {
    // Retrieve the product ID
    $product_id = $args['product_id'];
} else {
    $product_id = "";
}

$product = wc_get_product( $product_id );

if ( $product ) :
    $productName = !empty($product->get_name()) ? $product->get_name() : "";
    $currentPrice = !empty($product->get_price()) ? $product->get_price() : ""; ?>
    <div class="modal fade" id="editProductModal-<?php echo $product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel-<?php echo $product_id; ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel-<?php echo $product_id; ?>">Edit Gift Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="alertMessage-<?php echo $product_id; ?>" class="alert" role="alert" style="display: none;"></div>
                    <form id="update-product-form-<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
                        <?php wp_nonce_field( 'edit_gift_item', 'edit_gift_nonce' ); ?>  
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                        <div class="mb-3">
                            <?php $gift_details = get_option('charitious_gift_details', array()); ?>
                            <label for="gift_name" class="form-label">Gift Name:</label>
                            <select for="gift_name" name="gift_name" class="form-label" id="edit-product-name-<?php echo $product_id; ?>" required disabled>
                                <option value="">Select Gift:</option>
                            <?php
                            if (!empty($gift_details)) {
                                foreach ($gift_details as $detail) {
                                    $selected = ($detail == $productName ) ? "selected" : "";
                                ?>
                                    <option class="form-control" value="<?php echo esc_attr($detail); ?>" <?php echo $selected; ?>><?php echo esc_html( $detail ); ?></option>
                                    <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-product-price-<?php echo $product_id; ?>" class="form-label">Price:</label>
                            <input type="number" class="form-control" id="edit-product-price-<?php echo $product_id; ?>" name="gift_price" step="0.01" min="1" max="100000" value="<?php echo $currentPrice; ?>" required>
                        </div>
                            <?php 
                                // Check if a product image exists.
                                $giftImage = get_post_meta( $product_id, '_thumbnail_id', true );
                                if ( $giftImage ) : ?>
                                <div class="mb-3">
                                    <a href="<?php echo esc_url( get_the_post_thumbnail_url( $product_id, '' ) ); ?>" target="_blank"><img src="<?php echo esc_url( get_the_post_thumbnail_url( $product_id, '' ) ); ?>" alt="<?php echo $productName; ?>" width="150" height="100" /></a>
                                </div>
                            <?php endif; ?>
                        <div class="mb-3">
                            <label for="edit-product-image-<?php echo $product_id; ?>" class="form-label">Image:</label>
                            <input type="file" class="form-control" id="edit-product-image-<?php echo $product_id; ?>" name="gift_image" accept="image/*">
                            <span>[Note: Please make sure that the attached image does not contain any form of nudity.]</span>
                        </div>    
                        <button type="button" class="btn btn-primary submit-edit-form" data-product-id="<?php echo $product_id; ?>">Update Gift</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif;
