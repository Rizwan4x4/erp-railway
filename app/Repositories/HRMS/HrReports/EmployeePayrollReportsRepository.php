<?php

namespace App\Repositories\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeePayrollReportsRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
class EmployeePayrollReportsRepository implements EmployeePayrollReportsRepositoryInterface
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
public function getLoanAdvanceReport($startDate, $endDate, $department, $type, $status)
{
   
try{
   return DB::connection('sqlsrv2')->select("EXEC   [dbo].[Loan_Advances_Report]
                     @date = N'" . $startDate . "',
                     @date1 = N'" . $endDate . "',
                     @Dep = N'" . $department . "',
                     @type = N'" . $type . "',
                     @ReqStatus = N'" . $status . "'
                     ");
    } catch (QueryException $e) {
                        // Throw a custom exception with the original message
                        throw new ErrorException("Error getting Advance loan report: " . $e->getMessage());
                    }
   
}

public function arrears_report($starting_date,$ending_date,$dept){

    
    return DB::connection('sqlsrv2')->select("EXEC   [dbo].[Arrear_Report]
       @date = N'".$starting_date."',
       @date1 = N'".$ending_date."',
       @Dep = N'".$dept."'
       ");

    
           }
           public function getEmployCashDetail($sessionName)
           {
               return DB::connection('sqlsrv2')->table('Payroll_Distribution')
                   ->join('Emp_Register', 'Payroll_Distribution.EmployeeID', '=', 'Emp_Register.EmployeeID')
                   ->leftjoin('Payroll_DistributionLogs','Payroll_DistributionLogs.DistributionID','=','Payroll_Distribution.DistributionID')
                   ->where('Payroll_Distribution.CompanyID', '=', company_id())
                   ->where('Payroll_Distribution.SessionName', '=', $sessionName)
                   ->select('Payroll_Distribution.*', 'Emp_Register.CompanyName as Company','Payroll_DistributionLogs.ReceivedThrough as Received','Payroll_DistributionLogs.CurrentCashPaid as currentpaying','Payroll_DistributionLogs.ReceivedTime as ReceivedTi','Payroll_DistributionLogs.CashAmount as CCAmount','Payroll_DistributionLogs.BankAmount as BAmount','Payroll_DistributionLogs.PaidAmount as PAmount');
           }

         
    public function getEmployeeCashSum($emp_department, $emp_username, $sessionName, $status)
    {
        $query = DB::connection('sqlsrv2')->table('Payroll_Distribution')
            ->where('CompanyID', '=', company_id())
            ->where('SessionName', '=', $sessionName);

        if ($status == 'Unpaid' && $emp_department == 'All' && $emp_username == 'All') {
            return $query->whereNull('ReceivedThrough')->sum('CashAmount');
        }

        if ($status == 'Paid' && $emp_department == 'All' && $emp_username == 'All') {
            return $query->whereNotNull('ReceivedThrough')->sum('CashAmount');
        }

        if ($status == 'All' && $emp_department == 'All' && $emp_username == 'All') {
            return $query->sum('CashAmount');
        }

        if ($emp_department == 'All') {
            $emp_department = '';
        }

        if ($emp_username == 'All') {
            $emp_username = '';
        }

        return $query->where('Department', 'like', '%' . $emp_department . '%')
            ->where('ReceivedThrough', 'like', '%' . $emp_username . '%')
            ->sum('CashAmount');
    }

    public function getEmployeeBankSum($emp_department, $emp_username, $sessionName, $status)
    {
        $query = DB::connection('sqlsrv2')
            ->table('Payroll_Distribution')
            ->join("Emp_Register", "Payroll_Distribution.EmployeeID", "=", 'Emp_Register.EmployeeID')
            ->where('Payroll_Distribution.CompanyID', '=', company_id())
            ->where('Payroll_Distribution.SessionName', '=', $sessionName);

        if ($emp_department != 'All') {
            $query->where('Emp_Register.Department', 'like', '%' . $emp_department . '%');
        }

        if ($status == 'Unpaid') {
            $query->whereNull('ReceivedThrough');
        } elseif ($status == 'Paid') {
            $query->whereNotNull('ReceivedThrough');
        }

        if ($emp_username != 'All') {
            $query->where('ReceivedThrough', 'like', '%' . $emp_username . '%');
        }

        $emp_detail = $query->sum('BankAmount');

        return $emp_detail;
    }
}
