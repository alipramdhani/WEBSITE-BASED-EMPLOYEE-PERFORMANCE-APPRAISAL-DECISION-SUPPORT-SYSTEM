<!-- Modal Bootstrap -->
<div class="modal fade" id="editModal{{ $employee->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $employee->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered justify-content-center">
        <div class="modal-content w-75  rounded-4">
            <form action="{{ Auth::user()->role === 'superadmin' ? route('authManage.superadmin.update', $employee->id) : route('authManage.admin.update', $employee->id) }}" method="POST" onsubmit="showLoading('processing')">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $employee->id }}">Edit employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <input type="hidden" name="id" value="{{ $employee->id }}">
                    <div class="mb-3">
                        <label for="name{{ $employee->id }}" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="fullname" value="{{ $employee->fullname }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="username{{ $employee->id }}" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="{{ $employee->username }}" >
                    </div>
                    <div class="mb-3">
                        <label for="email{{ $employee->id }}" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $employee->email }}" >
                    </div>
                    <div class="mb-3">
                        <label for="password{{ $employee->id}}" class="form-label">Password</label>
                        <div class="input-group">
                            <input
                                id="inputEditPassword{{ $employee->id }}"
                                type="password"
                                class="form-control"
                                name="password"
                                value="{{ $employee->password }}">

                            <span
                                id="toggleIconEditPass{{ $employee->id }}"
                                class="btn border material-symbols-rounded"
                                onclick="toggleEditPasswordVisibility({{ $employee->id }})"
                                style="cursor: pointer;">
                                visibility_off
                            </span>
                        </div>

                    </div>
                     <div class="mb-3">
                        <label for="status{{ $employee->id }}" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status{{ $employee->id }}">
                            <option value="Aktif" {{ $employee->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ $employee->status === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
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
