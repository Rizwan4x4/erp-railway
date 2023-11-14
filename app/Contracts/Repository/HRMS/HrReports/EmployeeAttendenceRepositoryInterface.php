<?php
namespace App\Contracts\Repository\HRMS\HrReports;
interface EmployeeAttendenceRepositoryInterface {
    public function getAttendanceReport( $department, $location, $designation, $employeeId, $startDate, $endDate);
    public function getAttendanceCount(  $employeeId);
    public function getSessionEmployeeAttendanceReport( $employeeId);

    public function findSession();
    public function getMonthlyAttendanceData($startDate, $endDate);

    public function get_payroll_att_detail_report($startDatec,$endDate);
}