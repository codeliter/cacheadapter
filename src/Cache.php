<?php
/**
 * Created by PhpStorm.
 * User: abolarin
 * Date: 8/3/17
 * Time: 5:02 AM
 */

namespace Codeliter\CacheAdapter;

use Nette\Caching\Cache as NetteCache;
use Nette\Caching\Storages\FileStorage as NetteCacheStorage;


class Cache implements CacheInterface
{
    /**
     * The caching object
     * @var
     */
    protected $cache;

    /**
     * Initialize everything to make the Caching work
     * Cache constructor.
     * @param $cache_save_path
     * @throws \Error
     */
    public function __construct($cache_save_path)
    {
        // If the path is empty
        if (strlen($cache_save_path) == 0)
            throw new \Error('Please set a valid path to store cache in');

        // If the Cache storage does not exist
        if (!file_exists($cache_save_path))
            throw new \Error('Cache save path could not be opened!');

        // Set the storage
        $storage = new NetteCacheStorage($cache_save_path);

        // Initialize the Cache
        $this->cache = new NetteCache($storage);
    }

    /**
     * Save an Item to cache
     * This would overwrite any item with the same name in the cache
     * @param $cache_name
     * @param $cache_data
     * @param $expires
     */
    public function save($cache_name, $cache_data, $expires = '')
    {
        // Set an Extra parameter holder
        $extra = [];
        // If the Expiry time is set
        if (isset($expires))
            $extra = [NetteCache::EXPIRE => $expires];
        // Save the Item to cache
        $this->cache->save($cache_name, $cache_data, $extra);
    }

    /**
     * This fetches the data for a cache with the specified key
     * @param $cache_name
     * @return mixed
     * @throws \Error
     */
    public function get($cache_name)
    {
        $value = $this->cache->load($cache_name);

        // If the Cache does not exist
        if ($value === null) {
            throw new \Error('Cache item was does not exist');
        }

        return $value;
    }


    /**
     * Delete an Item from cache
     * @param $cache_name
     * @return bool
     */
    public function delete($cache_name)
    {
        $this->cache->remove($cache_name);
        return true;
    }
}