<?php
namespace App\Services\Accounts;
use App\Contracts\Services\Accounts\JVServiceInterface;
use App\Exceptions\ErrorException;
use App\Repositories\Accounts\JurnalVoucherRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JurnalVoucherService implements JVServiceInterface
{
    protected $JurnalVoucherRepository;
    public function __construct(JurnalVoucherRepository $StockDetailRepository)
    {
        $this->JurnalVoucherRepository = $StockDetailRepository;
    }
    public function jv_detail()
    {
        try{
            return $this->JurnalVoucherRepository->all_JVs();
        }
        catch (ErrorException $e) {
            // Handle the custom exception here
            // Log the error or take any other necessary action
        Log::error('Custom Exception in JurnalVoucherService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
        throw $e;
        }
        catch (\Exception $e) {
            // Handle other exceptions here
            // Log the error or take any other necessary action
            Log::error('Exception in JurnalVoucherService: ' . $e->getMessage());

            // Rethrow the exception to propagate it to the controller
            throw $e;
        }
    }
    public function insert_jv($request){
        try {
            $req_prefix = $this->JurnalVoucherRepository->accounts_configuration()->JournalVocvher . '_' . shiftformat();
            $rid = $this->JurnalVoucherRepository->last_JV() ? (intval(explode("-", $this->JurnalVoucherRepository->last_JV()->JVID)[1]) + 1) : 1;
            $final_PoCode = $req_prefix . '-' . $rid;
            $narratio = explode("|", $request->narration);
            $data = [
                'CompanyID' => company_id(),
                'JVID' => $final_PoCode,
                'JVDate' => $request->dated,
                'TransactionAmount' => $request->total,
                'Narration' => $narratio[1],
                'CreatedBy' => username(),
                'CreatedOn' => long_date(),
                'Session' => ac_c_session(),
                'Status' => 'Pending'
            ];
            $result = $this->JurnalVoucherRepository->insert_intoJV($data);

            if($result){
                $jv_ByCode = $this->JurnalVoucherRepository->JV_byCode($final_PoCode)->JournalVoucherID;
                $head_name1 = explode("|", $request->head_name);
                $credi = explode("|", $request->credit);
                $debi = explode("|", $request->debit);
                $values = [];

                for ($x = 1; $x < count($head_name1); $x++) {
                    $acc_head = explode("_", $head_name1[$x]);
                    $values[] = [
                        'JournalVoucherID' => $jv_ByCode,
                        'AccountID' => $acc_head[0],
                        'AccountName' => $acc_head[1],
                        'Narration' => $narratio[$x],
                        'credit_amount' => $credi[$x],
                        'debit_amount' => $debi[$x]
                    ];
                }
                $this->JurnalVoucherRepository->insert_intoJVDetail($values);
            }

            $find_config = 'submitted';
            return $find_config;
        }
        catch (ErrorException $e) {
            Log::error('Custom Exception in JurnalVoucherService: ' . $e->getMessage());
            throw $e;
        }
        catch (\Exception $e) {
            Log::error('Exception in JurnalVoucherService: ' . $e->getMessage());
            throw $e;
        }
    }
    public function update_jvStatus($request){
        try{
            $id = $request->get('jv_id');
            $sts = $request->get('sts');
            $jvdetail = $this->JurnalVoucherRepository->jv_detail($id);
            $sumCreditAmount = 0;
            $sumDebitAmount = 0;
            ;
            foreach ($jvdetail as $jvdetail1){
                $sumCreditAmount += floatval($jvdetail1->credit_amount);
                $sumDebitAmount += floatval($jvdetail1->debit_amount);
            }
            if($sumCreditAmount != $sumDebitAmount){
                $message = "Credit and Debit Amount are not Equal!";
                return request()->json(200, $message);
            }
            else if($sumCreditAmount < 0 || $sumDebitAmount < 0 ){
                $find_config = 'Amount Cannot be Negative!';
                return request()->json(200, $find_config);
            }
            $data = [
                'CompanyID' => company_id(),
                'JournalVoucherID' => $id,
                'status' => $sts,
                'UpdatedBy' => username(),
                'updatedOn' => long_date(),
            ];
            $result = $this->JurnalVoucherRepository->update_jv_status($data);
            if($result){
                $jvbyId = $this->JurnalVoucherRepository->JV_byID($id);
                $jvbyIdDetails = $this->JurnalVoucherRepository->jv_detail($id);
                $final_PoCode = $jvbyId->JVID;
                $narrationVariable = '';

                foreach ($jvbyIdDetails as $item) {
                    $narrationVariable .= $item->Narration . "\n";
                }
                
                $narratio1 = $jvbyId->Narration;
                $data = [
                    short_date(),
                    $final_PoCode,
                    'Journal Voucher',
                    'Journal Voucher',
                    long_date(),
                    username(),
                    company_id()
                ];
                $data = [
                    'DocumentDate' => short_date(),
                    'DocumentNo' => $final_PoCode,
                    'Description' => 'Journal Voucher',
                    'DocumentComments' => NULL,
                    'InternalComment' => NULL,
                    'DocumentType' => 'Journal Voucher',
                    'InsertedAt' => long_date(),
                    'InsertedBy' => username(),
                    'UpdatedAt' => NULL,
                    'UpdatedBy' => NULL,
                    'CompanyID' => company_id(),
                    'PVID' => NULL,
                    'distributionid' => NULL
                ];
                $doc = insert_document($data);
                if($doc){
                    $find_doc_id1 = $this->JurnalVoucherRepository->Document_ByNo($final_PoCode);
                    $tra_data = [
                        $find_doc_id1->ID,
                        short_date(),
                        'JV Against ' . $narrationVariable,
                        company_id()
                    ];
                    $this->JurnalVoucherRepository->insert_transaction($tra_data);
                    $find_tran_id1 = $this->JurnalVoucherRepository->transaction_ByDocId($find_doc_id1->ID);

                    $find_jv_detail = $this->JurnalVoucherRepository->jv_detail($id);
                    $ledger_entries = [];
                    foreach ($find_jv_detail as $find_jv_detail1) {
                        $acc_head20 = $find_jv_detail1->AccountID;
                        $credi2 = $find_jv_detail1->credit_amount;
                        $debi2 = $find_jv_detail1->debit_amount;

                        if ($credi2 != 0) {
                            $ledger_entries[] = [
                                'TransactionID' => $find_tran_id1->ID, 'AccountID' => $acc_head20, 'EntryType' => 'C', 'Amount' => $credi2, 'CompanyID' => company_id()
                            ];
                        }
                        if ($debi2 != 0) {
                            $ledger_entries[] = [
                                'TransactionID' => $find_tran_id1->ID, 'AccountID' => $acc_head20, 'EntryType' => 'D', 'Amount' => $debi2, 'CompanyID' => company_id()
                            ];
                        }
                    }
                    $this->JurnalVoucherRepository->insert_ledger($ledger_entries);
                }
            }

            $message = "Status updated!";
            return request()->json(200, $message);
        }
        catch (ErrorException $e) {
        Log::error('Custom Exception in JurnalVoucherService: ' . $e->getMessage());
        throw $e;
        }
        catch (\Exception $e) {
            Log::error('Exception in JurnalVoucherService: ' . $e->getMessage());
            throw $e;
        }
    }
    public function update_jv($request)
    {
        try{
            if($request->total != $request->debit_total){
                $find_config = 'Credit and Debit values are not equal!';
                return request()->json(200, $find_config);
            }
            $jv_id = $request->get('jv_id');
            $narrations = explode("|", $request->narration);
            $data = [
                $request->dated,
                $request->total,
                $narrations[1],
                username(),
                long_date(),
                company_id(),
                $jv_id
            ];
            $result = $this->JurnalVoucherRepository->update_JV($data);
            if($result){
                $result1 = $this->JurnalVoucherRepository->delete_JV_detail($jv_id);
                if($result1){
                    $head_names = explode("|", $request->head_name);
                    $credits = explode("|", $request->credit);
                    $debits = explode("|", $request->debit);
                    $data1 = [];
                    for ($x = 1; $x < count($head_names); $x++) {
                        $acc_head = explode("_", $head_names[$x]);
                        $data1[] = [
                            'JournalVoucherID' => $jv_id,
                            'AccountID' => $acc_head[0],
                            'AccountName' => $acc_head[1],
                            'Narration' => $narrations[$x],
                            'credit_amount' => $credits[$x],
                            'debit_amount' => $debits[$x]
                        ];
                    }
                    $this->JurnalVoucherRepository->insert_intoJVDetail($data1);
                }
            }
            $find_config = 'submitted';
            return request()->json(200, $find_config);
        }
        catch (ErrorException $e) {
            Log::error('Custom Exception in JurnalVoucherService: ' . $e->getMessage());
            throw $e;
        }
        catch (\Exception $e) {
            Log::error('Exception in JurnalVoucherService: ' . $e->getMessage());
            throw $e;
        }
    }
}
