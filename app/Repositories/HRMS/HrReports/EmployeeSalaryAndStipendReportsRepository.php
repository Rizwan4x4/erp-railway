<?php

namespace App\Repositories\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeSalaryAndStipendReportsRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
class EmployeeSalaryAndStipendReportsRepository implements EmployeeSalaryAndStipendReportsRepositoryInterface
{

   


// public function get_absent_detail($start, $end, $loc, $dept, $desig, $emp_id){

//    try{   
//      return DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name','AttData.ATTDate','Emp_Register.Department','Emp_Register.PostingCity','Emp_Register.Designation','Emp_Register.EmployeeCode')
//      ->where('AttData.CompanyID','=', company_id())
//      ->where('Emp_Register.PostingCity','like','%'.$loc.'%')
//      ->where('Emp_Register.Department','like','%'.$dept.'%')
//      ->where('Emp_Register.Designation','like','%'.$desig.'%')
//      ->where('AttData.EmpID','like','%'.$emp_id.'%')
//      ->where('AttData.AttStatus','=','A')
//      ->where('AttData.ATTDate', '>=', $start)
//      ->where('AttData.ATTDate', '<=', $end)
//      ->get();
//     } catch (QueryException $e) {
//                         // Throw a custom exception with the original message
//                         throw new ErrorException("Error getting absent details: " . $e->getMessage());
//                     }
     
//     }
public function getClosedSession()
{
    return DB::connection('sqlsrv2')
        ->table('HrSessions')
        ->where('CompanyID', '=', company_id())
        ->where('AttClosedPayrollStart', '=', 'Closed')
        ->get();
}

public function getSalaryDetails($sessionName)
{
    return DB::connection('sqlsrv2')
        ->table('PayrollFinanceApproval')
        ->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')
        ->where('PayrollFinanceApproval.SessionName', '=', $sessionName)
        ->select('Emp_Register.Department')
        ->whereNotNull('Emp_Register.Department')
        ->where('PayrollFinanceApproval.StipendAmount', '>', 0)
        ->orderBy('Emp_Register.Department', 'asc')
        ->groupBy('Emp_Register.Department')
        ->get();
}

public function getSalarySums($sessionName)
{
    $query = DB::connection('sqlsrv2')
        ->table('PayrollFinanceApproval')
        ->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')
        ->whereNotNull('Emp_Register.Department')
        ->where('PayrollFinanceApproval.SessionName', '=', $sessionName)
        ->where('PayrollFinanceApproval.StipendAmount', '>', 0);

    return [
        'stipend_sum' => $query->sum('PayrollFinanceApproval.StipendAmount'),
        'allowance_sum' => $query->sum('PayrollFinanceApproval.AllowanceAmount'),
        'bonus_sum' => $query->sum('PayrollFinanceApproval.BonusAmount'),
        't_sum' => $query->sum('PayrollFinanceApproval.TAmount'),
        'installment_sum' => $query->sum('PayrollFinanceApproval.InstallmentAmount'),
        'advance_sum' => $query->sum('PayrollFinanceApproval.AdvanceAmount'),
        'payable_sum' => $query->sum('PayrollFinanceApproval.PayableSalary')
    ];
}
}
