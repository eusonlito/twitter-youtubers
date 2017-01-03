<?php
namespace App\Services\Url\Shorteners;

class Wpme extends ShortenerInterface
{
    public static function expand($url)
    {
        return self::getHeaderLocation($url);
    }
}