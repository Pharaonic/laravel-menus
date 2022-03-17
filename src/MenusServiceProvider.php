<?php

namespace Pharaonic\Laravel\Menus;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Pharaonic\Laravel\Menus\Models\Menu;

class MenusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Migration Loading
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Views
        $this->loadViewsFrom(__DIR__ . '/views', 'laravel-menus');

        // Publishes
        $this->publishes([
            __DIR__ . '/views'  => resource_path('views/vendor/laravel-menus'),

            __DIR__ . '/database/migrations/2021_02_01_000016_create_menus_table.php'               => database_path('migrations/2021_02_01_000016_create_menus_table.php'),
            __DIR__ . '/database/migrations/2021_02_01_000017_create_menu_translations_table.php'   => database_path('migrations/2021_02_01_000017_create_menu_translations_table.php'),
        ], ['pharaonic', 'laravel-menus']);

        // Blade - Directive
        Blade::directive('menu', function ($data) {
            return "<?php echo \menu($data); ?>";
        });
    }
}
