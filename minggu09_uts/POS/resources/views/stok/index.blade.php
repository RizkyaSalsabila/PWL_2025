{{-- ------------------------------------- *jobsheet 06* ------------------------------------- --}}
@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" id="barang_id" name="barang_id" required>
                            <option value="">- Semua -</option>
                            @foreach($barang as $item)
                                <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Berdasarkan barang</small>
                    </div>
                </div>
            </div>
        </div>  
        
        <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Nama Supplier</th>
                    <th>Nama Barang</th>
                    <th>Nama User</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
{{-- JS6 - P1(tambah_ajax) --}}
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 
@endsection

@push('css')
@endpush

@push('js')
    <script>
        // JS6 - P1(tambah_ajax)
        function modalAction(url = ''){     
            $('#myModal').load(url,function() {         
                $('#myModal').modal('show');     
            }); 
        } 

        var dataStok;
        $(document).ready(function() {
            dataStok = $('#table_stok').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('stok/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data" : function (d) {
                        d.barang_id = $('#barang_id').val();
                    }
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
                        data: "stok_tanggal",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "stok_jumlah",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "supplier.supplier_nama",
                        orderable: true,
                        searchable: true
                    },
                    {
                     data: "barang.barang_nama",
                     orderable: true,
                     searchable: true
                    },
                    {
                        data: "user.nama",
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

            // JS5 - P4(filter)
            $('#barang_id').on('change', function() {
                dataStok.ajax.reload();
            });
        });
    </script>
@endpush