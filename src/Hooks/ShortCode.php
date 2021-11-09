<?php

namespace Hr\WpSTM\Hooks;

use Hr\WpSTM\Model\TodoModel;

class ShortCode
{
    protected $todoModel;

    public function __construct()
    {
        add_action('init', array($this, 'wpstm_shortcodes_init'));
        $this->todoModel = new TodoModel();
    }

    function wpstm_shortcodes_init()
    {
        add_shortcode('wpstm_shortcode', array($this, 'wpstm_shortcode_handler'));
    }

    public function wpstm_shortcode_handler($atts = [], $content = null, $tag = ''): string
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array)$atts, CASE_LOWER);

        // override default attributes with user attributes
        $wpstm_atts = shortcode_atts(
            array(
                'add-todo' => 'add-todo'
            ), $atts, $tag
        );

        if ($wpstm_atts['add-todo'] === 'add-todo') {
            $content = "<div class='add-todo'>
    <div class=''>
      <div class=''>
        <h1 class='add_todo_tittle'>Add New Todo</h1>
      </div>

      <div class=''>
        <form id='add_todo_form'>
          <input type='text' id='todo_name' placeholder='Todo...' name='todo_name'/>
          <button class='add_todo_button' type='submit'>add todo</button>
        </form>
      </div>
    </div>
  </div>";
        }


        return $content;
    }
}