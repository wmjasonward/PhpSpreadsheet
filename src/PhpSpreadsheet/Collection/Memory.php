<?php

namespace PhpOffice\PhpSpreadsheet\Collection;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

/**
 * This is the default implementation for in-memory cell collection.
 *
 * Alternatives implementation should leverage off-memory, non-volatile storage
 * to reduce overall memory usage.
 */
class Memory implements CacheInterface
{
    private $cache = [];

    /**
     * @return bool
     */
    public function clear() : bool
    {
        $this->cache = [];

        return true;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete(string $key) : bool
    {
        unset($this->cache[$key]);

        return true;
    }

    /**
     * @param iterable $keys
     *
     * @return bool
     */
    public function deleteMultiple(iterable $keys) : bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null) : mixed
    {
        if ($this->has($key)) {
            return $this->cache[$key];
        }

        return $default;
    }

    /**
     * @param iterable $keys
     * @param mixed    $default
     *
     * @return iterable
     */
    public function getMultiple(iterable $keys, mixed $default = null) : iterable
    {
        $results = [];
        foreach ($keys as $key) {
            $results[$key] = $this->get($key, $default);
        }

        return $results;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key) : bool
    {
        return array_key_exists($key, $this->cache);
    }

    /**
     * @param string                 $key
     * @param mixed                  $value
     * @param null|DateInterval|int $ttl
     *
     * @return bool
     */
    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null)
    {
        $this->cache[$key] = $value;

        return true;
    }

    /**
     * @param iterable               $values
     * @param null|DateInterval|int $ttl
     *
     * @return bool
     */
    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value);
        }

        return true;
    }
}
