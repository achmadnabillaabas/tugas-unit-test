<?php
//load config.php 
include("config/config.php");
 
// untuk api_key newsapi.org
$api_key="a5cc5cdfc7fb41ac91f432303bc26607";

// -------------------- MOVED: categories & countries (declare first) --------------------
$categories = [
    'general' => 'Umum',
    'business' => 'Bisnis',
    'technology' => 'Teknologi',
    'sports' => 'Olahraga',
    'entertainment' => 'Hiburan',
    'health' => 'Kesehatan',
    'science' => 'Sains'
];

$countries = [
    'us' => 'Amerika Serikat',
    'id' => 'Indonesia',
    'gb' => 'Inggris',
    'jp' => 'Jepang',
    'kr' => 'Korea Selatan',
    'au' => 'Australia',
    'de' => 'Jerman',
    'fr' => 'Prancis'
];
// -------------------- end moved --------------------

// Get selected category and country from URL parameters
$category = isset($_GET['category']) ? $_GET['category'] : 'general';
$country = isset($_GET['country']) ? $_GET['country'] : 'us';

// map country -> language (ISO-639-1)
$country_lang_map = [
    'us' => 'en',
    'gb' => 'en',
    'au' => 'en',
    'id' => 'id',
    'jp' => 'ja',
    'kr' => 'ko',
    'de' => 'de',
    'fr' => 'fr'
];

// Build API URL: prefer top-headlines when country is provided, else use everything
if (!empty($country) && array_key_exists($country, $countries)) {
    // use top-headlines (country + category)
    $url = "https://newsapi.org/v2/top-headlines?country={$country}&category={$category}&pageSize=100&apiKey=" . $api_key;
} else {
    // fallback to everything with language mapping
    $lang = $country_lang_map[$country] ?? 'en';
    $q = urlencode($category);
    $url = "https://newsapi.org/v2/everything?q={$q}&language={$lang}&sortBy=publishedAt&pageSize=100&apiKey=" . $api_key;
}
 
// ambil hasil
$data = http_request_get($url);
$hasil = json_decode($data, true);

// If top-headlines returned ok but no articles, try everything as fallback using mapped language
if (isset($hasil['status']) && $hasil['status'] === 'ok' && empty($hasil['articles'])) {
    // only attempt fallback when we previously used top-headlines
    if (strpos($url, '/top-headlines') !== false) {
        $lang = $country_lang_map[$country] ?? 'en';
        $q = urlencode($category);
        $fallbackUrl = "https://newsapi.org/v2/everything?q={$q}&language={$lang}&sortBy=publishedAt&pageSize=100&apiKey=" . $api_key;
        error_log("Top-headlines empty, trying fallback everything: " . $fallbackUrl);
        $data = http_request_get($fallbackUrl);
        $hasil = json_decode($data, true);
        $url = $fallbackUrl; // show fallback URL in debug/ui
    }
}

// Tambahkan ini setelah $hasil untuk debugging
if (isset($hasil['status']) && $hasil['status'] === 'error') {
    error_log("NewsAPI Error: " . json_encode($hasil));
}

// Debug response
error_log("API URL: " . $url);
error_log("API Response: " . $data);

// Arrays for categories and countries
$categories = [
    'general' => 'Umum',
    'business' => 'Bisnis',
    'technology' => 'Teknologi',
    'sports' => 'Olahraga',
    'entertainment' => 'Hiburan',
    'health' => 'Kesehatan',
    'science' => 'Sains'
];

$countries = [
    'us' => 'Amerika Serikat',
    'id' => 'Indonesia',
    'gb' => 'Inggris',
    'jp' => 'Jepang',
    'kr' => 'Korea Selatan',
    'au' => 'Australia',
    'de' => 'Jerman',
    'fr' => 'Prancis'
];

$current_lang = isset($_GET['lang']) ? $_GET['lang'] : 'id';

$translations = [
    'id' => [
        'home' => 'Beranda',
        'about' => 'Tentang',
        'select_category' => 'Pilih Kategori',
        'select_country' => 'Pilih Negara',
        'read_more' => 'Baca Selengkapnya',
        'dark_mode' => 'Mode Gelap',
        'light_mode' => 'Mode Terang',
        'hero_title' => 'Portal Berita',
        'hero_subtitle' => 'Temukan Berita Terbaru dari Dunia'
    ],
    'en' => [
        'home' => 'Home',
        'about' => 'About',
        'select_category' => 'Select Category',
        'select_country' => 'Select Country',
        'read_more' => 'Read More',
        'dark_mode' => 'Dark Mode',
        'light_mode' => 'Light Mode',
        'hero_title' => 'News Portal',
        'hero_subtitle' => 'Discover Latest News from World'
    ]
]; // Changed from }; to ];
?>
<!DOCTYPE html>
<html>

