<?php

namespace Hr\WpSTM\Shortcode;

use Hr\WpSTM\Model\TodoModel;

class AllTodo
{
    protected $todoModel;

    public function __construct()
    {
        $this->todoModel = new TodoModel();
        add_action('wp_enqueue_scripts', array($this, "wpstm_load_all_todo_assets"));
        add_shortcode('wpstm-all-todo-view', array($this, 'wpstm_all_todo_view_handler'));
    }

    public function wpstm_load_all_todo_assets()
    {
        wp_enqueue_style('wpstm_all_todo_view_frontend', plugin_dir_url(WPSTM_PUBLIC_PLUGIN_PATH) . 'assets/css/wpstm_all_todo_view_frontend.css');
        wp_enqueue_script('wpstm_all_todo_view_frontend', plugin_dir_url(WPSTM_PUBLIC_PLUGIN_PATH) . 'assets/js/wpstm_all_todo_view_frontend.js', ['jquery'], false, true);
    }

    public function wpstm_all_todo_view_handler($attr = [], $content = null, $tag = ''): string
    {
        $attr = array_change_key_case((array)$attr, CASE_LOWER);
        $wpstm_all_todo = shortcode_atts([
            'title' => 'Todos'
        ], $attr, $tag);

        $title = empty($wpstm_all_todo['title']) ? 'Todos' : $wpstm_all_todo['title'];


        $todos = $this->todoModel->getAll();

        if (!(count($todos) > 0)) {
            $content .= '
            <div class="todos_view">
                 <h1 class="todos_title">' . $title . '</h1>
                <div class="todo_container" id="todo_view_container">
                  <p id="todo_not_found_p">There is no todo in your list!</p>
                </div>
            </div>
            ';
			return $content;
        }


        $content .= "
        <div class='todos_view'>
            <h1 class=''>$title</h1>
            
            <div class='todo_container' id='todo_view_container'> ";


        foreach ($todos as $todo) {
            $id = $todo['id'];
            $name = $todo['todo_name'];
            $checked = boolval($todo['completed']) ? 'checked' : '';
            $_active = boolval($todo['completed']) ? 'active ' : '';
            $content .= "
            <div class='todo_item $_active' id='todo_view_item-$id' title = 'Double click for change status.'>
                <input type = 'checkbox' id = 'check_view_input-$id' $checked>
                <h4 class='todo_title no_select' >
                    $name
                </h4 >
                <button class='todo_delete_btn' id='todo_view_delte_btn-$id'>
                   <i class='far fa-trash-alt'></i>
                 </button >
             </div >";
        }
        $content .= "</div ></div >";


        return $content;
    }

}