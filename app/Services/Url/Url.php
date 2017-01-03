<?php
namespace App\Services\Url;

class Url
{
    public static function getReal($url)
    {
        switch (parse_url($url, PHP_URL_HOST)) {
            case 'bit.ly':
                $url = Bitly::expand($url);
                break;

            case 'fb.me':
                $url = Fbme::expand($url);
                break;

            case 'goo.gl':
                $url = Googl::expand($url);
                break;

            case 'ow.ly':
                $url = Owly::expand($url);
                break;

            case 'shar.es':
                $url = Shares::expand($url);
                break;
        }

        return is_array($url) ? $url[0] : $url;
    }
}
