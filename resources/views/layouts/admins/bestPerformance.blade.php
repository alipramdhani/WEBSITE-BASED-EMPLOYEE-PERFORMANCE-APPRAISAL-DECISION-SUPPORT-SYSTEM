@extends('app')

@php
    // Tentukan judul dinamis
    $roleTitle = $userRole === 'superadmin' ? 'Super Admin' : 'Admin';
@endphp

@section('title', "Kinerja Terbaik | $userRole")

@section('content')

@include('layouts.loadingScreen')

@php
    $role = Auth::user()->role;
@endphp
{{-- content --}}

{{-- Filter Tahun --}}
<section id="FilterTahun" class="border bg-white rounded-pill px-5 py-3 mb-5">
    <div class="d-flex justify-content-between align-items-center rounded-4 overflow-hidden bg-white">
        <form id="filterForm" method="GET" action="{{ route("bestPerformance.$role") }}" class="w-100 w-md-50" >
            <div class="row align-items-end g-3">
                <div class="d-flex align-items-center gap-3">
                    <label for="tahun-filter" class="form-label m-0">Filter Tahun</label>
                    <select name="evaluation_years" id="tahun-filter" class="form-select w-25"
                        onchange="document.getElementById('filterForm').submit()">
                        @for ($i = now()->year; $i >= now()->year - 5; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }} >{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </form>
        <div class="d-flex align-items-center ">
            <input id="liveSearch" class="form-control me-2" type="search" placeholder="Search..." aria-label="Search">
        </div>
    </div>
</section>

{{-- Tabel Total Skor Akhir --}}
<section id="finalScoreTotal" class="border bg-white rounded-5 px-5 py-5 mb-5" >
    <div class="rounded-4">
        <div class="border rounded-4 overflow-hidden">
            <div class="bg-light px-4 py-3 border-bottom">
                <h3 class="d-flex fw-bold align-items-center m-0"> Total Skor Akhir Tahap 1 - 4 </h3>
            </div>
            <div class="bg-white p-5">
                @include('partials.admins.evaluationResult.tableFinalScoreTotal')
            </div>
        </div>
    </div>
</section>
<div class="border bg-white rounded-5 px-5 py-5 mb-5">
    <div class="d-flex justify-content-end">
        {{-- Reset Clustering dari Pusat klaster dan Hasil CLustering --}}
        <form method="POST"
            action="{{ Auth::user()->role === 'superadmin'
                ? route('clusteringReset.superadmin', ['evaluation_years' => $tahun])
                : route('clusteringReset.admin', ['evaluation_years' => $tahun]) }}"
            onsubmit="return confirm('Yakin ingin mereset clustering? Semua data akan dihapus.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger d-flex align-items-center gap-2  rounded-3 mb-3">
                <span>Reset Clustering</span>
                <span class="material-symbols-rounded"><span class="material-symbols-rounded">cached</span>
                </span>
            </button>
        </form>
    </div>

    {{-- Tabel Menentukan Centroid Pertama --}}
    <section id="GenerateCentroid" class="rounded-4 mb-5">
        <div class="border rounded-4 overflow-hidden">
            <div class="bg-light px-4 py-3 border-bottom">
                <h3 class="d-flex fw-bold align-items-center m-0"> Menentukan Centroid (Titik Pusat) </h3>
            </div>
            <div class="bg-white p-5">
                @include('partials.admins.evaluationResult.tableCentroidFirst')
            </div>
        </div>
    </section>

    {{-- Tabel Menentukan Clustering --}}
    <section id="GenerateClustering" class="rounded-4">
        <div class="border rounded-4 overflow-hidden">
            <div class="bg-light px-4 py-3 border-bottom">
                <h3 class="d-flex fw-bold align-items-center m-0"> Hasil Clustering Algoritma K-Means </h3>
            </div>
            <div class="bg-white p-5">
                @include('partials.admins.evaluationResult.tableResultKMeans')
            </div>
        </div>
    </section>
</div>


<div class="border bg-white rounded-5 px-5 py-5 mb-5">
    {{-- Tabel Menentukan Clustering --}}
    <section id="TabelClusteringResult" class="rounded-4 mt-5">
        <div class="border rounded-4 overflow-hidden">
            <div class="bg-light px-4 py-3 border-bottom">
                <h3 class="d-flex fw-bold align-items-center m-0"> Hasil Pengelompokan Kinerja </h3>
            </div>
            <div class="bg-white p-5">
                @include('partials.admins.evaluationResult.tableClusteringEmployee')
            </div>
        </div>
    </section>
    {{-- Download PDF --}}
    <div class="d-flex justify-content-end my-4 gap-2">
        {{-- Tombol Preview PDF --}}
        <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2 shadow rounded-3" data-bs-toggle="modal" data-bs-target="#previewPdfModal">
            <span>Preview PDF</span>
            <span class="material-symbols-rounded">visibility</span>
        </button>

        {{-- Tombol Download PDF --}}
        <a href="{{ Auth::user()->role === 'superadmin'
            ? route('bestPerformance.superadmin.download', ['evaluation_years' => $tahun])
            : route('bestPerformance.admin.download', ['evaluation_years' => $tahun]) }}"
            class="btn btn-danger d-flex align-items-center gap-2 shadow rounded-3" target="_blank">
            <span>Download PDF</span>
            <span class="material-symbols-rounded">download</span>
        </a>
    </div>
    <!-- Modal Preview PDF -->
    <div class="modal fade" id="previewPdfModal" tabindex="-1" aria-labelledby="previewPdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewPdfModalLabel">Preview Laporan PDF - {{ $tahun }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-0" style="height: 80vh;">
                    <iframe src="{{ Auth::user()->role === 'superadmin'
                        ? route('bestPerformance.superadmin.preview', ['evaluation_years' => $tahun])
                        : route('bestPerformance.admin.preview', ['evaluation_years' => $tahun]) }}"
                        frameborder="0" width="100%" height="100%">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
