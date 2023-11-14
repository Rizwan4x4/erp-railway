<?php

namespace App\Http\Controllers\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeSalaryAndStipendReportsRepositoryInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeSalaryAndStipendReportsServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Session;
use Illuminate\Support\Facades\Log;



class EmployeeSalaryAndStipendReportsController extends Controller
{
    protected $EmployeeSalaryAndStipendReportsRepositoryInterface;
    protected $EmployeeSalaryAndStipendReportsServiceInterface;

    public function __construct(EmployeeSalaryAndStipendReportsRepositoryInterface $EmployeeSalaryAndStipendReportsRepositoryInterface, EmployeeSalaryAndStipendReportsServiceInterface $EmployeeSalaryAndStipendReportsServiceInterface)
    {
        $this->EmployeeSalaryAndStipendReportsRepositoryInterface = $EmployeeSalaryAndStipendReportsRepositoryInterface;
        $this->EmployeeSalaryAndStipendReportsServiceInterface = $EmployeeSalaryAndStipendReportsServiceInterface;
    }
    public function salary_detail_deptreport()
    {
       return $this->EmployeeSalaryAndStipendReportsServiceInterface->generateDepartmentReport();
    }
}