<head>
    <title>News Portal - Rest Client</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add this in the <head> section, after Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    /* Simple, minimal styles - Dark Theme */
    :root {
        /* Dark theme colors - adjusted for better contrast */
        --bg: #0f1115;
        --text: #ffffff;          /* Changed to pure white for better visibility */
        --muted: #cbd5e1;        /* Lightened muted text */
        --primary: #60a5fa;      /* Brightened primary color */
        --card-bg: #1e293b;      /* Slightly lighter card background */
        --border: #334155;       /* Lighter border color */
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
    .card-title { 
        color: #ffffff; /* Added white color for title */
        margin: 6px 0 0; 
        font-weight: 600; 
    }
    .card-meta { 
        color: #ffffff; /* Changed to white for better visibility */
    }
    .card-description {
        color: #ffffff; /* Changed to white for better visibility */
    }
    .news-date {
        color: #ffffff; /* Changed to white for better visibility */
    }
    .card-link { 
        color: #60a5fa; /* Brighter blue for better visibility */
        margin-top: 8px; 
        display: inline-block; 
        text-decoration: none; 
    }
    .card-link:hover { text-decoration: underline; }
    .error-box {
        background-color: #471f1f;
        color: #fecaca;
        border-color: #dc2626;
        padding: 12px;
        border-radius: 6px;
    }

    /* Additional styles */
    .filters {
        background: var(--card-bg);
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 24px;
    }
    
    .filter-label {
        color: var(--text);
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    
    select.form-select {
        background-color: var(--bg);
        color: #ffffff; /* Changed to white for better visibility */
        border-color: var(--border);
    }
    
    select.form-select:focus {
        background-color: var(--bg);
        color: var(--text);
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(77, 171, 247, 0.25);
    }
    
    .loading {
        text-align: center;
        padding: 40px;
        color: var(--muted);
    }
    
    .news-date {
        font-size: 0.8rem;
        color: var(--muted);
        margin-top: 8px;
    }
    
    .card-description {
        font-size: 0.9rem;
        margin: 10px 0;
        color: var(--muted);
    }

    /* Light theme colors - update these values */
    :root[data-theme="light"] {
        --bg: #ffffff;
        --text: #000000;          /* Darker text color */
        --muted: #333333;         /* Darker muted text */
        --primary: #0d6efd;
        --card-bg: #ffffff;
        --border: #dee2e6;
    }

    /* Add specific light mode overrides */
    [data-theme="light"] .card-title {
        color: #000000;           /* Black text for titles */
    }

    [data-theme="light"] .card-meta {
        color: #333333;           /* Darker gray for meta info */
    }

    [data-theme="light"] .card-description {
        color: #333333;           /* Darker gray for descriptions */
    }

    [data-theme="light"] .news-date {
        color: #333333;           /* Darker gray for dates */
    }

    [data-theme="light"] .filter-label {
        color: #000000;           /* Black text for filter labels */
    }

    [data-theme="light"] select.form-select {
        color: #000000;           /* Black text for select dropdowns */
        background-color: #ffffff;
    }

    [data-theme="light"] .card-link {
        color: #0d6efd;           /* Bootstrap primary blue for links */
    }

    /* Theme toggle button styles */
    .theme-toggle {
        background: transparent;
        border: 2px solid var(--border);
        color: var(--text);
        padding: 8px 16px;
        border-radius: 20px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .theme-toggle:hover {
        background: var(--border);
    }

    .theme-toggle i {
        font-size: 1.1rem;
    }

    /* Add this to your existing CSS */
    .lang-toggle {
        display: flex;
        gap: 2px;
        background: var(--card-bg);
        padding: 2px;
        border-radius: 20px;
        border: 2px solid var(--border);
    }

    .lang-btn {
        padding: 4px 12px;
        border-radius: 16px;
        color: var(--text);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .lang-btn:hover {
        background: var(--border);
        color: var(--text);
    }

    .lang-btn.active {
        background: var(--primary);
        color: white;
    }

    /* Hero Section Styles */
    .hero-section {
        background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                          url('https://wallpaperaccess.com/full/17350.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 100px 0;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, #D32F2F, #1976D2);
        opacity: 0.3;
    }

    .hero-content {
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-family: 'Poppins', sans-serif;
        font-size: 3.5rem;
        font-weight: 700;
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        margin-bottom: 20px;
    }

    .hero-subtitle {
        font-size: 1.5rem;
        color: #fff;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        max-width: 600px;
        margin: 0 auto;
    }

    /* One Piece theme colors */
    :root {
        --op-red: #D32F2F;
        --op-blue: #1976D2;
        --op-gold: #FFD700;
    }

    /* Update card styling for One Piece theme */
    .card {
        border: 2px solid var(--op-gold);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        border-color: var(--op-red);
    }

    /* Update button styling */
    .theme-toggle, .lang-btn {
        border: 2px solid var(--op-gold);
    }

    .lang-btn.active {
        background: var(--op-red);
    }

    /* Update filter section */
    .filters {
        background: linear-gradient(135deg, #1a237e, #0d47a1);
        border: 2px solid var(--op-gold);
    }

    /* Update select dropdowns */
    .form-select {
        border: 2px solid var(--op-gold);
        transition: all 0.3s ease;
    }

    .form-select:focus {
        border-color: var(--op-red);
        box-shadow: 0 0 0 0.25rem rgba(211, 47, 47, 0.25);
    }

    /* View toggle styles */
    .view-toggle { display:flex; gap:6px; align-items:center; }
    .view-btn {
        background: transparent;
        border: 2px solid var(--border);
        color: var(--text);
        padding: 6px 8px;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width:36px;
        height:36px;
    }
    .view-btn.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    .view-btn i { font-size: 16px; }

    /* News container - allow switching between grid and list */
    #news-container.grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }

    #news-container.list-view {
        display: block;
    }

    /* Card adjustments for list view */
    #news-container.list-view .card {
        display: flex;
        flex-direction: row;
        gap: 16px;
        align-items: flex-start;
        padding: 12px;
    }
    #news-container.list-view .card img {
        width: 220px;
        height: 140px;
        object-fit: cover;
        flex: 0 0 220px;
        border-radius: 6px;
    }
    #news-container.list-view .card-body {
        padding: 0;
        flex: 1;
    }
    #news-container.list-view .card-title {
        font-size: 1.05rem;
        margin-top: 0;
    }
    #news-container.list-view .card-description {
        margin: 8px 0 12px;
    }

    /* Improve spacing for grid cards (keep existing behavior) */
    #news-container.grid .card { padding: 0; }
    #news-container.grid .card-body { padding: 12px; }

    /* Responsive: on very small screens list -> stacked */
    @media (max-width: 600px) {
        #news-container.list-view .card { flex-direction: column; }
        #news-container.list-view .card img { width: 100%; height: 160px; flex: none; }
    }
    </style>
