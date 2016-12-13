<?php
namespace App\Console\Commands\Twitter;

use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

use App\Models;
use App\Services\Console\Locker;
use App\Services\Twitter\Twitter;

class Read extends Command
{
    protected $name        = 'twitter-read';
    protected $description = 'Read Twitter Profiles';

    protected $limitFollowers = 0;
    protected $limitFollowing = 0;
    protected $limitTimeline  = 0;

    protected $twitter;

    public function handle()
    {
        try {
            Locker::check(__FILE__);
        } catch (Exception $e) {
            return $this->setError($e);
        }

        $this->limitFollowers = env('LIMIT_FOLLOWERS');
        $this->limitFollowing = env('LIMIT_FOLLOWING');
        $this->limitTimeline  = env('LIMIT_TIMELINE');

        $this->twitter = new Twitter;

        foreach (DB::table('profile')->where('master', 1)->get() as $profile) {
            $this->loadFollowers($profile);
        }
    }

    private function loadFollowers($profile)
    {
        $limit = $this->limitFollowers - DB::table('profile_relation')
            ->where('profile_id_1', $profile->id)
            ->where('relation', 'follower')
            ->count();

        if ($limit <= 0) {
            return;
        }

        foreach ($this->twitter->getFollowers($profile->id, $limit) as $related) {
            Models\Profile::insertIgnore($related, $profile->id, 'follower');

            $this->loadFollowing($related);
        }
    }

    private function loadFollowing($profile)
    {
        $limit = $this->limitFollowing - DB::table('profile_relation')
            ->where('profile_id_1', $profile->id)
            ->where('relation', 'following')
            ->count();

        if ($limit <= 0) {
            return;
        }

        foreach ($this->twitter->getFollowing($profile->id, $limit) as $related) {
            Models\Profile::insertIgnore($related, $profile->id, 'following');

            $this->loadTimeline($related);
        }
    }

    private function loadTimeline($profile)
    {
        $limit = $this->limitTimeline - DB::table('status')->where('profile_id', $profile->id)->count();

        if ($limit <= 0) {
            return;
        }

        foreach ($this->twitter->getTimeline($profile->id, $limit) as $status) {
            Models\Status::insertIgnore($status);
        }
    }

    private function setError(Exception $e)
    {
        echo '['.date('Y-m-d H:i:s').']'
            .' ['.str_replace(base_path(), '', $e->getFile()).' | '.$e->getLine().']'
            .' '.$e->getMessage()."\n";
    }
}
