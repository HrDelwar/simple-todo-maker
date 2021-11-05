<?php

namespace Hr\WpSTM\Hooks;

class PluginInit
{
    protected $loader;
    protected $name;
    protected $version;

    public function __construct()
    {
        $this->name = 'WPSTM';
        $this->version = '1.0.1';
        $this->loader = new PluginLoader();
        $this->activateMe();
        $this->deactivation();
        $this->wpstm_load_asset();
    }

    public function run()
    {
        $this->loader->run();
    }

    // activation method
    public function activateMe()
    {
        register_activation_hook(PUBLIC_PLUGIN_PATH, array($this, 'wpstm_install_required_table'));
    }

    // deactivation method
    public function deactivation()
    {
        register_deactivation_hook(PUBLIC_PLUGIN_PATH, array($this, 'wpstm_uninstall_all_tables'));
    }

    // activation method for install required table
    public function wpstm_install_required_table()
    {
        global $wpdb;
        global $wpstm_todos_table_version;

        $wpstm_todos_table_version = 1.0;
        $wpstm_todos_table = $wpdb->prefix . wpstm_todos_table;

        $wpstm_todos_table_sql = "CREATE TABLE IF NOT EXISTS $wpstm_todos_table ( id int(11) NOT NULL AUTO_INCREMENT, todo_name VARCHAR(100) NOT NULL, status BOOLEAN NOT NULL DEFAULT 0, PRIMARY KEY (id) );";
        dbDelta($wpstm_todos_table_sql);
        add_option('wpstm_todos_table_version', $wpstm_todos_table_version);
    }

    // deactivation method for uninstall tables
    public function wpstm_uninstall_all_tables()
    {
        global $wpdb;
        $wpstm_todos_table = $wpdb->prefix . wpstm_todos_table;
        $sql = "DROP TABLE IF EXISTS $wpstm_todos_table";
        $wpdb->query($sql);
        delete_option("wpstm_todos_table_version");
    }

    // load all assets
    public function wpstm_load_asset()
    {
        $this->loader->add_action('init', $this, array($this, 'wpstm_load_public_style'));
        $this->loader->add_action('init', $this, array($this, 'wpstm_load_public_script'));
    }

    // enqueue public style
    public function wpstm_load_public_style()
    {
        wp_enqueue_style('wpstm_css' . plugin_dir_url(PUBLIC_PLUGIN_PATH) . 'assets/css/style.css');
    }

    // enqueue public style
    public function wpstm_load_public_script()
    {
        wp_enqueue_script('wpstm_css' . plugin_dir_url(PUBLIC_PLUGIN_PATH) . 'assets/js/main.js');
    }

}
