
<div class="px-md-4 py-4 p-2 border rounded-top-4 bg-light">
    <h4>Grafik Evaluasi Berdasarkan Tahap</h4>
</div>

<div class="p-5 bg-white border border-top-0 rounded-bottom-4">
    <div class="row">
        <!-- Sidebar Nama -->
        <div class="col-md-3">
            <div class="d-flex flex-column">
                <label class=" p-2 bg-primary border border-2 border-primary rounded-top-3 text-center fw-bold text-white" for="">List Karyawan</label>
                @foreach ($evaluasi as $index => $data)
                    <button
                        type="button"
                        class="btn btn-outline-light rounded-0 text-dark border border-top-0 text-start w-100 {{ $loop->first ? 'active' : '' }}"
                        onclick="updateChart({{ $loop->index }})"
                        id="fullname-btn-{{ $loop->index }}">
                        {{ $data->fullname }}
                    </button>
                @endforeach
            </div>
            <div class="mt-4 d-flex justify-content-center" >
                {{ $evaluasi->appends(['tahap' => $tahap])->links('pagination::bootstrap-4')  }}
            </div>
        </div>



        <!-- Grafik -->
        <div class="col-md-9">
            <div class="px-4 py-3 bg-white border shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex gap-3 align-items-center">
                        <h5 class="fw-bold mb-3" id="chartTitle">{{ $evaluasi[0]->fullname ?? '-' }}</h5>
                        {{-- Filter Tahap --}}
                        <form method="GET" class="mb-3" onsubmit="showLoading('swipe')>
                            <div class="d-flex gap-3 align-items-center">
                                <select name="tahap" id="tahap" class="form-select w-auto" onchange="this.form.submit()">
                                    @foreach (['t1', 't2', 't3', 't4'] as $t)
                                        <option value="{{ $t }}" {{ $tahap === $t ? 'selected' : '' }}>Tahap {{ strtoupper($t) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <canvas id="evaluationChart" style="max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const evaluationData = @json($evaluasi->items()); // hanya item halaman aktif

    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("evaluationChart").getContext("2d");
        const first = evaluationData[0];

        chart = new Chart(ctx, {
            type: 'line',
            data: getChartData(first),
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `Skor: ${ctx.parsed.y.toFixed(2)}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 20,
                        max: 100,
                        ticks: {
                            stepSize: 20
                        }
                    }
                },
                elements: {
                    line: {
                        tension: 0.4,
                        borderWidth: 3
                    },
                    point: {
                        radius: 4,
                        backgroundColor: '#0d6efd'
                    }
                }
            }
        });
    });

    function getChartData(data) {
        const labels = Array.from({length: 15}, (_, i) => `C${i + 1}`);
        const values = labels.map(label => parseFloat(data[label]) || 0);

        return {
            labels: labels,
            datasets: [{
                label: 'Nilai Kriteria',
                data: values,
                fill: true,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.2)'
            }]
        };
    }

    function updateChart(index) {
        const data = evaluationData[index];
        document.getElementById('chartTitle').textContent = data.fullname;
        chart.data = getChartData(data);
        chart.update();

        evaluationData.forEach((_, i) => {
            document.getElementById(`fullname-btn-${i}`).classList.remove('active');
        });
        document.getElementById(`fullname-btn-${index}`).classList.add('active');
    }
</script>
