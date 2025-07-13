<div class="border bg-white rounded-5 p-5">
    {{-- Tabel Hasil Tahap 1 - 4 --}}
        {{-- <section id="evaluationResult" class="rounded-4">
            <div class="border rounded-4 overflow-hidden">
                <div class="bg-light px-4 py-3 border-bottom">
                    <h3 class="fw-bold">
                        @switch($activeTab)
                            @case('evaluation')
                            Hasil Evaluasi Kinerja
                            @break
                            @case('utility')
                            Hasil Perhitungan Utility
                            @break
                            @case('finalScoreSmart')
                            Hasil Akhir SMART
                            @break
                            @default
                            Hasil Evaluasi
                        @endswitch
                    </h3>
                </div>

                <div class="bg-white p-4 px-md-5 pb-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div class="w-100 w-md-auto">
                            <ul class="nav nav-pills gap-2 flex-wrap" id="evaluationTabs" role="tablist">
                                @php
                                    $tabs = [
                                        'evaluation' => 'Hasil Evaluasi',
                                        'utility' => 'Hasil Utility',
                                        'finalScoreSmart' => 'Hasil SMART'
                                    ];
                                @endphp

                                @foreach ($tabs as $key => $label)
                                    <li class="nav-item" role="presentation">
                                        <a href="{{ Auth::user()->role === 'superadmin' ? route("evaluation.superadmin.result", ['tab' => $key, 'evaluation_stage' => $tahap]) : route("evaluation.admin.result", ['tab' => $key, 'evaluation_stage' => $tahap]) }}"
                                        class="nav-link {{ $activeTab == $key ? 'active text-white bg-primary' : 'text-primary border border-primary' }}">
                                            {{ $label }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="w-100 w-md-auto d-flex justify-content-end">
                            <form method="GET" action="{{ route("evaluation.$role.result") }}" class="d-flex flex-wrap align-items-center gap-2">
                                <input type="hidden" name="evaluation_years" value="{{ $tahun }}">
                                <input type="hidden" name="tab" value="{{ $activeTab }}">

                                <label for="tahap" class="form-label m-0">Pilih Tahap:</label>
                                <select name="evaluation_stage" id="tahap" class="form-select w-auto" onchange="this.form.submit()">
                                    @foreach (['t1' => 'Tahap 1', 't2' => 'Tahap 2', 't3' => 'Tahap 3'] as $key => $label)
                                        <option value="{{ $key }}" {{ $tahap == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="mt-4">
                        @if ($activeTab == 'evaluation')
                            @include('partials.admins.evaluationResult.tableResultEvaluation')
                        @elseif ($activeTab == 'utility')
                            @include('partials.admins.evaluationResult.tableResultUtility')
                        @elseif ($activeTab == 'finalScoreSmart')
                            @include('partials.admins.evaluationResult.tableResultSMART')
                        @endif
                    </div>
                </div>
            </div>
        </section> --}}

    {{-- Total Skor Akhir Penilaian Metode SMART --}}
    <section id="finalScoreTotal" class=" rounded-4">
        <div class="border rounded-4 overflow-hidden">
            <div class="bg-light px-4 py-3 border-bottom">
                <h3 class="d-flex fw-bold align-items-center m-0"> Total Skor Akhir Tahap 1 - 4 </h3>
            </div>
            <div class="bg-white p-5">
                @include('partials.admins.evaluationResult.tableFinalScoreTotal')
            </div>
        </div>
    </section>
</div>
