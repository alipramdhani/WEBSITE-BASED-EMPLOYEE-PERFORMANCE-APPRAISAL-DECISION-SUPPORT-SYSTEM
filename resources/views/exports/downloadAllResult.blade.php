<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Clustering Karyawan - {{ $tahun }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 20px;
            background-color: #fff;
        }

        h3 {
            margin-bottom: 20px;
            text-align: center;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-weight: bold;
            background-color: #f2f2f2;
            padding: 10px;
            border: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 4px;
            color: white;
        }

        .bg-success {
            background-color: #28a745;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #333;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #999;
        }
    </style>
</head>

<body>

    <h3>Laporan Hasil Evaluasi dan Pengelompokan Karyawan - {{ $tahun }}</h3>

        <!-- Tabel Total Skor Akhir & Jarak Tiap Cluster -->
        <div class="section">
            <div class="section-title">Tabel Total Skor Akhir dan Jarak ke Centroid</div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th class="text-center">Alternatif</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Skor Akhir <br> SMART T1</th>
                        <th class="text-center">Skor Akhir <br> SMART T2</th>
                        <th class="text-center">Skor Akhir <br> SMART T3</th>
                        <th class="text-center">Total Skor Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($finalScoreTotal as $fst)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $fst->fullname }}</td>
                            <td>{{ $fst->alternatif }}</td>
                            <td>{{ $fst->evaluation_years }}</td>
                            <td class="text-center">{{ $fst->score_t1 ?? '-' }}</td>
                            <td class="text-center">{{ $fst->score_t2 ?? '-' }}</td>
                            <td class="text-center">{{ $fst->score_t3 ?? '-' }}</td>
                            <td class="text-center">{{ $fst->final_score_total ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data Total Skor Akhir untuk tahun ini.</td>
                        </tr>
                        @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabel Centroid -->
        <div class="section">
            <div class="section-title">Tabel Pusat Klaster Pertama</div>
            <table>
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Terpilih</th>
                        <th>Pusat Klaster</th>
                        <th>Total Skor Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($centroidFirst as $cf)
                    <tr>
                        <td>{{ $cf->evaluation_years }}</td>
                        <td>{{ $cf->selected }}</td>
                        <td>{{ $cf->centroid }}</td>
                        <td>{{ $cf->final_score_total ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data centroid untuk tahun ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabel Hasil Clustering -->
        <div class="section">
            <div class="section-title">Hasil Pengelompokan Karyawan - Algoritma K-Means Clustering</div>
            <table>
                <thead>
                    <tr>
                        <th>Cluster</th>
                        <th>Nama</th>
                        <th>Total Skor Akhir</th>
                        <th>C1</th>
                        <th>C2</th>
                        <th>C3</th>
                        <th>Jarak Terdekat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kmeansResult as $data)
                    <tr>
                        <td>
                            <span class="badge
                                @if($data->cluster == 'C1') bg-success
                                @elseif($data->cluster == 'C2') bg-warning
                                @else bg-danger
                                @endif">
                                {{ $data->cluster }}
                            </span>
                        </td>
                        <td>{{ $data->fullname }}</td>
                        <td>{{ $data->final_score_total }}</td>
                        <td>{{ $data->distance_c1 }}</td>
                        <td>{{ $data->distance_c2 }}</td>
                        <td>{{ $data->distance_c3 }}</td>
                        <td>{{ $data->closest_distance }}</td>
                    </tr>
                     @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data centroid untuk tahun ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Tabel Kesimpulan Akhir -->
        <div class="section">
            <div class="section-title">Kesimpulan Hasil Clustering - Algoritma K-Means Clustering</div>
            <table>
                <thead>
                    <tr>
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
                            Pengelompokan karyawan berdasarkan <strong class="text-success">Kinerja Terbaik</strong> terdiri dari
                            <strong>{{ $cluster1->count() }}</strong> karyawan dengan rincian sebagai berikut.
                        </td>
                        <td class="text-justify">
                            Pengelompokan karyawan berdasarkan <strong class="text-warning">Kinerja Biasa</strong> terdiri dari
                            <strong>{{ $cluster2->count() }}</strong> karyawan dengan rincian sebagai berikut.
                        </td>
                        <td class="text-justify">
                            Pengelompokan karyawan berdasarkan <strong class="text-danger">Kinerja Terendah</strong> terdiri dari
                            <strong>{{ $cluster3->count() }}</strong> karyawan dengan rincian sebagai berikut.
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

</body>

</html>
