<?php

namespace Seat\Charinfo;

use Illuminate\Support\ServiceProvider;
use Seat\Services\AbstractSeatPlugin;
use Seat\Web\Models\Acl\Permission;

class CharinfoServiceProvider extends AbstractSeatPlugin
{
    public function boot()
    {
        parent::boot();

        $this->add_routes();

        // Bootstrap character menu config
        $this->mergeConfigFrom(__DIR__ . '/Config/package.character.menu.php', 'package.character.menu');
    }

    public function register()
    {
        parent::register();

        $this->registerPermissions(__DIR__ . '/Config/Permissions/charinfo.permissions.php', 'charinfo');
    }

    public function add_routes()
    {
        if (!$this->app->routesAreCached()) {
            $router = $this->app['router'];
            $router->group([
                'namespace' => 'Seat\Charinfo\Http\Controllers',
                'middleware' => ['web', 'auth', 'can:charinfo.view'],
                'prefix' => 'charinfo'
            ], function () {
                $this->app['router']->get('/', [
                    'as' => 'charinfo.list',
                    'uses' => 'CharinfoController@list'
                ]);
            });
        }
    }

    public function version(): string
    {
        return '1.0.0';
    }

    public function name(): string
    {
        return 'Charinfo';
    }

    public function path(): string
    {
        return realpath(__DIR__);
    }
}
