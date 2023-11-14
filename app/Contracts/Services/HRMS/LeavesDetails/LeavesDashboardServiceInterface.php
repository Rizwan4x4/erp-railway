<?php
namespace App\Contracts\Services\HRMS\LeavesDetails;

interface LeavesDashboardServiceInterface
{
    public function filterLeaves($leave_type, $department, $location, $designation);
    public function filterLeavesById($empNameCode);
}
