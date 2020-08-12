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
            $table->string('nisn');
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->char('jenis_kelamin');
            $table->string('agama');
            $table->string('email');
            $table->string('kode_tahun_akademik');
            $table->string('kode_rombel')->nullable();
            $table->string('kode_jurusan');
            $table->string('semester_aktif');
            $table->bigInteger('user_id');
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
