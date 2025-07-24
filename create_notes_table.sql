
CREATE TABLE IF NOT EXISTS reminders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed TINYINT(1) DEFAULT 0,
    deleted TINYINT(1) DEFAULT 0,
    INDEX idx_user_id (user_id),
    INDEX idx_deleted (deleted)
);
