<?php

namespace App\Repositories\Admin\ClubManagement;

use App\Contracts\Repository\Admin\ClubManagement\MemberFeesRepositoryInterface;
use App\Exceptions\ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class MemberFeesRepositoryRepository implements MemberFeesRepositoryInterface
{
    public function getFees()
    {
        try {
           return DB::connection('sqlsrv2')->table('ClubMembersFee')
    ->select('ClubMembersFee.id', 'ClubMembersFee.FeeAmount', 'ClubMembersFee.FeeDate', 'ClubMembersFee.CreatedAt as date', 'ClubMembers.*')
    ->leftJoin('ClubMembers', 'ClubMembersFee.member_id', '=', 'ClubMembers.id')
    ->orderByDesc('ClubMembersFee.CreatedAt')
    ->paginate(40);

            } catch (QueryException $e) {
            // Throw a custom exception with the original message
                throw new ErrorException("Error getting overall Leaves: " . $e->getMessage());
            }

    }


    public function getTotalFees()
    {
        try {
            $currentMonth = date('m');
            $currentYear = date('Y');

            $totalFee = DB::connection('sqlsrv2')
            ->table('ClubMembersFee')
            ->whereRaw('MONTH(FeeDate) = ?', [$currentMonth])
            ->whereRaw('YEAR(FeeDate) = ?', [$currentYear])
            ->sum('FeeAmount');

            $totalMembers = DB::connection('sqlsrv2')
            ->table('ClubMembers')
            ->where('Status', '=', 'Register')
            ->count('id');

            $paidEmployeeCount = DB::connection('sqlsrv2')
            ->table('ClubMembersFee')
            ->where('Status', '=', 'paid')
            ->whereRaw('MONTH(FeeDate) = ?', [$currentMonth])
            ->whereRaw('YEAR(FeeDate) = ?', [$currentYear])
            ->count();


            $data = [
                'totalFee' => $totalFee,
                'totalMembers' => $totalMembers,
                'paidEmployeeCount' => $paidEmployeeCount,
            ];
            
            // Convert the data array to JSON
            
            
            // Return the JSON response
            return $data;

            } catch (QueryException $e) {
            // Throw a custom exception with the original message
                throw new ErrorException("Error getting overall Leaves: " . $e->getMessage());
            }

    }

}
