<?php

namespace App\Repositories\ClientAdmin;

use App\Contracts\Repository\ClientAdmin\ClientAdminRepositoryInterface;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Database\QueryException;

class ClientAdminRepository implements ClientAdminRepositoryInterface
{
    public function registered_empcode()
    {
        try {
            $query = DB::connection('sqlsrv2')->table('Emp_Register')->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->select('Emp_Register.EmployeeCode', 'Emp_Register.EmployeeID', 'Emp_Profile.Name')->where('Emp_Register.Status', '=', 'Registered')->where('Emp_Register.CompanyId', '=', company_id())->orderBy('Emp_Profile.Name');
            if ((emp_department() == 'Software Development') || (emp_department() == 'Human Resource' && (Session::get('hr_write') == true || Session::get('payroll_write') == true))) {
                return $query->get();
            } else {
                $arr002 = DB::connection('sqlsrv2')
                    ->table('Att_Permission')
                    ->join('Emp_Register', 'Att_Permission.SubEmpID', '=', 'Emp_Register.EmployeeID')
                    ->select('Emp_Register.EmployeeID')
                    ->orderBy('Emp_Register.EmployeeID', 'asc')
                    ->where('Att_Permission.CompanyID', '=', company_id())
                    ->where('Att_Permission.ChiefEmpID', '=', employee_id())
                    ->where('Att_Permission.IsMandatory', '=', 1)
                    ->get();
                $arr02 = json_decode(json_encode($arr002), FALSE);
                $arr2 = array_column($arr02, 'EmployeeID');
//                dd($arr2);
                $employeeIDs = array_column(reporting_team(), 'EmployeeID');
//                dd($employeeIDs);
                $team = array_merge($employeeIDs, $arr2);
                return $query->whereIn('Emp_Register.EmployeeID', $team)->get();
            }

            }
            catch (QueryException $e) {
                // Throw a custom exception with the original message
                throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
            }


}
}