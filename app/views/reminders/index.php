<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h1 class="display-4">My Notes & Reminders</h1>
    <a href="/reminders/create" class="btn btn-success btn-lg">Add New Note</a>

    <?php if (empty($data['reminders'])): ?>
        <div class="alert alert-info">No notes found.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($data['reminders'] as $reminder): ?>
                <div class="col-md-6 mb-4">
                    <div class="card p-3 shadow-sm rounded">
                        <h5><?php echo htmlspecialchars($reminder['subject']); ?></h5>

                        <?php
                        if (!empty($reminder['created_at'])) {
                            $dt = new DateTime($reminder['created_at'], new DateTimeZone('UTC'));
                            $dt->setTimezone(new DateTimeZone('America/Toronto')); 
                            echo '<small class="text-muted">Created at: ' . $dt->format('M d, Y g:i A') . '</small>';
                        }
                        ?>

                        <div class="mt-2">
                            <a href="/reminders/edit/<?php echo $reminder['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="/reminders/delete/<?php echo $reminder['id']; ?>" class="btn btn-danger"
                               onclick="return confirm('Are you sure you want to delete this note?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
