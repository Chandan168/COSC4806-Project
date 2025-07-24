<?php require_once 'app/views/templates/header.php' ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-6">
                    <i class="fas fa-sign-in-alt"></i> Login Statistics
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
                    <h5><i class="fas fa-chart-bar"></i> Login Count by User</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Username</th>
                                    <th>Total Logins</th>
                                    <th>Activity Level</th>
                                    <th>Visual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($loginCounts)): ?>
                                    <?php 
                                    $maxLogins = max(array_column($loginCounts, 'login_count'));
                                    foreach ($loginCounts as $user): 
                                        $percentage = $maxLogins > 0 ? ($user['login_count'] / $maxLogins) * 100 : 0;
                                    ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">
                                                    <?php echo htmlspecialchars($user['username']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?php echo $user['login_count']; ?></strong>
                                            </td>
                                            <td>
                                                <?php
                                                $count = (int)$user['login_count'];
                                                if ($count >= 20) {
                                                    echo '<span class="badge bg-success">Very Active</span>';
                                                } elseif ($count >= 10) {
                                                    echo '<span class="badge bg-warning">Active</span>';
                                                } elseif ($count > 0) {
                                                    echo '<span class="badge bg-info">Moderate</span>';
                                                } else {
                                                    echo '<span class="badge bg-secondary">No Logins</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="progress" style="width: 100px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: <?php echo $percentage; ?>%" 
                                                         aria-valuenow="<?php echo $percentage; ?>" 
                                                         aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No login data found</td>
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
                    <h5><i class="fas fa-chart-bar"></i> Login Activity</h5>
                </div>
                <div class="card-body">
                    <canvas id="loginChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Login Chart
const loginCtx = document.getElementById('loginChart').getContext('2d');
const loginData = <?php echo json_encode($loginCounts ?? []); ?>;
const loginLabels = loginData.map(item => item.username);
const loginCounts = loginData.map(item => parseInt(item.login_count));

new Chart(loginCtx, {
    type: 'bar',
    data: {
        labels: loginLabels,
        datasets: [{
            label: 'Login Count',
            data: loginCounts,
            backgroundColor: '#36A2EB',
            borderColor: '#2196F3',
            borderWidth: 1
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
