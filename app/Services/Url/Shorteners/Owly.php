<?php
namespace App\Services\Url\Shorteners;

class Owly extends ShortenerInterface
{
    public static function expand($url)
    {
        return self::getHeaderLocation($url);
    }
}