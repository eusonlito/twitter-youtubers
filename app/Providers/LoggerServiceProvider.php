<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class LoggerServiceProvider extends ServiceProvider
{
    private $log = 'logs/query.log';

    public function register()
    {
        if (!env('APP_DEBUG')) {
            return;
        }

        $this->log = storage_path($this->log);

        if (is_file($this->log)) {
            unlink($this->log);
        }

        DB::listen(function($sql) {
            file_put_contents($this->log,
                "\n\n\n----------- ".date('Y-m-d H:i:s')." -----------".
                "\nSQL: ".$sql->sql.
                "\nBINDINGS: ".json_encode($sql->bindings)
            , FILE_APPEND);
        });
    }
}
