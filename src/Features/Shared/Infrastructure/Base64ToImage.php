<?php

namespace Epsomsegura\ConexionaldiaAddons\Features\Shared\Infrastructure;

class Base64ToImage
{
    public $base64;

    public function __construct($base64) {
        $this->base64 = $base64;
    }

    public function upload()
    {
        $parts = explode(',', $this->base64);
        $mime_type = $parts[0];
        $base64_data = $parts[1];
        $mime_split = explode(';', $mime_type);
        $mime_split = explode('/', $mime_split[0]);
        $file_extension = strtolower($mime_split[1]);
        $image_data = base64_decode($base64_data);
        $file_name = uniqid() . '.' . $file_extension;
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['path'] . "/conexionaldia_addons/"  . $file_name;
        file_put_contents($file_path, $image_data);
        return $upload_dir['url'] . "/conexionaldia_addons/"  . $file_name;
    }
}
