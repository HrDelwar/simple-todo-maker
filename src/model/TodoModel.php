<?php

namespace Hr\WpSTM\Model;

class TodoModel
{
    protected $_wpdb;
    protected $tableName;

    public function __construct()
    {
        global $wpdb;
        $this->_wpdb = $wpdb;
        $this->tableName = $wpdb->prefix . wpstm_todos_table;
    }

    public function find($id)
    {
        return $this->_wpdb->get_row("SELECT * FROM $this->tableName WHERE id=$id");
    }

    public function store($data)
    {
        return $this->_wpdb->insert($this->tableName, $data);
    }

    public function getAll()
    {
        return $this->_wpdb->get_results("SELECT * FROM $this->tableName ORDER BY id DESC", 'ARRAY_A');
    }

    public function update($data, $id)
    {
        return $this->_wpdb->update($this->tableName, $data, array('id' => $id));
    }
}