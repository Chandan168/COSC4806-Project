<?php require_once 'app/views/templates/header.php' ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-6">
                    <i class="fas fa-chart-bar"></i> Admin Reports Dashboard
                    <span class="badge bg-danger">ADMIN ONLY</span>
                </h1>
                <div class="btn-group" role="group">
                    <a href="/reports/allReminders" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> All Reminders
                    </a>
                    <a href="/reports/topUsers" class="btn btn-outline-success">
                        <i class="fas fa-users"></i> Top Users
                    </a>
                    <a href="/reports/loginStats" class="btn btn-outline-info">
                        <i class="fas fa-sign-in-alt"></i> Login Stats
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Reminders</h5>
                            <h3><?php echo $totalReminders ?? 0; ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-sticky-note fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Completed</h5>
                            <h3><?php echo $completedReminders ?? 0; ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Total Users</h5>
                            <h3><?php echo $totalUsers ?? 0; ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Active Today</h5>
                            <h3><?php echo count($remindersByDate ?? []) > 0 ? $remindersByDate[0]['count'] : 0; ?></h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie"></i> Reminders by User</h5>
                </div>
                <div class="card-body">
                    <canvas id="userRemindersChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-line"></i> Reminders Over Time</h5>
                </div>
                <div class="card-body">
                    <canvas id="remindersTimeChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-clock"></i> Recent Reminders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Subject</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($allReminders)): ?>
                                    <?php foreach (array_slice($allReminders, 0, 10) as $reminder): ?>
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
                                                if (!empty($reminder['created_at'])) {
                                                    $dt = new DateTime($reminder['created_at'], new DateTimeZone('UTC'));
                                                    $dt->setTimezone(new DateTimeZone('America/Toronto')); 
                                                    echo $dt->format('M j, Y g:i A');
                                                } else {
                                                    $dt = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
                                                    echo $dt->format('M j, Y g:i A');
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($reminder['completed']): ?>
                                                    <span class="badge bg-success">Completed</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No reminders found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// User Reminders Pie Chart
const userRemindersCtx = document.getElementById('userRemindersChart').getContext('2d');
const userRemindersData = <?php echo json_encode($userReminderCounts ?? []); ?>;

const userLabels = userRemindersData.map(item => item.username);
const userCounts = userRemindersData.map(item => parseInt(item.reminder_count));

new Chart(userRemindersCtx, {
    type: 'pie',
    data: {
        labels: userLabels,
        datasets: [{
            data: userCounts,
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
                '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
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

// Reminders Over Time Line Chart
const remindersTimeCtx = document.getElementById('remindersTimeChart').getContext('2d');
const timeData = <?php echo json_encode($remindersByDate ?? []); ?>;

const timeLabels = timeData.map(item => item.date);
const timeCounts = timeData.map(item => parseInt(item.count));

new Chart(remindersTimeCtx, {
    type: 'line',
    data: {
        labels: timeLabels.reverse(),
        datasets: [{
            label: 'Reminders Created',
            data: timeCounts.reverse(),
            borderColor: '#36A2EB',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php require_once 'app/views/templates/footer.php' ?>
