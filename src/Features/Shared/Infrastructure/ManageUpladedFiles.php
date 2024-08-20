<?php

namespace Epsomsegura\ConexionaldiaAddons\Features\Shared\Infrastructure;

class ManageUpladedFiles
{
    public function __construct() {}

    public function deleteFromUrl($url)
    {
        $upload_dir = wp_upload_dir();
        $file_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $url);
        if (file_exists($file_path)) {
            if (unlink($file_path)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
