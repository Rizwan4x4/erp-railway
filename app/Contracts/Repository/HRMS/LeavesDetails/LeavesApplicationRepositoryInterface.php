<?php
namespace App\Contracts\Repository\HRMS\LeavesDetails;
interface LeavesApplicationRepositoryInterface {
    public function find_emp_id();
    public function updateEmpLeaveRemaining($rem_an_levs, $us_lv_type, $emp_emp_id);
    public function GetEmpLeaveRemaining($us_lv_type, $emp_emp_id);

    public function fetch_leave_upSts($cid);
    public function filterLeavesRequisitions($leave_type, $department, $location, $designation, $status, $ManagerStatus, $HRStatus);
    public function search_Employee_leave($keyword1);
}
