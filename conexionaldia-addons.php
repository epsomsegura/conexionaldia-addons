<?php

/**
 * Plugin Name: Conexión al día - Addons
 * Plugin URI: https://conexionaldia.com
 * Description: Este plugin administra los addons de la cabecera y las dos barras laterales del portal conexionaldia.com
 * Version: 1.0.0
 * Author: Epsom Segura
 * Author URI: https://www.linkedin.com/in/epsomsegura/
 * License: MIT
 */

use Epsomsegura\ConexionaldiaAddons\Main;

if (!defined('ABSPATH')) {
    exit;
}

define('MY_PLUGIN_FILE', __FILE__);

require_once __DIR__ . '/vendor/autoload.php';

new Main();