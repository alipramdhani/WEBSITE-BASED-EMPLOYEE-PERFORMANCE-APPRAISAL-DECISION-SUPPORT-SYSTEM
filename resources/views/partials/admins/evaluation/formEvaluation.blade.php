<div>
    <form action="{{ Auth::user()->role === 'superadmin' ? route('evaluation.superadmin.store') : route('evaluation.admin.store') }}" method="POST" onsubmit="showLoading('processing')">
        @csrf
        @method('POST')

        {{-- Isi Data Karyawan --}}
        <div class="px-md-4 py-4 p-2 border rounded-top-3 bg-light">
            <h4 class="m-0">Karyawan</h4>
        </div>
        <div class="p-4 border">
            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    {{-- Nama Karyawan --}}
                    <div class="mb-4 row">
                        <label for="fullname" class="col-12 col-md-4 form-label">Nama Karyawan</label>
                        <div class="col-12 col-md-8">
                            <select class="form-select" name="user_id" id="fullname" required>
                                <option disabled selected>Pilih Karyawan</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                            data-email="{{ $user->email }}"
                                            data-fullname="{{ $user->fullname }}"
                                            data-departement="{{ $user->departement }}"
                                            data-employment="{{ $user->employeementStatus }}">
                                        {{ $user->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mb-4 row">
                        <label for="email" class="col-12 col-md-4 form-label">Email Karyawan</label>
                        <div class="col-12 col-md-8">
                            <input type="text" class="form-control" id="email" readonly  disabled>
                        </div>
                    </div>

                    {{-- Departement --}}
                    <div class="mb-4 row">
                        <label for="departement" class="col-12 col-md-4 form-label">Departement</label>
                        <div class="col-12 col-md-8">
                            <input type="text" class="form-control" id="departement" readonly disabled>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                    {{-- Status Pekerjaan --}}
                    <div class="mb-4 row">
                        <label for="employeementStatus" class="col-12 col-md-4 form-label">Status Pekerjaan</label>
                        <div class="col-12 col-md-8">
                            <input type="text" class="form-control" id="employeementStatus" readonly disabled>
                        </div>
                    </div>

                    {{-- Tahapan Evaluasi --}}
                    <div class="mb-4 row">
                        <label for="tahapan" class="col-12 col-md-4 form-label">Tahapan Evaluasi</label>
                        <div class="col-12 col-md-8">
                            <select class="form-select" name="evaluation_stage" id="tahapan" required>
                                <option value="" disabled selected>Pilih Tahap</option>
                                <option value="T1">Tahap 1 (April)</option>
                                <option value="T2">Tahap 2 (Agustus)</option>
                                <option value="T3">Tahap 3 (Desember)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tahun Evaluasi --}}
                    <div class="mb-4 row">
                        <label for="tahun" class="col-12 col-md-4 form-label">Tahun Evaluasi</label>
                        <div class="col-12 col-md-8">
                            <select class="form-select" name="evaluation_years" id="tahun" required>
                                <option value="" disabled selected>Pilih Tahun</option>
                                @for ($year = now()->year; $year >= now()->year - 5; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Evaluasi - Performance --}}
        <div class="p-4 border bg-light">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                {{-- Judul --}}
                <div>
                    <h4 class="m-0">Performance</h4>
                </div>

                {{-- Legend --}}
                <ul class="d-flex flex-wrap gap-4 list-unstyled mb-0">
                    @php
                     // nilai dibawah dikali 20 = 20,40,60,80,100
                        $scores = [
                            100 => 'Excellent',
                            80 => 'Good',
                            60 => 'Average',
                            40 => 'Below Standard',
                            20 => 'Unsatisfactory',
                        ];
                    @endphp

                    @foreach ($scores as $score => $label)
                        <li class="d-flex align-items-center gap-2">
                            <span class="rounded-circle border border-dark border-2 d-flex justify-content-center align-items-center"
                                style="width: 28px; height: 28px;">{{ $score }}</span>
                            <span>= {{ $label }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="border p-3">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="align-middle">
                        <th scope="col">No</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Kriteria</th>
                        <th scope="col" class="text-center">Bobot</th>
                        <th scope="col" class="text-center">Evaluasi kinerja</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($criteriaP as $index => $criterion)
                        <tr class="align-middle">
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $criterion->code }}</td>
                            <td>{{ $criterion->criteria }}</td>
                            <td class="text-center">{{ $criterion->priority_weight }}</td>
                            <td class="border-start" style="width:500px;">
                                <fieldset class="my-2"">
                                    <div class="d-md-flex justify-content-between mx-3">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <div class="form-check">
                                                <input class="form-check-input border border-secondary"
                                                    type="radio"
                                                    name="C{{ $index + 1 }}"
                                                    value="{{ $i * 20 }}"
                                                    required>
                                                <label style="font-size: 12px;" class="form-check-label">
                                                    {{ ['Unsatisfactory','Below Standard','Average','Good','Excellent'][$i-1] }}
                                                </label>
                                            </div>
                                        @endfor
                                    </div>
                                </fieldset>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Evaluasi - Work Attitude --}}
        <div class="p-4 border bg-light">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                {{-- Judul --}}
                <div>
                    <h4 class="m-0">Work Attitude</h4>
                </div>

                {{-- Legend --}}
                <ul class="d-flex flex-wrap gap-4 list-unstyled mb-0">
                    @php
                    // nilai dibawah dikali 20 = 20,40,60,80,100
                        $scores = [
                           100 => 'Excellent',
                            80 => 'Good',
                            60 => 'Average',
                            40 => 'Below Standard',
                            20 => 'Unsatisfactory',
                        ];
                    @endphp

                    @foreach ($scores as $score => $label)
                        <li class="d-flex align-items-center gap-2">
                            <span class="rounded-circle border border-dark border-2 d-flex justify-content-center align-items-center"
                                style="width: 28px; height: 28px;">{{ $score }}</span>
                            <span>= {{ $label }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
       <div class="border p-3  rounded-bottom-3">
            <div class="table-responsive ">
                <table class="table">
                    <thead>
                        <tr class="align-middle">
                        <th scope="col">No</th>
                        <th scope="col">Kode</th>
                        <th scope="col">Kriteria</th>
                        <th scope="col" class="text-center">Bobot</th>
                        <th scope="col" class="text-center">Evaluasi kinerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($criteriaWA as $index => $criterion)
                        <tr class="align-middle">
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $criterion->code }}</td>
                            <td>{{ $criterion->criteria }}</td>
                            <td class="text-center">{{ $criterion->priority_weight }}</td>
                            <td class="border-start" style="width:500px;">
                                <fieldset class="my-2"">
                                    <div class="d-md-flex justify-content-between mx-3">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <div class="form-check">
                                                <input class="form-check-input border border-secondary"
                                                    type="radio"
                                                    name="C{{ $index + 11 }}"
                                                    value="{{ $i * 20 }}"
                                                    required>
                                                <label style="font-size: 12px;" class="form-check-label">
                                                    {{ ['Unsatisfactory','Below Standard','Average','Good','Excellent'][$i-1] }}
                                                </label>
                                            </div>
                                        @endfor
                                    </div>
                                </fieldset>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tombol Kirim --}}
        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn btn-primary fw-bold py-2 d-flex align-items-center justify-content-center gap-3 rounded-3 shadow" style="width: 200px;"><span>Simpan Evaluasi</span>
                <span class="material-symbols-rounded">
                save
                </span>
            </button>
        </div>
    </form>
</div>
