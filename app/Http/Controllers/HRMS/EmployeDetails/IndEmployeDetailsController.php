<?php

namespace App\Http\Controllers\HRMS\EmployeDetails;

use App\Contracts\Repository\HRMS\EmployeeDetails\EmployeeRepositoryInterface;
use App\Contracts\Services\HRMS\EmployeeDetails\EmployeeServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\Log;
use Session;
use DB;

class IndEmployeDetailsController extends Controller
{
    use CommonTrait;

    protected $employeeRepository;
    protected $employeeService;

    public function __construct(EmployeeServiceInterface $employeeService, EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->employeeService = $employeeService;
    }

    public function getindemployee_detail($id)
    {
        try {
            return $this->sendSuccess('employe fetch success', $this->employeeService->getindemployee_detail($id));
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }

    }

    public function getemployee_education($id)
    {
        try {
            return $this->sendSuccess('employe eduaction fetch succuss', $this->employeeService->getemployee_education($id));
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function fetch_employee_amount($emp_id1)
    {
        try {
            return $this->sendSuccess('employe amount fetch succuss', $this->employeeService->fetchEmployeeAmount($emp_id1));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

//    public function getwarnig_emp($id)
//    {
//        try {
//            //  dd($this->employeeRepository->getwarnig_emp($id));
//            return $this->employeeRepository->getwarnig_emp($id);
//        } catch (\Exception $e) {
//
//            Log::error('Unhandled Exception: ' . $e->getMessage());
//            return $this->sendError($e->getMessage(), $e->getCode());
//        }
//    }

    public function getemployee_exp($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = employee_id();
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return $this->sendSuccess('employe exp fetch succuss', $this->employeeRepository->getemployee_exp($id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }


    public function reporting_employees($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = Session::get('employee_id');
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return $this->sendSuccess('employe reporting fetch succuss', $this->employeeService->getReportingEmployees($id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function success_array($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = Session::get('employee_id');
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return $this->sendSuccess('success array fetch succuss', $this->employeeService->getEmployeeSuccessArray($id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }

    }

    public function selected_emp_leaves($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = Session::get('employee_id');
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return $this->sendSuccess('selected employe leaves fetch succuss', $this->employeeRepository->selected_emp_leaves($id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function selected_emp_leaves_blnc($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = Session::get('employee_id');
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return $this->sendSuccess('employe leaves balance fetch succuss', $this->employeeRepository->selected_emp_leaves_blnc($id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function selected_emp_timeTable($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = Session::get('employee_id');
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return $this->sendSuccess('employe timetabel fetch succuss', $this->employeeRepository->selected_emp_timeTable($id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function fetch_emp_arrears($emp_id)
    {
        try {
            return $this->sendSuccess('employe arrears fetch succuss', $this->employeeRepository->fetch_emp_arrears($emp_id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function fetch_emp_bonuses($emp_id)
    {
        try {
            return $this->sendSuccess('employe bonus fetch succuss', $this->employeeRepository->fetch_emp_bonuses($emp_id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function fetch_emp_allowances($emp_id)
    {
        try {
            return $this->sendSuccess('employe Allowance fetch succuss', $this->employeeService->fetchEmpAllowances($emp_id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }

    }

    public function salaries_history($emp_id)
    {
        try {
            return $this->sendSuccess('employe salary history fetch succuss', $this->employeeRepository->salaries_history($emp_id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function fetch_employee_loans($emp_id)
    {
        try {
            return $this->sendSuccess('employe Loan fetch succuss', $this->employeeRepository->fetch_employee_loans($emp_id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function fetch_emp_fine($emp_id)
    {
        try {
            return $this->sendSuccess('employe fine fetch succuss', $this->employeeRepository->fetch_emp_fine($emp_id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function fetch_emp_dues($emp_id)
    {
        try {
            return $this->sendSuccess('employe dues fetch succuss', $this->employeeRepository->fetch_emp_dues($emp_id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }

    }

    public function registered($id)
    {
        try {
            return $this->sendSuccess('Registered employe  succuss', $this->employeeService->registered($id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }

    }
    //   public function terminate_emp($id, $date){
    //     try{
    //     return $this->sendSuccess('terminate employe succuss',$this->employeeService->terminateEmployee($id, $date));
    // } catch (\Exception $e) {

    //                 Log::error('Unhandled Exception: ' . $e->getMessage());
    //                 return $this->sendError($e->getMessage(), $e->getCode());
    //             }
    // }
    public function terminate_emp($id, $date)
    {


        $update_date = long_date();
        $result5 = DB::connection('sqlsrv2')->update('update Emp_Register set Status=?, TerminateDate=? where EmployeeID =?', ["Terminated", $date, $id]);

        if ($result5) {
            $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
            foreach ($find_session_closed as $find_session1) {

            }
            $sesson_name = $find_session1->SessionName;
            DB::connection('sqlsrv2')->insert("INSERT INTO FinalSettlement(CompanyID, EmployeeID, SessionName, ResignOn, DStatus, MStatus, HrStatus, Status, FStatus, CreatedBy, CreatedOn) values (?,?,?,?,?,?,?,?,?,?,?)", [company_id(), $id, $sesson_name, $date, 'Pending', 'Pending', 'Pending', 'Pending', 'Pending', username(), $update_date]);

            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Profile.EmployeeID', '=', $id)->get();
            $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $id)->get();
            foreach ($full_name_arr as $full_name_arr1) {

            }
            $full_name = $full_name_arr1->Name;
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Status', 'Update status of ' . $full_name . ' to Terminated', $update_date]);
            return request()->json(200, $emp_detail);
        }
    }

    public function suspend_emp($id, $date)
    {

        $update_date = date("Y-m-d");
        $result5 = DB::connection('sqlsrv2')->update('update Emp_Register set SuspensionEnd=?, Status=?,RegDate=? where EmployeeID =?', [$date, "Suspended", $update_date, $id]);

        if ($result5) {

            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())
                ->where('Emp_Profile.EmployeeID', '=', $id)->get();


            $update_date = long_date();

            $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $id)->get();
            foreach ($full_name_arr as $full_name_arr1) {

            }
            $full_name = $full_name_arr1->Name;
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Status', 'Update status of ' . $full_name . ' to Suspended', $update_date]);


            return request()->json(200, $emp_detail);
        }
    }
    // public function suspend_emp($id, $date){
    //     try{
    //     return $this->sendSuccess('suspend emp  success',$this->employeeService->suspendEmployee($id, $date));
    // } catch (\Exception $e) {

    //                 Log::error('Unhandled Exception: ' . $e->getMessage());
    //                 return $this->sendError($e->getMessage(), $e->getCode());
    //             }

    // }
//     public function resigned_emp($id, $resignDate)
// {
//     try{
//         return $this->sendSuccess('resgined emp  success',$this->employeeService->resignEmployee($id, $resignDate));
//     } catch (\Exception $e) {

//                     Log::error('Unhandled Exception: ' . $e->getMessage());
//                     return $this->sendError($e->getMessage(), $e->getCode());
//                 }
// }

    public function resigned_emp($id, $resign_date)
    {

        $update_date = date("Y-m-d");


        $result5 = DB::connection('sqlsrv2')->update('update Emp_Register set Status=?, ResignDate=? where EmployeeID =?', ["Resigned", $resign_date, $id]);

        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session_closed as $find_session1) {

        }
        $sesson_name = $find_session1->SessionName;

        DB::connection('sqlsrv2')->insert("INSERT INTO FinalSettlement(CompanyID, EmployeeID, SessionName, ResignOn, DStatus, MStatus, HrStatus, Status, FStatus, CreatedBy, CreatedOn) values (?,?,?,?,?,?,?,?,?,?,?)", [company_id(), $id, $sesson_name, $resign_date, 'Pending', 'Pending', 'Pending', 'Pending', 'Pending', username(), $update_date]);
        if ($result5) {
            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())
                ->where('Emp_Profile.EmployeeID', '=', $id)->get();

            $update_date = long_date();
            $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $id)->get();
            foreach ($full_name_arr as $full_name_arr1) {

            }
            $full_name = $full_name_arr1->Name;
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Status', 'Update status of ' . $full_name . ' to Resigned', $update_date]);
            //-------------
            /*
            $find_session =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=', company_id())->where('CurrentSession','=',1)->get();
                foreach ($find_session as $find_session1) {}
                $e_date = $find_session1->EndDate;
            $x = 1;
            $var=strtotime($e_date);
            $effectiveDate = strtotime("-".$x." months",$var);
            $previous_session = date("F-Y", $effectiveDate);  //Its previous seission e.g. "May-2022"
            $is_exist = DB::connection('sqlsrv2')->table('SessionReport')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('DStatus','=','P')->exists();
            $is_exist = DB::connection('sqlsrv2')->table('PayrollHrApproval')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('HrStatus','=','P')->exists();
            $is_exist = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('FStatus','=','P')->where('PayrollFinanceApproval.IsDeleted', '=' ,0)->exists();
            $is_exist = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('DStatus','=','P')->exists();
            if($is_exist)
            {
                $is_deleted = DB::connection('sqlsrv2')->table('SessionReport')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('DStatus','=','P')->delete();
                $is_deleted = DB::connection('sqlsrv2')->table('PayrollHrApproval')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('HrStatus','=','P')->delete();
                $is_deleted = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->where('SessionName','=',$previous_session)->where('PayrollFinanceApproval.IsDeleted', '=' ,0)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('FStatus','=','P')->delete();
                $is_deleted = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('DStatus','=','P')->delete();
                if($is_deleted)
                {
                    $find_session_last =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=', company_id())->where('SessionName','=',$previous_session)->get();
                    foreach ($find_session_last as $find_session_last1) {}
                    $sname1 = $find_session_last1->SessionName;
                    $s_date = $find_session_last1->StartDate;
                    $find_session_this =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=', company_id())->where('CurrentSession','=',1)->get();
                    foreach ($find_session_this as $find_session_this1) {}
                    $sname2 = $find_session1->SessionName;
                    $sname = $sname1.' and '.$sname2;
                }
            }
            else
            {
                $find_session =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=', company_id())->where('CurrentSession','=',1)->get();
                foreach ($find_session as $find_session1) {}
                $sname = $find_session1->SessionName;
                $s_date = $find_session1->StartDate;
                //$session_end_date = $find_session1->EndDate;
            }
            $result_insert = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ; exec [dbo].[Get_FinalSettlement]
                @createdby = N'".username()."',
                @createdon = N'".$update_date."',
                @session = N'".$sname."',
                @id = N'".$id."',
                @STARTDATE = '".$s_date."',
                @ENDDATE = '".$resign_date."' ");
                */
            /*
                 DB::connection('sqlsrv2')->SELECT("SET NOCOUNT ON  EXEC [dbo].[Get_FinalSettlement] N'".username()."', N'".$update_date."', N'".$sname."', N'".$id."', N'".$s_date."', N'".$resign_date."' ");*/

            //---------------
            return request()->json(200, $emp_detail);
        }
    }
}
