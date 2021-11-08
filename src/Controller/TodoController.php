<?php

namespace Hr\WpSTM\Controller;

use Hr\WpSTM\Model\TodoModel;

class TodoController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TodoModel();
    }

    public function wpstm_create_todo()
    {
        $todo_name = $_REQUEST['todo_name'];
        if (isset($todo_name) && !empty($todo_name)) {
            $data = array(
                'todo_name' => $todo_name,
            );


            if ($this->model->store($data)) {
                wp_send_json(array(
                    'status' => true,
                    'message' => 'Todo create successfully!'
                ));

            } else {
                wp_send_json(array(
                    'status' => false,
                    'message' => 'Something went wrong! Please try again latter.'
                ));
            }

        }


    }

    public function wpstm_get_all_todo()
    {
        $data = $this->model->getAll();

        if (count($data) > 0) {
            wp_send_json(array(
                'status' => true,
                'message' => 'Total todo found : ' . count($data),
                'todos' => $data
            ));
        } else {
            wp_send_json(array(
                'status' => false,
                'message' => 'Todo not found.',
                'todos' => []
            ));
        }
    }

    public function wpstm_change_todo_status()
    {
        $id = $_REQUEST['id'];
        if (isset($id) && !empty($id)) {
            $row = $this->model->find($id);
            $status = $row->completed;
            $row->completed = $row->completed === '0' ? 1 : 0;
            $this->model->update((array)$row, $id);
            if ($status === $row->completed) {
                wp_send_json(array(
                    'status' => false,
                    'message' => 'Something went wrong! Please try again latter.',
                    'completed' => $status
                ));
            } else {
                wp_send_json(array(
                    'status' => true,
                    'message' => 'Status change successfully!',
                    'completed' => $row->completed
                ));
            }
        }
    }
}