{{-- ------------------------------------- *jobsheet 05* ------------------------------------- --}}
{{-- JS6 - P1(tambah_ajax) --}}
@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan/export_excel') }}"><i class="fa fa-file-excel"></i> Export (Excel)</a>
            <a class="btn btn-sm btn-secondary mt-1" href="{{ url('penjualan/export_pdf') }}"><i class="fa fa-file-pdf"></i> Export (PDF)</a>
            <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Penjualan</th>
                    <th>Tanggal Penjualan</th>
                    <th>Pembeli</th>
                    <th>Nama Petugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = ''){     
            $('#myModal').load(url,function() {         
                $('#myModal').modal('show');     
            }); 
        } 

        var dataPenjualan;
        $(document).ready(function() {
            dataPenjualan = $('#table_penjualan').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [
                    {
                        //nomor urut dari laravel datatable addIndexColumn()
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "penjualan_kode",
                        className: "",
                        orderable: true,    //jika ingin kolom ini bisa diurutkan
                        searchable: true    //jika ingin kolom ini bisa dicari
                    },
                    {
                        data: "penjualan_tanggal",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pembeli",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "user.nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ],
            });
        });
    </script>
@endpush