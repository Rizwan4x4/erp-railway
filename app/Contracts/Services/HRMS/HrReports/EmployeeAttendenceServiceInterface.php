<?php
namespace App\Contracts\Services\HRMS\HrReports;

interface EmployeeAttendenceServiceInterface
{  
    public function getattendance_report($department,$location,$designation,$emp_id,$start,$close);
    public function getAttendanceCount( $employeeId);

    public function getattendance_summary();

    public function get_payroll_att_detail();
}
