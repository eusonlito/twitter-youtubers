<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    protected $table = 'profile';
    public static $foreign = 'profile_id';

    public static function topShares($limit)
    {
        return DB::select('
            SELECT `profile`.`id`, `profile`.`hash`, `profile`.`name`, `counter`.`count`
            FROM `profile`
            JOIN (
                SELECT `profile_id`, SUM(`counter`.`count`) AS `count`
                FROM `status`
                JOIN (
                    SELECT `status_id`, COUNT(`status_id`) AS `count`
                    FROM `url_status`
                    GROUP BY `status_id`
                    ORDER BY `count` DESC
                ) AS `counter`
                WHERE `status`.`id` = `counter`.`status_id`
                GROUP BY `profile_id`
                ORDER BY `count` DESC
                LIMIT '.(int)$limit.'
            ) AS `counter`
            WHERE `profile`.`id` = `counter`.`profile_id`
            ORDER BY `counter`.`count` DESC, `profile`.`name` ASC;
        ');
    }

    public static function insertIgnore($profile, $master_id = null, $relation = null)
    {
        DB::statement('
            INSERT IGNORE INTO `profile`
            SET
                `id` = :id,
                `hash` = :hash,
                `name` = :name,
                `description` = :description,
                `created_at` = :created_at;
        ', [
            'id' => $profile->id,
            'hash' => $profile->screen_name,
            'name' => $profile->name,
            'description' => trim($profile->description),
            'created_at' => date('Y-m-d H:i:s', strtotime($profile->created_at))
        ]);

        if ($master_id && $relation) {
            self::relate($master_id, $profile->id, $relation);
        }
    }

    public static function relate($profile_id_1, $profile_id_2, $relation)
    {
        DB::statement('
            INSERT IGNORE INTO `profile_relation`
            SET
                `profile_id_1` = :profile_id_1,
                `profile_id_2` = :profile_id_2,
                `relation` = :relation
        ', [
            'profile_id_1' => $profile_id_1,
            'profile_id_2' => $profile_id_2,
            'relation' => $relation
        ]);
    }
}
