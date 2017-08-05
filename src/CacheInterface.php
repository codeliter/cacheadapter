<?php
namespace Codeliter\CacheAdapter;


interface CacheInterface
{
    public function __construct($cache_save_path);


    /**
     * Save an Item to Cache
     * @param $cache_name
     * @param $cache_data
     * @param $expires
     */
    public function save($cache_name, $cache_data, $expires);

    /**
     * Get an item from Cache
     * @param $cache_name
     * @return mixed
     */
    public function get($cache_name);

    /**
     * Delete an Item from cache
     * @return bool
     */
    public function delete($cache_name);
}