<?php


namespace App\Contracts\Repository\Procurement\Inventory;

interface StockDetailRepositoryInterface
{
    public function available_stock($company_id);
    public function count_available();
    public function available_products($company_id);
    public function total_products($company_id);
    public function expired_items($company_id, $today);

}
