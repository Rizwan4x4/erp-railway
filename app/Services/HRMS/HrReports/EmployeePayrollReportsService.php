<?php

namespace App\Services\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeePayrollReportsRepositoryInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeePayrollReportsServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\HrReports\EmployeePayrollReportsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;
class EmployeePayrollReportsService implements EmployeePayrollReportsServiceInterface
{
    protected $EmployeePayrollReportsRepositoryInterface;

    public function __construct(EmployeePayrollReportsRepositoryInterface $EmployeePayrollReportsRepositoryInterface)
    {
        $this->EmployeePayrollReportsRepositoryInterface = $EmployeePayrollReportsRepositoryInterface;
    }

    public function getEmployCashDetail($emp_department, $emp_username, $sessionName, $status)
    {
        $query = $this->EmployeePayrollReportsRepositoryInterface->getEmployCashDetail($sessionName);

        if ($status == 'Unpaid') {
            $query->whereNull('Payroll_Distribution.ReceivedThrough');
        } elseif ($status == 'Paid') {
            $query->whereNotNull('Payroll_Distribution.ReceivedThrough');
            if ($emp_username != 'All') {
                $query->where('Payroll_Distribution.ReceivedThrough', 'like', '%' . $emp_username . '%');
            }
        }

        if ($emp_department != 'All') {
            $query->where('Payroll_Distribution.Department', 'like', '%' . $emp_department . '%');
        }

        $result = $query->get();

        return $result;
    }


    public function getEmployeeCashSum($emp_department, $emp_username, $sessionName, $status)
    {
        if ($emp_department == 'All') {
            $emp_department = '';
        }

        if ($emp_username == 'All') {
            $emp_username = '';
        }

       return $this->EmployeePayrollReportsRepositoryInterface->getEmployeeCashSum($emp_department, $emp_username, $sessionName, $status);

     
    }

    public function getEmployeeBankSum($emp_department, $emp_username, $sessionName, $status)
    {
        if ($status == 'Unpaid' && $emp_department == 'All' && $emp_username == 'All') {
          return $this->EmployeePayrollReportsRepositoryInterface->getEmployeeBankSum($emp_department, $emp_username, $sessionName, $status);
          
        }

        if ($status == 'Paid' && $emp_department == 'All' && $emp_username == 'All') {
           return $this->EmployeePayrollReportsRepositoryInterface->getEmployeeBankSum($emp_department, $emp_username, $sessionName, $status);
          
        }

        if ($status == 'All' && $emp_department == 'All' && $emp_username == 'All') {
            return $this->EmployeePayrollReportsRepositoryInterface->getEmployeeBankSum($emp_department, $emp_username, $sessionName, $status);
        }

        return $this->EmployeePayrollReportsRepositoryInterface->getEmployeeBankSum($emp_department, $emp_username, $sessionName, $status);
       
    }
}