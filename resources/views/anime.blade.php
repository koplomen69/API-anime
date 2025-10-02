<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Search - Jikan API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .search-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2) !important;
        }
        .card-img-top {
            transition: transform 0.3s ease;
        }
        .card:hover .card-img-top {
            transform: scale(1.05);
        }
        .score-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            z-index: 2;
        }
        .anime-title {
            color: #333;
            font-weight: bold;
            line-height: 1.2;
        }
        .anime-japanese {
            font-size: 0.9rem;
            color: #666;
        }
        .synopsis {
            color: #555;
            line-height: 1.5;
        }
        .loading {
            display: none;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .btn-search {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
        }
        .btn-search:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <!-- Navbar Sederhana -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="{{ route('anime.index') }}">
                <i class="fas fa-dragon me-2"></i>AnimeHub
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-white mb-3">
                        <i class="fas fa-search me-2"></i>Cari Anime Favoritmu
                    </h1>
                    <p class="lead text-white-50">Temukan ribuan anime seru dari database MyAnimeList!</p>
                </div>

                <!-- Form Pencarian -->
                <div class="search-container">
                    <form method="GET" action="{{ route('anime.search') }}" class="mb-0">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-transparent border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text"
                                   name="q"
                                   class="form-control border-0 py-3 ps-4"
                                   placeholder="Ketik nama anime, misal: Naruto, One Piece..."
                                   value="{{ $query ?? '' }}"
                                   required>
                            <button class="btn btn-search text-white" type="submit">
                                <i class="fas fa-magnifying-glass me-1"></i>Cari
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Loading Spinner -->
                @if(isset($animes))
                    <div id="loading" class="text-center py-4 loading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-white">Mencari anime favoritmu...</p>
                    </div>
                @endif

                <!-- Tampilkan Error kalau Ada -->
                @if(isset($error))
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Hasil Pencarian -->
                @if(isset($animes) && count($animes) > 0)
                    <div class="mt-4">
                        <h3 class="text-white mb-4">
                            <i class="fas fa-list me-2"></i>Hasil Pencarian untuk "{{ $query }}" ({{ count($animes) }} ditemukan)
                        </h3>
                        <div class="row g-4">
                            @foreach($animes as $index => $anime)
                                <div class="col-md-6 col-lg-4 fade-in" style="animation-delay: {{ $index * 0.1 }}s;">
                                    <div class="card position-relative bg-white">
                                        <div class="score-badge">
                                            {{ number_format($anime['score'] ?? 0, 1) }}/10
                                        </div>
                                        <img src="{{ $anime['images']['jpg']['image_url'] ?? 'https://via.placeholder.com/300x400?text=No+Image' }}"
                                             class="card-img-top"
                                             alt="{{ $anime['title'] }}"
                                             style="height: 250px; object-fit: cover;">
                                        <div class="card-body p-4">
                                            <h5 class="card-title anime-title">{{ $anime['title'] }}</h5>
                                            @if(isset($anime['title_japanese']) && $anime['title_japanese'])
                                                <h6 class="card-subtitle mb-2 anime-japanese">{{ $anime['title_japanese'] }}</h6>
                                            @endif
                                            <p class="card-text synopsis mb-3">{{ Str::limit($anime['synopsis'] ?? 'Synopsis tidak tersedia.', 120) }}</p>
                                            <ul class="list-unstyled small mb-3">
                                                <li class="d-flex align-items-center">
                                                    <i class="fas fa-tag me-2 text-muted"></i><strong>Tipe:</strong> {{ $anime['type'] ?? 'N/A' }}
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <i class="fas fa-play-circle me-2 text-muted"></i><strong>Episode:</strong> {{ $anime['episodes'] ?? 'N/A' }}
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <i class="fas fa-star me-2 text-warning"></i><strong>Score:</strong> {{ $anime['score'] ?? 'N/A' }}
                                                </li>
                                            </ul>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-secondary">{{ $anime['status'] ?? 'N/A' }}</span>
                                                <a href="{{ $anime['url'] ?? '#' }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                                    <i class="fas fa-external-link-alt me-1"></i>Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif(isset($animes))
                    <div class="alert alert-warning text-center py-5 my-5 bg-white rounded-4 shadow">
                        <i class="fas fa-inbox fa-3x text-warning mb-3"></i>
                        <h4>Tidak ada hasil untuk "{{ $query }}"</h4>
                        <p class="mb-0">Coba kata kunci lain atau periksa ejaan!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple loading simulation (hide after load)
        document.addEventListener('DOMContentLoaded', function() {
            const loading = document.getElementById('loading');
            if (loading) {
                setTimeout(() => {
                    loading.style.display = 'none';
                }, 1000);
            }
        });
    </script>
</body>
</html>
