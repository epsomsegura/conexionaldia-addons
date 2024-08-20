<?php

namespace Epsomsegura\ConexionaldiaAddons;

use Epsomsegura\ConexionaldiaAddons\App\Controllers\AddonsController;
use Epsomsegura\ConexionaldiaAddons\Core\Activate;
use Epsomsegura\ConexionaldiaAddons\Core\Deactivate;
use Epsomsegura\ConexionaldiaAddons\Core\Admin\Assets;
use Epsomsegura\ConexionaldiaAddons\Core\Admin\Menu;
use Epsomsegura\ConexionaldiaAddons\Core\Portal\PortalAssets;
use Epsomsegura\ConexionaldiaAddons\Features\Addons\Domain\Addon;

class Main
{
    public function __construct()
    {
        register_activation_hook(__FILE__, Activate::class);
        register_deactivation_hook(__FILE__, Deactivate::class);
        add_action('init', [$this, 'init']);
    }
    public function init()
    {
        new AddonsController();
        new PortalAssets();
        if(is_admin()){
            new Menu();
            new Assets();
        }
        new Addon();
    }
}
