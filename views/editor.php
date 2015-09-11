 <?php wp_editor( 
    htmlspecialchars_decode( $meta  ), 
    str_replace( "-", "_", $field['id'] ), 
    $settings = array('textarea_name'=> $field['id'], 'textarea_rows'=>$field['rows'] ) 
); ?>
<br><span class="description"><?= $field['desc'] ?></span>
    