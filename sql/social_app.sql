CREATE DATABASE IF NOT EXISTS campusconnect;
USE campusconnect;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    bio TEXT,
    profile_image VARCHAR(255),
    profile_pic VARCHAR(255) DEFAULT 'default-avatar.svg',
    last_active TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    UNIQUE(post_id, user_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (username, password, full_name, bio, profile_pic)
VALUES
('demo_admin', '$2y$10$gd5LdnX6zerH8MuFSH5C1O4pe7eVP5iTivXtOPRVypatd2WGxdqAK', 'Demo Admin', 'CampusConnect demo administrator account.', 'default-avatar.svg'),
('demo_student', '$2y$10$gd5LdnX6zerH8MuFSH5C1O4pe7eVP5iTivXtOPRVypatd2WGxdqAK', 'Demo Student', 'Enjoys sharing updates and joining discussions.', 'default-avatar.svg')
ON DUPLICATE KEY UPDATE
full_name = VALUES(full_name),
bio = VALUES(bio),
profile_pic = VALUES(profile_pic);

INSERT INTO posts (user_id, content, image)
SELECT u.id, 'Welcome to CampusConnect! Share updates, photos, and connect with your classmates.', NULL
FROM users u
WHERE u.username = 'demo_admin'
  AND NOT EXISTS (
      SELECT 1 FROM posts p WHERE p.user_id = u.id AND p.content = 'Welcome to CampusConnect! Share updates, photos, and connect with your classmates.'
  );
