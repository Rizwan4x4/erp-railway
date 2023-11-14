<?php
namespace App\Contracts\Repository\HRMS\WarningDetails;
interface WarningDetailsRepositoryInterface {
    public function count_warnings();
    public function searchWarnings($keyword, $Page);
    public function filterWarnings( $designation, $department, $location);
}