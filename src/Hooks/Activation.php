<?php

namespace Hr\WpSTM\Hooks;

class Activation
{
    protected $admin_action;

    public function __construct()
    {
        $this->admin_action = new PluginAdmin();
        $this->activate();
    }

    // activation method
    public function activate()
    {
        register_activation_hook(WPSTM_PUBLIC_PLUGIN_PATH, array($this, 'wpstm_register_activation_hook'));
        $this->admin_action->wpstm_register_admin_menu();
    }

    // register activation hook
    public function wpstm_register_activation_hook()
    {
        $this->wpstm_install_required_table();
    }

    // activation method for install required table
    public function wpstm_install_required_table()
    {
        global $wpdb;
        global $wpstm_todos_table_version;

        $wpstm_todos_table_version = "1.0";
        $wpstm_todos_table = $wpdb->prefix . wpstm_todos_table;

        $wpstm_todos_table_sql = "CREATE TABLE IF NOT EXISTS $wpstm_todos_table ( id int(11) NOT NULL AUTO_INCREMENT, todo_name VARCHAR(100) NOT NULL, completed BOOLEAN NOT NULL DEFAULT 0, created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,PRIMARY KEY (id) );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($wpstm_todos_table_sql);
        add_option('wpstm_todos_table_version', $wpstm_todos_table_version, '', 'yes');
    }


}