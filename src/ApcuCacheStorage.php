<?php

declare(strict_types=1);

namespace SR\ApcuSimpleCache;

use Psr\SimpleCache\CacheInterface;

/**
 * Class ApcuStorage
 *
 * @package SR\Cache
 */
class ApcuCacheStorage implements CacheInterface
{
    /**
     * @inheritdoc
     */
    public function clear()
    {
        return \apcu_clear_cache();
    }

    /**
     * @inheritdoc
     */
    public function getMultiple($keys, $default = null)
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $this->get($key);
        }

        return $values;
    }

    /**
     * @inheritdoc
     */
    public function get($key, $default = null)
    {
        return \apcu_fetch($key);
    }

    /**
     * @inheritdoc
     */
    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl ?? 0);
        }
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value, $ttl = null)
    {
        return \apcu_store($key, $value, $ttl ?? 0);
    }

    /**
     * @inheritdoc
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    /**
     * @inheritdoc
     */
    public function delete($key)
    {
        return \apcu_delete($key);
    }

    /**
     * @inheritdoc
     */
    public function has($key)
    {
        return \apcu_exists($key);
    }
}
