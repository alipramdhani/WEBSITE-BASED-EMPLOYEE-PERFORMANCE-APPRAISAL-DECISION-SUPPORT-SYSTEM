@extends('app')
@php
    // Tentukan judul dinamis
    $roleTitle = $userRole === 'superadmin' ? 'Super Admin' : 'Admin';
@endphp

@section('title', "Manajemen Karyawan | $userRole")

@section('content')

@include('layouts.loadingScreen')


<div class="border p-5 rounded-4 bg-white shadow-sm mb-5 ">
    <div class="mb-5">
        <label for="employee" class="fs-1 fw-bold">
            Manajemen Karyawan
        </label>
    </div>
    <div class="mb-5 d-flex justify-content-between">
        {{-- button tambah karyawan --}}
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2 rounded-3 shadow" data-bs-toggle="modal" data-bs-target="#createEmployeeModal">
            <span class="material-symbols-rounded">add_circle</span>
            <span>Karyawan</span>
        </button>
        @include('partials.superadmins.employeeManage.createEmployeeData')

        {{-- button search --}}
        <form class="d-flex gap-2" method="GET" action="{{ route('employeeManage.superadmin') }}">
            <input class="form-control me-2" type="search" name="search" placeholder="Search"
                value="{{ request('search') }}" aria-label="Search"/>

            <button class="btn btn-outline-primary rounded-circle px-2 py-0" type="submit">
                <span class="material-symbols-rounded mt-2 p-0">search</span>
            </button>

            @if(request('search'))
                <a href="{{ route('employeeManage.superadmin') }}" class="btn btn-outline-danger rounded-circle px-2 py-0" title="Reset">
                    <span class="material-symbols-rounded mt-2 p-0">close</span>
                </a>
            @endif
        </form>
    </div>

    <div>
        @include('partials.superadmins.employeeManage.tableEmployeeManage')
    </div>
</div>


@endsection
