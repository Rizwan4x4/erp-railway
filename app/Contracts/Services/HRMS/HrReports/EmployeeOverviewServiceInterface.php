<?php
namespace App\Contracts\Services\HRMS\HrReports;

interface EmployeeOverviewServiceInterface
{  
    public function getemploydetail($emp_department,$emp_location,$emp_designation,$emp_emp_id,$emp_type,$emp_status);
public function gethireemploy($hire_department,$hire_location,$hire_designation,$hire_emp_id,$hire_start_date,$hire_end_date);
public function gethireemploycount($hire_department,$hire_location,$hire_designation,$hire_emp_id,$hire_start_date,$hire_end_date);

}
