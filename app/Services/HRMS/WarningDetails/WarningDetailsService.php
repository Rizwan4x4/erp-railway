<?php

namespace App\Services\HRMS\WarningDetails;

use App\Contracts\Repository\HRMS\WarningDetails\WarningDetailsRepositoryInterface;
use App\Contracts\Services\HRMS\WarningDetails\WarningDetailsServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\WarningDetails\WarningDetailsRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;
class WarningDetailsService implements WarningDetailsServiceInterface
{
    protected $WarningDetailsRepositoryInterface;

    public function __construct(WarningDetailsRepositoryInterface $WarningDetailsRepositoryInterface)
    {
        $this->WarningDetailsRepositoryInterface = $WarningDetailsRepositoryInterface;
    }

    
    public function filterWarnings( $designation, $department, $location)
    { try {
        $designation = ($designation == 'All') ? '' : $designation;
        $department = ($department == 'All') ? '' : $department;
        $location = ($location == 'All') ? '' : $location;

        return $this->WarningDetailsRepositoryInterface->filterWarnings($designation, $department, $location);
    } catch (ErrorException $e) {
   
        Log::error('Custom Exception in YourService: ' . $e->getMessage());
    
        throw $e;
    }
    }
  

}
