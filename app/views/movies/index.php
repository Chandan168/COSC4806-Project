<?php require_once 'app/views/templates/header.php'; ?>

<style>
    body {
        background-color: #141414;
        color: #ffffff;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .netflix-container {
        background: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.9)), 
                    url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 1080"><rect fill="%23141414" width="1920" height="1080"/></svg>');
        min-height: 100vh;
        padding-top: 2rem;
    }

    .hero-section {
        text-align: center;
        padding: 3rem 0;
        background: linear-gradient(135deg, #e50914, #b20710);
        margin-bottom: 2rem;
    }

    .search-container {
        max-width: 800px;
        margin: 0 auto 3rem auto;
    }

    .search-box {
        background: rgba(0,0,0,0.8);
        border: 2px solid #333;
        border-radius: 4px;
        color: white;
        padding: 15px 20px;
        font-size: 16px;
        width: 100%;
        transition: border-color 0.3s;
    }

    .search-box:focus {
        border-color: #e50914;
        outline: none;
        box-shadow: 0 0 0 1px #e50914;
    }

    .search-btn {
        background: #e50914;
        border: none;
        padding: 15px 30px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 4px;
        margin-top: 10px;
        transition: background 0.3s;
    }

    .search-btn:hover {
        background: #f40612;
    }

    .movies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        padding: 0 2rem;
    }

    .movie-card {
        background: rgba(20,20,20,0.9);
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid #333;
    }

    .movie-card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(229,9,20,0.3);
    }

    .movie-poster {
        width: 100%;
        height: 400px;
        object-fit: cover;
        background: #333;
    }

    .movie-info {
        padding: 1.5rem;
    }

    .movie-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #fff;
    }

    .movie-year {
        color: #999;
        margin-bottom: 1rem;
    }

    .view-details-btn {
        background: #e50914;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s;
        font-weight: bold;
    }

    .view-details-btn:hover {
        background: #f40612;
        color: white;
        text-decoration: none;
    }

    .alert-dark {
        background-color: rgba(40,40,40,0.9);
        border-color: #555;
        color: #fff;
    }

    .no-results {
        text-align: center;
        padding: 3rem;
        color: #999;
    }
</style>

<div class="netflix-container">
    <div class="hero-section">
        <div class="container">
            <h1 class="display-4"><i class="fas fa-film"></i> Movie Search</h1>
            <p class="lead">Discover movies, rate them, and read AI-generated reviews</p>
        </div>
    </div>

    <div class="container">
        <div class="search-container">
            <form method="GET" action="/movies">
                <div class="input-group">
                    <input type="text" 
                           name="q" 
                           class="search-box" 
                           placeholder="Search for movies..." 
                           value="<?= htmlspecialchars($query) ?>"
                           autofocus>
                </div>
                <div class="text-center">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i> Search Movies
                    </button>
                </div>
            </form>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-dark" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($query) && empty($movies) && empty($error)): ?>
            <div class="no-results">
                <i class="fas fa-search fa-3x mb-3"></i>
                <h3>No movies found for "<?= htmlspecialchars($query) ?>"</h3>
                <p>Try searching with different keywords</p>
            </div>
        <?php endif; ?>

        <?php if (!empty($movies)): ?>
            <div class="movies-grid">
                <?php foreach ($movies as $movie): ?>
                    <div class="movie-card">
                        <img src="<?= $movie['Poster'] !== 'N/A' ? htmlspecialchars($movie['Poster']) : '/path/to/default-poster.jpg' ?>" 
                             alt="<?= htmlspecialchars($movie['Title']) ?>" 
                             class="movie-poster"
                             onerror="this.src='data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"300\" height=\"400\" viewBox=\"0 0 300 400\"><rect fill=\"%23333\" width=\"300\" height=\"400\"/><text x=\"150\" y=\"200\" text-anchor=\"middle\" fill=\"%23666\" font-size=\"16\">No Image</text></svg>'">

                        <div class="movie-info">
                            <h5 class="movie-title"><?= htmlspecialchars($movie['Title']) ?></h5>
                            <p class="movie-year"><?= htmlspecialchars($movie['Year']) ?></p>
                            <a href="/movies/details/<?= htmlspecialchars($movie['imdbID']) ?>" 
                               class="view-details-btn">
                                <i class="fas fa-info-circle"></i> View Details
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($query)): ?>
            <div class="no-results">
                <i class="fas fa-film fa-3x mb-3"></i>
                <h3>Start your movie discovery</h3>
                <p>Search for any movie above to see details, ratings, and AI reviews</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>