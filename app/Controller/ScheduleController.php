<?php

namespace App\Controller;

use App\Model\Course;
use App\Model\Student;
use App\Model\Enrollment;
use App\Database\Database;
use PDO;
use Exception;

class ScheduleController extends BaseController
{
    private $courseModel;
    private $studentModel;
    private $enrollmentModel;
    private $viewPath;

    public function __construct()
    {
        parent::__construct();
        $user = $this->requireLogin();
        
        $this->courseModel = new Course();
        $this->studentModel = new Student();
        $this->enrollmentModel = new Enrollment();
        $this->viewPath = __DIR__ . '/../../views';
    }

    public function index()
    {
        try {
            // Enable error reporting
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            $user = $this->getCurrentUser();
            if (!$user) {
                throw new Exception("No user logged in");
            }
            
            // Get student record
            $stmt = $this->db->prepare("SELECT * FROM students WHERE user_id = ?");
            $stmt->execute([$user['id']]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$student) {
                throw new Exception("No student record found for user ID: " . $user['id']);
            }

            // Get enrolled courses
            $query = "SELECT c.* 
                     FROM courses c 
                     INNER JOIN enrollments e ON c.id = e.course_id 
                     WHERE e.student_id = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([$student['id']]);
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($courses)) {
                echo "<!-- Debug: No courses found for student ID: " . $student['id'] . " -->";
            }

            // Initialize schedule array
            $scheduleByDay = [
                'Monday' => [],
                'Tuesday' => [],
                'Wednesday' => [],
                'Thursday' => [],
                'Friday' => []
            ];

            // Organize courses by day and time
            foreach ($courses as $course) {
                if (!empty($course['schedule_days']) && !empty($course['schedule_time'])) {
                    $days = array_map('trim', explode(',', $course['schedule_days']));
                    foreach ($days as $day) {
                        if (isset($scheduleByDay[$day])) {
                            $scheduleByDay[$day][] = $course;
                        }
                    }
                }
            }

            // Debug output
            echo "<!-- Debug Info:
            User ID: " . $user['id'] . "
            Student ID: " . $student['id'] . "
            Number of courses: " . count($courses) . "
            -->";

            // Make data available to the view
            require_once $this->viewPath . '/schedule/index.php';
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            // Log the error
            error_log($e->getMessage());
        }
    }
} 