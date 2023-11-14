<?php

namespace App\Services\HRMS\WarningDetails;

use App\Contracts\Repository\HRMS\WarningDetails\CreateWarningRepositoryInterface;
use App\Contracts\Services\HRMS\WarningDetails\CreateWarningServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\WarningDetails\CreateWarningRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;
class CreateWarningService implements CreateWarningServiceInterface
{
    protected $CreateWarningRepositoryInterface;

    public function __construct(CreateWarningRepositoryInterface $CreateWarningRepositoryInterface)
    {
        $this->CreateWarningRepositoryInterface = $CreateWarningRepositoryInterface;
    }

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
    ) 
    { try {
            $emp_rep1 =  $this->CreateWarningRepositoryInterface-> getEmployeeID($emp_code);

        if (!$emp_rep1) {
           return 'Employee not found';
            
          
        }
else{
     
        $find_warning =  $this->CreateWarningRepositoryInterface-> checkIfWarningLetterExists($emp_rep1->EmployeeID);
       
        if ($find_warning) {
            $find_warning1= $this->CreateWarningRepositoryInterface-> getWarningLetter($emp_rep1->EmployeeID);

            $warning_type2 = $find_warning1->WarningType;
       
            if ($warning_type2 == 'First') {
                $warning_type = 'Second';
            } elseif ($warning_type2 == 'Second') {
                $warning_type = 'Terminated';
            } elseif ($warning_type2 == 'Terminated') {
                $message = 'Employee is already terminated';
                return $message;
            }
        } else {
            $warning_type = 'First';
        }

        $data = [
            $company_id,
            $dated,
            $emp_rep1->EmployeeID,
            $emp_name,
            $department,
            $designation,
            $location,
            $warning_type,
            $subject,
            $username,
            date("Y-m-d h:i:s A"),
            $warning_content
        ];

        $this->CreateWarningRepositoryInterface->insertWarningLetter($data);

        if ($warning_type == 'Terminated') {
            $this->CreateWarningRepositoryInterface->updateEmployeeStatus($emp_rep1->EmployeeID, $warning_type);
        }
        $activityLogData = [
            $company_id,
            $username,
            $UserFullName,
            'Warning Issue',
            $warning_type . ' warning Issued to ' . $emp_name,
            date("Y-m-d h:i:s A")
        ];

        $this->CreateWarningRepositoryInterface->insertActivityLog($activityLogData);

        $message = 'submitted';
        return $message;

    }
} catch (ErrorException $e) {
   
    Log::error('Custom Exception in YourService: ' . $e->getMessage());

    throw $e;
}
}
  
  

}
