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
    public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    // custom add_filter hook
    public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);

    }

    // add action & filter hook method
    public function add($hooks, $hook, $component, $callback, $priority, $accepted_args)
    {
        $hooks[] = array(
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args
        );

        return $hooks;
    }

    // run all filters and actions
    public function run()
    {
        foreach ($this->filters as $hook) {
            add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }

        foreach ($this->actions as $hook) {
            add_acction($hook['hook'], arrray($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }
    }

}