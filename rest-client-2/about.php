<?php
include("config/config.php");
$current_lang = isset($_GET['lang']) ? $_GET['lang'] : 'id';

// Update the translations array with more detailed content
$translations = [
    'id' => [
        'home' => 'Beranda',
        'about' => 'Tentang',
        'about_title' => 'Portal Berita Internasional',
        'about_description' => 'Sebuah portal berita modern yang menyajikan berita terkini dari seluruh dunia menggunakan NewsAPI. Platform ini dirancang untuk memberikan pengalaman membaca berita yang personal dan mudah diakses.',
        'why_us' => 'Mengapa Memilih Kami',
        'why_1' => 'Berita Real-time dari NewsAPI',
        'why_2' => 'Interface yang Modern dan Responsif',
        'why_3' => 'Kemudahan Akses Berita Global',
        'about_features' => 'Fitur Portal',
        'feature_1' => 'Berita dari berbagai negara termasuk Indonesia, USA, UK, dan lainnya',
        'feature_2' => 'Kategori berita mencakup Umum, Bisnis, Teknologi, Olahraga, dan Entertainment',
        'feature_3' => 'Pilihan tampilan Light/Dark mode untuk kenyamanan membaca',
        'feature_4' => 'Dukungan bahasa Indonesia dan Inggris',
        'feature_5' => 'Tampilan Grid dan List untuk pengalaman membaca yang optimal',
        'api_source' => 'Sumber API',
        'api_desc' => 'Menggunakan NewsAPI.org untuk mengakses berita dari berbagai sumber terpercaya',
        'tech_stack' => 'Teknologi yang Digunakan',
        'tech_used' => 'Teknologi yang Digunakan',
        'contact' => 'Informasi Kontak',
        'developer' => 'Dikembangkan oleh',
        'university' => 'Universitas nusantara PGRI Kediri',
        'faculty' => 'Fakultas Teknik',
        'department' => 'Program Studi sistem informasi'
    ],
    'en' => [
        'home' => 'Home',
        'about' => 'About',
        'about_title' => 'International News Portal',
        'about_description' => 'A modern news portal that delivers latest news from around the world using NewsAPI. This platform is designed to provide a personalized and accessible news reading experience.',
        'why_us' => 'Why Choose Us',
        'why_1' => 'Real-time News from NewsAPI',
        'why_2' => 'Modern and Responsive Interface',
        'why_3' => 'Easy Access to Global News',
        'about_features' => 'Portal Features',
        'feature_1' => 'News from various countries including Indonesia, USA, UK, and more',
        'feature_2' => 'News categories including General, Business, Technology, Sports, and Entertainment',
        'feature_3' => 'Light/Dark mode options for comfortable reading',
        'feature_4' => 'Support for Indonesian and English languages',
        'feature_5' => 'Grid and List views for optimal reading experience',
        'api_source' => 'API Source',
        'api_desc' => 'Using NewsAPI.org to access news from various trusted sources',
        'tech_stack' => 'Technology Stack',
        'tech_used' => 'Technologies Used',
        'contact' => 'Contact Information',
        'developer' => 'Developed by',
        'university' => 'UNP Kediri University',
        'faculty' => 'Faculty of Engineering',
        'department' => 'information system Program'
    ]
]; ?>
<!DOCTYPE html>
<html>
<head>
    <title>About - News Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Copy existing root styles from index.php */
        :root {
            --bg: #0f1115;
            --text: #ffffff;
            --muted: #cbd5e1;
            --primary: #60a5fa;
            --card-bg: #1e293b;
            --border: #334155;
            --op-red: #D32F2F;
            --op-blue: #1976D2;
            --op-gold: #FFD700;
        }

        /* Light theme */
        :root[data-theme="light"] {
            --bg: #ffffff;
            --text: #000000;
            --muted: #333333;
            --primary: #0d6efd;
            --card-bg: #ffffff;
            --border: #dee2e6;
        }

        /* Copy existing base styles */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.5;
        }

        /* Copy navigation styles */
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

        /* Add About page specific styles */
        .about-section {
            padding: 60px 0;
            max-width: 800px;
            margin: 0 auto;
        }

        .about-card {
            background: var(--card-bg);
            border: 2px solid var(--op-gold);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .about-title {
            color: var(--text);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .features-list li {
            padding: 10px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text);
        }

        .features-list i {
            color: var(--op-gold);
            font-size: 1.2rem;
        }

        .tech-stack {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px 0;
        }

        .tech-item {
            background: var(--card-bg);
            border: 1px solid var(--op-gold);
            padding: 10px 20px;
            border-radius: 20px;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .contact-info {
            text-align: center;
            margin-top: 30px;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }

        .social-links a {
            color: var(--text);
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: var(--op-gold);
        }

        /* New styles for feature cards in Why Choose Us section */
        .feature-card {
            text-align: center;
            padding: 20px;
            background: var(--card-bg);
            border: 1px solid var(--op-gold);
            border-radius: 10px;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-card i {
            font-size: 2rem;
            color: var(--op-gold);
            margin-bottom: 15px;
        }

        /* New styles for API section button */
        .api-section {
            text-align: center;
            padding: 20px;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .api-section .btn {
            background: var(--primary);
            color: var(--text);
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .api-section .btn:hover {
            background: var(--op-gold);
        }

        .btn-primary {
            background-color: var(--op-blue);
            border-color: var(--op-blue);
            padding: 8px 20px;
        }

        .btn-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);  /* Fixed typo: removed comma */
        }

        /* Add to your existing style section */
        .nav a {
            color: var(--text);
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .nav a:hover,
        .nav a.active {
            background-color: var(--primary);
            color: white;
        }

        /* Controls on header (theme + language) */
        .topbar { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .topbar .nav { display:flex; gap:8px; list-style:none; margin:0; padding:0; align-items:center; }
        .controls { display:flex; gap:8px; align-items:center; }

        .theme-toggle {
            background: transparent;
            border: 2px solid var(--border);
            color: var(--text);
            padding: 6px 10px;
            border-radius: 20px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight:600;
        }
        .theme-toggle:hover { background: var(--border); }

        .lang-toggle {
            display:flex;
            gap:6px;
            background: var(--card-bg);
            padding: 3px;
            border-radius: 20px;
            border: 2px solid var(--border);
        }
        .lang-btn {
            padding: 6px 10px;
            border-radius: 14px;
            color: var(--text);
            text-decoration: none;
            font-weight:600;
            font-size:0.9rem;
        }
        .lang-btn.active {
            background: var(--primary);
            color: #fff;
        }

        /* ensure header links visible */
        .nav a { color:var(--text); text-decoration:none; padding:6px 10px; border-radius:4px; }
        .nav a.active { background:var(--primary); color:#fff; }
    </style>
</head>
<body>
    <!-- REPLACED HEADER -->
    <header class="topbar">
        <div style="display:flex;align-items:center;gap:12px;">
            <div class="brand">News Portal</div>
            <ul class="nav">
                <li><a href="index.php?lang=<?php echo $current_lang; ?>"><?php echo $translations[$current_lang]['home'] ?? 'Beranda'; ?></a></li>
                <li><a href="about.php?lang=<?php echo $current_lang; ?>" class="active"><?php echo $translations[$current_lang]['about'] ?? 'Tentang'; ?></a></li>
            </ul>
        </div>

        <div class="controls">
            <button id="theme-toggle" class="theme-toggle" title="Toggle theme">
                <i id="theme-icon" class="fas fa-moon"></i>
            </button>

            <div class="lang-toggle" role="tablist" aria-label="Language">
                <a href="about.php?lang=id" class="lang-btn <?php echo $current_lang === 'id' ? 'active' : ''; ?>">ID</a>
                <a href="about.php?lang=en" class="lang-btn <?php echo $current_lang === 'en' ? 'active' : ''; ?>">EN</a>
            </div>
        </div>
    </header>

    <div class="about-section">
        <div class="about-card">
            <h1 class="about-title"><?php echo $translations[$current_lang]['about_title']; ?></h1>
            <p class="lead text-center mb-5"><?php echo $translations[$current_lang]['about_description']; ?></p>

            <!-- Why Choose Us Section -->
            <div class="why-us mb-5">
                <h2 class="h3 mb-4"><?php echo $translations[$current_lang]['why_us']; ?></h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-bolt"></i>
                            <h3 class="h5"><?php echo $translations[$current_lang]['why_1']; ?></h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-laptop"></i>
                            <h3 class="h5"><?php echo $translations[$current_lang]['why_2']; ?></h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-globe"></i>
                            <h3 class="h5"><?php echo $translations[$current_lang]['why_3']; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <h2 class="h3 mb-4"><?php echo $translations[$current_lang]['about_features']; ?></h2>
            <ul class="features-list">
                <li><i class="fas fa-globe"></i> <?php echo $translations[$current_lang]['feature_1']; ?></li>
                <li><i class="fas fa-list"></i> <?php echo $translations[$current_lang]['feature_2']; ?></li>
                <li><i class="fas fa-moon"></i> <?php echo $translations[$current_lang]['feature_3']; ?></li>
                <li><i class="fas fa-language"></i> <?php echo $translations[$current_lang]['feature_4']; ?></li>
                <li><i class="fas fa-th"></i> <?php echo $translations[$current_lang]['feature_5']; ?></li>
            </ul>

            <!-- API Source Section -->
            <div class="api-section mt-5">
                <h2 class="h3 mb-3"><?php echo $translations[$current_lang]['api_source']; ?></h2>
                <p class="text-center"><?php echo $translations[$current_lang]['api_desc']; ?></p>
                <div class="text-center mt-3">
                    <a href="https://newsapi.org" target="_blank" class="btn btn-primary">
                        <i class="fas fa-external-link-alt me-2"></i>NewsAPI.org
                    </a>
                </div>
            </div>

            <!-- Tech Stack Section -->
            <h2 class="h3 mb-4 mt-5"><?php echo $translations[$current_lang]['tech_stack']; ?></h2>
            <div class="tech-stack">
                <div class="tech-item"><i class="fab fa-php"></i> PHP</div>
                <div class="tech-item"><i class="fab fa-bootstrap"></i> Bootstrap 5</div>
                <div class="tech-item"><i class="fab fa-js"></i> JavaScript</div>
                <div class="tech-item"><i class="fas fa-code"></i> REST API</div>
                <div class="tech-item"><i class="fas fa-paint-brush"></i> CSS3</div>
            </div>

            <!-- Contact Info Section -->
            <div class="contact-info mt-5">
                <h2 class="h3 mb-3"><?php echo $translations[$current_lang]['contact']; ?></h2>
                <p class="mb-2"><?php echo $translations[$current_lang]['developer']; ?> <strong>Achmad Nabilla Abas</strong></p>
                <p class="mb-1"><?php echo $translations[$current_lang]['university']; ?></p>
                <p class="mb-1"><?php echo $translations[$current_lang]['faculty']; ?></p>
                <p class="mb-4"><?php echo $translations[$current_lang]['department']; ?></p>
                
                <div class="social-links">
                    <a href="https://github.com/achmadnabillaabas" target="_blank" title="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://linkedin.com/in/achmad-nabilla-abas-4880842b8" target="_blank" title="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="mailto:achmadnabillaabas@gmail.com" title="Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- theme helpers (kept minimal to avoid duplicate conflicts) -->
    <script>
        const getPreferredTheme = () => {
            const saved = localStorage.getItem('theme');
            if (saved) return saved;
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        };

        const applyTheme = (theme) => {
            document.documentElement.setAttribute('data-theme', theme);
            updateThemeButton(theme);
        };

        const updateThemeButton = (theme) => {
            const icon = document.getElementById('theme-icon');
            const btn = document.getElementById('theme-toggle');
            if (!icon || !btn) return;
            if (theme === 'light') {
                icon.className = 'fas fa-sun';
                btn.title = 'Switch to Dark Mode';
            } else {
                icon.className = 'fas fa-moon';
                btn.title = 'Switch to Light Mode';
            }
        };

        const toggleTheme = () => {
            const current = document.documentElement.getAttribute('data-theme') || getPreferredTheme();
            const next = current === 'light' ? 'dark' : 'light';
            localStorage.setItem('theme', next);
            applyTheme(next);
        };

        document.addEventListener('DOMContentLoaded', () => {
            applyTheme(getPreferredTheme());
            const tbtn = document.getElementById('theme-toggle');
            if (tbtn) tbtn.addEventListener('click', toggleTheme);
        });
    </script>
</body>
</html>