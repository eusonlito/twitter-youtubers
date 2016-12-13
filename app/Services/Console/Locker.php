<?php
namespace App\Services\Console;

use Exception;

class Locker
{
    public static function check($file)
    {
        if (PHP_SAPI !== 'cli') {
            throw new Exception('This script can only work with php-cli requests');
        }

        $file = sys_get_temp_dir().'/'.str_slug($file).'.lock';

        if (self::isRunning($file)) {
            throw new Exception('Script Already Running');
        }

        self::lock($file);
    }

    private static function isRunning($file)
    {
        if (!is_file($file)) {
            return false;
        }

        $pid = (int)trim(file_get_contents($file));

        return $pid && posix_kill($pid, 0);
    }

    private static function lock($file)
    {
        file_put_contents($file, getmypid());

        register_shutdown_function(function($file) {
            unlink($file);
        }, $file);
    }
}
