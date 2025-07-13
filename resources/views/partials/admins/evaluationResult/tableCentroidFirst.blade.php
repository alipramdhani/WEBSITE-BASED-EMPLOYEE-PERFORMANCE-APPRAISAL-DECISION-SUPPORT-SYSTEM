{{-- Form Generate --}}
  {{-- Tampilkan form hanya jika bukan di halaman preview --}}
    @if (!Route::is('evaluation.admin.result') &&
        !Route::is('evaluation.superadmin.result') &&
        !Route::is('evaluation.employee.result'))

        {{-- Form Generate --}}
        <form action="{{ Auth::user()->role === 'superadmin' ? route('generateCentroid.superadmin',['years' => $tahun]) : route('generateCentroid.admin',['years' => $tahun]) }}" method="POST" class="row g-3 mb-5" onsubmit="showLoading('processing')">
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
                    <span class="material-symbols-rounded">hourglass</span>
                </button>
            </div>
        </form>
    @endif

    {{-- Table hasil centroid --}}
    <div class="table-responsive">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Tahun</th>
                    <th>Terpilih</th>
                    <th>Pusat Cluster</th>
                    <th>Total Skor Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($centroidFirst as $cf)
                    <tr>
                        <td>{{ $cf->evaluation_years }}</td>
                        <td>{{ $cf->selected }}</td>
                        <td>{{ $cf->centroid }}</td>
                        <td class="fw-bold text-dark">{{ $cf->final_score_total ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada data centroid.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
