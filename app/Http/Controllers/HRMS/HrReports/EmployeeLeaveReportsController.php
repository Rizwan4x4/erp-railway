<?php

namespace App\Http\Controllers\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeLeaveReportsRepositoryInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeLeaveReportsServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Session;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ErrorException;

class EmployeeLeaveReportsController extends Controller
{
    use CommonTrait;
    protected $EmployeeLeaveReportsRepositoryInterface;
    protected $EmployeeLeaveReportsServiceInterface;

    public function __construct(EmployeeLeaveReportsRepositoryInterface $EmployeeLeaveReportsRepositoryInterface, EmployeeLeaveReportsServiceInterface $EmployeeLeaveReportsServiceInterface)
    {
        $this->EmployeeLeaveReportsRepositoryInterface = $EmployeeLeaveReportsRepositoryInterface;
        $this->EmployeeLeaveReportsServiceInterface = $EmployeeLeaveReportsServiceInterface;
    }

   
    public function get_absent_detail($start, $end, $loc, $dept, $desig, $emp_id){

try{
        $dept = ($dept == "All") ? "" : $dept;
$desig = ($desig == "All") ? "" : $desig;
$loc = ($loc == "All") ? "" : $loc;
$emp_id = ($emp_id == "All") ? "" : $emp_id;

        return $this->sendSuccess('get absent detsils success',$this->EmployeeLeaveReportsRepositoryInterface->get_absent_detail($start, $end, $loc, $dept, $desig, $emp_id));
    } catch (\Exception $e) {
    
           
        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
    }
    public function getleaveemploy($department, $location, $designation, $emp_id, $date_from, $date_end, $leave_type)
    { try{
        if ($designation == 'All' && $department == 'All' && $location == 'All' && $emp_id == 'All' && $leave_type == 'All') {
          return  $this->sendSuccess('employee leaves success',$this->EmployeeLeaveReportsRepositoryInterface->getLeaveEmployees('', '', '', '', $date_from, $date_end, ''));
           
        } else {
           return $this->sendSuccess('employe leaves success',$this->EmployeeLeaveReportsRepositoryInterface->getLeaveEmployees($department, $location, $designation, $emp_id, $date_from, $date_end, $leave_type));
         
        }
    } catch (\Exception $e) {
    
           
        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
    }
    public function filter_leaves1($department, $location, $designation, $emp_id, $leave_type)
    { try{
        if ($designation == 'All' && $department == 'All' && $location == 'All' && $emp_id == 'All') {
         return $this->sendSuccess('filter leaves  success',$this->EmployeeLeaveReportsRepositoryInterface->filterLeaves('', '', '', '', $leave_type));
          
        } else {
         return $this->sendSuccess('filter leaves  success',$this->EmployeeLeaveReportsRepositoryInterface->filterLeaves($department, $location, $designation, $emp_id, $leave_type));
         
        }
    } catch (\Exception $e) {
    
           
        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
    }
  

 
}