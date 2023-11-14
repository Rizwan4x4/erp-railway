<?php

namespace App\Repositories\Admin\ClubManagement;

use Illuminate\Database\QueryException;
use App\Exceptions\ErrorException;
use App\Contracts\Repository\Admin\ClubManagement\MemberRegisterationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Rules\UniqueRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Session;

class MemberRegisterationRepository implements MemberRegisterationRepositoryInterface
{
    public function create_new_member(Request $request)
    {
        try {
            if($request->m_type == 'res'){
                $data = [
                    'user_id' => employee_id(),
                    'CreatedAt' => long_date(),
                    'Name' => $request['member detail']['m_name'],
                    'Cnic' => $request['member detail']['cnic'],
                    'PhoneNo' => $request['member detail']['m_mobile'],
                    'Email' => $request['member detail']['m_email'],
                    'm_type' => 'Resident',
                    'club_id' => $request['member detail']['club_id'],
                    'Status' =>'Register',
                    
                    ];
                    $clubId = DB::connection('sqlsrv2')->table('ClubMembers')->insertGetId($data);
                $data1 = [
                    'Block' => $request['member detail']['block'],
                    'Street' => $request['member detail']['street'],
                    'Plot_no' => $request['member detail']['plot'],
                    'ClubMembersId' => $clubId,

                ];
                return DB::connection('sqlsrv2')->table('ClubMembersResident')->insert($data1);
             }
             elseif ($request->m_type == 'emp') {

                $data = [
                    'Name' => $request['member detail']['m_name'],
                'employee_code' => $request['member detail']['emp_code_member'],
                'club_id' => $request['member detail']['club_id'],
                'PhoneNo' => $request['member detail']['m_mobile'],
                'Cnic' => $request['member detail']['cnic'],
                'PhoneNo' => $request['member detail']['m_mobile'],
                'Email' => $request['member detail']['m_email'],
                'm_type' => 'Employee',
                'user_id' => employee_id(),
                'CreatedAt' => long_date(),
                'Status' =>'Register',
                'Address' =>$request['member detail']['m_address'],
                ];

                return $clubId = DB::connection('sqlsrv2')->table('ClubMembers')->insertGetId($data);
             }
             elseif ($request->m_type == 'out') {
                $data = [
                    'Name' => $request['member detail']['m_name'],
                    'Cnic' => $request['member detail']['cnic'],
                    'PhoneNo' => $request['member detail']['m_mobile'],
                    'm_type' => 'Outsider',
                    'Email' => $request['member detail']['m_email'],
                    'club_id' => $request['member detail']['club_id'],
                    'Status' =>'Register',
                    'Address' => $request['member detail']['m_address'],
                    'user_id' => employee_id(),
                    'CreatedAt' => long_date(),
                ];
                return $clubId = DB::connection('sqlsrv2')->table('ClubMembers')->insertGetId($data);
             }

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error Updating Club Data: " . $e->getMessage());
        }
    }

