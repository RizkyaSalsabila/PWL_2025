{{-- -- ------------------------------------- *jobsheet 05* ------------------------------------- -- --}}
@extends('layout.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kategori')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Manage Kategori</h2>
            </div>
           
            <div class="card-body">
                {{-- TUGAS(1) --}}
                <div class="d-flex justify-content-first">
                    <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm my-3"><b><i class="fas fa-plus"></i>  Tambah</b></a>
                </div>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush