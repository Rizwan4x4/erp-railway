<?php

namespace App\Providers;

use App\Contracts\Repository\Accounts\JVRepositoryInterface;
use App\Contracts\Repository\Admin\ClubManagement\MemberFeesRepositoryInterface;
use App\Contracts\Repository\Admin\Roles\RolesRepositoryInterface;
use App\Contracts\Repository\Procurement\Inventory\StockDetailRepositoryInterface;
use App\Repositories\Accounts\JurnalVoucherRepository;

use App\Repositories\Admin\ClubManagement\MemberFeesRepositoryRepository;
use App\Repositories\Admin\Roles\RolesRepository;
use App\Repositories\HRMS\EmployeDetails\EmployeeRepository;
use App\Repositories\HRMS\WarningDetails\WarningDetailsRepository;
use App\Repositories\HRMS\WarningDetails\CreateWarningRepository;
use App\Repositories\HRMS\LeavesDetails\LeavesDashboardRepository;
use App\Repositories\HRMS\LeavesDetails\SubmitLeavesRepository;
use App\Repositories\HRMS\LeavesDetails\LeavesApplicationRepository;
use App\Repositories\HRMS\AttendenceDetails\LiveAttendenceRepository;
use App\Repositories\HRMS\AttendenceDetails\OverallAttendenceRepository;
use App\Repositories\HRMS\HrReports\EmployeeOverViewRepository;
use App\Repositories\HRMS\HrReports\EmployeeAttendenceRepository;
use App\Repositories\HRMS\HrReports\EmployeeLeaveReportsRepository;
use App\Repositories\HRMS\HrReports\EmployeePayrollReportsRepository;
use App\Repositories\HRMS\HrReports\EmployeeSalaryAndStipendReportsRepository;


use App\Repositories\ClientAdmin\ClientAdminRepository;
use App\Repositories\Procurement\Inventory\StockDetailRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Repository\UserRepositoryInterface;
use App\Contracts\Repository\HRMS\EmployeeDetails\EmployeeRepositoryInterface;
use App\Contracts\Repository\HRMS\WarningDetails\WarningDetailsRepositoryInterface;
use App\Contracts\Repository\HRMS\WarningDetails\CreateWarningRepositoryInterface;
use App\Contracts\Repository\HRMS\LeavesDetails\LeavesDashboardRepositoryInterface;
use App\Contracts\Repository\HRMS\LeavesDetails\SubmitLeavesRepositoryInterface;
use App\Contracts\Repository\HRMS\LeavesDetails\LeavesApplicationRepositoryInterface;
use App\Contracts\Repository\HRMS\AttendenceDetails\LiveAttendenceRepositoryInterface;
use App\Contracts\Repository\HRMS\AttendenceDetails\OverallAttendenceRepositoryInterface;

use App\Contracts\Repository\HRMS\HrReports\EmployeeOverviewRepositoryInterface;
use App\Contracts\Repository\HRMS\HrReports\EmployeeAttendenceRepositoryInterface;
use App\Contracts\Repository\HRMS\HrReports\EmployeeLeaveReportsRepositoryInterface;
use App\Contracts\Repository\HRMS\HrReports\EmployeePayrollReportsRepositoryInterface;
use App\Contracts\Repository\HRMS\HrReports\EmployeeSalaryAndStipendReportsRepositoryInterface;
use App\Contracts\Repository\Admin\ClubManagement\ClubRegisterationRepositoryInterface;
use App\Repositories\Admin\ClubManagement\ClubRegisterationRepository;
use App\Repositories\Admin\ClubManagement\MemberRegisterationRepository;
use App\Contracts\Repository\Admin\ClubManagement\MemberRegisterationRepositoryInterface;

use App\Contracts\Repository\ClientAdmin\ClientAdminRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(StockDetailRepositoryInterface::class, StockDetailRepository::class);
        $this->app->bind(JVRepositoryInterface::class, JurnalVoucherRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);

        //Warning Details HRMS
        $this->app->bind(WarningDetailsRepositoryInterface::class, WarningDetailsRepository::class);
        $this->app->bind(CreateWarningRepositoryInterface::class, CreateWarningRepository::class);

        //Leaves Details HRMS
        $this->app->bind(LeavesDashboardRepositoryInterface::class, LeavesDashboardRepository::class);
        $this->app->bind(SubmitLeavesRepositoryInterface::class, SubmitLeavesRepository::class);
        $this->app->bind(LeavesApplicationRepositoryInterface::class, LeavesApplicationRepository::class);

        // HR Reports HRMS

        $this->app->bind(EmployeeOverviewRepositoryInterface::class, EmployeeOverViewRepository::class);
        $this->app->bind(EmployeeAttendenceRepositoryInterface::class, EmployeeAttendenceRepository::class);
        $this->app->bind(EmployeeLeaveReportsRepositoryInterface::class, EmployeeLeaveReportsRepository::class);
        $this->app->bind(EmployeePayrollReportsRepositoryInterface::class, EmployeePayrollReportsRepository::class);
        $this->app->bind(EmployeeSalaryAndStipendReportsRepositoryInterface::class, EmployeeSalaryAndStipendReportsRepository::class);
         //ClientAdmin
        $this->app->bind(ClientAdminRepositoryInterface::class, ClientAdminRepository::class);
        //HRMS Attendence
        $this->app->bind(LiveAttendenceRepositoryInterface::class, LiveAttendenceRepository::class);
        $this->app->bind(OverallAttendenceRepositoryInterface::class, OverallAttendenceRepository::class);
        //Admin Club Management
        $this->app->bind(ClubRegisterationRepositoryInterface::class, ClubRegisterationRepository::class);
        //Admin member managgement
        $this->app->bind(MemberRegisterationRepositoryInterface::class, MemberRegisterationRepository::class);
        $this->app->bind(MemberFeesRepositoryInterface::class, MemberFeesRepositoryRepository::class);
        $this->app->bind(RolesRepositoryInterface::class,RolesRepository::class);

                //Admin roles permissions
              
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
