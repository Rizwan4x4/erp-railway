<?php

namespace App\Repositories\HRMS\LeavesDetails;

use App\Contracts\Repository\HRMS\LeavesDetails\LeavesApplicationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Exceptions\ErrorException;

class LeavesApplicationRepository implements LeavesApplicationRepositoryInterface
{
    public function find_emp_id()
    {
        try {
            return DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('Emp_Profile.EmployeeID', 'desc')
                ->select('Emp_Profile.Name', 'Emp_Register.EmployeeID', 'Emp_Register.EmployeeCode')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Register.EmployeeCode', '!=', '')->get();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting employeeID: " . $e->getMessage());
        }
    }

    public function updateEmpLeaveRemaining($rem_an_levs, $us_lv_type, $emp_emp_id)
    {
        try {
            DB::connection('sqlsrv2')->update('update EmpLeave set RemainingLeave=? where LeaveType=? AND EmployeeID=? AND CompanyID=?', [$rem_an_levs, $us_lv_type, $emp_emp_id, company_id()]);

        } catch (QueryException $e) {
            throw new ErrorException("Error updating Remaining Leaves: " . $e->getMessage());
        }
    }

    public function GetEmpLeaveRemaining($us_lv_type, $emp_emp_id)
    {
        try {
            return DB::connection('sqlsrv2')->table('EmpLeave')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $emp_emp_id)->where('LeaveType', '=', $us_lv_type)->whereYear('CreatedOn', '=', date('Y'))->value('RemainingLeave');
        } catch (QueryException $e) {
            throw new ErrorException("Error getting Employe Remaining Leaves: " . $e->getMessage());
        }

    }

    public function fetch_leave_upSts($cid)
    {
        try {
            return DB::connection('sqlsrv2')->table('leave_Requisition')
                ->join('Emp_Profile', 'leave_Requisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('leave_Requisition.EmployeeID', 'asc')
                ->select('leave_Requisition.*', 'Emp_Profile.*', 'Emp_Register.*')
                ->where('leave_Requisition.LeaveRQID', '=', $cid)
                ->where('leave_Requisition.CompanyID', '=', company_id())->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available stock: " . $e->getMessage());
        }
    }

    public function filterLeavesRequisitions($leave_type, $department, $location, $designation, $status, $ManagerStatus, $HRStatus)
    {
        try {
            $leaveQuery = DB::connection('sqlsrv2')
                ->table('Emp_Profile')
                ->join('leave_Requisition', 'Emp_Profile.EmployeeID', '=', 'leave_Requisition.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'leave_Requisition.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('leave_Requisition.CompanyID', '=', company_id())
                ->where('leave_Requisition.Leavetype', 'like', '%' . $leave_type . '%')
                ->where('leave_Requisition.PendingLeaveStatus', 'like', '%' . $status . '%')
                ->where('leave_Requisition.ManagerApproval', 'like', '%' . $ManagerStatus . '%')
                ->where('leave_Requisition.HRApproval', 'like', '%' . $HRStatus . '%')
                ->where('Emp_Register.Department', 'like', '%' . $department . '%')
                ->where('Emp_Register.Designation', 'like', '%' . $designation . '%')
                ->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')
                ->orderBy('StartDate', 'desc')
                ->orderByRaw("CASE WHEN PendingLeaveStatus = 'P' then 1 WHEN PendingLeaveStatus = 'OL' then 2 WHEN PendingLeaveStatus = 'A' then 3 WHEN PendingLeaveStatus = 'R' then 4 END ASC");

            if (emp_department() == 'Software Development' || emp_department() == 'Human Resource') {
                return $leaveQuery->paginate(15);
            } else {
                $employeeIDs = array_column(reporting_team(), 'EmployeeID');
                return $leaveQuery->whereIn('leave_Requisition.EmployeeID', $employeeIDs)->paginate(15);
            }

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available stock: " . $e->getMessage());
        }
    }

    public function search_Employee_leave($keyword1)
    {
        try {
//            dd('ok1');
            $leaveQuery = DB::connection('sqlsrv2')
                ->table('Emp_Profile')
                ->join('leave_Requisition', 'Emp_Profile.EmployeeID', '=', 'leave_Requisition.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'leave_Requisition.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('leave_Requisition.CompanyID', '=', company_id())
                ->Where(function ($query) use ($keyword1) {
                    $query->Where('Emp_Profile.Employee_Code', 'LIKE', '%' . $keyword1 . '%')
                        ->orWhere('Emp_Profile.Name', 'LIKE', '%' . $keyword1 . '%');
                })
                ->orderBy('StartDate', 'desc')
                ->orderByRaw("CASE WHEN PendingLeaveStatus = 'P' then 1 WHEN PendingLeaveStatus = 'OL' then 2 WHEN PendingLeaveStatus = 'A' then 3 WHEN PendingLeaveStatus = 'R' then 4 END ASC");

            if (emp_department() == 'Software Development' || emp_department() == 'Human Resource') {
                return $leaveQuery->paginate(15);
            } else {
                $employeeIDs = array_column(reporting_team(), 'EmployeeID');
                return $leaveQuery->whereIn('leave_Requisition.EmployeeID', $employeeIDs)->paginate(15);
            }
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available leave: " . $e->getMessage());
        }
    }
}
