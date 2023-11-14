<?php
namespace App\Services\HRMS\LeavesDetails;
use App\Contracts\Repository\HRMS\LeavesDetails\LeavesDashboardRepositoryInterface;
use App\Contracts\Services\HRMS\LeavesDetails\LeavesDashboardServiceInterface;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\Log;
use Session;
class LeavesDashboardService implements LeavesDashboardServiceInterface
{
    protected $LeavesDashboardRepositoryInterface;
    public function __construct(LeavesDashboardRepositoryInterface $LeavesDashboardRepositoryInterface)
    {
        $this->LeavesDashboardRepositoryInterface = $LeavesDashboardRepositoryInterface;
    }

    public function filterLeaves($leaveType, $department, $location, $designation)
    {
        try{
       
    
        $leaveType = ($leaveType == 'All') ? '' : $leaveType;
        $department = ($department == 'All') ? '' : $department;
        $designation = ($designation == 'All') ? '' : $designation;
        $location = ($location == 'All') ? '' : $location;
    
        return $this->LeavesDashboardRepositoryInterface->  filterLeaves($leaveType, $department, $location, $designation);
    } catch (ErrorException $e) {
        // Handle the custom exception here
        // Log the error or take any other necessary action
        Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }

    public function filterLeavesById($empNameCode)
    {
        try {
            return $this->LeavesDashboardRepositoryInterface->filterLeavesById($empNameCode);
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }
}
