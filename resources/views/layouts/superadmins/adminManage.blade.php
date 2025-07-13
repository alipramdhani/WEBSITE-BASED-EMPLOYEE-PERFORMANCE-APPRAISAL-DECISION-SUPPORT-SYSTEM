@extends('app')
@php
    // Tentukan judul dinamis
    $roleTitle = $userRole === 'superadmin' ? 'Super Admin' : 'Admin';
@endphp

{{-- Section judul halaman --}}
@section('title', "Manajemen Admin | $roleTitle")

@section('content')

@include('layouts.loadingScreen')

<div class="p-5 rounded-4 bg-white shadow-sm mb-5 ">
    <div class="mb-5">
        <label for="admin" class=" fs-1 fw-bold">
            Manajemen Admin
        </label>
    </div>
    <div class="mb-5">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2 rounded-3 shadow" data-bs-toggle="modal" data-bs-target="#createAdminModal">
            <span class="material-symbols-rounded">add_circle</span>
            <span>Admin</span>
        </button>
        @include('partials.superadmins.adminManage.createAdminData')
    </div>
    <div>
        @include('partials.superadmins.adminManage.tableAdminManage')
    </div>
</div>

@endsection
