<?php

namespace App\Repositories\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeLeaveReportsRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
class EmployeeLeaveReportsRepository implements EmployeeLeaveReportsRepositoryInterface
{




public function get_absent_detail($start, $end, $loc, $dept, $desig, $emp_id){

   try{
     return DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name','AttData.ATTDate','Emp_Register.Department','Emp_Register.PostingCity','Emp_Register.Designation','Emp_Register.EmployeeCode')
     ->where('AttData.CompanyID','=', company_id())
     ->where('Emp_Register.PostingCity','like','%'.$loc.'%')
     ->where('Emp_Register.Department','like','%'.$dept.'%')
     ->where('Emp_Register.Designation','like','%'.$desig.'%')
     ->where('AttData.EmpID','like','%'.$emp_id.'%')
     ->where('AttData.AttStatus','=','A')
     ->where('AttData.ATTDate', '>=', $start)
     ->where('AttData.ATTDate', '<=', $end)
     ->get();
    } catch (QueryException $e) {
                        // Throw a custom exception with the original message
                        throw new ErrorException("Error getting absent details: " . $e->getMessage());
                    }

    }

    public function getLeaveEmployees($department, $location, $designation, $emp_id, $date_from, $date_end, $leave_type)
    {
        try{
        $query = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('leave_Requisition', 'Emp_Profile.EmployeeID', '=', 'leave_Requisition.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('leave_Requisition.EmployeeID', 'desc')
            ->select('Emp_Profile.Name', 'leave_Requisition.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
            ->where('leave_Requisition.CompanyID', '=', company_id())
            ->where('leave_Requisition.StartDate', '>=', $date_from)
            ->where('leave_Requisition.EndDate', '<=', $date_end);

        if ($department != 'All') {
            $query->where('Emp_Register.Department', 'like', '%' . $department . '%');
        }
        if ($designation != 'All') {
            $query->where('Emp_Register.Designation', 'like', '%' . $designation . '%');
        }
        if ($location != 'All') {
            $query->where('Emp_Register.PostingCity', 'like', '%' . $location . '%');
        }
        if ($emp_id != 'All') {
            $query->where('Emp_Register.EmployeeCode', 'like', '%' . $emp_id . '%');
        }
        if ($leave_type != 'All') {
            $query->where('leave_Requisition.Leavetype', 'like', '%' . $leave_type . '%');
        }

        $result = $query->get();

        return $result;
    } catch (QueryException $e) {
        // Throw a custom exception with the original message
        throw new ErrorException("Error getting Employee Leaves: " . $e->getMessage());
    }
    }

    public function filterLeaves($department, $location, $designation, $emp_id, $leave_type)
    {
        $query = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('EmpLeave', 'Emp_Profile.EmployeeID', '=', 'EmpLeave.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('EmpLeave.EmployeeID', 'desc')
            ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'EmpLeave.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
            ->where('EmpLeave.CompanyID', '=', company_id())
            ->where('EmpLeave.LeaveType', '=', $leave_type);

        $designation = ($designation != 'All') ? '' : $designation;
        $department = ($department != 'All') ? '' : $department;
        $location = ($location != 'All') ? '' : $location;
        $emp_id = ($emp_id != 'All') ? '' : $emp_id;


        $query->where('Emp_Register.Department', 'like', '%' . $department . '%');
        $query->where('Emp_Register.Designation', 'like', '%' . $designation . '%');
        $query->where('Emp_Register.PostingCity', 'like', '%' . $location . '%');
        $query->where('EmpLeave.EmployeeID', 'like', '%' . $emp_id . '%');
/*
        if (emp_department() == 'Software Development' || emp_department() == 'Human Resource') {
            return $query->paginate(15);
        } else {
            $employeeIDs = array_column(reporting_team(), 'EmployeeID');
            return $query->whereIn('leave_Requisition.EmployeeID', $employeeIDs)->paginate(15);
        }
        */
        $result = $query->get();
        return $result;
    }


}
