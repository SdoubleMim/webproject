-- Insert sample enrollments (adjust user IDs based on your actual users)
INSERT INTO enrollments (user_id, course_id) 
SELECT u.id, c.id
FROM users u
CROSS JOIN courses c
WHERE 
    -- For user 1 (assuming ID = 1)
    (u.id = 1 AND c.code IN ('CS101', 'MATH201', 'ENG101', 'CS303')) OR
    -- For user 2 (assuming ID = 2)
    (u.id = 2 AND c.code IN ('PHY201', 'CHEM101', 'BIO101', 'CS202')) OR
    -- For user 3 (assuming ID = 3)
    (u.id = 3 AND c.code IN ('CS105', 'BUS201', 'PSY101', 'MUS101')) OR
    -- For user 4 (assuming ID = 4)
    (u.id = 4 AND c.code IN ('MATH205', 'CS210', 'ENG202', 'SOC101')); 