<?php

namespace Epsomsegura\ConexionaldiaAddons\Core;

use Epsomsegura\ConexionaldiaAddons\App\Repositories\AddonsRepository;
use Epsomsegura\ConexionaldiaAddons\Features\Addons\Domain\Addon;
use VK\Actions\Auth;

class Activate
{
    public function __invoke()
    {
        (new Addon())->create_schema();
    }
}
