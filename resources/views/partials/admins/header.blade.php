@php
    $role = Auth::user()->role;
@endphp
<div class="bg-white header shadow d-flex justify-content-between align-items-center py-2 pe-lg-5 w-100">
    <div class="d-none d-lg-block">
        {{-- web version --}}
        <button id="toggleSidebar" class="btn border-0 px-4"> {{-- md-lg = tidak ada --}}
            <span id="toggleIcon">
                <img src="{{asset('images/hambbar.png')}}" style="width: 28px;" alt="hamburger">
            </span>
        </button>
    </div>
    {{-- Mobile version --}}
    <div class="d-block d-lg-none"> {{-- md-sm = ada --}}
        <button id="mobileToggleSidebar" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop" class="btn border-0 px-4">
            <span>
                <img src="{{ asset('images/hambbar.png') }}" style="width: 28px;" alt="hamburger">
            </span>
        </button>
    </div>

    <div class="ms-auto d-flex align-items-center gap-3">
        <!-- Icon Lonceng -->
        {{-- <a class="nav-link position-relative" href="#" aria-label="Notifikasi">
            <img src="{{ asset('images/bell.png') }}" width="18" alt="Lonceng">
            <!-- Contoh badge -->
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                3
                <span class="visually-hidden">notifikasi baru</span>
            </span>
        </a> --}}

        <!-- Dropdown Profile -->
        <div class="dropdown">
            <a href="#" class="nav-link d-flex align-items-center link-dark text-decoration-none" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('images/profile.png') }}" alt="Profile" width="24" height="24" class="rounded-circle me-2">
                <span class="text-dark d-none d-md-block">{{ auth()->user()->fullname }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end text-small shadow mt-4 me-3 p-0  border-0 " aria-labelledby="dropdownUser2">
                <li>
                    <a class="dropdown-item p-3 d-flex align-items-center hstack gap-2" href="#">
                        <div>
                            <img src="{{ asset('images/profile.png') }}" alt="Profile" width="20" height="20" class="rounded-circle me-2">
                        </div>
                        <div>
                            <span class="text-label fw-bold">Terakhir Login</span><br>
                            <span class="text-label">
                                {{ Auth::user()->last_login_at
                                ? \Carbon\Carbon::parse(Auth::user()->last_login_at)->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') . ' WIB'
                                : '-' }}
                            </span>
                        </div>
                    </a>
                </li>
                @if(in_array($role, ['admin', 'employee']))
                    <li>
                        <a class="dropdown-item p-3 border-0 d-flex align-items-center hstack gap-2" href="#">
                            <div>
                                <img src="{{ asset('images/profile.png') }}" alt="Profile" width="20" height="20" class="rounded-circle me-2">
                            </div>
                            <div>
                                <span class="text-label fw-bold">Edit Profile</span> <br>
                                <span class="text-label">(waktu)</span>
                            </div>
                        </a>
                    <li>
                    <li>
                        <a class="dropdown-item p-3 border-0 d-flex align-items-center hstack gap-2" href="#">
                            <div>
                                <img src="{{ asset('images/profile.png') }}" alt="Profile" width="20" height="20" class="rounded-circle me-2">
                            </div>
                            <div>
                                <span class="text-label fw-bold">Ganti Password</span> <br>
                                <span class="text-label">(waktu)</span>
                            </div>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
