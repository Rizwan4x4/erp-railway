<?php
namespace App\Services\Admin\ClubManagement;

use App\Exceptions\ErrorException;
use App\Repositories\Admin\ClubManagement\ClubRegisterationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Contracts\Services\Admin\ClubManagement\ClubRegisterationServiceInterface;

class ClubRegisterationService implements ClubRegisterationServiceInterface{
    protected $ClubRegisterationRepository;
    public function __construct(ClubRegisterationRepository $ClubDetailRepository)
    {
        $this->ClubRegisterationRepository = $ClubDetailRepository;
    }
    public function create_new_club($request){
        try {
            $club_name = $request->club_name;
            $club_type = $request->club_type;
            $employee_fee = $request->employee_fee;
            $Resident_fee = $request->Resident_fee;
            $Outsider_fee = $request->Outsider_fee;
            $description = $request->description;
            $status = $request->status;
            $data = [
                'user_id' => employee_id(),
                'CreatedAt' => long_date(),
                'Name' => $club_name,
                'Type' => $club_type,
                'Employee_fee'=>$employee_fee,
                'Resident_fee'=>$Resident_fee,
                'Outsider_fee'=>$Outsider_fee,
                'Description' =>$description,
                'status' => $status,
              ];
            return $this->ClubRegisterationRepository->create_new_club($data);


        } catch (\Exception $e) {
            Log::error('Exception in ClubRegistrationService: ' . $e->getMessage());
            throw $e;
        }
            }


}
