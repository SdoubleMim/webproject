-- First, clear existing data
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE enrollments;
TRUNCATE TABLE courses;
SET FOREIGN_KEY_CHECKS = 1;

-- Insert courses with correct time formats
INSERT INTO courses (code, name, description, credits, category, instructor_name, schedule_days, schedule_time, room) VALUES
-- Monday-Wednesday courses
('CS101', 'Introduction to Programming', 'Basic programming concepts', 3, 'Computer Science', 'Prof. Brown', 'Monday,Wednesday', '08:00-10:00', 'Room 101'),
('MATH201', 'Calculus I', 'Limits and derivatives', 4, 'Mathematics', 'Prof. Smith', 'Monday,Wednesday', '10:00-12:00', 'Room 202'),
('ENG101', 'English Composition', 'Academic writing', 3, 'English', 'Prof. Wilson', 'Monday,Wednesday', '14:00-16:00', 'Room 303'),

-- Tuesday-Thursday courses
('PHY201', 'Physics I', 'Mechanics and thermodynamics', 4, 'Physics', 'Prof. Johnson', 'Tuesday,Thursday', '08:00-10:00', 'Room 404'),
('CHEM101', 'Chemistry I', 'Basic chemistry concepts', 4, 'Chemistry', 'Dr. Davis', 'Tuesday,Thursday', '10:00-12:00', 'Room 502'),
('BIO101', 'Biology I', 'Introduction to biology', 4, 'Biology', 'Dr. Wilson', 'Tuesday,Thursday', '14:00-16:00', 'Room 601'),

-- Friday courses
('CS202', 'Data Structures', 'Advanced programming', 3, 'Computer Science', 'Dr. Anderson', 'Friday', '08:00-10:00', 'Room 102'),
('MATH202', 'Linear Algebra', 'Vectors and matrices', 3, 'Mathematics', 'Dr. Taylor', 'Friday', '10:00-12:00', 'Room 203'),
('CS303', 'Database Systems', 'Database design', 3, 'Computer Science', 'Dr. Martin', 'Friday', '14:00-16:00', 'Room 103');

-- Insert enrollments for Jane Smith (student_id = 2)
INSERT INTO enrollments (student_id, course_id)
SELECT 2, c.id
FROM courses c
WHERE c.code IN ('PHY201', 'CHEM101', 'BIO101', 'CS202'); 