<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtitles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('started_at')->default('字幕开始时间');
            $table->string('end_at')->default('字幕结束时间');
            $table->string('content')->default('字幕内容');
            $table->string('type')->comment('字幕语言');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtitles');
    }
}
