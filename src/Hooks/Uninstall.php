<?php

namespace Hr\WpSTM\Hooks;

class Uninstall
{

    // uninstallation method
    public static function wpstm_uninstall()
    {
        register_uninstall_hook(WPSTM_PUBLIC_PLUGIN_PATH, 'wpstm_remove_all_tables');
    }

    // uninstall method for uninstall tables
    public function wpstm_remove_all_tables()
    {
        global $wpdb;
        $wpstm_todos_table = $wpdb->prefix . wpstm_todos_table;
        $sql = "DROP TABLE IF EXISTS $wpstm_todos_table";
        $wpdb->query($sql);
        delete_option("wpstm_todos_table_version");
    }
}