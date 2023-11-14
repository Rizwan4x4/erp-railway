<?php
namespace App\Repositories\Accounts;
use App\Contracts\Repository\Accounts\JVRepositoryInterface;
use App\Exceptions\ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
class JurnalVoucherRepository implements JVRepositoryInterface
{
    public function all_JVs()
    {
        try {
            return DB::connection('sqlsrv3')->table("JournalVoucher")->where('CompanyID', '=', company_id())
            ->where('Session', '=', ac_c_session())
            ->orderby('JournalVoucherID', 'desc')->paginate(20);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting available JV: " . $e->getMessage());
        }
    }
    public function accounts_configuration(){
        try{
            return DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('JournalVocvher')->where('CompanyID', '=', company_id())->first();
        } catch (QueryException $e) {
        throw new ErrorException("Error getting JV code from configuration: " . $e->getMessage());
        }
    }
    public function  last_JV(){
        try{
            return DB::connection('sqlsrv3')->table("JournalVoucher")->select('JVID')->orderByDesc('JournalVoucherID')->where('CompanyID', '=', company_id())->first();
        }
        catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting last JV Code: " . $e->getMessage());
        }
    }
    public function insert_intoJV($data){
        try{
            return DB::connection('sqlsrv3')->table('JournalVoucher')->insert($data);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
        throw new ErrorException("Error inserting JV: " . $e->getMessage());
        }
    }
    public function insert_intoJVDetail($data){
        try{
            return DB::connection('sqlsrv3')->table('JournalVoucherDetail')->insert($data);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
        throw new ErrorException("Error inserting JV detail: " . $e->getMessage());
        }
    }
    public function JV_byCode($code)
    {
        try{
            return DB::connection('sqlsrv3')->table("JournalVoucher")->select('JournalVoucherID')->where('CompanyID', '=', company_id())->where('JVID', $code)->first();
        } catch (QueryException $e) {
        // Throw a custom exception with the original message
        throw new ErrorException("Error getting JV by code: " . $e->getMessage());
        }
    }
    public function JV_byID($id)
    {
        try{
            return DB::connection('sqlsrv3')->table("JournalVoucher")->where('CompanyID', '=', company_id())->where('JournalVoucherID', $id)->first();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting JV by id: " . $e->getMessage());
        }
    }
    public function jv_detail($id){
        try{
            return DB::connection('sqlsrv3')->table("JournalVoucherDetail")->where('JournalVoucherID', $id)->get();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting JV detail: " . $e->getMessage());
        }
    }
    public function update_jv_status($data){
        try{
            //return DB::connection('sqlsrv3')->update('UPDATE JournalVoucher SET Status = :status, UpdatedBy = :updatedBy, UpdatedOn = :updatedOn WHERE CompanyID = :companyId AND JournalVoucherID = :journalVoucherId', $data);
            return DB::connection('sqlsrv3')
                ->table('JournalVoucher')
                ->where('CompanyID', $data['CompanyID'])
                ->where('JournalVoucherID', $data['JournalVoucherID'])
                ->update([
                    'Status' => $data['status'],
                    'UpdatedBy' => $data['UpdatedBy'],
                    'updatedOn' => $data['updatedOn']
                ]);


        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error updating JV: " . $e->getMessage());
        }
    }
    public function Document_ByNo($num){
        try{
            return DB::connection('sqlsrv3')->table("Documents")->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $num)->first();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting document by number: " . $e->getMessage());
        }
    }
    public function insert_transaction($data){
        try{
            return DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID, TransactionDate, Description, CompanyID) VALUES (?, ?, ?, ?)', $data);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error inserting transaction: " . $e->getMessage());
        }
    }
    public function transaction_ByDocId($id){
        try{
            return DB::connection('sqlsrv3')->table("Transactions")->where('CompanyID', '=', company_id())->where('DocumentID', '=', $id)->first();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting transaction by Documnt id: " . $e->getMessage());
        }
    }
    public function insert_ledger($data){
        try{
            return DB::connection('sqlsrv3')->table('Ledger_Entries')->insert($data);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error inserting ledger: " . $e->getMessage());
        }
    }
    public function JV_Bykeyword($request){
        try{
            return DB::connection('sqlsrv3')->table("JournalVoucher")->where('CompanyID', '=', company_id())->where('JVID','like','%'.$request->keyword1.'%')->orWhere('TransactionAmount','like','%'.$request->keyword1.'%')->orderby('JournalVoucherID', 'desc')->paginate(20);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting JV by keyword: " . $e->getMessage());
        }
    }
    public function jv_searchdate($datefrom, $dateto)
    {
        try{
            return DB::connection('sqlsrv3')->table("JournalVoucher")->where('CompanyID', '=', company_id())->where('JVDate', '>=', $datefrom)->where('JVDate', '<=', $dateto)->paginate(20);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting JV by date: " . $e->getMessage());
        }
    }
    public function jv_searchbyfilter($status)
    {
        try{
            return DB::connection('sqlsrv3')->table('JournalVoucher')->orderBy('JournalVoucherID', 'desc')->where('CompanyID', '=', company_id())->when($status !== 'All', function ($query) use ($status) {return $query->where('Status', '=', $status);})->paginate(20);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error getting JV by status: " . $e->getMessage());
        }
    }
    public function update_JV($data)
    {
        try{
            return DB::connection('sqlsrv3')->update("UPDATE JournalVoucher SET JVDate=?, TransactionAmount=?, Narration=?, UpdatedBy=?, UpdatedOn=? WHERE CompanyID=? AND JournalVoucherID=?", $data);
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error updating JV: " . $e->getMessage());
        }
    }
    public function delete_JV_detail($id)
    {
        try{
            return DB::connection('sqlsrv3')->table('JournalVoucherDetail')->where('JournalVoucherID', $id)->delete();
        } catch (QueryException $e) {
            // Throw a custom exception with the original message
            throw new ErrorException("Error deleting JV: " . $e->getMessage());
        }
    }
}