    public function get_member_DetailById($id){
        try {

            $result = DB::connection('sqlsrv2')
            ->table('ClubMembers')->select('m_type')->where('ClubMembers.id','=',$id)->first();

            if($result ->m_type == 'Employee'){
                return  DB::connection('sqlsrv2')
                ->table('ClubMembers')
                ->join('Clubs','Clubs.id','=','ClubMembers.club_id')
                ->Join('Emp_Register', 'ClubMembers.employee_code', '=', 'Emp_Register.EmployeeCode')
                ->Join('dbo.Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->select('ClubMembers.*', 'Clubs.Name As ClubName','Emp_Register.Designation','Emp_Register.Department')
                ->where('ClubMembers.Status','=','Register')
                ->where('ClubMembers.id','=',$id)->get();
            }
            if($result ->m_type == 'Resident'){
                return  DB::connection('sqlsrv2')
                ->table('ClubMembers')
                ->join('Clubs','Clubs.id','=','ClubMembers.club_id')
                ->join('ClubMembersResident','ClubMembers.id','=','ClubMembersResident.ClubMembersId')
                ->select('ClubMembers.Email as EmployeeEmail','ClubMembers.Cnic as EmployeeCNIC', 'ClubMembers.Name AS EmployeeName', 'ClubMembers.PhoneNo AS EmployeePhone','Clubs.Name As ClubName','ClubMembersResident.Block','ClubMembersResident.Street','ClubMembersResident.Plot_no','ClubMembers.m_type','ClubMembers.Status')
                ->where('ClubMembers.Status','=','Register')
                ->where('ClubMembers.id','=',$id)->get();
            }
            if($result ->m_type == 'Outsider'){
                return  DB::connection('sqlsrv2')
                ->table('ClubMembers')
                ->join('Clubs','Clubs.id','=','ClubMembers.club_id')
                ->select('ClubMembers.Email as EmployeeEmail','ClubMembers.Cnic as EmployeeCNIC', 'ClubMembers.Name AS EmployeeName', 'ClubMembers.PhoneNo AS EmployeePhone','ClubMembers.Email AS EmployeeEmail','Clubs.Name As ClubName','ClubMembers.m_type','ClubMembers.Status','ClubMembers.Address')
                ->where('ClubMembers.Status','=','Register')
                ->where('ClubMembers.id','=',$id)->get();

            }


        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Member Data: " . $e->getMessage());
        }
    }
    public function get_member_data($id)
    {
        try {
            // return DB::connection('sqlsrv2')
            //     ->table('ClubMembers')
            //     ->leftJoin(secondConDb() . '.dbo.Emp_Register', 'ClubMembers.employee_code', '=', 'Emp_Register.EmployeeCode')
            //     ->leftJoin(secondConDb() . '.dbo.Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')
            //     ->select('ClubMembers.*', 'Emp_Profile.Name AS EmployeeName', 'Emp_Profile.CNIC AS EmployeeCNIC', 'Emp_Profile.Mobile AS EmployeePhone','Emp_Profile.Email AS EmployeeEmail')
            //     ->where('ClubMembers.Status','=','Register')
            //     ->where('ClubMembers.club_id','=',$id)
            //     ->latest('CreatedAt')
            //     ->paginate(10);

            return DB::connection('sqlsrv2')
            ->table('ClubMembers')
            ->select('ClubMembers.*')
            ->where('ClubMembers.Status','=','Register')
            ->where('ClubMembers.club_id','=',$id)
            ->latest('CreatedAt')
            ->paginate(10);

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Member Data: " . $e->getMessage());
        }

    }
    public function create_Member_Receipt(Request $request){
        try {
            $type = DB::connection('sqlsrv2')->table('Clubs')->join('ClubMembers','Clubs.id','=','ClubMembers.club_id')->select('ClubMembers.m_type','ClubMembers.CreatedAt')->where('ClubMembers.id','=', $request->selectedMemberId)->first();

            if($type->m_type == 'Employee'){
                $Fees = DB::connection('sqlsrv2')->table('Clubs')->select('Clubs.Employee_Fee')->first();
                $Fees1 =$Fees->Employee_Fee;
            }
            if($type->m_type == 'Resident'){
                $Fees = DB::connection('sqlsrv2')->table('Clubs')->select('Clubs.Resident_fee')->first();
                $Fees1 =$Fees->Resident_fee;
            }
            if($type->m_type == 'Outsider'){
                $Fees = DB::connection('sqlsrv2')->table('Clubs')->select('Clubs.Outsider_fee')->first();
                $Fees1 =$Fees->Outsider_fee;
            }

            $data = [
                'member_id' => $request->selectedMemberId,
                'user_id' => employee_id(),
                'FeeAmount' => $Fees1,
                'FeeDate' => date('F Y', strtotime($request['receipt_fee']['date'])),
                'CreatedAt' => long_date(),
                'Status'=> 'Paid'
            ];
            return  DB::connection('sqlsrv2')->table('ClubMembersFee')->insertGetId($data);

        }  catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Member Data: " . $e->getMessage());
        }

    }

    // public function create_Member_Receipt(Request $request){
    //     try {
    //         $receiptDate = $request['receipt_fee']['date'];
    //         $FeeAmount = DB::connection('sqlsrv2')->table('ClubMembersFee')
    //             ->join('ClubMembers', 'ClubMembersFee.member_id', '=', 'ClubMembers.id')
    //             ->select('ClubMembers.FeeAmount')
    //             ->where('ClubMembersFee.member_id', '=', $request->selectedMemberId)
    //             ->first();

