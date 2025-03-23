<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    {{-- ------------------------------------- *jobsheet 03* ------------------------------------- --}}
    {{-- <h1>Data User</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->level_id }}</td>
        </tr>
        @endforeach --}}

        {{-- ----------------------------------------------------------------------------------------- --}}

        {{-- ------------------------------------- *jobsheet 04* ------------------------------------- --}}
        {{-- <h1>Data User</h1>

        <table border="1" cellpadding="2" cellspacing="0"> --}}
            {{-- <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
            </tr>
            <tr>
                <td>{{ $data->user_id }}</td>
                <td>{{ $data->username }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->level_id }}</td>
            </tr> --}}
            
            {{-- PRAKTIKUM 2.3(2) --}}
            {{-- <tr>
                <td>Jumlah Pengguna</td>
            </tr>
            <tr>
                <td>{{ $data }}</td>
            </tr> --}}

            {{-- PRAKTIKUM 2.4(1) --}}
            {{-- <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
            </tr>
            <tr>
                <td>{{ $data->user_id }}</td>
                <td>{{ $data->username }}</td>
                <td>{{ $data->nama }}</td>
                <td>{{ $data->level_id }}</td>
            </tr> --}}

        {{-- PRAKTIKUM 2.6(1) --}}
        <h1>Data User</h1>
        <a href="/user/tambah">+ Tambah User</a>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
                {{-- PRAKTIKUM 2.7(2) - SOAL 5 --}}
                <th>Kode Level</th>         
                <th>Nama Level</th>   
                {{-------------------------------}}      
                <th>Aksi</th>
            </tr>
            @foreach ($data as $d)
            <tr>
                <td>{{ $d->user_id }}</td>
                <td>{{ $d->username }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->level_id }}</td>
                {{-- PRAKTIKUM 2.7(2) - SOAL 5 --}}
                <td>{{ $d->level->level_kode }}</td>    
                <td>{{ $d->level->level_nama }}</td>
                {{-------------------------------}}   
                <td>
                    <a href="/user/ubah/{{ $d->user_id }}">Ubah</a> |
                    <a href="/user/hapus/{{ $d->user_id }}">Hapus</a>
                </td>
            </tr>
            @endforeach
        </table>
</body>
</html>