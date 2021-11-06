<?php

namespace Hr\WpSTM\Hooks;

use Hr\WpSTM\Views\Admin;

class PluginAdmin
{

    protected $admin_vue;

    public function __construct()
    {
        $this->wpstm_register_admin_menu();
        $this->admin_vue = new Admin();
    }


//  admin menu setup
    public function wpstm_admin_menu()
    {
        add_menu_page(
            'Todo Maker',
            'Todo Manager',
            'manage_options',
            'todos',
            array(&$this, 'load_view'),
            'dashicons-editor-ul',
            65
        );
        add_submenu_page(
            'todos',
            'Todos',
            'Todos',
            'manage_options',
            'todos',
            array(&$this, 'load_view')
        );
        add_submenu_page(
            'todos',
            'Add Todo',
            'Add Todo',
            'manage_options',
            'todos#/add-todo',
            array(&$this, 'load_view')
        );

    }

    public function load_view()
    {
        $this->admin_vue->wpstm_vue_rander();
    }

    // register admin menu
    public function wpstm_register_admin_menu()
    {
        add_action('admin_menu', array($this, 'wpstm_admin_menu'));
    }
}