<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login User | Faveaccess</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @include('script.scriptGoogle')
  </head>
  <body>
    @include('layouts.loadingScreen')
      <div class="container-fluid">
      <div class="row min-vh-100">
        {{-- KIRI: Carousel --}}
        <div class="col-md-6 p-0 d-none d-md-block">
          <div id="carouselExampleRide" class="carousel slide h-100" data-bs-ride="carousel">
            <div class="carousel-inner h-100">
              <div class="carousel-item active h-100">
                <img src="{{ asset('images/img-slide-1.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Slide 1">
              </div>
              <div class="carousel-item h-100">
                <img src="{{ asset('images/img-slide-2.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Slide 2">
              </div>
              <div class="carousel-item h-100">
                <img src="{{ asset('images/img-slide-3.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Slide 3">
              </div>
              <div class="carousel-item h-100">
                <img src="{{ asset('images/img-slide-4.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Slide 3">
              </div>
              <div class="carousel-item h-100">
                <img src="{{ asset('images/img-slide-5.jpg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Slide 3">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>

        {{-- KANAN: Form Login --}}
        <div class="col-md-6 d-flex align-items-center justify-content-center bg-white">
          <div class="p-5 shadow-sm rounded-4 bg-white w-sm-100 border">
                <div class="text-center">
                    <h2 class="fw-bold">
                    Log in
                    </h2>
                    <p style="font-size: 12px; margin: 0;">Silahkan masukkan username dan password anda!</p>
                </div>
                <div style="height: 50px; font-size: 12px;" class="text-center text-danger d-flex justify-content-center align-items-center">
                    @if ($errors->has('email'))
                    <span class="material-symbols-rounded me-2" style="color: red; font-size: 20px;">
                    error
                    </span>
                    {{ $errors->first('email') }}
                    @endif
                </div>
                <form method="POST" action="{{ route('login')}}" onsubmit="showLoading('login')">
                @csrf
                    <div class="mb-3">
                        <label for="exampleInputUsername1" class="form-label">Username</label>
                        <input type="username" class="form-control" id="exampleInputUsername1" aria-describedby="usernameHelp" name="username">
                    </div>
                    <div class="mb-4">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="">
                            <span id="toggleIconPass" class="btn border material-symbols-rounded" onclick="togglePasswordVisibility()" style="cursor: pointer;">
                            visibility_off
                            </span>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
    {{-- <div id="superadmin" class="col-md-6 d-flex align-items-center justify-content-center bg-white">
        <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center border">
            <div class="p-5 shadow-sm rounded-4 bg-white w-sm-100 border">
                <div class="text-center">
                    <h2 class="fw-bold">
                    Log in
                    </h2>
                    <p style="font-size: 12px; margin: 0;">Silahkan masukkan username dan password anda!</p>
                </div>
                <div style="height: 50px; font-size: 12px;" class="text-center text-danger d-flex justify-content-center align-items-center">
                    @if ($errors->has('email'))
                    <span class="material-symbols-rounded me-2" style="color: red; font-size: 20px;">
                    error
                    </span>
                    {{ $errors->first('email') }}
                    @endif
                </div>
                <form method="POST" action="{{ route('login')}}" onsubmit="showLoading('login')"">
                @csrf
                    <div class="mb-3">
                        <label for="exampleInputUsername1" class="form-label">Username</label>
                        <input type="username" class="form-control" id="exampleInputUsername1" aria-describedby="usernameHelp" name="username">
                    </div>
                    <div class="mb-4">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="">
                            <span id="toggleIconPass" class="btn border material-symbols-rounded" onclick="togglePasswordVisibility()" style="cursor: pointer;">
                            visibility_off
                            </span>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}


    {{-- Footer --}}
    <section id="footer" class="p-4">
        @include('partials.footerLogin')
    </section>

    {{-- Area Javascript --}}
    @include('script.scriptJS')
</html>
