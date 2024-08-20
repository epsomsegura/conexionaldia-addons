<?php

namespace Epsomsegura\ConexionaldiaAddons\App\Controllers;

use Epsomsegura\ConexionaldiaAddons\Features\Addons\Infrastructure\JSONRequestsHandler;

class AddonsController
{
    public function __construct() {
        new JSONRequestsHandler();
    }
}
