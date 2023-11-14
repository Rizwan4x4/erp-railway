<?php
namespace App\Contracts\Services\HRMS\WarningDetails;

interface WarningDetailsServiceInterface
{
    public function filterWarnings( $designation, $department, $location);
}
