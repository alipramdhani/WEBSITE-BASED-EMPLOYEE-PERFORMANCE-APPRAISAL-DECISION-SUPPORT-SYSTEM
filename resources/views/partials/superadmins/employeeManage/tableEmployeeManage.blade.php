<div class="table-responsive">
  <div style="min-width: 800px;">
    <table class="table">
      <thead class="table">
        <tr>
          <th scope="col" >No</th>
          <th scope="col">Nama Lengkap</th>
          <th scope="col">Jenis Kelamin</th>
          <th scope="col">Departemen</th>
          <th scope="col">Tahun Kerja</th>
          <th scope="col">Status Pekerjaan</th>
          @if (Auth::user()->role === 'superadmin') {{-- Admin tidak dapat menghapus dan edit data --}}
          <th scope="col" class="text-center">Edit</th>
          <th scope="col" class="text-center">Hapus</th>
          @endif
        </tr>
      </thead>
      <tbody >
        @forelse ($employeeData as $employee)
        <tr class="align-middle">
            <th scope="row">{{ $employeeData->firstItem() + $loop->index }}</th>
            <td >{{ $employee->fullname}}</td>
            <td>{{ $employee->gender }}</td>
            <td>{{ $employee->departement }}</td>
            <td>{{ $employee->workYears}}</td>
            <td>{{ $employee->employeementStatus}}</td>
            @if (Auth::user()->role === 'superadmin') {{-- Admin tidak dapat menghapus dan edit data --}}
                <td class="text-center">
                    <button type="button" class="btn btn-warning edit-btn rounded-5" data-bs-toggle="modal" data-bs-target="#editEmployeeModal{{ $employee->id }}" data-id="{{ $employee->id }}">
                        <span class="material-symbols-rounded text-dark mt-1 fs-4">
                        edit_square
                        </span>
                    </button>
                    @include('partials.superadmins.employeeManage.editEmployeeData')
                </td>
                <td class="text-center">
                    <form id="formdelete-{{ $employee->id }}" action="{{ Auth::user()->role === 'superadmin' ? route('employeeManage.superadmin.delete', $employee->id) : route('employeeManage.admin.delete', $employee->id) }}" method="POST" onsubmit="showLoading('processing')">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger rounded-5" onclick="confirmDelete({{ $employee->id }})">
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
          <td  colspan="7">Data Kosong! Silahkan Input Data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $employeeData->links('pagination::bootstrap-4') }}
    </div>
</div>
