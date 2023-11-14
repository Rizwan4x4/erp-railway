<?php

namespace App\Services\HRMS\AttendenceDetails;

use App\Contracts\Repository\HRMS\AttendenceDetails\LiveAttendenceRepositoryInterface;
use App\Contracts\Services\HRMS\AttendenceDetails\LiveAttendenceServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\AttendenceDetails\LiveAttendenceRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;
use maliklibs\Zkteco\Lib\ZKTeco;

class LiveAttendenceService implements LiveAttendenceServiceInterface
{
    protected $LiveAttendenceRepositoryInterface;

    public function __construct(LiveAttendenceRepositoryInterface $LiveAttendenceRepositoryInterface)
    {
        $this->LiveAttendenceRepositoryInterface = $LiveAttendenceRepositoryInterface;
    }

    public function countTodayAttendance($companyId, $updateDate)
    {
        try {
            $present = $this->LiveAttendenceRepositoryInterface->getAttendanceCount($companyId, $updateDate, 'P');
            $absent = $this->LiveAttendenceRepositoryInterface->getAttendanceCount($companyId, $updateDate, 'A');
            $late = $this->LiveAttendenceRepositoryInterface->getAttendanceCount($companyId, $updateDate, 'L');
            $leave = $this->LiveAttendenceRepositoryInterface->getAttendanceCount($companyId, $updateDate, 'LE');
            $holiday = $this->LiveAttendenceRepositoryInterface->getAttendanceCount($companyId, $updateDate, 'H');
            $unMarked = $this->LiveAttendenceRepositoryInterface->getUnMarkedCount($companyId, $updateDate);
            $shiftAwaiting = $this->LiveAttendenceRepositoryInterface->getShiftAwaitingCount($companyId, $updateDate);
            $max = $this->LiveAttendenceRepositoryInterface->getMaxAttendanceCount($companyId, $updateDate);
//dd($shiftAwaiting);
            $result = [
                'pres' => $present,
                'abse' => $absent,
                'late' => $late,
                'leave' => $leave,
                'UnMarked' => $unMarked,
                'shiftAwaiting' => $shiftAwaiting,
                'holiday' => $holiday,
                'max' => $max,
            ];

            return $result;
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }

    public function pullMachineAttendance($id)
    {
        try {
            $findMachine = DB::connection('sqlsrv2')->table('Devices')->where('Id', '=', $id)->where('CompanyID', '=', company_id())->first();
            $zk = new ZKTeco($findMachine->DeviceIP, 4370, null, '../storage/logs/laravel.log');
            $connect = $zk->connect();
//         dd($connect);
            if ($connect == 1) {
                $deviceAttendance = $zk->getAttendance();
//                dd($deviceAttendance);
                $lastUid = $this->LiveAttendenceRepositoryInterface->getLastUid($id);
                $data = [];
                foreach ($deviceAttendance as $deviceAttendance1) {
//                    dd('fetched');
                    if ($deviceAttendance1['uid'] > $lastUid->uid) {
//                        dd('ready to insert');
                        $data[] = [
                            'CompanyID' => company_id(),
                            'uid' => $deviceAttendance1['uid'],
                            'EmpCode' => $deviceAttendance1['id'],
                            'state' => $deviceAttendance1['state'],
                            'AttDate' => $deviceAttendance1['timestamp'],
                            'type' => $deviceAttendance1['type'],
                            'UploadedOn' => long_date(),
                            'DeviceID' => $id,
                        ];
                    }
                }
//                dd($data);
                // Check if the $data array is not empty before inserting into the database
                if (!empty($data)) {
                    DB::connection('sqlsrv2')->table('Machine_Attendance')->insert($data);
                    $runSP = $this->LiveAttendenceRepositoryInterface->executeStoredProcedures();
                    if ($runSP) {
//                        $zk->clearAttendance();
                    }
                }
                $zk->disconnect();
                return 'attendance updated';
            } else {
                return 'Not connected';
            }
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }
}