</head>

<body>
    <!-- Modify your existing header -->
<header class="topbar">
    <div class="brand">News Portal</div>
    <ul class="nav">
        <li><a href="index.php?lang=<?php echo $current_lang; ?>"><?php echo $translations[$current_lang]['home']; ?></a></li>
        <li><a href="about.php?lang=<?php echo $current_lang; ?>"><?php echo $translations[$current_lang]['about']; ?></a></li>
        <li>
            <button class="theme-toggle" onclick="toggleTheme()">
                <i class="fas fa-moon"></i>
                <span class="theme-text"><?php echo $translations[$current_lang]['dark_mode']; ?></span>
            </button>
        </li>
        <li>
            <div class="lang-toggle">
                <a href="?category=<?php echo $category; ?>&country=<?php echo $country; ?>&lang=id" class="lang-btn <?php echo $current_lang === 'id' ? 'active' : ''; ?>">ID</a>
                <a href="?category=<?php echo $category; ?>&country=<?php echo $country; ?>&lang=en" class="lang-btn <?php echo $current_lang === 'en' ? 'active' : ''; ?>">EN</a>
            </div>
        </li>

        <!-- VIEW TOGGLE BUTTONS -->
        <li>
            <div class="view-toggle" role="toolbar" aria-label="View toggle">
                <button id="btn-grid" class="view-btn active" title="Grid view" aria-pressed="true">
                    <i class="fa fa-th"></i>
                </button>
                <button id="btn-list" class="view-btn" title="List view" aria-pressed="false">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </li>
    </ul>
</header>

    <div class="container">
        <!-- Hero Section - Add this after the header section and before the filters -->
<div class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo $translations[$current_lang]['hero_title']; ?></h1>
            <p class="hero-subtitle"><?php echo $translations[$current_lang]['hero_subtitle']; ?></p>
        </div>
    </div>
