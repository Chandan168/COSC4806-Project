<?php

class Movies extends Controller {

    public function index() {
        $query = $_GET['q'] ?? '';
        $movies = [];
        $error = '';

        if (!empty($query)) {
            $movieModel = $this->model('Movie');
            $result = $movieModel->searchMovies($query);

            if (isset($result['error'])) {
                $error = $result['error'];
            } elseif (isset($result['Search'])) {
                $movies = $result['Search'];
            } elseif (isset($result['Error'])) {
                $error = $result['Error'];
            }
        }

        $this->view('movies/index', [
            'query' => $query,
            'movies' => $movies,
            'error' => $error
        ]);
    }

    public function details($imdbId = '') {
        if (empty($imdbId)) {
            header('Location: /movies');
            exit;
        }

        $movieModel = $this->model('Movie');

        // Get movie details from OMDB
        $movieData = $movieModel->getMovieDetails($imdbId);

        if (isset($movieData['error']) || isset($movieData['Error'])) {
            header('Location: /movies');
            exit;
        }

        // Save movie to database
        $movieModel->saveMovie($movieData);

        // Get movie from database
        $movie = $movieModel->getMovieByImdbId($imdbId);

        // Get ratings
        $ratings = $movieModel->getAverageRating($movie['id']);

        // Get user rating if logged in
        $userRating = null;
        if (isset($_SESSION['user_id'])) {
            $userRating = $movieModel->getUserRating($movie['id'], $_SESSION['user_id']);
        }

        // Get AI review
        $aiReview = $movieModel->getAIReview($movie['id']);

        $this->view('movies/details', [
            'movie' => $movieData,
            'movieDb' => $movie,
            'ratings' => $ratings,
            'userRating' => $userRating,
            'aiReview' => $aiReview
        ]);
    }

    public function rate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /movies');
            exit;
        }

        $movieId = $_POST['movie_id'] ?? '';
        $rating = $_POST['rating'] ?? '';
        $review = $_POST['review'] ?? '';
        $imdbId = $_POST['imdb_id'] ?? '';

        if (empty($movieId) || empty($rating) || $rating < 1 || $rating > 5) {
            header('Location: /movies/details/' . $imdbId);
            exit;
        }

        $userId = $_SESSION['user_id'] ?? null;

        $movieModel = $this->model('Movie');
        $success = $movieModel->addRating($movieId, $userId, $rating, $review);

        if ($success) {
            $_SESSION['success_message'] = 'Rating submitted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to submit rating.';
        }

        header('Location: /movies/details/' . $imdbId);
        exit;
    }

    public function generateReview($movieId = '') {
        if (empty($movieId)) {
            echo json_encode(['error' => 'Movie ID required']);
            exit;
        }

        $movieModel = $this->model('Movie');

        // Check if review already exists
        $existingReview = $movieModel->getAIReview($movieId);
        if ($existingReview) {
            echo json_encode(['review' => $existingReview]);
            exit;
        }

        // Get movie data
        $movie = $movieModel->getMovieByImdbId($movieId);
        if (!$movie) {
            echo json_encode(['error' => 'Movie not found']);
            exit;
        }

        // Generate AI review
        $result = $movieModel->generateAIReview($movie);

        if (isset($result['error'])) {
            echo json_encode($result);
            exit;
        }

        // Save the review
        $movieModel->saveAIReview($movie['id'], $result['review']);

        echo json_encode($result);
        exit;
    }
}
