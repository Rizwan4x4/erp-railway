<?php
namespace App\Contracts\Services\HRMS\WarningDetails;

interface CreateWarningServiceInterface
{
    public function submitWarning(
        $company_id,
        $username,
        $UserFullName,
        $dated,
        $emp_code,
        $emp_name,
        $department,
        $designation,
        $location,
        $subject,
        $warning_content
    ) ;
}
