<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTask Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    @yield('content')


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        // 3. Mengambil data dari variabel Controller
        const dataBelum = {{ $belum ?? 0 }};
        const dataProses = {{ $proses ?? 0 }};
        const dataSelesai = {{ $selesai ?? 0 }};

        // 4. Konfigurasi Grafik
        const ctx = document.getElementById('statusTaskChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut', // Jenis grafik lingkaran/donat
            data: {
                labels: ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai'],
                datasets: [{
                    data: [dataBelum, dataProses, dataSelesai],
                    backgroundColor: [
                        '#6c757d', // Abu-abu untuk Pending/Belum
                        '#ffc107', // Kuning untuk Progress/Sedang
                        '#198754'  // Hijau untuk Selesai/Completed
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom', // Posisi keterangan warna di bawah
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            }
        });
    });
    </script>
</body>
</html>