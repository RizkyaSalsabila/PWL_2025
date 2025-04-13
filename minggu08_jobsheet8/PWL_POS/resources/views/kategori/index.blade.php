{{-- ------------------------------------- *jobsheet 05* ------------------------------------- --}}
{{-- JS5 - Tugas(m_kategori) --}}
@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            {{-- JS8 - Tugas(m_kategori) --}}
            <button onclick="modalAction('{{ url('/kategori/import') }}')" class="btn btn-sm btn-info mt-1">Import Kategori</button>

            {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">Tambah</a> --}}
            {{-- JS8 - Tugas2(m_kategori) --}}
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/export_excel') }}"><i class="fa fa-file-excel"></i> Export Kategori (Excel)</a>
            
            {{-- JS8 - Tugas3(m_kategori) --}}
            <a class="btn btn-sm btn-secondary mt-1" href="{{ url('kategori/export_pdf') }}"><i class="fa fa-file-pdf"></i> Export Kategori (PDF)</a>
            
            {{-- JS6 - Tugas(m_kategori) --}}
            <button onclick="modalAction('{{ url('/kategori/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
{{-- JS6 - Tugas(m_kategori) --}}
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 
@endsection

@push('css')
@endpush

@push('js')
    <script>
         //-- JS6 - Tugas(m_kategori) --
         function modalAction(url = ''){     
            $('#myModal').load(url,function() {         
                $('#myModal').modal('show');     
            }); 
        } 

        var tableKategori;
        $(document).ready(function() {
            tableKategori = $('#table_kategori').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                processing: true,
                ajax: {
                    "url": "{{ url('kategori/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [
                    {
                        //nomor urut dari laravel datatable addIndexColumn()
                        data: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "kode_kategori",
                        className: "",
                        width: "10%",
                        orderable: true,    //jika ingin kolom ini bisa diurutkan
                        searchable: true    //jika ingin kolom ini bisa dicari
                    },
                    {
                        data: "nama_kategori",
                        className: "",
                        width: "25%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "deskripsi",
                        className: "",
                        width: "40%",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        width: "14%",
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            // JS8 - Tugas(m_kategori) 
            $('#table-kategori_filter input').unbid().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { //enter key
                    tableKategori.search(this.value).draw();
                }
            });
        });
    </script>
@endpush