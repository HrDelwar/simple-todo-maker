<?php

namespace Hr\WpSTM\Hooks;

class PluginLoader
{
    protected $actions;
    protected $filters;

    public function __construct()
    {
        $this->actions = array();
        $this->filters = array();
    }

    // custom add_action hook
    public function add_action($hook, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions = $this->add($this->actions, $hook, $callback, $priority, $accepted_args);
    }

    // custom add_filter hook
    public function add_filter($hook, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters = $this->add($this->filters, $hook, $callback, $priority, $accepted_args);

    }

    // add action & filter hook method
    public function add($hooks, $hook, $callback, $priority, $accepted_args)
    {
        $hooks[] = array(
            'hook' => $hook,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args
        );

        return $hooks;
    }

    // run all filters and actions
    public function run()
    {

        foreach ($this->actions as $hook) {
            add_action($hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args']);
        }
        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], $hook['callback'], $hook['priority'], $hook['accepted_args']);
        }


    }

}