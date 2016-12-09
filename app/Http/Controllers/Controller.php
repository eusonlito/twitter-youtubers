<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models;
use DB;

class Controller extends BaseController
{
    protected static function page($template, $params = [])
    {
        return view('pages.'.$template, $params);
    }

    public function index(Request $request)
    {
        view()->share([
            'STAT' => $request->input('stat')
        ]);

        switch ($request->input('stat')) {
            case 'profile-shares': return $this->profileShares();
            case 'url-shares':     return $this->urlShares();
            case 'media-links':    return $this->mediaLinks();
            case 'media-shares':   return $this->mediaShares();
        }

        return self::page('index', [
            'profiles' => DB::table('profile')->count(),
            'followers' => DB::table('profile_relation')->where('relation', 'follower')->count(),
            'followings' => DB::table('profile_relation')->where('relation', 'following')->count(),
            'statuses' => DB::table('status')->count(),
            'medias' => DB::table('media')->count(),
            'urls' => DB::table('url')->count(),
            'shares' => DB::table('url_status')->count(),
        ]);
    }

    private function profileShares()
    {
        return self::page('profile-shares', [
            'stats' => Models\Profile::topShares(200)
        ]);
    }

    private function urlShares()
    {
        return self::page('url-shares', [
            'stats' => Models\Url::topShares(200)
        ]);
    }

    private function mediaLinks()
    {
        return self::page('media-links', [
            'stats' => Models\Media::topLinks(100)
        ]);
    }

    private function mediaShares()
    {
        return self::page('media-shares', [
            'stats' => Models\Media::topShares(100)
        ]);
    }
}