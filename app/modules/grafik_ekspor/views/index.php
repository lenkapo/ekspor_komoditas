<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Analisis Visual Ekspor
            <small>Grafik Komoditas dan Negara Tujuan</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">

            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Volume Ekspor Total (Kg) per Komoditas</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart-responsive">
                            <canvas id="komoditasBarChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Proporsi Nilai Ekspor Total (USD) per Negara Tujuan</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart-responsive">
                            <canvas id="negaraDoughnutChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function() {
        // --- Data PHP yang sudah di-encode menjadi JSON ---
        const labelsKomoditas = <?= $labels_komoditas; ?>;
        const dataQty = <?= $data_qty; ?>;
        const labelsNegara = <?= $labels_negara; ?>;
        const dataNilai = <?= $data_nilai; ?>;

        // Fungsi untuk menghasilkan warna solid acak
        function getRandomColor(alpha = 1) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        // Fungsi untuk menghasilkan array warna sebanyak data
        function generateColors(count, alpha = 0.6) {
            const colors = [];
            for (let i = 0; i < count; i++) {
                colors.push(getRandomColor(alpha));
            }
            return colors;
        }

        // ===========================================
        // 1. BAR CHART: Volume Ekspor per Komoditas
        // ===========================================
        const komoditasChartCanvas = $('#komoditasBarChart').get(0).getContext('2d');
        const komoditasChartData = {
            labels: labelsKomoditas,
            datasets: [{
                label: 'Total Volume (Kg)',
                backgroundColor: generateColors(labelsKomoditas.length, 0.8),
                borderColor: generateColors(labelsKomoditas.length, 1),
                borderWidth: 1,
                data: dataQty
            }]
        };

        const komoditasChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Volume (Kg)'
                    }
                }]
            }
        };

        new Chart(komoditasChartCanvas, {
            type: 'bar',
            data: komoditasChartData,
            options: komoditasChartOptions
        });


        // ===========================================
        // 2. DOUGHNUT CHART: Nilai Ekspor per Negara
        // ===========================================
        const negaraChartCanvas = $('#negaraDoughnutChart').get(0).getContext('2d');
        const negaraChartData = {
            labels: labelsNegara,
            datasets: [{
                data: dataNilai,
                backgroundColor: generateColors(labelsNegara.length),
            }]
        };

        const negaraChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        const label = data.labels[tooltipItem.index] || '';
                        const value = data.datasets[0].data[tooltipItem.index];
                        const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(1);
                        return label + ': $' + value.toLocaleString('en-US') + ' (' + percentage + '%)';
                    }
                }
            }
        };

        new Chart(negaraChartCanvas, {
            type: 'doughnut',
            data: negaraChartData,
            options: negaraChartOptions
        });
    });
</script>