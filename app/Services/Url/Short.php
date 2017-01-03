<?php
namespace App\Services\Url;

class Short
{
    private static $shorteners = [];

    public static function getExpanded($url)
    {
        while (true) {
            $expanded = self::expand($url);

            if ($expanded === $url) {
                return $expanded;
            }

            $url = $expanded;
        }
    }

    public static function expand($url)
    {
        if ($shortener = self::getShortener(parse_url($url, PHP_URL_HOST))) {
            $url = $shortener::expand($url);
        }

        return is_array($url) ? $url[0] : $url;
    }

    private static function getShortener($host)
    {
        if (empty(self::$shorteners)) {
            self::loadShorteners();
        }

        return self::$shorteners[strtolower(preg_replace('/\W/', '', $host))] ?? null;
    }

    private static function loadShorteners()
    {
        foreach (glob(__DIR__.'/Shorteners/*.php') as $file) {
            $host = strtolower(str_replace('.php', '', basename($file)));
            self::$shorteners[$host] = __NAMESPACE__.'\\Shorteners\\'.ucfirst($host);
        }
    }
}
