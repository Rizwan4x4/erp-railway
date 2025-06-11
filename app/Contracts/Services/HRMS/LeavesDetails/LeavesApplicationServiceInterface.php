<?php
namespace App\Contracts\Services\HRMS\LeavesDetails;

interface LeavesApplicationServiceInterface
{
    public function update_leave_sts($request);
    public function filter_leaves_requisitions($leave_type, $department, $location, $designation,$status,$ManagerStatus, $HRStatus);
}
