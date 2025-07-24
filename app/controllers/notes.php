<?php

class Notes extends Controller {

    public function index() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        $note = $this->model('Note');
        $notes = $note->getUserNotes($_SESSION['user_id']);
        
        $this->view('notes/index', ['notes' => $notes]);
    }
    
    public function create() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? '';
            $content = $_POST['content'] ?? '';
            
            if (empty(trim($subject))) {
                $_SESSION['note_error'] = "Subject is required.";
                header('Location: /notes/create');
                die;
            }
            
            $note = $this->model('Note');
            if ($note->createNote($_SESSION['user_id'], $subject, $content)) {
                $_SESSION['note_success'] = "Note created successfully!";
                header('Location: /notes');
                die;
            } else {
                $_SESSION['note_error'] = "Failed to create note. Please try again.";
                header('Location: /notes/create');
                die;
            }
        }
        
        $this->view('notes/create');
    }
    
    public function edit() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        $note_id = $_GET['id'] ?? null;
        if (!$note_id) {
            header('Location: /notes');
            die;
        }
        
        $note = $this->model('Note');
        $noteData = $note->getNote($note_id, $_SESSION['user_id']);
        
        if (!$noteData) {
            $_SESSION['note_error'] = "Note not found.";
            header('Location: /notes');
            die;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? '';
            $content = $_POST['content'] ?? '';
            $completed = isset($_POST['completed']) ? 1 : 0;
            
            if (empty(trim($subject))) {
                $_SESSION['note_error'] = "Subject is required.";
                header('Location: /notes/edit?id=' . $note_id);
                die;
            }
            
            if ($note->updateNote($note_id, $_SESSION['user_id'], $subject, $content, $completed)) {
                $_SESSION['note_success'] = "Note updated successfully!";
                header('Location: /notes');
                die;
            } else {
                $_SESSION['note_error'] = "Failed to update note. Please try again.";
                header('Location: /notes/edit?id=' . $note_id);
                die;
            }
        }
        
        $this->view('notes/edit', ['note' => $noteData]);
    }
    
    public function delete() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        $note_id = $_POST['id'] ?? null;
        if (!$note_id) {
            header('Location: /notes');
            die;
        }
        
        $note = $this->model('Note');
        if ($note->deleteNote($note_id, $_SESSION['user_id'])) {
            $_SESSION['note_success'] = "Note deleted successfully!";
        } else {
            $_SESSION['note_error'] = "Failed to delete note.";
        }
        
        header('Location: /notes');
        die;
    }
    
    public function toggle() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        $note_id = $_POST['id'] ?? null;
        if (!$note_id) {
            header('Location: /notes');
            die;
        }
        
        $note = $this->model('Note');
        $note->toggleCompleted($note_id, $_SESSION['user_id']);
        
        header('Location: /notes');
        die;
    }
}
<?php

class Notes extends Controller {

    public function index() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        $note = $this->model('Note');
        $notes = $note->getUserNotes($_SESSION['user_id']);
        
        $this->view('notes/index', ['notes' => $notes]);
    }
    
    public function create() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? '';
            $content = $_POST['content'] ?? '';
            
            if (empty(trim($subject))) {
                $this->view('notes/create', ['error' => 'Subject is required.']);
                return;
            }
            
            $note = $this->model('Note');
            if ($note->createNote($_SESSION['user_id'], $subject, $content)) {
                header('Location: /notes');
                die;
            } else {
                $this->view('notes/create', ['error' => 'Failed to create note. Please try again.']);
                return;
            }
        }
        
        $this->view('notes/create');
    }
    
    public function edit() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        // Get note ID from URL segments
        $url_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $note_id = end($url_parts);
        
        if (!$note_id || !is_numeric($note_id)) {
            header('Location: /notes');
            die;
        }
        
        $note = $this->model('Note');
        $noteData = $note->getNote($note_id, $_SESSION['user_id']);
        
        if (!$noteData) {
            header('Location: /notes');
            die;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? '';
            $content = $_POST['content'] ?? '';
            $completed = isset($_POST['completed']) ? 1 : 0;
            
            if (empty(trim($subject))) {
                $this->view('notes/edit', ['note' => $noteData, 'error' => 'Subject is required.']);
                return;
            }
            
            if ($note->updateNote($note_id, $_SESSION['user_id'], $subject, $content, $completed)) {
                header('Location: /notes');
                die;
            } else {
                $this->view('notes/edit', ['note' => $noteData, 'error' => 'Failed to update note. Please try again.']);
                return;
            }
        }
        
        $this->view('notes/edit', ['note' => $noteData]);
    }
    
    public function delete() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        // Get note ID from URL segments
        $url_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $note_id = end($url_parts);
        
        if (!$note_id || !is_numeric($note_id)) {
            header('Location: /notes');
            die;
        }
        
        $note = $this->model('Note');
        $note->deleteNote($note_id, $_SESSION['user_id']);
        
        header('Location: /notes');
        die;
    }
    
    public function toggle() {
        if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
            header('Location: /login');
            die;
        }
        
        $url_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $note_id = end($url_parts);
        
        if (!$note_id || !is_numeric($note_id)) {
            header('Location: /notes');
            die;
        }
        
        $note = $this->model('Note');
        $note->toggleCompleted($note_id, $_SESSION['user_id']);
        
        header('Location: /notes');
        die;
    }
}
