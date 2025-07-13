<div class="table-responsive">
  <div style="min-width: 800px">
    <table class="table border">
      <thead class="table table-light border">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Lengkap</th>
          <th scope="col">Departemen</th>
          <th scope="col" class="text-center">Status Pekerjaan</th>
          <th scope="col" class="text-center">Evaluasi T1 <br> (Jan-Apr)</th>
          <th scope="col" class="text-center">Evaluasi T2 <br> (Mei-Aug)</th>
          <th scope="col" class="text-center">Evaluasi T3 <br> (Sep-Des)</th>
          <th scope="col" class="text-center">Lihat Hasil</th>
          @if (!Route::is('evaluation.admin.result') &&
               !Route::is('evaluation.superadmin.result') &&
               !Route::is('evaluation.employee.result'))
            <th scope="col" class="text-center">Hapus Hasil</th>
          @endif
        </tr>
      </thead>

      <tbody>
        @forelse (collect($employeDataStatus)->unique('fullname') as $eds)
          <tr class="align-middle">
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $eds->fullname }}</td>
            <td>{{ $eds->departement }}</td>
            <td class="text-center">{{ $eds->employeementStatus }}</td>

            @for ($t = 1; $t <= 3; $t++)
              <td class="text-center" style="width: 150px;">
                @php
                  $smart = $finalScoreSmart["t$t"][$eds->alternatif] ?? null;
                @endphp
                <div class="d-flex justify-content-center gap-2 align-items-center">
                  @if ($smart)
                    <span class="material-symbols-rounded p-1 bg-success rounded-circle text-white fs-6">check</span>
                    <span class="fw-semibold">Selesai</span>
                  @else
                    <span class="material-symbols-rounded text-danger">close</span>
                    <span class="fw-bold ms-1">Belum Selesai</span>
                  @endif
                </div>
              </td>
            @endfor

            <td class="text-center">
              <a type="button" class="btn btn-success pt-2 pb-0"
                 data-bs-toggle="modal"
                 data-bs-target="#reviewResultModal{{ $eds->alternatif }}">
                <span class="material-symbols-outlined">visibility</span>
              </a>
              @include('partials.admins.evaluation.reviewResult')
            </td>

            @if (!Route::is('evaluation.admin.result') &&
                 !Route::is('evaluation.superadmin.result') &&
                 !Route::is('evaluation.employee.result'))
              <td class="text-center">
                <a type="button" class="btn btn-danger pt-2 pb-0"
                   data-bs-toggle="modal"
                   data-bs-target="#deleteResultModal{{ $eds->alternatif }}">
                  <span class="material-symbols-outlined">delete</span>
                </a>
                @include('partials.admins.evaluation.deleteResult')
              </td>
            @endif
          </tr>
        @empty
          <tr class="align-middle text-center text-muted">
            <td colspan="9">Data Kosong! Silahkan Input Data.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
