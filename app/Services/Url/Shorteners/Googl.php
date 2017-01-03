<?php
namespace App\Services\Url\Shorteners;

class Googl extends ShortenerInterface
{
    public static function expand($url)
    {
        return self::getHeaderLocation($url);
    }
}