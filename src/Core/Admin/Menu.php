<?php

namespace Epsomsegura\ConexionaldiaAddons\Core\Admin;

class Menu
{
    public function __construct()
    {
        add_action('admin_menu',[$this,'handler']);
    }
    public function handler()
    {
        add_menu_page(
            "Conexión al día - Addons",
            "Conexión al día - Addons",
            "manage_options",
            "conexionaldia",
            [$this,'view'],
            plugin_dir_url(__FILE__)."../../../assets/img/logotypes/conexionaldia_20x20.png",
            "2"
        );
    }
    
    public function view()
    {
        require_once plugin_dir_path(__FILE__)."../../Views/Admin/Index.php";
    }
}
