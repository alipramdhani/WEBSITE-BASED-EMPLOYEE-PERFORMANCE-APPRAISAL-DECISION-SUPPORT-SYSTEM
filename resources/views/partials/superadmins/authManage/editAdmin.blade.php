<!-- Modal Bootstrap -->
<div class="modal fade" id="editModal{{ $admin->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $admin->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered justify-content-center">
        <div class="modal-content w-75  rounded-4">
             <form action="{{ Auth::user()->role === 'superadmin' ? route('authManage.superadmin.update', $admin->id) : route('authManage.admin.update', $admin->id) }}" method="POST" onsubmit="showLoading('processing')">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $admin->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $admin->id }}">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">

                    <div class="mb-3">
                        <label for="name{{ $admin->id }}" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="fullname" value="{{ $admin->fullname }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="username{{ $admin->id }}" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="{{ $admin->username }}" >
                    </div>
                    <div class="mb-3">
                        <label for="email{{ $admin->id }}" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $admin->email }}" >
                    </div>
                    <div class="mb-3">
                        <label for="password{{ $admin->id}}" class="form-label">Password</label>
                        <div class="input-group">
                            <input id="inputEditPassword" type="password" class="form-control" name="password" value="{{ $admin->password }}">
                            <span id="toggleIconEditPass" class="btn border material-symbols-rounded" onclick="toggleEditPasswordVisibility()" style="cursor: pointer;">
                                visibility_off
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status{{ $admin->id }}" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status{{ $admin->id }}">
                            <option value="Aktif" {{ $admin->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ $admin->status === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
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
