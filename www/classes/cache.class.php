<?php
// least recently used cache class in PHP
// by: Stephen Phillips
// 14/08/2022
//
// This class is used to store and retrieve data from a cache.
// Allows up to 10 items to be in the cache at all times. Evicting the least recently used items
//
// Stores cached items persistently across requests using files

class Cache {
    private $cache = [];
    private $cache_file = 'cache.txt';
    private $cache_dir = 'cache';
    private $cache_size = 10;
    private $cache_count = 0;

    public function __construct() {
        $this->cache = $this->get_cache();
    }

    // Two public methods get($key) and set($key, $value) (obviously as many private/protected methods are required)
    public function get($key) {
        // get cached item if it exists
        if (isset($this->cache[$key])) {
            $this->cache[$key]['last_used'] = time();
            $this->save_cache();
            return $this->cache[$key]['value'];
        }
        return null;
    }
    // Comparison function
    private function cmp($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }    
    // keys are expected to be integer numeric values only
    public function set($key, $value) {
        if (isset($this->cache[$key])) {
            $this->cache[$key]['value'] = $value;
            $this->cache[$key]['last_used'] = time();
        } else {
            // check if the cache is full
            if ($this->cache_count >= $this->cache_size) {
                // find and remove the least recently used item
                uasort($this->cache, function ($a, $b) {
                    return $this->cmp($a['last_used'], $b['last_used']);
                });
                // remove the least recently used item
                reset( $this->cache );
                unset( $this->cache[ key($this->cache)]);
                // reduce the number of items in the cache
                $this->cache_count--;
            }
            // add the new item to the cache
            $this->cache[$key] = [
                'value' => $value,
                'last_used' => time()
            ];
            $this->cache_count++;
        }
        $this->save_cache();
    }

    // Private method to get the cache from the cache file
    private function get_cache() {
        if (file_exists($this->cache_file)) {
            $cache = file_get_contents($this->cache_file);
            $cache = unserialize($cache);
            $this->cache_count = count($cache);
            return $cache;
        }
        return [];
    }

    // Private method to save the cache to the cache file
    private function save_cache() {
        $cache = serialize($this->cache);
        file_put_contents($this->cache_file, $cache);
    }
    // Public method to get cached items to test
    public function get_cached_items() {
        // save the cache
        return $this->cache;
    }    
}


?>