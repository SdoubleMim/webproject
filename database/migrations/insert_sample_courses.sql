-- Insert sample courses with varied schedules
INSERT INTO courses (code, name, description, credits, category, instructor_name, schedule_days, schedule_time, room) VALUES
-- Monday-Wednesday courses
('CS101', 'Introduction to Programming', 'Basic programming concepts using Python', 3, 'Computer Science', 'Dr. Smith', 'Monday,Wednesday', '8:00-10:00', 'Room 101'),
('MATH201', 'Calculus I', 'Limits, derivatives, and integrals', 4, 'Mathematics', 'Dr. Johnson', 'Monday,Wednesday', '10:00-12:00', 'Room 202'),
('ENG101', 'Academic Writing', 'Essay writing and composition', 3, 'English', 'Prof. Williams', 'Monday,Wednesday', '14:00-16:00', 'Room 303'),

-- Tuesday-Thursday courses
('PHY201', 'Physics I', 'Mechanics and thermodynamics', 4, 'Physics', 'Dr. Brown', 'Tuesday,Thursday', '8:00-10:00', 'Room 401'),
('CHEM101', 'General Chemistry', 'Basic chemistry concepts', 4, 'Chemistry', 'Dr. Davis', 'Tuesday,Thursday', '10:00-12:00', 'Room 502'),
('BIO101', 'Introduction to Biology', 'Cell biology and genetics', 4, 'Biology', 'Dr. Wilson', 'Tuesday,Thursday', '14:00-16:00', 'Room 601'),

-- Friday courses
('CS202', 'Data Structures', 'Advanced programming and algorithms', 3, 'Computer Science', 'Dr. Anderson', 'Friday', '8:00-10:00', 'Room 102'),
('MATH202', 'Linear Algebra', 'Vectors, matrices, and linear transformations', 3, 'Mathematics', 'Dr. Taylor', 'Friday', '10:00-12:00', 'Room 203'),
('CS303', 'Database Systems', 'Database design and SQL', 3, 'Computer Science', 'Dr. Martin', 'Friday', '14:00-16:00', 'Room 103'); 