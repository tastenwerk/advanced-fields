<a class="repeatable-upload-add button" href="#">Neue Datei hinzufügen</a>
<ul id="'.$field['id'].'-repeatable" class="custom_repeatable upload-repeatable">
<?php
  $i = 0;
  if ( !$meta ) 
    $meta = array( array() );
  foreach($meta as $row) { 
?>
  <li class="upload-repeatable">
    <input class="custom_upload_file_button button" type="button" value="Datei hochladen" title="Klicken für upload"/>
    <input class="file-link" name="<?= $field['id'] ?>[<?= $i ?>][title]" id="<?= $field['id'] ?>[<?= $i ?>][title]" 
      value="<?= $row['title'] ?>" type="hidden"/>
    <input class="file-title" name="<?= $field['id'] ?>[<?= $i ?>][href]" id="<?= $field['id'] ?>[<?= $i ?>][href]" 
      value="<?= $row['href'] ?>" type="hidden"/>
    <div class="file-upload-text">
      <a href="<?= $row['href'] ?>"><?= $row['title'] ? $row['title']  : "Keine Datei hochgeladen" ?></a>
      <span class="dashicons dashicons-no-alt remove-upload" title="Datei entfernen"></span>
    </div>
    <br clear="all" />  
  </li>
<?php
    $i++;
  } ?>
</ul>
<span class="description"><?= $field['desc'] ?></span>