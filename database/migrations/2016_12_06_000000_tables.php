<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tables extends Migration
{
    private static $tablesUp = [];
    private static $tablesDown = [];
    private static $exclude = '/^migrations$/';

    public function up()
    {
        $this->down();

        $this->upTables();
        $this->upIndexes();

        $this->info();
    }

    private function upTables()
    {
        self::create('cursor', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->string('request');
            $table->string('cursor');
            $table->bigInteger('profile_id');
        });

        self::create('media', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->string('domain')->unique();
        });

        self::create('profile', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigInteger('id')->unsigned()->unique()->index();

            $table->string('hash')->index();
            $table->string('name');
            $table->string('description');

            $table->boolean('master');

            $table->datetime('created_at');
        });

        self::create('profile_relation', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigInteger('profile_id_1')->unsigned();
            $table->bigInteger('profile_id_2')->unsigned();

            $table->string('relation');
        });

        self::create('status', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigInteger('id')->unsigned()->unique()->index();

            $table->string('text');
            $table->datetime('created_at');

            $table->bigInteger('profile_id')->unsigned();
        });

        self::create('url', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->string('url')->unique();
            $table->string('expanded');

            $table->bigInteger('media_id')->unsigned();
        });

        self::create('url_status', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigInteger('url_id')->unsigned();
            $table->bigInteger('status_id')->unsigned();
        });
    }

    private function upIndexes()
    {
        Schema::table('profile_relation', function (Blueprint $table) {
            $table->unique(['profile_id_1', 'profile_id_2', 'relation']);

            $table->foreign('profile_id_1')
                ->references('id')->on('profile')
                ->onDelete('cascade');

            $table->foreign('profile_id_2')
                ->references('id')->on('profile')
                ->onDelete('cascade');
        });

        Schema::table('status', function (Blueprint $table) {
            $table->foreign('profile_id')
                ->references('id')->on('profile')
                ->onDelete('cascade');
        });

        Schema::table('url', function (Blueprint $table) {
            $table->foreign('media_id')
                ->references('id')->on('media')
                ->onDelete('cascade');
        });

        Schema::table('url_status', function (Blueprint $table) {
            $table->unique(['url_id', 'status_id']);

            $table->foreign('url_id')
                ->references('id')->on('url')
                ->onDelete('cascade');

            $table->foreign('status_id')
                ->references('id')->on('status')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        DB::statement('SET foreign_key_checks=0');

        self::drop('cursor');
        self::drop('media');
        self::drop('profile');
        self::drop('profile_relation');
        self::drop('status');
        self::drop('url');
        self::drop('url_status');

        DB::statement('SET foreign_key_checks=1');
    }

    private static function create($name, $closure, $exclude = false)
    {
        if (preg_match(self::$exclude, $name)) {
            echo "\n".sprintf('Excluded Create %s', $name)."\n";
            return null;
        }

        self::$tablesUp[] = $name;

        if (($exclude === false) || !Schema::hasTable($name)) {
            Schema::create($name, $closure);
        }
    }

    private static function drop($name, $exclude = false)
    {
        if (preg_match(self::$exclude, $name)) {
            echo "\n".sprintf('Excluded Drop %s', $name)."\n";
            return null;
        }

        self::$tablesDown[] = $name;

        if ($exclude === false) {
            Schema::dropIfExists($name);
        }
    }

    private function info()
    {
    }
}
