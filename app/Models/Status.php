<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Status extends Model
{
    protected $table = 'status';
    public static $foreign = 'status_id';

    /**
     * @return object
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, Profile::$foreign);
    }

    /**
     * @return object
     */
    public function links()
    {
        return $this->hasMany(Url::class, self::$foreign);
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
            Url::insertIgnore($status->id, $url->expanded_url);
        }
    }
}
