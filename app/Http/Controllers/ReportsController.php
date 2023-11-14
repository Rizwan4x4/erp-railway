<?php

namespace App\Http\Controllers;

use Session;
use DB;
use Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\CustomFpdf;

class ReportsController extends Controller
{
    protected $fpdf;
    protected $customFpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
        $this->customFpdf = new CustomFpdf();
        $this->fpdf->SetAutoPageBreak(true);
        $this->fpdf->SetLeftMargin(10);

    }

    public function fetch_product_category1()
    {

        $find_config = DB::connection('sqlsrv3')->table("ItemCategory")->where('CompanyID', '=', company_id())->orderby('CategoryName', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public function DemandRequisition_Letter1($dept, $rid, $proj, $item, $startingdate, $enddate)
    {
        $this->fpdf->AddPage("L", ['280', '282']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }


        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(110, 17, 'Demand Requisition Report');
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 235, 7, 43, 15);

        $this->fpdf->ln(15);


        $this->fpdf->SetFont('Times', '', 10);
        $this->fpdf->Text(200, 33, 'Date From:');
        $this->fpdf->Text(221, 33, $startingdate);
        $this->fpdf->Text(200, 40, 'Date To:');
        $this->fpdf->Text(221, 40, $enddate);


        $this->fpdf->ln(19);

        $this->fpdf->Cell(18, 6, 'Dated', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Demand #', 1, 0, 'C', 0);
        $this->fpdf->Cell(45, 6, 'Department', 1, 0, 'C', 0);
        $this->fpdf->Cell(35, 6, 'Project', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Req. Type', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Status', 1, 0, 'C', 0);

        $this->fpdf->SetX(175);

        $this->fpdf->Cell(50, 6, 'Item Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Qty', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Unit', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Price', 1, 1, 'C', 0);

        $find = 0;
        if ($dept == 'All' && $rid == 'All' && $proj == 'All' && $startingdate != '' && $enddate != '') {
            $data = DB::connection('sqlsrv3')->table("DemandRequisition")->where("CompanyID", "=", company_id())->where('Dated', '>=', $startingdate)->where('Dated', '<=', $enddate)->get();
            $find = $data;
        } else {
            if ($dept == 'All') {
                $dept = '';
            }

            if ($proj == 'All') {
                $proj = '';
            }
            if ($rid == 'All') {
                $data = DB::connection('sqlsrv3')->table("DemandRequisition")->where("CompanyID", "=", company_id())->where("DepartmentName", 'like', '%' . $dept . '%')->where("ProjectName", 'like', '%' . $proj . '%')->where('Dated', '>=', $startingdate)->where('Dated', '<=', $enddate)->get();
                $find = $data;
            } else {
                $data = DB::connection('sqlsrv3')->table("DemandRequisition")->where("CompanyID", "=", company_id())->where("DepartmentName", 'like', '%' . $dept . '%')->where("ProjectName", 'like', '%' . $proj . '%')->where("RId", '=', $rid)->where('Dated', '>=', $startingdate)->where('Dated', '<=', $enddate)->get();
                $find = $data;
            }

        }
        foreach ($find as $find_config1) {
            if ($item != 'All') {
                $arr = DB::connection('sqlsrv3')->table("DemandRequisitionItem")->where("ReqID", '=', $find_config1->RequisitionId)->where('itemId', '=', $item)->get();

            } else {

                $arr = DB::connection('sqlsrv3')->table("DemandRequisitionItem")->where("ReqID", '=', $find_config1->RequisitionId)->get();
            }


            $this->fpdf->Cell(18, 6, $find_config1->Dated, 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, $find_config1->RId, 0, 0, 'L', 0);
            $this->fpdf->Cell(45, 6, Str::substr($find_config1->DepartmentName, 0, 30), 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, Str::substr($find_config1->ProjectName, 0, 20), 0, 0, 'L', 0);
            $this->fpdf->Cell(20, 6, $find_config1->RequisitionType, 0, 0, 'L', 0);
            $this->fpdf->Cell(20, 6, $find_config1->Status, 0, 0, 'L', 0);


            foreach ($arr as $arr1) {
                $this->fpdf->SetX(175);


                $this->fpdf->Cell(50, 6, (Str::substr($arr1->ItemName, 0, 35)), 0, 0, 'L', 0);
                $this->fpdf->Cell(15, 6, number_format($arr1->Quantity), 0, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, $arr1->unit, 0, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->EstCost), 0, 1, 'C', 0);

            }
            $this->fpdf->ln(15);


        }
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->ln(2);
        $this->fpdf->Output();
        exit;
    }

    public function item_ageing_report($start_date, $end_date, $item_name)
    {
        if ($item_name == 'All') {
            $item_name = '';
        }
        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[Item_Aging_Report_Issuance]
 @DateFrom  = N'" . $start_date . "',
 @DateTo  = N'" . $end_date . "',
 @Item  = '" . $item_name . "'");

        return request()->json(200, $result);
    }

    public function BalanceSheet_CurrentAssets($start_date, $end_date)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[BalanceSheet_CurrentAssets]
     @DateFrom = N'" . $start_date . "',
     @DateTo = N'" . $end_date . "'");

        return request()->json(200, $result);

    }

    public function BalanceSheet_CurrentLiabiities($start_date, $end_date)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[BalanceSheet_CurrentLiabiities]
     @DateFrom = N'" . $start_date . "',
     @DateTo = N'" . $end_date . "'");

        return request()->json(200, $result);

    }

    public function BalanceSheet_NonCurrentLiabiities($start_date, $end_date)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[BalanceSheet_NonCurrentLiabiities]
     @DateFrom = N'" . $start_date . "',
     @DateTo = N'" . $end_date . "'");

        return request()->json(200, $result);

    }

    public function BalanceSheet_ShareCapitalandReserves($start_date, $end_date)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[BalanceSheet_ShareCapitalandReserves]
     @DateFrom = N'" . $start_date . "',
     @DateTo = N'" . $end_date . "'");

        return request()->json(200, $result);

    }

    public function Balancesheet_TotalProfit($start_date, $end_date)
    {

        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[Balancesheet_TotalProfit]
     @DateFrom = N'" . $start_date . "',
     @DateTo = N'" . $end_date . "'");

        return request()->json(200, $result);

    }

    public function BalanceSheet_NonCurrentAssets($start_date, $end_date)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[BalanceSheet_NonCurrentAssets]
     @DateFrom = N'" . $start_date . "',
     @DateTo = N'" . $end_date . "'");

        return request()->json(200, $result);

    }

    public function item_averagecost_value($item)
    {

        if ($item == 'All') {
            $item = '';
        }

        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[Get_Item_AverageCostValue]
    @CompanyID   = '" . company_id() . "',
    @itemname   = '" . $item . "'");

        return request()->json(200, $result);
    }

    public function consumptionanalysis_report($start_date, $end_date, $item_name, $dept, $proj)
    {
        if ($item_name == 'All') {
            $item_name = '';
        }
        if ($dept == 'All') {
            $dept = '';
        }
        if ($proj == 'All') {
            $proj = '';
        }
        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[Item_Issuance_Report_department]
     @department   = '" . $dept . "',
     @project  = '" . $proj . "',
     @item   = '" . $item_name . "',
     @datefrom   = N'" . $start_date . "',
     @dateto   = N'" . $end_date . "'");

        return request()->json(200, $result);
    }

    public function unit_refunds_letter($id)
    {

        $this->fpdf->AddPage("P", ['210', '297']);
        $this->fpdf->SetFont('Times', 'B', 22);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }

        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 85, 10, 35, 17);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->Text(80, 35, 'Payment Voucher');
        $this->fpdf->SetFont('Times', 'B', 14);
        $this->fpdf->Text(90, 40, 'Cancellation');
        $arr = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('ID', '=', $id)->get();
        foreach ($arr as $arr1) {

        }

        $arr9 = DB::connection('sqlsrv3')->table('Ledger_Entries')->where('VendorID7', '=', $id)->where('EntryType', '=', 'D')->get();
        $arr8 = DB::connection('sqlsrv3')->table('Ledger_Entries')->where('VendorID7', '=', $id)->where('EntryType', '=', 'C')->get();


        $date = explode(" ", $arr1->DateTime);
        $this->fpdf->SetFont('Times', 'B', 14);
        $this->fpdf->Cell(105, 6, '', 0, 0, 'R', 0);
        $this->fpdf->SetTextColor(41, 46, 46);

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->ln(5);
        $this->fpdf->Cell(130, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Date:', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, $date[0], 0, 1, 'C', 0);
        $this->fpdf->Cell(130, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Receipt No:', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, $arr1->ReceiptNo, 0, 1, 'C', 0);
        $this->fpdf->Cell(130, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Instrument:', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, '', 0, 1, 'C', 0);
        $this->fpdf->Cell(130, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Instrument Date:', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, '', 0, 1, 'C', 0);
        $this->fpdf->ln(10);
        $this->fpdf->Cell(33, 6, 'Account ID', 0, 0, 'L', 0);
        $this->fpdf->Cell(45, 6, 'GL Name', 0, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Debit', 0, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Credit', 0, 0, 'C', 0);
        $this->fpdf->Cell(40, 6, 'Description', 0, 1, 'C', 0);
        $this->fpdf->SetFont('Times', '', 10);

        foreach ($arr9 as $arr91) {
            $this->fpdf->Cell(33, 10, $arr91->AccountID, 0, 0, 'L', 0);
            $find_acc_name = DB::connection('sqlsrv3')->table('Accounts')->where('ID', '=', $arr91->AccountID)->get();
            foreach ($find_acc_name as $find_acc_name1) {

            }

            $this->fpdf->Cell(45, 10, substr($find_acc_name1->AccountName, 0, 35), 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, $arr91->Amount, 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, '-', 0, 0, 'C', 0);
            $this->fpdf->MultiCell(40, 6, 'Against Cancellation of Plot No:' . $arr1->File_Plot_Number . ' Block:' . $arr1->Block . 'due to not paymeny with 10% deduction', 0, 'L', false);
        }
        foreach ($arr8 as $arr81) {
            $this->fpdf->Cell(33, 10, $arr81->AccountID, 0, 0, 'L', 0);
            $find_acc_name = DB::connection('sqlsrv3')->table('Accounts')->where('ID', '=', $arr81->AccountID)->get();
            foreach ($find_acc_name as $find_acc_name1) {

            }

            $this->fpdf->Cell(45, 10, substr($find_acc_name1->AccountName, 0, 35), 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, '-', 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, $arr81->Amount, 0, 0, 'C', 0);

            $this->fpdf->MultiCell(40, 6, 'Against Cancellation of Plot No:' . $arr1->File_Plot_Number . ' Block:' . $arr1->Block . 'due to not paymeny with 10% deduction', 0, 'L', false);
        }


        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(75, 10, 'Total Amount', 0, 0, 'L', 0);
        $this->fpdf->Cell(30, 10, $arr91->Amount, 0, 0, 'C', 0);
        $this->fpdf->Cell(30, 10, $arr91->Amount, 0, 1, 'C', 0);

        $this->fpdf->MultiCell(160, 6, 'Amounts In Words: ' . $this->numberToWord($arr91->Amount) . ' Rupees Only', 0, 'L', false);

        $this->fpdf->ln(15);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(60, 6, 'Paid By:', 0, 0, 'L', 0);
        $this->fpdf->Cell(60, 6, 'Supervised By:', 0, 0, 'C', 0);
        $this->fpdf->Cell(60, 6, 'Received By:', 0, 1, 'R', 0);
        $fetch_paid_detail = DB::connection('sqlsrv3')->table('UnitCashCounter')->where('UserID', $arr1->Userid)->get();
        foreach ($fetch_paid_detail as $fetch_paid_detail1) {

        }


        $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $arr1->UpdatedBy)->get();
        foreach ($fetch_user_detail as $fetch_user_detail1) {

        }


        $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);
        $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'C', 0);


        $this->fpdf->Cell(60, 6, '___________________', 0, 1, 'R', 0);


        $this->fpdf->Output();
        exit;
    }

    public function unit_refunds_amount_letter($id)
    {

        $this->fpdf->AddPage("P", ['210', '297']);
        $this->fpdf->SetFont('Times', 'B', 22);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }

        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 85, 10, 35, 17);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->Text(80, 35, 'Payment Voucher');
        $this->fpdf->SetFont('Times', 'B', 14);
        $this->fpdf->Text(90, 40, 'Cancellation');
        $arr = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('ID', '=', $id)->get();
        foreach ($arr as $arr1) {

        }

        $arr9 = DB::connection('sqlsrv3')->table('Ledger_Entries')->where('VendorID7', '=', $id)->where('EntryType', '=', 'D')->get();
        $arr8 = DB::connection('sqlsrv3')->table('Ledger_Entries')->where('VendorID7', '=', $id)->where('EntryType', '=', 'C')->get();


        $date = explode(" ", $arr1->DateTime);
        $this->fpdf->SetFont('Times', 'B', 14);
        $this->fpdf->Cell(105, 6, '', 0, 0, 'R', 0);
        $this->fpdf->SetTextColor(41, 46, 46);

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->ln(5);
        $this->fpdf->Cell(200, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Date:', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, $date[0], 0, 1, 'C', 0);
        $this->fpdf->Cell(200, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Receipt No:', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, $arr1->ReceiptNo, 0, 1, 'C', 0);
        $this->fpdf->Cell(200, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Instrument:', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, '', 0, 1, 'C', 0);
        $this->fpdf->Cell(200, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Instrument Date:', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, '', 0, 1, 'C', 0);
        $this->fpdf->ln(10);
        $this->fpdf->Cell(33, 6, 'Account ID', 0, 0, 'L', 0);
        $this->fpdf->Cell(45, 6, 'GL Name', 0, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Debit', 0, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Credit', 0, 0, 'C', 0);
        $this->fpdf->Cell(40, 6, 'Description', 0, 1, 'C', 0);
        $this->fpdf->SetFont('Times', '', 10);

        foreach ($arr9 as $arr91) {
            $this->fpdf->Cell(33, 10, $arr91->AccountID, 0, 0, 'L', 0);
            $find_acc_name = DB::connection('sqlsrv3')->table('Accounts')->where('ID', '=', $arr91->AccountID)->get();
            foreach ($find_acc_name as $find_acc_name1) {

            }

            $this->fpdf->Cell(45, 10, substr($find_acc_name1->AccountName, 0, 35), 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, $arr91->Amount, 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, '-', 0, 0, 'C', 0);
            $this->fpdf->MultiCell(40, 6, 'Against Cancellation of Plot No:' . $arr1->File_Plot_Number . ' Block:' . $arr1->Block . 'due to not paymeny with 10% deduction', 0, 'L', false);
        }
        foreach ($arr8 as $arr81) {
            $this->fpdf->Cell(33, 10, $arr81->AccountID, 0, 0, 'L', 0);
            $find_acc_name = DB::connection('sqlsrv3')->table('Accounts')->where('ID', '=', $arr81->AccountID)->get();
            foreach ($find_acc_name as $find_acc_name1) {

            }

            $this->fpdf->Cell(45, 10, substr($find_acc_name1->AccountName, 0, 35), 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, '-', 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, $arr81->Amount, 0, 0, 'C', 0);

            $this->fpdf->MultiCell(40, 6, 'Against Cancellation of Plot No:' . $arr1->File_Plot_Number . ' Block:' . $arr1->Block . 'due to not paymeny with 10% deduction', 0, 'L', false);
        }


        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(75, 10, 'Total Amount', 0, 0, 'L', 0);
        $this->fpdf->Cell(30, 10, $arr91->Amount, 0, 0, 'C', 0);
        $this->fpdf->Cell(30, 10, $arr91->Amount, 0, 1, 'C', 0);

        $this->fpdf->MultiCell(160, 6, 'Amounts In Words: ' . $this->numberToWord($arr91->Amount) . ' Rupees Only', 0, 'L', false);

        $this->fpdf->ln(15);
        $this->fpdf->SetFont('Times', 'B', 12);
        //$this->fpdf->Cell(60,6,'Paid By:',0,0,'L',0);
        $this->fpdf->Cell(60, 6, 'Supervised By:', 0, 0, 'C', 0);
        $this->fpdf->Cell(60, 6, 'Received By:', 0, 1, 'R', 0);
        //       $fetch_paid_detail=DB::connection('sqlsrv3')->table('UnitCashCounter')->where('UserID',$arr1->Userid)->get();
        // foreach ($fetch_paid_detail as $fetch_paid_detail1) {
        //
        //   }


        $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $arr1->UpdatedBy)->get();
        foreach ($fetch_user_detail as $fetch_user_detail1) {

        }


//$this->fpdf->Cell(60,6,$fetch_paid_detail1->Name,0,0,'L',0);
        $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'C', 0);


        $this->fpdf->Cell(60, 6, '___________________', 0, 1, 'R', 0);


        $this->fpdf->Output();
        exit;
    }

    public function company_salary_report()
    {
        $page = $sr = 1;
        $row = 0;
        $finance_empreg_query = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', hr_closed_session()->SessionName)->where('PayrollFinanceApproval.IsDeleted', '=', 0);

        $finance_empreg_query1 = clone $finance_empreg_query;
        $finance_empreg_query2 = clone $finance_empreg_query;
        $check = $finance_empreg_query1->exists();
        if ($check) {
            $result = $finance_empreg_query2->whereNotNull('Emp_Register.CompanyName')->select('Emp_Register.CompanyName')->groupBy('Emp_Register.CompanyName')->orderby('Emp_Register.CompanyName', 'asc')->get();
//            dd($result);
            $this->fpdf->AddPage("L", ['280', '297']);
            $this->fpdf->Image('public/images/logo/' . company_logo()->RightLogo, 10, 12, 40, 12);
            $this->fpdf->Image('public/images/logo/sasystems.png', 254, 2, 34, 35);
            $this->fpdf->ln(0);
            // table 2

            $this->fpdf->SetFont('Times', 'B', 18);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->MultiCell(280, 10, 'Company Salary Report' . "\n" . Carbon::parse(hr_closed_session()->EndDate)->format('F-Y'), 0, 'C', false);

            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
            $this->fpdf->Cell(53, 6, 'Company Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(24, 6, 'Gross Salary', 1, 0, 'C', 0);
            $this->fpdf->Cell(18, 6, 'Tax', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Loan', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Advance', 1, 0, 'C', 0);
            $this->fpdf->Cell(23, 6, 'Deduction', 1, 0, 'C', 0);
            $this->fpdf->Cell(23, 6, 'Allowance', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Fuel', 1, 0, 'C', 0);
            $this->fpdf->Cell(18, 6, 'Arrears', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Stipend', 1, 0, 'C', 0);
            $this->fpdf->Cell(28, 6, 'Net Payable', 1, 1, 'C', 0);
            $this->fpdf->SetFont('', '', 10);

            $finance_empreg_query3 = [];
            foreach ($result as $index => $result1) {
                $finance_empreg_query3[$index] = clone $finance_empreg_query;
                $fetch_detail = $finance_empreg_query3[$index]->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->whereIn('Emp_Register.Status', ['Registered', 'Suspended'])->get([DB::raw('SUM(PayrollFinanceApproval.TAmount) AS grosssalary'), DB::raw('SUM(PayrollFinanceApproval.FuelAmount) AS fuel'), DB::raw('SUM(PayrollFinanceApproval.TaxAmount) AS tax'), DB::raw('SUM(PayrollFinanceApproval.InstallmentAmount) AS loan'), DB::raw('SUM(PayrollFinanceApproval.AdvanceAmount) AS advance'), DB::raw('SUM(DuesAmount) AS deduction'), DB::raw('SUM(PayrollFinanceApproval.AllowanceAmount) AS allowance'), DB::raw('SUM(PayrollFinanceApproval.ArrearsAmount) AS arrear'), DB::raw('SUM(PayrollFinanceApproval.StipendAmount) AS stipend'), DB::raw('SUM(PayrollFinanceApproval.PayableSalary) AS payable')]);

                $for_sum_query = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', hr_closed_session()->SessionName)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->whereNotNull('Emp_Register.CompanyName');

                $gross_salary_sum = $for_sum_query->sum('PayrollFinanceApproval.TAmount');
                $tax_sum = $for_sum_query->sum('PayrollFinanceApproval.TaxAmount');
                $loan_sum = $for_sum_query->sum('PayrollFinanceApproval.InstallmentAmount');
                $advance_sum = $for_sum_query->sum('PayrollFinanceApproval.AdvanceAmount');
                $dedu_sum = $for_sum_query->sum('PayrollFinanceApproval.DuesAmount');
                $allowance_sum = $for_sum_query->sum('PayrollFinanceApproval.AllowanceAmount');
                $arrear_sum = $for_sum_query->sum('PayrollFinanceApproval.ArrearsAmount');
                $stipend_sum = $for_sum_query->sum('PayrollFinanceApproval.StipendAmount');
                $payable_sum = $for_sum_query->sum('PayrollFinanceApproval.PayableSalary');
                $fuel_sum = $for_sum_query->sum('PayrollFinanceApproval.FuelAmount');

                //  $find_salary_sum=$salary_sum;
                $Array = Arr::flatten($fetch_detail);
                foreach ($Array as $get_req1) {
                    $this->fpdf->SetFillColor(237, 240, 238);
                    $rowStyle = $row % 2 == 0 ? 0 : 1;
                    $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', $rowStyle);
                    $this->fpdf->Cell(53, 6, Str::substr($result1->CompanyName, 0, 40), 1, 0, 'L', $rowStyle);
                    $this->fpdf->Cell(24, 6, number_format($get_req1->grosssalary), 1, 0, 'R', $rowStyle);
                    $this->fpdf->Cell(18, 6, number_format($get_req1->tax), 1, 0, 'R', $rowStyle);
                    $this->fpdf->Cell(20, 6, number_format($get_req1->loan), 1, 0, 'R', $rowStyle);
                    $this->fpdf->Cell(20, 6, number_format($get_req1->advance), 1, 0, 'R', $rowStyle);
                    $this->fpdf->Cell(23, 6, number_format($get_req1->deduction), 1, 0, 'R', $rowStyle);
                    $this->fpdf->Cell(23, 6, number_format($get_req1->allowance), 1, 0, 'R', $rowStyle);
                    $this->fpdf->Cell(20, 6, number_format($get_req1->fuel), 1, 0, 'R', $rowStyle);
                    $this->fpdf->Cell(18, 6, number_format($get_req1->arrear), 1, 0, 'R', $rowStyle);
                    $this->fpdf->Cell(20, 6, number_format($get_req1->stipend), 1, 0, 'R', $rowStyle);
                    $this->fpdf->Cell(28, 6, number_format($get_req1->payable), 1, 1, 'R', $rowStyle);
                    $row++;
                }
                $sr++;
            }
            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(62, 6, 'Grand Total: ', 1, 0, 'R', 0);
            $this->fpdf->Cell(24, 6, number_format($gross_salary_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(18, 6, number_format($tax_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(20, 6, number_format($loan_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(20, 6, number_format($advance_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(23, 6, $dedu_sum . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(23, 6, number_format($allowance_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(20, 6, number_format($fuel_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(18, 6, number_format($arrear_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(20, 6, number_format($stipend_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(28, 6, number_format($payable_sum) . '/-', 1, 1, 'R', 0);
            $this->fpdf->SetFont('', '', 10);
            $this->fpdf->Cell(100, 6, 'Gross Salary = Basic Salary + Bonuses + Attendance Adjustment', 0, 1, 'L', 0);
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('', 'B', 12);
            $this->fpdf->Cell(40, 6, 'Prepared By:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, 'Accounts:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, 'Director HR:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 1, 'L', 0);
            $this->fpdf->ln(15);
            $this->fpdf->Cell(40, 6, '', 0, 0, 'R', 0);
            $this->fpdf->Cell(30, 6, 'CEO: ', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, 'Chairman:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);

            $this->fpdf->SetY(-10);
            $this->fpdf->Cell(280, 6, $page, 0, 1, 'C', 0);
            foreach ($result as $index1 => $result1) {
                $department_list_query = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->select('Emp_Register.Department')->groupBy('Emp_Register.Department')->where('PayrollFinanceApproval.SessionName', '=', hr_closed_session()->SessionName)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->whereNotNull('Emp_Register.Department')->where('Emp_Register.CompanyName', '=', $result1->CompanyName);
                $department_list_query1 = clone $department_list_query;
                $department_list_query2 = clone $department_list_query;
                $department_list = $department_list_query1->get();
                $department_check = $department_list_query2->exists();
                if ($department_check) {
                    $sum_emp_allowance = [];
                    $sum_emp_deduc = [];
                    $sum_emp_t = [];
                    $sum_emp_tax = [];
                    $sum_emp_loan = [];
                    $sum_emp_stipend = [];
                    $sum_emp_arrear = [];
                    $sum_emp_payable = [];
                    $sum_emp_advance = [];
                    $sum_emp_fuel = [];

                    $this->fpdf->AddPage("L", ['280', '297']);
                    $this->fpdf->SetFont('Times', 'B', 15);
                    $this->fpdf->ln(5);
                    $sr = 1;
                    $row = 0;
                    foreach ($department_list as $department_list1) {
                        $for_sum_query1 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', hr_closed_session()->SessionName)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName);

                        $for_sum_query2 = clone $for_sum_query1;

                        $stipend_sum1 = $for_sum_query1->sum('PayrollFinanceApproval.StipendAmount');
                        $deduc_sum1 = $for_sum_query1->sum('PayrollFinanceApproval.DuesAmount');
                        $allowance_sum1 = $for_sum_query1->sum('PayrollFinanceApproval.AllowanceAmount');
                        $t_sum1 = $for_sum_query1->sum('PayrollFinanceApproval.TAmount');
                        $tax_sum1 = $for_sum_query1->sum('PayrollFinanceApproval.TaxAmount');
                        $loan_sum1 = $for_sum_query1->sum('PayrollFinanceApproval.InstallmentAmount');
                        $advance_sum1 = $for_sum_query1->sum('PayrollFinanceApproval.AdvanceAmount');
                        $arears_sum1 = $for_sum_query1->sum('PayrollFinanceApproval.ArrearsAmount');
                        $payable_sum1 = $for_sum_query1->sum('PayrollFinanceApproval.PayableSalary');
                        $fuel_sum1 = $for_sum_query1->sum('PayrollFinanceApproval.FuelAmount');

                        array_push($sum_emp_deduc, $deduc_sum1);
                        array_push($sum_emp_allowance, $allowance_sum1);
                        array_push($sum_emp_t, $t_sum1);
                        array_push($sum_emp_tax, $tax_sum1);
                        array_push($sum_emp_loan, $loan_sum1);
                        array_push($sum_emp_stipend, $stipend_sum1);
                        array_push($sum_emp_arrear, $arears_sum1);
                        array_push($sum_emp_payable, $payable_sum1);
                        array_push($sum_emp_advance, $advance_sum1);
                        array_push($sum_emp_fuel, $fuel_sum1);

                        $fetch_dept_detail = $for_sum_query2->get([DB::raw('SUM(PayrollFinanceApproval.FuelAmount) AS fuel'), DB::raw('SUM(PayrollFinanceApproval.TAmount) AS grosssalary'), DB::raw('SUM(PayrollFinanceApproval.TaxAmount) AS tax'), DB::raw('SUM(PayrollFinanceApproval.InstallmentAmount) AS loan'), DB::raw('SUM(PayrollFinanceApproval.AdvanceAmount) AS advance'), DB::raw('SUM(DuesAmount) AS deduction'), DB::raw('SUM(PayrollFinanceApproval.AllowanceAmount) AS allowance'), DB::raw('SUM(PayrollFinanceApproval.ArrearsAmount) AS arrear'), DB::raw('SUM(PayrollFinanceApproval.StipendAmount) AS stipend'), DB::raw('SUM(PayrollFinanceApproval.PayableSalary) AS payable')]);
                        $arr_dept = Arr::flatten($fetch_dept_detail);
                        foreach ($arr_dept as $arr_dept1) {
                            $this->fpdf->SetFillColor(230, 240, 233);
                            if ($sr % 39 == 0 || $sr == 1) {
                                if ($sr == 1) {
                                    $this->fpdf->Cell(30, 6, ($index1 + 1) . '-' . $result1->CompanyName, 0, 1, 'L', 0);
                                }
                                else if($sr % 39 == 0){
                                    $page++;
                                    $this->fpdf->SetFont('', 'B', 12);
                                    $this->fpdf->SetY(-10);
                                    $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);
                                    $this->fpdf->AddPage("L", ['280', '297']);
                                    $this->fpdf->ln(5);
                                }
                                $this->fpdf->SetFont('Times', 'B', 10);
                                $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
                                $this->fpdf->Cell(53, 6, 'Department', 1, 0, 'C', 0);
                                $this->fpdf->Cell(24, 6, 'Gross Salary', 1, 0, 'C', 0);
                                $this->fpdf->Cell(18, 6, 'Tax', 1, 0, 'C', 0);
                                $this->fpdf->Cell(20, 6, 'Loan', 1, 0, 'C', 0);
                                $this->fpdf->Cell(20, 6, 'Advance', 1, 0, 'C', 0);
                                $this->fpdf->Cell(23, 6, 'Deduction', 1, 0, 'C', 0);
                                $this->fpdf->Cell(23, 6, 'Allowance', 1, 0, 'C', 0);
                                $this->fpdf->Cell(20, 6, 'Fuel', 1, 0, 'C', 0);
                                $this->fpdf->Cell(18, 6, 'Arrear', 1, 0, 'C', 0);
                                $this->fpdf->Cell(20, 6, 'Stipend', 1, 0, 'C', 0);
                                $this->fpdf->Cell(28, 6, 'Net Payable', 1, 1, 'C', 0);
                                $this->fpdf->SetFont('', '', 10);
                            }
                            $row_fill = $row % 2;
                            $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', $row_fill);
                            $this->fpdf->Cell(53, 6, Str::substr($department_list1->Department, 0, 40), 1, 0, 'L', $row_fill);
                            $this->fpdf->Cell(24, 6, number_format($arr_dept1->grosssalary), 1, 0, 'R', $row_fill);
                            $this->fpdf->Cell(18, 6, number_format($arr_dept1->tax), 1, 0, 'R', $row_fill);
                            $this->fpdf->Cell(20, 6, number_format($arr_dept1->loan), 1, 0, 'R', $row_fill);
                            $this->fpdf->Cell(20, 6, number_format($arr_dept1->advance), 1, 0, 'R', $row_fill);
                            $this->fpdf->Cell(23, 6, number_format($arr_dept1->deduction), 1, 0, 'R', $row_fill);
                            $this->fpdf->Cell(23, 6, number_format($arr_dept1->allowance), 1, 0, 'R', $row_fill);
                            $this->fpdf->Cell(20, 6, number_format($arr_dept1->fuel), 1, 0, 'R', $row_fill);
                            $this->fpdf->Cell(18, 6, number_format($arr_dept1->arrear), 1, 0, 'R', $row_fill);
                            $this->fpdf->Cell(20, 6, number_format($arr_dept1->stipend), 1, 0, 'R', $row_fill);
                            $this->fpdf->Cell(28, 6, number_format($arr_dept1->payable), 1, 1, 'R', $row_fill);
                        }
                        $row++;
                        $sr++;
                    }
                    $this->fpdf->SetFont('Times', 'B', 10);
                    $this->fpdf->Cell(62, 6, 'Grand Total: ', 1, 0, 'R', 0);
                    $this->fpdf->Cell(24, 6, number_format(array_sum($sum_emp_t)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(18, 6, number_format(array_sum($sum_emp_tax)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(20, 6, number_format(array_sum($sum_emp_loan)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(20, 6, number_format(array_sum($sum_emp_advance)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(23, 6, number_format(array_sum($sum_emp_deduc)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(23, 6, number_format(array_sum($sum_emp_allowance)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(20, 6, number_format(array_sum($sum_emp_fuel)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(18, 6, number_format(array_sum($sum_emp_arrear)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(20, 6, number_format(array_sum($sum_emp_stipend)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(28, 6, number_format(array_sum($sum_emp_payable)) . '/-', 1, 1, 'R', 0);
                }
                $row++;
                $sr++;
                $page++;
                $this->fpdf->ln(10);
                $this->fpdf->SetFont('', 'B', 12);
                $this->fpdf->SetY(-10);
                $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);
            }
            $this->fpdf->Output();
            exit;
        }
    }

    public function issuance_letter($id, $grid)
    {
        $height = 1;
        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }
        $check_security = DB::connection('sqlsrv3')->table('Issuances')->where('CompanyID', '=', company_id())->where('IssuanceCode', '=', $grid)->where('IssuanceId', '=', $id)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('Issuances')->where('CompanyID', '=', company_id())->where('IssuanceCode', '=', $grid)->where('IssuanceId', '=', $id)->get();
            foreach ($get_req as $get_req1) {
            }
            $a = 0;
            $b = 0;
            $this->fpdf->AddPage("P", ['230', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 18);
            $this->fpdf->SetY(10);
            $this->fpdf->SetX(97);
            $this->fpdf->Cell(35, 7, 'Issuance', 0, 1, 'C', 0);
            $this->fpdf->SetTextColor(255, 255, 255);
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetY(20);
            $this->fpdf->SetX(97);
            $this->fpdf->Cell(35, 5, 'Department copy', 1, 1, 'C', 1);
            $this->fpdf->SetFont('Times', '', 13);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 170, 11, 43, 11);

            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);
            $this->fpdf->Cell(33, 5, 'For Department:', 0, 0, 'L', 0);
            $this->fpdf->Cell(123, 5, substr($get_req1->DepartmentName, 0, 60), 0, 0, 'L', 0);
            $this->fpdf->Cell(23, 5, 'Date:', 0, 0, 'L', 0);
            $this->fpdf->Cell(25, 5, substr($get_req1->IssuanceDate, 0, 10), 0, 1, 'L', 0);
            $this->fpdf->SetX(12);
            $this->fpdf->Cell(33, 6, 'Project:', 0, 0, 'L', 0);
            $this->fpdf->Cell(123, 6, substr($get_req1->ProjectName, 0, 60), 0, 0, 'L', 0);
            $this->fpdf->Cell(23, 6, 'Issuance #:', 0, 0, 'L', 0);
            $this->fpdf->Cell(25, 6, $get_req1->IssuanceCode, 0, 1, 'L', 0);
            // table 2
            $this->fpdf->SetX(12);

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(15, 6, 'Sr. #', 1, 0, 'C', 0);
            $this->fpdf->Cell(110, 6, 'Item Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Req Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Issuance Qty', 1, 1, 'C', 0);
            $get_req_detail = DB::connection('sqlsrv3')->table('IssuanceItem')->where('IssuanceId', '=', $id)->get();
            // $remaining=$find_req_table_sum-$find_req_id_sum;
            $remaining=0;
            $x = 1;

            foreach ($get_req_detail as $get_req_detail1) {


                $this->fpdf->SetX(12);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->Cell(15, 5, $x++, 1, 0, 'C', 0);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->Cell(110, 5, $get_req_detail1->ItemName, 1, 0, 'L', 0);
                $this->fpdf->SetFont('Times', '', 12);
                $this->fpdf->Cell(20, 5, $get_req_detail1->unit, 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 5, $get_req_detail1->ReqQuantity, 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 5, $get_req_detail1->IssuanceQuantity, 1, 1, 'C', 0);
                $remaining = $get_req_detail1->ReqQuantity - $get_req_detail1->IssuanceQuantity;
                $a = $a + $get_req_detail1->ReqQuantity;
                $b = $b + $get_req_detail1->IssuanceQuantity;
            }
            $this->fpdf->SetX(12);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(145, 6, 'Total: ', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, $a, 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, $b, 1, 0, 'C', 0);
            $this->fpdf->ln(6);

            $this->fpdf->SetX(12);
            $this->fpdf->Cell(190, 5, 'Remaining Items:', 0, 0, 'R', 0);
            $this->fpdf->Cell(15, 5, ($a - $b), 0, 1, 'L', 0);

            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);

            $this->fpdf->SetFont('Times', 'B', 12);

            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            $this->fpdf->Cell(120, 5, substr('Prepared By:  ' . $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 50), 0, 0, 'L', 0);
            $this->fpdf->Cell(80, 5, 'Received By: _______________', 0, 1, 'L', 0);
            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);
            $this->fpdf->SetFont('Times', '', 10);

            $this->fpdf->Cell(205, 3, '-  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - -', 0, 1, 'L', 0);
            $height = ((($x - 1) * 5) + 85);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, $height, 35, 18);
            $this->fpdf->SetY(4 + $height);
            $this->fpdf->SetX(97);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Cell(35, 7, 'Issuance', 0, 1, 'C', 0);
            $this->fpdf->SetTextColor(255, 255, 255);
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetY(13 + $height);
            $this->fpdf->SetX(97);
            $this->fpdf->Cell(35, 5, 'Warehouse copy', 1, 1, 'C', 1);
            $this->fpdf->SetFont('Times', '', 13);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 170, $height, 43, 11);
            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);
            $this->fpdf->Cell(33, 5, 'For Department:', 0, 0, 'L', 0);
            $this->fpdf->Cell(123, 5, substr($get_req1->DepartmentName, 0, 60), 0, 0, 'L', 0);
            $this->fpdf->Cell(23, 5, 'Date:', 0, 0, 'L', 0);
            $this->fpdf->Cell(25, 5, substr($get_req1->IssuanceDate, 0, 10), 0, 1, 'L', 0);
            $this->fpdf->SetX(12);
            $this->fpdf->Cell(33, 6, 'Project:', 0, 0, 'L', 0);
            $this->fpdf->Cell(123, 6, substr($get_req1->ProjectName, 0, 60), 0, 0, 'L', 0);
            $this->fpdf->Cell(23, 6, 'Issuance #:', 0, 0, 'L', 0);
            $this->fpdf->Cell(25, 6, $get_req1->IssuanceCode, 0, 1, 'L', 0);
            // table 2
            $this->fpdf->SetX(12);

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(15, 6, 'Sr. #', 1, 0, 'C', 0);
            $this->fpdf->Cell(110, 6, 'Item Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Req Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Issuance Qty', 1, 1, 'C', 0);
            $get_req_detail = DB::connection('sqlsrv3')->table('IssuanceItem')->where('IssuanceId', '=', $id)->get();
            // $remaining=$find_req_table_sum-$find_req_id_sum;
            $remaining;
            $x = 1;
            $a = 0;
            $b = 0;
            foreach ($get_req_detail as $get_req_detail1) {


                $this->fpdf->SetX(12);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->Cell(15, 5, $x++, 1, 0, 'C', 0);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->Cell(110, 5, $get_req_detail1->ItemName, 1, 0, 'L', 0);
                $this->fpdf->SetFont('Times', '', 12);
                $this->fpdf->Cell(20, 5, $get_req_detail1->unit, 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 5, $get_req_detail1->ReqQuantity, 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 5, $get_req_detail1->IssuanceQuantity, 1, 1, 'C', 0);
                $remaining = $get_req_detail1->ReqQuantity - $get_req_detail1->IssuanceQuantity;
                $a = $a + $get_req_detail1->ReqQuantity;
                $b = $b + $get_req_detail1->IssuanceQuantity;
            }
            $this->fpdf->SetX(12);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(145, 6, 'Total: ', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, $a, 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, $b, 1, 0, 'C', 0);
            $this->fpdf->ln(6);

            $this->fpdf->SetX(12);
            $this->fpdf->Cell(190, 5, 'Remaining Items:', 0, 0, 'R', 0);
            $this->fpdf->Cell(15, 5, ($a - $b), 0, 1, 'L', 0);

            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);

            $this->fpdf->SetFont('Times', 'B', 12);

            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            $this->fpdf->Cell(120, 5, substr('Prepared By:  ' . $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 50), 0, 0, 'L', 0);
            $this->fpdf->Cell(80, 5, 'Received By: _______________', 0, 1, 'L', 0);
            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Output();
            exit;
        } else {

        }
    }

    public function service_bill($id)
    {

        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }
        $ServiceBill_array = DB::connection('sqlsrv3')->table('ServiceBill')->where('CompanyID', '=', company_id())->where('ServiceBillId', '=', $id)->get();
        foreach ($ServiceBill_array as $ServiceBill_array1) {

        }
        $email = $ServiceBill_array1->CreatedBy;
        $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Profile.Email', '=', $email)->get();
        foreach ($emp_detail as $emp_detail1) {

        }
        $this->fpdf->AddPage("L", ['210', '297']);
        $this->fpdf->SetFont('Times', 'B', 22);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }


        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(125, 18, 'SA Gardens');
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->Text(15, 44, 'Project Name:');
        $this->fpdf->Text(45, 44, $ServiceBill_array1->ProjectName);
        $this->fpdf->Text(195, 38, 'Date:');
        $this->fpdf->Text(210, 38, $ServiceBill_array1->Dated);
        $this->fpdf->Text(170, 44, 'Contractor Name:');
        $this->fpdf->Text(210, 44, $ServiceBill_array1->ContractorName);
        $this->fpdf->ln(35);

        $this->fpdf->SetFont('Times', 'B', 16);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Cell(260, 6, 'Service Bill', 1, 1, 'C', 0);

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Cell(12, 6, ' Sr. #', 1, 0, 'L', 0);
        $this->fpdf->Cell(51, 6, '             Description', 1, 0, 'L', 0);
        $this->fpdf->Cell(14, 6, '  Unit', 1, 0, 'L', 0);
        $this->fpdf->Cell(13, 6, '  Nos', 1, 0, 'L', 0);
        $this->fpdf->Cell(11, 6, '   L', 1, 0, 'L', 0);
        $this->fpdf->Cell(11, 6, '   B', 1, 0, 'L', 0);
        $this->fpdf->Cell(11, 6, '   H', 1, 0, 'L', 0);
        $this->fpdf->Cell(15, 6, '   Qty', 1, 0, 'L', 0);
        $this->fpdf->Cell(14, 6, '  Rate', 1, 0, 'L', 0);
        $this->fpdf->Cell(19, 6, ' Amount', 1, 0, 'L', 0);
        $this->fpdf->Cell(25, 6, ' Completion', 1, 0, 'L', 0);
        $this->fpdf->Cell(19, 6, ' Amount', 1, 0, 'L', 0);
        $this->fpdf->Cell(18, 6, ' Balance', 1, 0, 'L', 0);
        $this->fpdf->Cell(27, 6, '    Remarks', 1, 1, 'L', 0);//
        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->SetTextColor(41, 46, 46);

        $ServiceBill_detail = DB::connection('sqlsrv3')->table('ServiceBillItem')->where('CompanyID', '=', company_id())->where('SBID', '=', $id)->get();
        $a = 'a';
        $sum_amount = 0;
        $sum_totalamount = 0;
        $sum_balance = 0;
        foreach ($ServiceBill_detail as $ServiceBill_detail1) {
            $this->fpdf->Cell(12, 6, '    ' . $a . '.', 1, 0, 'L', 0);
            $this->fpdf->Cell(51, 6, $ServiceBill_detail1->ServiceName, 1, 0, 'L', 0);
            $this->fpdf->Cell(14, 6, $ServiceBill_detail1->unit, 1, 0, 'L', 0);
            $this->fpdf->Cell(13, 6, $ServiceBill_detail1->unit, 1, 0, 'L', 0);
            $this->fpdf->Cell(11, 6, $ServiceBill_detail1->unit, 1, 0, 'L', 0);
            $this->fpdf->Cell(11, 6, $ServiceBill_detail1->unit, 1, 0, 'L', 0);
            $this->fpdf->Cell(11, 6, $ServiceBill_detail1->unit, 1, 0, 'L', 0);
            $this->fpdf->Cell(15, 6, number_format($ServiceBill_detail1->Quantity), 1, 0, 'L', 0);
            $this->fpdf->Cell(14, 6, number_format($ServiceBill_detail1->Rate), 1, 0, 'L', 0);
            $this->fpdf->Cell(19, 6, number_format($ServiceBill_detail1->Amount), 1, 0, 'L', 0);
            $this->fpdf->Cell(25, 6, $ServiceBill_detail1->unit, 1, 0, 'L', 0);
            $this->fpdf->Cell(19, 6, number_format($ServiceBill_detail1->TotalAmount), 1, 0, 'L', 0);
            $this->fpdf->Cell(18, 6, number_format($ServiceBill_detail1->Balance), 1, 0, 'L', 0);
            $this->fpdf->Cell(27, 6, $ServiceBill_detail1->Detail, 1, 1, 'L', 0);//
            $a++;
            $sum_amount = $sum_amount + $ServiceBill_detail1->Amount;
            $sum_totalamount = $sum_totalamount + $ServiceBill_detail1->TotalAmount;
            $sum_balance = $sum_balance + $ServiceBill_detail1->Balance;
        }
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Cell(152, 6, '                                                              Total Amount', 1, 0, 'L', 0);
        $this->fpdf->Cell(19, 6, number_format($sum_amount), 1, 0, 'L', 0);
        $this->fpdf->Cell(25, 6, '', 1, 0, 'L', 0);
        $this->fpdf->Cell(19, 6, number_format($sum_totalamount), 1, 0, 'L', 0);
        $this->fpdf->Cell(18, 6, number_format($sum_balance), 1, 0, 'L', 0);
        $this->fpdf->Cell(27, 6, '', 1, 1, 'L', 0);

        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Cell(30, 6, 'Narration:', 0, 0, 'L', 0);
        $this->fpdf->SetFont('Times', '', 10);
        $this->fpdf->Cell(10, 6, substr($ServiceBill_array1->Narration, 0, 250), 0, 1, 'L', 0);
        $this->fpdf->SetFont('Times', 'B', 11);
        $this->fpdf->Text(145, 140, 'Workdone Amount');
        $this->fpdf->Text(220, 140, number_format($ServiceBill_array1->WorkdoneAmount) . '/-');
        $this->fpdf->Text(145, 160, 'This Bill');
        $this->fpdf->Text(220, 160, number_format($ServiceBill_array1->BillAmount) . '/-');
        $this->fpdf->Text(15, 190, 'Site Engineer');
        $this->fpdf->Text(70, 190, 'Quantity Surveyor');
        $this->fpdf->Text(125, 190, 'Construction Manager');
        $this->fpdf->Text(185, 190, 'Project Manager');
        $this->fpdf->Text(240, 190, 'Managing Director');
        $this->fpdf->Cell(150, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(180, 6, '', 0, 1, 'R', 0);
        $this->fpdf->ln(2);

        $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(60, 6, '', 0, 1, 'R', 0);
        $this->fpdf->ln(10);
        $this->fpdf->Cell(33);
        $this->fpdf->Output();
        exit;
    }

    public function comparative_letter($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("PQuotation")->where("RequisitionID", "=", $id)->get();
        $find_req = DB::connection('sqlsrv3')->table("Requisition")->where("RequisitionId", "=", $id)->get();
        foreach ($find_req as $find_req1) {

        }

        $this->fpdf = new Fpdf;
        $this->fpdf->AddPage("L", ['290', '267']);
        $this->fpdf->SetFont('Times', 'B', 22);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }


        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(90, 17, 'Vendors Comparative Report');
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 220, 7, 43, 15);
        $this->fpdf->Text(210, 33, 'Req ID #:');
        $this->fpdf->Text(231, 33, $find_req1->RId);
        $this->fpdf->ln(30);
        foreach ($find_config as $find_config1) {
            $this->fpdf->Cell(50, 6, 'Quotation No: ' . $find_config1->QuotationNumber, 1, 0, 'C', 0);
            $this->fpdf->ln(7);

            $this->fpdf->SetFont('Times', '', 12);

            $this->fpdf->ln(2);

            $this->fpdf->Cell(50, 6, 'Vendor Name', 1, 0, 'C', 0);

            $this->fpdf->SetX(65);
            $this->fpdf->Cell(30, 6, 'Item Code', 1, 0, 'C', 0);

            $this->fpdf->Cell(80, 6, 'Item Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Price', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Total', 1, 1, 'C', 0);


            $cand = DB::connection('sqlsrv3')->table('PQuotationItems')->join('ItemList', 'ItemList.ID', '=', 'PQuotationItems.ItemId')->where("PQuotationItems.QuotationID", "=", $find_config1->QuotationID)->select('PQuotationItems.*', 'ItemList.ItemCode')->get();
            $this->fpdf->SetFont('Times', '', 10);

            $this->fpdf->Cell(50, 6, substr($find_config1->VendorName, 0, 40), 0, 0, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);

            foreach ($cand as $cand1) {

                $this->fpdf->SetX(65);


                $this->fpdf->Cell(30, 6, $cand1->ItemCode, 0, 0, 'C', 0);
                $this->fpdf->SetFont('Times', '', 10);

                $this->fpdf->Cell(80, 6, substr($cand1->ItemName, 0, 65), 0, 0, 'C', 0);
                $this->fpdf->SetFont('Times', '', 12);

                $this->fpdf->Cell(20, 6, $cand1->Quantity, 0, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, $cand1->Unit, 0, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($cand1->Price), 0, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, number_format($cand1->Total), 0, 0, 'C', 0);
                $this->fpdf->ln();
            }

            $this->fpdf->SetX(225);


            $this->fpdf->MultiCell(50, 5, ("Delivery:" . round($find_config1->ShippingCharges) . "\n" . "Tax:" . round($find_config1->Tax) . "\n" . "Total:" . round($find_config1->Total)), 0, 'C', false);
            $this->fpdf->ln(10);


        }
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->ln(2);
        $this->fpdf->Output();
        exit;
    }

    public function received_letter($rid, $rvid)
    {


        $update_date = date("Y-m-d");
        $check_security = DB::connection('sqlsrv3')->table('ReceivedVoucher')->where('CompanyID', '=', company_id())->where('ReceivedVoucherID', '=', $rid)->where('RVID', '=', $rvid)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('ReceivedVoucher')->where('CompanyID', '=', company_id())->where('ReceivedVoucherID', '=', $rid)->where('RVID', '=', $rvid)->get();
            foreach ($get_req as $get_req1) {
            }

            $check_image = DB::connection('sqlsrv3')->table('ReceivedVoucher')->where('CompanyID', '=', company_id())->where('ReceivedVoucherID', '=', $rid)->where('RVID', '=', $rvid)->where('Photo', '!=', null)->exists();
            $fet_detail = DB::connection('sqlsrv3')->table('ReceivedVoucherDetail')->where('CompanyID', '=', company_id())->where('RID', '=', $rid)->get();
            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(70, 17, 'Receipt Voucher');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 155, 7, 43, 12);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Text(136, 37, 'R. Voucher #:');
            $this->fpdf->Text(135, 43, 'Voucher Date:');
            $this->fpdf->Text(15, 37, 'Received Against:');
            $this->fpdf->Text(25, 43, 'Account ID:');
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Text(165, 37, $get_req1->RVID);
            $this->fpdf->Text(165, 43, $get_req1->VoucherDate);
            $this->fpdf->Text(50, 37, $get_req1->PaymentAgainst);
            $this->fpdf->Text(50, 43, $get_req1->AccountID);
            $this->fpdf->ln(40);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->SetLeftMargin(15);
            $this->fpdf->Cell(180, 6, 'Description', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            // $this->fpdf->MultiCell(0,5,('SalesPerson:'.$get_req1->SalesPerson.', '.'Account ID:'.$get_req1->MethodAccountID.', '.'Cheque No: '.$get_req1->ChqNumber),1,1,0);
            $this->fpdf->MultiCell(180, 8, ('Received From : ' . $get_req1->InvoiceNumber . '/ Payment Type: ' . $get_req1->MethodType . ' with Account ID: ' . $get_req1->MethodAccountID . ' / ' . ' Cheque No And Date : ' . $get_req1->ChqNumber . ',' . $get_req1->ChqDate), 1, 'L', false);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(180, 6, 'Full Receipt Detail', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(33, 6, 'Date', 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 6, 'Invoice/PO', 1, 0, 'C', 0);
            $this->fpdf->Cell(52, 6, 'Total amount', 1, 0, 'C', 0);
            $this->fpdf->Cell(55, 6, 'Remaining amount', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            foreach ($fet_detail as $fet_detail1) {
                $this->fpdf->Cell(33, 6, $fet_detail1->Date, 1, 0, 'C', 0);
                if ($fet_detail1->AgainstINV != null) {
                    $this->fpdf->Cell(40, 6, $fet_detail1->AgainstINV, 1, 0, 'C', 0);
                }
                else if ($fet_detail1->AgainstPO != null) {
                    $this->fpdf->Cell(40, 6, $fet_detail1->AgainstPO, 1, 0, 'C', 0);
                }
                else {
                    $this->fpdf->Cell(40, 6, '-------', 1, 0, 'C', 0);
                }
                $this->fpdf->Cell(52, 6, 'Rs. ' . number_format($fet_detail1->Amount), 1, 0, 'C', 0);
                $this->fpdf->Cell(55, 6, 'Rs. ' . number_format($fet_detail1->Remaining), 1, 1, 'C', 0);
            }
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(40, 6, 'Amount in Digits:', 1, 0, 'C', 0);
            $this->fpdf->Cell(140, 6, ('Rs. ' . number_format($get_req1->Amount) . '/-'), 1, 1, 'L', 0);
            $this->fpdf->MultiCell(180, 6, 'Amount in words:      ' . ($this->numberToWord(round($get_req1->Amount)) . ' Only'), 1, 'L', false);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->MultiCell(170, 6, 'Narration: ' . $get_req1->Naration, 0, 'L', false);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(60, 6, '  Received By', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, 'Supervised By', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, 'Deposited by ', 0, 1, 'R', 0);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {
            }
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '________________', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, $get_req1->SalesPerson, 0, 1, 'R', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            if ($check_image) {
                $this->fpdf->AddPage("P", ['210', '297']);
                $this->fpdf->SetFont('Times', 'B', 16);
                $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 6, 7, 35, 17);
                $this->fpdf->Text(63, 17, 'Receipt Voucher Attachment');
                $this->fpdf->SetFont('Times', '', 14);
                $this->fpdf->SetTextColor(41, 46, 46);
                $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 12);
                $pdf = explode(".pdf", $get_req1->Photo);
                $jfif = explode(".jfif", $get_req1->Photo);
                if (count($pdf) <= 1 && count($jfif) <= 1) {
                    $this->fpdf->Image('public/images/received_images/' . $get_req1->Photo, 10, 50, 180);
                } else {
                    $this->fpdf->SetFont('Times', 'B', 14);
                    $this->fpdf->Text(80, 80, 'Invalid image format');
                    $this->fpdf->SetFont('Times', '', 12);
                }
            }
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetY(-15);
            $this->fpdf->Cell(0, 10, 'Printed Date: ' . $update_date, 0, 0, 'C');
            $this->fpdf->Output();
            exit;
        } else {
        }
    }

    public function issuance_return_letter($id, $grid)
    {

        $height = 1;
        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }
        $check_security = DB::connection('sqlsrv3')->table('IssuanceReturn')->where('CompanyID', '=', company_id())->where('IRtnID', '=', $grid)->where('IssuenceReturnID', '=', $id)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('IssuanceReturn')->join('Issuances', 'IssuanceReturn.IssID', '=', 'Issuances.IssuanceId')->select('IssuanceReturn.*', 'Issuances.DepartmentName', 'Issuances.ProjectName')->where('IssuanceReturn.CompanyID', '=', company_id())->where('IssuanceReturn.IRtnID', '=', $grid)->where('IssuanceReturn.IssuenceReturnID', '=', $id)->get();
            foreach ($get_req as $get_req1) {
            }
            $a = 0;
            $b = 0;
            $this->fpdf->AddPage("P", ['230', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 18);
            $this->fpdf->SetY(10);
            $this->fpdf->SetX(97);
            $this->fpdf->Cell(35, 7, 'Issuance Return', 0, 1, 'C', 0);
            $this->fpdf->SetTextColor(255, 255, 255);
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetY(20);
            $this->fpdf->SetX(97);
            $this->fpdf->Cell(35, 5, 'Department copy', 1, 1, 'C', 1);
            $this->fpdf->SetFont('Times', '', 13);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 170, 11, 43, 11);

            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);
            $this->fpdf->Cell(33, 5, 'For Department:', 0, 0, 'L', 0);
            $this->fpdf->Cell(123, 5, substr($get_req1->DepartmentName, 0, 60), 0, 0, 'L', 0);
            $this->fpdf->Cell(23, 5, 'Date:', 0, 0, 'L', 0);
            $this->fpdf->Cell(25, 5, substr($get_req1->Dated, 0, 10), 0, 1, 'L', 0);
            $this->fpdf->SetX(12);
            $this->fpdf->Cell(33, 6, 'Project:', 0, 0, 'L', 0);
            $this->fpdf->Cell(123, 6, substr($get_req1->ProjectName, 0, 60), 0, 0, 'L', 0);
            $this->fpdf->Cell(28, 6, 'Issuance Ret #:', 0, 0, 'L', 0);
            $this->fpdf->Cell(25, 6, $get_req1->IRtnID, 0, 1, 'L', 0);
            // table 2
            $this->fpdf->SetX(12);

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(15, 6, 'Sr. #', 1, 0, 'C', 0);
            $this->fpdf->Cell(110, 6, 'Item Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Issuance Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Return Qty', 1, 1, 'C', 0);
            $get_req_detail = DB::connection('sqlsrv3')->table('IssuanceReturnItem')->where('IssuanceReturnId', '=', $id)->get();
            // $remaining=$find_req_table_sum-$find_req_id_sum;
            $remaining;
            $x = 1;

            foreach ($get_req_detail as $get_req_detail1) {


                $this->fpdf->SetX(12);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->Cell(15, 5, $x++, 1, 0, 'C', 0);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->Cell(110, 5, substr($get_req_detail1->ItemName, 0, 50), 1, 0, 'L', 0);
                $this->fpdf->SetFont('Times', '', 12);
                $this->fpdf->Cell(20, 5, $get_req_detail1->unit, 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 5, number_format($get_req_detail1->IssuanceQuantity), 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 5, number_format($get_req_detail1->ReturnQuantity), 1, 1, 'C', 0);
                //  $remaining=$get_req_detail1->ReqQuantity-$get_req_detail1->IssuanceQuantity;
                $a = $a + $get_req_detail1->IssuanceQuantity;
                $b = $b + $get_req_detail1->ReturnQuantity;
            }
            $this->fpdf->SetX(12);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(145, 6, 'Total: ', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, $a, 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, $b, 1, 0, 'C', 0);
            $this->fpdf->ln(6);

            $this->fpdf->SetX(12);
            // $this->fpdf->Cell(190,5,'Remaining Items:',0,0,'R',0);
            // $this->fpdf->Cell(15,5,($a-$b),0,1,'L',0);

            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);

            $this->fpdf->SetFont('Times', 'B', 12);

            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            $this->fpdf->Cell(120, 5, substr('Prepared By:  ' . $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 50), 0, 0, 'L', 0);
            $this->fpdf->Cell(80, 5, 'Received By: _______________', 0, 1, 'L', 0);
            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);
            $this->fpdf->SetFont('Times', '', 10);

            $this->fpdf->Cell(205, 3, '-  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  - -', 0, 1, 'L', 0);
            $height = ((($x - 1) * 5) + 85);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, $height, 35, 18);
            $this->fpdf->SetY(4 + $height);
            $this->fpdf->SetX(97);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Cell(35, 7, 'Issuance Return', 0, 1, 'C', 0);
            $this->fpdf->SetTextColor(255, 255, 255);
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->SetY(13 + $height);
            $this->fpdf->SetX(97);
            $this->fpdf->Cell(35, 5, 'Warehouse copy', 1, 1, 'C', 1);
            $this->fpdf->SetFont('Times', '', 13);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 170, $height, 43, 11);
            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);
            $this->fpdf->Cell(33, 5, 'For Department:', 0, 0, 'L', 0);
            $this->fpdf->Cell(123, 5, substr($get_req1->DepartmentName, 0, 60), 0, 0, 'L', 0);
            $this->fpdf->Cell(23, 5, 'Date:', 0, 0, 'L', 0);
            $this->fpdf->Cell(25, 5, substr($get_req1->Dated, 0, 10), 0, 1, 'L', 0);
            $this->fpdf->SetX(12);
            $this->fpdf->Cell(33, 6, 'Project:', 0, 0, 'L', 0);
            $this->fpdf->Cell(123, 6, substr($get_req1->ProjectName, 0, 60), 0, 0, 'L', 0);
            $this->fpdf->Cell(28, 6, 'Issuance Ret#:', 0, 0, 'L', 0);
            $this->fpdf->Cell(25, 6, $get_req1->IRtnID, 0, 1, 'L', 0);
            // table 2
            $this->fpdf->SetX(12);

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(15, 6, 'Sr. #', 1, 0, 'C', 0);
            $this->fpdf->Cell(110, 6, 'Item Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Issuance Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Return Qty', 1, 1, 'C', 0);
            $get_req_detail = DB::connection('sqlsrv3')->table('IssuanceReturnItem')->where('IssuanceReturnId', '=', $id)->get();
            // $remaining=$find_req_table_sum-$find_req_id_sum;
            $remaining;
            $x = 1;
            $a = 0;
            $b = 0;
            foreach ($get_req_detail as $get_req_detail1) {


                $this->fpdf->SetX(12);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->Cell(15, 5, $x++, 1, 0, 'C', 0);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->Cell(110, 5, substr($get_req_detail1->ItemName, 0, 50), 1, 0, 'L', 0);
                $this->fpdf->SetFont('Times', '', 12);
                $this->fpdf->Cell(20, 5, $get_req_detail1->unit, 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 5, number_format($get_req_detail1->IssuanceQuantity), 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 5, number_format($get_req_detail1->ReturnQuantity), 1, 1, 'C', 0);
                //$remaining=$get_req_detail1->ReqQuantity-$get_req_detail1->IssuanceQuantity;
                $a = $a + $get_req_detail1->IssuanceQuantity;
                $b = $b + $get_req_detail1->ReturnQuantity;
            }
            $this->fpdf->SetX(12);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(145, 6, 'Total: ', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, $a, 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, $b, 1, 0, 'C', 0);
            $this->fpdf->ln(6);

            $this->fpdf->SetX(12);
            // $this->fpdf->Cell(190,5,'Remaining Items:',0,0,'R',0);
            // $this->fpdf->Cell(15,5,($a-$b),0,1,'L',0);

            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);

            $this->fpdf->SetFont('Times', 'B', 12);

            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            $this->fpdf->Cell(120, 5, substr('Prepared By:  ' . $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 50), 0, 0, 'L', 0);
            $this->fpdf->Cell(80, 5, 'Received By: _______________', 0, 1, 'L', 0);
            $this->fpdf->ln(6);
            $this->fpdf->SetX(12);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Output();
            exit;
        } else {

        }
    }

    public function trial_balance_report($start_date, $end_date)
    {

        $username = Session::get('username');

        $update_dated = date("Y-m-d");


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[TrialBalance_1]
    @Datefrom = N'" . $start_date . "',
    @DateTo = N'" . $end_date . "',
    @compid = N'" . company_id() . "'  ");

        $result21 = Arr::sort($result, function ($student) {
            return $student->AccountID;
        });

        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }
        $this->fpdf->AddPage("L", ['280', '297']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);

        $this->fpdf->Text(125, 15, 'Trial Balance');

        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 233, 7, 43, 15);
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->SetTextColor(41, 46, 46);

        $this->fpdf->ln(20);
        $this->fpdf->Cell(180, 5, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(23, 5, 'Print Date:', 0, 0, 'C', 0);
        $this->fpdf->Cell(100, 5, $update_dated, 0, 1, 'L', 0);
        $this->fpdf->Cell(180, 5, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(20, 5, 'Print By:', 0, 0, 'C', 0);
        $this->fpdf->Cell(100, 5, $username, 0, 1, 'L', 0);
        $this->fpdf->ln(10);

        $this->fpdf->Cell(30, 5, 'Date Range:', 0, 0, 'L', 0);
        $this->fpdf->Cell(60, 5, $start_date . ' to ' . $end_date, 0, 0, 'L', 0);

        $this->fpdf->ln(10);
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->Cell(15, 5, 'S.no', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 5, 'Account ID', 1, 0, 'C', 0);
        $this->fpdf->Cell(160, 5, 'Account Name', 1, 0, 'C', 0);

        $this->fpdf->Cell(25, 5, 'Debit', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 5, 'Credit', 1, 1, 'C', 0);
        $this->fpdf->SetFont('Times', '', 12);
        $credit = [];
        $debit = [];
        $sr = 1;
        foreach ($result21 as $get_req_detail1) {
            array_push($credit, $get_req_detail1->Credit);
            array_push($debit, $get_req_detail1->Debit);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(15, 8, $sr, 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 8, $get_req_detail1->AccountID, 1, 0, 'C', 0);
            $this->fpdf->Cell(160, 8, substr($get_req_detail1->AccountName, 0, 120), 1, 0, 'L', 0);
            $this->fpdf->Cell(25, 8, number_format($get_req_detail1->Debit), 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 8, number_format($get_req_detail1->Credit), 1, 1, 'C', 0);
            $sr = $sr + 1;
        }
        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Cell(205, 8, 'Grand Total:', 1, 0, 'R', 0);
        $this->fpdf->Cell(25, 8, number_format(array_sum($debit)), 1, 0, 'L', 0);
        $this->fpdf->Cell(25, 8, number_format(array_sum($credit)), 1, 0, 'L', 0);
        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Output();
        exit;


    }




// public function payment_letter1($pid,$pvid){
//   date_default_timezone_set("Asia/Karachi");
//    $update_date=date("Y-m-d");
//       $check_security =DB::connection('sqlsrv3')->table('PaymentVoucher')->where('CompanyID','=',company_id())->where('PaymentVoucherID','=',$pid)->where('PVID','=',$pvid)->exists();
//  if($check_security){
//   $get_req =DB::connection('sqlsrv3')->table('PaymentVoucher')->where('CompanyID','=',company_id())->where('PaymentVoucherID','=',$pid)->where('PVID','=',$pvid)->get();
//   foreach ($get_req as $get_req1) {
//   }


//   $fet_detail =DB::connection('sqlsrv3')->table('PaymentVoucherDetail')->where('CompanyID','=',company_id())->where('PID','=',$pid)->get();
//   $this->fpdf->AddPage("P", ['210', '297']);
//   $this->fpdf->SetFont('Times','B',22);
//   $this->fpdf->SetTextColor(41, 46, 46);
//   $fetch_image=DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID','=',company_id())->get();
//   foreach ($fetch_image as $fetch_image1) {
//
//   }


//   $this->fpdf->Image('public/images/logo/'.$fetch_image1->LeftLogo,10,7,35,17);
//   $this->fpdf->Text(65, 17, 'PAYMENT VOUCHER');
//   $this->fpdf->SetFont('Times','',14);
// $this->fpdf->SetTextColor(41, 46, 46 );
// $this->fpdf->Image('public/images/logo/'.$fetch_image1->RightLogo,165,7,43,15);
// $this->fpdf->SetFont('Times','',12);
// $this->fpdf->Text(150, 37,'PV #:');
// $this->fpdf->Text(165, 37,$get_req1->PVID);
// $this->fpdf->Text(135, 43,'Voucher Date:');
// $this->fpdf->Text(165, 43,$get_req1->VoucherDate);
// $this->fpdf->Text(15, 37,'Payment Against:');
// $this->fpdf->Text(50, 37,$get_req1->PaymentAgainst);
// $this->fpdf->Text(15, 43,'Account ID:');
// $this->fpdf->Text(50, 43,$get_req1->AccountID);
// $this->fpdf->ln(40);
// $this->fpdf->SetFont('Times','B',12);
// $this->fpdf->Cell(170,6,'Description',1,1,'C',0);
//  $this->fpdf->SetFont('Times','',12);
// // $this->fpdf->MultiCell(0,5,('SalesPerson:'.$get_req1->SalesPerson.', '.'Account ID:'.$get_req1->MethodAccountID.', '.'Cheque No: '.$get_req1->ChqNumber),1,1,0);
// $this->fpdf->MultiCell(170,8,('Payment Against : '.$get_req1->InvoiceNumber.'/ Payment Type: '.$get_req1->MethodType.' with Account ID: '.$get_req1->MethodAccountID.' / '.' Cheque No And Date : '.$get_req1->ChqNumber.','.$get_req1->ChqDate),1,'L',false);
//  $this->fpdf->SetFont('Times','B',12);
//  $this->fpdf->Cell(170,6,'Full Payment Detail',1,1,'C',0);
//   $this->fpdf->SetFont('Times','',12);
//  $this->fpdf->Cell(20,6,'Date',1,0,'C',0);
//  $this->fpdf->Cell(27,6,'Po NO.',1,0,'C',0);
//  $this->fpdf->Cell(28,6,'INV NO.',1,0,'C',0);
//  $this->fpdf->Cell(25,6,'JV NO.',1,0,'C',0);
//  $this->fpdf->Cell(35,6,'Amount',1,0,'C',0);
// $this->fpdf->Cell(35,6,'Remaining',1,1,'C',0);
//  foreach ($fet_detail as $fet_detail1) {
//
//   $this->fpdf->Cell(20,6,$fet_detail1->Date,1,0,'C',0);
//  $this->fpdf->Cell(27,6,$fet_detail1->AgainstPO,1,0,'C',0);
// $this->fpdf->Cell(28,6,$fet_detail1->AgainstINV,1,0,'C',0);
// $this->fpdf->Cell(25,6,$fet_detail1->AgainstJV,1,0,'C',0);
//  $this->fpdf->Cell(35,6,'Rs. '.number_format($fet_detail1->Amount),1,0,'C',0);
//   $this->fpdf->Cell(35,6,'Rs. '.number_format($fet_detail1->Remaining),1,1,'C',0);
//  }


// $this->fpdf->SetFont('Times','B',12);

// if($get_req1->TaxAmount!=0){
// $this->fpdf->Cell(50,6,'Tax Amount:',1,0,'C',0);
// $this->fpdf->Cell(120,6,('Rs. '.number_format($get_req1->TaxAmount).'/-'),1,1,'L',0);
// }


// $this->fpdf->Cell(50,6,'Paid Amount in Digits:',1,0,'C',0);
// $this->fpdf->Cell(120,6,('Rs. '.number_format($get_req1->Amount-$get_req1->TaxAmount).'/-'),1,1,'L',0);
// $this->fpdf->MultiCell(170,6,'Amount in Words: '.($this->numberToWord(round($get_req1->Amount-$get_req1->TaxAmount)).' Only'),1,'L',false);
// $this->fpdf->SetFont('Times','',12);
// $this->fpdf->MultiCell(170,6,'Narration: '.$get_req1->Naration,0,'L',false);
// $this->fpdf->ln(10);
//  $this->fpdf->SetFont('Times','B',12);
// $this->fpdf->Cell(60,6,'Paid By:',0,0,'L',0);
// $this->fpdf->Cell(60,6,'Supervised By:',0,0,'C',0);
// $this->fpdf->Cell(60,6,'Received By:',0,1,'R',0);


// $fetch_user_detail=DB::table('tb_users')->where('company_id','=',company_id())->where('email',$get_req1->CreatedBy)->get();
// foreach ($fetch_user_detail as $fetch_user_detail1) {
//
// }

// $this->fpdf->Cell(60,6,$fetch_user_detail1->first_name.' '.$fetch_user_detail1->last_name,0,0,'L',0);


// $this->fpdf->Cell(60,6,'________________',0,0,'C',0);
// $this->fpdf->Cell(60,6,$get_req1->SalesPerson,0,1,'R',0);

// $this->fpdf->ln(10);
// $this->fpdf->SetFont('Times','B',12);

// $this->fpdf->SetFont('Times','',12);
// $this->fpdf->SetY(-15);
// $this->fpdf->Cell(0,10,'Printed Date: '.$update_date,0,0,'C');
//   $this->fpdf->Output();
//   exit;
// }else{
// }
// }
    public function payment_letter1($pid, $pvid)
    {


        $update_date = date("Y-m-d");
        $check_security = DB::connection('sqlsrv3')->table('PaymentVoucher')->where('CompanyID', '=', company_id())->where('PaymentVoucherID', '=', $pid)->where('PVID', '=', $pvid)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('PaymentVoucher')->where('CompanyID', '=', company_id())->where('PaymentVoucherID', '=', $pid)->where('PVID', '=', $pvid)->get();
            foreach ($get_req as $get_req1) {
            }
            $fet_detail = DB::connection('sqlsrv3')->table('PaymentVoucherDetail')->where('CompanyID', '=', company_id())->where('PID', '=', $pid)->get();
            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(65, 17, 'PAYMENT VOUCHER');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 15);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Text(150, 37, 'PV #:');
            $this->fpdf->Text(165, 37, $get_req1->PVID);
            $this->fpdf->Text(135, 43, 'Voucher Date:');
            $this->fpdf->Text(165, 43, $get_req1->VoucherDate);
            $this->fpdf->Text(15, 37, 'Payment Against:');
            $this->fpdf->Text(50, 37, $get_req1->PaymentAgainst);
            $this->fpdf->Text(15, 43, 'Account ID:');
            $this->fpdf->Text(50, 43, $get_req1->AccountID);
            $this->fpdf->ln(40);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(185, 6, 'Description', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
// $this->fpdf->MultiCell(0,5,('SalesPerson:'.$get_req1->SalesPerson.', '.'Account ID:'.$get_req1->MethodAccountID.', '.'Cheque No: '.$get_req1->ChqNumber),1,1,0);
            $this->fpdf->MultiCell(185, 8, ('Payment Against : ' . $get_req1->InvoiceNumber . '/ Payment Type: ' . $get_req1->MethodType . ' with Account ID: ' . $get_req1->MethodAccountID . ' / ' . ' Cheque No And Date : ' . $get_req1->ChqNumber . ',' . $get_req1->ChqDate), 1, 'L', false);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(185, 6, 'Full Payment Detail', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Date', 1, 0, 'C', 0);
            $this->fpdf->Cell(27, 6, 'Po NO.', 1, 0, 'C', 0);
            $this->fpdf->Cell(33, 6, 'INV NO.', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, 'JV NO.', 1, 0, 'C', 0);
            $this->fpdf->Cell(35, 6, 'Amount', 1, 0, 'C', 0);
            $this->fpdf->Cell(35, 6, 'Remaining', 1, 1, 'C', 0);
            foreach ($fet_detail as $fet_detail1) {

                $this->fpdf->Cell(30, 6, $fet_detail1->Date, 1, 0, 'C', 0);
                $this->fpdf->Cell(27, 6, $fet_detail1->AgainstPO, 1, 0, 'C', 0);
                $this->fpdf->Cell(33, 6, $fet_detail1->AgainstINV, 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, $fet_detail1->AgainstJV, 1, 0, 'C', 0);
                $this->fpdf->Cell(35, 6, 'Rs. ' . number_format($fet_detail1->Amount), 1, 0, 'C', 0);
                $this->fpdf->Cell(35, 6, 'Rs. ' . number_format($fet_detail1->Remaining), 1, 1, 'C', 0);
            }
            $this->fpdf->SetFont('Times', 'B', 12);
            if ($get_req1->TaxAmount != 0) {
                $this->fpdf->Cell(50, 6, 'Tax Amount:', 1, 0, 'C', 0);
                $this->fpdf->Cell(135, 6, ('Rs. ' . number_format($get_req1->TaxAmount) . '/-'), 1, 1, 'L', 0);
            }
            $this->fpdf->Cell(50, 6, 'Paid Amount in Digits:', 1, 0, 'C', 0);
            $this->fpdf->Cell(135, 6, ('Rs. ' . number_format($get_req1->Amount - $get_req1->TaxAmount) . '/-'), 1, 1, 'L', 0);
            $this->fpdf->MultiCell(185, 6, 'Amount in Words: ' . ($this->numberToWord(round($get_req1->Amount - $get_req1->TaxAmount)) . ' Only'), 1, 'L', false);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->MultiCell(185, 6, 'Narration: ' . $get_req1->Naration, 0, 'L', false);
            $this->fpdf->ln(5);
            $invoiceNumbers = DB::connection('sqlsrv3')
            ->table('PaymentVoucherDetail')
            ->where('PID', $pid)->Where('AgainstINV', '!=', '')
            ->pluck('AgainstINV')
            ->toArray();
        // dd($invoiceNumbers);
        $jv_numbers = DB::connection('sqlsrv3')
            ->table('PaymentVoucherDetail')
            ->where('PID', $pid)
            ->whereNotNull('AgainstJV')
            ->pluck('AgainstJV')
            ->toArray();

        $po_numbers = DB::connection('sqlsrv3')
            ->table('PaymentVoucherDetail')
            ->where('PID', $pid)
            ->whereNotNull('AgainstPO')
            ->pluck('AgainstPO')
            ->toArray();
            $check_Inv = DB::connection('sqlsrv3')->table('PaymentVoucherDetail')->whereIn('AgainstINV', $invoiceNumbers)->count();
            $check_po = DB::connection('sqlsrv3')->table('PaymentVoucherDetail')->whereIn('AgainstPO', $po_numbers)->count();
            $check_jv = DB::connection('sqlsrv3')->table('PaymentVoucherDetail')->whereIn('AgainstJV', $jv_numbers)->count();

            if ($check_Inv>1 || $check_po>1 || $check_jv>1) {
                $this->fpdf->SetFont('Times', 'B', 12);
                $this->fpdf->Cell(186, 6, 'Partial Payment Detail', 1, 1, 'C', 0);
                $this->fpdf->SetFont('Times', '', 12);
                $this->fpdf->Cell(21, 6, 'Date', 1, 0, 'C', 0);
                $this->fpdf->Cell(28, 6, 'PVID / RVID', 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, 'PO No.', 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, 'INV No.', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'JV No.', 1, 0, 'C', 0);
                $this->fpdf->Cell(26, 6, 'Amount', 1, 0, 'C', 0);
                $this->fpdf->Cell(26, 6, 'Remaining', 1, 1, 'C', 0);
                //  dd($invoiceNumbers);
                $data = DB::connection('sqlsrv3')->table('PaymentVoucherDetail')
                ->whereIn('AgainstINV', $invoiceNumbers)
                ->orWhereIn('AgainstPO', $po_numbers)
                ->orWhereIn('AgainstJV', $jv_numbers)
                ->orderBy('DetailID','asc')->get();

                foreach ($data as $data1) {
                    $this->fpdf->Cell(21, 6, $data1->Date, 1, 0, 'L', 0);
                    $this->fpdf->Cell(28, 6, $data1->PVNO, 1, 0, 'L', 0);
                    $this->fpdf->Cell(30, 6, $data1->AgainstPO, 1, 0, 'L', 0);
                    $this->fpdf->Cell(30, 6, $data1->AgainstINV, 1, 0, 'L', 0);
                    $this->fpdf->Cell(25, 6, $data1->AgainstJV, 1, 0, 'L', 0);
                    $this->fpdf->Cell(26, 6, number_format($data1->Amount), 1, 0, 'L', 0);
                    $this->fpdf->Cell(26, 6, number_format($data1->Remaining), 1, 1, 'L', 0);
                }
            }


            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(60, 6, 'Paid By:', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, 'Supervised By:', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, 'Received By:', 0, 1, 'R', 0);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '________________', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, $get_req1->SalesPerson, 0, 1, 'R', 0);
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetY(-15);
            $this->fpdf->Cell(0, 10, 'Printed Date: ' . $update_date, 0, 0, 'C');
            $this->fpdf->Output();
            exit;
        } else {
        }
    }


    public function jv_letter($jid, $jvid)
    {

        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }
        $check_security = DB::connection('sqlsrv3')->table('JournalVoucher')->where('CompanyID', '=', company_id())->where('JournalVoucherID', '=', $jid)->where('JVID', '=', $jvid)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('JournalVoucher')->where('CompanyID', '=', company_id())->where('JournalVoucherID', '=', $jid)->where('JVID', '=', $jvid)->get();
            foreach ($get_req as $get_req1) {
            }
            $get_req_detail = DB::connection('sqlsrv3')->table('JournalVoucherDetail')->where('JournalVoucherID', '=', $get_req1->JournalVoucherID)->get();
            $get_req_sum = DB::connection('sqlsrv3')->table('JournalVoucherDetail')->where('JournalVoucherID', '=', $get_req1->JournalVoucherID)->sum('debit_amount');
            $get_req_sum1 = DB::connection('sqlsrv3')->table('JournalVoucherDetail')->where('JournalVoucherID', '=', $get_req1->JournalVoucherID)->sum('credit_amount');
            $this->fpdf->AddPage("P", ['220', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(65, 17, 'JOURNAL VOUCHER');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 15);
            $this->fpdf->Text(160, 30, 'Date:');
            $this->fpdf->Text(175, 30, $get_req1->JVDate);
            $this->fpdf->Text(160, 37, 'JV #');
            $this->fpdf->Text(175, 37, $get_req1->JVID);
            $this->fpdf->ln(40);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(30, 6, 'Account ID', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, 'Account Name', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Narration', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Debit', 0, 0, 'R', 0);
            $this->fpdf->Cell(30, 6, 'Credit', 0, 1, 'R', 0);
            $max_y = 297;
            foreach ($get_req_detail as $get_req_detail1) {
                $x = $this->fpdf->GetX();
                $y = $this->fpdf->GetY();
                $this->fpdf->SetFont('Times', '', 11);
                $this->fpdf->Cell(30, 6, $get_req_detail1->AccountID, 0, 0, 'L', 0);
                $this->customFpdf->SetFont('Times', '', 10);
//                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->SetXY($x + 30, $y);
                $nb_lines1 = $this->customFpdf->NbLines(60, $get_req_detail1->AccountName);
                $text_height1 = 6 * $nb_lines1;
                $this->fpdf->MultiCell(60, 6, $get_req_detail1->AccountName, 0, 'L', 0);
                $this->customFpdf->SetFont('Times', '', 11);
                $this->fpdf->SetXY($x + 90, $y);
                $line_height = 6; // Set the line height
                $nb_lines = $this->customFpdf->NbLines(51, $get_req_detail1->Narration);
                //
                $text_height = $line_height * $nb_lines;
                $this->fpdf->MultiCell(51, $line_height, $get_req_detail1->Narration, 0, 'L', 0);
                $this->fpdf->SetFont('Times', '', 11);
                $this->fpdf->SetXY($x + 161, $y);
                $this->fpdf->MultiCell(30, 6, number_format($get_req_detail1->debit_amount), 0, 'L', 0);
                $this->fpdf->SetXY($x + 191, $y);
                $this->fpdf->Cell(30, 6, number_format($get_req_detail1->credit_amount), 0, 1, 'L', 0);
                $this->fpdf->ln($text_height);
                $this->fpdf->ln($text_height1 - 6);
                if ($this->fpdf->GetY() + $text_height > $max_y) {
                    // Add a new page and reset the current position
                    $this->fpdf->AddPage("P", ['220', '297']);
                    $this->fpdf->SetXY($x, $this->fpdf->GetY());
                }
            }
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(141, 1, '', 0, 0, 'R', 0);
            $this->fpdf->Cell(30, 3, '____________', 0, 0, 'R', 0);
            $this->fpdf->Cell(30, 3, '____________', 0, 1, 'R', 0);
            $this->fpdf->Cell(141, 6, 'Total:', 0, 0, 'R', 0);
            $this->fpdf->Cell(30, 6, number_format($get_req_sum), 0, 0, 'R', 0);
            $this->fpdf->Cell(30, 6, number_format($get_req_sum1), 0, 1, 'R', 0);
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(90, 6, 'Created By:', 0, 0, 'L', 0);
            $this->fpdf->Cell(90, 6, 'Approved By:', 0, 1, 'R', 0);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            $this->fpdf->Cell(90, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);
            if ($get_req1->UpdatedBy != null) {
                $fetch_user_detail2 = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->UpdatedBy)->get();
                foreach ($fetch_user_detail2 as $fetch_user_detail21) {

                }
                $this->fpdf->Cell(90, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 1, 'R', 0);
            }
            $this->fpdf->Output();
            exit;
        } else {
        }
    }

    public function pr_letter($id, $prid)
    {

        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }

        $check_security = DB::connection('sqlsrv3')->table('ReceivingOrderReturn')->where('CompanyID', '=', company_id())->where('ReturnOrderID', '=', $id)->where('RtnID', '=', $prid)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('ReceivingOrderReturn')->join('Vendor', 'ReceivingOrderReturn.vendorName', '=', 'Vendor.CompanyName')->where('ReceivingOrderReturn.CompanyID', '=', company_id())->where('ReceivingOrderReturn.ReturnOrderID', '=', $id)->where('ReceivingOrderReturn.RtnID', '=', $prid)->get();

            foreach ($get_req as $get_req1) {

            }


            $get_req_detail = DB::connection('sqlsrv3')->table('ReceivingReturnItems')->join('ItemList', 'ItemList.ID', '=', 'ReceivingReturnItems.itemId')->where('ReceivingReturnItems.RRID', '=', $get_req1->ReturnOrderID)->get();

            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }


            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(70, 17, 'Purchase Return');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 15);
            $this->fpdf->Text(150, 30, 'Date:');
            $this->fpdf->Text(165, 30, $get_req1->Dated);
            $this->fpdf->Text(150, 37, 'PR #:');
            $this->fpdf->Text(165, 37, $get_req1->RtnID);
            $this->fpdf->ln(35);


            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->SetTextColor(233, 242, 235);
            $this->fpdf->Cell(90, 5, 'VENDOR', 1, 0, 'C', 1);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(90, 5, 'SHIP TO', 1, 1, 'C', 1);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Cell(30, 6, 'Company Name', 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(60, 6, substr($get_req1->CompanyName, 0, 25), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Company Name', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->company_name, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Email Id:', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->Email, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Email Id:', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->company_email, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Address', 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(60, 6, substr($get_req1->Address, 0, 25), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'City', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->city, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Web Link', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->weblink, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Phone', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->phone_number, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Phone', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->Mobile, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);


            $this->fpdf->ln(10);


            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(25, 5, 'ID', 1, 0, 'C', 0);
            $this->fpdf->Cell(65, 5, 'Item Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, 'Ord. Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, 'Rtn Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 5, 'Price', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 5, 'Total Price', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 10);
            foreach ($get_req_detail as $get_req_detail1) {

                $this->fpdf->Cell(25, 6, $get_req_detail1->ItemCode, 1, 0, 'C', 0);
                $this->fpdf->Cell(65, 6, $get_req_detail1->ItemName, 1, 0, 'L', 0);
                $this->fpdf->Cell(25, 6, $get_req_detail1->PoQuantity, 1, 0, 'C', 0);

                $this->fpdf->Cell(25, 6, $get_req_detail1->ReturnQuantity, 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, 'Rs.' . number_format($get_req_detail1->Price), 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req_detail1->SubTotal), 1, 1, 'C', 0);
            }


            $this->fpdf->Cell(30, 6, 'Narration:' . $get_req1->Remarks, 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Subtotal:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs. ' . number_format($get_req1->SubTotal), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Delivery:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs. ' . number_format($get_req1->ShippingCharges), 0, 1, 'L', 0);

            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Tax:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs. ' . number_format($get_req1->Tax), 0, 1, 'L', 0);

            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Discount:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs. ' . number_format($get_req1->Discount), 0, 1, 'L', 0);

            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '_________________________', 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Total:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs. ' . number_format($get_req1->TotalAmount), 0, 1, 'L', 0);


            $this->fpdf->ln(20);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(60, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, 'Verified By', 0, 1, 'R', 0);
            $this->fpdf->ln(2);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', '=', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }


            //$this->fpdf->Cell(60,6,$fetch_user_detail1->first_name.' '.$fetch_user_detail1->last_name,0,0,'L',0);

            $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, '_____________', 0, 1, 'R', 0);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(33);
            $this->fpdf->Cell(17, 26, 'If You have any question about this purchase return, Please contact us');


            $this->fpdf->Output();
            exit;

        } else {

        }


    }

    public function pr_letter1($vendor, $startingdate, $enddate)
    {


        $counted1 = 55;
        $this->fpdf->AddPage("L", ['290', '292']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);
        // $this->fpdf->Text(95, 15, "Purchase Return Report");
        //$this->fpdf->SetFont('Times','',10);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }


        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(110, 17, 'Purchase Return Report');
        $this->fpdf->SetFont('Times', '', 10);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 235, 7, 43, 15);

        $this->fpdf->ln(15);


        $this->fpdf->Text(200, 33, 'Date From:');
        $this->fpdf->Text(221, 33, $startingdate);


        $this->fpdf->Text(200, 40, 'Date To:');
        $this->fpdf->Text(221, 40, $enddate);


        $this->fpdf->ln(25);

        $this->fpdf->Cell(18, 6, 'Date', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'PR #', 1, 0, 'C', 0);
        $this->fpdf->Cell(35, 6, 'Vendor Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Delivery', 1, 0, 'C', 0);
        $this->fpdf->Cell(10, 6, 'Tax', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Discount', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Total', 1, 0, 'C', 0);

        $this->fpdf->SetX(155);

        $this->fpdf->Cell(40, 6, 'Item Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Po Qty', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Return Qty', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Unit', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Price', 1, 1, 'C', 0);

        $find;
        if ($vendor == 'All' && $startingdate != '' && $enddate != '') {
            $data = DB::connection('sqlsrv3')->table("ReceivingOrderReturn")->where("CompanyID", "=", company_id())->where('Dated', '>=', $startingdate)->where('Dated', '<=', $enddate)->get();
            $find = $data;
        } else {
            if ($vendor == 'All') {
                $vendor = '';
            }
            $data = DB::connection('sqlsrv3')->table("ReceivingOrderReturn")->where("CompanyID", "=", company_id())->where("vendorName", 'like', '%' . $vendor . '%')->where('Dated', '>=', $startingdate)->where('Dated', '<=', $enddate)->get();
            $find = $data;
        }
        foreach ($find as $find_config1) {


            $arr = DB::connection('sqlsrv3')->table("ReceivingReturnItems")->where("CompanyID", "=", company_id())->where("RRID", '=', $find_config1->ReturnOrderID)->get();

            $this->fpdf->Cell(18, 6, $find_config1->Dated, 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, $find_config1->RtnID, 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, Str::substr($find_config1->vendorName, 0, 22), 0, 0, 'L', 0);
            $this->fpdf->Cell(20, 6, number_format($find_config1->ShippingCharges), 0, 0, 'L', 0);
            $this->fpdf->Cell(10, 6, number_format($find_config1->Tax), 0, 0, 'L', 0);
            $this->fpdf->Cell(15, 6, number_format($find_config1->Discount), 0, 0, 'L', 0);
            $this->fpdf->Cell(20, 6, number_format($find_config1->TotalAmount), 0, 0, 'L', 0);
            foreach ($arr as $arr1) {
                $this->fpdf->SetX(155);


                $this->fpdf->Cell(40, 6, Str::substr($arr1->ItemName, 0, 27), 0, 0, 'L', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->PoQuantity), 0, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->ReturnQuantity), 0, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->Price), 0, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, number_format($arr1->SubTotal), 0, 1, 'C', 0);

            }
            $this->fpdf->ln(15);


        }
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->ln(2);
        $this->fpdf->Output();
        exit;
    }

    public function Issuance_return_report1($dept, $rid, $proj, $item, $startingdate, $enddate)
    {


        $this->fpdf->AddPage("L", ['270', '272']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);

        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(95, 17, 'Issuance Return Detail Report');
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 220, 7, 43, 15);

        $this->fpdf->ln(15);
        $this->fpdf->SetFont('Times', '', 10);
        $this->fpdf->Text(200, 33, 'Date From:');
        $this->fpdf->Text(221, 33, $startingdate);
        $this->fpdf->Text(200, 40, 'Date To:');
        $this->fpdf->Text(221, 40, $enddate);


        $this->fpdf->ln(25);

        $this->fpdf->Cell(18, 6, 'Dated', 1, 0, 'C', 0);
        $this->fpdf->Cell(23, 6, 'IR ID', 1, 0, 'C', 0);
        $this->fpdf->Cell(50, 6, 'Department', 1, 0, 'C', 0);
        $this->fpdf->Cell(40, 6, 'Project', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Status', 1, 0, 'C', 0);


        $this->fpdf->SetX(165);

        $this->fpdf->Cell(50, 6, 'Item Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Issu Qty', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Unit', 1, 0, 'C', 0);
        $this->fpdf->Cell(17, 6, 'Return Qty', 1, 0, 'C', 0);

        $find_rid = DB::connection('sqlsrv3')->table("IssuanceReturn")->where('CompanyID', '=', company_id())->where('IRtnID', '=', $rid)->select('IssuenceReturnID')->get();
        foreach ($find_rid as $find_rid1) {

        }

        if ($dept == 'All' && $rid == 'All' && $proj == 'All' && $startingdate != '' && $enddate != '') {
            $data = DB::connection('sqlsrv3')->table("IssuanceReturn")->join('Issuances', 'Issuances.IssuanceId', '=', 'IssuanceReturn.IssID')->where("IssuanceReturn.CompanyID", "=", company_id())->where('IssuanceReturn.Dated', '>=', $startingdate)->where('IssuanceReturn.Dated', '<=', $enddate)->select('IssuanceReturn.*', 'Issuances.DepartmentName', 'Issuances.ProjectName')->get();
            $find = $data;
        } else {
            if ($dept == 'All') {
                $dept = '';
            }

            if ($proj == 'All') {
                $proj = '';
            }
            if ($rid == 'All') {
                $data = DB::connection('sqlsrv3')->table("IssuanceReturn")->join('Issuances', 'Issuances.IssuanceId', '=', 'IssuanceReturn.IssID')->where("IssuanceReturn.CompanyID", "=", company_id())->where("Issuances.DepartmentName", 'like', '%' . $dept . '%')->where("Issuances.ProjectName", 'like', '%' . $proj . '%')->where('IssuanceReturn.Dated', '>=', $startingdate)->where('IssuanceReturn.Dated', '<=', $enddate)->select('IssuanceReturn.*', 'Issuances.*')->get();
                $find = $data;
            } else {

                $data = DB::connection('sqlsrv3')->table("IssuanceReturn")->join('Issuances', 'Issuances.IssuanceId', '=', 'IssuanceReturn.IssID')->where("IssuanceReturn.CompanyID", "=", company_id())->where("Issuances.DepartmentName", 'like', '%' . $dept . '%')->where("Issuances.ProjectName", 'like', '%' . $proj . '%')->where("IssuanceReturn.IssuenceReturnID", '=', $find_rid1->IssuenceReturnID)->where('IssuanceReturn.Dated', '>=', $startingdate)->where('IssuanceReturn.Dated', '<=', $enddate)->select('IssuanceReturn.*', 'Issuances.*')->get();
                $find = $data;
            }

        }
        foreach ($find as $find_config1) {
            if ($item != 'All') {
                $arr = DB::connection('sqlsrv3')->table("IssuanceReturnItem")->where("IssuanceReturnId", '=', $find_config1->IssuenceReturnID)->where('itemId', '=', $item)->get();

            } else {

                $arr = DB::connection('sqlsrv3')->table("IssuanceReturnItem")->where("IssuanceReturnId", '=', $find_config1->IssuenceReturnID)->get();
            }

            $this->fpdf->ln(8);
            $this->fpdf->SetFont('Times', '', 9);
            $this->fpdf->Cell(18, 6, $find_config1->Dated, 0, 0, 'C', 0);
            $this->fpdf->Cell(23, 6, $find_config1->IRtnID, 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, Str::substr($find_config1->DepartmentName, 0, 35), 0, 0, 'L', 0);
            $this->fpdf->Cell(40, 6, Str::substr($find_config1->ProjectName, 0, 25), 0, 0, 'L', 0);
            $this->fpdf->Cell(25, 6, $find_config1->Status2, 0, 0, 'L', 0);


            foreach ($arr as $arr1) {
                $this->fpdf->SetX(165);
                $this->fpdf->SetFont('Times', '', 9);


                $this->fpdf->Cell(50, 6, (Str::substr($arr1->ItemName, 0, 30)), 0, 0, 'L', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->IssuanceQuantity), 0, 0, 'L', 0);
                $this->fpdf->Cell(15, 6, $arr1->unit, 0, 0, 'L', 0);
                $this->fpdf->Cell(15, 6, number_format($arr1->ReturnQuantity), 0, 0, 'L', 0);
                $this->fpdf->ln(8);


            }


        }
        $this->fpdf->Output();
        exit;
    }

    public function pi_letter9($id, $roid)
    {

        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }

        $check_security = DB::connection('sqlsrv3')->table('ReceivingOrder')->where('CompanyID', '=', company_id())->where('ReceavingOrderID', '=', $id)->where('FormID', '=', $roid)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'ReceivingOrder.POID')->join('Vendor', 'PurchaseOrder.vendorName', '=', 'Vendor.CompanyName')->select('PurchaseOrder.*', 'Vendor.*', 'ReceivingOrder.*')->where('ReceivingOrder.CompanyID', '=', company_id())->where('ReceivingOrder.ReceavingOrderID', '=', $id)->where('ReceivingOrder.FormID', '=', $roid)->get();
            foreach ($get_req as $get_req1) {

            }


            $get_req_detail = DB::connection('sqlsrv3')->table('ReceivingOrderItems')->where('ROID', '=', $get_req1->ReceavingOrderID)->get();


            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 30, 17);
            $this->fpdf->Text(70, 18, 'Purchase Invoice');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 159, 7, 44, 12);
            $this->fpdf->Text(150, 30, 'Date:');
            $this->fpdf->Text(165, 30, $get_req1->Dated);
            $this->fpdf->Text(150, 37, 'PI #:');
            $this->fpdf->Text(165, 37, $get_req1->FormID);

            $this->fpdf->ln(35);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->SetTextColor(233, 242, 235);
            $this->fpdf->Cell(90, 5, 'VENDOR', 1, 0, 'C', 1);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(90, 5, 'SHIP TO', 1, 1, 'C', 1);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Cell(30, 6, 'Company Name', 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(60, 6, substr($get_req1->CompanyName, 0, 25), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Company Name', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->company_name, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Email Id', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->Email, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Email Id', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->company_email, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Address', 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(60, 6, substr($get_req1->Address, 0, 25), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'City', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->city, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Phone', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->Mobile, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Phone', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->phone_number, 1, 1, 'L', 0);

            $this->fpdf->SetX(108);


            $this->fpdf->ln(10);


            $this->fpdf->SetFont('Times', 'B', 12);
            if ($get_req1->RequisitionType != 'Services') {
                $this->fpdf->Cell(25, 5, 'ID', 1, 0, 'C', 0);
                $this->fpdf->Cell(80, 5, 'Item Name', 1, 0, 'C', 0);
            } else {
                $this->fpdf->Cell(105, 5, 'Services Description', 1, 0, 'C', 0);
            }
            $this->fpdf->Cell(25, 5, 'Qty', 1, 0, 'C', 0);

            $this->fpdf->Cell(25, 5, 'Price', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 5, 'Total Price', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 10);
            foreach ($get_req_detail as $get_req_detail1) {

                if ($get_req1->RequisitionType != 'Services') {
                    $this->fpdf->Cell(25, 6, $get_req_detail1->ItemCode, 1, 0, 'C', 0);
                    $this->fpdf->Cell(80, 6, $get_req_detail1->ItemName, 1, 0, 'L', 0);
                } else {
                    $this->fpdf->Cell(105, 6, substr($get_req_detail1->Detail, 0, 70), 1, 0, 'C', 0);
                }

                $this->fpdf->Cell(25, 6, $get_req_detail1->PoQuantity, 1, 0, 'C', 0);

                $this->fpdf->Cell(25, 6, 'Rs.' . number_format($get_req_detail1->Price), 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req_detail1->SubTotal), 1, 1, 'C', 0);
            }

            $this->fpdf->SetFont('Times', '', 12);

            $this->fpdf->Cell(30, 6, 'Narration:' . substr($get_req1->Remarks, 0, 70), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(120, 6, '', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(120, 6, 'Terms & Conditions', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Goods not fully upto the mark will be rejected.', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Goods are subject to our inspection on arrival at destination.', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Deliver this order in accordance with the price, terms, and', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Subtotal:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->SubTotal), 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, 'delivery method, and specifications listed above.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Delivery:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->ShippingCharges), 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Notify us immediatly if you are unable to ship as specified.', 0, 0, 'L', 0);

            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Tax:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->Tax), 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- SA Gardens reserves the rights to accept/reject any item found defected.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Discount:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->Discount), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '- Failure to deliver an item above will automatically authorized ', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '_________________________', 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, 'SA Gardens to purchase the undelivered item on risk & cost of Supplier.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(30, 6, 'Total:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->TotalAmount) . '/-', 0, 1, 'L', 0);
            $this->fpdf->MultiCell(160, 6, 'Amounts In Words: ' . $this->numberToWord(round($get_req1->TotalAmount)) . ' Rupees Only', 0, 'L', false);
            $this->fpdf->ln(20);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(60, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, '', 0, 1, 'R', 0);
            $this->fpdf->ln(2);

            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }


            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);
            // $this->fpdf->Cell(60,6,$get_req1->CreatedBy,0,0,'L',0);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, '_____________', 0, 1, 'R', 0);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(33);

            $this->fpdf->Output();
            exit;
        } else {
        }
    }

    public function pi_letter1($vendor, $startingdate, $enddate)
    {

        $counted1 = 55;
        $this->fpdf->AddPage("L", ['290', '292']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);
        //$this->fpdf->Text(112, 10, "Purchase Invoice Report");
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }


        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(110, 17, 'Purchase Invoice Report');
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 235, 7, 43, 15);

        $this->fpdf->ln(15);


        $this->fpdf->SetFont('Times', '', 10);
        $this->fpdf->Text(120, 30, 'From');
        $this->fpdf->Text(130, 30, $startingdate);
        $this->fpdf->Text(150, 30, 'to');
        $this->fpdf->Text(155, 30, $enddate);
        $this->fpdf->ln(13);
        $this->fpdf->Cell(18, 6, 'Date', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'PI #', 1, 0, 'C', 0);
        $this->fpdf->Cell(40, 6, 'Vendor Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Delivery', 1, 0, 'C', 0);
        $this->fpdf->Cell(10, 6, 'Tax', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Discount', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Total', 1, 0, 'C', 0);
        $this->fpdf->SetX(155);
        $this->fpdf->Cell(40, 6, 'Item Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Po Qty', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Recvd Qty', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Unit', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Price', 1, 1, 'C', 0);
        $find;
        if ($vendor == 'All' && $startingdate != '' && $enddate != '') {
            $data = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->where("ReceivingOrder.CompanyID", "=", company_id())->where('ReceivingOrder.Dated', '>=', $startingdate)->where('ReceivingOrder.Dated', '<=', $enddate)->select("ReceivingOrder.*", "PurchaseOrder.vendorName")->get();
            $find = $data;
        } else {
            if ($vendor == 'All') {
                $vendor = '';
            }
            $data = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->where("ReceivingOrder.CompanyID", "=", company_id())->where("PurchaseOrder.vendorName", 'like', '%' . $vendor . '%')->where('ReceivingOrder.Dated', '>=', $startingdate)->where('ReceivingOrder.Dated', '<=', $enddate)->select("ReceivingOrder.*", "PurchaseOrder.vendorName")->get();
            $find = $data;
        }
        foreach ($find as $find_config1) {
            $arr = DB::connection('sqlsrv3')->table("ReceivingOrderItems")->where("CompanyID", "=", company_id())->where("ROID", '=', $find_config1->ReceavingOrderID)->get();
            $this->fpdf->Cell(18, 6, $find_config1->Dated, 0, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, $find_config1->FormID, 0, 0, 'L', 0);
            $this->fpdf->Cell(40, 6, Str::substr($find_config1->vendorName, 0, 25), 0, 0, 'L', 0);
            $this->fpdf->Cell(15, 6, number_format($find_config1->ShippingCharges), 0, 0, 'C', 0);
            $this->fpdf->Cell(10, 6, number_format($find_config1->Tax), 0, 0, 'L', 0);
            $this->fpdf->Cell(15, 6, number_format($find_config1->Discount), 0, 0, 'L', 0);
            $this->fpdf->Cell(20, 6, number_format($find_config1->TotalAmount), 0, 0, 'L', 0);
            foreach ($arr as $arr1) {
                $this->fpdf->SetX(155);
                $this->fpdf->Cell(40, 6, Str::substr($arr1->ItemName, 0, 20), 0, 0, 'L', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->PoQuantity), 0, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->RecvdQuantity), 0, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, $arr1->Unit, 0, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, number_format($arr1->SubTotal), 0, 1, 'C', 0);
            }
            $this->fpdf->ln(15);
        }
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->ln(2);
        $this->fpdf->Output();
        exit;
    }

    public function grn_letter($id, $grid)
    {

        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {
        }

        $check_security = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', company_id())->where('GrnID', '=', $grid)->where('GrnOrderID', '=', $id)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('GrnOrder')->join('Requisition', 'Requisition.RequisitionId', '=', 'GrnOrder.ReqID')->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'GrnOrder.POID')->join('ReceivingOrder', 'ReceivingOrder.GRNID', '=', 'GrnOrder.GrnOrderID')->where('GrnOrder.CompanyID', '=', company_id())->select('PurchaseOrder.vendorName', 'PurchaseOrder.PoCode', 'GrnOrder.*', 'Requisition.RId', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'ReceivingOrder.FormID')->where('GrnOrder.GrnID', '=', $grid)->where('GrnOrder.GrnOrderID', '=', $id)->get();
            foreach ($get_req as $get_req1) {
            }
            $get_req_detail = DB::connection('sqlsrv3')->table('GrnOrderItems')->join('ItemList', 'ItemList.ID', '=', 'GrnOrderItems.itemId')->where('GrnOrderItems.GrnID', '=', $get_req1->GrnOrderID)->get();
            $get_req_sum = DB::connection('sqlsrv3')->table('GrnOrderItems')->where('GrnID', '=', $get_req1->GrnOrderID)->sum('RecvdQuantity');

            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {
            }

            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 30, 17);
            $this->fpdf->Text(65, 18, 'Goods Received Note');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 159, 7, 44, 12);
            $this->fpdf->Text(127, 33, 'Date:');
            $this->fpdf->Text(163, 33, $get_req1->Dated);
            $this->fpdf->Text(127, 40, 'GRN Number:');
            $this->fpdf->Text(163, 40, $get_req1->GrnID);

            $this->fpdf->Text(127, 47, 'PI#:');
            $this->fpdf->Text(163, 47, $get_req1->FormID);
            $this->fpdf->Text(127, 54, 'Invoice #:');
            //$this->fpdf->Text(163, 54,$get_req1->InvoiceNo);
            $this->fpdf->SetXY(163, 50);
            $this->fpdf->MultiCell(30, 6, $get_req1->InvoiceNo, 0, 'L');
            $this->fpdf->Text(15, 40, 'Req. Number:');
            $this->fpdf->Text(45, 40, $get_req1->RId);
            $this->fpdf->Text(15, 47, 'PO Number:');
            $this->fpdf->Text(45, 47, $get_req1->PoCode);
            $this->fpdf->Text(15, 54, 'Supplier:');
            $this->fpdf->Text(45, 54, substr($get_req1->vendorName, 0, 16));
            $this->fpdf->ln(10);
            // table 2

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(25, 6, 'Item ID', 1, 0, 'C', 0);
            $this->fpdf->Cell(100, 6, 'Item Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Order Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Rcvd Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Unit', 1, 1, 'C', 0);

            foreach ($get_req_detail as $get_req_detail1) {
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->Cell(25, 5, $get_req_detail1->ItemCode, 1, 0, 'C', 0);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->Cell(100, 5, $get_req_detail1->ItemName, 1, 0, 'L', 0);
                $this->fpdf->SetFont('Times', '', 12);
                $this->fpdf->Cell(20, 5, $get_req_detail1->PoQuantity, 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 5, $get_req_detail1->RecvdQuantity, 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 5, $get_req_detail1->Unit, 1, 1, 'C', 0);
            }

            $this->fpdf->ln(1);
            $this->fpdf->Cell(7, 26, '');
            $this->fpdf->Cell(15);
            $this->fpdf->Cell(17, 26, '');
            $this->fpdf->Cell(70);
            $this->fpdf->Cell(7, 26, 'Total Received Qty :');
            $this->fpdf->Cell(30);
            $this->fpdf->Cell(30, 26, $get_req_sum);
            $this->fpdf->ln(30);

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(60, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
            $this->fpdf->Cell(55, 6, 'Verified By', 0, 1, 'R', 0);
            $this->fpdf->ln(2);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {
            }


            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);

            $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, '_____________', 0, 1, 'R', 0);

            //
            $check_image = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', company_id())->where('GrnID', '=', $grid)->where('Photo', '!=', null)->exists();
            $get_req_image = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', company_id())->where('GrnID', '=', $grid)->where('Photo', '!=', null)->get();
            foreach ($get_req_image as $get_req_image1) {
            }
            if ($check_image) {
                $this->fpdf->AddPage("P", ['210', '297']);
                $this->fpdf->SetFont('Times', 'B', 22);

                $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 30, 17);
                $this->fpdf->Text(69, 18, 'GRN Attachment');
                $this->fpdf->SetFont('Times', '', 14);
                $this->fpdf->SetTextColor(41, 46, 46);
                $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 159, 7, 44, 12);
                $this->fpdf->Text(127, 33, 'Date:');
                $this->fpdf->Text(163, 33, $get_req1->Dated);
                $this->fpdf->Text(127, 40, 'GRN Number:');
                $this->fpdf->Text(163, 40, $get_req1->GrnID);
                $this->fpdf->Text(15, 40, 'PI#:');
                $this->fpdf->Text(45, 40, $get_req1->FormID);
                $pdf = explode(".pdf", $get_req1->Photo);
                $jfif = explode(".jfif", $get_req1->Photo);
                if (count($pdf) <= 1 && count($jfif) <= 1) {
                    $this->fpdf->Image('public/images/grn_images/' . $get_req_image1->Photo, 10, 50, 180);
                } else {
                    $this->fpdf->SetFont('Times', 'B', 14);
                    $this->fpdf->Text(80, 80, 'Invalid image format');
                    $this->fpdf->SetFont('Times', '', 12);
                }

            }
            $this->fpdf->Output();
            exit;
        } else {
        }
    }

    public function wordorder_letter($id, $poid)
    {

        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }

        $check_security = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('PoCode', '=', $poid)->where('PurchaseOrderID', '=', $id)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('PurchaseOrder')->join('Requisition', 'Requisition.RequisitionId', '=', 'PurchaseOrder.AgainstReq')->join('Vendor', 'PurchaseOrder.vendorName', '=', 'Vendor.CompanyName')->where('PurchaseOrder.CompanyID', '=', company_id())->select('Vendor.*', 'PurchaseOrder.*', 'Requisition.RId', 'Requisition.DepartmentName', 'Requisition.ProjectName')->where('PurchaseOrder.PoCode', '=', $poid)->where('PurchaseOrder.PurchaseOrderID', '=', $id)->get();
            foreach ($get_req as $get_req1) {

            }


            if ($get_req1->RequisitionType != 'Services') {
                $get_req_detail = DB::connection('sqlsrv3')->table('PurchaseOrderItems')->join('ItemList', 'ItemList.ID', '=', 'PurchaseOrderItems.itemId')->where('PurchaseOrderItems.POID', '=', $get_req1->PurchaseOrderID)->get();
            } else {
                $get_req_detail = DB::connection('sqlsrv3')->table('PurchaseOrderItems')->where('POID', '=', $get_req1->PurchaseOrderID)->get();
            }


            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }


            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(70, 17, 'Work Order Form');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 15);
            $this->fpdf->Text(150, 40, 'Date:');
            $this->fpdf->Text(165, 40, $get_req1->PoDate);
            $this->fpdf->Text(150, 47, 'Ref. #:');
            $this->fpdf->Text(170, 47, $get_req1->PoCode);
            $this->fpdf->ln(35);


            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->SetTextColor(233, 242, 235);
            $this->fpdf->Cell(90, 5, 'VENDOR', 1, 1, 'C', 1);

            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Cell(30, 6, 'Company Name', 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(60, 6, substr($get_req1->CompanyName, 0, 25), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '', 0, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Email Id:', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->Email, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '', 0, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Address', 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(60, 6, substr($get_req1->Address, 0, 25), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetX(108);


            $this->fpdf->Cell(30, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '', 0, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Phone', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->Mobile, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);


            $this->fpdf->ln(10);

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(40, 5, 'Requisition ID', 1, 0, 'C', 0);
            $this->fpdf->Cell(50, 5, 'Department', 1, 0, 'C', 0);
            $this->fpdf->Cell(60, 5, 'Project', 1, 0, 'C', 0);
            $this->fpdf->Cell(35, 5, 'Requisition Type', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(40, 6, $get_req1->RId, 1, 0, 'C', 0);
            $this->fpdf->Cell(50, 6, $get_req1->DepartmentName, 1, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, $get_req1->ProjectName, 1, 0, 'C', 0);
            $this->fpdf->Cell(35, 6, $get_req1->RequisitionType, 1, 1, 'C', 0);
            $this->fpdf->ln(10);

            $this->fpdf->SetFont('Times', 'B', 12);
            if ($get_req1->RequisitionType != 'Services') {
                $this->fpdf->Cell(20, 5, 'Item #', 1, 0, 'C', 0);
                $this->fpdf->Cell(80, 5, 'Description', 1, 0, 'C', 0);
            } else {

                $this->fpdf->Cell(100, 5, 'Services Description', 1, 0, 'C', 0);
            }

            $this->fpdf->Cell(20, 5, 'Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(15, 5, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 5, 'Unit Price', 1, 0, 'C', 0);
            $this->fpdf->Cell(33, 5, 'Total Price', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            foreach ($get_req_detail as $get_req_detail1) {

                $this->fpdf->SetFont('Times', '', 8);
                if ($get_req1->RequisitionType != 'Services') {
                    $this->fpdf->Cell(20, 6, $get_req_detail1->ItemCode, 1, 0, 'C', 0);
                    $this->fpdf->SetFont('Times', '', 10);
                    $this->fpdf->Cell(80, 6, $get_req_detail1->ItemName . ' : ' . substr($get_req_detail1->Detail, 0, 40), 1, 0, 'L', 0);
                } else {
                    $this->fpdf->Cell(100, 6, substr($get_req_detail1->Detail, 0, 60), 1, 0, 'C', 0);
                }


                $this->fpdf->SetFont('Times', '', 12);
                $this->fpdf->Cell(20, 6, $get_req_detail1->Quantity, 1, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, $get_req_detail1->Unit, 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($get_req_detail1->Price), 1, 0, 'C', 0);
                $this->fpdf->Cell(33, 6, 'Rs.' . number_format($get_req_detail1->SubTotal), 1, 1, 'C', 0);
            }


            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(30, 6, 'Narration:' . substr($get_req1->Remarks, 0, 70), 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(120, 6, '', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(120, 6, 'Terms & Conditions', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Goods not fully upto the mark will be rejected.', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Goods are subject to our inspection on arrival at destination.', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Deliver this order in accordance with the price, terms, and', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Subtotal:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->SubTotal), 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, 'delivery method, and specifications listed above.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Delivery:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->ShippingCharges), 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Notify us immediatly if you are unable to ship as specified.', 0, 0, 'L', 0);

            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Tax:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->Tax), 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- SA Gardens reserves the rights to accept/reject any item found defected.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Discount:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->Discount), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '- Failure to deliver an item above will automatically authorized ', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '_________________________', 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, 'SA Gardens to purchase the undelivered item on risk & cost of Supplier.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(30, 6, 'Total:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->TotalAmount) . '/-', 0, 1, 'L', 0);
            $this->fpdf->MultiCell(160, 6, 'Amounts In Words: ' . $this->numberToWord(round($get_req1->TotalAmount)) . ' Rupees Only', 0, 'L', false);
            $this->fpdf->ln(20);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(60, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, 'Status', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, 'Supervision', 0, 1, 'R', 0);
            $this->fpdf->ln(2);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }


            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);

            $this->fpdf->Cell(60, 6, $get_req1->Status2, 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, '------------------', 0, 1, 'R', 0);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(33);


            $this->fpdf->Output();
            exit;

        } else {

        }
    }

    public function land_paymentdetail_letter($id)
    {

        $this->fpdf->AddPage("P", ['210', '297']);
        $this->fpdf->SetFont('Times', 'B', 22);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }

        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 85, 10, 35, 17);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->Text(80, 35, 'Land Payment');
        $arr = DB::connection('sqlsrv3')->table('LandInformation')->where('ID', '=', $id)->get();
        foreach ($arr as $arr1) {

        }


        $this->fpdf->SetFont('Times', 'B', 14);
        $this->fpdf->Cell(105, 6, '', 0, 0, 'R', 0);
        $this->fpdf->SetTextColor(41, 46, 46);

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->ln(5);
        $this->fpdf->Cell(135, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Date: ' . $arr1->DocDate, 0, 1, 'L', 0);
        $this->fpdf->Cell(135, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Moza No: ' . $arr1->MozaNo, 0, 1, 'L', 0);
        $this->fpdf->Cell(135, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Deal No: ' . $arr1->DealNo, 0, 1, 'L', 0);
        $this->fpdf->Cell(135, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Maraba No: ' . $arr1->MarabaNo, 0, 1, 'L', 0);
        $this->fpdf->Cell(135, 6, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Khasra No: ' . $arr1->KhasraNo, 0, 1, 'L', 0);
        $this->fpdf->ln(10);
        $this->fpdf->Cell(60, 6, 'Seller Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Total Area', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Acre Price', 1, 0, 'C', 0);
        $this->fpdf->Cell(40, 6, 'Additional Charges', 1, 0, 'C', 0);
        $this->fpdf->Cell(35, 6, 'Total Price', 1, 1, 'C', 0);

        $this->fpdf->SetFont('Times', '', 10);

        $this->fpdf->Cell(60, 10, substr($arr1->SellerName, 0, 42), 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 10, $arr1->TotalArea, 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 10, number_format($arr1->AcrePrice), 1, 0, 'C', 0);
        $this->fpdf->Cell(40, 10, number_format($arr1->AdditionalCharges), 1, 0, 'C', 0);
        $this->fpdf->Cell(35, 10, number_format($arr1->TotalPrice), 1, 1, 'C', 0);

        $this->fpdf->MultiCell(160, 6, 'Amounts In Words: ' . $this->numberToWord($arr1->TotalPrice) . ' Rupees Only', 0, 'L', false);

        $this->fpdf->ln(15);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(60, 6, 'Paid By:', 0, 0, 'L', 0);
        $this->fpdf->Cell(60, 6, 'Supervised By:', 0, 0, 'C', 0);
        $this->fpdf->Cell(60, 6, 'Received By:', 0, 1, 'R', 0);
        $fetch_paid_detail = DB::connection('sqlsrv3')->table('LandInformation')->where('CreatedBy', '=', $arr1->CreatedBy)->get();
        foreach ($fetch_paid_detail as $fetch_paid_detail1) {

        }


        $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $arr1->CreatedBy)->get();
        foreach ($fetch_user_detail as $fetch_user_detail1) {

        }


        $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);
        $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'C', 0);


        $this->fpdf->Cell(60, 6, '___________________', 0, 1, 'R', 0);


        $this->fpdf->Output();
        exit;
    }

    public function landpayment_pvletter($id)
    {

        $check_security = DB::connection('sqlsrv3')->table('LandInformation')->where('ID', '=', $id)->where('TotalPaid', '!=', 0)->exists();
        if ($check_security) {
            $users = DB::connection('sqlsrv3')->table('LandInformation')->where('ID', '=', $id)->where('TotalPaid', '!=', 0)->get();
            foreach ($users as $users57) {
            }
            $this->fpdf = new Fpdf;
            $this->fpdf->AddPage("L", ['280', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 140, 15, 35, 17);
            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(105, 6, '', 0, 0, 'R', 0);
            $this->fpdf->SetTextColor(250, 248, 248);
            $this->fpdf->Cell(85, 12, 'LAND PAYMENT VOUCHER', 0, 1, 'C', 1);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(40, 6, 'Seller Name: ' . $users57->SellerName, 0, 0, 'L', 0);
            $this->fpdf->Cell(160, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Payment Voucher', 0, 1, 'R', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(40, 6, 'Deal No: ' . $users57->DealNo, 0, 0, 'L', 0);
            $this->fpdf->Cell(170, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(42, 6, 'PV ID: ' . $users57->PVID, 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, 'Khasra No: ' . $users57->KhasraNo, 0, 1, 'L', 0);
            $this->fpdf->Cell(40, 6, 'Moza No: ' . $users57->MozaNo, 0, 1, 'L', 0);
            $this->fpdf->Cell(40, 6, 'Maraba No: ' . $users57->MarabaNo, 0, 1, 'L', 0);
            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(220, 6, 'Description', 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 6, 'Paid', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(220, 15, ('Land Payment information of  ' . $users57->SellerName . ' use of Amount ' . number_format($users57->TotalPaid)), 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 15, number_format($users57->TotalPaid), 1, 1, 'C', 0);
            $this->fpdf->Cell(220, 6, 'Remaining Amount:', 0, 0, 'R', 0);
            $this->fpdf->Cell(40, 6, number_format($users57->Remaining), 0, 1, 'C', 0);
            $this->fpdf->Output();
            exit;
        }
    }

    public function po_letter1($po_type, $vendor, $proj, $dept, $create_by, $check, $startingdate, $enddate)
    {
        $this->fpdf->AddPage("L", ['280', '292']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);
        // $this->fpdf->Text(95, 15, "Purchase Order Report");
        $this->fpdf->SetLeftMargin(5);

        $fetch_image1 = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->first();

        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(110, 17, 'Purchase Order Report');
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 235, 7, 43, 15);


        $this->fpdf->SetFont('Times', '', 10);
        $this->fpdf->Text(200, 33, 'Date From:');
        $this->fpdf->Text(221, 33, $startingdate);


        $this->fpdf->Text(200, 40, 'Date To:');
        $this->fpdf->Text(221, 40, $enddate);


        $this->fpdf->ln(39);

        $this->fpdf->Cell(18, 6, 'Date', 1, 0, 'C', 0);
        $this->fpdf->Cell(23, 6, 'PO ID', 1, 0, 'C', 0);
        $this->fpdf->Cell(45, 6, 'Department', 1, 0, 'L', 0);
        $this->fpdf->Cell(37, 6, 'Project', 1, 0, 'L', 0);
        $this->fpdf->Cell(30, 6, 'Vendor Name', 1, 0, 'L', 0);
        $this->fpdf->Cell(15, 6, 'Delivery', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Amount', 1, 0, 'C', 0);
        $this->fpdf->SetX(188);

        $this->fpdf->Cell(40, 6, 'Item Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Qty', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Per Unit', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Price', 1, 1, 'C', 0);

        $find;
        if ($vendor == 'All' && $proj == 'All' && $dept == 'All' && $po_type == 'All' && $create_by == 'All' && $check == 'All' && $startingdate != '' && $enddate != '') {
            $data = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'Requisition.RequisitionId', '=', 'PurchaseOrder.AgainstReq')->where("PurchaseOrder.CompanyID", "=", company_id())->where('PurchaseOrder.PoDate', '>=', $startingdate)->where('PurchaseOrder.PoDate', '<=', $enddate)->select('PurchaseOrder.*', 'Requisition.ProjectName', 'Requisition.DepartmentName')->get();
            $find = $data;
        } else {
            if ($vendor == 'All') {
                $vendor = '';
            }
            if ($proj == 'All') {
                $proj = '';
            }
            if ($dept == 'All') {
                $dept = '';
            }
            if ($create_by == 'All') {
                $create_by = '';
            }
            if ($check == 'GRN Generated' && $po_type != 'All') {
                $data = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'Requisition.RequisitionId', '=', 'PurchaseOrder.AgainstReq')->where("PurchaseOrder.CompanyID", "=", company_id())->where("PurchaseOrder.vendorName", 'like', '%' . $vendor . '%')->where("PurchaseOrder.CreatedBy", 'like', '%' . $create_by . '%')->where("PurchaseOrder.RequisitionType", '=', $po_type)->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('PurchaseOrder.state', '=', 1)->where('Requisition.DepartmentName', 'like', '%' . $dept . '%')->where('PurchaseOrder.PoDate', '>=', $startingdate)->where('PurchaseOrder.PoDate', '<=', $enddate)->select('PurchaseOrder.*', 'Requisition.ProjectName', 'Requisition.DepartmentName')->get();
                $find = $data;
            } else if ($check == 'GRN Generated' && $po_type == 'All') {

                $data = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'Requisition.RequisitionId', '=', 'PurchaseOrder.AgainstReq')->where("PurchaseOrder.CompanyID", "=", company_id())->where("PurchaseOrder.vendorName", 'like', '%' . $vendor . '%')->where("PurchaseOrder.CreatedBy", 'like', '%' . $create_by . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('PurchaseOrder.state', '=', 1)->where('Requisition.DepartmentName', 'like', '%' . $dept . '%')->where('PurchaseOrder.PoDate', '>=', $startingdate)->where('PurchaseOrder.PoDate', '<=', $enddate)->select('PurchaseOrder.*', 'Requisition.ProjectName', 'Requisition.DepartmentName')->get();
                $find = $data;
            } else if ($check == 'GRN Not Generated' && $po_type != 'All') {
                $data = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'Requisition.RequisitionId', '=', 'PurchaseOrder.AgainstReq')->where("PurchaseOrder.CompanyID", "=", company_id())->where("PurchaseOrder.vendorName", 'like', '%' . $vendor . '%')->where("PurchaseOrder.CreatedBy", 'like', '%' . $create_by . '%')->where("PurchaseOrder.RequisitionType", '=', $po_type)->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('PurchaseOrder.state', '=', 0)->where('Requisition.DepartmentName', 'like', '%' . $dept . '%')->where('PurchaseOrder.PoDate', '>=', $startingdate)->where('PurchaseOrder.PoDate', '<=', $enddate)->select('PurchaseOrder.*', 'Requisition.ProjectName', 'Requisition.DepartmentName')->get();
                $find = $data;

            } else if ($check == 'GRN Not Generated' && $po_type == 'All') {
                $data = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'Requisition.RequisitionId', '=', 'PurchaseOrder.AgainstReq')->where("PurchaseOrder.CompanyID", "=", company_id())->where("PurchaseOrder.vendorName", 'like', '%' . $vendor . '%')->where("PurchaseOrder.CreatedBy", 'like', '%' . $create_by . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('PurchaseOrder.state', '=', 0)->where('Requisition.DepartmentName', 'like', '%' . $dept . '%')->where('PurchaseOrder.PoDate', '>=', $startingdate)->where('PurchaseOrder.PoDate', '<=', $enddate)->select('PurchaseOrder.*', 'Requisition.ProjectName', 'Requisition.DepartmentName')->get();
                $find = $data;

            } else if ($check == 'All' && $po_type != 'All') {

                $data = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'Requisition.RequisitionId', '=', 'PurchaseOrder.AgainstReq')->where("PurchaseOrder.CompanyID", "=", company_id())->where("PurchaseOrder.RequisitionType", '=', $po_type)->where("PurchaseOrder.vendorName", 'like', '%' . $vendor . '%')->where("PurchaseOrder.CreatedBy", 'like', '%' . $create_by . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.DepartmentName', 'like', '%' . $dept . '%')->where('PurchaseOrder.PoDate', '>=', $startingdate)->where('PurchaseOrder.PoDate', '<=', $enddate)->select('PurchaseOrder.*', 'Requisition.ProjectName', 'Requisition.DepartmentName')->get();
                $find = $data;
            } else {
                $data = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'Requisition.RequisitionId', '=', 'PurchaseOrder.AgainstReq')->where("PurchaseOrder.CompanyID", "=", company_id())->where("PurchaseOrder.vendorName", 'like', '%' . $vendor . '%')->where("PurchaseOrder.CreatedBy", 'like', '%' . $create_by . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.DepartmentName', 'like', '%' . $dept . '%')->where('PurchaseOrder.PoDate', '>=', $startingdate)->where('PurchaseOrder.PoDate', '<=', $enddate)->select('PurchaseOrder.*', 'Requisition.ProjectName', 'Requisition.DepartmentName')->get();
                $find = $data;
            }

        }
        foreach ($find as $find_config1) {


            $arr = DB::connection('sqlsrv3')->table("PurchaseOrderItems")->where("CompanyID", "=", company_id())->where("POID", '=', $find_config1->PurchaseOrderID)->get();

            $this->fpdf->Cell(18, 6, $find_config1->PoDate, 0, 0, 'C', 0);
            $this->fpdf->Cell(23, 6, $find_config1->PoCode, 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 8);

            $this->fpdf->Cell(45, 6, Str::substr($find_config1->DepartmentName, 0, 33), 0, 0, 'L', 0);
            $this->fpdf->Cell(37, 6, Str::substr($find_config1->ProjectName, 0, 25), 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, Str::substr($find_config1->vendorName, 0, 20), 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);

            $this->fpdf->Cell(15, 6, number_format($find_config1->ShippingCharges), 0, 0, 'L', 0);
            $this->fpdf->Cell(20, 6, number_format($find_config1->TotalAmount), 0, 0, 'L', 0);


            foreach ($arr as $arr1) {
                $this->fpdf->SetX(188);


                $this->fpdf->Cell(40, 6, (Str::substr($arr1->ItemName, 0, 25)), 0, 0, 'L', 0);
                $this->fpdf->Cell(15, 6, number_format($arr1->Quantity), 0, 0, 'L', 0);
                $this->fpdf->Cell(15, 6, number_format($arr1->Price), 0, 0, 'L', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->SubTotal), 0, 1, 'L', 0);

            }
            $this->fpdf->ln(15);


        }
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->ln(2);
        $this->fpdf->Output();
        exit;
    }

    public function po_letter($id, $poid)
    {
        $q_Items = [];
        $q_Items1 = [];

        $fetch_company_detail1 = DB::table('tb_create_company')->where('company_id', '=', company_id())->first();
        $check_security = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('PoCode', '=', $poid)->where('PurchaseOrderID', '=', $id)->exists();
        if ($check_security) {
            $PO_detail = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('PoCode', '=', $poid)->where('PurchaseOrderID', '=', $id)->first();

            if ($PO_detail->Status == 'Full') {
                $q_Items = DB::connection('sqlsrv3')->table('PurchaseOrderItems')
                    ->where('POID', '=', $id)
                    ->pluck('ItemId'); // Get an array of ItemId values


                $q_Items1 = DB::connection('sqlsrv3')->table('PQuotationItems')
                    ->where('QuotationID', '=', $PO_detail->AgainstQuo)
                    ->whereNotIn('ItemId', $q_Items)
                    ->where('State', 'true')
                    ->get();


                if ($q_Items1->isNotEmpty()) {
                    $quotation_Items = DB::connection('sqlsrv3')->table('PQuotationItems')
                        ->where('QuotationID', '=', $PO_detail->AgainstQuo)
                        ->whereIn('ItemId', $q_Items1->pluck('ItemId')) // Use pluck to get ItemId values
                        ->get();
                    foreach ($quotation_Items as $quotation_Item) {
                        $poItem = [
                            'CompanyID' => company_id(),
                            'POID' => $id,
                            'QuoteQuantity' => $quotation_Item->Quantity,
                            'Quantity' => $quotation_Item->Quantity,
                            'Price' => $quotation_Item->Price,
                            'SubTotal' => $quotation_Item->Total,
                            'Detail' => $quotation_Item->Detail,
                            'Unit' => $quotation_Item->Unit,
                            'ItemId' => $quotation_Item->ItemId,
                            'ItemName' => $quotation_Item->ItemName,
                        ];
                        DB::connection('sqlsrv3')->table('PurchaseOrderItems')->insert($poItem);
                    }
                }
            }
            $get_req1 = DB::connection('sqlsrv3')->table('PurchaseOrder')->join('Requisition', 'Requisition.RequisitionId', '=', 'PurchaseOrder.AgainstReq')->join('Vendor', 'PurchaseOrder.vendorName', '=', 'Vendor.CompanyName')->where('PurchaseOrder.CompanyID', '=', company_id())->select('Vendor.*', 'PurchaseOrder.*', 'Requisition.RId', 'Requisition.DepartmentName', 'Requisition.ProjectName')->where('PurchaseOrder.PoCode', '=', $poid)->where('PurchaseOrder.PurchaseOrderID', '=', $id)->first();
            if ($get_req1->RequisitionType != 'Services') {
                $get_req_detail = DB::connection('sqlsrv3')->table('PurchaseOrderItems')->join('ItemList', 'ItemList.ID', '=', 'PurchaseOrderItems.itemId')->where('PurchaseOrderItems.POID', '=', $get_req1->PurchaseOrderID)->get();
            } else {
                $get_req_detail = DB::connection('sqlsrv3')->table('PurchaseOrderItems')->where('POID', '=', $get_req1->PurchaseOrderID)->get();
            }
            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image1 = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->first();

           $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 18);
            $this->fpdf->Text(75, 15, 'Purchase Order');
            $this->fpdf->SetFont('', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
           $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 155, 8, 43, 11);
            $this->fpdf->ln(4);
            $this->fpdf->Text(10, 35, 'PO # : ');
            $this->fpdf->Text(27, 35, $get_req1->PoCode);
            $this->fpdf->Text(160, 35, 'Date:');
            $this->fpdf->Text(173, 35, $get_req1->PoDate);
            $this->fpdf->ln(23);


            $this->fpdf->SetFont('', 'B', 12);
            $this->fpdf->SetTextColor(233, 242, 235);
            $this->fpdf->Cell(90, 5, 'VENDOR', 1, 0, 'C', 1);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(90, 5, 'SHIP TO', 1, 1, 'C', 1);
            $this->fpdf->SetFont('', '', 12);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Cell(30, 6, 'Company Name', 1, 0, 'L', 0);
            $this->fpdf->SetFont('', '', 10);
            $this->fpdf->Cell(60, 6, substr($get_req1->CompanyName, 0, 25), 1, 0, 'L', 0);
            $this->fpdf->SetFont('', '', 12);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Company Name', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->company_name, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Email Id:', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->Email, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Email Id:', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->CreatedBy, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Address', 1, 0, 'L', 0);
            $this->fpdf->SetFont('', '', 10);
            $this->fpdf->Cell(60, 6, substr($get_req1->Address, 0, 25), 1, 0, 'L', 0);
            $this->fpdf->SetFont('', '', 12);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'City', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->city, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Phone', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->Mobile, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Phone', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $fetch_company_detail1->phone_number, 1, 1, 'L', 0);


            $this->fpdf->ln(10);

            $this->fpdf->SetFont('', 'B', 12);
            $this->fpdf->Cell(30, 5, 'Requisition ID', 1, 0, 'C', 0);
            $this->fpdf->Cell(60, 5, 'Department', 1, 0, 'C', 0);
            $this->fpdf->Cell(75, 5, 'Project', 1, 0, 'C', 0);
            $this->fpdf->Cell(23, 5, 'Req. Type', 1, 1, 'C', 0);
            $this->fpdf->SetFont('', '', 12);
            $this->fpdf->Cell(30, 6, $get_req1->RId, 1, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, $get_req1->DepartmentName, 1, 0, 'C', 0);
            $this->fpdf->Cell(75, 6, $get_req1->ProjectName, 1, 0, 'C', 0);
            $this->fpdf->Cell(23, 6, $get_req1->RequisitionType, 1, 1, 'C', 0);
            $this->fpdf->ln(10);

            $this->fpdf->SetFont('', 'B', 12);
            if ($get_req1->RequisitionType != 'Services') {
                $this->fpdf->Cell(20, 5, 'Item #', 1, 0, 'C', 0);
                $this->fpdf->Cell(80, 5, 'Description', 1, 0, 'C', 0);
            } else {

                $this->fpdf->Cell(100, 5, 'Services Description', 1, 0, 'C', 0);
            }

            $this->fpdf->Cell(20, 5, 'Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(15, 5, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 5, 'Unit Price', 1, 0, 'C', 0);
            $this->fpdf->Cell(33, 5, 'Total Price', 1, 1, 'C', 0);
            $this->fpdf->SetFont('', '', 12);
            foreach ($get_req_detail as $get_req_detail1) {
                $this->fpdf->SetFont('', '', 8);
                if ($get_req1->RequisitionType != 'Services') {
                    $a = '';
                    if (strlen($get_req_detail1->Detail) > 25) {
                        $a = '..';
                    }
                    $this->fpdf->Cell(20, 6, $get_req_detail1->ItemCode, 1, 0, 'C', 0);
                    $this->fpdf->SetFont('', '', 10);
                    $this->fpdf->Cell(80, 6, $get_req_detail1->ItemName . ' : ' . substr($get_req_detail1->Detail, 0, 26) . $a, 1, 0, 'L', 0);
                } else {
                    $a = '';
                    if (strlen($get_req_detail1->Detail) > 78) {
                        $a = '..';
                    }
                    $this->fpdf->Cell(100, 6, substr($get_req_detail1->Detail, 0, 80) . $a, 1, 0, 'C', 0);
                }
                $this->fpdf->SetFont('', '', 12);
                $this->fpdf->Cell(20, 6, $get_req_detail1->Quantity, 1, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, $get_req_detail1->Unit, 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($get_req_detail1->Price, 1), 1, 0, 'C', 0);
                $this->fpdf->Cell(33, 6, 'Rs.' . number_format($get_req_detail1->SubTotal, 1), 1, 1, 'C', 0);
            }

            $this->fpdf->SetFont('', '', 10);
//            $this->fpdf->Cell(30, 6, 'Narration:' . substr($get_req1->Remarks, 0, 120), 0, 1, 'L', 0);
            //
            $this->fpdf->MultiCell(189, 6, 'Narration: ' . $get_req1->Remarks, 0, 'L', false);
            //
            $this->fpdf->SetFont('', '', 12);
            $this->fpdf->Cell(120, 4, '', 0, 1, 'L', 0);

            $this->fpdf->SetFont('', 'B', 12);
            $this->fpdf->Cell(120, 4, 'Payment Term: ' . substr($get_req1->PaymentTerm, 0, 70), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 4, '', 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, 'Terms & Conditions', 0, 1, 'L', 0);

            $this->fpdf->SetFont('', '', 10);
            $this->fpdf->Cell(120, 6, '- Goods not fully upto the mark will be rejected.', 0, 1, 'L', 0);

            $this->fpdf->SetFont('', '', 10);
            $this->fpdf->Cell(120, 6, '- Goods are subject to our inspection on arrival at destination.', 0, 1, 'L', 0);

            $this->fpdf->SetFont('', '', 10);
            $this->fpdf->Cell(120, 6, '- Deliver this order in accordance with the price, terms, and', 0, 0, 'L', 0);
            $this->fpdf->SetFont('', '', 12);
            $this->fpdf->Cell(30, 6, 'Subtotal:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->SubTotal), 0, 1, 'L', 0);
            $this->fpdf->SetFont('', '', 10);
            $this->fpdf->Cell(120, 6, 'delivery method, and specifications listed above.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('', '', 12);
            $this->fpdf->Cell(30, 6, 'Delivery:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->ShippingCharges), 0, 1, 'L', 0);
            $this->fpdf->SetFont('', '', 10);
            $this->fpdf->Cell(120, 6, '- Notify us immediatly if you are unable to ship as specified.', 0, 0, 'L', 0);

            $this->fpdf->SetFont('', '', 12);
            $this->fpdf->Cell(30, 6, 'Tax:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->Tax), 0, 1, 'L', 0);
            $this->fpdf->SetFont('', '', 10);
            $this->fpdf->Cell(120, 6, '- SA Gardens reserves the rights to accept/reject any item found defected.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('', '', 12);
            $this->fpdf->Cell(30, 6, 'Discount:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->Discount), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '- Failure to deliver an item above will automatically authorized ', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '_________________________', 0, 1, 'L', 0);
            $this->fpdf->SetFont('', '', 10);
            $this->fpdf->Cell(120, 6, 'SA Gardens to purchase the undelivered item on risk & cost of Supplier.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('', 'B', 12);
            $this->fpdf->Cell(30, 6, 'Total:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->TotalAmount) . '/-', 0, 1, 'L', 0);
            $this->fpdf->MultiCell(160, 6, 'Amounts In Words: ' . $this->numberToWord(round($get_req1->TotalAmount)) . ' Rupees Only', 0, 'L', false);
            $this->fpdf->ln(20);

            $Est_time_currency1 = DB::connection('sqlsrv3')->table('PurchaseOrder')->join('PQuotation', 'PQuotation.QuotationID', '=', 'PurchaseOrder.AgainstQuo')->select('PQuotation.Est_Completion_time', 'PQuotation.Est_Completion_time1', 'PQuotation.Currency')->where('PurchaseOrder.PoCode', '=', $poid)->where('PurchaseOrder.PurchaseOrderID', '=', $id)->first();
            if ($Est_time_currency1->Est_Completion_time != null && $Est_time_currency1->Currency != null && $Est_time_currency1->Est_Completion_time1 != null) {

                $this->fpdf->SetFont('Times', 'B', 12);
                $this->fpdf->Cell(60, 6, 'Estimated Time of it\'s Quotation was: "' . $Est_time_currency1->Est_Completion_time . '' . $Est_time_currency1->Est_Completion_time1 . '" and the Currency Selected: "' . $Est_time_currency1->Currency . '" ', 0, 1, 'L', 0);
            }

            $this->fpdf->SetFont('', 'B', 12);
            $this->fpdf->Cell(60, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, '', 0, 1, 'R', 0);
            $this->fpdf->ln(2);
            $fetch_user_detail1 = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->first();
            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, '', 0, 1, 'R', 0);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(33);
            $this->fpdf->Output();
            exit;
        }
    }


    public function quotation_letter($id, $rid)
    {

        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }
        if (DB::connection('sqlsrv3')->table('PQuotation')->where('CompanyID', '=', company_id())->where('RequisitionID', '=', $rid)->where('QuotationNumber', '=', $id)->exists()) {
            $get_req1 = DB::connection('sqlsrv3')->table('PQuotation')->join('Requisition', 'Requisition.RequisitionId', '=', 'PQuotation.RequisitionID')->join('Vendor', 'PQuotation.VendorName', '=', 'Vendor.CompanyName')->where('PQuotation.CompanyID', '=', company_id())->select('Vendor.*', 'PQuotation.*', 'Requisition.RequisitionType', 'Requisition.RId', 'Requisition.DepartmentName', 'Requisition.ProjectName')->where('PQuotation.RequisitionID', '=', $rid)->where('PQuotation.QuotationNumber', '=', $id)->first();

            $check_image = DB::connection('sqlsrv3')->table('PQuotation')->where('CompanyID', '=', company_id())->where('RequisitionID', '=', $rid)->where('QuotationNumber', '=', $id)->where('Photo', '!=', null)->exists();
            if ($get_req1->Status != 'finalize') {
                if ($get_req1->RequisitionType != 'Services') {
                    $get_req_detail = DB::connection('sqlsrv3')->table('PQuotationItems')->join('ItemList', 'ItemList.ID', '=', 'PQuotationItems.itemId')->where('PQuotationItems.QuotationID', '=', $get_req1->QuotationID)->get();
                } else {
                    $get_req_detail = DB::connection('sqlsrv3')->table('PQuotationItems')->where('QuotationID', '=', $get_req1->QuotationID)->get();
                }
            } else {
                if ($get_req1->RequisitionType != 'Services') {
                    $get_req_detail = DB::connection('sqlsrv3')->table('PQuotationItems')->join('ItemList', 'ItemList.ID', '=', 'PQuotationItems.itemId')->where('PQuotationItems.QuotationID', '=', $get_req1->QuotationID)->where('PQuotationItems.State', '=', 'true')->get();
                } else {
                    $get_req_detail = DB::connection('sqlsrv3')->table('PQuotationItems')->where('QuotationID', '=', $get_req1->QuotationID)->where('State', '=', 'true')->get();
                }
            }

            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(75, 17, 'Quotation Form');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 15);
            $this->fpdf->Text(130, 30, 'Date: ');
            $this->fpdf->Text(155, 30, $get_req1->QuotationDate);
            $this->fpdf->Text(130, 37, 'Vendor: ');
            $this->fpdf->Text(155, 37, substr($get_req1->VendorName, 0, 16));
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Text(130, 44, 'Email Id: ');
            $this->fpdf->Text(155, 44, $get_req1->Email);

            $this->fpdf->Text(130, 51, 'Phone No: ');
            $this->fpdf->Text(155, 51, $get_req1->Mobile);
            $this->fpdf->Text(13, 40, 'For Department: ' . $get_req1->RId . ' (' . $get_req1->DepartmentName . ') ');
            $this->fpdf->Text(13, 47, 'Project: ' . $get_req1->ProjectName);
            $this->fpdf->Text(13, 54, 'Req Type: ' . $get_req1->RequisitionType);
            $this->fpdf->Text(13, 61, 'Payment Term: ' . $get_req1->PaymentTerm);

            $this->fpdf->ln(57);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(80, 5, 'Description', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 5, 'Quantity', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 5, 'Cost', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 5, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 5, 'Price', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 10);
            foreach ($get_req_detail as $get_req_detail1) {

                if ($get_req1->RequisitionType != 'Services') {
                    $this->fpdf->Cell(80, 6, $get_req_detail1->ItemCode . ' : ' . substr($get_req_detail1->ItemName, 0, 30), 1, 0, 'C', 0);
                } else {
                    $this->fpdf->Cell(80, 6, substr($get_req_detail1->Detail, 0, 50), 1, 0, 'C', 0);
                }
                $this->fpdf->Cell(20, 6, $get_req_detail1->Quantity, 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($get_req_detail1->Price), 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, $get_req_detail1->Unit, 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, number_format($get_req_detail1->Total), 1, 1, 'C', 0);
            }

            $this->fpdf->Cell(30, 6, 'Narration:' . $get_req1->Remarks, 0, 1, 'L', 0);
            $this->fpdf->ln(1);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Subtotal:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'RS.' . number_format($get_req1->SubTotal), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Delivery:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'RS.' . number_format($get_req1->ShippingCharges), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Tax:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'RS.' . number_format($get_req1->Tax), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Discount:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'RS.' . number_format($get_req1->Discount), 0, 1, 'L', 0);

            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '____________________', 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Total:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'RS.' . number_format($get_req1->Total), 0, 1, 'L', 0);

            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(60, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, 'Quotation Status', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, 'Admin', 0, 1, 'R', 0);
            $this->fpdf->ln(2);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);

            $this->fpdf->Cell(60, 6, $get_req1->Status, 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, '_____________', 0, 1, 'R', 0);

            //

            if ($check_image) {
                $this->fpdf->AddPage("P", ['210', '297']);
                $this->fpdf->SetFont('Times', 'B', 22);
                $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 6, 7, 35, 17);
                $this->fpdf->Text(63, 17, 'Quotation Attachment');
                $this->fpdf->SetFont('Times', '', 14);
                $this->fpdf->SetTextColor(41, 46, 46);
                $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 12);
                $this->fpdf->Text(130, 30, 'Date: ');
                $this->fpdf->Text(155, 30, $get_req1->QuotationDate);
                $this->fpdf->SetFont('Times', '', 12);
                $this->fpdf->Text(13, 37, 'For Department: ' . $get_req1->RId . ' (' . $get_req1->DepartmentName . ') ');
                $this->fpdf->Text(13, 44, 'Project: ' . $get_req1->ProjectName);
                $this->fpdf->Text(130, 37, 'Req Type: ' . $get_req1->RequisitionType);
                $this->fpdf->Text(130, 44, 'Payment Term: ' . $get_req1->PaymentTerm);
                $pdf = explode(".pdf", $get_req1->Photo);
                $jfif = explode(".jfif", $get_req1->Photo);
                if (count($pdf) <= 1 && count($jfif) <= 1) {
                    $this->fpdf->Image('public/images/quotation_images/' . $get_req1->Photo, 10, 50, 180);
                } else {
                    $this->fpdf->SetFont('Times', 'B', 14);
                    $this->fpdf->Text(80, 80, 'Invalid image format');
                    $this->fpdf->SetFont('Times', '', 12);
                }
            }
            $this->fpdf->Output();
            exit;
        } else {
        }
    }

    public function asset_assignletter($id)
    {

        $data = DB::connection('sqlsrv3')->table('Assets')->join('ItemList', 'Assets.AssetID', '=', 'ItemList.ID')->select('Assets.*',  'ItemList.ItemCode', 'ItemList.Name')->where('Assets.AssetType', '=', 2)->where('Assets.AssetsUniqueID', '=', $id)->orderBy('Assets.ID', 'desc')->first();

        $check_security = DB::connection('sqlsrv3')->table('Assets')->join('ItemList', 'Assets.AssetID', '=', 'ItemList.ID')->where('Assets.AssetType', '=', 2)->where('Assets.AssetsUniqueID', '=', $id)->orderBy('Assets.ID', 'desc')->first();
        if ($check_security) {

            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetLeftMargin(7);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(75, 17, 'Asset Assign Form');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 15);
            $this->fpdf->Text(130, 30, 'Date: ');
            $this->fpdf->Text(155, 30, $data->Dated);

            $this->fpdf->ln(37);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(30, 7, 'Item Code', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 7, 'Asset ID', 1, 0, 'C', 0);
            $this->fpdf->Cell(50, 7, 'Asset Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(90, 7, 'Reference', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(30, 7, $data->ItemCode, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 7, $data->AssetsUniqueID, 1, 0, 'C', 0);
            $this->fpdf->Cell(50, 7, $data->Name, 1, 0, 'C', 0);
            $this->fpdf->MultiCell(90, 7, $data->Reference, 1, 'L', false);

            $this->fpdf->SetFont('Times', 'B', 12);
            // Adjust vertical spacing
            $this->fpdf->ln(3);
            $this->fpdf->Cell(50, 7, 'Employee Name:', 1, 0, 'C', 0);
            $this->fpdf->Cell(50, 7, 'Department:', 1, 0, 'C', 0);
            $this->fpdf->Cell(50, 7, 'Project:', 1, 0, 'C', 0);
            $this->fpdf->Cell(45, 7, 'Location:', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 10);

            if(!empty($data->EmployeeCode)){
                $name=DB::connection('sqlsrv2')->table('Emp_Profile')->where('CompanyID', '=', company_id())->where('Employee_Code','=',$data->EmployeeCode)->select('Name')->first();

                $this->fpdf->Cell(50, 7, $name->Name, 1, 0, 'C', 0);

            }else{
                $this->fpdf->Cell(50, 7, '', 1, 0, 'C', 0);

            }
            $this->fpdf->Cell(50, 7, $data->AssignedTo, 1, 0, 'C', 0);
            $this->fpdf->Cell(50, 7, $data->Project, 1, 0, 'C', 0);
            $this->fpdf->Cell(45, 7, $data->Location, 1, 1, 'C', 0);

            $this->fpdf->SetFont('', '', 10);

            $this->fpdf->MultiCell(189, 6, 'Narration: ' . $data->Remarks, 0, 'L', false);
            $this->fpdf->ln(30);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(60, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, 'Assigned By:', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, 'Assigned To', 0, 1, 'R', 0);
            $this->fpdf->ln(2);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $data->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);

            $this->fpdf->Cell(60, 6, '_____________', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, $data->EmployeeCode, 0, 1, 'R', 0);

            //

            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetY(-15);
            $this->fpdf->Cell(0, 10, 'Printed Date: ' . short_date(), 0, 0, 'C');
            $this->fpdf->Output();
            exit;
        } else {
        }
    }

    public function petty_Letter($id, $pid)
    {

        $check_security = DB::connection('sqlsrv3')->table('PettyCash')->where('CompanyID', '=', company_id())->where('ID', '=', $id)->where('PettyID', '=', $pid)->exists();
        if ($check_security) {
            $users = DB::connection('sqlsrv3')->table('PettyCash')->where('ID', '=', $id)->get();
            $text = DB::connection('sqlsrv3')->table('PettyCashDetail')->where('PID', '=', $id)->get();

            foreach ($users as $users57) {


            }
            $this->fpdf = new Fpdf;
            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }


            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(70, 17, '');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 15);
            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->Text(90, 20, "FY " . $users57->Session);

            $this->fpdf->Text(53, 30, "REQUEST FOR  PETTY CASH ADJUSTMENT");


            $this->fpdf->SetFont('Arial', 'B', 11);
            $this->fpdf->Text(10, 38, "Petty Cash ID : ");
            $this->fpdf->SetFont('Arial', '', 11);
            $this->fpdf->Text(43, 38, $users57->PettyID);


            $this->fpdf->SetFont('Arial', 'B', 11);
            $this->fpdf->Text(10, 45, "Originated By : ");
            $this->fpdf->SetFont('Arial', '', 11);
            $this->fpdf->Text(43, 45, $users57->DeptName);
            //  $this->fpdf->Line(53, 46, 90, 46);


            $this->fpdf->SetFont('Arial', 'B', 11);
            $this->fpdf->Text(10, 52, "Date:");
            $this->fpdf->SetFont('Arial', '', 11);
            $this->fpdf->Text(43, 52, $users57->PettyDate);
            //   $this->fpdf->Line(53, 54, 90, 54);
            $this->fpdf->Ln(50);

            foreach ($text as $text15) {
                $this->fpdf->SetFont('Arial', 'B', 10);


                $this->fpdf->SetFont('Arial', 'B', 10);
                $this->fpdf->Cell(100, 5, "Vendor Name", 1, 0, 'L');
                $this->fpdf->Cell(50, 5, "Bill No.", 1, 0, 'L');
                $this->fpdf->Cell(40, 5, "Amount", 1, 1, 'L');

                $this->fpdf->SetFont('Arial', '', 10);
                $this->fpdf->Cell(100, 5, $text15->VendorName, 1, 0, 'L');
                $this->fpdf->Cell(50, 5, $text15->BillNumber, 1, 0, 'L');
                $this->fpdf->Cell(40, 5, number_format($text15->Amount), 1, 1, 'L');
                $this->fpdf->MultiCell(190, 6, 'Item Detail: ' . $text15->ItemDetail, 1, 'L', false);
                $this->fpdf->Ln(5);

            }


            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->Cell(145, 7, "Total Amount", 1, 0, 'C');

            $this->fpdf->Cell(45, 7, 'Rs. ' . number_format($users57->TotalAmount), 1, 1, 'R');


            $this->fpdf->Ln(20);


            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Ln(10);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $users57->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            $this->fpdf->Cell(60, 0, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L');
            if ($users57->UpdatedBy != null) {
                $fetch_user_detail9 = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $users57->UpdatedBy)->get();
                foreach ($fetch_user_detail9 as $fetch_user_detail91) {

                }
                $this->fpdf->Cell(60, 0, $fetch_user_detail91->first_name . ' ' . $fetch_user_detail91->last_name, 0, 0, 'C');
            } else {
                $this->fpdf->Cell(60, 0, 'Not Verified', 0, 0, 'C');
            }

            $this->fpdf->Cell(65, 0, $users57->Status2, 0, 1, 'R');


            $this->fpdf->Cell(60, 5, '------------------------', 0, 0, 'L');
            $this->fpdf->Cell(60, 5, '-------------------------', 0, 0, 'C');
            $this->fpdf->Cell(65, 5, '------------------------', 0, 1, 'R');
            $this->fpdf->Ln(3);
            $this->fpdf->Cell(60, 0, 'Prepared By', 0, 0, 'L');
            $this->fpdf->Cell(60, 0, 'Checked By', 0, 0, 'C');
            $this->fpdf->Cell(65, 0, 'Accounts Status', 0, 1, 'R');


            $this->fpdf->Ln(5);
            $this->fpdf->Cell(185, 0, '', 1, 1, 'L');


            $this->fpdf->Output();
            exit;
        } else {

        }
    }

    public function req_letter($id, $rid)
    {

        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }

        $check_security = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $id)->where('RId', '=', $rid)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $id)->where('RId', '=', $rid)->get();
            foreach ($get_req as $get_req1) {

            }

            if ($get_req1->RequisitionType != 'Services') {
                $get_req_detail = DB::connection('sqlsrv3')->table('DemandRequisitionItem')->join('ItemList', 'ItemList.ID', '=', 'DemandRequisitionItem.itemId')->where('DemandRequisitionItem.ReqID', '=', $id)->get();
            } else {
                $get_req_detail = DB::connection('sqlsrv3')->table('DemandRequisitionItem')->where('ReqID', '=', $id)->get();
            }


            $this->fpdf->AddPage("L", ['280', '277']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }


            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(110, 17, 'Requisition Form');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 225, 7, 43, 15);
            $this->fpdf->Text(160, 30, 'Request ID:');
            $this->fpdf->Text(198, 30, $get_req1->RId);
            $this->fpdf->Text(160, 38, 'Request Date:');
            $this->fpdf->Text(198, 38, $get_req1->Dated);

            $this->fpdf->Text(160, 46, 'Department:');
            $this->fpdf->Text(188, 46, $get_req1->DepartmentName);
            $this->fpdf->Text(160, 54, 'Project:');
            $this->fpdf->Text(188, 54, $get_req1->ProjectName);
            $this->fpdf->Text(160, 62, 'Type:');
            $this->fpdf->Text(192, 62, $get_req1->RequisitionType);

            $this->fpdf->ln(60);
            // table 2

            $this->fpdf->SetFont('Times', 'B', 12);
            if ($get_req1->RequisitionType != 'Services') {
                $this->fpdf->Cell(25, 5, 'ItemCode', 1, 0, 'C', 0);
                $this->fpdf->Cell(160, 5, 'Item Description', 1, 0, 'C', 0);
            } else {
                $this->fpdf->Cell(165, 5, 'Services Description', 1, 0, 'C', 0);
            }
            $this->fpdf->Cell(18, 5, 'Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 5, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 5, 'Est. Cost', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            foreach ($get_req_detail as $get_req_detail1) {
                $this->fpdf->SetFont('Times', '', 10);
                if ($get_req1->RequisitionType != 'Services') {
                    $this->fpdf->Cell(25, 6, $get_req_detail1->ItemCode, 1, 0, 'L', 0);
                    $this->fpdf->SetFont('Times', '', 8);
                    $this->fpdf->Cell(160, 6, substr($get_req_detail1->ItemName . ' - ' . $get_req_detail1->Detail, 0, 70), 1, 0, 'L', 0);
                } else {
                    $this->fpdf->Cell(165, 6, $get_req_detail1->Detail, 1, 0, 'L', 0);
                }

                $this->fpdf->SetFont('Times', '', 12);
                $this->fpdf->Cell(18, 6, number_format($get_req_detail1->Quantity), 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, $get_req_detail1->unit, 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, number_format($get_req_detail1->EstCost), 1, 1, 'C', 0);
            }


            $this->fpdf->ln(2);

            $this->fpdf->Cell(20, 6, 'Narration:', 0, 0, 'L', 0);
            $this->fpdf->Cell(160, 6, $get_req1->Narration, 0, 1, 'L', 0);

            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(80, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->Cell(80, 6, 'Requisition Status', 0, 0, 'C', 0);
            $this->fpdf->Cell(80, 6, 'Admin', 0, 1, 'R', 0);

            $this->fpdf->ln(2);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }


            $this->fpdf->Cell(80, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);
            $this->fpdf->Cell(80, 6, $get_req1->Status, 0, 0, 'C', 0);
            $this->fpdf->Cell(80, 6, '_____________', 0, 1, 'R', 0);


            $this->fpdf->Output();
            exit;


        } else {

        }


    }

    public function Issuance_report1($dept, $rid, $proj, $item, $startingdate, $enddate)
    {


        $this->fpdf->AddPage("L", ['280', '282']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);
        // $this->fpdf->Text(95, 15, "Issuance Detail Report");
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }


        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(110, 17, 'Issuance Detail Report');
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 220, 7, 43, 15);

        $this->fpdf->ln(15);
        $this->fpdf->SetFont('Times', '', 10);
        $this->fpdf->Text(200, 33, 'Date From:');
        $this->fpdf->Text(221, 33, $startingdate);
        $this->fpdf->Text(200, 40, 'Date To:');
        $this->fpdf->Text(221, 40, $enddate);


        $this->fpdf->ln(29);

        $this->fpdf->Cell(18, 6, 'T. Date', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'I ID', 1, 0, 'C', 0);
        $this->fpdf->Cell(45, 6, 'Department', 1, 0, 'C', 0);
        $this->fpdf->Cell(45, 6, 'Project', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Status', 1, 0, 'C', 0);

        $this->fpdf->SetX(175);

        $this->fpdf->Cell(50, 6, 'Item Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Req. Qty', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Unit', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Issuance Qty', 1, 1, 'C', 0);
        $find_rid = DB::connection('sqlsrv3')->table("Issuances")->where('CompanyID', '=', company_id())->where('IssuanceCode', '=', $rid)->select('IssuanceId')->get();
        foreach ($find_rid as $find_rid1) {

        }
        $find=0;
        if ($dept == 'All' && $rid == 'All' && $proj == 'All' && $startingdate != '' && $enddate != '') {
            $data = DB::connection('sqlsrv3')->table("Issuances")->where("Issuances.CompanyID", "=", company_id())->where('Issuances.IssuanceDate', '>=', $startingdate)->where('Issuances.IssuanceDate', '<=', $enddate)->orderby('IssuanceId', 'desc')->get();
            $find = $data;
        } else {
            if ($dept == 'All') {
                $dept = '';
            }

            if ($proj == 'All') {
                $proj = '';
            }
            if ($rid == 'All') {
                $data = DB::connection('sqlsrv3')->table("Issuances")->where("Issuances.CompanyID", "=", company_id())->where("Issuances.DepartmentName", 'like', '%' . $dept . '%')->where("Issuances.ProjectName", 'like', '%' . $proj . '%')->where('Issuances.IssuanceDate', '>=', $startingdate)->where('Issuances.IssuanceDate', '<=', $enddate)->orderby('IssuanceId', 'desc')->get();
                $find = $data;
            } else {

                $data = DB::connection('sqlsrv3')->table("Issuances")->where("Issuances.CompanyID", "=", company_id())->where("Issuances.DepartmentName", 'like', '%' . $dept . '%')->where("Issuances.ProjectName", 'like', '%' . $proj . '%')->where("Issuances.IssuanceId", '=', $find_rid1->IssuanceId)->where('Issuances.IssuanceDate', '>=', $startingdate)->where('Issuances.IssuanceDate', '<=', $enddate)->orderby('IssuanceId', 'desc')->get();
                $find = $data;
            }

        }
        foreach ($find as $find_config1) {
            if ($item != 'All') {
                $arr = DB::connection('sqlsrv3')->table("IssuanceItem")->where("IssuanceId", '=', $find_config1->IssuanceId)->where('itemId', '=', $item)->get();

            } else {

                $arr = DB::connection('sqlsrv3')->table("IssuanceItem")->where("IssuanceId", '=', $find_config1->IssuanceId)->get();
            }


            $this->fpdf->Cell(18, 6, $find_config1->IssuanceDate, 0, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, $find_config1->IssuanceCode, 0, 0, 'L', 0);
            $this->fpdf->Cell(45, 6, Str::substr($find_config1->DepartmentName, 0, 30), 0, 0, 'L', 0);
            $this->fpdf->Cell(45, 6, Str::substr($find_config1->ProjectName, 0, 25), 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, $find_config1->Status, 0, 0, 'L', 0);


            foreach ($arr as $arr1) {
                $this->fpdf->SetX(175);


                $this->fpdf->Cell(50, 6, (Str::substr($arr1->ItemName, 0, 22)), 0, 0, 'L', 0);
                $this->fpdf->Cell(15, 6, number_format($arr1->ReqQuantity), 0, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, $arr1->unit, 0, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->IssuanceQuantity), 0, 1, 'C', 0);

            }
            $this->fpdf->ln(15);


        }
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->ln(2);
        $this->fpdf->Output();
        exit;
    }

    public function Requisition_Letter1($dept, $rid, $proj, $item, $startingdate, $enddate)
    {


        $this->fpdf->AddPage("L", ['280', '282']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);
        //$this->fpdf->Text(95, 15, "Requisition Report");
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }


        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(110, 17, 'Requisition Report');
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 235, 7, 43, 15);

        $this->fpdf->ln(15);


        $this->fpdf->SetFont('Times', '', 10);
        $this->fpdf->Text(200, 33, 'Date From:');
        $this->fpdf->Text(221, 33, $startingdate);
        $this->fpdf->Text(200, 40, 'Date To:');
        $this->fpdf->Text(221, 40, $enddate);


        $this->fpdf->ln(29);

        $this->fpdf->Cell(18, 6, 'Dated', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'R ID', 1, 0, 'C', 0);
        $this->fpdf->Cell(40, 6, 'Department', 1, 0, 'C', 0);
        $this->fpdf->Cell(45, 6, 'Project', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Req. Type', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Status', 1, 0, 'C', 0);

        $this->fpdf->SetX(175);

        $this->fpdf->Cell(50, 6, 'Item Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Qty', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Unit', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Price', 1, 1, 'C', 0);

        $find=0;
        if ($dept == 'All' && $rid == 'All' && $proj == 'All' && $startingdate != '' && $enddate != '') {
            $data = DB::connection('sqlsrv3')->table("Requisition")->where("CompanyID", "=", company_id())->where('Dated', '>=', $startingdate)->where('Dated', '<=', $enddate)->get();
            $find = $data;
        } else {
            if ($dept == 'All') {
                $dept = '';
            }

            if ($proj == 'All') {
                $proj = '';
            }
            if ($rid == 'All') {
                $data = DB::connection('sqlsrv3')->table("Requisition")->where("CompanyID", "=", company_id())->where("DepartmentName", 'like', '%' . $dept . '%')->where("ProjectName", 'like', '%' . $proj . '%')->where('Dated', '>=', $startingdate)->where('Dated', '<=', $enddate)->get();
                $find = $data;
            } else {
                $data = DB::connection('sqlsrv3')->table("Requisition")->where("CompanyID", "=", company_id())->where("DepartmentName", 'like', '%' . $dept . '%')->where("ProjectName", 'like', '%' . $proj . '%')->where("RId", '=', $rid)->where('Dated', '>=', $startingdate)->where('Dated', '<=', $enddate)->get();
                $find = $data;
            }

        }
        foreach ($find as $find_config1) {
            if ($item != 'All') {
                $arr = DB::connection('sqlsrv3')->table("RequisitionItem")->where("ReqID", '=', $find_config1->RequisitionId)->where('itemId', '=', $item)->get();

            } else {

                $arr = DB::connection('sqlsrv3')->table("RequisitionItem")->where("ReqID", '=', $find_config1->RequisitionId)->get();
            }


            $this->fpdf->Cell(18, 6, $find_config1->Dated, 0, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, $find_config1->RId, 0, 0, 'L', 0);
            $this->fpdf->Cell(40, 6, Str::substr($find_config1->DepartmentName, 0, 22), 0, 0, 'L', 0);
            $this->fpdf->Cell(45, 6, Str::substr($find_config1->ProjectName, 0, 27), 0, 0, 'L', 0);
            $this->fpdf->Cell(20, 6, $find_config1->RequisitionType, 0, 0, 'L', 0);
            $this->fpdf->Cell(20, 6, $find_config1->Status, 0, 0, 'L', 0);


            foreach ($arr as $arr1) {
                $this->fpdf->SetX(175);


                $this->fpdf->Cell(50, 6, (Str::substr($arr1->ItemName, 0, 22)), 0, 0, 'L', 0);
                $this->fpdf->Cell(15, 6, number_format($arr1->Quantity), 0, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, $arr1->unit, 0, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->EstCost), 0, 1, 'C', 0);

            }
            $this->fpdf->ln(15);


        }
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->ln(2);
        $this->fpdf->Output();
        exit;
    }

    public function grn_letter1($vendor, $startingdate, $enddate)
    {

        $counted1 = 55;
        $row = 1;
        $this->fpdf->AddPage("L", ['290', '292']);
        $this->fpdf->SetFont('Times', 'B', 24);
        $this->fpdf->SetTextColor(41, 46, 46);
        // $this->fpdf->Text(95, 15, "GRN Detail Report");
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }

        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 37, 18);
        $this->fpdf->Text(105, 17, 'GRN Detail Report');
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 235, 7, 43, 13);

        $this->fpdf->ln(5);
        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Text(110, 25, 'Date From: ' . $startingdate . ' to ' . $enddate);
        $this->fpdf->ln(15);
        $this->fpdf->SetX(5);
        $this->fpdf->SetTextColor(250, 248, 248);
        $this->fpdf->Cell(18, 6, 'Date', 1, 0, 'C', 1);
        $this->fpdf->Cell(21, 6, 'GRN #', 1, 0, 'C', 1);
        $this->fpdf->Cell(21, 6, 'PO #', 1, 0, 'C', 1);
        $this->fpdf->Cell(21, 6, 'PR #', 1, 0, 'C', 1);
        $this->fpdf->Cell(43, 6, 'Vendor Name', 1, 0, 'C', 1);
        $this->fpdf->Cell(27, 6, 'Status', 1, 0, 'C', 1);

        $this->fpdf->SetX(158);
        $this->fpdf->Cell(34, 6, 'Item Name', 1, 0, 'C', 1);
        $this->fpdf->Cell(15, 6, 'Po Qty', 1, 0, 'C', 1);
        $this->fpdf->Cell(20, 6, 'Recvd Qty', 1, 0, 'C', 1);
        $this->fpdf->Cell(15, 6, 'Unit', 1, 0, 'C', 1);
        $this->fpdf->Cell(15, 6, 'Per Unit', 1, 0, 'C', 1);
        $this->fpdf->Cell(25, 6, 'Total', 1, 1, 'C', 1);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->SetFont('Times', '', 9);
        $find=0;
        if ($vendor == 'All' && $startingdate != '' && $enddate != '') {
            $data = DB::connection('sqlsrv3')->table("GrnOrder")->join("PurchaseOrder", "GrnOrder.POID", "=", "PurchaseOrder.PurchaseOrderID")->join('Requisition', 'Requisition.RequisitionId', '=', 'GrnOrder.ReqID')->where("GrnOrder.CompanyID", "=", company_id())->where('GrnOrder.Dated', '>=', $startingdate)->where('GrnOrder.Dated', '<=', $enddate)->select("GrnOrder.*", "PurchaseOrder.vendorName", 'PurchaseOrder.PoCode', 'Requisition.RId')->orderby('GrnOrder.GrnID', 'asc')->get();
            $find = $data;
        } else {
            if ($vendor == 'All') {
                $vendor = '';
            }
            $data = DB::connection('sqlsrv3')->table("GrnOrder")->join("PurchaseOrder", "GrnOrder.POID", "=", "PurchaseOrder.PurchaseOrderID")->join('Requisition', 'Requisition.RequisitionId', '=', 'GrnOrder.ReqID')->where("GrnOrder.CompanyID", "=", company_id())->where("PurchaseOrder.vendorName", 'like', '%' . $vendor . '%')->where('GrnOrder.Dated', '>=', $startingdate)->where('GrnOrder.Dated', '<=', $enddate)->select("GrnOrder.*", "PurchaseOrder.vendorName", 'PurchaseOrder.PoCode', 'Requisition.RId')->orderby('GrnOrder.GrnID', 'asc')->get();
            $find = $data;
        }
        foreach ($find as $index => $find_config1) {
            $arr = DB::connection('sqlsrv3')->table("GrnOrderItems")->where("CompanyID", "=", company_id())->where("GrnID", '=', $find_config1->GrnOrderID)->get();
            $this->fpdf->setFillColor(218, 218, 218);
            if ($index % 2 == 0) {
                $fill = 0;
            } else {
                $fill = 1;
            }

            $this->fpdf->Cell(18, 6, $find_config1->Dated, 0, 0, 'C', $fill);
            $this->fpdf->Cell(21, 6, $find_config1->GrnID, 0, 0, 'C', $fill);
            $this->fpdf->Cell(21, 6, $find_config1->PoCode, 0, 0, 'C', $fill);
            $this->fpdf->Cell(21, 6, $find_config1->RId, 0, 0, 'L', $fill);
            $this->fpdf->Cell(43, 6, Str::substr($find_config1->vendorName, 0, 26), 0, 0, 'L', $fill);
            $this->fpdf->Cell(27, 6, $find_config1->Status, 0, 0, 'L', $fill);
            foreach ($arr as $arr1) {
                $this->fpdf->SetX(158);


                $this->fpdf->Cell(34, 6, Str::substr($arr1->ItemName, 0, 25), 0, 0, 'L', $fill);
                $this->fpdf->Cell(15, 6, number_format($arr1->PoQuantity), 0, 0, 'C', $fill);
                $this->fpdf->Cell(20, 6, number_format($arr1->RecvdQuantity), 0, 0, 'C', $fill);
                $this->fpdf->Cell(15, 6, $arr1->Unit, 0, 0, 'C', $fill);
                $this->fpdf->Cell(15, 6, number_format($arr1->Price), 0, 0, 'C', $fill);
                $this->fpdf->Cell(25, 6, number_format($arr1->Price * $arr1->RecvdQuantity), 0, 1, 'C', $fill);
                $row++;
                if ($row % 34 == 0) {
                    $this->fpdf->AddPage("L", ['280', '297']);
                    $this->fpdf->SetFont('Times', 'B', 12);
                    $this->fpdf->SetTextColor(41, 46, 46);
                    $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 8, 5, 17, 9);
                    $this->fpdf->Text(110, 10, 'GRN Detail Report (Continue)');
                    $this->fpdf->SetFont('Times', '', 14);
                    $this->fpdf->SetTextColor(41, 46, 46);
                    $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 262, 6, 21, 6);
                    $this->fpdf->SetFont('Times', 'B', 10);
                    $this->fpdf->ln(5);
                    $this->fpdf->SetX(5);
                    $this->fpdf->SetTextColor(250, 248, 248);
                    $this->fpdf->setFillColor(1, 1, 1);
                    $this->fpdf->Cell(18, 6, 'Date', 1, 0, 'C', 1);
                    $this->fpdf->Cell(21, 6, 'GRN #', 1, 0, 'C', 1);
                    $this->fpdf->Cell(21, 6, 'PO #', 1, 0, 'C', 1);
                    $this->fpdf->Cell(21, 6, 'PR #', 1, 0, 'C', 1);
                    $this->fpdf->Cell(43, 6, 'Vendor Name', 1, 0, 'C', 1);
                    $this->fpdf->Cell(27, 6, 'Status', 1, 0, 'C', 1);

                    $this->fpdf->SetX(158);
                    $this->fpdf->Cell(34, 6, 'Item Name', 1, 0, 'C', 1);
                    $this->fpdf->Cell(15, 6, 'Po Qty', 1, 0, 'C', 1);
                    $this->fpdf->Cell(20, 6, 'Recvd Qty', 1, 0, 'C', 1);
                    $this->fpdf->Cell(15, 6, 'Unit', 1, 0, 'C', 1);
                    $this->fpdf->Cell(15, 6, 'Per Unit', 1, 0, 'C', 1);
                    $this->fpdf->Cell(25, 6, 'Total', 1, 1, 'C', 1);
                    $this->fpdf->SetTextColor(41, 46, 46);
                    $this->fpdf->setFillColor(218, 218, 218);
                    $this->fpdf->SetFont('Times', '', 9);
                }
            }
            $this->fpdf->ln(1);


        }
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->ln(2);
        $this->fpdf->Output();
        exit;
    }

    public function QuotationComparative_report1($rid, $item, $vendor, $startingdate, $enddate)
    {


        $this->fpdf->AddPage("L", ['270', '282']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);
        // $this->fpdf->Text(95, 15, "Quotation Comparative Report");

        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }


        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(110, 17, 'Quotation Comparative Report');
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 235, 7, 43, 15);

        $this->fpdf->ln(15);


        $this->fpdf->SetFont('Times', '', 10);
        $this->fpdf->Text(200, 33, 'Date From:');
        $this->fpdf->Text(221, 33, $startingdate);
        $this->fpdf->Text(200, 40, 'Date To:');
        $this->fpdf->Text(221, 40, $enddate);


        $this->fpdf->ln(29);

        $this->fpdf->Cell(60, 6, 'VendorName', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Quotation Date', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Discount', 1, 0, 'C', 0);
        $this->fpdf->Cell(10, 6, 'Tax', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Delivery', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Total', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Status', 1, 0, 'C', 0);

        $this->fpdf->SetX(170);

        $this->fpdf->Cell(40, 6, 'Item Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Quantity', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Price', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Unit', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Subtotal', 1, 1, 'C', 0);

        $find;
        if ($vendor == 'All' && $rid == 'All' && $startingdate != '' && $enddate != '') {
            $data = DB::connection('sqlsrv3')->table("PQuotation")->where("CompanyID", "=", company_id())->where('QuotationDate', '>=', $startingdate)->where('QuotationDate', '<=', $enddate)->get();
            $find = $data;
        } else {
            if ($vendor == 'All') {
                $vendor = '';
            }
            if ($rid == 'All') {
                $data = DB::connection('sqlsrv3')->table("PQuotation")->where("CompanyID", "=", company_id())->where("VendorName", 'like', '%' . $vendor . '%')->where('QuotationDate', '>=', $startingdate)->where('QuotationDate', '<=', $enddate)->get();
                $find = $data;
            } else {
                $get_rid = DB::connection('sqlsrv3')->table("Requisition")->where("CompanyID", "=", company_id())->where("RId", '=', $rid)->select('RequisitionId')->get();
                foreach ($get_rid as $get_rid1) {

                }
                $data = DB::connection('sqlsrv3')->table("PQuotation")->where("CompanyID", "=", company_id())->where("VendorName", 'like', '%' . $vendor . '%')->where('RequisitionID', '=', $get_rid1->RequisitionId)->where('QuotationDate', '>=', $startingdate)->where('QuotationDate', '<=', $enddate)->get();
                $find = $data;
            }

        }
        foreach ($find as $find_config1) {
            if ($item != 'All') {
                $arr = DB::connection('sqlsrv3')->table("PQuotationItems")->where("QuotationID", '=', $find_config1->QuotationID)->where('ItemId', '=', $item)->get();

            } else {

                $arr = DB::connection('sqlsrv3')->table("PQuotationItems")->where("QuotationID", '=', $find_config1->QuotationID)->get();
            }


            $this->fpdf->Cell(60, 6, Str::substr($find_config1->VendorName, 0, 40), 0, 0, 'L', 0);
            $this->fpdf->Cell(25, 6, $find_config1->QuotationDate, 0, 0, 'L', 0);
            $this->fpdf->Cell(15, 6, number_format($find_config1->Discount), 0, 0, 'L', 0);
            $this->fpdf->Cell(10, 6, number_format($find_config1->Tax), 0, 0, 'L', 0);
            $this->fpdf->Cell(15, 6, number_format($find_config1->ShippingCharges), 0, 0, 'L', 0);
            $this->fpdf->Cell(20, 6, number_format($find_config1->Total), 0, 0, 'L', 0);
            $this->fpdf->Cell(15, 6, $find_config1->Status, 0, 0, 'L', 0);


            foreach ($arr as $arr1) {
                $this->fpdf->SetX(170);


                $this->fpdf->Cell(40, 6, (Str::substr($arr1->ItemName, 0, 22)), 0, 0, 'L', 0);
                $this->fpdf->Cell(15, 6, number_format($arr1->Quantity), 0, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, number_format($arr1->Price), 0, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, $arr1->Unit, 0, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, number_format($arr1->Total), 0, 1, 'C', 0);

            }
            $this->fpdf->ln(15);


        }
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->ln(2);
        $this->fpdf->Output();
        exit;
    }

    public function pi_letter($id, $roid)
    {
        $check_security = DB::connection('sqlsrv3')->table('ReceivingOrder')->where('CompanyID', '=', company_id())->where('ReceavingOrderID', '=', $id)->where('FormID', '=', $roid)->exists();
        if ($check_security) {
            $get_req1 = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'ReceivingOrder.POID')->join('Vendor', 'PurchaseOrder.vendorName', '=', 'Vendor.CompanyName')->join('GrnOrder', 'ReceivingOrder.GRNID', '=', 'GrnOrder.GrnOrderID')->select('PurchaseOrder.*', 'ReceivingOrder.*', 'GrnOrder.GrnID', 'Vendor.*', 'ReceivingOrder.CreatedBy as InvoiceCreator')->where('ReceivingOrder.CompanyID', '=', company_id())->where('ReceivingOrder.ReceavingOrderID', '=', $id)->where('ReceivingOrder.FormID', '=', $roid)->first();

            if ($get_req1->RequisitionType != 'Services') {
                $get_req_detail = DB::connection('sqlsrv3')->table('ReceivingOrderItems')->join('ItemList', 'ItemList.ID', '=', 'ReceivingOrderItems.itemId')->where('ReceivingOrderItems.ROID', '=', $get_req1->ReceavingOrderID)->get();
            } else {
                $get_req_detail = DB::connection('sqlsrv3')->table('ReceivingOrderItems')->where('ROID', '=', $get_req1->ReceavingOrderID)->get();
            }
            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image1 = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->first();
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 30, 17);
            $this->fpdf->Text(70, 18, 'Purchase Invoice');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 159, 7, 44, 12);
            $this->fpdf->Text(150, 30, 'Date:');
            $this->fpdf->Text(165, 30, $get_req1->Dated);
            $this->fpdf->Text(150, 37, 'PI #:');
            $this->fpdf->Text(165, 37, $get_req1->FormID);
            $this->fpdf->Text(15, 37, 'GRN #:');
            $this->fpdf->Text(35, 37, $get_req1->GrnID);
            $this->fpdf->ln(35);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->SetTextColor(233, 242, 235);
            $this->fpdf->Cell(90, 5, 'VENDOR', 1, 0, 'C', 1);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(90, 5, 'SHIP TO', 1, 1, 'C', 1);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Cell(30, 6, 'Company Name', 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(60, 6, substr($get_req1->CompanyName, 0, 25), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Company Name', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, company_detail()->company_name, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Email Id', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->Email, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Email Id', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, company_detail()->company_email, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Address', 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(60, 6, substr($get_req1->Address, 0, 25), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'City', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, company_detail()->city, 1, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Phone', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, $get_req1->Mobile, 1, 0, 'L', 0);
            $this->fpdf->SetX(108);
            $this->fpdf->Cell(30, 6, 'Phone', 1, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, company_detail()->phone_number, 1, 1, 'L', 0);
            $this->fpdf->SetX(108);
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            if ($get_req1->RequisitionType != 'Services') {
                $this->fpdf->Cell(25, 5, 'ID', 1, 0, 'C', 0);
                $this->fpdf->Cell(80, 5, 'Item Name', 1, 0, 'C', 0);
            } else {
                $this->fpdf->Cell(105, 5, 'Services Description', 1, 0, 'C', 0);
            }
            $this->fpdf->Cell(25, 5, 'Rcv. Qty', 1, 0, 'C', 0);

            $this->fpdf->Cell(25, 5, 'Price', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 5, 'Total Price', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 10);
            foreach ($get_req_detail as $get_req_detail1) {

                if ($get_req1->RequisitionType != 'Services') {
                    $this->fpdf->Cell(25, 6, $get_req_detail1->ItemCode, 1, 0, 'C', 0);
                    $this->fpdf->Cell(80, 6, $get_req_detail1->ItemName, 1, 0, 'L', 0);
                } else {
                    $this->fpdf->Cell(105, 6, $get_req_detail1->Detail, 1, 0, 'C', 0);
                }

                $this->fpdf->Cell(25, 6, $get_req_detail1->RecvdQuantity, 1, 0, 'C', 0);

                $this->fpdf->Cell(25, 6, 'Rs.' . number_format($get_req_detail1->Price), 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req_detail1->SubTotal), 1, 1, 'C', 0);
            }

            $this->fpdf->SetFont('Times', '', 12);

            $this->fpdf->Cell(30, 6, 'Narration:' . substr($get_req1->Remarks, 0, 70), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(120, 6, '', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(120, 6, 'Terms & Conditions', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Goods not fully upto the mark will be rejected.', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Goods are subject to our inspection on arrival at destination.', 0, 1, 'L', 0);

            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Deliver this order in accordance with the price, terms, and', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Subtotal:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->SubTotal), 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, 'delivery method, and specifications listed above.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Delivery:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->ShippingCharges), 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- Notify us immediatly if you are unable to ship as specified.', 0, 0, 'L', 0);

            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Tax:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->Tax), 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, '- SA Gardens reserves the rights to accept/reject any item found defected.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, 'Discount:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->Discount), 0, 1, 'L', 0);
            $this->fpdf->Cell(120, 6, '- Failure to deliver an item above will automatically authorized ', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '_________________________', 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(120, 6, 'SA Gardens to purchase the undelivered item on risk & cost of Supplier.', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(30, 6, 'Total:', 0, 0, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Rs.' . number_format($get_req1->TotalAmount) . '/-', 0, 1, 'L', 0);
            $this->fpdf->MultiCell(160, 6, 'Amounts In Words: ' . $this->numberToWord(round($get_req1->TotalAmount)) . ' Rupees Only', 0, 'L', false);
            $this->fpdf->ln(20);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(60, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, '', 0, 1, 'R', 0);
            $this->fpdf->ln(2);

            $this->fpdf->Cell(60, 6, $get_req1->InvoiceCreator, 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, '_____________', 0, 1, 'R', 0);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(33);

            $this->fpdf->Output();
            exit;
        }
    }

    public function payment_letter($pid, $pvid)
    {
        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }

        $check_security = DB::connection('sqlsrv3')->table('PaymentVoucher')->where('CompanyID', '=', company_id())->where('PaymentVoucherID', '=', $pid)->where('PVID', '=', $pvid)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('PaymentVoucher')->where('CompanyID', '=', company_id())->where('PaymentVoucherID', '=', $pid)->where('PVID', '=', $pvid)->get();
            foreach ($get_req as $get_req1) {

            }

            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/' . $fetch_company_detail1->company_logo, 10, 5, 50, 15);
            $this->fpdf->Text(95, 14, 'PAYMENT VOUCHER');
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Text(15, 25, $fetch_company_detail1->company_name . ' , ' . $fetch_company_detail1->city);
            $this->fpdf->Text(130, 30, 'Date:');
            $this->fpdf->Text(155, 30, $get_req1->VoucherDate);
            $this->fpdf->Text(130, 37, 'PV #:');
            $this->fpdf->Text(155, 37, $get_req1->PVID);
            $this->fpdf->ln(40);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(40, 6, 'Payment Against:', 1, 0, 'L', 0);
            $this->fpdf->Cell(141, 6, $get_req1->PaymentAgainst, 1, 1, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(181, 6, 'Mode of Payment', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(40, 6, 'Cash/Bank/Cheque:', 1, 0, 'L', 0);
            $this->fpdf->Cell(141, 6, $get_req1->MethodType, 1, 1, 'L', 0);

            $this->fpdf->Cell(40, 6, 'Amount in Words:', 1, 0, 'L', 0);
            $this->fpdf->Cell(141, 6, $this->numberToWord(round($get_req1->Amount)) . ' Only', 1, 1, 'L', 0);
            $this->fpdf->Cell(40, 6, 'Amount in digits:', 1, 0, 'L', 0);
            $this->fpdf->Cell(141, 6, 'Rs. ' . number_format($get_req1->Amount) . '/-', 1, 1, 'L', 0);
            $this->fpdf->Cell(15, 6, 'Being:', 0, 0, 'L', 0);
            $this->fpdf->MultiCell(166, 6, ('Against ' . $get_req1->InvoiceNumber . ' / ' . $get_req1->SalesPerson . ', ' . 'Account ID:' . $get_req1->MethodAccountID . ' / ' . 'Cheque No: ' . $get_req1->ChqNumber), 1, 'L', false);

            $this->fpdf->Cell(90, 6, 'Created By:', 1, 0, 'L', 0);
            $this->fpdf->Cell(91, 6, 'Approved By:', 1, 1, 'L', 0);
            $this->fpdf->Cell(90, 24, $get_req1->CreatedBy, 1, 0, 'L', 0);
            $this->fpdf->Cell(91, 24, $get_req1->UpdatedOn, 1, 1, 'L', 0);
            $this->fpdf->Cell(20, 6, 'Narration:', 0, 0, 'L', 0);
            $this->fpdf->MultiCell(120, 6, $get_req1->Naration, 0, 'L', false);
            $this->fpdf->ln(1);

            $this->fpdf->Output();
            exit;
        } else {
        }
    }

    public function numberToWord($num = '')
    {
        $num = (string)((int)$num);
        if ((int)($num) && ctype_digit($num)) {
            $words = array();
            $num = str_replace(array(',', ' '), '', trim($num));
            $list1 = array(
                '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
            );
            $list2 = array(
                '', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred'
            );
            $list3 = array(
                '', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion'
            );
            $num_length = strlen($num);
            $levels = (int)(($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);
            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds = (int)($num_part / 100);
                $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $tens = (int)($num_part % 100);
                $singles = '';
                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = (int)($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int)($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && (int)($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }
            $words = implode(', ', $words);
            $words = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words = str_replace(',', ' and', $words);
            }
            return $words;
        } else if (!((int)$num)) {
            return 'Zero';
        }
        return '';
    }

    public function pettycash_access($id)
    {


        $update_date = date("Y-m-d");
        $check_security = DB::connection('sqlsrv3')->table('PettyCashAccess')->where('CompanyID', '=', company_id())->where('PettyCashAccess.ID', '=', $id)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('PettyCashAccess')->where('CompanyID', '=', company_id())->where('PettyCashAccess.ID', '=', $id)->get();
            foreach ($get_req as $get_req1) {
            }


            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }

            $date = explode(" ", $get_req1->CreatedOn);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(75, 17, 'PETTY CASH');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 15);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Text(145, 43, 'Date:');
            $this->fpdf->Text(165, 43, $date[0]);
            $this->fpdf->Text(15, 37, 'Payment To:');
            $this->fpdf->Text(50, 37, $get_req1->Name);
            $this->fpdf->Text(15, 43, 'Account ID:');
            $this->fpdf->Text(50, 43, $get_req1->AccountID);
            $this->fpdf->ln(40);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(170, 6, 'Description', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->MultiCell(170, 8, ('With Account ID : ' . $get_req1->COAID . ' And Account Name: ' . $get_req1->COAName), 1, 'L', false);
            $this->fpdf->SetFont('Times', 'B', 12);


            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(40, 6, 'Amount in Digits:', 1, 0, 'C', 0);
            $this->fpdf->Cell(130, 6, ('Rs. ' . number_format($get_req1->UpdatedAmount) . '/-'), 1, 1, 'L', 0);
            $this->fpdf->MultiCell(170, 6, 'Amount in Words: ' . ($this->numberToWord(round($get_req1->UpdatedAmount)) . ' Only'), 1, 'L', false);

            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(60, 6, 'Created By:', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, 'Supervised By:', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, 'Received By:', 0, 1, 'R', 0);

            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }

            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);

