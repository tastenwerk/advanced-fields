<input class="custom_upload_file_button button" type="button" value="Datei hochladen"/>
<input class="file-link" name="<?= $field['id'] ?>[title]" id="<?= $field['id'] ?>[title]" value="<?= $meta['title'] ?>" type="hidden"/>
<input class="file-title" name="<?= $field['id'] ?>[href]" id="<?= $field['id'] ?>[href]" value="<?= $meta['href'] ?>" type="hidden"/>
<div class="file-upload-text">
  <a href="<?= $meta['href'] ?>"><?= $meta['title'] ?></a>
</div>