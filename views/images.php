<a class="repeatable-image-add button" href="#">Neues Bild zur Gallery hinzufügen</a>
<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">
<?php
  $i = 0;
  if ($meta) {
    foreach($meta as $row) {
      if ($row) { $image = wp_get_attachment_image_src($row, 'thumb'); $image = $image[0]; }  
?>
  <li class="image-repeatable">
    <div class="pic-wrapper">
      <span class="pic-background dashicons dashicons-format-image"></span>
      <div class="pic-tools repeatable-remove">
        <span class="dashicons dashicons-star-filled"></span>
        <span class="dashicons dashicons-no-alt"></span>
      </div>
      <span class="custom_default_image" style="display:none"><?= $image ?></span>             
      <input name="<?= $field['id'] ?>[<?= $i ?>]" id="<?= $field['id'] ?>[<?= $i ?>]" 
        type="hidden" class="custom_upload_image" value="<?= $row ?>" />
      <img src="<?= $image ?>" class="custom_preview_image" alt="" /><br />
      <input class="custom_upload_image_button button" type="button" value="Bild wählen" />
      <br clear="all" />  
    </div>          
  </li>
<?php
    $i++;
  }
} else {
?>
  <li class="image-repeatable">
    <div class="pic-wrapper">
      <span class="pic-background dashicons dashicons-format-image"></span>
      <div class="pic-tools repeatable-remove">
        <span class="dashicons dashicons-star-filled"></span>
        <span class="dashicons dashicons-no-alt"></span>
      </div>
      <span class="custom_default_image" style="display:none"><?= $image ?></span>         
      <input name="<?= $field['id'] ?>[0]" id="<?= $field['id'] ?>[0]" 
        type="hidden" class="custom_upload_image" value="" />
      <img src="<?= $image ?>" class="custom_preview_image" alt="" /><br />
      <input class="custom_upload_image_button button" type="button" value="Bild wählen" />
      <br clear="all" />         
    </div>
  </li>
<?php } ?>
</ul>
<span class="description"><?= $field['desc'] ?></span>