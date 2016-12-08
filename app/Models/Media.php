<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Media extends Model
{
    protected $table = 'media';
    public static $foreign = 'media_id';

    protected static $medias = [];

    /**
     * @return object
     */
    public function links()
    {
        return $this->hasMany(Url::class, self::$foreign);
    }

    public static function insertIgnore($url)
    {
        $domain = self::fixDomain($url);

        if ($media_id = self::getMediaId($domain)) {
            return $media_id;
        }

        DB::statement('
            INSERT IGNORE INTO `media`
            SET `domain` = :domain;
        ', ['domain' => $domain]);

        return self::$medias[$domain] = DB::getPdo()->lastInsertId();
    }

    private static function getMediaId($domain)
    {
        if (empty(self::$medias[$domain])) {
            self::$medias = DB::table('media')->get()->keyBy('domain')->map(function($value) {
                return $value->id;
            })->toArray();
        }

        return self::$medias[$domain] ?? null;
    }

    private static function fixDomain($url)
    {
        $domain = str_replace('www.', '', strtolower(parse_url($url, PHP_URL_HOST)));
        $domain = str_replace('youtu.be', 'youtube.com', $domain);

        return preg_replace('/^m\./', '', $domain);
    }
}
