<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_years', function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->string('kode_tahun_akademik')->primary();
            $table->string('tahun_akademik');
            $table->date('tanggal_awal_sekolah')->nullable();
            $table->date('tanggal_akhir_sekolah')->nullable();
            $table->date('tanggal_awal_uts')->nullable();
            $table->date('tanggal_akhir_uts')->nullable();
            $table->date('tanggal_awal_uas')->nullable();
            $table->date('tanggal_akhir_uas')->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif']);
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
        Schema::dropIfExists('academic_year');
    }
}
