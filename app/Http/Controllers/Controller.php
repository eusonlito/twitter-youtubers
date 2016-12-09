<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models;
use DB;

class Controller extends BaseController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        view()->share([
            'SECTION' => $request->route()[1]['as']
        ]);
    }

    protected static function page($template, $params = [])
    {
        return view('pages.'.$template, $params);
    }

    public function index()
    {
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

    public function profileShares()
    {
        return self::page('profile-shares', [
            'stats' => Models\Profile::topShares(200)
        ]);
    }

    public function profile($id)
    {
        return self::page('profile', [
            'profile' => Models\Profile::find($id),
            'urls' => Models\Url::profile($id),
            'statuses' => Models\Status::profile($id)
        ]);
    }

    public function urlShares()
    {
        return self::page('url-shares', [
            'stats' => Models\Url::topShares(200)
        ]);
    }

    public function url($id)
    {
        return self::page('url', [
            'url' => Models\Url::find($id),
            'statuses' => Models\Status::url($id)
        ]);
    }

    public function mediaLinks()
    {
        return self::page('media-links', [
            'stats' => Models\Media::topLinks(100)
        ]);
    }

    public function mediaShares()
    {
        return self::page('media-shares', [
            'stats' => Models\Media::topShares(100)
        ]);
    }
}