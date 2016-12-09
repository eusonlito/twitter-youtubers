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

    public static function topLinks($limit)
    {
        return DB::select('
            SELECT `media`.`domain`, `counter`.`count`
            FROM `media`
            JOIN (
                SELECT `media_id`, COUNT(`media_id`) AS `count`
                FROM `url`
                GROUP BY `media_id`
                ORDER BY `count` DESC
                LIMIT '.(int)$limit.'
            ) AS `counter`
            WHERE `media`.`id` = `counter`.`media_id`
            ORDER BY `counter`.`count` DESC, `media`.`domain` ASC;
        ');
    }

    public static function topShares($limit)
    {
        return DB::select('
            SELECT `media`.`domain`, `counter`.`count`
            FROM `media`
            JOIN (
                SELECT `media_id`, SUM(`counter`.`count`) AS `count`
                FROM `url`
                JOIN (
                    SELECT `url_id`, COUNT(`url_id`) AS `count`
                    FROM `url_status`
                    GROUP BY `url_id`
                    ORDER BY `count` DESC
                ) AS `counter`
                WHERE `url`.`id` = `counter`.`url_id`
                GROUP BY `media_id`
                ORDER BY `count` DESC
                LIMIT '.(int)$limit.'
            ) AS `counter`
            WHERE `media`.`id` = `counter`.`media_id`
            ORDER BY `counter`.`count` DESC, `media`.`domain` ASC;
        ');
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
