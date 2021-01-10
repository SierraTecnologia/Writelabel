<?php
/**
 * | Events
 * | ---------------------------------
 * | Illuminate\Auth\Events\Attempting
 * | Illuminate\Auth\Events\Login
 * | Illuminate\Auth\Events\Logout
 * |
 * | Illuminate\Cache\Events\CacheMissed
 * | Illuminate\Cache\Events\CacheHit
 * | Illuminate\Cache\Events\KeyWritten
 * | Illuminate\Cache\Events\KeyForgotten
 * |
 * | Illuminate\Database\Events\TransactionBeginning
 * | Illuminate\Database\Events\TransactionCommitted
 * | Illuminate\Database\Events\TransactionRolledBack
 * | Illuminate\Database\Events\QueryExecuted
 * |
 * | Illuminate\Queue\Events\JobProcessed
 * | Illuminate\Queue\Events\JobFailed
 * | Illuminate\Queue\Events\WorkerStopping
 * |
 * | Illuminate\Mail\Events\MessageSending
 * | Illuminate\Routing\Events\RouteMatched
 * |
 * | eloquent.booting
 * | eloquent.booted
 * | eloquent.deleting
 * | eloquent.deleted
 * | eloquent.saving
 * | eloquent.saved
 * | eloquent.updating
 * | eloquent.updated
 * | eloquent.creating
 * | eloquent.created
 * | eloquent.restoring
 * | eloquent.restored
 * |
 * | kernel.handled
 * | locale.changed
 */
namespace WriteLabel;

use App;
use Config;
use WriteLabel\Facades\WriteLabel as WriteLabelFacade;
use WriteLabel\Services\WriteLabelService;
use Illuminate\Foundation\AliasLoader;

use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

use Log;

use Muleta\Traits\Providers\ConsoleTools;
use Route;

class WriteLabelProvider extends ServiceProvider
{
    use ConsoleTools;

    public $packageName = 'writelabel';
    const pathVendor = 'sierratecnologia/writelabel';

    public static $aliasProviders = [
        'WriteLabel' => \WriteLabel\Facades\WriteLabel::class,
    ];

