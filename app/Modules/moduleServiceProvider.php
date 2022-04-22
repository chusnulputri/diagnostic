<?php

namespace App\Modules;

class moduleServiceProvider extends \Illuminate\Support\ServiceProvider
{

    protected $path = '';

    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */
    public function boot()
    {

        // For each of the registered modules, include their routes and Views
        $this->initiateModules('Modules');
    }

    private function initiateModules(String $path)
    {
        $filesystem = $this->app->make('files')->directories(app_path($path));

        foreach ($filesystem as $modules) {
            $truncate = str_replace('\\', '/', $modules);
            $moduleName = last(explode('/', $truncate));
            if (is_dir(app_path() . '/' . str_replace('\\', '/', $path) . '/' . $moduleName . '/Views')) {
                
                $this->loadViewsFrom(app_path() . '/' . str_replace('\\', '/', $path) . '/' . $moduleName . '/Views', $moduleName);
            } else {
                $this->initiateModules($path . DIRECTORY_SEPARATOR . $moduleName);
            }
        }
    }

    public function register()
    {

        $this->initiateProvider('Modules');
    }

    private function initiateProvider(String $path)
    {
        $filesystem = $this->app->make('files')->directories(app_path($path));
        foreach ($filesystem as $modules) {
            $truncate = str_replace('\\', '/', $modules);
            $moduleName = last(explode('/', $truncate));
            $pathProvider = str_replace('\\', '/', $path);
            if (is_dir(app_path() . '/' . str_replace('\\', '/', $path) . '/' . $moduleName . '/Providers')) {
                $path = explode(DIRECTORY_SEPARATOR, $path);
                $path = implode('\\', $path);

                $pt = "App\\{$path}\\{$moduleName}\\Providers\\routeServiceProvider";
                $this->app->register($pt);
            } else {
                $this->initiateProvider($path . DIRECTORY_SEPARATOR . $moduleName);
            }
        }
    }
}
