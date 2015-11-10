<?php foreach ( $field['options'] as $option ) { ?>
  <input  type="radio" name="<?= $field['id'] ?>" 
          id="<?= $option['value'] ?>" value="<?= $option['value'] ?>" 
          <?= $meta == $option['value'] ? ' checked="checked"' : '' ?> 
  />
  <label for="'.$option['value'].'"><?= $option['label'] ?>'</label><br/>
<?php } ?>