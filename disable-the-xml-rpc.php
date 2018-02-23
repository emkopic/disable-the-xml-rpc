<?php
/*
Plugin Name: Disable The XML-RPC
Plugin URI: https://github.com/emkopic/disable-the-xml-rpc
Description: This plugin disables XML-RPC API in WordPress which is enabled by default.
Version: 1.0
Author: Emir
Author URI: https://github.com/emkopic
License: GPLv2
*/

add_filter( 'wp_xmlrpc_server_class', 'emko_wp_xmlrpc_server_class' );

function emko_wp_xmlrpc_server_class() {
	return 'emko_wp_xmlrpc_server';
}

require_once(ABSPATH . WPINC . '/class-IXR.php');

class emko_wp_xmlrpc_server extends IXR_Server {

	/**
	 * Register all of the XMLRPC methods that XMLRPC server understands.
	 *
	 * Sets up server and method property. Passes XMLRPC
	 * methods through the 'xmlrpc_methods' filter to allow plugins to extend
	 * or replace XMLRPC methods.
	 *
	 * @since 1.5.0
	 *
	 * @return wp_xmlrpc_server
	 */
	function __construct() {
		$this->methods = array(
			// PingBack
			'pingback.ping' => 'this:pingback_ping',
			'pingback.extensions.getPingbacks' => 'this:pingback_extensions_getPingbacks',

			'demo.sayMyName' => 'this:sayMyName',
			'demo.addWhatsUp' => 'this:addWhatsUp'
		);

		$this->initialise_blog_option_info();
		$this->methods = apply_filters('xmlrpc_methods', $this->methods);
	}

	function serve_request() {
	}
	
	/**
	 * Set up blog options property.
	 *
	 * Passes property through 'xmlrpc_blog_options' filter.
	 *
	 * @since 2.6.0
	 */
	function initialise_blog_option_info() {
		global $wp_version;

		$this->blog_options = array(
		);
	}
}
?>