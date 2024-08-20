<?php

namespace Epsomsegura\ConexionaldiaAddons\Core\Admin;

class Assets
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'conexionaldia_addons_admin_enqueue_scripts']);
    }
    public function conexionaldia_addons_admin_enqueue_scripts($hook)
    {
        if ($hook != 'toplevel_page_conexionaldia') {
            return;
        }
        wp_enqueue_script('jquery');
        wp_enqueue_style('bootstrap-css', plugins_url("../../../assets/css/bootstrap.min.css", __FILE__), array(), '5.2.0');
        wp_enqueue_script('bootstrap-js', plugins_url("../../../assets/js/bootstrap.bundle.min.js", __FILE__), array('jquery'), '5.2.0', true);
        wp_enqueue_script('sweetalert2', plugins_url("../../../assets/js/sweetalert2.min.js", __FILE__), array(), '2.11.12.4', true);
        wp_enqueue_script('alpinejs', plugins_url("../../../assets/js/alpine.js", __FILE__), array(), '3.14.1',true);
        wp_enqueue_style('fontawesome', plugins_url("../../../assets/css/all.min.css", __FILE__), array(), '6.6.0');
        wp_enqueue_style('conexionaldia-addons-css', plugins_url("../../../assets/css/conexionaldia-addons.css", __FILE__), array(), '1.0.0');
        $nonce = wp_create_nonce('wp_rest');
        wp_localize_script('jquery', 'wpApiSettings', ['nonce' => $nonce,'apiUrl' => esc_url(rest_url('conexionaldia_addons/')),]);
    }
}
