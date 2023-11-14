<?php
namespace App\Contracts\Services\HRMS\AttendenceDetails;

interface OverallAttendenceServiceInterface
{
    public function getAttendance($company_id, $emp_code, $start, $close, $department, $designation, $location, $code);
    public function update_ind_att( $request);
    public function getUserAttendanceData($emp_id);
}
