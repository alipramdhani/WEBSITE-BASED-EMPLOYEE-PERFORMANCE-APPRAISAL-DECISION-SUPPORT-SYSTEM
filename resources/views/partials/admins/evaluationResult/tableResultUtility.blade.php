<div class="table-responsive">
  @php
        $data = $utilitiesResults[$tahap] ?? collect();
    @endphp

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alternatif</th>
                @for ($i = 1; $i <= 15; $i++)
                    <th>U{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td>{{ $item->alternatif }}</td>
                    @for ($i = 1; $i <= 15; $i++)
                        <td>{{ number_format($item->{"C$i"}, 2) ?? '-' }}</td>
                    @endfor
                </tr>
            @empty
                <tr>
                    <td colspan="16" class="text-center text-muted">Belum ada data evaluasi untuk tahap ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
