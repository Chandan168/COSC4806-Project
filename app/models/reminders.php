<?php
class Reminder {

    public function getAllByUser($userId) {
        $db = db_connect();
        if ($db === null) {
            return [];
        }
        $statement = $db->prepare("SELECT * FROM notes WHERE user_id = :user_id AND deleted = 0 ORDER BY created_at DESC");
        $statement->bindValue(':user_id', $userId);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id, $userId) {
        $db = db_connect();
        if ($db === null) {
            return null;
        }
        $statement = $db->prepare("SELECT * FROM notes WHERE id = :id AND user_id = :user_id AND deleted = 0");
        $statement->bindValue(':id', $id);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    public function create($userId, $subject, $content = '') {
        $db = db_connect();
        if ($db === null) {
            return false;
        }
        $statement = $db->prepare("INSERT INTO notes (user_id, subject, content) VALUES (:user_id, :subject, :content)");
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':subject', $subject);
        $statement->bindValue(':content', $content);
        return $statement->execute();
    }
    public function update($id, $userId, $subject, $content, $completed = 0) {
        $db = db_connect();
        if ($db === null) {
            return false;
        }
        $statement = $db->prepare("UPDATE notes SET subject = :subject, content = :content, completed = :completed WHERE id = :id AND user_id = :user_id");
        $statement->bindValue(':id', $id);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':subject', $subject);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':completed', $completed);
        return $statement->execute();
    }
    public function delete($id, $userId) {
        $db = db_connect();
        if ($db === null) {
            return false;
        }
        $statement = $db->prepare("UPDATE notes SET deleted = 1 WHERE id = :id AND user_id = :user_id");
        $statement->bindValue(':id', $id);
        $statement->bindValue(':user_id', $userId);
        return $statement->execute();
    }
    public function toggleCompleted($id, $userId) {
        $db = db_connect();
        if ($db === null) {
            return false;
        }
        $statement = $db->prepare("UPDATE notes SET completed = NOT completed WHERE id = :id AND user_id = :user_id");
        $statement->bindValue(':id', $id);
        $statement->bindValue(':user_id', $userId);
        return $statement->execute();
    }
}