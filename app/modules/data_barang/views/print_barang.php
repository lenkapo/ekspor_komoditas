<!DOCTYPE html>
<html>

<head>
    <title>Print Data</title>
    <style>
        /* gaya untuk print jika perlu */
        @media print {

            /* contoh: sembunyikan tombol */
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div id="print‐area">
        <h2>Data: <?= htmlspecialchars($data->name) ?></h2>
        <p><?= nl2br(htmlspecialchars($data->description)) ?></p>
        <!-- tambahkan elemen yang ingin dicetak -->
    </div>

    <button class="no-print" onclick="window.print()">Print Sekarang</button>
</body>

</html>