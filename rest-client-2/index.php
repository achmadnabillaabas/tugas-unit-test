<?php
//load config.php 
include("config/config.php");
 
// untuk api_key newsapi.org
$api_key="a5cc5cdfc7fb41ac91f432303bc26607";
 
// URL API 
$url="https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=".$api_key;
 
// menyimpan hasil dalam variabel
$data=http_request_get($url);
 
// konversi data json ke array
$hasil=json_decode($data,true);
 
?>
<!DOCTYPE html>
<html>

<head>
    <title>Rest Client dengan cURL</title>
    <!-- Add a more prominent header font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <style>
    /* Simple, minimal styles - Dark Theme */
    :root {
        --bg: #0f1115;
        --text: #e6e6e6;
        --muted: #9aa0a6;
        --primary: #4dabf7;
        --card-bg: #151922;
        --border: #222738;
    }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
        background: var(--bg);
        color: var(--text);
        line-height: 1.5;
    }
    .topbar {
        position: sticky;
        top: 0;
        z-index: 10;
        background: var(--card-bg);
        border-bottom: 1px solid var(--border);
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    /* Make brand more prominent */
    .brand {
        font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
        font-weight: 700;
        font-size: 1.15rem;
        letter-spacing: 0.6px;
        text-transform: uppercase;
    }
    .nav {
        display: flex;
        gap: 12px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    /* Make nav links more noticeable */
    .nav a {
        font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--muted);
        text-decoration: none;
        padding: 8px 10px;
        border-radius: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .nav a:hover { background: rgba(255,255,255,0.06); color: var(--text); }
    .container { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }
    .card {
        display: flex;
        flex-direction: column;
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
        transition: background-color .12s ease, border-color .12s ease;
    }
    .card:hover { border-color: #2a3042; }
    .card img { width: 100%; height: 180px; object-fit: cover; background: #2a2f3a; }
    .card-body { padding: 12px; }
    .card-title { margin: 6px 0 0; font-weight: 600; }
    .card-meta { color: var(--muted); font-size: 0.9rem; }
    .card-link { margin-top: 8px; display: inline-block; color: var(--primary); text-decoration: none; }
    .card-link:hover { text-decoration: underline; }
    .error-box {
        background-color: #2b1f22;
        color: #f2b8bd;
        border: 1px solid #6d2f38;
        padding: 12px;
        border-radius: 6px;
    }
    </style>
</head>

<body>

    <header class="topbar">
        <div class="brand">RestClient</div>
        <ul class="nav">
            <li><a href="#">Home</a></li>
            <li><a href="#">News</a></li>
            <li><a href="#">About</a></li>
        </ul>
    </header>
    <div class="container">
        <div class="grid">

            <?php 

if (is_array($hasil) && isset($hasil['status']) && $hasil['status'] == 'ok' && isset($hasil['articles'])) {
    
    // Looping jika data valid
    foreach ($hasil['articles'] as $row) { 
?>

            <div class="card">
                <img src="<?php echo $row['urlToImage'] ?? 'placeholder.jpg'; ?>" alt="Gambar Berita">
                <div class="card-body">
                    <div class="card-meta">Oleh <?php echo htmlspecialchars($row['author'] ?? 'N/A'); ?></div>
                    <div class="card-title"><?php echo htmlspecialchars($row['title']); ?></div>
                    <a class="card-link" href="<?php echo htmlspecialchars($row['url']); ?>" target="_blank">Selengkapnya</a>
                </div>
            </div>

            <?php 
    } // Akhir foreach
    
} else {
    // Tampilkan pesan error jika API request gagal (API Key salah, kuota habis, dll.)
    echo '<div class="col-12">';
    echo '<div class="error-box">';
    echo '<h3>Error Mengambil Data API</h3>';
    
    if (isset($hasil['status']) && $hasil['status'] == 'error') {
        echo '<p><strong>Pesan API:</strong> ' . htmlspecialchars($hasil['message'] ?? 'Kesalahan tak teridentifikasi.') . '</p>';
        echo '<p>Pastikan API Key Anda valid dan kuota harian belum habis.</p>';
    } else {
        echo '<p>Gagal mengkonversi JSON atau response API tidak valid. (Kemungkinan error di fungsi http_request_get)</p>';
    }
    
    echo '</div>';
    echo '</div>';
}
?>

        </div>
    </div>

    
</body>

</html>