<?php

namespace App\Services\HRMS\EmployeDetails;

use App\Contracts\Repository\HRMS\EmployeeDetails\EmployeeRepositoryInterface;
use App\Contracts\Services\HRMS\EmployeeDetails\EmployeeServiceInterface;

use App\Exceptions\ErrorException;
use App\Repositories\HRMS\EmployeDetails\EmployeeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;
use Carbon\Carbon;

class EmployeeDetailsService implements EmployeeServiceInterface
{
    protected $EmployeeRepositoryInterface;

    public function __construct(EmployeeRepositoryInterface $EmployeeRepositoryInterface)
    {
        $this->EmployeeRepositoryInterface = $EmployeeRepositoryInterface;
    }


    public function getindemployee_detail($id)
    {

        try {

            // dd("good");
            if ($id == 0 || $id == null || $id == '') {
                $id = Session::get('employee_id');
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            $stipend = $this->EmployeeRepositoryInterface->StipendDetail($id);
            $emp_detail = $stipend ? $this->EmployeeRepositoryInterface->emp_detail($id) : $this->EmployeeRepositoryInterface->Else_emp_detail($id);
            return $emp_detail;
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        } catch (\Exception $e) {
            // Handle other exceptions here
            // Log the error or take any other necessary action
            Log::error('Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }

    public function getemployee_education($id)
    {

        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = Session::get('employee_id');
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            return $this->EmployeeRepositoryInterface->getemployee_education($id);


        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }

    public function fetchEmployeeAmount($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = Session::get('employee_id');
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }
            $loanSession = $this->EmployeeRepositoryInterface->getLoanSessionName(company_id());
            $tax = $this->EmployeeRepositoryInterface->getEmployeeTax(company_id(), $id);
            $installment = $this->EmployeeRepositoryInterface->getEmployeeInstallment(company_id(), $id, $loanSession);
            $stipend = $this->EmployeeRepositoryInterface->getEmployeeStipend(company_id(), $id, long_date());
            $allowance = $this->EmployeeRepositoryInterface->getEmployeeAllowance(company_id(), $id, long_date());
            $fuel = $this->EmployeeRepositoryInterface->getEmployeeFuel(company_id(), $id);
            $joining_date = $this->EmployeeRepositoryInterface->getEmployeeJoiningDate(company_id(), $id);

            // Calculate years using Carbon library
            $years = Carbon::parse($joining_date)->diff(long_date())->format('%y');

            return compact('tax', 'installment', 'stipend', 'years', 'allowance', 'fuel');
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }

    }

    public function getReportingEmployees($id)
    {
        try {
            return $this->EmployeeRepositoryInterface->getReportingEmployee($id);

        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }

    public function getEmployeeSuccessArray($id)
    {

        try {
            return $this->EmployeeRepositoryInterface->getEmployeeSuccessDetail($id);
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }

    public function fetchEmpAllowances($id)
    {
        try {
            if ($id == 0 || $id == null || $id == '') {
                $id = employee_id();
            } elseif (Session::get('hr_write') != true && !in_array($id, array_column(reporting_team(), 'EmployeeID'))) {
                return;
            }

            $allowanceExists = $this->EmployeeRepositoryInterface->checkEmpAllowanceExistence(company_id(), $id);
            if ($allowanceExists) {
                return $this->EmployeeRepositoryInterface->fetchEmpAllowances(company_id(), $id);

            } else {
                // Handle the case when no allowances are found
                return "Emp allowence not found";
            }
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }

    public function registered($id)
    {
        try {
            return $this->EmployeeRepositoryInterface->registered($id);
        } catch (ErrorException $e) {

            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            throw $e;
        }
    }

    public function resignEmployee($id, $resignDate)
    {
        try {
            $username = Session::get('username');
            $userFullName = Session::get('UserName');
            $company_id = company_id();
            $update_date = date("Y-m-d h:i:s A");
            $result = $this->EmployeeRepositoryInterface->updateEmployeeResignedStatus($id, $resignDate);

            if ($result) {
                $this->EmployeeRepositoryInterface->createFinalSettlement($id, $resignDate);

                $employeeDetail = $this->EmployeeRepositoryInterface->getEmployeeDetails($id);
                $full_name_arr = $this->EmployeeRepositoryInterface->fetchFullName($id);
                $full_name = $full_name_arr->Name;
                $this->EmployeeRepositoryInterface->insertActivityLog($company_id, $username, $userFullName, $full_name, 'Update Status', 'Update status of ' . $full_name . ' to Resigned', $update_date);


                return $employeeDetail;
            }

        } catch (ErrorException $e) {

            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            throw $e;
        }
    }

    public function terminateEmployee($id, $date)
    {
        try {
            $username = Session::get('username');
            $userFullName = Session::get('UserName');
            $company_id = company_id();
            $update_date = date("Y-m-d h:i:s A");


            $this->EmployeeRepositoryInterface->insertFinalSettlement($company_id, $id, $session_name, $date, $username, $update_date);


            $this->EmployeeRepositoryInterface->insertActivityLog($company_id, $username, $userFullName, $full_name, 'Update Status', 'Update status of ' . $full_name . ' to Terminated', $update_date);

            return $this->EmployeeRepositoryInterface->fetchEmployeeDetails($company_id, $id);


        } catch (ErrorException $e) {

            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            throw $e;
        }
    }

    public function suspendEmployee($id, $date)
    {
        try {
            $update_date = date("Y-m-d");
            $result5 = $this->EmployeeRepositoryInterface->updateEmployeeStatusAndDate($id, $date, "Suspended", $update_date);

            if ($result5) {
                $company_id = Session::get('company_id');


                $allowanceExists = $this->EmployeeRepositoryInterface->checkEmpAllowanceExistence($company_id, $id);

                if ($allowanceExists) {
                    return $this->EmployeeRepositoryInterface->fetchEmpAllowances($company_id, $id);

                } else {
                    // Handle the case when no allowances are found
                    return "Emp allowence not found";
                }
            }
        } catch (ErrorException $e) {

            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            throw $e;
        }

    }
//     public function terminateEmployee($id, $date)
//     {
//         try {
//         $username = Session::get('username');
//         $userFullName = Session::get('UserName');
//         $company_id = company_id();
//         $update_date = date("Y-m-d h:i:s A");

//         $statusUpdateResult = $this->EmployeeRepositoryInterface->updateEmployeeStatus($id, 'Terminated', $date);

//         if ($statusUpdateResult) {
//             $findSessionClosed = $this->EmployeeRepositoryInterface->findSession($company_id, 1);
//             $session_name = $findSessionClosed->SessionName;

//         return $this->EmployeeRepositoryInterface->fetchEmployeeDetails($company_id, $id);
//     }
// } catch (ErrorException $e) {

//     Log::error('Custom Exception in YourService: ' . $e->getMessage());

//     throw $e;
// }


// }
}
