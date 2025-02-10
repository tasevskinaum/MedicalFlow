	CREATE DATABASE clinic_manager;
USE clinic_manager;

CREATE TABLE roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(16) NOT NULL
);

INSERT INTO roles (name)
VALUES ('super_admin'), ('admin'), ('doctor');

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id INT UNSIGNED,
    name VARCHAR(32) NOT NULL,
    username VARCHAR(16) NOT NULL,
    email VARCHAR(32) NOT NULL,
    password VARCHAR(64) NOT NULL,
    CONSTRAINT fk_role FOREIGN KEY(role_id) REFERENCES roles(id)
);

INSERT INTO users(role_id, name, username, email, password)
VALUES (1, "Naum Tasevski", "tasevskinaum", "tasevskinaum@yahoo.com", "$2y$10$MECK5MRpIDVQtafi.O4gxuEstzDkyyzz2lc3.HK2P8bmHCJ7p0m0W");

CREATE TABLE doctor_profile(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED,
	short_bio LONGTEXT,
	phone_number VARCHAR(16),
	is_completed BOOLEAN DEFAULT 0,
	CONSTRAINT fk_user FOREIGN KEY(user_id) REFERENCES users(id)
);