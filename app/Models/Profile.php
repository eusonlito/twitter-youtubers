<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    protected $table = 'profile';
    public static $foreign = 'profile_id';

    /**
     * @return object
     */
    public function statuses()
    {
        return $this->hasMany(Status::class, self::$foreign);
    }

    /**
     * @return object
     */
    public function profiles()
    {
        return $this->belongsToMany(self::class, 'profile_relation', 'profile_id_1', 'profile_id_2');
    }

    /**
     * @return object
     */
    public function scopeMasters($q)
    {
        return $q->where('master', 1);
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
