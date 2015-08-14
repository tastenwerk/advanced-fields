<?php  $items = get_posts( array (
  'post_type' => $field['post_type'],
  'posts_per_page' => -1
)); ?>
<select name="<?= $field['id'] ?>" id="<?= $field['id'] ?>">
  <option value=""> Auswählen </option>
<?php foreach($items as $item) { ?>
  <option value="<?= $item->ID ?>" <?= $meta == $item->ID ? 'selected="selected"' : '' ?> >
    <?= localize( $item->post_title ) ?>
  </option>
<?php } ?>
</select><br/>
<span class="description"><?= $field['desc'] ?></span>