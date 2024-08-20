<?php

namespace Epsomsegura\ConexionaldiaAddons\Features\Addons\Domain\Validations;

class Update
{
    public function validations()
    {
        return [
            'start_date' => [
                'required' => false,
                'validate_callback' => 'validate_start_date',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'end_date' => [
                'required' => true,
                'validate_callback' => 'validate_end_date',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'status' => [
                'required' => false,
                'validate_callback' => 'validate_status',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'payload' => [
                'required' => false,
                'validate_callback' => 'validate_payload',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'created_at' => [
                'required' => false,
                'validate_callback' => 'validate_created_at',
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'updated_at' => [
                'required' => false,
                'validate_callback' => 'validate_updated_at',
                'sanitize_callback' => 'sanitize_text_field',
            ],
        ];
    }
    public function validate_start_date($value, $request, $key)
    {
        return true;
        // if (is_numeric($value) && intval($value) > 0) {
        // }
        // return new \WP_Error('invalid_param', 'El parámetro param1 debe ser un número entero positivo', ['status' => 400]);
    }

    public function validate_end_date($value, $request, $key)
    {
        return true;
        // if (!empty($value)) {
        // }
        // return new \WP_Error('invalid_param', 'El parámetro param2 no puede estar vacío', ['status' => 400]);
    }
    public function validate_status($value, $request, $key)
    {
        return true;
        // if (!empty($value)) {
        // }
        // return new \WP_Error('invalid_param', 'El parámetro param2 no puede estar vacío', ['status' => 400]);
    }
    public function validate_payload($value, $request, $key)
    {
        return true;
        // if (!empty($value)) {
        // }
        // return new \WP_Error('invalid_param', 'El parámetro param2 no puede estar vacío', ['status' => 400]);
    }
    public function validate_created_at($value, $request, $key)
    {
        return true;
        // if (is_numeric($value) && intval($value) > 0) {
        // }
        // return new \WP_Error('invalid_param', 'El parámetro param1 debe ser un número entero positivo', ['status' => 400]);
    }

    public function validate_updated_at($value, $request, $key)
    {
        return true;
        // if (!empty($value)) {
        // }
        // return new \WP_Error('invalid_param', 'El parámetro param2 no puede estar vacío', ['status' => 400]);
    }
}
