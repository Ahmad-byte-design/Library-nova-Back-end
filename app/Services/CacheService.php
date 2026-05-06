<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    protected bool $supportsTags;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
        $driver = config('cache.default');
        $this->supportsTags = in_array($driver, ['redis', 'memcached']);
    }

    public function remember(string $key, callable $callback, ?int $ttl = 360, $tags = null)
    {
        if ($this->supportsTags && $tags) {
            $tagsArray = is_array($tags) ? $tags : [$tags];

            return Cache::tags($tagsArray)->remember($key, $ttl, $callback);
        }

        return Cache::remember($key, $ttl, $callback);
    }


    public function forget($keys, $tags = null)
    {
        $keys = is_array($keys) ? $keys : [$keys];

        if ($this->supportsTags && $tags) {
            $tagsArray = is_array($tags) ? $tags : [$tags];

            return Cache::tags($tagsArray)->flush();
        } else {
            foreach ($keys as $key) {
                Cache::forget($key);
            }
        }
    }


    public function flushTags($tags)
    {
        if (! $this->supportsTags) return;
        $tagsArray = is_array($tags) ? $tags : [$tags];

        return Cache::tags($tagsArray)->flush();
    }
}
