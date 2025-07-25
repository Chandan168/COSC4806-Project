<?php 
if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
    require_once 'app/views/templates/header.php';
} else {
    require_once 'app/views/templates/headerPublic.php';
}
?>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Search Movies</h1>

    <form action="/movies/search" method="get" class="mb-4">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Enter movie name..." required>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <?php if (isset($data['error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($data['error']); ?></div>
    <?php endif; ?>

    <?php if (!empty($data['movies'])): ?>
        <div class="row">
            <?php foreach ($data['movies'] as $movie): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow">
                        <?php if (!empty($movie['poster']) && $movie['poster'] !== 'N/A'): ?>
                            <img src="<?php echo htmlspecialchars($movie['poster']); ?>" class="card-img-top" alt="Poster of <?php echo htmlspecialchars($movie['title']); ?>">
                        <?php else: ?>
                            <img src="/public/images/no-image.png" class="card-img-top" alt="No image available">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h5>
                            <p class="card-text">Year: <?php echo htmlspecialchars($movie['year']); ?></p>
                            <p class="card-text">IMDB ID: <?php echo htmlspecialchars($movie['imdb_id']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($data['movies']) && empty($data['movies'])): ?>
        <div class="alert alert-warning">No movies found for your search.</div>
    <?php endif; ?>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
