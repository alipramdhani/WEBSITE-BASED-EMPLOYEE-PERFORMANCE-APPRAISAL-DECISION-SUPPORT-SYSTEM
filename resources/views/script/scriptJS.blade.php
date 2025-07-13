<script>
    const searchInput = document.getElementById('liveSearch');
    const rows        = document.querySelectorAll('#performanceTable tbody tr');

    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value.trim().toLowerCase();

        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const match   = rowText.includes(keyword);

            // Tampilkan/sembunyikan baris
            row.style.display = match || !keyword ? '' : 'none';

            // Tambah/hapus warna sorotan
            row.classList.toggle('highlight-row', match && keyword);
        });
    });
</script>


{{-- Loading Screen --}}
<script>
    function showLoading(mode = 'processing') {
        const overlay = document.getElementById('loadingOverlay');
        const text = document.getElementById('loadingText');

        text.textContent = mode === 'login'
            ? 'Sedang masuk ke sistem...'
            : mode === 'logout'
            ? 'Sedang keluar...'
            : mode === 'swipe'
            ? 'Tunggu Sesaat...'
            : 'Sedang memproses data...';

        overlay.style.display = 'flex';

        // Matikan tombol submit agar tidak diklik berkali-kali
        const buttons = document.querySelectorAll('button[type="submit"]');
        buttons.forEach(btn => btn.disabled = true);
    }
</script>

{{-- Pagenation --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tahap-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        const target = this.getAttribute('data-target');
        const container = this.closest('.modal-body');

        // Sembunyikan semua tahap
        container.querySelectorAll('.tahap-section').forEach(function (section) {
          section.style.display = 'none';
        });

        // Tampilkan tahap yang diklik
        const selected = container.querySelector('#' + target);
        if (selected) selected.style.display = 'block';
      });
    });
  });
</script>

{{-- Warna Nav Button switch --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabLinks = document.querySelectorAll('#evaluationTabs .nav-link');

    tabLinks.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function () {
            tabLinks.forEach(link => {
                if (link.classList.contains('active')) {
                    link.classList.add('text-white', 'bg-primary','border', 'border-primary');
                    link.classList.remove('text-primary');
                } else {
                    link.classList.add('text-primary', 'border', 'border-primary');
                    link.classList.remove('text-white', 'bg-primary',);
                }
            });
        });
    });

    // Set initial state on load (untuk pertama kali)
    const activeTab = document.querySelector('#evaluationTabs .nav-link.active');
    if (activeTab) {
        activeTab.classList.add('text-white', 'bg-primary');
        activeTab.classList.remove('text-primary', 'border', 'border-primary');
    }
});
</script>
{{-- Mengganti judul sesuai tabel --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabTitle = document.getElementById('tabTitle');

    const tabLinks = document.querySelectorAll('#evaluationTabs .nav-link');

    tabLinks.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (event) {
            const selectedTab = event.target.textContent.trim();
            tabTitle.textContent = selectedTab + ' Kinerja';
        });
    });
});
</script>
{{-- Menginput otomatis form ketika nama dipanggil --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("fullname");
    const emailField = document.getElementById("email");
    const departementField = document.getElementById("departement");
    const employmentField = document.getElementById("employeementStatus");

    select.addEventListener("change", function () {
        const selected = this.options[this.selectedIndex];
        emailField.value = selected.dataset.email || '';
        departementField.value = selected.dataset.departement || '';
        employmentField.value = selected.dataset.employment || '';
    });
});
</script>
{{-- Tabel Admin Setting --}}
<script>

    function copyToClipboard(id) {
        const passwordInput = document.getElementById(`password-${id}`);
        passwordInput.select();
        passwordInput.setSelectionRange(0, 99999); // Mobile
        document.execCommand("copy");
        alert("Password berhasil disalin!");
    }
</script>
<!-- Toogle Eyes Form Login-->
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('inputPassword');
        const toggleIconPass = document.getElementById('toggleIconPass');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text'; // Tampilkan password
            toggleIconPass.textContent = 'visibility'; // Ganti ikon menjadi visibility
        } else {
            passwordInput.type = 'password'; // Sembunyikan password
            toggleIconPass.textContent = 'visibility_off'; // Ganti ikon menjadi visibility_off
        }
    }
</script>
{{-- Toggle Pass Form Edit Auth --}}
<script>
     function toggleEditPasswordVisibility(userId) {
        const passwordInput = document.getElementById(`inputEditPassword${userId}`);
        const toggleIcon = document.getElementById(`toggleIconEditPass${userId}`);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = 'visibility';
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = 'visibility_off';
        }
    }
</script>

<!-- Login Success Alert -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.getElementById('alertToast');
        const toast = new bootstrap.Toast(toastEl, {
            delay: 3000,
            autohide: true
        });
        toast.show();
    });
</script>
{{-- Sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Toogle Header --}}
<script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const toggleIcon = document.getElementById('toggleIcon');

        sidebar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');

        const isCollapsed = sidebar.classList.contains('collapsed');
        toggleIcon.innerHTML = isCollapsed
            ? '<img src="{{asset('images/hambbar.png')}}" style="width: 28px;" alt="hammbar">'
            : '<img src="{{asset('images/hambbar.png')}}" style="width: 28px;" alt="hammbar">';
    });
</script>

{{-- bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
</script>
