<?php

namespace App\Http\Controllers\HRMS\LeavesDetails;

use App\Contracts\Repository\HRMS\LeavesDetails\SubmitLeavesRepositoryInterface;
use App\Contracts\Services\HRMS\LeavesDetails\SubmitLeavesServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Session;
use Illuminate\Support\Facades\Log;



class SubmitLeavesController extends Controller
{
    protected $SubmitLeavesRepositoryInterface;
    protected $SubmitLeavesServiceInterface;

    public function __construct(SubmitLeavesRepositoryInterface $SubmitLeavesRepositoryInterface, SubmitLeavesServiceInterface $SubmitLeavesServiceInterface)
    {
        $this->SubmitLeavesRepositoryInterface = $SubmitLeavesRepositoryInterface;
        $this->SubmitLeavesServiceInterface = $SubmitLeavesServiceInterface;
    }




    public function submit_leave(Request $request)
    {
        //Apply Leaves Controller function
    try{
        $emp_emp_id = $request->emp_id;
        $selecteddays = $request->get('days');
        $emp_date_from = $request->get('emp_date_from');
        $emp_date_to = $request->get('emp_date_to');
        $emp_reason = $request->get('emp_reason');
        $emp_leave = $request->get('emp_leave');
        $emp_emp_id = ($emp_emp_id == 0) ? employee_id() : $emp_emp_id;

        //  use $request->all(),
        $result =$this->SubmitLeavesServiceInterface->submitLeave( $emp_emp_id, $selecteddays, $emp_date_from, $emp_date_to, $emp_reason, $emp_leave);
        return [
            'message' => 'Leave applied',
            'data' => $result,
        ];

     } catch (\Exception $e) {
                    Log::error('error submit apply leave : ' . $e->getMessage());
                    return response()->json($e->getMessage());
                }
    }

    public function submit_emp_leaves(Request $request)
    {

        //Assign Leaves Controllelr function
        try {

            $lv_emp_id = $request->get('lv_emp_id');
            $lv_type = $request->get('lv_type');
            $lv_nmbr = $request->get('lv_nmbr');
                   //  use $request->all(),


         return   $this->SubmitLeavesServiceInterface->submitEmpLeaves( $lv_emp_id ,  $lv_type,   $lv_nmbr );


        } catch (\Exception $e) {
            Log::error('error submit assign emp leave : ' . $e->getMessage());
            return response()->json($e->getMessage());
        }
    }


}
