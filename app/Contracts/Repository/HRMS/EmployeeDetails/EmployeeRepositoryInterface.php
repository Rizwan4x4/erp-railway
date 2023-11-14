<?php
namespace App\Contracts\Repository\HRMS\EmployeeDetails;
interface EmployeeRepositoryInterface {
    public function searchEmployeeByNameCnic( $keyword);
    public function searchEmployeeByFilter($department, $location, $designation, $gender, $status, $min_price, $max_price, $cnic, $emp_id, $emp_sts);
    public function department_detail( );
    public function overall_designation();
    public function overall_location();
    public function  count_employees();
    public function StipendDetail($id);
    public function emp_detail($id);
    public function Else_emp_detail($id);
    public function getemployee_education($id);
    public function registered($id);
    public function getLoanSessionName($company_id);
    public function getEmployeeTax($company_id, $emp_id);
    public function getEmployeeInstallment($company_id, $emp_id, $loanSession);
    public function getEmployeeStipend($company_id, $emp_id, $update_date);
    public function getEmployeeAllowance($company_id, $emp_id, $update_date);
    public function getEmployeeFuel($company_id, $emp_id);
    public function getEmployeeJoiningDate($company_id, $emp_id);

    public function getwarnig_emp($id);
    public function getemployee_exp($id);

    public function getReportingEmployee($id);
    public function getEmployeeSuccessDetail($id);
    public function selected_emp_leaves($id);
    public function selected_emp_leaves_blnc($id);
    public function selected_emp_timeTable($id);
    public function findSession($company_id);

public function fetch_emp_arrears($emp_id);
public function fetch_emp_bonuses($emp_id);
public function checkEmpAllowanceExistence($company_id, $emp_id);
public function fetchEmpAllowances($company_id, $emp_id);
public function salaries_history($emp_id);
public function fetch_employee_loans($emp_id);
public function fetch_emp_fine($emp_id);
public function fetch_emp_dues($emp_id);
//terminate
public function updateEmployeeStatus($id, $status, $terminateDate);
public function insertFinalSettlement($company_id, $id, $session_name, $date, $username, $update_date);
public function insertActivityLog($company_id, $username, $userFullName, $employeeName, $eventStatus, $description, $activityTime);
public function fetchEmployeeDetails($company_id, $id);
//suspend
public function updateEmployeeStatusAndDate($id, $suspensionEnd, $status, $regDate);
public function fetchFullName($id);
//resigned
public function updateEmployeeResignedStatus($id, $resignDate);
public function createFinalSettlement($id, $resignDate);
public function getEmployeeDetails($id);

}
