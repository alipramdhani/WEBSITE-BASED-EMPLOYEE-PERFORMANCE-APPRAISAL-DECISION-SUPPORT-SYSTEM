
@extends('app')

@php
    // Tentukan judul dinamis
    $roleTitle = $userRole === 'superadmin' ? 'Super Admin' : 'Admin';
@endphp

@section('title', "Manajemen Autentikasi | $userRole")

@section('content')

@include('layouts.loadingScreen')

@php
    $role = Auth::user()->role;
@endphp

@if($role !== 'admin')
<div class="border p-5 rounded-4 bg-white shadow-sm mb-5 ">
    <div class="mb-5">
        <label for="admin" class="fs-1 fw-bold">
            Autentikasi Admin
        </label>
    </div>
    <div>
        @include('partials.superadmins.authManage.tableAdmin')
    </div>
</div>
@endif
<div class="border p-5 rounded-4 bg-white shadow-sm mt-5">
    <div class="mb-5 d-flex align-items-center justify-content-between">
        <div>
            <label for="admin" class="fs-1 fw-bold">
                Autentikasi Karyawan
            </label>
        </div>
        <div>
            {{-- button search --}}
            <form class="d-flex gap-2" method="GET" action="{{ route('authManage.superadmin') }}">
                <input class="form-control me-2" type="search" name="search" placeholder="Search"
                    value="{{ request('search') }}" aria-label="Search"/>

                <button class="btn btn-outline-primary rounded-circle px-2 py-0" type="submit">
                    <span class="material-symbols-rounded mt-2 p-0">search</span>
                </button>

                @if(request('search'))
                    <a href="{{ route('authManage.superadmin') }}" class="btn btn-outline-danger rounded-circle px-2 py-0" title="Reset">
                        <span class="material-symbols-rounded mt-2 p-0">close</span>
                    </a>
                @endif
            </form>
        </div>
    </div>
    <div>
         @include('partials.superadmins.authManage.tableEmployee')
    </div>
</div>

@endsection
