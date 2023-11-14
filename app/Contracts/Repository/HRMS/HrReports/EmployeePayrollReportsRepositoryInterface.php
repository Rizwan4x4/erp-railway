<?php
namespace App\Contracts\Repository\HRMS\HrReports;
interface EmployeePayrollReportsRepositoryInterface {
    public function getLoanAdvanceReport($startDate, $endDate, $department, $type, $status);
    public function arrears_report($starting_date,$ending_date,$dept);
    public function getEmployCashDetail($sessionName);
    public function getEmployeeCashSum($emp_department, $emp_username, $sessionName, $status);
    public function getEmployeeBankSum($emp_department, $emp_username, $sessionName, $status);
}

