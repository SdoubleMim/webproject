-- Create and use the correct database
CREATE DATABASE IF NOT EXISTS webproject_database;
USE webproject_database;

-- Create tables if they don't exist
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    student_id VARCHAR(20) NOT NULL,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    address TEXT,
    phone VARCHAR(20),
    class VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    credits INT NOT NULL,
    category VARCHAR(50) NOT NULL,
    instructor_name VARCHAR(100),
    max_students INT DEFAULT 30,
    schedule_days VARCHAR(50),
    schedule_time VARCHAR(50),
    room VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATE NOT NULL,
    status ENUM('enrolled', 'dropped', 'completed') DEFAULT 'enrolled',
    grade VARCHAR(2),
    assignments_grade DECIMAL(5,2),
    midterm_grade DECIMAL(5,2),
    final_grade DECIMAL(5,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

CREATE TABLE IF NOT EXISTS schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    event_type ENUM('class', 'study_group', 'exam', 'assignment') NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    location VARCHAR(100),
    recurring TINYINT(1) DEFAULT 0,
    recurrence_pattern VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id)
);

-- Clear existing data
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE users;
TRUNCATE TABLE students;
TRUNCATE TABLE courses;
TRUNCATE TABLE enrollments;
TRUNCATE TABLE schedules;
SET FOREIGN_KEY_CHECKS = 1;

-- Insert sample users (passwords are 'password123' hashed)
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@school.com', '$2y$10$./42eeS2pxA360ulKGiiuuvvrPz1KJkqyH2MMLy0eLOizLe1/k.7y', 'admin'),
('john.doe', 'john.doe@student.com', '$2y$10$./42eeS2pxA360ulKGiiuuvvrPz1KJkqyH2MMLy0eLOizLe1/k.7y', 'student'),
('jane.smith', 'jane.smith@student.com', '$2y$10$./42eeS2pxA360ulKGiiuuvvrPz1KJkqyH2MMLy0eLOizLe1/k.7y', 'student');

-- Insert sample students
INSERT INTO students (user_id, first_name, last_name, student_id, date_of_birth, gender, address, phone, class) VALUES
(2, 'John', 'Doe', 'STU001', '2000-05-15', 'male', '123 Student St, College Town', '1234567890', '2023A'),
(3, 'Jane', 'Smith', 'STU002', '2001-03-20', 'female', '456 Campus Ave, College Town', '0987654321', '2023A');

-- Insert sample courses
INSERT INTO courses (code, name, description, credits, category, instructor_name, max_students, schedule_days, schedule_time, room) VALUES
('CS101', 'Introduction to Programming', 'Basic programming concepts and problem solving', 3, 'Computer Science', 'Prof. Brown', 30, 'Monday,Wednesday', '09:00-10:30', 'Room 101'),
('MATH201', 'Calculus I', 'Limits, derivatives, and basic integration', 4, 'Mathematics', 'Prof. Smith', 25, 'Tuesday,Thursday', '11:00-12:30', 'Room 202'),
('ENG101', 'English Composition', 'Academic writing and critical thinking', 3, 'English', 'Prof. Wilson', 30, 'Monday,Wednesday', '14:00-15:30', 'Room 303'),
('PHY201', 'Physics I', 'Mechanics and thermodynamics', 4, 'Physics', 'Prof. Johnson', 25, 'Tuesday,Thursday', '09:00-10:30', 'Room 404');

-- Insert sample enrollments
INSERT INTO enrollments (student_id, course_id, enrollment_date, status, assignments_grade, midterm_grade, final_grade) VALUES
(1, 1, '2024-01-15', 'enrolled', 85.50, 78.00, NULL),
(1, 2, '2024-01-15', 'enrolled', 90.00, 88.50, NULL),
(2, 1, '2024-01-16', 'enrolled', 92.00, 85.00, NULL),
(2, 3, '2024-01-16', 'enrolled', 88.00, 91.50, NULL);

-- Insert sample schedules
INSERT INTO schedules (student_id, event_type, title, description, start_time, end_time, location, recurring, recurrence_pattern) VALUES
(1, 'class', 'CS101 Lecture', 'Introduction to Programming class', '2024-01-22 09:00:00', '2024-01-22 10:30:00', 'Room 101', 1, 'weekly-mon-wed'),
(1, 'study_group', 'CS101 Study Group', 'Programming practice session', '2024-01-23 15:00:00', '2024-01-23 17:00:00', 'Library Room 2', 1, 'weekly-tue'),
(2, 'class', 'ENG101 Lecture', 'English Composition class', '2024-01-22 14:00:00', '2024-01-22 15:30:00', 'Room 303', 1, 'weekly-mon-wed'),
(2, 'exam', 'MATH201 Midterm', 'Calculus I Midterm Examination', '2024-03-15 11:00:00', '2024-03-15 13:00:00', 'Room 202', 0, NULL); 