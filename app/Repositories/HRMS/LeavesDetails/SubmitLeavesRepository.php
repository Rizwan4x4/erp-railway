<?php

namespace App\Repositories\HRMS\LeavesDetails;

use App\Contracts\Repository\HRMS\LeavesDetails\SubmitLeavesRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Session;
class SubmitLeavesRepository implements SubmitLeavesRepositoryInterface
{



    public function getFullName($emp_id)
    {
        // Implementation for getting the full name based on employee ID
        try{
            return DB::connection('sqlsrv2')
            ->table('Emp_Profile')
            ->where('EmployeeID', $emp_id)
            ->where('CompanyID', company_id())
            ->pluck('Name')->first();
                    } catch (QueryException $e) {
                // Throw a custom exception with the original message
                throw new ErrorException("Error getting full name : " . $e->getMessage());
            }
    }
    public function isFemaleEmployee($emp_emp_id)
    {
        // Implementation for checking if the employee is female based on employee ID
        // Example implementation using DB query
        try{
        return DB::connection('sqlsrv2')
            ->table('Emp_Profile')
            ->where('CompanyID', '=', company_id())
            ->where('EmployeeID', '=', $emp_emp_id)
            ->where('Gender', '=', 'Female')
            ->exists();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting female employe: " . $e->getMessage());
        }
    }

    public function getRemainingLeaves($this_year, $emp_emp_id, $emp_leave)
    {
        // Implementation for getting the remaining leaves for the specified employee and leave type
        // Example implementation using DB query
        try{

        return DB::connection('sqlsrv2')
            ->table('EmpLeave')
            ->where('CompanyID', '=', company_id())
            ->where('CreatedOn', 'like', '%' . $this_year . '%')
            ->where('EmployeeID', '=', $emp_emp_id)
            ->where('LeaveType', '=', $emp_leave)
            ->sum('RemainingLeave');
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting remaining leaves: " . $e->getMessage());
        }
    }
    public function insertLeaveRequisition($emp_emp_id, $emp_leave, $emp_date_from, $emp_date_to, $days, $emp_reason, $pl_status)
    {
        // Implementation for inserting leave requisition into the database
        // Example implementation using DB query

        try{
      $result = DB::connection('sqlsrv2')
            ->table('leave_Requisition')
            ->insertGetId([
                'EmployeeID' => $emp_emp_id,
                'Leavetype' => $emp_leave,
                'StartDate' => $emp_date_from,
                'EndDate' => $emp_date_to,
                'NoOfDays' => $days,
                'Reason' => $emp_reason,
                'AppliedBy' => username(),
                'PendingLeaveStatus' => $pl_status,
                'CompanyID' => company_id(),
            ]);
// dd($result);
        // Retrieve the inserted data by querying the table with the ID
        $insertedData = DB::connection('sqlsrv2')
        ->table('leave_Requisition')
        ->join('Emp_Profile', 'Emp_Profile.EmployeeID', '=', 'leave_Requisition.EmployeeID')
        ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
        ->where('LeaveRQID', $result)
        ->select('Emp_Profile.Name','Emp_Profile.Photo', 'leave_Requisition.*', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode','Emp_Register.Department')
        ->first();
    
    // Now $insertedData contains the fields you requested from both tables
    

        return $insertedData;
            } catch (QueryException $e) {
                // Throw a custom exception with the original message
                throw new ErrorException("Error insert Leaves requisition : " . $e->getMessage());
            }

            }



            public function insertActivityLog( $eventStatus, $description, $activityTime)
            {
                // Implementation for inserting activity log into the database

        try{
        return DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)",
                [company_id(),username(), UserFullName(), $eventStatus, $description, $activityTime]);
            } catch (QueryException $e) {
                // Throw a custom exception with the original message
                throw new ErrorException("Error getting insert activitylog: " . $e->getMessage());
            }

            }
            public function checkLeaveExistence( $lv_emp_id, $lv_type, $this_year)
            {
                    // Implementation for checking if leaves exist in database
                try{
                return DB::connection('sqlsrv2')->table('EmpLeave')
                    ->where('CompanyID', '=', company_id())
                    ->where('CreatedOn', 'like', '%' . $this_year . '%')
                    ->where('EmployeeID', '=', $lv_emp_id)
                    ->where('LeaveType', '=', $lv_type)
                    ->exists();
                 } catch (QueryException $e) {
                        // Throw a custom exception with the original message
                        throw new ErrorException("Error getting levae: " . $e->getMessage());
                    }
            }

            public function updateLeave( $lv_emp_id, $lv_type, $lv_nmbr, $update_date)
            {
                    // Implementation for update leave in the database
                try{
                $result = DB::connection('sqlsrv2')->table('EmpLeave')
                    ->select('TotalLeave', 'RemainingLeave')
                    ->where('CompanyID', '=', company_id())
                    ->where('EmployeeID', '=', $lv_emp_id)
                    ->where('LeaveType', '=', $lv_type)
                    ->get();

                foreach ($result as $result1) {
                    // ...
                }
                // remove this

                $lv_number1 = $result1->TotalLeave;
                $rem_lvs = $result1->RemainingLeave;
                $lv_number2 = $lv_nmbr + $lv_number1;
                $rem = $rem_lvs + $lv_nmbr;
                // $rem = min($rem_lvs + $lv_nmbr, $lv_number2);
                DB::connection('sqlsrv2')->update(
                    'update EmpLeave set TotalLeave=?, RemainingLeave=?, UpdatedBy=?, UpdatedOn=? where EmployeeID=? AND LeaveType=? AND CompanyID=?',
                    [$lv_number2, $rem, username(), $update_date, $lv_emp_id, $lv_type, company_id()]
                );
            } catch (QueryException $e) {
                // Throw a custom exception with the original message
                throw new ErrorException("Error updating the leaves: " . $e->getMessage());
            }
            }

            public function addLeave($lv_nmbr, $lv_emp_id, $lv_type, $update_date)
            {
                    // Implementation fadding leaves to the Employee leaves tabel
                try{
                DB::connection('sqlsrv2')->insert(
                    "INSERT INTO EmpLeave(RemainingLeave, EmployeeID, LeaveType, TotalLeave, CreatedBy, CreatedOn, CompanyID) values (?,?,?,?,?,?,?)",
                    [$lv_nmbr, $lv_emp_id, $lv_type, $lv_nmbr, username(), $update_date, company_id()]
                );
            } catch (QueryException $e) {
                // Throw a custom exception with the original message
                throw new ErrorException("Error getting insert activitylog: " . $e->getMessage());
            }
            }


            public function checkExistingRequisition($emp_emp_id, $emp_leave, $emp_date_from, $emp_date_to)
{

       $leaveExists =  DB::connection('sqlsrv2')
        ->table('leave_Requisition')
        ->where('EmployeeID', '=', $emp_emp_id)
//        ->where('LeaveType', '=', $emp_leave)
        ->where('PendingLeaveStatus', '=', 'P')
        ->where(function ($query) use ($emp_date_from, $emp_date_to) {
            $query->where(function ($innerQuery) use ($emp_date_from, $emp_date_to) {
                $innerQuery->where('StartDate', '<=', $emp_date_to)
                    ->where('EndDate', '>=', $emp_date_from);
            })
            ->orWhere(function ($innerQuery) use ($emp_date_from, $emp_date_to) {
                $innerQuery->where('StartDate', '>=', $emp_date_from)
                    ->where('EndDate', '<=', $emp_date_to);
            });
        })
        ->value('LeaveType');
//       dd($leaveExists);
       return $leaveExists;
    }

}
