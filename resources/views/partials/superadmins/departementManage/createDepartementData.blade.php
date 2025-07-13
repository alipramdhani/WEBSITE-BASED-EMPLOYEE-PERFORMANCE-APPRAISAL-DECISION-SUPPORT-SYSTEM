<!-- Modal Bootstrap -->
<div class="modal fade" id="createDepartementModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered justify-content-center">
        <div class="modal-content  rounded-4 mx-md-0 mx-5">
            <form action="{{  route('departementManage.create')}}" method="POST" onsubmit="showLoading('processing')">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Tambah Departemen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="">
                    <div class="mb-3">
                        <label for="departement" class="form-label">Departemen</label>
                        <input type="text" class="form-control" name="departement" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe</label>
                        <select class="form-select" name="type" id="status">
                            <option disabled selected>--- Tipe ---</option>
                            <option value="Staff">Staff</option>
                            <option value="Employee">Employee</option>
                        </select>
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
