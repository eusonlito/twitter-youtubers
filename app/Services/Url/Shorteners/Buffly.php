<?php
namespace App\Services\Url\Shorteners;

class Buffly extends ShortenerInterface
{
    public static function expand($url)
    {
        return self::getHeaderLocation($url);
    }
}
