<?php

namespace App\Http\Controllers\HRMS\EmployeDetails;

use App\Contracts\Repository\HRMS\EmployeeDetails\EmployeeRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\Log;

class EmployeDetailsController extends Controller
{
    protected $employeeRepository;
    use CommonTrait;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function search_Employee_bynamecnic(Request $request)
    {
        try {
            $keyword = $request->keyword1;
            return $this->sendSuccess('Count employee success', $this->employeeRepository->searchEmployeeByNameCnic($keyword));
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function searchemployee($department, $location, $designation, $gender, $status, $min_price, $max_price, $cnic, $emp_id, $emp_sts)
    {
        try {
            $department = $department == "All" ? '' : $department;
            $location = $location == "All" ? '' : $location;
            $designation = $designation == "All" ? '' : $designation;
            $gender = $gender == "All" ? '' : $gender;
            $status = $status == "All" ? '' : $status;
            $min_price = $min_price == "All" ? '0' : $min_price;
            $max_price = $max_price == "All" ? '2147483647' : $max_price;
            $cnic = $cnic == "All" ? '' : $cnic;
            $emp_id = $emp_id == "All" ? null : $emp_id;
            $emp_sts = $emp_sts == "All" ? '' : $emp_sts;

            return $this->sendSuccess('Count employee success', $this->employeeRepository->searchEmployeeByFilter($department, $location, $designation, $gender, $status, $min_price, $max_price, $cnic, $emp_id, $emp_sts));

        } catch (\Exception $e) {
            //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }


    public function department_detail()
    {

        $departmentDetails = $this->employeeRepository->department_detail();
        return response()->json($departmentDetails);

    }

    public function overall_designation()
    {

        $designantionDetails = $this->employeeRepository->overall_designation();
        return response()->json($designantionDetails);

    }

    public function overall_location()
    {

        $locations = $this->employeeRepository->overall_location();
        return response()->json($locations);

    }

    public function count_employees()
    {
        try {
            return $this->sendSuccess('Count employee success', $this->employeeRepository->count_employees());
        } catch (\Exception $e) {
            //            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
}
