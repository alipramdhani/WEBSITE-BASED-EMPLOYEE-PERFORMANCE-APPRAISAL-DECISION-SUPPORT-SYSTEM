@extends('app')

@php
    // Tentukan judul dinamis
    $roleTitle = $userRole === 'superadmin' ? 'Super Admin' : 'Admin';
@endphp

@section('title', "Penilaian Kinerja | $userRole")

@section('content')

@include('layouts.loadingScreen')

@php
    $role = Auth::user()->role;
@endphp

<div class="p-md-5 p-3 rounded-4 bg-white shadow-sm ">
    <div class="mb-5">
        <label for="admin" class=" fs-1 fw-bold">
            Penilaian Kinerja
        </label>
    </div>
    <div>
        @include('partials.admins.evaluation.formEvaluation')
    </div>
</div>
<div class="my-5"></div>
<div class="p-md-5 p-3 rounded-4 bg-white shadow-sm">
    <div class="mb-5 p-3 rounded-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3 mb-md-0">
                <label for="admin" class="fs-1 fw-bold m-0">
                    Progres Penilaian Kinerja
                </label>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-md-end">
                <form id="filterForm" method="GET" action="{{ route("evaluation.$role") }}" class="d-flex align-items-center gap-3 w-100 w-md-auto justify-content-end">
                    <label for="tahun-filter" class="form-label m-0 w-auto text-end">Filter Tahun</label>
                    <select name="evaluation_years" id="tahun-filter" class="form-select w-25 w-md-auto"
                        onchange="document.getElementById('filterForm').submit()">
                        @for ($i = now()->year; $i >= now()->year - 5; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div>
        @include('partials.admins.evaluation.tableEvaluation')
    </div>
</div>

@endsection
