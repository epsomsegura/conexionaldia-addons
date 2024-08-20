<?php

/**
 * Plugin Name: Conexión al día - Addons
 * Plugin URI: https://conexionaldia.com
 * Description: Este plugin administra los addons de la cabecera y las dos barras laterales
 * Version: 1.0.0
 * Author: Epsom Segura
 * Author URI: https://www.linkedin.com/in/epsomsegura/
 * License: GPL2
 */

use Epsomsegura\ConexionaldiaAddons\Main;

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

new Main();