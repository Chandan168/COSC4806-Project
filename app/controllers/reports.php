<?php

class Reports extends Controller {

    public function __construct() {
        // Check if user is logged in
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            exit;
        }

        // Check if user is admin
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            $_SESSION['error_message'] = "Access denied. Admin privileges required.";
            header('Location: /home');
            exit;
        }
    }

    public function index() {
        $data = $this->getAllReportsData();
        
        // Debug output
        error_log("Debug - Total Reminders: " . ($data['totalReminders'] ?? 'null'));
        error_log("Debug - Total Users: " . ($data['totalUsers'] ?? 'null'));
        error_log("Debug - All Reminders count: " . count($data['allReminders'] ?? []));
        error_log("Debug - User Reminder Counts: " . print_r($data['userReminderCounts'] ?? [], true));
        error_log("Debug - Login Counts: " . print_r($data['loginCounts'] ?? [], true));
        
        $this->view('reports/index', $data);
    }

    private function getAllReportsData() {
        $reminder = $this->model('Reminder');
        $user = $this->model('User');

        // Get data with fallback to empty arrays/zero if database fails
        return [
            'allReminders' => $reminder->getAllReminders() ?: [],
            'userReminderCounts' => $reminder->getUserReminderCounts() ?: [],
            'loginCounts' => $user->getLoginCounts() ?: [],
            'totalReminders' => $reminder->getTotalReminderCount() ?: 0,
            'totalUsers' => $user->getTotalUserCount() ?: 0,
            'completedReminders' => $reminder->getCompletedReminderCount() ?: 0,
            'remindersByDate' => $reminder->getRemindersByDate() ?: []
        ];
    }

    public function allReminders() {
        $reminder = $this->model('Reminder');
        $data = ['allReminders' => $reminder->getAllReminders()];
        $this->view('reports/allReminders', $data);
    }

    public function topUsers() {
        $reminder = $this->model('Reminder');
        $data = ['userReminderCounts' => $reminder->getUserReminderCounts()];
        $this->view('reports/topUsers', $data);
    }

    public function loginStats() {
        $user = $this->model('User');
        $data = ['loginCounts' => $user->getLoginCounts()];
        $this->view('reports/loginStats', $data);
    }
}
