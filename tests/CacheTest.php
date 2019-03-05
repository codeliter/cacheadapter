<?php 

/**
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author Abolarin Stephen <cod3liter@gmail.com>
*/

use Codeliter\CacheAdapter\Cache;

class CacheTest extends PHPUnit_Framework_TestCase{
    const CACHE_SAVE_PATH = __DIR__ . "/data/cache/";
    private $cache;

    function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->cache = new Cache(self::CACHE_SAVE_PATH);
    }

    /**
     * Test if it can save a cache to filesystem
     */
    function test_it_can_save() {
        $this->cache->save('test_cache','Hello','12 Hours');
        $this->assertEquals('Hello',$this->cache->get('test_cache'));
    }

    /**
     * Test if it can get a saved cache
     */
    function test_it_can_get() {
        $cache_data = $this->cache->get('test_cache');
        $this->assertEquals('Hello', $cache_data);
    }

    /**
     * Test if a cache data can be deleted
     */
    function test_it_can_delete() {
        $delete_cache = $this->cache->delete('test_cache');
        $this->assertTrue($delete_cache);
    }
}