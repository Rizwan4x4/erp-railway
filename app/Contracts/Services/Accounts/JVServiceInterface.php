<?php
namespace App\Contracts\Services\Accounts;
interface JVServiceInterface
{
    public function jv_detail();
    public function insert_jv($request);
    public function update_jvStatus($request);
    public function update_jv($request);
}
