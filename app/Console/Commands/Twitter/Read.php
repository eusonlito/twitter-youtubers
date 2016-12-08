<?php
namespace App\Console\Commands\Twitter;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

use App\Models;
use App\Services\Twitter\Twitter;

class Read extends Command
{
    protected $name        = 'twitter-read';
    protected $description = 'Read Twitter Profiles';

    protected $limitFollowers = 200;
    protected $limitFollowing = 50;
    protected $limitTimeline  = 50;

    protected $twitter;

    public function handle()
    {
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
}
