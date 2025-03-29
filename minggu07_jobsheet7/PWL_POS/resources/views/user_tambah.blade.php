<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data User</title>
</head>
<body>
    {{-- ------------------------------------- *jobsheet 04* ------------------------------------- --}}
    {{-- PRAKTIKUM 2.6(2) - SOAL 4 --}}
    <h1>Form Tambah Data User</h1>
    <form method="post" action="/user/tambah_simpan">
        
        {{ csrf_field() }}

        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan Username">
        <br>

        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama">
        <br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan Password">
        <br>

        <label>Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level">
        <br><br>

        <input type="submit" class="btn btn-success" value="Simpan">

    </form>
</body>
</html>