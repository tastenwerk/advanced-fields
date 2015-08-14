<?php

  class CustomMetaBox
  {
    public function __construct() {
      $this->init_array();
      add_action('admin_init', array($this, 'my_meta_init'));
      add_action('save_post', array( $this, 'save_custom_meta') );
      // add_action('admin_head', array( $this, 'add_custom_scripts') );
    }

    public $fields_array = array();
    public $points;

    public $template = '';
    public $templatedir = '';
    public $boxname = 'boxname';

    public $post_type = 'page';
    public $context = 'normal';
    public function init_array(){}

    public function my_meta_init()
    {
      $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

      $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);

      if ( $this->template == '' || $template_file == $this->templatedir.$this->template.'.php')
      {
          add_meta_box('myplugin_sectionid',
            __( $this->boxname, 'myplugin_textdomain' ),
            array($this,'show_custom_meta_box'), $this->post_type, $this->context, 'high');
      }
    }

    public function show_custom_meta_box($array) {
      global $post;

      echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
      echo '<table class="form-table">';

      foreach ($this->fields_array as $field) {

        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr><th><label for="'.$field['id'].'">'.$field['label'].'</label></th><td>';
        // remove last character due to include
        if( file_exists ( dirname( __FILE__).'/views/'.$field['type'].'.php' ) )
          echo substr( require( dirname( __FILE__)."/views/".$field['type'].'.php' ), 0, -3);
        elseif( file_exists ( get_template_directory()."/advanced-fields/views/".$field['type'].'.php' ) )
          echo substr( require( get_template_directory()."/advanced-fields/views/".$field['type'].'.php' ), 0, -3);
        echo '</td></tr>';
      }
      echo '</table>';
    }

    public function save_custom_meta($post_id) {

      // verify nonce
      if ( !isset( $_POST['custom_meta_box_nonce'] )  || !wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
        return $post_id;
      // check autosave
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
      // check permissions
      if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
          return $post_id;
      } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
      }

      foreach ($this->fields_array as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
          update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
          delete_post_meta($post_id, $field['id'], $old);
        }
      } 
    }

  }
?>
