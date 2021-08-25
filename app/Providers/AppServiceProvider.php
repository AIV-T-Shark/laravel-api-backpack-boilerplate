<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $request_uri = \Request::getRequestUri();
        
        //admin
        $admin_prefix = '/'.config('backpack.base.route_prefix', 'admin');
        if (mb_strpos($request_uri, $admin_prefix) === 0 || $this->app->runningInConsole()) {
            $this->app->register(\Backpack\CRUD\BackpackServiceProvider::class);
            $this->app->register(\Backpack\LogManager\LogManagerServiceProvider::class);
            $this->app->register(\Backpack\PermissionManager\PermissionManagerServiceProvider::class);
    
        }
        
        //api
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
