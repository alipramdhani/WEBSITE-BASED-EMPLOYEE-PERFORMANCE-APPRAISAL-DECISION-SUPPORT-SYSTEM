<!-- Modal Bootstrap: Hapus Hasil Evaluasi Per Tahap -->
<div class="modal fade" id="deleteResultModal{{ $eds->alternatif }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $eds->alternatif }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <form action="{{ route('evaluation.superadmin.delete') }}" method="POST" onsubmit="showLoading('processing')">
                @csrf
                @method('DELETE')

                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="deleteModalLabel{{ $eds->alternatif }}">
                        <i class="bi bi-trash3-fill"></i> Konfirmasi Hapus Hasil
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <!-- Kirim alternatif, bukan id -->
                    <input type="hidden" name="alternatif" value="{{ $eds->alternatif }}">
                    <input type="hidden" name="evaluation_years" value="{{ $tahun }}">

                    <p class="mb-3 text-muted">Pilih tahap evaluasi yang ingin dihapus:</p>

                    {{-- Checkbox tiap tahap, disable jika data tidak ada --}}
                    @for ($i = 1; $i <= 3; $i++)
                        @php
                            $tahap = 't' . $i;
                            $evaluations = DB::table("evaluations_{$tahap}")
                                ->where('alternatif', $eds->alternatif)
                                ->where('evaluation_years', $tahun)
                                ->exists();

                            $utilities = DB::table("utilities_results_{$tahap}")
                                ->where('alternatif', $eds->alternatif)
                                ->where('evaluation_years', $tahun)
                                ->exists();

                            $finalScore = DB::table("final_score_smart_{$tahap}")
                                ->where('alternatif', $eds->alternatif)
                                ->where('evaluation_years', $tahun)
                                ->exists();

                            $isDisabled = !($evaluations || $utilities || $finalScore);
                        @endphp

                        <div class="d-flex justify-content-start gap-3 mb-2 align-items-center">
                            <input
                                class="form-check-input fs-4 m-0"
                                type="checkbox"
                                name="tahap[]"
                                value="{{ $tahap }}"
                                id="tahap_{{ $eds->alternatif }}_{{ $i }}"
                                {{ $isDisabled ? 'disabled' : '' }}
                            >
                            <label class="form-check-label text-{{ $isDisabled ? 'secondary text-decoration-line-through' : 'dark' }}"
                                   for="tahap_{{ $eds->alternatif }}_{{ $i }}">
                                Tahap {{ $i }}
                            </label>
                        </div>
                    @endfor
                </div>

                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
