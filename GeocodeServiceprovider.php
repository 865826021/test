<?php
namespace Lusong\Geocode;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
class GeocodeServiceprovider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__.'/../views'), 'geocode');
        $this->setupRoutes($this->app->router);
        // this for conig
        $this->publishes([
            __DIR__.'/config/geocode.php' => config_path('geocode.php'),
        ]);
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Lusong\Geocode\Http\Controllers'], function($router)
        {
            require __DIR__.'/Http/routes.php';
        });
    }

    public function register()
    {
        $this->registerGeocode();
        config([
            'config/geocode.php',
        ]);
    }
    private function registerGeocode()
    {
        $this->app->bind('geocode',function($app){
            return new Geocode($app);
        });
    }
}
