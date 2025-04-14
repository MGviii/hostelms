DELETE FROM users;
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES ('Admin User', 'admin@hostelms.com', 'admin123', 'admin', NOW(), NOW());
