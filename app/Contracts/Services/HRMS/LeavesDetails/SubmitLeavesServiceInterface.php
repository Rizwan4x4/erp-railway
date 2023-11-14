<?php
namespace App\Contracts\Services\HRMS\LeavesDetails;

interface SubmitLeavesServiceInterface
{  //Apply Leaves function 
    public function submitLeave( $emp_emp_id, $selecteddays, $emp_date_from, $emp_date_to, $emp_reason, $emp_leave);    

    //Assign Leaves function
    public function submitEmpLeaves( $lv_emp_id ,  $lv_type,   $lv_nmbr );

}
