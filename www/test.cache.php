<?php
// This is a simple PHP script to test using the two public properties and methods of the Cache class.
// The script will create a cache file if it doesn't exist, and will read the cache file if it does exist.
// The script will then add and retrieve items to the cache.
// by: Stephen Phillips
// 14/08/2022

// turn on error reporting to help spot errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// for the sake of this example, we're going to use a cache file to store the cache
// lets clear the cache file if it exists (You can comment this out if you don't want to clear the cache file to check persistence)
if (file_exists('cache.txt')) {
    unlink('cache.txt');
}

// include the cache class
require_once 'classes/cache.class.php';
// declare a new cache object
$cache = new Cache();

echo "<h1>Testing the Cache class</h1>";
echo "<p>The cache file is located at <strong>cache.txt</strong></p>";
echo "<p>The maximumcache size is set to <strong>10</strong> items</p>";
echo "<p>This test script makes use of the PHP sleep command when setting items to force a unique timestamp to use to find LRU</p>";
echo "<p>The cache item timestamp is updated each time the item is accessed via get or set</p>";

echo "<hr>";

echo "Setting cache items 1 to 10<br>";

echo "<hr>";

// set 10 items in the cache
$cache->set(0, 'value1');
sleep(1);
$cache->set(1, 'value2');
sleep(1);
$cache->set(2, 'value3');
sleep(1);
$cache->set(3, 'value4');
sleep(1);
$cache->set(4, 'value5');
sleep(1);
$cache->set(5, 'value6');
sleep(1);
$cache->set(6, 'value7');
sleep(1);
$cache->set(7, 'value8');
sleep(1);
$cache->set(8, 'value9');
sleep(1);
$cache->set(9, 'value10');

// using sleep to change time value between requestsd
sleep(1);

echo "<hr>";

echo "Getting cached items 1 to 10<br>";

echo "<hr>";

// get 10 items from the cache
$items = $cache->get_cached_items();
// list all items in the cache to check using a for loop
$count = 1;
foreach ($items as $key => $item) {
    echo "#$count - ";
    $count++;    
    echo "Key: ".$key."<br>";
    echo "Value: ".$item['value']."<br>";
    echo "Last Used: ".$item['last_used']."<br><br>";
    
}

// using sleep to change time value between requestsd
sleep(1);

echo "Setting cache item key 11 to replace LRU<br>";

echo "<hr>";

// set another item in the cache to test if the cache is full
$cache->set(10, 'value11');

// using sleep to change time value between requestsd
sleep(1);

echo "Getting new list of cached including item key 11 after LRU item was replaced as least recently used based on time<br>";

echo "<hr>";

// get 10 items from the cache
$items = $cache->get_cached_items();
// list all items in the cache to check using a for loop
$count = 1;
foreach ($items as $key => $item) {
    echo "#$count - ";
    $count++;  
    echo "Key: ".$key."<br>";
    echo "Value: ".$item['value']."<br>";
    echo "Last Used: ".$item['last_used']."<br><br>";
    
}

// using sleep to change time value between requestsd
sleep(1);

// setting new items in the cache to test if the cache is full

echo "<hr>";

echo "Updating Cached items with keys 1 to 8 so that item key 1 is now the least recently used<br>";

echo "<hr>";

$cache->set(1, 'new value1');
$cache->set(2, 'new value2');
$cache->set(3, 'new value3');
$cache->set(4, 'new value4');
$cache->set(5, 'new value5');
$cache->set(6, 'new value6');
$cache->set(7, 'new value7');
$cache->set(8, 'new value8');


// using sleep to change time value between requestsd
sleep(1);

echo "<hr>";
echo "Setting cache item key 12 to replace LRU item<br>";

echo "<hr>";

// set another item in the cache to test if the cache is full
$cache->set(12, 'value12');

// using sleep to change time value between requestsd
sleep(1);

echo "Getting new list of cached including item key 12 after LRU item was replaced as least used based on time<br>";

echo "<hr>";

// get 10 items from the cache
$items = $cache->get_cached_items();

// list all items in the cache to check using a for loop
$count = 1;
foreach ($items as $key => $item) {
    echo "#$count - ";
    $count++;  
    echo "Key: ".$key."<br>";
    echo "Value: ".$item['value']."<br>";
    echo "Last Used: ".$item['last_used']."<br><br>";
    
}

?>
