{{-- ------------------------------------- *jobsheet 05* ------------------------------------- --}}
{{-- JS8 - Tugas(m_level) --}}
@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            {{-- JS8 - Tugas(m_level) --}}
            <button onclick="modalAction('{{ url('/level/import') }}')" class="btn btn-sm btn-info mt-1">Import Level</button>

            <a class="btn btn-sm btn-primary mt-1" href="{{ url('level/create') }}">Tambah</a>
            {{-- JS6 - Tugas(m_level) --}}
            <button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Level</th>
                    <th>Nama Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
{{-- JS6 - Tugas(m_level) --}}
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 
@endsection

@push('css')
@endpush

@push('js')
    <script>
        //-- JS6 - Tugas(m_level) --
        function modalAction(url = ''){     
            $('#myModal').load(url,function() {         
                $('#myModal').modal('show');     
            }); 
        } 

        var tableLevel;
        $(document).ready(function() {
            tableLevel = $('#table_level').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                processing: true,
                ajax: {
                    "url": "{{ url('level/list') }}",
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
                        data: "level_kode",
                        className: "",
                        width: "10%",
                        orderable: true,    //jika ingin kolom ini bisa diurutkan
                        searchable: true    //jika ingin kolom ini bisa dicari
                    },
                    {
                        data: "level_nama",
                        className: "",
                        width: "37%",
                        orderable: true,
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

            $('#table-level_filter input').unbid().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { //enter key
                    tableLevel.search(this.value).draw();
                }
            });
        });
    </script>
@endpush