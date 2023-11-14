<?php

namespace App\Http\Controllers\HRMS\WarningDetails;

use App\Contracts\Repository\HRMS\WarningDetails\CreateWarningRepositoryInterface;
use App\Contracts\Services\HRMS\WarningDetails\CreateWarningServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\Log;
use Session;
use App\Http\Controllers\HRMS\EmployeDetails\IndEmployeDetailsController;

class CreateWarningController extends Controller
{
    use CommonTrait;
    protected $CreateWarningRepository;
    protected $CreateWarningservice;
    protected $indEmployeDetailsController;

    public function __construct(
        CreateWarningServiceInterface $CreateWarningservice,
        CreateWarningRepositoryInterface $CreateWarningRepository,
        IndEmployeDetailsController $indEmployeDetailsController
    ) {
        $this->CreateWarningRepository = $CreateWarningRepository;
        $this->CreateWarningservice = $CreateWarningservice;
        $this->indEmployeDetailsController = $indEmployeDetailsController;
    }

    public function warning_reasons()
    {
        try {
            return $this->sendSuccess(' warning reason success',$this->CreateWarningRepository->warning_reasons());
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function get_emp_detail(Request $request)
    {
        try {
            $emp_id = $request->get('emp_id');
            return $this->sendSuccess('get emp details success',$this->CreateWarningRepository->getEmployeeDetail($emp_id));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function submit_warning(Request $request)
    {
        try{
        $company_id = company_id();
        $username = session('username');
        $UserFullName = session('UserName');
        $dated = $request->input('dated');
        $emp_code = $request->emp_code;
        $emp_name = $request->input('emp_name');
        $department = $request->input('department');
        $designation = $request->input('designation');
        $location = $request->input('location');
        $subject = $request->input('subject');
        $warning_content = $request->input('warning_content');

       return $this->CreateWarningservice->submitWarning(
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
        );


    } catch (\Exception $e) {

        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
    }

    public function getwarnig_emp($id)
    {
        try{
        return $this->sendSuccess('get warning employee success',$this->CreateWarningRepository->getwarnig_emp($id));
    } catch (\Exception $e) {

        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());
    }
    }
}
