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
use Nette\Caching\Storages\NewMemcachedStorage as MemCachedStorage;


class Cache implements CacheInterface
{
    /**
     * The caching object
     * @var
     */
    protected $cache;

    /**
     * @var
     */
    protected $storage;

    /**
     * Initialize everything to make the Caching work
     * Cache constructor.
     * @param string $cache_save_path
     * @throws \Error
     */
    public function __construct($cache_save_path = '')
    {
        // If Memcached module is properly installed
        if (class_exists('Memcached'))
            $type = 'MEMORY';
        else
            $type = 'FILE';
        // Set the storage
        $this->setStorageType($type, $cache_save_path);

        // If the Storage type is file type & the path is empty
        if ($type == 'FILE' && strlen($cache_save_path) == 0)
            throw new \Error('Please set a valid path to store cache in');

        // If the Storage type is file type & Cache storage does not exist
        if ($type == 'FILE' && !file_exists($cache_save_path))
            throw new \Error('Cache save path could not be opened!');

        // Initialize the Cache
        $this->cache = new NetteCache($this->storage);
    }

    /**
     * Set the storage Type
     * @param string $type
     * @param $path
     */
    private function setStorageType($type = '', $path = '')
    {
        switch ($type) {
            case 'MEMORY':
                $this->storage = new MemCachedStorage();
                break;
            default:
                $this->storage = new NetteCacheStorage($path);
                break;
        }
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
            throw new \Error('Cache item does not exist');
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