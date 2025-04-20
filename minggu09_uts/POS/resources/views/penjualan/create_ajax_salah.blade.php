{{-- ------------------------------------- *jobsheet 06* ------------------------------------- --}}
{{-- JS6 - P1(tambah_ajax) --}}
<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal fade" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Petugas</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">- Pilih Petugas -</option>
                        @foreach($user as $u)
                            <option value="{{ $u->user_id }}">{{ $u->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-kategori_id" class="error-text form-text textdanger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" required>
                    <small id="error-penjualan_kode" class="error-text form-text textdanger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input type="datetime-local" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required min="{{ now()->format('Y-m-d\TH:i') }}">
                    <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Pembeli</label>
                    <input  type="text" name="pembeli" id="pembeli" class="form-control" required>
                    <small id="error-pembeli" class="error-text form-text text-danger"></small>
                </div>
                {{-- <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Penjualan Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div> --}}
                <div class="modal-dialog modal-lg" id="modalDetail" tabindex="-1">
                    <div class="modal-dialog">
                      <form id="form-detail">
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Tambah Barang ke Penjualan</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                          </div>
                          <div class="modal-body">
                            <input type="hidden" name="penjualan_id" id="penjualan_id">
                            <div class="form-group">
                              <label for="barang_id">Barang</label>
                              <select name="barang_id" id="barang_id" class="form-control">
                                @foreach($barang as $b)
                                <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga }}">{{ $b->nama }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Harga</label>
                              <input type="number" name="harga" id="harga" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                              <label>Jumlah</label>
                              <input type="number" name="jumlah" id="jumlah" class="form-control">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                <button type="button" class="btn btn-success mt-2" id="btn-tambah-barang" data-target="#modal-master"  data-toggle="modal">
                    Tambah Barang
                </button>
            {{-- <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div> --}}
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                penjualan_kode: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                penjualan_tanggal: {
                    required: true,
                    date: true
                },
                pembeli: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                user_id: {
                    required: true,
                    number: true
                },
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataPenjualan.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                            // event.preventDefault();
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
        // Set harga otomatis saat barang dipilih
        $('#barang_id').on('change', function() {
            const harga = $(this).find(':selected').data('harga');
            $('#harga').val(harga);
        });

        // Simpan detail penjualan via AJAX
        $('#form-detail').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
            url: '/penjualan-detail/store',
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if(res.status){
                Swal.fire('Berhasil', res.message, 'success');
                $('#modalDetail').modal('hide');
                $('#form-detail')[0].reset();
                // reload table detail (optional)
                } else {
                Swal.fire('Gagal', res.message, 'error');
                }
            }
            });
        });
    });
        //untuk mengatur tanggal, agar tanggal hanya bisa di klik hari ini dan kedepannya
        document.addEventListener('DOMContentLoaded', function () {
        const now = new Date();
        const datetimeLocal = now.toISOString().slice(0,16); // format: YYYY-MM-DDTHH:MM
        document.getElementById('penjualan_tanggal').value = datetimeLocal;
    });

    // $(document).ready(function() {
    //     // // Set harga otomatis saat barang dipilih
    //     // $('#barang_id').on('change', function() {
    //     //     const harga = $(this).find(':selected').data('harga');
    //     //     $('#harga').val(harga);
    //     // });

    //     // // Simpan detail penjualan via AJAX
    //     // $('#form-detail').on('submit', function(e) {
    //     //     e.preventDefault();
    //     //     $.ajax({
    //     //     url: '/penjualan-detail/store',
    //     //     method: 'POST',
    //     //     data: $(this).serialize(),
    //     //     success: function(res) {
    //     //         if(res.status){
    //     //         Swal.fire('Berhasil', res.message, 'success');
    //     //         $('#modalDetail').modal('hide');
    //     //         // reload table detail (optional)
    //     //         } else {
    //     //         Swal.fire('Gagal', res.message, 'error');
    //     //         }
    //     //     }
    //     //     });
    //     // });
    // });
</script>        