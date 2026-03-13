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

INSERT INTO programs (name) VALUES ('CSIT'), ('BBA');
-- CSIT
INSERT INTO semesters (program_id, semester_no) VALUES
(1,1),(1,2);

-- BBA
INSERT INTO semesters (program_id, semester_no) VALUES
(2,1);


INSERT INTO subjects (semester_id, name) VALUES
(1,'Mathematics I'),
(1,'IT-1'),
(1,'C Programming'),
(1,'Fundamentals of Computer'),
(1,'English');
INSERT INTO subjects (semester_id, name) VALUES
(2,'Mathematics II'),
(2,'Data Structures'),
(2,'English'),
(2,'Java Programming'),
(2,'Computer Electronics');


INSERT INTO subjects (semester_id, name) VALUES
(3,'Business Mathematics'),
(3,'Principles of Management'),
(3,'Micro Economics'),
(3,'Financial Accounting'),
(3,'English');

INSERT INTO users (name,email,password,role) VALUES
('Ram Sir','ram@uni.com','1234','TEACHER'),
('Sita Maam','sita@uni.com','1234','TEACHER'),
('Hari Sir','hari@uni.com','1234','TEACHER');


ALTER TABLE users ADD COLUMN semester_id INT;
UPDATE users SET semester_id = 1 WHERE email LIKE 'csit1_%@uni.com';
UPDATE users SET semester_id = 2 WHERE email LIKE 'csit2_%@uni.com';
UPDATE users SET semester_id = 3 WHERE email LIKE 'bba1_%@uni.com';



INSERT INTO teacher_subjects (teacher_id, subject_id) VALUES
(1,1),(1,2),
(2,3),(2,4),
(3,5);

INSERT INTO schedules (subject_id, day, start_time, end_time) VALUES
(1,'Sunday','10:00','11:00'),
(2,'Monday','11:00','12:00'),
(3,'Tuesday','10:00','11:00'),
(4,'Wednesday','12:00','13:00'),
(5,'Thursday','09:00','10:00');
INSERT INTO enrollments (student_id, semester_id)
SELECT id, 1 FROM users WHERE email LIKE 'csit1_%';

INSERT INTO users (name,email,password,role)
VALUES
('Sujan Shrestha','csit1_1@uni.com', MD5('1234'),'STUDENT'),
('Pratik Adhikari','csit1_2@uni.com', MD5('1234'),'STUDENT'),
('Anisha KC','csit1_3@uni.com', MD5('1234'),'STUDENT'),
('Ramesh Thapa','csit1_4@uni.com', MD5('1234'),'STUDENT'),
('Sita Magar','csit1_5@uni.com', MD5('1234'),'STUDENT');

INSERT INTO users (name,email,password,role)
VALUES
('Bikash Rai','csit2_1@uni.com', MD5('1234'),'STUDENT'),
('Pooja Gurung','csit2_2@uni.com', MD5('1234'),'STUDENT'),
('Rabin Lama','csit2_3@uni.com', MD5('1234'),'STUDENT'),
('Nisha Tamang','csit2_4@uni.com', MD5('1234'),'STUDENT'),
('Kiran Shahi','csit2_5@uni.com', MD5('1234'),'STUDENT');

INSERT INTO users (name,email,password,role)
VALUES
('Suman Koirala','bba1_1@uni.com', MD5('1234'),'STUDENT'),
('Asmita Thapa','bba1_2@uni.com', MD5('1234'),'STUDENT'),
('Dipesh Adhikari','bba1_3@uni.com', MD5('1234'),'STUDENT'),
('Priya Basnet','bba1_4@uni.com', MD5('1234'),'STUDENT'),
('Rohit Magar','bba1_5@uni.com', MD5('1234'),'STUDENT');

INSERT INTO users (name, email, password, role)
VALUES (
    'System Admin',
    'admin@sams.com',
    MD5("admin123@"),
    'ADMIN'
);






