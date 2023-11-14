<?php
namespace App\Contracts\Repository\HRMS\LeavesDetails;
interface SubmitLeavesRepositoryInterface {
    //Apply Leaves function 
    public function getFullName($emp_emp_id);
    public function isFemaleEmployee( $emp_emp_id);
    public function getRemainingLeaves( $this_year, $emp_emp_id, $emp_leave);
    public function insertLeaveRequisition($emp_emp_id, $emp_leave, $emp_date_from, $emp_date_to, $days, $emp_reason, $pl_status);
    public function insertActivityLog(  $eventStatus, $description, $activityTime);
    public function checkExistingRequisition($emp_emp_id, $emp_leave, $emp_date_from, $emp_date_to);

//Assign Leaves function
    public function checkLeaveExistence( $lv_emp_id, $lv_type, $this_year);
    public function updateLeave( $lv_emp_id, $lv_type, $lv_nmbr, $update_date);
    public function addLeave($lv_nmbr, $lv_emp_id, $lv_type, $update_date);
    
}