<?php
class Batch {
    private $conn;
    private $table_name = "academic_batches";

    public $id;
    public $program_id;
    public $batch_year;
    public $batch_code;
    public $batch_name;
    public $start_date;
    public $end_date;
    public $current_semester;
    public $total_students;
    public $max_capacity;
    public $class_teacher_id;
    public $fee_structure;
    public $admission_criteria;
    public $status;
    public $created_by;

    // Constructor, CRUD methods, validation methods...
}