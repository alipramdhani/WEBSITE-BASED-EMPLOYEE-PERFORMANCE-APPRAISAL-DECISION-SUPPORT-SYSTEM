<!-- Modal Bootstrap -->
<div class="modal fade" id="createCriteriaModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered justify-content-center">
        <div class="modal-content  rounded-4 mx-md-0 mx-5">
             <form action="{{ Auth::user()->role === 'superadmin' ? route('criteriaManage.superadmin.create') : route('criteriaManage.admin.create') }}" method="POST" onsubmit="showLoading('processing')">
                @csrf
                @method('POST')
                 <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="">
                    <div class="mb-3">
                        <label for="code" class="form-label">Kode</label>
                        <input type="text" class="form-control" name="code" placeholder="Tambahkan Kriteria" required>
                    </div>
                    <div class="mb-3">
                        <label for="criteria" class="form-label">Kriteria</label>
                        <input type="text" class="form-control" name="criteria" placeholder="Tambahkan Kriteria" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis Kriteria</label>
                        <select class="form-select" name="type" id="status">
                            <option disabled selected>--- Pilih Jenis Kriteria ---</option>
                            <option value="Performance">Performance</option>
                            <option value="Work Attitude">Work Attitude</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="priority_level" class="form-label">Tingkat Kepentingan</label>
                        <select class="form-select" name="priority_level" id="status">
                            <option disabled selected>--- Pilih Tingkat Kepentingan ---</option>
                            <option value="Sangat Penting">Sangat Penting</option>
                            <option value="Penting">Penting</option>
                            <option value="Biasa">Biasa</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
