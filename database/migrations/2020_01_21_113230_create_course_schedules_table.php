<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigIncrements('user_id');
            $table->string('kode_mp');
            $table->string('hari');
            $table->bigIncrements('jam');
            $table->string('kode_jurusan');
            $table->string('kode_ruangan');
            $table->string('kode_tahun_akademik');
            $table->integer('semester');
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
        Schema::dropIfExists('course_schedules');
    }
}