</div>

        <!-- Filters Section -->
        <div class="filters">
            <form action="" method="GET" class="row g-3">
                <input type="hidden" name="lang" value="<?php echo $current_lang; ?>">
                <div class="col-md-5">
                    <div class="filter-label"><?php echo $translations[$current_lang]['select_category']; ?></div>
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <?php foreach($categories as $key => $value): ?>
                        <option value="<?php echo $key; ?>" <?php echo $category === $key ? 'selected' : ''; ?>>
                            <?php echo $value; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <div class="filter-label"><?php echo $translations[$current_lang]['select_country']; ?></div>
                    <select name="country" class="form-select" onchange="this.form.submit()">
                        <?php foreach($countries as $key => $value): ?>
                        <option value="<?php echo $key; ?>" <?php echo $country === $key ? 'selected' : ''; ?>>
                            <?php echo $value; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>

        <!-- News Grid -->
        <div id="news-container" class="grid">
            <?php 
            if (is_array($hasil) && isset($hasil['status'])) {
                if ($hasil['status'] === 'ok' && !empty($hasil['articles'])) {
                    foreach ($hasil['articles'] as $row) { 
                        // Convert date format
                        $date = new DateTime($row['publishedAt']);
                        $formatted_date = $date->format('d M Y H:i');
            ?>
                <div class="card">
                    <img src="<?php echo $row['urlToImage'] ?? 'placeholder.jpg'; ?>" alt="News Image"
                        onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                    <div class="card-body">
                        <div class="card-meta">
                            <?php echo htmlspecialchars($row['source']['name'] ?? 'Unknown Source'); ?>
                        </div>
                        <h3 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <div class="card-description">
                            <?php echo htmlspecialchars(substr($row['description'] ?? '', 0, 120)) . '...'; ?>
                        </div>
                        <div class="news-date"><?php echo $formatted_date; ?></div>
                        <a class="card-link" href="<?php echo htmlspecialchars($row['url']); ?>" target="_blank">
                            <?php echo $translations[$current_lang]['read_more']; ?> &rarr;
                        </a>
                    </div>
                </div>
            <?php 
                    }
                } else {
                    echo '<div class="col-12">';
                    echo '<div class="error-box">';
                    echo '<h3>Status API: ' . htmlspecialchars($hasil['status']) . '</h3>';
                    echo '<p><strong>Message:</strong> ' . htmlspecialchars($hasil['message'] ?? 'Tidak ada pesan error.') . '</p>';
                    echo '<p><strong>URL:</strong> ' . htmlspecialchars($url) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12">';
                echo '<div class="error-box">';
                echo '<h3>Error Parsing Data</h3>';
                echo '<p>Terjadi kesalahan saat memproses data dari API.</p>';
                echo '<p><strong>Raw Response:</strong> ' . htmlspecialchars(substr($data, 0, 500)) . '...</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Add this before closing body tag -->
<script>
// Check for saved theme preference, otherwise use device preference
const getPreferredTheme = () => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        return savedTheme;
    }
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

// Apply theme
const applyTheme = (theme) => {
    document.documentElement.setAttribute('data-theme', theme);
    
    // Update button text and icon
    const themeText = document.querySelector('.theme-text');
    const themeIcon = document.querySelector('.theme-toggle i');
    
    if (theme === 'light') {
        themeText.textContent = 'Dark Mode';
        themeIcon.className = 'fas fa-moon';
    } else {
        themeText.textContent = 'Light Mode';
        themeIcon.className = 'fas fa-sun';
    }
};

// Toggle theme function
const toggleTheme = () => {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    localStorage.setItem('theme', newTheme);
    applyTheme(newTheme);
};

// View toggle: grid / list
const newsContainer = document.getElementById('news-container');
const btnGrid = document.getElementById('btn-grid');
const btnList = document.getElementById('btn-list');

function applyView(view) {
    if (!newsContainer) return;
    if (view === 'list') {
        newsContainer.classList.remove('grid');
        newsContainer.classList.add('list-view');
        btnList.classList.add('active');
        btnGrid.classList.remove('active');
        btnList.setAttribute('aria-pressed', 'true');
        btnGrid.setAttribute('aria-pressed', 'false');
    } else {
        newsContainer.classList.remove('list-view');
        newsContainer.classList.add('grid');
        btnGrid.classList.add('active');
        btnList.classList.remove('active');
        btnGrid.setAttribute('aria-pressed', 'true');
        btnList.setAttribute('aria-pressed', 'false');
    }
    localStorage.setItem('newsView', view);
}

// attach events
btnGrid.addEventListener('click', () => applyView('grid'));
btnList.addEventListener('click', () => applyView('list'));

// initialize from saved preference
document.addEventListener('DOMContentLoaded', () => {
    // existing theme init
    applyTheme(getPreferredTheme());

    const savedView = localStorage.getItem('newsView') || 'grid';
    applyView(savedView);
});
</script>
</body>
</html>