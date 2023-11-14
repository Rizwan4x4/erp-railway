<?php
namespace App\Contracts\Repository\HRMS\HrReports;
interface EmployeeSalaryAndStipendReportsRepositoryInterface {
    public function getClosedSession();
    public function getSalaryDetails($sessionName);
    public function getSalarySums($sessionName);
}

