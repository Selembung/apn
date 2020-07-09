<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khs', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->string('nis');
            $table->string('kode_tahun_akademik');
            $table->string('kode_mp');
            $table->bigIncrements('user_id');
            $table->bigIncrements('guru_id');
            $table->integer('nilai_harian');
            $table->integer('nilai_praktek');
            $table->integer('nilai_uts');
            $table->integer('nilai_uas');
            $table->integer('nilai_akhir');
            $table->char('grade')->nullable();
            $table->char('nilai_sikap')->nullable();
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
        Schema::dropIfExists('khs');
    }
}
