<?php

namespace App\Http\Controllers\HRMS\LeavesDetails;

use App\Contracts\Repository\HRMS\LeavesDetails\LeavesApplicationRepositoryInterface;
use App\Contracts\Services\HRMS\LeavesDetails\LeavesApplicationServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Session;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ErrorException;

class LeavesApplicationController extends Controller
{
    use CommonTrait;
    protected $LeavesApplicationRepositoryInterface;
    protected $LeavesApplicationServiceInterface;

    public function __construct(LeavesApplicationRepositoryInterface $LeavesApplicationRepositoryInterface, LeavesApplicationServiceInterface $LeavesApplicationServiceInterface)
    {
        $this->LeavesApplicationRepositoryInterface = $LeavesApplicationRepositoryInterface;
        $this->LeavesApplicationServiceInterface = $LeavesApplicationServiceInterface;
    }

   


    public function find_emp_id()
    {

        //Apply Leaves Controller function
    try{



    return $this->sendSuccess('find emp id  success',$this->LeavesApplicationRepositoryInterface->find_emp_id());
       
} catch (\Exception $e) {
    //            dd($e->getMessage());
                // Handle other exceptions here
                // For example, you can log the error and return a default response
                Log::error('Unhandled Exception: ' . $e->getMessage());
                return $this->sendError($e->getMessage(), $e->getCode());
            }
    }
  
  
    public function update_leave_sts(Request $request)
    {
        try{
     return $this->sendSuccess('Update Leaves status success',$this->LeavesApplicationServiceInterface->update_leave_sts($request));

        
    } catch (\Exception $e) {
        //            dd($e->getMessage());
                    // Handle other exceptions here
                    // For example, you can log the error and return a default response
                    Log::error('Unhandled Exception: ' . $e->getMessage());
                    return $this->sendError($e->getMessage(), $e->getCode());
                }
    }
    public function fetch_leave_upSts($cid)
    {

        //Apply Leaves Controller function
    try{

    return $this->sendSuccess('featch leaves status success',$this->LeavesApplicationRepositoryInterface->fetch_leave_upSts($cid));
       
} catch (\Exception $e) {
    //            dd($e->getMessage());
                // Handle other exceptions here
                // For example, you can log the error and return a default response
                Log::error('Unhandled Exception: ' . $e->getMessage());
                return $this->sendError($e->getMessage(), $e->getCode());
            }
    }
    public function filter_leaves_requisitions($leave_type, $department, $location, $designation,$status,$ManagerStatus, $HRStatus)
    {

        //Apply Leaves Controller function
    try{

    return $this->sendSuccess('filter leaves requistion success',$this->LeavesApplicationServiceInterface->  filter_leaves_requisitions($leave_type, $department, $location, $designation,$status,$ManagerStatus, $HRStatus));
       
} catch (\Exception $e) {
    //            dd($e->getMessage());
                // Handle other exceptions here
                // For example, you can log the error and return a default response
                Log::error('Unhandled Exception: ' . $e->getMessage());
                return $this->sendError($e->getMessage(), $e->getCode());
            }
    }
    public function search_Employee_leave($keyword1){
        try{

            return $this->sendSuccess('search employee leaves success',$this->LeavesApplicationRepositoryInterface->  search_Employee_leave($keyword1));
               
        } catch (\Exception $e) {
            //            dd($e->getMessage());
                        // Handle other exceptions here
                        // For example, you can log the error and return a default response
                        Log::error('Unhandled Exception: ' . $e->getMessage());
                        return $this->sendError($e->getMessage(), $e->getCode());
                    }
    }
}
