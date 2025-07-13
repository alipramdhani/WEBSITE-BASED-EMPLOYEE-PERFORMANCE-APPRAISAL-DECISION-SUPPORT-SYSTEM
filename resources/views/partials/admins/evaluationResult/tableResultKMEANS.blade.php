{{-- Form Generate & Filter Clustering --}}
 {{-- Form Generate Centroid --}}
@if (!Route::is('evaluation.admin.result') &&
    !Route::is('evaluation.superadmin.result') &&
    !Route::is('evaluation.employee.result'))

    <form action="{{ Auth::user()->role === 'superadmin' ? route('generateKMeans.superadmin', ['years' => $tahun]) : route('generateKMeans.admin',['years' => $tahun]) }}" method="POST" class="row g-3 mb-5" onsubmit="showLoading('processing')">
        @csrf
        <div class="col-md-4">
            <label for="tahun" class="form-label">Tahun Evaluasi</label>
            <select class="form-select" name="evaluation_years" id="tahun" required>
                <option value="" disabled selected>Pilih Tahun</option>
                @for ($year = now()->year; $year >= now()->year - 5; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary rounded-3 shadow d-flex justify-content-center align-items-center gap-3">
                <span>Generate</span>
                <span class="material-symbols-rounded">
                hourglass
                </span>
            </button>
        </div>
    </form>
@endif
    {{-- Filter Tahun Clustering --}}
{{-- <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
    <form id="filterForm" method="GET" action="{{ route('bestPerformance.superadmin') }}" style="width: 48%;">
        <div class="row g-3 align-items-end">
            <div class="col-md-8">
                <label for="tahun-filter" class="form-label">Filter Tahun</label>
                <select name="evaluation_years" id="tahun-filter" class="form-select" onchange="document.getElementById('filterForm').submit()">
                    @for ($i = now()->year; $i >= now()->year - 5; $i--)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-outline-secondary w-100">Tampilkan</button>
            </div>
        </div>
    </form>
</div> --}}


{{-- Tabel Hasil Clustering --}}
<div class="table-responsive">
    <table class="table">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th class="text-center">Tahun Evaluasi</th>
                <th class="text-center">Total Skor</th>
                <th class="text-center">C1</th>
                <th class="text-center">C2</th>
                <th class="text-center">C3</th>
                <th class="text-center">Jarak Terdekat</th>
                <th class="text-center">Cluster</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kmeansResult as $kr)
            @php
                $isSearched = isset($highlightedNames) && $highlightedNames->contains($kr->fullname);
            @endphp
                <tr class="{{ $isSearched ? 'table-warning' : '' }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kr->fullname }}</td>
                    <td class="text-center">{{ $kr->evaluation_years }}</td>
                    <td class="text-center">{{ number_format($kr->final_score_total, 4) }}</td>
                    <td class="text-center">{{ number_format($kr->distance_c1, 4) }}</td>
                    <td class="text-center">{{ number_format($kr->distance_c2, 4) }}</td>
                    <td class="text-center">{{ number_format($kr->distance_c3, 4) }}</td>
                    <td class="fw-bold text-center">{{ number_format($kr->closest_distance, 4) }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            @php
                                switch(strtolower($kr->cluster)) {
                                    case 'c1':
                                        $badgeClass = 'bg-success';
                                        break;
                                    case 'c2':
                                        $badgeClass = 'bg-warning text-dark';
                                        break;
                                    case 'c3':
                                        $badgeClass = 'bg-danger';
                                        break;
                                    default:
                                        $badgeClass = 'bg-secondary';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ strtoupper($kr->cluster) }}</span>
                        </div>
                    </div>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">Belum ada hasil clustering untuk tahun ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
