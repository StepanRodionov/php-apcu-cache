# php-apcu-cache
This is PSR-6 compatible cache library using php-apcu module.
It's provides one class ApcuStorage which implements ```Psr\SimpleCache\CacheInterface``` and may be used in your code everywhere, where 
php cache is need.

About apcu
---
Php-apcu provides in-memory cache, which stores variables between requests. You can read more about it in this page http://php.net/manual/en/ref.apcu.php

Usage
---
You should create instance of ApcuStorage and when you'll get access to its functionality

```php
$cacheManager = new SR\Cache\ApcuStorage();

//  store variable with ttl
$success = $cacheManager->set('key', $variable, 3600);

//  get variable
$variable = $cacheManager->get('key');

//  'key' will be overwritten
$cacheManager->set('key', $anotherVar, 3600);

//  deleting one cached variable and all of them
$cacheManager->delete('key');
$cacheManager->clear();

// dealing with multiple data
$cacheManager->getMultiple([
    'key', 
    'key1',
]);
$cacheManager->setMultiple([
    'key' => 'value',
    'key1' => 'value1',
]);
$cacheManager->deleteMultiple([
    'key', 
    'key1',
]);

//  check if variable exists
$isVarCached = $cacheManager->has('key');
```