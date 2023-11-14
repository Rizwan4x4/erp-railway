<?php

namespace App\Repositories\HRMS\AttendenceDetails;

use App\Contracts\Repository\HRMS\AttendenceDetails\LiveAttendenceRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ErrorException;

class LiveAttendenceRepository implements LiveAttendenceRepositoryInterface
{


    public function get_count_leave()
    {
        try {
            $find_session = DB::connection('sqlsrv2')
                ->table('HrSessions')
                ->where('CompanyID', '=', company_id())
                ->where('CurrentSession', '=', 1)
                ->first();

            if ($find_session) {
                $s_date = $find_session->StartDate;
                $e_date = $find_session->EndDate;

                return DB::connection('sqlsrv2')
                    ->table('leave_Requisition')
                    ->select('Leavetype', DB::raw('COUNT(*) as count'))
                    ->where('CompanyID', '=', company_id())
                    ->whereBetween('StartDate', [$s_date, $e_date])
                    ->whereIn('Leavetype', ['Sick', 'Casual', 'Annual'])
                    ->groupBy('Leavetype')
                    ->get()
                    ->pluck('count', 'Leavetype')
                    ->toArray();


            }
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }

    }

//    public function get_machines()
//    {
//        try {
//            return DB::connection('sqlsrv2')->table('Devices')->where('CompanyID', '=', company_id())->orderBy('Id', 'desc')->get();
//        } catch (QueryException $e) {
//            // Throw a custom exception with the original message
//            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
//        }
//    }

    public function getAttendanceCount($companyId, $updateDate, $status)
    {
        try {
            return DB::connection('sqlsrv2')
                ->table('AttData')
                ->join('Emp_Register', 'AttData.EmpID', '=', 'Emp_Register.EmployeeID')
                ->where('Emp_Register.Status', '!=', 'Terminated')
                ->where('Emp_Register.Status', '!=', 'Resigned')
                ->where('AttData.CompanyID', '=', $companyId)
                ->where('AttData.ATTDate', '=', $updateDate)
                ->where('AttData.AttStatus', '=', $status)
                ->count();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }
    }

    public function getUnMarkedCount($companyId, $updateDate)
    {
        try {
            $currentTime = date('H:i:s');
            return DB::connection('sqlsrv2')
                ->table('AttData')
                ->join('Emp_Register', 'AttData.EmpID', '=', 'Emp_Register.EmployeeID')
                ->where('Emp_Register.Status', '!=', 'Terminated')
                ->where('Emp_Register.Status', '!=', 'Resigned')
                ->where('AttData.ATTDate', '=', $updateDate)
                ->whereNull('AttData.AttStatus')
                ->where('AttData.OpeningTime', '<', $currentTime)
                ->where('AttData.CompanyID', '=', $companyId)
                ->count();
//            dd($result);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }
    }
    public function getShiftAwaitingCount($companyId, $updateDate)
    {
        try {
            $currentTime = date('H:i:s');
            return DB::connection('sqlsrv2')
                ->table('AttData')
                ->join('Emp_Register', 'AttData.EmpID', '=', 'Emp_Register.EmployeeID')
                ->where('Emp_Register.Status', '!=', 'Terminated')
                ->where('Emp_Register.Status', '!=', 'Resigned')
                ->where('AttData.ATTDate', '=', $updateDate)
                //->whereIn('AttData.AttStatus', [null, ''])
                ->where(function ($query) use ($currentTime) {
                    $query->where(function ($subquery) use ($currentTime) {
                        $subquery
                            ->where('AttData.OpeningTime', '>', $currentTime)
                            ->where('AttData.ClosingTime', '<', $currentTime);
                    });
                })
                ->where('AttData.CompanyID', '=', $companyId)
                ->count();
//            dd($result);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }
    }

    public function getMaxAttendanceCount($companyId, $updateDate)
    {
        try {
            return DB::connection('sqlsrv2')
                ->table('AttData')
                ->join('Emp_Register', 'AttData.EmpID', '=', 'Emp_Register.EmployeeID')
                ->where('Emp_Register.Status', '!=', 'Terminated')
                ->where('Emp_Register.Status', '!=', 'Resigned')
                ->where('AttData.CompanyID', '=', $companyId)
                ->where('AttData.ATTDate', '=', $updateDate)
                ->count();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }
    }

    public function attendance_detail($request)
    {
        try {
            $update_date = date("Y-m-d");

            return DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('Emp_Profile.Name', 'like', $request->keyword2 . '%')->where('AttData.CompanyID', '=', company_id())->where('AttData.ATTDate', '=', date("Y-m-d"))->orWhere('Emp_Register.EmployeeCode', 'like', '%' . $request->keyword2 . '%')->where('AttData.CompanyID', '=', company_id())->where('AttData.ATTDate', '=', $update_date)->paginate(20);

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }
    }

    public function getLastUid($deviceId)
    {
        try {
            return DB::connection('sqlsrv2')->table('Machine_Attendance')->where('DeviceID', '=', $deviceId)->orderBy('uid', 'desc')->where('CompanyID', '=', company_id())->first();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }
    }

    public function FindMachine($id)
    {
        try {
            return DB::connection('sqlsrv2')->table('Devices')->where('Id', $id)->where('CompanyID', company_id())->first();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }
    }

    public function executeStoredProcedures()
    {
        try {
            return DB::connection('sqlsrv2')->select("SET NOCOUNT ON; EXEC [dbo].[Insert_Into_Attdatas]; EXEC [dbo].[Add_PunchTime_Attdata]; EXEC [dbo].[AttendanceStatus]");

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Leave Count: " . $e->getMessage());
        }
    }
}
