<select name="'.$field['id'].'" id="'.$field['id'].'">
<option value=""> Auswählen </option>
<?php 
  $terms = get_terms($field['id'], 'get=all');
  $selected = wp_get_object_terms($post->ID, $field['id']);
  foreach ($terms as $term) {
    if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug)) 
?>
  <option value="<?= $term->slug ?>" selected="selected"><?= $term->name ?></option>
<?php else ?>
  <option value="<?= $term->slug ?>"><?= $term->name ?></option> 
<?php }
  $taxonomy = get_taxonomy($field['id']);
?>
</select><br>
<span class="description"><a href="<?= get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id']?>">
Manage <?= $taxonomy->label ?></a></span>