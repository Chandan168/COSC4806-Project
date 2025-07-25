<?php

class Movie {

    public function searchMovies($query) {
        $omdbKey = getenv('OMDB_KEY');
        if (!$omdbKey) {
            return ['error' => 'OMDB API key not configured'];
        }

        $url = "http://www.omdbapi.com/?apikey={$omdbKey}&s=" . urlencode($query);
        $response = file_get_contents($url);

        if ($response === false) {
            return ['error' => 'Failed to fetch movie data'];
        }

        return json_decode($response, true);
    }

    public function getMovieDetails($imdbId) {
        $omdbKey = getenv('OMDB_KEY');
        if (!$omdbKey) {
            return ['error' => 'OMDB API key not configured'];
        }

        $url = "http://www.omdbapi.com/?apikey={$omdbKey}&i={$imdbId}&plot=full";
        $response = file_get_contents($url);

        if ($response === false) {
            return ['error' => 'Failed to fetch movie details'];
        }

        return json_decode($response, true);
    }

    public function saveMovie($movieData) {
        $db = db_connect();
        if ($db === null) {
            return false;
        }

        $statement = $db->prepare("
            INSERT IGNORE INTO movies (imdb_id, title, year, poster, plot, director, actors, genre, runtime, imdb_rating) 
            VALUES (:imdb_id, :title, :year, :poster, :plot, :director, :actors, :genre, :runtime, :imdb_rating)
        ");

        $statement->bindValue(':imdb_id', $movieData['imdbID']);
        $statement->bindValue(':title', $movieData['Title']);
        $statement->bindValue(':year', $movieData['Year']);
        $statement->bindValue(':poster', $movieData['Poster']);
        $statement->bindValue(':plot', $movieData['Plot']);
        $statement->bindValue(':director', $movieData['Director']);
        $statement->bindValue(':actors', $movieData['Actors']);
        $statement->bindValue(':genre', $movieData['Genre']);
        $statement->bindValue(':runtime', $movieData['Runtime']);
        $statement->bindValue(':imdb_rating', $movieData['imdbRating']);

        return $statement->execute();
    }

    public function getMovieByImdbId($imdbId) {
        $db = db_connect();
        if ($db === null) {
            return null;
        }

        $statement = $db->prepare("SELECT * FROM movies WHERE imdb_id = :imdb_id");
        $statement->bindValue(':imdb_id', $imdbId);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function addRating($movieId, $userId, $rating, $review = '') {
        $db = db_connect();
        if ($db === null) {
            return false;
        }

        $statement = $db->prepare("
            INSERT INTO movie_ratings (movie_id, user_id, rating, review) 
            VALUES (:movie_id, :user_id, :rating, :review)
        ");

        $statement->bindValue(':movie_id', $movieId);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':rating', $rating);
        $statement->bindValue(':review', $review);

        return $statement->execute();
    }

    public function getAverageRating($movieId) {
        $db = db_connect();
        if ($db === null) {
            return 0;
        }

        $statement = $db->prepare("
            SELECT AVG(rating) as avg_rating, COUNT(*) as total_ratings 
            FROM movie_ratings 
            WHERE movie_id = :movie_id
        ");
        $statement->bindValue(':movie_id', $movieId);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return [
            'average' => round($result['avg_rating'], 1),
            'count' => $result['total_ratings']
        ];
    }

    public function getUserRating($movieId, $userId) {
        $db = db_connect();
        if ($db === null) {
            return null;
        }

        $statement = $db->prepare("
            SELECT rating, review FROM movie_ratings 
            WHERE movie_id = :movie_id AND user_id = :user_id
        ");
        $statement->bindValue(':movie_id', $movieId);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function generateAIReview($movieData) {
        $geminiKey = getenv('GEMINI');
        if (!$geminiKey) {
            return ['error' => 'Gemini API key not configured'];
        }

        $prompt = "Write a detailed movie review for '{$movieData['title']}' ({$movieData['year']}). " .
                 "Genre: {$movieData['genre']}. Director: {$movieData['director']}. " .
                 "Plot: {$movieData['plot']}. " .
                 "Write a professional review in 150-200 words covering plot, performances, direction, and overall impact.";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Content-Type: application/json',
                    'x-goog-api-key: ' . $geminiKey
                ],
                'content' => json_encode($payload)
            ]
        ]);

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            return ['error' => 'Failed to generate AI review'];
        }

        $data = json_decode($response, true);

        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return ['review' => $data['candidates'][0]['content']['parts'][0]['text']];
        }

        return ['error' => 'Invalid response from AI service'];
    }

    public function saveAIReview($movieId, $reviewText) {
        $db = db_connect();
        if ($db === null) {
            return false;
        }

        $statement = $db->prepare("
            INSERT INTO ai_reviews (movie_id, review_text) 
            VALUES (:movie_id, :review_text)
        ");

        $statement->bindValue(':movie_id', $movieId);
        $statement->bindValue(':review_text', $reviewText);

        return $statement->execute();
    }

    public function getAIReview($movieId) {
        $db = db_connect();
        if ($db === null) {
            return null;
        }

        $statement = $db->prepare("
            SELECT review_text FROM ai_reviews 
            WHERE movie_id = :movie_id 
            ORDER BY generated_at DESC 
            LIMIT 1
        ");
        $statement->bindValue(':movie_id', $movieId);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['review_text'] : null;
    }
}
