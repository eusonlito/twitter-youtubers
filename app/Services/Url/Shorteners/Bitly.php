<?php
namespace App\Services\Url\Shorteners;

class Bitly extends ShortenerInterface
{
    public static function expand($url)
    {
        return self::getHeaderLocation($url);
    }
}
