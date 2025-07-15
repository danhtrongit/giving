/**
 * JavaScript for handling taxonomy media uploads
 */
(function($) {
    'use strict';

    // Media uploader
    $(document).ready(function() {
        var mediaUploader;

        // Handle the add image button
        $('.taxonomy_media_button').click(function(e) {
            e.preventDefault();

            // If the uploader object has already been created, reopen the dialog
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            // Create the media uploader
            mediaUploader = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Use This Image'
                },
                multiple: false
            });

            // When an image is selected, run a callback
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#category-image-id').val(attachment.id);
                $('#category-image-wrapper').html('<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>');
            });

            // Open the uploader dialog
            mediaUploader.open();
        });

        // Handle the remove image button
        $('.taxonomy_media_remove').click(function(e) {
            e.preventDefault();
            $('#category-image-id').val('');
            $('#category-image-wrapper').html('');
        });
    });
})(jQuery); 