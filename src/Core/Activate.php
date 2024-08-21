<?php

namespace Epsomsegura\ConexionaldiaAddons\Core;

use Epsomsegura\ConexionaldiaAddons\Features\Addons\Domain\Addon;

class Activate
{
    public static function activate()
    {
        (new Addon())->create_schema();
    }
}
