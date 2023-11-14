<?php

use App\Exceptions\ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

function accounts_c_session()
{
    $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->first();
    return $find_session->SessionName;
}

function company_id()
{
    return Session::get('company_id');
}

function paginateLedger($result, $currentPage, $perPage)
{
    // Convert array into a collection
    $collection = collect($result);
    // Apply pagination
    $paginatedData = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();
    $paginatedData = new LengthAwarePaginator($paginatedData, $collection->count(), $perPage, $currentPage);
    return $paginatedData;
}

function shiftformat()
{
    $year_fetch = date("y");
    $month_fetch = date("m");
    if ($month_fetch == 1) {
        $month = 'A';
    } else if ($month_fetch == 2) {
        $month = 'B';
    } else if ($month_fetch == 3) {
        $month = 'C';
    } else if ($month_fetch == 4) {
        $month = 'D';
    } else if ($month_fetch == 5) {
        $month = 'E';
    } else if ($month_fetch == 6) {
        $month = 'F';
    } else if ($month_fetch == 7) {
        $month = 'G';
    } else if ($month_fetch == 8) {
        $month = 'H';
    } else if ($month_fetch == 9) {
        $month = 'I';
    } else if ($month_fetch == 10) {
        $month = 'J';
    } else if ($month_fetch == 11) {
        $month = 'K';
    } else if ($month_fetch == 12) {
        $month = 'L';
    }
    return $month . $year_fetch;
}

function transaction_heads()
{
    $find_config = DB::connection('sqlsrv3')->table("Accounts")->select('ID', 'AccountName')->where('CoaType', '=', 'Transaction')->orderby('ID', 'asc')->get();
    return request()->json(200, $find_config);
}

function company_detail()
{
    return DB::table('tb_create_company')->orderBy('id', 'asc')->first();
}

function user_detail()
{
    $email = Session::get('username');
    return DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $email)->first();
}

function User()
{
    $username = Session::get('Username');
    return request()->json(200, $username);
}

function username()
{
    return Session::get('username');
}

function UserFullName()
{
    return Session::get('UserName');
}

function employee_id()
{
    return Session::get('employee_id');
}

function emp_department()
{
    return Session::get('employee_department');
}

