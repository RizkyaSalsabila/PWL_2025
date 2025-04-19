@extends('layouts.template')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ asset('storage/profiles/' . ($user->profile_photo ?? 'profile.jpg')) }}" alt="profile"
                            style="width: 150px; height: 150px; object-fit: cover; border: 5px solid #e9ecef;">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->nama }}</h3>

                    <p class="text-muted text-center">{{ $user->level->level_nama ?? 'Tidak diketahui' }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Username</b> <a class="float-right">{{ $user->username }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>ID Level</b> <a class="float-right">{{ $user->level_id }}</a>
                        </li>
                    </ul>

                    <button onclick="modalAction('{{ route('profile.edit') }}')" class="btn btn-primary btn-block">
                        <i class="fas fa-camera mr-2"></i>Edit Foto Profil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
        data-width="75%"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function(response, status, xhr) {
                if (status == "error") {
                    alert('Terjadi kesalahan saat memuat form');
                } else {
                    $('#myModal').modal('show');
                }
            });
        }

        $(document).ready(function() {
            $('.toggle-password').click(function() {
                const input = $(this).parent().prev('input');
                const icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
@endpush