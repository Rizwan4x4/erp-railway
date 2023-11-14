<?php
namespace App\Contracts\Services\HRMS\AttendenceDetails;

interface LiveAttendenceServiceInterface
{  
    public function countTodayAttendance($companyId, $updateDate);
    public function pullMachineAttendance($id);
}