// $this->fpdf->Cell(60,6,$get_req1->CreatedBy,0,0,'L',0);


            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '________________', 0, 1, 'R', 0);

            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);

            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetY(-15);
            $this->fpdf->Cell(0, 10, 'Printed Date: ' . $update_date, 0, 0, 'C');
            $this->fpdf->Output();
            exit;
        } else {
        }
    }



    //


    //1
    public function salary_detail_deptreport()
    {
        //Need to add companies

        $page = 1;
        $row = 0;
        $sr = 1;

        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->get();
        foreach ($find_session_closed as $find_session1) {
        }
        $result = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->select('Emp_Register.Department')->whereNotNull('Emp_Register.Department')->where('PayrollFinanceApproval.StipendAmount', '>', 0)->orderby('Emp_Register.Department', 'asc')->groupBy('Emp_Register.Department')->get();
        $this->fpdf->AddPage("L", ['280', '297']);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 15, 12, 40, 12);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/sasystems.png', 247, 2, 34, 35);
        $this->fpdf->ln(3);
        // table 2
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->MultiCell(265, 8, 'Department Stipend Report' . "\n Salary month: " . Carbon::parse($find_session1->EndDate)->format('F Y'), 0, 'C', false);
        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
        $this->fpdf->Cell(75, 6, 'Department Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Stipend', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Allo. / Bonus', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Gross Payable', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Loan', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Advance', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Net Payable', 1, 1, 'C', 0);
        foreach ($result as $result1) {
            $fetch_detail = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->get();
            $stipend_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->whereNotNull('Emp_Register.Department')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.StipendAmount');
            $allowance_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->whereNotNull('Emp_Register.Department')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.AllowanceAmount');
            $bonus_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->whereNotNull('Emp_Register.Department')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.BonusAmount');
            $t_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->whereNotNull('Emp_Register.Department')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.TAmount');
            $installment_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->whereNotNull('Emp_Register.Department')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.InstallmentAmount');
            $advance_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->whereNotNull('Emp_Register.Department')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.AdvanceAmount');
            $payable_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->whereNotNull('Emp_Register.Department')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.PayableSalary');
            foreach ($fetch_detail as $get_req1) {
            }
            $dept = $get_req1->Department;
            $stipend = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $dept)->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.StipendAmount');
            $AllowanceAmount = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $dept)->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.AllowanceAmount');
            $BonusAmount = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $dept)->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.BonusAmount');
            $TAmount = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $dept)->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.TAmount');
            $InstallmentAmount = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $dept)->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.InstallmentAmount');
            $AdvanceAmount = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $dept)->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.AdvanceAmount');
            $PayableSalary = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $dept)->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('PayrollFinanceApproval.StipendAmount', '>', 0)->sum('PayrollFinanceApproval.PayableSalary');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetFillColor(237, 240, 238);
            if ($row % 2 == 0) {
                $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 0);
                $this->fpdf->Cell(75, 6, substr($dept, 0, 55), 1, 0, 'L', 0);
                $this->fpdf->Cell(30, 6, number_format($stipend), 1, 0, 'R', 0);
                $this->fpdf->Cell(30, 6, number_format($AllowanceAmount + $BonusAmount), 1, 0, 'R', 0);
                $this->fpdf->Cell(30, 6, number_format($TAmount), 1, 0, 'R', 0);
                $this->fpdf->Cell(30, 6, number_format($InstallmentAmount), 1, 0, 'R', 0);
                $this->fpdf->Cell(30, 6, number_format($AdvanceAmount), 1, 0, 'R', 0);
                $this->fpdf->Cell(30, 6, number_format($PayableSalary), 1, 1, 'R', 0);
            } else {
                $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 1);
                $this->fpdf->Cell(75, 6, substr($dept, 0, 55), 1, 0, 'L', 1);
                $this->fpdf->Cell(30, 6, number_format($stipend), 1, 0, 'R', 1);
                $this->fpdf->Cell(30, 6, number_format($AllowanceAmount + $BonusAmount), 1, 0, 'R', 1);
                $this->fpdf->Cell(30, 6, number_format($TAmount), 1, 0, 'R', 1);
                $this->fpdf->Cell(30, 6, number_format($InstallmentAmount), 1, 0, 'R', 1);
                $this->fpdf->Cell(30, 6, number_format($AdvanceAmount), 1, 0, 'R', 1);
                $this->fpdf->Cell(30, 6, number_format($PayableSalary), 1, 1, 'R', 1);
            }
            $row++;
            $sr++;
        }

        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->Cell(84, 6, 'Grand Total:', 1, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, number_format($stipend_sum) . '/-', 1, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, number_format($allowance_sum + $bonus_sum) . '/-', 1, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, number_format($t_sum) . '/-', 1, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, number_format($installment_sum) . '/-', 1, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, number_format($advance_sum) . '/-', 1, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, number_format($payable_sum) . '/-', 1, 1, 'R', 0);
        $this->fpdf->ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(40, 6, 'Prepared By:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Accounts:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Director HR:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 1, 'L', 0);
        $this->fpdf->ln(15);
        $this->fpdf->Cell(40, 6, '', 0, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, 'CEO: ', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Chairman:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->SetY(-10);
        $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);
        $this->fpdf->Output();
        exit;
    }

    //2
    public function salary_detail_deptsalaryreport()
    {
        $page = 0;
        $row = 0;
        $th_font = 13;
        $td_font = 12;
        $result = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->select('Emp_Register.Department')->groupBy('Emp_Register.Department')->where('Emp_Register.Department', '!=', " ")->where('IsDeleted', '=', 0)->get();
        //  return request()->json(200, $result);
        $this->fpdf->AddPage("L", ['280', '297']);
        $this->fpdf->SetFont('Times', 'B', 22);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }
        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->get();
        foreach ($find_session_closed as $find_session1) {
        }

        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 15, 12, 40, 12);
        $this->fpdf->SetFont('Arial', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/sasystems.png', 249, 2, 34, 35);
        $this->fpdf->ln(0);

        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->MultiCell(260, 10, 'Employee Salary Report', 0, 'C', false);
        $this->fpdf->SetFont('Times', 'B', 16);
        $this->fpdf->MultiCell(260, 10, "Salary month: " . Carbon::parse($find_session1->EndDate)->format('F Y'), 0, 'C', false);

        // table 2
        $sr = 1;

        foreach ($result as $result1) {

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->Cell(265, 5, "\"" . $result1->Department . "\"", 0, 1, 'C', 0);
            $this->fpdf->SetFont('Times', 'B', $th_font);
            $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
            $this->fpdf->Cell(23, 6, 'Emp. Code', 1, 0, 'C', 0);
            $this->fpdf->Cell(54, 6, 'Employee Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(54, 6, 'Designation', 1, 0, 'C', 0);
            $this->fpdf->Cell(22, 6, 'B Salary', 1, 0, 'C', 0);
            $this->fpdf->Cell(18, 6, 'Stipend', 1, 0, 'C', 0);
            $this->fpdf->Cell(15, 6, 'Bonus', 1, 0, 'C', 0);
            $this->fpdf->Cell(21, 6, 'Allowance', 1, 0, 'C', 0);
            $this->fpdf->Cell(22, 6, 'Loan', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Advance', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, ' Net Payable', 1, 1, 'C', 0);

            $this->fpdf->SetFont('Times', '', 12);
            $fetch_detail = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->join('Emp_Profile', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->select('Emp_Register.Department', 'Emp_Register.Designation', 'PayrollFinanceApproval.*', 'Emp_Register.JoiningDate', 'Emp_Register.EmployeeCode', 'Emp_Profile.Name')->orderBy('Emp_Profile.Name', 'asc')->get();

            $salary_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.Salary');

            $overtime_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.OAmount');
            $allowance_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.AllowanceAmount');
            $bonus_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.BonusAmount');
            $tax_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.TaxAmount');
            $loan_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.InstallmentAmount');
            $advance_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.AdvanceAmount');
            $absentee_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.DAmount');
            $ded_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.ArrearsAmount');
            $payable_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.PayableSalary');
            $stipend_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('Emp_Register.Department', '=', $result1->Department)->sum('PayrollFinanceApproval.StipendAmount');


            foreach ($fetch_detail as $get_req1) {
                $this->fpdf->SetFillColor(230, 240, 233);
                if ($sr % 39 == 0) {
                    $this->fpdf->SetY(-10);
                    $this->fpdf->SetFont('Arial', 'B', 10);
                    $page++;
                    $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);
                    $this->fpdf->AddPage("L", ['280', '297']);
                    $this->fpdf->SetFont('Times', 'B', 14);
                    $this->fpdf->Cell(265, 9, $result1->Department, 0, 1, 'C', 0);
                    $this->fpdf->SetFont('Times', 'B', $th_font);
                    $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
                    $this->fpdf->Cell(23, 6, 'Emp. Code', 1, 0, 'C', 0);
                    $this->fpdf->Cell(54, 6, 'Employee Name', 1, 0, 'C', 0);
                    $this->fpdf->Cell(54, 6, 'Designation', 1, 0, 'C', 0);
                    $this->fpdf->Cell(22, 6, 'B Salary', 1, 0, 'C', 0);
                    $this->fpdf->Cell(18, 6, 'Stipend', 1, 0, 'C', 0);
                    $this->fpdf->Cell(15, 6, 'Bonus', 1, 0, 'C', 0);
                    $this->fpdf->Cell(21, 6, 'Allowance', 1, 0, 'C', 0);
                    $this->fpdf->Cell(22, 6, 'Loan', 1, 0, 'C', 0);
                    $this->fpdf->Cell(20, 6, 'Advance', 1, 0, 'C', 0);
                    $this->fpdf->Cell(25, 6, ' Net Payable', 1, 1, 'C', 0);
                    $this->fpdf->SetFont('Times', '', $td_font);
                }
                if (strlen($get_req1->Designation) > 32) {
                    $dot = '..';
                } else {
                    $dot = '';
                }
                if ($row % 2 == 0) {
                    $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 0);
                    $this->fpdf->Cell(23, 6, $get_req1->EmployeeCode, 1, 0, 'C', 0);
                    $this->fpdf->Cell(54, 6, Str::substr($get_req1->Name, 0, 40), 1, 0, 'L', 0);
                    $this->fpdf->Cell(54, 6, substr($get_req1->Designation, 0, 32) . $dot, 1, 0, 'C', 0);
                    $this->fpdf->Cell(22, 6, number_format($get_req1->Salary), 1, 0, 'C', 0);
                    $this->fpdf->Cell(18, 6, $get_req1->StipendAmount, 1, 0, 'R', 0);
                    $this->fpdf->Cell(15, 6, number_format($get_req1->BonusAmount), 1, 0, 'R', 0);
                    $this->fpdf->Cell(21, 6, number_format($get_req1->AllowanceAmount), 1, 0, 'R', 0);
                    $this->fpdf->Cell(22, 6, number_format($get_req1->InstallmentAmount), 1, 0, 'R', 0);
                    $this->fpdf->Cell(20, 6, number_format($get_req1->AdvanceAmount), 1, 0, 'R', 0);
                    $this->fpdf->Cell(25, 6, number_format($get_req1->PayableSalary), 1, 1, 'R', 0);
                } else {
                    $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 1);
                    $this->fpdf->Cell(23, 6, $get_req1->EmployeeCode, 1, 0, 'C', 1);
                    $this->fpdf->Cell(54, 6, Str::substr($get_req1->Name, 0, 40), 1, 0, 'L', 1);
                    $this->fpdf->Cell(54, 6, substr($get_req1->Designation, 0, 32) . $dot, 1, 0, 'C', 1);
                    $this->fpdf->Cell(22, 6, number_format($get_req1->Salary), 1, 0, 'C', 1);
                    $this->fpdf->Cell(18, 6, $get_req1->StipendAmount, 1, 0, 'R', 1);
                    $this->fpdf->Cell(15, 6, number_format($get_req1->BonusAmount), 1, 0, 'R', 1);
                    $this->fpdf->Cell(21, 6, number_format($get_req1->AllowanceAmount), 1, 0, 'R', 1);
                    $this->fpdf->Cell(22, 6, number_format($get_req1->InstallmentAmount), 1, 0, 'R', 1);
                    $this->fpdf->Cell(20, 6, number_format($get_req1->AdvanceAmount), 1, 0, 'R', 1);
                    $this->fpdf->Cell(25, 6, number_format($get_req1->PayableSalary), 1, 1, 'R', 1);
                }
                $row++;
                $sr++;
            }
            $page++;
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Cell(140, 6, 'Total:  ', 1, 0, 'C', 0);
            $this->fpdf->Cell(22, 6, number_format($salary_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(18, 6, number_format($stipend_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(15, 6, number_format($bonus_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(21, 6, number_format($allowance_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(22, 6, number_format($loan_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(20, 6, number_format($advance_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(25, 6, number_format($payable_sum) . '/-', 1, 1, 'R', 0);
            $this->fpdf->SetY(-10);
            $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);
            $this->fpdf->AddPage("L", ['280', '297']);
            $sr = 1;
        }
        $this->fpdf->Output();
        exit;

    }


    public function salary_detail_report()
    {

        $page = 1;
        $sr = 1;
        $row = 0;
        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->get();
        foreach ($find_session_closed as $find_session1) {
        }
        //  return $find_session1->SessionName;
        $check = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->select('Emp_Register.CompanyName')->groupBy('Emp_Register.CompanyName')->orderby('Emp_Register.CompanyName')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->exists();
        if ($check) {


            $result = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.CompanyName')->select('Emp_Register.CompanyName')->groupBy('Emp_Register.CompanyName')->orderby('Emp_Register.CompanyName', 'asc')->get();
            //  return $result;


            $this->fpdf->AddPage("L", ['280', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 15, 12, 40, 12);
            $this->fpdf->SetFont('Arial', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/sasystems.png', 250, 2, 34, 35);
            $this->fpdf->ln(0);
            // table 2

            $this->fpdf->SetFont('Times', 'B', 18);
            $this->fpdf->MultiCell(260, 10, 'Company Salary Report' . "\n Salary month: " . Carbon::parse($find_session1->EndDate)->format('F Y'), 0, 'C', false);

            $this->fpdf->SetFont('Times', 'B', 10);
            $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
            $this->fpdf->Cell(50, 6, 'Company Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, 'Gross Salary', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Tax', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Loan', 1, 0, 'C', 0);
            $this->fpdf->Cell(18, 6, 'Advance', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, 'Deduction', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, 'Allowance', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Arrear', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, 'Stipend', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Net Payable', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 10);

            $arr = [];
            // $find_salary_sum;
            foreach ($result as $result1) {
                $fetch_detail = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->get([DB::raw('SUM(PayrollFinanceApproval.TAmount) AS grosssalary'), DB::raw('SUM(PayrollFinanceApproval.TaxAmount) AS tax'), DB::raw('SUM(PayrollFinanceApproval.InstallmentAmount) AS loan'), DB::raw('SUM(PayrollFinanceApproval.AdvanceAmount) AS advance'), DB::raw('SUM(DAmount) AS deduction'), DB::raw('SUM(PayrollFinanceApproval.AllowanceAmount) AS allowance'), DB::raw('SUM(PayrollFinanceApproval.ArrearsAmount) AS arrear'), DB::raw('SUM(PayrollFinanceApproval.StipendAmount) AS stipend'), DB::raw('SUM(PayrollFinanceApproval.PayableSalary) AS payable')]);
                $gross_salary_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.CompanyName')->sum('PayrollFinanceApproval.TAmount');
                $tax_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.CompanyName')->sum('PayrollFinanceApproval.TaxAmount');
                $loan_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.CompanyName')->sum('PayrollFinanceApproval.InstallmentAmount');
                $advance_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.CompanyName')->sum('PayrollFinanceApproval.AdvanceAmount');
                $dedu_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.CompanyName')->sum('PayrollFinanceApproval.DAmount');
                $allowance_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.CompanyName')->sum('PayrollFinanceApproval.AllowanceAmount');
                $arrear_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.CompanyName')->sum('PayrollFinanceApproval.ArrearsAmount');
                $stipend_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.CompanyName')->sum('PayrollFinanceApproval.StipendAmount');
                $payable_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.CompanyName')->sum('PayrollFinanceApproval.PayableSalary');
                //  $find_salary_sum=$salary_sum;
                $Array = Arr::flatten($fetch_detail);
                foreach ($Array as $get_req1) {

                    $this->fpdf->SetFillColor(237, 240, 238);
                    if ($row % 2 == 0) {
                        $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 0);
                        $this->fpdf->Cell(50, 6, Str::substr($result1->CompanyName, 0, 40), 1, 0, 'L', 0);

                        $this->fpdf->Cell(25, 6, number_format($get_req1->grosssalary), 1, 0, 'R', 0);
                        $this->fpdf->Cell(20, 6, number_format($get_req1->tax), 1, 0, 'R', 0);

                        $this->fpdf->Cell(20, 6, number_format($get_req1->loan), 1, 0, 'R', 0);
                        $this->fpdf->Cell(18, 6, number_format($get_req1->advance), 1, 0, 'R', 0);
                        $this->fpdf->Cell(25, 6, '0', 1, 0, 'R', 0);
                        $this->fpdf->Cell(25, 6, number_format($get_req1->allowance), 1, 0, 'R', 0);
                        $this->fpdf->Cell(20, 6, number_format($get_req1->arrear), 1, 0, 'R', 0);
                        $this->fpdf->Cell(25, 6, number_format($get_req1->stipend), 1, 0, 'R', 0);
                        $this->fpdf->Cell(30, 6, number_format($get_req1->payable), 1, 1, 'R', 0);
                    } else {
                        $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 1);
                        $this->fpdf->Cell(50, 6, Str::substr($result1->CompanyName, 0, 40), 1, 0, 'L', 1);

                        $this->fpdf->Cell(25, 6, number_format($get_req1->grosssalary), 1, 0, 'R', 1);
                        $this->fpdf->Cell(20, 6, number_format($get_req1->tax), 1, 0, 'R', 1);

                        $this->fpdf->Cell(20, 6, number_format($get_req1->loan), 1, 0, 'R', 1);
                        $this->fpdf->Cell(18, 6, number_format($get_req1->advance), 1, 0, 'R', 1);
                        $this->fpdf->Cell(25, 6, '0', 1, 0, 'R', 1);
                        $this->fpdf->Cell(25, 6, number_format($get_req1->allowance), 1, 0, 'R', 1);
                        $this->fpdf->Cell(20, 6, number_format($get_req1->arrear), 1, 0, 'R', 1);
                        $this->fpdf->Cell(25, 6, number_format($get_req1->stipend), 1, 0, 'R', 1);
                        $this->fpdf->Cell(30, 6, number_format($get_req1->payable), 1, 1, 'R', 1);
                    }
                    $row++;
                }

                $sr++;
            }
            $this->fpdf->SetFont('Times', 'B', 10);
            $this->fpdf->Cell(59, 6, 'Grand Total: ', 1, 0, 'R', 0);
            $this->fpdf->Cell(25, 6, number_format($gross_salary_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(20, 6, number_format($tax_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(20, 6, number_format($loan_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(18, 6, number_format($advance_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(25, 6, '0' . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(25, 6, number_format($allowance_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(20, 6, number_format($arrear_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(25, 6, number_format($stipend_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(30, 6, number_format($payable_sum) . '/-', 1, 1, 'R', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(100, 6, 'Gross Salary=Basic Salary+Bonuses+Attendance Adjustment', 0, 1, 'L', 0);
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(40, 6, 'Prepared By:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, 'Accounts:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, 'Director HR:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 1, 'L', 0);
            $this->fpdf->ln(15);
            $this->fpdf->Cell(40, 6, '', 0, 0, 'R', 0);
            $this->fpdf->Cell(30, 6, 'CEO: ', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, 'Chairman:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);

            $this->fpdf->SetY(-10);
            $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);
            $deptNo = 1;
            foreach ($result as $result1) {

                $this->fpdf->AddPage("L", ['280', '297']);
                $this->fpdf->SetFont('Times', 'B', 15);
                $this->fpdf->ln(5);
                $this->fpdf->Cell(30, 6, $result1->CompanyName, 0, 1, 'L', 0);
                $deptNo++;
                $this->fpdf->ln(1);
                $sr = 1;
                $this->fpdf->SetFont('Times', 'B', 10);
                $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
                $this->fpdf->Cell(50, 6, 'Department', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'Gross Salary', 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, 'Tax', 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, 'Loan', 1, 0, 'C', 0);
                $this->fpdf->Cell(18, 6, 'Advance', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'Deduction', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'Allowance', 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, 'Arrear', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'Stipend', 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, 'Net Payable', 1, 1, 'C', 0);
                $this->fpdf->SetFont('Times', '', 10);

                $department_list = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->select('Emp_Register.Department')->groupBy('Emp_Register.Department')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.Department')->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->get();
                $department_check = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->select('Emp_Register.Department')->groupBy('Emp_Register.Department')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->whereNotNull('Emp_Register.Department')->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->exists();
                if ($department_check) {
//                    $sum_emp_sal = [];
//                    $sum_emp_overtime = [];
                    $sum_emp_allowance = [];
                    $sum_emp_deduc = [];
                    $sum_emp_t = [];
                    $sum_emp_tax = [];
                    $sum_emp_loan = [];
                    $sum_emp_stipend = [];
                    $sum_emp_arrear = [];
                    $sum_emp_payable = [];
                    $sum_emp_advance = [];

                    $row = 0;
                    foreach ($department_list as $department_list1) {

                        $stipend_sum1 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->sum('PayrollFinanceApproval.StipendAmount');
                        $deduc_sum1 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->sum('PayrollFinanceApproval.DAmount');
                        $allowance_sum1 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->sum('PayrollFinanceApproval.AllowanceAmount');
                        $t_sum1 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->sum('PayrollFinanceApproval.TAmount');
                        $tax_sum1 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->sum('PayrollFinanceApproval.TaxAmount');
                        $loan_sum1 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->sum('PayrollFinanceApproval.InstallmentAmount');
                        $advance_sum1 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->sum('PayrollFinanceApproval.AdvanceAmount');
                        $arears_sum1 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->sum('PayrollFinanceApproval.ArrearsAmount');
                        $payable_sum1 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->sum('PayrollFinanceApproval.PayableSalary');

                        array_push($sum_emp_deduc, $deduc_sum1);
                        array_push($sum_emp_allowance, $allowance_sum1);
                        array_push($sum_emp_t, $t_sum1);
                        array_push($sum_emp_tax, $tax_sum1);
                        array_push($sum_emp_loan, $loan_sum1);
                        array_push($sum_emp_stipend, $stipend_sum1);
                        array_push($sum_emp_arrear, $arears_sum1);
                        array_push($sum_emp_payable, $payable_sum1);
                        array_push($sum_emp_advance, $advance_sum1);
                        $fetch_dept_detail = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where('Emp_Register.Department', '=', $department_list1->Department)->where('Emp_Register.CompanyName', '=', $result1->CompanyName)->get([DB::raw('SUM(PayrollFinanceApproval.TAmount) AS grosssalary'), DB::raw('SUM(PayrollFinanceApproval.TaxAmount) AS tax'), DB::raw('SUM(PayrollFinanceApproval.InstallmentAmount) AS loan'), DB::raw('SUM(PayrollFinanceApproval.AdvanceAmount) AS advance'), DB::raw('SUM(DAmount) AS deduction'), DB::raw('SUM(PayrollFinanceApproval.AllowanceAmount) AS allowance'), DB::raw('SUM(PayrollFinanceApproval.ArrearsAmount) AS arrear'), DB::raw('SUM(PayrollFinanceApproval.StipendAmount) AS stipend'), DB::raw('SUM(PayrollFinanceApproval.PayableSalary) AS payable')]);
                        $arr_dept = Arr::flatten($fetch_dept_detail);
                        foreach ($arr_dept as $arr_dept1) {

                            $this->fpdf->SetFillColor(230, 240, 233);
                            if ($sr % 39 == 0) {
                                $this->fpdf->SetFont('Times', 'B', 12);
                                $this->fpdf->SetY(-10);
                                $page++;
                                $this->fpdf->Cell(280, 6, $page, 0, 1, 'C', 0);
                                $this->fpdf->SetFont('Times', 'B', 10);
                                $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
                                $this->fpdf->Cell(50, 6, 'Department', 1, 0, 'C', 0);
                                $this->fpdf->Cell(25, 6, 'Gross Salary', 1, 0, 'C', 0);
                                $this->fpdf->Cell(20, 6, 'Tax', 1, 0, 'C', 0);
                                $this->fpdf->Cell(20, 6, 'Loan', 1, 0, 'C', 0);
                                $this->fpdf->Cell(18, 6, 'Advance', 1, 0, 'C', 0);
                                $this->fpdf->Cell(25, 6, 'Deduction', 1, 0, 'C', 0);
                                $this->fpdf->Cell(25, 6, 'Allowance', 1, 0, 'C', 0);
                                $this->fpdf->Cell(20, 6, 'Arrear', 1, 0, 'C', 0);
                                $this->fpdf->Cell(25, 6, 'Stipend', 1, 0, 'C', 0);
                                $this->fpdf->Cell(30, 6, 'Net Payable', 1, 1, 'C', 0);
                                $this->fpdf->SetFont('Times', '', 10);
                                $this->fpdf->SetFont('Times', '', 10);
                            }
                            if ($row % 2 == 0) {
                                $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 0);
                                $this->fpdf->Cell(50, 6, Str::substr($department_list1->Department, 0, 40), 1, 0, 'L', 0);
                                $this->fpdf->Cell(25, 6, number_format($arr_dept1->grosssalary), 1, 0, 'R', 0);
                                $this->fpdf->Cell(20, 6, number_format($arr_dept1->tax), 1, 0, 'R', 0);

                                $this->fpdf->Cell(20, 6, number_format($arr_dept1->loan), 1, 0, 'R', 0);
                                $this->fpdf->Cell(18, 6, number_format($arr_dept1->advance), 1, 0, 'R', 0);
                                $this->fpdf->Cell(25, 6, '0', 1, 0, 'R', 0);
                                $this->fpdf->Cell(25, 6, number_format($arr_dept1->allowance), 1, 0, 'R', 0);
                                $this->fpdf->Cell(20, 6, number_format($arr_dept1->arrear), 1, 0, 'R', 0);
                                $this->fpdf->Cell(25, 6, number_format($arr_dept1->stipend), 1, 0, 'R', 0);
                                $this->fpdf->Cell(30, 6, number_format($arr_dept1->payable), 1, 1, 'R', 0);


                            } else {
                                $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 1);
                                $this->fpdf->Cell(50, 6, Str::substr($department_list1->Department, 0, 40), 1, 0, 'L', 1);
                                $this->fpdf->Cell(25, 6, number_format($arr_dept1->grosssalary), 1, 0, 'R', 1);
                                $this->fpdf->Cell(20, 6, number_format($arr_dept1->tax), 1, 0, 'R', 1);

                                $this->fpdf->Cell(20, 6, number_format($arr_dept1->loan), 1, 0, 'R', 1);
                                $this->fpdf->Cell(18, 6, number_format($arr_dept1->advance), 1, 0, 'R', 1);
                                $this->fpdf->Cell(25, 6, '0', 1, 0, 'R', 1);
                                $this->fpdf->Cell(25, 6, number_format($arr_dept1->allowance), 1, 0, 'R', 1);
                                $this->fpdf->Cell(20, 6, number_format($arr_dept1->arrear), 1, 0, 'R', 1);
                                $this->fpdf->Cell(25, 6, number_format($arr_dept1->stipend), 1, 0, 'R', 1);
                                $this->fpdf->Cell(30, 6, number_format($arr_dept1->payable), 1, 1, 'R', 1);
                            }
                        }
                        $row++;
                        $sr++;
                    }
                    $this->fpdf->SetFont('Times', 'B', 10);

                    $this->fpdf->Cell(59, 6, 'Grand Total: ', 1, 0, 'R', 0);
                    $this->fpdf->Cell(25, 6, number_format(array_sum($sum_emp_t)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(20, 6, number_format(array_sum($sum_emp_tax)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(20, 6, number_format(array_sum($sum_emp_loan)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(18, 6, number_format(array_sum($sum_emp_advance)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(25, 6, '0' . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(25, 6, number_format(array_sum($sum_emp_allowance)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(20, 6, number_format(array_sum($sum_emp_arrear)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(25, 6, number_format(array_sum($sum_emp_stipend)) . '/-', 1, 0, 'R', 0);
                    $this->fpdf->Cell(30, 6, number_format(array_sum($sum_emp_payable)) . '/-', 1, 1, 'R', 0);
                    $this->fpdf->SetFont('Times', '', 10);
                }
                $row++;
                $sr++;
                $page = $page + 1;

                $this->fpdf->ln(10);
                $this->fpdf->SetFont('Times', 'B', 12);
                $this->fpdf->SetY(-10);
                $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);
            }

            $this->fpdf->Output();
            exit;
        }
    }

    //4
    public function employee_stipend_report()
    {

        $page = 1;
        $row = 0;
        $space = 0;
        $result = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->select('Emp_Register.Department')->groupBy('Emp_Register.Department')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('PayrollFinanceApproval.StipendAmount', '!=', 0)->where('Emp_Register.Department', '!=', " ")->get();
        //  return request()->json(200, $result);
        $this->fpdf->AddPage("L", ['280', '297']);
        $this->fpdf->SetFont('Times', 'B', 22);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }
        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->get();
        foreach ($find_session_closed as $find_session1) {
        }

        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 15, 12, 40, 12);
        $this->fpdf->SetFont('Arial', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/sasystems.png', 249, 2, 34, 35);
        $this->fpdf->ln(0);

        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->MultiCell(260, 10, 'Employee Stipend Report' . "\n Salary month: " . Carbon::parse($find_session1->EndDate)->format('F Y'), 0, 'C', false);

        // table 2
        $sr = 1;

        foreach ($result as $result1) {
            $space = $space + 3;
            if ($space > (37 * $page)) {
                $space = $space + 3;
                $this->fpdf->SetY(-10);
                $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);
                $this->fpdf->AddPage("L", ['280', '297']);

                $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 15, 12, 40, 12);
                $this->fpdf->SetFont('Arial', '', 14);
                $this->fpdf->SetTextColor(41, 46, 46);
                $this->fpdf->Image('public/images/logo/sasystems.png', 249, 2, 34, 35);
                $this->fpdf->ln(0);

                $this->fpdf->SetFont('Times', 'B', 18);
                $this->fpdf->MultiCell(260, 10, 'Employee Stipend Report' . "\n Salary month: " . Carbon::parse($find_session1->EndDate)->format('F Y'), 0, 'C', false);
                $page++;
            }
            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->Cell(265, 5, $result1->Department, 0, 1, 'C', 0);
            $this->fpdf->SetFont('Times', 'B', 10);
            $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Emp. Code', 1, 0, 'C', 0);
            $this->fpdf->Cell(65, 6, 'Employee Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(45, 6, 'Designation', 1, 0, 'C', 0);
            $this->fpdf->Cell(22, 6, 'Joining Date', 1, 0, 'C', 0);
            $this->fpdf->Cell(18, 6, 'Stipend', 1, 0, 'C', 0);
            $this->fpdf->Cell(31, 6, 'Allowance/Bonus', 1, 0, 'C', 0);
            $this->fpdf->Cell(17, 6, 'Loan', 1, 0, 'C', 0);
            $this->fpdf->Cell(15, 6, 'Advance', 1, 0, 'C', 0);
            $this->fpdf->Cell(24, 6, ' Net Payable', 1, 1, 'C', 0);

            $this->fpdf->SetFont('Times', '', 10);
            $fetch_detail = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->join('Emp_Profile', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.StipendAmount', '!=', 0)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->select('Emp_Register.Department', 'Emp_Register.Designation', 'PayrollFinanceApproval.*', 'Emp_Register.JoiningDate', 'Emp_Register.EmployeeCode', 'Emp_Profile.Name')->get();


            $salary_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.Salary');
            $overtime_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.OAmount');
            $allowance_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.AllowanceAmount');
            $bonus_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.BonusAmount');
            $tax_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.TaxAmount');
            $loan_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.InstallmentAmount');
            $advance_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.AdvanceAmount');
            $absentee_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.DAmount');
            $ded_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.ArrearsAmount');
            $payable_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.PayableSalary');
            $stipend_sum = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->where('Emp_Register.Department', '=', $result1->Department)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->sum('PayrollFinanceApproval.StipendAmount');


            foreach ($fetch_detail as $get_req1) {
                $this->fpdf->SetFillColor(230, 240, 233);

                if ($row % 2 == 0) {
                    $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 0);
                    $this->fpdf->Cell(20, 6, $get_req1->EmployeeCode, 1, 0, 'C', 0);
                    $this->fpdf->Cell(65, 6, Str::substr($get_req1->Name, 0, 30), 1, 0, 'L', 0);
                    $this->fpdf->Cell(45, 6, substr($get_req1->Designation, 0, 18), 1, 0, 'C', 0);
                    $this->fpdf->Cell(22, 6, $get_req1->JoiningDate, 1, 0, 'C', 0);
                    $this->fpdf->Cell(18, 6, $get_req1->StipendAmount, 1, 0, 'R', 0);
                    $this->fpdf->Cell(31, 6, number_format($get_req1->AllowanceAmount + $get_req1->BonusAmount), 1, 0, 'R', 0);
                    $this->fpdf->Cell(17, 6, number_format($get_req1->InstallmentAmount), 1, 0, 'R', 0);
                    $this->fpdf->Cell(15, 6, number_format($get_req1->AdvanceAmount), 1, 0, 'R', 0);
                    $this->fpdf->Cell(24, 6, number_format($get_req1->PayableSalary), 1, 1, 'R', 0);
                } else {
                    $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 1);
                    $this->fpdf->Cell(20, 6, $get_req1->EmployeeCode, 1, 0, 'R', 1);
                    $this->fpdf->Cell(65, 6, Str::substr($get_req1->Name, 0, 30), 1, 0, 'L', 1);
                    $this->fpdf->Cell(45, 6, substr($get_req1->Designation, 0, 18), 1, 0, 'C', 1);
                    $this->fpdf->Cell(22, 6, $get_req1->JoiningDate, 1, 0, 'C', 1);
                    $this->fpdf->Cell(18, 6, $get_req1->StipendAmount, 1, 0, 'R', 1);
                    $this->fpdf->Cell(31, 6, number_format($get_req1->AllowanceAmount + $get_req1->BonusAmount), 1, 0, 'R', 1);
                    $this->fpdf->Cell(17, 6, number_format($get_req1->InstallmentAmount), 1, 0, 'R', 1);
                    $this->fpdf->Cell(15, 6, number_format($get_req1->AdvanceAmount), 1, 0, 'R', 1);
                    $this->fpdf->Cell(24, 6, number_format($get_req1->PayableSalary), 1, 1, 'R', 1);
                }
                $row++;
                $sr++;
                $space++;
            }
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Cell(161, 6, 'Total:  ', 1, 0, 'C', 0);
            $this->fpdf->Cell(18, 6, number_format($stipend_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(31, 6, number_format($allowance_sum + $bonus_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(17, 6, number_format($loan_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(15, 6, number_format($advance_sum) . '/-', 1, 0, 'R', 0);
            $this->fpdf->Cell(24, 6, number_format($payable_sum) . '/-', 1, 1, 'R', 0);
            $this->fpdf->ln(8);
            $space++;
            //

            $sr = 1;
        }
        $this->fpdf->ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(40, 6, 'Prepared By:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Accounts:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Director HR:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 1, 'L', 0);
        $this->fpdf->ln(15);
        $this->fpdf->Cell(40, 6, '', 0, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, 'CEO: ', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Chairman:', 0, 0, 'R', 0);
        $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);

        $this->fpdf->SetY(-10);
        $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);
        $this->fpdf->Output();
        exit;

    }

    //5
    public function employee_stipend()
    {

        $page = 1;
        $sr = 1;
        $row = 0;
        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->get();
        foreach ($find_session_closed as $find_session1) {
        }
        $check = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->orderby('Emp_Register.EmployeeID', 'asc')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where("PayrollFinanceApproval.StipendAmount", '>', 0)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->exists();
        if ($check) {

            $result = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->orderby('Emp_Register.EmployeeID', 'asc')->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where("PayrollFinanceApproval.StipendAmount", '>', 0)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->get();
            $emp_um = DB::connection('sqlsrv2')->table("PayrollFinanceApproval")->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->orderby('Emp_Register.EmployeeID', 'asc')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('PayrollFinanceApproval.SessionName', '=', $find_session1->SessionName)->where("PayrollFinanceApproval.StipendAmount", '>', 0)->sum("PayrollFinanceApproval.StipendAmount");

            $this->fpdf->AddPage("L", ['280', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 15, 12, 40, 12);
            $this->fpdf->SetFont('Arial', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/sasystems.png', 250, 2, 34, 35);
            $this->fpdf->ln(0);
            // table 2

            $this->fpdf->SetFont('Times', 'B', 18);
            $this->fpdf->MultiCell(260, 10, 'All Employee Stipend Report' . "\n" . Carbon::parse($find_session1->EndDate)->format('F Y'), 0, 'C', false);

            $this->fpdf->SetFont('Times', 'B', 10);
            $this->fpdf->Cell(9, 6, 'Sr.', 1, 0, 'C', 0);
            $this->fpdf->Cell(35, 6, 'Employee Code', 1, 0, 'C', 0);
            $this->fpdf->Cell(70, 6, 'Company Name', 1, 0, 'C', 0);
            $this->fpdf->Cell(70, 6, 'Department', 1, 0, 'C', 0);
            $this->fpdf->Cell(50, 6, 'Stipend Amount', 1, 1, 'C', 0);

            $this->fpdf->SetFont('Times', '', 10);

            // $find_salary_sum;
            foreach ($result as $result1) {

                $this->fpdf->SetFillColor(237, 240, 238);
                if ($row % 2 == 0) {
                    $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 0);
                    $this->fpdf->Cell(35, 6, $result1->EmployeeCode, 1, 0, 'R', 0);
                    $this->fpdf->Cell(70, 6, Str::substr($result1->CompanyName, 0, 55), 1, 0, 'L', 0);


                    $this->fpdf->Cell(70, 6, Str::substr($result1->Department, 0, 55), 1, 0, 'L', 0);
                    $this->fpdf->Cell(50, 6, number_format($result1->StipendAmount), 1, 1, 'R', 0);
                } else {
                    $this->fpdf->Cell(9, 6, $sr, 1, 0, 'C', 0);

                    $this->fpdf->Cell(35, 6, $result1->EmployeeCode, 1, 0, 'R', 1);
                    $this->fpdf->Cell(70, 6, Str::substr($result1->CompanyName, 0, 55), 1, 0, 'L', 1);


                    $this->fpdf->Cell(70, 6, Str::substr($result1->Department, 0, 55), 1, 0, 'L', 1);
                    $this->fpdf->Cell(50, 6, number_format($result1->StipendAmount), 1, 1, 'R', 1);

                }
                $row++;
                $sr++;
            }


            $this->fpdf->SetFont('Times', 'B', 10);
            $this->fpdf->Cell(184, 6, 'Grand Total: ', 1, 0, 'R', 0);
            $this->fpdf->Cell(50, 6, number_format($emp_um) . '/-', 1, 0, 'R', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(40, 6, 'Prepared By:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, 'Accounts:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, 'Director HR:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 1, 'L', 0);
            $this->fpdf->ln(15);
            $this->fpdf->Cell(40, 6, '', 0, 0, 'R', 0);
            $this->fpdf->Cell(30, 6, 'CEO: ', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, 'Chairman:', 0, 0, 'R', 0);
            $this->fpdf->Cell(45, 6, '___________________', 0, 0, 'L', 0);

            $this->fpdf->SetY(-10);
            $this->fpdf->Cell(280, 6, $page, 0, 0, 'C', 0);

            $this->fpdf->Output();
            exit;
        }
    }

    //Print
    public function settlement_slip($id)
    {

        $update_date = date("Y-m-d h:i:s A");
        $username = Session::get('username');

        $this->fpdf->AddPage("P", ['210', '297']);

        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }
        $check_security = DB::connection('sqlsrv2')->table('FinalSettlement')->where('CompanyID', '=', company_id())->where('ID', '=', $id)->exists();
        if ($check_security) {
            $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->get();
            foreach ($find_session_closed as $find_session1) {
            }
            $sesson_name = $find_session1->SessionName;
            $emp_loan_dtl = DB::connection('sqlsrv2')->table('FinalSettlement')->join('Emp_Profile', 'FinalSettlement.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('Emp_Profile.CNIC', 'Emp_Profile.DOB', 'Emp_Register.*', 'Emp_Profile.Address', 'Emp_Profile.Mobile', 'Emp_Profile.Photo', 'Emp_Profile.Name', 'FinalSettlement.*')->where('FinalSettlement.CompanyID', '=', company_id())->where('FinalSettlement.ID', '=', $id)->get();
            foreach ($emp_loan_dtl as $test1) {

            }

            $pdf = explode(".pdf", $test1->Photo);
            $jfif = explode(".jfif", $test1->Photo);
            if (strpos($test1->Photo, ".pdf") === false && strpos($test1->Photo, ".jfif") === false) {
                $this->fpdf->Image('public/images/profile_images/' . $test1->Photo,10,6,31,30);
            } else {
                $this->fpdf->Image('public/images/profile_images/pro.png',10,6,31,30);
            }

            $this->fpdf->Image('public/images/' . $fetch_company_detail1->company_logo, 170, 6, 30);
            $this->fpdf->SetFont('Arial', 'B', 20);
            $this->fpdf->Text(80, 14, $fetch_company_detail1->company_name);
            $this->fpdf->SetFont('Arial', '', 14);
            $this->fpdf->Text(60, 20, $fetch_company_detail1->company_address);
            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->Text(85, 35, "Final Settlement");
            $this->fpdf->SetFont('Arial', '', 16);
            $this->fpdf->Text(15, 42, "Employee Copy");
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Ln(40);
            $this->fpdf->Cell(105, 0, "Settlement Month: " . $test1->SessionName, 0, 0, 'L');
            $this->fpdf->Cell(80, 0, "Received Time: " . $update_date, 0, 1, 'R');
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell(25, 0, "Employee Code", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->EmployeeCode, 0, 0, 'R');
            $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Basic Salary", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->Salary) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Employee Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Name, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Stipend", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->Stipend) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Department Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Department, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Gratuity", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->Gratuity) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Designation", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Designation, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Arears & Bonus", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->ArrearsAmount + $test1->BonusAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Date Of Joining", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JoiningDate, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Settlement", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->SettlementAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Job Status", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JobStatus, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Allowance", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->AllowanceAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Posting City", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->PostingCity, 0, 0, 'R');
            $this->fpdf->SetFont('Arial', 'B', 10);
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Gross Total", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, "Rs. " . number_format($test1->PayableSalary) . "/-", 0, 1, 'R');
            $this->fpdf->SetFont('Arial', '', 10);

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "CNIC No.", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->CNIC, 0, 0, 'R');
            $this->fpdf->SetFont('Arial', 'B', 10);
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(70, 0, "Deductions", 0, 0, 'C');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Phone No.", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Mobile, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Loan & Advance", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->LoanAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Date of Birth", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->DOB, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Fine", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->Fine) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Prepared By", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, "HR Department", 0, 0, 'R');
            $this->fpdf->SetFont('Arial', 'B', 10);
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Total Payable", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, "Rs. " . number_format($test1->PayableSalary) . "/-", 0, 1, 'R');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Payment Method", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->MethodType, 0, 0, 'R');

            $this->fpdf->Ln(5);

            $this->fpdf->Line(128, 58, 128, 117);
            $this->fpdf->Ln(7);
            //
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $username)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            //
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Cell(20, 5, "Printed By: ", 0, 0, 'L');
            $this->fpdf->Cell(80, 5, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L');
            $this->fpdf->Cell(20, 5, '', 0, 0, 'L');
            $this->fpdf->Cell(70, 5, "Received By: ____________________", 0, 1, 'L');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Ln(8);
            $this->fpdf->Cell(170, 0, "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -", 0, 1, 'L');
            if (strpos($test1->Photo, ".pdf") === false && strpos($test1->Photo, ".jfif") === false) {
                $this->fpdf->Image('public/images/profile_images/' . $test1->Photo,10,160,35,30);
            } else {
                $this->fpdf->Image('public/images/profile_images/pro.png',10,160,35,30);
            }
            $this->fpdf->Image('public/images/' . $fetch_company_detail1->company_logo, 170, 150, 30);
            $this->fpdf->SetFont('Arial', 'B', 20);
            $this->fpdf->Text(80, 153, $fetch_company_detail1->company_name);
            $this->fpdf->SetFont('Arial', '', 14);
            $this->fpdf->Text(60, 159, $fetch_company_detail1->company_address);
            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->Text(90, 172, "Final Settlement");
            $this->fpdf->SetFont('Arial', '', 16);
            $this->fpdf->Text(15, 183, "Accounts Copy");
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Ln(50);
            $this->fpdf->Cell(105, 0, "Settlement Month: " . $test1->SessionName, 0, 0, 'L');
            $this->fpdf->Cell(80, 0, "Received Time: " . $update_date, 0, 1, 'R');
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell(25, 0, "Employee Code", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->EmployeeCode, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Basic Salary", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->Salary) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Employee Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Name, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Stipend", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->Stipend) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Department Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Department, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Gratuity", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->Gratuity) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Designation", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Designation, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Arears & Bonus", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->ArrearsAmount + $test1->BonusAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Date Of Joining", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JoiningDate, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Settlement", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->SettlementAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Job Status", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JobStatus, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Allowance", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->AllowanceAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Posting City", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->PostingCity, 0, 0, 'R');
            $this->fpdf->SetFont('Arial', 'B', 10);
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Gross Total", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, "Rs. " . number_format($test1->PayableSalary) . "/-", 0, 1, 'R');
            $this->fpdf->SetFont('Arial', '', 10);

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "CNIC No.", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->CNIC, 0, 0, 'R');
            $this->fpdf->SetFont('Arial', 'B', 10);
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(70, 0, "Deductions", 0, 0, 'C');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Phone No.", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Mobile, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Loan & Advance", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->LoanAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Date of Birth", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->DOB, 0, 0, 'R');
             $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Fine", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, number_format($test1->Fine) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Prepared By", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, "HR Department", 0, 0, 'R');
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Cell(8, 0, '', 0, 0, 'L');
            $this->fpdf->Cell(20, 0, "Total Payable", 0, 0, 'L');
            $this->fpdf->Cell(50, 0, "Rs. " . number_format($test1->PayableSalary) . "/-", 0, 1, 'R');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Payment Method", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->MethodType, 0, 0, 'R');

            $this->fpdf->Ln(5);

            $this->fpdf->Line(128, 200, 128, 259);
            $this->fpdf->Ln(7);
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Cell(20, 5, "Printed By: ", 0, 0, 'L');
            $this->fpdf->Cell(80, 5, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L');
            $this->fpdf->Cell(20, 5, '', 0, 0, 'L');
            $this->fpdf->Cell(70, 5, "Received By: ____________________", 0, 1, 'L');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Ln(5);
            $this->fpdf->Output();
            exit;
        } else {
            echo "not exists";
        }
    }

    /*
    public function settlement_slip($id){

        $update_date=date("Y-m-d h:i:s A");
        $this->fpdf->AddPage("P", ['210', '297']);
        $fetch_company_detail=DB::table('tb_create_company')->where('company_id','=',company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }
        $check_security =DB::connection('sqlsrv2')->table('FinalSettlement')->where('CompanyID','=',company_id())->where('ID','=',$id)->exists();
        if($check_security){
            $find_session_closed =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=',company_id())->where('AttClosedPayrollStart','=','Closed')->get();
            foreach ($find_session_closed as $find_session1) {
            }
            $sesson_name=$find_session1->SessionName;
            $emp_loan_dtl = DB::connection('sqlsrv2')->table('FinalSettlement')->join('Emp_Profile', 'FinalSettlement.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('Emp_Profile.CNIC', 'Emp_Profile.DOB', 'Emp_Register.*', 'Emp_Profile.Address','Emp_Profile.Mobile','Emp_Profile.Photo','Emp_Profile.Name','FinalSettlement.*')->where('FinalSettlement.CompanyID','=',company_id())->where('FinalSettlement.ID','=',$id)->get();
            foreach ($emp_loan_dtl as $test1) {

            }
            $this->fpdf->Image('public/images/profile_images/'.$test1->Photo,10,6,31,30);
            $this->fpdf->Image('public/images/'.$fetch_company_detail1->company_logo,170,6,30);
            $this->fpdf->SetFont('Arial','B',20);
            $this->fpdf->Text(80, 14, $fetch_company_detail1->company_name);
            $this->fpdf->SetFont('Arial','',14);
            $this->fpdf->Text(60, 20, $fetch_company_detail1->company_address);
            $this->fpdf->SetFont('Arial','B',14);
            $this->fpdf->Text(85, 35, "Final Settlement");
            $this->fpdf->SetFont('Arial','',16);
            $this->fpdf->Text(15, 42, "Employee Copy");
            $this->fpdf->SetFont('Arial','B',10);
            $this->fpdf->Ln(40);
            $this->fpdf->Cell(105,0,"Settlement Month: ".$test1->SessionName,0,0,'L');
            $this->fpdf->Cell(85,0,"Received Date: ".$update_date,0,1,'R');
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial','',10);
            $this->fpdf->Cell(25,0,"Employee Code",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->EmployeeCode,0,0,'R');
            $this->fpdf->Cell(30,0,"Basic Salary",0,0,'R');
            $this->fpdf->Cell(50,0,"Rs. ".number_format($test1->Salary)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Employee Name",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->Name,0,0,'R');
            $this->fpdf->Cell(30,0,"Stipend",0,0,'C');
            $this->fpdf->Cell(50,0,"Rs. ".number_format($test1->Stipend)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Department Name",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->Department,0,0,'R');
            $this->fpdf->Cell(29,0,"Gratuity",0,0,'C');
            $this->fpdf->Cell(51,0,"Rs. ".number_format($test1->Gratuity)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Designation",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->Designation,0,0,'R');
            $this->fpdf->Cell(33,0,"Arears & Bonus",0,0,'R');
            $this->fpdf->Cell(47,0,"Rs. ".number_format($test1->ArrearsAmount+$test1->BonusAmount)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Date Of Joining",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->JoiningDate,0,0,'R');
            $this->fpdf->Cell(29,0,"Settlement",0,0,'C');
            $this->fpdf->Cell(51,0,"Rs. ".number_format($test1->SettlementAmount)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Job Status",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->JobStatus,0,0,'R');
            $this->fpdf->Cell(26,0,"Allowance",0,0,'R');
            $this->fpdf->Cell(54,0,"Rs. ".number_format($test1->AllowanceAmount)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Posting City",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->PostingCity,0,0,'R');
            $this->fpdf->SetFont('Arial','B',10);
            $this->fpdf->Cell(18,0,"Total",0,0,'R');
            $this->fpdf->Cell(62,0,"Rs. ".number_format($test1->TAmount+$test1->SettlementAmount)."/-",0,1,'R');
            $this->fpdf->SetFont('Arial','',10);

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"CNIC No.",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->CNIC,0,0,'R');
            $this->fpdf->SetFont('Arial','B',10);
            $this->fpdf->Cell(47,5,"Deduction & Loan",0,0,'C');
            $this->fpdf->SetFont('Arial','',10);
            $this->fpdf->Cell(1,0,"",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Phone No.",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->Mobile,0,0,'R');
            $this->fpdf->Cell(35,3,"Loan & Advance",0,0,'R');
            $this->fpdf->Cell(45,0,"Rs. ".number_format($test1->LoanAmount)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Date of Birth",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->DOB,0,0,'R');
            $this->fpdf->Cell(17,0,"Fine",0,0,'R');
            $this->fpdf->Cell(63,0,"Rs. ".number_format($test1->Fine)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Prepared By",0,0,'L');
            $this->fpdf->Cell(85,0,"HR Department",0,0,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Payment Method",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->MethodType,0,0,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"",0,0,'L');
            $this->fpdf->Cell(85,0,"",0,0,'R');
            $this->fpdf->SetFont('Arial','B',10);
            $this->fpdf->Cell(17,0,"Total",0,0,'R');
            $this->fpdf->Cell(63,0,"Rs. ".number_format($test1->PayableSalary)."/-",0,1,'R');

            $this->fpdf->SetFont('Arial','',10);
            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('Arial','B',11);
            $this->fpdf->Cell(90,0,"NET PAYABLE : ".number_format($test1->PayableSalary)."/- ",0,0,'L');
            $this->fpdf->Cell(40,0,"Cash : ".number_format($test1->PayableSalary)."/- ",0,0,'L');
            $this->fpdf->SetFont('Arial','',10);
            $this->fpdf->Line(128, 70, 128, 120);
            $this->fpdf->Ln(7);
            $this->fpdf->Cell(150,5,"-----------------------",0,0,'L');
            $this->fpdf->Cell(90,5,"-----------------------",0,1,'L');
            $this->fpdf->Cell(155,5,"Prepared By",0,0,'L');
            $this->fpdf->Cell(90,5,"Received By",0,1,'L');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(170,0,"- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -",0,1,'L');
            $this->fpdf->Image('public/images/profile_images/'.$test1->Photo,10,160,35,30);
            $this->fpdf->Image('public/images/'.$fetch_company_detail1->company_logo,170,160,30);
            $this->fpdf->SetFont('Arial','B',20);
            $this->fpdf->Text(80, 160, $fetch_company_detail1->company_name);
            $this->fpdf->SetFont('Arial','',14);
            $this->fpdf->Text(60, 166, $fetch_company_detail1->company_address);
            $this->fpdf->SetFont('Arial','B',14);
            $this->fpdf->Text(90, 179, "Final Settlement");
            $this->fpdf->SetFont('Arial','',16);
            $this->fpdf->Text(15, 196, "Accounts Copy");
            $this->fpdf->SetFont('Arial','B',10);
            $this->fpdf->Ln(55);
            $this->fpdf->Cell(105,0,"Settlement Month: ".$test1->SessionName,0,0,'L');
            $this->fpdf->Cell(85,0,"Received Date: ".$update_date,0,1,'R');
            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial','',10);
            $this->fpdf->Cell(25,0,"Employee Code",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->EmployeeCode,0,0,'R');
            $this->fpdf->Cell(30,0,"Basic Salary",0,0,'R');
            $this->fpdf->Cell(50,0,"Rs. ".number_format($test1->Salary)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Employee Name",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->Name,0,0,'R');
            $this->fpdf->Cell(30,0,"Stipend",0,0,'C');
            $this->fpdf->Cell(50,0,"Rs. ".number_format($test1->Stipend)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Department Name",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->Department,0,0,'R');
            $this->fpdf->Cell(29,0,"Gratuity",0,0,'C');
            $this->fpdf->Cell(51,0,"Rs. ".number_format($test1->Gratuity)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Designation",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->Designation,0,0,'R');
            $this->fpdf->Cell(33,0,"Arears & Bonus",0,0,'R');
            $this->fpdf->Cell(47,0,"Rs. ".number_format($test1->ArrearsAmount+$test1->BonusAmount)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Date Of Joining",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->JoiningDate,0,0,'R');
            $this->fpdf->Cell(29,0,"Settlement",0,0,'C');
            $this->fpdf->Cell(51,0,"Rs. ".number_format($test1->SettlementAmount)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Job Status",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->JobStatus,0,0,'R');
            $this->fpdf->Cell(26,0,"Allowance",0,0,'R');
            $this->fpdf->Cell(54,0,"Rs. ".number_format($test1->AllowanceAmount)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Posting City",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->PostingCity,0,0,'R');
            $this->fpdf->SetFont('Arial','B',10);
            $this->fpdf->Cell(18,0,"Total",0,0,'R');
            $this->fpdf->Cell(62,0,"Rs. ".number_format($test1->TAmount+$test1->SettlementAmount)."/-",0,1,'R');
            $this->fpdf->SetFont('Arial','',10);

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"CNIC No.",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->CNIC,0,0,'R');
            $this->fpdf->SetFont('Arial','B',10);
            $this->fpdf->Cell(47,5,"Deduction & Loan",0,0,'C');
            $this->fpdf->SetFont('Arial','',10);
            $this->fpdf->Cell(1,0,"",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Phone No.",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->Mobile,0,0,'R');
            $this->fpdf->Cell(35,3,"Loan & Advance",0,0,'R');
            $this->fpdf->Cell(45,0,"Rs. ".number_format($test1->LoanAmount)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Date of Birth",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->DOB,0,0,'R');
            $this->fpdf->Cell(17,0,"Fine",0,0,'R');
            $this->fpdf->Cell(63,0,"Rs. ".number_format($test1->Fine)."/-",0,1,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Prepared By",0,0,'L');
            $this->fpdf->Cell(85,0,"HR Department",0,0,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"Payment Method",0,0,'L');
            $this->fpdf->Cell(85,0,$test1->MethodType,0,0,'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25,0,"",0,0,'L');
            $this->fpdf->Cell(85,0,"",0,0,'R');
            $this->fpdf->SetFont('Arial','B',10);
            $this->fpdf->Cell(17,0,"Total",0,0,'R');
            $this->fpdf->Cell(63,0,"Rs. ".number_format($test1->PayableSalary)."/-",0,1,'R');

            $this->fpdf->SetFont('Arial','',10);
            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('Arial','B',11);
            $this->fpdf->Cell(90,0,"NET PAYABLE : ".number_format($test1->PayableSalary)."/- ",0,0,'L');
            $this->fpdf->Cell(40,0,"Cash : ".number_format($test1->PayableSalary)."/- ",0,0,'L');
            $this->fpdf->SetFont('Arial','',10);
            $this->fpdf->Line(128, 70, 128, 120);
            $this->fpdf->Ln(7);
            $this->fpdf->Cell(150,5,"-----------------------",0,0,'L');
            $this->fpdf->Cell(90,5,"-----------------------",0,1,'L');
            $this->fpdf->Cell(155,5,"Prepared By",0,0,'L');
            $this->fpdf->Cell(90,5,"Received By",0,1,'L');
            $this->fpdf->Ln(5);
            $this->fpdf->Output();
            exit;
        }
        else {
            echo "not exists";
        }
    } */
    public function Cancelled_receipt_bill($id)
    {

        $check_security = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('ID', '=', $id)->where('PaidAmount', '!=', 0)->exists();
        if ($check_security) {
            $users = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('ID', '=', $id)->where('PaidAmount', '!=', 0)->get();
            foreach ($users as $users57) {
            }
            $this->fpdf = new Fpdf;
            $this->fpdf->AddPage("L", ['280', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 140, 15, 35, 17);
            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(105, 6, '', 0, 0, 'R', 0);
            $this->fpdf->SetTextColor(250, 248, 248);
            $this->fpdf->Cell(85, 12, 'CANCELLATION PAYMENT VOUCHER', 0, 1, 'C', 1);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(40, 6, 'Name: ' . $users57->Name, 0, 0, 'L', 0);
            $this->fpdf->Cell(160, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Payment Voucher', 0, 1, 'R', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(40, 6, 'File Plot No: ' . $users57->File_Plot_Number, 0, 0, 'L', 0);
            $this->fpdf->Cell(170, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Method Type: ' . $users57->AccountID, 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, 'Contact: ' . $users57->Contact, 0, 0, 'L', 0);
            $this->fpdf->Cell(162, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'PV ID: ' . $users57->PVID, 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, 'Block: ' . $users57->Block, 0, 1, 'L', 0);
            $this->fpdf->Cell(40, 6, 'Plot Type: ' . $users57->Plot_Type, 0, 1, 'L', 0);
            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(220, 6, 'Description', 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 6, 'Paid', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(220, 15, ('Cancellation Receipt Bill of  ' . $users57->Name . ' use of Amount ' . number_format($users57->PaidAmount) . ' in Total Amount: ' . number_format($users57->RemainingAmount)), 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 15, number_format($users57->PaidAmount), 1, 1, 'C', 0);
            $this->fpdf->Cell(220, 6, 'Remaining Amount:', 0, 0, 'R', 0);
            $this->fpdf->Cell(40, 6, number_format($users57->RemainingAmount), 0, 1, 'C', 0);
            $this->fpdf->Output();
            exit;
        }
    }

    public function unit_repurchased_amount_letter($id)
    {

        $this->fpdf->AddPage("P", ['210', '297']);
        $this->fpdf->SetFont('Times', 'B', 22);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }

        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 85, 10, 35, 17);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->Text(60, 35, 'Request for Payment Voucher');
        $this->fpdf->SetFont('Times', 'B', 14);
        $this->fpdf->Text(90, 40, 'Repurchased');
        $arr = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('ID', '=', $id)->get();
        foreach ($arr as $arr1) {

        }

        $arr9 = DB::connection('sqlsrv3')->table('Ledger_Entries')->where('VendorID7', '=', $id)->where('EntryType', '=', 'D')->get();
        $arr8 = DB::connection('sqlsrv3')->table('Ledger_Entries')->where('VendorID7', '=', $id)->where('EntryType', '=', 'C')->get();


        $date = explode(" ", $arr1->DateTime);
        $this->fpdf->SetFont('Times', 'B', 14);
        $this->fpdf->Cell(105, 6, '', 0, 0, 'R', 0);
        $this->fpdf->SetTextColor(41, 46, 46);

        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->ln(45);


        $this->fpdf->Cell(33, 6, 'Account ID', 0, 0, 'L', 0);
        $this->fpdf->Cell(45, 6, 'GL Name', 0, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Debit', 0, 0, 'C', 0);
        $this->fpdf->Cell(30, 6, 'Credit', 0, 0, 'C', 0);
        $this->fpdf->Cell(50, 6, 'Description', 0, 1, 'C', 0);
        $this->fpdf->SetFont('Times', '', 10);

        foreach ($arr9 as $arr91) {
            $this->fpdf->Cell(33, 10, $arr91->AccountID, 0, 0, 'L', 0);
            $find_acc_name = DB::connection('sqlsrv3')->table('Accounts')->where('ID', '=', $arr91->AccountID)->get();
            foreach ($find_acc_name as $find_acc_name1) {

            }

            $this->fpdf->Cell(45, 10, substr($find_acc_name1->AccountName, 0, 35), 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, $arr91->Amount, 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, '-', 0, 0, 'C', 0);
            $this->fpdf->MultiCell(50, 6, 'Against Repurchased of Plot No:' . $arr1->File_Plot_Number . ' Block:' . $arr1->Block . ' file', 0, 'L', false);
        }
        foreach ($arr8 as $arr81) {
            $this->fpdf->Cell(33, 10, $arr81->AccountID, 0, 0, 'L', 0);
            $find_acc_name = DB::connection('sqlsrv3')->table('Accounts')->where('ID', '=', $arr81->AccountID)->get();
            foreach ($find_acc_name as $find_acc_name1) {

            }

            $this->fpdf->Cell(45, 10, substr($find_acc_name1->AccountName, 0, 35), 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, '-', 0, 0, 'C', 0);
            $this->fpdf->Cell(30, 10, $arr81->Amount, 0, 0, 'C', 0);

            $this->fpdf->MultiCell(50, 6, 'Against Repurchased of Plot No:' . $arr1->File_Plot_Number . ' Block:' . $arr1->Block . ' file', 0, 'L', false);
        }


        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(75, 10, 'Total Amount', 0, 0, 'L', 0);
        $this->fpdf->Cell(30, 10, $arr91->Amount, 0, 0, 'C', 0);
        $this->fpdf->Cell(30, 10, $arr91->Amount, 0, 1, 'C', 0);

        $this->fpdf->MultiCell(160, 6, 'Amounts In Words: ' . $this->numberToWord($arr91->Amount) . ' Rupees Only', 0, 'L', false);

        $this->fpdf->ln(15);
        $this->fpdf->SetFont('Times', 'B', 12);

        $this->fpdf->Cell(60, 6, 'Supervised By:', 0, 1, 'C', 0);


        $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $arr1->UpdatedBy)->get();
        foreach ($fetch_user_detail as $fetch_user_detail1) {

        }


//$this->fpdf->Cell(60,6,$fetch_paid_detail1->Name,0,0,'L',0);
        $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 1, 'C', 0);


        $this->fpdf->Output();
        exit;
    }

    public function Amount_refund_receipt_bill($id)
    {

        $check_security = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('ID', '=', $id)->where('PaidAmount', '!=', 0)->exists();
        if ($check_security) {
            $users = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('ID', '=', $id)->where('PaidAmount', '!=', 0)->get();
            foreach ($users as $users57) {
            }

            $this->fpdf = new Fpdf;
            $this->fpdf->AddPage("L", ['280', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 140, 15, 35, 17);
            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(105, 6, '', 0, 0, 'R', 0);
            $this->fpdf->SetTextColor(250, 248, 248);
            $this->fpdf->Cell(85, 12, 'AMOUNT REFUND PAYMENT VOUCHER', 0, 1, 'C', 1);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(40, 6, 'Name: ' . $users57->Name, 0, 0, 'L', 0);
            $this->fpdf->Cell(160, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Payment Voucher', 0, 1, 'R', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(40, 6, 'File Plot No: ' . $users57->File_Plot_Number, 0, 0, 'L', 0);
            $this->fpdf->Cell(170, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Method Type: ' . $users57->AccountID, 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, 'Contact: ' . $users57->Contact, 0, 0, 'L', 0);
            $this->fpdf->Cell(162, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'PV ID: ' . $users57->PVID, 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, 'Block: ' . $users57->Block, 0, 1, 'L', 0);
            $this->fpdf->Cell(40, 6, 'Plot Type: ' . $users57->Plot_Type, 0, 1, 'L', 0);

            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(220, 6, 'Description', 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 6, 'Paid', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(220, 15, ('Amount Refund Receipt Bill of  ' . $users57->Name . ' use of Amount ' . number_format($users57->PaidAmount) . ' in Total Amount: ' . number_format($users57->RemainingAmount)), 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 15, number_format($users57->PaidAmount), 1, 1, 'C', 0);
            $this->fpdf->Cell(220, 6, 'Remaining Amount:', 0, 0, 'R', 0);
            $this->fpdf->Cell(40, 6, number_format($users57->RemainingAmount), 0, 1, 'C', 0);
            $this->fpdf->Output();
            exit;
        }
    }

    public function Amount_repurchased_receipt_bill($id)
    {

        $check_security = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('ID', '=', $id)->where('PaidAmount', '!=', 0)->exists();
        if ($check_security) {
            $users = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('ID', '=', $id)->where('PaidAmount', '!=', 0)->get();
            foreach ($users as $users57) {
            }
            $this->fpdf = new Fpdf;
            $this->fpdf->AddPage("L", ['280', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 140, 15, 35, 17);
            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(105, 6, '', 0, 0, 'R', 0);
            $this->fpdf->SetTextColor(250, 248, 248);
            $this->fpdf->Cell(85, 12, 'Repurchased PAYMENT VOUCHER', 0, 1, 'C', 1);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(40, 6, 'Name: ' . $users57->Name, 0, 0, 'L', 0);
            $this->fpdf->Cell(160, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Payment Voucher', 0, 1, 'R', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(40, 6, 'File Plot No: ' . $users57->File_Plot_Number, 0, 0, 'L', 0);
            $this->fpdf->Cell(170, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Method Type: ' . $users57->AccountID, 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, 'Contact: ' . $users57->Contact, 0, 0, 'L', 0);
            $this->fpdf->Cell(162, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'PV ID: ' . $users57->PVID, 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, 'Block: ' . $users57->Block, 0, 1, 'L', 0);
            $this->fpdf->Cell(40, 6, 'Plot Type: ' . $users57->Plot_Type, 0, 1, 'L', 0);
            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(220, 6, 'Description', 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 6, 'Paid', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(220, 15, ('Repurchased Receipt Bill of  ' . $users57->Name . ' use of Amount ' . number_format($users57->PaidAmount)), 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 15, number_format($users57->PaidAmount), 1, 1, 'C', 0);
            $this->fpdf->Cell(220, 6, 'Remaining Amount:', 0, 0, 'R', 0);
            $this->fpdf->Cell(40, 6, number_format($users57->RemainingAmount), 0, 1, 'C', 0);
            $this->fpdf->Output();
            exit;
        }
    }

    public function debit_note_letter($id)
    {

        $fetch_company_detail = DB::table('tb_create_company')->where('company_id', '=', company_id())->get();
        foreach ($fetch_company_detail as $fetch_company_detail1) {

        }
        $check_security = DB::connection('sqlsrv3')->table('DebitNotes')->where('CompanyID', '=', company_id())->where('ID', '=', $id)->exists();
        if ($check_security) {
            $get_req = DB::connection('sqlsrv3')->table('DebitNotes')->where('CompanyID', '=', company_id())->where('ID', '=', $id)->get();
            foreach ($get_req as $get_req1) {
            }
            $get_req_pay = DB::connection('sqlsrv3')->table('PaymentVoucherDetail')->where('CompanyID', '=', company_id())->where('AgainstINV', '=', $get_req1->InvoiceID)->where('PVNO', '=', $get_req1->DebitNotesID)->get();
            foreach ($get_req_pay as $get_req_pay1) {
            }
            $this->fpdf->AddPage("P", ['210', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(75, 17, 'DEBIT NOTES');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 165, 7, 43, 15);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Text(135, 37, 'Debit Notes #:');
            $this->fpdf->Text(165, 37, $get_req1->DebitNotesID);
            $this->fpdf->Text(150, 43, 'Date:');
            $this->fpdf->Text(165, 43, $get_req1->Dated);
            $this->fpdf->Text(15, 37, 'Vendor ID:');
            $this->fpdf->Text(50, 37, $get_req1->VendorID);
            $this->fpdf->Text(15, 43, 'Vendor Name:');
            $this->fpdf->Text(50, 43, $get_req1->VendorName);
            $this->fpdf->Text(15, 50, 'Total Debit Amount:');
            $this->fpdf->Text(55, 50, number_format($get_req1->TotalDebitAmount));

            $this->fpdf->ln(50);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->SetFont('Times', '', 12);

            $update_date = date("Y-m-d");
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(180, 6, 'Full Debit Notes Detail', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', 'B', 10);
            $this->fpdf->Cell(30, 6, 'Item Code', 1, 0, 'C', 0);
            $this->fpdf->Cell(70, 6, 'Item Name.', 1, 0, 'C', 0);

            $this->fpdf->Cell(40, 6, 'Sub Total.', 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 6, 'Debit Amount.', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 10);
            $fet_detail = DB::connection("sqlsrv3")->table("DebitNotesItems")->leftJoin('ItemList', 'DebitNotesItems.ItemId', '=', 'ItemList.ID')->where('DebitNotesItems.CompanyID', '=', company_id())->where("DebitNotesItems.DNID", '=', $id)->select('DebitNotesItems.*', 'ItemList.ItemCode')->get();
            foreach ($fet_detail as $fet_detail1) {

                $this->fpdf->Cell(30, 6, $fet_detail1->ItemCode, 1, 0, 'C', 0);

                $this->fpdf->Cell(70, 6, $fet_detail1->ItemName, 1, 0, 'C', 0);
                $this->fpdf->Cell(40, 6, number_format($fet_detail1->SubTotal), 1, 0, 'C', 0);
                $this->fpdf->Cell(40, 6, number_format($fet_detail1->DebitAmount), 1, 1, 'C', 0);
            }
            $this->fpdf->MultiCell(170, 6, 'Narration: ' . $get_req1->Remarks, 0, 'L', false);
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(60, 6, 'Paid By:', 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, 'Supervised By:', 0, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, 'Received By:', 0, 1, 'R', 0);
            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', $get_req1->CreatedBy)->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {

            }
            $this->fpdf->Cell(60, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, '________________', 0, 0, 'C', 0);
// $this->fpdf->Cell(60,6,$get_req1->SalesPerson,0,1,'R',0);
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetY(-15);
            $this->fpdf->Cell(0, 10, 'Printed Date: ' . $update_date, 0, 0, 'C');
            $this->fpdf->Output();
            exit;
        } else {
        }
    }


    //

}
