<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->string('nis')->primary();
            $table->bigInteger('user_id');
            $table->string('kode_tahun_akademik');
            $table->string('nama');
            $table->string('email');
            $table->string('kode_rombel')->nullable();
            $table->string('kode_jurusan');
            $table->string('semester_aktif');
            $table->text('alamat');
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
        Schema::dropIfExists('students');
    }
}
