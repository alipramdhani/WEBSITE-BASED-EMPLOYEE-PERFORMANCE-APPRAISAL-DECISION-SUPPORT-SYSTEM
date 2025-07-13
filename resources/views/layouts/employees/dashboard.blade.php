@extends('appEmployee')

@section('title', 'Dashboard | Karyawan')

@section('content')
        {{-- content --}}
<div class="border-bottom border-2 mb-5 pb-3">
    <h2>Selamat Datang di Dashboard,</h2>
    <h5 class="fw-bold">{{ auth()->user()->fullname }}</h5>
</div>

<section id="card">
    @include('partials.admins.dashboard.card')
</section>

<section class="mt-5">
    @include('partials.admins.dashboard.grafikResultEvaluation')
</section>
@endsection
