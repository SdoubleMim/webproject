-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create courses table
CREATE TABLE IF NOT EXISTS courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    credits INT NOT NULL DEFAULT 3,
    instructor_name VARCHAR(100) NOT NULL,
    room_number VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create course_schedules table for flexible scheduling
CREATE TABLE IF NOT EXISTS course_schedules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Create enrollments table
CREATE TABLE IF NOT EXISTS enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (user_id, course_id)
);

-- Create grades table with multiple grade types
CREATE TABLE IF NOT EXISTS grades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    enrollment_id INT NOT NULL,
    grade_type ENUM('assignment', 'quiz', 'midterm', 'final', 'project') NOT NULL,
    grade_name VARCHAR(100) NOT NULL,
    score DECIMAL(5,2) NOT NULL,
    max_score DECIMAL(5,2) NOT NULL DEFAULT 100.00,
    weight DECIMAL(5,2) NOT NULL DEFAULT 1.00,
    graded_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE
);

-- Insert sample courses with realistic schedules
INSERT INTO courses (code, name, description, credits, instructor_name, room_number) VALUES
('CS101', 'Introduction to Programming', 'Learn the fundamentals of programming with Python', 3, 'Prof. Brown', '101'),
('MATH201', 'Calculus I', 'Introduction to differential and integral calculus', 4, 'Prof. Smith', '202'),
('CS201', 'Data Structures', 'Advanced programming concepts and data structures', 3, 'Prof. Johnson', '103'),
('PHY101', 'Physics I', 'Mechanics and thermodynamics', 4, 'Prof. Wilson', '301'),
('ENG101', 'English Composition', 'Academic writing and communication', 3, 'Prof. Davis', '205'),
('CHEM101', 'General Chemistry', 'Basic principles of chemistry', 4, 'Prof. Miller', '401'),
('HIST101', 'World History', 'Survey of world civilizations', 3, 'Prof. Anderson', '204'),
('MATH202', 'Calculus II', 'Advanced calculus concepts', 4, 'Prof. Taylor', '203');

-- Insert course schedules with realistic timings
INSERT INTO course_schedules (course_id, day_of_week, start_time, end_time) VALUES
(1, 'Monday', '08:00:00', '10:00:00'),
(1, 'Wednesday', '08:00:00', '10:00:00'),
(2, 'Tuesday', '10:00:00', '12:00:00'),
(2, 'Thursday', '10:00:00', '12:00:00'),
(3, 'Monday', '14:00:00', '16:00:00'),
(3, 'Wednesday', '14:00:00', '16:00:00'),
(4, 'Tuesday', '14:00:00', '16:00:00'),
(4, 'Thursday', '14:00:00', '16:00:00'),
(5, 'Monday', '16:00:00', '18:00:00'),
(5, 'Wednesday', '16:00:00', '18:00:00'),
(6, 'Tuesday', '08:00:00', '10:00:00'),
(6, 'Friday', '08:00:00', '10:00:00'),
(7, 'Wednesday', '10:00:00', '12:00:00'),
(7, 'Friday', '10:00:00', '12:00:00'),
(8, 'Monday', '10:00:00', '12:00:00'),
(8, 'Thursday', '16:00:00', '18:00:00'); 