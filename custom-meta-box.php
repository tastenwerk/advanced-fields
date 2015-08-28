<?php

  function localize( $string ){
    //  TODO!
    // echo qtrans_use( qtrans_getLanguage(), $string, false );
    // echo split('[:]', $string);
    // echo "HERE";
    return substr( split('\[:', $string)[1], 3);
  }

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
    public $working_dir = '';
    public $boxname = 'boxname';

    public $post_type = 'page';
    public $context = 'normal';

    public $boxes = array();

    public function init_array(){}

    public function my_meta_init()
    {
      $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

      $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);

      if( sizeof( $this->boxes ) > 0 ){
        $index = 0;
        foreach ($this->boxes as $box ) {
          // echo $box->title;
          // echo "TEST";
          // echo $box['title'];
          // print_r( $box );
          // $title = $box['title']."_".$box['context']."_".$index;
          // echo $title;
          // echo $box['content'];
          // print_r( $box['content'] );
          $this->context = $box['context'];
          $this->fields_array = $box['content'];
          echo $box['title']."_".$box['context']."_".$index;
          add_meta_box(
            $box['title']."_".$box['context']."_".$index,
            __( $box['title'], 'lineup'),
            array( $this,'show_custom_meta_box' ), 
            $this->post_type, 
            $box['context'], 
            $box['priority']
          );
        }
      }
      elseif ( $this->template == '' || $template_file == $this->templatedir.$this->template.'.php')
      {
        add_meta_box(
           $this->title.$this->context,
          __( $this->boxname, 'lineup' ),
          array($this,'show_custom_meta_box'), 
          $this->post_type, $this->context, 'high'
        );
      }
    }

    public function show_custom_meta_box() {
      global $post;

      if( sizeof( $this->fields_array) == 0 )
        return;

      $jump_table = $this->context == 'normal' ? false : true;

      if (!$jump_table){
        echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
        echo '<table class="form-table">';
      }

      foreach ($this->fields_array as $field) {
        $meta = get_post_meta($post->ID, $field['id'], true);
        if (!$jump_table) echo '<tr><th>';
        else echo '<div>';
        echo '<label'; 
        if($field['id']) echo ' for="'.$field['id'];
        if($field['type']=='sub') echo ' class="mini-title"';
        echo '">'.$field['label'].'</label>';
        if (!$jump_table) echo '</th><td>';
        if( $field['type'] == 'sub' && !$field['first'] ) echo '<hr>';
        
        if( file_exists ( dirname( __FILE__).'/views/'.$field['type'].'.php' ) )
          echo substr( require( dirname( __FILE__)."/views/".$field['type'].'.php' ), 0, -3);
        elseif ( file_exists ( $this->working_dir.'/views/'.$field['type'].'.php' ) )
          echo substr( require( $this->working_dir."/views/".$field['type'].'.php' ), 0, -3);
        elseif( file_exists ( get_template_directory()."/advanced-fields/views/".$field['type'].'.php' ) )
          echo substr( require( get_template_directory()."/advanced-fields/views/".$field['type'].'.php' ), 0, -3);
        
        if (!$jump_table) echo '</td></tr>';
        else echo '</div>';
      } 
      if (!$jump_table) echo '</table>'; 
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
