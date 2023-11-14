<?php
namespace App\Contracts\Repository\HRMS\AttendenceDetails;
interface LiveAttendenceRepositoryInterface {
    public function get_count_leave();
//    public function get_machines();

    public function getAttendanceCount($companyId, $updateDate, $status);
    public function getShiftAwaitingCount($companyId, $updateDate);
    public function getUnMarkedCount($companyId, $updateDate);
    public function getMaxAttendanceCount($companyId, $updateDate);

    public function getLastUid($deviceId);
    public function FindMachine($id);
    public function executeStoredProcedures();
}
