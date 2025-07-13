@php
    $role = Auth::user()->role;
@endphp

{{-- Sidebar Web --}}
<div id="sidebar" class="sidebar d-flex flex-column text-decoration-none py-3 px-2 shadow-lg min-vh-100 d-none d-lg-block">
    {{-- Image --}}
    <ul class="nav flex-column">
        <li>
            <a class="nav-link d-flex align-items-center ps-3 rounded-3">
                <img src="{{ asset('images/home.png')}}" width="24" alt="home">
                <img src="{{ asset('images/faveaccess.png') }}" class="faveaccess ms-3 w-75" alt="logo-faceaccess">
            </a>
        </li>
    </ul>
    <hr class="text-white">
    {{-- Home --}}
    <ul class="sidebar-list nav flex-column gap-4 mb-auto">
        {{-- ASKES MENU : Superadmin, Admin, Karyawan --}}
        <li >
            <a href="{{ route("dashboard.$role") }}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/dashboard") ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/dashboard.png') }}" width="20" alt="">
                <span class="ms-3 label-text">Dashboard</span>
            </a>
        </li>
    @if(in_array($role, ['superadmin', 'admin']))
        <li>
            <a href="{{route("authManage.$role")}}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/manajemen-autentikasi","admin/manajemen-autentikasi") ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/auth.png') }}" width="20" alt="">
                <span class="ms-3 label-text">Manajemen Autentikasi</span>
            </a>
        </li>
    @endif
    @if($role !== 'admin' && $role !== 'employee')
        {{-- ASKES MENU : Superadmin --}}
        <li>

            <a href="{{route('departementManage.superadmin')}}" class="nav-link ps-3 rounded-3 {{ request()->is('superadmin/manajemen-departemen') ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/departement.png') }}" width="20" alt="">
                <span class="ms-3 label-text">Manajemen Departemen</span>
            </a>
        </li>
        {{-- ASKES MENU : Superadmin --}}
        <li>
            <a href="{{route('adminManage.superadmin')}}" class="nav-link ps-3 rounded-3 {{ request()->is('superadmin/manajemen-admin') ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/admin.png') }}" width="20" alt="">
                <span class="ms-3 label-text">Manajemen Admin</span>
            </a>
        </li>
    @endif
    @if(in_array($role, ['superadmin', 'admin']))
        <li>
            {{-- ASKES MENU : Superadmin & Admin --}}

            <a href="{{route("employeeManage.$role")}}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/manajemen-karyawan","admin/manajemen-karyawan") ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/employee.png') }}" width="20" alt="">
                <span class="ms-3 label-text">Manajemen Karyawan</span>
            </a>
        </li>
        <li>
            {{-- ASKES MENU : Superadmin & Admin --}}
            <a href="{{route("criteriaManage.$role")}}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/manajemen-kriteria","admin/manajemen-kriteria") ? 'active' : '' }}"onclick="showLoading('swipe')">
                <img src="{{ asset('images/criteria.png') }}" width="20" alt="">
                <span class="ms-3 label-text">Manajemen Kriteria</span>
            </a>
        </li>
        <li>
            {{-- ASKES MENU : Superadmin & Admin --}}
            <a href="{{route("evaluation.$role")}}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/evaluasi-kinerja","admin/evaluasi-kinerja") ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/evaluation.png') }}" width="20" alt="">
                <span class="ms-3 label-text">Penilaian Kinerja</span>
            </a>
        </li>
        <li>
            {{-- ASKES MENU : Superadmin & Admin --}}
            <a href="{{route("bestPerformance.$role")}}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/kinerja-terbaik","admin/kinerja-terbaik") ? 'active' : '' }}" onclick="showLoading('swipe')">
            <img src="{{ asset('images/ranking.png') }}" width="20" alt="">
            <span class="ms-3 label-text">Kinerja Terbaik</span>
            </a>
        </li>
    @endif
        <li>
        {{-- ASKES MENU : Superadmin, Admin, Karyawan --}}
            <a href="{{ route("evaluation.$role.result") }}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/hasil-evaluasi") ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/result.png
                ') }}" width="20" alt="">
                <span class="ms-3 label-text">Hasil Evaluasi</span>
            </a>
        </li>
    </ul>
    <hr class="text-white">
    <ul class="sidebar-logout nav flex-column">
        <li>
          <form id="formlogout" action="{{ route('logout') }}" method="POST" onsubmit="showLoading('logout')">
            @csrf
            <button type="button" class="nav-link ps-3 rounded-3 border-0" onclick="logout()">
              <img src="{{ asset('images/logout.png') }}" width="20" alt="">
              <span class="ms-3 label-text">Keluar</span>
            </button>
          </form>
          </li>
    </ul>
</div>

