<?php


namespace App\Contracts\Repository\Accounts;

interface JVRepositoryInterface
{
    public function all_JVs();
    public function accounts_configuration();
    public function last_JV();
    public function insert_intoJV($data);
    public function insert_intoJVDetail($data);
    public function JV_byCode($code);
    public function JV_byID($id);
    public function jv_detail($id);
    public function update_jv_status($data);
    public function update_JV($data);
    public function delete_JV_detail($id);
    public function insert_transaction($data);
    public function transaction_ByDocId($id);
    public function Document_ByNo($num);
    public function insert_ledger($data);
    public function JV_Bykeyword($request);
    public function jv_searchdate($datefrom, $dateto);
    public function jv_searchbyfilter($status);
}
