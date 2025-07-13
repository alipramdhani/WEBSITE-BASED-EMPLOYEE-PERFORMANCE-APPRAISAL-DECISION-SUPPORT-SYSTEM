
{{-- Tabel Hasil Clustering --}}
<div class="table-responsive">
    <table class="table">
        <thead class="table-light">
            <tr class="text-center">
                <th>Cluster 1 <br> Kinerja Terbaik</th>
                <th>Cluster 2 <br> Kinerja Biasa</th>
                <th>Cluster 3 <br> Kinerja Terendah</th>
            </tr>
        </thead>
        <tbody>
            @if ($kmeansResult->isNotEmpty())
                <tr>
                    {{-- Nama karyawan per cluster --}}
                    <td>
                        @foreach ($cluster1 as $item)
                            <div class="mb-2">{{ $item->fullname }}</div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($cluster2 as $item)
                            <div class="mb-2">{{ $item->fullname }}</div>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($cluster3 as $item)
                            <div class="mb-2">{{ $item->fullname }}</div>
                        @endforeach
                    </td>
                </tr>

                <tr>
                    {{-- Ringkasan jumlah --}}
                    <td class="text-justify">
                        <strong>Kesimpulan :</strong> Pengelompokan karyawan berdasarkan <strong class="text-success">Kinerja Terbaik</strong> terdiri dari
                        <strong>{{ $cluster1->count() }}</strong> karyawan.
                    </td>
                    <td class="text-justify">
                        <strong>Kesimpulan :</strong> Pengelompokan karyawan berdasarkan <strong class="text-warning">Kinerja Biasa</strong> terdiri dari
                        <strong>{{ $cluster2->count() }}</strong> karyawan.
                    </td>
                    <td class="text-justify">
                        <strong>Kesimpulan :</strong> Pengelompokan karyawan berdasarkan <strong class="text-danger">Kinerja Terendah</strong> terdiri dari
                        <strong>{{ $cluster3->count() }}</strong> karyawan.
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada hasil clustering untuk tahun ini.</td>
                </tr>
            @endif

        </tbody>
    </table>
</div>
