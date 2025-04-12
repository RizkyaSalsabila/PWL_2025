{{-- ------------------------------------- *jobsheet 05* ------------------------------------- --}}
{{-- JS5 - Tugas(m_barang) --}}
@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            {{-- JS8 - P1(3) --}}
            <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-sm btn-info mt-1">Import Barang</button>

            <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
            {{-- JS6 - Tugas(m_barang) --}}
            <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>

    <div class="card-body">
        <!-- untuk filter data -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="filter_date" class="col-md-1 col-formlabel">Filter</label>
                        <div class="col-md-3">
                            <select  name="filter_kategori" class="form-control formcontrol-sm filter_kategori">
                                <option value="">- Semua -</option>
                                @foreach($kategori as $l)
                                    <option value="{{ $l->kategori_id }}">{{ $l->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Barang</small>
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

        <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Kategori Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
{{-- JS6 - Tugas(m_barang) --}}
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 
@endsection

@push('css')
@endpush

@push('js')
    <script>
        //-- JS6 - Tugas(m_barang) --
        function modalAction(url = ''){     
            $('#myModal').load(url,function() {         
                $('#myModal').modal('show');     
            }); 
        } 

        var tableBarang;
        $(document).ready(function() {
            tableBarang = $('#table_barang').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                processing: true,
                ajax: {
                    "url": "{{ url('barang/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data" : function (d) {
                        d.filter_kategori = $('.filter_kategori').val(); 
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
                        data: "barang_kode",
                        className: "",
                        width: "10%",
                        orderable: true,    //jika ingin kolom ini bisa diurutkan
                        searchable: true    //jika ingin kolom ini bisa dicari
                    },
                    {
                        data: "barang_nama",
                        className: "",
                        width: "37%",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "harga_beli",
                        className: "",
                        width: "10%",
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row){                     
                            return new Intl.NumberFormat('id-ID').format(data);  
                        }               
                    },
                    {
                        data: "harga_jual",
                        className: "",
                        width: "10%",
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row){                     
                            return new Intl.NumberFormat('id-ID').format(data);  
                        }
                    },
                    {
                        //mengambil data kategori hasil dari ORM berelasi
                        data: "kategori.nama_kategori",
                        className: "",
                        width: "14%",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "aksi",
                        className: "",
                        width: "14%",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#table-barang_filter input').unbid().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { //enter key
                    tableBarang.search(this.value).draw();
                }
            });

            $('.filter_kategori').change(function() {
                tableBarang.draw();
            });
        });
    </script>
@endpush