<?php

namespace Epsomsegura\ConexionaldiaAddons\Features\Addons\Infrastructure;

use Epsomsegura\ConexionaldiaAddons\Features\Addons\Domain\Addon;
use Epsomsegura\ConexionaldiaAddons\Features\Addons\Domain\Validations\Create;
use Epsomsegura\ConexionaldiaAddons\Features\Addons\Domain\Validations\Update;
use Epsomsegura\ConexionaldiaAddons\Features\Shared\Infrastructure\Base64ToImage;
use Epsomsegura\ConexionaldiaAddons\Features\Shared\Infrastructure\ManageUpladedFiles;

class JSONRequestsHandler
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'get_active_addon_endpoint']);
        add_action('rest_api_init', [$this, 'find_by_id_endpoint']);
        add_action('rest_api_init', [$this, 'get_endpoint']);
        add_action('rest_api_init', [$this, 'create_endpoint']);
        add_action('rest_api_init', [$this, 'delete_endpoint']);
        add_action('rest_api_init', [$this, 'update_endpoint']);
    }

    public function admin_permission()
    {
        $current_user = wp_get_current_user();
        if (in_array('administrator', $current_user->roles)) {
            return true;
        }
        return new \WP_Error('rest_forbidden', esc_html__('No tienes permiso para acceder a este recurso.', 'conexioinaldia-addons'), ['status' => 403]);
    }


    public function create_callback(\WP_REST_Request $request)
    {
        $params = $request->get_params();
        (new Addon)->inactivate_all();
        
        $payload = json_decode($params['payload'], TRUE);
        $payload['header']['path'] = (new Base64ToImage($payload['header']['base64']))->upload();
        $payload['header']['base64'] = null;
        foreach ($payload['left'] as $index => $leftImage) {
            $payload['left'][$index]['path'] = (new Base64ToImage($payload['left'][$index]['base64']))->upload();
            $payload['left'][$index]['base64'] = null;
        }
        foreach ($payload['right'] as $index => $rightImage) {
            $payload['right'][$index]['path'] = (new Base64ToImage($payload['right'][$index]['base64']))->upload();
            $payload['right'][$index]['base64'] = null;
        }
        $addon = new Addon();
        $addon->start_date = $params['start_date'] . " 00:00:00";
        $addon->end_date = $params['end_date'] . " 23:59:00";
        $addon->status = $params['status'];
        $addon->payload = json_encode($payload,JSON_UNESCAPED_UNICODE);
        $addon->created_at = date('Y-m-d H:i:s');
        $addon->updated_at = NULL;
        $response = $addon->save();
        return new \WP_REST_Response($response, 200);
    }
    public function create_endpoint()
    {
        register_rest_route('conexionaldia_addons', '/create', [
            'methods' => 'POST',
            'callback' => [$this, 'create_callback'],
            'permission_callback' => [$this, 'admin_permission'],
            'args' => (new Create)->validations()
        ]);
    }

    
    public function delete_callback(\WP_REST_Request $request)
    {
        return new \WP_REST_Response((new Addon)->delete($request->get_param('id')), 200);
    }
    public function delete_endpoint()
    {
        register_rest_route('conexionaldia_addons', '/delete/(?P<id>\d+)', [
            'methods' => 'DELETE',
            'callback' => [$this, 'delete_callback'],
            'permission_callback' => [$this, 'admin_permission']
        ]);
    }


    public function get_active_addon(\WP_REST_Request $request)
    {
        return new \WP_REST_Response((new Addon)->whereTrue('status')->first(), 200);
    }
    public function get_active_addon_endpoint()
    {
        register_rest_route('conexionaldia_addons', '/active', [
            'methods' => 'GET',
            'callback' => [$this, 'get_active_addon'],
            'permission_callback' => '__return_true',
        ]);
    }
    
    
    public function get_callback(\WP_REST_Request $request)
    {
        return new \WP_REST_Response((new Addon)->select(['id', 'status', 'created_at', 'start_date', 'end_date'])->orderBy('id', 'DESC')->paginate($request->get_params()), 200);
    }
    public function get_endpoint()
    {
        register_rest_route('conexionaldia_addons', '/index', [
            'methods' => 'GET',
            'callback' => [$this, 'get_callback'],
            'permission_callback' => [$this, 'admin_permission'],
        ]);
    }


    public function find_by_id_callback(\WP_REST_Request $request)
    {
        return new \WP_REST_Response((new Addon)->find($request->get_param('id')), 200);
    }
    public function find_by_id_endpoint()
    {
        register_rest_route('conexionaldia_addons', '/find/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => [$this, 'find_by_id_callback'],
            'permission_callback' => [$this, 'admin_permission'],
        ]);
    }


    public function update_callback(\WP_REST_Request $request)
    {
        $params = $request->get_params();

        $payload = json_decode($params['payload'], TRUE);
        if(!is_null($payload['header']['base64'])){
            (new ManageUpladedFiles())->deleteFromUrl($payload['header']['path']);
            $payload['header']['path'] = (new Base64ToImage($payload['header']['base64']))->upload();
            $payload['header']['base64'] = null;
        }
        foreach ($payload['left'] as $index => $leftImage) {
            if(!is_null($payload['left'][$index]['base64'])){
                (new ManageUpladedFiles())->deleteFromUrl($payload['left'][$index]['path']);
                $payload['left'][$index]['path'] = (new Base64ToImage($payload['left'][$index]['base64']))->upload();
                $payload['left'][$index]['base64'] = null;
            }
        }
        foreach ($payload['right'] as $index => $rightImage) {
            if(!is_null($payload['right'][$index]['base64'])){
                (new ManageUpladedFiles())->deleteFromUrl($payload['right'][$index]['path']);
                $payload['right'][$index]['path'] = (new Base64ToImage($payload['right'][$index]['base64']))->upload();
                $payload['right'][$index]['base64'] = null;
            }
        }
        $addon = (new Addon())->find($params['id']);
        $addon->start_date = (array_key_exists('start_date', $params) ? $params['start_date'] : $addon->start_date);
        $addon->end_date = (array_key_exists('end_date', $params) ? $params['end_date'] : $addon->end_date);
        $addon->status = (array_key_exists('status', $params) ? $params['status'] : $addon->status);
        $addon->payload = (array_key_exists('payload', $params) ? json_encode($payload,JSON_UNESCAPED_UNICODE) : $addon->payload);
        $addon->updated_at = date('Y-m-d H:i:s');
        $response = $addon->save();
        return new \WP_REST_Response($response, 200);
    }
    public function update_endpoint()
    {
        register_rest_route('conexionaldia_addons', '/update/(?P<id>\d+)', [
            'methods' => 'PATCH',
            'callback' => [$this, 'update_callback'],
            'permission_callback' => [$this, 'admin_permission'],
            'args' => (new Update)->validations()
        ]);
    }
}
