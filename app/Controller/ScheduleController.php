<?php

namespace App\Controller;

use App\Model\Course;
use App\Model\Student;

class ScheduleController
{
    private $courseModel;
    private $studentModel;
    private $viewPath;

    public function __construct()
    {
        if (!auth()) {
            setFlash('Please login to continue', 'warning');
            redirect('/login');
        }
        $this->courseModel = new Course();
        $this->studentModel = new Student();
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

        $schedule = $this->courseModel->getStudentSchedule($student['id']);
        
        // Group schedule by days
        $scheduleByDay = [];
        foreach ($schedule as $class) {
            $days = explode(',', $class['schedule_days']);
            foreach ($days as $day) {
                $day = trim($day);
                if (!isset($scheduleByDay[$day])) {
                    $scheduleByDay[$day] = [];
                }
                $scheduleByDay[$day][] = $class;
            }
        }
        
        // Sort by time for each day
        foreach ($scheduleByDay as &$daySchedule) {
            usort($daySchedule, function($a, $b) {
                return strtotime($a['schedule_time']) - strtotime($b['schedule_time']);
            });
        }

        require_once $this->viewPath . '/schedule/index.php';
    }
}
