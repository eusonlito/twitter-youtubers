<?php
namespace App\Models;

class Cursor extends Model
{
    protected $table = 'cursor';

    public static function previous($request, $profile_id)
    {
        $cursor = self::where('request', $request)->where('profile_id', $profile_id)->first();

        if (empty($cursor)) {
            $cursor = new self;

            $cursor->request = $request;
            $cursor->profile_id = $profile_id;
            $cursor->cursor = -1;
        }

        return $cursor;
    }
}
