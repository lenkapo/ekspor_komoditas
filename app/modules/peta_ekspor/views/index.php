<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/temaalus/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<style>
    /* Styling untuk Legenda Leaflet */
    .info {
        padding: 6px 8px;
        font: 10px Arial, Helvetica, sans-serif;
        background: white;
        background: rgba(255, 255, 255, 0.8);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    .info h4 {
        margin: 0 0 5px;
        color: #777;
    }

    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin-right: 8px;
        opacity: 0.7;
        border-radius: 50%;
        /* Membuat kotak warna menjadi lingkaran */
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Peta Sebaran Ekspor</h1>
    </section>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Filter Data Ekspor Berdasarkan Waktu</h3>
                </div>
                <form action="<?= base_url('peta_ekspor/index'); ?>" method="post" class="form-inline" style="padding: 15px;">
                    <div class="form-group">
                        <label for="start_date">Dari Tanggal:</label>
                        <input type="date" class="form-control" name="start_date" id="start_date"
                            value="<?= isset($start_date) ? $start_date : ''; ?>" required>
                    </div>

                    <div class="form-group" style="margin-left: 10px;">
                        <label for="end_date">Sampai Tanggal:</label>
                        <input type="date" class="form-control" name="end_date" id="end_date"
                            value="<?= isset($end_date) ? $end_date : ''; ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
                        <i class="fa fa-filter"></i> Terapkan Filter
                    </button>
                    <a href="<?= base_url('peta_ekspor/index'); ?>" class="btn btn-default" style="margin-left: 5px;">
                        <i class="fa fa-refresh"></i> Reset Filter
                    </a>
                    <br>
                    <br>
                    <div id="exportMap" style="height: 500px;"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">

    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Definisikan ikon kustom untuk membedakan Pelabuhan Asal
    // Anda harus memuat CSS/JS Leaflet (jika belum) dan gambar ikon, 
    // tetapi ini adalah definisi JS minimal untuk Ikon Leaflet.
    const originIcon = L.icon({
        iconUrl: '<?= base_url("assets/img/port_marker_3.png"); ?>', // Ganti dengan path ikon Anda
        iconSize: [80, 80],
        iconAnchor: [40, 70],
        popupAnchor: [0, -51]
    });

    // =======================================================
    // FUNGSI BARU: Menentukan warna berdasarkan nilai (USD)
    // =======================================================
    function getColor(value) {
        // Angka threshold ini harus disesuaikan dengan range data ekspor aktual Anda!
        return value > 500000 ? '#e31a1c' : // Merah Tua (Tinggi)
            value > 250000 ? '#ff7f00' : // Oranye (Menengah ke Tinggi)
            value > 100000 ? '#ffb900' : // Kuning (Menengah)
            value > 50000 ? '#b3ffb3' : // Hijau Muda (Rendah)
            '#00ff00'; // Hijau Cerah (Sangat Rendah)
    }

    function getRadius(volume) {
        // Threshold volume (misalnya, dalam Kg)
        return volume > 100000 ? 15 : // Radius besar (Volume Sangat Tinggi)
            volume > 50000 ? 10 : // Radius sedang (Volume Tinggi)
            volume > 10000 ? 7 : // Radius kecil (Volume Menengah)
            5; // Radius default (Volume Rendah)
    }


    $(document).ready(function() {
        const mapData = <?= $map_data; ?>;
        // Inisialisasi Peta
        const map = L.map('exportMap').setView([-2.5, 118.0], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var legend = L.control({
            position: 'bottomright'
        });

        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'info legend'),
                // Ambil fungsi getColor dan getRadius yang sudah Anda definisikan di atas!
                colors = [500000, 250000, 100000, 50000, 0], // Threshold Nilai USD (Sama dengan di getColor)
                labels = [],
                from, to;

            // --- LEGEND UNTUK WARNA (NILAI EKSPOR USD) ---
            div.innerHTML += '<h4>Nilai Ekspor (USD)</h4>';
            for (var i = 0; i < colors.length; i++) {
                from = colors[i];
                to = colors[i + 1];

                if (i === 0) {
                    // Label untuk nilai tertinggi
                    labels.push(
                        '<i style="background:' + getColor(from + 1) + '"></i> ' +
                        '> $' + from.toLocaleString('en-US')
                    );
                } else if (i < colors.length - 1) {
                    // Label untuk rentang nilai
                    labels.push(
                        '<i style="background:' + getColor(from) + '"></i> $' +
                        to.toLocaleString('en-US') + ' &ndash; $' + from.toLocaleString('en-US')
                    );
                } else {
                    // Label untuk nilai terendah
                    labels.push(
                        '<i style="background:' + getColor(from) + '"></i> ' +
                        'Hingga $' + colors[i - 1].toLocaleString('en-US') // Ambil nilai threshold sebelumnya
                    );
                }
            }
            div.innerHTML += labels.join('<br>');

            // --- LEGEND UNTUK UKURAN (VOLUME EKSPOR KG) ---
            div.innerHTML += '<hr><h4>Volume Ekspor (Kg)</h4>';
            // Gunakan nilai threshold dari fungsi getRadius (100000, 50000, 10000)
            var volumes = [100000, 50000, 10000];

            volumes.forEach(function(v) {
                div.innerHTML +=
                    '<div style="margin-bottom: 5px;">' +
                    '<svg height="' + (getRadius(v) * 2) + '" width="' + (getRadius(v) * 2) + '" style="vertical-align: middle; margin-right: 5px;">' +
                    '<circle cx="' + getRadius(v) + '" cy="' + getRadius(v) + '" r="' + getRadius(v) + '" stroke="#333" stroke-width="1" fill="#bbb" />' +
                    '</svg>' +
                    '&nbsp;> ' + v.toLocaleString() + ' Kg' +
                    '</div>';
            });

            // Tambahkan label untuk volume terendah
            div.innerHTML +=
                '<div style="margin-bottom: 5px;">' +
                '<svg height="' + (getRadius(0) * 2) + '" width="' + (getRadius(0) * 2) + '" style="vertical-align: middle; margin-right: 5px;">' +
                '<circle cx="' + getRadius(0) + '" cy="' + getRadius(0) + '" r="' + getRadius(0) + '" stroke="#333" stroke-width="1" fill="#bbb" />' +
                '</svg>' +
                '&nbsp;Hingga ' + volumes[volumes.length - 1].toLocaleString() + ' Kg' +
                '</div>';

            return div;
        };

        legend.addTo(map);

        // --- TAMBAHKAN GUARD CLAUSE DI SINI ---
        if (mapData.length > 0) {
            let addedOriginPorts = {};
            let allMarkers = []; // Array untuk menyimpan semua marker/polyline boundaries

            // HAPUS BARIS 1. Tambahkan Penanda untuk Titik Asal (ORIGIN MARKER) yang redundan.
            // Gunakan logika di dalam loop untuk membuat marker asal berdasarkan data yang valid.

            // 2. Loop dan Tambahkan Penanda untuk Setiap Negara Tujuan
            mapData.forEach(function(marker) {
                const originKey = marker.origin.lat + ',' + marker.origin.lng; // ID unik pelabuhan

                // 1. TAMBAHKAN PENANDA PELABUHAN ASAL JIKA BELUM ADA
                if (!addedOriginPorts[originKey]) {
                    const originMarker = L.marker([marker.origin.lat, marker.origin.lng], {
                            icon: originIcon // Sekarang originIcon sudah didefinisikan!
                        }).addTo(map)
                        .bindPopup("<b>Pelabuhan Asal</b><br>Koordinat: " + marker.origin.lat + ", " + marker.origin.lng);

                    addedOriginPorts[originKey] = true;
                    allMarkers.push(originMarker);
                }


                // Buat pop-up detail
                const popupContent = `
                    <b>Tujuan: ${marker.negara_tujuan}</b><br>
                    Volume Ekspor: ${marker.volume.toLocaleString()} Kg<br>
                    Nilai Ekspor: $ ${marker.nilai.toLocaleString('en-US', { minimumFractionDigits: 2 })}
                `;

                // Tambahkan marker tujuan
                const destMarker = L.circleMarker([marker.lat, marker.lng], {
                        radius: getRadius(marker.volume), // Ukuran marker statis (bisa juga dibuat dinamis berdasarkan volume)
                        fillColor: getColor(marker.nilai), // WARNA DINAMIS
                        color: '#000', // Garis tepi hitam
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.9
                    }).addTo(map)
                    .bindPopup(popupContent);

                allMarkers.push(destMarker);
                // Tambahkan Garis Rute (Polyline)
                const routeLine = L.polyline([
                    [marker.origin.lat, marker.origin.lng],
                    [marker.lat, marker.lng]
                ], {
                    color: '#007bff', // Warna biru yang lebih jelas
                    weight: 2,
                    opacity: 0.8
                }).addTo(map);
            });

            // Sesuaikan view peta agar semua marker terlihat
            if (allMarkers.length > 0) {
                const group = new L.featureGroup(allMarkers);
                map.fitBounds(group.getBounds());
            }

        } else {
            // Jika data kosong, tampilkan notifikasi di tengah Indonesia
            console.log("Data ekspor tidak ditemukan.");
            L.marker([-2.5, 118.0]).addTo(map)
                .bindPopup("Tidak ada data ekspor yang cocok untuk periode ini.").openPopup();
        }
    });
</script>