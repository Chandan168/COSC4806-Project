<?php require_once 'app/views/templates/header.php' ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-6">
                    <i class="fas fa-users"></i> Top Users by Reminders
                </h1>
                <a href="/reports" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-trophy"></i> User Rankings</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Rank</th>
                                    <th>Username</th>
                                    <th>Total Reminders</th>
                                    <th>Activity Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($userReminderCounts)): ?>
                                    <?php foreach ($userReminderCounts as $index => $user): ?>
                                        <tr>
                                            <td>
                                                <?php if ($index === 0): ?>
                                                    <i class="fas fa-crown text-warning"></i> #1
                                                <?php elseif ($index === 1): ?>
                                                    <i class="fas fa-medal text-secondary"></i> #2
                                                <?php elseif ($index === 2): ?>
                                                    <i class="fas fa-medal text-warning"></i> #3
                                                <?php else: ?>
                                                    #<?php echo $index + 1; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    <?php echo htmlspecialchars($user['username']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?php echo $user['reminder_count']; ?></strong>
                                            </td>
                                            <td>
                                                <?php
                                                $count = (int)$user['reminder_count'];
                                                if ($count >= 10) {
                                                    echo '<span class="badge bg-success">Very Active</span>';
                                                } elseif ($count >= 5) {
                                                    echo '<span class="badge bg-warning">Moderate</span>';
                                                } elseif ($count > 0) {
                                                    echo '<span class="badge bg-info">Light</span>';
                                                } else {
                                                    echo '<span class="badge bg-secondary">No Activity</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No users found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie"></i> Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="userDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// User Distribution Chart
const ctx = document.getElementById('userDistributionChart').getContext('2d');
const userData = <?php echo json_encode($userReminderCounts ?? []); ?>;
const labels = userData.slice(0, 5).map(item => item.username); // Top 5 users
const data = userData.slice(0, 5).map(item => parseInt(item.reminder_count));

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            data: data,
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<?php require_once 'app/views/templates/footer.php' ?>
