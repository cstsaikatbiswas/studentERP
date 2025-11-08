<?php
class Subject {
    private $conn;
    private $table_name = "subjects";

    public $id;
    public $name;
    public $code;
    public $description;
    public $credit_hours;
    public $theory_hours;
    public $practical_hours;
    public $subject_type;
    public $difficulty_level;
    public $department_id;
    public $prerequisites;
    public $learning_outcomes;
    public $status;
    public $created_by;

    // Constructor, CRUD methods, validation methods...
}