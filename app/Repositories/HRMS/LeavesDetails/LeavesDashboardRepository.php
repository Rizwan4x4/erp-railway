<?php

namespace App\Repositories\HRMS\LeavesDetails;

use App\Contracts\Repository\HRMS\LeavesDetails\LeavesDashboardRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Exceptions\ErrorException;
class LeavesDashboardRepository implements LeavesDashboardRepositoryInterface
{


    public function overall_leaves(){
        try{
            return DB::connection('sqlsrv2')->table('leaves')->select('LeaveType')->where('CompanyID','=',company_id())->get();
        }
        catch (QueryException $e) {
               // Throw a custom exception with the original message
               throw new ErrorException("Error getting available stock: " . $e->getMessage());
           }

            }
            public function filterLeaves($leave_type, $department, $location, $designation)
            {
                try{
                    $leaveBalanceQuery = DB::connection('sqlsrv2')->table('EmpLeave')->join('Emp_Profile', 'EmpLeave.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('Emp_Register.EmployeeCode', 'asc')
                        ->selectRaw("Emp_Register.EmployeeID, Emp_Register.employeecode, Emp_Profile.Name, Emp_Profile.Photo, Emp_Register.department, Emp_Register.Designation, SUM(CASE WHEN EmpLeave.LeaveType = 'casual' THEN TotalLeave ELSE 0 END) AS casualtotal, SUM(CASE WHEN LeaveType = 'casual' THEN RemainingLeave ELSE 0 END) AS casualremaining, SUM(CASE WHEN LeaveType = 'sick' THEN TotalLeave ELSE 0 END) AS sicktotal, SUM(CASE WHEN LeaveType = 'sick' THEN RemainingLeave ELSE 0 END) AS sickremaining, SUM(CASE WHEN LeaveType = 'Annual' THEN TotalLeave ELSE 0 END) AS Annualtotal, SUM(CASE WHEN LeaveType = 'Annual' THEN RemainingLeave ELSE 0 END) AS Annualremaining")
                        ->whereRaw("EmpLeave.LeaveType like ? and Emp_Register.Department like ? and EmpLeave.CreatedOn like ? and Emp_Register.Designation like ? and Emp_Register.PostingCity like ? and EmpLeave.CompanyID = ?",['%' . $leave_type . '%', '%' . $department . '%', '%' . date("Y") . '%', '%' . $designation . '%', '%' . $location . '%', company_id()])
                        ->groupby('Emp_Register.EmployeeID', 'Emp_Register.employeecode', 'Emp_Profile.Name', 'Emp_Profile.Photo', 'Emp_Register.department', 'Emp_Register.Designation');

                    if (emp_department() == 'Software Development' || emp_department() == 'Human Resource') {
                        return $leaveBalanceQuery->paginate(20);
                    } else {
                        $employeeIDs = array_column(reporting_team(), 'EmployeeID');
                        return $leaveBalanceQuery->whereIn('Emp_Register.EmployeeID', $employeeIDs)->paginate(20);
                    }
                }
                catch (QueryException $e) {
                       // Throw a custom exception with the original message
                       throw new ErrorException("Error getting available stock: " . $e->getMessage());
                   }
            }
    public function filterLeavesById($empNameCode)
    {try{
        $thisYear = date("Y");

        $query = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('EmpLeave', 'Emp_Profile.EmployeeID', '=', 'EmpLeave.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('Emp_Register.EmployeeCode', 'asc')
            ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'EmpLeave.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
            ->whereRaw("(Emp_Register.EmployeeCode like ? or Emp_Profile.Name like ?) and EmpLeave.CreatedOn like ? and EmpLeave.CompanyID = ?",
                ['%' . $empNameCode . '%', '%' . $empNameCode . '%', '%' . $thisYear . '%', company_id()]);

        return $query->paginate(20);
    }
    catch (QueryException $e) {
           // Throw a custom exception with the original message
           throw new ErrorException("Error getting available stock: " . $e->getMessage());
       }
    }

}
