<?php

namespace Epsomsegura\ConexionaldiaAddons\Core\Portal;

class PortalAssets
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this,'conexionaldia_addons_enqueue_scripts']);
    }
    function conexionaldia_addons_enqueue_scripts()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_style('bootstrap-css', plugins_url("../../../assets/css/bootstrap.min.css", __FILE__), array(), '5.2.0');
        wp_enqueue_script('bootstrap-js', plugins_url("../../../assets/js/bootstrap.bundle.min.js", __FILE__), array('jquery'), '5.2.0', true);
        wp_enqueue_script('sweetalert2', plugins_url("../../../assets/js/sweetalert2.min.js", __FILE__), array(), '2.11.12.4', true);
        wp_enqueue_script('conexionaldia_addons', plugins_url("../../../assets/js/conexionaldia_addons.js", __FILE__), array('jquery'), null, true);
        wp_enqueue_style('fontawesome', plugins_url("../../../assets/css/all.min.css", __FILE__), array(), '6.6.0');
        wp_enqueue_style('cropper-css', plugins_url("../../../assets/css/cropper.min.css", __FILE__), array(), '1.6.2');
        wp_enqueue_script('cropper-js', plugins_url("../../../assets/js/cropper.min.js", __FILE__), array('jquery'), '1.6.2', true);
        wp_enqueue_style('conexionaldia-addons-css', plugins_url("../../../assets/css/conexionaldia-addons.css", __FILE__), array(), '1.0.0');

        wp_localize_script('conexionaldia_addons', 'conexionaldia_addons_object', array(
            'api_url' => rest_url('/conexionaldia_addons/active')
        ));
    }
}
