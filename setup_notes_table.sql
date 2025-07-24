
-- Create the notes table for the reminder system
-- Run this in your database to set up the table structure

CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed TINYINT(1) DEFAULT 0,
    deleted TINYINT(1) DEFAULT 0,
    INDEX idx_user_id (user_id),
    INDEX idx_user_deleted (user_id, deleted),
    INDEX idx_created_at (created_at)
);

-- For PostgreSQL, use this version instead:
-- CREATE TABLE IF NOT EXISTS notes (
--     id SERIAL PRIMARY KEY,
--     user_id INTEGER NOT NULL,
--     subject VARCHAR(255) NOT NULL,
--     content TEXT,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     completed SMALLINT DEFAULT 0,
--     deleted SMALLINT DEFAULT 0
-- );
-- 
-- CREATE INDEX IF NOT EXISTS idx_notes_user_id ON notes(user_id);
-- CREATE INDEX IF NOT EXISTS idx_notes_user_deleted ON notes(user_id, deleted);
-- CREATE INDEX IF NOT EXISTS idx_notes_created_at ON notes(created_at);
