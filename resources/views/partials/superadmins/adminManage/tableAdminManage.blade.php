<div class="table-responsive">
  <div style="min-width: 800px">
    <table class="table">
      <thead class="table" >
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Lengkap</th>
          <th scope="col">Jenis Kelamin</th>
          <th scope="col">Departemen</th>
          <th scope="col">Tahun Kerja</th>
          <th scope="col">Status Pekerjaan</th>
          <th scope="col">Role</th>
          <th scope="col" class="text-center">Edit</th>
          <th scope="col" class="text-center">Delete</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($adminData as $ad)
        <tr class="align-middle">
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $ad->fullname}}</td>
            <td>{{ $ad->gender }}</td>
            <td>{{ $ad->departement }}</td>
            <td>{{ $ad->workYears}}</td>
            <td>{{ $ad->employeementStatus}}</td>
            <td>{{ $ad->role}}</td>
            <td class="text-center">
                <button type="button" class="btn btn-warning edit-btn rounded-circle" data-bs-toggle="modal" data-bs-target="#editAdminModal{{ $ad->id }}" data-id="{{ $ad->id }}">
                    <span class="material-symbols-rounded text-dark mt-1 fs-4">
                    edit_square
                    </span>
                </button>
                @include('partials.superadmins.adminManage.editAdminData')
            </td>
            <td class="text-center">
                <form id="formdelete-{{ $ad->id }}" action="{{ route('adminManage.delete', $ad->id) }}" method="POST" onsubmit="showLoading('processing')">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger rounded-circle" onclick="confirmDelete({{ $ad->id }})">
                    <span class="material-symbols-rounded text-white mt-1 fs-4">
                    delete
                    </span>
                </button>
            </form></td>
        </tr>
        @empty
        <tr class="align-middle text-center">
          <td  colspan="7">Data Kosong! Silahkan Input Data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
