jQuery(document).ready(function ($) {
    // Handle the Reference link click
    $('body').on('click', '.acf-reference-link', function (e) {
        e.preventDefault();

        // Get the image URL from the data attribute
        var imageUrl = $(this).data('image');

        // Create the modal if it doesn't exist
        if ($('#acf-reference-modal').length === 0) {
            $('body').append(`
                <div id="acf-reference-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); display: flex; align-items: center; justify-content: center; z-index: 9999; visibility: hidden;">
                    <div style="position: relative; max-width: 90%; max-height: 90%;">
                        <img id="acf-reference-image" src="" alt="Reference" style="max-width: 100%; max-height: 100%; display: block;">
                        <button id="acf-reference-close" style="position: absolute; top: 10px; right: 10px; background: #fff; border: none; padding: 5px 10px; cursor: pointer; font-size: 16px;">Close</button>
                    </div>
                </div>
            `);
        }

        // Set the image source and show the modal
        $('#acf-reference-image').attr('src', imageUrl);
        $('#acf-reference-modal').css('visibility', 'visible');
    });

    // Close the modal
    $('body').on('click', '#acf-reference-close', function () {
        $('#acf-reference-modal').css('visibility', 'hidden');
    });
});