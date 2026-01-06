CREATE DATABASE sams;
USE sams;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('ADMIN','TEACHER','STUDENT')
);

CREATE TABLE programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);

CREATE TABLE semesters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    program_id INT,
    semester_no INT,
    FOREIGN KEY (program_id) REFERENCES programs(id)
);

CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    semester_id INT,
    name VARCHAR(100),
    FOREIGN KEY (semester_id) REFERENCES semesters(id)
);

CREATE TABLE teacher_subjects (
    teacher_id INT,
    subject_id INT,
    FOREIGN KEY (teacher_id) REFERENCES users(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

CREATE TABLE enrollments (
    student_id INT,
    semester_id INT,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (semester_id) REFERENCES semesters(id)
);

CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT,
    day VARCHAR(15),
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    subject_id INT,
    date DATE,
    status ENUM('PRESENT','ABSENT'),
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);
