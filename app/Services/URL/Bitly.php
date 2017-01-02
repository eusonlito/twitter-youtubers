<?php
namespace App\Services\URL;

class Bitly
{
    public static function expand($url)
    {
        return get_headers($url, 1)['Location'] ?? $url;
    }
}
