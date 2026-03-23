-- 文字コード設定
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- データベース選択
USE testdb;

-- ユーザー管理テーブル
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(255) NOT NULL UNIQUE,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- テスト用初期データ
INSERT INTO users (name, email) VALUES
    ('テストユーザー', 'test@example.com'),
    ('管理者', 'admin@example.com');
