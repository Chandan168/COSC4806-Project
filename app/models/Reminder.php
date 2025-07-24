<?php

class Reminder {

    public function getAllByUser($userId) {
        $db = db_connect();
        if ($db === null) {
            return [];
        }
        $statement = $db->prepare("SELECT * FROM reminders WHERE user_id = :user_id AND deleted = FALSE ORDER BY created_at DESC");
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $userId) {
        $db = db_connect();
        if ($db === null) {
            return null;
        }
        $statement = $db->prepare("SELECT * FROM reminders WHERE id = :id AND user_id = :user_id AND deleted = FALSE");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create($userId, $subject, $content = '') {
        $db = db_connect();
        if ($db === null) {
            return false;
        }
        $statement = $db->prepare("INSERT INTO reminders (user_id, subject, content) VALUES (:user_id, :subject, :content)");
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':subject', $subject, PDO::PARAM_STR);
        $statement->bindValue(':content', $content, PDO::PARAM_STR);
        return $statement->execute();
    }

    public function update($id, $userId, $subject, $content, $completed = false) {
        $db = db_connect();
        if ($db === null) {
            return false;
        }
        $statement = $db->prepare("UPDATE reminders SET subject = :subject, content = :content, completed = :completed WHERE id = :id AND user_id = :user_id");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':subject', $subject, PDO::PARAM_STR);
        $statement->bindValue(':content', $content, PDO::PARAM_STR);
        $statement->bindValue(':completed', $completed, PDO::PARAM_BOOL);
        return $statement->execute();
    }

    public function delete($id, $userId) {
        $db = db_connect();
        if ($db === null) {
            return false;
        }
        $statement = $db->prepare("UPDATE reminders SET deleted = TRUE WHERE id = :id AND user_id = :user_id");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        return $statement->execute();
    }

    public function toggleCompleted($id, $userId) {
        $db = db_connect();
        if ($db === null) {
            return false;
        }
        $statement = $db->prepare("UPDATE reminders SET completed = NOT completed WHERE id = :id AND user_id = :user_id");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        return $statement->execute();
    }

    public function markCompleted($id, $user_id) {
        $db = db_connect();
        if ($db === null) {
            return false;
        }
        $statement = $db->prepare("UPDATE reminders SET completed = 1 WHERE id = :id AND user_id = :user_id");
        $statement->bindValue(':id', $id);
        $statement->bindValue(':user_id', $user_id);
        return $statement->execute();
    }

    // Admin report methods
    public function getAllReminders() {
        $db = db_connect();
        if ($db === null) {
            return [];
        }
        $statement = $db->prepare("
            SELECT r.*, u.username 
            FROM reminders r 
            LEFT JOIN users u ON r.user_id = u.id 
            WHERE r.deleted = false 
            ORDER BY r.created_at DESC
        ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserReminderCounts() {
        $db = db_connect();
        if ($db === null) {
            return [];
        }
        $statement = $db->prepare("
            SELECT u.username, COUNT(r.id) as reminder_count 
            FROM users u 
            LEFT JOIN reminders r ON u.id = r.user_id AND r.deleted = false
            GROUP BY u.id, u.username 
            ORDER BY reminder_count DESC
        ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalReminderCount() {
        $db = db_connect();
        if ($db === null) {
            return 0;
        }
        $statement = $db->prepare("SELECT COUNT(*) as count FROM reminders WHERE deleted = false");
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getCompletedReminderCount() {
        $db = db_connect();
        if ($db === null) {
            return 0;
        }
        $statement = $db->prepare("SELECT COUNT(*) as count FROM reminders WHERE deleted = false AND completed = true");
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getRemindersByDate() {
        $db = db_connect();
        if ($db === null) {
            return [];
        }

        $statement = $db->prepare("
            SELECT 
                DATE(created_at AT TIME ZONE 'UTC' AT TIME ZONE 'America/Toronto') AS date,
                COUNT(*) AS count
            FROM reminders
            WHERE deleted = false
            GROUP BY DATE(created_at AT TIME ZONE 'UTC' AT TIME ZONE 'America/Toronto')
            ORDER BY date DESC
            LIMIT 30
        ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

