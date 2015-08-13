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


}

$plugin = new Plugin();

?>
