<?php

namespace App\Controller;

use App\Model\Course;
use App\Model\Student;
use App\Model\Enrollment;

class GradeController
{
    private $courseModel;
    private $studentModel;
    private $enrollmentModel;
    private $viewPath;

    public function __construct()
    {
        if (!auth()) {
            setFlash('Please login to continue', 'warning');
            redirect('/login');
        }
        $this->courseModel = new Course();
        $this->studentModel = new Student();
        $this->enrollmentModel = new Enrollment();
        $this->viewPath = __DIR__ . '/../../views';
    }

    public function index()
    {
        $user = auth();
        $student = $this->studentModel->getByUserId($user['id']);
        
        if (!$student) {
            setFlash('Student profile not found', 'danger');
            redirect('/dashboard');
        }

        $enrolledCourses = $this->courseModel->getEnrolledCourses($student['id']);
        $grades = $this->enrollmentModel->getStudentGrades($student['id']);

        // Calculate GPA
        $totalPoints = 0;
        $totalCredits = 0;
        foreach ($enrolledCourses as $course) {
            if (isset($course['grade']) && $course['grade'] !== null) {
                $totalPoints += $course['grade'] * $course['credits'];
                $totalCredits += $course['credits'];
            }
        }
        $gpa = $totalCredits > 0 ? $totalPoints / $totalCredits : 0;

        require_once $this->viewPath . '/grades/index.php';
    }

    public function update()
    {
        if (!isAdmin()) {
            setFlash('Unauthorized access', 'danger');
            redirect('/dashboard');
        }

        $studentId = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);
        $courseId = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT);
        $grade = filter_input(INPUT_POST, 'grade', FILTER_VALIDATE_FLOAT);

        if (!$studentId || !$courseId || !$grade || $grade < 0 || $grade > 20) {
            setFlash('Invalid grade value', 'danger');
            redirect('/grades/all');
        }

        try {
            if ($this->enrollmentModel->updateGrade($studentId, $courseId, $grade)) {
                setFlash('Grade updated successfully', 'success');
            } else {
                setFlash('Failed to update grade', 'danger');
            }
        } catch (\Exception $e) {
            setFlash($e->getMessage(), 'danger');
        }

        redirect('/grades/all');
    }

    public function updateGrade()
    {
        // This is just an alias for update() to match the route
        return $this->update();
    }

    public function allGrades()
    {
        if (!isAdmin()) {
            setFlash('Unauthorized access', 'danger');
            redirect('/dashboard');
        }

        $enrollments = $this->enrollmentModel->getAllEnrollments();
        require_once $this->viewPath . '/grades/all.php';
    }
}
