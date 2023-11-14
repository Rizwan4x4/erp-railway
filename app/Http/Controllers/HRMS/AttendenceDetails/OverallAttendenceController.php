<?php

namespace App\Http\Controllers\HRMS\AttendenceDetails;

use App\Contracts\Repository\HRMS\AttendenceDetails\OverallAttendenceRepositoryInterface;
use App\Contracts\Services\HRMS\AttendenceDetails\OverallAttendenceServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Session;
use Illuminate\Support\Facades\Log;

use App\Exceptions\ErrorException;



class OverallAttendenceController extends Controller
{
    use CommonTrait;
    protected $OverallAttendenceRepositoryInterface;
    protected $OverallAttendenceServiceInterface;

    public function __construct(OverallAttendenceRepositoryInterface $OverallAttendenceRepositoryInterface, OverallAttendenceServiceInterface $OverallAttendenceServiceInterface)
    {
        $this->OverallAttendenceRepositoryInterface = $OverallAttendenceRepositoryInterface;
        $this->OverallAttendenceServiceInterface = $OverallAttendenceServiceInterface;
    }



    public function this_user_attendence($id)
    {
        try {
            return $this->sendSuccess('user attendence fetch succuss', $this->OverallAttendenceServiceInterface->getUserAttendanceData($id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function getattendance($department, $location, $designation, $start, $close, $code)
    {
        try {
        $company_id = Session::get('company_id');
        $emp_code = Session::get('employee_id');

       return $this->sendSuccess('get attendence success',$this->OverallAttendenceServiceInterface->getattendance($company_id, $emp_code, $start, $close, $department, $designation, $location, $code));

    } catch (\Exception $e) {


        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
    }

    public function update_ind_att(Request $request)
    {
        try {

        return $this->sendSuccess('update indvidual attendence success',$this->OverallAttendenceServiceInterface->update_ind_att($request));


    } catch (\Exception $e) {


        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
    }
}
