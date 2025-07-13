<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @include('script.scriptGoogle')
  </head>
  <body>
    <section id="employee">
        <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
            <div>
                <div class="p-5 shadow-sm rounded-4 bg-white w-sm-100 ">
                    <div class="text-center">
                        <h2 class="fw-bold">
                        Log in
                        </h2>
                        <p style="font-size: 12px; margin: 0;">Silahkan masukkan username dan password anda!</p>
                    </div>
                    <div style="height: 50px; font-size: 12px;" class="text-center text-danger d-flex justify-content-center align-items-center">
                        @if ($errors->has('message'))
                        <span class="material-symbols-rounded me-2" style="color: red; font-size: 20px;">
                        error
                        </span>
                        {{ $errors->first('message') }}
                        @endif
                    </div>
                    <form method="POST" action="{{ route('login.employee') }}" onsubmit="showLoading()">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputUsername1" class="form-label">Username</label>
                            <input type="username" class="form-control" id="exampleInputUsername1" aria-describedby="usernameHelp" name="username" required>
                        </div>
                        <div class="mb-4">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="" required>
                                    <span id="toggleIconPass" class="btn border material-symbols-rounded" onclick="togglePasswordVisibility()" style="cursor: pointer;">
                                    visibility_off
                                    </span>
                                </div>
                                <div class="form-text mb-3">
                                    <a class="nav-link active text-primary text-end fw-semibold fs-6" href="#">Lupa Password?</a>
                                </div>
                        </div>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <section id="footer" class="border">
        @include('partials.footerLogin')
    </section>

    {{-- Area Javascript --}}
    @include('script.scriptJS')
</html>
