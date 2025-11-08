<?php
class AcademicController {
    private $programModel;
    private $batchModel;
    private $subjectModel;
    private $programSubjectModel;
    private $departmentModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->programModel = new Program($this->db);
        $this->batchModel = new Batch($this->db);
        $this->subjectModel = new Subject($this->db);
        $this->programSubjectModel = new ProgramSubject($this->db);
        $this->departmentModel = new Department($this->db);
    }

    // Programs Management Methods
    public function programs() {
        // List all programs with pagination and filters
    }

    public function addProgram() {
        // Add new program form and processing
    }

    public function editProgram($id) {
        // Edit program form and processing
    }

    public function viewProgram($id) {
        // View program details
    }

    public function deleteProgram($id) {
        // Delete program with validation
    }

    // Batch Management Methods
    public function batches() {
        // List all batches with filters
    }

    public function addBatch() {
        // Add new batch form and processing
    }

    public function editBatch($id) {
        // Edit batch form and processing
    }

    public function viewBatch($id) {
        // View batch details
    }

    public function deleteBatch($id) {
        // Delete batch with validation
    }

    // Subject Management Methods
    public function subjects() {
        // List all subjects
    }

    public function addSubject() {
        // Add new subject
    }

    public function editSubject($id) {
        // Edit subject
    }

    public function deleteSubject($id) {
        // Delete subject
    }

    // Program Curriculum Methods
    public function curriculum($program_id) {
        // Manage program curriculum - subject mapping
    }

    public function addSubjectToProgram() {
        // Add subject to program curriculum
    }

    public function removeSubjectFromProgram() {
        // Remove subject from program
    }

    // API Methods for AJAX
    public function getProgramsByDepartment() {
        // AJAX endpoint for department-wise programs
    }

    public function getBatchesByProgram() {
        // AJAX endpoint for program-wise batches
    }

    public function getProgramStatistics() {
        // Statistics for dashboard
    }

    // Validation and Helper Methods
    private function validateProgramData($data) {
        // Program validation logic
    }

    private function validateBatchData($data) {
        // Batch validation logic
    }

    private function validateSubjectData($data) {
        // Subject validation logic
    }

    private function sanitizeInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}