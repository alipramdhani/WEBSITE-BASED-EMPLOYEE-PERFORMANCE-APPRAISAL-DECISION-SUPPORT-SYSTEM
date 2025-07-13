<!-- Modal Bootstrap -->
<div class="modal fade" id="editAdminModal{{ $ad->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $ad->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered justify-content-center">
        <div class="modal-content  rounded-4 mx-md-0 mx-5">
            <form action="{{ route('adminManage.update', $ad->id) }}" method="POST" onsubmit="showLoading('processing')>
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $ad->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdminModalLabel{{ $ad->id }}">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">

                    <div class="mb-3">
                        <label for="name{{ $ad->id }}" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="fullname" value="{{ $ad->fullname }}">
                    </div>
                    <div class="mb-3">
                        <label for="gender{{ $ad->id }}" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" name="gender" id="gender{{ $ad->id }}">
                            <option value="Pria" {{ $ad->gender === 'Pria' ? 'selected' : '' }}>Pria</option>
                            <option value="Wanita" {{ $ad->gender === 'Wanita' ? 'selected' : '' }}>Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="departement{{ $ad->id }}" class="form-label">Departemen</label>
                         <select class="form-select" name="departement" id="departement{{ $ad->id }}">
                             @foreach ($departementStaff as $ds)
                                <option value="{{ $ds->departement }}" {{ $ad->departement === $ds->departement ? 'selected' : '' }}>
                                    {{ $ds->departement }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="mb-3">
                        <label for="workYears{{ $ad->id }}" class="form-label">Tahun Kerja</label>
                        <input type="number" class="form-control" name="workYears" value="{{ $ad->workYears }}" >
                    </div>
                    <div class="mb-3">
                        <label for="employeementStatus{{ $ad->id }}" class="form-label">Status Pekerjaan</label>
                        <select class="form-select" name="employeementStatus" id="employeementStatus{{ $ad->id }}">
                            <option value="Kontrak" {{ $ad->employeementStatus === 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                            <option value="Tetap" {{ $ad->employeementStatus === 'Tetap' ? 'selected' : '' }}>Tetap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="workYears" class="form-control" name="role" value="Admin" disabled>
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
