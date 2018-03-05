jQuery(document).ready(function($) {
  // Uploading files
  var file_frame;

  jQuery.fn.upload_about_featured_image = function(button) {
    var button_id = button.attr('id');
    var field_id = button_id.replace('_button', '');

    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery(this).data('uploader_title'),
      button: { text: jQuery(this).data('uploader_button_text'), },
      multiple: false
    });

    // When an image is selected, run a callback.
    file_frame.on('select', function() {
      var attachment = file_frame.state().get('selection').first().toJSON();
      jQuery('#'+field_id).val(attachment.id);
      jQuery('#fg-about-featured-image img').attr('src',attachment.url);
      jQuery('#fg-about-featured-image img').show();
      jQuery('#' + button_id).attr('id', 'remove_about_featured_image_button');
      jQuery('#remove_about_featured_image_button').text('Remove featured image two');
    });

    // Finally, open the modal
    file_frame.open();
  };

  jQuery('#fg-about-featured-image').on('click', '#upload_about_featured_image_button', function(event) {
    event.preventDefault();
    jQuery.fn.upload_about_featured_image(jQuery(this));
  });

  jQuery('#fg-about-featured-image').on('click', '#remove_about_featured_image_button', function(event) {
    event.preventDefault();
    jQuery('#upload_about_featured_image').val('');
    jQuery('#fg-about-featured-image img').attr('src', '');
    jQuery('#fg-about-featured-image img').hide();
    jQuery(this).attr('id', 'upload_about_featured_image_button');
    jQuery('#upload_about_featured_image_button').text('Set featured image two');
  });
});