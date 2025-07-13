<div class="table-responsive">
  <div style="min-width: 800px">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Departemen</th>
          <th scope="col">Tipe</th>
          <th scope="col">Dibuat</th>
          <th scope="col" class="text-center">Hapus</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($departements as $departement)
        <tr class="align-middle">
          <th scope="row">{{ $loop->iteration }}</th>
          <td >{{ $departement->departement}}</td>
          <td >{{ $departement->type }}</td>
           <td>{{ $departement->created_at->diffForHumans() }}</td>
          <td class="text-center">
            <form id="formdelete-{{ $departement->id }}" action="{{ route('departementManage.delete', $departement->id ) }}" method="POST" onsubmit="showLoading('processing')">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger rounded-circle" onclick="confirmDelete({{ $departement->id }})">
                    <span class="material-symbols-rounded text-white mt-1 fs-4">
                        delete
                        </span>
                </button>
            </form>
          </td>
        </tr>
        @empty
        <tr class="align-middle text-center">
          <td  colspan="5">Data Kosong! Silahkan Input Data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
