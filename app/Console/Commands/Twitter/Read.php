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
        foreach ($this->twitter->getFollowers($profile->id, $this->limitFollowers) as $related) {
            Models\Profile::insertIgnore($related, $profile->id, 'follower');

            $this->loadFollowing($related);
        }
    }

    private function loadFollowing($profile)
    {
        foreach ($this->twitter->getFollowing($profile->id, $this->limitFollowing) as $related) {
            Models\Profile::insertIgnore($related, $profile->id, 'following');

            $this->loadTimeline($related);
        }
    }

    private function loadTimeline($profile)
    {
        foreach ($this->twitter->getTimeline($profile->id, $this->limitTimeline) as $status) {
            Models\Status::insertIgnore($status);
        }
    }
}
