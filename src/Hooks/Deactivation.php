<?php

namespace Hr\WpSTM\Hooks;

class Deactivation
{

    protected $admin_action;

    public function __construct()
    {
        $this->admin_action = new PluginAdmin();
        $this->deactivation();
    }

    // deactivation method
    public function deactivation()
    {

    }

}