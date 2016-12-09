# Twitter Youtubers Analytics

* Required PHP 7.x

```bash
$> git clone https://github.com/eusonlito/twitter-youtubers.git
$> cd twitter-youtubers
$> composer install
$> mysql -e 'CREATE DATABASE `twitter-youtubers` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;'
$> cp .env.example .env
$> vi .env
$> php artisan migrate --seed
$> while [ true ]; do php artisan twitter-read; done
```