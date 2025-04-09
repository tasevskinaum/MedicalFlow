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

INSERT INTO users (role_id, name, username, email, password)
VALUES 
    (1, "Naum Tasevski", "tasevskinaum", "tasevskinaum@yahoo.com", "$2y$10$oyGjyFRsDCZD8vxb4kc6beNLC/TqL8Q5Gvx2aIXYr2etVKVZCAa.y"),
    (2, "Admin Admin", "admin", "admin@admin.com", "$2y$10$dzGPLdH5S.wpLwr6rl.N2ufdnR0TvWeUlWo5Sjp7vBzb5uIgDGyBC"),
    (3, "Doctor Doctor", "doctor", "doctor@doctor.com", "$2y$10$mpFwYR9UD0edrBHVCW2wUu9PsSVMVFeWY2ublqVMekwOOrbofdDxK");


CREATE TABLE doctor_profile(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED,
	short_bio LONGTEXT,
	phone_number VARCHAR(16),
	is_completed BOOLEAN DEFAULT 0,
	CONSTRAINT fk_user FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE doctor_schedules (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    date DATE NOT NULL,
    time_from TIME NOT NULL,
    time_to TIME NOT NULL,
    CONSTRAINT fk_user_1 FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE patients(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(32) NOT NULL,
    last_name VARCHAR(32) NOT NULL,
    personal_no VARCHAR(13) NOT NULL,
    phone_number VARCHAR(32) NOT NULL
);

CREATE TABLE doctor_appointments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    doctor_schedule_id INT UNSIGNED,
    time TIME NOT NULL,
    is_booked BOOLEAN DEFAULT 0,
    patient_id INT UNSIGNED,
    note TEXT,
    diagnosis TEXT,
    CONSTRAINT fk_doctor_schedule FOREIGN KEY(doctor_schedule_id) REFERENCES doctor_schedules(id),
    CONSTRAINT fk_patient FOREIGN KEY(patient_id) REFERENCES patients(id)
);