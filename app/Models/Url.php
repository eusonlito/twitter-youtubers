<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Url extends Model
{
    protected $table = 'url';
    public static $foreign = 'url_id';

    protected static $urls = [];

    public static function topShares($limit)
    {
        return DB::select('
            SELECT `url`.`id`, `url`.`url`, `counter`.`count`
            FROM `url`
            JOIN (
                SELECT `url_id`, COUNT(`url_id`) AS `count`
                FROM `url_status`
                GROUP BY `url_id`
                ORDER BY `count` DESC
                LIMIT '.(int)$limit.'
            ) AS `counter`
            WHERE `url`.`id` = `counter`.`url_id`
            ORDER BY `counter`.`count` DESC, `url`.`url` ASC;
        ');
    }

    public static function profile($id)
    {
        return DB::select('
            SELECT `url`.`id`, `url`.`url`
            FROM `url`
            JOIN `status` ON (`status`.`profile_id` = "'.(int)$id.'")
            JOIN `url_status` ON (`url_status`.`status_id` = `status`.`id`)
            WHERE `url`.`id` = `url_status`.`url_id`
            GROUP BY `url`.`url`
            ORDER BY `url`.`url` ASC
        ');
    }

    public static function insertIgnore($status_id, $url)
    {
        $media_id = Media::insertIgnore($url);
        $url_id = self::getUrlId($url);

        if ($url_id === null) {
            DB::statement('
                INSERT IGNORE INTO `url`
                SET
                    `url` = :url,
                    `media_id` = :media_id;
            ', [
                'url' => $url,
                'media_id' => $media_id
            ]);

            self::$urls[$url] = $url_id = DB::getPdo()->lastInsertId();
        }

        DB::statement('
            INSERT IGNORE INTO `url_status`
            SET
                `url_id` = :url_id,
                `status_id` = :status_id;
        ', [
            'url_id' => $url_id,
            'status_id' => $status_id
        ]);
    }

    private static function getUrlId($url)
    {
        if (empty(self::$urls[$url])) {
            self::$urls = DB::table('url')->get()->keyBy('url')->map(function($value) {
                return $value->id;
            })->toArray();
        }

        return self::$urls[$url] ?? null;
    }
}
