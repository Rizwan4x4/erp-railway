<?php

namespace App\Repositories\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeAttendenceRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
class EmployeeAttendenceRepository implements EmployeeAttendenceRepositoryInterface
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

public function getAttendanceReport( $department, $location, $designation, $employeeId, $startDate, $endDate)
{
    return DB::connection('sqlsrv2')
        ->table('Emp_Profile')
        ->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')
        ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
        ->orderBy('AttData.EmpID', 'desc')
        ->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
        ->where('AttData.CompanyID', '=', company_id())
        ->where('AttData.ATTDate', '>=', $startDate)
        ->where('AttData.ATTDate', '<=', $endDate)
        ->where('Emp_Register.Department', 'like', '%' . $department . '%')
        ->where('Emp_Register.Designation', 'like', '%' . $designation . '%')
        ->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')
        ->where('AttData.EmpID', 'like', '%' . $employeeId . '%')
        ->get();
}


public function getAttendanceCount(  $employeeId)
{
    $find_session =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=',company_id())->where('CurrentSession','=',1)->get();
    foreach ($find_session as $find_session1) {
     
         }
        //  remove this 

    $startDate = $find_session1->StartDate;
    $endDate = $find_session1->EndDate;
    // 

    $totalDays = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '>=', $startDate)->where('ATTDate', '<=', $endDate)->where('EmpID', '=', $employeeId)->count();

    $present = DB::connection('sqlsrv2')->select("SELECT COUNT(AttStatus) AS present FROM AttData WHERE ATTDate BETWEEN ? AND ? AND EmpID = ? AND AttStatus IN ('P', 'L')", [$startDate, $endDate, $employeeId]);
    
    $absent = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '>=', $startDate)->where('ATTDate', '<=', $endDate)->where('EmpID', '=', $employeeId)->where('AttStatus', '=', 'A')->count();

    $leaves = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '>=', $startDate)->where('ATTDate', '<=', $endDate)->where('EmpID', '=', $employeeId)->where('AttStatus', '=', 'LE')->count();

    $employeeData = DB::connection('sqlsrv2')->table('Emp_Profile')
        ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
        ->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.PostingCity')
        ->where('Emp_Profile.CompanyID', '=', company_id())
        ->where('Emp_Profile.EmployeeID', '=', $employeeId)
        ->first();

    return [
        'totaldays' => $totalDays,
        'present' => $present[0]->present,
        'absent' => $absent,
        'leaves' => $leaves,
        'Name' => $employeeData->Name,
        'EmployeeCode' => $employeeData->EmployeeCode,
        'Department' => $employeeData->Department,
        'Designation' => $employeeData->Designation,
        'PostingCity' => $employeeData->PostingCity,
    ];
}

public function getSessionEmployeeAttendanceReport( $employeeId)
{
    $find_session =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=',company_id())->where('CurrentSession','=',1)->get();
    foreach ($find_session as $find_session1) {
     
         }
        //  remove this 

    $startDate = $find_session1->StartDate;
    $endDate = $find_session1->EndDate;
    // extra var

   return DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '>=', $startDate)->where('ATTDate', '<=', $endDate)->where('EmpID', '=', $employeeId)->orderBy('ATTDate', 'desc')->get();

 
}

public function getMonthlyAttendanceData($startDate, $endDate)
{
    return DB::connection('sqlsrv2')
        ->select("SET NOCOUNT ON; exec [dbo].[GetMonthltAttReport] N'$startDate', N'$endDate'");

    
}
public function findSession()
{
    return DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=', company_id())->where('CurrentSession','=',1)->first();

    
}
public function get_payroll_att_detail_report($startDatec,$endDate)
{





  return DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC  [dbo].[Get_TotalReport]  N'".$startDatec."', N'".$endDate."' ");

  

   return request()->json(200,$result);
      }
}
