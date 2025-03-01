<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void      //membuat tabel tanpa mengembalikan nilai
    {
        Schema::create('items', function (Blueprint $table) {       //membuat tabel baru bernama 'items' pada database
            $table->id();               //kolom 'id' sebagai primary key dengan tipe BIGINT dan auto-increment          
            $table->string('name');     //kolom 'name' untuk menyimpan nama item dengan tipe VARCHAR(255)
            $table->text('description');//kolom 'description' untuk menyimpan deskripsi barang dengan tipe TEXT
            $table->integer('stock');   //kolom 'stock' untuk menyimpan jumlah stok barang dalam bentuk bilangan bulat(INTEGER)
            $table->integer('price');   //kolom 'price' untuk menyimpan harga barang dalam bentuk bilangan bulat(INTEGER)
            $table->timestamps();       //untuk menambahkan kolom 'created_at' dan 'updated_at' secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};