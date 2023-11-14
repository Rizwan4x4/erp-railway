<?php

namespace App\Services\HRMS\HrReports;

use App\Contracts\Repository\HRMS\HrReports\EmployeeLeaveReportsRepositoryInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeLeaveReportsServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\HrReports\EmployeeLeaveReportsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;
class EmployeeLeaveReportsService implements EmployeeLeaveReportsServiceInterface
{
    protected $EmployeeLeaveReportsRepositoryInterface;

    public function __construct(EmployeeLeaveReportsRepositoryInterface $EmployeeLeaveReportsRepositoryInterface)
    {
        $this->EmployeeLeaveReportsRepositoryInterface = $EmployeeLeaveReportsRepositoryInterface;
    }


}