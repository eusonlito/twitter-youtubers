<?php
namespace App\Services\Url\Shorteners;

class Shares extends ShortenerInterface
{
    public static function expand($url)
    {
        return self::getHeaderLocation($url);
    }
}