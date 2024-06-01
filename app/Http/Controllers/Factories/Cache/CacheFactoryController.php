<?php

namespace App\Http\Controllers\Factories\Cache;

use App\Http\Controllers\Controller;

class CacheFactoryController extends Controller implements CacheFactory {
    static int $CacheTime = 60 * 24;

    public static function get(string $key): mixed {
        return cache()->get($key);
    }

    public static function set(string $key, mixed $value): bool {
        return cache()->put($key, $value, self::$CacheTime);
    }

    public static function remove(string $key): bool{
        return cache()->delete($key);
    }
}
