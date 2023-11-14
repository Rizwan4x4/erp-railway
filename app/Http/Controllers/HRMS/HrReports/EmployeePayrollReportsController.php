<?php

namespace App\Http\Controllers\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeePayrollReportsRepositoryInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeePayrollReportsServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Session;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ErrorException;


class EmployeePayrollReportsController extends Controller
{
    use CommonTrait;
    protected $EmployeePayrollReportsRepositoryInterface;
    protected $EmployeePayrollReportsServiceInterface;

    public function __construct(EmployeePayrollReportsRepositoryInterface $EmployeePayrollReportsRepositoryInterface, EmployeePayrollReportsServiceInterface $EmployeePayrollReportsServiceInterface)
    {
        $this->EmployeePayrollReportsRepositoryInterface = $EmployeePayrollReportsRepositoryInterface;
        $this->EmployeePayrollReportsServiceInterface = $EmployeePayrollReportsServiceInterface;
    }

   
    public function loan_advance_report($startDate, $endDate, $department, $type, $status)
    { try{
        $department = ($department == 'All') ? '' : $department;
$type = ($type == 'All') ? '' : $type;
$status = ($status == 'All') ? '' : $status;

       return $this->sendSuccess('advance loan report success',$this->EmployeePayrollReportsRepositoryInterface->getLoanAdvanceReport($startDate, $endDate, $department, $type, $status));
      
    } catch (\Exception $e) {
    
           
        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
    }
    public function arrears_report($starting_date,$ending_date,$dept){
        try{
        if($dept=='All'){
         $dept='';
        }
       return  $this->sendSuccess('arrears report success',$this->EmployeePayrollReportsRepositoryInterface->arrears_report($starting_date,$ending_date,$dept));
       
    
    } catch (\Exception $e) {
    
           
        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
               }

               public function getemploycashdetail($emp_department, $emp_username, $sessionName, $status)
               {
                try{
                   return $this->sendSuccess('employee cash detail success',$this->EmployeePayrollReportsServiceInterface->getEmployCashDetail($emp_department, $emp_username, $sessionName, $status));
                } catch (\Exception $e) {
    
           
                    Log::error('Unhandled Exception: ' . $e->getMessage());
                    return $this->sendError($e->getMessage(), $e->getCode());
                }
                }
               public function getemployeecashsum($emp_department, $emp_username, $sessionName, $status)
               {
                try{
                   return $this->sendSuccess('employee cash sum success',$this->EmployeePayrollReportsServiceInterface->getEmployeeCashSum($emp_department, $emp_username, $sessionName, $status));
                } catch (\Exception $e) {
    
           
                    Log::error('Unhandled Exception: ' . $e->getMessage());
                    return $this->sendError($e->getMessage(), $e->getCode());
                }
                }

               public function getemployeebanksum($emp_department, $emp_username, $sessionName, $status)
               {
                try{
        return $this->sendSuccess('employe bank sum success',$this->EmployeePayrollReportsServiceInterface->getEmployeeBankSum($emp_department, $emp_username, $sessionName, $status));
                 
                } catch (\Exception $e) {
    
           
                    Log::error('Unhandled Exception: ' . $e->getMessage());
                    return $this->sendError($e->getMessage(), $e->getCode());
                }
                }
}