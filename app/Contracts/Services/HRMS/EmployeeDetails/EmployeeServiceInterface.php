<?php
namespace App\Contracts\Services\HRMS\EmployeeDetails;

interface EmployeeServiceInterface
{
    public function getindemployee_detail($id);
    public function getemployee_education($id);
    public function fetchEmployeeAmount($emp_id1);
    public function getReportingEmployees($id);
    public function getEmployeeSuccessArray($id);
    public function fetchEmpAllowances($emp_id);
    public function terminateEmployee($id, $date);
    public function suspendEmployee($id, $date);
    public function registered($id);
    public function resignEmployee($id, $resignDate);
}
