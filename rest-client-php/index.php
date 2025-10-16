<?php
include("config/config.php");

// Ambil semua daftar surah (1–114)
$listSurah = http_request_get("https://equran.id/api/v2/surat");
$daftarSurah = json_decode($listSurah, true);

// Ambil nomor surah dari dropdown (jika ada)
$nomorSurah = isset($_GET['surah']) ? $_GET['surah'] : 1;

// Ambil isi ayat dari surah yang dipilih
$urlSurah = "https://equran.id/api/v2/surat/" . $nomorSurah;
$dataSurah = http_request_get($urlSurah);
$hasil = json_decode($dataSurah, true);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Quran Digital</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar bg-success navbar-expand-lg" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">QuranAPI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" href="index.php">Home</a>
                    <a class="nav-link" href="#">Surah</a>
                    <a class="nav-link" href="#">About</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container mt-4">
        <h1 class="mb-4 text-success fw-bold">Quran Digital</h1>

        <!-- Dropdown Daftar Surah -->
        <form method="get" class="mb-4">
            <label for="surah" class="form-label fw-semibold">Pilih Surah:</label>
            <select name="surah" id="surah" class="form-select" onchange="this.form.submit()">
                <?php
                if (isset($daftarSurah['data']) && is_array($daftarSurah['data'])) {
                    foreach ($daftarSurah['data'] as $surah) {
                        $selected = ($surah['nomor'] == $nomorSurah) ? 'selected' : '';
                        echo "<option value='{$surah['nomor']}' $selected>{$surah['nomor']}. {$surah['namaLatin']} ({$surah['arti']})</option>";
                    }
                }
                ?>
            </select>
        </form>

        <!-- Informasi Surah -->
        <?php if (isset($hasil['data'])): ?>
            <div class="mb-4">
                <h3><?= $hasil['data']['namaLatin']; ?> - <?= $hasil['data']['arti']; ?></h3>
                <p>Jumlah Ayat: <?= $hasil['data']['jumlahAyat']; ?></p>
                <p>Tempat Turun: <?= $hasil['data']['tempatTurun']; ?></p>
            </div>
        <?php endif; ?>

        <!-- Ayat-ayat -->
        <?php if (isset($hasil['data']['ayat']) && is_array($hasil['data']['ayat'])): ?>
            <div class="list-group">
                <?php foreach ($hasil['data']['ayat'] as $row): ?>
                    <div class="list-group-item">
                        <p class="text-end fs-3 fw-bold"><?= $row['teksArab']; ?></p>
                        <p class="text-start"><?= $row['teksIndonesia']; ?></p>
                        <audio src="<?= $row['audio']['05']; ?>" controls></audio>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                ⚠️ Gagal memuat data dari API. Pastikan koneksi internet aktif.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>