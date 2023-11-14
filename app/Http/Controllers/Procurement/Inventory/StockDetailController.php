<?php

namespace App\Http\Controllers\Procurement\Inventory;

use App\Contracts\Repository\Procurement\Inventory\StockDetailRepositoryInterface;
use App\Contracts\Services\Procurement\Inventory\StockDetailServiceInterface;
use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Session;


class StockDetailController extends Controller
{
    use CommonTrait;

    protected $stockdetailServiceInterface;
    protected $stockdetailRepository;

    public function __construct(StockDetailServiceInterface $stockdetailServiceInterface, StockDetailRepositoryInterface $stockdetailRepository)
    {
        $this->stockdetailServiceInterface = $stockdetailServiceInterface;
        $this->stockdetailRepository = $stockdetailRepository;
    }


    public function count_available(){

        try {
//            $company_id = '632462982ad6e';
            $company_id = Session::get('company_id');

            $available_stock = $this->stockdetailServiceInterface->available_stock($company_id);

            $today = date("Y-m-d h:i:s A");

            $total_products = $this->stockdetailRepository->total_products($company_id);

            $expired_items = $this->stockdetailRepository->expired_items($company_id, $today);


            $available_products = $this->stockdetailServiceInterface->available_products($company_id, $total_products);

            $not_available = $total_products - $available_products;

            return $this->sendSuccess('Stock Count Fetch Successfully .', [
                'available_stock' => number_format($available_stock),
                'total_products' => $total_products,
                'available_products' => $available_products,
                'not_available' => $not_available,
                'expired_items' => $expired_items,
            ]);
        } catch (\Exception $e) {
//            dd($e->getMessage());
            // Handle other exceptions here
            // For example, you can log the error and return a default response
            Log::error('Unhandled Exception: ' . $e->getMessage());
            return response()->json($e->getMessage());
        }


    }

}
