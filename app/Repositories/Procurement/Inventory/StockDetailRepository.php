<?php

namespace App\Repositories\Procurement\Inventory;

use App\Contracts\Repository\Procurement\Inventory\StockDetailRepositoryInterface;
use App\Contracts\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Exceptions\ErrorException;
class StockDetailRepository implements StockDetailRepositoryInterface
{
    protected $table;

    public function __construct()
    {
//        $this->table = 'tb_users';
    }

    public function count_available(){

    }

    public function available_stock($company_id){
        try {
            return DB::connection('sqlsrv3')
                ->table('Inventory')
                ->selectRaw('SUM(CASE WHEN Type % 2 != 0 THEN Quantity ELSE 0 END) as stock_in, SUM(CASE WHEN Type % 2 = 0 THEN Quantity ELSE 0 END) as stock_out')
                ->where('CompanyID', '=', $company_id)
                ->first();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available stock: " . $e->getMessage());
        }
    }

    public function  available_products($company_id){
        return DB::connection('sqlsrv3')
            ->table('Inventory as inv1')
            ->join('Inventory as inv2', function($join) use($company_id) {
                $join->on('inv1.ItemID', '=', 'inv2.ItemID')
                    ->where('inv2.CompanyID', '=', $company_id);
            })
            ->select('inv1.ItemID', DB::raw('SUM(CASE WHEN inv1.Type % 2 != 0 THEN inv1.Quantity ELSE 0 END) as product_in'), DB::raw('SUM(CASE WHEN inv1.Type % 2 = 0 THEN inv1.Quantity ELSE 0 END) as product_out'))
            ->where('inv1.CompanyID', '=', $company_id)
            ->groupBy('inv1.ItemID')
            ->havingRaw('SUM(CASE WHEN inv1.Type % 2 != 0 THEN inv1.Quantity ELSE 0 END) > SUM(CASE WHEN inv1.Type % 2 = 0 THEN inv1.Quantity ELSE 0 END)')
            ->get()
            ->count();
    }

//    Total products
    public function total_products($company_id){
        return DB::connection('sqlsrv3')->table('ItemList')->where('CompanyID', '=', $company_id)->count();
    }

//    Expired Item From Inventory
    public function expired_items($company_id, $today)
    {
        return DB::connection('sqlsrv3')->table('Inventory')->where('ItemExpiry', '<=', $today)->distinct('ItemID')->where('CompanyID', '=', $company_id)->count();
    }

}
