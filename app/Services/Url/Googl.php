<?php
namespace App\Services\Url;

class Googl
{
    public static function expand($url)
    {
        return get_headers($url, 1)['Location'] ?? $url;
    }
}
