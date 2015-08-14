<?php 
  $image = get_template_directory_uri().'/images/image.png';
?> 
<span class="custom_default_image" style="display:none"><?= $image ?></span>
<?php if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0]; } ?>              
<input name="<?= $field['id'] ?>" type="hidden" class="custom_upload_image" value="<?= $meta ?>" />
<img src="<?= $image ?>" class="custom_preview_image" alt="" /><br />
<input class="custom_upload_image_button button" type="button" value="Choose Image" />
<small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>
<br clear="all" /><span class="description"><?= $field['desc'] ?></span>';
    