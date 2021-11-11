<?php

namespace Hr\WpSTM\Hooks;

use Hr\WpSTM\Router\Router;
use Hr\WpSTM\Shortcode\AddTodo;
use Hr\WpSTM\Shortcode\AllTodo;

class PluginInit
{
    protected $loader;
    protected $name;
    protected $version;

    public function __construct()
    {
        $this->name = 'WPSTM';
        $this->version = '1.0';
        $this->loader = new PluginLoader();
    }

    public function wpstm_init_shortcode()
    {
        new AddTodo();
        new AllTodo();
    }

    public function run()
    {
        new Activation();
        new Deactivation();
        Uninstall::wpstm_uninstall();
        $this->wpstm_load_asset();
        new Router($this->loader);
        $this->loader->run();
        $this->wpstm_init_shortcode();
    }


    // load all assets
    public function wpstm_load_asset()
    {
        $this->loader->add_action('admin_enqueue_scripts', array($this, 'wpstm_load_admin_script'));
        $this->loader->add_action('wp_enqueue_scripts', array($this, 'wpstm_load_public_assets'));
    }


    // enqueue public style
    public function wpstm_load_admin_script()
    {
        wp_enqueue_style('wpstm_css', plugin_dir_url(WPSTM_PUBLIC_PLUGIN_PATH) . 'assets/css/style.css');

        wp_enqueue_script('wpstm_script', plugin_dir_url(WPSTM_PUBLIC_PLUGIN_PATH) . 'assets/js/main.js', $this->version, ['jquery'], true);
        wp_localize_script('wpstm_script', 'ajax_object', array(
            'nonce' => wp_create_nonce(WPSTM_NONCE)
        ));
    }

    public function wpstm_load_public_assets()
    {

        wp_enqueue_style('wpstm_fontawesome', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css');

        wp_enqueue_script('wpstm_sweetalert2', plugin_dir_url(WPSTM_PUBLIC_PLUGIN_PATH) . 'assets/js/sweetalert2.all.min.js');

        wp_localize_script('wpstm_sweetalert2', 'ajax_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce(WPSTM_NONCE)
        ));
    }
}
