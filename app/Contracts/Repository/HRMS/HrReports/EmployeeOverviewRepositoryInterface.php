<?php
namespace App\Contracts\Repository\HRMS\HrReports;
interface EmployeeOverviewRepositoryInterface {
    public function getEmployeeDetails( $emp_department, $emp_location, $emp_designation, $emp_emp_id, $emp_type, $emp_status);
public function getHireEmployees($hire_department,$hire_location,$hire_designation,$hire_emp_id,$hire_start_date,$hire_end_date);
public function getHireEmployeesCount($hire_department,$hire_location,$hire_designation,$hire_emp_id,$hire_start_date,$hire_end_date);
    
}