<?php

namespace App\Services\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeOverviewRepositoryInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeOverviewServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\HrReports\EmployeeOverViewRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;
class EmployeeOverviewService implements EmployeeOverviewServiceInterface
{
    protected $EmployeeOverviewRepositoryInterface;

    public function __construct(EmployeeOverviewRepositoryInterface $EmployeeOverviewRepositoryInterface)
    {
        $this->EmployeeOverviewRepositoryInterface = $EmployeeOverviewRepositoryInterface;
    }

    public function getemploydetail($emp_department, $emp_location, $emp_designation, $emp_emp_id, $emp_type, $emp_status)
    {
        if ($emp_department == 'All' && $emp_location == 'All' && $emp_designation == 'All' && $emp_emp_id == 'All' && $emp_type == 'All' && $emp_status == 'All') {
            return $this->EmployeeOverviewRepositoryInterface->getEmployeeDetails('', '', '', '', '', '');
        } else {
            $emp_department = ($emp_department == 'All') ? '' : $emp_department;
            $emp_designation = ($emp_designation == 'All') ? '' : $emp_designation;
            $emp_location = ($emp_location == 'All') ? '' : $emp_location;
            $emp_emp_id = ($emp_emp_id == 'All') ? '' : $emp_emp_id;
            $emp_type = ($emp_type == 'All') ? '' : $emp_type;
            $emp_status = ($emp_status == 'All') ? '' : $emp_status;

            return $this->EmployeeOverviewRepositoryInterface->getEmployeeDetails($emp_department, $emp_location, $emp_designation, $emp_emp_id, $emp_type, $emp_status);
        }
    }




public function gethireemploy($hire_department, $hire_location, $hire_designation, $hire_emp_id, $hire_start_date, $hire_end_date)
{
    if ($hire_department == 'All' && $hire_location == 'All' && $hire_designation == 'All' && $hire_emp_id == 'All' && $hire_start_date != '' && $hire_end_date != '') {
        return $this->EmployeeOverviewRepositoryInterface->getHireEmployees('', '', '', '', $hire_start_date, $hire_end_date);
    } else {
        $hire_department = ($hire_department == 'All') ? '' : $hire_department;
        $hire_designation = ($hire_designation == 'All') ? '' : $hire_designation;
        $hire_location = ($hire_location == 'All') ? '' : $hire_location;
        $hire_emp_id = ($hire_emp_id == 'All') ? '' : $hire_emp_id;

        return $this->EmployeeOverviewRepositoryInterface->getHireEmployees($hire_department, $hire_location, $hire_designation, $hire_emp_id, $hire_start_date, $hire_end_date);
    }
}


public function gethireemploycount($hire_department, $hire_location, $hire_designation, $hire_emp_id, $hire_start_date, $hire_end_date)
{
    if ($hire_department == 'All' && $hire_location == 'All' && $hire_designation == 'All' && $hire_emp_id == 'All' && $hire_start_date != '' && $hire_end_date != '') {
        return $this->EmployeeOverviewRepositoryInterface->getHireEmployeesCount('', '', '', '', $hire_start_date, $hire_end_date);
    } else {
        $hire_department = ($hire_department == 'All') ? '' : $hire_department;
        $hire_designation = ($hire_designation == 'All') ? '' : $hire_designation;
        $hire_location = ($hire_location == 'All') ? '' : $hire_location;
        $hire_emp_id = ($hire_emp_id == 'All') ? '' : $hire_emp_id;

        return $this->EmployeeOverviewRepositoryInterface->getHireEmployeesCount($hire_department, $hire_location, $hire_designation, $hire_emp_id, $hire_start_date, $hire_end_date);
    }
}

}
