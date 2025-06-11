<?php

namespace App\Http\Controllers\HRMS\AttendenceDetails;

use App\Contracts\Repository\HRMS\AttendenceDetails\LiveAttendenceRepositoryInterface;
use App\Contracts\Services\HRMS\AttendenceDetails\LiveAttendenceServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Session;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ErrorException;


class LiveAttendenceController extends Controller
{
    use CommonTrait;

    protected $LiveAttendenceRepositoryInterface;
    protected $LiveAttendenceServiceInterface;

    public function __construct(LiveAttendenceRepositoryInterface $LiveAttendenceRepositoryInterface, LiveAttendenceServiceInterface $LiveAttendenceServiceInterface)
    {
        $this->LiveAttendenceRepositoryInterface = $LiveAttendenceRepositoryInterface;
        $this->LiveAttendenceServiceInterface = $LiveAttendenceServiceInterface;
    }

    public function get_count_leave()
    {
        try {
            return $this->sendSuccess('get count leaves success', $this->LiveAttendenceRepositoryInterface->get_count_leave());
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

   public function get_machines()
   {
       try {
           return $this->sendSuccess('get machines success', $this->LiveAttendenceRepositoryInterface->get_machines());
       } catch (\Exception $e) {


           Log::error('Unhandled Exception: ' . $e->getMessage());
           return $this->sendError($e->getMessage(), $e->getCode());
       }
   }

    public function count_today_attendance()
    {
        try {
            return $this->sendSuccess('get count attendence today success', $this->LiveAttendenceServiceInterface->countTodayAttendance(company_id(), short_date()));
        } catch (\Exception $e) {


            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function attendance_detail(Request $request)
    {
        try {
            return $this->sendSuccess('attendence details of  employee success', $this->LiveAttendenceRepositoryInterface->attendance_detail($request));
        } catch (\Exception $e) {


            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function pull_m_attendance($id)
    {
        try {
            return $this->LiveAttendenceServiceInterface->pullMachineAttendance($id);

        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
}
