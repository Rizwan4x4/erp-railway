<?php

namespace App\Services\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeAttendenceRepositoryInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeAttendenceServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\HrReports\EmployeeAttendenceRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;
class EmployeeAttendenceService implements EmployeeAttendenceServiceInterface
{
    protected $EmployeeAttendenceRepositoryInterface;

    public function __construct(EmployeeAttendenceRepositoryInterface $EmployeeAttendenceRepositoryInterface)
    {
        $this->EmployeeAttendenceRepositoryInterface = $EmployeeAttendenceRepositoryInterface;
    }

    public function getattendance_report($department, $location, $designation, $emp_id, $start, $close)
    {
        $company_id = Session::get('company_id');
        $username = Session::get('username');
        $update_date = date("Y-m-d h:i:s A");
    
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?, ?, ?, ?, ?, ?)", [$company_id, $username, $username, 'Attendance report printed', 'Attendance report printed', $update_date]);
    
        if ($designation == 'All' && $department == 'All' && $location == 'All' && $emp_id == 'All') {
            return $this->EmployeeAttendenceRepositoryInterface->getAttendanceReport('', '', '', '', $start, $close);
        } else {
            $department = ($department == 'All') ? '' : $department;
            $designation = ($designation == 'All') ? '' : $designation;
            $location = ($location == 'All') ? '' : $location;
            $emp_id = ($emp_id == 'All') ? '' : $emp_id;
    
            return $this->EmployeeAttendenceRepositoryInterface->getAttendanceReport($department, $location, $designation, $emp_id, $start, $close);
        }
    }
    
    public function getAttendanceCount( $employeeId)
    {
      

        return $this->EmployeeAttendenceRepositoryInterface->getAttendanceCount($employeeId);
    }


public function getattendance_summary()
{
      $find_session = $this->EmployeeAttendenceRepositoryInterface->findSession();

      if ($find_session) {
        $startDate = date('Y-m-d', strtotime($find_session->StartDate));
        $endDate = date('Y-m-d', strtotime($find_session->EndDate));
    
        $rangArray = array_map(function ($date) {
          return date('Y-m-d H:i:s', $date);
      }, range(strtotime($startDate), strtotime($endDate), 86400));
    }
 
    $count_range = count($rangArray);

    $result =   $this->EmployeeAttendenceRepositoryInterface->getMonthlyAttendanceData($startDate, $endDate);

    $d = '';
    foreach ($result as $result1) {
      $b = '<tr><td>' . $result1->Name . '</td>' .
          '<td>' . $result1->Designation . '</td>' .
          '<td>' . $result1->Department . '</td>';
  
      foreach ($rangArray as $date) {
          $property = date('Y-m-d', strtotime($date));
          $b .= '<td>' . $result1->{$property} ?? '' . '</td>';
      }
    

        $b .= '</tr>';
        $d .= $b;
    }

    return response()->json($d, 200);
}
public function get_payroll_att_detail()
{

    $find_session = $this->EmployeeAttendenceRepositoryInterface->findSession();

    if ($find_session) {
      $startDate = date('Y-m-d', strtotime($find_session->StartDate));
      $endDate = date('Y-m-d', strtotime($find_session->EndDate));


    return  $this->EmployeeAttendenceRepositoryInterface->get_payroll_att_detail_report($startDate,$endDate);
 
      }
}
}