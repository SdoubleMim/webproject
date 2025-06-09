<?php

namespace App\Controllers;

use App\Database;

class GradeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        requireLogin();
        $user = getCurrentUser();
        
        // Get all enrolled courses with their grades
        $query = "
            SELECT 
                c.id as course_id,
                c.code,
                c.name,
                c.instructor_name,
                e.id as enrollment_id,
                g.id as grade_id,
                g.grade_type,
                g.grade_name,
                g.score,
                g.max_score,
                g.weight,
                g.graded_date
            FROM enrollments e
            JOIN courses c ON e.course_id = c.id
            LEFT JOIN grades g ON e.id = g.enrollment_id
            WHERE e.user_id = ?
            ORDER BY c.code, g.grade_type
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$user['id']]);
        $results = $stmt->fetchAll();
        
        // Organize the data by course
        $courses = [];
        foreach ($results as $row) {
            if (!isset($courses[$row['course_id']])) {
                $courses[$row['course_id']] = [
                    'code' => $row['code'],
                    'name' => $row['name'],
                    'instructor_name' => $row['instructor_name'],
                    'grades' => [],
                    'final_grade' => null,
                    'grade_distribution' => [
                        'A' => 25,
                        'B' => 35,
                        'C' => 25,
                        'D' => 10,
                        'F' => 5
                    ]
                ];
            }
            
            if ($row['grade_id']) {
                $courses[$row['course_id']]['grades'][] = [
                    'grade_type' => $row['grade_type'],
                    'grade_name' => $row['grade_name'],
                    'score' => $row['score'],
                    'max_score' => $row['max_score'],
                    'weight' => $row['weight'],
                    'graded_date' => $row['graded_date']
                ];
            }
        }
        
        // Calculate final grades for each course
        foreach ($courses as &$course) {
            if (!empty($course['grades'])) {
                $weightedSum = 0;
                $totalWeight = 0;
                
                foreach ($course['grades'] as $grade) {
                    $percentage = ($grade['score'] / $grade['max_score']) * 100;
                    $weightedSum += $percentage * $grade['weight'];
                    $totalWeight += $grade['weight'];
                }
                
                if ($totalWeight > 0) {
                    $finalPercentage = $weightedSum / $totalWeight;
                    $course['final_grade'] = $this->calculateLetterGrade($finalPercentage);
                }
            }
        }
        
        return $this->view('grades', ['courses' => array_values($courses)]);
    }
    
    private function calculateLetterGrade($percentage) {
        if ($percentage >= 97) return 'A+';
        if ($percentage >= 93) return 'A';
        if ($percentage >= 90) return 'A-';
        if ($percentage >= 87) return 'B+';
        if ($percentage >= 83) return 'B';
        if ($percentage >= 80) return 'B-';
        if ($percentage >= 77) return 'C+';
        if ($percentage >= 73) return 'C';
        if ($percentage >= 70) return 'C-';
        if ($percentage >= 67) return 'D+';
        if ($percentage >= 63) return 'D';
        if ($percentage >= 60) return 'D-';
        return 'F';
    }
} 