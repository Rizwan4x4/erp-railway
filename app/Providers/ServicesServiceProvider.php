<?php

namespace App\Providers;

use App\Contracts\Repository\UserRepositoryInterface;
use App\Contracts\Services\Procurement\Inventory\StockDetailServiceInterface;
use App\Contracts\Services\HRMS\WarningDetails\WarningDetailsServiceInterface;
use App\Contracts\Services\HRMS\WarningDetails\CreateWarningServiceInterface;
use App\Contracts\Services\HRMS\LeavesDetails\LeavesDashboardServiceInterface;
use App\Contracts\Services\HRMS\LeavesDetails\SubmitLeavesServiceInterface;
use App\Contracts\Services\HRMS\LeavesDetails\LeavesApplicationServiceInterface;
use App\Contracts\Services\HRMS\AttendenceDetails\LiveAttendenceServiceInterface;
use App\Contracts\Services\HRMS\AttendenceDetails\OverallAttendenceServiceInterface;

use App\Contracts\Services\HRMS\HrReports\EmployeeOverviewServiceInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeAttendenceServiceInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeLeaveReportsServiceInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeePayrollReportsServiceInterface;
use App\Contracts\Services\HRMS\HrReports\EmployeeSalaryAndStipendReportsServiceInterface;


use App\Contracts\Services\HRMS\EmployeeDetails\EmployeeServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Services\HRMS\EmployeDetails\EmployeeDetailsService;
use App\Services\HRMS\WarningDetails\WarningDetailsService;
use App\Services\HRMS\WarningDetails\CreateWarningService;
use App\Services\HRMS\LeavesDetails\LeavesDashboardService;
use App\Services\HRMS\LeavesDetails\SubmitLeavesService;
use App\Services\HRMS\LeavesDetails\LeavesApplicationService;
use App\Services\HRMS\AttendenceDetails\LiveAttendenceService;
use App\Services\HRMS\AttendenceDetails\OverallAttendenceService;

use App\Services\HRMS\HrReports\EmployeeOverviewService;
use App\Services\HRMS\HrReports\EmployeeAttendenceService;
use App\Services\HRMS\HrReports\EmployeeLeaveReportsService;
use App\Services\HRMS\HrReports\EmployeePayrollReportsService;
use App\Services\HRMS\HrReports\EmployeeSalaryAndStipendReportsService;
use App\Repositories\UserRepository;
use App\Services\Procurement\Inventory\StockDetailService;

use App\Services\Accounts\JurnalVoucherService;
use App\Contracts\Services\Accounts\JVServiceInterface;

use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\Admin\ClubManagement\ClubRegisterationServiceInterface;
use App\Services\Admin\ClubManagement\ClubRegisterationService;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(StockDetailServiceInterface::class, StockDetailService::class);
        $this->app->bind(JVServiceInterface::class, JurnalVoucherService::class);
        $this->app->bind(EmployeeServiceInterface::class, EmployeeDetailsService::class);
        $this->app->bind(WarningDetailsServiceInterface::class, WarningDetailsService::class);
        $this->app->bind(CreateWarningServiceInterface::class, CreateWarningService::class);
        $this->app->bind(LeavesDashboardServiceInterface::class, LeavesDashboardService::class);
        $this->app->bind(SubmitLeavesServiceInterface::class, SubmitLeavesService::class);
        $this->app->bind(LeavesApplicationServiceInterface::class, LeavesApplicationService::class);

                //hr reports
        $this->app->bind(EmployeeOverviewServiceInterface::class, EmployeeOverviewService::class);
        $this->app->bind(EmployeeAttendenceServiceInterface::class, EmployeeAttendenceService::class);
        $this->app->bind(EmployeeLeaveReportsServiceInterface::class, EmployeeLeaveReportsService::class);
        $this->app->bind(EmployeePayrollReportsServiceInterface::class, EmployeePayrollReportsService::class);
        $this->app->bind(EmployeeSalaryAndStipendReportsServiceInterface::class, EmployeeSalaryAndStipendReportsService::class);
//HRMS attendence
$this->app->bind(LiveAttendenceServiceInterface::class, LiveAttendenceService::class);
$this->app->bind(OverallAttendenceServiceInterface::class, OverallAttendenceService::class);
//Admin Club Management
$this->app->bind(ClubRegisterationServiceInterface::class,ClubRegisterationService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
