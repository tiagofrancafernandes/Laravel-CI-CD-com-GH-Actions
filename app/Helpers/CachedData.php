<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CachedData
{
    /**
     * function cachedByModel
     *
     * @param string $model
     * @param array $columns
     * @param array $with
     * @param int $ttl
     *
     * @return mixed
     */
    public static function cachedByModel(
        string $model,
        array $columns = [],
        array $with = [],
        int $ttl = 120,
    ): EloquentCollection|Collection {
        $ttl = $ttl > 0 ? $ttl : 120;

        $prefix = static::prefixByClass($model);
        $cacheKey = [$prefix];
        $columns = \array_filter(\array_values($columns), 'is_string');

        $query = $model::query();

        if ($with) {
            $cacheKey = [...$cacheKey, 'with:' . \implode(
                ',',
                \array_filter(\array_keys($with), 'is_string')
            )];

            $query = $query->with($with);
        }

        $columns = $columns ?: ['*'];

        if ($columns) {
            $cacheKey = [...$cacheKey, 'select:' . \implode(',', $columns)];

            $query = \in_array('*', $columns) ? $query : $query->select(\array_values($columns));
        }

        $cacheKey = implode('|', $cacheKey);

        static::addKeyToList($model, $cacheKey);

        return Cache::remember(
            $cacheKey,
            $ttl /*secs*/,
            fn () => $query->get()
        );
    }

    /**
     * function cacheKeysByClass
     *
     * @param string $class
     * @return array
     */
    public static function cacheKeysByClass(string $class): array
    {
        $prefix = static::prefixByClass($class);

        if (!$prefix) {
            return [];
        }

        return (array) cache::get("keys_for_{$prefix}", []);
    }

    /**
     * function addKeyToList
     *
     * @param string $class
     * @param string $key
     *
     * @return bool
     */
    public static function addKeyToList(string $class, string $key): bool
    {
        $class = trim($class);
        $key = trim($key);
        $prefix = static::prefixByClass($class);

        if (!$key || !$class || !$prefix) {
            return false;
        }

        $keys = (array) static::cacheKeysByClass($class, []);
        $keys[] = $key;
        $keys = (array) \array_unique(\array_values($keys));

        return (bool) cache::put("keys_for_{$prefix}", $keys);
    }

    /**
     * function prefixByClass
     *
     * @param string $class
     * @return string
     */
    public static function prefixByClass(string $class): string
    {
        $class = \trim($class);

        if (!$class) {
            return '';
        }

        return str_replace(["\\"], '_', $class);
    }

    /**
     * function clearAllDataByClass
     *
     * @param string $class
     * @return void
     */
    public static function clearAllDataByClass(string $class): void
    {
        foreach (static::cacheKeysByClass($class) as $key) {
            if (!$key || !\is_string($key)) {
                continue;
            }

            cache::forget($key);
        }
    }
}
