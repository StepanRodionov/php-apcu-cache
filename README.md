[![Latest Stable Version](https://poser.pugx.org/stepanrodionov/php-apcu-cache/version)](https://packagist.org/packages/stepanrodionov/php-apcu-cache)
[![Latest Unstable Version](https://poser.pugx.org/stepanrodionov/php-apcu-cache/v/unstable)](//packagist.org/packages/stepanrodionov/php-apcu-cache)
[![License](https://poser.pugx.org/stepanrodionov/php-apcu-cache/license)](https://packagist.org/packages/stepanrodionov/php-apcu-cache)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/29423005a7124bcf8782eb6254929d63)](https://www.codacy.com/app/pandmitr/php-apcu-cache?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=StepanRodionov/php-apcu-cache&amp;utm_campaign=Badge_Grade)

# php-apcu-cache (PSR-16)
This is [PSR-16](https://www.php-fig.org/psr/psr-16/) compatible cache library using php-apcu module.
It's provides one class ApcuCacheStorage which implements ```Psr\SimpleCache\CacheInterface``` and may be used in your code everywhere, where 
php cache is need.

## About apcu
Php-apcu provides in-memory cache, which stores variables between requests. You can read more about it in [this page](http://php.net/manual/en/ref.apcu.php).

## Usage
You should create instance of ApcuCacheStorage and when you'll get access to its functionality

```php
$cache = new SR\Cache\ApcuCacheStorage();

//  store variable with ttl
$success = $cache->set('key', $variable, 3600);

//  get variable
$variable = $cache->get('key');

//  'key' will be overwritten
$cache->set('key', $anotherVar, 3600);

//  deleting one cached variable and all of them
$cache->delete('key');
$cache->clear();

// dealing with multiple data
$cache->getMultiple([
    'key', 
    'key1',
]);
$cache->setMultiple([
    'key' => 'value',
    'key1' => 'value1',
]);
$cache->deleteMultiple([
    'key', 
    'key1',
]);

//  check if variable exists
$isVarCached = $cache->has('key');
```

## Tests

Run `composer test`.

## License

This component is under the MIT license. See the complete license in the [LICENSE](./LICENSE) file.
