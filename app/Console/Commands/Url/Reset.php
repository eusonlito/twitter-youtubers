<?php
namespace App\Console\Commands\Url;

use DB;
use Illuminate\Console\Command;
use App\Models;
use App\Services\Url\Short;

class Reset extends Command
{
    protected $name        = 'url-reset';
    protected $description = 'Reset URLs to regenerate';

    public function handle()
    {
        $this->resetMedia();

        foreach (Models\Url::get() as $row) {
            $this->parse($row);
        }
    }

    private function resetMedia()
    {
        DB::statement('SET foreign_key_checks=0');

        Models\Media::truncate();

        DB::statement('SET foreign_key_checks=1');
    }

    private function parse($url)
    {
        if ($url->url === $url->original) {
            $expanded = Short::getExpanded($url->original);
        } else {
            $expanded = $url->url;
        }

        $url->media_id = Models\Media::insertIgnore($expanded);

        if (empty($expanded) || ($expanded === $url->url)) {
            return;
        }

        $url->url = $expanded;
        $url->save();
    }
}
