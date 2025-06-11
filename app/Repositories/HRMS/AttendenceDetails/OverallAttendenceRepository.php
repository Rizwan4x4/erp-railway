<?php

namespace App\Repositories\HRMS\AttendenceDetails;

use App\Contracts\Repository\HRMS\AttendenceDetails\OverallAttendenceRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ErrorException;

class OverallAttendenceRepository implements OverallAttendenceRepositoryInterface
{


    public function get_count_leave()
    {
        try {

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }

    }

    public function getUserAttendance($company_id, $emp_id, $attendDate, $attstartDate)
    {
        try {
            // dd('its ok');
            return DB::connection('sqlsrv2')->table('AttData')
                ->orderBy('ATTDate', 'desc')
                ->select('AttData.*')
                ->where('CompanyID', '=', company_id())
                ->where('ATTDate', '>=', $attstartDate)
                ->where('ATTDate', '<=', $attendDate)
                ->where('EmpID', '=', $emp_id)
                ->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available value: " . $e->getMessage());
        }
    }

    public function getAttendanceData($company_id, $emp_code, $start, $close, $department, $designation, $location, $code)
    {
//        dd('ok1');
        try {
            $department = ($department == 'All') ? '' : $department;
            $designation = ($designation == 'All') ? '' : $designation;
            $location = ($location == 'All') ? '' : $location;
            return DB::connection('sqlsrv2')
                ->table('Emp_Profile')
                ->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('AttData.EmpID', 'desc')
                ->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('AttData.CompanyID', '=', $company_id)
                ->where('Emp_Register.EmployeeCode', 'like', '%' . $code . '%')
                ->where('AttData.ATTDate', '>=', $start)
                ->where('AttData.ATTDate', '<=', $close)
                ->where('Emp_Register.Department', 'like', '%' . $department . '%')
                ->where('Emp_Register.Designation', 'like', '%' . $designation . '%')
                ->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')
                ->paginate(20);

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }

    }
    public function getAttendanceData1($company_id, $emp_code, $start, $close, $department, $designation, $location, $code)
    {
//        dd('ok1');
        try {
            $department = ($department == 'All') ? '' : $department;
            $designation = ($designation == 'All') ? '' : $designation;
            $location = ($location == 'All') ? '' : $location;

            $arr01 = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC [dbo].[Get_reporting_tree] @id = N'" . $emp_code . "', @companyid = N'" . $company_id . "'");
            $arr1 = array_column($arr01, 'EmployeeID');
            $arr002 = DB::connection('sqlsrv2')
                ->table('Att_Permission')
                ->join('Emp_Register', 'Att_Permission.SubEmpID', '=', 'Emp_Register.EmployeeID')
                ->select('Emp_Register.EmployeeID')
                ->orderBy('Emp_Register.EmployeeID', 'asc')
                ->where('Att_Permission.CompanyID', '=', company_id())
                ->where('Att_Permission.ChiefEmpID', '=', $emp_code)
                ->where('Att_Permission.IsMandatory', '=', 1)
                ->get();
//            dd($arr);
            $arr02 = json_decode(json_encode($arr002), FALSE);
            $arr2 = array_column($arr02, 'EmployeeID');

            $team = array_merge($arr1, $arr2);
//        DD($team);
            $EmpCode = [];
//        foreach ($team as $team1) {
//            if (is_object($team1)) {
//                $EmpCode[] = $team1->EmployeeCode;
//            }
//        }

            return DB::connection('sqlsrv2')
                ->table('Emp_Profile')
                ->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('AttData.EmpID', 'desc')
                ->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('AttData.CompanyID', '=', $company_id)
                ->where('Emp_Register.EmployeeCode', 'like', '%' . $code . '%')
                ->whereIn('Emp_Register.EmployeeID', $team)
                ->where('AttData.ATTDate', '>=', $start)
                ->where('AttData.ATTDate', '<=', $close)
                ->where('Emp_Register.Department', 'like', '%' . $department . '%')
                ->where('Emp_Register.Designation', 'like', '%' . $designation . '%')
                ->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')
                ->paginate(20);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }

    }

    public function getAttData($att_id)
    {
        try {
            return DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('AttDataID', '=', $att_id)->get();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }
    }

    public function updateAttendence($check_in, $check_out, $att_status, $att_id)
    {
        try {
            return DB::connection('sqlsrv2')->update('update AttData set CheckIN=?,CheckOut=?,AttStatus=?,UpdatedBy=? where AttDataID=?', [$check_in . ':00.0000000', $check_out . ':00.0000000', $att_status, username(), $att_id]);

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }
    }

}
