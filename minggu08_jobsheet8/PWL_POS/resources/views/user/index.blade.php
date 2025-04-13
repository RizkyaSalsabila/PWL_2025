{{-- ------------------------------------- *jobsheet 05* ------------------------------------- --}}
{{-- JS5 - P3(5) --}}
@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            {{-- JS8 - Tugas(m_user) --}}
            <button onclick="modalAction('{{ url('/user/import') }}')" class="btn btn-sm btn-info mt-1">Import User</button>

            {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ url('user/create') }}">Tambah</a> --}}
            {{-- JS8 - Tugas2(m_user) --}}
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('user/export_excel') }}"><i class="fa fa-file-excel"></i> Export User (Excel)</a>
            
            {{-- JS8 - Tugas3(m_user) --}}
            <a class="btn btn-sm btn-secondary mt-1" href="{{ url('user/export_pdf') }}"><i class="fa fa-file-pdf"></i> Export User (PDF)</a>
           
            {{-- JS6 - P1(3) --}}
            <button onclick="modalAction('{{ url('/user/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>

    {{-- JS5 - P3(23) --}}
    <div class="card-body">
        <!-- untuk filter data -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="filter_date" class="col-md-1 col-formlabel">Filter</label>
                        <div class="col-md-3">
                            <select  name="filter_level" class="form-control formcontrol-sm filter_level">
                                <option value="">- Semua -</option>
                                @foreach($level as $l)
                                    <option value="{{ $l->filter_level_id }}">{{ $l->username }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">User</small>
                        </div>
                    </div>
                </div>
            </div>    
        </div> 

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif        

        <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Level Pengguna</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
{{-- JS6 - P1(4) --}}
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 
@endsection

@push('css')
@endpush

@push('js')
    <script>
        //-- JS6 - P1(5) --
        function modalAction(url = ''){     
            $('#myModal').load(url,function() {         
                $('#myModal').modal('show');     
            }); 
        } 

        var tableUser;
        $(document).ready(function() {
            tableUser = $('#table_user').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                processing: true,
                ajax: {
                    "url": "{{ url('user/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    // -- JS5 - P4(3) --
                    "data" : function (d) {
                        d.level_id = $('#level_id').val();
                    }
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
                        data: "username",
                        className: "",
                        width: "20%",
                        orderable: true,    //jika ingin kolom ini bisa diurutkan
                        searchable: true    //jika ingin kolom ini bisa dicari
                    },
                    {
                        data: "nama",
                        className: "",
                        width: "37%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        //mengambil data level hasil dari ORM berelasi
                        data: "level.level_nama",
                        className: "",
                        width: "15%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "aksi",
                        className: "",
                        width: "15%",
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            // -- JS8 - Tugas(m_user) --
            $('#table-user_filter input').unbid().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { //enter key
                    tableUser.search(this.value).draw();
                }
            });
            // -- JS5 - P4(4) --
            $('#level_id').on('change', function() {
                tableUser.ajax.reload();
            });
        });
    </script>
@endpush