{{-- Sidebar Mobile --}}
<div class="offcanvas offcanvas-start min-vh-100 d-block d-lg-none w-50 " data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
  <div class="offcanvas-header">
    {{-- Image --}}
    <ul class="nav flex-column">
        <li>
            <a class="d-flex align-items-center rounded-3 gap-3" data-bs-theme="dark">
                <img src="{{ asset('images/home.png')}}" width="16" alt="home">
                <img src="{{ asset('images/faveaccess.png') }}" width="95" alt="logo-faceaccess">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </a>

        </li>
    </ul>
    <hr class="text-white">
  </div>
  <div class="offcanvas-body">
    {{-- Home --}}
    <ul class="sidebar-list nav flex-column gap-4 mb-auto">
        {{-- ASKES MENU : Superadmin, Admin, Karyawan --}}
        <li >
            <a href="{{ route("dashboard.$role") }}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/dashboard") ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/dashboard.png') }}" width="14" alt="">
                <span class="ms-3 label-text">Dashboard</span>
            </a>
        </li>
    @if(in_array($role, ['superadmin', 'admin']))
        <li>
            <a href="{{route("employeeManage.$role")}}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/manajemen-karyawan","admin/manajemen-karyawan") ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/auth.png') }}" width="14" alt="">
                <span class="ms-3 label-text">Manajemen Autentikasi</span>
            </a>
        </li>
    @endif
    @if($role !== 'admin')
        {{-- ASKES MENU : Superadmin --}}
        <li>
            {{-- ASKES MENU : Superadmin --}}
            <a href="{{route('departementManage.superadmin')}}" class="nav-link ps-3 rounded-3 {{ request()->is('superadmin/manajemen-departemen') ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/departement.png') }}" width="14" alt="">
                <span class="ms-3 label-text">Manajemen Departemen</span>
            </a>
        </li>
        {{-- ASKES MENU : Superadmin --}}
        <li>
            <a href="{{route('adminManage.superadmin')}}" class="nav-link ps-3 rounded-3 {{ request()->is('superadmin/manajemen-admin') ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/admin.png') }}" width="14" alt="">
                <span class="ms-3 label-text">Manajemen Admin</span>
            </a>
        </li>
    @endif
    @if(in_array($role, ['superadmin', 'admin']))
        <li>
            {{-- ASKES MENU : Superadmin & Admin --}}

            <a href="{{route("employeeManage.$role")}}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/manajemen-karyawan","admin/manajemen-karyawan") ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/employee.png') }}" width="14" alt="">
                <span class="ms-3 label-text">Manajemen Karyawan</span>
            </a>
        </li>
        <li>
            {{-- ASKES MENU : Superadmin & Admin --}}
            <a href="{{route("criteriaManage.$role")}}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/manajemen-kriteria","admin/manajemen-kriteria") ? 'active' : '' }}" onclick="showLoading('swipe')" onclick="showLoading('swipe')">
                <img src="{{ asset('images/criteria.png') }}" width="14" alt="">
                <span class="ms-3 label-text">Manajemen Kriteria</span>
            </a>
        </li>
        <li>
            {{-- ASKES MENU : Superadmin & Admin --}}
            <a href="{{route("evaluation.$role")}}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/evaluasi-kriteria","admin/evaluasi-kriteria") ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/evaluation.png') }}" width="14" alt="">
                <span class="ms-3 label-text">Penilaian Kinerja</span>
            </a>
        </li>
        <li>
            {{-- ASKES MENU : Superadmin & Admin --}}
            <a href="{{route("bestPerformance.$role")}}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/kinerja-terbaik","admin/kinerja-terbaik") ? 'active' : '' }}" onclick="showLoading('swipe')">
            <img src="{{ asset('images/ranking.png') }}" width="14" alt="">
            <span class="ms-3 label-text">Kinerja Terbaik</span>
            </a>
        </li>
    @endif
        <li>
        {{-- ASKES MENU : Superadmin, Admin, Karyawan --}}
            <a href="{{ route("evaluation.$role.result") }}" class="nav-link ps-3 rounded-3 {{ request()->is("$role/hasil-evaluasi") ? 'active' : '' }}" onclick="showLoading('swipe')">
                <img src="{{ asset('images/result.png
                ') }}" width="14" alt="">
                <span class="ms-3 label-text">Hasil Evaluasi</span>
            </a>
        </li>
    </ul>
    <hr class="text-white">
    <ul class="sidebar-logout nav flex-column">
        <li>
          <form id="formlogout" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link ps-3 rounded-3 border-0" onclick="logout()" onsubmit="showLoading('logout')">
              <img src="{{ asset('images/logout.png') }}" width="14" alt="">
              <span class="ms-3 label-text">Keluar</span>
            </button>
          </form>
          </li>
    </ul>
  </div>
</div>
