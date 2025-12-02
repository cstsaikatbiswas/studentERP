<?php
class Student {
    private $conn;
    private $table_name = "students";

    public $id;
    public $user_id;
    public $admission_number;
    public $roll_number;
    public $enrollment_number;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $date_of_birth;
    public $gender;
    public $blood_group;
    public $nationality;
    public $religion;
    public $caste_category;
    public $aadhaar_number;
    public $pan_number;
    public $personal_email;
    public $phone;
    public $alternate_phone;
    public $permanent_address;
    public $current_address;
    public $city;
    public $state;
    public $pincode;
    public $country;
    public $program_id;
    public $batch_id;
    public $admission_date;
    public $admission_type;
    public $admission_category;
    public $current_semester;
    public $father_name;
    public $father_occupation;
    public $father_phone;
    public $father_email;
    public $mother_name;
    public $mother_occupation;
    public $mother_phone;
    public $mother_email;
    public $guardian_name;
    public $guardian_relation;
    public $guardian_occupation;
    public $guardian_phone;
    public $guardian_email;
    public $guardian_address;
    public $emergency_contact_name;
    public $emergency_contact_relation;
    public $emergency_contact_phone;
    public $medical_history;
    public $disability_status;
    public $disability_details;
    public $blood_pressure;
    public $height;
    public $weight;
    public $photo_path;
    public $signature_path;
    public $id_card_path;
    public $status;
    public $graduation_date;
    public $leaving_date;
    public $leaving_reason;
    public $created_by;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CRUD methods will go here
    // ... create(), readAll(), readOne(), update(), delete(), etc.
}