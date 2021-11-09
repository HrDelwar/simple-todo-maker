<?php

namespace Hr\WpSTM\Router;

use Hr\WpSTM\Controller\TodoController;

class Router
{
    protected $loader;

    public function __construct($loader)
    {
        $this->loader = $loader;
        $this->wpstm_routes();
    }

    public function wpstm_routes()
    {
        $todoController = new TodoController();
        $this->loader->add_action('wp_ajax_wpstm_create_todo', array($todoController, 'wpstm_create_todo'));
        $this->loader->add_action('wp_ajax_wpstm_get_all_todo', array($todoController, 'wpstm_get_all_todo'));
        $this->loader->add_action('wp_ajax_wpstm_change_todo_status', array($todoController, 'wpstm_change_todo_status'));
        $this->loader->add_action('wp_ajax_wpstm_delete_todo', array($todoController, 'wpstm_delete_todo'));

    }
}