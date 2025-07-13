<div class="table-responsive">
  <div style="min-width: 800px">
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
            @forelse ($employeeUsers as $employee)
            <tr class="align-middle">
                <th scope="row">{{ $employeeUsers->firstItem() + $loop->index }}</th>
                <td style="width: 250px;">{{ $employee->fullname}}</td>
                <td style="width: 150px;">{{ $employee->username }}</td>
                <td style="width: 300px;">{{ $employee->email }}</td>
                <td style="width: 250px;">
                <input type="password" class="form-control rounded-2 w-50" id="inputPassword" value="{{ ($employee->password) }}" disabled>
                </td>
                <td style="width: 150px;">
                    <spa class="btn bg-white  border-2 rounded-3 py-1 {{ $employee->status === 'Aktif' ? 'border-success text-success' : 'border-danger text-danger' }}" >{{ ($employee->status) }}</spa>
                </td>
                <td style="width: 100px;" class="text-center">
                    <button type="button" class="btn btn-warning edit-btn rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal{{ $employee->id }}" data-id="{{ $employee->id }}">
                        <span class="material-symbols-rounded text-dark mt-1 fs-4">
                        edit_square
                        </span>
                    </button>
                    @include('partials.superadmins.authManage.editEmployee')
                </td>
            </tr>
            @empty
            <tr>
            <td class="align-middle text-center" colspan="7">Data Kosong! Silahkan Input Data.</td>
            </tr>
            @endforelse
        </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $employeeUsers->links('pagination::bootstrap-4') }}
    </div>
</div>
