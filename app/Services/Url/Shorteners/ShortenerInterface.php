<?php
namespace App\Services\Url\Shorteners;

use Exception;

abstract class ShortenerInterface
{
    protected static function getHeaderLocation($url)
    {
        stream_context_set_default([
            'http' => [
                'timeout' => 5
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ],
        ]);

        try {
            return get_headers($url, 1)['Location'] ?? $url;
        } catch (Exception $e) {
            return $url;
        }
    }
}
