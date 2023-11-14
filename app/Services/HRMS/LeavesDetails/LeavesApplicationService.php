<?php

namespace App\Services\HRMS\LeavesDetails;

use App\Contracts\Repository\HRMS\LeavesDetails\LeavesApplicationRepositoryInterface;
use App\Contracts\Services\HRMS\LeavesDetails\LeavesApplicationServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\LeavesDetails\LeavesApplicationRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;

class LeavesApplicationService implements LeavesApplicationServiceInterface
{
    protected $LeavesApplicationRepositoryInterface;

    public function __construct(LeavesApplicationRepositoryInterface $LeavesApplicationRepositoryInterface)
    {
        $this->LeavesApplicationRepositoryInterface = $LeavesApplicationRepositoryInterface;
    }

    public function update_leave_sts($request)
    {
        try {
            $lv_app_id = $request->get('lv_app_id');
            $lv_status = $request->get('lv_status');
            $who = $request->get('who');

            $statusMapping = [
                'Approved' => 'A',
                'Rejected' => 'R',
                'Pending' => 'P',
            ];
            $pl_Status = $statusMapping[$lv_status] ?? '';
            $leaveDetail = DB::connection('sqlsrv2')
                ->table('leave_Requisition')
                ->where('LeaveRQID', $lv_app_id)
                ->where('CompanyID', company_id())->first();
            $us_lv_type = $leaveDetail->Leavetype;
            $emp_emp_id = $leaveDetail->EmployeeID;
            $us_lv_number = $leaveDetail->NoOfDays;
            if ($lv_status == "Approved") {
                $rem_levs = $this->LeavesApplicationRepositoryInterface->GetEmpLeaveRemaining($us_lv_type, $emp_emp_id);
                $rem_an_levs = $rem_levs - $us_lv_number;
                if ($rem_an_levs < 1 && $us_lv_type != 'Leave Without Pay' && $us_lv_type != 'CPL' && $us_lv_type != 'Special Approval') {
                    return "Employee don't have remaining " . $us_lv_number . " " . $us_lv_type . " leaves!";
                }
                $this->LeavesApplicationRepositoryInterface->updateEmpLeaveRemaining($rem_an_levs, $us_lv_type, $emp_emp_id);

                $leaveData = DB::connection('sqlsrv2')
                    ->table('leave_Requisition')
                    ->where('LeaveRQID', $lv_app_id)
                    ->where('CompanyID', company_id())->first();
                if ($leaveData->StartDate < short_date()) {
                    $startDate = $leaveData->StartDate;
                    $endDate = $leaveData->NoOfDays == 1 ? $startDate : $leaveData->EndDate;
                    $query = DB::connection('sqlsrv2')
                        ->table('AttData')
                        ->whereBetween('ATTDate', [$startDate, $endDate])
                        ->where('EmpID', $leaveData->EmployeeID)
                        ->where('CompanyID', company_id());
                    $query->update([
                        'AttStatus' => 'LE',
                    ]);
                }
            }

            if ($who == "Manager") {
                DB::connection('sqlsrv2')->update('update leave_Requisition set ManagerApproval=?, PendingLeaveStatus=? where LeaveRQID=? AND CompanyID=?', [$lv_status, $pl_Status, $lv_app_id, company_id()]);
                $data = "Status updated";
            }
            else if ($who == "HR") {
                DB::connection('sqlsrv2')->update('update leave_Requisition set HRApproval=?, PendingLeaveStatus=? where LeaveRQID=? AND CompanyID=?', [$lv_status, $pl_Status, $lv_app_id, company_id()]);
                $data = "Status updated";
            }
//dd('okg');
            $full_name = DB::connection('sqlsrv2')->table('Emp_Profile')->where('EmployeeID', '=', $emp_emp_id)->value('Name');
            insertLog('Leave Status Changed', 'Status of ' . $full_name . ' leave of id :' . $leaveDetail->LeaveRQID . ' has been' . $lv_status);

            return $data;
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }

    }

    public function filter_leaves_requisitions($leave_type, $department, $location, $designation, $status, $ManagerStatus, $HRStatus)
    {

        try {
            $leave_type = ($leave_type === 'All' || $leave_type === null) ? '' : $leave_type;
            $department = ($department === 'All' || $department === null) ? '' : $department;
            $designation = ($designation === 'All' || $designation === null) ? '' : $designation;
            $location = ($location === 'All' || $location === null) ? '' : $location;


            switch ($status) {
                case 'All':
                    $status = '';
                    break;
                case 'Pending':
                    $status = 'P';
                    break;
                case 'Rejected':
                    $status = 'R';
                    break;
                case 'Approved':
                    $status = 'A';
                    break;
            }

            $ManagerStatus = $ManagerStatus == 'All' ? '' : $ManagerStatus;
            $HRStatus = $HRStatus == 'All' ? '' : $HRStatus;

            $ids = ['P', 'A', 'R'];
            return $this->LeavesApplicationRepositoryInterface->filterLeavesRequisitions($leave_type, $department, $location, $designation, $status, $ManagerStatus, $HRStatus);
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }
}
