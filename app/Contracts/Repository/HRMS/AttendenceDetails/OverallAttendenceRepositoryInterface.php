<?php
namespace App\Contracts\Repository\HRMS\AttendenceDetails;
interface OverallAttendenceRepositoryInterface {
    public function getAttendanceData($company_id, $emp_code, $start, $close, $department, $designation, $location, $code);
    public function getAttendanceData1($company_id, $emp_code, $start, $close, $department, $designation, $location, $code);
    public function getAttData($att_id);
    public function getUserAttendance($company_id, $emp_id, $attendDate, $attstartDate);
    public function updateAttendence($check_in,$check_out,$att_status,$att_id);
}
