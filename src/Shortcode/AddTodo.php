<?php

namespace Hr\WpSTM\Shortcode;

use Hr\WpSTM\Model\TodoModel;

class AddTodo
{
    protected $todoModel;

    public function __construct()
    {
        $this->todoModel = new TodoModel();
        add_shortcode('wpstm-add-todo', array($this, 'wpstm_add_todo_handler'));
        add_action('wp_enqueue_scripts', array($this, 'wpstm_load_add_todo_assets'));
    }

    public function wpstm_load_add_todo_assets()
    {
        wp_enqueue_style('wpstm_add_todo_frontend', plugin_dir_url(WPSTM_PUBLIC_PLUGIN_PATH) . 'assets/css/wpstm_add_todo_frontend.css');

        wp_enqueue_script('wpstm_add_todo_frontend_script', plugin_dir_url(WPSTM_PUBLIC_PLUGIN_PATH) . 'assets/js/wpstm_add_todo_frontend.js', ['jquery'], false, true);
    }

    public function wpstm_add_todo_handler($atts = [], $content = null, $tag = ''): string
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array)$atts, CASE_LOWER);

        // override default attributes with user attributes
        $wpstm_add_todo = shortcode_atts(
            array(
                'title' => 'Add New Todo'
            ), $atts, $tag
        );


        $content .= '<div class="add-todo">
    <div class="">
      <div class="">
        <h1 class="add_todo_tittle">' . $wpstm_add_todo['title'] . '</h1>
      </div>

      <div class="">
        <form id="add_todo_form">
          <input type="text" id="todo_name" placeholder="Todo..." name="todo_name"/>
          <button class="add_todo_button" type="submit">add todo</button>
        </form>
      </div>
    </div>
  </div>';


        return $content;
    }
}