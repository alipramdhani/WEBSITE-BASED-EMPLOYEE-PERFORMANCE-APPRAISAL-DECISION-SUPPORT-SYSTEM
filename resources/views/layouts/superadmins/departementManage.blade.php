@extends('app')

@php
    // Tentukan judul dinamis
    $roleTitle = $userRole === 'superadmin' ? 'Super Admin' : 'Admin';
@endphp

@section('title', "Manajemen Departemen | $userRole")

@section('content')

@include('layouts.loadingScreen')


<div class="border p-5 rounded-4 bg-white shadow-sm mb-5 ">
    <div class="mb-5">
        <label for="departement" class="fs-1 fw-bold">
            Manajemen Departemen
        </label>
    </div>
    <div class="mb-5">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2 rounded-3 shadow" data-bs-toggle="modal" data-bs-target="#createDepartementModal">
            <span class="material-symbols-rounded">add_circle</span>
            <span>Departemen</span>
        </button>
        @include('partials.superadmins.departementManage.createDepartementData')
    </div>
    <div>
        @include('partials.superadmins.departementManage.tableDepartementManage')
    </div>
</div>

@endsection
