<?php require_once 'app/views/templates/header.php'; ?>

<style>
    body {
        background-color: #141414;
        color: #ffffff;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .movie-details-container {
        background: linear-gradient(to bottom, rgba(0,0,0,0.8), rgba(20,20,20,0.95));
        min-height: 100vh;
        padding-top: 2rem;
    }

    .movie-header {
        background: linear-gradient(135deg, rgba(0,0,0,0.8), rgba(229,9,20,0.1));
        padding: 2rem 0;
        margin-bottom: 2rem;
    }

    .movie-poster-large {
        width: 100%;
        max-width: 300px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
    }

    .movie-info-section {
        background: rgba(40,40,40,0.8);
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #555;
    }

    .rating-section {
        background: rgba(229,9,20,0.1);
        border: 1px solid #e50914;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .star-rating {
        display: flex;
        gap: 5px;
        margin: 1rem 0;
    }

    .star {
        font-size: 2rem;
        color: #666;
        cursor: pointer;
        transition: color 0.2s;
    }

    .star.active {
        color: #ffd700;
    }

    .star:hover {
        color: #ffd700;
    }

    .rating-display {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .avg-rating {
        font-size: 2rem;
        font-weight: bold;
        color: #ffd700;
    }

    .rating-count {
        color: #999;
    }

    .ai-review-section {
        background: rgba(60,60,60,0.8);
        border-radius: 8px;
        padding: 2rem;
        border: 1px solid #666;
    }

    .btn-netflix {
        background: #e50914;
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 4px;
        font-weight: bold;
        transition: background 0.3s;
    }

    .btn-netflix:hover {
        background: #f40612;
        color: white;
    }

    .btn-secondary-netflix {
        background: rgba(109,109,110,0.7);
        border: 1px solid #6d6d6e;
        color: white;
        padding: 12px 24px;
        border-radius: 4px;
        font-weight: bold;
    }

    .btn-secondary-netflix:hover {
        background: rgba(109,109,110,0.9);
        color: white;
    }

    .review-textarea {
        background: rgba(0,0,0,0.5);
        border: 1px solid #555;
        color: white;
        border-radius: 4px;
        padding: 10px;
        resize: vertical;
    }

    .review-textarea:focus {
        border-color: #e50914;
        outline: none;
        box-shadow: 0 0 0 1px #e50914;
    }

    .loading-spinner {
        display: none;
        text-align: center;
        padding: 2rem;
    }

    .movie-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin: 1rem 0;
    }

    .badge-netflix {
        background: #e50914;
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
    }
</style>

