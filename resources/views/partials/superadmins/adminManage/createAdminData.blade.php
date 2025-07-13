<!-- Modal Bootstrap -->
<div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="createAdminModalLabel" aria-hidden="true">
   <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <form action="{{ route('adminManage.create') }}" method="POST" onsubmit="showLoading('processing')">
             @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createAdminModalLabel">Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Tambahkan Nama Lengkap" required>
                        <div class="invalid-feedback">Nama wajib diisi.</div>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="gender" id="gender" required>
                            <option disabled selected value="">--- Pilih Jenis Kelamin ---</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                        <div class="invalid-feedback">Jenis kelamin wajib dipilih.</div>
                    </div>
                    <div class="mb-3">
                        <label for="departement" class="form-label">Departemen</label>
                        <select class="form-select" name="departement" id="departement">
                           <option disabled selected>--- Pilih Departemen ---</option>
                            @foreach ($departementStaff as $ds)
                            <option value="{{ $ds->departement }}">{{ $ds->departement }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="workYears" class="form-label">Tahun Kerja</label>
                        <input type="number" class="form-control" name="workYears" id="workYears" placeholder="Tambahkan Tahun Kerja" min="0" required>
                        <div class="invalid-feedback">Tahun kerja wajib diisi.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Tambahkan Email" required>
                        <div class="invalid-feedback">Email tidak boleh kosong dan harus valid.</div>
                    </div>
                    <div class="mb-3">
                        <label for="employeementStatus" class="form-label">Status Kepegawaian</label>
                        <select class="form-select" name="employeementStatus" id="employeementStatus" required>
                            <option disabled selected value="">--- Pilih Status Kepegawaian ---</option>
                            <option value="Tetap">Tetap</option>
                            <option value="Kontrak">Kontrak</option>
                        </select>
                        <div class="invalid-feedback">Status kepegawaian wajib dipilih.</div>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" value="Admin" disabled>
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
