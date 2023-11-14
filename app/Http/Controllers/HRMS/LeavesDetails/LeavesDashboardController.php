<?php

namespace App\Http\Controllers\HRMS\LeavesDetails;

use App\Contracts\Repository\HRMS\LeavesDetails\LeavesDashboardRepositoryInterface;
use App\Contracts\Services\HRMS\LeavesDetails\LeavesDashboardServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Session;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ErrorException;



class LeavesDashboardController extends Controller
{
    use CommonTrait;
    protected $LeavesDashboardRepositoryInterface;
    protected $LeavesDashboardServiceInterface;

    public function __construct(LeavesDashboardRepositoryInterface $LeavesDashboardRepositoryInterface, LeavesDashboardServiceInterface $LeavesDashboardServiceInterface)
    {
        $this->LeavesDashboardRepositoryInterface = $LeavesDashboardRepositoryInterface;
        $this->LeavesDashboardServiceInterface = $LeavesDashboardServiceInterface;
    }

    public function overall_leaves()
    {
        try {
            return $this->sendSuccess('employe fetch success',$this->LeavesDashboardRepositoryInterface->overall_leaves());
        } catch (\Exception $e) {
            //            dd($e->getMessage());
                        // Handle other exceptions here
                        // For example, you can log the error and return a default response
                        Log::error('Unhandled Exception: ' . $e->getMessage());
                        return $this->sendError($e->getMessage(), $e->getCode());
                    }
    }




public function filter_leaves($leave_type, $department, $location, $designation)
    {
        try {
            $leave_type = ($leave_type == 'All') ? '' : $leave_type;
            $department = ($department == 'All') ? '' : $department;
            $location = ($location == 'All') ? '' : $location;
            $designation = ($designation == 'All') ? '' : $designation;

            return $this->sendSuccess('employe fetch success',$this->LeavesDashboardServiceInterface->filterLeaves($leave_type, $department, $location, $designation));
        } catch (\Exception $e) {
            //            dd($e->getMessage());
                        // Handle other exceptions here
                        // For example, you can log the error and return a default response
                        Log::error('Unhandled Exception: ' . $e->getMessage());
                        return $this->sendError($e->getMessage(), $e->getCode());
                    }
    }

    public function filter_leaves_byId(Request $request)
    {
   try{
        $empNameCode = $request->emp_name_code;

     return $this->sendSuccess('employe fetch success',$this->LeavesDashboardServiceInterface->filterLeavesById($empNameCode));

    } catch (\Exception $e) {
        //            dd($e->getMessage());
                    // Handle other exceptions here
                    // For example, you can log the error and return a default response
                    Log::error('Unhandled Exception: ' . $e->getMessage());
                    return $this->sendError($e->getMessage(), $e->getCode());
                }
    }

}
