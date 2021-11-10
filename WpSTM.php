<?php
/**
 * Plugin Name
 *
 * @package Wp S
 * TM
 * @author Hr Delwar
 * @copyright 2001
 * @license GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Simple Todo Maker
 * Plugin URI: https://example.com/plugins/simple-task-manager
 * Description: Todo maker
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Hr Delwar
 * Author URI: https://hrdelwar.netlify.app
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI: https://example.com/simple-todo-maker
 * Text Domain: simple-todo-maker
 * Domain Path: /languages
 */

require_once 'vendor/autoload.php';

const WPSTM_PUBLIC_PLUGIN_PATH = __FILE__;
const wpstm_todos_table = 'wpstm_todos';
const WPSTM_NONCE = 'WPSTM54321';


$wpstm = new \Hr\WpSTM\Hooks\PluginInit();
$wpstm->run();