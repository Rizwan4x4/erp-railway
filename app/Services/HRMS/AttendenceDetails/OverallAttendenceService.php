<?php

namespace App\Services\HRMS\AttendenceDetails;

use App\Contracts\Repository\HRMS\AttendenceDetails\OverallAttendenceRepositoryInterface;
use App\Contracts\Services\HRMS\AttendenceDetails\OverallAttendenceServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\AttendenceDetails\OverallAttendenceRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;
use maliklibs\Zkteco\Lib\ZKTeco;

class OverallAttendenceService implements OverallAttendenceServiceInterface
{
    protected $OverallAttendenceRepositoryInterface;

    public function __construct(OverallAttendenceRepositoryInterface $OverallAttendenceRepositoryInterface)
    {
        $this->OverallAttendenceRepositoryInterface = $OverallAttendenceRepositoryInterface;
    }

    public function getUserAttendanceData($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = employee_id();
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            $attstartDate = date('Y-m-d', strtotime(short_date() . " - 30 days"));
            return $this->OverallAttendenceRepositoryInterface->getUserAttendance(company_id(), $id, short_date(), $attstartDate);
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }

    }

    public function getattendance($company_id, $emp_code, $start, $close, $department, $designation, $location, $code)
    {
        $dept = Session::get('employee_department');

        if ($dept == 'Software Development' || $dept == 'Human Resource') {
//            if ($designation == 'All' && $department == 'All' && $location == 'All') {
            return $this->OverallAttendenceRepositoryInterface->getAttendanceData($company_id, $emp_code, $start, $close, $department, $designation, $location, $code);
//            }
//            else {
//                return $this->OverallAttendenceRepositoryInterface->getAttendanceData($company_id, $emp_code, $start, $close, $department, $designation, $location, $code);
//            }
        } else {
//            if ($designation == 'All' && $location == 'All') {
            return $this->OverallAttendenceRepositoryInterface->getAttendanceData1($company_id, $emp_code, $start, $close, 'All', $designation, $location, $code);
//            }
//            else {
//                return $this->OverallAttendenceRepositoryInterface->getAttendanceData($company_id, $emp_code, $start, $close, 'All', $designation, $location, $code);
//            }
        }
    }

    // public function getattendance($department,$location,$designation,$start,$close, $code){
    //     $company_id=Session::get('company_id');
    //     $username = Session::get('username');
    //     $dept = Session::get('employee_department');
    //     $emp_code= Session::get('employee_id');
    //     $name='';
    //     $arr1 = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC   [dbo].[Get_reporting_tree]
    //   @id = N'".$emp_code."',
    //   @companyid = N'".$company_id."'
    // ");
    //     $arr = DB::connection('sqlsrv2')->table('Att_Permission')->join('Emp_Register', 'Att_Permission.SubEmpID', '=', 'Emp_Register.EmployeeID')->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->select('Emp_Profile.*','Emp_Register.*')->orderBy('Emp_Profile.Name', 'asc')->where('Att_Permission.CompanyID','=',$company_id)->where('Att_Permission.ChiefEmpID', '=', $emp_code)->where('Att_Permission.IsMandatory','=',1)->get();
    //     $arr2 = json_decode(json_encode($arr), FALSE);
    //     $team = array_merge($arr1, $arr2);
    //     $EmpCode = [];
    //     foreach($team as $team1) {
    //         if (is_object($team1)) {
    //             $EmpCode[] = $team1->EmployeeCode;
    //         }
    //     }
    //     if($dept== 'Software Development' || $dept == 'Human Resource' ){
    //         // return request()->json(200,$code.'  '. $start);
    //         if($designation=='All' && $department=='All'&& $location=='All'){
    //             $arr =DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID','=',$company_id)->where('Emp_Register.EmployeeCode', 'like', '%'.$code.'%')->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)->paginate(20);
    //             return request()->json(200,$arr);
    //         }
    //         else {
    //             if($department=='All'){
    //                 $department='';
    //             }
    //             if($designation=='All'){
    //                 $designation='';
    //             }
    //             if($location=='All'){
    //                 $location='';
    //             }
    //             $arr =DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name','AttData.*','Emp_Register.Department','Emp_Register.PostingCity','Emp_Register.Designation','Emp_Register.EmployeeCode')->where('AttData.CompanyID','=',$company_id)->where('Emp_Register.EmployeeCode', 'like', '%'.$code.'%')->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)->where('Emp_Register.Department','like','%'.$department.'%')->where('Emp_Register.Designation','like','%'.$designation.'%')->where('Emp_Register.PostingCity','like','%'.$location.'%')->paginate(30);
    //             return request()->json(200,$arr);
    //         }
    //     }
    //     else {
    //         if($designation=='All' && $location=='All'){
    //             $arr =DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID','=',$company_id)->whereIn('Emp_Register.EmployeeCode', $EmpCode)->where('Emp_Register.EmployeeCode', 'like', '%'.$code.'%')->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)->paginate(20);
    //             return request()->json(200,$arr);
    //         }
    //         else {
    //             if($designation=='All'){
    //                 $designation='';
    //             }
    //             if($location=='All'){
    //                 $location='';
    //             }
    //             $arr =DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID','=',$company_id)->whereIn('Emp_Register.EmployeeCode', $EmpCode)->where('Emp_Register.EmployeeCode', 'like', '%'.$code.'%')->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)
    //                 ->where('Emp_Register.Designation', 'like', '%' . $designation . '%')
    //                 ->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')->paginate(20);
    //             return response()->json($arr, 200);
    //         }
    //     }
    // }
    public function update_ind_att($request)
    {
        $att_id = $request->get('att_id');
        $check_in = $request->get('check_in');
        $check_out = $request->get('check_out');


        $update_date = long_date();

        $arr = $this->OverallAttendenceRepositoryInterface->getAttData($att_id);
        foreach ($arr as $arr1) {
        }
        if ($check_in <= $arr1->OpeningTime) {
            $att_status = 'P';
        } elseif ($check_in > $arr1->OpeningTime) {
            $att_status = 'L';
        }

        return $this->OverallAttendenceRepositoryInterface->updateAttendence($check_in, $check_out, $att_status, $att_id);


        $emp_id_arr = DB::connection('sqlsrv2')->table('AttData')->select('EmpID')->where('CompanyID', '=', company_id())->where('AttDataID', '=', $att_id)->get();
        foreach ($emp_id_arr as $emp_id_arr1) {

        }
        $emp_id = $emp_id_arr1->EmpID;
        $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $emp_id)->get();
        foreach ($full_name_arr as $full_name_arr1) {

        }
        $full_name = $full_name_arr1->Name;
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Attendace Updated', 'Attendace of ' . $full_name . ' updated', $update_date]);


    }

}
