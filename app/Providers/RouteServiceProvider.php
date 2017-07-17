<?php

namespace App\Providers;
use Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Router $router, Request $request, Application $app){
        $locale = $request->segment(1);
        if(! array_key_exists( $locale, Config::get('app.locales') )){
            $locale =  Config::get('app.locale');
            $app->setLocale($locale);
            $router->group(['namespace' => $this->namespace, 'prefix' => '','middleware' => 'web'], function ($router) {
                require base_path('routes/web.php');
            });

        } else {
            $app->setLocale($locale);
            $router->group(['namespace' => $this->namespace, 'prefix' => $locale,'middleware' => 'web' ],
                function ($router) {
                    require base_path('routes/web.php');
                });
        }
        view()->share('lang_data',['ru'=>'ru','ro'=>'ro']);
        //$this->mapWebRoutes($router);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
