<?php
namespace App\Contracts\Repository\HRMS\WarningDetails;
interface CreateWarningRepositoryInterface {
    public function warning_reasons();
    public function getEmployeeDetail( $emp_id);
    public function getEmployeeID($emp_code);
    public function checkIfWarningLetterExists( $emp_id);
    public function getWarningLetter( $emp_id);
    public function insertWarningLetter($data);
    public function updateEmployeeStatus($emp_id, $warning_type);
    public function insertActivityLog($data);
}