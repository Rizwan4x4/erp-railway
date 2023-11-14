<?php


namespace App\Contracts\Services\Procurement\Inventory;

interface StockDetailServiceInterface
{
    public function available_stock($company_id);
    public function count_available();
    public function available_products($company_id, $total_products);

}