    //             $validator = Validator::make(['FeeDate' => $receiptDate], [
    //                 'FeeDate' => [
    //                     'required',
    //                     'date_format:Y-m-d',
    //                     function ($attribute, $value, $fail) use ($request) {
    //                         $existingRecord = DB::connection('sqlsrv2')->table('ClubMembersFee')
    //                             ->where('member_id', $request->selectedMemberId)
    //                             ->whereYear('FeeDate', date('Y', strtotime($value)))
    //                             ->whereMonth('FeeDate', date('m', strtotime($value)))
    //                             ->first();

    //                         if ($existingRecord) {
    //                             $fail('A record for the selected month and year already exists.');
    //                         }
    //                     },
    //                 ],
    //             ]);

    //             if ($validator->fails()) {
    //                 return response()->json(['errors' => $validator->errors()], 422);
    //             }

    //         $data = [
    //             'member_id' => $request->selectedMemberId,
    //             'user_id' => employee_id(),
    //             'FeeAmount' => $FeeAmount->FeeAmount,
    //             'FeeDate' => $receiptDate,
    //             'CreatedAt' => long_date(),
    //         ];

    //         return DB::connection('sqlsrv2')->table('ClubMembersFee')->insertGetId($data);
    //     } catch (QueryException $e) {
    //         // Throw a custom exception with the original message
    //         throw new ErrorException("Error getting Member Data: " . $e->getMessage());
    //     }
    // }

    public function get_receipt_data($id){
        try {


            $result = DB::connection('sqlsrv2')->select("
                DECLARE @InputMemberID INT = :id;
                SET NOCOUNT ON;
                EXEC [dbo].[Memeber_ReceiptDetail] @InputMemberID = @InputMemberID;
            ", ['id' => $id]);

            return response()->json($result, 200);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting receipts Data: " . $e->getMessage());
        }

    }
    private function buildSearchQuery($query, $name, $club_id) {
        return $query->where(function ($q) use ($name, $club_id) {
            if ($name) {
                $q->orWhere('Name', 'like', '%' . $name . '%')->orWhere('Cnic', 'like', '%' . $name . '%');
            }
            if ($club_id) {
                $q->orWhere('club_id', 'like', '%' . $club_id . '%');
            }
        });
    }
    public function search_MemberFees(Request $request) {
        try {
            $name = $request->name;

            return DB::connection('sqlsrv2')->table('ClubMembersFee')
                ->select('ClubMembers.*','ClubMembersFee.id', 'ClubMembersFee.FeeAmount', 'ClubMembersFee.FeeDate', 'ClubMembersFee.CreatedAt as date', 'ClubMembers.club_id', 'ClubMembers.Email as MemberEmail')
                ->leftJoin('ClubMembers', 'ClubMembersFee.member_id', '=', 'ClubMembers.id')
                ->where(function ($query) use ($name) {
                    $query->Where('ClubMembers.Name', 'like', '%' . $name . '%')
                        ->orWhere('ClubMembers.Cnic', 'like', '%' . $name . '%');
                })
                ->where('ClubMembers.Status','=','Register')
                ->latest('CreatedAt')->paginate(10);
        } catch (QueryException $e) {
            throw new ErrorException("Error getting receipts Data: " . $e->getMessage());
        }
    }

    public function searchClubmember(Request $request) {
        try {
             $name = $request->name;
             $club_id = $request->club_id;

            $result =  DB::connection('sqlsrv2')
            ->table('ClubMembers')
            ->select('ClubMembers.*')
            ->where(function ($query) use ($name) {
                $query->Where('ClubMembers.Name', 'like', '%' . $name . '%')
                    ->orWhere('ClubMembers.Cnic', 'like', '%' . $name . '%');
            })
            ->where('ClubMembers.Status','=','Register')
            ->where('ClubMembers.club_id','=',$club_id)
            ->latest('CreatedAt')->paginate(10);

             return $result;
        } catch (QueryException $e) {
            throw new ErrorException("Error getting receipts Data: " . $e->getMessage());
        }
    }

    }

