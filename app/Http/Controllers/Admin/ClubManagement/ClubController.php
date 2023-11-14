<?php

namespace App\Http\Controllers\Admin\ClubManagement;

use App\Contracts\Repository\Admin\ClubManagement\ClubRegisterationRepositoryInterface;
use App\Contracts\Services\Admin\ClubManagement\ClubRegisterationServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Rules\UniqueRule;
use Illuminate\Support\Facades\Validator;



class ClubController extends Controller
{
    use CommonTrait;
    protected $ClubRegisterationRepositoryInterface;
    protected  $ClubRegisterationServiceInterface;

    public function __construct(ClubRegisterationRepositoryInterface $ClubRegisterationRepositoryInterface, ClubRegisterationServiceInterface $ClubRegisterationServiceInterface)
    {
        $this->ClubRegisterationRepositoryInterface = $ClubRegisterationRepositoryInterface;
        $this->ClubRegisterationServiceInterface = $ClubRegisterationServiceInterface;
    }

    public function create_new_club(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'club_name' => ['required', 'string', new UniqueRule('Clubs', 'Name')],
                'club_type' => 'required|string|max:255',
                'employee_fee' => 'required|int',
                'Resident_fee' => 'required|int',
                'Outsider_fee' => 'required|int',
                'description' => 'required|string|max:255',
                'status'  =>  'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // insertLog('Created','new Club created');

            return $this->sendSuccess('new club created!', $this->ClubRegisterationServiceInterface->create_new_club($request));
        } catch (\Exception $e) {


            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
    public function get_club_data()
    {
        try {

            return $this->sendSuccess('clubs data!', $this->ClubRegisterationRepositoryInterface->get_club_data());
        } catch (\Exception $e) {


            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
    public function update_club(Request $request, $id)
    {
        try {
            $clubdata = $this->ClubRegisterationRepositoryInterface->get_club_data_byId($id);
       

            if ($clubdata[0]->Name == $request->club_name) {
                $validator = Validator::make($request->all(), [
                    
                    'club_type' => 'required|string|max:255',
                   'employee_fee' => 'required|int',
                'Resident_fee' => 'required|int',
                'Outsider_fee' => 'required|int',
                'description' => 'required|string|max:255',
                'club_status'  =>  'required|string|max:255',
                    
                ]);
            } 
            else {
                $validator = Validator::make($request->all(), [
                    'club_name' => ['required', 'string', new UniqueRule('Clubs', 'Name')],
                    'club_type' => 'required|string|max:255',
                    'employee_fee' => 'required|int',
                    'Resident_fee' => 'required|int',
                    'Outsider_fee' => 'required|int',
                    'description' => 'required|string|max:255',
                    'club_status'  =>  'required|string|max:255',
                    
                ]);
            }

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            return $this->sendSuccess('club Edited!', $this->ClubRegisterationRepositoryInterface->update_club($request, $id));
        } catch (\Exception $e) {


            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
    public function del_club(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);

            return $this->sendSuccess('club Deleted!', $this->ClubRegisterationRepositoryInterface->del_club($request));
        } catch (\Exception $e) {

            Log::error('Unhandled Exception: ' . $e->getMessage());
            return $this->sendError($e->getMessage(), $e->getCode());
        }
    }
}
