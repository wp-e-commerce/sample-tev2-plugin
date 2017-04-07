<?php
/**
  * Plugin Name: TEv2 - Test Plugin
  * Plugin URI: http://wpecommerce.org/
  * Description: A plugin that provides a WordPress Shopping Cart. See also: <a href="http://wpecommerce.org" target="_blank">WPeCommerce.org</a> | <a href="https://wordpress.org/support/plugin/wp-e-commerce/" target="_blank">Support Forum</a> | <a href="http://docs.wpecommerce.org/" target="_blank">Documentation</a>
  * Version: 3.9.2
  * Author: WP eCommerce
  * Author URI: http://wpecommerce.org/
  **/

add_action( 'wpsc_ready', 'wpsc_register_wishlist' );

function wpsc_register_wishlist() {
	return WPSC_Wishlist::get_instance();
}

class WPSC_Wishlist {
	private static $instance;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new WPSC_Wishlist();
			self::$instance->init();
		}

		return self::$instance;
	}

	public static function init() {

		//Step 1: Register custom template path.
		self::$instance->register_template_path();

		//Step 2: Register customer account tab.
		self::$instance->register_customer_account_tab();

		//Step 3: Filter controller path.
		self::$instance->filter_controller_path();

		//Step 4: Filter controller class.
		self::$instance->filter_controller_class();

	}

	private function register_template_path() {

		WPSC_Template_Engine::get_instance()->register_template_part_path( plugin_dir_path( __FILE__ ) . '/template-parts', 20 );
	}

	private function register_customer_account_tab() {
		add_filter( 'wpsc_customer_account_tabs', function( $tabs ) {
			$tabs['wishlist'] = 'Wishlist';

			return $tabs;
		} );
	}

	private function filter_controller_path() {
		add_filter( 'wpsc_load_controller_path_wishlist', function( $path, $controller, $class ) {

			// Checks to ensure we're on the customer-account controller.
			if ( 'customer-account' == $controller ) {
				$path = plugin_dir_path( __FILE__ ) . 'controllers/wishlist.php';
			}

			return $path;
		}, 10, 3 );
	}

	private function filter_controller_class() {
		add_filter( 'wpsc_load_controller_class_wishlist', function( $class, $controller ) {

			return $controller == 'customer-account' ? 'WPSC_Controller_Wishlist' : $class;
		}, 10, 2 );
	}
}
