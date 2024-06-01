<?php

namespace App\Http\Controllers\Factories\Cache;

interface CacheFactory {
    public static function get(string $key): mixed;
    public static function set(string $key, mixed $value): bool;
    public static function remove(string $key): bool;
}
