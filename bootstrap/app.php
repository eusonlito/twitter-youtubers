<?php
use Illuminate\Contracts;

require_once __DIR__.'/../vendor/autoload.php';

(new Dotenv\Dotenv(__DIR__.'/../'))->load();

$app = new Laravel\Lumen\Application(realpath(__DIR__.'/../'));

$app->singleton(Contracts\Debug\ExceptionHandler::class, App\Exceptions\Handler::class);
$app->singleton(Contracts\Console\Kernel::class, App\Console\Kernel::class);

$app->register(App\Providers\AppServiceProvider::class);

return $app;