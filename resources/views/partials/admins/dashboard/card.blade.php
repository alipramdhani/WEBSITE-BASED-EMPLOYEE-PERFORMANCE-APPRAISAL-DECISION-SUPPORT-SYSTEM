<div class="row g-4">
    <div class="col-md-6 col-xl-3">
        <div class="px-5 py-3 bg-white d-flex align-items-center border-0 shadow rounded-4 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="material-symbols-rounded fs-1 text-primary">group</span>
                <div>
                    <h5 class="card-title mb-0">{{ $jumlahKaryawan }}</h5>
                    <p class="text-muted mb-0">Jumlah Karyawan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="px-5 py-3 bg-white d-flex align-items-center border-0 shadow rounded-4 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="material-symbols-rounded fs-1 text-success">check_circle</span>
                <div>
                    <h5 class="card-title mb-0">{{ $akunAktif }}</h5>
                    <p class="text-muted mb-0">Akun Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="px-5 py-3 bg-white border-0 shadow rounded-4 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="material-symbols-rounded fs-1 text-warning">star</span>
                <div>
                    <h5 class="card-title mb-0">
                        {{ $skorSmartTertinggi?->final_score_total ?? '-' }}
                    </h5>
                    <p class="text-muted mb-0">
                        SMART Tertinggi:<br>
                        {{ $skorSmartTertinggi?->fullname ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="px-5 py-3 bg-white border-0 shadow rounded-4 h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="material-symbols-rounded fs-1 text-danger">analytics</span>
                <div>
                    <h5 class="card-title mb-0">
                        {{ $skorKmeansTertinggi?->closest_distance ?? '-' }}
                    </h5>
                    <p class="text-muted mb-0">
                        K-Means Tertinggi:<br>
                        {{ $skorKmeansTertinggi?->fullname ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
