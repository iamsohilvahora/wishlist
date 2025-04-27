<div class="modal fade" id="addGiftModal" tabindex="-1" aria-labelledby="addGiftModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGiftModalLabel">Add New Gift</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alertMessage" class="alert" role="alert" style="display: none;"></div>
                <form id="addGiftForm" method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field( 'add_gift_item', 'add_gift_nonce' ); ?>
                    <div class="mb-3">
                        <?php $gift_details = get_option('charitious_gift_details', array()); ?>
                        <label for="gift_name" class="form-label">Gift Name:</label>
                        <select for="giftName" class="form-label" id="giftName" name="gift_name" required>
                            <option value="">Select Gift:</option>
                        <?php
                        if (!empty($gift_details)) {
                            foreach ($gift_details as $detail) { ?>
                                <option class="form-control" value="<?php echo esc_attr($detail); ?>"><?php echo esc_html( $detail ); ?></option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="giftPrice" class="form-label">Price:</label>
                        <input type="number" class="form-control" id="giftPrice" name="gift_price" step="0.01" min="1" max="100000" required>
                    </div>
                    <div class="mb-3">
                        <label for="giftImage" class="form-label">Image:</label>
                        <input type="file" class="form-control" id="giftImage" name="gift_image" accept="image/*" />
                        <span>[Note: Please make sure that the attached image does not contain any form of nudity.]</span>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submitButton">Add Gift</button>
                </form>
            </div>
        </div>
    </div>
</div>