<div class="movie-details-container">
    <div class="container">
        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Movie Header -->
        <div class="movie-header">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?= $movie['Poster'] !== 'N/A' ? htmlspecialchars($movie['Poster']) : '/path/to/default-poster.jpg' ?>" 
                         alt="<?= htmlspecialchars($movie['Title']) ?>" 
                         class="movie-poster-large"
                         onerror="this.src='data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"300\" height=\"400\" viewBox=\"0 0 300 400\"><rect fill=\"%23333\" width=\"300\" height=\"400\"/><text x=\"150\" y=\"200\" text-anchor=\"middle\" fill=\"%23666\" font-size=\"16\">No Image</text></svg>'">
                </div>
                <div class="col-md-8">
                    <h1><?= htmlspecialchars($movie['Title']) ?> (<?= htmlspecialchars($movie['Year']) ?>)</h1>

                    <div class="movie-badges">
                        <?php if (!empty($movie['Genre'])): ?>
                            <?php foreach (explode(', ', $movie['Genre']) as $genre): ?>
                                <span class="badge-netflix"><?= htmlspecialchars($genre) ?></span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="rating-display">
                        <?php if ($ratings['count'] > 0): ?>
                            <span class="avg-rating"><?= $ratings['average'] ?>/5</span>
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?= $i <= $ratings['average'] ? 'active' : '' ?>">★</span>
                                <?php endfor; ?>
                            </div>
                            <span class="rating-count">(<?= $ratings['count'] ?> ratings)</span>
                        <?php else: ?>
                            <span class="text-muted">No ratings yet</span>
                        <?php endif; ?>
                    </div>

                    <p class="mt-3"><strong>Director:</strong> <?= htmlspecialchars($movie['Director']) ?></p>
                    <p><strong>Runtime:</strong> <?= htmlspecialchars($movie['Runtime']) ?></p>
                    <p><strong>IMDB Rating:</strong> <?= htmlspecialchars($movie['imdbRating']) ?>/10</p>

                    <a href="/movies" class="btn btn-secondary-netflix">
                        <i class="fas fa-arrow-left"></i> Back to Search
                    </a>
                </div>
            </div>
        </div>

        <!-- Movie Info -->
        <div class="movie-info-section">
            <h3>Plot</h3>
            <p><?= htmlspecialchars($movie['Plot']) ?></p>

            <div class="row mt-3">
                <div class="col-md-6">
                    <strong>Cast:</strong><br>
                    <?= htmlspecialchars($movie['Actors']) ?>
                </div>
                <div class="col-md-6">
                    <strong>Genre:</strong><br>
                    <?= htmlspecialchars($movie['Genre']) ?>
                </div>
            </div>
        </div>

        <!-- Rating Section -->
        <div class="rating-section">
            <h3><i class="fas fa-star"></i> Rate This Movie</h3>

            <?php if ($userRating): ?>
                <div class="alert alert-info">
                    You've already rated this movie: <?= $userRating['rating'] ?>/5 stars
                    <?php if (!empty($userRating['review'])): ?>
                        <br><strong>Your review:</strong> <?= htmlspecialchars($userRating['review']) ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <form method="POST" action="/movies/rate">
                    <input type="hidden" name="movie_id" value="<?= $movieDb['id'] ?>">
                    <input type="hidden" name="imdb_id" value="<?= $movie['imdbID'] ?>">
                    <input type="hidden" name="rating" id="rating-value" value="">

                    <div class="mb-3">
                        <label class="form-label">Your Rating:</label>
                        <div class="star-rating" id="user-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star" data-rating="<?= $i ?>">★</span>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="review" class="form-label">Review (Optional):</label>
                        <textarea name="review" 
                                  id="review" 
                                  class="form-control review-textarea" 
                                  rows="4" 
                                  placeholder="Write your review here... (max 500 characters)"
                                  maxlength="500"></textarea>
                    </div>

                    <button type="submit" class="btn btn-netflix" id="submit-rating" disabled>
                        <i class="fas fa-star"></i> Submit Rating
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <!-- AI Review Section -->
        <div class="ai-review-section">
            <h3><i class="fas fa-robot"></i> AI-Generated Review</h3>

            <div id="ai-review-content">
                <?php if ($aiReview): ?>
                    <p><?= nl2br(htmlspecialchars($aiReview)) ?></p>
                <?php else: ?>
                    <p class="text-muted">No AI review generated yet for this movie.</p>
                    <button type="button" class="btn btn-netflix" onclick="generateAIReview()">
                        <i class="fas fa-magic"></i> Generate AI Review
                    </button>
                <?php endif; ?>
            </div>

            <div class="loading-spinner" id="ai-loading">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Generating review...</span>
                </div>
                <p class="mt-2">Generating AI review...</p>
            </div>
        </div>
    </div>
</div>

<script>
// Star rating functionality
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#user-rating .star');
    const ratingValue = document.getElementById('rating-value');
    const submitButton = document.getElementById('submit-rating');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingValue.value = rating;

            // Update visual state
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });

            submitButton.disabled = false;
        });

        star.addEventListener('mouseover', function() {
            const rating = this.getAttribute('data-rating');
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.style.color = '#ffd700';
                } else {
                    s.style.color = '#666';
                }
            });
        });
    });

    document.getElementById('user-rating').addEventListener('mouseleave', function() {
        const currentRating = ratingValue.value;
        stars.forEach((s, index) => {
            if (index < currentRating) {
                s.style.color = '#ffd700';
            } else {
                s.style.color = '#666';
            }
        });
    });
});

// AI Review generation
function generateAIReview() {
    const content = document.getElementById('ai-review-content');
    const loading = document.getElementById('ai-loading');

    content.style.display = 'none';
    loading.style.display = 'block';

    fetch('/movies/generateReview/<?= $movie['imdbID'] ?>')
        .then(response => response.json())
        .then(data => {
            loading.style.display = 'none';
            content.style.display = 'block';

            if (data.error) {
                content.innerHTML = '<div class="alert alert-danger">' + data.error + '</div>';
            } else {
                content.innerHTML = '<p>' + data.review.replace(/\n/g, '<br>') + '</p>';
            }
        })
        .catch(error => {
            loading.style.display = 'none';
            content.style.display = 'block';
            content.innerHTML = '<div class="alert alert-danger">Failed to generate review. Please try again.</div>';
        });
}
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
