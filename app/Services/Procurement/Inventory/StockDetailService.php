<?php

namespace App\Services\Procurement\Inventory;

use App\Contracts\Repository\Procurement\Inventory\StockDetailRepositoryInterface;
use App\Contracts\Services\Procurement\Inventory\StockDetailServiceInterface;
use App\Contracts\Repository\UserRepositoryInterface;
use App\Exceptions\ErrorException;
use App\Repositories\Procurement\Inventory\StockDetailRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockDetailService implements StockDetailServiceInterface
{
    protected $StockDetailRepository;

    public function __construct(StockDetailRepository $StockDetailRepositoryInterface)
    {
        $this->StockDetailRepository = $StockDetailRepositoryInterface;
    }

    public function count_available(){

    }

    public function available_stock($company_id){
        try {
            $stock = $this->StockDetailRepository->available_stock($company_id);
            return $stock->stock_in - $stock->stock_out;
        } catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
            Log::error('Custom Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        } catch (\Exception $e) {
            // Handle other exceptions here
            // Log the error or take any other necessary action
            Log::error('Exception in YourService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }

    }

    public function available_products($company_id, $total_products){
        $available_products = $this->StockDetailRepository->available_products($company_id);
        return $total_products - $available_products;


    }


}
