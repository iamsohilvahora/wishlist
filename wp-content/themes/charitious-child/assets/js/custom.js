jQuery(document).ready(function($) {
    // Handle add Gift form submission using AJAX
    $('#addGiftForm').submit(function(e) {
        e.preventDefault();
        let ajaxUrl = gift_object.ajax_url;

        let formData = new FormData(this);
        formData.append('action', 'add_gift_item_ajax');

        // Validate image file size and extension
        let inputFile = $('#giftImage')[0].files[0];
        if(inputFile){
            let fileSize = inputFile.size; // Size in bytes
            let fileExtension = inputFile.name.split('.').pop().toLowerCase(); // Get file extension

            // Check if file extension is not an image
            if (!['jpg', 'jpeg', 'png', 'webp'].includes(fileExtension)) {
                $('#alertMessage').removeClass('alert-success').addClass('alert-danger').html('Only image files (jpg, jpeg, png, webp) are allowed.').show();
                return; // Exit function
            }

            // Check if file size exceeds 5000KB (in bytes)
            if (fileSize > 5000 * 1024) {
                $('#alertMessage').removeClass('alert-success').addClass('alert-danger').html('Maximum image file size allowed is 5MB.').show();
                return; // Exit function
            } 
        }               

        // Disable submit button and change text to "Loading..."
        $('#submitButton').prop('disabled', true); // Disable button
        $('#submitButton').text('Loading...');

        $.ajax({
            url: ajaxUrl,
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success === true) {
                    // Display success message.
                    $('#alertMessage').removeClass('alert-danger').addClass('alert-success').html(response.data).show();
                } else {
                    // Display error message.
                    $('#alertMessage').removeClass('alert-success').addClass('alert-danger').html('Error in adding the wish. Please try again later.').show();
                }
                // reset form and reload after 2 seconds.
                setTimeout(function() {
                    $('#addGiftForm').trigger('reset'); // Reset form fields
                    $('#addGiftModal').modal('hide');  // Hide modal after successful submission
                    location.reload(); // Refresh the current page
                }, 2000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Display error message.
                $('#alertMessage').removeClass('alert-success').addClass('alert-danger').html('There was an error to add the gift list item.').show();
                setTimeout(function() {
                    $('#addGiftForm').trigger('reset'); // Reset form fields
                    $('#addGiftModal').modal('hide');  // Hide modal after successful submission
                    location.reload(); // Refresh the current page
                }, 2000);
            }
        });
    });

    // Handle edit gift form submission using AJAX
    $(document).on('click', '.submit-edit-form', function(e) {
        e.preventDefault();
        
        let $button = $(this);
        let productId = $button.data('product-id');

        let formId = $('#update-product-form-' + productId);
        if (!$(formId).find('select[name="gift_name"]').val() || !$(formId).find('input[name="gift_price"]').val()) {
            $('#alertMessage-' + productId).removeClass('alert-success').addClass('alert-danger').html('Please fill required fields.').show();
            return; // Exit function
        }

        let ajaxUrl = gift_object.ajax_url;
        let editForm = $('#update-product-form-' + productId)[0]; // Get the raw form element.
        let formData = new FormData(editForm);
        formData.append('action', 'edit_gift_item_ajax');

        // Validate image file size and extension.
        let inputFile = $('#edit-product-image-' + productId)[0].files[0];
        if(inputFile){
            let fileSize = inputFile.size; // Size in bytes.
            let fileExtension = inputFile.name.split('.').pop().toLowerCase(); // Get file extension.

            // Check if file extension is not an image.
            if (!['jpg', 'jpeg', 'png', 'webp'].includes(fileExtension)) {
                $('#alertMessage-' + productId).removeClass('alert-success').addClass('alert-danger').html('Only image files (jpg, jpeg, png, webp) are allowed.').show();
                return; // Exit function
            }

            // Check if file size exceeds 5000KB (in bytes)
            if (fileSize > 5000 * 1024) {
                $('#alertMessage-' + productId).removeClass('alert-success').addClass('alert-danger').html('Maximum image file size allowed is 5MB.').show();
                return; // Exit function
            } 
        }

        // Disable update button and change text to "Loading..."
        $button.prop('disabled', true); // Disable button
        $button.text('Loading...');

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success === true){
                    // Display success message.
                    $('#alertMessage-' + productId).removeClass('alert-danger').addClass('alert-success').html(response.data).show();
                } else {
                    // Display error message.
                    $('#alertMessage-' + productId).removeClass('alert-success').addClass('alert-danger').html('Error in adding the wish. Please try again later.').show();
                }
                // reset form and reload after 2 seconds.
                setTimeout(function() {
                    $('#editProductModal-' + productId).modal('hide'); // Hide modal after successful submission
                    location.reload(); // Refresh the current page
                }, 2000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Display error message.
                $('#alertMessage-' + productId).removeClass('alert-success').addClass('alert-danger').html('There was an error to update the gift list item.').show();
                // reset form and reload after 2 seconds.
                setTimeout(function() {
                    $('#editProductModal-' + productId).modal('hide'); // Hide modal after successful submission
                    location.reload(); // Refresh the current page
                }, 2000);
            }
        });
    });

    // Handle delete gift item.
    $( '.delete-product-btn' ).click(function(e) {
        e.preventDefault(); // Prevent default form submission

        let $button = $(this);
        let productId = $button.data( 'product-id' );

        let deleteForm = $('#delete-product-form-' + productId)[0]; // Get the raw form element
        let formData = new FormData(deleteForm);
        formData.append( 'action', 'delete_gift_item' );

        if ( confirm( 'Are you sure you want to delete this Gift?' ) ) {
            let ajaxUrl = gift_object.ajax_url;

            $.ajax({
                url: ajaxUrl,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function( response ) {
                    if(response.success === true){
                        location.reload(); // Refresh the current page
                    } else {
                        alert('Error in deleting the gift item'); // Error message
                    }
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    alert('There is an error to delete the gift list item.'); // Error message
                }
            });
        }
    });

    // Giftlist url name search functionality.
    $('#giftlist_url').on('input', function() {
       var urlName = $(this).val();
       var statusMessage = $(this).closest('.woocommerce-input-wrapper').find('.status-message');

       // Display "checking" message
       statusMessage.text('Checking...');

       let ajaxUrl = gift_object.ajax_url;

       // AJAX call to check if the URL name exists
       $.ajax({
           url: ajaxUrl,
           type: 'POST',
           data: {
               action: 'check_giftlist_url',
               giftlist_url: urlName
           },
           success: function(response) {
               // Handle response from server
               if (response.success) {
                   statusMessage.text(response.data);
               } else {
                   statusMessage.text(response.data);
               }
           },
           error: function(error) {
               // Display error message.
               statusMessage.text('There is an error. Please try again later.');
           }
       });
    });

    // Leaderboard - creator search functionality.
    var searchBox = $('#searchBox');

    searchBox.on('input', function() {
        let searchQuery = $(this).val().trim();
        let page = 1;
        let currentPeriod;
        if($("#monthlyBtn").hasClass('active')) {
            currentPeriod = $("#monthlyBtn").text().toLowerCase();
        } else if($("#weeklyBtn").hasClass('active')) {
            currentPeriod = $("#weeklyBtn").text().toLowerCase();
        } else if($("#dailyBtn").hasClass('active')) {
            currentPeriod = $("#dailyBtn").text().toLowerCase();
        } else {
            currentPeriod = "";
        }
        if (searchQuery !== '') {
            loadUsers(page, searchQuery, currentPeriod);
        } else {
            loadUsers(page, searchQuery, currentPeriod);
        }
    });

    // Function to load creators via AJAX
    function loadUsers(page, searchQuery, currentPeriod) {
        let ajaxUrl = gift_object.ajax_url;
        var data = {
            'action': 'load_more_creators',
            'page': page,
            'search_query': searchQuery,
            'period': currentPeriod
        };

        // Show spinner
        $('#spinner').removeClass('d-none');
        
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: data,
            success: function(response) {
                $('#latest-user').html(response.latest_users); // Update latest user list
                $('#userList').html(response.users); // Update user list
                $('.pagination').html(response.pagination); // Update pagination links
                // Hide spinner
                $('#spinner').addClass('d-none');
            }
        });
    }

    // Load creator via pagination.
    $('.pagination').on('click', '.creator-page', function(e) {
        e.preventDefault();
        let currentPeriod;
        currentPage = $(this).data('page');
        let searchQuery = searchBox.val().trim();
        if($("#monthlyBtn").hasClass('active')) {
            currentPeriod = $("#monthlyBtn").text().toLowerCase();
        } else if($("#weeklyBtn").hasClass('active')) {
            currentPeriod = $("#weeklyBtn").text().toLowerCase();
        } else if($("#dailyBtn").hasClass('active')) {
            currentPeriod = $("#dailyBtn").text().toLowerCase();
        } else {
            currentPeriod = "";
        }
        loadUsers(currentPage, searchQuery, currentPeriod); // Load users for the selected page
    });

    // Function to handle button clicks for creator via monthly, weekly, daily.
    $('#monthlyBtn, #weeklyBtn, #dailyBtn').on('click', function() {
        let page = 1;
        let searchQuery = searchBox.val().trim();
        $('#monthlyBtn, #weeklyBtn, #dailyBtn').removeClass('active');
        $(this).addClass('active');
        let currentPeriod = $(this).text().toLowerCase(); // Get the selected period.
        loadUsers(page, searchQuery, currentPeriod); // Load users for the selected period.
    });

    // Handle sort selection change
    $('.product-sort').on('change', function() {
        var selectedSort = $(this).val();
        var authorId = $(this).data('author');
        let ajaxUrl = gift_object.ajax_url;

        // Send AJAX request to update products based on selected sort
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'update_product_list',
                sort: selectedSort,
                author_id: authorId
            },
            success: function(response) {
                $('div.product-list').html(response.data); // Update product container with new content
            }
        });
    });

    // Function to copy product link to clipboard
    function copyProductLink(productId, element) {
        var productUrl = window.location.href.split('?')[0] + '?item=' + productId;
        var tempInput = document.createElement('input');
        tempInput.value = productUrl;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        element.textContent = 'Copied';
    }

    // Handle Copy Link icon hover and click events
    $(document).on('mouseenter', '.copy-link-btn', function() {
        $(this).html('<span>Copy link</span>');
    }).on('mouseleave', '.copy-link-btn', function() {
        $(this).html('');
    });

    $(document).on('click', '.copy-link-btn', function() {
        var productId = $(this).data('product-id');
        var element = this;
        copyProductLink(productId, element);
    });

    // Check if the URL contains the item parameter
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('item');
    if (productId) {
        // Product ID exists in the URL, trigger the modal
        openProductModal(productId);
    }

    // Function to open modal with product details
    function openProductModal(productId) {
        let ajaxUrl = gift_object.ajax_url;
        // AJAX call to fetch product details
        if (!isNaN(productId)) {
            $.ajax({
                url: ajaxUrl, // Adjust this URL according to your setup
                type: 'POST',
                data: {
                    action: 'get_product_details', // AJAX action to fetch product details
                    product_id: productId
                },
                success: function(response) {
                    // Populate modal with product details
                    $('#product-details-modal .modal-content').html(response.data);
                    // Open the modal
                    $('#product-details-modal').modal('show');
                }
            });
        }
    }

    // Event listener for modal close event
    $('#product-details-modal').on('hidden.bs.modal', function () {
        removeProductIdFromURL();
    });

    // Function to remove product_id parameter from URL
    function removeProductIdFromURL() {
        if (history.replaceState) {
            const url = window.location.href;
            const newUrl = url.split('?')[0]; // Remove query parameters
            history.replaceState({}, document.title, newUrl);
        }
    }

    // Event listener for "Add To Cart And Keep Shopping" button click
    $(document).on('click', '.add-to-cart-keep-shopping-btn', function() {
        let productId = $(this).data('product-id');
        addToCartAndKeepShopping(productId);
    });

    // Event listener for "Add To Cart And Checkout" button click
    $(document).on('click', '.add-to-cart-checkout-btn', function() {
        let productId = $(this).data('product-id');
        addToCartAndCheckout(productId);
    });

    // Function to add product to cart and keep shopping
    function addToCartAndKeepShopping(productId) {
        let ajaxUrl = gift_object.ajax_url;
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'add_product_to_cart',
                product_id: productId
            },
            success: function(response) {
                if(response.success) {
                    // Update cart count in the navigation menu
                    $('.nav-cart .cart-count').text(response.data.cart_count);
                } else {
                    alert(response.data.message);
                }
                $('#product-details-modal-' + productId).modal('hide');
                $('#product-details-modal').modal('hide');
            },
            error: function(xhr, status, error) {
                // Handle errors
                alert('Error adding product to cart!');
            }
        });
    }

    // Function to add product to cart and redirect to checkout
    function addToCartAndCheckout(productId) {
        let ajaxUrl = gift_object.ajax_url;
        let siteUrl = gift_object.site_url;
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'add_product_to_cart',
                product_id: productId
            },
            success: function(response) {
                if(response.success) {
                    // Redirect to checkout page
                    window.location.href = siteUrl + '/cart';
                } else {
                    alert(response.data.message);
                    $('#product-details-modal-' + productId).modal('hide');
                    $('#product-details-modal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                alert('Error adding product to cart!');
            }
        });
    }

    // Set min, max attribute for password fields on checkout page.
    jQuery(document).ready(function($) {
        // Set min and max length for password field
        $('#account_password').attr('minlength', '8'); // Minimum password length
        $('#account_password').attr('maxlength', '12'); // Maximum password length
    });

    // Function to handle button clicks for sort the order data.
    $('#day-filter, #week-filter, #month-filter, #year-filter').on('click', function() {
        $('#day-filter, #week-filter, #month-filter, #year-filter').removeClass('active');
        jQuery(this).addClass('active');
        let range = jQuery(this).text();
        filterOrders(range);
    });

    // Function to load order data via AJAX
    function filterOrders(range) {
        let ajaxUrl = gift_object.ajax_url;
        let data = {
            'action': 'filter_orders',
            'range': range
        };

        // Show spinner
        $('#spinner').removeClass('d-none');
        
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: data,
            success: function(response) {
                // Display orders in response
                $('#order-table-container').html(response.order_data); // Update latest user list
                // Hide spinner
                $('#spinner').addClass('d-none');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Trigger to update cart-count on cart page
    jQuery(document.body).on('removed_from_cart updated_cart_totals wc_cart_emptied', function() {
        let ajaxUrl = gift_object.ajax_url;
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'get_cart_count'
            },
            success: function(response) {
                if (response.success) {
                    $('.nav-cart .cart-count').text(response.data.cart_count);
                }
            }
        });
    });

    // Creator/gifter profile image delete call
    $('.profile-image-delete').click(function(e) {
        e.preventDefault(); // Prevent default link behavior

        // Confirmation message
        if (confirm('Are you sure you want to delete your profile image?')) {
            let ajaxUrl = gift_object.ajax_url;
            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action: 'profile_image_delete'
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the image container and link
                        $("#profile-image-container").remove();
                    } else {
                        alert(response.data.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    alert('An error occurred. Please try again later.');
                }
            });
        }
    });

    // Creator stripe account
    jQuery(document).ready(function($) {
        // Handle next button click
        $('#accountSetupForm').on('submit', function() {
            // Get the selected value
            let selectedValue = $('input[name="nsfw_creator"]:checked').val();

            if (selectedValue) {
                localStorage.setItem('nsfw_creator', selectedValue);
            }

            // Update modal title and content
            $('#accountSetupLabel').text('Start Stripe Setup');
            $('#modal-body-content').html('<p><i class="fa-solid fa-circle-exclamation"></i>The following rules are required by our payment processors to prevent a rejection of your account.</p><h4>Prohibited Activity</h4><p><i class="fa-solid fa-close" style="color:red;"></i> Selling services or goods.</p><p><i class="fa-solid fa-close" style="color:red;"></i> Gifts promising services or goods in exchange.</p><p><i class="fa-solid fa-close" style="color:red;"></i> Items with nudity in the image.</p><p><i class="fa-solid fa-close" style="color:red;"></i> Alcohol, Tobacco, & items containing THC.</p><p><i class="fa-solid fa-close" style="color:red;"></i> Adult Toys.</p><p><i class="fa-solid fa-close" style="color:red;"></i> Gifts including descriptions like – Tax, Fee, Session, Deposit, Unblock & Tribute.</p><div class="form-group"><input class="form-check-input confirmation-checkbox" type="checkbox" value="" id="confirmation_checkbox"><label class="form-check-label" for="confirmation_checkbox">I hereby confirm that none of these items are listed.</label></div><button type="button" class="btn btn-primary next-button2" disabled>Next <i class="fa-solid fa-arrow-right"></i></button>');
        });
    });

    // Toggle next button based on checkbox state
    $(document).on('change', '.confirmation-checkbox', function() {
        $('.next-button2').prop('disabled', !$(this).is(':checked'));
    });

    // Handle next button2 click
    $(document).on('click', '.next-button2', function() {
        // Update modal title and content
        $('#accountSetupLabel').text('Withdrawal account');
        $('#modal-body-content').html('<div><h4>Setting up your withdrawal account</h4><p><i class="fa-solid fa-circle-exclamation"></i>Please carefully read this information.</p><p>When filling in your details with our payment processor Stripe, we recommend that you don\'t enter your business or social media page directly.</div><button type="button" class="btn btn-primary finish-button">Continue to Stripe <i class="fa-solid fa-arrow-right"></i></button>');

        // Enable the button for next steps
        $(this).prop('disabled', true);
    });

    // Handle finish button click
    $(document).on('click', '.finish-button', function() {
        let selectedValue = localStorage.getItem('nsfw_creator');
        let ajaxUrl = gift_object.ajax_url;
        let siteUrl = gift_object.site_url;

        // Disable button and change text to "Loading..."
        $(this).prop('disabled', true); // Disable button
        $(this).text('Loading...'); // Change text

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'stripe_account_setup',
                selectedValue: selectedValue,
            },
            success: function(response) {
                if (response.success) {
                    // Redirect to checkout page
                    window.location.href = response.data.account_url;
                } else {
                    alert(response.data);
                    location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                alert('An error occurred. Please try again later.');
            }
        });
    });

    // Handle "finish stripe setup" functionality
    $('#finish-stripe-setup').on('click', function(e) {
       e.preventDefault();
       let ajaxUrl = gift_object.ajax_url;
       let siteUrl = gift_object.site_url;

       // Disable button and change text to "Loading..."
       $(this).prop('disabled', true); // Disable button
       $(this).text('Loading...'); // Change text
       
       $.ajax({
           url: ajaxUrl,
           type: 'POST',
           data: {
               action: 'finish_stripe_setup',
           },
           success: function(response) {
               if (response.success) {
                   window.location.href = response.data.url;
               } else {
                   alert(response.data.message);
                   location.reload();
               }
           },
           error: function(jqXHR, textStatus, errorThrown) {
               console.error('AJAX Error:', textStatus, errorThrown);
               alert('An error occurred. Please try again later.');
           }
       });
    });

    // Delete stripe account code
    $('#delete-stripe-account').on('click', function(e) {
        e.preventDefault();
        let ajaxUrl = gift_object.ajax_url;
        let siteUrl = gift_object.site_url;

        // Disable button and change text to "Loading..."
        $(this).prop('disabled', true); // Disable button
        $(this).text('Loading...'); // Change text
       
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: 'delete_stripe_account',
            },
            success: function(response) {
                if (response.success) {
                    alert('Stripe account deleted successfully.');
                    location.reload();
                } else {
                    alert(response.data.message);
                    location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
                alert('An error occurred. Please try again later.');
            }
        });
    });

    // test payment
    $('#payment-button').on('click', function() {
        $.ajax({
            url: gift_object.ajax_url,
            type: 'POST',
            data: {
                action: 'make_payment_to_vendor',
            },
            success: function(response) {
                $('#payment-result').html(response);
            },
            error: function(errorThrown) {
                console.log(errorThrown);
            }
        });
    });

});