function insert_sequencevoucher($final_PoCode, $pvid, $RefType)
{
    try {
        $result = DB::connection('sqlsrv3')->insert('INSERT INTO SequenceVoucher(PVID,RefID,RefType,CompanyID,MonthId) values (?,?,?,?,?)', [$final_PoCode, $pvid, $RefType, company_id(), shiftformat()]);
        if ($result) {
            $message = "inserted";
            return request()->json(200, $message);
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

}
function insert_payment_voucher($data){
    try {
       return DB::connection('sqlsrv3')
        ->table('PaymentVoucher')
        ->insertGetId($data);

    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() == 23000) {
            return response()->json(['message' => 'Payment Voucher Already Exists.'], 422);
        } else {
            throw $e;

        }
    }
}
function insert_payment_voucher_items($pv_items){
    try {
        DB::connection('sqlsrv3')
        ->table('PaymentVoucherDetail')
        ->insert($pv_items);
    } catch (\Throwable $th) {
        throw new ErrorException("Error inserting Payment Voucher Items: " . $th->getMessage());

    }
}
function insert_document($data)
{
    try {
        return DB::connection('sqlsrv3')->table('Documents')->insert($data);
    } catch (QueryException $e) {
        // Throw a custom exception with the original message
        throw new ErrorException("Error inserting document: " . $e->getMessage());
    }
}

function PVID()
{
    $date_pref = shiftformat();
    $find_prefix1 = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('PaymentVoucher')->where('CompanyID', '=', company_id())->orderBy('ConfigurationID', 'desc')->first();
    $find_rid9 = DB::connection('sqlsrv3')->table("SequenceVoucher")->where('CompanyID', '=', company_id())->exists();
    if ($find_rid9) {
        $find_rid1 = DB::connection('sqlsrv3')->table("SequenceVoucher")->where('CompanyID', '=', company_id())->orderBy('SvID', 'desc')->first();


        if ($find_rid1->MonthId == $date_pref) {
            $pre_id = explode("-", $find_rid1->PVID);
            $rid = $pre_id[1] + 1;
        } else {
            $rid = 1;

        }

    } else {
        $rid = 1;
    }
    $req_prefix = $find_prefix1->PaymentVoucher . '_' . $date_pref;
    $final_PoCode = $req_prefix . '-' . $rid;
    return request()->json(200, $final_PoCode);

}

function acc_config()
{
    return DB::connection('sqlsrv3')->table("AccountsConfiguration")->where('CompanyID', '=', company_id())->first();
}

function ac_c_session()
{
    $find_session1 = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->first();
    return request()->json(200, $find_session1->SessionName);
}

function hr_closed_session()
{
    return DB::connection('sqlsrv2')->table('HrSessions')->orderBy('SessionID', 'desc')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->first();
}

function hr_current_session()
{
    return DB::connection('sqlsrv2')->table('HrSessions')->orderBy('SessionID', 'desc')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->first();
}

function get_remaining_items($items)
{
    $company_id = Session::get('company_id');
    $ItemDetail = [];
    foreach ($items as $item) {
        //$ItemId = $item['itemId'];
        //$qty = $item['Quantity'];
        $result10 = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[RemainingItem_companywise] @id = " . $item['itemId'] . ",@compID = N'" . $company_id . "' ");
        if ($result10) {
            foreach ($result10 as $result101) {
            }
            $formatted_number = number_format($result101->Remaining, 4);
//            dd($item['itemId'].' - '.$formatted_number);
            if ($formatted_number < $item['Quantity']) {
                array_push($ItemDetail, (object)$item);
            }
        } else {
            array_push($ItemDetail, (object)$item);
        }
    }
    //dd($ItemDetail);
    return $ItemDetail;
}

function generateNextId($table, $column)
{
    $rid = 1;
    if (DB::connection('sqlsrv3')->table($table)->where('CompanyID', '=', company_id())->exists()) {
        // Detect primary key column
        $primaryKeyColumns = DB::connection('sqlsrv3')->getDoctrineConnection()->getSchemaManager()->listTableDetails($table)->getPrimaryKey()->getColumns();
        $primaryKey = reset($primaryKeyColumns);
        // Use a database lock
        DB::connection('sqlsrv3')->beginTransaction();
        try {
            $find_rid1 = DB::connection('sqlsrv3')->table($table)
                ->select($column)
                ->orderBy($primaryKey, 'desc')
                ->where('CompanyID', '=', company_id())
                ->lockForUpdate()
                ->value($column);
            $rid = (int)explode("-", $find_rid1)[1] + 1;
            DB::connection('sqlsrv3')->commit();
        } catch (\Exception $e) {
            DB::connection('sqlsrv3')->rollback();
            throw $e;
        }
    }
    return $rid;
}

function short_date()
{
    return date("Y-m-d");
}

function long_date()
{
    return date("Y-m-d h:i:s A");
}

function insertLog($status, $description)
{
    return DB::table('Activity_Log')->insert([
        'CompanyId' => company_id(),
        'UserEmail' => username(),
        'EmployeeName' => UserFullName(),
        'EmployeeID' => employee_id(),
        'EventStatus' => $status,
        'Description' => $description,
        'ActivityTime' => long_date()
    ]);
}

function insertRecord($table, $prefix, $rid, $request, $status2, $rId, $demandReqID = null)
{
//$reqID = $this->insertRecord('Requisition', $final_rido, $rid, $request, $request->status, $rId = 'RequisitionId', $demandReqID);
    $status = ($status2 == 'Services') ? 'Not Completed' : NULL;
    $requisitionId = '';
    try {
        DB::connection('sqlsrv3')->statement('SET IDENTITY_INSERT ' . $table . ' ON');
        // insert and get id
        $requisitionId = DB::connection('sqlsrv3')->table($table)->insertGetId([
            'CompanyID' => company_id(),
            $rId => $prefix,// . '-' . $rid,
            'Dated' => $request->date,
            'DepartmentName' => $request->dept_name,
            'ProjectName' => $request->project_name,
            'Status' => 'Pending',
            'Narration' => $request->narration,
            'CreatedBy' => username(),
            'CreatedOn' => long_date(),
            'Session' => ac_c_session(),
            'RequisitionType' => $request->status,
            'Status2' => $status,
            'DemandRID' => $demandReqID,
        ]);
        DB::connection('sqlsrv3')->statement('SET IDENTITY_INSERT ' . $table . ' OFF');
    } catch (\Exception $e) {
        DB::connection('sqlsrv3')->statement('SET IDENTITY_INSERT ' . $table . ' OFF');
        // Handle exception
    }
    return $requisitionId;
}

function reporting_team()
{
    return DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC   [dbo].[Get_reporting_tree] @id = N'" . employee_id() . "', @companyid = N'" . company_id() . "' ");
}
function secondConDb(){
    return config('database.connections.sqlsrv2')['database'];
}

function company_logo()
{
    return DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->first();
}

function isLive(){
    return (env('APP_ENV') === 'live');
}
function company_prefix(){
    return DB::table('tb_create_company')->select('company_prefix')->where('company_id', '=', company_id())->first();
}

