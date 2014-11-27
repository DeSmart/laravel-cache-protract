<?php namespace DeSmart\CacheProtract;

use Illuminate\Cache\Repository;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    protected $defer = true;

    public function register()
    {
        $this->app['config']->package('desmart/laravel-cache-protract', __DIR__.'/../config');

        $this->app['cache']->extend('file-protract', function () {
            $path = $this->app['config']['cache.path'];
            $store = new FileStore($this->app['files'], $path);

            $config = $this->app['config']->get('laravel-cache-protract::laravel-cache-protract');

            return new Repository($store);
        });
    }

    public function when()
    {
        return ['Illuminate\\Cache\\CacheServiceProvider'];
    }
}
