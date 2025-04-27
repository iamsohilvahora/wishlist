jQuery(document).ready(function($) {
    // Add gift detail field
    $('#charitious-add-gift-detail').on('click', function() {
        var lastInput = $('#charitious-gift-details-container .charitious-gift-detail-input').last();
        if (lastInput.length === 0 || lastInput.val().trim() !== '') {
            var container = $('#charitious-gift-details-container');
            var newRow = $('<div class="charitious-gift-detail-row"><input type="text" name="charitious_gift_details[]" value="" class="regular-text charitious-gift-detail-input"><button type="button" class="button charitious-remove-gift-detail">Remove</button></div>');
            container.append(newRow);
        } else {
            alert('Please fill in the input field.');
        }
    });

    // Remove gift detail field
    $(document).on('click', '.charitious-remove-gift-detail', function() {
        var inputVal = $(this).siblings('.charitious-gift-detail-input').val().trim();
        if (inputVal === '') {
            $(this).parent('.charitious-gift-detail-row').remove();
        } else {
            if (confirm('Are you sure you want to remove gifts?')) {
                $(this).parent('.charitious-gift-detail-row').remove();
            }
        }
    });
});
