<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->enum('media_type', ['movie', 'tv'])->after('movie_tmdb_id');
        });
    }

    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn('media_type');
        });
    }
};
