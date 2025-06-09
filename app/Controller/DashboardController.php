<?php

namespace App\Controller;

use App\Model\Course;
use App\Model\Student;
use App\Model\Enrollment;

class DashboardController
{
    private $courseModel;
    private $studentModel;
    private $enrollmentModel;

    public function __construct()
    {
        requireAuth();
        $this->courseModel = new Course();
        $this->studentModel = new Student();
        $this->enrollmentModel = new Enrollment();
    }

    public function index()
    {
        $user = auth();
        
        if ($user['role'] === 'student') {
            // Get student information
            $student = $this->studentModel->getByUserId($user['id']);
            
            if (!$student) {
                setFlash('Student profile not found', 'danger');
                redirect('/logout');
            }
            
            // Get enrolled courses
            $enrolledCourses = $this->courseModel->getEnrolledCourses($student['id']);
            
            // Get grades
            $grades = $this->enrollmentModel->getStudentGrades($student['id']);
            
            // Get upcoming schedule
            $schedule = $this->courseModel->getStudentSchedule($student['id']);
            
            view('dashboard/student', [
                'student' => $student,
                'enrolledCourses' => $enrolledCourses,
                'grades' => $grades,
                'schedule' => $schedule
            ]);
        } else if ($user['role'] === 'admin') {
            // Get statistics for admin
            $totalCourses = $this->courseModel->getTotalCount();
            $recentEnrollments = $this->enrollmentModel->getRecentEnrollments();
            
            view('dashboard/admin', [
                'totalCourses' => $totalCourses,
                'recentEnrollments' => $recentEnrollments
            ]);
        } else {
            setFlash('Invalid user role', 'danger');
            redirect('/logout');
        }
    }
} 