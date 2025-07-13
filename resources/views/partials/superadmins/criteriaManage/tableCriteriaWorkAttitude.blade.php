<div class="table-responsive">
  <div style="min-width: 800px">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Kode</th>
          <th scope="col">Kriteria</th>
          <th scope="col" class="text-center">Tingkat Kepentingan</th>
          <th scope="col" class="text-center">Bobot Kepentingan</th>
          <th scope="col" class="text-center">Normaliasi Bobot</th>
          @if (Auth::user()->role === 'superadmin') {{--- Admin tidak bisa menghapus data ---}}
          <th scope="col">Hapus</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse ($criteriaWA as $cwa)
        <tr class="align-middle">
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $cwa->code}}</td>
            <td>{{ $cwa->criteria }}</td>
            <td class="text-center">{{ $cwa->priority_level}}</td>
            <td class="text-center">{{ number_format($cwa->priority_weight) }}%</td>
            <td class="text-center">{{ number_format($cwa->normalized_weight, 4) }}</td>
            @if (Auth::user()->role === 'superadmin') {{--- Admin tidak bisa menghapus data ---}}
            <td>
                <form id="formdelete-{{ $cwa->id }}" action="{{ route('criteriaManage.superadmin.delete', $cwa->id) }}" method="POST" onsubmit="showLoading('processing')">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger rounded-circle" onclick="confirmDelete({{ $cwa->id }})">
                        <span class="material-symbols-rounded text-white mt-1 fs-4">
                        delete
                        </span>
                    </button>
                </form>
            </td>
            @endif

        </tr>
        @empty
        <tr class="align-middle text-center">
          <td  colspan="9">Data Kosong! Silahkan Input Data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
