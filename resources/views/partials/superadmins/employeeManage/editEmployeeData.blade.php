<!-- Modal Bootstrap -->
<div class="modal fade" id="editEmployeeModal{{ $employee->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $employee->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered justify-content-center">
        <div class="modal-content  rounded-4 mx-md-0 mx-5">
            <form action="{{ Auth::user()->role === 'superadmin' ? route('employeeManage.superadmin.update', $employee->id) : route('employeeManage.admin.update', $employee->id) }}" method="POST" onsubmit="showLoading('processing')">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $employee->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel{{ $employee->id }}">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">

                    <div class="mb-3">
                        <label for="name{{ $employee->id }}" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="fullname" value="{{ $employee->fullname }}">
                    </div>
                    <div class="mb-3">
                        <label for="gender{{ $employee->id }}" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="gender" id="gender{{ $employee->id }}">
                            <option value="Pria" {{ $employee->gender === 'Pria' ? 'selected' : '' }}>Pria</option>
                            <option value="Wanita" {{ $employee->gender === 'Wanita' ? 'selected' : '' }}>Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="departement{{ $employee->id }}" class="form-label">Departemen</label>
                         <select class="form-select" name="departement" id="departement{{ $employee->id }}">
                              @foreach ($departementEmployee as $de)
                                <option value="{{ $de->departement }}" {{ $employee->departement === $de->departement ? 'selected' : '' }}>
                                    {{ $de->departement }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="workYears{{ $employee->id }}" class="form-label">Tahun Kerja</label>
                        <input type="number" class="form-control" name="workYears" value="{{ $employee->workYears }}" >
                    </div>
                    <div class="mb-3">
                        <label for="employeementStatus{{ $employee->id }}" class="form-label">Status Pekerjaan</label>
                        <select class="form-select" name="employeementStatus" id="employeementStatus{{ $employee->id }}">
                            <option value="Kontrak" {{ $employee->employeementStatus === 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                            <option value="Tetap" {{ $employee->employeementStatus === 'Tetap' ? 'selected' : '' }}>Tetap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" value="Employee" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
