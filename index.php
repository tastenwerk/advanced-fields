<?php
/**
 * @package AdvancedFields
 * @version 1.0
 */
/*
Plugin Name: AdvancedFields
Plugin URI: http://wordpress.org/plugins/advanced-fields/
Description: Advanced fields manager for developers
Author: TZ, DR (TASTENWERK)
Version: 1.0
Author URI: http://tastenwerk.com
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

include 'custom-meta-box.php';  

class Plugin{

  public $dirname = 'advanced-fields';
  public $namespace = '';

  function __construct() {
    $this->init_boxes();    
    add_action( 'init', array( $this, 'add_js_and_css_files' ) );
  }

  public function init_boxes(){
    $boxdir = get_template_directory()."/".$this->dirname."/boxes";
    $files = scandir( $boxdir );
    foreach ( $files as $file ) {
      if( preg_match( "/.php$/", $file) ){
        include( $boxdir."/".$file);
        // Make filename to classname with namespace and creates class
        $name = str_replace(' ','',ucwords(str_replace('-',' ',$file)));
        $classname = $this->namespace.ucfirst ( str_replace( '.php', '', $name ) );
        new $classname();
      }
    }
  }


  public function add_js_and_css_files(){
    if(is_admin()) { 
      // GET PLUGIN DIRS
      if ( ! function_exists( 'get_plugins' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
      }
      $dirs = array();
      $plugins = get_plugins();
      foreach ($plugins as $key => $value ) {
        array_push( $dirs, array(
          "url"   => plugin_dir_url( $key ),
          "path"  => WP_PLUGIN_DIR."/".plugin_dir_path( $key )
        ) );
      }
      // GET TEMPLATE DIR
      array_push( $dirs, array(
        "url"   => get_template_directory_uri(),
        "path"  => get_template_directory()
      ) );

      $this->add_css_files( $dirs );      
      $this->add_js_files( $dirs );

    }
  }

  function add_css_files( $dirs ){
    foreach ($dirs as $dir ) {
      if( strpos($dir['path'], $this->dirname ) )
        $css_dir = $dir['path']."css";
      else
        $css_dir = $dir['path'].$this->dirname."/css";
      if( file_exists( $css_dir ) ) 
        foreach ( scandir( $css_dir ) as $file ) {
          if( preg_match( "/.css$/", $file) ){
            wp_enqueue_style( str_replace( '.css', '', $file  ), $dir['url']."css/".$file );
          }
        }
    }
  }

  function add_js_files( $dirs ){
    foreach ($dirs as $dir ) {
      if( strpos($dir['path'], $this->dirname ) )
        $css_dir = $dir['path']."js";
      else
        $css_dir = $dir['path'].$this->dirname."/js";
      if( file_exists( $css_dir ) ) 
        foreach ( scandir( $css_dir ) as $file ) {
          if( preg_match( "/.js$/", $file) ){
            wp_enqueue_script( str_replace( '.js', '', $file  ), $dir['url']."js/".$file );
          }
        }
    }
  }

}

$plugin = new Plugin();

?>
