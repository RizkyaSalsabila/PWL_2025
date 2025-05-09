<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // JS3 - P2(migrasi)
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('level_id')->index();    //indexing untuk ForeignKey
            $table->string('username', 20)->unique();       //unique untuk memastikan tidak ada username yang sama
            $table->string('nama', 100);
            $table->string('password', 255);
            $table->timestamps();

            //Mendefinisikan ForeignKey pada kolom level_id mengacu pada kolom di tabel 'm_level'
            $table->foreign('level_id')->references('level_id')->on('m_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user');
    }
};