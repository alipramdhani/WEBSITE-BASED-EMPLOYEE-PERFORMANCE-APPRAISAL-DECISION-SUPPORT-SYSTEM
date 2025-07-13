<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @include('script.scriptGoogle')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
    @include('layouts.loadingScreen')
    {{-- Allert Success Login --}}
    @include('partials.admins.successAlert')
    @include('partials.admins.failedAlert')


    {{-- sidebar & Navbar --}}
    <div id="admin" class="d-flex position-fixed vw-100" style=" height: 50px; background:none;">
    {{-- background:none; kunci utama content berfungsi --}}
        <div class="vh-100">
            @include('partials.admins.sidebar')
        </div>
        <div class="w-100 z-3" style=" height: 50px">
            @include('partials.admins.header')
        </div>
    </div>

    {{-- Konten halaman --}}
    <section id="content">
        <div class="container my-5">
            @yield('content')
        </div>
    </section>

    {{-- Area javascript --}}
    @include('script.scriptJS')
    {{-- Area SweetAlert2 --}}
    @include('script.scriptSweetAlert2')
  </body>
</html>
