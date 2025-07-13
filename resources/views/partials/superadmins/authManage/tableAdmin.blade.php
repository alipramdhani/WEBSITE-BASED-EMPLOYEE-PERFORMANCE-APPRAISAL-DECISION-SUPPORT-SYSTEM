
<div class="table-responsive">
  <div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama</th>
          <th scope="col">Username</th>
          <th scope="col">Email</th>
          <th scope="col">Password</th>
          <th scope="col">Status</th>
          <th scope="col" class="text-center">Edit</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($adminUsers as $admin)
        <tr class="align-middle">
            <th scope="row">{{ $loop->iteration }}</th>
            <td style="width: 250px;">{{ $admin->fullname}}</td>
            <td style="width: 150px;">{{ $admin->username }}</td>
            <td style="width: 300px;">{{ $admin->email }}</td>
            <td style="width: 250px;">
            <input type="password" class="form-control rounded-2 w-50" id="inputPassword" value="{{ ($admin->password) }}" disabled>
            </td>
            <td style="width: 150px;">
                <span class="btn bg-white border-2 rounded-3 py-1 {{ $admin->status === 'Aktif' ? 'border-success text-success' : 'border-danger text-danger' }}" >{{ ($admin->status) }}</span>
            </td>
            <td style="width: 100px;" class="text-center">
                <button type="button" class="btn btn-warning edit-btn rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal{{ $admin->id }}" data-id="{{ $admin->id }}">
                    <span class="material-symbols-rounded text-dark mt-1 fs-4">
                    edit_square
                    </span>
                </button>
                @include('partials.superadmins.authManage.editAdmin')
            </td>
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
