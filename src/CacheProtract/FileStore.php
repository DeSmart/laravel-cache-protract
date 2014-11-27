<?php namespace DeSmart\CacheProtract;

class FileStore extends \Illuminate\Cache\FileStore
{

    /**
     * Prolonging time in minutes
     *
     * @var integer
     */
    protected $prolongTime = 2;

    /**
     * Retrieve an item from the cache 
     *
     * When cache file is expired its expire time will be set in future.
     * This prevents other threads to refresh the cache contents at the same time.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        $path = $this->path($key);

        if (false === $this->files->exists($path)) {
            return null;
        }

        try {
            $expire = substr($contents = $this->files->get($path), 0, 10);
        } catch (\Exception $e) {
            return null;
        }

        $serialized = substr($contents, 10);

        if (time() >= $expire) {
            // serialization is heavy - in this case it's not necessary so it's better
            // to put contents back to file rather then unserialize, and serialize back (@see self::put())
            $this->files->put($path, $this->expiration($this->prolongTime).$serialized);

            return null;
        }

        return unserialize($serialized);
    }

    /**
     * Sets the prolonging time
     *
     * @param integer $time prolonging time in minutes
     */
    public function setProlongTime($time)
    {
        $this->prolongTime = $time;
    }
}
