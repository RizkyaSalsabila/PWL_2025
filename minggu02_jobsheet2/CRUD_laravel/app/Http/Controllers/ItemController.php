<?php

namespace App\Http\Controllers;     //mendefinisikan namespace untuk controller ini

use App\Models\Item;     //mengimpor model 'Item' untuk mewakili tabel 'items' pada database
use Illuminate\Http\Request;        //mengimpor class 'Request' untuk menangani input dari form

class ItemController extends Controller
{

    public function index()     #menampilkan semua data
    {
        $items = Item::all();       //mengambil semua data dari tabel items
        return view('items.index', compact('items'));       //mengembalikan tampilan 'items.index' dan mengirimkan data ke tampilan tersebut
    }  

    public function create()    #menampilkan form tambah data
    {
        return view('items.create');        //menampilkan halaman 'items.create' yang berisi form untuk menambahkan barang baru
    }

    public function store(Request $request)     #menyimpan data ke database 
    {
        $request->validate([        //berisi validasi agar semua kolom wajib diisi (required)
            'name' => 'required',       // Atribut 'name' harus diisi
            'description' => 'required',        // Atribut 'description' harus diisi
            'stock' => 'required',      // Atribut 'stock' harus diisi
            'price' => 'required'       // Atribut 'price' harus diisi
        ]);

        //Item::create($request->all());
        //return redirect()->route('items.index');

        //Hanya masukkan atribut yang diizinkan
        Item::create($request->only(['name', 'description', 'stock', 'price']));        //menyimpan data ke tabel 'items' dengan input kolom yang diizinkan
        return redirect()->route('items.index')->with('success', 'Item added successfully.');        //diarahkan ke halaman index dengan mengirimkan pesan sukses
    }

    public function show(Item $item)    #menampilkan detail data
    {
        return view('items.show', compact('item'));     //menampilkan halaman 'items.show' dan mengirimkan data item yang akan ditampilkan ke halaman tersebut
    }

    public function edit(Item $item)    #menampilkan form edit data
    {
        return view('items.edit', compact('item'));     //menampilkan halaman 'items.edit' untuk mengedit barang berdasarkan ID yang dipilih
    }

    public function update(Request $request, Item $item)    #memperbarui data 
    {
        $request->validate([         //berisi validasi agar semua kolom wajib diisi (required)
            'name' => 'required',       // Atribut 'name' harus diisi
            'description' => 'required',        // Atribut 'description' harus diisi
            'stock' => 'required',      // Atribut 'stock' harus diisi
            'price' => 'required'       // Atribut 'price' harus diisi
        ]);

        //$item->update($request->all());
        //return redirect()->route('items.index');

        //Hanya masukkan atribut yang diizinkan
        $item->update($request->only(['name', 'description', 'stock', 'price']));       //memperbarui data hanya pada kolom yang diizinkan
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');     //mengembalikan halaman index dengan pesan sukses
    }

    public function destroy(Item $item)     #menghapus data dari database
    {
        //return redirect()->route('items.index');
        $item->delete();        //menghapus data 'item' dari database
        return redirect()->route('items.index')->with('succes', 'Item deleted successfully.');      //mengembalikan halaman index dengan pesan sukses
    }
}