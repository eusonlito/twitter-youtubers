<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Status extends Model
{
    protected $table = 'status';
    public static $foreign = 'status_id';

    public static function profile($id)
    {
        return DB::select('
            SELECT `id`, `text`, `created_at`
            FROM `status`
            WHERE `profile_id` = "'.(int)$id.'"
            ORDER BY `created_at` DESC;
        ');
    }

    public static function url($id)
    {
        return DB::select('
            SELECT `status`.`id`, `status`.`text`, `status`.`created_at`,
                `status`.`profile_id`, `profile`.`hash`, `profile`.`name`
            FROM `status`
            JOIN `url_status` ON (`url_status`.`url_id` = "'.(int)$id.'")
            JOIN `profile` ON (`profile`.`id` = `status`.`profile_id`)
            WHERE `status`.`id` = `url_status`.`status_id`
            ORDER BY `status`.`created_at` DESC;
        ');
    }

    public static function insertIgnore($status)
    {
        DB::statement('
            INSERT IGNORE INTO `status`
            SET
                `id` = :id,
                `text` = :text,
                `created_at` = :created_at,
                `profile_id` = :profile_id;
        ', [
            'id' => $status->id,
            'text' => trim($status->text),
            'created_at' => date('Y-m-d H:i:s', strtotime($status->created_at)),
            'profile_id' => $status->user->id
        ]);

        foreach ($status->entities->urls as $url) {
            Url::insertIgnore($url->expanded_url, $status->id);
        }
    }
}
