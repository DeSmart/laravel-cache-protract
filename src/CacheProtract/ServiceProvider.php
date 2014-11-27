<?php namespace DeSmart\CacheProtract;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->package('desmart/laravel-cache-protract');
    }
}
