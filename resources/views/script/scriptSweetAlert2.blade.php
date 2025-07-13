<script>
function logout() {
    Swal.fire({
        title: 'Yakin ingin keluar website?',
        text: "Keluar dari halaman ini!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Keluar',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formlogout').submit();
        }
    });
}
function confirmDelete(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data akan dihapus secara permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
         if (result.isConfirmed) {
            // 1. Tampilkan overlay
            showLoading('processing');

            // 2. Submit form
            const form = document.getElementById('formdelete-' + id);
            if (form) {
                form.submit();
            } else {
                console.error(`Form dengan ID formdelete-${id} tidak ditemukan.`);
            }
        }
    });
}
</script>
