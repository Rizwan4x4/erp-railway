<?php

namespace App\Http\Controllers\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeOverviewRepositoryInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeOverviewServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Session;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ErrorException;


class EmployeeOverviewController extends Controller
{
    use CommonTrait;
    protected $EmployeeOverviewRepositoryInterface;
    protected $EmployeeOverviewServiceInterface;

    public function __construct(EmployeeOverviewRepositoryInterface $EmployeeOverviewRepositoryInterface, EmployeeOverviewServiceInterface $EmployeeOverviewServiceInterface)
    {
        $this->EmployeeOverviewRepositoryInterface = $EmployeeOverviewRepositoryInterface;
        $this->EmployeeOverviewServiceInterface = $EmployeeOverviewServiceInterface;
    }


    public function getemploydetail($emp_department, $emp_designation, $emp_location, $emp_emp_id, $emp_type, $emp_status)
    {
        try{
      return $this->sendSuccess('employee details success',$this->EmployeeOverviewServiceInterface->getemploydetail($emp_department, $emp_designation, $emp_location, $emp_emp_id, $emp_type, $emp_status));

       
    } catch (\Exception $e) {
        //            dd($e->getMessage());
                    // Handle other exceptions here
                    // For example, you can log the error and return a default response
                    Log::error('Unhandled Exception: ' . $e->getMessage());
                    return $this->sendError($e->getMessage(), $e->getCode());
                }
  

   
}
public function gethireemploy($hire_department, $hire_location, $hire_designation, $hire_emp_id, $hire_start_date, $hire_end_date)
{ try{
    return $this->sendSuccess('get registered employee success',$this->EmployeeOverviewServiceInterface->gethireemploy($hire_department, $hire_location, $hire_designation, $hire_emp_id, $hire_start_date, $hire_end_date));
} catch (\Exception $e) {
    
           
                Log::error('Unhandled Exception: ' . $e->getMessage());
                return $this->sendError($e->getMessage(), $e->getCode());
            }

}
public function gethireemploycount($hire_department, $hire_location, $hire_designation, $hire_emp_id, $hire_start_date, $hire_end_date)
{
    try{
    return $this->sendSuccess(' get re rmployee count success',$this->EmployeeOverviewServiceInterface->gethireemploycount($hire_department, $hire_location, $hire_designation, $hire_emp_id, $hire_start_date, $hire_end_date));
} catch (\Exception $e) {

                Log::error('Unhandled Exception: ' . $e->getMessage());
                return $this->sendError($e->getMessage(), $e->getCode());
            }

}
}