<?php
class Reminders extends Controller {

    private function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    private function isAuthenticated() {
        return isset($_SESSION['auth']) && $_SESSION['auth'] == 1 && $this->getUserId();
    }

    private function authCheck() {
        if (!$this->isAuthenticated()) {
            header('Location: /login');
            exit;
        }
    }

    public function index() {
        $this->authCheck();
        $userId = $this->getUserId();

        $reminder = $this->model('Reminder');
        $reminders = $reminder->getAllByUser($userId);

        $data = ['reminders' => $reminders];
        $this->view('reminders/index', $data);
    }

    public function create() {
        $this->authCheck();
        $this->view('reminders/create');
    }

    public function store() {
        $this->authCheck();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? '';
            $content = $_POST['content'] ?? '';
            $userId = $this->getUserId();

            if (!empty($subject)) {
                $reminder = $this->model('Reminder');

                if ($reminder->create($userId, $subject, $content)) {
                    header('Location: /reminders');
                    exit;
                }
            }
        }

        header('Location: /reminders/create');
        exit;
    }

    public function edit($id = null) {
        $this->authCheck();
        $userId = $this->getUserId();

        if (!$id) {
            header('Location: /reminders');
            exit;
        }

        $reminder = $this->model('Reminder');
        $data['reminder'] = $reminder->getById($id, $userId);

        if (!$data['reminder']) {
            header('Location: /reminders');
            exit;
        }

        $this->view('reminders/edit', $data);
    }

    public function update($id = null) {
        $this->authCheck();
        $userId = $this->getUserId();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $subject = $_POST['subject'] ?? '';
            $content = $_POST['content'] ?? '';
            $completed = isset($_POST['completed']) ? 1 : 0;

            if (!empty($subject)) {
                $reminder = $this->model('Reminder');
                $reminder->update($id, $userId, $subject, $content, $completed);
            }
        }

        header('Location: /reminders');
        exit;
    }

    public function delete($id = null) {
        $this->authCheck();
        $userId = $this->getUserId();

        if ($id) {
            $reminder = $this->model('Reminder');
            $reminder->delete($id, $userId);
        }

        header('Location: /reminders');
        exit;
    }

    public function toggle($id = null) {
        $this->authCheck();
        $userId = $this->getUserId();

        if ($id) {
            $reminder = $this->model('Reminder');
            $reminder->toggleComplete($id, $userId);
        }

        header('Location: /reminders');
        exit;
    }
}
