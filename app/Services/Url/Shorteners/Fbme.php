<?php
namespace App\Services\Url\Shorteners;

class Fbme extends ShortenerInterface
{
    public static function expand($url)
    {
        return self::getHeaderLocation($url);
    }
}