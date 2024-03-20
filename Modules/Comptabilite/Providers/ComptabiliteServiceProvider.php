<?php

namespace Modules\Comptabilite\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Comptabilite\Entities\Corps;
use Modules\Comptabilite\Entities\Ligne;
use Modules\Comptabilite\Entities\Budget;
use Modules\Comptabilite\Entities\Mouvement;
use Modules\Comptabilite\Entities\Morgue;
use Modules\Comptabilite\Entities\Examen;
use Modules\Comptabilite\Entities\Autorisation;
use Modules\Comptabilite\Entities\Saccount;
use Modules\Comptabilite\Entities\Parametre;
use Modules\Comptabilite\Entities\SaccountClass;
use Modules\Comptabilite\Observers\CorpsObserver;
use Modules\Comptabilite\Observers\LigneObserver;
use Modules\Comptabilite\Observers\BudgetObserver;
use Modules\Comptabilite\Observers\MouvementObserver;
use Modules\Comptabilite\Observers\MorgueObserver;
use Modules\Comptabilite\Observers\ExamenObserver;
use Modules\Comptabilite\Observers\AutorisationObserver;
use Modules\Comptabilite\Observers\SaccountObserver;
use Modules\Comptabilite\Observers\ParametreObserver;
use Modules\Comptabilite\Observers\SaccountClassObserver;

class ComptabiliteServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Comptabilite';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'comptabilite';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        Ligne::observe(LigneObserver::class);
        Mouvement::observe(MouvementObserver::class);
        Budget::observe(BudgetObserver::class);
        Examen::observe(ExamenObserver::class);
        Corps::observe(CorpsObserver::class);
        Saccount::observe(SaccountObserver::class);
        Autorisation::observe(AutorisationObserver::class);
        Parametre::observe(ParametreObserver::class);
        SaccountClass::observe(SaccountClassObserver::class);
        Morgue::observe(MorgueObserver::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
