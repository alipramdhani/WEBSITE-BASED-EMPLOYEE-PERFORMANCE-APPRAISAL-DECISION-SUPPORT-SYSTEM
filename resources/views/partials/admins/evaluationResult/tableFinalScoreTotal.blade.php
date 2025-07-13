{{-- Table total skor akhir --}}

<div>
    <div class="table-responsive">
        <table class="table" id="performanceTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th class="text-center">Alternatif</th>
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Skor Akhir <br> SMART T1</th>
                    <th class="text-center">Skor Akhir <br> SMART T2</th>
                    <th class="text-center">Skor Akhir <br> SMART T3</th>
                    <th class="text-center">Total Skor Akhir </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($finalScoreTotal as $fst)
                    <tr>
                        <td>{{ ($finalScoreTotal->currentPage() - 1) * $finalScoreTotal->perPage() + $loop->iteration }}</td>
                        <td>{{ $fst->fullname }}</td>
                        <td class="text-center">{{ $fst->alternatif }}</td>
                        <td class="text-center">{{ $fst->evaluation_years }}</td>
                        <td class="text-center">{{ $fst->score_t1 ?? '-' }}</td>
                        <td class="text-center">{{ $fst->score_t2 ?? '-' }}</td>
                        <td class="text-center">{{ $fst->score_t3 ?? '-' }}</td>
                        <td class="text-center fw-bold">{{ $fst->final_score_total ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Tidak ada data Hasil Akhir Penilaian untuk tahun ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="position-fixed bottom-0 start-0 w-100 bg-white py-2 border-top shadow-sm">
        <div class="d-flex justify-content-center">
            {{ $finalScoreTotal->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
