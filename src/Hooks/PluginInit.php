<?php

namespace Hr\WpSTM\Hooks;

use Hr\WpSTM\Router\Router;
use Hr\WpSTM\Model\TodoModel;
use Hr\WpSTM\Shortcode\AddTodo;
use Hr\WpSTM\Shortcode\AllTodo;

class PluginInit {
	protected $loader;
	protected $name;
	protected $version;
	protected $model;

	public function __construct() {
		$this->name    = 'WPSTM';
		$this->version = '1.0';
		$this->loader  = new PluginLoader();
		new PluginAdmin();
		$this->activateMe();
		$this->deactivation();
		$this->wpstm_load_asset();
		new Router( $this->loader );
		$this->model = new TodoModel();
		$this->wpstm_init_shortcode();
	}

	public function wpstm_init_shortcode() {
		new AddTodo();
		new AllTodo();
	}

	public function run() {
		$this->loader->run();
	}

	// activation method
	public function activateMe() {
		register_activation_hook( WPSTM_PUBLIC_PLUGIN_PATH, array( $this, 'wpstm_register_activation_hook' ) );

	}

	// deactivation method
	public function deactivation() {

	}

	// uninstallation method
	public function uninstall() {
		register_uninstall_hook( WPSTM_PUBLIC_PLUGIN_PATH, array( $this, 'wpstm_remove_all_tables' ) );
	}

	// register activation hook
	public function wpstm_register_activation_hook() {
		$this->wpstm_install_required_table();
		$this->uninstall();
	}

	// activation method for install required table
	public function wpstm_install_required_table() {
		global $wpdb;
		global $wpstm_todos_table_version;

		$wpstm_todos_table_version = "1.0";
		$wpstm_todos_table         = $wpdb->prefix . wpstm_todos_table;

		$wpstm_todos_table_sql = "CREATE TABLE IF NOT EXISTS $wpstm_todos_table ( id int(11) NOT NULL AUTO_INCREMENT, todo_name VARCHAR(100) NOT NULL, completed BOOLEAN NOT NULL DEFAULT 0, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,PRIMARY KEY (id) );";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $wpstm_todos_table_sql );
		add_option( 'wpstm_todos_table_version', $wpstm_todos_table_version, '', 'yes' );
	}

	// deactivation method for uninstall tables
	public function wpstm_remove_all_tables() {
		global $wpdb;
		$wpstm_todos_table = $wpdb->prefix . wpstm_todos_table;
		$sql               = "DROP TABLE IF EXISTS $wpstm_todos_table";
		$wpdb->query( $sql );
		delete_option( "wpstm_todos_table_version" );
	}

	// load all assets
	public function wpstm_load_asset() {
		$this->loader->add_action( 'admin_enqueue_scripts', array( $this, 'wpstm_load_admin_script' ) );
		$this->loader->add_action( 'wp_enqueue_scripts', array( $this, 'wpstm_load_public_assets' ) );
	}


	// enqueue public style
	public function wpstm_load_admin_script() {
		wp_enqueue_style( 'wpstm_css', plugin_dir_url( WPSTM_PUBLIC_PLUGIN_PATH ) . 'assets/css/style.css' );

		wp_enqueue_script( 'wpstm_script', plugin_dir_url( WPSTM_PUBLIC_PLUGIN_PATH ) . 'assets/js/main.js', $this->version, [ 'jquery' ], true );
		wp_localize_script( 'wpstm_script', 'ajax_object', array(
			'nonce' => wp_create_nonce( WPSTM_NONCE )
		) );
	}

	public function wpstm_load_public_assets() {

		wp_enqueue_style( 'wpstm_fontawesome', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css' );

		wp_enqueue_script( 'wpstm_sweetalert2', plugin_dir_url( WPSTM_PUBLIC_PLUGIN_PATH ) . 'assets/js/sweetalert2.all.min.js' );

		wp_localize_script( 'wpstm_sweetalert2', 'ajax_object', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( WPSTM_NONCE )
		) );
	}
}
