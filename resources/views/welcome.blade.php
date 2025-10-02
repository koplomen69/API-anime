<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnimeHub - Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            text-align: center;
            color: white;
            background: url('https://images.unsplash.com/photo-1618477461853-e6278c1e7a74?q=80&w=2070&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        .hero-content {
            z-index: 2;
            max-width: 800px;
            padding: 2rem;
        }
        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1s ease-in;
        }
        .hero-content p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1.2s ease-in;
            animation-delay: 0.2s;
            animation-fill-mode: both;
        }
        .btn-explore {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 1.4s ease-in;
            animation-delay: 0.4s;
            animation-fill-mode: both;
        }
        .btn-explore:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="{{ route('anime.index') }}">
                <i class="fas fa-dragon me-2"></i>AnimeHub
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="mb-4">Selamat Datang di AnimeHub!</h1>
            <p class="lead">Jelajahi dunia anime favoritmu dengan pencarian cepat dan mudah dari database MyAnimeList. Temukan judul baru, cek rating, dan nikmati petualangan seru!</p>
            <a href="{{ route('anime.index') }}" class="btn btn-explore">
                <i class="fas fa-search me-2"></i>Cari Anime Sekarang
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
