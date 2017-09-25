<?php
/**
 * Plugin Name:    Page Builder Type
 * Plugin URI:     https://github.com/campuspress/page-builder-type
 * Description:    Adds an admin column that identifies the type of page builder currently active on a page or post.
 * Version:        1.0
 * Author:         Joseph Fusco
 * Author URI:     https://josephfus.co
 * License:        GPLv2 or later
 * License URI:    http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:    idbbu
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Page_Builder_Type {

	function __construct() {
		$this->load_page_builder_type_column();
	}

	function can_load_column() {
		if ( function_exists( 'et_pb_is_pagebuilder_used' ) && current_user_can( 'activate_plugins' ) ) {
			return true;
		}
	}

	function load_page_builder_type_column() {
		add_filter( 'manage_posts_columns', array( $this, 'column_head' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'column_content' ), 10, 2 );
		add_filter( 'manage_pages_columns', array( $this, 'column_head' ) );
		add_action( 'manage_pages_custom_column', array( $this, 'column_content' ), 10, 2 );
	}

	function column_head( $defaults ) {
		if ( ! $this->can_load_column() ) {
			return $defaults;
		}

		$defaults['page_builder_type'] = 'Page Builder Type';

		return $defaults;
	}

	function column_content( $column, $post_id ) {
		if ( ! $this->can_load_column() ) {
			return;
		}

		if ( 'page_builder_type' == $column ){
			$is_divi_used = et_pb_is_pagebuilder_used( $post_id );

			if ( $is_divi_used ) {
				echo '<span style="border-radius:3px;background-color:#9834EF;color:#FFF;padding:3px 7px;">Divi Builder</span>';
			} else {
				echo 'Default Editor';
			}
		}
	}

}

$page_builder_type = new Page_Builder_Type();
