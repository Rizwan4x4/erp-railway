<?php
namespace App\Contracts\Repository\HRMS\HrReports;
interface EmployeeLeaveReportsRepositoryInterface {
    public function get_absent_detail($start, $end, $loc, $dept, $desig, $emp_id);
    public function getLeaveEmployees($department, $location, $designation, $emp_id, $date_from, $date_end, $leave_type);
    public function filterLeaves($department, $location, $designation, $emp_id, $leave_type);
  
}