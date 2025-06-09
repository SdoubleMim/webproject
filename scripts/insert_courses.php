<?php

require_once __DIR__ . '/../app/bootstrap.php';

use App\Model\Course;

$courseModel = new Course();

$sampleCourses = [
    [
        'code' => 'CS101',
        'name' => 'Introduction to Programming',
        'description' => 'Basic programming concepts using Python',
        'credits' => 3,
        'category' => 'Computer Science',
        'instructor_name' => 'Dr. Smith',
        'schedule_days' => 'Monday,Wednesday',
        'schedule_time' => '8:00-10:00',
        'room' => 'Room 101'
    ],
    [
        'code' => 'MATH201',
        'name' => 'Calculus I',
        'description' => 'Limits, derivatives, and integrals',
        'credits' => 4,
        'category' => 'Mathematics',
        'instructor_name' => 'Dr. Johnson',
        'schedule_days' => 'Monday,Wednesday',
        'schedule_time' => '10:00-12:00',
        'room' => 'Room 202'
    ],
    [
        'code' => 'ENG101',
        'name' => 'Academic Writing',
        'description' => 'Essay writing and composition',
        'credits' => 3,
        'category' => 'English',
        'instructor_name' => 'Prof. Williams',
        'schedule_days' => 'Monday,Wednesday',
        'schedule_time' => '14:00-16:00',
        'room' => 'Room 303'
    ],
    [
        'code' => 'PHY201',
        'name' => 'Physics I',
        'description' => 'Mechanics and thermodynamics',
        'credits' => 4,
        'category' => 'Physics',
        'instructor_name' => 'Dr. Brown',
        'schedule_days' => 'Tuesday,Thursday',
        'schedule_time' => '8:00-10:00',
        'room' => 'Room 401'
    ],
    [
        'code' => 'CHEM101',
        'name' => 'General Chemistry',
        'description' => 'Basic chemistry concepts',
        'credits' => 4,
        'category' => 'Chemistry',
        'instructor_name' => 'Dr. Davis',
        'schedule_days' => 'Tuesday,Thursday',
        'schedule_time' => '10:00-12:00',
        'room' => 'Room 502'
    ],
    [
        'code' => 'BIO101',
        'name' => 'Introduction to Biology',
        'description' => 'Cell biology and genetics',
        'credits' => 4,
        'category' => 'Biology',
        'instructor_name' => 'Dr. Wilson',
        'schedule_days' => 'Tuesday,Thursday',
        'schedule_time' => '14:00-16:00',
        'room' => 'Room 601'
    ],
    [
        'code' => 'CS202',
        'name' => 'Data Structures',
        'description' => 'Advanced programming and algorithms',
        'credits' => 3,
        'category' => 'Computer Science',
        'instructor_name' => 'Dr. Anderson',
        'schedule_days' => 'Friday',
        'schedule_time' => '8:00-10:00',
        'room' => 'Room 102'
    ],
    [
        'code' => 'MATH202',
        'name' => 'Linear Algebra',
        'description' => 'Vectors, matrices, and linear transformations',
        'credits' => 3,
        'category' => 'Mathematics',
        'instructor_name' => 'Dr. Taylor',
        'schedule_days' => 'Friday',
        'schedule_time' => '10:00-12:00',
        'room' => 'Room 203'
    ],
    [
        'code' => 'CS303',
        'name' => 'Database Systems',
        'description' => 'Database design and SQL',
        'credits' => 3,
        'category' => 'Computer Science',
        'instructor_name' => 'Dr. Martin',
        'schedule_days' => 'Friday',
        'schedule_time' => '14:00-16:00',
        'room' => 'Room 103'
    ]
];

foreach ($sampleCourses as $course) {
    try {
        $courseModel->create($course);
        echo "Created course: {$course['code']} - {$course['name']}\n";
    } catch (Exception $e) {
        echo "Error creating course {$course['code']}: {$e->getMessage()}\n";
    }
}

echo "\nFinished inserting sample courses.\n"; 