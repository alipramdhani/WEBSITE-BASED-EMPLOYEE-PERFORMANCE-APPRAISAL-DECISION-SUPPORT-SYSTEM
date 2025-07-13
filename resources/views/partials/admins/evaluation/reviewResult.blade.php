<!-- Modal Evaluasi -->
<div class="modal fade" id="reviewResultModal{{ $eds->alternatif }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $eds->alternatif }}" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title">Detail Hasil Evaluasi - {{ $eds->fullname }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body table-responsive p-5">
            {{-- menghitung progres jika Tahap 1 = 25% Tahap 4 = 100% --}}
        @php
                $stageString = $eds->evaluation_stage ?? '';
                $stages = explode(',', strtoupper(trim($stageString))); // memastikan huruf besar dan tidak ada spasi
                $validStages = ['T1', 'T2', 'T3'];
                $completed = collect($validStages)->filter(fn($stage) => in_array($stage, $stages))->count();
                $progress = $completed * 25;
            @endphp

            <div class="d-flex justify-content-center align-items-center mb-5">
                <!-- Pagination Tahapan -->
                <div>
                <ul class="pagination m-0">
                    <li class="page-item disabled"><span class="page-link">Tahap</span></li>
                    @for ($i = 1; $i <= 3; $i++)
                    <li class="page-item">
                        <a class="page-link tahap-btn" href="javascript:void(0)" data-target="Tahap_{{ $i }}">{{ $i }}</a>
                    </li>
                    @endfor
                </ul>
                </div>
            </div>

            <!-- Konten Tahap -->
            @for ($t = 1; $t <= 3; $t++)
            <div id="Tahap_{{ $t }}" class="tahap-section" style="{{ $t !== 1 ? 'display:none;' : '' }}">
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Criteria</th>
                    <th>Bobot</th>
                    <th>Normalisasi</th>
                    <th>Evaluasi</th>
                    <th>Utility</th>
                    <th>Skor Akhir SMART</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($criteria as $index => $c)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $c->criteria }}</td>
                    <td>{{ $c->priority_weight }}</td>
                    <td>{{ number_format($c->normalized_weight, 3) }}</td>
                     <td class="fw-semibold">
                        {{ isset($evaluations['t'.$t][$eds->alternatif]) && isset($evaluations['t'.$t][$eds->alternatif]->{'C'.($index+1)})
                            ? number_format($evaluations['t'.$t][$eds->alternatif]->{'C'.($index+1)}, 0)
                            : '-' }}
                    </td>
                    <td class="fw-semibold">
                        {{ isset($utilities['t'.$t][$eds->alternatif]) && isset($utilities['t'.$t][$eds->alternatif]->{'C'.($index+1)})
                            ? number_format($utilities['t'.$t][$eds->alternatif]->{'C'.($index+1)}, 2)
                            : '-' }}
                    </td>
                    <td class="fw-semibold">
                        {{ isset($finalScoreSmart['t'.$t][$eds->alternatif]) && isset($finalScoreSmart['t'.$t][$eds->alternatif]->{'C'.($index+1)})
                            ? number_format($finalScoreSmart['t'.$t][$eds->alternatif]->{'C'.($index+1)}, 4)
                            : '-' }}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            @endfor
        </div>
        <div class="modal-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex gap-2 flex-wrap">
                @for ($t = 1; $t <= 3; $t++)
                    @php
                        $role = Auth::user()->role;
                        $userId = Auth::id();

                        // Hanya tampilkan tombol jika:
                        // - superadmin atau admin
                        // - atau karyawan dengan id yang sesuai
                        $isAllowed = in_array($role, ['superadmin', 'admin']) || ($role === 'karyawan' && $eds->alternatif === $userId);

                        if ($isAllowed) {
                            $downloadRoute = match ($role) {
                                'superadmin' => route('evaluation.superadmin.download', ['id' => $eds->alternatif, 'tahap' => 'T'.$t]),
                                'admin'      => route('evaluation.admin.download', ['id' => $eds->alternatif, 'tahap' => 'T'.$t]),
                                'karyawan'   => route('evaluation.employee.download', ['id' => $eds->alternatif, 'tahap' => 'T'.$t]),
                                default      => '#',
                            };
                        }
                    @endphp

                    @if ($isAllowed)
                        <a href="{{ $downloadRoute }}"
                            class="btn btn-danger d-flex align-items-center gap-2 shadow rounded-3"
                            target="_blank">
                            <span>Download T{{ $t }}</span>
                            <span class="material-symbols-rounded">download</span>
                        </a>
                    @endif
                @endfor
            </div>
            <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
    </div>
  </div>
</div>
