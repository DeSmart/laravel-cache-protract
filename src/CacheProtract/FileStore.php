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

        if (false === $this->files->exists($path))
        {
            return null;
        }

        try
        {
            $expire = substr($contents = $this->files->get($path), 0, 10);
        }
        catch (\Exception $e)
        {
            return null;
        }

        $value = unserialize(substr($contents, 10));

        if (time() >= $expire)
        {
            $this->put($key, $value, $this->prolongTime);

            return null;
        }

        return $value;
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
