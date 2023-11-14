<?php

namespace App\Services\HRMS\LeavesDetails;

use App\Contracts\Repository\HRMS\LeavesDetails\SubmitLeavesRepositoryInterface;
use App\Contracts\Services\HRMS\LeavesDetails\SubmitLeavesServiceInterface;
use Illuminate\Http\Request;
use App\Exceptions\ErrorException;
use App\Repositories\HRMS\LeavesDetails\SubmitLeavesRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;

class SubmitLeavesService implements SubmitLeavesServiceInterface
{
    protected $SubmitLeavesRepositoryInterface;

    public function __construct(SubmitLeavesRepositoryInterface $SubmitLeavesRepositoryInterface)
    {
        $this->SubmitLeavesRepositoryInterface = $SubmitLeavesRepositoryInterface;
    }

    public function submitLeave($emp_emp_id, $selecteddays, $emp_date_from, $emp_date_to, $emp_reason, $emp_leave)
    {
        try {
            $full_name = $this->SubmitLeavesRepositoryInterface->getFullName($emp_emp_id);

            $emp_female = $this->SubmitLeavesRepositoryInterface->isFemaleEmployee($emp_emp_id);
            if (!$emp_female && $emp_leave == 'Maternity') {
                return $full_name . ' is not eligible for Maternity Leaves. Please check gander in his/her profile!';
            }
            //count days of multiple days leave
            $days = ($selecteddays == "Multiple Days")
                ? floor((strtotime($emp_date_to) - strtotime($emp_date_from)) / (60 * 60 * 24)) + 1
                : (($emp_date_to = $emp_date_from) && 1);

            $existingRequisition = $this->SubmitLeavesRepositoryInterface->checkExistingRequisition($emp_emp_id, $emp_leave, $emp_date_from, $emp_date_to);
            if ($existingRequisition) {
                $data = "User has already applied for " . $existingRequisition . " leaves during the same date range!";
                return request()->json(200, $data);

            }
            $pl_status = "P";
            $isComparable = DB::connection('sqlsrv2')
                ->table('EmpLeave')
                ->where('CompanyID', '=', company_id())
                ->where('LeaveType', '=', $emp_leave)
                ->exists();
            if($isComparable){
                //getting how many reamianing leaves left
                $rem_levs = $this->SubmitLeavesRepositoryInterface->getRemainingLeaves(date("Y"), $emp_emp_id, $emp_leave);
                if ($days > $rem_levs) {
                    return request()->json(200, $full_name . ' do not have ' . $days . ' remaining ' . $emp_leave . ' leaves!');
                }
            }

            //inserting applied leves to leaves requisition tabel
           $arr =   $this->SubmitLeavesRepositoryInterface->insertLeaveRequisition($emp_emp_id, $emp_leave, $emp_date_from, $emp_date_to, $days, $emp_reason, $pl_status);
            // $arr = "Leave applied";
            $update_date = date("Y-m-d h:i:s A");
            //insert in activity log tabel
            insertLog('Leave Applied', $emp_leave . ' leave of ' . $full_name . ' applied');
            return request()->json(200, $arr);

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error submitting leave: " . $e->getMessage());
        }
    }


    public function submitEmpLeaves($lv_emp_id, $lv_type, $lv_nmbr)
    {


        $exist = $this->SubmitLeavesRepositoryInterface->checkLeaveExistence($lv_emp_id, $lv_type, date("Y"));

        $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Register')
            ->where('EmployeeID', '=', $lv_emp_id)
            ->get();

        foreach ($full_name_arr as $full_name_arr1) {

        }

        if ($exist) {
            $this->SubmitLeavesRepositoryInterface->updateLeave($lv_emp_id, $lv_type, $lv_nmbr, date("Y-m-d h:i:s A"));
            $action = 'updated';
        } else {
            $this->SubmitLeavesRepositoryInterface->addLeave($lv_nmbr, $lv_emp_id, $lv_type, date("Y-m-d h:i:s A"));
            $action = 'added';
        }

        $this->SubmitLeavesRepositoryInterface->insertActivityLog('Employee Leave ' . $action, $lv_type . ' Leave of ' . $full_name_arr1->EmployeeCode . ' ' . $action, date("Y-m-d h:i:s A"));

        return 'Employee leave ' . $action;


    }


}
