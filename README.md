[![Build Status](https://api.travis-ci.org/DeSmart/laravel-cache-protract.png)](https://travis-ci.org/DeSmart/laravel-cache-protract)

# laravel-cache-protract

File based cache prolonger for Laravel.

# Background

Laravel's file cache is rather simple. When it's expired the cache file is removed. Depending on implementation this cache gets regenerated during the request. 

On heavy loaded applications this means that during the time of regeneration every request bumps into empty cache file and tries to regenerate it. This gap can lead to DoS - application will stop to respond.

This package is meant to lower the risk of that. Request hits expired cache, prolongs its expiration and in the meantime tries to regenerate the cache. For the time of regeneration other threads will get old contents.

# Installation

```bash
composer require desmart/laravel-cache-protract:~1.0.0
```

In `app/config/app.php` add `DeSmart\CacheProtract\ServiceProvider` to providers.

In `app/config/cache.php` change driver to `file-protract`.

Optionally you can publish, and change config file.
