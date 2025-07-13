@extends('app')

@php
    // Tentukan judul dinamis
    $roleTitle = $userRole === 'superadmin' ? 'Super Admin' : 'Admin';
@endphp

@section('title', "Manajemen Kriteria | $userRole")

@section('content')

@include('layouts.loadingScreen')


<div class="border p-5 rounded-4 bg-white shadow-sm mb-5 ">
    <div class="mb-5">
        <label for="criteria" class="fs-1 fw-bold">
            Manajemen Kriteria
        </label>
    </div>
     @if (Auth::user()->role === 'superadmin')
    <div class="mb-5 d-flex justify-content-between">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2 rounded-3 shadow" data-bs-toggle="modal" data-bs-target="#createCriteriaModal">
            <span class="material-symbols-rounded">add_circle</span>
            <span>Kriteria</span>
        </button>
        @include('partials.superadmins.criteriaManage.createCriteriaData')

        {{-- button search --}}
        <form class="d-flex gap-2" method="GET" action="{{ route('criteriaManage.superadmin') }}">
            <input class="form-control me-2" type="search" name="search" placeholder="Search"
                value="{{ request('search') }}" aria-label="Search"/>

            <button class="btn btn-outline-primary rounded-circle px-2 py-0" type="submit">
                <span class="material-symbols-rounded mt-2 p-0">search</span>
            </button>

            @if(request('search'))
                <a href="{{ route('criteriaManage.superadmin') }}" class="btn btn-outline-danger rounded-circle px-2 py-0" title="Reset">
                    <span class="material-symbols-rounded mt-2 p-0">close</span>
                </a>
            @endif
        </form>
    </div>
    @endif
    <div>
        <div class="px-md-4 py-4 p-2 mt-5 border rounded-top-4 bg-light ">
            <h2 class="fst-italic m-0 fw-bold">Performance ( 60% )</h1>
        </div>
        <div class="border p-3 border-top-0 rounded-bottom-4">
            @include('partials.superadmins.criteriaManage.tableCriteriaPerformance')
        </div>

        <div class="px-md-4 py-4 p-2 mt-5 border rounded-top-4 bg-light fw-bold fs-1">
            <h2 class="fst-italic m-0 fw-bold">Work Attitude ( 40% )</h1>
        </div>
        <div class="border p-3 border-top-0 rounded-bottom-4">
            @include('partials.superadmins.criteriaManage.tableCriteriaWorkAttitude')
        </div>
    </div>
</div>

@endsection
