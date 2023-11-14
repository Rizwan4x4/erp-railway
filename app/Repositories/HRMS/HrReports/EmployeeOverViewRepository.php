<?php

namespace App\Repositories\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeOverviewRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
class EmployeeOverViewRepository implements EmployeeOverviewRepositoryInterface
{


//     public function find_emp_id(){
//         try{



//    return  DB::connection('sqlsrv2')->table('Emp_Profile')
//     ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
//     ->orderBy('Emp_Profile.EmployeeID', 'desc')
//     ->select('Emp_Profile.Name','Emp_Register.EmployeeID','Emp_Register.EmployeeCode')->where('Emp_Profile.CompanyID','=',company_id())->where('Emp_Register.EmployeeCode','!=','')->get();

//             } catch (QueryException $e) {
//                 // Throw a custom exception with the original message
//                 throw new ErrorException("Error getting employeeID: " . $e->getMessage());
//             }

//             }
public function getEmployeeDetails( $emp_department, $emp_location, $emp_designation, $emp_emp_id, $emp_type, $emp_status)
{
    return DB::connection('sqlsrv2')
        ->table('Emp_Profile')
        ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
        ->orderBy('Emp_Profile.EmployeeID', 'desc')
        ->select('Emp_Profile.*', 'Emp_Register.*')
        ->where('Emp_Profile.CompanyID', '=', company_id())
        ->where('Emp_Register.Department', 'like', '%' . $emp_department . '%')
        ->where('Emp_Register.Designation', 'like', '%' . $emp_designation . '%')
        ->where('Emp_Register.PostingCity', 'like', '%' . $emp_location . '%')
        ->where('Emp_Register.EmployeeID', 'like', '%' . $emp_emp_id . '%')
        ->where('Emp_Register.Status', 'like', '%' . $emp_status . '%')
        ->where('Emp_Register.JobStatus', 'like', '%' . $emp_type . '%')
        ->get();
}


public function getHireEmployees($hire_department,$hire_location,$hire_designation,$hire_emp_id,$hire_start_date,$hire_end_date)
{
    return DB::connection('sqlsrv2')
        ->table('Emp_Profile')
        ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
        ->orderBy('Emp_Profile.EmployeeID', 'desc')
        ->select('Emp_Profile.*', 'Emp_Register.*')
        ->where('Emp_Profile.CompanyID', '=', company_id())
        ->where('Emp_Register.Department', 'like', '%' . $hire_department . '%')
        ->where('Emp_Register.Designation', 'like', '%' . $hire_designation . '%')
        ->where('Emp_Register.PostingCity', 'like', '%' . $hire_location . '%')
        ->where('Emp_Register.EmployeeID', 'like', '%' . $hire_emp_id . '%')
        ->where('Emp_Register.JoiningDate', '>=', $hire_start_date)
        ->where('Emp_Register.JoiningDate', '<=', $hire_end_date)
        ->get();
}

public function getHireEmployeesCount($hire_department,$hire_location,$hire_designation,$hire_emp_id,$hire_start_date,$hire_end_date)
{
    return DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID','=',company_id())->where('JoiningDate', '>=', $hire_start_date)->where('JoiningDate', '<=', $hire_end_date)->where('Department','like','%'.$hire_department.'%')->where('Designation','like','%'.$hire_designation.'%')->where('PostingCity','like','%'.$hire_location.'%')->where('EmployeeID','like','%'.$hire_emp_id.'%')->count();
}


}