    public static $providers = [
        \Tracking\TrackingProvider::class,
        \Finder\FinderProvider::class,
        \Spatie\EventSourcing\EventSourcingServiceProvider::class,
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [
        [
            'text'        => 'Meus Pontos',
            'route'       => 'profile.writelabel.home',
            'icon'        => 'fas fa-fw fa-gamepad',
            'icon_color'  => 'blue',
            'label_color' => 'success',
            'section' => "profile",
            // 'access' => \Porteiro\Models\Role::$ADMIN
        ],
        [
            'text' => 'Gamificação',
            'icon' => 'fas fa-fw fa-search',
            'icon_color' => "blue",
            'label_color' => "success",
            'section'   => 'admin',
            'level'       => 2, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        ],
        'Gamificação' => [
            [
                'text'        => 'Tipos de Pontos',
                'route'       => 'rica.writelabel.pointTypes.index',
                'icon'        => 'fas fa-fw fa-gamepad',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "admin",
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'Challenges (Competições)',
                'route'       => 'rica.writelabel.competitions.index',
                'icon'        => 'fas fa-fw fa-flag',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "admin",
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'Score de Pontos',
                'route'       => 'profile.writelabel.home',
                'icon'        => 'fas fa-fw fa-gamepad',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "admin",
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'Badges (Metalhas)',
                'route'       => 'rica.writelabel.home',
                'icon'        => 'fas fa-fw fa-flag',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "admin",
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
            [
                'text'        => 'Guests (Desafios)',
                'route'       => 'rica.writelabel.home',
                'icon'        => 'fas fa-fw fa-flag',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'section' => "admin",
                // 'access' => \Porteiro\Models\Role::$ADMIN
            ],
        ],
    ];

    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        
        // Register configs, migrations, etc
        $this->registerDirectories();

        // COloquei no register pq nao tava reconhecendo as rotas para o adminlte
        $this->app->booted(function () {
            $this->routes();
        });

        //
        $this->app['events']->listen(
            'eloquent.*',
            'WriteLabel\Observers\ModelCallbacks'
        );
        $this->app['events']->listen(
            'Illuminate\Auth\Events\Login',
            'WriteLabel\Observers\LoginObserver'
        );
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        /**
         * Transmissor; Routes
         */
        $this->loadRoutesForRiCa(__DIR__.'/../routes');
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../publishes/config/writelabel.php', 'writelabel');
        // $this->mergeConfigFrom(__DIR__.'/../publishes/config/horizon.php', 'horizon');
        // $this->mergeConfigFrom(__DIR__.'/../publishes/config/event-sourcing.php', 'event-sourcing');
        

        $this->setProviders();
        // $this->routes();



        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $loader = AliasLoader::getInstance();
        $loader->alias('WriteLabel', WriteLabelFacade::class);

        $this->app->singleton(
            'writelabel', function () {
                return new WriteLabel();
            }
        );
        
        /*
        |--------------------------------------------------------------------------
        | Register the Utilities
        |--------------------------------------------------------------------------
        */
        /**
         * Singleton WriteLabel
         */
        $this->app->singleton(
            WriteLabelService::class, function ($app) {
                Log::info('Singleton WriteLabel');
                return new WriteLabelService(\Illuminate\Support\Facades\Config::get('sitec.writelabel'));
            }
        );

        // Register commands
        $this->registerCommandFolders(
            [
            base_path('vendor/sierratecnologia/writelabel/src/Console/Commands') => '\WriteLabel\Console\Commands',
            ]
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'writelabel',
        ];
    }

    /**
     * Register configs, migrations, etc
     *
     * @return void
     */
    public function registerDirectories()
    {

        $this->publishConfig();
        $this->publishMigration();

        // // Publish writelabel css and js to public directory
        // $this->publishes([
        //     $this->getDistPath('writelabel') => public_path('assets/writelabel')
        // ], ['public',  'sitec', 'sitec-public']);

        $this->loadViews();
        $this->loadTranslations();
    }

    /**
     * Publish Tecnico configuration.
     */
    protected function publishConfig()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../publishes/config/writelabel.php' => config_path('writelabel.php'),
            __DIR__.'/../publishes/config/event-sourcing.php' => config_path('event-sourcing.php'),
            __DIR__.'/../publishes/config/horizon.php' => config_path('horizon.php'),
        ], ['config', 'writelabel', 'writelabel-config', 'rica', 'rica-config']);
    }

    /**
     * Publish Tecnico migration.
     */
    protected function publishMigration()
    {
        $this->publishes(
            [
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], ['migrations', 'writelabel', 'writelabel-migrations', 'rica', 'rica-migrations']
        );
        // @todo
        // if (! class_exists('TecnicoSetupTables')) {
        //     // Publish the migration
        //     $timestamp = date('Y_m_d_His', time());
        //     $this->publishes([
        //         __DIR__.'/../database/migrations/2016_05_18_000000_tecnico_setup_tables.php' => database_path('migrations/'.$timestamp.'_tecnico_setup_tables.php'),
        //       ],, ['migrations', 'writelabel', 'writelabel-migrations', 'rica', 'rica-migrations']);
        // }
    }

    private function loadViews()
    {
        // View namespace
        $viewsPath = $this->getResourcesPath('views');
        $this->loadViewsFrom($viewsPath, 'writelabel');
        $this->publishes(
            [
            $viewsPath => base_path('resources/views/vendor/writelabel'),
            ], ['views', 'writelabel', 'writelabel-views', 'rica', 'rica-views']
        );
    }
    
    private function loadTranslations()
    {
        // Publish lanaguage files
        $this->publishes(
            [
            $this->getResourcesPath('lang') => resource_path('lang/vendor/writelabel')
            ], ['lang', 'writelabel', 'writelabel-lang', 'rica', 'rica-lang', 'translations']
        );

        // Load translations
        $this->loadTranslationsFrom($this->getResourcesPath('lang'), 'writelabel');
    }
}
