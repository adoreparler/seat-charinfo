<?php

namespace Seat\Charinfo;

use Seat\Services\AbstractSeatPlugin;

class CharinfoServiceProvider extends AbstractSeatPlugin
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'charinfo');
        $this->mergeConfigFrom(__DIR__ . '/Config/package.character.menu.php', 'package.character.menu');
    }

    public function register()
    {
        $this->registerPermissions(__DIR__ . '/Config/Permissions/charinfo.permissions.php', 'charinfo');
    }

    public function getName(): string { return 'Character Info'; }
    public function getPackage(): string { return 'seat-charinfo'; }
    public function getVersion(): string { return '1.0.0'; }
    public function getAuthor(): string { return 'Adore Parler'; }
    public function getIcon(): string { return 'fas fa-info-circle'; }
    public function getUrl(): ?string { return 'https://github.com/adoreparler/seat-charinfo'; }
}
