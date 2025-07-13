<div class="border bg-white rounded-5 p-5">
    {{-- Tabel Centroid Pertama | Halaman Hasil Evaluasi --}}
    <section id="GenerateCentroid" class="rounded-4">
        <div class="border rounded-4 overflow-hidden">
            <div class="bg-light px-4 py-3 border-bottom">
                <h3 class="d-flex fw-bold align-items-center m-0"> Menentukan Centroid (Titik Pusat) </h3>
            </div>
            <div class="bg-white p-5">
                @include('partials.admins.evaluationResult.tableCentroidFirst')
            </div>
        </div>
    </section>

    {{-- Tabel Hasil Cluster | Halaman Hasil Evaluasi --}}
    <section id="GenerateCentroid" class="rounded-4 mt-5">
        <div class="border rounded-4 overflow-hidden">
            <div class="bg-light px-4 py-3 border-bottom">
                <h3 class="d-flex fw-bold align-items-center m-0"> Hasil Clustering Algoritma K-Means </h3>
            </div>
            <div class="bg-white p-5">
                @include('partials.admins.evaluationResult.tableResultKMEANS')
            </div>
        </div>
    </section>

    {{-- Tabel Pengelompokan Karyawan | Halaman Hasil Evaluasi --}}
    <section id="GenerateCentroid" class="rounded-4 mt-5">
        <div class="border rounded-4 overflow-hidden">
            <div class="bg-light px-4 py-3 border-bottom">
                <h3 class="d-flex fw-bold align-items-center m-0"> Hasil Pengelompokan Karyawan Berdasarkan Kinerja </h3>
            </div>
            <div class="bg-white p-5">
                @include('partials.admins.evaluationResult.tableClusteringEmployee')
            </div>
        </div>
    </section>
</div>
