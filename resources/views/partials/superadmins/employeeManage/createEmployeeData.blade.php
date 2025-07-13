<!-- Modal Bootstrap -->
<div class="modal fade" id="createEmployeeModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered justify-content-center">
        <div class="modal-content  rounded-4 mx-md-0 mx-5">
            <form action="{{ Auth::user()->role === 'superadmin' ? route('employeeManage.superadmin.create') : route('employeeManage.admin.create') }}" method="POST" onsubmit="showLoading('processing')">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="fullname" placeholder="Tambahkan Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="gender" id="status">
                            <option disabled selected>--- Pilih Jenis Kelamin ---</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="departement" class="form-label">Departemen</label>
                        <select class="form-select" name="departement" id="status">
                           <option disabled selected>--- Pilih Departemen ---</option>
                            @foreach ($departementEmployee as $de)
                            <option value="{{ $de->departement }}">{{ $de->departement }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="workYears" class="form-label">Tahun Kerja</label>
                        <input type="workYears" class="form-control" name="workYears" placeholder="Tambahkan Tahun Kerja" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Tambahkan Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="employeementStatus" class="form-label">Jenis Pekerjaan</label>
                        <select class="form-select" name="employeementStatus" id="status">
                            <option disabled selected>--- Status Pekerjaan ---</option>
                            <option value="Tetap">Tetap</option>
                            <option value="Kontrak">Kontrak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" value="Employee" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
