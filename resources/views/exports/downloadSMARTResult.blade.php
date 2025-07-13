<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 5px; text-align: center; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <h3>Detail Evaluasi Karyawan</h3>
  <p><strong>Nama:</strong> {{ $user->fullname }}</p>
  <p><strong>Departemen:</strong> {{ $user->departement ?? '-' }}</p>
  <p><strong>Status:</strong> {{ $user->employeementStatus ?? '-' }}</p>
  <p><strong>Tahap Evaluasi:</strong> {{ $tahap }}</p>

  @php
      $t = strtolower($tahap); // t1, t2, t3
      $evaluasi = $evaluations[$t][$user->id] ?? null;
      $utility = $utilities[$t][$user->id] ?? null;
      $smart = $finalScoreSmart[$t][$user->id] ?? null;
  @endphp

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Kriteria</th>
        <th>Bobot</th>
        <th>Normalisasi</th>
        <th>Evaluasi</th>
        <th>Utility</th>
        <th>Skor SMART</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($criteria as $i => $c)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $c->criteria }}</td>
        <td>{{ $c->priority_weight }}</td>
        <td>{{ number_format($c->normalized_weight, 3) }}</td>
        <td>{{ $evaluasi ? number_format($evaluasi->{'C'.($i+1)}, 0) : '-' }}</td>
        <td>{{ $utility ? number_format($utility->{'C'.($i+1)}, 2) : '-' }}</td>
        <td>{{ $smart ? number_format($smart->{'C'.($i+1)}, 4) : '-' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
