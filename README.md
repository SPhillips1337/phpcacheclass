# phpcacheclass
// least recently used cache class in PHP
// by: Stephen Phillips
// 14/08/2022

A simple file based cache using a PHP class which handles this serializing and unserialising data to a file 'cache.txt' in order to persist it.

This class is used to store and retrieve data from a cache.
Allows up to 10 items by default to be in the cache at all times. Evicting the least recently used items
Stores cached items persistently across requests using files

Note
----
Included in these files is a docker-compose.yml file which will start a minimal simple web server pointed at the included www folder here.
To launch it simply enter the command 'docker-compose up -d' in a terminal if you have docker compose setup on your system. 
(I used docker desktop on windows 10 with WSL Ubuntu to develop this)

The Cache class file called 'cache.class.php' is found in the folder classes under /www 

The PHP Cache class has the two public properties and methods.

Two public methods get($key) and set($key, $value) both these two methods will update the value `last_used` for the cache item with the specified key which will then affect the LRU to decide if an item gets evicted from the cache.

The method set checks to see if the cache item key exists and adds or updates it, If we already have 10 items in the cache it will expire the LRU before adding the new item.

I added a further public function to get the current cached items for testing purposes.

The file test.cache.php runs a number of tests of the functions of the class to show that it is working correctly and as expected.


Files
-----
www/
	test.cache.php
	classes/
		cache.class.php - PHP Class to cache data serialised in a file.
    
* The files were created as part of a technical test as part of an interview for a role with a company.
