<?php

namespace App\Repositories\Admin\ClubManagement;

use Illuminate\Database\QueryException;
use App\Exceptions\ErrorException;
use App\Contracts\Repository\Admin\ClubManagement\ClubRegisterationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use Session;

class ClubRegisterationRepository implements ClubRegisterationRepositoryInterface
{


    public function create_new_club($data)
    {
        try {


            return DB::connection('sqlsrv2')->table('Clubs')->insertGetId($data);

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error Creating Club: " . $e->getMessage());
        }

    }

    public function get_club_data()
    {
        try {

            return DB::connection('sqlsrv2')->table('Clubs')->orderBy('id')->where('isDeleted','=', null)->get();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Club Data: " . $e->getMessage());
        }

    }
    public function get_club_data_byId($id)
    {
        try {

            return DB::connection('sqlsrv2')->table('Clubs')->where('id', $id)->where('isDeleted','=', null)->get();

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting Club Data: " . $e->getMessage());
        }

    }
    public function update_club(Request $request, $id)
    {
        try {
            $data = [
                'Name' => $request->club_name,
                'Type' => $request->club_type,
                'Employee_fee'=> $request->employee_fee,
                'Resident_fee'=> $request->Resident_fee,
                'Outsider_fee'=> $request->Outsider_fee,
                'status' => $request->club_status,
                'Description' =>$request->description,
                'update_by' => employee_id(),
                'UpdateAt' => long_date(),

            ];
            return DB::connection('sqlsrv2')->table('Clubs')->where('id', $id)->update($data);

        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error Updating Club Data: " . $e->getMessage());
        }
    }
    public function del_club(Request $request){
try {
    return DB::connection('sqlsrv2')->table('Clubs')->where('id','=',$request->id)->update(['isDeleted' => 1]);
}  catch (QueryException $e) {
    // Throw a custom exception with the original message
    throw new ErrorException("Error Deleting Club Data: " . $e->getMessage());
}
    }


}
