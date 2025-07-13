@extends('app')

@php
    // Tentukan judul dinamis
    $roleTitle = $userRole === 'superadmin' ? 'Super Admin' : 'Admin';
@endphp

@section('title', "Hasil Kinerja | $userRole")

@section('content')

@include('layouts.loadingScreen')

@php
    $role = Auth::user()->role;
@endphp

<section id="filterTahun" class="d-flex justify-content-between align-items-center border bg-white rounded-4 py-3 px-5">
 {{-- filter Tahun --}}
 <div class="w-50">
     <form id="filterForm" method="GET" action="{{ route("evaluation.$role.result") }}" class="w-100 w-md-50">
         <input type="hidden" name="evaluation_stage" value="{{ $tahap }}">
         <input type="hidden" name="tab" value="{{ $activeTab }}">
         <div class="row align-items-end g-3">
             <div class="d-flex align-items-center gap-3">
                 <label for="tahun-filter" class="form-label m-0">Filter Tahun</label>
                 <select name="evaluation_years" id="tahun-filter" class="form-select w-25"
                     onchange="document.getElementById('filterForm').submit()">
                     @for ($i = now()->year; $i >= now()->year - 5; $i--)
                         <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                     @endfor
                 </select>
             </div>
         </div>
     </form>
 </div>
 <div>
    <div class="d-flex justify-content-end gap-3">
        {{-- Tombol Preview PDF --}}
        <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2 shadow rounded-3"
            data-bs-toggle="modal" data-bs-target="#previewPdfModal">
            <span>Preview PDF</span>
            <span class="material-symbols-rounded">visibility</span>
        </button>

      {{-- Tombol Download PDF --}}
        <a href="{{ route('evaluationResult.download.all', ['role' => Auth::user()->role, 'evaluation_years' => $tahun]) }}"
            class="btn btn-danger d-flex align-items-center gap-2 rounded-3" target="_blank">
            <span>Download Semua PDF</span>
            <span class="material-symbols-rounded">download</span>
        </a>
    </div>

    <!-- Modal Preview PDF -->
    <div class="modal fade" id="previewPdfModal" tabindex="-1" aria-labelledby="previewPdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Laporan Evaluasi & Clustering - {{ $tahun }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-0" style="height: 80vh;">
                    <iframe src="{{ route('evaluationResult.preview.all', ['role' => Auth::user()->role, 'evaluation_years' => $tahun]) }}"
                            width="100%" height="100%" frameborder="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
 </div>
</section>

{{-- Progres Evaluasi --}}
@if (Auth::user()->role === 'Employee')
<section id="progresEvaluasi" class="mt-5">
    <div class="p-md-5 p-3 rounded-4 bg-white shadow-sm">
        <div class="mb-5">
            <label for="admin" class=" fs-1 fw-bold">
            Progres Evaluasi
            </label>
        </div>
        <div>
            @include('partials.admins.evaluation.tableEvaluation')
        </div>
    </div>
</section>
@endif
{{-- Hasil Evaluasi SMART --}}
<section id="SmartMethodResult" class="mt-5">
    @include('partials.employees.SmartMethodResult')
</section>

{{-- Hasil Evaluasi K-Means Clustering --}}
<section id="KMeansAlgoResult" class="mt-5">
    @include('partials.employees.KMeansAlgoResult')
</section>


@endsection
