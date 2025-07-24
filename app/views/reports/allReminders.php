<?php require_once 'app/views/templates/header.php' ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-6">
                    <i class="fas fa-list"></i> All Reminders Report
                </h1>
                <a href="/reports" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-sticky-note"></i> Complete Reminders List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Subject</th>
                            <th>Content</th>
                            <th>Created</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($allReminders)): ?>
                            <?php foreach ($allReminders as $reminder): ?>
                                <tr>
                                    <td><?php echo $reminder['id']; ?></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?php echo htmlspecialchars($reminder['username'] ?? 'Unknown'); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($reminder['subject']); ?></td>
                                    <td>
                                        <?php 
                                        $content = htmlspecialchars($reminder['content']);
                                        echo strlen($content) > 50 ? substr($content, 0, 50) . '...' : $content;
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        if (!empty($reminder['created_at'])) {
                                            $utc = new DateTime($reminder['created_at'], new DateTimeZone('UTC'));
                                            $utc->setTimezone(new DateTimeZone('America/Toronto'));
                                            echo $utc->format('M j, Y g:i A');
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($reminder['completed']): ?>
                                            <span class="badge bg-success"><i class="fas fa-check"></i> Completed</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning"><i class="fas fa-clock"></i> Pending</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No reminders found in the system</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php' ?>
