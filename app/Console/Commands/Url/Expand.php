<?php
namespace App\Console\Commands\Url;

use Illuminate\Console\Command;
use App\Models;
use App\Services\Url\Url as UrlService;

class Expand extends Command
{
    protected $name        = 'url-expand';
    protected $description = 'Expand shorted URLs';

    public function handle()
    {
        foreach (Models\Url::get() as $row) {
            $this->parse($row);
        }
    }

    private function parse($url)
    {
        $expanded = UrlService::getReal($url->url);

        if (empty($expanded) || ($expanded === $url->expanded)) {
            return;
        }

        $url->expanded = $expanded;
        $url->save();
    }
}
