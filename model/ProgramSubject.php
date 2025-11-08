<?php
class ProgramSubject {
    private $conn;
    private $table_name = "program_subjects";

    public $id;
    public $program_id;
    public $subject_id;
    public $semester;
    public $is_optional;
    public $min_credits;
    public $max_credits;
    public $course_code;
    public $course_type;
    public $teaching_methodology;
    public $assessment_pattern;
    public $status;

    // Constructor, CRUD methods, validation methods...
}