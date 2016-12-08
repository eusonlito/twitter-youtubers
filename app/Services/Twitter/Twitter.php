<?php
namespace App\Services\Twitter;

use Illuminate\Support\Facades\Cache;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models;

class Twitter extends TwitterOAuth
{
    public function __construct()
    {
        $config = config('twitter');

        return parent::__construct(
            $config['CONSUMER_KEY'],
            $config['CONSUMER_SECRET'],
            $config['ACCESS_TOKEN'],
            $config['ACCESS_TOKEN_SECRET']
        );
    }

    public function get($path, array $parameters = [])
    {
        $key = md5(serialize(func_get_args()));

        if ($cache = Cache::get($key)) {
            return $cache;
        }

        $response = parent::get($path, $parameters);

        if (isset($response->errors)) {
            return;
        }

        Cache::forever($key, $response);

        return $response;
    }

    public function getFollowers($id, $limit)
    {
        return $this->getProfiles('followers', $id, $limit);
    }

    public function getFollowing($id, $limit)
    {
        return $this->getProfiles('friends', $id, $limit);
    }

    private function getProfiles($type, $id, $limit)
    {
        $cursor = Models\Cursor::previous($type.'/list', $id);
        $stored = 0;

        while ($cursor->cursor) {
            $list = $this->get($type.'/list', [
                'cursor' => $cursor->cursor,
                'user_id' => $id,
                'count' => 200,
                'include_user_entities' => false
            ]);

            if (empty($list->users)) {
                break;
            }

            $cursor->cursor = $list->next_cursor;

            if ($cursor->cursor) {
                $cursor->save();
            }

            foreach ($list->users as $profile) {
                if ($this->isValidProfile($profile) === false) {
                    continue;
                }

                yield $profile;

                if (++$stored >= $limit) {
                    break;
                }
            }
        }
    }

    public function isValidProfile($profile)
    {
        return ($profile->protected === false)
            && ($profile->friends_count > 50)
            && ($profile->followers_count > 20)
            && (strlen(trim($profile->description)) > 50);
    }

    public function getTimeline($id, $limit)
    {
        $stored = 0;
        $list = $this->get('statuses/user_timeline', [
            'user_id' => $id,
            'count' => 200,
            'include_rts' => true
        ]);

        if (empty($list)) {
            return [];
        }

        foreach ($list as $status) {
            if ($this->isValidStatus($status) === false) {
                continue;
            }

            yield $status;

            if (++$stored >= $limit) {
                break;
            }
        }
    }

    private function isValidStatus($status)
    {
        if ($status->lang !== 'es') {
            return false;
        }

        foreach ($status->entities->urls as $url) {
            if ($this->isValidUrl($url->expanded_url)) {
                return true;
            }
        }

        return false;
    }

    private function isValidUrl($url)
    {
        return (strpos($url, 'https://twitter.com/') !== 0);
    }
}
