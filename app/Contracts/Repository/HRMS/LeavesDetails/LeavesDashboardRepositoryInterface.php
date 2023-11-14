<?php
namespace App\Contracts\Repository\HRMS\LeavesDetails;
interface LeavesDashboardRepositoryInterface {
    public function overall_leaves();
    public function   filterLeaves($leave_type, $department, $location, $designation);
    public function  filterLeavesById($empNameCode);
}
