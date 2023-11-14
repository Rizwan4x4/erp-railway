<?php

namespace App\Http\Controllers\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeAttendenceRepositoryInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeAttendenceServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Session;

use DB;

use Illuminate\Support\Facades\Log;


use App\Exceptions\ErrorException;


class EmployeeAttendenceController extends Controller
{
    use CommonTrait;

    protected $EmployeeAttendenceRepositoryInterface;
    protected $EmployeeAttendenceServiceInterface;

    public function __construct(EmployeeAttendenceRepositoryInterface $EmployeeAttendenceRepositoryInterface, EmployeeAttendenceServiceInterface $EmployeeAttendenceServiceInterface)
    {
        $this->EmployeeAttendenceRepositoryInterface = $EmployeeAttendenceRepositoryInterface;
        $this->EmployeeAttendenceServiceInterface = $EmployeeAttendenceServiceInterface;
    }


    public function getattendance_report($department, $location, $designation, $emp_id, $start, $close)
    {
        try {
            return $this->sendSuccess('get attendence report  success', $this->EmployeeAttendenceServiceInterface->getattendance_report($department, $location, $designation, $emp_id, $start, $close));
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }

    }

    public function getindatt_count($id)
    {
        try {
            return $this->sendSuccess('attendence count success', $this->EmployeeAttendenceServiceInterface->getAttendanceCount($id));


        } catch (\Exception $e) {
            //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function getindatt_report($id)
    {
        try {
            return $this->sendSuccess('get in attendece  success', $this->EmployeeAttendenceRepositoryInterface->getSessionEmployeeAttendanceReport($id));
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }

    }

    public function getattendance_summary()
    {
        try {
            return $this->sendSuccess('attendence summary success', $this->EmployeeAttendenceServiceInterface->getattendance_summary());
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }

    }

    public function get_payroll_att_detail()
    {
        try {
            return $this->sendSuccess('payroll att details  success', $this->EmployeeAttendenceServiceInterface->get_payroll_att_detail());

        } catch (\Exception $e) {
            //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function custom_attendance(Request $request)
    {
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $department_name = $request->department_name;
        $department_name = ($department_name == 'All') ? '' : $department_name;
        $employees = $request->employees;
        if ($employees != null) {
            $employeeIds = array_column($employees, 'id');
            $employeeIdsString = implode(',', $employeeIds);
        } else {
            $employeeIdsString = '';
        }

//        $employeeIdsString = '('.$employeeIdsString.')';
        $attendances = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ; exec [dbo].[sp_customAttendance] N'" . $startdate . "', N'" . $enddate . "', N'" . $department_name . "', N'" . $employeeIdsString . "'");

        return $attendances;
    }
}
