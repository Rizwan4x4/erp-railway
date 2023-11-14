<?php
namespace App\Contracts\Services\HRMS\HrReports;

interface EmployeePayrollReportsServiceInterface
{  
    public function getEmployCashDetail($emp_department, $emp_username, $sessionName, $status);
    public function getEmployeeCashSum($emp_department, $emp_username, $sessionName, $status);
    public function getEmployeeBankSum($emp_department, $emp_username, $sessionName, $status);
}
