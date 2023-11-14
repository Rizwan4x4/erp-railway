<?php

namespace App\Http\Controllers\Admin\ClubManagement;

use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rules\UniqueRule;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Rules\UniqueRule2Col;
use App\Contracts\Repository\Admin\ClubManagement\MemberFeesRepositoryInterface;
use App\Contracts\Repository\Admin\ClubManagement\MemberRegisterationRepositoryInterface;


class MemberController extends Controller
{
    use CommonTrait;

    protected $MemberRegisterationRepositoryInterface;
    protected $MemberFeesRepositoryInterface;


    public function __construct(MemberRegisterationRepositoryInterface $MemberRegisterationRepositoryInterface, MemberFeesRepositoryInterface $MemberFeesRepositoryInterface)
    {
        $this->MemberRegisterationRepositoryInterface = $MemberRegisterationRepositoryInterface;
        $this->MemberFeesRepositoryInterface = $MemberFeesRepositoryInterface;

    }

    public function create_new_member(Request $request)
    {
        try {
//            Unique Validations
            if ($request->m_type == "emp") {
                // dd($request['member detail']['club_id']);
                $validator = Validator::make($request->all()["member detail"], [
                     'emp_code_member' => ['required', 'string', new UniqueRule2Col('ClubMembers', 'employee_code', 'club_id',$request['member detail']['club_id'])],
                    'club_id' => 'required',  
                    'm_mobile' => 'required',
                    'cnic' => 'required',
                    'm_email' => 'required',
                    
                ]);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
            } elseif ($request->m_type == "res" || $request->m_type == "out") {
                $validator = Validator::make($request->all()["member detail"], [
                    'cnic' => ['required', 'string', new UniqueRule('ClubMembers', 'Cnic')],
                    'm_email' => ['required', 'string', new UniqueRule('ClubMembers', 'Email')],
                    'm_mobile' => ['required', 'string', new UniqueRule('ClubMembers', 'PhoneNo')],
                ]);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }
            }

            return $this->sendSuccess('new member created!', $this->MemberRegisterationRepositoryInterface->create_new_member($request));


        } catch (\Exception $e) {


            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
    public function get_member_DetailById($id){
        try {
            return $this->sendSuccess('member detail!', $this->MemberRegisterationRepositoryInterface->get_member_DetailById($id));
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }

    }

    public function get_member_data($id)
    {
        try {
            return $this->sendSuccess('member data!', $this->MemberRegisterationRepositoryInterface->get_member_data($id));
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }

    public function create_Member_Receipt(Request $request)
    {
        try {
            $inputDate = $request['receipt_fee']['date'];
            $dateObject = new \DateTime($inputDate);
            $formattedDate = $dateObject->format('F Y');
            
            // Get the CreatedAt month and year from the ClubMembers table
            $createdAtMonth = DB::connection('sqlsrv2')
                ->table('ClubMembers')
                ->where('id', $request->selectedMemberId)
                ->value(DB::raw("MONTH(CreatedAt)"));
            $createdAtYear = DB::connection('sqlsrv2')
                ->table('ClubMembers')
                ->where('id', $request->selectedMemberId)
                ->value(DB::raw("YEAR(CreatedAt)"));
            
            // Extract month and year from the formatted date
            $formattedDateMonth = date('n', strtotime($formattedDate)); // Month without leading zeros
            $formattedDateYear = date('Y', strtotime($formattedDate)); // Year
            
            // Compare the formattedDate month and year with CreatedAt
            if ($formattedDateYear < $createdAtYear ||
                ($formattedDateYear == $createdAtYear && $formattedDateMonth < $createdAtMonth)) {
                return response()->json(['errors' => ['date' => 'You were not registered then.']], 422);
            }
            
            // Perform validation using the converted date
            $validator = Validator::make(
                ['date' => $formattedDate],
                ['date' => ['required', 'string', new UniqueRule2Col('ClubMembersFee', 'FeeDate', 'member_id', $request->selectedMemberId)]]
            );
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            return $this->sendSuccess('new fee receipt created!', $this->MemberRegisterationRepositoryInterface->create_Member_Receipt($request));
        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
    

    public function get_receipt_data($id)
    {
        try {
            
            return $this->sendSuccess('fee receipt data received!', $this->MemberRegisterationRepositoryInterface->get_receipt_data($id));


        } catch (\Exception $e) {


            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());

        }
    }

    public function get_members_fees()
    {
        try {
            return $this->sendSuccess("Fees fetch Successfully.", $this->MemberFeesRepositoryInterface->getFees());

        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
    public function get_members_Totalfees()
    {
        try {
            return $this->sendSuccess("Fees fetch Successfully.", $this->MemberFeesRepositoryInterface->getTotalFees());

        } catch (\Exception $e) {
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
public function search_MemberFees(Request $request){
    try {
        return $this->sendSuccess('member data received!', $this->MemberRegisterationRepositoryInterface->search_MemberFees($request));

    } catch (\Exception $e) {


        Log::error('Unhandled Exception: ' . $e->getMessage());
        return $this->sendError($e->getMessage(), $e->getCode());

    }

}
    public function searchClubmember(Request $request)
    {
        try {
            return $this->sendSuccess('member data received!', $this->MemberRegisterationRepositoryInterface->searchClubmember($request));


        } catch (\Exception $e) {


            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());

        }
    }
}
