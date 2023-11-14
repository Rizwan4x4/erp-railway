<?php

namespace App\Http\Controllers\Accounts;

use App\Exports\GeneralReportExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertRequisitionForm;
use App\Traits\CommonTrait;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Str;

class AccountsController extends Controller
{
    use CommonTrait;

    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
        $this->fpdf->SetAutoPageBreak(true);
        $this->fpdf->SetLeftMargin(15);
    }

    public function cost_orland_report($start_date, $end_date)
    {

        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[IncomeStatment_CostOfLand]
    @date1  = N'" . $start_date . "',
    @date2  = N'" . $end_date . "'");
        return request()->json(200, $result);
    }

    public function get_invoice_date($id)
    {

        $result = DB::connection('sqlsrv3')->table('ReceivingOrder')->select('ReceivingOrder.InvoiceNo', 'ReceivingOrder.Dated', 'Status')->where('ReceivingOrder.ReceavingOrderID', '=', $id)->get();
        return request()->json(200, $result);
    }

    public function operatingland_report($start_date, $end_date)
    {

        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[IncomeStatment_OperatingProfit]
    @date1  = N'" . $start_date . "',
    @date2  = N'" . $end_date . "'");

        return request()->json(200, $result);
    }

    public function get_purchaseorder_detail1_by_PIID($id)
    {
        $get_quo = DB::connection('sqlsrv3')->table('ReceivingOrderItems')->where('ROID', '=', $id)->get();
        return request()->json(200, $get_quo);
    }

    public function get_po_detail_by_PIID($id)
    {

        $result = DB::connection('sqlsrv3')->table('ReceivingOrder')->where('ReceivingOrder.ReceavingOrderID', '=', $id)->select('ReceivingOrder.POID')->get();
        foreach ($result as $result1) {
        }
        $P_id = $result1->POID;
        $get_quo = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('PurchaseOrderID', '=', $P_id)->get();
        return request()->json(200, $get_quo);
    }

    public function get_POdetails_by_id($id)
    {

        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();

        foreach ($find_session as $find_session1) {
        }
        $session = $find_session1->SessionName;
        $result = DB::connection('sqlsrv3')->table('ReceivingOrder')->where('ReceivingOrder.ReceavingOrderID', '=', $id)->select('ReceivingOrder.POID')->get();
        foreach ($result as $result1) {
        }
        $P_id = $result1->POID;
        $find_config = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'PurchaseOrder.AgainstReq', '=', 'Requisition.RequisitionId')->where('PurchaseOrder.CompanyID', '=', company_id())->where('PurchaseOrder.PurchaseOrderID', '=', $result1->POID)->select('PurchaseOrder.PurchaseOrderID', 'PurchaseOrder.VendorName', 'Requisition.RequisitionId', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'PurchaseOrder.PoCode')->get();

        return request()->json(200, $find_config);
    }

    public function IncomeStatment_Taxation($start_date, $end_date)
    {

        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[IncomeStatment_Taxation]
    @date1  = N'" . $start_date . "',
    @date2  = N'" . $end_date . "'");

        return request()->json(200, $result);
    }

    public function ledger_get_general($start_date, $end_date, $ledger_name)
    {


        $update_dated = short_date();
        $pre_id = explode("_", $ledger_name);
        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[LedgerReport]
      @startdate = N'" . $start_date . "',
      @enddate = N'" . $end_date . "',
      @compa = N'" . company_id() . "',
      @Id = " . $pre_id[0] . "  ");
        $result21 = Arr::sort($result, function ($student) {
            return $student->TransactionDate;
        });
        $result_last = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[Ledger_Report_PB]
    @Start_date =  N'" . $start_date . "',
    @comp = N'" . company_id() . "',
    @ID = " . $pre_id[0] . "
      ");
        $lastEle_opb = Arr::last($result_last);
        $result1 = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
      @Datefrom = N'" . $start_date . "',
      @DateTo = N'" . $end_date . "',
      @id = " . $pre_id[0] . ",
      @compid = N'" . company_id() . "'  ");
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }

        $this->fpdf->AddPage("L", ['280', '297']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);

        $this->fpdf->Text(125, 15, 'General Ledger');
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 233, 7, 43, 15);
        $this->fpdf->SetFont('Times', '', 12);
        $this->fpdf->SetTextColor(41, 46, 46);

        $this->fpdf->ln(20);
        foreach ($result1 as $ledger_d_detail1) {
        }
        $this->fpdf->Cell(23, 5, 'Account ID:', 0, 0, 'C', 0);
        $this->fpdf->Cell(60, 5, $ledger_d_detail1->AccountID, 0, 0, 'L', 0);
        $this->fpdf->Cell(30, 5, 'Account Name:', 0, 0, 'L', 0);
        $this->fpdf->Cell(70, 5, $ledger_d_detail1->AccountName, 0, 1, 'L', 0);
        $this->fpdf->Cell(30, 5, 'Date Range:', 0, 0, 'L', 0);
        $this->fpdf->Cell(60, 5, $start_date . ' to ' . $end_date, 0, 0, 'L', 0);
        $this->fpdf->Cell(20, 5, 'Balance:', 0, 0, 'L', 0);
        $this->fpdf->Cell(100, 5, number_format($ledger_d_detail1->am) . '/-', 0, 1, 'L', 0);
        $this->fpdf->SetFont('Times', 'B', 10);

        $this->fpdf->Cell(40, 5, 'Opening Balance:', 0, 0, 'L', 0);
        if (!empty($lastEle_opb)) {

            $this->fpdf->Cell(100, 5, number_format($lastEle_opb->balance), 0, 1, 'L', 0);
        } else {
            $this->fpdf->Cell(100, 5, '', 0, 1, 'L', 0);

        }
        $this->fpdf->SetFont('Times', '', 12);

        $this->fpdf->Cell(200, 5, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(23, 5, 'Print Date:', 0, 0, 'C', 0);
        $this->fpdf->Cell(100, 5, $update_dated, 0, 1, 'L', 0);
        $this->fpdf->Cell(200, 5, '', 0, 0, 'C', 0);
        $this->fpdf->Cell(20, 5, 'Print By:', 0, 0, 'C', 0);
        $this->fpdf->Cell(100, 5, username(), 0, 1, 'L', 0);

        $this->fpdf->ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(9, 5, 'S.no', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 5, 'Date', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 5, 'Ref.No', 1, 0, 'C', 0);
        $this->fpdf->Cell(115, 5, 'Description', 1, 0, 'C', 0);

        $this->fpdf->Cell(25, 5, 'Debit', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 5, 'Credit', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 5, 'Balance', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 5, 'Post', 1, 1, 'C', 0);
        $this->fpdf->SetFont('Times', '', 12);
        $credit = [];
        $debit = [];
        $balance = [];
        foreach ($result21 as $get_req_detail1) {
            array_push($credit, $get_req_detail1->Credit);
            array_push($debit, $get_req_detail1->Debit);
            array_push($balance, $get_req_detail1->balance);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(9, 8, $get_req_detail1->RowNumber, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 8, $get_req_detail1->TransactionDate, 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 8, $get_req_detail1->DocumentNo, 1, 0, 'C', 0);
            $this->fpdf->SetFont('Times', '', 8);

            $this->fpdf->Cell(115, 8, substr($get_req_detail1->Description, 0, 80), 1, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);

            $this->fpdf->Cell(25, 8, number_format($get_req_detail1->Debit), 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 8, number_format($get_req_detail1->Credit), 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 8, number_format($get_req_detail1->balance), 1, 0, 'C', 0);
            $this->fpdf->Cell(15, 8, '', 1, 1, 'C', 0);
        }
        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Cell(174, 8, 'Grand Total:', 1, 0, 'R', 0);
        $this->fpdf->Cell(25, 8, number_format(array_sum($debit)), 1, 0, 'L', 0);
        $this->fpdf->Cell(25, 8, number_format(array_sum($credit)), 1, 0, 'L', 0);
        $this->fpdf->Cell(40, 8, '', 1, 1, 'L', 0);
        $this->fpdf->SetFont('Times', 'B', 10);
        $this->fpdf->Output();
        exit;
    }

    public function chq_superwise_detail($start_date, $end_date)
    {
        $check = DB::connection('sqlsrv3')->table('UnitsChqDetail')->where('DateTime', '>=', $start_date)->where('DateTime', '<=', $end_date)->where('Status', '=', 'Clearanced')->orWhere('Status', '=', 'Deposited')->get();
        return request()->json(200, $check);
    }

    public function search_receivedvoucher($start_date, $end_date)
    {
        $check = DB::connection('sqlsrv3')->table('ReceivedVoucher')->where('VoucherDate', '>=', $start_date)->where('VoucherDate', '<=', $end_date)->where('CompanyID', '=', company_id())->orderBy('ReceivedVoucherID', 'DESC')->paginate(20);
        return request()->json(200, $check);
    }

    public function online_cash_report($start_date, $end_date)
    {
        $check = DB::connection('sqlsrv3')->table('UnitsOnlineCash')->where('DateTime', '>=', $start_date)->where('DateTime', '<=', $end_date)->where('Status', '=', 'Proceed')->get();
        return request()->json(200, $check);
    }

    public function cash_report($start_date, $end_date)
    {
        $request = request();
        $exportAll = $request->query('exportAll'); // Get the query parameter

        $query = DB::connection('sqlsrv3')
            ->table('UnitsCashDetail')
            ->where('DateTime', '>=', $start_date)
            ->where('DateTime', '<=', $end_date)
            ->where('Status', '=', 'Proceed');

        if ($exportAll) {
            $check = $query->get(); // Retrieve all the data without pagination
        } else {
            $check = $query->paginate(500); // Paginated data
        }

        return response()->json($check);
    }

    public function debit_credit_superwisedetail($start_date, $end_date)
    {
        $check = DB::connection('sqlsrv3')->table('UnitsDebitCreditDetail')->where('DateTime', '>=', $start_date)->where('DateTime', '<=', $end_date)->where('Status', '=', 'Proceed')->get();
        return request()->json(200, $check);
    }

    public function get_datad($rid)
    {
        $data = explode("_", $rid);
        $id = $data[0];

        $check = DB::connection('sqlsrv3')->table('Issuances')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $id)->exists();
        $getIssu = DB::connection('sqlsrv3')->table('Issuances')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $id)->get();
        $i = 0;
        $j = 0;
        $k = '';
        // return request()->json(200,$getIssu);
        if ($check) {

            foreach ($getIssu as $getIssu1) {
                $counted = DB::connection('sqlsrv3')->table('IssuanceItem')->where('IssuanceId', '=', $getIssu1->IssuanceId)->count();
                $i = $i + 1;

                $b[$i] = '<tr ><td style="border-style: none !important;">' . $getIssu1->IssuanceDate . '</td>
      <td style="border-style: none !important;">' . $getIssu1->IssuanceCode . '</td>
      <td style="border-style: none !important;">' . $getIssu1->DepartmentName . '</td>
      <td style="border-style: none !important;">' . $getIssu1->ProjectName . '</td>';
                $k = $k . '' . $b[$i];
                $cand = DB::connection('sqlsrv3')->table('IssuanceItem')->join('ItemList', 'ItemList.ID', '=', 'IssuanceItem.itemId')->where('IssuanceItem.IssuanceId', '=', $getIssu1->IssuanceId)->select('IssuanceItem.*', 'ItemList.ItemCode')->get();
                $check11 = DB::connection('sqlsrv3')->table('IssuanceItem')->join('ItemList', 'ItemList.ID', '=', 'IssuanceItem.itemId')->where('IssuanceItem.IssuanceId', '=', $getIssu1->IssuanceId)->select('IssuanceItem.*', 'ItemList.ItemCode')->exists();

                if ($check11) {
                    foreach ($cand as $candidate1) {
                        $j = $j + 1;
                        if ($counted > 1) {
                            $b[$j] = '<td style="border-style: none !important;">' . $candidate1->ItemCode . '</td>
            <td style="border-style: none !important;">' . $candidate1->ItemName . '</td>
            <td style="border-style: none !important;">' . number_format($candidate1->ReqQuantity) . '</td>
            <td style="border-style: none !important;">' . $candidate1->unit . '</td>
              <td style="border-style: none !important;">' . number_format($candidate1->IssuanceQuantity) . '</td></tr>';
                            $k = $k . '' . $b[$j];
                            $c[$j] = '<tr ><td style="border-style: none !important;"></td>
          <td style="border-style: none !important;"></td>
          <td style="border-style: none !important;"></td>
          <td style="border-style: none !important;"></td>';
                            $k = $k . '' . $c[$j];
                        } else {
                            $b[$j] = '<td style="border-style: none !important;">' . $candidate1->ItemCode . '</td>
          <td style="border-style: none !important;">' . $candidate1->ItemName . '</td>
          <td style="border-style: none !important;">' . number_format($candidate1->ReqQuantity) . '</td>
          <td style="border-style: none !important;">' . $candidate1->unit . '</td>
            <td style="border-style: none !important;">' . number_format($candidate1->IssuanceQuantity) . '</td></tr>';
                            $k = $k . '' . $b[$j];
                        }
                    }
                }
            }
        }
        return request()->json(200, $k);
    }

    public function Receiving_Data_report($start_date, $end_date, $Dep_Name = null, $Pro_Name = null)
    {


        if ($Dep_Name == 'All') {
            $Dep_Name = '';
        }
        $result = DB::connection('sqlsrv3')->table('GrnOrder as grn')
            ->select('il.ItemCode as ItemCode', 'roi.ItemName as Name', 'r.DepartmentName', 'roi.Unit as UOM', 'po.RequisitionType as Type', 'roi.RecvdQuantity as ReceivedQty', 'roi.Price as UnitPrice', 'grn.GrnID as GRNNo', 'grn.Dated as GRNDate', 'grn.Status', 'r.ProjectName', 'po.vendorName as VendorName')
            ->join('PurchaseOrder as po', 'grn.POID', '=', 'po.PurchaseOrderID')
            ->join('Requisition as r', 'po.AgainstReq', '=', 'r.RequisitionId')
            ->join('GrnOrderItems as roi', 'grn.GrnOrderID', '=', 'roi.GrnID')
            ->join('ItemList as il', 'roi.ItemId', '=', 'il.ID')
            ->whereBetween('grn.Dated', [$start_date, $end_date])->where('r.DepartmentName', 'like', '%' . $Dep_Name . '%')->where('r.ProjectName', 'like', '%' . $Pro_Name . '%')
            ->orderBy('grn.Dated')
            ->orderBy('po.PoCode')
            // ->orderBy('ro.Status2')
            ->get();

        return request()->json(200, $result);
    }

    public function Issuance_Data_report($start_date, $end_date, $Dep_Name = null, $Pro_Name = null)
    {

        if ($Dep_Name == 'All') {
            $Dep_Name = '';
        }
        $result = DB::connection('sqlsrv3')->table('Issuances as i')
            ->select('il.ItemCode', 'il.Name', 'ii.unit as UOM', 'dr.RequisitionType as Type', 'ii.IssuanceQuantity as IssuedQuantity', 'i.IssuanceCode as IssuanceNo', 'i.IssuanceDate as IssuanceDate', 'i.Status', 'i.DepartmentName', 'i.ProjectName as Project', 'quot.VendorName as VendorName', 'ii.Price as Price', 'ii.SubTotal')
            ->leftJoin('DemandRequisition as dr', 'i.RequisitionId', '=', 'dr.RequisitionId')
            ->leftJoin('Requisition as req', 'dr.RequisitionId', '=', 'req.DemandRID')
            ->leftJoin('PQuotation as quot', 'req.RequisitionId', '=', 'quot.RequisitionID')
            ->join('IssuanceItem as ii', 'ii.IssuanceId', '=', 'i.IssuanceId')
            ->join('ItemList as il', 'il.ID', '=', 'ii.itemId')
            ->whereBetween('i.IssuanceDate', [$start_date, $end_date])
            ->where('i.DepartmentName', 'like', '%' . $Dep_Name . '%')
            ->where('i.ProjectName', 'like', '%' . $Pro_Name . '%')
            ->orderBy('i.IssuanceDate')
            ->orderBy('dr.RequisitionId')
            ->orderBy('i.IssuanceId')
            ->get();
        return request()->json(200, $result);
    }

    public function OpenPos_Data_report($start_date, $end_date, $Dep_Name = null, $Pro_Name = null)
    {


        if ($Dep_Name == 'All') {
            $Dep_Name = '';
        }
        $result = DB::connection('sqlsrv3')->table('PurchaseOrderItems as poi')
            ->select('il.ItemCode', 'il.Name', 'poi.Detail as Description', 'poi.Unit as Uom', 'poi.QuoteQuantity as Q_Qty', 'poi.Quantity as PO_Qty', 'po.RequisitionType as Type', 'po.PoCode as PONo', 'po.PoDate as PODate', 'poi.Price as UnitPrice', 'po.TotalAmount as Amount', 'po.Status', 'r.DepartmentName', 'r.ProjectName as Project', 'po.vendorName as VendorName', 'po.PoCode')
            ->join('PurchaseOrder as po', 'po.PurchaseOrderID', '=', 'poi.POID')
            ->join('Requisition as r', 'r.RequisitionId', '=', 'po.AgainstReq')
            ->join('ItemList as il', 'il.ID', '=', 'poi.ItemId')
            ->where('po.state', '=', 0)->whereBetween('po.PoDate', [$start_date, $end_date])
            ->where('po.RequisitionType', '!=', 'Services')->where('r.DepartmentName', 'like', '%' . $Dep_Name . '%')->where('r.ProjectName', 'like', '%' . $Pro_Name . '%')
            ->orderBy('po.PoCode')
            ->get();

        return request()->json(200, $result);
    }


    public function GIGBPP_Data_report($start_date, $end_date, $Dep_Name = null, $Pro_Name = null)
    {


        if ($Dep_Name == 'All') {
            $Dep_Name = '';
        }
        $result = DB::connection('sqlsrv3')->table('GrnOrder as grn')
            ->select('po.PoCode as PONo', 'po.PoDate as PODate', 'grn.GrnID as GRNNo', 'grn.Dated as GRNDate', 'ro.TotalAmount as PayableAmount', 'ro.Status2 as AmountStatus', 'po.vendorName as VendorName', 'r.DepartmentName', 'r.ProjectName as Project', 'grn.Status', 'po.RequisitionType as Type')
            ->join('PurchaseOrder as po', 'grn.POID', '=', 'po.PurchaseOrderID')
            ->join('Requisition as r', 'po.AgainstReq', '=', 'r.RequisitionId')
            ->join('ReceivingOrder as ro', 'grn.GrnOrderID', '=', 'ro.GRNID')
            ->whereBetween('grn.Dated', [$start_date, $end_date])->where('r.DepartmentName', 'like', '%' . $Dep_Name . '%')->where('r.ProjectName', 'like', '%' . $Pro_Name . '%')
            ->where('ro.Status2', '=', 'Not Verified')
            ->orderBy('grn.Dated')
            ->orderBy('po.PoCode')
            ->orderBy('ro.Status2')
            ->get();

        return request()->json(200, $result);
    }

    public function update_accounts_configuration(Request $request)
    {

        $update_date = short_date();

        $Emp_id = employee_id();

        $customer_inv = $request->get('customer_inv');
        $customer_credit = $request->get('customer_credit');
        $customer_pre = $request->get('customer_pre');
        $customer_voucher = $request->get('customer_voucher');
        $quotation = $request->get('quotation');
        $vendor_debit = $request->get('vendor_debit');
        $vendor_inv = $request->get('vendor_inv');
        $vendor_pre = $request->get('vendor_pre');
        $vendor_voucher = $request->get('vendor_voucher');
        $requistion = $request->get('requistion');
        $journal_voucher = $request->get('journal_voucher');
        $currency = $request->get('currency');
        $grn = $request->get('grn');


        $company_exists = DB::connection('sqlsrv3')->table('AccountsConfiguration')->where('CompanyID', '=', company_id())->exists();
        if ($company_exists) {

            $result = DB::connection('sqlsrv3')->update('update  AccountsConfiguration set CustomerInvoice=?, CreditNote=?, ReceivedVoucher=?, Customer=?, Quotation=?, PurchaseOrder=?, DebitNote=?, PaymentVoucher=?, Vendor=?, Requisition=?, JournalVocvher=?,Currency=?,GoodReceivedNote=? where CompanyID=?', [$customer_inv, $customer_credit, $customer_voucher, $customer_pre, $quotation, $vendor_inv, $vendor_debit, $vendor_pre, $vendor_voucher, $requistion, $journal_voucher, $currency, $grn, company_id()]);
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Updated Account Configurations', 'Updated Acounts Configuration for Company | ' . company_id() . '', $update_date]);
        } else {

            $result = DB::connection('sqlsrv3')->insert('INSERT INTO AccountsConfiguration(CompanyID,CustomerInvoice, CreditNote, ReceivedVoucher, Customer, Quotation, PurchaseOrder,DebitNote,PaymentVoucher,Vendor,Requisition,JournalVocvher,Currency,GoodReceivedNote) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $customer_inv, $customer_credit, $customer_voucher, $customer_pre, $quotation, $vendor_inv, $vendor_debit, $vendor_pre, $vendor_voucher, $requistion, $journal_voucher, $currency, $grn]);
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Added Account Configurations', 'Added Acounts Configuration for New Company | ' . company_id() . '', $update_date]);
        }

        return request()->json(200, "Successfully Added");
    }

    public function get_starting_date($name)
    {
        $asset_id = explode("_", $name);
        $check11 = DB::connection('sqlsrv3')->table('DepreciationAssets')->where('AssetId', '=', $asset_id[0])->exists();
        if ($check11) {
            $getDate = DB::connection('sqlsrv3')->table('DepreciationAssets')->where('AssetId', '=', $asset_id[0])->select('StartingDate')->first();
            return request()->json(200, $getDate);
        }


    }

    public function get_net_value_salvage($name)
    {
        $asset_id = explode("_", $name);
        $data = DB::connection('sqlsrv3')->table('Assets')->select('Assets.SalvageValue')->where('Assets.AssetsUniqueID', '=', $asset_id[0])->first();
        return request()->json(200, $data);
    }

    public function get_net_value($Retirement_date, $name)
    {
        $date = date('Y-m', strtotime($Retirement_date));
        $asset_id = explode("_", $name);
        $data = DB::connection('sqlsrv3')->table('AssetBook')->select('ClosingValue')->where('AssetID', '=', $asset_id[0])
            ->where(DB::raw('SUBSTRING(AssetBook.ClosingDate, 1, 7)'), '=', $date)
            ->get();
        return request()->json(200, $data);
    }

    public function submit_AssetRetirement(Request $request)
    {
        $cost_unit = $request->get('net_value');
        $asset_name = $request->get("assets_name");
        $asset_name1 = explode("_", $asset_name);
        $Retirement_type = $request->get("Retirement_type");
        $Retirement_date = $request->get("Retirement_date");
        $closing_date = $request->get("closing_date");
        $return_date = substr($closing_date, 0, 7);
        $narration = $request->get("narration");
        $net_value = $request->get("net_value");

        date_default_timezone_set("Asia/Karachi");
        $created_on = long_date();
        $fromDate_Deprec = Carbon::parse($Retirement_date);
        $get_depreccloasingdate = $fromDate_Deprec;

        //when Asset Dispose off will apply, this function will get last date of previous month
        $lastDayOfMonth = date('Y-m-t', strtotime(substr($get_depreccloasingdate, 0, 10)));
        $session_enddate = substr($Retirement_date, 0, 7);
        $toDate = Carbon::parse($return_date);
        $fromDate = Carbon::parse($session_enddate);
        $months = $toDate->diffInMonths($fromDate);
        $month1 = $months;
        $depreciation_id = DB::connection('sqlsrv3')->table('DepreciationAssets')->where('DepreciationAssets.AssetId', '=', $asset_name1[0])->exists();


        if ($depreciation_id) {
            $dep_id = DB::connection('sqlsrv3')->table('DepreciationAssets')->select('DepreciationAssets.*')->where('DepreciationAssets.AssetId', '=', $asset_name1[0])->get();
            foreach ($dep_id as $dep_id1) {
            }
            $history = 'Previous Depreciation Entries was Closing Date: ' . $dep_id1->ClosingDate . ' Closing Value: ' . $dep_id1->ClosingValue . ' Depreciated Value: ' . $dep_id1->DepreciatedValue . ' StartingValue: ' . $dep_id1->StartingValue . ' Starting Date: ' . $dep_id1->StartingDate . ' Disposed Value ' . $cost_unit;
            $result = DB::connection('sqlsrv3')->insert("INSERT INTO AssetDisposals(RetirementType,RetirementDate,NetValueBalance,Narration,AssetsUniqueID,DepreciationAssetsID,Status,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?,?)", [$Retirement_type, $Retirement_date, $net_value, $narration, $asset_name1[0], $dep_id1->ID, "Retired", username(), $created_on]);
            if ($result) {
                $d_id = DB::connection('sqlsrv3')->table('AssetDisposals')->select('AssetDisposals.ID')->where('AssetDisposals.AssetsUniqueID', '=', $asset_name1[0])->get();
                foreach ($d_id as $d_id1) {

                }
                $Disposal_id = $d_id1->ID;
                DB::connection('sqlsrv3')->update('update AssetBook set UpdatedBy=?,UpdatedOn=?,ChangeType=?, isDeleted = ?, AssetDisposalsID = ? WHERE AssetID = ? and ClosingDate >= ?', [username(), $created_on, "Retired", 1, $Disposal_id, $asset_name1[0], $fromDate]);

                if ($dep_id1->Methods == 'Reducing_balance') {
                    $percentage = $dep_id1->Percentage;
                    $total_val = ($cost_unit / 100) * $percentage;
                    $total_val1 = ($total_val / 12) * $month1;
                    $closing_value = $cost_unit - $total_val1;

                    $update_Depreciation = DB::connection('sqlsrv3')->update('update DepreciationAssets set  Status=?, ClosingDate=? ,ClosingValue=? ,DepreciatedValue=? ,UpdatedBy=?,UpdatedOn=?,AssetDisposalsID=?, History=?,AssetsRetired=? Where AssetId=?', ['deactive', substr($get_depreccloasingdate, 0, 10), $closing_value, $total_val1, username(), $created_on, $Disposal_id, $history, 1, $asset_name1[0]]);
                } elseif ($dep_id1->Methods == 'straight_line') {
                    $get_salvagevalue = DB::connection('sqlsrv3')->table('Assets')->where('AssetsUniqueID', '=', $asset_name1[0])->where('AssetType', '=', 2)->select('SalvageValue', 'EstLife')->get();
                    foreach ($get_salvagevalue as $get_salvagevalue1) {
                    }
                    $toDate1 = Carbon::parse(substr($dep_id1->StartingDate, 0, 7));
                    $fromDate1 = Carbon::parse($get_salvagevalue1->EstLife);
                    $months_dec = $toDate1->diffInMonths($fromDate1);
                    $months_dec1 = $months_dec;
                    $year = 1;
                    $year = floor($months_dec1 / 12);
                    $mon = $months_dec1 % 12;

                    if ($mon > 0) {
                        $year = $year + 1;
                    }
                    $total_val1 = ($cost_unit - $get_salvagevalue1->SalvageValue) / $year;
                    $closing_value = $cost_unit - $total_val1;
                    $update_Depreciation = DB::connection('sqlsrv3')->update('update DepreciationAssets set Status=?,ClosingValue=?,DepreciatedValue=?, ClosingDate=? ,UpdatedBy=?,UpdatedOn=?,AssetDisposalsID=?, History=?,AssetsRetired=? Where AssetId=?', ['deactive', $closing_value, $total_val1, substr($get_depreccloasingdate, 0, 10), username(), $created_on, $Disposal_id, $history, 1, $asset_name1[0]]);
                }
                DB::connection('sqlsrv3')->update('update Assets set  AssetDisposalsID=?, UpdatedBy=? ,UpdatedOn=?,IsRetired=? where AssetsUniqueID=?', [$Disposal_id, username(), $created_on, 1, $asset_name1[0]]);
                $arr = 'Submitted';
                return request()->json(200, $arr);
            }
        } else {
            $result1 = DB::connection('sqlsrv3')->insert("INSERT INTO AssetDisposals(RetirementType,RetirementDate,NetValueBalance,Narration,AssetsUniqueID,Status,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?)", [$Retirement_type, $Retirement_date, $net_value, $narration, $asset_name1[0], "Retired", username(), $created_on]);

            if ($result1) {
                $d_id = DB::connection('sqlsrv3')->table('AssetDisposals')->select('AssetDisposals.ID')->where('AssetDisposals.AssetsUniqueID', '=', $asset_name1[0])->get();
                foreach ($d_id as $d_id1) {

                }
                $Disposal_id = $d_id1->ID;
                DB::connection('sqlsrv3')->update('update Assets set  AssetDisposalsID=?, UpdatedBy=? ,UpdatedOn=?,IsRetired=? where AssetsUniqueID=?', [$Disposal_id, username(), $created_on, 1, $asset_name1[0]]);
                $arr = 'Submitted';
                return request()->json(200, $arr);
            }
        }


    }

    public function assets_retirement_detail()
    {
        $arr = DB::connection('sqlsrv3')->table('AssetDisposals')->orderBy('AssetDisposals.CreatedOn', 'desc')->paginate(20);
        return request()->json(200, $arr);
    }

    public function get_session_dates()
    {
        $dates = DB::connection('sqlsrv3')->table('Session')->select('Session.*')->where('Status', '=', 1)->get();
        return request()->json(200, $dates);
    }

    public function search_asset_retirement_byAssetUniqueID(Request $request)
    {
        $arr = DB::connection('sqlsrv3')->table('AssetDisposals')->where('AssetDisposals.AssetsUniqueID', 'like', '%' . $request->keyword1 . '%')->orderBy('AssetDisposals.CreatedOn', 'desc')->paginate(20);

        return request()->json(200, $arr);
    }

    public function AssetDisposedDetail($start_date, $end_date, $id)
    {
        if ($id == 'All') {
            $data = DB::connection('sqlsrv3')->table('AssetDisposals')->select('AssetDisposals.*')->where('AssetDisposals.CreatedOn', '>=', $start_date)->where('AssetDisposals.CreatedOn', '<=', $end_date)->get();
            return request()->json(200, $data);
        } elseif ($id != 'All') {
            $disposed_di = explode("_", $id);
            $data = DB::connection('sqlsrv3')->table('AssetDisposals')->select('AssetDisposals.*')->where('AssetDisposals.AssetsUniqueID', '=', $disposed_di[0])->exists();
            if ($data) {
                $data = DB::connection('sqlsrv3')->table('AssetDisposals')->select('AssetDisposals.*')->where('AssetDisposals.AssetsUniqueID', '=', $disposed_di[0])->get();
                return request()->json(200, $data);
            } else {
                $message = 'Selected Asset is not Retired';
                return response()->json(['message' => $message], 200);
            }


        }
    }

    public function child_detail()
    {

        $find_company = DB::connection('sqlsrv3')->table("ChildCompany")->where('CompanyID', '=', company_id())->where('Type', '=', 'child')->paginate(8);
        return request()->json(200, $find_company);
    }

//already available route but that not use paginate
    public function dept_data1()
    {

        $find_company = DB::connection('sqlsrv3')->table("ChildCompany")->where('CompanyID', '=', company_id())->where('Type', '=', 'department')->paginate(10);
        return request()->json(200, $find_company);
    }

    public function dept_data()
    {

        $find_company = DB::connection('sqlsrv3')->table("ChildCompany")->where('CompanyID', '=', company_id())->where('Type', '=', 'department')->get();
        return request()->json(200, $find_company);
    }

    public function unit_data()
    {

        $find_company = DB::connection('sqlsrv3')->table("Unit")->where('CompanyID', '=', company_id())->orderby('UnitName', 'asc')->paginate(8);
        return request()->json(200, $find_company);
    }

    public function submit_unit(Request $request)
    {


        $update_date = short_date();

        $Emp_id = employee_id();

        $status = 'Active';
        $unit_name = $request->get('unit_name');
        $isunit_name = DB::connection('sqlsrv3')->table("Unit")->where('CompanyID', '=', company_id())->where("UnitName", "=", $unit_name)->exists();
        if ($isunit_name) {
            $data = "Unit already exists";
            return request()->json(401, $data);
        }

        $result = DB::connection('sqlsrv3')->insert('INSERT INTO Unit(CompanyID,UnitName,Status) values (?,?,?)', [company_id(), $unit_name, $status]);
        if ($result) {
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Unit Created', 'Unit Name | ' . $unit_name . ' | has been created ', $update_date]);
            $find_company = DB::connection('sqlsrv3')->table("Unit")->where('CompanyID', '=', company_id())->orderby('UnitName', 'asc')->paginate(8);
            return request()->json(200, $find_company);
        }
    }

    public function submit_departments(Request $request)
    {


        $update_date = short_date();

        $Emp_id = employee_id();

        $type = 'department';
        $status = 'Active';
        $company_name = $request->get('department');

        $isdepart_name = DB::connection('sqlsrv3')->table("ChildCompany")->where('CompanyID', '=', company_id())->where("COmpanyName", "=", $company_name)->exists();
        if ($isdepart_name) {
            $data = "Company already exists";
            return request()->json(401, $data);
        }


        $result = DB::connection('sqlsrv3')->insert('INSERT INTO ChildCompany(CompanyID,Type,COmpanyName,Status) values (?,?,?,?)', [company_id(), $type, $company_name, $status]);
        if ($result) {
            $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Expenses')->where('AccountHead', '=', 'Departments')->exists();
            if ($find_last_head_code9) {
                $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Expenses')->where('AccountHead', '=', 'Departments')->get();
                foreach ($find_last_head_code as $find_last_head_code1) {

                }
                $account_code = $find_last_head_code1->ID + 1;


                $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Expenses')->where('AccountHead', '=', 'Departments')->get();
                foreach ($find_head_name as $find_head_name1) {
                }
                $result = DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(), $company_name, 'Expenses', $find_head_name1->ID, $find_head_name1->AccountName, 'Node']);
            } else {
                $find_head_name = DB::connection('sqlsrv3')->table("HeadJournal")->where('CompanyID', '=', company_id())->where('HeadId', '=', 'Expenses')->where('JournalName', '=', 'Departments')->get();
                return $find_head_name;
                foreach ($find_head_name as $find_head_name1) {
                }
                $account_code = $find_head_name1->journalCode . '001';
                //return request()->json(200,$account_code);

                $result = DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(), $company_name, 'Expenses', $find_head_name1->journalCode, $find_head_name1->JournalName, 'Node']);
            }


            $find_company = DB::connection('sqlsrv3')->table("ChildCompany")->where('CompanyID', '=', company_id())->where('Type', '=', 'department')->paginate(8);
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Department Created', 'Department Name | ' . $company_name . ' | has been created ', $update_date]);
            return request()->json(200, $find_company);
        }
    }

    public function project_data()
    {

        $find_projects = DB::connection('sqlsrv3')->table("CompanyProjects")->where('CompanyID', '=', company_id())->orderby('ProjectName', 'asc')->paginate(8);
        return request()->json(200, $find_projects);
    }

    public function fetch_company_config()
    {

        $find_config = DB::connection('sqlsrv3')->table("AccountsConfiguration")->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $find_config);
    }

    public function submit_childcompany(Request $request)
    {


        $update_date = short_date();
        $Emp_id = employee_id();

        $company_name = $request->get('company_name');
        $company_address = $request->get('company_name');
        $company_email = $request->get('company_name');
        $phone_no = $request->get('company_name');
        $type = 'child';
        $status = 'Active';
        $iscustomer_name = DB::connection('sqlsrv3')->table("ChildCompany")->where('CompanyID', '=', company_id())->where("COmpanyName", "=", $company_name)->exists();
        if ($iscustomer_name) {
            $data = "Company name already exists";
            return request()->json(200, $data);
        }
        $iscustomer_email = DB::connection('sqlsrv3')->table("ChildCompany")->where('CompanyID', '=', company_id())->where("CompanyEmail", "=", $company_email)->exists();
        if ($iscustomer_email) {
            $data = "Company email already exists";
            return request()->json(200, $data);
        }

        $result = DB::connection('sqlsrv3')->insert('INSERT INTO ChildCompany(CompanyID,Type,COmpanyName, CompanyAddress, CompanyEmail, CompanyPhone,Status) values (?,?,?,?,?,?,?)', [company_id(), $type, $company_name, $company_address, $company_email, $phone_no, $status]);
        if ($result) {


            $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountHead', '=', 'Long-term Investment')->exists();
            if ($find_last_head_code9) {
                $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountHead', '=', 'Long-term Investment')->get();
                foreach ($find_last_head_code as $find_last_head_code1) {

                }
                $account_code = $find_last_head_code1->ID + 1;


                $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', 'Long-term Investment')->get();
                foreach ($find_head_name as $find_head_name1) {
                }
            } else {
                $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', 'Long-term Investment')->get();
                foreach ($find_head_name as $find_head_name1) {
                }
                $account_code = $find_head_name1->ID . '001';
                //return request()->json(200,$account_code);
            }


            $result = DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(), $company_name, 'Assets', $find_head_name1->ID, $find_head_name1->AccountName, 'Node']);


            $find_company = DB::connection('sqlsrv3')->table("ChildCompany")->where('CompanyID', '=', company_id())->where('Type', '=', 'child')->paginate(8);
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Child Company Created', 'New Child Company | Name | ' . $company_name . ' | with email address ' . $company_email . ' | Company Address | ' . $company_address . ' | Phone Number ' . $phone_no . ' | has been created ', $update_date]);
            return request()->json(200, $find_company);
        }
    }

    public function submit_childcompanyproject(Request $request)
    {

    }

    public function get_childcompany()
    {

        $find_config = DB::connection('sqlsrv3')->table("ChildCompany")->select('ChildID', 'COmpanyName')->where('CompanyID', '=', company_id())->orderby('COmpanyName', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public function get_childcompany1($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("ChildCompany")->where('Type', '=', $id)->select('ChildID', 'COmpanyName')->where('CompanyID', '=', company_id())->orderby('COmpanyName', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public function submit_project_child(Request $request)
    {

        $project_name = $request->get('project_name');
        $child_company = $request->get('child_company');
        $parent = $request->get('parent');

        $founded = short_date();

        $isproject_name = DB::connection('sqlsrv3')->table("CompanyProjects")->where('CompanyID', '=', company_id())->where("ChildID", "=", $child_company)->where("ProjectName", "=", $project_name)->exists();
        if ($isproject_name) {
            $data = "Project name already exists";
            return request()->json(401, $data);
        } else {
            $result = DB::connection('sqlsrv3')->insert('INSERT INTO CompanyProjects(CompanyID,ChildID,ProjectName,FoundingDate,CreatedBy) values (?,?,?,?,?)', [company_id(), $child_company, $project_name, $founded, username()]);
            if ($result) {

                if ($parent == 'child') {
                    $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountHead', '=', $child_company)->exists();
                    if ($find_last_head_code9) {
                        $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountHead', '=', $child_company)->get();
                        foreach ($find_last_head_code as $find_last_head_code1) {

                        }
                        $account_code = $find_last_head_code1->ID + 1;


                        $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $child_company)->get();
                        foreach ($find_head_name as $find_head_name1) {
                        }
                    } else {
                        $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $child_company)->get();
                        foreach ($find_head_name as $find_head_name1) {
                        }
                        $account_code = $find_head_name1->ID . '001';
                        //return request()->json(200,$account_code);
                    }


                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(), $project_name, 'Assets', $find_head_name1->ID, $find_head_name1->AccountName, 'Transaction']);
                } else if ($parent == 'department') {
                    $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Expenses')->where('AccountHead', '=', $child_company)->exists();
                    if ($find_last_head_code9) {
                        $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Expenses')->where('AccountHead', '=', $child_company)->get();
                        foreach ($find_last_head_code as $find_last_head_code1) {

                        }
                        $account_code = $find_last_head_code1->ID + 1;


                        $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Expenses')->where('AccountName', '=', $child_company)->get();
                        foreach ($find_head_name as $find_head_name1) {
                        }
                    } else {
                        $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Expenses')->where('AccountName', '=', $child_company)->get();
                        foreach ($find_head_name as $find_head_name1) {
                        }
                        $account_code = $find_head_name1->ID . '001';
                        //return request()->json(200,$account_code);
                    }


                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(), $project_name, 'Assets', $find_head_name1->ID, $find_head_name1->AccountName, 'Transaction']);
                }

                $find_company = DB::connection('sqlsrv3')->table("CompanyProjects")->where('CompanyID', '=', company_id())->orderby('ProjectName', 'asc')->paginate(8);
                return request()->json(200, $find_company);
            }
        }
    }

    public function submit_account_type(Request $request)
    {

        $category_name = $request->get('category_name');
        $Description = $request->get('Description');
        $head_code = $request->get('head_code');

        $find_acc_exists = DB::connection('sqlsrv3')->table("AccountsHead")->where('CompanyID', '=', company_id())->where('HeadCode', '=', $head_code)->exists();

        if ($find_acc_exists) {
            $find_config = "Head Code Already Exists in Our Record.Please Try Other One";
            return request()->json(200, $find_config);
        } else {
            $find_acc_name_exists = DB::connection('sqlsrv3')->table("AccountsHead")->where('CompanyID', '=', company_id())->where('HeadName', '=', $category_name)->exists();
            if ($find_acc_name_exists) {
                $find_config = "Accounts Type Already Exists in Our Record.Please Try Other One";
                return request()->json(200, $find_config);
            } else {
                $result = DB::connection('sqlsrv3')->insert('INSERT INTO AccountsHead(CompanyID,HeadName,HeadCode,Description) values (?,?,?,?)', [company_id(), $category_name, $head_code, $Description]);
                if ($result) {
                    $find_config = DB::connection('sqlsrv3')->table("AccountsHead")->select('HeadName', 'HeadCode', 'Description')->where('CompanyID', '=', company_id())->orderby('HeadCode', 'asc')->paginate(8);
                    return request()->json(200, $find_config);
                }
            }
        }
    }

    public function get_acc_types()
    {

        $find_config = DB::connection('sqlsrv3')->table("AccountsHead")->select('HeadName', 'HeadCode', 'Description')->where('CompanyID', '=', company_id())->orderby('HeadCode', 'asc')->paginate(8);
        return request()->json(200, $find_config);
    }

    public function get_journal_heads()
    {

        $find_config = DB::connection('sqlsrv3')->table("HeadJournal")->select('JournalName', 'HeadId', 'journalCode')->where('CompanyID', '=', company_id())->orderby('journalCode', 'asc')->paginate(8);
        return request()->json(200, $find_config);
    }

    public function get_account_type()
    {

        $find_config = DB::connection('sqlsrv3')->table("AccountsHead")->select('HeadName', 'HeadCode')->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $find_config);
    }

    public function submit_journal_head(Request $request)
    {


        $update_date = long_date();

        $Emp_id = employee_id();
        $journal_name = $request->get('journal_name');
        $type = $request->get('type');
        $journal_code = $request->get('journal_code');

        if (strlen($journal_code) != 3) {
            $find_config = "Please select 3 Digits Code";
            return request()->json(200, $find_config);
        } else {
            $find_assets_code = DB::connection('sqlsrv3')->table("AccountsHead")->where('CompanyID', '=', company_id())->where('HeadName', '=', $type)->get();
            foreach ($find_assets_code as $find_assets_code1) {

            }
            $head_code = $find_assets_code1->HeadCode;
            if ($head_code != $journal_code[0]) {
                $find_config = "Please Select Valid Head Code";
                return request()->json(200, $find_config);
            } else {
                $find_code_exists = DB::connection('sqlsrv3')->table("HeadJournal")->where('CompanyID', '=', company_id())->where('journalCode', '=', $journal_code)->exists();

                if ($find_code_exists) {
                    $find_config = "Head Code Already Exists in Our Record.Please Try Other One";
                    return request()->json(200, $find_config);
                } else {
                    $find_acc_name_exists = DB::connection('sqlsrv3')->table("HeadJournal")->where('CompanyID', '=', company_id())->where('JournalName', '=', $journal_name)->exists();
                    if ($find_acc_name_exists) {
                        $find_config = "Journal Name Already Exists in Our Record.Please Try Other One";
                        return request()->json(200, $find_config);
                    } else {
                        $result = DB::connection('sqlsrv3')->insert('INSERT INTO HeadJournal(CompanyID,HeadId,JournalName,journalCode) values (?,?,?,?)', [company_id(), $type, $journal_name, $journal_code]);
                        if ($result) {
                            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Journal Head Created', 'Journal Head | Having Journal Code | ' . $journal_code . ' | Name | ' . $journal_name . ' | Type |' . $type . ' | has been created', $update_date]);
                            $find_config = DB::connection('sqlsrv3')->table("HeadJournal")->select('JournalName', 'HeadId', 'journalCode')->where('CompanyID', '=', company_id())->orderby('journalCode', 'asc')->paginate(8);
                            return request()->json(200, $find_config);
                        }
                    }
                }
            }
        }
    }


    public function get_coa_main_head($account_type)
    {

        $find_config = DB::connection('sqlsrv3')->table("HeadJournal")->where('CompanyID', '=', company_id())->where('HeadId', '=', $account_type)->get();
        return request()->json(200, $find_config);
    }

    public function get_coa_sub_head($main_head)
    {

        $find_config = DB::connection('sqlsrv3')->table("Accounts")->select('ID', 'AccountName')->where('CompanyID', '=', company_id())->where('CoaType', '=', 'Node')->where('AccountCode', '=', $main_head)->get();
        return request()->json(200, $find_config);
    }

    public function submit_chart_of_accounts(Request $request)
    {


        $Emp_id = employee_id();

        $update_date = long_date();
        $account_name = $request->get('account_name');
        $account_type = $request->get('account_type');
        $main_head = $request->get('main_head');
        $coa_type = $request->get('coa_type');
        //  return request()->json(200,$main_head);

        $check_validation = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $account_type)->where('AccountCode', '=', $main_head)->where('AccountName', '=', $account_name)->exists();
        if ($check_validation) {
            return request()->json(200, 'Already Exists');
        } else {
            $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $account_type)->where('AccountCode', '=', $main_head)->exists();
            if ($find_last_head_code9) {
                $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $account_type)->where('AccountCode', '=', $main_head)->get();
                foreach ($find_last_head_code as $find_last_head_code1) {

                }
                $account_code = $find_last_head_code1->ID + 1;
            } else {
                $account_code = $main_head . '001';
                //return request()->json(200,$account_code);
            }

            if (strlen($main_head) == 3) {
                $find_journal_headname = DB::connection('sqlsrv3')->table("HeadJournal")->where('CompanyID', '=', company_id())->where('journalCode', '=', $main_head)->get();
                foreach ($find_journal_headname as $find_journal_headname1) {

                }
                $ledger_name = $find_journal_headname1->JournalName;
            } else if (strlen($main_head) > 3) {
                $find_journal_headname = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('ID', '=', $main_head)->get();
                foreach ($find_journal_headname as $find_journal_headname1) {

                }
                $ledger_name = $find_journal_headname1->AccountName;
            }

            $result = DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountHead,AccountCode,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(), $account_name, $account_type, $ledger_name, $main_head, $coa_type]);
            if ($result) {
                DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Ledger Account Created', 'Ledger Account | ' . $account_name . ' | Account Type | ' . $account_type . ' | COA Type | ' . $coa_type . ' | Having Main Head | ' . $main_head . ' | has been Created ', $update_date]);
                $find_journal_headname = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->orderby('AccountType', 'Asc')->get();
                return request()->json(200, $find_journal_headname);
            }

        }
    }

    public function fetch_account_type()
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("AccountsHead")->select('HeadName', 'HeadCode')->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $find_journal_headname);
    }

    public function fetch_overall_coa()
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->orderby('AccountType', 'Asc')->get();

        return request()->json(200, $find_journal_headname);
    }

    public function fetch_type_coa($acc_type)
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $acc_type)->orderby('AccountHead', 'Asc')->get();

        return request()->json(200, $find_journal_headname);
    }

    public function fetch_type_menu($acc_type)
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("HeadJournal")->where('CompanyID', '=', company_id())->where('HeadId', '=', $acc_type)->orderby('journalCode', 'Asc')->get();

        return request()->json(200, $find_journal_headname);
    }

    public function fetch_journal_data($journal_id)
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountCode', 'like', $journal_id . '%')->orderby('ID', 'Asc')->get();

        return request()->json(200, $find_journal_headname);
    }

    public function get_coa_sub_head2($sub_head2)
    {

        $find_config = DB::connection('sqlsrv3')->table("Accounts")->select('ID', 'AccountName')->where('CompanyID', '=', company_id())->where('CoaType', '=', 'Node')->where('AccountCode', '=', $sub_head2)->get();
        return request()->json(200, $find_config);
    }

    public function get_coa_sub_head3($sub_head3)
    {

        $find_config = DB::connection('sqlsrv3')->table("Accounts")->select('ID', 'AccountName')->where('CompanyID', '=', company_id())->where('CoaType', '=', 'Node')->where('AccountCode', '=', $sub_head3)->get();
        return request()->json(200, $find_config);
    }

    public function submit_session(Request $request)
    {

        $update_date = short_date();


        $Emp_id = employee_id();

        $session_start = $request->get('session_start');
        $session_end = $request->get('session_end');
        $c_session = $request->get('c_session');
        $year_start = date('Y', strtotime($session_start));
        $year_end = date('Y', strtotime($session_end));
        $session_name = $year_start . '-' . $year_end;
        if ($c_session == "1") {
            DB::connection('sqlsrv3')->update('update Session set Status=? where CompanyID=?', [0, company_id()]);
        }
        $result = DB::connection('sqlsrv3')->insert('INSERT INTO Session(SessionName, StartDate, EndDate, CompanyID, Status) values (?,?,?,?,?)', [$session_name, $session_start, $session_end, company_id(), $c_session]);
        if ($result) {
            $arr = DB::connection('sqlsrv3')->table("Session")->where('CompanyID', '=', company_id())->orderBy('SessionID', 'desc')->paginate(5);
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Accounts Session Created', 'Account Session from ' . $session_start . ' | to ' . $session_end . ' | with Current Session Value | ' . $c_session . ' |  has been Created', $update_date]);
            $arr = "Submitted";
            return request()->json(200, $arr);
        }
    }

    public function session_detail()
    {

        $arr = DB::connection('sqlsrv3')->table("Session")->where('CompanyID', '=', company_id())->orderBy('SessionID', 'desc')->paginate(5);
        return request()->json(200, $arr);
    }

    public function delete_session($id)
    {
        $session_name_arr = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('SessionID', '=', $id)->get();
        foreach ($session_name_arr as $session_name_arr1) {
        }
        $session_name = $session_name_arr1->SessionName;
        //DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Delete Session','Session '.$session_name.' deleted', $update_date]);
        $result = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('SessionID', $id)->delete();
        if ($result) {
            $arr = DB::connection('sqlsrv3')->table("Session")->where('CompanyID', '=', company_id())->orderBy('SessionID', 'desc')->paginate(5);
            return request()->json(200, $arr);
        }
    }

    public function vendor_detail()
    {

        $can = DB::connection('sqlsrv3')->table('Vendor')
            ->orderBy('ID', 'asc')
            ->where('CompanyID', '=', company_id())->paginate(20);
        return request()->json(200, $can);
    }

    public function vendor_report_detail()
    {

        $can = DB::connection('sqlsrv3')->table('Vendor')
            ->select('CompanyName')
            ->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $can);
    }

    //fetch vendor
    public function fetch_vendors($id)
    {

        $ven = DB::connection('sqlsrv3')->table('Vendor')->orderBy('ID', 'asc')->where('CompanyID', '=', company_id())->where('ID', '=', $id)->get();
        return request()->json(200, $ven);
    }

    public function add_vendor(Request $request)
    {


        $Emp_id = employee_id();

        $update_date = long_date();
        $vendor_name = $request->get('vendor_name');
        $v_phone = $request->get('v_phone');
        $v_email = $request->get('v_email');
        $v_mobile = $request->get('v_mobile');
        $v_website = $request->get('v_website');
        $v_address = $request->get('v_address');
        $c_type = $request->get('c_type');
        $exist = DB::connection('sqlsrv3')->table("Vendor")->where('CompanyName', '=', $vendor_name)->where('CompanyID', '=', company_id())->exists();
        if ($exist) {
            $message = "Product exist";
            return request()->json(200, $message);
        } else {
            $result = DB::connection('sqlsrv3')->insert('INSERT INTO Vendor(CompanyName, Email, weblink, Mobile, Phone, Status, type, CreatedBy, CreatedOn, Address, CompanyID) values (?,?,?,?,?,?,?,?,?,?,?)', [$vendor_name, $v_email, $v_website, $v_mobile, $v_phone, "Active", $c_type, username(), $update_date, $v_address, company_id()]);
            if ($result) {

                $top_head = 'Trade Creditors';
                $type = 'Liabilities';

                $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountHead', '=', $top_head)->exists();
                if ($find_last_head_code9) {
                    $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountHead', '=', $top_head)->get();
                    foreach ($find_last_head_code as $find_last_head_code1) {

                    }
                    $account_code = $find_last_head_code1->ID + 1;


                    $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountName', '=', $top_head)->get();
                    foreach ($find_head_name as $find_head_name1) {
                    }
                } else {
                    $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountName', '=', $top_head)->get();
                    foreach ($find_head_name as $find_head_name1) {
                    }
                    $account_code = $find_head_name1->ID . '001';
                }


                $result = DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(), $vendor_name, $type, $find_head_name1->ID, $find_head_name1->AccountName, 'Transaction']);

                DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Vendor Added', 'Vendor ' . $vendor_name . ' | of Type | ' . $c_type . ' | with mobile number | ' . $v_mobile . ' | Address | ' . $v_address . ' |   has been Added ', $update_date]);

                $data = "Vendor Added Successfully";
                return request()->json(200, $data);
            }
        }
    }

    //Update
    public function update_vendor(Request $request)
    {

        $Emp_id = employee_id();


        $update_date = long_date();
        $edvendor_name = $request->get('edvendor_name');
        $edv_phone = $request->get('edv_phone');
        $edv_email = $request->get('edv_email');
        $edv_mobile = $request->get('edv_mobile');
        $edv_website = $request->get('edv_website');
        $edv_address = $request->get('edv_address');
        $edc_type = $request->get('edc_type');
        $vendor_id = $request->get('vendor_id');

        // $data="Vendor updated!";
        //   return request()->json(200,$data);

        DB::connection('sqlsrv3')->update('update Vendor set CompanyName=?, Email=?, weblink=?, Mobile=?, Phone=?, type=?, UpdatedBy=?, UpdatedOn=?, Address=? where ID=?', [$edvendor_name, $edv_email, $edv_website, $edv_mobile, $edv_phone, $edc_type, username(), $update_date, $edv_address, $vendor_id]);
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Vendor Information Updated', 'Vendor Name | ' . $edvendor_name . ' Information | has been updated ', $update_date]);
        $data = "Vendor updated!";
        return request()->json(200, $data);
    }

    public function fetch_product_category()
    {

        $find_config = DB::connection('sqlsrv3')->table("ItemCategory")->where('CompanyID', '=', company_id())->orderby('CategoryName', 'asc')->paginate(10);
        return request()->json(200, $find_config);
    }

    public function submit_category(Request $request)
    {

        $Emp_id = employee_id();

        $category_name = $request->get('cateogory_name');
        $Description = $request->get('Description');
        $c_type = $request->get('c_type');
        $shortcode = $request->get('shortcode');
        $category_status = $request->get('category_status');
        $opeining_date = $request->get('opeining_date');
        $closing_date = $request->get('closing_date');


        $update_date = long_date();
        $is_cat_exist = DB::connection('sqlsrv3')->table("ItemCategory")->where('CompanyID', '=', company_id())->where('CategoryName', '=', $category_name)->where('CategoryType', '=', $c_type)->exists();
        if ($is_cat_exist) {
            $find_config = "Already exist";
            return request()->json(200, $find_config);
        }


        $result = DB::connection('sqlsrv3')->insert('INSERT INTO ItemCategory(CompanyID,CategoryName,Description,Status,CreatedBy,CreatedOn,CategoryType,ShortCode,OpeningDate,ClosingDate) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $category_name, $Description, $category_status, username(), $update_date, $c_type, $shortcode, $opeining_date, $closing_date]);


        //if($c_type=='Goods'){
        // $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountHead','=','Inventory')->exists();
        // if($find_last_head_code9){
        //   $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountHead','=','Inventory')->get();
        //      foreach ($find_last_head_code as $find_last_head_code1) {
        //
        //      }
        //      $account_code=$find_last_head_code1->ID +1;


        //          $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountName','=','Inventory')->get();
        //      foreach($find_head_name as $find_head_name1){

        //      }
        // }
        //      else {
        //       $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountName','=','Inventory')->get();
        // foreach($find_head_name as $find_head_name1){

        // }
        //       $account_code=$find_head_name1->ID.'001';

        //      }

        //return request()->json(200,$account_code);
        // $result=  DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(),$category_name,'Assets',$find_head_name1->ID,$find_head_name1->AccountName,'Node']);
        //}


        //       if($c_type=='Assets'){
        //          $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountHead','=','Assets Equipments')->exists();
        //      if($find_last_head_code9){
        //        $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountHead','=','Assets Equipments')->get();
        //     foreach ($find_last_head_code as $find_last_head_code1) {
        //
        //     }
        //     $account_code=$find_last_head_code1->ID +1;


        //     $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountName','=','Assets Equipments')->get();
        // foreach($find_head_name as $find_head_name1){

        // }
        //      }
        //      else {
        //       $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountName','=','Assets Equipments')->get();
        //         foreach($find_head_name as $find_head_name1){

        //         }
        //           $account_code=$find_head_name1->ID.'001';

        //          }


        //         $result=  DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(),$category_name,'Assets',$find_head_name1->ID,$find_head_name1->AccountName,'Node']);
        //       }


        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Products Category Created', 'Product Category ' . $category_name . ' | of Category Type | ' . $c_type . ' | having short code | ' . $shortcode . ' | has been created ', $update_date]);


        $find_config = DB::connection('sqlsrv3')->table("ItemCategory")->where('CompanyID', '=', company_id())->orderby('CategoryName', 'asc')->paginate(10);
        return request()->json(200, $find_config);
    }

    public function category_detail($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("ItemCategory")->where('CompanyID', '=', company_id())->where('CategoryType', '=', $id)->orderby('CategoryName', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public function submit_product(Request $request)
    {


        $Emp_id = employee_id();
        $productName = $request->get('productName');
        $consumable = $request->get('consumable');
        $purhcased = $request->get('purhcased');
        $sold = $request->get('sold');
        $product_type = $request->get('product_type');
        $purchase_cost = $request->get('purchase_cost');
        $partnumber = $request->get('partnumber');
        $sale_value = $request->get('sale_value');
        $category = $request->get('category');
        $unit = $request->get('unit');
        $p_account_idname = $request->get('p_account_idname');
        $prod_dept = $request->get('prod_dept');
        $ItemNumber = '1';


        $update_date = long_date();

        $find_short = DB::connection('sqlsrv3')->table("ItemCategory")->where('ID', '=', $category)->where('CompanyID', '=', company_id())->get();
        foreach ($find_short as $find_short1) {
        }
        $find_pre = DB::table("tb_create_company")->where('company_id', '=', company_id())->get();
        foreach ($find_pre as $find_pre1) {
        }
        $itemexist = DB::connection('sqlsrv3')->table("ItemList")->where('CompanyID', '=', company_id())->exists();
        if ($itemexist) {
            $itemexist8 = DB::connection('sqlsrv3')->table("ItemList")->where('CompanyID', '=', company_id())->get();
            foreach ($itemexist8 as $itemexist81) {

            }
            $old_pre = $itemexist81->ItemCode;
            $itemcode = explode("-", $old_pre);
            $newitemcode = $itemcode[2] + 1;

            $product_code = $find_pre1->company_prefix . '-' . $find_short1->ShortCode . '-' . $newitemcode;
        } else {
            $product_code = $find_pre1->company_prefix . '-' . $find_short1->ShortCode . '-1';
        }


        $exist = DB::connection('sqlsrv3')->table("ItemList")->where('Name', '=', $productName)->where('CompanyID', '=', company_id())->exists();
        if ($exist) {
            $message = "Product exist";
            return request()->json(200, $message);
        } else {


            $result = DB::connection('sqlsrv3')->insert('INSERT INTO ItemList(CompanyID,PartNumber,LinkedDept, Name,ItemCategory,Sold,Purchase,Consumed,ItemType,SaleCost,PurchaseCost,Status,CreatedBy,CreatedOn, unit,ItemCode) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $partnumber, $prod_dept, $productName, $category, $sold, $purhcased, $consumable, $product_type, $sale_value, $purchase_cost, 'Active', username(), $update_date, $unit, $product_code]);
            $p_account = explode("_", $p_account_idname);
            if ($result) {
                if ($product_type == 'Goods') {


                    $ven = DB::connection('sqlsrv3')->table('ItemList')->where('CompanyID', '=', company_id())->where('ItemType', '=', 'Goods')->where('Name', '=', $productName)->get();
                    foreach ($ven as $ven1) {

                    }

                    DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,FaceValue) values (?,?,?,?,?,?)', [company_id(), $ven1->ID, 0, $unit, 0, $purchase_cost]);

                    DB::connection('sqlsrv3')->insert('INSERT INTO ItemLinkCoa(CompanyID,ItemId,Name,CoaID,CoaName) values (?,?,?,?,?)', [company_id(), $ven1->ID, $ven1->Name, $p_account[0], $p_account[1]]);


                    // $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountHead','=',$get_cate_1->CategoryName)->exists();
                    //      if($find_last_head_code9){
                    //        $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountHead','=',$get_cate_1->CategoryName)->get();
                    //     foreach ($find_last_head_code as $find_last_head_code1) {
                    //
                    //     }
                    //     $account_code=$find_last_head_code1->ID +1;


                    //     $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountName','=',$get_cate_1->CategoryName)->get();
                    // foreach($find_head_name as $find_head_name1){

                    // }
                    //      }
                    //      else {
                    //       $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountName','=',$get_cate_1->CategoryName)->get();
                    // foreach($find_head_name as $find_head_name1){

                    // }
                    //       $account_code=$find_head_name1->ID.'0001';
                    //       //return request()->json(200,$account_code);
                    //      }


                    // $result=  DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(),$productName,'Assets',$find_head_name1->ID,$find_head_name1->AccountName,'Transaction']);
                } elseif ($product_type == 'Assets') {


                    $ven = DB::connection('sqlsrv3')->table('ItemList')->where('CompanyID', '=', company_id())->where('ItemType', '=', 'Assets')->where('Name', '=', $productName)->get();
                    foreach ($ven as $ven1) {

                    }


                    DB::connection('sqlsrv3')->insert('INSERT INTO AssetsLinkCoa(CompanyID,AssetId,Name,CoaID,CoaName) values (?,?,?,?,?)', [company_id(), $ven1->ID, $ven1->Name, $p_account[0], $p_account[1]]);

                    //   $get_cate_=DB::connection('sqlsrv3')->table('ItemCategory')->where('CompanyID','=', company_id())->where('ID','=',$category)->get();
                    // foreach ($get_cate_ as $get_cate_1) {
                    //
                    // }
                    // $ven=DB::connection('sqlsrv3')->table('ItemList')->where('CompanyID','=', company_id())->get();
                    // foreach ($ven as $ven1) {
                    //
                    // }


                    // $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountHead','=',$get_cate_1->CategoryName)->exists();
                    //      if($find_last_head_code9){
                    //        $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountHead','=',$get_cate_1->CategoryName)->get();
                    //     foreach ($find_last_head_code as $find_last_head_code1) {
                    //
                    //     }
                    //     $account_code=$find_last_head_code1->ID +1;


                    //     $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountName','=',$get_cate_1->CategoryName)->get();
                    // foreach($find_head_name as $find_head_name1){

                    // }
                    //      }
                    //      else {
                    //       $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=','Assets')->where('AccountName','=',$get_cate_1->CategoryName)->get();
                    // foreach($find_head_name as $find_head_name1){

                    // }
                    //       $account_code=$find_head_name1->ID.'0001';
                    //       //return request()->json(200,$account_code);
                    //      }


                    // $result=  DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(),$productName,'Assets',$find_head_name1->ID,$find_head_name1->AccountName,'Transaction']);

                }
            }
            $find_config = DB::connection('sqlsrv3')->table("ItemList")->Join('ItemCategory', 'ItemList.ItemCategory', '=', 'ItemCategory.ID')->where('ItemList.CompanyID', '=', company_id())->orderby('ItemList.Name', 'desc')->select('ItemList.*', 'ItemCategory.CategoryName')->paginate(20);
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Product Created', 'Product ' . $product_code . ' | Linked to Account | ' . $p_account_idname . ' | Product Department | ' . $prod_dept . ' | Product Type | ' . $product_type . ' | Purchase Cost ' . $purchase_cost . ' | Sale Cost ' . $sale_value . '  Created', $update_date]);
            return request()->json(200, $find_config);
        }
    }

    /*
  public function fetch_product_detail(Request $request)
  {

    $find_config = DB::connection('sqlsrv3')->table("ItemList")->join('ItemCategory', 'ItemList.ItemCategory', '=', 'ItemCategory.ID')->where('ItemList.CompanyID', '=', company_id())->orderby('ItemList.ID', 'desc')->select('ItemList.*', 'ItemCategory.CategoryName')->paginate(20);
    return request()->json(200, $find_config);
  }
  */
    public function get_dept()
    {

        $find_config = DB::connection('sqlsrv3')->table("ChildCompany")->where('CompanyID', '=', company_id())->orderby('Type', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public function get_items($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('ItemId as ID', 'Name')->where('CompanyID', '=', company_id())->orderby('Name', 'asc')->whereNotNull('CoaID')->get();
        return request()->json(200, $find_config);
    }

    public function get_itemsassets($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("AssetsLinkCoa")->select('AssetId as ID', 'Name')->where('CompanyID', '=', company_id())->orderby('Name', 'asc')->whereNotNull('CoaID')->get();
        return request()->json(200, $find_config);
    }

    public function get_itemss()
    {

        $find_config = DB::connection('sqlsrv3')->table("ItemList")->select('ID', 'Name')->where('CompanyID', '=', company_id())->orderby('Name', 'asc')->where('Status', 'Active')->where('ItemType', 'Goods')->get();
        return request()->json(200, $find_config);
    }

    public function get_units()
    {

        $find_config = DB::connection('sqlsrv3')->table("Unit")->select('UnitName')->where('CompanyID', '=', company_id())->orderby('UnitName', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public function get_projects($child)
    {

        $find_config = DB::connection('sqlsrv3')->table("CompanyProjects")->select('ProjectName')->where('CompanyID', '=', company_id())->where('ChildID', $child)->get();
        return request()->json(200, $find_config);
    }

    public function insert_requisition(InsertRequisitionForm $request)
    {
        DB::connection('sqlsrv3')->transaction(function () use ($request) {
            $rid = generateNextId("DemandRequisition", "RId");
            $final_rid = 'DR_' . $this->shiftformat() . '-' . $rid;
            // Lock the DemandRequisition table before insert
            DB::connection('sqlsrv3')->table('DemandRequisition')->lockForUpdate()->get();
            $demandReqID = DB::connection('sqlsrv3')->table('DemandRequisition')->insertGetId([
                'CompanyID' => company_id(),
                'RId' => $final_rid,
                'Dated' => $request->date,
                'DepartmentName' => $request->dept_name,
                'ProjectName' => $request->project_name,
                'Status' => 'Pending',
                'Narration' => $request->narration,
                'CreatedBy' => username(),
                'CreatedOn' => long_date(),
                'Session' => ac_c_session(),
                'RequisitionType' => $request->status,
                'Status2' => ($request->status == 'Services') ? 'Not Completed' : NULL,
            ]);
            $items = [];
            foreach ($request->allItems as $item) {
                $item['ReqID'] = $demandReqID;
                $item['PStatus'] = 0;
                unset($item['errors']);
                unset($item['codes']);
                $items[] = $item;
            }
            DB::connection('sqlsrv3')->table('DemandRequisitionItem')->insert($items);
            $req_prefix = acc_config()->Requisition . '_' . $this->shiftformat();
            $rid = generateNextId("Requisition", "RId");
            $final_rido = $req_prefix . '-' . $rid;
            // Lock the Requisition table before insert
            DB::connection('sqlsrv3')->table('Requisition')->lockForUpdate()->get();
            if ($request->status == 'Goods' && count(get_remaining_items($items)) > 0) {
                $reqID = insertRecord('Requisition', $final_rido, $rid, $request, $request->status, $rId = 'RId', $demandReqID);
                $reqItems = [];
                foreach (get_remaining_items($items) as $ItemDetail1) {
                    $reqItems[] = [
                        'ReqID' => $reqID,
                        'itemId' => $ItemDetail1->itemId,
                        'ItemName' => $ItemDetail1->ItemName,
                        'Quantity' => $ItemDetail1->Quantity,
                        'unit' => $ItemDetail1->unit,
                        'EstCost' => $ItemDetail1->EstCost,
                        'Detail' => $ItemDetail1->Detail
                    ];
                }
                DB::connection('sqlsrv3')->table('RequisitionItem')->insert($reqItems);
                DB::connection('sqlsrv3')->table('DemandRequisitionItem')->where('ReqId', $demandReqID)->whereIn('itemId', array_column($reqItems, 'itemId'))->update(['PStatus' => '1']);
            } else {
                $reqID = insertRecord('Requisition', $final_rido, $rid, $request, $request->status, $rId = 'RId', $demandReqID);
                $drItems = [];
//                $request->status != 'Services' ? array_shift($items) : $items; // Remove the first element from the array
                foreach ($items as $item) {
                    $drItems[] = [
                        'ReqID' => $reqID,
                        'itemId' => $request->status == 'Services' ? NULL : $item['itemId'],
                        'ItemName' => $request->status == 'Services' ? NULL : $item['ItemName'],
                        'Quantity' => $item['Quantity'],
                        'unit' => $request->status == 'Services' ? NULL : $item['unit'],
                        'EstCost' => $request->status == 'Services' ? NULL : $item['EstCost'],
                        'Detail' => $item['Detail']
                    ];
                }
                DB::connection('sqlsrv3')->table('RequisitionItem')->insert($drItems);
                $query = DB::connection('sqlsrv3')->table('DemandRequisitionItem')->where('ReqId', $demandReqID);
                if ($request->status != 'Services') {
                    $query->whereIn('itemId', array_column($drItems, 'itemId'));
                }
                $query->update(['PStatus' => '1']);
            }
            insertLog('New Demand Requisition posted', 'Demand Requsiition | ' . $final_rido . ' | aginst Department | ' . $request->dept_name . ' | Project Name | ' . $request->project_name . ' | Status Pending Posted');
        });
        return $this->sendSuccess("Requisition created successfully");
    }

    public function inventory_receipt_report($start_date, $end_date, $dept, $proj)
    {
        if ($dept == 'All') {
            $dept = '';
        }
        if ($proj == 'All') {
            $proj = '';
        }
        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[Material_ReceivedAND_Issuance_Report]
        @datefrom = N'" . $start_date . "',
        @dateto = N'" . $end_date . "',
        @department = N'" . $dept . "',
        @project = N'" . $proj . "'
        ");
        return request()->json(200, $result);
    }

    public function issuance_receipt($id, $name)
    {

        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[Issuance_Report_Itemwise]
  @ItemId = " . $name . ",
  @reqid = " . $id . "
  ");
        return request()->json(200, $result);

    }

    public function received_receipt($id, $name)
    {

        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[Material_ReceivedReport_Itemwise]
  @ItemID = " . $name . ",
  @reqid = " . $id . "
  ");
        return request()->json(200, $result);

    }

    public function accounts_catagory_byname(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('ItemCategory')->orderBy('ID', 'desc')->where('CompanyID', '=', company_id())->where('CategoryName', 'like', '%' . $request->name . '%')->paginate(20);
        return request()->json(200, $arr);
    }

    public function accounts_products_byname(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('ItemList')->join('ItemCategory', 'ItemList.ItemCategory', '=', 'ItemCategory.ID')->orderBy('ItemList.ID', 'asc')->where('ItemList.CompanyID', '=', company_id())->where('ItemList.Name', 'like', '%' . $request->name . '%')->select('ItemList.*', 'ItemCategory.CategoryName')->paginate(20);
        return request()->json(200, $arr);
    }

    //Update catagory
    public function accounts_update_catagory(Request $request)
    {
        $update_date = long_date();
        $ed_catid = $request->get('ed_catid');
        $ed_catName = $request->get('ed_catName');
        $ed_catDescription = $request->get('ed_catDescription');
        DB::connection('sqlsrv3')->update('update ItemCategory set CategoryName=?, Description=?, UpdatedBy=?, UpdatedOn=? where ID=? AND CompanyID=?', [$ed_catName, $ed_catDescription, username(), $update_date, $ed_catid, company_id()]);
        $data = "Catagory updated!";
        return request()->json(200, $data);
    }

    //Update catagory status
    public function accounts_update_catSts(Request $request)
    {
        $update_date = long_date();
        $ed_catid = $request->get('ed_catid');
        $status = $request->get('status');
        DB::connection('sqlsrv3')->update('update ItemCategory set Status=? where ID=? AND CompanyID=?', [$status, $ed_catid, company_id()]);
        $data = "Status updated!";
        return request()->json(200, $data);
    }

    //Update product status
    public function accounts_update_proSts(Request $request)
    {
        $Emp_id = employee_id();
        $update_date = long_date();
        $ed_proid = $request->get('ed_proid');
        $status = $request->get('status');
        DB::connection('sqlsrv3')->update('update ItemList set Status=? where ID=? AND CompanyID=?', [$status, $ed_proid, company_id()]);
        $req1 = DB::connection('sqlsrv3')->table('ItemList')->select('ItemList.*')->where('ID', '=', $ed_proid)->first();
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Inventory Product Status Updated', 'Product With Product Code | ' . $req1->ItemCode . ' | Name | ' . $req1->Name . ' | Type | ' . $req1->ItemType . ' | Unit | ' . $req1->unit . ' | Linked To Department | ' . $req1->LinkedDept . ' | Purchase Cost | ' . number_format($req1->PurchaseCost) . ' | Selling Cost | ' . number_format($req1->SaleCost) . '| Status has been Updated to | ' . $status . ' ', $update_date]);
        $data = "Status updated!";
        return request()->json(200, $data);
    }

    public function accounts_update_product(Request $request)
    {

        $Emp_id = employee_id();


        $update_date = long_date();
        $ed_productid = $request->get('ed_productid');
        $e_productName = $request->get('e_productName');
        $e_purhcased = $request->get('e_purhcased');
        $e_sold = $request->get('e_sold');
        $e_consumable = $request->get('e_consumable');
        $e_product_type = $request->get('e_product_type');
        $e_purchase_cost = $request->get('e_purchase_cost');
        $e_partnumber = $request->get('e_partnumber');
        $e_sale_value = $request->get('e_sale_value');
        $category = $request->get('category');
        $ed_unit = $request->get('ed_unit');
        $e_prod_dept = $request->get('e_prod_dept');
        $exist = DB::connection('sqlsrv3')->table("ItemList")->where('Name', '=', $e_productName)->where('ID', '!=', $ed_productid)->where('CompanyID', '=', company_id())->exists();
        if ($exist) {
            $message = "Product exist";
            return request()->json(200, $message);
        } else {
            DB::connection('sqlsrv3')->update('update ItemList set Name=?, LinkedDept=?, Purchase=?, Sold=?, Consumed=?, ItemType=?, PurchaseCost=?, PartNumber=?, SaleCost=?, ItemCategory=?, unit=? where ID=? AND CompanyID=?', [$e_productName, $e_prod_dept, $e_purhcased, $e_sold, $e_consumable, $e_product_type, $e_purchase_cost, $e_partnumber, $e_sale_value, $category, $ed_unit, $ed_productid, company_id()]);
            if ($e_product_type == 'Goods') {

                DB::connection('sqlsrv3')->update('update ItemLinkCoa set Name=? where CompanyID=? AND ItemId=?', [$e_productName, company_id(), $ed_productid]);
            } elseif ($e_product_type == 'Assets') {
                DB::connection('sqlsrv3')->update('update AssetsLinkCoa set Name=? where CompanyID=? AND AssetId=?', [$e_productName, company_id(), $ed_productid]);
            }
            $message = "Product updated!";
        }

        $req = DB::connection('sqlsrv3')->table('ItemList')->select('ItemList.*')->where('ID', '=', $ed_productid)->get();
        foreach ($req as $req1) {

        }
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Inventory Product Updated', 'Product With Product Code | ' . $req1->ItemCode . ' | Name | ' . $e_productName . ' | Type | ' . $e_product_type . ' | Unit | ' . $ed_unit . ' | Linked To Department | ' . $e_prod_dept . ' | Purchase Cost | ' . number_format($e_purchase_cost) . ' | Selling Cost | ' . number_format($e_sale_value) . ' has been Updated ', $update_date]);

        return request()->json(200, $message);
    }

    //fetch catagory to edit
    public function fetch_catagory($id)
    {

        $cand = DB::connection('sqlsrv3')->table('ItemCategory')->where('CompanyID', '=', company_id())->where('ID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public function fetch_product($id)
    {

        $cand = DB::connection('sqlsrv3')->table('ItemList')
            ->join('ItemCategory', 'ItemList.ItemCategory', '=', 'ItemCategory.ID')
            ->select('ItemList.*', 'ItemCategory.CategoryName')
            ->where('ItemList.CompanyID', '=', company_id())->where('ItemList.ID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public function get_req_data($id)
    {

        $cand = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public function get_req_data3($id)
    {

        $data = explode("_", $id);
        $rid = $data[0];
        $cand = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $rid)->get();
        return request()->json(200, $cand);
    }

    public function get_req_data1($id)
    {

        $cand = DB::connection('sqlsrv3')->table('RequisitionItem')->where('ReqID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public function get_no_data($id, $no)
    {

        $detail = DB::connection('sqlsrv3')->table('PQuotation')->join('PurchaseOrder', 'PQuotation.RequisitionID', '=', 'PurchaseOrder.AgainstReq')->select('PurchaseOrder.PoCode', 'PurchaseOrder.PurchaseOrderID')->where('PQuotation.CompanyID', '=', company_id())->where('PQuotation.RequisitionID', '=', $id)->where('PQuotation.QuotationNumber', '=', $no)->get();
        return request()->json(200, $detail);
    }

    public function update_requisition(Request $request)
    {


        $item_name = $request->get('item_name');
        $unit = $request->get('unit');
        $est_cost = $request->get('est_cost');
        $qty = $request->get('qty');

        $detail = $request->get('detail');

        $e_rid = $request->get('e_rid');
        $id = $request->get('id');
        $date = $request->get('date');
        $dept_name = $request->get('dept_name');
        $project_name = $request->get('project_name');
        $narration = $request->get('narration');
        $req_type = $request->get('req_type');
        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $item_nam = explode("|", $item_name);
            $qt = explode("|", $qty);
            $uni = explode("|", $unit);
            $est_cos = explode("|", $est_cost);
            if ($item_nam[$x] == '' || $qt[$x] == '' || $est_cos[$x] == '' || $uni[$x] == '') {
                $message = 'Empty field';
                return request()->json(200, $message);
            }
        }


        $update_date = long_date();

        $result = DB::connection('sqlsrv3')->update('update  Requisition set Dated=?, DepartmentName=?, ProjectName=?, Narration=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and RequisitionId=?', [$date, $dept_name, $project_name, $narration, username(), $update_date, company_id(), $id]);


        if ($result) {
            DB::connection('sqlsrv3')->table('RequisitionItem')->where('ReqID', $id)->delete();


            $item_name1 = explode("|", $item_name);
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $qt = explode("|", $qty);
                $uni = explode("|", $unit);
                $est_cos = explode("|", $est_cost);
                $detai = explode("|", $detail);
                if ($req_type == 'Goods' || $req_type == 'Assets') {
                    $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'unit')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                    foreach ($find_itemname as $find_itemname1) {

                    }

                    $result5 = DB::connection('sqlsrv3')->insert('INSERT INTO RequisitionItem(ReqID,itemId,ItemName,Quantity,unit,EstCost,Detail) values (?,?,?,?,?,?,?)', [$id, $item_nam[$x], $find_itemname1->Name, $qt[$x], $find_itemname1->unit, $est_cos[$x], $detai[$x]]);
                } elseif ($req_type == 'Services') {

                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO RequisitionItem(ReqID,Quantity,unit,EstCost,Detail) values (?,?,?,?,?)', [$id, $qt[$x], 'NOS', $est_cos[$x], $detai[$x]]);
                }
            }
        }

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', company_id())->where('Session', $session)->orderby('RequisitionId', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public function accounts_vendor_byname(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('Vendor')->orderBy('ID', 'asc')->where('CompanyID', '=', company_id())->where('CompanyName', 'like', '%' . $request->name . '%')->paginate(20);
        return request()->json(200, $arr);
    }

    //Update vendor status
    public function accounts_update_venSts(Request $request)
    {

        $Emp_id = employee_id();


        $update_date = long_date();
        $ed_venid = $request->get('ed_venid');
        $status = $request->get('status');
        DB::connection('sqlsrv3')->update('update Vendor set Status=? where ID=? AND CompanyID=?', [$status, $ed_venid, company_id()]);

        $req = DB::connection('sqlsrv3')->table("Vendor")->select('Vendor.*')->where('ID', '=', $ed_venid)->where('CompanyID', '=', company_id())->get();
        foreach ($req as $req1) {

        }
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Vendor Status Updated', 'Vendor ' . $req1->CompanyName . ' | status updated to | ' . $status . ' ', $update_date]);
        $data = "Status updated!";
        return request()->json(200, $data);
    }

    public function taxes_detail()
    {

        $find_config = DB::connection('sqlsrv3')->table("Taxes")->where('CompanyID', '=', company_id())->orderby('TaxID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public function submit_tax(Request $request)
    {


        $Emp_id = employee_id();
        $tax_name = $request->get('tax_name');
        $tax_type = $request->get('tax_type');
        $tax_computation = $request->get('tax_computation');
        $tax_amount = $request->get('tax_amount');
        $tax_status = $request->get('tax_status');


        $update_date = long_date();
        $isTax = DB::connection("sqlsrv3")->table("Taxes")->where("TaxName", "=", $tax_name)->where("TaxType", "=", $tax_type)->exists();
        if ($isTax) {
            $find_config = "this tax already exists";
            return request()->json(401, $find_config);
        }
        $result = DB::connection('sqlsrv3')->insert('INSERT INTO Taxes(CompanyID,TaxName, TaxType, TaxAmount, TaxComputation,Status,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?)', [company_id(), $tax_name, $tax_type, $tax_amount, $tax_computation, $tax_status, username(), $update_date]);
        //          if($result){
        //             if($tax_type=='Sales'){
        //               $top_head='Sales Tax';
        //               $type='Liabilities';
        //             }
        //             else if($tax_type=='Purchase') {
        //               $top_head='Purchase Tax Payable';
        //               $type='Liabilities';
        //             }
        //            $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=',$type)->where('AccountHead','=',$top_head)->exists();
        //      if($find_last_head_code9){
        //        $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=',$type)->where('AccountHead','=',$top_head)->get();
        //     foreach ($find_last_head_code as $find_last_head_code1) {
        //
        //     }
        //     $account_code=$find_last_head_code1->ID+1;


        //     $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=',$type)->where('AccountName','=',$top_head)->get();
        // foreach($find_head_name as $find_head_name1){

        // }
        //      }
        //      else {
        //       $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=',$type)->where('AccountName','=',$top_head)->get();
        // foreach($find_head_name as $find_head_name1){

        // }
        //       $account_code=$find_head_name1->ID.'001';
        //       //return request()->json(200,$account_code);
        //      }


        //         $result=  DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(),$tax_name,$type,$find_head_name1->ID,$find_head_name1->AccountName,'Transaction']);


        //          }
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Tax Head Created', ' New Tax ' . $tax_name . ' | has been created | having tax Amount | ' . $tax_amount . ' | Status ' . $tax_status . '', $update_date]);
        $find_config = 'Tax added successfully';
        //$find_config = DB::connection('sqlsrv3')->table("Taxes")->where('CompanyID','=', company_id())->orderby('TaxID','desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public function accounts_update_taxes_status(Request $request)
    {


        $Emp_id = employee_id();


        $update_date = long_date();
        $ed_venid = $request->get('id');
        $status = $request->get('status');
        DB::connection('sqlsrv3')->update('update Taxes set Status=? where TaxID=? AND CompanyID=?', [$status, $ed_venid, company_id()]);
        $req = DB::connection('sqlsrv3')->table("Taxes")->select('Taxes.*')->where('TaxID', '=', $ed_venid)->get();
        foreach ($req as $req1) {

        }
        if ($req1->Status == 0) {

            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Tax Status Updated', 'Tax Status for | ' . $req1->TaxName . ' | of Tax Type | ' . $req1->TaxType . ' | Tax Amount | ' . $req1->TaxAmount . ' | Tax Computation | ' . $req1->TaxComputation . ' | has been Set To Disabled', $update_date]);

            $data = "Status updated!";
            return request()->json(200, $data);
        } else {
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Tax Status Updated', 'Tax Status for | ' . $req1->TaxName . ' | of Tax Type | ' . $req1->TaxType . ' | Tax Amount | ' . $req1->TaxAmount . ' | Tax Computation | ' . $req1->TaxComputation . ' | has been Set To Active', $update_date]);

            $data = "Status updated!";
            return request()->json(200, $data);
        }

    }

    public function filter_tax(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('Taxes')->orderby('TaxID', 'desc')->where('CompanyID', '=', company_id())->where('TaxName', 'like', '%' . $request->name . '%')->paginate(20);
        return request()->json(200, $arr);
    }

    public function filter_bank(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('Banks')->orderby('BankID', 'desc')->where('CompanyID', '=', company_id())->where('AccountTitle', 'like', '%' . $request->name . '%')->paginate(20);
        return request()->json(200, $arr);
    }

    public function delivery_detail()
    {

        $find_config = DB::connection('sqlsrv3')->table("Delivery")->where('CompanyID', '=', company_id())->orderby('DID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public function submit_delivery(Request $request)
    {

        $tax_name = $request->get('tax_name');
        $tax_type = $request->get('tax_type');

        $Emp_id = employee_id();
        $tax_computation = $request->get('tax_computation');
        $tax_amount = $request->get('tax_amount');
        $tax_status = $request->get('tax_status');


        $update_date = long_date();
        $isDelivery = DB::connection('sqlsrv3')->table("Delivery")->where('CompanyID', '=', company_id())->where("DeliveryName", "=", $tax_name)->where("DType", "=", $tax_type)->exists();
        if ($isDelivery) {
            $data = "Delivery tax already exists";
            return request()->json(401, $data);
        }
        $result = DB::connection('sqlsrv3')->insert('INSERT INTO Delivery(CompanyID,DeliveryName, DType, DAmount, DComputation,Status,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?)', [company_id(), $tax_name, $tax_type, $tax_amount, $tax_computation, $tax_status, username(), $update_date]);
        //          if($result){
        //           if($tax_type=='Sales'){
        //               $top_head='Sales Delivery Receivable';
        //               $type='Assets';
        //             }
        //             else if($tax_type=='Purchase') {
        //               $top_head='Delivery Payable';
        //               $type='Liabilities';
        //             }
        //            $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=',$type)->where('AccountHead','=',$top_head)->exists();
        //      if($find_last_head_code9){
        //        $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=',$type)->where('AccountHead','=',$top_head)->get();
        //     foreach ($find_last_head_code as $find_last_head_code1) {
        //
        //     }
        //     $account_code=$find_last_head_code1->ID+1;


        //     $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=',$type)->where('AccountName','=',$top_head)->get();
        // foreach($find_head_name as $find_head_name1){

        // }
        //      }
        //      else {
        //       $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID','=', company_id())->where('AccountType','=',$type)->where('AccountName','=',$top_head)->get();
        // foreach($find_head_name as $find_head_name1){

        // }
        //       $account_code=$find_head_name1->ID.'001';
        //       //return request()->json(200,$account_code);
        //      }
        //         $result=  DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(),$tax_name,$type,$find_head_name1->ID,$find_head_name1->AccountName,'Transaction']);

        //          }
        // $find_config = DB::connection('sqlsrv3')->table("Delivery")->where('CompanyID','=', company_id())->orderby('DID','desc')->paginate(20);
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Delivery Head Created', 'New Delivery Head | ' . $tax_name . ' | has been created | having tax Amount | ' . $tax_amount . ' | Status ' . $tax_status . '  ', $update_date]);
        $find_config = 'Tax added successfully';
        return request()->json(200, $find_config);
    }

    public function filter_delivery(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('Delivery')->orderby('DID', 'desc')->where('CompanyID', '=', company_id())->where('DeliveryName', 'like', '%' . $request->name . '%')->paginate(20);
        return request()->json(200, $arr);
    }

    public function accounts_update_delivery_status(Request $request)
    {


        $update_date = long_date();

        $Emp_id = employee_id();
        $ed_venid = $request->get('id');
        $status = $request->get('status');
        DB::connection('sqlsrv3')->update('update Delivery set Status=? where DID=? AND CompanyID=?', [$status, $ed_venid, company_id()]);
        $req = DB::connection('sqlsrv3')->table("Delivery")->select('Delivery.*')->where('DID', '=', $ed_venid)->get();
        foreach ($req as $req1) {

        }
        if ($req1->Status == 0) {
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Updated Delivery Status', 'Delivery Status for | ' . $req1->DeliveryName . ' | of Delivery Type | ' . $req1->DType . ' | Delivery Amount | ' . $req1->DAmount . ' | Delivery Computation | ' . $req1->DComputation . ' | has been Set To Disabled', $update_date]);
            $data = "Status updated!";
            return request()->json(200, $data);
        } else {
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Updated Delivery Status', 'Delivery Status for | ' . $req1->DeliveryName . ' | of Delivery Type | ' . $req1->DType . ' | Delivery Amount | ' . $req1->DAmount . ' | Delivery Computation | ' . $req1->DComputation . ' | has been Set To Active', $update_date]);
            $data = "Status updated!";
            return request()->json(200, $data);
        }
    }

    public function accounts_update_bank_status(Request $request)
    {

        $Emp_id = employee_id();


        $update_date = long_date();
        $ed_venid = $request->get('id');
        $status = $request->get('status');
        $result = DB::connection('sqlsrv3')->update('update Banks set Status=? where BankID=? AND CompanyID=?', [$status, $ed_venid, company_id()]);
        if ($result) {
            $req = DB::connection('sqlsrv3')->table("Banks")->select('BankName')->where('BankID', '=', $ed_venid)->get();
            foreach ($req as $req1) {

            }
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Bank Status Updated', 'status of Bank Name | ' . $req1->BankName . ' | Updated to | ' . $status . ' | Bank ID | ' . $ed_venid . ' ', $update_date]);
            $data = "Status updated!";
            return request()->json(200, $data);
        }
    }

    public function get_vendor()
    {

        $arr = DB::connection('sqlsrv3')->table('Vendor')->orderby('CompanyName', 'asc')->select('ID', 'CompanyName')->where('CompanyID', '=', company_id())->where('Status', '=', 'Active')->get();
        return request()->json(200, $arr);
    }

    public function get_vendor_detail($id)
    {

        $arr = DB::connection('sqlsrv3')->table('Vendor')->where('CompanyID', '=', company_id())->where('ID', '=', $id)->get();
        return request()->json(200, $arr);
    }

    public function get_delivery()
    {

        $arr = DB::connection('sqlsrv3')->table('Delivery')->select('DID', 'DeliveryName')->where('DType', '=', 'Purchase')->where('CompanyID', '=', company_id())->where('Status', '=', 'true')->get();
        return request()->json(200, $arr);
    }

    public function get_delivery2()
    {

        $arr = DB::connection('sqlsrv3')->table('Delivery')->select('DID', 'DeliveryName')->where('DType', '=', 'Sales')->where('CompanyID', '=', company_id())->where('Status', '=', 'true')->get();
        return request()->json(200, $arr);
    }

    public function get_tax()
    {

        $arr = DB::connection('sqlsrv3')->table('Taxes')->select('TaxID', 'TaxName')->where('CompanyID', '=', company_id())->where('TaxType', '=', 'Purchase')->where('Status', '=', 'true')->get();
        return request()->json(200, $arr);
    }

    public function get_tax2()
    {

        $arr = DB::connection('sqlsrv3')->table('Taxes')->select('TaxID', 'TaxName')->where('CompanyID', '=', company_id())->where('TaxType', '=', 'Sales')->where('Status', '=', 'true')->get();
        return request()->json(200, $arr);
    }

    public function select_delivery_value($delivery_value, $subtotal)
    {

        $arr = DB::connection('sqlsrv3')->table('Delivery')->where('CompanyID', '=', company_id())->where('DID', '=', $delivery_value)->get();
        foreach ($arr as $arr1) {

        }
        if ($arr1->DComputation == 'Fixed') {
            $delivery_amount = $arr1->DAmount;
        } else {
            $delivery_amount = ($arr1->DAmount * $subtotal) / 100;
        }
        return request()->json(200, $delivery_amount);
    }

    public function select_tax_value($tax_value, $subtotal)
    {

        $arr = DB::connection('sqlsrv3')->table('Taxes')->where('CompanyID', '=', company_id())->where('TaxID', '=', $tax_value)->get();
        foreach ($arr as $arr1) {

        }
        if ($arr1->TaxComputation == 'Fixed') {
            $tax_amount = $arr1->TaxAmount;
        } else {
            $tax_amount = ($arr1->TaxAmount * $subtotal) / 100;
        }
        return request()->json(200, $tax_amount);
    }

    public function accounts_requisition_byDept(Request $request)
    {

        $dept = emp_department();
        $session = ac_c_session();
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            $find_config = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', company_id())->where('Session', $session)->where('DepartmentName', 'like', '%' . $request->dept . '%')->orderby('RequisitionId', 'desc')->paginate(20);
            return request()->json(200, $find_config);
        } else {
            $find_config = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', company_id())->where('DepartmentName', '=', $dept)->where('Session', $session)->orderby('RequisitionId', 'desc')->where('DepartmentName', 'like', '%' . $request->dept . '%')->paginate(20);
            return request()->json(200, $find_config);
        }
    }

    public function req_status_update(Request $request)
    {

        $req_id = $request->get('reqId');
        $req_sts = $request->get('sts');


        $update_date = long_date();
        DB::connection('sqlsrv3')->update('update Requisition set Status=?,ApprovedBy=?,ApprovedOn=? where CompanyID=? and RequisitionId=?', [$req_sts, username(), $update_date, company_id(), $req_id]);
        $message = "Status updated!";
        return request()->json(200, $message);
    }

    public function insert_pquotation(Request $request)
    {

        $id = employee_id();

        $session = ac_c_session();

        $rid = $request->get('rid');
        $qid = $request->get('qid');
        $date = $request->get('date');
        $narration = $request->get('narration');
        $vendor_n = $request->get('vendor_n');
        $subtotal = $request->get('subtotal');
        $discount = $request->get('discount');
        $tax_amount = $request->get('tax_amount');
        //
        $select_pmterm = $request->get('select_pmterm');
        $delivery_amount = $request->get('delivery_amount');
        $total = $request->get('total');
        $status = $request->get('status');
        $item_name = $request->get('item_name');
        $qty = $request->get('qty');
        $unit_cost = $request->get('unit_cost');
        $detail = $request->get('detail');
        $check_purchase = $request->get('check_purchase');
        $est_time = $request->get('est_time');
        $est_time1 = $request->get('est_time1');
        $currency = $request->get('currency');
        // $message=$check_purchase;
        //       return request()->json(200, $message);
        $item_name1 = explode("|", $item_name);
        $find_req_type = DB::connection('sqlsrv3')->table("Requisition")->select('RequisitionType', 'RId')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $rid)->get();
        foreach ($find_req_type as $find_req_type1) {
        }
        $req_type = $find_req_type1->RequisitionType;
        if ($req_type != 'Services') {
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $qt = explode("|", $qty);
                $est_cos = explode("|", $unit_cost);
                if ($item_nam[$x] == '' || $qt[$x] == '' || $est_cos[$x] == '') {
                    $message = 'Empty field';
                    return request()->json(200, $message);
                }
                $find_req_item_detail = DB::connection('sqlsrv3')->table("RequisitionItem")->where('ReqID', '=', $rid)->where('itemId', '=', $item_nam[$x])->orderby('RequisitionItemId', 'asc')->get();
                foreach ($find_req_item_detail as $find_req_item_detail1) {
                }
                if (intval($find_req_item_detail1->Quantity) < intval($qt[$x])) {
                    $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'unit')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                    foreach ($find_itemname as $find_itemname1) {

                    }
                    $message = 'Quotation quantity of ' . $find_itemname1->Name . ' at index ' . $x . ' is greatar than requisition quantity!';
                    return request()->json(200, $message);
                }
            }
        }
        if (str_contains($check_purchase, 'true')) {
            date_default_timezone_set("Asia/Karachi");
            $update_date = long_date();
            if ($request->hasFile('image_file')) {
                $file = $request->file('image_file');
                $name_image = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/images/quotation_images/', $name_image);
                $result9 = DB::connection('sqlsrv3')->insert('INSERT INTO PQuotation(CompanyID,VendorName,RequisitionID,QuotationNumber,QuotationDate,SubTotal,Discount,Tax,ShippingCharges,Total,Remarks,Status,CreatedBy,CreatedOn,Session, PaymentTerm, Photo ,Est_Completion_time,Est_Completion_time1, Currency ) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $vendor_n, $rid, $qid, $date, $subtotal, $discount, $tax_amount, $delivery_amount, $total, $narration, $status, username(), $update_date, $session, $select_pmterm, $name_image, $est_time, $est_time1, $currency]);
            } else {
                $result9 = DB::connection('sqlsrv3')->insert('INSERT INTO PQuotation(CompanyID,VendorName,RequisitionID,QuotationNumber,QuotationDate,SubTotal,Discount,Tax,ShippingCharges,Total,Remarks,Status,CreatedBy,CreatedOn,Session, PaymentTerm ,Est_Completion_time,Est_Completion_time1, Currency) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $vendor_n, $rid, $qid, $date, $subtotal, $discount, $tax_amount, $delivery_amount, $total, $narration, $status, username(), $update_date, $session, $select_pmterm, $est_time, $est_time1, $currency]);
            }
            if ($result9) {
                $find_reqid = DB::connection('sqlsrv3')->table("PQuotation")->select('QuotationID')->where('CompanyID', '=', company_id())->where('RequisitionID', '=', $rid)->where('QuotationNumber', '=', $qid)->get();
                foreach ($find_reqid as $find_reqid1) {
                }
                $item_name1 = explode("|", $item_name);
                for ($x = 1; $x < count($item_name1); $x++) {
                    $item_nam = explode("|", $item_name);
                    $qt = explode("|", $qty);
                    $detai = explode("|", $detail);
                    $est_cos = explode("|", $unit_cost);
                    $check_purchas = explode("|", $check_purchase);
                    $total9 = $qt[$x] * $est_cos[$x];
                    if ($check_purchas[$x] == 'true') {
                        if ($req_type == 'Goods' || $req_type == 'Assets') {
                            $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'unit')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                            foreach ($find_itemname as $find_itemname1) {

                            }
                            $result3 = DB::connection('sqlsrv3')->insert('INSERT INTO PQuotationItems(QuotationID,ItemId,ItemName,Quantity,Price,Unit,Total,Detail,State) values (?,?,?,?,?,?,?,?,?)', [$find_reqid1->QuotationID, $item_nam[$x], $find_itemname1->Name, $qt[$x], $est_cos[$x], $find_itemname1->unit, $total9, $detai[$x], 'false']);
                        } else {
                            $result3 = DB::connection('sqlsrv3')->insert('INSERT INTO PQuotationItems(QuotationID,Quantity,Price,Unit,Total,Detail,State) values (?,?,?,?,?,?,?)', [$find_reqid1->QuotationID, $qt[$x], $est_cos[$x], 'NOS', $total9, $detai[$x], 'false']);
                        }
                    }
                }
            }
            if ($qid == 1) {
                DB::connection('sqlsrv3')->update('update Requisition set q1=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
            } elseif ($qid == 2) {
                DB::connection('sqlsrv3')->update('update Requisition set q2=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
            } elseif ($qid == 3) {
                DB::connection('sqlsrv3')->update('update Requisition set q3=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
            } elseif ($qid == 4) {
                DB::connection('sqlsrv3')->update('update Requisition set q4=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
            } elseif ($qid == 5) {
                DB::connection('sqlsrv3')->update('update Requisition set q5=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
            } elseif ($qid == 6) {
                DB::connection('sqlsrv3')->update('update Requisition set q6=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
            }
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $id, 'New Quotation posted', ' Quotation ID ' . $find_reqid1->QuotationID . ' |  Quotation Number ' . $qid . ' | against Purchase Requisition ID ' . $find_req_type1->RId . ' | Vendor Name | ' . $vendor_n . ' | Total Amount | ' . $total . ' | has been posted', $update_date]);
            $message = 'submitted';
            return request()->json(200, $message);
        } else {
            $message = 'Empty field';
            return request()->json(200, $message);
        }
    }

    public function get_quotation_data($id, $rid)
    {

        $find_reqid = DB::connection('sqlsrv3')->table("PQuotation")->where('CompanyID', '=', company_id())->where('RequisitionID', '=', $rid)->where('QuotationNumber', '=', $id)->get();
        return request()->json(200, $find_reqid);
    }

    public function get_quotation_data1($qid)
    {

        $find_reqid = DB::connection('sqlsrv3')->table("PQuotationItems")->where('QuotationID', '=', $qid)->get();
        return request()->json(200, $find_reqid);
    }

    public function edit_pquotation(Request $request)
    {
        $rid = $request->get('rid');
        $qid = $request->get('qid');
        $date = $request->get('date');
        $narration = $request->get('narration');
        $vendor_n = $request->get('vendor_n');
        $subtotal = $request->get('subtotal');
        $discount = $request->get('discount');
        $tax_amount = $request->get('tax_amount');
        $delivery_amount = $request->get('delivery_amount');
        //
        $select_pmterm = $request->get('select_pmterm');
        $total = $request->get('total');
        $status = $request->get('status');
        $quotationid = $request->get('quotationid');
        $item_name = $request->get('item_name');
        $qty = $request->get('qty');
        $detail = $request->get('detail');
        $unit_cost = $request->get('unit_cost');
        $check_purchase = $request->get('check_purchase');
        $item_name1 = explode("|", $item_name);
        $find_req_type = DB::connection('sqlsrv3')->table("Requisition")->select('RequisitionType')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $rid)->get();
        foreach ($find_req_type as $find_req_type1) {
        }
        $req_type = $find_req_type1->RequisitionType;
        if ($req_type != 'Services') {

            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $qt = explode("|", $qty);
                $est_cos = explode("|", $unit_cost);
                if ($item_nam[$x] == '' || $qt[$x] == '' || $est_cos[$x] == '') {
                    $message = 'Empty field';
                    return request()->json(200, $message);
                }
                $find_req_item_detail = DB::connection('sqlsrv3')->table("RequisitionItem")->where('ReqID', '=', $rid)->where('ReqID', '=', $rid)->where('itemId', '=', $item_nam[$x])->get();
                foreach ($find_req_item_detail as $find_req_item_detail1) {
                }
                if ($find_req_item_detail1->Quantity < $qt[$x]) {
                    $message = 'Quotation Quantity is greatar than Requisition Quantity';
                    return request()->json(200, $message);
                }
            }
        }

        if (str_contains($check_purchase, 'true')) {
            $status = 'finalize';
        } else {
            $status = $request->get('status');
        }


        $update_date = long_date();
        if ($request->hasFile('image_file')) {

            $file = $request->file('image_file');
            $name_image = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/images/quotation_images/', $name_image);
            $result = DB::connection('sqlsrv3')->update('update PQuotation set VendorName=?,QuotationDate=?,SubTotal=?,Discount=?,Tax=?, PaymentTerm=?, ShippingCharges=?, Total=?,Remarks=?,Status=?, Photo=?, UpdatedBy=?,UpdatedOn=? where QuotationID=?', [$vendor_n, $date, $subtotal, $discount, $tax_amount, $select_pmterm, $delivery_amount, $total, $narration, $status, $name_image, username(), $update_date, $quotationid]);
        } else {
            $result = DB::connection('sqlsrv3')->update('update PQuotation set VendorName=?,QuotationDate=?,SubTotal=?,Discount=?,Tax=?, PaymentTerm=?, ShippingCharges=?, Total=?,Remarks=?,Status=?,UpdatedBy=?,UpdatedOn=? where QuotationID=?', [$vendor_n, $date, $subtotal, $discount, $tax_amount, $select_pmterm, $delivery_amount, $total, $narration, $status, username(), $update_date, $quotationid]);
        }
        if ($result) {
            DB::connection('sqlsrv3')->table('PQuotationItems')->where('QuotationID', $quotationid)->delete();
            $item_name1 = explode("|", $item_name);
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $qt = explode("|", $qty);
                $detai = explode("|", $detail);
                $est_cos = explode("|", $unit_cost);
                $check_purchas = explode("|", $check_purchase);

                $total9 = $qt[$x] * $est_cos[$x];
                if ($req_type == 'Goods' || $req_type == 'Assets') {
                    $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'unit')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                    foreach ($find_itemname as $find_itemname1) {

                    }
                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO PQuotationItems(QuotationID,ItemId,ItemName,Quantity,Price,Unit,Total,Detail,State) values (?,?,?,?,?,?,?,?,?)', [$quotationid, $item_nam[$x], $find_itemname1->Name, $qt[$x], $est_cos[$x], $find_itemname1->unit, $total9, $detai[$x], $check_purchas[$x]]);
                } else {
                    $result3 = DB::connection('sqlsrv3')->insert('INSERT INTO PQuotationItems(QuotationID,Quantity,Price,Unit,Total,Detail,State) values (?,?,?,?,?,?,?)', [$quotationid, $qt[$x], $est_cos[$x], 'NOS', $total9, $detai[$x], $check_purchas[$x]]);
                }
            }
        }
        if ($qid == 1) {
            DB::connection('sqlsrv3')->update('update Requisition set q1=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
        } elseif ($qid == 2) {
            DB::connection('sqlsrv3')->update('update Requisition set q2=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
        } elseif ($qid == 3) {
            DB::connection('sqlsrv3')->update('update Requisition set q3=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
        } elseif ($qid == 4) {
            DB::connection('sqlsrv3')->update('update Requisition set q4=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
        } elseif ($qid == 5) {
            DB::connection('sqlsrv3')->update('update Requisition set q5=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
        } elseif ($qid == 6) {
            DB::connection('sqlsrv3')->update('update Requisition set q6=? where CompanyID=? and RequisitionId=?', [$status, company_id(), $rid]);
        }
        $message = 'submitted';
        return request()->json(200, $message);
    }


    public function count_purchase()
    {

        $session = ac_c_session();
        $total = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->count();
        $notdelivered = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status2', '=', 'Not Delivered')->count();
        $received = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status2', '=', 'Received')->count();
        $issued = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status2', '=', 'Issued')->count();

        $myJSON = array(
            'total' => $total,
            'notdelivered' => $notdelivered,
            'received' => $received,
            'issued' => $issued,
        );
        return request()->json(200, $myJSON);
    }

    public function get_quotationdetail()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("PQuotation")->join('Requisition', 'PQuotation.RequisitionID', '=', 'Requisition.RequisitionId')->where('PQuotation.CompanyID', '=', company_id())
            // ->where('PQuotation.Session', '=', $session)
            ->where('PQuotation.state', '=', 0)->where('PQuotation.Status', '=', 'finalize')->orderby('PQuotation.QuotationID', 'desc')->select('PQuotation.QuotationID', 'PQuotation.QuotationNumber', 'PQuotation.VendorName', 'Requisition.RId')->get();
        return request()->json(200, $find_config);
    }

    public function get_quotation_detail($qid)
    {

        $get_quo = DB::connection('sqlsrv3')->table('PQuotation')->join('Requisition', 'PQuotation.RequisitionID', '=', 'Requisition.RequisitionId')->select('PQuotation.*', 'Requisition.RequisitionType')->where('PQuotation.CompanyID', '=', company_id())->where('PQuotation.QuotationID', '=', $qid)->get();
        $getcharges = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('AgainstQuo', $get_quo[0]->QuotationID)->where('Status', 'Partial')->get();
        if (count($getcharges) > 0) {
            foreach ($get_quo as $getcharge) {
                $getcharge->ShippingCharges = '';
            }
        }
        return request()->json(200, $get_quo);
    }

    public function get_quotation_detail1($qid)
    {
        $get_quo = DB::connection('sqlsrv3')->table('PQuotationItems')->where('State', '=', 'true')->where('QuotationID', '=', $qid)->get();
        return request()->json(200, $get_quo);
    }

    public function getitems_demandrequisition($rid)
    {
        $data1 = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('RId', '=', $rid)->select('RequisitionId')->first();
        $arr = DB::connection('sqlsrv3')->table('DemandRequisitionItem')->where('ReqID', '=', $data1->RequisitionId)->select('ItemName', 'itemId')->get();
        return request()->json(200, $arr);
    }

    public function insert_purchaseorder(Request $request)
    {
        $item_name = $request->get('item_name');
        $unit_cost = $request->get('unit_cost');
        $orderedQty = $request->get('orderedqty');
        $quoteqty = $request->get('quoteqty');
        $detail = $request->get('detail');
        $quoid = $request->get('quoid');
        $reqid = $request->get('reqid');
        $narration = $request->get('narration');
        $date = $request->get('date');
        $vendor_n = $request->get('vendor_n');
        $subtotal = $request->get('subtotal');
        $discount = $request->get('discount');
        $tax_amount = $request->get('tax_amount');
        $delivery_amount = $request->get('delivery_amount');
        $select_pmterm = $request->get('select_pmterm');
        $total = $request->get('total');
        $status = $request->get('status');
        $is_partial = false;

//        $update_date = long_date();
        $find_req_type1 = DB::connection('sqlsrv3')->table("Requisition")->select('RequisitionType')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $reqid)->first();
        $req_type = $find_req_type1->RequisitionType;

        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $item_nam = explode("|", $item_name);
            $quoteqt = explode("|", $quoteqty);
            $qt = explode("|", $orderedQty);
            $detai = explode("|", $detail);

            $already_inPO = 0;
            $in_PR = 0;
            if ($req_type != 'Services') {
                $already_inPO = DB::connection('sqlsrv3')->table("PurchaseOrderItems")->join('PurchaseOrder', 'PurchaseOrderItems.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'PurchaseOrder.AgainstReq', '=', 'Requisition.RequisitionId')->where('Requisition.RequisitionId', '=', $reqid)->where('Requisition.RequisitionType', '!=', 'Services')->where('PurchaseOrder.Status2', '!=', 'Reverse')->where('PurchaseOrderItems.ItemId', '=', $item_nam[$x])->where('PurchaseOrder.CompanyID', '=', company_id())->sum('PurchaseOrderItems.Quantity');
                $find_itemname1 = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'unit')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->first();
                $in_PR = DB::connection('sqlsrv3')->table("RequisitionItem")->where('ReqId', '=', $reqid)->where('itemId', '=', $item_nam[$x])->sum('Quantity');
            }
            if ($qt[$x] == '') {
                if ($req_type == 'Services') {
                    $find_config = "Please enter quantity of \"" . $detai[$x] . "\"!";
                } else {
                    $find_config = "Please enter quantity of \"" . ($find_itemname1 ? $find_itemname1->Name : '') . "\"!";
                }
                return request()->json(200, $find_config);
            }
            if ($qt[$x] < $quoteqt[$x] && $is_partial == false) {
                $is_partial = true;
            }
            if ($qt[$x] > $quoteqt[$x]) {
                $find_config = "Quantity of \"" . $find_itemname1->Name . "\" is exceded then " . $quoteqt[$x] . "!";
                return request()->json(200, $find_config);
            } else if ($req_type != 'Services') {
                if (($qt[$x] + $already_inPO) > $in_PR) {
                    $find_config = "Quantity of \"" . $find_itemname1->Name . "\" is exceded then " . $in_PR - $already_inPO . "!";
                    return request()->json(200, $find_config);
                }
                if ($status == 'Full' && ($qt[$x]) != $quoteqt[$x]) {
                    $find_config = "Remaining quantity of \"" . $find_itemname1->Name . "\" is " . $quoteqt[$x] . " please enter it for full PO!";
                    return request()->json(200, $find_config);
                } else if ($status == 'Partial' && $is_partial != true && ($qt[$x] + $already_inPO) < $quoteqt[$x]) {
                    $is_partial = true;
                }
            }
        }
        if ($status == 'Partial' && $is_partial != true) {
            $find_config = 'Please select partial quantity for "Partial" PO status!';
            return request()->json(200, $find_config);
        }
        $req_prefix = acc_config()->PurchaseOrder . '_' . $this->shiftformat();
        $rid = generateNextId("PurchaseOrder", 'PoCode');
        $final_PoCode = $req_prefix . '-' . $rid;
        $status2 = $req_type == 'Services' ? 'Not Completed' : 'Not Delivered';

        $purchaseOrder = [
            'CompanyID' => company_id(),
            'AgainstReq' => $reqid,
            'AgainstQuo' => $quoid,
            'PoCode' => $final_PoCode,
            'PoDate' => $date,
            'vendorName' => $vendor_n,
            'SubTotal' => $subtotal,
            'Discount' => $discount,
            'Tax' => $tax_amount,
            'ShippingCharges' => $delivery_amount,
            'TotalAmount' => $total,
            'Remarks' => $narration,
            'Status' => $status,
            'CreatedBy' => username(),
            'CreatedOn' => long_date(),
            'Session' => ac_c_session(),
            'Status2' => $status2,
            'RequisitionType' => $req_type,
            'PaymentTerm' => $select_pmterm,
        ];
//        dd($purchaseOrder);
        $result = DB::connection('sqlsrv3')->table('PurchaseOrder')->insertGetId($purchaseOrder);
        for ($x = 1; $x < count($item_name1); $x++) {
            $est_cos = explode("|", $unit_cost);
            $total0 = $qt[$x] * $est_cos[$x];
            $poItem = [
                'CompanyID' => company_id(),
                'POID' => $result,
                'QuoteQuantity' => $quoteqt[$x],
                'Quantity' => $qt[$x],
                'Price' => $est_cos[$x],
                'SubTotal' => $total0,
                'Detail' => $detai[$x],
                'Unit' => 'NOS',
            ];

            if ($req_type != 'Services') {
                $find_itemname1 = DB::connection('sqlsrv3')
                    ->table("ItemList")
                    ->select('Name', 'unit')
                    ->where('CompanyID', '=', company_id())
                    ->where('ID', '=', $item_nam[$x])
                    ->first();

                $poItem['ItemId'] = $item_nam[$x];
                $poItem['ItemName'] = $find_itemname1->Name;
                $poItem['Unit'] = $find_itemname1->unit;
            }
            $poItems[] = $poItem;
        }
        DB::connection('sqlsrv3')->table('PurchaseOrderItems')->insert($poItems);

        if ($status == 'Full') {
            DB::connection('sqlsrv3')
                ->table('PQuotation')
                ->where('QuotationID', $quoid)
                ->where('CompanyID', company_id())
                ->update(['state' => 1]);
        }
        insertLog('PO created', 'New Purchase Order against Vendor: ' . $vendor_n . ' | PO.Code: ' . $final_PoCode . ' | Total Amount: ' . $total . ' | Status: ' . $status . ' has been created');

        $message = "submitted";
        return request()->json(200, $message);
    }

    public function accounts_fetch_demandreqBysts($sts, $depts, $proj, $startdate, $closedate, $page)
    {
        $dept = emp_department();
        if ($sts == "All") {
            $sts = "";
        }
        if ($depts == "All") {
            $depts = "";
        }
        if ($proj == "All") {
            $proj = "";
        }

        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($page == 'All') {
                $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')
                    // ->where('Session',$session)
                    ->where('DepartmentName', 'like', '%' . $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')
                    ->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)
                    ->where("RequisitionType", "=", "Goods")->get();
                return request()->json(200, $req);
            } else {
                $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')
                    // ->where('Session',$session)
                    ->where('DepartmentName', 'like', '%' . $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where("RequisitionType", "=", "Goods")->paginate($page);
                return request()->json(200, $req);
            }
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {
                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;
                if ($depts == $d1 || $depts == $d2 || $depts == $d3 || $depts == $d4 || $depts == $d5 || $depts == $d6) {
                    if ($page == 'All') {
                        $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', company_id())
                            // ->where('Session',$session)
                            ->where('DepartmentName', 'like', $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Goods")->get();
                        return request()->json(200, $find_config);
                    } else {
                        $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', company_id())
                            // ->where('Session',$session)
                            ->where('DepartmentName', 'like', $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Goods")->paginate($page);
                        return request()->json(200, $find_config);
                    }
                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }
            } else {
                if ($depts == $dept) {
                    if ($page == 'All') {
                        $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')->where('DepartmentName', '=', $dept)->where('ProjectName', 'like', '%' . $proj . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where("RequisitionType", "=", "Goods")->get();
                        return request()->json(200, $req);
                    } else {
                        $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')->where('DepartmentName', '=', $dept)->where('ProjectName', 'like', '%' . $proj . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where("RequisitionType", "=", "Goods")->paginate($page);
                        return request()->json(200, $req);
                    }
                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }
            }
        }
    }

    public function fetch_methods1()
    {
        $find_config = DB::connection('sqlsrv3')->select("Select ID,AccountName
  from Accounts
  where CompanyID = '" . company_id() . "' and
    CoaType = 'Transaction' and
      AccountName <> 'Cash in Hand'
      and
    AccountCode like '101001002%'");
        return request()->json(200, $find_config);
    }

    public function filter_bank_name($name)
    {
        $data = explode("_", $name);
        $find = DB::connection('sqlsrv3')->table('TempBank')->where('TempBank.ClearanceAccountID', '=', $data[0])->paginate(20);
        return request()->json(200, $find);
    }

    public function get_po_detail()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("PurchaseOrder")->where('CompanyID', '=', company_id())->where('Session', $session)->orderby('PurchaseOrderID', 'desc')->paginate(50);
        return request()->json(200, $find_config);
    }

    public function get_POdetail()
    {

        $dept = emp_department();


        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->first();
        $session = $find_session->SessionName;

        if ($dept == 'Software Development' || $dept == 'Audit' || $dept == 'Procurement' || $dept == 'Accounts') {
            $find_config = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'PurchaseOrder.AgainstReq', '=', 'Requisition.RequisitionId')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->where('PurchaseOrder.CompanyID', '=', company_id())
                // ->where('PurchaseOrder.Session', '=', $session)
                ->where('PurchaseOrder.pinv_state', '=', 0)->where('PurchaseOrder.RequisitionType', '=', 'Services')->orderby('PurchaseOrder.PurchaseOrderID', 'desc')->select('PurchaseOrder.PurchaseOrderID', 'PurchaseOrder.VendorName', 'Requisition.RequisitionId', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'PurchaseOrder.PoCode', 'DemandRequisition.RId')->get();
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->first();
                $departments = [$find_user->d1, $find_user->d2, $find_user->d3, $find_user->d4, $find_user->d5, $find_user->d6];

                $find_config = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'PurchaseOrder.AgainstReq', '=', 'Requisition.RequisitionId')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->where('PurchaseOrder.CompanyID', '=', company_id())->whereIn('Requisition.DepartmentName', $departments)->where('PurchaseOrder.Session', '=', $session)->where('PurchaseOrder.pinv_state', '=', 0)->where('PurchaseOrder.RequisitionType', '=', 'Services')->orderby('PurchaseOrder.PurchaseOrderID', 'desc')->select('PurchaseOrder.PurchaseOrderID', 'PurchaseOrder.VendorName', 'Requisition.RequisitionId', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'PurchaseOrder.PoCode', 'DemandRequisition.RId')->get();
            } else {
                $find_config = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'PurchaseOrder.AgainstReq', '=', 'Requisition.RequisitionId')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->where('PurchaseOrder.CompanyID', '=', company_id())->where('Requisition.DepartmentName', '=', $dept)->where('PurchaseOrder.Session', '=', $session)->where('PurchaseOrder.pinv_state', '=', 0)->where('PurchaseOrder.RequisitionType', '=', 'Services')->orderby('PurchaseOrder.PurchaseOrderID', 'desc')->select('PurchaseOrder.PurchaseOrderID', 'PurchaseOrder.VendorName', 'Requisition.RequisitionId', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'PurchaseOrder.PoCode', 'DemandRequisition.RId')->get();
            }
        }

        return request()->json(200, $find_config);
    }

    public function accounts_get_servicebill_bydate($datefrom, $dateto)
    {

        if ($datefrom == "All") {
            $datefrom = "00-00-0000";
        }
        if ($dateto == "All") {
            $dateto = "99-99-9999";
        }

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("ServiceBill")->where('CompanyID', '=', company_id())->where('Dated', '>=', $datefrom)->where('Dated', '<=', $dateto)->where('Session', $session)->orderby('ServiceBillId', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public function get_POreturn()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->where('ReceivingOrder.CompanyID', '=', company_id())->where('PurchaseOrder.RequisitionType', '!=', 'Services')
            // ->where('ReceivingOrder.Session', '=', $session)
            ->where('ReceivingOrder.Status2', '=', 'Verified')->orderby('ReceivingOrder.ReceavingOrderID', 'desc')->select('ReceivingOrder.ReceavingOrderID', 'PurchaseOrder.VendorName', 'ReceivingOrder.FormID')->get();
        return request()->json(200, $find_config);
    }

    public function get_purchaseorder_detail($poid)
    {

        $get_quo = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('PurchaseOrderID', '=', $poid)->get();
        return request()->json(200, $get_quo);
    }


    public function get_purchaseorder_detail1($poid)
    {
        // $get_quo  = DB::connection('sqlsrv3')->table('PurchaseOrderItems')->where('POID', '=', $poid)->get();

        $get_quo = DB::connection('sqlsrv3')->select("select po.ItemId,po.ItemName,po.Quantity ,po.POID ,po.[Price], po.[Unit], po.[SubTotal], po.[Detail],
    --ISNULL(sum (g.RecvdQuantity), 0) as  ReceivedQuantity,
    SUM(CASE WHEN g1.isDeleted != '1'
       THEN g.RecvdQuantity ELSE 0.0 END) AS ReceivedQuantity
    from PurchaseOrder p
    join PurchaseOrderItems po  on p.PurchaseOrderID =po.POID
    left join GrnOrderItems g on p.PurchaseOrderID= g.poid and po.ItemId= g.ItemId
    left join GrnOrder g1 on g1.GrnOrderID = g.GrnID
    where  p.PurchaseOrderID = '" . $poid . "'
    ---PurchaseOrderid in (select poid from GrnOrder)
    group by po.ItemId,po.ItemName,po.Quantity ,po.POID, po.[Price], po.[Unit], po.[SubTotal], po.[Detail]");
        return request()->json(200, $get_quo);
    }

    public function get_purchaseinvoice_detail($poid)
    {

        $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->where('ReceivingOrder.CompanyID', '=', company_id())->where('ReceivingOrder.ReceavingOrderID', '=', $poid)->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'PurchaseOrder.RequisitionType')->get();

        return request()->json(200, $find_config);
    }

    public function get_purchaseinvoice_detail1($poid)
    {
        $get_quo = DB::connection('sqlsrv3')->table('ReceivingOrderItems')->where('ROID', '=', $poid)->get();
        return request()->json(200, $get_quo);
    }

    public function fetch_po_byStatus($sts)
    {

        if ($sts == "All") {
            $req = DB::connection('sqlsrv3')->table('PurchaseOrder')->orderBy('PurchaseOrderID', 'desc')->where('CompanyID', '=', company_id())->paginate(20);
        } else {
            $req = DB::connection('sqlsrv3')->table('PurchaseOrder')->orderBy('PurchaseOrderID', 'desc')->where('CompanyID', '=', company_id())->where('Status2', '=', $sts)->paginate(20);
        }
        return request()->json(200, $req);
    }


    public function PO_By_Name(Request $request)
    {
        $find_session1 = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->first();
        //foreach ($find_session as $find_session1) {}
        $session = $find_session1->SessionName;

        $arr = DB::connection('sqlsrv3')->table('PurchaseOrder')->join('Requisition', 'PurchaseOrder.AgainstReq', '=', 'Requisition.RequisitionId')->select('PurchaseOrder.*', 'Requisition.RId')
            ->where('PurchaseOrder.vendorName', 'like', '%' . $request->name . '%')
            ->orwhere('PurchaseOrder.poCode', 'like', '%' . $request->name . '%')
            ->orwhere('Requisition.RId', 'like', '%' . $request->name . '%')
            // ->where('PurchaseOrder.Session', $session)
            ->where('PurchaseOrder.CompanyID', '=', company_id())->orderby('PurchaseOrder.PurchaseOrderID', 'desc')->paginate(20);
        return request()->json(200, $arr);
    }


    public function get_po_data($id)
    {

        $cand = DB::connection('sqlsrv3')->table('PurchaseOrder')->join('Requisition', 'PurchaseOrder.AgainstReq', '=', 'Requisition.RequisitionId')->select('PurchaseOrder.*', 'Requisition.RId')->where('PurchaseOrder.CompanyID', '=', company_id())->where('PurchaseOrder.PurchaseOrderID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public function get_po_data2($id)
    {
        $data = explode("_", $id);
        $rid = $data[0];

        $cand = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('PurchaseOrderID', '=', $rid)->get();
        return request()->json(200, $cand);
    }


    public function get_poProducts($id)
    {

        $find_products = DB::connection('sqlsrv3')->table("PurchaseOrderItems")->select('PurchaseOrderItems.*')->where('CompanyID', '=', company_id())->where('POID', $id)->get();
        return request()->json(200, $find_products);
    }

    public function po_by_date($datefrom, $dateto)
    {

        if ($datefrom == "All") {
            $datefrom = "00-00-0000";
        }
        if ($dateto == "All") {
            $dateto = "99-99-9999";
        }
        $cand = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('PoDate', '>=', $datefrom)->where('PoDate', '<=', $dateto)->orderby('PurchaseOrderID', 'desc')->paginate(20);
        return request()->json(200, $cand);
    }


    public function sales_detail()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("SalesInvoice")->join('Customer', 'Customer.CustomerID', '=', 'SalesInvoice.CustomerID')->where('SalesInvoice.CompanyID', '=', company_id())->where('SalesInvoice.Session', '=', $session)->orderby('SalesInvoice.SalesInvoiceID', 'desc')->select('SalesInvoice.*', 'Customer.CustomerName')->paginate(20);
        return request()->json(200, $find_config);
    }

    public function purreturn_detail()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("ReceivingOrderReturn")->where('CompanyID', '=', company_id())->where('Session', '=', $session)->orderby('ReturnOrderID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public function search_purchasereturn($start_date, $end_date)
    {

        $find_config = DB::connection('sqlsrv3')->table("ReceivingOrderReturn")->where('CompanyID', '=', company_id())->where('Dated', '>=', $start_date)->where('Dated', '<=', $end_date)->orderby('ReturnOrderID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }


    public function balances_report($start_date, $end_date)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[BalanceSheet]
         @Datefrom = N'" . $start_date . "',
         @DateTo = N'" . $end_date . "'");

        return request()->json(200, $result);
    }

    public function stock_sum()
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[Stock_Value_Sum]");

        return request()->json(200, $result);
    }

    public function taxdetails_report($tax)
    {

        $find_session = DB::connection('sqlsrv3')->table("Session")->where("CompanyID", "=", company_id())->get();
        foreach ($find_session as $find_session1) {
        }
        $session_sdate = explode(" ", $find_session1->StartDate);
        $session_edate = explode(" ", $find_session1->EndDate);

        $find = '';
        if ($tax == 'All') {
            $find_config = DB::connection('sqlsrv3')->table("TaxDetail")->where("CompanyID", "=", company_id())->where("CreatedOn", ">=", $session_sdate)->where("CreatedOn", "<=", $session_edate)->get();

            $find = $find_config;
        } else {
            $find_config = DB::connection('sqlsrv3')->table("TaxDetail")->where("CompanyID", "=", company_id())->where('TaxType', '=', $tax)->where("CreatedOn", ">=", $session_sdate)->where("CreatedOn", "<=", $session_edate)->get();
            $find = $find_config;
        }
        return request()->json(200, $find);
    }

    public function deliverydetails_report($tax)
    {

        $find_session = DB::connection('sqlsrv3')->table("Session")->where("CompanyID", "=", company_id())->get();
        foreach ($find_session as $find_session1) {
        }
        $session_sdate = explode(" ", $find_session1->StartDate);
        $session_edate = explode(" ", $find_session1->EndDate);

        $find = '';
        if ($tax == 'All') {
            $find_config = DB::connection('sqlsrv3')->table("DeliveryDetail")->where("CompanyID", "=", company_id())->where("CreatedOn", ">=", $session_sdate)->where("CreatedOn", "<=", $session_edate)->get();

            $find = $find_config;
        } else {
            $find_config = DB::connection('sqlsrv3')->table("DeliveryDetail")->where("CompanyID", "=", company_id())->where('DeliveryType', '=', $tax)->where("CreatedOn", ">=", $session_sdate)->where("CreatedOn", "<=", $session_edate)->get();
            $find = $find_config;
        }
        return request()->json(200, $find);
    }

    public function get_linkprojects()
    {

        $find_config = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->where('CompanyID', '=', company_id())->whereNotNull('CoaID')->select('ProjectName')->get();
        return request()->json(200, $find_config);
    }

    public function incomestatement_report($start_date, $end_date)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[IncomeStatment]
             @Datefrom = N'" . $start_date . "',
             @DateTo = N'" . $end_date . "'");

        return request()->json(200, $result);
    }

    public function po_detailreport()
    {

        $find_session = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->select("PurchaseOrderID", "vendorName")->get();
        return request()->json(200, $find_session);
    }

    public function vendor_balance_report($start_date, $end_date)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[Vendors_Balance]
               @Datefrom = N'" . $start_date . "',
               @DateTo = N'" . $end_date . "',
               @compid = N'" . company_id() . "'  ");

        return request()->json(200, $result);
    }


    public function ledger_method_report_openingbalance($start_date, $ledger_name)
    {
        $id = explode("_", $ledger_name);


        $created_on = short_date();
        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[Ledger_Report_PB]
      @Start_date =  N'" . $start_date . "',
      @comp = N'" . company_id() . "',
      @ID = " . $id[0] . "
        ");

        return request()->json(200, $result);
    }

    public function trail_balance($start_date, $end_date)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC   [dbo].[TrialBalance_1]
         @Datefrom = N'" . $start_date . "',
         @DateTo = N'" . $end_date . "',
         @compid = N'" . company_id() . "'  ");

        return request()->json(200, $result);
    }

    public function get_POdetail9()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'PurchaseOrder.AgainstReq', '=', 'Requisition.RequisitionId')->where('PurchaseOrder.CompanyID', '=', company_id())->where('Requisition.RequisitionType', '!=', 'Services')
            // ->where('PurchaseOrder.Session', '=', $session)
            ->where('PurchaseOrder.state', '=', 0)->orderby('PurchaseOrder.PurchaseOrderID', 'desc')->select('PurchaseOrder.PurchaseOrderID', 'PurchaseOrder.VendorName', 'Requisition.RequisitionId', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'PurchaseOrder.PoCode')->get();
        return request()->json(200, $find_config);
    }

    public function stock_detail()
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC [dbo].[RemainingItem]
    @CompID = N'" . company_id() . "' ");

        return request()->json(200, $result);
    }

    public function stock_detail1($name)
    {
        $id = explode("_", $name);


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[RemainingItem_companywise] @id = " . $id[0] . ",@compID = N'" . company_id() . "' ");

        return request()->json(200, $result);
    }

    public function search_item(Request $request)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC [dbo].[Item_detail_byName]
    @CompID = N'" . company_id() . "' ,
    @name = N'" . $request->keyword1 . "' ");

        return request()->json(200, $result);
    }

    public function assets_detail()
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC  [dbo].[RemainingAssets]
    @CompID =  N'" . company_id() . "' ");

        return request()->json(200, $result);
    }

    public function getindtotalstock($id)
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[RemainingItem_companywise] @id = " . $id . ",@compID = N'" . company_id() . "' ");
        return request()->json(200, $result);
    }

    public function getindstock($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("Inventory")->join('ItemList', 'Inventory.ItemID', '=', 'ItemList.ID')
            ->join('ItemCategory', 'ItemList.ItemCategory', '=', 'ItemCategory.ID')->where('Inventory.CompanyID', '=', company_id())->where('Inventory.ItemID', '=', $id)->where('Inventory.Type', '!=', 0)->orderby('Inventory.ID', 'desc')->select('Inventory.*', 'ItemList.Name', 'ItemCategory.CategoryName')->get();
        return request()->json(200, $find_config);
    }

    public function getindassets($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("Assets")->join('ItemList', 'Assets.AssetID', '=', 'ItemList.ID')
            ->join('ItemCategory', 'ItemList.ItemCategory', '=', 'ItemCategory.ID')->where('Assets.CompanyID', '=', company_id())->where('Assets.AssetsUniqueID', '=', $id)->where('Assets.AssetType', '!=', 0)->orderby('Assets.ID', 'desc')->select('Assets.*', 'ItemList.Name', 'ItemCategory.CategoryName')->get();
        return request()->json(200, $find_config);
    }

    public function fetch_item_name($id)
    {

        $find_config = DB::connection('sqlsrv3')->table('ItemList')->where('CompanyID', '=', company_id())->where('ID', '=', $id)->get();

        return request()->json(200, $find_config);
    }

    public function submit_stock_adj(Request $request)
    {

        $type = $request->get('type');
        $product_name = $request->get('product_name');
        $product_id = $request->get('product_id');
        $quantity = $request->get('quantity');
        $unit = $request->get('unit');
        $cost_unit = $request->get('cost_unit');

        $update_da = short_date();
        $update_date = long_date();

        if ($type == 3) {
            $ref = 'Added stock Through stock Adjustment';
        } else if ($type == 4) {
            $ref = 'Minus Stock Through stock Adjustment';
        }
        $result5 = DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,CreatedBy,CreatedOn,Reference,Dated) values (?,?,?,?,?,?,?,?,?)', [company_id(), $product_id, $quantity, $unit, $type, username(), $update_date, $ref, $update_da]);
        if ($cost_unit > 0) {
            DB::connection('sqlsrv3')->update('update Inventory set FaceValue=? where CompanyID=? and ItemID=?', [$cost_unit, company_id(), $product_id]);
        }
        if ($result5) {
            $result = "submitted";
            return request()->json(200, $result);
        }
    }

    public function get_issuancebyid($id)
    {
        $find_config = DB::connection('sqlsrv3')->table("Issuances")->join('DemandRequisition', 'Issuances.RequisitionId', '=', 'DemandRequisition.RequisitionId')->where('Issuances.IssuanceId', '=', $id)->where('Issuances.CompanyID', '=', company_id())->select('Issuances.*', 'DemandRequisition.RId')->orderby('Issuances.IssuanceId', 'desc')->get();
        return request()->json(200, $find_config);
    }

    public function get_issuanceitem($id)
    {
        $find_config = DB::connection('sqlsrv3')->table("IssuanceItem")->join('ItemList', 'ItemList.ID', '=', 'IssuanceItem.ItemId')->select('IssuanceItem.*', 'ItemList.ItemCode')->where('IssuanceId', '=', $id)->get();
        return request()->json(200, $find_config);
    }

    public function issuance_bydept(Request $request)
    {
        $find_config = DB::connection('sqlsrv3')
            ->table("Issuances")
            ->join('DemandRequisition', 'Issuances.RequisitionId', '=', 'DemandRequisition.RequisitionId')
            ->where('Issuances.CompanyID', '=', company_id())
            ->where(function ($query) use ($request) {
                $query->where('Issuances.IssuanceCode', 'like', '%' . $request->dept . '%')
                    ->orWhere('Issuances.DepartmentName', 'like', '%' . $request->dept . '%')
                    ->orWhere('Issuances.ProjectName', 'like', '%' . $request->dept . '%')
                    ->orWhere('DemandRequisition.RId', 'like', '%' . $request->dept . '%');
            })
            ->select('Issuances.*', 'DemandRequisition.RId')
            ->orderByDesc('Issuances.IssuanceId')
            ->paginate(20);
        return request()->json(200, $find_config);
    }

    public function searchissuance($department, $project, $datefrom, $dateto)
    {
        $department = ($department == "All") ? "" : $department;
        $project = ($project == "All") ? "" : $project;
        $find_config = DB::connection('sqlsrv3')->table("Issuances")->join('DemandRequisition', 'Issuances.RequisitionId', '=', 'DemandRequisition.RequisitionId')
            ->where('Issuances.CompanyID', '=', company_id())->where('Issuances.DepartmentName', 'like', '%' . $department)->where('Issuances.ProjectName', 'like', '%' . $project)->where('Issuances.IssuanceDate', '>=', $datefrom)->where('Issuances.IssuanceDate', '<=', $dateto)->select('Issuances.*', 'DemandRequisition.RId')->orderby('Issuances.IssuanceId', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public function get_all_projects()
    {
        $find_config = DB::connection('sqlsrv3')->table("CompanyProjects")->select('ProjectName')->orderBy('ProjectName', 'asc')->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $find_config);
    }

    public function fetch_payable_head()
    {

        $find_config = DB::connection('sqlsrv3')->table("Accounts")->select('ID', 'AccountName')->where('CompanyID', '=', company_id())->where('CoaType', '=', 'Transaction')->orderby('ID', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public function fetch_receivable_head()
    {

        $find_config = DB::connection('sqlsrv3')->table("Accounts")->select('ID', 'AccountName')->where('CompanyID', '=', company_id())->where('CoaType', '=', 'Transaction')->where('AccountCode', 'like', '101002%')->orWhere('AccountCode', 'like', '102003%')->orderby('ID', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public function fetch_all_transaction_head()
    {
        $cand = transaction_heads();
        return request()->json(200, $cand);
    }

    public function fetch_methods()
    {

        $find_config = DB::connection('sqlsrv3')->select("Select ID,AccountName from Accounts where CompanyID = '" . company_id() . "' and  CoaType = 'Transaction' and
 (ID LIKE '101001001001%' or ID LIKE '101001002%') ");
        return request()->json(200, $find_config);
    }

    public function fetch_bank_methods()
    {

        $find_config = DB::connection('sqlsrv3')->select("Select ID,AccountName from Accounts where CompanyID = '" . company_id() . "' and  CoaType = 'Transaction' and (ID LIKE '101001002%') ");
        return request()->json(200, $find_config);
    }

    public function pvid()
    {
        $pvid = insert_sequencevoucher('PV_F23-2009', 176212, 'Payment Voucher');
        return request()->json(200, $pvid);

    }

    public function submit_payment_voucher(Request $request)
    {
        $session = ac_c_session();
        $username = username();
        $date = $request->get('date');
        $chq_date = $request->get('chq_date');
        $vendor_name = $request->get('vendor_name');
        $method_type = $request->get('method_type');
        $amount = $request->get('amount');
        $narration = $request->get('narration');
        $chq_number = $request->get('chq_number');
        $salesperson = $request->get('salesperson');
        $invoices = $request->get('invoices');
        $remaining_amount = $request->get('remaining_amount');
        $invoice_amount = $request->get('invoice_amount');
        $tax_totalamount = $request->get('tax_totalamount');
        $tax_against = $request->get('tax_against');
        $taxagin = explode("_", $tax_against);

        if ($amount < 0 || $tax_totalamount < 0) {
            $find_config = 'Amount Cannot be Negative';
            return request()->json(200, $find_config);
        }

        $final_PoCode = PVID();


        $update_date = long_date();
        $doc_date = short_date();
        $method_typ = explode("_", $method_type);

        $cashinhand_balance = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
    @Datefrom = N'2000-01-01',
    @DateTo = N'" . $doc_date . "',
    @id = " . $method_typ[0] . ",
    @compid = N'" . company_id() . "'  ");
        $pv_items = [];
        $params = [];
        foreach ($cashinhand_balance as $cashinhand_balance1) {
        }
        if ($method_type == '101001001001_Cash in Hand' && $cashinhand_balance1->am <= 0) {
            $find_config = 'Not Suficient Balance';
            return request()->json(200, $find_config);
        }

        $pay_against = explode("_", $vendor_name);

        $p_agnst = $request->get('p_agnst');
        $against_invoice = $request->get('against_invoice');

        $invoice9 = explode("|", $invoices);
        for ($y = 1; $y < count($invoice9); $y++) {
            $invoic = explode("|", $invoices);
            $remaining_amoun = explode("|", $remaining_amount);
            $invoice_amoun = explode("|", $invoice_amount);
            if ($remaining_amoun[$y] == '' || $invoice_amoun[$y] == '' || $invoic[$y] == '') {
                $find_config = 'Required Compulsory Fileds';
                return request()->json(200, $find_config);
            }
            if ($remaining_amoun[$y] < $invoice_amoun[$y]) {
                $find_config = 'Remaining Amount must be greater than Invoice Amount';
                return request()->json(200, $find_config);
            }
        }


        // for against others
        if ($p_agnst == 'mis') {
            $params = [
                'CompanyID' => company_id(),
                'PVID' => $final_PoCode,
                'VoucherDate' => $date,
                'AccountID' => $pay_against[0],
                'PaymentAgainst' => $pay_against[1],
                'InvoiceNumber' => $against_invoice,
                'Amount' => $amount,
                'MethodType' => $method_typ[1],
                'MethodAccountID' => $method_typ[0],
                'Naration' => $narration,
                'SalesPerson' => $salesperson,
                'CreatedBy' => username(),
                'CreatedOn' => $update_date,
                'Session' => $session,
                'ChqDate' => $chq_date,
                'ChqNumber' => $chq_number,
                'Status' => 'Not Verified',
                'TaxAmount' => $tax_totalamount,
                'TaxID' => $taxagin[0]
            ];
            $result = insert_payment_voucher($params);
            if ($result) {
                $pv_items[] = [
                    'CompanyID' => company_id(),
                    'PID' => $result,
                    'Date' => $date,
                    'Amount' => $amount,
                    'PVNO' => $final_PoCode,
                    'Remaining' => '',
                    'AgainstINV' => '',
                    'AgainstPO' => $against_invoice,
                ];
                insert_payment_voucher_items($pv_items);
            }

        } // against journal voucher
        else if ($p_agnst == 'jv_') {

            $invoices1 = explode("|", $invoices);

            for ($x = 1; $x < count($invoices1); $x++) {
                $invoic = explode("|", $invoices);
                $check_pvdetail = DB:: connection('sqlsrv3')->table('PaymentVoucherDetail')->select('Remaining')->where('AgainstJV', '=', $invoic[$x])->orderBy('Date', 'desc')->orderBy('DetailID', 'desc')->first();
                if ($check_pvdetail) {
                    if ($check_pvdetail->Remaining == 0) {
                        $find_config = 'The amount against invoice ' . $invoic[$x] . ' is fully paid';
                        return request()->json(200, $find_config);
                    }
                }
            }


            $theRest = substr($invoices, 5);
            $params = [
                'CompanyID' => company_id(),
                'PVID' => $final_PoCode,
                'VoucherDate' => $date,
                'AccountID' => $pay_against[0],
                'PaymentAgainst' => $pay_against[1],
                'InvoiceNumber' => $theRest, // Assuming $theRest[0] is the first value
                'Amount' => $amount,
                'MethodType' => $method_typ[1],
                'MethodAccountID' => $method_typ[0],
                'Naration' => $narration,
                'SalesPerson' => $salesperson,
                'CreatedBy' => username(),
                'CreatedOn' => $update_date,
                'Session' => $session,
                'ChqDate' => $chq_date,
                'ChqNumber' => $chq_number,
                'Status' => 'Not Verified',
                'TaxAmount' => $tax_totalamount,
                'TaxID' => $taxagin[0]
            ];
            $result = insert_payment_voucher($params);

            if ($result) {
                $invoices1 = explode("|", $invoices);
                for ($x = 1; $x < count($invoices1); $x++) {
                    $invoic = explode("|", $invoices);
                    $remaining_amoun = explode("|", $remaining_amount);
                    $invoice_amoun = explode("|", $invoice_amount);
                    $pv_items[] = [
                        'CompanyID' => company_id(),
                        'PID' => $result,
                        'Date' => $date,
                        'Amount' => $invoice_amoun[$x],
                        'PVNO' => $final_PoCode,
                        'Remaining' => $remaining_amoun[$x] - $invoice_amoun[$x],
                        'AgainstJV' => $invoic[$x],
                    ];

                }
                insert_payment_voucher_items($pv_items);

            }
        } // against po
        else if ($p_agnst == 'po_') {
            $invoices1 = explode("|", $invoices);

            for ($x = 1; $x < count($invoices1); $x++) {
                $invoic = explode("|", $invoices);
                $check_pvdetail = DB:: connection('sqlsrv3')->table('PaymentVoucherDetail')->select('Remaining')->where('AgainstPO', '=', $invoic[$x])->orderBy('Date', 'desc')->orderBy('DetailID', 'desc')->first();
                if ($check_pvdetail) {
                    if ($check_pvdetail->Remaining == 0) {
                        $find_config = 'The amount against invoice ' . $invoic[$x] . ' is fully paid';
                        return request()->json(200, $find_config);
                    }
                }
            }

            $theRest = substr($invoices, 5);
            $params = [
                'CompanyID' => company_id(),
                'PVID' => $final_PoCode,
                'VoucherDate' => $date,
                'AccountID' => $pay_against[0],
                'PaymentAgainst' => $pay_against[1],
                'InvoiceNumber' => $theRest,
                'Amount' => $amount,
                'MethodType' => $method_typ[1],
                'MethodAccountID' => $method_typ[0],
                'Naration' => $narration,
                'SalesPerson' => $salesperson,
                'CreatedBy' => username(),
                'CreatedOn' => $update_date,
                'Session' => $session,
                'ChqDate' => $chq_date,
                'ChqNumber' => $chq_number,
                'Status' => 'Not Verified',
                'TaxAmount' => $tax_totalamount,
                'TaxID' => $taxagin[0]
            ];
            $result = insert_payment_voucher($params);

            if ($result) {


                $invoices1 = explode("|", $invoices);

                for ($x = 1; $x < count($invoices1); $x++) {
                    $invoic = explode("|", $invoices);
                    $remaining_amoun = explode("|", $remaining_amount);
                    $invoice_amoun = explode("|", $invoice_amount);
                    $pv_items[] = [
                        'CompanyID' => company_id(),
                        'PID' => $result,
                        'Date' => $date,
                        'Amount' => $invoice_amoun[$x],
                        'PVNO' => $final_PoCode,
                        'Remaining' => $remaining_amoun[$x] - $invoice_amoun[$x],
                        'AgainstPO' => $invoic[$x],
                        'AgainstINV' => '',
                    ];
                }
                insert_payment_voucher_items($pv_items);

            }
            // against invoice
        } else if ($p_agnst == 'pi_') {
            $invoices1 = explode("|", $invoices);
            for ($x = 1; $x < count($invoices1); $x++) {
                $invoic = explode("|", $invoices);
                $check_pvdetail = DB:: connection('sqlsrv3')->table('PaymentVoucherDetail')->select('Remaining')->where('AgainstINV', '=', $invoic[$x])->orderBy('Date', 'desc')->orderBy('DetailID', 'desc')->first();
                if ($check_pvdetail) {
                    if ($check_pvdetail->Remaining == 0) {
                        $find_config = 'The amount against invoice ' . $invoic[$x] . ' is fully paid';
                        return request()->json(200, $find_config);
                    }
                }
            }
            $theRest = substr($invoices, 5);

            $params = [
                'CompanyID' => company_id(),
                'PVID' => $final_PoCode,
                'VoucherDate' => $date,
                'AccountID' => $pay_against[0],
                'PaymentAgainst' => $pay_against[1],
                'InvoiceNumber' => $theRest,
                'Amount' => $amount,
                'MethodType' => $method_typ[1],
                'MethodAccountID' => $method_typ[0],
                'Naration' => $narration,
                'SalesPerson' => $salesperson,
                'CreatedBy' => username(),
                'CreatedOn' => $update_date,
                'Session' => $session,
                'ChqDate' => $chq_date,
                'ChqNumber' => $chq_number,
                'Status' => 'Not Verified',
                'TaxAmount' => $tax_totalamount,
                'TaxID' => $taxagin[0],
            ];
            $result = insert_payment_voucher($params);

            if ($result) {
                $invoices1 = explode("|", $invoices);

                for ($x = 1; $x < count($invoices1); $x++) {
                    $invoic = explode("|", $invoices);
                    $remaining_amoun = explode("|", $remaining_amount);
                    $invoice_amoun = explode("|", $invoice_amount);


                    $find_invid = DB::connection('sqlsrv3')->table("ReceivingOrder")->select('POID', 'TotalAmount')->where('FormID', $invoic[$x])->where('CompanyID', '=', company_id())->get();
                    foreach ($find_invid as $find_invid1) {

                    }

                    $find_po_exists = DB::connection('sqlsrv3')->table("PurchaseOrder")->where('PurchaseOrderID', $find_invid1->POID)->where('CompanyID', '=', company_id())->exists();

                    if ($find_po_exists) {
                        $find_po_sum = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('PoCode')->where('PurchaseOrderID', $find_invid1->POID)->where('CompanyID', '=', company_id())->get();
                        foreach ($find_po_sum as $find_po_sum1) {

                        }
                        $po__id = $find_po_sum1->PoCode;
                    }
                    $pv_items[] = [
                        'CompanyID' => company_id(),
                        'PID' => $result,
                        'Date' => $date,
                        'Amount' => $invoice_amoun[$x],
                        'PVNO' => $final_PoCode,
                        'Remaining' => $remaining_amoun[$x] - $invoice_amoun[$x],
                        'AgainstPO' => $po__id,
                        'AgainstINV' => $invoic[$x],
                    ];
                    $result1 = DB::connection('sqlsrv3')->update('update PaymentVoucherDetail set AgainstINV=? where CompanyID=? and AgainstPO=? and AgainstINV=?', [$invoic[$x], company_id(), $po__id, '']);
                }
                insert_payment_voucher_items($pv_items);

            }
        }

        $find_detail1 = DB::connection('sqlsrv3')->table("PaymentVoucher")->where('CompanyID', '=', company_id())->where('PVID', $final_PoCode)->orderBy('PaymentVoucherID', 'desc')->first();

        //Helper of insert sequence voucher
        insert_sequencevoucher($final_PoCode, $find_detail1->PaymentVoucherID, 'Payment Voucher');
        $update_date = long_date();
        $doc_date = short_date();

        $result1 = DB::connection('sqlsrv3')->update('update PaymentVoucher set Status=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and PaymentVoucherID=?', ['Approved', username(), $update_date, company_id(), $find_detail1->PaymentVoucherID]);
        if ($result1) {

            $final_PoCode0 = $find_detail1->PVID;
            $vendor_name0 = $find_detail1->PaymentAgainst;
            $against_invoice0 = $find_detail1->InvoiceNumber;
            $narration0 = $find_detail1->Naration;

            $method_type0 = $find_detail1->MethodType;
            $chq_date0 = $find_detail1->ChqDate;
            $chq_number0 = $find_detail1->ChqNumber;
            $pay_against0 = $find_detail1->AccountID;
            $amount0 = $find_detail1->Amount;
            $method_typ0 = $find_detail1->MethodAccountID;

            // accounts
            if ($method_type == '101001001001_Cash in Hand') {
                $find_ledger = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('CompanyID', '=', company_id())->where('PVAfterVerify', '=', $find_detail1->PaymentVoucherID)->exists();
                if (!$find_ledger) {
                    $doc = DB::connection('sqlsrv3')
                        ->table('Documents')
                        ->insertGetId([
                            'DocumentDate' => $doc_date,
                            'DocumentNo' => $final_PoCode0,
                            'Description' => 'Payment To ' . $vendor_name0 . '/Invoice #' . $against_invoice0 . '/' . $narration0,
                            'DocumentType' => 'Payment Voucher',
                            'InsertedAt' => $update_date,
                            'InsertedBy' => username(),
                            'CompanyID' => company_id(),
                        ]);

                    if ($doc) {
                        $transaction = DB::connection('sqlsrv3')
                            ->table('Transactions')
                            ->insertGetId([
                                'DocumentID' => $doc,
                                'TransactionDate' => $doc_date,
                                'Description' => 'Payment To ' . $vendor_name0 . ' Through ' . $method_type0 . '/' . $narration0 . '/ Against ' . $against_invoice0,
                                'CompanyID' => company_id(),
                            ]);

                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID,PVAfterVerify) values (?,?,?,?,?,?)', [$transaction, $pay_against0, 'D', $amount0, company_id(), $find_detail1->PaymentVoucherID]);
                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID,PVAfterVerify) values (?,?,?,?,?,?)', [$transaction, $method_typ0, 'C', $amount0 - $find_detail1->TaxAmount, company_id(), $find_detail1->PaymentVoucherID]);
                        if ($find_detail1->TaxAmount != 0) {
                            $ledger_entry3 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID,PVAfterVerify) values (?,?,?,?,?,?)', [$transaction, $find_detail1->TaxID, 'C', $find_detail1->TaxAmount, company_id(), $find_detail1->PaymentVoucherID]);
                        }
                    }
                }
            } else {
                $status2 = 'Chq Paid';
                DB::connection('sqlsrv3')->insert('INSERT INTO TempBank(PVID,VendorId,VendorName,ChqNo,ChqDate,ChqAmount,ClearanceAccountID,ClearanceAccountName,Status,RefID,RefType) values (?,?,?,?,?,?,?,?,?,?,?)', [$final_PoCode, $pay_against[0], $pay_against[1], $chq_number, $chq_date, $amount, $method_typ[0], $method_typ[1], $status2, $find_detail1->PaymentVoucherID, 'Payment Voucher']);
            }
        }
        $find_config = 'submitted';
        return request()->json(200, $find_config);
    }

    public function fetch_dashboard_TopConsumedItem()
    {
        $myJSON = DB::connection('sqlsrv3')->select("EXEC  [dbo].[TopConsumedItem]");
        return request()->json(200, $myJSON);
    }

    public function fetch_dashboard_TopItem()
    {
        $myJSON = DB::connection('sqlsrv3')->select("EXEC  [dbo].[TopItem]  @compid = N'" . company_id() . "' ");
        return request()->json(200, $myJSON);
    }

    public function fetch_dashboard_TopCategoryInventory()
    {
        $myJSON = DB::connection('sqlsrv3')->select("EXEC  [dbo].[TopCategory_Inventory]  @compid = N'" . company_id() . "' ");
        return request()->json(200, $myJSON);
    }

    public function fetch_dashboard_TopAssetCategory()
    {
        $myJSON = DB::connection('sqlsrv3')->select("EXEC  [dbo].[TopAssetCategory_Inventory]  @compid = N'" . company_id() . "' ");
        return request()->json(200, $myJSON);
    }

    public function Assets_D()
    {
        $myJSON = DB::connection('sqlsrv3')->select("EXEC  [dbo].[Assets_Details]");
        return request()->json(200, $myJSON);
    }

    public function Assets_Detail_CategoryWi()
    {
        $myJSON = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[RemainingAssets_CategoryWi]");

        return request()->json(200, $myJSON);
    }

    public function RemainingAssets_Dashboard($name)
    {

        $myJSON = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[RemainingAssets_Dashboard]  @CompID = N'" . company_id() . "',
@Name = N'" . $name . "'");

        return request()->json(200, $myJSON);
    }

    public function accounts_upd_req_sts_completion(Request $request)
    {

        $req_id = $request->get('reqId');
        $req_sts = $request->get('sts');


        $update_date = long_date();
        $check = DB::connection('sqlsrv3')->table("Requisition")->where("CompanyID", '=', company_id())->where("DemandRID", '=', $req_id)->exists();
        if ($check) {
            $service11 = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('RequisitionType', '=', 'Services')->where('DemandRID', '=', $req_id)->select('RequisitionId')->get();
            foreach ($service11 as $service22) {

            }
            $check1 = DB::connection('sqlsrv3')->table("PurchaseOrder")->where("CompanyID", '=', company_id())->where("AgainstReq", '=', $service22->RequisitionId)->exists();
            if ($check1) {
                $result = DB::connection('sqlsrv3')->update('update DemandRequisition set Status2=?,ApprovedBy=?,ApprovedOn=? where CompanyID=? and RequisitionId=?', [$req_sts, username(), $update_date, company_id(), $req_id]);
                if ($result) {
                    $service = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $req_id)->get();
                    foreach ($service as $service1) {

                    }

                    $result1 = DB::connection('sqlsrv3')->update('update Requisition set Status2=?,ApprovedBy=?,ApprovedOn=? where CompanyID=? and DemandRID=?', [$req_sts, username(), $update_date, company_id(), $req_id]);
                    if ($result1) {

                        $result10 = DB::connection('sqlsrv3')->update('update PurchaseOrder set Status2=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and AgainstReq=?', [$req_sts, username(), $update_date, company_id(), $service22->RequisitionId]);
                        if ($result10) {

                            $message = "Status updated!";
                            return request()->json(200, $message);
                        }
                    }
                }
            }

        }


    }


    public function fetch_journals_detail($vendor)
    {


        $vendo = explode("_", $vendor);
        $find_config = DB::connection('sqlsrv3')->table("JournalVoucherDetail")->join('JournalVoucher', 'JournalVoucher.JournalVoucherID', '=', 'JournalVoucherDetail.JournalVoucherID')->where('JournalVoucherDetail.AccountID', '=', $vendo[0])->where('JournalVoucherDetail.credit_amount', '!=', 0)->where('JournalVoucher.Status', '=', 'Approved')->select('JVID as PoCode')->orderby('JVID', 'desc')->get();
        return request()->json(200, $find_config);
    }

    public function get_pdcpayable_detail()
    {
        $result = DB::connection('sqlsrv3')->table('TempBank')->where("Status", '!=', 'Clearanced')->orderby("ID", "desc")->paginate(10);

        return request()->json(200, $result);
    }

    public function getsinglepdcpayable($id)
    {
        $result = DB::connection('sqlsrv3')->table('TempBank')->where('ID', '=', $id)->get();

        return request()->json(200, $result);
    }

    public function submit_pdcclearancedetails(Request $request)
    {
        $id = $request->get('id');
        $stat = $request->get('Deposit_Bank');
        $update_date = long_date();
        $doc_date = short_date();
        $Clearance_Date = long_date();
        $status = 'Clearanced';
        $response = null;

        if ($stat == 'Clearanced') {
            $find_vendor1 = DB::connection('sqlsrv3')->table("TempBank")->where('ID', '=', $id)->orderBy('ID', 'DESC')->first();

            if ($find_vendor1->ChqAmount < 0) {
                $find_config = 'Amount Cannot be Negative';
                return request()->json(200, $find_config);
            }
            if ($find_vendor1->RefType == 'Recovery Refund') {
                $find_detail1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $find_vendor1->RefID)->orderBy('ID', 'DESC')->first();

                $final_PoCode0 = $find_detail1->PVID;

                $amount0 = $find_detail1->PaidAmount;
                $name = $find_detail1->Name;
                if ($find_vendor1->Receipt_Type != 'Extra Amount Refund' && isLive()) {
                    DB::connection('sqlsrv4')->insert('INSERT INTO Voucher(VoucherNo,Name,Father_Name,Contact,Amount,PaymentType,Project,File_Plot_Id,Module,Type,Description,DateTime,Bank,Ch_Pay_Draft_No,Ch_Pay_Draft_Date) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$final_PoCode0, $name, $find_detail1->Father_Name, $find_detail1->Contact, $amount0, 'Cheque', $find_detail1->Project, $find_detail1->File_Plot_No, $find_detail1->Module, 'Receipt_Refund', 'Amount Refund Against the ' . $find_detail1->ReceiptNo . ' of Plot No ' . $find_detail1->File_Plot_No . ' and owner name is ' . $name . ' from New System', $update_date, $find_vendor1->ClearanceAccountID, $find_vendor1->ClearanceAccountName, $Clearance_Date]);
                }

            } else if ($find_vendor1->RefType == 'Cancellation Refund') {
                $find_detail1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $find_vendor1->RefID)->orderBy('ID', 'DESC')->first();

                $final_PoCode0 = $find_detail1->PVID;

                $amount0 = $find_detail1->PaidAmount;
                $name = $find_detail1->Name;
                if (isLive()) {
                    DB::connection('sqlsrv4')->insert('INSERT INTO Voucher(VoucherNo,Name,Father_Name,Contact,Amount,PaymentType,Project,File_Plot_Id,Module,Type,Description,DateTime,Bank,Ch_Pay_Draft_No,Ch_Pay_Draft_Date) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$final_PoCode0, $name, $find_detail1->Father_Name, $find_detail1->Contact, $amount0, 'Cheque', $find_detail1->Project, $find_detail1->File_Plot_No, $find_detail1->Module, 'Cancellation', 'Against Cancellation the ' . $find_detail1->ReceiptNo . ' of Plot No ' . $find_detail1->File_Plot_No . ' and owner name is ' . $name . ' from New System', $update_date, $find_vendor1->ClearanceAccountID, $find_vendor1->ClearanceAccountName, $Clearance_Date]);
                }
            }


            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $find_vendor1->PVID, 'Payment To ' . $find_vendor1->VendorName . '/Through #' . $find_vendor1->PVID, 'Payment Voucher', $update_date, username(), company_id()]);

            if ($doc) {

                $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $find_vendor1->PVID)->orderBy('ID', 'DESC')->first();


                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Payment To ' . $find_vendor1->VendorName . '/Through #' . $find_vendor1->PVID . '/with Chq number#' . $find_vendor1->ChqNo . '/with Chq date#' . $find_vendor1->ChqDate, company_id()]);

                $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                if ($find_vendor1->RefType == 'Payment Voucher') {
                    $get_arr1 = DB::connection('sqlsrv3')->table("PaymentVoucher")->where("CompanyID", '=', company_id())->where("PVID", '=', $find_vendor1->PVID)->orderBy('PaymentVoucherID', 'desc')->first();

                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID,PVAfterVerify) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_vendor1->VendorId, 'D', $find_vendor1->ChqAmount, company_id(), $get_arr1->PaymentVoucherID]);

                    $get_arr1 = DB::connection('sqlsrv3')->table("PaymentVoucher")->where("CompanyID", '=', company_id())->where("PVID", '=', $find_vendor1->PVID)->orderBy('PaymentVoucherID', 'desc')->first();

                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID,PVAfterVerify) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_vendor1->ClearanceAccountID, 'C', $find_vendor1->ChqAmount - $get_arr1->TaxAmount, company_id(), $get_arr1->PaymentVoucherID]);

                    if ($get_arr1->TaxAmount != 0) {
                        $ledger_entry3 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID,PVAfterVerify) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $get_arr1->TaxID, 'C', $get_arr1->TaxAmount, company_id(), $get_arr1->PaymentVoucherID]);
                    }

                } else {
                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_vendor1->VendorId, 'D', $find_vendor1->ChqAmount, company_id()]);
                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_vendor1->ClearanceAccountID, 'C', $find_vendor1->ChqAmount, company_id()]);
                }


            }

            $result = DB::connection('sqlsrv3')->update("UPDATE TempBank SET Status=?,ClearanceDate=?,Clearanceby=? WHERE ID=?", [$stat, $Clearance_Date, username(), $id]);

            if ($result) {
                $find_config = 'Clearance';
                return request()->json(200, $find_config);
            }

        } else {
            if ($stat == 'Dishonered') {
                $find_vendor1 = DB::connection('sqlsrv3')->table("TempBank")->where('ID', '=', $id)->orderBy('ID', 'DESC')->first();

                if ($find_vendor1->ChqAmount < 0) {
                    $find_config = 'Amount Cannot be Negative';
                    return request()->json(200, $find_config);
                }
                if (!empty($find_vendor1->RefType == 'Land Payment')) {
                    $find_pre_check = DB::connection("sqlsrv3")->table("LandInformation")->where("ID", '=', $find_vendor1->RefID)->exists();
                    if ($find_pre_check) {
                        $find_pre_detail1 = DB::connection("sqlsrv3")->table("LandInformation")->where("ID", '=', $find_vendor1->RefID)->orderBy('ID', 'DESC')->first();

                        $paid_total = $find_pre_detail1->TotalPaid - $find_vendor1->ChqAmount;
                        $remaining_total = $find_pre_detail1->Remaining + $find_vendor1->ChqAmount;


                        $result = DB::connection('sqlsrv3')->update('update LandInformation set TotalPaid=?,Remaining=? where  ID=?', [$paid_total, $remaining_total, $find_pre_detail1->ID]);

                    }

                } else if (!empty($find_vendor1->RefType == 'Cancellation Refund' || $find_vendor1->RefType == 'Recovery Refund' || $find_vendor1->RefType == 'Repurchased Refund')) {
                    $find_pre_check = DB::connection("sqlsrv3")->table("TempCancellation_Receipts")->where("ID", '=', $find_vendor1->RefID)->exists();
                    $find_pre_check1 = DB::connection("sqlsrv3")->table("TempCancellation_Receipts")->where("ID", '=', $find_vendor1->RefID)->where('PVID', '=', $find_vendor1->PVID)->exists();
                    if ($find_pre_check1) {
                        $find_pre_detail1 = DB::connection("sqlsrv3")->table("TempCancellation_Receipts")->where("ID", '=', $find_vendor1->RefID)->where('PVID', '=', $find_vendor1->PVID)->orderBy('ID', 'DESC')->first();

                        $remaining_total = $find_pre_detail1->RemainingAmount + $find_vendor1->ChqAmount;
                        $paid_amount = $find_pre_detail1->PaidAmount - $find_vendor1->ChqAmount;

                        $result = DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set RemainingAmount=?, PaidAmount=?, AccountID=?, PVID=? where  ID=?', [$remaining_total, $paid_amount, NULL, NULL, $find_pre_detail1->ID]);

                    } else if ($find_pre_check) {
                        $find_pre_detail1 = DB::connection("sqlsrv3")->table("TempCancellation_Receipts")->where("ID", '=', $find_vendor1->RefID)->orderBy('ID', 'DESC')->first();

                        $remaining_total = $find_pre_detail1->RemainingAmount + $find_vendor1->ChqAmount;


                        $result = DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set RemainingAmount=? where  ID=?', [$remaining_total, $find_pre_detail1->ID]);

                    }

                }

                // for Payment Voucher Dishonored Cheque
                $cheque_pv = [];
                $get_arrcheck = DB::connection('sqlsrv3')
                    ->table("PaymentVoucher")
                    ->where("CompanyID", '=', company_id())
                    ->where("PVID", '=', $find_vendor1->PVID)
                    ->select('PaymentVoucherID')
                    ->first();
                if ($get_arrcheck) {
                    $result = DB::connection('sqlsrv3')->table('PaymentVoucherDetail')->where('PID', '=', $get_arrcheck->PaymentVoucherID)->get();
                    foreach ($result as $result1) {
                        $cheque_pv[] = [
                            'CompanyID' => company_id(),
                            'Date' => $doc_date,
                            'Amount' => $result1->Amount,
                            'PVNO' => 'Dishonored',
                            'Remaining' => $result1->Remaining + $result1->Amount,
                            'AgainstINV' => $result1->AgainstINV,
                            'AgainstPO' => $result1->AgainstPO,
                            'AgainstJV' => $result1->AgainstJV
                        ];
                    }
                    //  call Payment Voucher Detail Helper
                    insert_payment_voucher_items($cheque_pv);

                }

                $result = DB::connection('sqlsrv3')->update("UPDATE TempBank SET Status=?,ClearanceDate=?,Clearanceby=? WHERE ID=?", [$stat, $Clearance_Date, username(), $id]);
                if ($result) {
                    $find_config = 'Dishonered';
                    return request()->json(200, $find_config);
                }
            }
        }
    }

    public
    function land_add_seller(Request $request)
    {
        $update_date = long_date();
        $seller_name = $request->get('customer_name');
        $c_mobile = $request->get('c_mobile');
        $c_cnic = $request->get('cnic');


        $isseller_name = DB::connection('sqlsrv3')->table("Seller")->where("SellerName", "=", $seller_name)->exists();
        if ($isseller_name) {
            $find_config = "Seller Name Already exist";
            return request()->json(200, $find_config);
        }


        $result = DB::connection('sqlsrv3')->insert('INSERT INTO Seller(SellerName,Mobile,CNIC, CreatedBy, CreatedOn) values (?,?,?,?,?)', [$seller_name, $c_mobile, $c_cnic, username(), $update_date]);
        if ($result) {
            $top_head = 'Sellers';
            $type = 'Liabilities';

            $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountHead', '=', $top_head)->exists();
            if ($find_last_head_code9) {
                $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountHead', '=', $top_head)->get();
                foreach ($find_last_head_code as $find_last_head_code1) {

                }
                $account_code = $find_last_head_code1->ID + 1;


                $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountName', '=', $top_head)->get();
                foreach ($find_head_name as $find_head_name1) {

                }
            } else {
                $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountName', '=', $top_head)->get();
                foreach ($find_head_name as $find_head_name1) {

                }
                $account_code = $find_head_name1->ID . '001';

            }


            $result = DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(), $seller_name, $type, $find_head_name1->ID, $find_head_name1->AccountName, 'Transaction']);
            $data = "Seller Added Successfully";
            return request()->json(200, $data);
        }


    }

    public
    function accounts_seller_detail()
    {

        $can = DB::connection('sqlsrv3')->table('Seller')
            ->orderBy('SellerID', 'desc')
            ->paginate(20);
        return request()->json(200, $can);
    }

    public
    function fetch_seller($id)
    {
        $cus = DB::connection('sqlsrv3')->table('Seller')->where('SellerID', '=', $id)->get();
        return request()->json(200, $cus);
    }

    public
    function get_seller()
    {
        $arr = DB::connection('sqlsrv3')->table('Seller')->get();
        return request()->json(200, $arr);
    }

    public
    function insert_land_information(Request $request)
    {


        $update_date = long_date();
        $docdate = short_date();
        $kanal = $request->get('kanaltemp');
        $marla = $request->get('marlatemp');
        $sqft = $request->get('sqfttemp');
        $khewat = $request->get('khewattemp');
        $khewatnew = $request->get('khewatnew');
        $khotoninew = $request->get('khotoninew');


        $additional_price = $request->get('additional_price');

        $installment_datetemp = $request->get('installment_datetemp');
        $installment_amounttemp = $request->get('installment_amounttemp');


        $seller_name = $request->get('seller_name');
        $deal_no = $request->get('deal_no');
        $moza_no = $request->get('moza_no');
        $maraba_no = $request->get('maraba_no');
        $khasra_no = $request->get('khasra_no');
        $acre_price = $request->get('acre_price');
        $p_status = $request->get('p_status');
        $litigation = $request->get('litigation');
        $remarks = $request->get('remarks');


        $kanai = explode("|", $kanal);
        $marli = explode("|", $marla);
        $sqfi = explode("|", $sqft);
        $acre = explode("|", $khewat);


        $insta = explode("|", $installment_amounttemp);
        $installamt = array_sum($insta);


        $k = array_sum($kanai);
        $m = array_sum($marli);
        $sf = array_sum($sqfi);
        $ac = array_sum($acre);


        $totalarea = $ac + ($k * 0.125) + (($m / 20) / 8) + ((($sf / 225) / 20) / 8);

        $totalprice = $additional_price + ($totalarea * $acre_price);

        if ($installamt != round($totalprice)) {
            $arr = 'Empty field';
            return request()->json(200, $arr);
        }


        $result = DB::connection('sqlsrv3')->insert('INSERT INTO LandInformation(SellerName,DealNo, MozaNo, MarabaNo, KhasraNo, TotalArea, AcrePrice,TotalPrice,PossessionStatus,AnyLitigation,Remarks,CreatedBy,CreatedOn,Status,Khewat,Khotoni,AdditionalCharges,DocDate) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$seller_name, $deal_no, $moza_no, $maraba_no, $khasra_no, $totalarea, $acre_price, $totalprice, $p_status, $litigation, $remarks, username(), $update_date, 'Pending', $khewatnew, $khotoninew, $additional_price, $docdate]);
        if ($result) {
            $find_id = DB::connection('sqlsrv3')->table('LandInformation')->where('SellerName', '=', $seller_name)->get();
            foreach ($find_id as $find_id1) {

            }

            $installment_amounttemp1 = explode("|", $installment_amounttemp);
            for ($x = 1; $x < count($installment_amounttemp1); $x++) {
                $installment_date = explode("|", $installment_datetemp);
                $installment_amount = explode("|", $installment_amounttemp);

                DB::connection('sqlsrv3')->insert('INSERT INTO LandInstallmentDetail(LandID,InstallmentDate, InstallmentAmount, CreatedBy, CreatedOn,istatus) values (?,?,?,?,?,?)', [$find_id1->ID, $installment_date[$x], $installment_amount[$x], username(), $update_date, 'Pending']);

            }

            $kanal1 = explode("|", $kanal);
            for ($y = 1; $y < count($kanal1); $y++) {

                $kana = explode("|", $kanal);
                $marl = explode("|", $marla);
                $sqf = explode("|", $sqft);
                $khewa = explode("|", $khewat);


                DB::connection('sqlsrv3')->insert('INSERT INTO LandAreaDetail(LandID,Kanal, Marla,SQFT,Acre,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?)', [$find_id1->ID, $kana[$y], $marl[$y], $sqf[$y], $khewa[$y], username(), $update_date]);

            }

            $arr = 'submitted';
            return request()->json(200, $arr);


        }
    }

    public
    function land_detail()
    {
        $can = DB::connection('sqlsrv3')->table('LandInformation')
            ->orderBy('ID', 'desc')
            ->paginate(50);
        return request()->json(200, $can);
    }

    public
    function check_land_total_amount(Request $request)
    {
        $kanal = $request->get('kanaltemp');
        $marla = $request->get('marlatemp');
        $sqft = $request->get('sqfttemp');
        $acre = $request->get('khewattemp');

        $areaprice = $request->get('acre_price');
        $additional_price = $request->get('additional_price');

        $kanai = explode("|", $kanal);
        $marli = explode("|", $marla);
        $sqfi = explode("|", $sqft);
        $ac = explode("|", $acre);


        $acr = array_sum($ac);
        $k = array_sum($kanai);
        $m = array_sum($marli);
        $sf = array_sum($sqfi);
        $totalarea = $acr + ($k * 0.125) + (($m / 20) / 8) + ((($sf / 225) / 20) / 8);
        $tot_amount = $additional_price + ($totalarea * $areaprice);
        $myJSON = array(
            'tot_area' => $totalarea,
            'tot_amount' => $tot_amount,
        );
        return request()->json(200, $myJSON);
    }

    public
    function get_land_installment($id)
    {
        $cand = DB::connection('sqlsrv3')->table('LandInstallmentDetail')->where('LandID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public
    function get_landinformation_area_data($id)
    {
        $cand = DB::connection('sqlsrv3')->table('LandAreaDetail')->where('LandID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public
    function get_landinformation_installment_data($id)
    {
        $cand = DB::connection('sqlsrv3')->table('LandInstallmentDetail')->where('LandID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public
    function get_landinformation_data($id)
    {
        $cand = DB::connection('sqlsrv3')->table('LandInformation')->where('ID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public
    function update_land_information(Request $request)
    {
        $get_id = $request->get('get_id');
        $sts = $request->get('sts');


        $update_date = long_date();

        $find_prefix = DB::connection('sqlsrv3')->table("LandInformation")->select('DealNo')->where('DealNo', '!=', null)->get();
        foreach ($find_prefix as $find_prefix1) {

        }

        $dealno = explode("_", $find_prefix1->DealNo);
        $deal_number = $dealno[1] + 1;
        $req_prefix = 'Deal_' . $deal_number;
        $result9 = DB::connection('sqlsrv3')->update('update  LandInformation set DealNo=?,Status=?,Remaining=TotalPrice where ID=?', [$req_prefix, $sts, $get_id]);
        if ($result9) {

            $top_head = 'Deals';
            $type = 'Assets';

            $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountHead', '=', $top_head)->exists();
            if ($find_last_head_code9) {
                $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountHead', '=', $top_head)->get();
                foreach ($find_last_head_code as $find_last_head_code1) {

                }
                $account_code = $find_last_head_code1->ID + 1;


                $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountName', '=', $top_head)->get();
                foreach ($find_head_name as $find_head_name1) {

                }
            } else {
                $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountName', '=', $top_head)->get();
                foreach ($find_head_name as $find_head_name1) {

                }
                $account_code = $find_head_name1->ID . '001';

            }

            $result = DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(), $req_prefix, $type, $find_head_name1->ID, $find_head_name1->AccountName, 'Transaction']);


            $find_deal_information = DB::connection('sqlsrv3')->table("LandInformation")->where('ID', '=', $get_id)->get();
            foreach ($find_deal_information as $find_deal_information1) {

            }


            $find_deal_installment = DB::connection('sqlsrv3')->table("LandInstallmentDetail")->where('LandID', '=', $get_id)->get();
            foreach ($find_deal_installment as $find_deal_installment1) {


                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$find_deal_installment1->InstallmentDate, $find_deal_information1->DealNo, 'Land Payable Booking of ' . $find_deal_information1->SellerName . '/ Against Deal No #' . $find_deal_information1->DealNo, 'Land Booking', $update_date, username(), company_id()]);

                if ($doc) {
                    $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $find_deal_information1->DealNo)->get();
                    foreach ($find_doc_id as $find_doc_id1) {

                    }


                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $find_deal_installment1->InstallmentDate, 'Land Payable Booking of ' . $find_deal_information1->SellerName . '/ Against Deal No #' . $find_deal_information1->DealNo, company_id()]);

                    $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                    foreach ($find_tran_id as $find_tran_id1) {

                    }
                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $find_deal_information1->DealNo)->get();
                    foreach ($find_acc_code as $find_acc_code1) {

                    }

                    $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Liabilities')->where('AccountName', '=', $find_deal_information1->SellerName)->get();
                    foreach ($find_acc_code9 as $find_acc_code91) {

                    }


                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'D', $find_deal_installment1->InstallmentAmount, company_id()]);

                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->ID, 'C', $find_deal_installment1->InstallmentAmount, company_id()]);


                }


            }

            return request()->json(200, 'Status updated!');

        }

    }

    public
    function submit_paid_landpayment(Request $request)
    {

        $id = $request->get("id");
        $limit1 = $request->get("limit");
        $paid_amount = $request->get("paid_amount");
        $dept = $request->get("dept");
        $method = $request->get("method");
        $chq_date = $request->get("chq_date");
        $chq_number = $request->get("chq_number");


        if ($paid_amount > $limit1) {
            $arr = "Paid Amount cannot greater then limit";
            return request()->json(200, $arr);
        }

        $find_prefix = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('PaymentVoucher')->where('CompanyID', '=', company_id())->get();
        foreach ($find_prefix as $find_prefix1) {

        }
        $date_pref = $this->shiftformat();
        $req_prefix = $find_prefix1->PaymentVoucher . '_' . $date_pref;

        $find_rid9 = DB::connection('sqlsrv3')->table("SequenceVoucher")->where('CompanyID', '=', company_id())->exists();
        if ($find_rid9) {
            $find_rid = DB::connection('sqlsrv3')->table("SequenceVoucher")->select('PVID')->where('CompanyID', '=', company_id())->get();
            foreach ($find_rid as $find_rid1) {

            }
            $pre_id = explode("-", $find_rid1->PVID);
            $rid = $pre_id[1] + 1;

        } else {
            $rid = 1;
        }
        $final_PoCode = $req_prefix . '-' . $rid;


        DB::connection('sqlsrv3')->insert('INSERT INTO SequenceVoucher(PVID,RefID,RefType,CompanyID,MonthId) values (?,?,?,?,?)', [$final_PoCode, $id, 'Land Payment', company_id(), $date_pref]);


        $update_date = long_date();
        $doc_date = short_date();


        $find_pre_detail = DB::connection("sqlsrv3")->table("LandInformation")->where("ID", '=', $id)->get();
        foreach ($find_pre_detail as $find_pre_detail1) {

        }
        $paid_total = $find_pre_detail1->TotalPaid + $paid_amount;
        $remaining_total = $find_pre_detail1->Remaining - $paid_amount;


        $result = DB::connection('sqlsrv3')->update('update LandInformation set PaidAmount=?,PVID=?,UpdatedBy=?,UpdatedOn=?,TotalPaid=?,Remaining=? where  ID=?', [$paid_amount, $final_PoCode, username(), $doc_date, $paid_total, $remaining_total, $id]);

        if ($result) {
            $security = DB::connection('sqlsrv3')->table('LandInstallmentDetail')->select('ID', 'InstallmentAmount')->where('LandID', '=', $id)->exists();
            if ($security) {
                $x = 0;
                $cand = DB::connection('sqlsrv3')->table('LandInstallmentDetail')->select('ID', 'InstallmentAmount')->where('LandID', '=', $id)->get();

                for ($B = $paid_total; $B > 0; $x++) {

                    if ($cand[$x]->InstallmentAmount <= $B) {
                        $check = DB::connection('sqlsrv3')->table('LandInstallmentDetail')->where('ID', '=', $cand[$x]->ID)->update(['istatus' => 'paid']);
                        $B = $B - $cand[$x]->InstallmentAmount;

                    } else if ($cand[$x]->InstallmentAmount > $B) {
                        $check = DB::connection('sqlsrv3')->table('LandInstallmentDetail')->where('ID', '=', $cand[$x]->ID)
                            ->update(['istatus' => 'partial']);
                        $B = 0;
                    }
                }
            }


            if ($method == '101001001001_Cash in Hand') {


                $limit = $limit1;


                $update_date = long_date();
                $doc_date = short_date();


                $doc1 = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode, 'Paid Land payment to ' . $dept, 'Land Payment', $update_date, username(), company_id()]);

                if ($doc1) {
                    $find_doc_id2 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('DocumentNo', '=', $final_PoCode)->get();
                    foreach ($find_doc_id2 as $find_doc_id21) {

                    }
                    $transaction1 = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id21->ID, $doc_date, 'Paid Land payment to ' . $dept, company_id()]);

                    $find_tran_id2 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id21->ID)->get();
                    foreach ($find_tran_id2 as $find_tran_id21) {

                    }

                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountHead', '=', 'Sellers')->where('AccountName', '=', $dept)->get();
                    foreach ($find_acc_code as $find_acc_code1) {

                    }

                    $ledger_entry3 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id21->ID, $find_acc_code1->ID, 'D', $paid_amount, company_id()]);
                    $cash_hand = '101001001001';
                    $ledger_entry4 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id21->ID, $cash_hand, 'C', $paid_amount, company_id()]);

                }

            } else {
                $status2 = 'Chq Paid';
                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountHead', '=', 'Sellers')->where('AccountName', '=', $dept)->get();
                foreach ($find_acc_code as $find_acc_code1) {

                }
                $method1 = explode("_", $method);
                DB::connection('sqlsrv3')->insert('INSERT INTO TempBank(PVID,VendorId,VendorName,ChqNo,ChqDate,ChqAmount,ClearanceAccountID,ClearanceAccountName,Status,RefID,RefType) values (?,?,?,?,?,?,?,?,?,?,?)', [$final_PoCode, $find_acc_code1->ID, $dept, $chq_number, $chq_date, $paid_amount, $method1[0], $method1[1], $status2, $id, 'Land Payment']);
            }
            $arr = 'Updated';
            return request()->json(200, $arr);

        }
    }

    public
    function fetch_journal_data_assets($journal_id)
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountCode', 'like', $journal_id . '%')->orderby('ID', 'Asc')->get();

        return request()->json(200, $find_journal_headname);
    }

    public
    function fetch_journal_data_assets_unique($journal_id)
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountCode', '=', $journal_id)->where('CoaType', '=', 'Node')->select('ID', 'AccountName')->orderby('ID', 'asc')->get();

        return request()->json(200, $find_journal_headname);
    }

    public
    function searchpdcdate($startingdate, $closingdate)
    {
        $find_config = DB::connection('sqlsrv3')->table("TempBank")->where("Status", '!=', 'Clearanced')->where('ChqDate', '>=', $startingdate)->where('ChqDate', '<=', $closingdate)->paginate(10);
        return request()->json(200, $find_config);
    }

    public
    function payment_detail()
    {


        $doc_date = short_date();
        $session = ac_c_session();

        $find_config = DB::connection('sqlsrv3')->table("PaymentVoucher")->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('VoucherDate', '=', $doc_date)->orderby('PaymentVoucherID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function search_payment_date($from, $to)
    {


        $session = ac_c_session();

        $find_config = DB::connection('sqlsrv3')->table("PaymentVoucher")->where('CompanyID', '=', company_id())
            // ->where('Session', '=', $session)
            ->where('VoucherDate', '>=', $from)->where('VoucherDate', '<=', $to)->orderby('PaymentVoucherID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function received_detail()
    {

        $session = ac_c_session();

        $find_config = DB::connection('sqlsrv3')->table("ReceivedVoucher")->where('CompanyID', '=', company_id())
            ->where('Session', '=', $session)
            ->orderby('ReceivedVoucherID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function get_services()
    {

        $find_config = DB::connection('sqlsrv3')->table("Accounts")->select('ID', 'AccountName')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Expenses')->orderby('ID', 'asc')->where('CoaType', 'Transaction')->get();
        return request()->json(200, $find_config);
    }

    public
    function fetch_req_type($id)
    {
        $find_config = DB::connection('sqlsrv3')->table("Requisition")->select('RequisitionType', 'RId')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $id)->get();
        return request()->json(200, $find_config);
    }


    public
    function search_generalfilter(Request $request)
    {
        $result = DB::connection('sqlsrv3')->table('TempBank')->where("Status", '!=', 'Clearanced')
            ->where('PVID', 'like', '%' . $request->keyword1 . '%')
            ->orWhere('ChqNo', 'like', '%' . $request->keyword1 . '%')
            ->orWhere('ChqDate', 'like', '%' . $request->keyword1 . '%')
            ->orWhere('RefType', 'like', '%' . $request->keyword1 . '%')
            ->orderby("ID", "desc")->paginate(10);

        return request()->json(200, $result);
    }

    public
    function accType_byName(Request $request)
    {

        $find_config = DB::connection('sqlsrv3')->table("AccountsHead")->select('HeadName', 'HeadCode', 'Description')->where('HeadName', 'like', '%' . $request->name . '%')->where('CompanyID', '=', company_id())->orderby('HeadCode', 'asc')->paginate(8);
        return request()->json(200, $find_config);
    }

    public
    function jurHead_byName(Request $request)
    {

        $find_config = DB::connection('sqlsrv3')->table("HeadJournal")->select('JournalName', 'HeadId', 'journalCode')->where('JournalName', 'like', '%' . $request->jHead . '%')->where('CompanyID', '=', company_id())->orderby('journalCode', 'asc')->paginate(8);
        return request()->json(200, $find_config);
    }

    public
    function session_byName(Request $request)
    {

        $find_config = DB::connection('sqlsrv3')->table("Session")->where('SessionName', 'like', '%' . $request->name . '%')->where('CompanyID', '=', company_id())->orderBy('SessionID', 'desc')->paginate(5);
        return request()->json(200, $find_config);
    }

    public
    function catagory_byName(Request $request)
    {

        $find_config = DB::connection('sqlsrv3')->table("ItemCategory")->where('CategoryName', 'like', '%' . $request->name . '%')->where('CompanyID', '=', company_id())->orderby('CategoryName', 'asc')->paginate(10);
        return request()->json(200, $find_config);
    }

    public
    function update_purchaseorder(Request $request)
    {
        $e_id = $request->get('e_id');
        $quoid = $request->get('quoid');
        $reqid = $request->get('reqid');
        $remarks = $request->get('ed_narration');
        $date = $request->get('date');
        $vendor_n = $request->get('vendor_n');
        $subtotal = $request->get('subtotal');
        $discount = $request->get('discount');
        $tax_amount = $request->get('tax_amount');
        $delivery_amount = $request->get('delivery_amount');
        $total = $request->get('total');
        $status = $request->get('status');

        $update_date = long_date();
        $item_name = $request->get('item_name');
        $quoteqty = $request->get('quoteqty');
        $orderedQty = $request->get('orderedqty');
        $unit_cost = $request->get('unit_cost');
        $detail = $request->get('detail');
        $price = $request->get('price');
        $pro_unit = $request->get('pro_unit');
        $find_config = "";
        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $quoteqty1 = explode("|", $quoteqty);
            $orderedQty1 = explode("|", $orderedQty);
            if ($orderedQty1[$x] > $quoteqty1[$x] || $orderedQty1[$x] == NULL) {
                $find_config = "Quantity error";
                return request()->json(200, $find_config);
            }
        }
        if ($find_config != "Quantity error") {
            $result = DB::connection('sqlsrv3')->update('update PurchaseOrder set AgainstReq=?, AgainstQuo=?, PoDate=?, vendorName=?, SubTotal=?, Discount=?, Tax=?, ShippingCharges=?, TotalAmount=?, Remarks=?, Status=?, UpdatedBy=?, UpdatedOn=? where CompanyID=?  and PurchaseOrderID=? ', [$reqid, $quoid, $date, $vendor_n, $subtotal, $discount, $tax_amount, $delivery_amount, $total, $remarks, $status, username(), $update_date, company_id(), $e_id]);
            if ($result) {
                DB::connection('sqlsrv3')->table('PurchaseOrderItems')->where('CompanyID', '=', company_id())->where('POID', $e_id)->delete();
                $item_name1 = explode("|", $item_name);
                for ($x = 1; $x < count($item_name1); $x++) {
                    $item_nam = explode("|", $item_name);
                    $quoteqty1 = explode("|", $quoteqty);
                    $orderedQty1 = explode("|", $orderedQty);
                    $unit_cost1 = explode("|", $unit_cost);
                    $price1 = explode("|", $price);
                    $detai = explode("|", $detail);
                    $pro_unit1 = explode("|", $pro_unit);
                    $pricetest = $orderedQty1[$x] * $unit_cost1[$x];
                    $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'ID')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                    foreach ($find_itemname as $find_itemname1) {

                    }
                    DB::connection('sqlsrv3')->insert('INSERT INTO PurchaseOrderItems(CompanyID, POID, ItemId, ItemName, QuoteQuantity, Quantity, Unit, Price, SubTotal,Detail) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $e_id, $find_itemname1->ID, $find_itemname1->Name, $quoteqty1[$x], $orderedQty1[$x], $pro_unit1[$x], $unit_cost1[$x], $pricetest, $detai[$x]]);
                }
            }
            $find_config = "PO updated";
        }
        return request()->json(200, $find_config);
    }

    public
    function get_quotationdetaill()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("PQuotation")->join('Requisition', 'PQuotation.RequisitionID', '=', 'Requisition.RequisitionId')->where('PQuotation.CompanyID', '=', company_id())
            // ->where('PQuotation.Session', '=', $session)
            ->where('PQuotation.state', '=', 0)->where('PQuotation.Status', '=', 'finalize')->orderby('PQuotation.QuotationID', 'desc')->select('PQuotation.QuotationID', 'PQuotation.VendorName', 'Requisition.RId')->get();
        return request()->json(200, $find_config);
    }

    public
    function insert_purchase_return(Request $request)
    {


        $id = employee_id();
        $unit = $request->get('unit');
        $cost = $request->get('cost');
        $date = $request->get('date');
        $vendor = $request->get('vendor');
        $invoice_no = $request->get('invoice_no');
        $poid = $request->get('poid');
        $reqid = $request->get('reqid');
        $remarks = $request->get('remarks');
        $status = $request->get('status');
        $subtotal = $request->get('subtotal');
        $discount = $request->get('discount');
        $tax_amount = $request->get('tax_amount');
        $delivery_amount = $request->get('delivery_amount');
        $select_tax = $request->get('select_tax');
        $select_delivery = $request->get('select_delivery');
        $type = $request->get('type');
        $update_date = long_date();
        $doc_date = short_date();
        $session = ac_c_session();

        $total = $request->get('total');

        $item_name = $request->get('item_name');
        $req_id = $request->get('req_id');
        $item_name1 = explode("|", $item_name);
        $ordrqty = $request->get('ordrqty');
        $qty = $request->get('qty');
        for ($x = 1; $x < count($item_name1); $x++) {
            $ordrqt = explode("|", $ordrqty);
            $qt = explode("|", $qty);
            $cosfind = explode("|", $cost);
            $d_value = count($cosfind) - 1;
            $find_ex_amount = $total - $subtotal;
            $item_name1 = explode("|", $item_name);
            $qt = explode("|", $qty);
            $amountt = ($qt[$x] * $cosfind[$x]) + (($find_ex_amount * $qt[$x] * $cosfind[$x]) / $subtotal);
            if ($qt[$x] == '') {
                $message = 'Please enter return quantity';
                return request()->json(200, $message);
            } else if ($qt[$x] > $ordrqt[$x]) {
                $message = 'Return quantity cannot be greater then Ordered quantity';
                return request()->json(200, $message);
            } else if ($amountt < 0 || $total < 0) {
                $message = 'Amount cannot be Negative';
                return request()->json(200, $message);
            }
        }
        $check = DB::connection('sqlsrv3')->table('Issuances')->where('RequisitionId', '=', $req_id)->exists();
        if ($check) {
            $message = 'Issuance Exist against this Invoice';
            return request()->json(200, $message);
        }
        $unit = $request->get('unit');
        $cost = $request->get('cost');
        $date = $request->get('date');
        $vendor = $request->get('vendor');
        $invoice_no = $request->get('invoice_no');
        $poid = $request->get('poid');
        $reqid = $request->get('reqid');
        $remarks = $request->get('remarks');
        $status = $request->get('status');
        $subtotal = $request->get('subtotal');
        $discount = $request->get('discount');
        $tax_amount = $request->get('tax_amount');
        $delivery_amount = $request->get('delivery_amount');
        $total = $request->get('total');
        $select_tax = $request->get('select_tax');
        $select_delivery = $request->get('select_delivery');
        $type = $request->get('type');
        $update_date = long_date();
        $doc_date = short_date();
        $find_prefix = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('CustomerInvoice')->where('CompanyID', '=', company_id())->get();
        foreach ($find_prefix as $find_prefix1) {

        }
        $date_pref = $this->shiftformat();
        $req_prefix = $find_prefix1->CustomerInvoice . '_' . $date_pref;
        $find_rid9 = DB::connection('sqlsrv3')->table("ReceivingOrderReturn")->where('CompanyID', '=', company_id())->exists();
        if ($find_rid9) {
            $find_rid = DB::connection('sqlsrv3')->table("ReceivingOrderReturn")->select('RtnID')->where('CompanyID', '=', company_id())->get();
            foreach ($find_rid as $find_rid1) {

            }
            $pre_id = explode("-", $find_rid1->RtnID);
            $rid = $pre_id[2] + 1;
        } else {
            $rid = 1;
        }
        $final_PoCode = 'RTN-' . $req_prefix . '-' . $rid;

        $result = DB::connection('sqlsrv3')->insert('INSERT INTO ReceivingOrderReturn(CompanyID,Dated,InvID,RtnID,vendorName,InvoiceNo,SubTotal,Discount,Tax,ShippingCharges,TotalAmount,Remarks,CreatedBy,CreatedOn,Session,Status2,Type) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $date, $poid, $final_PoCode, $vendor, $invoice_no, $subtotal, $discount, $tax_amount, $delivery_amount, $total, $remarks, username(), $update_date, $session, 'Verified', $type]);
        if ($result) {
            $find_reqid = DB::connection('sqlsrv3')->table("ReceivingOrderReturn")->select('ReturnOrderID')->where('CompanyID', '=', company_id())->where('InvID', '=', $poid)->where('RtnID', '=', $final_PoCode)->get();
            foreach ($find_reqid as $find_reqid1) {
            }
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $ordrqt = explode("|", $ordrqty);
                $uni = explode("|", $unit);
                $qt = explode("|", $qty);
                $cos = explode("|", $cost);
                $total1 = $qt[$x] * $cos[$x];
                if ($type == 'Goods' || $type == 'Assets') {
                    $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                    foreach ($find_itemname as $find_itemname1) {

                    }
                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO ReceivingReturnItems(CompanyID,RRID,ItemId,ItemName,PoQuantity,Unit,ReturnQuantity,Price,SubTotal) values (?,?,?,?,?,?,?,?,?)', [company_id(), $find_reqid1->ReturnOrderID, $item_nam[$x], $find_itemname1->Name, $ordrqt[$x], $uni[$x], $qt[$x], $cos[$x], $total1]);
                } else {
                    $find_itemname = DB::connection('sqlsrv3')->table("Accounts")->select('AccountName')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                    foreach ($find_itemname as $find_itemname1) {

                    }
                    $result3 = DB::connection('sqlsrv3')->insert('INSERT INTO ReceivingReturnItems(CompanyID,RRID,ItemId,ItemName,PoQuantity,Unit,ReturnQuantity,Price,SubTotal) values (?,?,?,?,?,?,?,?,?)', [company_id(), $find_reqid1->ReturnOrderID, $item_nam[$x], $find_itemname1->AccountName, $ordrqt[$x], $uni[$x], $qt[$x], $cos[$x], $total1]);
                }
            }
            if ($type == 'Goods') {
                $find_recvd_items = DB::connection('sqlsrv3')->table('ReceivingReturnItems')->where('RRID', '=', $find_reqid1->ReturnOrderID)->get();
                foreach ($find_recvd_items as $find_recvd_items1) {
                    $itemid = $find_recvd_items1->ItemId;
                    $ItemName = $find_recvd_items1->ItemName;
                    $Unit = $find_recvd_items1->Unit;
                    $RecvdQuantity = $find_recvd_items1->ReturnQuantity;
                    $check_invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $itemid)->exists();
                    $facevalue = '';
                    if ($check_invent) {
                        $invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $itemid)->select('FaceValue')->orderBy('ID', 'DESC')->first();
                        $facevalue = $invent->FaceValue;
                    } else {
                        $facevalue = 0;
                    }
                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,CreatedBy,CreatedOn,Reference,Dated,FaceValue) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $itemid, $RecvdQuantity, $Unit, 6, username(), $update_date, 'Purchase Return stock through ' . $find_reqid1->ReturnOrderID, $date, $facevalue]);
                }
            }
            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode, $final_PoCode . '/Invoice #' . $invoice_no . '/' . $remarks, 'Purchase Return', $update_date, username(), company_id()]);
            if ($doc) {
                $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode)->get();
                foreach ($find_doc_id as $find_doc_id1) {

                }
                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Inventory to ' . $vendor, company_id()]);
                $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                foreach ($find_tran_id as $find_tran_id1) {

                }
                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountHead', '=', 'Trade Creditors')->where('AccountName', '=', $vendor)->get();
                foreach ($find_acc_code as $find_acc_code1) {

                }
                $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'D', $total, company_id()]);
                for ($y = 1; $y < count($item_name1); $y++) {
                    $item_nam = explode("|", $item_name);
                    $ordrqt = explode("|", $ordrqty);
                    $qt = explode("|", $qty);
                    $cosfind = explode("|", $cost);
                    $d_value = count($cosfind) - 1;
                    $find_ex_amount = $total - $subtotal;
                    $item_name1 = explode("|", $item_name);
                    $qt = explode("|", $qty);
                    $amountt = ($qt[$y] * $cosfind[$y]) + (($find_ex_amount * $qt[$y] * $cosfind[$y]) / $subtotal);

                    if ($type == 'Goods') {
                        $find_acc_code = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ItemId', '=', $item_nam[$y])->get();
                        foreach ($find_acc_code as $find_acc_code1) {

                        }
                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->CoaID, 'C', $amountt, company_id()]);
                    }
                    if ($type == 'Assets') {
                        $find_acc_code = DB::connection('sqlsrv3')->table("AssetsLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('AssetId', '=', $item_nam[$y])->get();
                        foreach ($find_acc_code as $find_acc_code1) {

                        }
                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->CoaID, 'C', $amountt, company_id()]);
                    }
                }
                DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Purchase Return Added', 'Purchase Return | ' . $final_PoCode . ', | against invoice Number | ' . $invoice_no . ' | having total Amount | ' . $total . ' | against vendor | ' . $vendor . ' |  has been posted ', $update_date]);
                $message = 'submitted';
                return request()->json(200, $message);
            }
        }
    }


    public
    function get_poProducts1($id)
    {
        $data = explode("_", $id);
        $rid = $data[0];

        $find_products = DB::connection('sqlsrv3')->table("PurchaseOrderItems")->join('ItemList', 'ItemList.ID', '=', 'PurchaseOrderItems.ItemId')->select('PurchaseOrderItems.*', 'ItemList.ItemCode')->where('PurchaseOrderItems.CompanyID', '=', company_id())->where('PurchaseOrderItems.POID', $rid)->get();
        return request()->json(200, $find_products);
    }

    public
    function accounts_get_poProducts_count($id)
    {
        $data = explode("_", $id);
        $po__id = $data[0];

        $find_products = DB::connection('sqlsrv3')->table("PurchaseOrderItems")->where('CompanyID', '=', company_id())->where('POID', $po__id)->count();
        return request()->json(200, $find_products);
    }

    public
    function get_requisition1()
    {

        $find_session = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->select('RequisitionId', 'RId')->get();
        return request()->json(200, $find_session);
    }

    public
    function get_req_data_count($id)
    {
        $data = explode("_", $id);
        $rid = $data[0];

        $cand = DB::connection('sqlsrv3')->table('RequisitionItem')->where('ReqID', '=', $rid)->count();
        return request()->json(200, $cand);
    }

    public
    function get_req_data2($rid)
    {
        $data = explode("_", $rid);
        $id = $data[0];

        $cand = DB::connection('sqlsrv3')->table('RequisitionItem')->join('ItemList', 'ItemList.ID', '=', 'RequisitionItem.itemId')->where('RequisitionItem.ReqID', '=', $id)->select('RequisitionItem.*', 'ItemList.ItemCode')->get();
        return request()->json(200, $cand);
    }

    public
    function get_po_grn_detailreport($rid)
    {
        $data = explode("_", $rid);
        $id = $data[0];

        $check = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', company_id())->where('POID', '=', $id)->exists();
        $getIssu = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', company_id())->where('POID', '=', $id)->get();
        $i = 0;
        $j = 0;
        $k = '';
        if ($check) {
            foreach ($getIssu as $getIssu1) {
                $counted = DB::connection('sqlsrv3')->table('GrnOrderItems')->where('GrnID', '=', $getIssu1->GrnOrderID)->count();
                $i = $i + 1;

                $b[$i] = '<tr ><td style="border-style: none !important;">' . $getIssu1->Dated . '</td>
                <td style="border-style: none !important;">' . $getIssu1->GrnID . '</td>
                <td style="border-style: none !important;">' . $getIssu1->Status . '</td>
                <td style="border-style: none !important;">' . $getIssu1->Status2 . '</td>';
                $k = $k . '' . $b[$i];
                $cand = DB::connection('sqlsrv3')->table('GrnOrderItems')->join('ItemList', 'ItemList.ID', '=', 'GrnOrderItems.ItemId')->where('GrnOrderItems.GrnID', '=', $getIssu1->GrnOrderID)->select('GrnOrderItems.*', 'ItemList.ItemCode')->get();
                $check11 = DB::connection('sqlsrv3')->table('GrnOrderItems')->join('ItemList', 'ItemList.ID', '=', 'GrnOrderItems.ItemId')->where('GrnOrderItems.GrnID', '=', $getIssu1->GrnOrderID)->select('GrnOrderItems.*', 'ItemList.ItemCode')->exists();

                if ($check11) {
                    foreach ($cand as $candidate1) {
                        $j = $j + 1;
                        if ($counted > 1) {
                            $b[$j] = '<td style="border-style: none !important;">' . $candidate1->ItemCode . '</td>
                      <td style="border-style: none !important;">' . $candidate1->ItemName . '</td>
                      <td style="border-style: none !important;">' . number_format($candidate1->PoQuantity) . '</td>
                      <td style="border-style: none !important;">' . $candidate1->Unit . '</td>
                        <td style="border-style: none !important;">' . number_format($candidate1->RecvdQuantity) . '</td>
                        <td style="border-style: none !important;">' . number_format($candidate1->Price) . '</td></tr>';
                            $k = $k . '' . $b[$j];
                            $c[$j] = '<tr ><td style="border-style: none !important;"></td>
                    <td style="border-style: none !important;"></td>
                    <td style="border-style: none !important;"></td>
                    <td style="border-style: none !important;"></td>';
                            $k = $k . '' . $c[$j];
                        } else {
                            $b[$j] = '<td style="border-style: none !important;">' . $candidate1->ItemCode . '</td>
                    <td style="border-style: none !important;">' . $candidate1->ItemName . '</td>
                    <td style="border-style: none !important;">' . number_format($candidate1->PoQuantity) . '</td>
                    <td style="border-style: none !important;">' . $candidate1->Unit . '</td>
                      <td style="border-style: none !important;">' . number_format($candidate1->RecvdQuantity) . '</td>
                      <td style="border-style: none !important;">' . number_format($candidate1->Price) . '</td></tr>';
                            $k = $k . '' . $b[$j];
                        }
                    }
                }
            }
        }
        return request()->json(200, $k);
    }

    public
    function customer_byname(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('Customer')->orderBy('CustomerID', 'asc')->where('CompanyID', '=', company_id())->where('CustomerName', 'like', '%' . $request->name . '%')->paginate(20);
        return request()->json(200, $arr);
    }

    public
    function get_purchaseorder_id()
    {

        $find_session = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->select('PurchaseOrderID', 'PoCode')->get();
        return request()->json(200, $find_session);
    }

    public
    function customer_detail()
    {

        $can = DB::connection('sqlsrv3')->table('Customer')
            ->orderBy('CustomerID', 'asc')
            ->where('CompanyID', '=', company_id())->paginate(20);
        return request()->json(200, $can);
    }

    public
    function update_customer(Request $request)
    {


        $update_date = long_date();

        $edcustomer_name = $request->get('edcustomer_name');
        $ed_father_name = $request->get('ed_father_name');
        $ed_cnic = $request->get('ed_cnic');
        $ed_date = $request->get('ed_date');
        $edc_phone = $request->get('edc_phone');
        $edc_mobile = $request->get('edc_mobile');
        $edc_email = $request->get('edc_email');
        $edc_type = $request->get('edc_type');
        $customer_id = $request->get('customer_id');

        if ($edc_type == "Company") {
            $ed_father_name = "";
            $ed_cnic = "";
            $ed_date = "";
        }
        DB::connection('sqlsrv3')->update('update Customer set CustomerName=?, FatherHusband=?, Email=?, Mobile=?, Phone=?, CNIC=?, DOB=?, CustomerType=?, UpdatedBy=?, UpdatedOn=? where CustomerID=? AND CompanyID=?', [$edcustomer_name, $ed_father_name, $edc_email, $edc_mobile, $edc_phone, $ed_cnic, $ed_date, $edc_type, username(), $update_date, $customer_id, company_id()]);

        $data = "Customer updated!";
        return request()->json(200, $data);
    }


    public
    function add_customer(Request $request)
    {


        $update_date = long_date();

        $customer_name = $request->get('customer_name');
        $c_fathername = $request->get('c_fathername');
        $c_phone = $request->get('c_phone');
        $c_email = $request->get('c_email');
        $c_mobile = $request->get('c_mobile');
        $c_website = $request->get('c_website');
        $c_type = $request->get('c_type');
        $c_cnic = $request->get('cnic');
        $c_dob = $request->get('date');
        if ($c_type == "Company") {
            $c_fathername = "";
            $c_cnic = "";
            $c_dob = "";
        }
        $iscustomer_name = DB::connection('sqlsrv3')->table("Customer")->where('CompanyID', '=', company_id())->where("CustomerName", "=", $customer_name)->where("CustomerType", "=", $c_type)->exists();
        if ($iscustomer_name) {
            $find_config = "Customer Name Already exist";
            return request()->json(200, $find_config);
        }


        $result = DB::connection('sqlsrv3')->insert('INSERT INTO Customer(CustomerName, FatherHusband, CNIC, DOB, Email, Mobile, Phone, Status, CustomerType, CreatedBy, CreatedOn, CompanyID) values (?,?,?,?,?,?,?,?,?,?,?,?)', [$customer_name, $c_fathername, $c_cnic, $c_dob, $c_email, $c_mobile, $c_phone, 1, $c_type, username(), $update_date, company_id()]);
        if ($result) {
            $top_head = 'Customers';
            $type = 'Assets';

            $find_last_head_code9 = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountHead', '=', $top_head)->exists();
            if ($find_last_head_code9) {
                $find_last_head_code = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountHead', '=', $top_head)->get();
                foreach ($find_last_head_code as $find_last_head_code1) {

                }
                $account_code = $find_last_head_code1->ID + 1;


                $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountName', '=', $top_head)->get();
                foreach ($find_head_name as $find_head_name1) {
                }
            } else {
                $find_head_name = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountType', '=', $type)->where('AccountName', '=', $top_head)->get();
                foreach ($find_head_name as $find_head_name1) {
                }
                $account_code = $find_head_name1->ID . '001';
            }


            $result = DB::connection('sqlsrv3')->insert('INSERT INTO Accounts(ID,CompanyID,AccountName,AccountType,AccountCode,AccountHead,CoaType) values (?,?,?,?,?,?,?)', [$account_code, company_id(), $customer_name, $type, $find_head_name1->ID, $find_head_name1->AccountName, 'Transaction']);
            $data = "Customer Added Successfully";
            return request()->json(200, $data);
        }
    }


    public
    function update_cusSts(Request $request)
    {


        $update_date = long_date();
        $ed_cusid = $request->get('ed_cusid');
        $status = $request->get('status');
        DB::connection('sqlsrv3')->update('update Customer set Status=?, UpdatedBy=?, UpdatedOn=? where CustomerID=? AND CompanyID=?', [$status, username(), $update_date, $ed_cusid, company_id()]);
        $data = "Status updated!";
        return request()->json(200, $data);
    }

    public
    function fetch_customer($id)
    {

        $cus = DB::connection('sqlsrv3')->table('Customer')->orderBy('CustomerID', 'asc')->where('CompanyID', '=', company_id())->where('CustomerID', '=', $id)->get();
        return request()->json(200, $cus);
    }

    public
    function count_stock()
    {

        date_default_timezone_set("Asia/Karachi");
        $today = long_date();
        $total_products = DB::connection('sqlsrv3')->table('ItemList')->where('CompanyID', '=', company_id())->count();
        $stock_in0 = DB::connection('sqlsrv3')->table('Inventory')->where('CompanyID', '=', company_id())->get();
        $stock_in = 0;
        $stock_out = 0;
        foreach ($stock_in0 as $stock) {
            $type = $stock->Type;
            if ($type % 2 != 0) {
                $stock_in = $stock_in + $stock->Quantity;
            } else if ($type % 2 == 0) {
                $stock_out = $stock_out + $stock->Quantity;
            }
        }
        $available_stock = $stock_in - $stock_out;
        $expired_items = DB::connection('sqlsrv3')->table('Inventory')->where('ItemExpiry', '<=', $today)->distinct('ItemID')->where('CompanyID', '=', company_id())->count();
        //--------Stock value--------//
        $value = DB::connection('sqlsrv3')->table('Inventory')->where('CompanyID', '=', company_id())->distinct('ItemID')->select('ItemID')->orderBy('ItemID', 'desc')->get();
        $stock_value = 0;
        foreach ($value as $value1) {
            $id1 = $value1->ItemID;
            $this_prod_cost = 0;
            $this_prod_items = 0;
            $this_avg_price = 0;
            $this_in = 0;
            $this_out = 0;
            $value_in = 0;
            $products = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $id1)->where('CompanyID', '=', company_id())->get();
            foreach ($products as $products1) {
                $type = $products1->Type;
                if ($type == 1) {
                    $this_prod_cost = $this_prod_cost + ($products1->CostUnit * $products1->Quantity);
                    $this_prod_items = $this_prod_items + $products1->Quantity;
                    if ($this_prod_cost > 0) {
                        $this_avg_price = $this_prod_cost / $this_prod_items;
                    }
                }
                if ($type % 2 != 0) {
                    $this_in = $this_in + $products1->Quantity;
                } else if ($type % 2 == 0) {
                    $this_out = $this_out + $products1->Quantity;
                }
                $value_in = ($this_in - $this_out) * $this_avg_price;
            }
            $stock_value = $stock_value + $value_in;
        }
        $stock_value = $stock_value;
        $all_products = DB::connection('sqlsrv3')->table('Inventory')->distinct('ItemID')->select('ItemID')->orderBy('ItemID', 'asc')->where('CompanyID', '=', company_id())->get();
        $available_products = 0;
        foreach ($all_products as $all_products1) {
            $id = $all_products1->ItemID;
            $product_in0 = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $id)->where('CompanyID', '=', company_id())->get();
            $product_in = 0;
            $product_out = 0;
            foreach ($product_in0 as $product_in1) {
                $type = $product_in1->Type;
                if ($type % 2 != 0) {
                    $product_in = $product_in + $product_in1->Quantity;
                } else if ($type % 2 == 0) {
                    $product_out = $product_out + $product_in1->Quantity;
                }
            }
            if ($product_in > $product_out) {
                $available_products++;
            }
        }
        $not_available = $total_products - $available_products;
        $myJSON = array(
            'total_products' => $total_products,
            'available_products' => $available_products,
            'not_available' => $not_available,
            'available_stock' => number_format($available_stock),
            'stock_value' => number_format($stock_value),
            'expired_items' => $expired_items,
        );
        return request()->json(200, $myJSON);
    }

    public
    function count_stock1()
    {
        $today = long_date();
        $inventory = DB::connection('sqlsrv3')->table('Inventory')
            ->select('ItemID')
            ->where('CompanyID', '=', company_id())
            ->where('Type', '=', 1)
            ->groupBy('ItemID')
            ->selectRaw('SUM(Quantity * CostUnit) / nullif(SUM(Quantity), 0) as avg_price, SUM(Quantity) as total_quantity')
            ->get();
// Get all products with their Type and Quantity for the given ItemIDs
        $products = DB::connection('sqlsrv3')->table('Inventory')
            ->select('ItemID', 'Type', 'Quantity')
            ->whereIn('ItemID', $inventory->pluck('ItemID')->toArray())
            ->where('CompanyID', '=', company_id())
            ->get()
            ->groupBy('ItemID');  // Group products by ItemID for easy access
// Calculate the stock value based on the aggregated data
        $stock_value = 0;
        foreach ($inventory as $item) {
            if ($item->total_quantity == 0) {
                continue; // Skip items with zero total quantity
            }
            $value_in = 0;
            if (isset($products[$item->ItemID])) {
                foreach ($products[$item->ItemID] as $product) {
                    if ($product->Type % 2 != 0) {
                        $value_in += $product->Quantity * $item->avg_price;
                    } else {
                        $value_in -= $product->Quantity * $item->avg_price;
                    }
                }
            }
            $stock_value += $value_in;
        }
        $stock_value = $stock_value;
        $myJSON = array(
            'stock_value' => number_format($stock_value),
        );
        return request()->json(200, $myJSON);
    }


    public
    function count_available()
    {

//        $company_id = '632462982ad6e';
        $today = long_date();

        $stock = DB::connection('sqlsrv3')
            ->table('Inventory')
            ->selectRaw('SUM(CASE WHEN Type % 2 != 0 THEN Quantity ELSE 0 END) as stock_in, SUM(CASE WHEN Type % 2 = 0 THEN Quantity ELSE 0 END) as stock_out')
            ->where('CompanyID', '=', company_id())
            ->first();

        $available_stock = $stock->stock_in - $stock->stock_out;

        $total_products = DB::connection('sqlsrv3')->table('ItemList')->where('CompanyID', '=', company_id())->count();

        $expired_items = DB::connection('sqlsrv3')->table('Inventory')->where('ItemExpiry', '<=', $today)->distinct('ItemID')->where('CompanyID', '=', company_id())->count();

        $company_id = Session::get('company_id');

//      --------Stock value--------//
        $company_id = Session::get('company_id');
        $available_products = DB::connection('sqlsrv3')
            ->table('Inventory as inv1')
            ->join('Inventory as inv2', function ($join) use ($company_id) {
                $join->on('inv1.ItemID', '=', 'inv2.ItemID')
                    ->where('inv2.CompanyID', '=', company_id());
            })
            ->select('inv1.ItemID', DB::raw('SUM(CASE WHEN inv1.Type % 2 != 0 THEN inv1.Quantity ELSE 0 END) as product_in'), DB::raw('SUM(CASE WHEN inv1.Type % 2 = 0 THEN inv1.Quantity ELSE 0 END) as product_out'))
            ->where('inv1.CompanyID', '=', company_id())
            ->groupBy('inv1.ItemID')
            ->havingRaw('SUM(CASE WHEN inv1.Type % 2 != 0 THEN inv1.Quantity ELSE 0 END) > SUM(CASE WHEN inv1.Type % 2 = 0 THEN inv1.Quantity ELSE 0 END)')
            ->get()
            ->count();


        $not_available = $total_products - $available_products;

        return response()->json([
            'available_stock' => number_format($available_stock),
            'total_products' => $total_products,
            'available_products' => $available_products,
            'not_available' => $not_available,
            'expired_items' => $expired_items,
        ]);

    }

    public
    function insert_saleinvoice(Request $request)
    {
        $update_date = long_date();
        $doc_date = short_date();
        $date = $request->get('date');
        $customer = $request->get('customer');
        $invoice_no = $request->get('invoice_no');
        $status = $request->get('status');
        $select_tax = $request->get('select_tax');
        $select_delivery = $request->get('select_delivery');
        $subtotal = $request->get('subtotal');
        $discount = $request->get('discount');
        $tax_amount = $request->get('tax_amount');
        $delivery_amount = $request->get('delivery_amount');
        $total = $request->get('total');
        $remarks = $request->get('remarks');

        $item_name = $request->get('item_name');
        $quantity = $request->get('quantity');
        $unit = $request->get('unit');
        $unit_cost = $request->get('unit_cost');

        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $item_nam = explode("|", $item_name);
            $quantit = explode("|", $quantity);
            $uni = explode("|", $unit);
            $unit_cos = explode("|", $unit_cost);
            if ($quantit[$x] < 1) {
                $message = "quantity error";
                return request()->json(200, $message);
            } else if ($quantit[$x] == null || $uni[$x] == null || $unit_cos[$x] == null) {
                $message = "Empty field";
                return request()->json(200, $message);
            }
        }
        $session = ac_c_session();
        //Select prefix
        $find_prefix = DB::connection('sqlsrv3')->table('AccountsConfiguration')->where('CompanyID', '=', company_id())->get();
        foreach ($find_prefix as $find_prefix1) {
        }
        $date_pref = $this->shiftformat();
        $prefix = $find_prefix1->CustomerInvoice . '_' . $date_pref;

        $find_saleinvoice = DB::connection('sqlsrv3')->table('SalesInvoice')->where('CompanyID', '=', company_id())->exists();
        if ($find_saleinvoice) {
            $find_id = DB::connection('sqlsrv3')->table('SalesInvoice')->Select('saleID')->orderBy('SalesInvoiceID', 'asc')->where('CompanyID', '=', company_id())->get();
            foreach ($find_id as $find_id1) {
            }
            $previous_saleid = explode("-", $find_id1->saleID);
            $id = $previous_saleid[1] + 1;
            $sale_id = $prefix . "-" . $id;
        } else {
            $sale_id = $prefix . "-" . '1';
        }
        $result = DB::connection('sqlsrv3')->insert('INSERT INTO SalesInvoice(CompanyID, CustomerID, Dated, saleID, InvoiceNo, SubTotal, Discount, Tax, ShippingCharges, TotalAmount, Remarks, Status, CreatedBy, CreatedOn, Session, Status2) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $customer, $date, $sale_id, $invoice_no, $subtotal, $discount, $tax_amount, $delivery_amount, $total, $remarks, $status, username(), $update_date, $session, 'Verified']);
        if ($result) {
            $item_name1 = explode("|", $item_name);
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $quantit = explode("|", $quantity);
                $uni = explode("|", $unit);
                $unit_cos = explode("|", $unit_cost);

                $Price = $quantit[$x] * $unit_cos[$x];

                //Get item name
                $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'ID')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                foreach ($find_itemname as $find_itemname1) {

                }

                //Get SIID
                $SI_ID = DB::connection('sqlsrv3')->table("SalesInvoice")->select('SalesInvoiceID')->where('CompanyID', '=', company_id())->where('saleID', '=', $sale_id)->get();
                foreach ($SI_ID as $SI_ID1) {

                }
                //Submit items
                $result = DB::connection('sqlsrv3')->insert('INSERT INTO SalesInvoiceItems(CompanyID, SIID, ItemId, ItemName, SaleQuantity, Unit, Price, SubTotal) values (?,?,?,?,?,?,?,?)', [company_id(), $SI_ID1->SalesInvoiceID, $find_itemname1->ID, $find_itemname1->Name, $quantit[$x], $uni[$x], $unit_cos[$x], $Price]);
            }

            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $sale_id, $sale_id . '/Invoice #' . $invoice_no . '/' . $remarks, 'Sale Invoice', $update_date, username(), company_id()]);
            if ($doc) {
                $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $sale_id)->get();
                foreach ($find_doc_id as $find_doc_id1) {

                }
                $find_vendor = DB::connection('sqlsrv3')->table("Customer")->select('CustomerName')->where('CompanyID', '=', company_id())->where('CustomerID', '=', $customer)->get();
                foreach ($find_vendor as $find_vendor1) {

                }
                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountHead', '=', 'Customers')->where('AccountName', '=', $find_vendor1->CustomerName)->get();
                foreach ($find_acc_code as $find_acc_code1) {

                }

                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Inventory to ' . $find_vendor1->CustomerName, company_id()]);

                $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                foreach ($find_tran_id as $find_tran_id1) {

                }
                $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'D', $total, company_id()]);

                $find_acc_id9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('AccountType', '=', 'Income')->where('CompanyID', '=', company_id())->where('AccountName', '=', 'Sale Invoices')->get();
                foreach ($find_acc_id9 as $find_acc_id91) {

                }

                $ledger_entry9 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_id91->ID, 'C', $total, company_id()]);

                $find_saacc_id = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Expenses')->where('AccountName', '=', 'Cost of Sale')->get();

                foreach ($find_saacc_id as $find_saacc_id1) {

                }
                $ledger_entry5 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_saacc_id1->ID, 'D', $total, company_id()]);


                $cosfind = explode("|", $unit_cost);
                $d_value = count($cosfind) - 1;
                $find_ex_amount = $total - $subtotal;
                $item_wise_value = $find_ex_amount / $d_value;


                for ($y = 1; $y < count($item_name1); $y++) {

                    $item_nam = explode("|", $item_name);
                    $qt = explode("|", $quantity);
                    $cos = explode("|", $unit_cost);

                    $amountt = ($qt[$y] * $cos[$y]) + $item_wise_value;

                    $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$y])->get();
                    foreach ($find_itemname as $find_itemname1) {
                    }
                    $find_acc_id = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('AccountType', '=', 'Assets')->where('CompanyID', '=', company_id())->where('AccountName', '=', $find_itemname1->Name)->get();
                    foreach ($find_acc_id as $find_acc_id1) {

                    }
                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_id1->ID, 'C', $amountt, company_id()]);
                }


                $find_de_name = DB::connection('sqlsrv3')->table("Delivery")->select('DeliveryName')->where('CompanyID', '=', company_id())->where('DID', '=', $select_delivery)->get();
                foreach ($find_de_name as $find_de_name1) {

                }
                $ledger_delivery3 = DB::connection('sqlsrv3')->insert('INSERT INTO DeliveryDetail(CompanyID,DeliveryName,DeliveryType,DeliveryAmount,ReferenceAccount,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?)', [company_id(), $find_de_name1->DeliveryName, 'Sales', $delivery_amount, $sale_id, username(), $update_date]);

                $find_tax_name = DB::connection('sqlsrv3')->table("Taxes")->select('TaxName')->where('CompanyID', '=', company_id())->where('TaxID', '=', $select_tax)->get();
                foreach ($find_tax_name as $find_tax_name1) {

                }

                $ledger_tax4 = DB::connection('sqlsrv3')->insert('INSERT INTO TaxDetail(CompanyID,TaxName,TaxType,TaxAmount,ReferenceAccount,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?)', [company_id(), $find_tax_name1->TaxName, 'Sales', $tax_amount, $sale_id, username(), $update_date]);


            }


            $item_name2 = explode("|", $item_name);
            for ($z = 1; $z < count($item_name2); $z++) {
                $item_nam = explode("|", $item_name);
                $quantit = explode("|", $quantity);
                $uni = explode("|", $unit);

                //Submit items
                DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,CreatedBy,CreatedOn,Reference,Dated) values (?,?,?,?,?,?,?,?,?)', [company_id(), $item_nam[$z], $quantit[$z], $uni[$z], 2, username(), $update_date, 'Minus stock through ' . $sale_id, $doc_date]);
            }
        }

        $message = "submitted";
        return request()->json(200, $message);
    }


    public
    function get_customers()
    {


        $find_config = DB::connection('sqlsrv3')->table("Customer")->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $find_config);
    }

    public
    function submit_bank(Request $request)
    {

        $bank_name = $request->get('bank_name');
        $bank_type = $request->get('bank_type');
        $bank_branch = $request->get('bank_branch');
        $account_name = $request->get('account_name');
        $account_number = $request->get('account_number');
        $bank_status = $request->get('bank_status');
        $p_account_idname = $request->get('p_account_idname');
        $pre_id = explode("_", $p_account_idname);


        $update_date = long_date();
        $result = DB::connection('sqlsrv3')->insert('INSERT INTO Banks(CompanyID,BankName,BankBranch,AccountNumber,AccountTitle,AccountType,Status,CreatedBy,CreatedOn,AccountID,AccountName) values (?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $bank_name, $bank_branch, $account_number, $account_name, $bank_type, $bank_status, username(), $update_date, $pre_id[0], $pre_id[1]]);


        $find_config = DB::connection('sqlsrv3')->table("Banks")->where('CompanyID', '=', company_id())->orderby('BankID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function bank_detail()
    {

        $find_config = DB::connection('sqlsrv3')->table("Banks")->where('CompanyID', '=', company_id())->orderby('BankID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function get_rcv_vchr($id)
    {

        $cand = DB::connection('sqlsrv3')->table('ReceivedVoucher')->where('CompanyID', '=', company_id())->where('ReceivedVoucherID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public
    function get_payment_vchr($id)
    {

        $cand = DB::connection('sqlsrv3')->table('PaymentVoucher')->where('CompanyID', '=', company_id())->where('PaymentVoucherID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    //Pdf Reports

    public
    function pr_detailreport()
    {

        $find_session = DB::connection('sqlsrv3')->table('ReceivingOrderReturn')->where('CompanyID', '=', company_id())->select("vendorName")->get();
        return request()->json(200, $find_session);
    }


    public
    function requisition_detail_report()
    {

        $find_config = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', company_id())->select('RId')->get();
        return request()->json(200, $find_config);
    }

    public
    function issu_detail_report()
    {

        $find_config = DB::connection('sqlsrv3')->table("Issuances")->where('CompanyID', '=', company_id())->select('IssuanceCode')->get();
        return request()->json(200, $find_config);
    }

    public
    function getitems_quotation($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', company_id())->where('RId', '=', $id)->select('RequisitionId')->get();
        foreach ($find_config as $find_config1) {
        }
        $arr = DB::connection('sqlsrv3')->table("PQuotation")->where('RequisitionID', '=', $find_config1->RequisitionId)->select('QuotationID')->get();
        foreach ($arr as $arr1) {
        }
        $data = DB::connection('sqlsrv3')->table("PQuotationItems")->where('QuotationID', '=', $arr1->QuotationID)->select('ItemId', 'ItemName')->get();
        return request()->json(200, $data);
    }


    public
    function getitems_requisition($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', company_id())->where('RId', '=', $id)->select('RequisitionId')->get();
        foreach ($find_config as $find_config1) {
        }
        $arr = DB::connection('sqlsrv3')->table("RequisitionItem")->where('ReqID', '=', $find_config1->RequisitionId)->select('itemId', 'ItemName')->get();
        return request()->json(200, $arr);
    }


    public
    function getitems_issuance($id)
    {

        $checker = DB::connection('sqlsrv3')->table('Issuances')->where('CompanyID', '=', company_id())->where('IssuanceCode', '=', $id)->exists();
        if ($checker) {
            $find_config = DB::connection('sqlsrv3')->table('Issuances')->where('CompanyID', '=', company_id())->where('IssuanceCode', '=', $id)->select('IssuanceId')->get();

            foreach ($find_config as $find_config1) {
            }

            $checker1 = DB::connection('sqlsrv3')->table("IssuanceItem")->where('IssuanceId', '=', $find_config1->IssuanceId)->get();
            return request()->json(200, $checker1);

        }
    }


    //dashbaord
    public
    function get_sum_accounts_data()
    {


        $first_date = date('Y-m-d', strtotime('first day of this month'));
        $last_date = date('Y-m-d', strtotime('last day of this month'));
        $current_month = date('F, Y');

        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC   [dbo].[Nodeledger_remainingbalance]
    @Datefrom = N'" . $first_date . "',
    @DateTo = N'" . $last_date . "',
    @compid = N'" . company_id() . "',
    @id = 201001
     ");
        foreach ($result as $result1) {

        }
        $overdue_po = $result1->TotalAmount;

        $result2 = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC   [dbo].[Nodeledger_remainingbalance]
    @Datefrom = N'" . $first_date . "',
    @DateTo = N'" . $last_date . "',
    @compid = N'" . company_id() . "',
    @id = 101001001");
        foreach ($result2 as $result21) {

        }
        $overdue_sale = $result21->TotalAmount;

        $result3 = DB::connection('sqlsrv3')->select("EXEC   [dbo].[dashboard_TotalCredit]
    @Datefrom = N'" . $first_date . "',
    @DateTo = N'" . $last_date . "',
    @compid = N'" . company_id() . "',
    @id = 201001
    ");
        foreach ($result3 as $result31) {

        }
        $acc_payable = $result31->TotalCredit;

        $result4 = DB::connection('sqlsrv3')->select("EXEC   [dbo].[dashboard_TotalCredit]
    @Datefrom = N'" . $first_date . "',
    @DateTo = N'" . $last_date . "',
    @compid = N'" . company_id() . "',
    @id = 101002
    ");
        foreach ($result4 as $result41) {

        }
        $acc_receivable = $result41->Totaldebit;


        $result5 = DB::connection('sqlsrv3')->select("EXEC   [dbo].[dashboard_TotalCredit]
    @Datefrom = N'" . $first_date . "',
    @DateTo = N'" . $last_date . "',
    @compid = N'" . company_id() . "',
    @id = 5 ");
        foreach ($result5 as $result51) {

        }
        $acc_expense = $result51->Totaldebit;

        $result6 = DB::connection('sqlsrv3')->select("EXEC   [dbo].[dashboard_TotalCredit]
    @Datefrom = N'" . $first_date . "',
    @DateTo = N'" . $last_date . "',
    @compid = N'" . company_id() . "',
        @id = 4 ");
        foreach ($result6 as $result61) {

        }
        $acc_income = $result61->TotalCredit;

        $myJSON = array(
            'current_month' => $current_month,
            'overdue_po' => $overdue_po,
            'cash_in_hand' => $overdue_sale,
            'acc_receivable' => $acc_receivable,
            'acc_payable' => $acc_payable,
            'acc_expense' => $acc_expense,
            'acc_income' => $acc_income,
        );
        return request()->json(200, $myJSON);
    }

    public
    function fetch_dashboard_customers()
    {
        $myJSON = DB::connection('sqlsrv3')->select("EXEC   [dbo].[TopCustomer]
    @compid = N'" . company_id() . "' ");
        return request()->json(200, $myJSON);
    }

    public
    function fetch_dashboard_vendors()
    {


        $myJSON = DB::connection('sqlsrv3')->select("EXEC  [dbo].[TopVendor]
    @compid = N'" . company_id() . "' ");
        return request()->json(200, $myJSON);
    }

    public
    function get_d_purchase()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', company_id())->where('ReceivingOrder.Session', '=', $session)->orderby('ReceivingOrder.ReceavingOrderID', 'desc')->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->limit(5)->get();
        return request()->json(200, $find_config);
    }

    public
    function get_d_sale()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("SalesInvoice")->join('Customer', 'Customer.CustomerID', '=', 'SalesInvoice.CustomerID')->where('SalesInvoice.CompanyID', '=', company_id())->where('SalesInvoice.Session', '=', $session)->orderby('SalesInvoice.SalesInvoiceID', 'desc')->select('SalesInvoice.*', 'Customer.CustomerName')->limit(5)->get();
        return request()->json(200, $find_config);
    }

    public
    function get_d_payment()
    {

        $session = ac_c_session();

        $find_config = DB::connection('sqlsrv3')->table("PaymentVoucher")->where('CompanyID', '=', company_id())->where('Session', '=', $session)->orderby('PaymentVoucherID', 'desc')->limit(5)->get();
        return request()->json(200, $find_config);
    }

    public
    function get_d_received()
    {

        $session = ac_c_session();

        $find_config = DB::connection('sqlsrv3')->table("ReceivedVoucher")->where('CompanyID', '=', company_id())->where('Session', '=', $session)->orderby('ReceivedVoucherID', 'desc')->limit(5)->get();
        return request()->json(200, $find_config);
    }

    public
    function get_d_jv()
    {


        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("JournalVoucher")->where('CompanyID', '=', company_id())->where('Session', '=', $session)->orderby('JournalVoucherID', 'desc')->limit(5)->get();
        return request()->json(200, $find_config);
    }

    public
    function count_sales_d()
    {
        $year = date("Y");
        $jan = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-01-%')->sum('Ledger_Entries.Amount');
        $feb = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-02-%')->sum('Ledger_Entries.Amount');
        $mar = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-03-%')->sum('Ledger_Entries.Amount');
        $april = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-04-%')->sum('Ledger_Entries.Amount');
        $may = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-05-%')->sum('Ledger_Entries.Amount');
        $june = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-06-%')->sum('Ledger_Entries.Amount');
        $july = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-07-%')->sum('Ledger_Entries.Amount');
        $aug = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-08-%')->sum('Ledger_Entries.Amount');
        $sept = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-09-%')->sum('Ledger_Entries.Amount');
        $oct = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-10-%')->sum('Ledger_Entries.Amount');
        $nov = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-11-%')->sum('Ledger_Entries.Amount');
        $dec = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-12-%')->sum('Ledger_Entries.Amount');
        $myJSON = array(
            '0' => $july,
            '1' => $aug,
            '2' => $sept,
            '3' => $oct,
            '4' => $nov,
            '5' => $dec,
            '6' => $jan,
            '7' => $feb,
            '8' => $mar,
            '9' => $april,
            '10' => $may,
            '11' => $june,
        );
        return request()->json(200, $myJSON);
    }
    public function units_ageing_blocks(){
        $save_ledger = DB::connection('sqlsrv4')->table('RealEstate_Blocks')->get();
        return request()->json(200, $save_ledger);

    }
    public function get_units_ageing_payables_receivables_report($module,$block,$year,$month){
        $new_block=null;



        if($block !==null && $module =="Commercial"){
            $save_ledger = DB::connection('sqlsrv4')->table('RealEstate_Projects')->where("Project_Name","=",$block)->select('Id')->first();
            if($save_ledger){
            $new_block=$save_ledger->Id;
            }else{
                $new_block=$block;
               }
        }
        else if($block !==null && ($module =="FileManagement" || $module =="PlotManagement")){

            $save_ledger = DB::connection('sqlsrv4')->table('RealEstate_Blocks')->where("Block_Name","=",$block)->select('Id')->first();

            if($save_ledger){
            $new_block=$save_ledger->Id;
           }else{
            $new_block=$block;
           }

        }else{
            $new_block=$block;
        }
        $result1=DB::connection('sqlsrv4')->select("SET NOCOUNT ON ;EXEC  [dbo].[Sp_Get_Aging_Reports_FilePLotsCommercial]
          @module = N'".$module."',
          @block = ".$new_block.",
          @yr = ".$year.",
          @mon = ".$month." ");
        return request()->json(200, $result1);


    }
    public
    function count_purchase_d()
    {


        $year = date("Y");

        $jan = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-01-%')->sum('Ledger_Entries.Amount');
        $feb = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-02-%')->sum('Ledger_Entries.Amount');
        $mar = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-03-%')->sum('Ledger_Entries.Amount');
        $april = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-04-%')->sum('Ledger_Entries.Amount');
        $may = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-05-%')->sum('Ledger_Entries.Amount');
        $june = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-06-%')->sum('Ledger_Entries.Amount');
        $july = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-07-%')->sum('Ledger_Entries.Amount');
        $aug = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-08-%')->sum('Ledger_Entries.Amount');
        $sept = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-09-%')->sum('Ledger_Entries.Amount');
        $oct = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-10-%')->sum('Ledger_Entries.Amount');
        $nov = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-11-%')->sum('Ledger_Entries.Amount');
        $dec = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '201001%')->where('Transactions.TransactionDate', 'like', $year . '-12-%')->sum('Ledger_Entries.Amount');
        $myJSON = array(
            '0' => $july,
            '1' => $aug,
            '2' => $sept,
            '3' => $oct,
            '4' => $nov,
            '5' => $dec,
            '6' => $jan,
            '7' => $feb,
            '8' => $mar,
            '9' => $april,
            '10' => $may,
            '11' => $june,
        );
        return request()->json(200, $myJSON);
    }

    public
    function count_revenue_d()
    {


        $year = date("Y");

        $jan = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-01-%')->sum('Ledger_Entries.Amount');
        $feb = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-02-%')->sum('Ledger_Entries.Amount');
        $mar = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-03-%')->sum('Ledger_Entries.Amount');
        $april = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-04-%')->sum('Ledger_Entries.Amount');
        $may = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-05-%')->sum('Ledger_Entries.Amount');
        $june = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-06-%')->sum('Ledger_Entries.Amount');
        $july = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-07-%')->sum('Ledger_Entries.Amount');
        $aug = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-08-%')->sum('Ledger_Entries.Amount');
        $sept = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-09-%')->sum('Ledger_Entries.Amount');
        $oct = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-10-%')->sum('Ledger_Entries.Amount');
        $nov = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-11-%')->sum('Ledger_Entries.Amount');
        $dec = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'C')->where('Ledger_Entries.AccountID', 'like', '4%')->where('Transactions.TransactionDate', 'like', $year . '-12-%')->sum('Ledger_Entries.Amount');
        $myJSON = array(
            '0' => $jan,
            '1' => $feb,
            '2' => $mar,
            '3' => $april,
            '4' => $may,
            '5' => $june,
            '6' => $july,
            '7' => $aug,
            '8' => $sept,
            '9' => $oct,
            '10' => $nov,
            '11' => $dec,
        );
        return request()->json(200, $myJSON);
    }

    public
    function count_expense_d()
    {


        $year = date("Y");

        $jan = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-01-%')->sum('Ledger_Entries.Amount');
        $feb = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-02-%')->sum('Ledger_Entries.Amount');
        $mar = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-03-%')->sum('Ledger_Entries.Amount');
        $april = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-04-%')->sum('Ledger_Entries.Amount');
        $may = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-05-%')->sum('Ledger_Entries.Amount');
        $june = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-06-%')->sum('Ledger_Entries.Amount');
        $july = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-07-%')->sum('Ledger_Entries.Amount');
        $aug = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-08-%')->sum('Ledger_Entries.Amount');
        $sept = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-09-%')->sum('Ledger_Entries.Amount');
        $oct = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-10-%')->sum('Ledger_Entries.Amount');
        $nov = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-11-%')->sum('Ledger_Entries.Amount');
        $dec = DB::connection('sqlsrv3')->table('Transactions')->join('Ledger_Entries', 'Transactions.ID', '=', 'Ledger_Entries.TransactionID')->where('Transactions.CompanyID', '=', company_id())->where('Ledger_Entries.EntryType', '=', 'D')->where('Ledger_Entries.AccountID', 'like', '5%')->where('Transactions.TransactionDate', 'like', $year . '-12-%')->sum('Ledger_Entries.Amount');
        $myJSON = array(
            '0' => $jan,
            '1' => $feb,
            '2' => $mar,
            '3' => $april,
            '4' => $may,
            '5' => $june,
            '6' => $july,
            '7' => $aug,
            '8' => $sept,
            '9' => $oct,
            '10' => $nov,
            '11' => $dec,
        );
        return request()->json(200, $myJSON);
    }

    public
    function count_stock_d()
    {


        $today = long_date();
        $total_products = DB::connection('sqlsrv3')->table('ItemList')->where('CompanyID', '=', company_id())->count();
        $stock_in0 = DB::connection('sqlsrv3')->table('Inventory')->where('CompanyID', '=', company_id())->get();
        $stock_in = 0;
        $stock_out = 0;
        foreach ($stock_in0 as $stock) {
            $type = $stock->Type;
            if ($type % 2 != 0) {
                $stock_in = $stock_in + $stock->Quantity;
            } else if ($type % 2 == 0) {
                $stock_out = $stock_out + $stock->Quantity;
            }
        }
        $available_stock = $stock_in - $stock_out;
        $expired_items = DB::connection('sqlsrv3')->table('Inventory')->where('ItemExpiry', '<=', $today)->distinct('ItemID')->where('CompanyID', '=', company_id())->count();
        //--------Stock value--------//
        $value = DB::connection('sqlsrv3')->table('Inventory')->where('CompanyID', '=', company_id())->distinct('ItemID')->select('ItemID')->orderBy('ItemID', 'desc')->get();
        $stock_value = 0;
        foreach ($value as $value1) {
            $id1 = $value1->ItemID;
            $this_prod_cost = 0;
            $this_prod_items = 0;
            $this_avg_price = 0;
            $this_in = 0;
            $this_out = 0;
            $value_in = 0;
            $products = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $id1)->where('CompanyID', '=', company_id())->get();
            foreach ($products as $products1) {
                $type = $products1->Type;
                if ($type == 1) {
                    $this_prod_cost = $this_prod_cost + ($products1->CostUnit * $products1->Quantity);
                    $this_prod_items = $this_prod_items + $products1->Quantity;
                    $this_avg_price = $this_prod_cost / $this_prod_items;
                }
                if ($type % 2 != 0) {
                    $this_in = $this_in + $products1->Quantity;
                } else if ($type % 2 == 0) {
                    $this_out = $this_out + $products1->Quantity;
                }
                $value_in = ($this_in - $this_out) * $this_avg_price;
            }
            $stock_value = $stock_value + $value_in;
        }
        $stock_value = $stock_value;
        //--------Stock value--------//
        $all_products = DB::connection('sqlsrv3')->table('Inventory')->distinct('ItemID')->select('ItemID')->orderBy('ItemID', 'asc')->where('CompanyID', '=', company_id())->get();
        $available_products = 0;
        foreach ($all_products as $all_products1) {
            $id = $all_products1->ItemID;
            $product_in0 = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $id)->where('CompanyID', '=', company_id())->get();
            $product_in = 0;
            $product_out = 0;
            foreach ($product_in0 as $product_in1) {
                $type = $product_in1->Type;
                if ($type % 2 != 0) {
                    $product_in = $product_in + $product_in1->Quantity;
                } else if ($type % 2 == 0) {
                    $product_out = $product_out + $product_in1->Quantity;
                }
            }
            if ($product_in > $product_out) {
                $available_products++;
            }
        }
        $not_available = $total_products - $available_products;
        $myJSON = array(
            'first1' => $available_products,
            'second' => $available_stock,
            'third' => $total_products,
            'fourth' => $not_available,
            'stock_value' => $stock_value
        );
        return request()->json(200, $myJSON);
    }

    public
    function searchcoa_name($account_name)
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where('AccountName', 'like', '%' . $account_name . '%')->get();
        return request()->json(200, $find_journal_headname);
    }


    public
    function paymentsearch_name($against)
    {


        $session = ac_c_session();

        $find_config = DB::connection('sqlsrv3')->table("PaymentVoucher")->where('CompanyID', '=', company_id())
            // ->where('Session', '=', $session)
            ->where("PaymentAgainst", "like", '%' . $against . '%')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function paymentsearch_number($against)
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("PaymentVoucher")->where('CompanyID', '=', company_id())
            ->where("InvoiceNumber", "like", '%' . $against . '%')->orWhere('PVID', 'like', '%' . $against . '%')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function received_vouchername($name)
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("ReceivedVoucher")->where('CompanyID', '=', company_id())
            // ->where('Session', '=', $session)
            ->where('PaymentAgainst', 'like', '%' . $name . '%')
            ->orWhere('RVID', 'like', '%' . $name . '%')
            ->orWhere('InvoiceNumber', 'like', '%' . $name . '%')
            ->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function count_req_amt_d()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->count();
        $req_est = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->count();

        $myJSON = array(
            'pending' => $find_config,
            'amount' => $req_est,
        );

        return request()->json(200, $myJSON);
    }

    public
    function count_po_amt_d()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status2', '=', 'Verified')->count();
        $req_est = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status2', '=', 'Verified')->sum('TotalAmount');

        $myJSON = array(
            'inv_count' => $find_config,
            'inv_amount' => $req_est,
        );

        return request()->json(200, $myJSON);
    }

    public
    function search_invoicedata($startingdate, $closingdate)
    {


        $find_config = DB::connection('sqlsrv3')->table("Customer")->join('SalesInvoice', 'Customer.CustomerID', '=', 'SalesInvoice.CustomerID')->where('SalesInvoice.CompanyID', '=', company_id())->where('SalesInvoice.Dated', '=', $startingdate)->where('SalesInvoice.Dated', '=', $closingdate)->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function get_vendorinvoice($vendor)
    {


        $find_config = DB::connection('sqlsrv3')->table("Customer")->join('SalesInvoice', 'Customer.CustomerID', '=', 'SalesInvoice.CustomerID')->where('SalesInvoice.CompanyID', '=', company_id())->where('Customer.CustomerName', 'like', '%' . $vendor . '%')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function get_invoicedata($id)
    {


        $find_config = DB::connection('sqlsrv3')->table("SalesInvoice")->join('Customer', 'SalesInvoice.CustomerID', '=', 'Customer.CustomerID')->where('SalesInvoice.SalesInvoiceID', '=', $id)->select('SalesInvoice.*', 'Customer.CustomerName')->get();
        return request()->json(200, $find_config);
    }

    public
    function get_invoicedata_detail($id)
    {


        $find_config = DB::connection('sqlsrv3')->table("SalesInvoiceItems")->where('SIID', '=', $id)->get();
        return request()->json(200, $find_config);
    }

    public
    function get_saleinvoice(Request $request)
    {

        $sale_invoice = DB::connection('sqlsrv3')->table("SalesInvoice")->join('Customer', 'SalesInvoice.CustomerID', '=', 'Customer.CustomerID')->select('SalesInvoice.*', 'Customer.CustomerName')->where('SalesInvoice.CompanyID', '=', company_id())->orderby('SalesInvoiceID', 'desc')->get();
        return request()->json(200, $sale_invoice);
    }

    public
    function get_saleinvoice_detail($id)
    {

        $sale_invoice = DB::connection('sqlsrv3')->table("SalesInvoice")->join('Customer', 'SalesInvoice.CustomerID', '=', 'Customer.CustomerID')->select('SalesInvoice.*', 'Customer.CustomerName')->where('SalesInvoice.CompanyID', '=', company_id())->where('SalesInvoice.SalesInvoiceID', '=', $id)->get();
        return request()->json(200, $sale_invoice);
    }

    public
    function get_saleinvoice_detail1($id)
    {

        $sale_invoice = DB::connection('sqlsrv3')->table("SalesInvoiceItems")->where('CompanyID', '=', company_id())->where('SIID', '=', $id)->get();
        return request()->json(200, $sale_invoice);
    }

    public
    function post_salereturn(Request $request)
    {


        $created_on = long_date();

        $date = $request->get("date");
        $invoice_no = $request->get("invoice_no");
        $customer = $request->get("customer");
        $sale_inv = $request->get("sale_inv");
        $subtotal = $request->get("subtotal");
        $tax = $request->get("tax_amount");
        $delivery_amount = $request->get("delivery_amount");
        $discount = $request->get("discount");
        $totalamount = $request->get("total");
        $remarks = $request->get("remarks");
        $item_name = $request->get('item_name');
        $unit = $request->get('unit');
        $cost = $request->get('cost');
        $saleqty = $request->get('saleqty');
        $rtnqty = $request->get('rtnqty');
        $session = ac_c_session();
        $find_prefix = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('CustomerInvoice')->where('CompanyID', '=', company_id())->get();
        foreach ($find_prefix as $find_prefix1) {

        }
        $date_pref = $this->shiftformat();
        $req_prefix = $find_prefix1->CustomerInvoice . '_' . $date_pref;
        $find_rid9 = DB::connection('sqlsrv3')->table("SalesReturn")->where('CompanyID', '=', company_id())->exists();
        if ($find_rid9) {
            $find_rid = DB::connection('sqlsrv3')->table("SalesReturn")->select('SRtnID')->where('CompanyID', '=', company_id())->get();
            foreach ($find_rid as $find_rid1) {

            }
            $pre_id = explode("-", $find_rid1->SRtnID);
            $rid = $pre_id[2] + 1;
        } else {
            $rid = 1;
        }
        $final_SiCode = 'RTN-' . $req_prefix . '-' . $rid;
        $result = DB::connection('sqlsrv3')->insert("INSERT INTO SalesReturn(CompanyID, SRtnID, customerName, Dated, InvID, InvoiceNo, Session, SubTotal, Tax, ShippingCharges, Discount, TotalAmount, Remarks, CreatedBy, CreatedOn) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [company_id(), $final_SiCode, $customer, $date, $sale_inv, $invoice_no, $session, $subtotal, $tax, $delivery_amount, $discount, $totalamount, $remarks, username(), $created_on]);
        if ($result) {
            $find_srID = DB::connection('sqlsrv3')->table("SalesReturn")->where('CompanyID', '=', company_id())->get();
            foreach ($find_srID as $find_srID1) {

            }
            $item_name1 = explode("|", $item_name);

            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $saleqt = explode("|", $saleqty);
                $rtnqt = explode("|", $rtnqty);
                $uni = explode("|", $unit);
                $cos = explode("|", $cost);
                $subtot = $rtnqt[$x] * $cos[$x];
                $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'ID')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                foreach ($find_itemname as $find_itemname1) {

                }
                DB::connection('sqlsrv3')->insert("INSERT INTO SalesReturnItems(CompanyID, SRID, ItemId, ItemName, PoQuantity, Unit, ReturnQuantity, Price, SubTotal) values (?,?,?,?,?,?,?,?,?)", [company_id(), $find_srID1->SaleReturnID, $find_itemname1->ID, $find_itemname1->Name, $saleqt[$x], $uni[$x], $rtnqt[$x], $cos[$x], $subtot]);
            }

            $doc_date = short_date();
            //
            $item_name2 = explode("|", $item_name);
            for ($z = 1; $z < count($item_name2); $z++) {
                $item_nam = explode("|", $item_name);
                $quantit = explode("|", $rtnqty);
                $uni = explode("|", $unit);
                $cos = explode("|", $cost);
                //Submit items
                DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,CreatedBy,CreatedOn,Reference,Dated, CostUnit) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $item_nam[$z], $quantit[$z], $uni[$z], 5, username(), $created_on, 'Added stock through ' . $final_SiCode, $doc_date, $cos[$z]]);
            }
            //

            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_SiCode, $remarks, 'Sale Return', $created_on, username(), company_id()]);
            if ($doc) {
                $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_SiCode)->get();
                foreach ($find_doc_id as $find_doc_id1) {

                }


                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountHead', '=', 'Customers')->where('AccountName', '=', $customer)->get();
                foreach ($find_acc_code as $find_acc_code1) {

                }


                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Rtn ' . $customer . ' to Inventory', company_id()]);

                $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                foreach ($find_tran_id as $find_tran_id1) {

                }

                $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'C', $totalamount, company_id()]);

                $find_acc_id9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('AccountType', '=', 'Income')->where('CompanyID', '=', company_id())->where('AccountName', '=', 'Sale Invoices')->get();
                foreach ($find_acc_id9 as $find_acc_id91) {

                }

                $ledger_entry9 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_id91->ID, 'D', $totalamount, company_id()]);

                $find_saacc_id = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Expenses')->where('AccountName', '=', 'Cost of Sale')->get();

                foreach ($find_saacc_id as $find_saacc_id1) {

                }
                $ledger_entry5 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_saacc_id1->ID, 'C', $totalamount, company_id()]);


                $cosfind = explode("|", $cost);
                $d_value = count($cosfind) - 1;
                $find_ex_amount = $totalamount - $subtotal;
                $item_wise_value = $find_ex_amount / $d_value;


                for ($y = 1; $y < count($item_name1); $y++) {

                    $item_nam = explode("|", $item_name);
                    $qt = explode("|", $rtnqty);
                    $cos = explode("|", $cost);

                    $amountt = ($qt[$y] * $cos[$y]) + $item_wise_value;

                    $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$y])->get();
                    foreach ($find_itemname as $find_itemname1) {
                    }
                    $find_acc_id = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('AccountType', '=', 'Assets')->where('CompanyID', '=', company_id())->where('AccountName', '=', $find_itemname1->Name)->get();
                    foreach ($find_acc_id as $find_acc_id1) {

                    }
                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_id1->ID, 'D', $amountt, company_id()]);
                }
            }
        }
        $message = "submitted";
        return request()->json(201, $message);
    }


    public
    function get_sale_returns()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("SalesReturn")->where('CompanyID', '=', company_id())->where('Session', $session)->orderby('SaleReturnID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function get_sr_data($id)
    {

        $cand = DB::connection('sqlsrv3')->table('SalesReturn')->join('SalesInvoice', 'SalesReturn.InvID', '=', 'SalesInvoice.SalesInvoiceID')->where('SalesReturn.CompanyID', '=', company_id())->where('SalesReturn.SaleReturnID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public
    function get_srProducts($id)
    {

        $find_products = DB::connection('sqlsrv3')->table("SalesReturnItems")->where('CompanyID', '=', company_id())->where('SRID', $id)->get();
        return request()->json(200, $find_products);
    }

    public
    function insert_squotation(Request $request)
    {


        $date = $request->get('date');

        $customer_name = $request->get('customer_name');

        $item_name = $request->get('item_name');
        $qty = $request->get('qty');
        $unit_cost = $request->get('unit_cost');

        $subtotal = $request->get('subtotal');
        $discount = $request->get('discount');
        $tax_amount = $request->get('tax_amount');
        $delivery_amount = $request->get('delivery_amount');
        $total = $request->get('total');
        $narration = $request->get('narration');

        $created_on = long_date();

        $session = ac_c_session();

        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $item_nam = explode("|", $item_name);
            $qt = explode("|", $qty);
            $est_cos = explode("|", $unit_cost);
            if ($item_nam[$x] == '' || $qt[$x] == '' || $est_cos[$x] == '') {
                $message = 'Empty field';
                return request()->json(200, $message);
            }
        }
        $find_prefix = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('Quotation')->where('CompanyID', '=', company_id())->get();
        foreach ($find_prefix as $find_prefix1) {

        }
        $date_pref = $this->shiftformat();
        $quo_prefix = $find_prefix1->Quotation . '_' . $date_pref;
        $is_quot_exist = DB::connection('sqlsrv3')->table("SQuotation")->where('CompanyID', '=', company_id())->exists();
        if ($is_quot_exist) {
            $find_quot = DB::connection('sqlsrv3')->table("SQuotation")->orderBy('QuotationID', 'asc')->where('CompanyID', '=', company_id())->get();
            foreach ($find_quot as $find_quot1) {
            }
            $find_quotid = explode("-", $find_quot1->QuotationNumber);
            $qid = $find_quotid[1] + 1;
            $quot_number = $quo_prefix . "-" . $qid;
        } else {
            $quot_number = $quo_prefix . "-1";
        }

        $result9 = DB::connection('sqlsrv3')->insert('INSERT INTO SQuotation(CompanyID, CustomerName, SubTotal, Discount, Tax, ShippingCharges, Total, QuotationNumber, Remarks, CreatedBy, CreatedOn, Session, Dated) values (?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $customer_name, $subtotal, $discount, $tax_amount, $delivery_amount, $total, $quot_number, $narration, username(), $created_on, $session, $date]);
        if ($result9) {
            $find_quotid = DB::connection('sqlsrv3')->table("SQuotation")->select('QuotationID')->where('CreatedOn', '=', $created_on)->where('CompanyID', '=', company_id())->get();
            foreach ($find_quotid as $find_quotid1) {
            }

            $item_name1 = explode("|", $item_name);
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $qt = explode("|", $qty);
                $est_cos = explode("|", $unit_cost);
                $total9 = $qt[$x] * $est_cos[$x];

                $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'unit')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                foreach ($find_itemname as $find_itemname1) {

                }
                $result3 = DB::connection('sqlsrv3')->insert('INSERT INTO SQuotationItems(QuotationID, ItemId, ItemName, Quantity, Price, Unit, Total) values (?,?,?,?,?,?,?)', [$find_quotid1->QuotationID, $item_nam[$x], $find_itemname1->Name, $qt[$x], $est_cos[$x], $find_itemname1->unit, $total9]);
            }
        }

        $message = 'submitted';
        return request()->json(200, $message);
    }

    public
    function squotation_detail()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("SQuotation")->where('CompanyID', '=', company_id())->where('Session', '=', $session)->orderby('QuotationID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function get_salecustomer()
    {

        $arr = DB::connection('sqlsrv3')->table('Customer')->orderBy('CustomerName', 'asc')->select('CompanyID', 'CustomerName')->where('CompanyID', '=', company_id())->where('Status', '=', '1')->get();
        return request()->json(200, $arr);
    }

    public
    function get_customer_detail($name)
    {

        $arr = DB::connection('sqlsrv3')->table('Customer')->where('CompanyID', '=', company_id())->where('CustomerName', '=', $name)->orderBy('CustomerID', 'desc')->get();
        return request()->json(200, $arr);
    }

    public
    function get_quotationdetails($id)
    {

        $find_session = DB::connection('sqlsrv3')->table('SQuotation')->where('CompanyID', '=', company_id())->where('QuotationID', '=', $id)->orderBy('QuotationID', 'desc')->get();
        return request()->json(200, $find_session);
    }

    public
    function get_quotationdetails1($id)
    {

        $find_session = DB::connection('sqlsrv3')->table('SQuotationItems')->where('CompanyID', '=', company_id())->where('QuotationID', '=', $id)->orderBy('QuotationItemID', 'desc')->get();
        return request()->json(200, $find_session);
    }

    public
    function squotation_byname(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('SQuotation')->orderBy('QuotationID', 'desc')->where('CompanyID', '=', company_id())->where('CustomerName', 'like', '%' . $request->name . '%')->paginate(20);
        return request()->json(200, $arr);
    }

    public
    function all_acc_types()
    {

        $find_config = DB::connection('sqlsrv3')->table("AccountsHead")->select('HeadName')->where('CompanyID', '=', company_id())->orderby('HeadCode', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public
    function chartof_Accounts($c_type)
    {
        if ($c_type == 'All') {
            $c_type = '';
        }

        $find_config = DB::connection('sqlsrv3')->table("Accounts")->where('CompanyID', '=', company_id())->where("AccountType", 'like', '%' . $c_type . '%')->get();
        return request()->json(200, $find_config);
    }

    //reports
    public
    function itemlist_report($c_type)
    {

        $arr = DB::connection("sqlsrv3")->table("ItemList")->join("ItemCategory", "ItemCategory.ID", "=", "ItemList.ItemCategory")->where("ItemList.CompanyID", '=', company_id())->where("ItemCategory.CategoryType", '=', $c_type)->select("ItemList.*", "ItemCategory.CategoryName")->get();
        return request()->json(200, $arr);
    }

    // public function ledger_report($start_date, $end_date, $ledger_name)
    // {
    //

    //   $pre_id = explode("_", $ledger_name);
    //   //         $result=DB::connection('sqlsrv3')->select("SET NOCOUNT ON
    //   // ;with cte as (SELECT ROW_NUMBER() OVER (ORDER BY CAST(GETDATE() AS TIMESTAMP)) AS RowNumber,  d.DocumentNo,e.AccountID, a.AccountName,t.TransactionDate,t.Description,
    //   // (CASE WHEN e.EntryType='D'
    //   //          THEN e.amount ELSE 0.0 END) AS TotalDebit,
    //   // (CASE WHEN  e.EntryType='C'
    //   //          THEN e.amount ELSE 0.0 END) AS TotalCredit
    //   // FROM Transactions t
    //   // LEFT JOIN ledger_entries e ON e.TransactionID = t.id
    //   // LEFT JOIN Documents d ON d.ID = t.DocumentID
    //   // LEFT JOIN Accounts a ON a.id = e.AccountID
    //   // WHERE t.TransactionDate   between '".$start_date."' and '".$end_date."'
    //   // and  e.AccountID like concat (".$pre_id[0]." ,'%')
    //   // and a.CompanyID = '".company_id()."'
    //   // ),
    //   // ctee AS (
    //   // select   * , sum( TotalCredit - TotalDebit )   over (order by   RowNumber RANGE UNBOUNDED PRECEDING) as balance
    //   //    from cte)
    //   //    select RowNumber,DocumentNo , AccountID , AccountName, TransactionDate,Description ,TotalDebit , TotalCredit  , ABS(Balance) as balance from  ctee
    //   //    ORDER BY RowNumber ");


    //   $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC	 [dbo].[LedgerReport]
    //  @startdate = '" . $start_date . "',
    //  @enddate = '" . $end_date . "',
    //  @compa = N'" .company_id() . "',
    //  @Id = '" . $pre_id[0] . "' ");


    //   return request()->json(200, $result);
    // }
    public
    function ledger_report(Request $request, $start_date, $end_date, $ledger_name)
    {
        try {
            $myArray = explode(',', $ledger_name);
            $perPage = $request->input('per_page', 1000); // default to 1000 if not provided

            $currentPage = $request->input('page', 1);
            $result = [];
            if ($request->input('new') === "true") {
                if (count($myArray) > 1) {
                    foreach ($myArray as $arr) {
                        $pre_id = explode("_", $arr);
                        $result_arr = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC	 [dbo].[LedgerReport]
                           @startdate = '" . $start_date . "',
                           @enddate = '" . $end_date . "',
                           @compa = N'" . company_id() . "',
                           @Id = '" . $pre_id[0] . "' ");
                        $result[] = $result_arr;
                    }
                    $result = array_merge(...$result);

//                 cache the LedgerReport data
                    Cache::forget('LedgerReport');
                    Cache::put('LedgerReport', $result);

                    // Return paginated data as JSON response
                    $perPage = count($result);
                    return $this->sendSuccess('Ledger report generated successfully .', paginateLedger($result, $currentPage, $perPage));
                } else {
                    $pre_id = explode("_", $myArray[0]);

                    $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC	 [dbo].[LedgerReport]
                       @startdate = '" . $start_date . "',
                       @enddate = '" . $end_date . "',
                       @compa = N'" . company_id() . "',
                       @Id = '" . $pre_id[0] . "' ");

//                 cache the LedgerReport data
                    Cache::forget('LedgerReport');
                    Cache::put('LedgerReport', $result);

                    // Return paginated data as JSON response
                    return $this->sendSuccess('Ledger report generated successfully .', paginateLedger($result, $currentPage, $perPage));
                }
            } else if (Cache::has('LedgerReport')) {

                $collection = collect(Cache::get('LedgerReport'));

                // Return paginated data as JSON response
                return $this->sendSuccess('Ledger report generated successfully .', paginateLedger($collection, $currentPage, $perPage));

            }
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }


    }

    public
    function exportExcel(Request $request)
    {
        try {

            $headings = [
                'S.NO',
                'DATE',
                'REF.NO',
                'DESCRIPTION',
                'DEBIT',
                'CREDIT',
                'BALANCE',
            ];

            $mappings = [
                'S.NO' => 'RowNumber',
                'DATE' => 'TransactionDate',
                'REF.NO' => 'DocumentNo',
                'DESCRIPTION' => 'Description',
                'DEBIT' => 'Debit',
                'CREDIT' => 'Credit',
                'BALANCE' => 'balance',
            ];

            $additionalFields = [
                'Date' => $request->input('0.start_data') . ' To ' . $request->input('0.end_date'),
                'Account ID' => $request->input('0.AccountID'),
                'Account Name' => $request->input('0.AccountName'),
                'Balance' => $request->input('0.am'),
                'Opening Balance' => $request->input('0.opening_balance'),
            ];


            $collection = collect(Cache::get('LedgerReport'));
            $data = $collection->map(function ($object) use ($mappings) {
                $row = [];
                foreach ($mappings as $heading => $property) {
                    $row[$heading] = $object->$property ?? null;
                }
                return $row;
            });
            $export = new GeneralReportExport($data, $headings, $additionalFields);

            return Excel::download($export, 'Datewise_Ledger_Detail.xlsx');

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    public
    function get_all_general()
    {
        try {
            $collection = collect(Cache::get('LedgerReport'));
            return $this->sendSuccess('All Ledger report generated successfully .', $collection);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }

    }


    public
    function trail_balance_sum()
    {


        // $credit = DB::connection('sqlsrv3')->table('Ledger_Entries')->join("Transactions", 'Ledger_Entries.TransactionID', '=', 'Transactions.ID')
        // ->where('Transactions.TransactionDate','>=',$start_date)->where('Transactions.TransactionDate','<=',$end_date)
        // ->where('Ledger_Entries.EntryType','=',"C")->where('Ledger_Entries.CompanyID','=', company_id())->sum('Ledger_Entries.Amount');

        // $debit = DB::connection('sqlsrv3')->table('Ledger_Entries')->join("Transactions", 'Ledger_Entries.TransactionID', '=', 'Transactions.ID')
        // ->where('Transactions.TransactionDate','>=',$start_date)->where('Transactions.TransactionDate','<=',$end_date)
        // ->where('Ledger_Entries.EntryType','=','D')->where('Ledger_Entries.CompanyID','=', company_id())->sum('Ledger_Entries.Amount');
        $credit = DB::connection('sqlsrv3')->table('Ledger_Entries')->where('EntryType', '=', "C")->sum('Amount');
        $debit = DB::connection('sqlsrv3')->table('Ledger_Entries')->where('EntryType', '=', "D")->sum('Amount');
        $myJSON = array(
            'credit_sum' => $credit,
            'debit_sum' => $debit,
        );
        return request()->json(200, $myJSON);
    }

    public
    function ledger_report_balance($start_date, $end_date, $ledger_name)
    {
        $myArray = explode(',', $ledger_name);

        $created_on = short_date();

        $results = [];
        if (count($myArray) > 1) {
            foreach ($myArray as $ledger_name) {
                $created_on = short_date();
                $pre_id = explode("_", $ledger_name);
                $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
            @Datefrom = N'2000-01-01',
            @DateTo = N'" . $created_on . "',
            @id = " . $pre_id[0] . ",
            @compid = N'" . company_id() . "'  ");
                $results[] = $result;
            }
            $results = array_merge(...$results);
            Cache::put('ledger_report_balance', $results);

            return request()->json(200, $results);
        } else {
            $created_on = short_date();
            $pre_id = explode("_", $ledger_name);
            $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
            @Datefrom = N'2000-01-01',
            @DateTo = N'" . $created_on . "',
            @id = " . $pre_id[0] . ",
            @compid = N'" . company_id() . "'  ");

            Cache::put('ledger_report_balance', $results);

            return request()->json(200, $result);
        }


    }

    public
    function fetch_asset($id)
    {

        $arr = DB::connection('sqlsrv3')->table('Assets')->join("ItemList", 'ItemList.ID', '=', 'Assets.AssetID')->join('ItemCategory', 'ItemList.ItemCategory', '=', 'ItemCategory.ID')->where('Assets.CompanyID', '=', company_id())->where('Assets.AssetType', '=', 1)->where('Assets.AssetsUniqueID', '=', $id)->select('Assets.*', 'ItemCategory.CategoryName', 'ItemList.Name')->get();
        return request()->json(200, $arr);
    }

    public
    function assign_asset(Request $request)
    {

        $asset_id = $request->get('asset_id');
        $unit = $request->get('unit');

        $emp_Dept = $request->get('emp_Dept');

        $empCode = explode("_", $request->get('empCode'));
        $location = $request->get('location');
        $project = $request->get('project');
        $remarks = $request->get('remarks');


        $update_date = long_date();
        $update_d = short_date();

        $asset = explode("-", $asset_id);
        $resu = DB::connection('sqlsrv3')->insert('INSERT INTO Assets(CompanyID,AssetID,AssetsUniqueID,Quantity,Unit,AssetType,CreatedBy,CreatedOn,Reference,Dated,AssignedTo,Location,Project,EmployeeCode,Remarks) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $asset[0], $asset_id, 1, $unit, 2, username(), $update_date, 'Assign Asset To ' . $emp_Dept, $update_d, $emp_Dept, $location, $project, $empCode[0], $remarks]);
        $arr = "submitted!";
        return request()->json(200, $arr);
    }

    public
    function return_asset(Request $request)
    {

        $asset_id = $request->get('asset_id');
        $emp_Dept = $request->get('emp_Dept');
        $empCode = explode("_", $request->get('emp_Code'));
        $unit = $request->get('unit');
        $remarks = $request->get('remarks');

        $update_date = long_date();
        $update_d = short_date();

        $asset = explode("-", $asset_id);
        $resu = DB::connection('sqlsrv3')->insert('INSERT INTO Assets(CompanyID,AssetID,AssetsUniqueID,Quantity,Unit,AssetType,CreatedBy,CreatedOn,Reference,Dated,EmployeeCode,Remarks) values (?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $asset[0], $asset_id, 1, $unit, 3, username(), $update_date, 'Return Asset From ' . $emp_Dept, $update_d, $empCode[0], $remarks]);
        $arr = "submitted!";
        return request()->json(200, $arr);
    }


    public
    function get_isssuances()
    {

        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $all_issuances = DB::connection('sqlsrv3')->table("Issuances")
            // ->where('Session', '=', $find_session1->SessionName)
            ->where('CompanyID', '=', company_id())->orderby('IssuanceId', 'desc')->get();
        return request()->json(200, $all_issuances);
    }

    public
    function get_iss_detail($id)
    {

        $cand = DB::connection('sqlsrv3')->table('Issuances')->where('IssuanceId', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public
    function get_iss_item($id)
    {

        $cand = DB::connection('sqlsrv3')->table('IssuanceItem')->where('IssuanceId', '=', $id)->orderby('IssuanceItemId', 'desc')->get();
        return request()->json(200, $cand);
    }

    public
    function insert_issuanceReturn(Request $request)
    {
        $username = username();
        $date = $request->get('date');
        $issuance = $request->get('issuance');
        $status = $request->get('status');
        $item_name = $request->get('item_name');
        $unit = $request->get('unit');
        $iss_qty = $request->get('iss_qty');
        $qty = $request->get('qty');
        $remarks = $request->get('narration');
        $created_on = long_date();

        $Tamount = $request->get('Total');

        $UnitPrice = $request->get('UnitPrice');
        $short_date = short_date();
        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $iss_qt = explode("|", $iss_qty);
            $qt = explode("|", $qty);
            $UnitCost = explode("|", $UnitPrice);
            if ($qt[$x] == '') {
                $message = 'Please enter return quantity';
                return request()->json(200, $message);
            } else if ($qt[$x] > $iss_qt[$x]) {
                $message = 'Return quantity cannot be greater then Issued quantity';
                return request()->json(200, $message);
            } else if ($qt[$x] < 0) {
                $message = 'Return quantity cannot be negative';
                return request()->json(200, $message);
            }

            $t_iss_amount = $UnitCost[$x] * $qt[$x];
            if ($t_iss_amount < 0) {
                $message = 'Amount cannot be negative';
                return request()->json(200, $message);
            }
        }

        $session = ac_c_session();
        $find_rid9 = DB::connection('sqlsrv3')->table("IssuanceReturn")->where('CompanyID', '=', company_id())->exists();
        if ($find_rid9) {
            $find_rid1 = DB::connection('sqlsrv3')->table("IssuanceReturn")->where('CompanyID', '=', company_id())->orderBy('IssuenceReturnID', 'DESC')->first();

            $pre_id = explode("-", $find_rid1->IRtnID);
            $rid = $pre_id[2] + 1;
        } else {
            $rid = 1;
        }
        $date_pref = shiftformat();
        $final_IssID = 'Rtn-Iss_' . $date_pref . '-' . $rid;
        if ($status == 1) {
            $status1 = 'Fully Returned';
        } else {
            $status1 = 'Partially Returned';
        }

        try {
            $issrtninserted = DB::connection('sqlsrv3')->insert('INSERT INTO IssuanceReturn(CompanyID, Dated, IssID, IRtnID, Status2, Remarks, CreatedBy, CreatedOn, Session,TotalAmount) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $date, json_decode($issuance['id']), $final_IssID, $status1, $remarks, username(), $created_on, $session, $Tamount]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json(['message' => 'IssuanceReturn Already Exists.'], 422);

            } else {
                throw $e;
            }
        }
        if ($issrtninserted) {
            $find_issrtnid1 = DB::connection('sqlsrv3')->table("IssuanceReturn")->select('IssuenceReturnID')->where('CreatedOn', '=', $created_on)->where('CompanyID', '=', company_id())->orderBy('IssuenceReturnID', 'desc')->first();

            $item_name1 = explode("|", $item_name);
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $iss_qt = explode("|", $iss_qty);
                $uni = explode("|", $unit);
                $qt = explode("|", $qty);
                $UnitCost = explode("|", $UnitPrice);
                $ucost = 0;

                if ($UnitCost[$x] == "") {
                    $ucost = 0;
                } else {
                    $ucost = $UnitCost[$x];
                }

                $SubTotal = $ucost * $qt[$x];
                $find_itemname1 = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'unit')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->orderBy('ID', 'DESC')->first();

                if ($qt[$x] != 0 || $qt[$x] != 0.00) {
                    $result3 = DB::connection('sqlsrv3')->insert('INSERT INTO IssuanceReturnItem(CompanyID, IssuanceReturnId, ItemId, ItemName, IssuanceQuantity, unit, ReturnQuantity,Price,SubTotal) values (?,?,?,?,?,?,?,?,?)', [company_id(), $find_issrtnid1->IssuenceReturnID, $item_nam[$x], $find_itemname1->Name, $iss_qt[$x], $uni[$x], $qt[$x], $ucost, $SubTotal]);
                    $check_invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $item_nam[$x])->exists();
                    $facevalue = '';
                    if ($check_invent) {
                        $invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $item_nam[$x])->select('FaceValue')->orderBy('ID', 'DESC')->first();
                        $facevalue = $invent->FaceValue;
                    } else {
                        $facevalue = 0;
                    }
                    DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,CreatedBy,CreatedOn,Reference,Dated,FaceValue) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $item_nam[$x], $qt[$x], $uni[$x], 7, username(), $created_on, 'Added stock through ' . $final_IssID, $date, $facevalue]);

                }
            }
            $find_dept_name1 = DB::connection('sqlsrv3')->table("Issuances")->where('CompanyID', '=', company_id())->where('IssuanceId', '=', $issuance)->orderBy('IssuanceId', 'desc')->first();

            $dept_name = $find_dept_name1->DepartmentName;
            $project = $find_dept_name1->ProjectName;
            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$short_date, $final_IssID, $final_IssID . '/' . $dept_name . '/' . $project, 'Issuance Return', $created_on, username(), company_id()]);
            if ($doc) {
                $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_IssID)->orderBy('ID', 'DESC')->first();

                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $short_date, $dept_name . '/' . $project . 'To Inventory', company_id()]);
                $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                for ($x = 1; $x < count($item_name1); $x++) {
                    $item_nam = explode("|", $item_name);
                    $qt = explode("|", $qty);
                    $UnitCost = explode("|", $UnitPrice);
                    $t_iss_amount = $UnitCost[$x] * $qt[$x];
                    $find_acc_code1 = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ItemId', '=', $item_nam[$x])->orderBy('ID', 'DESC')->first();
                    $find_acc_code91 = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ProjectName', '=', $project)->orderBy('ID', 'DESC')->first();

                    if ($qt[$x] != 0 || $qt[$x] != 0.00) {
                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->CoaID, 'D', $t_iss_amount, company_id()]);

                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'C', $t_iss_amount, company_id()]);
                    }
                }
            }
        }
        $message = 'submitted';
        return request()->json(200, $message);
    }

    public
    function get_issuance_return()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("IssuanceReturn")->join('Issuances', 'IssuanceReturn.IssID', '=', 'Issuances.IssuanceId')->where('IssuanceReturn.Session', '=', $session)->where('IssuanceReturn.CompanyID', '=', company_id())->select('IssuanceReturn.*', 'Issuances.DepartmentName', 'Issuances.ProjectName', 'Issuances.IssuanceCode')->orderby('IssuanceReturn.IssuenceReturnID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function issuanceRtn_bydept(Request $request)
    {


        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("IssuanceReturn")->join('Issuances', 'IssuanceReturn.IssID', '=', 'Issuances.IssuanceId')
            // ->where('IssuanceReturn.Session', '=', $session)
            ->where('IssuanceReturn.CompanyID', '=', company_id())->where('Issuances.DepartmentName', 'like', '%' . $request->dept . '%')->select('IssuanceReturn.*', 'Issuances.DepartmentName', 'Issuances.ProjectName', 'Issuances.IssuanceCode')->orderby('IssuanceReturn.IssuenceReturnID', 'desc')->paginate(20);


        return request()->json(200, $find_config);
    }

    public
    function searchissuance_rtn($department, $project, $datefrom, $dateto)
    {

        if ($department == "All") {
            $department = "";
        }
        if ($project == "All") {
            $project = "";
        }

        $session = ac_c_session();

        $find_config = DB::connection('sqlsrv3')->table("IssuanceReturn")->join('Issuances', 'IssuanceReturn.IssID', '=', 'Issuances.IssuanceId')
            // ->where('IssuanceReturn.Session', '=', $session)
            ->where('IssuanceReturn.CompanyID', '=', company_id())->select('IssuanceReturn.*', 'Issuances.DepartmentName', 'Issuances.ProjectName', 'Issuances.IssuanceCode')->where('Issuances.DepartmentName', 'like', '%' . $department)->where('Issuances.ProjectName', 'like', '%' . $project)->where('IssuanceReturn.Dated', '>=', $datefrom)->where('IssuanceReturn.Dated', '<=', $dateto)->orderby('IssuanceReturn.IssuenceReturnID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function get_PO_Grndetail()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("GrnOrder")->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'GrnOrder.POID')->join('Requisition', 'PurchaseOrder.AgainstReq', '=', 'Requisition.RequisitionId')->where('PurchaseOrder.RequisitionType', '=', 'Services')->where('PurchaseOrder.CompanyID', '=', company_id())->where('PurchaseOrder.Session', '=', $session)->where('PurchaseOrder.pinv_state', '=', 0)->orderby('GrnOrder.GrnOrderID', 'desc')->select('PurchaseOrder.PurchaseOrderID', 'PurchaseOrder.VendorName', 'PurchaseOrder.RequisitionType', 'Requisition.RequisitionId', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'PurchaseOrder.PoCode', 'GrnOrder.GrnID', 'GrnOrder.GrnOrderID')->get();
        return request()->json(200, $find_config);
    }

    public
    function get_purchaseorder_detailgrn($poid)
    {

        $get_quo = DB::connection('sqlsrv3')->table('GrnOrder')->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'GrnOrder.POID')->where('GrnOrder.CompanyID', '=', company_id())->where('GrnOrder.GrnOrderID', '=', $poid)->select('GrnOrder.*', 'PurchaseOrder.*')->get();
        return request()->json(200, $get_quo);
    }

    public
    function get_purchaseorder_detail1grn($poid)
    {
        $get_quo = DB::connection('sqlsrv3')->table('GrnOrderItems')->where('GrnID', '=', $poid)->get();
        return request()->json(200, $get_quo);
    }

    public
    function get_PO_servicesdetail()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("PurchaseOrder")->join('Requisition', 'PurchaseOrder.AgainstReq', '=', 'Requisition.RequisitionId')->where('PurchaseOrder.CompanyID', '=', company_id())->where('PurchaseOrder.Session', '=', $session)->where('PurchaseOrder.pinv_state', '=', 0)->where('PurchaseOrder.RequisitionType', '=', 'Services')->orderby('PurchaseOrder.PurchaseOrderID', 'desc')->select('PurchaseOrder.PurchaseOrderID', 'PurchaseOrder.VendorName', 'PurchaseOrder.RequisitionType', 'Requisition.RequisitionId', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'PurchaseOrder.PoCode')->get();
        return request()->json(200, $find_config);
    }

    public
    function get_issuancereturn($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("IssuanceReturn")->join('Issuances', 'IssuanceReturn.IssID', '=', 'Issuances.IssuanceId')->where('IssuanceReturn.CompanyID', '=', company_id())->where('IssuanceReturn.IssuenceReturnID', '=', $id)->get();
        return request()->json(200, $find_config);
    }

    public
    function get_issuancereturn1($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("IssuanceReturnItem")->where('CompanyID', '=', company_id())->where('IssuanceReturnId', '=', $id)->get();
        return request()->json(200, $find_config);
    }

    public
    function numberToWord($num = '')
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

    public
    function reverse_po($id)
    {


        $founded = long_date();
        $find_qo1 = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->where('PurchaseOrderID', '=', $id)->orderBy('PurchaseOrderID', 'desc')->first();


        $check = DB::connection('sqlsrv3')->table("ReceivingOrder")->where("POID", '=', $id)->exists();
        $check1 = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where("AgainstPO", '=', $find_qo1->PoCode)->exists();
        if ($check1) {
            $arr1 = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where("AgainstPO", '=', $find_qo1->PoCode)->orderBy('DetailID', 'DESC')->select('Remaining')->first();
            if ($arr1->Remaining < $find_qo1->TotalAmount) {
                $arr = 'Advance present against this PO';
                return request()->json(200, $arr);
            }
        }
        if ($check) {
            $arr = 'Purchase Invoice present againstt this PO';
            return request()->json(200, $arr);
        } else {
            $result = DB::connection('sqlsrv3')->update('update PurchaseOrder set Status2=?,state=?,pinv_state=?,DebitState=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and PurchaseOrderID=?', ['Reverse', 1, 1, 1, username(), $founded, company_id(), $id]);
            if ($result) {

                DB::connection('sqlsrv3')->update('update PQuotation set Status=?,state=? where CompanyID=? and QuotationID=?', ['Added', 0, company_id(), $find_qo1->AgainstQuo]);

                DB::connection('sqlsrv3')->update('update PQuotationItems set State=? where QuotationID=?', ['false', $find_qo1->AgainstQuo]);


                $find_req = DB::connection('sqlsrv3')->table('PQuotation')->where('CompanyID', '=', company_id())->where('QuotationID', '=', $find_qo1->AgainstQuo)->get();
                foreach ($find_req as $find_req1) {
                }
                $req_id = $find_req1->RequisitionID;
                $req_quo = 'q' . $find_req1->QuotationNumber;

                DB::connection('sqlsrv3')->update('update Requisition set ' . $req_quo . '=? where CompanyID=? and RequisitionId=?', ['Added', company_id(), $req_id]);
            }

            $find_config = "submitted";
            return request()->json(200, $find_config);
        }


    }

    public
    function po_data()
    {

        $find_company = DB::connection('sqlsrv3')->table("PurchaseOrder")->where('CompanyID', '=', company_id())->orderby('PurchaseOrderID', 'desc')->paginate(8);
        return request()->json(200, $find_company);
    }

    public
    function close_po(Request $request)
    {

        $po_id = $request->get('po_id');
        $success = DB::connection('sqlsrv3')->update('update  PurchaseOrder set state=?, pinv_state=? where CompanyID=? and PurchaseOrderID=?', [1, 1, company_id(), $po_id]);
        if ($success) {
            $result = DB::connection('sqlsrv3')->table("PurchaseOrder")->where('CompanyID', '=', company_id())->orderby('PurchaseOrderID', 'desc')->paginate(8);
            return request()->json(200, $result);
        } else {
            $result = "Purchase order not closed";
            return request()->json(200, $result);
        }
    }

    public
    function get_currency()
    {


        $find_config = DB::connection('sqlsrv3')->table("AccountsConfiguration")->where('CompanyID', '=', company_id())->select('Currency')->get();
        return request()->json(200, $find_config);
    }

    public
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

    public
    function fetch_po_detail($vendor)
    {


        $session = ac_c_session();
        $vendo = explode("_", $vendor);
        $find_config = DB::connection('sqlsrv3')->table("PurchaseOrder")->where('CompanyID', '=', company_id())->where('state', '=', 0)->where('pinv_state', '=', 0)
            ->where('Session', '=', $session)
            ->where('Status2', '!=', 'Reverse')
            ->where('vendorName', '=', $vendo[1])->select('PoCode')->orderby('PurchaseOrderID', 'desc')->get();
        return request()->json(200, $find_config);
    }

    public
    function fetch_po_detail1($vendor)
    {


        $session = ac_c_session();
        $vendo = explode("_", $vendor);
        $find_config = DB::connection('sqlsrv3')->table("PurchaseOrder")->where('CompanyID', '=', company_id())->where('DebitState', '=', 0)->where('Status2', '!=', 'Reverse')->where('Session', '=', $session)->where('vendorName', '=', $vendo[1])->select('PoCode')->orderby('PurchaseOrderID', 'desc')->get();
        return request()->json(200, $find_config);
    }

    public
    function fetch_pi_detailpv($vendor)
    {

        $session = ac_c_session();
        $vendo = explode("_", $vendor);
        $find_config1 = DB::connection('sqlsrv3')->table("ReceivingOrder")
            ->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'ReceivingOrder.POID')->where('ReceivingOrder.CompanyID', '=', company_id())
            ->where('ReceivingOrder.isDeleted', '=', 0)
            ->where('ReceivingOrder.Status2', '=', 'Verified')
            ->where('PurchaseOrder.vendorName', '=', $vendo[1])->select('ReceivingOrder.FormID')->get();
        $find_config2 = DB::connection('sqlsrv3')->table("PaymentVoucher")
            ->join('PaymentVoucherDetail', 'PaymentVoucher.PaymentVoucherID', '=', 'PaymentVoucherDetail.PID')
            ->where('PaymentVoucher.CompanyID', '=', company_id())
            ->where('PaymentVoucherDetail.Remaining', '=', 0)
            ->where('PaymentVoucher.PaymentAgainst', '=', $vendo[1])->select('PaymentVoucherDetail.AgainstINV as FormID')->get();
        $valuesToExclude = collect($find_config2)->pluck('FormID')->toArray();
        // Remove objects from $objects1 based on property value
        $filteredObjects = collect($find_config1)->reject(function ($object) use ($valuesToExclude) {
            return in_array($object->FormID, $valuesToExclude);
        })->values();
        return request()->json(200, $find_config1);
    }

    public
    function fetch_pi_detail($vendor)
    {


        $session = ac_c_session();
        $vendo = explode("_", $vendor);
        $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")
            ->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'ReceivingOrder.POID')->where('ReceivingOrder.CompanyID', '=', company_id())
            // ->where('ReceivingOrder.Session', '=', $session)
            ->where('ReceivingOrder.Status2', '=', 'Verified')
            ->where('PurchaseOrder.vendorName', '=', $vendo[1])->select('ReceivingOrder.*')->orderby('ReceivingOrder.ReceavingOrderID', 'desc')->get();
        return request()->json(200, $find_config);
    }

    public
    function fetch_pi_detail9($vendor)
    {


        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")
            ->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'ReceivingOrder.POID')->where('ReceivingOrder.CompanyID', '=', company_id())
            ->where('ReceivingOrder.Session', '=', $session)->where('ReceivingOrder.Status2', '=', 'Verified')
            ->where('PurchaseOrder.vendorName', '=', $vendor)->select('ReceivingOrder.FormID')->orderby('ReceivingOrder.ReceavingOrderID', 'desc')->get();
        return request()->json(200, $find_config);
    }

    public
    function submit_project_child1(Request $request)
    {

        $project_name = $request->get('project_name');


        $founded = long_date();

        $isproject_name = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->where('CompanyID', '=', company_id())->where("ProjectName", "=", $project_name)->exists();
        if ($isproject_name) {
            $data = "Project name already exists";
            return request()->json(401, $data);
        } else {
            $result = DB::connection('sqlsrv3')->insert('INSERT INTO ProjectLinkCoa(CompanyID,ProjectName,CreatedBy,CreatedOn) values (?,?,?,?)', [company_id(), $project_name, username(), $founded]);
            $data = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->where('CompanyID', '=', company_id())->paginate(20);
            return request()->json(401, $data);
        }
    }

    public
    function fetch_coaproject()
    {

        $data = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->where('CompanyID', '=', company_id())->paginate(20);
        return request()->json(401, $data);
    }

    public
    function searchcoa($account_name)
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->where('CompanyID', '=', company_id())->where('ProjectName', 'like', '%' . $account_name . '%')->paginate(20);
        return request()->json(200, $find_journal_headname);
    }

    public
    function get_linkaccount($id)
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->where('CompanyID', '=', company_id())->where('ID', '=', $id)->get();
        return request()->json(200, $find_journal_headname);
    }

    public
    function fetch_expense_head()
    {

        $find_config = DB::connection('sqlsrv3')->select("Select ID,AccountName from Accounts where CompanyID = '" . company_id() . "' and  CoaType = 'Transaction' and
 (ID like '5%'  or ID like '302%'  or ID like '10%') ");
        return request()->json(200, $find_config);
    }

    public
    function fetch_pettycash_head()
    {

        $find_config = DB::connection('sqlsrv3')->select("Select ID,AccountName from Accounts where CompanyID = '" . company_id() . "' and  CoaType = 'Transaction' and
 (ID like '101001001002%') ");
        return request()->json(200, $find_config);
    }

    public
    function fetch_inventory_head()
    {

        $find_config = DB::connection('sqlsrv3')->table("Accounts")->select('ID', 'AccountName')->where('CompanyID', '=', company_id())->where('CoaType', '=', 'Transaction')->where('ID', 'like', '101003%')->orderby('ID', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public
    function fetch_assets_head()
    {

        $find_config = DB::connection('sqlsrv3')->table("Accounts")->select('ID', 'AccountName')->where('CompanyID', '=', company_id())->where('CoaType', '=', 'Transaction')->where('AccountCode', 'like', '1%')->orderby('ID', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public
    function submit_linkcoaproject(Request $request)
    {

        $Emp_id = employee_id();

        $project_id = $request->get('project_id');
        $project_name1 = $request->get('project_name1');
        $selected = $request->get('dept_name');
        $account_idname = $request->get('account_idname');

        $founded = long_date();

        $accountby = explode("_", $account_idname);
        $account_id = $accountby[0];
        $account_name = $accountby[1];
        $result = DB::connection('sqlsrv3')->update('update ProjectLinkCoa set CoaID=?,CoaName=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and ID=?', [$account_id, $account_name, username(), $founded, company_id(), $project_id]);

        if ($result) {
            DB::connection('sqlsrv3')->table('DepartmentProject')->where('CompanyID', '=', company_id())->where('ProjectID', $project_id)->delete();
            for ($x = 0; $x < count($selected); $x++) {
                DB::connection('sqlsrv3')->insert("INSERT INTO DepartmentProject(CompanyID,DepartmentName,ProjectID,CreatedBy,CreatedOn) values (?,?,?,?,?)", [company_id(), $selected[$x], $project_id, username(), $founded]);
                DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Linked Project to new Department or Account', 'Linked Project | ' . $project_name1 . ' | having Project Id | ' . $project_id . ' | to Department | ' . $selected[$x] . ' against Account | ' . $account_idname . '', $founded]);

            }


            $data = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->where('CompanyID', '=', company_id())->paginate(20);
            return request()->json(401, $data);
        } else {
            $data = "error";
            return request()->json(401, $data);
        }
    }

    public
    function get_departmentdetail1($id)
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("DepartmentProject")->where('CompanyID', '=', company_id())->where('ProjectID', '=', $id)->select('DepartmentName')->get();

        return request()->json(200, $find_journal_headname);
    }

    public
    function get_projects9()
    {

        $dept = emp_department();
        $find_config = DB::connection('sqlsrv3')->select("select d.DepartmentName,p.ID, p.ProjectName from DepartmentProject d join ProjectLinkCoa p on d.ProjectID =p.ID where p.CoaID is not null and d.CompanyID = '" . company_id() . "' and d.DepartmentName = '" . $dept . "'");
        return request()->json(200, $find_config);
    }

    public
    function get_projects99($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->where('CompanyID', '=', company_id())->where('ID', '=', $id)->get();
        return request()->json(200, $find_config);
    }

    public
    function get_departmentcoa($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("DepartmentProject")->where('CompanyID', '=', company_id())->where('ProjectID', '=', $id)->orderby('ID', 'desc')->get();
        return request()->json(200, $find_config);
    }

    /*
  public function fetch_inventorydata()
  {

    $data = DB::connection('sqlsrv3')->table("ItemLinkCoa")->where('CompanyID', '=', company_id())->orderby('ID', 'desc')->paginate(20);
    return request()->json(401, $data);
  }
  */
    public
    function fetch_assetsdata()
    {

        $data = DB::connection('sqlsrv3')->table("AssetsLinkCoa")->where('CompanyID', '=', company_id())->orderby('ID', 'desc')->paginate(20);
        return request()->json(401, $data);
    }

    public
    function fetch_itemlist()
    {

        $data = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('ItemId', 'Name')->where('CompanyID', '=', company_id())->get();
        return request()->json(401, $data);
    }

    public
    function submit_inventorylink(Request $request)
    {


        $selected = $request->get('item_idname');
        $account_idname = $request->get('account_idname');

        $founded = long_date();

        $accountby = explode("_", $account_idname);
        $account_id = $accountby[0];
        $account_name = $accountby[1];
        for ($x = 0; $x < count($selected); $x++) {
            $item = explode("_", $selected[$x]);
            $item_id = $item[0];
            $item_name = $item[1];

            $result = DB::connection('sqlsrv3')->update('update ItemLinkCoa set CoaID=?,CoaName=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and ItemId=?', [$account_id, $account_name, username(), $founded, company_id(), $item_id]);
        }
        $data = DB::connection('sqlsrv3')->table("ItemLinkCoa")->where('CompanyID', '=', company_id())->orderby('ID', 'desc')->paginate(20);
        return request()->json(401, $data);
    }

    public
    function get_itemsdetail1($id)
    {

        $find_journal_headname = DB::connection('sqlsrv3')->table("ItemLinkCoa")->where('CompanyID', '=', company_id())->where('ItemId', '=', $id)->get();

        return request()->json(200, $find_journal_headname);
    }

    public
    function submit_sepinventorylink(Request $request)
    {


        $item_ide = $request->get('item_ide');
        $account_idname = $request->get('account_idname_sep');

        $founded = long_date();

        $accountby = explode("_", $account_idname);
        $account_id = $accountby[0];
        $account_name = $accountby[1];


        $result = DB::connection('sqlsrv3')->update('update ItemLinkCoa set CoaID=?,CoaName=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and ItemId=?', [$account_id, $account_name, username(), $founded, company_id(), $item_ide]);
        $data = DB::connection('sqlsrv3')->table("ItemLinkCoa")->where('CompanyID', '=', company_id())->orderby('ID', 'desc')->paginate(20);
        return request()->json(401, $data);
    }

    public
    function fetch_assetlist()
    {

        $data = DB::connection('sqlsrv3')->table("AssetsLinkCoa")->select('AssetId', 'Name')->orderby('ID', 'desc')->where('CompanyID', '=', company_id())->get();
        return request()->json(401, $data);
    }

    public
    function submit_assetslink(Request $request)
    {


        $selected = $request->get('asset_idname');
        $account_idname = $request->get('a_account_idname');

        $founded = long_date();

        $accountby = explode("_", $account_idname);
        $account_id = $accountby[0];
        $account_name = $accountby[1];
        for ($x = 0; $x < count($selected); $x++) {
            $item = explode("_", $selected[$x]);
            $item_id = $item[0];
            $item_name = $item[1];

            $result = DB::connection('sqlsrv3')->update('update AssetsLinkCoa set CoaID=?,CoaName=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and AssetId=?', [$account_id, $account_name, username(), $founded, company_id(), $item_id]);
        }
        $data = DB::connection('sqlsrv3')->table("AssetsLinkCoa")->where('CompanyID', '=', company_id())->orderby('ID', 'desc')->paginate(20);
        return request()->json(401, $data);
    }

    public
    function search_inv(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('ItemLinkCoa')->where('CompanyID', '=', company_id())->where('Name', 'like', '%' . $request->keyword1 . '%')->orderby('ID', 'desc')->paginate(20);
        return request()->json(200, $arr);
    }

    public
    function update_pv_disable(Request $request)
    {

        $pv_id = $request->get('pv_id');
        $sts = $request->get('sts');

        $update_date = long_date();
        $doc_date = short_date();

        $result = DB::connection('sqlsrv3')->update('update PaymentVoucher set Status=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and PaymentVoucherID=?', [$sts, username(), $update_date, company_id(), $pv_id]);
        if ($result) {

            $find_detail = DB::connection('sqlsrv3')->table("PaymentVoucher")->where('CompanyID', '=', company_id())->where('PaymentVoucherID', '=', $pv_id)->get();
            foreach ($find_detail as $find_detail1) {

            }
            $final_PoCode = $find_detail1->PVID;
            $vendor_name = $find_detail1->PaymentAgainst;
            $against_invoice = $find_detail1->InvoiceNumber;
            $narration = $find_detail1->Naration;

            $method_type = $find_detail1->MethodType;
            $chq_date = $find_detail1->ChqDate;
            $chq_number = $find_detail1->ChqNumber;
            $pay_against0 = $find_detail1->AccountID;
            $amount = $find_detail1->Amount;
            $method_typ0 = $find_detail1->MethodAccountID;

            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode, 'Payment To ' . $vendor_name . '/Invoice #' . $against_invoice . '/' . $narration, 'Payment Voucher', $update_date, username(), company_id()]);

            if ($doc) {
                $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode)->get();
                foreach ($find_doc_id as $find_doc_id1) {

                }


                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Payment To ' . $vendor_name . ' Through ' . $method_type . ' Chq Date:' . $chq_date . '/' . $chq_number . '/' . $narration . '/ Against ' . $against_invoice, company_id()]);

                $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                foreach ($find_tran_id as $find_tran_id1) {

                }
                $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $pay_against0, 'D', $amount, company_id()]);

                $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $method_typ0, 'C', $amount, company_id()]);
            }


            $message = "Status updated!";
            return request()->json(200, $message);
        }
    }


    public
    function submit_payment_term(Request $request)
    {

        $Emp_id = employee_id();

        $update_date = long_date();


        $payment_name = $request->get('payment_name');
        $payment_status = $request->get('payment_status');
        if ($payment_status == true) {
            $payment_status = 1;
        } else {
            $payment_status = 0;
        }
        $result = DB::connection('sqlsrv3')->insert('INSERT INTO PaymentTerm(CompanyID, PaymentTermName, Status, CreatedBy, CreatedOn) values (?,?,?,?,?)', [company_id(), $payment_name, $payment_status, username(), $update_date]);
        $req = DB::connection('sqlsrv3')->table("PaymentTerm")->select('PaymentTermId')->where('PaymentTermName', '=', $payment_name)->get();
        foreach ($req as $req1) {

        }
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Payment Term Created', 'New Payment Term | ' . $payment_name . ' | Payment Term ID | ' . $req1->PaymentTermId . ' | Status | ' . $payment_status . ' | has been added succesfully', $update_date]);
        $arr = "Submitted";
        return request()->json(200, $arr);
    }

    public
    function payment_terms()
    {

        $find_config = DB::connection('sqlsrv3')->table("PaymentTerm")->where('CompanyID', '=', company_id())->orderby('PaymentTermId', 'desc')->get();
        return request()->json(200, $find_config);
    }

    public
    function insert_issuanceledger(Request $request)
    {
        $issuance_id = $request->get('issuance_id');
        $issuance_code = $request->get('issuance_code');
        $project = $request->get('project');
        $company_id = Session::get('company_id');

        $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('DocumentNo', '=', $issuance_code)->orderBy('ID', 'DESC')->first();
        $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();
        $items = DB::connection('sqlsrv3')->table("IssuanceItem")->where("IssuanceId", '=', $issuance_id)->get();
        foreach ($items as $items1) {
            if ($items1->IssuanceQuantity != 0 || $items1->IssuanceQuantity != 0.000) {

                $find_acc_code = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('CoaID')->where('ItemId', '=', $items1->itemId)->get();
                foreach ($find_acc_code as $find_acc_code1) {

                }

                $find_inventory_amount = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC   [dbo].[Get_Item_AverageCostValue_ItemWise]
   @CompanyID = N'" . $company_id . "',
   @itemid = " . $items1->itemId . " ");
                if ($find_inventory_amount) {
                    foreach ($find_inventory_amount as $find_inventory_amount1) {

                    }
                    $t_iss_amount = $find_inventory_amount1->AVG * $items1->IssuanceQuantity;

                }

                DB::connection('sqlsrv3')->update('update  Ledger_Entries set Amount=? where AccountID=? and EntryType=? and TransactionID=?', [$t_iss_amount, $find_acc_code1->CoaID, 'C', $find_tran_id1->ID]);


                $find_acc_code9 = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->select('CoaID')->where('ProjectName', '=', $project)->get();
                foreach ($find_acc_code9 as $find_acc_code91) {

                }

                DB::connection('sqlsrv3')->update('update  Ledger_Entries set Amount=? where AccountID=? and EntryType=? and TransactionID=?', [$t_iss_amount, $find_acc_code91->CoaID, 'D', $find_tran_id1->ID]);

            }
        }
        return request()->json(200, 'success');
    }

    public
    function emp_name($emp_code)
    {


        $emp_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Register.EmployeeCode', '=', $emp_code)->select('Emp_Profile.Name')->get();
        foreach ($emp_name_arr as $emp_name_arr1) {
        }
        $emp_name = $emp_name_arr1->Name;

        return request()->json(200, $emp_name);
    }

    public
    function submit_pettycash(Request $request)
    {


        $emp_name = $request->get('emp_name');
        $emp_code = $request->get('emp_code');
        $amount = $request->get('pcash_amount');

        $find_emp = DB::connection('sqlsrv3')->table("PettyCashAccess")->where('CompanyID', '=', company_id())->where('EmployeeCode', '=', $emp_code)->exists();
        if ($find_emp) {
            $message = "Already Exists!";
            return request()->json(200, $message);
        } else {
            $find_dept = DB::connection('sqlsrv2')->table("Emp_Register")->select('Department')->where('CompanyID', '=', company_id())->where('EmployeeCode', '=', $emp_code)->get();
            foreach ($find_dept as $find_dept1) {

            }

            $update_date = long_date();

            DB::connection('sqlsrv3')->insert('INSERT INTO PettyCashAccess(CompanyID, Name, EmployeeCode, Limit, CreatedBy, CreatedOn,Department,Status) values (?,?,?,?,?,?,?,?)', [company_id(), $emp_name, $emp_code, $amount, username(), $update_date, $find_dept1->Department, 'Not Paid']);
            $message = "PettyCAsh Added";
            return request()->json(200, $message);
        }
    }

    public
    function pcash_access_detail()
    {

        $find_config = DB::connection('sqlsrv3')->table("PettyCashAccess")->where('CompanyID', '=', company_id())->orderby('ID', 'desc')->paginate(10);
        return request()->json(200, $find_config);
    }

    public
    function filter_pcash_access(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('PettyCashAccess')->orderby('ID', 'desc')->where('CompanyID', '=', company_id())->where('Name', 'like', '%' . $request->name . '%')->paginate(10);
        return request()->json(200, $arr);
    }

    public
    function submit_linkcoa_pcash(Request $request)
    {


        $updated_on = long_date();

        $id = $request->get('pcash_id');
        $account_id = $request->get('account_id');
        $account_i = explode("_", $account_id);


        $coa_id = $request->get('coa_id');
        $coa_i = explode("_", $coa_id);


        DB::connection('sqlsrv3')->update('update PettyCashAccess set AccountID=?, COAID=?,COAName=?, UpdatedBy=?, UpdatedOn=? where CompanyID=? and ID=?', [$account_i[0], $coa_i[0], $coa_i[1], username(), $updated_on, company_id(), $id]);

        $data = "PettyCAsh Linked";
        return request()->json(401, $data);
    }

    /*
  public function fetch_depart_access()
  {

    $find_config = DB::connection('sqlsrv3')->table("DeptAccess")->where('CompanyID', '=', company_id())->paginate(30);
    return request()->json(200, $find_config);
  }
  */
    public
    function fetch_useremail()
    {

        $find_config = DB::table("tb_users")->where('company_id', '=', company_id())->get();
        return request()->json(200, $find_config);
    }

    public
    function submit_userdepartment(Request $request)
    {

        $Emp_id = employee_id();

        $selected = $request->get('dept_name');
        $email_id = $request->get('email_id');

        $founded = long_date();
        $update_date = long_date();

        $countv = count($selected);
        if ($countv == 1) {
            $d0 = $selected[0];
            $d1 = '0';
            $d2 = '0';
            $d3 = '0';
            $d4 = '0';
            $d5 = '0';
        } elseif ($countv == 2) {
            $d0 = $selected[0];
            $d1 = $selected[1];
            $d2 = '0';
            $d3 = '0';
            $d4 = '0';
            $d5 = '0';
        } elseif ($countv == 3) {
            $d0 = $selected[0];
            $d1 = $selected[1];
            $d2 = $selected[2];
            $d3 = '0';
            $d4 = '0';
            $d5 = '0';
        } elseif ($countv == 4) {
            $d0 = $selected[0];
            $d1 = $selected[1];
            $d2 = $selected[2];
            $d3 = $selected[3];
            $d4 = '0';
            $d5 = '0';
        } elseif ($countv == 5) {
            $d0 = $selected[0];
            $d1 = $selected[1];
            $d2 = $selected[2];
            $d3 = $selected[3];
            $d4 = $selected[4];
            $d5 = '0';
        } elseif ($countv >= 6) {
            $d0 = $selected[0];
            $d1 = $selected[1];
            $d2 = $selected[2];
            $d3 = $selected[3];
            $d4 = $selected[4];
            $d5 = $selected[5];
        }

        $find_exists = DB::connection('sqlsrv3')->table("DeptAccess")->where('CompanyID', '=', company_id())->where('Email', '=', $email_id)->exists();
        if ($find_exists) {
            $result = DB::connection('sqlsrv3')->update('update DeptAccess set d1=?,d2=?,d3=?,d4=?,d5=?,d6=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and Email=?', [$d0, $d1, $d2, $d3, $d4, $d5, username(), $founded, company_id(), $email_id]);
        } else {
            $result = DB::connection('sqlsrv3')->insert('INSERT INTO DeptAccess(CompanyID, Email,d1,d2,d3,d4,d5,d6,UpdatedBy,UpdatedOn) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $email_id, $d0, $d1, $d2, $d3, $d4, $d5, username(), $founded]);
        }

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Department Access Updated', ' Departments Access for | ' . $email_id . ' | has been updated for Departments | ' . $d0 . ' | ' . $d1 . ' | ' . $d2 . ' | ' . $d3 . ' | ' . $d4 . ' | ' . $d5 . ' ', $update_date]);

        $find_config = DB::connection('sqlsrv3')->table("DeptAccess")->where('CompanyID', '=', company_id())->paginate(30);
        return request()->json(401, $find_config);
    }

    public
    function get_coa_projects()
    {

        $find_config = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->select('ProjectName')->where('CoaID', '!=', null)->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $find_config);
    }

    public function fetch_po_value($id, $vendor)
    {

        $ide = explode("_", $id);

        $vendor_name = explode("_", $vendor);

        if ($ide[0] == 'JV') {


            $find_poid = DB::connection('sqlsrv3')->table("JournalVoucher")->select('JournalVoucherID')->where('JVID', $id)->where('CompanyID', '=', company_id())->get();
            foreach ($find_poid as $find_poid1) {

            }

            $find_balance = DB::connection('sqlsrv3')->table("JournalVoucherDetail")->where('JournalVoucherID', $find_poid1->JournalVoucherID)->where('AccountID', $vendor_name[0])->where('credit_amount', '!=', 0)->get();
            foreach ($find_balance as $find_balance1) {

            }
            $total = $find_balance1->credit_amount;
            $firstEntryexists = DB::connection('sqlsrv3')
                ->table("PaymentVoucherDetail")
                ->where('AgainstJV', $id)
                ->where('CompanyID', '=', company_id())
                ->orderBy('DetailID', 'desc') // Use asc to get the first entry
                ->exists();
            if ($firstEntryexists) {
                $firstEntry = DB::connection('sqlsrv3')
                    ->table("PaymentVoucherDetail")
                    ->where('AgainstJV', $id)
                    ->where('CompanyID', '=', company_id())
                    ->orderBy('DetailID', 'desc') // Use asc to get the first entry
                    ->first();
                $sumOfAmount = $firstEntry ? $firstEntry->Remaining : 0;
                $remaining = $sumOfAmount;
            } else {
                $remaining = $total;
            }

            $myJSON = array(
                'total_value' => $total,
                'remaining_value' => $remaining,
            );
            return request()->json(200, $myJSON);
        } else if ($ide[0] == 'PO') {

            $find_ve_exists = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('PurchaseOrderID')->where('PoCode', $id)->where('CompanyID', '=', company_id())->where('vendorName', $vendor_name[1])->exists();
            if (!$find_ve_exists) {
                $message = "notexists";
                return request()->json(200, $message);
            }
            {
                $find_poid = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('PurchaseOrderID')->where('PoCode', $id)->where('CompanyID', '=', company_id())->get();
                foreach ($find_poid as $find_poid1) {

                }
                $find_inv_exists = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('POID', '=', $find_poid1->PurchaseOrderID)->where('CompanyID', '=', company_id())->exists();
                if ($find_inv_exists) {
                    $find_inv_sum = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('POID', $find_poid1->PurchaseOrderID)->where('CompanyID', '=', company_id())->sum('TotalAmount');
                    $find_inv_remaining = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('AgainstPO', $id)->where('CompanyID', '=', company_id())->whereNotNull("PID")->sum('Amount');
                    $remaining = $find_inv_sum - $find_inv_remaining;
                    $myJSON = array(
                        'total_value' => $find_inv_sum,
                        'remaining_value' => $remaining,
                    );
                    return request()->json(200, $myJSON);
                } else {
                    $find_balance = DB::connection('sqlsrv3')->table("PurchaseOrder")->where('PoCode', '=', $id)->where('CompanyID', '=', company_id())->get();
                    foreach ($find_balance as $find_balance1) {

                    }
                    $total = $find_balance1->TotalAmount;
                    $firstEntryexists = DB::connection('sqlsrv3')
                        ->table("PaymentVoucherDetail")
                        ->where('AgainstPO', $id)
                        ->where('CompanyID', '=', company_id())
                        ->orderBy('DetailID', 'desc') // Use asc to get the first entry
                        ->exists();
                    if ($firstEntryexists) {
                        $firstEntry = DB::connection('sqlsrv3')
                            ->table("PaymentVoucherDetail")
                            ->where('AgainstPO', $id)
                            ->where('CompanyID', '=', company_id())
                            ->orderBy('DetailID', 'desc') // Use asc to get the first entry
                            ->first();
                        $sumOfAmount = $firstEntry ? $firstEntry->Remaining : 0;
                        $remaining = $sumOfAmount;
                    } else {
                        $remaining = $total;
                    }

                    $myJSON = array(
                        'total_value' => $total,
                        'remaining_value' => $remaining,
                    );
                    return request()->json(200, $myJSON);
                }
            }
        } elseif ($ide[0] == 'INV') {
            $find_v = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('FormID', $id)->where('CompanyID', '=', company_id())->get();
            foreach ($find_v as $find_v1) {

            }
            $find_ve_exists = DB::connection('sqlsrv3')->table("PurchaseOrder")->where('PurchaseOrderID', $find_v1->POID)->where('CompanyID', '=', company_id())->where('vendorName', $vendor_name[1])->exists();
            if (!$find_ve_exists) {
                $message = "notexists";
                return request()->json(200, $message);
            } else {
                $find_balance = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('FormID', $id)->where('CompanyID', '=', company_id())->get();
                foreach ($find_balance as $find_balance1) {

                }
                $find_po_c = DB::connection('sqlsrv3')->table("PurchaseOrder")->where('PurchaseOrderID', $find_balance1->POID)->where('CompanyID', '=', company_id())->get();
                foreach ($find_po_c as $find_po_c1) {

                }

                $find_inv_remaining = DB::connection('sqlsrv3')->select("select sum(Amount) as Amount From PaymentVoucherDetail where CompanyID = '" . company_id() . "' and AgainstPO = '" . $find_po_c1->PoCode . "' and ( AgainstINV='" . $id . "' OR AgainstINV='') and PID is not Null");
                foreach ($find_inv_remaining as $find_inv_remaining1) {

                }
                $find_inv_remainingcheck = DB::connection('sqlsrv3')->select("select sum(Amount) as Amount From PaymentVoucherDetail where CompanyID = '" . company_id() . "' and AgainstPO = '" . $find_po_c1->PoCode . "' and ( AgainstINV='" . $id . "' OR AgainstINV='') and PID is Null");
                foreach ($find_inv_remainingcheck as $find_inv_remainingcheck1) {

                }
                if (is_null($find_inv_remaining1->Amount) && $find_inv_remainingcheck1->Amount > 0) {
                    $remaining = $find_balance1->TotalAmount - $find_inv_remainingcheck1->Amount;
                } else {
                    $remaining = $find_balance1->TotalAmount - ($find_inv_remaining1->Amount - $find_inv_remainingcheck1->Amount);
                }


                $total = $find_balance1->TotalAmount;

                $myJSON = array(
                    'total_value' => $total,
                    'remaining_value' => $remaining,
                );

                return request()->json(200, $myJSON);
            }
        }
    }

    public
    function fetch_po_details($id)
    {

        $find_payment_detail = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', company_id())->where('AgainstPO', $id)->orWhere('AgainstINV', $id)->orWhere('AgainstJV', $id)->get();
        return request()->json(200, $find_payment_detail);
    }

    public
    function fetch_po_details1($id)
    {
        $find_payment_detail = DB::connection('sqlsrv3')
            ->table("PaymentVoucherDetail")
            ->where('CompanyID', '=', company_id())
            ->where('AgainstPO', $id)
            ->whereNotNull("PID")
            ->sum("Amount");
        $find_payment_detail1 = DB::connection('sqlsrv3')
            ->table("PaymentVoucherDetail")
            ->where('CompanyID', '=', company_id())
            ->where('AgainstPO', $id)
            ->whereNull('PID')
            ->sum("Amount");

        return response()->json([
            'Amount' => $find_payment_detail - $find_payment_detail1,
            'Remaining' => $find_payment_detail - $find_payment_detail1
        ], 200);


    }

    public
    function fetch_rcvd_details($id)
    {

        $find_payment_detail = DB::connection('sqlsrv3')->table("ReceivedVoucherDetail")->where('CompanyID', '=', company_id())->where('AgainstPO', $id)->get();
        return request()->json(200, $find_payment_detail);
    }

    public
    function accounts_category_products($id)
    {

        $find_payment_detail = DB::connection('sqlsrv3')->table("ItemCategory")->where('CompanyID', '=', company_id())->where('ID', $id)->get();
        return request()->json(200, $find_payment_detail);
    }

    public
    function insert_pettycash(Request $request)
    {

        $Emp_id = employee_id();

        $session = ac_c_session();


        $vendor_name = $request->get('vendor_name');
        $bill_no = $request->get('bill_no');
        $amount = $request->get('amount');
        $item_detail = $request->get('item_detail');
        $date = $request->get('date');
        $dept_name = $request->get('dept_name');
        $total = $request->get('total');


        $find_exists = DB::connection('sqlsrv3')->table("PettyCashAccess")->where('CompanyID', '=', company_id())->where('Department', '=', $dept_name)->exists();
        if (!$find_exists) {
            $find_config = "Access not allowed";
            //return request()->json(200,$find_config);
        }

        $vendor_name1 = explode("|", $vendor_name);
        for ($x = 1; $x < count($vendor_name1); $x++) {
            $vendor_nam = explode("|", $vendor_name);
            $bill_n = explode("|", $bill_no);
            $amoun = explode("|", $amount);
            $item_detai = explode("|", $item_detail);
            if ($vendor_nam[$x] == '' || $bill_n[$x] == '' || $amoun[$x] == '' || $item_detai[$x] == '') {
                $find_config = "Empty field";
                return request()->json(200, $find_config);
            }
            if ($amoun[$x] < 0) {
                $find_config = 'Amount Cannot be Negative';
                return request()->json(200, $find_config);
            }
        }
        $date_pref = $this->shiftformat();
        $req_prefix = 'PC' . '_' . $date_pref;
        $find_rid9 = DB::connection('sqlsrv3')->table("PettyCash")->where('CompanyID', '=', company_id())->exists();
        if ($find_rid9) {
            $find_rid = DB::connection('sqlsrv3')->table("PettyCash")->select('PettyID')->where('CompanyID', '=', company_id())->get();
            foreach ($find_rid as $find_rid1) {

            }
            $pre_id = explode("-", $find_rid1->PettyID);
            $rid = $pre_id[1] + 1;
        } else {
            $rid = 1;
        }
        $final_rid = $req_prefix . '-' . $rid;
        $status = "Pending";
        $status1 = "Not Verified";

        $update_date = long_date();
        $result = DB::connection('sqlsrv3')->insert('INSERT INTO PettyCash(CompanyID,PettyID,PettyDate,DeptName,TotalAmount,Status1,Status2,CreatedBy,CreatedOn,Session) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $final_rid, $date, $dept_name, $total, $status, $status1, username(), $update_date, $session]);
        if ($result) {
            $find_reqid = DB::connection('sqlsrv3')->table("PettyCash")->select('ID')->where('CompanyID', '=', company_id())->get();
            foreach ($find_reqid as $find_reqid1) {
            }
            $vendor_name1 = explode("|", $vendor_name);
            for ($x = 1; $x < count($vendor_name1); $x++) {
                $vendor_nam = explode("|", $vendor_name);
                $bill_n = explode("|", $bill_no);
                $amoun = explode("|", $amount);
                $item_detai = explode("|", $item_detail);

                $result = DB::connection('sqlsrv3')->insert('INSERT INTO PettyCashDetail(PID,VendorName,BillNumber,ItemDetail,Amount) values (?,?,?,?,?)', [$find_reqid1->ID, $vendor_nam[$x], $bill_n[$x], $item_detai[$x], $amoun[$x]]);
            }
        }
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Petty Cash Created', 'Petty Cash | having Petty ID | ' . $final_rid . ' | for Department/Company Name | ' . $dept_name . ' | Against Total Amount | ' . $total . ' | has been created', $update_date]);

        $find_config = "submitted";
        return request()->json(200, $find_config);
    }

    public
    function edit_pettycash(Request $request)
    {
        $session = ac_c_session();
        $vendor_name = $request->get('vendor_name');
        $bill_no = $request->get('bill_no');
        $amount = $request->get('amount');
        $item_detail = $request->get('item_detail');
        $id = $request->get('id');
        $date = $request->get('date');
        $dept_name = $request->get('dept_name');
        $total = $request->get('total');

        $vendor_name1 = explode("|", $vendor_name);
        for ($x = 1; $x < count($vendor_name1); $x++) {
            $vendor_nam = explode("|", $vendor_name);
            $bill_n = explode("|", $bill_no);
            $amoun = explode("|", $amount);
            $item_detai = explode("|", $item_detail);
            if ($vendor_nam[$x] == '' || $bill_n[$x] == '' || $amoun[$x] == '' || $item_detai[$x] == '') {
                $find_config = "Empty field";
                return request()->json(200, $find_config);
            }
        }
        $check_security = DB::connection('sqlsrv3')->table("PettyCash")->where('CompanyID', '=', company_id())->where("ID", "=", $id)->exists();
        if ($check_security) {
            DB::connection("sqlsrv3")->table("PettyCashDetail")->where("PID", "=", $id)->delete();

            $update_date = long_date();
            $result = DB::connection('sqlsrv3')->update('update PettyCash set TotalAmount=? where ID=? and CompanyID=?', [$total, $id, company_id()]);
            if ($result) {

                $vendor_name1 = explode("|", $vendor_name);
                for ($x = 1; $x < count($vendor_name1); $x++) {
                    $vendor_nam = explode("|", $vendor_name);
                    $bill_n = explode("|", $bill_no);
                    $amoun = explode("|", $amount);
                    $item_detai = explode("|", $item_detail);

                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO PettyCashDetail(PID,VendorName,BillNumber,ItemDetail,Amount) values (?,?,?,?,?)', [$id, $vendor_nam[$x], $bill_n[$x], $item_detai[$x], $amoun[$x]]);
                }
            }
        }
        $req = DB::connection('sqlsrv3')->table("PettyCash")->select('PettyCash.*')->where('ID', '=', $id)->get();
        foreach ($req as $req1) {
        }

        insertLog('Petty Cash Updated', 'Petty Cash For | ' . $req1->PettyID . ' | Against Vendor | ' . $vendor_name . ' | For Department | ' . $dept_name . ' | Total Amount | ' . $total . ' |  has been updated ');

        $find_config = "submitted";
        return request()->json(200, $find_config);
    }

    public
    function searchpetty_cash($startdate, $enddate, $keyword)
    {
        if ($keyword == 'All') {
            $keyword = '';
        }
        $dept = emp_department();
        if ($dept == 'Accounts' || $dept == 'Software Development') {
            $find_config = DB::connection('sqlsrv3')->table("PettyCash")
                ->where('CompanyID', '=', company_id())
                ->where('PettyDate', '>=', $startdate)
                ->where('PettyDate', '<=', $enddate)
                ->where(function ($query) use ($keyword) {
                    $query->where('DeptName', 'like', '%' . $keyword . '%')
                        ->orWhere('PettyID', 'like', '%' . $keyword . '%');
                })
                ->orderby('PettyID', 'desc')->paginate(10);
            return request()->json(200, $find_config);
        } else {

            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {
                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;
                $find_config = DB::connection('sqlsrv3')->table("PettyCash")->where('CompanyID', company_id())->where('PettyDate', '>=', $startdate)->where('PettyDate', '<=', $enddate)->orderby('PettyID', 'desc')
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DeptName', 'like', $d1 . '%')
                            ->orWhere('DeptName', 'like', $d2 . '%')
                            ->orWhere('DeptName', 'like', $d3 . '%')
                            ->orWhere('DeptName', 'like', $d4 . '%')
                            ->orWhere('DeptName', 'like', $d5 . '%')
                            ->orWhere('DeptName', 'like', $d6 . '%');
                    })
                    ->where(function ($query1) use ($keyword) {
                        $query1->where('DeptName', 'like', '%' . $keyword . '%')
                            ->orWhere('PettyID', 'like', '%' . $keyword . '%');
                    })
                    ->orderby('ID', 'desc')->paginate(20);
                return request()->json(200, $find_config);
            } else {
                $find_config = DB::connection('sqlsrv3')->table("PettyCash")->where('CompanyID', '=', company_id())->where('DeptName', '=', $dept)->where('PettyDate', '>=', $startdate)->where('PettyDate', '<=', $enddate)->orderby('PettyID', 'desc')->orderby('ID', 'desc')->paginate(20);
                return request()->json(200, $find_config);
            }
        }
    }

    public
    function petty_cash_details()
    {
        $dept = emp_department();
        $session = ac_c_session();
        if ($dept == 'Accounts' || $dept == 'Software Development') {
            $arr = DB::connection("sqlsrv3")->table("PettyCash")->where("CompanyID", '=', company_id())->orderby("ID", 'desc')->paginate(10);
            return request()->json(200, $arr);
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {
                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;
                $find_config = DB::connection('sqlsrv3')->table("PettyCash")->where('CompanyID', company_id())->where('Session', $session)->where('DeptName', 'like', $d1 . '%')->orWhere('DeptName', 'like', $d2 . '%')->orWhere('DeptName', 'like', $d3 . '%')->orWhere('DeptName', 'like', $d4 . '%')->orWhere('DeptName', 'like', $d5 . '%')->orWhere('DeptName', 'like', $d6 . '%')->orderby('ID', 'desc')->paginate(20);
                return request()->json(200, $find_config);
            } else {
                $find_config = DB::connection('sqlsrv3')->table("PettyCash")->where('CompanyID', '=', company_id())->where('DeptName', '=', $dept)->where('Session', $session)->orderby('ID', 'desc')->paginate(20);
                return request()->json(200, $find_config);
            }
        }
    }

    public
    function pettyitem_details($id)
    {

        $arr = DB::connection("sqlsrv3")->table("PettyCash")->where("CompanyID", '=', company_id())->where("ID", '=', $id)->get();
        return request()->json(200, $arr);
    }

    public
    function pettyitem_details1($id)
    {

        $arr = DB::connection("sqlsrv3")->table("PettyCashDetail")->where("PID", '=', $id)->get();
        return request()->json(200, $arr);
    }

    public
    function update_pettycash_status($id, $status)
    {

        $update_date = long_date();
        $doc_date = short_date();


        $Emp_id = employee_id();

        $result = DB::connection('sqlsrv3')->update('update PettyCash set Status1=? where CompanyID=? and ID=?', [$status, company_id(), $id]);
        if ($result) {
            $req = DB::connection('sqlsrv3')->table("PettyCash")->select('PettyCash.*')->where('ID', '=', $id)->get();
            foreach ($req as $req1) {

            }
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Petty Cash Status Updated', 'Petty Cash For | ' . $req1->PettyID . ' | Status Updated to | ' . $status . ' ', $update_date]);

            $arr = 'Status Update';
            return request()->json(200, $arr);
        }
    }

    public
    function update_pettycash_status1($id, $status)
    {

        $arr = DB::connection("sqlsrv3")->table("PettyCash")->where("ID", '=', $id)->get();
        foreach ($arr as $arr1) {
        }
        $amount0 = $arr1->TotalAmount;
        if ($amount0 < 0) {
            $find_config = 'Amount Cannot be Negative';
            return request()->json(200, $find_config);
        }
        $result = DB::connection('sqlsrv3')->update('update PettyCash set Status2=? where CompanyID=? and ID=?', [$status, company_id(), $id]);
        if ($result) {
            $arr = DB::connection("sqlsrv3")->table("PettyCash")->where("ID", '=', $id)->get();
            foreach ($arr as $arr1) {
            }
            DB::connection('sqlsrv3')->update('update PettyCash set Remaining=? where CompanyID=? and ID=?', [$arr1->TotalAmount, company_id(), $id]);

            $update_date = long_date();
            $doc_date = short_date();

            $final_PoCode0 = $arr1->PettyID;
            $amount0 = $arr1->TotalAmount;
            $dept = $arr1->DeptName;
            $find_acc_head_check = DB::connection("sqlsrv3")->table("PettyCashAccess")->where("Department", '=', $dept)->exists();
            if ($find_acc_head_check) {
                $find_acc_head = DB::connection("sqlsrv3")->table("PettyCashAccess")->where("Department", '=', $dept)->get();
                foreach ($find_acc_head as $find_acc_head1) {
                }
                $AccountID = $find_acc_head1->AccountID;
                $COAID = $find_acc_head1->COAID;
                $limit = $find_acc_head1->Limit;
            } else {
                $find_config = 'Department has not petty cash access';
                return request()->json(200, $find_config);
            }

            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode0, $dept . ' Used PettyCash Expense Against Petty#' . $final_PoCode0, 'Petty Cash', $update_date, username(), company_id()]);
            if ($doc) {
                $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode0)->get();
                foreach ($find_doc_id as $find_doc_id1) {

                }

                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, $dept . ' Used PettyCash Expense Against Petty#' . $final_PoCode0, company_id()]);
                $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                foreach ($find_tran_id as $find_tran_id1) {

                }
                $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $COAID, 'D', $amount0, company_id()]);

                $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $AccountID, 'C', $amount0, company_id()]);
            }
            $result = DB::connection('sqlsrv3')->update('update PettyCashAccess set Status=? where CompanyID=? and AccountID=? and Department=?', ['Not Paid', company_id(), $AccountID, $dept]);

            $find_config = 'Status Update';
            return request()->json(200, $find_config);
        }
    }

    public
    function submit_paid_cash($id, $paid_amount)
    {


        $result = DB::connection('sqlsrv3')->update('update PettyCashAccess set Status=?,UpdatedAmount=? where CompanyID=? and ID=?', ['Paid', $paid_amount, company_id(), $id]);

        if ($result) {

            $find_acc_head = DB::connection("sqlsrv3")->table("PettyCashAccess")->where("ID", '=', $id)->get();
            foreach ($find_acc_head as $find_acc_head1) {
            }
            $COAID = $find_acc_head1->COAID;
            $dept = $find_acc_head1->Department;
            $AccountID = $find_acc_head1->AccountID;
            $limit = $find_acc_head1->Limit;


            $update_date = long_date();
            $doc_date = short_date();


            $doc1 = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, 'ADV PC', 'Paid Pettycash to ' . $dept, 'Petty Cash', $update_date, username(), company_id()]);

            if ($doc1) {
                $find_doc_id2 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', 'ADV PC')->get();
                foreach ($find_doc_id2 as $find_doc_id21) {

                }
                $transaction1 = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id21->ID, $doc_date, 'Paid Pettycash to ' . $dept, company_id()]);

                $find_tran_id2 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id21->ID)->get();
                foreach ($find_tran_id2 as $find_tran_id21) {

                }
                $ledger_entry3 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id21->ID, $AccountID, 'D', $paid_amount, company_id()]);
                $cash_hand = '101001001001';
                $ledger_entry4 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id21->ID, $cash_hand, 'C', $paid_amount, company_id()]);
            }
            $arr = 'Status Update';
            return request()->json(200, $arr);
        }
    }

    public
    function asset_assignment_list()
    {
        $data = DB::connection('sqlsrv3')->table('Assets')->join('ItemList', 'Assets.AssetID', '=', 'ItemList.ID')->select('Assets.AssetsUniqueID', 'Assets.Reference', 'Assets.Dated', 'Assets.Quantity', 'ItemList.ItemCode', 'ItemList.Name', 'Assets.AssignedTo', 'Assets.EmployeeCode', 'Assets.Project', 'Assets.Location')->where('Assets.AssetType', '=', 2)->get();
        return request()->json(401, $data);
    }

    public
    function get_session_date()
    {


        $arr = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        return request()->json(200, $arr);
    }

    public
    function get_petty_access($id)
    {
        $find_access = DB::connection('sqlsrv3')->table("PettyCashAccess")->where("ID", "=", $id)->get();
        foreach ($find_access as $find_access1) {

        }
        $limit = $find_access1->Limit;
        $dept = $find_access1->Department;
        $AccountId = $find_access1->AccountID;


        $created_on = short_date();
        $result9 = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
    @Datefrom = N'2000-01-01',
    @DateTo = N'" . $created_on . "',
    @id = " . $AccountId . ",
    @compid = N'" . company_id() . "'  ");


        if ($result9) {

            $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
    @Datefrom = N'2000-01-01',
    @DateTo = N'" . $created_on . "',
    @id = " . $AccountId . ",
    @compid = N'" . company_id() . "'  ");

            foreach ($result as $result1) {

            }

            $am = $result1->am;
            $remaining_c = $limit + $am;
        } else {
            $am = $limit;
            $remaining_c = $limit;
        }

        $myJSON = array(
            'limit' => $limit,
            'dept' => $dept,
            'accountid' => $AccountId,
            'remaining' => $remaining_c,
        );
        return request()->json(200, $myJSON);
    }

    public
    function sum_ledger($ledger_name, $first_date, $last_date)
    {

        $pre_id = explode("_", $ledger_name);
        $result3 = DB::connection('sqlsrv3')->select("EXEC   [dbo].[dashboard_TotalCredit]
    @Datefrom = N'" . $first_date . "',
    @DateTo = N'" . $last_date . "',
    @compid = N'" . company_id() . "',
    @id = '" . $pre_id[0] . "'
    ");
        foreach ($result3 as $result31) {

        }
        $acc_credit = $result31->TotalCredit;
        $acc_debit = $result31->Totaldebit;
        $myJSON = array(
            'credit' => $acc_credit,
            'debit' => $acc_debit,
        );
        return request()->json(200, $myJSON);
    }

    public
    function get_pmterm()
    {

        $arr = DB::connection('sqlsrv3')->table('PaymentTerm')->select('PaymentTermName')->where('CompanyID', '=', company_id())->where('Status', '=', '1')->get();
        return request()->json(200, $arr);
    }


    public
    function fetch_typesdata()
    {

        $data = DB::connection('sqlsrv3')->table("TypesLinkCoa")->orderby('ID', 'desc')->paginate(30);
        return request()->json(401, $data);
    }

    public
    function update_typename($ide, $account_idname_sep)
    {

        $update_date = long_date();

        $account = explode("_", $account_idname_sep);

        $result = DB::connection('sqlsrv3')->update('update TypesLinkCoa set CoaID=?,CoaName=?,UpdatedBy=?,UpdatedOn=? where ID=?', [$account[0], $account[1], username(), $update_date, $ide]);
        if ($result) {
            $data = "successfully";
            return request()->json(401, $data);
        }
    }

    public
    function pending_booking_detail()
    {
        $data = DB::connection('sqlsrv3')->table("TempBookingTable")->where('Supervision', '=', null)->orderby('BID', 'desc')->get();
        return request()->json(401, $data);
    }

    public
    function all__mis_detail($date, $type, $user)
    {

        if ($user == 'All') {
            if ($type == 'Both') {

                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->where('DateTime', '=', $date)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else if ($type == 'Cash') {
                $type == 'Cash';
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->where('PaymentType', '=', 'Cash')->where('DateTime', '=', $date)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else {
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->where('PaymentType', '!=', 'Cash')->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            }
        } else {
            if ($type == 'Both') {

                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->where('DateTime', '=', $date)->where('Userid', '=', $user)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else if ($type == 'Cash') {
                $type == 'Cash';
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->where('PaymentType', '=', 'Cash')->where('DateTime', '=', $date)->where('Userid', '=', $user)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else {
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->where('PaymentType', '!=', 'Cash')->where('Userid', '=', $user)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            }
        }
    }

    public
    function search_r_byname($date, $type, $user)
    {
        if ($user == 'All') {
            if ($type == 'Both') {

                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else if ($type == 'Cash') {
                $type == 'Cash';
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->where('PaymentType', '=', 'Cash')->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else {
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->where('PaymentType', '!=', 'Cash')->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            }
        } else {
            if ($type == 'Both') {

                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->where('Userid', '=', $user)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else if ($type == 'Cash') {
                $type == 'Cash';
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('PaymentType', '=', 'Cash')->where('DateTime', '=', $date)->where('Userid', '=', $user)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else {
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '=', $date)->where('PaymentType', '!=', 'Cash')->where('Userid', '=', $user)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            }
        }
    }

    public
    function get_counter_sum1($date, $type, $id)
    {
        if ($id == 'All') {
            $id = '';
        }
        if ($type == 'Both') {
            $type = '';
        }


        $total = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('Userid', 'like', '%' . $id . '%')->where('DateTime', '=', $date)->sum('Amount');
        $cash_amount = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('Userid', 'like', '%' . $id . '%')->where('PaymentType', '=', 'Cash')->where('DateTime', '=', $date)->sum('Amount');
        $chq_amount = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('Userid', 'like', '%' . $id . '%')->where('PaymentType', '!=', 'Cash')->where('DateTime', '=', $date)->sum('Amount');
        $myJSON = array(
            'total' => $total,
            'cash' => $cash_amount,
            'chq' => $chq_amount,
        );
        return request()->json(200, $myJSON);
    }


    public
    function search_r_byname_cash($user)
    {
        if ($user == 'All') {
            $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Status', '=', null)->orderby('Id', 'desc')->get();
            return request()->json(200, $arr);
        } else {
            $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $user)->where('Status', '=', null)->orderby('Id', 'desc')->get();
            return request()->json(200, $arr);
        }
    }

    public
    function get_counter_sum($user, $dated, $category, $type)
    {
        if ($type == 'All') {
            $type = '';
        }

        if ($user == 'All') {
            if ($category == 'Both') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '=', $dated)->where('Type', 'like', '%' . $type . '%')->where('Status', '=', null)->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            } elseif ($category == 'SAM') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '=', $dated)->where('Type', 'like', '%' . $type . '%')->where('Status', '=', null)->where('Text', '=', 'SAM')->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            } elseif ($category == 'SAGardens') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '=', $dated)->where('Type', 'like', '%' . $type . '%')->where('Status', '=', null)->where('Text', '!=', 'SAM')->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            }
        } else {
            if ($category == 'Both') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $user)->where('Type', 'like', '%' . $type . '%')->where('DateTime', '=', $dated)->where('Status', '=', null)->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            } elseif ($category == 'SAM') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $user)->where('Type', 'like', '%' . $type . '%')->where('DateTime', '=', $dated)->where('Text', '=', 'SAM')->where('Status', '=', null)->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            } elseif ($category == 'SAGardens') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $user)->where('Type', 'like', '%' . $type . '%')->where('DateTime', '=', $dated)->where('Text', '!=', 'SAM')->where('Status', '=', null)->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            }
        }
    }

    public
    function search_booking_name($id)
    {

        $arr = DB::connection('sqlsrv3')->table('TempBookingTable')->where('Supervision', '=', null)->where('OwnerName', 'like', '%' . $id . '%')->orderby('BID', 'desc')->get();
        return request()->json(200, $arr);
    }

    public
    function get_cashcounter_user()
    {
        $arr = DB::connection('sqlsrv3')->table('UnitCashCounter')->orderby('Id', 'desc')->get();
        return request()->json(200, $arr);
    }

    public
    function submit_unitbooking(Request $request)
    {

        $id = $request->get('id');
        $update_date = long_date();

        $check = $request->get('added');
        $id1 = explode("|", $id);
        $t = 'TRUE';
        for ($x = 1; $x < count($id1); $x++) {
            $chec = explode("|", $check);

            if ($chec[$x] == 'false') {
                $t = 'FALSE';
            } else {
                $t = 'TRUE';
            }

            if ($t == 'TRUE') {
                for ($x = 1; $x < count($id1); $x++) {
                    $id2 = explode("|", $id);
                    $chec = explode("|", $check);
                    if ($chec[$x] == 'true') {
                        $save_ledger = DB::connection('sqlsrv3')->table('TempBookingTable')->where('BID', '=', $id2[$x])->get();
                        foreach ($save_ledger as $save_ledger1) {

                            if ($save_ledger1->BookingAmount < 0) {
                                $find_config = 'Amount Cannot be Negative';
                                return request()->json(200, $find_config);
                            }
                            $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID', '=', $save_ledger1->BID)->where('CompanyID', '=', company_id())->exists();
                            if (!$find_vendor_id) {
                                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$save_ledger1->Dated, $save_ledger1->file_plot_number, $save_ledger1->Type . ' ' . $save_ledger1->UnitModule . ' Against File Plot No:' . $save_ledger1->file_plot_number . '/Owner Name: ' . $save_ledger1->OwnerName, $save_ledger1->Type, $update_date, username(), company_id()]);
                                if ($doc) {
                                    $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->file_plot_number)->get();
                                    foreach ($find_doc_id as $find_doc_id1) {

                                    }
                                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $save_ledger1->Dated, $save_ledger1->Type . ' ' . $save_ledger1->UnitModule . ' Against File Plot No:' . $save_ledger1->file_plot_number . '/Owner Name: ' . $save_ledger1->OwnerName, company_id()]);
                                    $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                                    foreach ($find_tran_id as $find_tran_id1) {

                                    }
                                    if ($save_ledger1->Block_Name == 'SA Premium Homes' || $save_ledger1->Block_Name == 'Premium Homes' || $save_ledger1->Block_Name == 'Ayaan Center' || $save_ledger1->Block_Name == 'Faisal Height') {
                                        $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block_Name . ' Receivables')->get();
                                        foreach ($find_acc_code as $find_acc_code1) {

                                        }
                                    } else if ($save_ledger1->Block_Name == 'Main G.T Road') {
                                        $blo = 'Main GT road';
                                        $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $blo . ' Block ' . $save_ledger1->Type . ' Receivables')->get();
                                        foreach ($find_acc_code as $find_acc_code1) {

                                        }
                                    } else {
                                        $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block_Name . ' Block ' . $save_ledger1->Type . ' Receivables')->get();
                                        foreach ($find_acc_code as $find_acc_code1) {

                                        }
                                    }
                                    if ($save_ledger1->Block_Name == 'SA Premium Homes' || $save_ledger1->Block_Name == 'Premium Homes' || $save_ledger1->Block_Name == 'Ayaan Center' || $save_ledger1->Block_Name == 'Faisal Height') {
                                        $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block_Name . ' Sales')->get();
                                        foreach ($find_acc_code9 as $find_acc_code91) {

                                        }
                                    } else if ($save_ledger1->Block_Name == 'Main G.T Road') {
                                        $blo = 'Main GT road';
                                        $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $blo . ' Block ' . $save_ledger1->Type . ' Sales')->get();
                                        foreach ($find_acc_code9 as $find_acc_code91) {

                                        }
                                    } else {
                                        $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block_Name . ' Block ' . $save_ledger1->Type . ' Sales')->get();
                                        foreach ($find_acc_code9 as $find_acc_code91) {

                                        }
                                    }
                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'D', $save_ledger1->BookingAmount, $save_ledger1->BID, company_id()]);
                                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->ID, 'C', $save_ledger1->BookingAmount, $save_ledger1->BID, company_id()]);
                                } //doc
                            }
                        } //for
                        DB::connection('sqlsrv3')->update('update TempBookingTable set Supervision=? where BID=?', [username(), $save_ledger1->BID]);
                    }
                }
                $message = "submitted";
                return request()->json(401, $message);
            } else {
                $t = "false";
            }
        }
        if ($t == 'false') {
            $message = "Select Data";
            return request()->json(401, $message);
        }
    }

    public
    function get_units_chq_detail()
    {
        $arr2 = DB::connection('sqlsrv3')->table('UnitsChqDetail')->where("Status", '!=', 'Clearanced')->orWhere("Status", '=', null)->orderby("ChqID", "desc")->get();
        return request()->json(200, $arr2);
    }

    public
    function ledger_report_balance1($start_date, $end_date, $vendor_name)
    {

        $data = explode("_", $vendor_name);
        $vid = $data[0];
        $vname = $data[1];

        $check = DB::connection('sqlsrv3')->table('TempBank')->where('VendorId', '=', $vid)->where("VendorName", 'like', '%' . $vname . '%')->where('Status', '=', 'Chq Paid')->where('ChqDate', '>=', $start_date)->where('ChqDate', '<=', $end_date)->exists();

        if ($check) {
            $arr = DB::connection('sqlsrv3')->table('TempBank')->where('VendorId', '=', $vid)->where("VendorName", 'like', '%' . $vname . '%')->where('Status', '=', 'Chq Paid')->where('ChqDate', '>=', $start_date)->where('ChqDate', '<=', $end_date)->get();
            return request()->json(200, $arr);
        }
    }

    public
    function units_check_detail($id)
    {


        $find_config = DB::connection('sqlsrv3')->table("UnitsChqDetail")->where('ChqID', '=', $id)->get();
        return request()->json(200, $find_config);
    }


    public
    function submit_deposit_bankdetails(Request $request)
    {
        $chqId = $request->get("chqId");
        $id = $request->get("id");


        $Deposit_Bank = $request->get('Deposit_Bank');
        $Deposit_Ban = explode("_", $Deposit_Bank);

        $Time = short_date();
        $update_date = long_date();
        $status = 'Deposited';
        $result = DB::connection('sqlsrv3')->update("UPDATE UnitsChqDetail SET  DepositedAccount=?,DepositedID=?,DepositDate=?,Status=?,UpdatedBy=?,ProceedDate=? WHERE ChqID=?", [$Deposit_Ban[1], $Deposit_Ban[0], $Time, $status, username(), $update_date, $chqId]);
        if ($result) {
            $find_chq = DB::connection('sqlsrv3')->table("UnitsChqDetail")->where('ChqID', '=', $chqId)->get();
            foreach ($find_chq as $find_chq1) {

            }
            $rid = $find_chq1->RId;
            $rid_id = explode("_", $rid);
            if (isLive()) {
                DB::connection('sqlsrv4')->update("UPDATE Cheque_DemandDraft_PayOrder SET Deposit_Bank=?,Deposit_Bank_Acc_Number=? WHERE ReceiptId=?", [$Deposit_Ban[1], $Deposit_Ban[0], $rid_id[1]]);
            }
        }
        $find_chq_grouped = DB::connection('sqlsrv3')->table("UnitsChqDetail")->where('ChqID', '=', $chqId)->get();
        foreach ($find_chq_grouped as $find_chq_grouped1) {
        }
        DB::connection('sqlsrv3')->update("UPDATE UnitsChqDetail SET  DepositedAccount=?,DepositedID=?,DepositDate=?,Status=? WHERE Bank=? and Ch_Pay_Draft_No=? and Ch_Pay_Draft_Date=?", [$Deposit_Ban[1], $Deposit_Ban[0], $Time, $status, $find_chq_grouped1->Bank, $find_chq_grouped1->Ch_Pay_Draft_No, $find_chq_grouped1->Ch_Pay_Draft_Date]);
        if (isLive()) {
            DB::connection('sqlsrv4')->update("UPDATE Cheque_DemandDraft_PayOrder SET Deposit_Bank=?,Deposit_Bank_Acc_Number=?  WHERE Bank=? and Ch_Pay_Draft_No=? and Ch_Pay_Draft_Date=?", [$Deposit_Ban[1], $Deposit_Ban[0], $find_chq_grouped1->Bank, $find_chq_grouped1->Ch_Pay_Draft_No, $find_chq_grouped1->Ch_Pay_Draft_Date]);
        }

        $arr = 'Submitted';
        return request()->json(200, $arr);
    }


    public
    function clearncedetails($id)
    {
        $find_config = DB::connection('sqlsrv3')->table("UnitsChqDetail")->where('ChqID', '=', $id)->get();
        return request()->json(200, $find_config);
    }

    public
    function update_asset(Request $request)
    {


        $asset_id = $request->get('asset_id');
        $sr_number = $request->get('sr_number');
        $salvage_value = $request->get('salvage_value');
        $asset_category = $request->get('asset_category');
        $estlife = $request->get('estlife');

        $update_date = long_date();

        $result = DB::connection('sqlsrv3')->update("UPDATE Assets SET SrNumber=?,SalvageValue=?,EstLife=?, UpdatedBy=?, UpdatedOn=? WHERE AssetsUniqueID=? and CompanyID=?", [$sr_number, $salvage_value, $estlife, username(), $update_date, $asset_id, company_id()]);
        $arr = "submitted!";
        return request()->json(200, $arr);
    }

    public
    function search_assetsbyuniqueid(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('Assets')->join('ItemList', 'ItemList.ID', '=', 'Assets.AssetID')->join('ItemCategory', 'ItemCategory.ID', '=', 'ItemList.ItemCategory')->where('Assets.AssetType', '=', 1)->where('Assets.CompanyID', '=', company_id())->where('Assets.AssetsUniqueID', 'like', '%' . $request->keyword1 . '%')->orderby('Assets.EstLife', 'desc')->select('Assets.*', 'ItemCategory.ID as Category_id', 'ItemCategory.CategoryName', 'ItemList.ItemCode', 'ItemList.Name')->get();

        return request()->json(200, $arr);
    }

    public
    function updateclearance($id, $Clearance_Date)
    {

        $status = 'Clearanced';
        $update_date = long_date();

        $result = DB::connection('sqlsrv3')->update("UPDATE UnitsChqDetail SET ClearanceDateTime=?,Status=?,UpdatedBy=?,ProceedDate=? WHERE ChqID=?", [$Clearance_Date, $status, username(), $update_date, $id]);
        if ($result) {
            $save_ledger = DB::connection('sqlsrv3')->table('UnitsChqDetail')->where('ChqID', '=', $id)->get();
            foreach ($save_ledger as $save_ledger1) {
                $rid = $save_ledger1->RId;
                $rid_id = explode("_", $rid);
                if ($rid_id[0] == 'R2' && isLive()) {
                    $result = DB::connection('sqlsrv4')->update("UPDATE SAM_Receipts SET Status=? WHERE Id=?", ['Approved', $rid_id[1]]);
                }
                $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID2', '=', $save_ledger1->ID)->where('CompanyID', '=', company_id())->exists();
                if (!$find_vendor_id) {
                    $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$save_ledger1->DateTime, $save_ledger1->ReceiptNo, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number . 'with Chq detail:' . $save_ledger1->Ch_Pay_Draft_No . '/' . $save_ledger1->Ch_Pay_Draft_Date, $save_ledger1->PaymentType, $update_date, username(), company_id()]);
                    if ($doc) {
                        $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->ReceiptNo)->get();
                        foreach ($find_doc_id as $find_doc_id1) {

                        }
                        $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $save_ledger1->DateTime, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number . 'with Chq detail:' . $save_ledger1->Ch_Pay_Draft_No . '/' . $save_ledger1->Ch_Pay_Draft_Date . 'Received From :' . $save_ledger1->Name, company_id()]);
                        $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                        foreach ($find_tran_id as $find_tran_id1) {

                        }
                        if ($save_ledger1->Text == 'SAM') {
                            $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', 'SAM')->get();
                            foreach ($find_acc_code as $find_acc_code1) {

                            }
                        } elseif ($save_ledger1->Type == 'Installment' || $save_ledger1->Type == 'Booking') {
                            if ($save_ledger1->Plot_Type == 'Apartment') {
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Project . ' Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            } elseif ($save_ledger1->Plot_Type == 'Shop') {
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Project . ' Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            } else if ($save_ledger1->Block == 'Main G.T Road') {
                                $blo = 'Main GT road';
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $blo . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            } else {
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            }
                        } elseif ($save_ledger1->Type == 'ServiceCharges') {
                            //dynamic types
                            $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                            foreach ($find_acc_code as $find_acc_code1) {

                            }
                            //end dynamic types
                        } elseif ($save_ledger1->Type == 'Electricity_Charges') {
                            //dynamic types
                            $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                            foreach ($find_acc_code as $find_acc_code1) {

                            }
                            //end dynamic types
                        } elseif ($save_ledger1->Type == 'Transfer') {
                            //dynamic types
                            $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block transfer fee')->get();
                            foreach ($find_acc_code as $find_acc_code1) {

                            }
                            //end dynamic types
                        } elseif ($save_ledger1->Type == 'Subsidiary_Recovery' || $save_ledger1->Type == 'Receivable_Receipt') {
                            //dynamic types
                            $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Module . '-Recovery')->get();
                            foreach ($find_acc_code as $find_acc_code1) {

                            }
                            //end dynamic types
                        } elseif ($save_ledger1->Type == 'New_Connection_Charges') {
                            //dynamic types
                            $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block new connection charges')->get();
                            foreach ($find_acc_code as $find_acc_code1) {

                            }
                            //end dynamic types
                        } else {

                            $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', $save_ledger1->Type)->get();

                            foreach ($find_acc_code as $find_acc_code1) {

                            }
                        }
                        if ($find_acc_code1->ID == null) {
                            $message = "Account Head Not Linked";
                            return request()->json(401, $message);
                        } else {

                            $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID2,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'C', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);
                            $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID2,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $save_ledger1->DepositedID, 'D', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);
                        }

                    } //doc
                }
                ///end accounts
            } //for
        }
        if ($result) {

            $find_chq = DB::connection('sqlsrv3')->table("UnitsChqDetail")->where('ChqID', '=', $id)->get();
            foreach ($find_chq as $find_chq1) {

            }
            $rid = $find_chq1->RId;
            $rid_id = explode("_", $rid);
            if (isLive()) {
                if ($rid_id[0] == 'R4') {
                    $result1 = DB::connection('sqlsrv4')->update("UPDATE PropertyDeal_Receipts SET Status=? WHERE Id=?", ['Approved', $rid_id[1]]);
                } else if ($rid_id[0] == 'R2') {
                    $result1 = DB::connection('sqlsrv4')->update("UPDATE SAM_Receipts SET Status=? WHERE Id=?", ['Approved', $rid_id[1]]);
                } else {
                    $result1 = DB::connection('sqlsrv4')->update("UPDATE Cheque_DemandDraft_PayOrder SET Status=?,Clearance_Date=? WHERE ReceiptId=?", ['Approved', $Clearance_Date, $rid_id[1]]);
                }
            }
            $arr = 'Updated';
            return request()->json(200, $arr);
        }
    }

    public
    function search_units_date($startingdate, $closingdate, $type)
    {
        if ($type == 'All') {
            $type = '';
        }
        $find_config = DB::connection('sqlsrv3')->select("select * from UnitsChqDetail where Status !='Clearanced' and Type like '%" . $type . "' and  DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $startingdate . "' and '" . $closingdate . "' order by ChqID desc");
        return request()->json(200, $find_config);
    }

    public
    function submit_unitcash(Request $request)
    {
        $Emp_id = employee_id();
        $id = $request->get('id');
        $update_date = long_date();

        $check = $request->get('added');
        $id1 = explode("|", $id);

        for ($x = 1; $x < count($id1); $x++) {
            $id2 = explode("|", $id);
            $chec = explode("|", $check);

            if ($chec[$x] == 'true') {
                $save_ledger = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('CashID', '=', $id2[$x])->get();
                foreach ($save_ledger as $save_ledger1) {
                    //start accounts
                    $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID2', '=', $save_ledger1->ID)->where('CompanyID', '=', company_id())->exists();
                    if (!$find_vendor_id) {
                        $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$save_ledger1->DateTime, $save_ledger1->ReceiptNo, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number, $save_ledger1->PaymentType, $update_date, username(), company_id()]);
                        if ($doc) {
                            $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->ReceiptNo)->get();
                            foreach ($find_doc_id as $find_doc_id1) {

                            }

                            DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $save_ledger1->DateTime, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number . 'Received From :' . $save_ledger1->Name, company_id()]);
                            $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                            foreach ($find_tran_id as $find_tran_id1) {

                            }
                            if ($save_ledger1->Text == 'SAM') {
                                $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', 'SAM')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            } elseif ($save_ledger1->Type == 'Installment' || $save_ledger1->Type == 'Booking') {
                                if ($save_ledger1->Plot_Type == 'Apartment') {
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Project . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                } else if ($save_ledger1->Block == 'Main G.T Road') {
                                    $blo = 'Main GT road';
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $blo . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                } else {
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                    //end dynamic types
                                }
                            } elseif ($save_ledger1->Type == 'ServiceCharges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Electricity_Charges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Transfer') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block transfer fee')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Subsidiary_Recovery' || $save_ledger1->Type == 'Receivable_Receipt') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Module . '-Recovery')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'New_Connection_Charges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block new connection charges')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } else {
                                $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', $save_ledger1->Type)->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            }


                            $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', 'Cash in Hand')->get();
                            foreach ($find_acc_code9 as $find_acc_code91) {

                            }

                            if ($find_acc_code1->ID == null || $find_acc_code91->ID == null) {
                                $message = "Account Head Not Linked";
                                return request()->json(401, $message);
                            } else {


                                DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID2,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'C', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);

                                DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID2,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->ID, 'D', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);
                            }

                        }
                    }
                    ///end accounts
                    DB::connection('sqlsrv3')->update('update UnitsCashDetail set Status=?,UpdatedBy=?, ProceedDate=? where CashID=?', ['Proceed', username(), $update_date, $id2[$x]]);

                    $find_chq = DB::connection('sqlsrv3')->table("UnitsCashDetail")->where('CashID', '=', $id2[$x])->get();
                    foreach ($find_chq as $find_chq1) {

                    }

                    $rid = $find_chq1->RId;
                    $rid_id = explode("_", $rid);
                    if ($rid_id[0] == 'R4' && isLive()) {
                        $result = DB::connection('sqlsrv4')->update("UPDATE PropertyDeal_Receipts SET Status=? WHERE Id=?", ['Approved', $rid_id[1]]);
                    } else if ($rid_id[0] == 'R2' && isLive()) {
                        $result = DB::connection('sqlsrv4')->update("UPDATE SAM_Receipts SET Status=? WHERE Id=?", ['Approved', $rid_id[1]]);
                    }
                } //for

                insertLog('Unit cash Proceeded', 'Unit Cash for Receipt ID | ' . $rid . ' | Receipt No | ' . $find_chq1->ReceiptNo . ' | amount | ' . $find_chq1->Amount . ' | with Status | ' . $find_chq1->Status . ' | against Name | ' . $find_chq1->Name . ' | Father Name | ' . $find_chq1->Father_Name . ' | File Plot Number | ' . $find_chq1->File_Plot_Number . ' |  has been Proceeded ');

            }

        }


        $message = "submitted";
        return request()->json(401, $message);
    }


    public
    function advance_paid_po()
    {
        $array = [];

        $result = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('PurchaseOrder.CompanyID', '=', company_id())->select('PurchaseOrder.PoCode')->get();
        foreach ($result as $result1) {
            $arr = DB::connection('sqlsrv3')->table('PaymentVoucherDetail')->join('PaymentVoucher', 'PaymentVoucher.PaymentVoucherID', '=', 'PaymentVoucherDetail.PID')->join("PurchaseOrder", 'PurchaseOrder.PoCode', '=', 'PaymentVoucherDetail.AgainstPO')->where('PaymentVoucherDetail.CompanyID', '=', company_id())->where('PaymentVoucherDetail.AgainstPO', '=', $result1->PoCode)->where('PaymentVoucherDetail.AgainstINV', '=', '')->select('PaymentVoucherDetail.PVNO', 'PurchaseOrder.PoCode', 'PurchaseOrder.vendorName', 'PurchaseOrder.TotalAmount', 'PurchaseOrder.Status2', 'PaymentVoucherDetail.Date', 'PaymentVoucherDetail.Amount', 'PaymentVoucher.PaymentAgainst', 'PaymentVoucher.SalesPerson')->get();
            array_push($array, $arr);

        }
        $array1 = Arr::flatten($array);
        return request()->json(200, $array1);
    }

    public
    function unit_trans_type(Request $request)
    {
        $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->select('Type')->groupBy('Type')->get();
        return request()->json(200, $arr);
    }

    public
    function pending_cash_detail($all, $dated, $category, $type)
    {
        if ($type == 'All') {
            $type = '';
        }
        if ($all == 'All') {
            if ($category == 'Both') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '=', $dated)->where('Type', 'like', '%' . $type . '%')->where('Status', '=', null)->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            } elseif ($category == 'SAM') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '=', $dated)->where('Type', 'like', '%' . $type . '%')->where('Status', '=', null)->where('Text', '=', 'SAM')->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            } elseif ($category == 'SAGardens') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '=', $dated)->where('Type', 'like', '%' . $type . '%')->where('Status', '=', null)->where('Text', '!=', 'SAM')->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            }
        } else {
            if ($category == 'Both') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $all)->where('DateTime', '=', $dated)->where('Type', 'like', '%' . $type . '%')->where('Status', '=', null)->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            } elseif ($category == 'SAM') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $all)->where('DateTime', '=', $dated)->where('Type', 'like', '%' . $type . '%')->where('Text', '=', 'SAM')->where('Status', '=', null)->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            } elseif ($category == 'SAGardens') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $all)->where('DateTime', '=', $dated)->where('Type', 'like', '%' . $type . '%')->where('Text', '!=', 'SAM')->where('Status', '=', null)->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            }
        }
    }

    public
    function proceed_report()
    {
        $update_date = long_date();
        $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('status', '=', null)->get();
        foreach ($data as $date1) {


            $record_exists = DB::connection('sqlsrv3')->table('UnitsChqDetail')->where('ID', '=', $date1->ID)->exists();
            if (!$record_exists) {

                if ($date1->PaymentType == 'Debit/Credit Card') {

                    $debt_record_exists = DB::connection('sqlsrv3')->table('UnitsDebitCreditDetail')->where('ID', '=', $date1->ID)->where('RId', '=', $date1->RId)->where('ReceiptNo', '=', $date1->ReceiptNo)->exists();
                    if (!$debt_record_exists) {


                        DB::connection('sqlsrv3')->table('UnitsDebitCreditDetail')->insert([
                            'ID' => $date1->ID,
                            'RId' => $date1->RId,
                            'ReceiptNo' => $date1->ReceiptNo,
                            'Name' => $date1->Name,
                            'Father_Name' => $date1->Father_Name,
                            'Amount' => $date1->Amount,
                            'PaymentType' => $date1->PaymentType,
                            'Bank' => $date1->Bank,
                            'Ch_Pay_Draft_No' => $date1->Ch_Pay_Draft_No,
                            'Ch_Pay_Draft_Date' => $date1->Ch_Pay_Draft_Date,
                            'Branch_Name' => $date1->Branch_Name,
                            'File_Plot_No' => $date1->File_Plot_No,
                            'Type' => $date1->Type,
                            'Text' => $date1->Text,
                            'Module' => $date1->Module,
                            'Plot_Type' => $date1->Plot_Type,
                            'Userid' => $date1->Userid,
                            'Block' => $date1->Block,
                            'Phase' => $date1->Phase,
                            'File_Plot_Number' => $date1->File_Plot_Number,
                            'Transaction_Id' => $date1->Transaction_Id,
                            'DateTime' => $date1->DateTime,
                            'Project' => $date1->Project,

                        ]);
                        DB::connection('sqlsrv3')->update('update TempReceiptTable set status=?, UpdatedBy=?,ProceedDate=? where ID=?', ['Proceed', username(), $update_date, $date1->ID]);
                    }
                } else if ($date1->PaymentType == 'Cash') {
                    $debt_cash_exists = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('ID', '=', $date1->ID)->where('RId', '=', $date1->RId)->where('ReceiptNo', '=', $date1->ReceiptNo)->exists();
                    if (!$debt_cash_exists) {
                        DB::connection('sqlsrv3')->table('UnitsCashDetail')->insert([
                            'ID' => $date1->ID,
                            'RId' => $date1->RId,
                            'ReceiptNo' => $date1->ReceiptNo,
                            'Name' => $date1->Name,
                            'Father_Name' => $date1->Father_Name,
                            'Amount' => $date1->Amount,
                            'PaymentType' => $date1->PaymentType,
                            'Bank' => $date1->Bank,
                            'Ch_Pay_Draft_No' => $date1->Ch_Pay_Draft_No,
                            'Ch_Pay_Draft_Date' => $date1->Ch_Pay_Draft_Date,
                            'Branch_Name' => $date1->Branch_Name,
                            'File_Plot_No' => $date1->File_Plot_No,
                            'Type' => $date1->Type,
                            'Text' => $date1->Text,
                            'Module' => $date1->Module,
                            'Plot_Type' => $date1->Plot_Type,
                            'Userid' => $date1->Userid,
                            'Block' => $date1->Block,
                            'Phase' => $date1->Phase,
                            'File_Plot_Number' => $date1->File_Plot_Number,
                            'Transaction_Id' => $date1->Transaction_Id,
                            'DateTime' => $date1->DateTime,
                            'Project' => $date1->Project,

                        ]);

                        DB::connection('sqlsrv3')->update('update TempReceiptTable set status=?, UpdatedBy=?,ProceedDate=? where ID=?', ['Proceed', username(), $update_date, $date1->ID]);
                    }
                } else if ($date1->PaymentType == 'Online_Cash' || $date1->PaymentType == 'Online_Cheque') {

                    if (str_contains($date1->ReceiptNo, 'DIB') || str_contains($date1->ReceiptNo, 'HBL')) {
                        $debt_online_exists = DB::connection('sqlsrv3')->table('UnitsOnlineCash')->where('ID', '=', $date1->ID)->where('RId', '=', $date1->RId)->where('ReceiptNo', '=', $date1->ReceiptNo)->exists();
                        if (!$debt_online_exists) {
                            DB::connection('sqlsrv3')->table('UnitsOnlineCash')->insert([
                                'ID' => $date1->ID,
                                'RId' => $date1->RId,
                                'ReceiptNo' => $date1->ReceiptNo,
                                'Name' => $date1->Name,
                                'Father_Name' => $date1->Father_Name,
                                'Amount' => $date1->Amount,
                                'PaymentType' => $date1->PaymentType,
                                'Bank' => $date1->Bank,
                                'Ch_Pay_Draft_No' => $date1->Ch_Pay_Draft_No,
                                'Ch_Pay_Draft_Date' => $date1->Ch_Pay_Draft_Date,
                                'Branch_Name' => $date1->Branch_Name,
                                'File_Plot_No' => $date1->File_Plot_No,
                                'Type' => $date1->Type,
                                'Text' => $date1->Text,
                                'Module' => $date1->Module,
                                'Plot_Type' => $date1->Plot_Type,
                                'Userid' => $date1->Userid,
                                'Block' => $date1->Block,
                                'Phase' => $date1->Phase,
                                'File_Plot_Number' => $date1->File_Plot_Number,
                                'Transaction_Id' => $date1->Transaction_Id,
                                'DateTime' => $date1->DateTime,
                                'Project' => $date1->Project,

                            ]);
                            DB::connection('sqlsrv3')->update('update TempReceiptTable set status=?, UpdatedBy=?,ProceedDate=? where ID=?', ['Proceed', username(), $update_date, $date1->ID]);
                        }
                    } else {

                        $chq_record_exists = DB::connection('sqlsrv3')->table('UnitsChqDetail')->where('ID', '=', $date1->ID)->where('RId', '=', $date1->RId)->where('ReceiptNo', '=', $date1->ReceiptNo)->exists();
                        if (!$chq_record_exists) {

                            DB::connection('sqlsrv3')->table('UnitsChqDetail')->insert([
                                'ID' => $date1->ID,
                                'RId' => $date1->RId,
                                'ReceiptNo' => $date1->ReceiptNo,
                                'Name' => $date1->Name,
                                'Father_Name' => $date1->Father_Name,
                                'Amount' => $date1->Amount,
                                'PaymentType' => $date1->PaymentType,
                                'Bank' => $date1->Bank,
                                'Ch_Pay_Draft_No' => $date1->Ch_Pay_Draft_No,
                                'Ch_Pay_Draft_Date' => $date1->Ch_Pay_Draft_Date,
                                'Branch_Name' => $date1->Branch_Name,
                                'File_Plot_No' => $date1->File_Plot_No,
                                'Type' => $date1->Type,
                                'Text' => $date1->Text,
                                'Module' => $date1->Module,
                                'Plot_Type' => $date1->Plot_Type,
                                'Userid' => $date1->Userid,
                                'Block' => $date1->Block,
                                'Phase' => $date1->Phase,
                                'File_Plot_Number' => $date1->File_Plot_Number,
                                'Transaction_Id' => $date1->Transaction_Id,
                                'DateTime' => $date1->DateTime,
                                'Project' => $date1->Project,

                            ]);
                            DB::connection('sqlsrv3')->update('update TempReceiptTable set status=?, UpdatedBy=?,ProceedDate=? where ID=?', ['Proceed', username(), $update_date, $date1->ID]);
                        }
                    }
                } else if ($date1->PaymentType == 'Adjusted') {

                    $debt_record_exists = DB::connection('sqlsrv3')->table('UnitsAdjustOnlineCash')->where('ID', '=', $date1->ID)->where('RId', '=', $date1->RId)->where('ReceiptNo', '=', $date1->ReceiptNo)->exists();
                    if (!$debt_record_exists) {


                        DB::connection('sqlsrv3')->table('UnitsAdjustOnlineCash')->insert([
                            'ID' => $date1->ID,
                            'RId' => $date1->RId,
                            'ReceiptNo' => $date1->ReceiptNo,
                            'Name' => $date1->Name,
                            'Father_Name' => $date1->Father_Name,
                            'Amount' => $date1->Amount,
                            'PaymentType' => $date1->PaymentType,
                            'Bank' => $date1->Bank,
                            'Ch_Pay_Draft_No' => $date1->Ch_Pay_Draft_No,
                            'Ch_Pay_Draft_Date' => $date1->Ch_Pay_Draft_Date,
                            'Branch_Name' => $date1->Branch_Name,
                            'File_Plot_No' => $date1->File_Plot_No,
                            'Type' => $date1->Type,
                            'Text' => $date1->Text,
                            'Module' => $date1->Module,
                            'Plot_Type' => $date1->Plot_Type,
                            'Userid' => $date1->Userid,
                            'Block' => $date1->Block,
                            'Phase' => $date1->Phase,
                            'File_Plot_Number' => $date1->File_Plot_Number,
                            'Transaction_Id' => $date1->Transaction_Id,
                            'DateTime' => $date1->DateTime,
                            'Project' => $date1->Project,


                        ]);
                        DB::connection('sqlsrv3')->update('update TempReceiptTable set status=?, UpdatedBy=?,ProceedDate=? where ID=?', ['Proceed', username(), $update_date, $date1->ID]);
                    }
                } else if ($date1->PaymentType != 'Cash' || $date1->PaymentType != 'Debit/Credit Card' || $date1->PaymentType != 'Online_Cash') {

                    $chq_record_exists = DB::connection('sqlsrv3')->table('UnitsChqDetail')->where('ID', '=', $date1->ID)->where('RId', '=', $date1->RId)->where('ReceiptNo', '=', $date1->ReceiptNo)->exists();
                    if (!$chq_record_exists) {

                        DB::connection('sqlsrv3')->table('UnitsChqDetail')->insert([
                            'ID' => $date1->ID,
                            'RId' => $date1->RId,
                            'ReceiptNo' => $date1->ReceiptNo,
                            'Name' => $date1->Name,
                            'Father_Name' => $date1->Father_Name,
                            'Amount' => $date1->Amount,
                            'PaymentType' => $date1->PaymentType,
                            'Bank' => $date1->Bank,
                            'Ch_Pay_Draft_No' => $date1->Ch_Pay_Draft_No,
                            'Ch_Pay_Draft_Date' => $date1->Ch_Pay_Draft_Date,
                            'Branch_Name' => $date1->Branch_Name,
                            'File_Plot_No' => $date1->File_Plot_No,
                            'Type' => $date1->Type,
                            'Text' => $date1->Text,
                            'Module' => $date1->Module,
                            'Plot_Type' => $date1->Plot_Type,
                            'Userid' => $date1->Userid,
                            'Block' => $date1->Block,
                            'Phase' => $date1->Phase,
                            'File_Plot_Number' => $date1->File_Plot_Number,
                            'Transaction_Id' => $date1->Transaction_Id,
                            'DateTime' => $date1->DateTime,
                            'Project' => $date1->Project,

                        ]);
                        DB::connection('sqlsrv3')->update('update TempReceiptTable set status=?, UpdatedBy=?,ProceedDate=? where ID=?', ['Proceed', username(), $update_date, $date1->ID]);
                    }
                }
            }
        }
        $message = "Status updated!";
        return request()->json(401, $message);
    }

    public
    function get_item_det($id)
    {

        $data = DB::connection('sqlsrv3')->table("ItemList")->where('CompanyID', '=', company_id())->where('ID', '=', $id)->get();
        return request()->json(401, $data);
    }


//units controller
    public
    function get_counter_sum_online_adjust($dated, $bank_type)
    {
        if ($bank_type == 'All') {
            $cash_amount = DB::connection('sqlsrv3')->table('UnitsAdjustOnlineCash')->where('Status', '=', null)->where('DateTime', '=', $dated)->sum('Amount');

            $myJSON = array(
                'cash' => $cash_amount,
            );
            return request()->json(200, $myJSON);
        } else {
            $cash_amount = DB::connection('sqlsrv3')->table('UnitsAdjustOnlineCash')->where('Status', '=', null)->where('DateTime', '=', $dated)->where('ReceiptNo', 'like', '%' . $bank_type . '%')->sum('Amount');

            $myJSON = array(
                'cash' => $cash_amount,
            );
            return request()->json(200, $myJSON);
        }
    }

    public
    function submit_unitelectricity(Request $request)
    {

        $id = $request->get('id');

        $update_date = long_date();

        $check = $request->get('added');
        $id1 = explode("|", $id);
        $t = 'TRUE';
        for ($x = 1; $x < count($id1); $x++) {
            $chec = explode("|", $check);

            if ($chec[$x] == 'false') {
                $t = 'FALSE';
            } else {
                $t = 'TRUE';
            }

            if ($t == 'TRUE') {

                for ($x = 1; $x < count($id1); $x++) {
                    $id2 = explode("|", $id);
                    $chec = explode("|", $check);
                    if ($chec[$x] == 'true') {
                        $save_ledger = DB::connection('sqlsrv3')->table('TempElectricityBooking')->where('EID', '=', $id2[$x])->get();
                        foreach ($save_ledger as $save_ledger1) {
                            //
                            if ($save_ledger1->Total < 0) {
                                $find_config = 'Amount Cannot be Negative';
                                return request()->json(200, $find_config);
                            }
                            $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID5', '=', $save_ledger1->EID)->where('CompanyID', '=', company_id())->exists();
                            if (!$find_vendor_id) {
                                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$save_ledger1->Dated, 'Electricity ' . $save_ledger1->Block, 'Electricity Charges Against' . $save_ledger1->Block . '/' . $save_ledger1->Plot_Type, $save_ledger1->Plot_Type, $update_date, username(), company_id()]);
                                if ($doc) {
                                    $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', 'Electricity ' . $save_ledger1->Block)->get();
                                    foreach ($find_doc_id as $find_doc_id1) {

                                    }

                                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $save_ledger1->Dated, 'Booking Electricity Charges Against' . $save_ledger1->Block . '/' . $save_ledger1->Plot_Type, company_id()]);

                                    $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                                    foreach ($find_tran_id as $find_tran_id1) {

                                    }
                                    if ($save_ledger1->Block == 'Main G.T Road') {
                                        $blo = 'Main GT road';

                                        $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $blo . ' Block electricity charges Receivables')->get();
                                        foreach ($find_acc_code as $find_acc_code1) {

                                        }
                                    } else {

                                        $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block electricity charges Receivables')->get();
                                        // Shoaib Block Commerical Services Receivables
                                        foreach ($find_acc_code as $find_acc_code1) {

                                        }
                                    }
                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID5,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'D', $save_ledger1->Total, $save_ledger1->EID, company_id()]);

                                    if ($save_ledger1->Block == 'Main G.T Road') {
                                        $blo = 'Main GT road';
                                        $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $blo . ' block electricity charges income')->get();
                                        foreach ($find_acc_code9 as $find_acc_code91) {

                                        }
                                    } else {
                                        $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block electricity charges income')->get();
                                        foreach ($find_acc_code9 as $find_acc_code91) {

                                        }
                                    }
                                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID5,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->ID, 'C', $save_ledger1->Total, $save_ledger1->EID, company_id()]);
                                } //doc
                            }
                            DB::connection('sqlsrv3')->update('update TempElectricityBooking set Status=? where EID=?', [username(), $save_ledger1->EID]);
                        } //for
                    }
                } //for
                $message = "submitted";
                return request()->json(401, $message);
            } else {
                $t = "false";
            }
        }
        if ($t == 'false') {
            $message = "Select Data";
            return request()->json(401, $message);
        }
    }

    public
    function pending_dealervoucher_detail()
    {
        $data = DB::connection('sqlsrv3')->table("Dealer_Voucher")->where('Status', '=', null)->where('DateTime', '>=', '2023-04-25 18:11:08.763')->orderby('Id', 'desc')->get();
        return request()->json(401, $data);
    }

    public
    function pending_dealervoucher_sum()
    {
        $data = DB::connection('sqlsrv3')->table("Dealer_Voucher")->where('Status', '=', null)->where('DateTime', '>=', '2023-04-25 18:11:08.763')->sum('Amount');
        return request()->json(401, $data);
    }

    public
    function search_dealervoucher($id)
    {

        $arr = DB::connection('sqlsrv3')->table('Dealer_Voucher')->where('Status', '=', null)->where('Name', 'like', '%' . $id . '%')->where('DateTime', '>=', '2023-04-25 18:11:08.763')->orderby('Id', 'desc')->get();
        return request()->json(200, $arr);
    }

    public
    function submit_dealervoucher(Request $request)
    {
        $id = $request->get('id');
        $update_date = long_date();
        $check = $request->get('added');
        $id1 = explode("|", $id);

        for ($x = 1; $x < count($id1); $x++) {
            $id2 = explode("|", $id);
            $chec = explode("|", $check);
            if ($chec[$x] == 'true') {
                $save_ledger = DB::connection('sqlsrv3')->table('Dealer_Voucher')->where('Id', '=', $id2[$x])->get();
                foreach ($save_ledger as $save_ledger1) {
                    ;
                    $voucher_date = explode(" ", $save_ledger1->DateTime);
                    if ($save_ledger1->PaymentType == 'Cheque') {
                        $checKing = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountName', '=', $save_ledger1->Bank)->exists();
                        if ($checKing) {
                            $find_acc = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountName', '=', $save_ledger1->Bank)->get();
                            foreach ($find_acc as $find_acc1) {

                            }
                        } else {
                            $message = "Account Head does not exist Against this Bank";
                            return request()->json(401, $message);
                        }
                    }
                    $seccheck = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Liabilities')->where('ID', '=', $save_ledger1->AccountId)->exists();
                    if ($seccheck) {

                        $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$voucher_date[0], $save_ledger1->VoucherNo, $save_ledger1->Type . ' ' . ' Against File Plot Id:' . $save_ledger1->File_Plot_Id . '/ Name: ' . $save_ledger1->Name, $save_ledger1->Type, $update_date, username(), company_id()]);
                        if ($doc) {
                            $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->VoucherNo)->get();
                            foreach ($find_doc_id as $find_doc_id1) {

                            }

                            $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $voucher_date[0], $save_ledger1->Type . ' ' . ' Against File Plot Id:' . $save_ledger1->File_Plot_Id . '/ Name: ' . $save_ledger1->Name, company_id()]);

                            $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                            foreach ($find_tran_id as $find_tran_id1) {

                            }
                            $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Liabilities')->where('AccountName', '=', $save_ledger1->Name)->get();
                            foreach ($find_acc_code as $find_acc_code1) {

                            }
                            $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'D', $save_ledger1->Amount, company_id()]);

                            if ($save_ledger1->PaymentType == 'Cash') {
                                $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '101001001001', 'C', $save_ledger1->Amount, company_id()]);
                            } else if ($save_ledger1->PaymentType == 'Cheque') {
                                $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc1->ID, 'C', $save_ledger1->Amount, company_id()]);
                            }

                        }

                    } else {
                        $message = "Account Head does not exist Against this Name";
                        return request()->json(401, $message);
                    }


                } //for
                DB::connection('sqlsrv3')->update('update Dealer_Voucher set Status=? where Id=?', ['Proceed', $save_ledger1->Id]);
            }
        }

        $message = "submitted";
        return request()->json(401, $message);
    }

    public
    function fetchdealer_voucher()
    {
        $arr = DB::connection('sqlsrv3')->select("INSERT INTO [SAG_Accounts_DB].[dbo].[Dealer_Voucher]
    ([VoucherNo], [Name], [Father_Name], [Contact], [Address], [Amount], [Voucher_Amount], [AmountinWords], [PaymentType], [Bank], [Ch_Pay_Draft_No], [Ch_Pay_Draft_Date], [Branch_Name], [Project], [File_Plot_Id], [Module], [Type], [TokenParameter], [Text], [Description], [Cancel], [Vendor_Id], [Gen_Name], [Userid], [DateTime], [Pre_Name], [Prepared_by], [Pre_Datetime], [Sup_Name], [Supervised_By], [Sup_Datetime], [Status], [Group_Id], [Transaction_Id], [Checked], [dayClose], [Comp_Id], [Sale_Id], [Plot_Is_Cancelled] , AccountID)
SELECT [VoucherNo], [Name], [Father_Name], [Contact], v.[Address], [Amount], [Voucher_Amount], [AmountinWords], [PaymentType], [Bank], [Ch_Pay_Draft_No], [Ch_Pay_Draft_Date], [Branch_Name], [Project], [File_Plot_Id], [Module], [Type], [TokenParameter], [Text], [Description], [Cancel], [Vendor_Id], [Gen_Name], [Userid], [DateTime], [Pre_Name], [Prepared_by], [Pre_Datetime], [Sup_Name], [Supervised_By], [Sup_Datetime], v.[Status], [Group_Id], [Transaction_Id], [Checked], [dayClose], [Comp_Id], [Sale_Id], [Plot_Is_Cancelled]
  ,d.[COA_Code]
FROM  [192.168.11.161].[SA_MIS].[dbo].[Voucher] v
 join [192.168.11.161].[SA_MIS].[dbo].[Dealership] d on v.Name=d.Dealership_Name
    WHERE v.module = 'Dealers'
     AND v.[VoucherNo] NOT IN
                  (SELECT [VoucherNo]
            FROM [SAG_Accounts_DB].[dbo].[Dealer_Voucher]
                     WHERE module = 'Dealers')");
        $arr1 = 'Transferred Data';
        return request()->json(200, $arr1);
    }

    public
    function submit_unitservices1(Request $request)
    {

        $id = $request->get('id');
        $update_date = long_date();

        $check = $request->get('added');
        $id1 = explode("|", $id);


        for ($x = 1; $x < count($id1); $x++) {
            $id2 = explode("|", $id);
            $chec = explode("|", $check);

            if ($chec[$x] == 'true') {
                $save_ledger = DB::connection('sqlsrv3')->table('TempServicesBooking')->where('SRID', '=', $id2[$x])->get();
                foreach ($save_ledger as $save_ledger1) {

                    if ($save_ledger1->Total < 0) {
                        $find_config = 'Amount Cannot be Negative';
                        return request()->json(200, $find_config);
                    }
                    $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID3', '=', $save_ledger1->SRID)->where('CompanyID', '=', company_id())->exists();
                    if (!$find_vendor_id) {
                        $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$save_ledger1->Dated, 'Services ' . $save_ledger1->Block, 'Booking Services Charges Against' . $save_ledger1->Block . '/' . $save_ledger1->Plot_Type, $save_ledger1->Plot_Type, $update_date, username(), company_id()]);
                        if ($doc) {
                            $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', 'Services ' . $save_ledger1->Block)->get();
                            foreach ($find_doc_id as $find_doc_id1) {

                            }

                            $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $save_ledger1->Dated, 'Booking Services Charges Against' . $save_ledger1->Block . '/' . $save_ledger1->Plot_Type, company_id()]);

                            $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                            foreach ($find_tran_id as $find_tran_id1) {

                            }
                            if ($save_ledger1->Block == 'Main G.T Road') {
                                $blo = 'Main GT road';

                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $blo . ' Block service charges Receivables')->get();
                                // Shoaib Block Commerical Services Receivables
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            } else {
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                                // Shoaib Block Commerical Services Receivables
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            }

                            $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID3,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'D', $save_ledger1->Total, $save_ledger1->SRID, company_id()]);

                            if ($save_ledger1->Block == 'Main G.T Road') {
                                $blo = 'Main GT road';
                                $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $blo . ' block service charges income')->get();
                                foreach ($find_acc_code9 as $find_acc_code91) {

                                }
                            } else {
                                $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block service charges income')->get();
                                foreach ($find_acc_code9 as $find_acc_code91) {

                                }
                            }
                            $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID3,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->ID, 'C', $save_ledger1->Total, $save_ledger1->SRID, company_id()]);
                        } //doc

                    }
                    DB::connection('sqlsrv3')->update('update TempServicesBooking set Status=? where SRID=?', [username(), $save_ledger1->SRID]);
                } //for

                $message = "submitted";
            } else {
                $t = "false";
            }

        }
        if ($t == 'false') {
            $message = "Select Data";
            return request()->json(401, $message);
        } else {


            return request()->json(401, $message);
        }

    }

    public
    function submit_unitservices(Request $request)
    {

        $id = $request->get('id');
        $update_date = long_date();

        $check = $request->get('added');
        $id1 = explode("|", $id);
        $t = 'TRUE';

        for ($x = 1; $x < count($id1); $x++) {
            $chec = explode("|", $check);

            if ($chec[$x] == 'false') {
                $t = 'FALSE';
            } else {
                $t = 'TRUE';
            }
            if ($t == 'TRUE') {

                for ($x = 1; $x < count($id1); $x++) {
                    $id2 = explode("|", $id);
                    $chec = explode("|", $check);

                    if ($chec[$x] == 'true') {

                        $save_ledger = DB::connection('sqlsrv3')->table('TempServicesBooking')->where('SRID', '=', $id2[$x])->get();
                        foreach ($save_ledger as $save_ledger1) {


                            if ($save_ledger1->Total < 0) {
                                $find_config = 'Amount Cannot be Negative';
                                return request()->json(200, $find_config);
                            }
                            $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID3', '=', $save_ledger1->SRID)->where('CompanyID', '=', company_id())->exists();
                            if (!$find_vendor_id) {
                                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$save_ledger1->Dated, 'Services ' . $save_ledger1->Block, 'Booking Services Charges Against' . $save_ledger1->Block . '/' . $save_ledger1->Plot_Type, $save_ledger1->Plot_Type, $update_date, username(), company_id()]);
                                if ($doc) {
                                    $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', 'Services ' . $save_ledger1->Block)->get();
                                    foreach ($find_doc_id as $find_doc_id1) {

                                    }

                                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $save_ledger1->Dated, 'Booking Services Charges Against' . $save_ledger1->Block . '/' . $save_ledger1->Plot_Type, company_id()]);

                                    $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                                    foreach ($find_tran_id as $find_tran_id1) {

                                    }
                                    if ($save_ledger1->Block == 'Main G.T Road') {
                                        $blo = 'Main GT road';

                                        $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $blo . ' Block service charges Receivables')->get();
                                        // Shoaib Block Commerical Services Receivables
                                        foreach ($find_acc_code as $find_acc_code1) {

                                        }
                                    } else {
                                        $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                                        // Shoaib Block Commerical Services Receivables
                                        foreach ($find_acc_code as $find_acc_code1) {

                                        }
                                    }

                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID3,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'D', $save_ledger1->Total, $save_ledger1->SRID, company_id()]);

                                    if ($save_ledger1->Block == 'Main G.T Road') {
                                        $blo = 'Main GT road';
                                        $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $blo . ' block service charges income')->get();
                                        foreach ($find_acc_code9 as $find_acc_code91) {

                                        }
                                    } else {
                                        $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block service charges income')->get();
                                        foreach ($find_acc_code9 as $find_acc_code91) {

                                        }
                                    }
                                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID3,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->ID, 'C', $save_ledger1->Total, $save_ledger1->SRID, company_id()]);
                                } //doc

                            }
                            DB::connection('sqlsrv3')->update('update TempServicesBooking set Status=? where SRID=?', [username(), $save_ledger1->SRID]);
                        } //for
                    }
                }
                $message = "submitted";
                return request()->json(401, $message);
            } else {
                $t = "false";
            }

        }
        if ($t == 'false') {
            $message = "Select Data";
            return request()->json(401, $message);
        }
    }

    public
    function pending_services_detail()
    {
        $data = DB::connection('sqlsrv3')->table("TempServicesBooking")->where('Status', '=', null)->orderby('SRID', 'desc')->get();
        return request()->json(401, $data);
    }

    public
    function Booking_services_Mis_to_sa_app($start_date)
    {
        $update_date = short_date();
        try {
            DB::connection('sqlsrv4')->getPdo();
            if (DB::connection('sqlsrv4')->getDatabaseName()) {
                $record = DB::connection('sqlsrv4')->select("SELECT Block , Plot_Type, sum (Amount_Paid) as AmountPaid, sum (Net_Total) as Total FROM ServiceCharges_Bill where Date  > '" . $start_date . "-01' and Date  < '" . $start_date . "-28' group by Block, Plot_Type");
                foreach ($record as $record1) {
                    DB::connection('sqlsrv3')->table('TempServicesBooking')->insert([
                        'Block' => $record1->Block,
                        'Plot_Type' => $record1->Plot_Type,
                        'Total' => $record1->Total,
                        'Dated' => $update_date,
                        'username' => username(),
                    ]);
                }
                $arr = "Transfered Successfully";
                return request()->json(200, $arr);
            } else {
                $arr = "Could not find the MIS DB. Please check your Network Connection.";
                return request()->json(200, $arr);
            }
        } catch (\Exception $e) {
            $arr = "Could not find the MIS DB. Please check your Network Connection1.";
            return request()->json(200, $arr);
        }
    }

    public
    function receipt_Mis_to_sa_app($start_date, $end_date)
    {
        $update_date = long_date();
        try {
            DB::connection('sqlsrv4')->getPdo();
            if (DB::connection('sqlsrv4')->getDatabaseName()) {
                $record0 = DB::connection('sqlsrv4')->select("select * from Receipts where Cancel=1 and DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");
                foreach ($record0 as $record00) {
                    $record_d = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId', '=', 'R1_' . $record00->Id)->where('status', null)->exists();
                    if ($record_d) {
                        DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId', '=', 'R1_' . $record00->Id)->where('status', null)->delete();
                    }
                }
                $record = DB::connection('sqlsrv4')->select("select * from Receipts where Cancel is null and DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");
                foreach ($record as $record1) {
                    $record_exists = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId', '=', 'R1_' . $record1->Id)->exists();
                    if (!$record_exists) {
                        $date2 = explode(" ", $record1->DateTime);
                        DB::connection('sqlsrv3')->table('TempReceiptTable')->insert([
                            'RId' => 'R1_' . $record1->Id,
                            'ReceiptNo' => $record1->ReceiptNo,
                            'Name' => $record1->Name,
                            'Father_Name' => $record1->Father_Name,
                            'Amount' => $record1->Amount,
                            'PaymentType' => $record1->PaymentType,
                            'Bank' => $record1->Bank,
                            'Ch_Pay_Draft_No' => $record1->Ch_Pay_Draft_No,
                            'Ch_Pay_Draft_Date' => $record1->Ch_Pay_Draft_Date,
                            'Branch_Name' => $record1->Branch_Name,
                            'File_Plot_No' => $record1->File_Plot_No,
                            'Type' => $record1->Type,
                            'Text' => $record1->Text,
                            'Module' => $record1->Module,
                            'Plot_Type' => $record1->Plot_Type,
                            'Userid' => $record1->Userid,
                            'Block' => $record1->Block,
                            'Phase' => $record1->Phase,
                            'File_Plot_Number' => $record1->File_Plot_Number,
                            'Transaction_Id' => $record1->Transaction_Id,
                            'DateTime' => $date2[0],
                            'Project' => $record1->Project,
                            'CreatedBy' => username(),
                            'Recovery_StartDate' => $start_date,
                            'Recovery_EndDate' => $end_date,
                        ]);
                    }
                }
                //SAM_RECIPT
                $record001 = DB::connection('sqlsrv4')->select("select * from SAM_Receipts where Cancel=1 and DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");
                foreach ($record0 as $record00) {
                    $record_d = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId', '=', 'R2_' . $record00->Id)->where('status', null)->exists();
                    if ($record_d) {
                        DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId', '=', 'R2_' . $record00->Id)->where('status', null)->delete();
                    }

                }
                $record22 = DB::connection('sqlsrv4')->select("select * from SAM_Receipts where Cancel is null and DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");
                foreach ($record22 as $record221) {
                    $record_exists22 = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId', '=', 'R2_' . $record221->Id)->exists();
                    if (!$record_exists22) {
                        $date22 = explode(" ", $record221->DateTime);
                        DB::connection('sqlsrv3')->table('TempReceiptTable')->insert([
                            'RId' => 'R2_' . $record221->Id,
                            'ReceiptNo' => $record221->ReceiptNo,
                            'Name' => $record221->Name,
                            'Father_Name' => $record221->Father_Name,
                            'Amount' => $record221->Amount,
                            'PaymentType' => $record221->PaymentType,
                            'Bank' => $record221->Bank,
                            'Ch_Pay_Draft_No' => $record221->Ch_Pay_Draft_No,
                            'Ch_Pay_Draft_Date' => $record221->Ch_Pay_Draft_Date,
                            'Branch_Name' => $record221->Branch_Name,
                            'Type' => $record221->Type,
                            'Text' => 'SAM',
                            'Module' => $record221->Module,
                            'Userid' => $record221->Userid,
                            'Block' => $record221->Block,
                            'Phase' => $record221->Phase,
                            'File_Plot_Number' => $record221->File_Plot_Number,
                            'DateTime' => $date22[0],
                        ]);
                    }
                }
                $record44 = DB::connection('sqlsrv4')->select("select * from PropertyDeal_Receipts where Type !='Direct Payment' and DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");
                foreach ($record44 as $record441) {
                    $record_exists44 = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId', '=', 'R4_' . $record441->Id)->exists();
                    if (!$record_exists44) {
                        $date44 = explode(" ", $record441->DateTime);
                        $find_sam_already_exists = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('ReceiptNo', '=', $record441->ReceiptNo)->where('DateTime', '=', $date44[0])->where('RId', 'like', 'R2_%')->exists();
                        if (!$find_sam_already_exists) {
                            DB::connection('sqlsrv3')->table('TempReceiptTable')->insert([
                                'RId' => 'R4_' . $record441->Id,
                                'ReceiptNo' => $record441->ReceiptNo,
                                'Name' => $record441->Name,
                                'Father_Name' => $record441->Father_Name,
                                'Amount' => $record441->Amount,
                                'PaymentType' => $record441->PaymentType,
                                'Bank' => $record441->Bank,
                                'Ch_Pay_Draft_No' => $record441->Ch_Pay_Draft_No,
                                'Ch_Pay_Draft_Date' => $record441->Ch_Pay_Draft_Date,
                                'Branch_Name' => $record441->Branch_Name,
                                'Type' => $record441->Type,
                                'Text' => 'SAM',
                                'Module' => $record441->Module,
                                'Userid' => $record441->Userid,
                                'Block' => $record441->Block,
                                'File_Plot_Number' => $record441->File_Plot_Number,
                                'DateTime' => $date44[0],
                            ]);

                        }

                    }

                }
                //SAM payment voucher
                $record55 = DB::connection('sqlsrv4')->select("select * from PropertyDeal_Voucher where DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");
                foreach ($record55 as $record551) {
                    $record_exists55 = DB::connection('sqlsrv3')->table('TempPaymentTable')->where('PId', '=', 'P1_' . $record551->Id)->exists();
                    if (!$record_exists55) {
                        $date55 = explode(" ", $record551->DateTime);
                        DB::connection('sqlsrv3')->table('TempPaymentTable')->insert([
                            'PId' => 'P1_' . $record551->Id,
                            'ReceiptNo' => $record551->VoucherNo,
                            'Name' => $record551->Name,
                            'Father_Name' => $record551->Father_Name,
                            'Amount' => $record551->Amount,
                            'PaymentType' => $record551->PaymentType,
                            'Bank' => $record551->Bank,
                            'Ch_Pay_Draft_No' => $record551->Ch_Pay_Draft_No,
                            'Ch_Pay_Draft_Date' => $record551->Ch_Pay_Draft_Date,
                            'Branch_Name' => $record551->Branch_Name,
                            'Type' => $record551->Type,
                            'Text' => 'SAM',
                            'Userid' => $record551->Userid,
                            'Block' => $record551->Block,
                            'File_Plot_Number' => $record551->File_Plot_Number,
                            'DateTime' => $date55[0],
                        ]);
                    }
                }
                $record66 = DB::connection('sqlsrv4')->select("select * from SAM_Voucher where DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");
                foreach ($record66 as $record661) {
                    $record_exists66 = DB::connection('sqlsrv3')->table('TempPaymentTable')->where('PId', '=', 'P2_' . $record661->Id)->exists();
                    if (!$record_exists66) {
                        $date66 = explode(" ", $record661->DateTime);
                        DB::connection('sqlsrv3')->table('TempPaymentTable')->insert([
                            'PId' => 'P2_' . $record661->Id,
                            'ReceiptNo' => $record661->VoucherNo,
                            'Name' => $record661->Name,
                            'Father_Name' => $record661->Father_Name,
                            'Amount' => $record661->Amount,
                            'PaymentType' => $record661->PaymentType,
                            'Bank' => $record661->Bank,
                            'Ch_Pay_Draft_No' => $record661->Ch_Pay_Draft_No,
                            'Ch_Pay_Draft_Date' => $record661->Ch_Pay_Draft_Date,
                            'Branch_Name' => $record661->Branch_Name,
                            'Type' => $record661->Type,
                            'Text' => 'SAM',
                            'Userid' => $record661->Userid,
                            'Block' => $record661->Block,
                            'File_Plot_Number' => $record661->File_Plot_Number,
                            'DateTime' => $date66[0],
                        ]);
                    }
                }
                $record77 = DB::connection('sqlsrv4')->select("select * from Cancellation_Receipts where Id > 1253 ");
                foreach ($record77 as $record771) {
                    $record_exists77 = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('Rid', '=', $record771->Id)->exists();
                    if (!$record_exists77) {
                        $date77 = explode(" ", $record771->DateTime);
                        DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->insert([
                            'Rid' => $record771->Id,
                            'ReceiptNo' => $record771->ReceiptNo,
                            'File_Plot_No' => $record771->File_Plot_No,
                            'File_Plot_Number' => $record771->File_Plot_Number,
                            'Block' => $record771->Block,
                            'Name' => $record771->Name,
                            'Father_Name' => $record771->Father_Name,
                            'Contact' => $record771->Contact,
                            'Project' => $record771->Project,
                            'Size' => $record771->Size,
                            'Plot_Total_Amount' => $record771->Plot_Total_Amount,
                            'Amount' => $record771->Amount,
                            'Type' => $record771->Type,
                            'TokenParameter' => $record771->TokenParameter,
                            'DateTime' => $date77[0],
                            'Module' => $record771->Module,
                            'Description' => $record771->Description,
                            'Userid' => $record771->Userid,
                            'Cancel' => $record771->Cancel,
                            'Text' => $record771->Text,
                            'Phase' => $record771->Phase,
                            'Receipt_Type' => $record771->Receipt_Type,
                            'Deduction' => $record771->Deduction,
                            'Repurchased_Amt' => $record771->Repurchased_Amt,
                            'Deduction_Amt' => $record771->Deduction_Amt,
                            'Plot_Type' => $record771->Plot_Type,
                            'Status' => 'Not Cleared',
                        ]);
                    }
                }
                $arr = "Transfered Successfully";
                return request()->json(200, $arr);
            } else {
                $arr = "Could not find the MIS DB. Please check your Network Connection.";
                return request()->json(200, $arr);
            }
        } catch (\Exception $e) {
            $arr = "Could not transfer the data!";
            return request()->json(200, $arr);
        }
    }

    public
    function submit_unitsam(Request $request)
    {
        $id = $request->get('id');
        $update_date = long_date();
        $check = $request->get('added');
        $id1 = explode("|", $id);

        for ($x = 1; $x < count($id1); $x++) {
            $id2 = explode("|", $id);
            $chec = explode("|", $check);
            if ($chec[$x] == 'true') {
                $save_ledger = DB::connection('sqlsrv3')->table('TempPaymentTable')->where('ID', '=', $id2[$x])->get();
                foreach ($save_ledger as $save_ledger1) {
                    //start accounts
                    $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID6', '=', $save_ledger1->ID)->where('CompanyID', '=', company_id())->exists();
                    if (!$find_vendor_id) {
                        $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$save_ledger1->DateTime, $save_ledger1->ReceiptNo, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number, $save_ledger1->PaymentType, $update_date, username(), company_id()]);
                        if ($doc) {
                            $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->ReceiptNo)->get();
                            foreach ($find_doc_id as $find_doc_id1) {

                            }

                            $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $save_ledger1->DateTime, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number . 'Received From :' . $save_ledger1->Name, company_id()]);
                            $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                            foreach ($find_tran_id as $find_tran_id1) {

                            }

                            $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', $save_ledger1->Text)->get();
                            foreach ($find_acc_code as $find_acc_code1) {

                            }

                            if ($save_ledger1->PaymentType == 'Cash') {
                                $find_acc_code9 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', 'Cash in Hand')->get();
                                foreach ($find_acc_code9 as $find_acc_code91) {

                                }
                            }


                            $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID6,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'D', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);

                            $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID6,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->ID, 'C', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);
                        }
                    }
                    ///end accounts
                    DB::connection('sqlsrv3')->update('update TempPaymentTable set status=? where ID=?', ['Proceed', $id2[$x]]);
                } //for


            }
        }

        $message = "submitted";
        return request()->json(401, $message);
    }


    public
    function Booking_Mis_to_sa_app($start_date, $end_date)
    {


        $update_date = long_date();

        try {
            DB::connection('sqlsrv4')->getPdo();
            if (DB::connection('sqlsrv4')->getDatabaseName()) {

                $record = DB::connection('sqlsrv4')->select("select distinct pb.Id,pb.File_Plot_Id,ff.FileFormNumber as file_plot_number, ff.Type,ff.Block as Block_Name
   , pb.Module as UnitModule ,pb.Total_Amount as BookingAmount
  --,dd.Dealer_Id, dd.Dealer_Name ,dd.Com_Amount
  , po.Name as OwnerName , po.DateTime
  from  File_Plot_Balance pb
  join File_Form ff on   ff.Id= pb.File_Plot_Id  and pb.Module = 'FileManagement'
  join  Files_Transfer po  on po.File_Form_Id = pb.File_Plot_Id     and po.Ownership_Status = 'Owner'
  where pb.Booking_Date  between '" . $start_date . "' AND DATEADD(s,-1,DATEADD(d,1,'" . $end_date . "'))");


                foreach ($record as $record1) {


                    $record_exists = DB::connection('sqlsrv3')->table('TempBookingTable')->where('Id', '=', $record1->Id)->exists();
                    if (!$record_exists) {
                        $date2 = explode(" ", $record1->DateTime);
                        DB::connection('sqlsrv3')->table('TempBookingTable')->insert([
                            'Id' => $record1->Id,
                            'File_Plot_Id' => $record1->File_Plot_Id,
                            'file_plot_number' => $record1->file_plot_number,
                            'Type' => $record1->Type,
                            'Block_Name' => $record1->Block_Name,
                            'UnitModule' => $record1->UnitModule,
                            'BookingAmount' => $record1->BookingAmount,
                            'OwnerName' => $record1->OwnerName,
                            'Dated' => $date2[0],
                        ]);

                    }
                }
                //plotmanagement

                $record5 = DB::connection('sqlsrv4')->select("select pb.Id , pb.File_Plot_Id,ff.Plot_Number  as file_plot_number, ff.Type, ff.Block_Name
  , pb.Module as UnitModule ,pb.Total_Amount as BookingAmount,
   po.Name as OwnerName , po.Ownership_DateTime as DateTime
  from  File_Plot_Balance pb
  join Plots ff on   ff.Id= pb.File_Plot_Id  and pb.Module = 'PlotManagement'
  join  Plot_Ownership po  on po.Plot_Id = pb.File_Plot_Id     and po.Ownership_Status = 'Owner'
  where pb.Booking_Date  between '" . $start_date . "' AND DATEADD(s,-1,DATEADD(d,1,'" . $end_date . "'))");
                foreach ($record5 as $record51) {


                    $record_exists5 = DB::connection('sqlsrv3')->table('TempBookingTable')->where('Id', '=', $record51->Id)->exists();
                    if (!$record_exists5) {
                        $date52 = explode(" ", $record51->DateTime);
                        DB::connection('sqlsrv3')->table('TempBookingTable')->insert([
                            'Id' => $record51->Id,
                            'File_Plot_Id' => $record51->File_Plot_Id,
                            'file_plot_number' => $record51->file_plot_number,
                            'Type' => $record51->Type,
                            'Block_Name' => $record51->Block_Name,
                            'UnitModule' => $record51->UnitModule,
                            'BookingAmount' => $record51->BookingAmount,
                            'OwnerName' => $record51->OwnerName,
                            'Dated' => $date52[0],
                        ]);

                    }
                }

                //Commericalmanagement

                $record7 = DB::connection('sqlsrv4')->select("select pb.Id , pb.File_Plot_Id,ff.Plot_Number  as file_plot_number, ff.Type, ff.Block_Name
  , pb.Module as UnitModule ,pb.Total_Amount as BookingAmount,
   po.Name as OwnerName , po.Ownership_DateTime
  from  File_Plot_Balance pb
  join Plots ff on   ff.Id= pb.File_Plot_Id  and pb.Module = 'CommercialManagement'
  join  Plot_Ownership po  on po.Plot_Id = pb.File_Plot_Id     and po.Ownership_Status = 'Owner'
  where pb.Booking_Date between '" . $start_date . "' AND DATEADD(s,-1,DATEADD(d,1,'" . $end_date . "'))");
                foreach ($record7 as $record71) {


                    $record_exists7 = DB::connection('sqlsrv3')->table('TempBookingTable')->where('Id', '=', $record71->Id)->exists();
                    if (!$record_exists7) {
                        $date72 = explode(" ", $record71->DateTime);
                        DB::connection('sqlsrv3')->table('TempBookingTable')->insert([
                            'Id' => $record71->Id,
                            'File_Plot_Id' => $record71->File_Plot_Id,
                            'file_plot_number' => $record71->file_plot_number,
                            'Type' => $record71->Type,
                            'Block_Name' => $record71->Block_Name,
                            'UnitModule' => $record71->UnitModule,
                            'BookingAmount' => $record71->BookingAmount,
                            'OwnerName' => $record71->OwnerName,
                            'Dated' => $dat72[0],
                        ]);

                    }
                }


                $arr = "Transfered Successfully";
                return request()->json(200, $arr);

            } else {
                $arr = "Could not find the MIS DB. Please check your Network Connection.";
                return request()->json(200, $arr);
            }
        } catch (\Exception $e) {
            $arr = "Could not find the MIS DB. Please check your Network Connection.";
            return request()->json(200, $arr);
        }
    }

//yasir
    public
    function count_requisitions_services()
    {

        $session = ac_c_session();
        $total = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where("RequisitionType", "=", "Services")->count();
        $approved = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 0)->where("RequisitionType", "=", "Services")->count();
        $pending = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->where("RequisitionType", "=", "Services")->count();
        $issued = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 1)->where("RequisitionType", "=", "Services")->count();

        $myJSON = array(
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
            'issued' => $issued,
        );
        return request()->json(200, $myJSON);
    }

    public
    function count_requisitions_assets()
    {

        $session = ac_c_session();
        $total = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where("RequisitionType", "=", "Assets")->count();
        $approved = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 0)->where("RequisitionType", "=", "Assets")->count();
        $pending = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->where("RequisitionType", "=", "Assets")->count();
        $issued = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 1)->where("RequisitionType", "=", "Assets")->count();

        $myJSON = array(
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
            'issued' => $issued,
        );
        return request()->json(200, $myJSON);
    }

    public
    function get_requisition(Request $request)
    {

        $dept = emp_department();

        $totalResult = $request->get("pages");
        $session = ac_c_session();
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($totalResult == 'All') {
                $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Session', $session)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Goods")->get();
                return request()->json(200, $find_config);
            } else {
                $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Session', $session)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Goods")->paginate($totalResult);
                return request()->json(200, $find_config);
            }
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {
                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', company_id())->where('Requisition.Session', $session)->where('Requisition.DepartmentName', 'like', $d1 . '%')->orWhere('Requisition.DepartmentName', 'like', $d2 . '%')->orWhere('Requisition.DepartmentName', 'like', $d3 . '%')->orWhere('Requisition.DepartmentName', 'like', $d4 . '%')->orWhere('Requisition.DepartmentName', 'like', $d5 . '%')->orWhere('Requisition.DepartmentName', 'like', $d6 . '%')->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Goods")->get();
                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', company_id())->where('Requisition.Session', $session)->where('Requisition.DepartmentName', 'like', $d1 . '%')->orWhere('Requisition.DepartmentName', 'like', $d2 . '%')->orWhere('Requisition.DepartmentName', 'like', $d3 . '%')->orWhere('Requisition.DepartmentName', 'like', $d4 . '%')->orWhere('Requisition.DepartmentName', 'like', $d5 . '%')->orWhere('Requisition.DepartmentName', 'like', $d6 . '%')->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Goods")->paginate($totalResult);
                    return request()->json(200, $find_config);
                }
            } else {
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.Session', $session)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Goods")->get();
                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.Session', $session)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Goods")->paginate($totalResult);
                    return request()->json(200, $find_config);
                }
            }
        }
    }

    public
    function count_requisitions()
    {

        $session = ac_c_session();
        $total = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where("RequisitionType", "=", "Goods")->count();
        $approved = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 0)->where("RequisitionType", "=", "Goods")->count();
        $pending = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->where("RequisitionType", "=", "Goods")->count();
        $issued = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 1)->where("RequisitionType", "=", "Goods")->count();
        $rejected = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Rejected')->where("RequisitionType", "=", "Goods")->count();

        $myJSON = array(
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
            'rejected' => $rejected,
            'issued' => $issued,
        );
        return request()->json(200, $myJSON);
    }

    public
    function searchbyreqid($id, $page)
    {

        if ($page == 'All') {
            $arr = DB::connection("sqlsrv3")->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where("Requisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Goods")->orwhere("DemandRequisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Goods")->get();
            return request()->json(200, $arr);
        } else {
            $arr = DB::connection("sqlsrv3")->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where("Requisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Goods")->orwhere("DemandRequisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Goods")->paginate($page);
            return request()->json(200, $arr);
        }
    }

    public
    function searchbyreqid_services($id, $page)
    {

        if ($page == 'All') {
            $arr = DB::connection("sqlsrv3")->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where("Requisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Services")->orwhere("DemandRequisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Services")->get();
            return request()->json(200, $arr);
        } else {

            $arr = DB::connection("sqlsrv3")->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where("Requisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Services")->orwhere("DemandRequisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Services")->paginate($page);
            return request()->json(200, $arr);
        }
    }

    public
    function searchbyreqid_assets($id, $page)
    {

        if ($page == 'All') {
            $arr = DB::connection("sqlsrv3")->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where("Requisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Assets")->orwhere("DemandRequisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Assets")->get();
            return request()->json(200, $arr);
        } else {

            $arr = DB::connection("sqlsrv3")->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where("Requisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Assets")->orwhere("DemandRequisition.RId", 'like', '%' . $id . '%')->where("Requisition.RequisitionType", "=", "Assets")->paginate($page);
            return request()->json(200, $arr);
        }
    }

    public
    function get_requisition_assets(Request $request)
    {

        $dept = emp_department();

        $totalResult = $request->get("pages");


        $session = ac_c_session();
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($totalResult == 'All') {
                $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Session', $session)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Assets")->get();
                return request()->json(200, $find_config);
            } else {
                $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Session', $session)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Assets")->paginate($totalResult);
                return request()->json(200, $find_config);
            }
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {
                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', company_id())->where('Requisition.Session', $session)->where('Requisition.DepartmentName', 'like', $d1 . '%')->orWhere('Requisition.DepartmentName', 'like', $d2 . '%')->orWhere('Requisition.DepartmentName', 'like', $d3 . '%')->orWhere('Requisition.DepartmentName', 'like', $d4 . '%')->orWhere('Requisition.DepartmentName', 'like', $d5 . '%')->orWhere('Requisition.DepartmentName', 'like', $d6 . '%')->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Assets")->get();
                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', company_id())->where('Requisition.Session', $session)->where('Requisition.DepartmentName', 'like', $d1 . '%')->orWhere('Requisition.DepartmentName', 'like', $d2 . '%')->orWhere('Requisition.DepartmentName', 'like', $d3 . '%')->orWhere('Requisition.DepartmentName', 'like', $d4 . '%')->orWhere('Requisition.DepartmentName', 'like', $d5 . '%')->orWhere('Requisition.DepartmentName', 'like', $d6 . '%')->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Assets")->paginate($totalResult);
                    return request()->json(200, $find_config);
                }
            } else {
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.Session', $session)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Assets")->get();
                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.Session', $session)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Assets")->paginate($totalResult);
                    return request()->json(200, $find_config);
                }
            }
        }
    }


    public
    function get_requisition_services(Request $request)
    {

        $dept = emp_department();

        $totalResult = $request->get("pages");
        $session = ac_c_session();
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($totalResult == 'All') {
                $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where("Requisition.RequisitionType", "=", "Services")->where("Requisition.RequisitionType", "=", "Services")->where('Requisition.Session', $session)->where('Requisition.CompanyID', '=', company_id())->orderby('Requisition.RequisitionId', 'desc')->get();
                return request()->json(200, $find_config);
            } else {
                $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where("Requisition.RequisitionType", "=", "Services")->where("Requisition.RequisitionType", "=", "Services")->where('Requisition.Session', $session)->where('Requisition.CompanyID', '=', company_id())->orderby('Requisition.RequisitionId', 'desc')->paginate($totalResult);
                return request()->json(200, $find_config);
            }
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {
                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', company_id())->where('Requisition.Session', $session)->where('Requisition.DepartmentName', 'like', $d1 . '%')->orWhere('Requisition.DepartmentName', 'like', $d2 . '%')->orWhere('Requisition.DepartmentName', 'like', $d3 . '%')->orWhere('Requisition.DepartmentName', 'like', $d4 . '%')->orWhere('Requisition.DepartmentName', 'like', $d5 . '%')->orWhere('Requisition.DepartmentName', 'like', $d6 . '%')->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Services")->get();
                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', company_id())->where('Requisition.Session', $session)->where('Requisition.DepartmentName', 'like', $d1 . '%')->orWhere('Requisition.DepartmentName', 'like', $d2 . '%')->orWhere('Requisition.DepartmentName', 'like', $d3 . '%')->orWhere('Requisition.DepartmentName', 'like', $d4 . '%')->orWhere('Requisition.DepartmentName', 'like', $d5 . '%')->orWhere('Requisition.DepartmentName', 'like', $d6 . '%')->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Services")->paginate($totalResult);
                    return request()->json(200, $find_config);
                }
            } else {
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.Session', $session)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Services")->get();
                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.Session', $session)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Services")->paginate($totalResult);
                    return request()->json(200, $find_config);
                }
            }
        }
    }

    public
    function fetch_req_byStatus($sts, $depts, $proj, $startdate, $closedate, $page)
    {

        $dept = emp_department();

        if ($sts == "All") {
            $sts = "";
        }
        if ($depts == "All") {
            $depts = "";
        }
        if ($proj == "All") {
            $proj = "";
        }
        $session = ac_c_session();
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($page == 'All') {
                $req = DB::connection('sqlsrv3')->table('Requisition')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->orderBy('Requisition.RequisitionId', 'desc')
                    // ->where('Requisition.Session', $session)
                    ->where('Requisition.DepartmentName', 'like', '%' . $depts . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Status', 'like', '%' . $sts . '%')->where("Requisition.RequisitionType", "=", "Goods")->get();
                return request()->json(200, $req);
            } else {
                $req = DB::connection('sqlsrv3')->table('Requisition')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->orderBy('Requisition.RequisitionId', 'desc')
                    // ->where('Requisition.Session', $session)
                    ->where('Requisition.DepartmentName', 'like', '%' . $depts . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Status', 'like', '%' . $sts . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where("Requisition.RequisitionType", "=", "Goods")->paginate($page);
                return request()->json(200, $req);
            }
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {
                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;

                if ($depts == $d1 || $depts == $d2 || $depts == $d3 || $depts == $d4 || $depts == $d5 || $depts == $d6) {
                    if ($page == 'All') {
                        $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', company_id())
                            // ->where('Requisition.Session', $session)
                            ->where('Requisition.DepartmentName', 'like', $depts . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.Status', 'like', '%' . $sts . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Goods")->get();
                        return request()->json(200, $find_config);
                    } else {
                        $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', company_id())
                            // ->where('Requisition.Session', $session)
                            ->where('Requisition.DepartmentName', 'like', $depts . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.Status', 'like', '%' . $sts . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Goods")->paginate($page);
                        return request()->json(200, $find_config);
                    }
                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }
            } else {
                if ($depts == $dept) {
                    if ($page == 'All') {

                        $req = DB::connection('sqlsrv3')->table('Requisition')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->orderBy('Requisition.RequisitionId', 'desc')->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Status', 'like', '%' . $sts . '%')->where("Requisition.RequisitionType", "=", "Goods")->get();
                        return request()->json(200, $req);
                    } else {

                        $req = DB::connection('sqlsrv3')->table('Requisition')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->orderBy('Requisition.RequisitionId', 'desc')->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Status', 'like', '%' . $sts . '%')->where("Requisition.RequisitionType", "=", "Goods")->paginate($page);
                        return request()->json(200, $req);
                    }
                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }
            }
        }
    }

    public
    function inv_reqCounter($status, $type)
    {

        $session = ac_c_session();
        if ($status == 'all') {
            $result = DB::connection('sqlsrv3')->select("select DepartmentName, count (DepartmentName) as TotalReqs
              from  Requisition er
                where CompanyID = 'company_id()' and RequisitionType = '$type'
               group by DepartmentName");
        } else {
            $result = DB::connection('sqlsrv3')->select("select DepartmentName, count (DepartmentName) as TotalReqs
              from  Requisition er
                where CompanyID = 'company_id()' and RequisitionType = '$type' and Status = '$status'
               group by DepartmentName");
        }
        return request()->json(200, $result);
    }

    public
    function accounts_fetch_reqBysts_services($sts, $depts, $proj, $startdate, $closedate, $page)
    {

        $dept = emp_department();

        if ($sts == "All") {
            $sts = "";
        }
        if ($depts == "All") {
            $depts = "";
        }
        if ($proj == "All") {
            $proj = "";
        }
        $session = ac_c_session();
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($page == 'All') {
                $req = DB::connection('sqlsrv3')->table('Requisition')->orderBy('RequisitionId', 'desc')
                    // ->where('Session', $session)
                    ->where('DepartmentName', 'like', '%' . $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where("RequisitionType", "=", "Services")->get();
                return request()->json(200, $req);
            } else {
                $req = DB::connection('sqlsrv3')->table('Requisition')->orderBy('RequisitionId', 'desc')
                    // ->where('Session', $session)
                    ->where('DepartmentName', 'like', '%' . $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where("RequisitionType", "=", "Services")->paginate($page);
                return request()->json(200, $req);
            }
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {
                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;

                if ($depts == $d1 || $depts == $d2 || $depts == $d3 || $depts == $d4 || $depts == $d5 || $depts == $d6) {
                    if ($page == 'All') {
                        $find_config = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', company_id())
                            // ->where('Session', $session)
                            ->where('DepartmentName', 'like', $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('Status', 'like', '%' . $sts . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Services")->get();
                        return request()->json(200, $find_config);
                    } else {
                        $find_config = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', company_id())
                            // ->where('Session', $session)
                            ->where('DepartmentName', 'like', $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('Status', 'like', '%' . $sts . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Services")->paginate($page);
                        return request()->json(200, $find_config);
                    }
                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }
            } else {
                if ($depts == $dept) {
                    if ($page == 'All') {

                        $req = DB::connection('sqlsrv3')->table('Requisition')->orderBy('RequisitionId', 'desc')->where('DepartmentName', '=', $dept)->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where("RequisitionType", "=", "Services")->get();
                        return request()->json(200, $req);
                    } else {

                        $req = DB::connection('sqlsrv3')->table('Requisition')->orderBy('RequisitionId', 'desc')->where('DepartmentName', '=', $dept)->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where("RequisitionType", "=", "Services")->paginate($page);
                        return request()->json(200, $req);
                    }
                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }
            }
        }
    }

    public
    function accounts_fetch_reqBysts_assets($sts, $depts, $proj, $startdate, $closedate, $page)
    {

        $dept = emp_department();

        if ($sts == "All") {
            $sts = "";
        }
        if ($depts == "All") {
            $depts = "";
        }
        if ($proj == "All") {
            $proj = "";
        }
        $session = ac_c_session();
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($page == 'All') {
                $req = DB::connection('sqlsrv3')->table('Requisition')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->orderBy('Requisition.RequisitionId', 'desc')
                    // ->where('Requisition.Session', $session)
                    ->where('Requisition.DepartmentName', 'like', '%' . $depts . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Status', 'like', '%' . $sts . '%')->where("Requisition.RequisitionType", "=", "Assets")->get();
                return request()->json(200, $req);
            } else {
                $req = DB::connection('sqlsrv3')->table('Requisition')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->orderBy('Requisition.RequisitionId', 'desc')
                    // ->where('Requisition.Session', $session)
                    ->where('Requisition.DepartmentName', 'like', '%' . $depts . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Status', 'like', '%' . $sts . '%')->where("Requisition.RequisitionType", "=", "Assets")->paginate($page);
                return request()->json(200, $req);
            }
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {
                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;

                if ($depts == $d1 || $depts == $d2 || $depts == $d3 || $depts == $d4 || $depts == $d5 || $depts == $d6) {
                    if ($page == 'All') {
                        $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', company_id())
                            // ->where('Requisition.Session', $session)
                            ->where('Requisition.DepartmentName', 'like', $depts . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.Status', 'like', '%' . $sts . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Assets")->get();
                        return request()->json(200, $find_config);
                    } else {
                        $find_config = DB::connection('sqlsrv3')->table("Requisition")->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->where('Requisition.CompanyID', company_id())
                            // ->where('Requisition.Session', $session)
                            ->where('Requisition.DepartmentName', 'like', $depts . '%')->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.Status', 'like', '%' . $sts . '%')->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->orderby('Requisition.RequisitionId', 'desc')->where("Requisition.RequisitionType", "=", "Assets")->paginate($page);
                        return request()->json(200, $find_config);
                    }
                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }
            } else {
                if ($depts == $dept) {
                    if ($page == 'All') {

                        $req = DB::connection('sqlsrv3')->table('Requisition')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->orderBy('Requisition.RequisitionId', 'desc')->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Status', 'like', '%' . $sts . '%')->where("Requisition.RequisitionType", "=", "Assets")->get();
                        return request()->json(200, $req);
                    } else {

                        $req = DB::connection('sqlsrv3')->table('Requisition')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('Requisition.*', 'DemandRequisition.RId as RId2')->orderBy('Requisition.RequisitionId', 'desc')->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.Dated', '>=', $startdate)->where('Requisition.Dated', '<=', $closedate)->where('Requisition.ProjectName', 'like', '%' . $proj . '%')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.Status', 'like', '%' . $sts . '%')->where("Requisition.RequisitionType", "=", "Assets")->paginate($page);
                        return request()->json(200, $req);
                    }
                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }
            }
        }
    }

    public
    function submit_deposit_status(Request $request)
    {
        $Emp_id = employee_id();
        $update_date = long_date();
        $chqId = $request->get("chqId");
        $id = $request->get("id");
        $d_status = $request->get('d_status');
        $d_reason = $request->get('d_reason');
        $result = DB::connection('sqlsrv3')->update("UPDATE UnitsChqDetail SET Status=?, DiscartReason=?,UpdatedBy=?,ProceedDate=? WHERE ChqID=? and ID=?", [$d_status, $d_reason, username(), $update_date, $chqId, $id]);
        if ($result) {
            $req = DB::connection('sqlsrv3')->table("UnitsChqDetail")->select('UnitsChqDetail.*')->where('ChqID', '=', $chqId)->get();
            foreach ($req as $req1) {

            }
            $rid = $req1->RId;
            $rid_id = explode("_", $rid);
            if (isLive()) {
                if ($rid_id[0] == 'R4') {
                    DB::connection('sqlsrv4')->update("UPDATE PropertyDeal_Receipts SET Status=?,Dishonored_Reason=? WHERE Id=?", ['Dishonored', $d_reason, $rid_id[1]]);
                } else if ($rid_id[0] == 'R2') {
                    DB::connection('sqlsrv4')->update("UPDATE SAM_Receipts SET Status=?,Dishonored_Reason=? WHERE Id=?", ['Dishonored', $d_reason, $rid_id[1]]);
                } else {
                    DB::connection('sqlsrv4')->update("UPDATE Cheque_DemandDraft_PayOrder SET Status=?,Dishonored_Reason=? WHERE ReceiptId=?", ['Dishonored', $d_reason, $rid_id[1]]);
                }

            }
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Updated Account Deposit Status if Discarted', 'the Status of | Receipt ID | ' . $req1->RId . ' | against Receipt No | ' . $req1->ReceiptNo . ' | Payment Type | ' . $req1->PaymentType . ' | Name | ' . $req1->Name . ' | Amount | ' . number_format($req1->Amount) . ' | Bank | ' . $req1->Bank . ' | has updated to Status | ' . $req1->Status . ' | having Discart Reason | ' . $req1->DiscartReason . ' ', $update_date]);
            $arr = 'Submitted';
            return request()->json(200, $arr);
        }
    }

//electricity
    public
    function Booking_electricity_Mis_to_sa_app($start_date)
    {


        $update_date = short_date();

        $start_da = explode("-", $start_date);


        try {
            DB::connection('sqlsrv4')->getPdo();
            if (DB::connection('sqlsrv4')->getDatabaseName()) {
                $record = DB::connection('sqlsrv4')->select("SELECT
    [Block] , [Plot_Type] , convert (date ,  [Month] ) AS Dated
      , sum ([Grand_Total]) as total
      , sum ([Net_Total]) as NetTotal
  FROM [SA_MIS].[dbo].[Electricity_Bill]
  where    DATEPART(year,[Month]) = '" . $start_da[0] . "' and  DATEPART(day,[Month]) = '01' and  DATEPART(month,[Month]) = '" . $start_da[1] . "'
  group by Block
   ,  [Plot_Type] , convert (date ,  [Month])");
                foreach ($record as $record1) {


                    DB::connection('sqlsrv3')->table('TempElectricityBooking')->insert([
                        'Block' => $record1->Block,
                        'Plot_Type' => $record1->Plot_Type,
                        'Total' => $record1->NetTotal,
                        'Dated' => $update_date,
                        'username' => username(),
                    ]);
                }


                $arr = "Transfered Successfully";
                return request()->json(200, $arr);
            } else {
                $arr = "Could not find the MIS DB. Please check your Network Connection.";
                return request()->json(200, $arr);
            }
        } catch (\Exception $e) {
            $arr = "Could not find the MIS DB. Please check your Network Connection1.";
            return request()->json(200, $arr);
        }
    }

    public
    function pending_electricity_detail()
    {
        $data = DB::connection('sqlsrv3')->table("TempElectricityBooking")->where('Status', '=', null)->orderby('EID', 'desc')->get();
        return request()->json(401, $data);
    }

    public
    function search_electricity_name($id)
    {

        $arr = DB::connection('sqlsrv3')->table('TempElectricityBooking')->where('Status', '=', null)->where('Block', 'like', '%' . $id . '%')->orderby('EID', 'desc')->get();
        return request()->json(200, $arr);
    }


    public
    function insert_servicebill(Request $request)
    {


        $session = ac_c_session();
        $service_name = $request->get('service_name');
        $unit = $request->get('unit');
        $quantity = $request->get('quantity');
        $rate = $request->get('rate');

        $detail = $request->get('detail');
        $date = $request->get('date'); //items
        $contractor_name = $request->get('contractor_name');
        $narration = $request->get('narration');

        $update_date = long_date();
        $service_name1 = explode("|", $service_name);

        $result = DB::connection('sqlsrv3')->insert('INSERT INTO ServiceBill(ContractorName, Dated, Status, CompanyID, Narration, CreatedBy, CreatedOn, Session) values (?,?,?,?,?,?,?,?)', [$contractor_name, $date, 'Pending', company_id(), $narration, username(), $update_date, $session]);
        if ($result) {
            $find_serbilid = DB::connection('sqlsrv3')->table("ServiceBill")->select('ServiceBillId')->where('CompanyID', '=', company_id())->get();
            foreach ($find_serbilid as $find_serbilid1) {
            }
            $service_name1 = explode("|", $service_name);
            for ($x = 1; $x < count($service_name1); $x++) {
                $service_nam = explode("|", $service_name);

                $uni = explode("|", $unit);
                $quantit = explode("|", $quantity);
                $rat = explode("|", $rate);

                $result1 = DB::connection('sqlsrv3')->insert('INSERT INTO ServiceBillItem(CompanyID, SBID, ServiceName, unit, Quantity, Rate) values (?,?,?,?,?,?)', [company_id(), $find_serbilid1->ServiceBillId, $service_nam[$x], $uni[$x], $quantit[$x], $rat[$x]]);
            }
            $find_config = "submitted";
            return request()->json(200, $find_config);
        }
    }


    public
    function get_serviceBill()
    {

        $session = ac_c_session();
        $find_config = DB::connection('sqlsrv3')->table("ServiceBill")->where('CompanyID', '=', company_id())->where('Session', $session)->orderby('ServiceBillId', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

//print Bill

    public
    function pending_debt_detail($dated)
    {

        $arr = DB::connection('sqlsrv3')->table('UnitsDebitCreditDetail')->where('Status', '=', null)->where('DateTime', '=', $dated)->orderby('Id', 'desc')->get();
        return request()->json(200, $arr);
    }

    public
    function get_counter_sum_debt($dated)
    {

        $cash_amount = DB::connection('sqlsrv3')->table('UnitsDebitCreditDetail')->where('Status', '=', null)->where('DateTime', '=', $dated)->sum('Amount');

        $myJSON = array(
            'cash' => $cash_amount,
        );
        return request()->json(200, $myJSON);
    }

    public
    function submit_unitdebt(Request $request)
    {


        $Emp_id = employee_id();
        $id = $request->get('id');


        $update_date = long_date();

        $check = $request->get('added');

        $id1 = explode("|", $id);

        for ($x = 1; $x < count($id1); $x++) {
            $id2 = explode("|", $id);
            $chec = explode("|", $check);

            if ($chec[$x] == 'true') {

                $save_ledger = DB::connection('sqlsrv3')->table('UnitsDebitCreditDetail')->where('DbtID', '=', $id2[$x])->get();
                foreach ($save_ledger as $save_ledger1) {


                    //start accounts
                    $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID2', '=', $save_ledger1->ID)->where('CompanyID', '=', company_id())->exists();
                    if (!$find_vendor_id) {
                        $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$save_ledger1->DateTime, $save_ledger1->ReceiptNo, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number, $save_ledger1->PaymentType, $update_date, username(), company_id()]);
                        if ($doc) {
                            $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->ReceiptNo)->get();
                            foreach ($find_doc_id as $find_doc_id1) {

                            }

                            $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $save_ledger1->DateTime, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number . 'Received From :' . $save_ledger1->Name, company_id()]);

                            $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                            foreach ($find_tran_id as $find_tran_id1) {

                            }
                            if ($save_ledger1->Text == 'SAM') {
                                $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', 'SAM')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            } elseif ($save_ledger1->Type == 'Installment' || $save_ledger1->Type == 'Booking') {
                                if ($save_ledger1->Plot_Type == 'Apartment') {
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Project . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                } else if ($save_ledger1->Block == 'Main G.T Road') {
                                    $blo = 'Main GT road';
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $blo . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                } else {
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                    //end dynamic types
                                }
                            } elseif ($save_ledger1->Type == 'ServiceCharges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Electricity_Charges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Transfer') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block transfer fee')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Subsidiary_Recovery' || $save_ledger1->Type == 'Receivable_Receipt') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Module . '-Recovery')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'New_Connection_Charges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block new connection charges')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } else {
                                $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', $save_ledger1->Type)->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            }
                            if ($find_acc_code1->ID == null) {
                                $message = "Account Head Not Linked";
                                return request()->json(401, $message);
                            } else {


                                $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID2,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'C', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);

                                $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID2,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, 101001002005004, 'D', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);
                            }

                        }
                    }
                    ///end accounts
                    DB::connection('sqlsrv3')->update('update UnitsDebitCreditDetail set Status=?,UpdatedBy=?,ProceedDate=? where DbtID=?', ['Proceed', username(), $update_date, $id2[$x]]);
                    $find_chq = DB::connection('sqlsrv3')->table("UnitsDebitCreditDetail")->where('DbtID', '=', $id2[$x])->get();
                    foreach ($find_chq as $find_chq1) {

                    }
                    $rid = $find_chq1->RId;
                    $rid_id = explode("_", $rid);
                    if (isLive()) {
                        $result = DB::connection('sqlsrv4')->update("UPDATE Cheque_DemandDraft_PayOrder SET Status=?,Clearance_Date=? WHERE ReceiptId=?", ['Approved', $update_date, $rid_id[1]]);
                    }
                } //for
                DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Unit credit/Debit Status Updated', 'Status of ' . $rid . ' | Name | ' . $find_chq1->Name . ' | Father Name | ' . $find_chq1->Father_Name . ' | amount | ' . number_format($find_chq1->Amount) . '  has been Updated to Approved ', $update_date]);


            }
        }

        $message = "submitted";
        return request()->json(401, $message);
    }

    public
    function pending_onlinecash_detail($dated, $bank_type)
    {
        if ($bank_type == 'All') {
            $arr = DB::connection('sqlsrv3')->table('UnitsOnlineCash')->where('Status', '=', null)->where('DateTime', '=', $dated)->orderby('Id', 'desc')->get();
            return request()->json(200, $arr);
        } else {
            $arr = DB::connection('sqlsrv3')->table('UnitsOnlineCash')->where('Status', '=', null)->where('DateTime', '=', $dated)->where('ReceiptNo', 'like', '%' . $bank_type . '%')->orderby('Id', 'desc')->get();
            return request()->json(200, $arr);
        }
    }

    public
    function get_counter_sum_online($dated, $bank_type)
    {
        if ($bank_type == 'All') {
            $cash_amount = DB::connection('sqlsrv3')->table('UnitsOnlineCash')->where('Status', '=', null)->where('DateTime', '=', $dated)->sum('Amount');

            $myJSON = array(
                'cash' => $cash_amount,
            );
            return request()->json(200, $myJSON);
        } else {
            $cash_amount = DB::connection('sqlsrv3')->table('UnitsOnlineCash')->where('Status', '=', null)->where('DateTime', '=', $dated)->where('ReceiptNo', 'like', '%' . $bank_type . '%')->sum('Amount');

            $myJSON = array(
                'cash' => $cash_amount,
            );
            return request()->json(200, $myJSON);
        }
    }

    public
    function submit_unitonlinecash(Request $request)
    {


        $Emp_id = employee_id();
        $id = $request->get('id');
        $deposit_bank = $request->get('deposit_bank');
        $deposit = explode("_", $deposit_bank);

        $update_date = long_date();

        $check = $request->get('added');
        $id1 = explode("|", $id);

        for ($x = 1; $x < count($id1); $x++) {
            $id2 = explode("|", $id);
            $chec = explode("|", $check);

            if ($chec[$x] == 'true') {

                $save_ledger = DB::connection('sqlsrv3')->table('UnitsOnlineCash')->where('OnlineID', '=', $id2[$x])->get();
                foreach ($save_ledger as $save_ledger1) {


                    //start accounts
                    $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID2', '=', $save_ledger1->ID)->where('CompanyID', '=', company_id())->exists();
                    if (!$find_vendor_id) {
                        $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$save_ledger1->DateTime, $save_ledger1->ReceiptNo, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number, $save_ledger1->PaymentType, $update_date, username(), company_id()]);
                        if ($doc) {
                            $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->ReceiptNo)->get();
                            foreach ($find_doc_id as $find_doc_id1) {

                            }

                            $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $save_ledger1->DateTime, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number . 'Received From :' . $save_ledger1->Name, company_id()]);
                            $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                            foreach ($find_tran_id as $find_tran_id1) {

                            }
                            if ($save_ledger1->Text == 'SAM') {
                                $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', 'SAM')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            } elseif ($save_ledger1->Type == 'Installment' || $save_ledger1->Type == 'Booking') {
                                if ($save_ledger1->Plot_Type == 'Apartment') {
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Project . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                } else if ($save_ledger1->Block == 'Main G.T Road') {
                                    $blo = 'Main GT road';
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $blo . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                } else {
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                    //end dynamic types
                                }
                            } elseif ($save_ledger1->Type == 'ServiceCharges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Electricity_Charges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Transfer') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block transfer fee')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Subsidiary_Recovery' || $save_ledger1->Type == 'Receivable_Receipt') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Module . '-Recovery')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'New_Connection_Charges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block new connection charges')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } else {
                                $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', $save_ledger1->Type)->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            }

                            if ($find_acc_code1->ID == null) {
                                $message = "Account Head Not Linked";
                                return request()->json(401, $message);
                            } else {


                                $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID2,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'C', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);

                                $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID2,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $deposit[0], 'D', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);
                            }

                        }
                    }
                    ///end accounts
                    DB::connection('sqlsrv3')->update('update UnitsOnlineCash set Status=?,UpdatedBy=?,ProceedDate=?,DepositedID=? where OnlineID=?', ['Proceed', username(), $update_date, $deposit[0], $id2[$x]]);
                    $find_chq = DB::connection('sqlsrv3')->table("UnitsOnlineCash")->where('OnlineID', '=', $id2[$x])->get();
                    foreach ($find_chq as $find_chq1) {

                    }
                    $rid = $find_chq1->RId;
                    $rid_id = explode("_", $rid);
                    if (isLive()) {
                        DB::connection('sqlsrv4')->update("UPDATE Cheque_DemandDraft_PayOrder SET Status=?,Clearance_Date=? WHERE ReceiptId=?", ['Approved', $update_date, $rid_id[1]]);
                    }
                } //for

                DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'Unit Online Cash Submitted', 'Status of ' . $rid . ' | Name | ' . $find_chq1->Name . ' | Father Name | ' . $find_chq1->Father_Name . ' | amount | ' . number_format($find_chq1->Amount) . '| has been Updated ', $update_date]);

            }
        }

        $message = "submitted";
        return request()->json(401, $message);
    }

    public
    function pending_sam_voucher_detail()
    {

        $arr = DB::connection('sqlsrv3')->table('TempPaymentTable')->where('status', '=', null)->orderby('Id', 'desc')->get();
        return request()->json(200, $arr);
    }

    public
    function ledger_report_balance2($ledger_name)
    {
        $company_id = '632462982ad6e';


        $created_on = short_date();

        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
      @Datefrom = N'2000-01-01',
      @DateTo = N'" . $created_on . "',
      @id = " . $ledger_name . ",
      @compid = N'" . $company_id . "'  ");

        return request()->json(200, $result);
    }


    public
    function fetch_receivable_head1()
    {

        $find_config = DB::connection('sqlsrv3')
            ->table('Accounts')
            ->select('ID', 'AccountName')
            ->where('CompanyID', '=', company_id())
            ->where('CoaType', '=', 'Transaction')
            ->where(function ($query) {
                $query->where('AccountCode', 'like', '101002%')
                    ->orWhere('AccountCode', 'like', '102003%')
                    ->orWhere('AccountCode', 'like', '5%')
                    ->orWhere('AccountCode', 'like', '4%')
                    ->orWhere('AccountCode', 'like', '2%')
                    ->orWhere('AccountCode', 'like', '3%');
            })
            ->orderBy('ID', 'asc')
            ->get();
        return request()->json(200, $find_config);
    }

    public
    function get_pdcreceivable_detail()
    {
        $result = DB::connection('sqlsrv3')->table('TempBankSales')->where("Status", '!=', 'Clearanced')->orderby("ID", "desc")->paginate(20);

        return request()->json(200, $result);
    }

    public
    function submit_pdcreceivedclearancedetails(Request $request)
    {
        $id = $request->get('id');
        $stat = $request->get('Deposit_Bank');
        $deposit_bank2 = $request->get('deposit_bank2');
        //$Deposit_Ban = explode("_", $Deposit_Bank);


        $update_date = long_date();
        $doc_date = short_date();

        $Clearance_Date = long_date();
        $status = 'Clearanced';
        if ($deposit_bank2 != '') {
            $bank = explode("_", $deposit_bank2);
            $result = DB::connection('sqlsrv3')->update("UPDATE TempBankSales SET ClearanceAccountID=?,ClearanceAccountName=?,Status=?,ClearanceDate=?,Clearanceby=? WHERE ID=?", [$bank[0], $bank[1], $stat, $Clearance_Date, username(), $id]);
        } else {
            $result = DB::connection('sqlsrv3')->update("UPDATE TempBankSales SET Status=?,ClearanceDate=?,Clearanceby=? WHERE ID=?", [$stat, $Clearance_Date, username(), $id]);
        }
        if ($stat == 'Clearanced') {
            if ($result) {
                $find_vendor = DB::connection('sqlsrv3')->table("TempBankSales")->where('ID', '=', $id)->get();
                foreach ($find_vendor as $find_vendor1) {

                }
                if ($find_vendor1->ChqAmount < 0) {
                    $find_config = 'Amount Cannot be Negative';
                    return request()->json(200, $find_config);
                }
                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $find_vendor1->RVID, 'Received From ' . $find_vendor1->VendorName . '/Through #' . $find_vendor1->RVID, 'Received Voucher', $update_date, username(), company_id()]);
                if ($doc) {
                    $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $find_vendor1->RVID)->get();
                    foreach ($find_doc_id as $find_doc_id1) {

                    }
                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Received From ' . $find_vendor1->VendorName . '/Through #' . $find_vendor1->RVID . '/with Chq number#' . $find_vendor1->ChqNo . '/with Chq date#' . $find_vendor1->ChqDate, company_id()]);

                    $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                    foreach ($find_tran_id as $find_tran_id1) {

                    }
                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_vendor1->VendorId, 'C', $find_vendor1->ChqAmount, company_id()]);

                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_vendor1->ClearanceAccountID, 'D', $find_vendor1->ChqAmount, company_id()]);
                }

            }
        }
        $find_config = 'Updated';
        return request()->json(200, $find_config);

    }

    public
    function getsinglepdcreceivable($id)
    {
        $result = DB::connection('sqlsrv3')->table('TempBankSales')->where('ID', '=', $id)->get();

        return request()->json(200, $result);
    }

    public
    function submit_received_voucher(Request $request)
    {

        $session = ac_c_session();


        $date = $request->get('date');
        $chq_date = $request->get('chq_date');
        $vendor_name = $request->get('vendor_name');

        $method_type = $request->get('method_type');
        $amount = $request->get('amount');
        $narration = $request->get('narration');
        $chq_number = $request->get('chq_number');
        $salesperson = $request->get('salesperson');
        $method = $request->get('method');
        $invoices = $request->get('invoices');
        $remaining_amount = $request->get('remaining_amount');
        $invoice_amount = $request->get('invoice_amount');
        $Bank_name = $request->get('Bank_name');
        if ($amount < 0) {
            $find_config = 'Amount Cannot be Negative';
            return request()->json(200, $find_config);
        }
        $find_prefix = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('ReceivedVoucher')->where('CompanyID', '=', company_id())->get();
        foreach ($find_prefix as $find_prefix1) {

        }
        $date_pref = $this->shiftformat();
        $req_prefix = $find_prefix1->ReceivedVoucher . '_' . $date_pref;

        $find_rid9 = DB::connection('sqlsrv3')->table("ReceivedVoucher")->where('CompanyID', '=', company_id())->exists();
        if ($find_rid9) {
            $find_rid = DB::connection('sqlsrv3')->table("ReceivedVoucher")->select('RVID')->where('CompanyID', '=', company_id())->get();
            foreach ($find_rid as $find_rid1) {

            }
            $pre_id = explode("-", $find_rid1->RVID);
            $rid = $pre_id[1] + 1;

        } else {
            $rid = 1;
        }
        $final_PoCode = $req_prefix . '-' . $rid;

        $update_date = long_date();
        $doc_date = short_date();
        $pay_against = explode("_", $vendor_name);
        $method_typ = explode("_", $method_type);

        $p_agnst = $request->get('p_agnst');
        $against_invoice = $request->get('against_invoice');

        $invoice9 = explode("|", $invoices);
        for ($y = 1; $y < count($invoice9); $y++) {
            $invoic = explode("|", $invoices);
            $remaining_amoun = explode("|", $remaining_amount);
            $invoice_amoun = explode("|", $invoice_amount);
            if ($remaining_amoun[$y] == '' || $invoice_amoun[$y] == '' || $invoic[$y] == '') {
                $find_config = 'Required Compulsory Fileds';
                return request()->json(200, $find_config);
            }
            if ($remaining_amoun[$y] < $invoice_amoun[$y]) {
                $find_config = 'Remaining Amount must be greater than Invoice Amount';
                return request()->json(200, $find_config);
            }
        }


        if ($p_agnst == 'mis') {
            if ($request->hasFile('image_file')) {
                $file = $request->file('image_file');
                $name_image = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/images/received_images/', $name_image);
                try {
                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO ReceivedVoucher(CompanyID,RVID,VoucherDate,AccountID,PaymentAgainst,InvoiceNumber,Amount,MethodType,MethodAccountID,Naration,SalesPerson,CreatedBy,CreatedOn,Session,ChqDate,ChqNumber,Status,InstrumentBank,Photo,Method) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $final_PoCode, $date, $pay_against[0], $pay_against[1], $against_invoice, $amount, $method_typ[1], $method_typ[0], $narration, $salesperson, username(), $update_date, $session, $chq_date, $chq_number, 'Not Verified', $Bank_name, $name_image, $method]);
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->getCode() == 23000) {
                        return response()->json(['message' => 'Recieved Voucher Already Exists.'], 422);
                    } else {
                        throw $e;
                    }
                }


            } else {
                $result = DB::connection('sqlsrv3')->insert('INSERT INTO ReceivedVoucher(CompanyID,RVID,VoucherDate,AccountID,PaymentAgainst,InvoiceNumber,Amount,MethodType,MethodAccountID,Naration,SalesPerson,CreatedBy,CreatedOn,Session,ChqDate,ChqNumber,Status,InstrumentBank,Method) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $final_PoCode, $date, $pay_against[0], $pay_against[1], $against_invoice, $amount, $method_typ[1], $method_typ[0], $narration, $salesperson, username(), $update_date, $session, $chq_date, $chq_number, 'Not Verified', $Bank_name, $method]);
            }

            if ($result) {
                $find_pv = DB::connection('sqlsrv3')->table("ReceivedVoucher")->where('CompanyID', '=', company_id())->where('RVID', '=', $final_PoCode)->get();
                foreach ($find_pv as $find_pv1) {

                }

                DB::connection('sqlsrv3')->insert('INSERT INTO ReceivedVoucherDetail(CompanyID,RID,Date,AgainstPO,AgainstINV,Amount,RVNO,Remaining) values (?,?,?,?,?,?,?,?)', [company_id(), $find_pv1->ReceivedVoucherID, $find_pv1->VoucherDate, $against_invoice, '', $amount, $find_pv1->RVID, '']);

            }
        } else if ($p_agnst == 'po_') {
            $invoices1 = explode("|", $invoices);
            for ($x = 1; $x < count($invoices1); $x++) {
                $invoic = explode("|", $invoices);
                $check_pvdetail = DB:: connection('sqlsrv3')->table('ReceivedVoucherDetail')->select('Remaining')->where('AgainstPO', '=', $invoic[$x])->orderBy('Date', 'desc')->orderBy('DetailID', 'desc')->first();
                // if ($check_pvdetail) {
                //     if ($check_pvdetail->Remaining == 0) {
                //         $find_config = 'The amount against invoice ' . $invoic[$x] . ' is fully Received';
                //         return request()->json(200, $find_config);
                //     }
                // }
            }
            $theRest = substr($invoices, 5);
            try {
                $result = DB::connection('sqlsrv3')->insert('INSERT INTO ReceivedVoucher(CompanyID,RVID,VoucherDate,AccountID,PaymentAgainst,InvoiceNumber,Amount,MethodType,MethodAccountID,Naration,CreatedBy,CreatedOn,Session,ChqDate,ChqNumber,Status) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $final_PoCode, $date, $pay_against[0], $pay_against[1], $theRest, $amount, $method_typ[1], $method_typ[0], $narration, username(), $update_date, $session, $chq_date, $chq_number, 'Not Verified']);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == 23000) {
                    return response()->json(['message' => 'Receipt Voucher Already Exists.'], 422);

                } else {
                    throw $e;
                }
            }


            if ($result) {
                if ($result) {
                    $find_pv = DB::connection('sqlsrv3')->table("ReceivedVoucher")->where('CompanyID', '=', company_id())->where('RVID', '=', $final_PoCode)->get();
                    foreach ($find_pv as $find_pv1) {

                    }

                    $invoices1 = explode("|", $invoices);
                    for ($x = 1; $x < count($invoices1); $x++) {
                        $invoic = explode("|", $invoices);
                        $remaining_amoun = explode("|", $remaining_amount);
                        $invoice_amoun = explode("|", $invoice_amount);
                        $find_pv_security = DB::connection('sqlsrv3')->table("PaymentVoucher")->where('CompanyID', '=', company_id())->where('AccountID', '=', $pay_against[0])->where('PaymentAgainst', '=', $pay_against[1])->exists();
                        if ($find_pv_security) {
                            $find_pv_pv1 = DB::connection('sqlsrv3')->table("PaymentVoucher")->where('CompanyID', '=', company_id())->where('AccountID', '=', $pay_against[0])->where('PaymentAgainst', '=', $pay_against[1])->orderBy('PaymentVoucherID', 'desc')->first();

                            $pv_security = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', company_id())->orderBy('DetailID', 'DESC')->where('AgainstPO', '=', $invoic[$x])->exists();
                            if ($pv_security) {
                                $find_pvitems1 = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', company_id())->orderBy('DetailID', 'DESC')->where('AgainstPO', '=', $invoic[$x])->first();

                                DB::connection('sqlsrv3')->insert('INSERT INTO PaymentVoucherDetail(CompanyID,Remaining,Amount,AgainstPO,AgainstINV,Date,PVNO) values (?,?,?,?,?,?,?)', [company_id(), $find_pvitems1->Remaining + $invoice_amoun[$x], $invoice_amoun[$x], $invoic[$x], $find_pvitems1->AgainstINV, $date, $final_PoCode]);


                            }
                            DB::connection('sqlsrv3')->insert('INSERT INTO ReceivedVoucherDetail(CompanyID,RID,Date,AgainstPO,AgainstINV,Amount,RVNO,Remaining) values (?,?,?,?,?,?,?,?)', [company_id(), $find_pv1->ReceivedVoucherID, $find_pv1->VoucherDate, $invoic[$x], '', $invoice_amoun[$x], $find_pv1->RVID, '']);


                        } else {
                            $find_config = 'Payment Voucher does not exist';
                            return request()->json(200, $find_config);
                        }

                    }
                }
            }
        }
        $find_pv = DB::connection('sqlsrv3')->table("ReceivedVoucher")->select('ReceivedVoucherID')->where('CompanyID', '=', company_id())->where('RVID', '=', $final_PoCode)->get();
        foreach ($find_pv as $find_pv1) {

        }

        $update_date = long_date();
        $doc_date = short_date();

        $result1 = DB::connection('sqlsrv3')->update('update ReceivedVoucher set Status=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and ReceivedVoucherID=?', ['Approved', username(), $update_date, company_id(), $find_pv1->ReceivedVoucherID]);
        if ($result1) {

            $find_detail = DB::connection('sqlsrv3')->table("ReceivedVoucher")->where('CompanyID', '=', company_id())->where('ReceivedVoucherID', '=', $find_pv1->ReceivedVoucherID)->get();
            foreach ($find_detail as $find_detail1) {

            }
            $final_PoCode0 = $find_detail1->RVID;
            $vendor_name0 = $find_detail1->PaymentAgainst;
            $against_invoice0 = $find_detail1->InvoiceNumber;
            $narration0 = $find_detail1->Naration;

            $method_type0 = $find_detail1->MethodType;
            $chq_date0 = $find_detail1->ChqDate;
            $chq_number0 = $find_detail1->ChqNumber;
            $pay_against0 = $find_detail1->AccountID;
            $amount0 = $find_detail1->Amount;
            $method_typ0 = $find_detail1->MethodAccountID;

            if ($method_type == '101001001001_Cash in Hand') {
                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode0, 'Received From ' . $vendor_name0 . '/Invoice #' . $against_invoice0 . '/' . $narration0, 'Received Voucher', $update_date, username(), company_id()]);

                if ($doc) {
                    $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode0)->get();
                    foreach ($find_doc_id as $find_doc_id1) {

                    }
                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Payment To ' . $vendor_name0 . ' Through ' . $method_type0 . ' Chq Date:' . $chq_date0 . '/' . $chq_number0 . '/' . $narration0 . '/ Against ' . $against_invoice0, company_id()]);

                    $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                    foreach ($find_tran_id as $find_tran_id1) {

                    }
                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $pay_against0, 'C', $amount0, company_id()]);

                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $method_typ0, 'D', $amount0, company_id()]);
                }
            } else {
                $status2 = 'Chq Paid';

                DB::connection('sqlsrv3')->insert('INSERT INTO TempBankSales(RVID,VendorId,VendorName,ChqNo,ChqDate,ChqAmount,ClearanceAccountID,ClearanceAccountName,Status,InstrumentBank,Method) values (?,?,?,?,?,?,?,?,?,?,?)', [$final_PoCode, $pay_against[0], $pay_against[1], $chq_number, $chq_date, $amount, $method_typ[0], $method_typ[1], $status2, $Bank_name, $method]);

            }


        }
        $find_config = 'submitted';
        return request()->json(200, $find_config);
    }

    public
    function update_pdc_chq_detail(Request $request)
    {
        $pdc_id = $request->get('pdc_id');
        $chq_date = $request->get('chq_date');
        $chq_number = $request->get('chq_number');
        $result = DB::connection('sqlsrv3')->update('update TempBank set ChqNo=?,ChqDate=? where ID=?', [$chq_number, $chq_date, $pdc_id]);
        if ($result) {
            $message = "updated";
            return request()->json(200, $message);
        }
    }

    public
    function pending_onlinecash_adjust($dated, $bank_type)
    {
        if ($bank_type == 'All') {
            $arr = DB::connection('sqlsrv3')->table('UnitsAdjustOnlineCash')->where('Status', '=', null)->where('DateTime', '=', $dated)->orderby('Id', 'desc')->get();
            return request()->json(200, $arr);
        } else {
            $arr = DB::connection('sqlsrv3')->table('UnitsAdjustOnlineCash')->where('Status', '=', null)->where('DateTime', '=', $dated)->where('ReceiptNo', 'like', '%' . $bank_type . '%')->orderby('Id', 'desc')->get();
            return request()->json(200, $arr);
        }
    }

    public
    function submit_unitonlinecash_adjust(Request $request)
    {

        $id = $request->get('id');
        $deposit_bank = $request->get('deposit_bank');
        $deposit = explode("_", $deposit_bank);

        $update_date = long_date();

        $check = $request->get('added');
        $id1 = explode("|", $id);

        for ($x = 1; $x < count($id1); $x++) {
            $id2 = explode("|", $id);
            $chec = explode("|", $check);

            if ($chec[$x] == 'true') {

                $save_ledger = DB::connection('sqlsrv3')->table('UnitsAdjustOnlineCash')->where('AdjustID', '=', $id2[$x])->get();
                foreach ($save_ledger as $save_ledger1) {


                    //start accounts
                    $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID2', '=', $save_ledger1->ID)->where('CompanyID', '=', company_id())->exists();
                    if (!$find_vendor_id) {
                        $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$save_ledger1->DateTime, $save_ledger1->ReceiptNo, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number, $save_ledger1->PaymentType, $update_date, username(), company_id()]);
                        if ($doc) {
                            $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->ReceiptNo)->get();
                            foreach ($find_doc_id as $find_doc_id1) {

                            }

                            $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $save_ledger1->DateTime, $save_ledger1->Type . ' Against File Plot ID:' . $save_ledger1->File_Plot_Number . 'Received From :' . $save_ledger1->Name, company_id()]);
                            $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                            foreach ($find_tran_id as $find_tran_id1) {

                            }
                            if ($save_ledger1->Text == 'SAM') {
                                $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', 'SAM')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            } elseif ($save_ledger1->Type == 'Installment' || $save_ledger1->Type == 'Booking') {
                                if ($save_ledger1->Plot_Type == 'Apartment') {
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Project . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                } else {
                                    $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->get();
                                    foreach ($find_acc_code as $find_acc_code1) {

                                    }
                                    //end dynamic types
                                }
                            } elseif ($save_ledger1->Type == 'ServiceCharges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Electricity_Charges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block service charges Receivables')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'New_Connection_Charges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block new connection charges')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Transfer') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block transfer fee')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'Subsidiary_Recovery' || $save_ledger1->Type == 'Receivable_Receipt') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Module . '-Recovery')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } elseif ($save_ledger1->Type == 'New_Connection_Charges') {
                                //dynamic types
                                $find_acc_code = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' block new connection charges')->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                                //end dynamic types
                            } else {
                                $find_acc_code = DB::connection('sqlsrv3')->table("TypesLinkCoa")->select('CoaID as ID')->where('TypeName', '=', $save_ledger1->Type)->get();
                                foreach ($find_acc_code as $find_acc_code1) {

                                }
                            }


                            $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID2,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'C', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);

                            $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID2,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $deposit[0], 'D', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);
                        }
                    }
                    ///end accounts
                    DB::connection('sqlsrv3')->update('update UnitsAdjustOnlineCash set Status=?,UpdatedBy=?,ProceedDate=?,DepositedID=? where AdjustID=?', ['Proceed', username(), $update_date, $deposit[0], $id2[$x]]);

                    $find_chq = DB::connection('sqlsrv3')->table("UnitsAdjustOnlineCash")->where('AdjustID', '=', $id2[$x])->get();
                    foreach ($find_chq as $find_chq1) {

                    }
                    $rid = $find_chq1->RId;
                    $rid_id = explode("_", $rid);
                    if (isLive()) {
                        DB::connection('sqlsrv4')->update("UPDATE Cheque_DemandDraft_PayOrder SET Status=?,Clearance_Date=? WHERE ReceiptId=?", ['Approved', $update_date, $rid_id[1]]);
                    }
                } //for
            }
        }
        $message = "submitted";
        return request()->json(401, $message);
    }

    public
    function search_unitrefund_date($from, $to)
    {
        $find_config = DB::connection('sqlsrv3')->select("select * from TempCancellation_Receipts
    where DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $from . "' and '" . $to . "'");
        return request()->json(200, $find_config);
    }

    public
    function units_fund_detail()
    {
        $find_config = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->orderBy('ReceiptNo', 'asc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function single_units_refund($id)
    {
        $find_config_check = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $id)->where('Receipt_Type', '!=', 'Repurchased')->exists();
        if ($find_config_check) {
            $find_config = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $id)->get();
            return request()->json(200, $find_config);
        } else {
            $find_config = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->leftjoin('UnitDiscounts', 'UnitDiscounts.Module_Id', '=', 'TempCancellation_Receipts.File_Plot_No')->where('TempCancellation_Receipts.ID', '=', $id)
                // ->where('TempCancellation_Receipts.Module','=','UnitDiscounts.Module')
                ->select('TempCancellation_Receipts.*', 'UnitDiscounts.Discount_Amount')->get();
            return request()->json(200, $find_config);
        }

    }

    public
    function update_units_refund_amount(Request $request)
    {
        $id = $request->get("pv_id");
        $status = $request->get('sts');


        $update_date = long_date();
        $doc_date = short_date();


        $check_sec = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $id)->exists();
        if ($check_sec) {
            $save_ledger1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $id)->orderBy('ID', 'DESC')->first();


            //start accounts
            $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID7', '=', $save_ledger1->ID)->where('CompanyID', '=', company_id())->exists();
            if (!$find_vendor_id) {
                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $save_ledger1->ReceiptNo, 'Units Refund of Plot No:' . $save_ledger1->File_Plot_Number . ' Block No:' . $save_ledger1->Block . ' file refund due to Exceed Amount', $save_ledger1->Receipt_Type, $update_date, username(), company_id()]);
                if ($doc) {
                    $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->ReceiptNo)->orderBy('ID', 'DESC')->first();


                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Units Refund of Plot No:' . $save_ledger1->File_Plot_Number . ' Block No:' . $save_ledger1->Block . ' file refund due to Exceed Amount', company_id()]);
                    $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();


                    if ($save_ledger1->Plot_Type == 'Apartment') {
                        $find_acc_code1 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Project . ' Receivables')->orderBy('ID', 'DESC')->first();

                    } else if ($save_ledger1->Block == 'Main G.T Road') {
                        $blo = 'Main GT road';
                        $find_acc_code1 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $blo . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->orderBy('ID', 'DESC')->first();

                    } else {
                        $find_acc_code1 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->orderBy('ID', 'DESC')->first();

                        //end dynamic types
                    }

                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'D', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);

                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, '201001006', 'C', $save_ledger1->Amount, $save_ledger1->ID, company_id()]);
                    DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set RemainingAmount=? where ID=?', [round($save_ledger1->Amount), $id]);


                }
            }
            $result1 = DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set Status=?,UpdatedBy=? where ID=?', [$status, username(), $id]);
        }


        $result = 'Status updated!';
        return request()->json(200, $result);
    }

    public
    function update_units_refund(Request $request)
    {
        $id = $request->get("pv_id");
        $status = $request->get('sts');


        $update_date = long_date();
        $doc_date = short_date();


        $check_sec = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $id)->orderBy('ID', 'DESC')->exists();
        if ($check_sec) {
            $save_ledger1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $id)->orderBy('ID', 'DESC')->first();

            //start accounts
            $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID7', '=', $save_ledger1->ID)->where('CompanyID', '=', company_id())->exists();
            if (!$find_vendor_id) {
                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $save_ledger1->ReceiptNo, 'Units Cancellation of Plot No:' . $save_ledger1->File_Plot_Number . 'Block No:' . $save_ledger1->Block . '-' . $save_ledger1->Plot_Type . ' file cancel due to not payment with ' . $save_ledger1->Deduction . '% deduction', $save_ledger1->Receipt_Type, $update_date, username(), company_id()]);
                if ($doc) {
                    $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->ReceiptNo)->orderBy('ID', 'DESC')->first();


                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Units Cancellation of Plot No:' . $save_ledger1->File_Plot_Number . 'Block No:' . $save_ledger1->Block . '-' . $save_ledger1->Plot_Type . ' file cancel due to not payment with ' . $save_ledger1->Deduction . '% deduction', company_id()]);
                    $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                    foreach ($find_tran_id as $find_tran_id1) {

                    }

                    if ($save_ledger1->Block == 'SA Premium Homes' || $save_ledger1->Block == 'Premium Homes' || $save_ledger1->Block == 'Ayaan Center' || $save_ledger1->Block == 'Faisal Height') {
                        $find_acc_code91 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' Sales')->orderBy('ID', 'DESC')->first();

                    } else {
                        $find_acc_code91 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Income')->where('AccountName', '=', $save_ledger1->Block . ' Block ' . $save_ledger1->Plot_Type . ' Sales')->orderBy('ID', 'DESC')->first();

                    }
                    if ($save_ledger1->Block == 'SA Premium Homes' || $save_ledger1->Block == 'Premium Homes' || $save_ledger1->Block == 'Ayaan Center' || $save_ledger1->Block == 'Faisal Height') {
                        $find_acc_code1 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Receivables')->orderBy('ID', 'DESC')->first();

                        //end dynamic types
                    } else {
                        $find_acc_code1 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->orderBy('ID', 'DESC')->first();

                        //end dynamic types
                    }
                    $instrument_amount = round($save_ledger1->Amount - $save_ledger1->Deduction_Amt);
                    $receivable_amount = round($save_ledger1->Plot_Total_Amount - $save_ledger1->Amount);
                    $other_recovery_amount = round($save_ledger1->Deduction_Amt);
                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->ID, 'D', round($save_ledger1->Plot_Total_Amount), $save_ledger1->ID, company_id()]);
                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'C', $receivable_amount, $save_ledger1->ID, company_id()]);

                    $ledger_entry3 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, '201001007', 'C', $instrument_amount, $save_ledger1->ID, company_id()]);

                    $ledger_entry4 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, '402007', 'C', $other_recovery_amount, $save_ledger1->ID, company_id()]);

                    DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set RemainingAmount=? where ID=?', [round($instrument_amount), $id]);


                }
            }

            $result1 = DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set Status=?,UpdatedBy=? where ID=?', [$status, username(), $id]);

        }


        $result = 'Status updated!';
        return request()->json(200, $result);
    }

    public
    function get_comparative_report($id)
    {
        $check = DB::connection('sqlsrv3')->table('RequisitionItem')->where('ReqID', '=', $id)->exists();
        $i = $j = $totalQuantity = $totalUnitPrice = $totalAmount = 0;
        $k = '';
        $myrr = [];
        if ($check) {
            $getIssu = DB::connection('sqlsrv3')->table('PQuotation')->where('CompanyID', '=', company_id())->where('RequisitionID', '=', $id)->select('QuotationID', 'VendorName')->get();
            $items = DB::connection('sqlsrv3')->table('RequisitionItem')->where('ReqID', '=', $id)->get();

            $m = ' <thead>
    <tr>
    <th scope="col"></th>
    ';
            $k = $k . '' . $m;
            foreach ($getIssu as $getIssu1) {
                $i = $i + 1;

                $b[$i] = '
      <th scope="col" style="text-align:center; border:1px solid darkgray">' . $getIssu1->VendorName . '</th>
    ';
                $k = $k . '' . $b[$i];
                array_push($myrr, $getIssu1->QuotationID);
            }
            $m = ' </thead>
    </tr> <tbody>';
            $k = $k . '' . $m;

            foreach ($items as $items1) {

                $b[$j] = '

      <tr>
      <td class="td-center" style="border:1px solid darkgray">' . $items1->ItemName . '</td>';
                $k = $k . '' . $b[$j];

                for ($y = 0; $y < count($myrr); $y++) {
                    $items_quot = DB::connection('sqlsrv3')->table('PQuotationItems')->where('QuotationID', '=', $myrr[$y])->where('ItemId', '=', $items1->itemId)->select('ItemId', 'Quantity', 'Price', 'Total')->get();
                    $items_quot_check = DB::connection('sqlsrv3')->table('PQuotationItems')->where('QuotationID', '=', $myrr[$y])->where('ItemId', '=', $items1->itemId)->exists();


                    if ($items_quot_check) {
                        foreach ($items_quot as $items_quot1) {

                            $totalQuantity += $items_quot1->Quantity;
                            $totalUnitPrice += $items_quot1->Price;
                            $totalAmount += $items_quot1->Total;
                            $j += 1;
                            $b[$j] = '
        <td style="border:1px solid darkgray; padding:0px !important">
        <table class="table" border="1" style="margin-bottom: 0px !important">
    <thead >
      <tr >
        <th class="td-center" style="background-color: white !important;border:1px solid darkgray">Quantity</th>
        <th class="td-center" style="background-color: white !important;border:1px solid darkgray">Unit Price</th>
        <th class="td-center" style="background-color: white !important;border:1px solid darkgray">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="td-center" style="border:1px solid darkgray">' . number_format($items_quot1->Price) . '</td>
        <td class="td-center" style="border:1px solid darkgray">' . number_format($items_quot1->Quantity) . '</td>
        <td class="td-center" style="border:1px solid darkgray">' . number_format($items_quot1->Total) . '</td>
      </tr>
    </tbody>
  </table>
        </td>

        ';
                            $k = $k . '' . $b[$j];

                        }
                    } else {
                        $t = '<td style="border:1px solid darkgray"></td>';
                        $k = $k . '' . $t;
                    }
                }

                $r = '</tr>
    </tbody>';
                $k = $k . '' . $r;
            }
        }
        return request()->json(200, $k);

    }

    public
    function search_refund_byname(Request $request)
    {
        $arr = DB::connection('sqlsrv3')->table('TempCancellation_Receipts')->where('Name', 'like', '%' . $request->keyword1 . '%')->orwhere('File_Plot_Number', 'like', '%' . $request->keyword1 . '%')->orwhere('ReceiptNo', 'like', '%' . $request->keyword1 . '%')->orderby('ReceiptNo', 'asc')->paginate(20);
        return request()->json(200, $arr);
    }


    public
    function search_units_cash_date($datefrom, $dateto, $type, $user)
    {

        if ($user == 'All') {
            if ($type == 'Both') {

                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '>=', $datefrom)->where('DateTime', '<=', $dateto)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else if ($type == 'Cash') {
                $type == 'Cash';
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '>=', $datefrom)->where('DateTime', '<=', $dateto)->where('PaymentType', '=', 'Cash')->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else {
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '>=', $datefrom)->where('DateTime', '<=', $dateto)->where('PaymentType', '!=', 'Cash')->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            }
        } else {
            if ($type == 'Both') {

                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '>=', $datefrom)->where('DateTime', '<=', $dateto)->where('Userid', '=', $user)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else if ($type == 'Cash') {
                $type == 'Cash';
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '>=', $datefrom)->where('DateTime', '<=', $dateto)->where('PaymentType', '=', 'Cash')->where('Userid', '=', $user)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            } else {
                $data = DB::connection('sqlsrv3')->table("TempReceiptTable")->where('DateTime', '>=', $datefrom)->where('DateTime', '<=', $dateto)->where('PaymentType', '!=', 'Cash')->where('Userid', '=', $user)->orderby('ID', 'desc')->get();
                return request()->json(401, $data);
            }
        }
    }

    public
    function get_counter_sum_datewise($datefrom, $dateto, $type, $id)
    {
        if ($id == 'All') {
            $id = '';
        }
        if ($type == 'Both') {
            $type = '';
        }


        $total = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('DateTime', '>=', $datefrom)->where('DateTime', '<=', $dateto)->where('Userid', 'like', '%' . $id . '%')->sum('Amount');
        $cash_amount = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('Userid', 'like', '%' . $id . '%')->where('PaymentType', '=', 'Cash')->where('DateTime', '>=', $datefrom)->where('DateTime', '<=', $dateto)->sum('Amount');
        $chq_amount = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('Userid', 'like', '%' . $id . '%')->where('PaymentType', '!=', 'Cash')->where('DateTime', '>=', $datefrom)->where('DateTime', '<=', $dateto)->sum('Amount');
        $myJSON = array(
            'total' => $total,
            'cash' => $cash_amount,
            'chq' => $chq_amount,
        );
        return request()->json(200, $myJSON);
    }

    public
    function session_detail1()
    {

        $arr = DB::connection('sqlsrv3')->table("Session")->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        return request()->json(200, $arr);
    }

    public
    function getgrndate_byasset($id)
    {


        $arr = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', company_id())->where('GrnID', '=', $id)->select('Dated')->get();
        return request()->json(200, $arr);
    }

    public
    function depreciated_assets_bookdetails()
    {
        $check = DB::connection('sqlsrv3')->table('DepreciationAssets')->join('Assets', 'Assets.AssetsUniqueID', '=', 'DepreciationAssets.AssetID')->join('ItemList', 'ItemList.ID', '=', 'Assets.AssetID')->where('Assets.AssetType', '=', 1)->orderby('DepreciationAssets.ID', 'desc')->select('DepreciationAssets.*', 'ItemList.Name')->paginate(20);
        return request()->json(200, $check);
    }

    public
    function search_assets_bookbyname(Request $request)
    {
        $check = DB::connection('sqlsrv3')->table('DepreciationAssets')->join('Assets', 'Assets.AssetsUniqueID', '=', 'DepreciationAssets.AssetID')->join('ItemList', 'ItemList.ID', '=', 'Assets.AssetID')->where('ItemList.Name', 'like', '%' . $request->keyword1 . '%')->where('Assets.AssetType', '=', 1)->orderby('DepreciationAssets.ID', 'desc')->select('DepreciationAssets.*', 'ItemList.Name')->paginate(20);

        return request()->json(200, $check);
    }

    public
    function pending_booking_sum()
    {
        $data = DB::connection('sqlsrv3')->table("TempBookingTable")->where('Supervision', '=', null)->orderby('BID', 'desc')->sum('BookingAmount');
        return request()->json(401, $data);
    }

    public
    function pending_Services_sum()
    {
        $data = DB::connection('sqlsrv3')->table("TempServicesBooking")->orderby('SRID', 'desc')->sum('Total');
        return request()->json(401, $data);
    }

    public
    function pending_Electricity_sum()
    {
        $data = DB::connection('sqlsrv3')->table("TempElectricityBooking")->orderby('EID', 'desc')->sum('Total');
        return request()->json(401, $data);
    }

    public
    function search_assetsbyname(Request $request)
    {

        $arr = DB::connection('sqlsrv3')->table('Assets')->join('ItemList', 'ItemList.ID', '=', 'Assets.AssetID')->join('ItemCategory', 'ItemCategory.ID', '=', 'ItemList.ItemCategory')->where('Assets.CompanyID', '=', company_id())->where('Assets.AssetType', '=', 1)->where('ItemList.Name', 'like', '%' . $request->keyword1 . '%')->orderby('Assets.EstLife', 'desc')->select('Assets.*', 'ItemCategory.ID as Category_id', 'ItemCategory.CategoryName', 'ItemList.ItemCode', 'ItemList.Name')->get();

        return request()->json(200, $arr);
    }

    public
    function fetch_assets_depreciation()
    {

        $arr = DB::connection('sqlsrv3')->table('Assets')->join('ItemList', 'ItemList.ID', '=', 'Assets.AssetID')->join('ItemCategory', 'ItemCategory.ID', '=', 'ItemList.ItemCategory')->where('Assets.AssetType', '=', 1)->where('Assets.CompanyID', '=', company_id())->orderby('Assets.EstLife', 'desc')->select('Assets.*', 'ItemCategory.ID as Category_id', 'ItemCategory.CategoryName', 'ItemList.ItemCode', 'ItemList.Name')->get();
        return request()->json(200, $arr);
    }

    public
    function single_depreciationasset($id)
    {

        $arr = DB::connection('sqlsrv3')->table('Assets')->join('ItemList', 'ItemList.ID', '=', 'Assets.AssetID')->join('ItemCategory', 'ItemCategory.ID', '=', 'ItemList.ItemCategory')->where('Assets.CompanyID', '=', company_id())->where('Assets.EstLife', '=', $id)->orderby('Assets.ID', 'desc')->select('Assets.*', 'ItemCategory.ID as Category_id', 'ItemCategory.CategoryName', 'ItemList.ItemCode', 'ItemList.Name')->get();

        return request()->json(200, $arr);
    }

    public
    function submit_assetbook(Request $request)
    {

        $category_id = $request->get('category_id');
        $percentage = $request->get('percentage');
        $method = $request->get('method');
        $starting_date = $request->get('starting_date');
        $start_mydate = $starting_date;
        $cost_unit = $request->get('cost_unit');
        $est_life = $request->get('est_life');
        $salvage_value = $request->get('salvage_value');
        $purchase_date = $request->get('purchase_date');
        $asset_name = $request->get('asset_name');

        $assetid = $request->get('assetid');
        date_default_timezone_set("Asia/Karachi");
        $update_date = date("Y-m");
        $return_date = substr($starting_date, 0, 7);
        $updated_date = short_date();
        $update_dateddd = long_date();

        $status = 'Depreciation';
        $session_get = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->select('EndDate')->get();
        foreach ($session_get as $session_get1) {

        }
        $session_enddate = substr($session_get1->EndDate, 0, 7);
        $checkdate1 = Carbon::parse($starting_date);
        $checkdate2 = Carbon::parse(substr($session_get1->EndDate, 0, 10));
        if ($checkdate2->lt($checkdate1)) {
            $arr = 'Depreciation Already exists for this financial year';
            return request()->json(200, $arr);
        } else {


            $toDate = Carbon::parse($return_date);
            $fromDate = Carbon::parse($session_enddate);

            $months = $toDate->diffInMonths($fromDate);
            $month1 = $months + 1;
            $closed_mydate1 = Carbon::parse($starting_date)->addMonths($months);


            //calculate years
            $toDate1 = Carbon::parse($return_date);
            $fromDate1 = Carbon::parse($est_life);
            $months_dec = $toDate1->diffInMonths($fromDate1);
            $months_dec1 = $months_dec + 1;
            $year = 1;
            $year = floor($months_dec1 / 12);
            $mon = $months_dec1 % 12;

            if ($mon > 0) {
                $year = $year + 1;
            }
            if ($method == 'straight_line') {
                $straight_check = DB::connection('sqlsrv3')->table('DepreciationAssets')->where('Methods', '=', 'straight_line')->where('AssetId', '=', $assetid)->orderBy('ClosingDate', 'desc')->first();
                if ($straight_check) {
                    $deprec_value = ($straight_check->DepreciatedValue / 12) * $month1;
                    $closing_value = $cost_unit - $deprec_value;
                    if ($closing_value < 0) {
                        $arr = 'Invalid Depreciation';
                        return request()->json(200, $arr);
                    }
                    DB::connection('sqlsrv3')->insert('INSERT INTO DepreciationAssets(Methods,Percentage,StartingDate,ClosingDate,AssetId,StartingValue,ClosingValue,CreatedBy,CreatedOn,Status,DepreciatedValue) values (?,?,?,?,?,?,?,?,?,?,?)', [$method, $percentage, $start_mydate, substr($session_get1->EndDate, 0, 10), $assetid, $cost_unit, $closing_value, username(), $update_dateddd, 'active', $deprec_value]);
                    $deprec_asset = DB::connection('sqlsrv3')->table('DepreciationAssets')->select('ID')->get();
                    foreach ($deprec_asset as $deprec_asset1) {
                    }
                    for ($z = 0; $z < $month1; $z++) {

                        $closed_mydate = (Carbon::parse($starting_date)->addMonths($z)->format('Y-m-d'));
                        DB::connection('sqlsrv3')->insert('INSERT INTO AssetBook(AssetsName,Age,AssetID,StartingDate,PurchaseDate,ClosingDate,AssetDepreciationID,OpeningValue,ClosingValue,AssetCategoryID,ChangeType,DepreciationDate,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$asset_name, $est_life, $assetid, $start_mydate, $purchase_date, substr($closed_mydate, 0, 10), $deprec_asset1->ID, $cost_unit, $closing_value, $category_id, $status, $updated_date, username(), $update_dateddd]);
                    }
                } else {
                    $total_val1 = ($cost_unit - $salvage_value) / $year;
                    $deprec_value = ($total_val1 / 12) * $month1;
                    $closing_value = $cost_unit - $deprec_value;
                    if ($closing_value < 0) {
                        $arr = 'Invalid Depreciation';
                        return request()->json(200, $arr);
                    }
                    DB::connection('sqlsrv3')->insert('INSERT INTO DepreciationAssets(Methods,Percentage,StartingDate,ClosingDate,AssetId,StartingValue,ClosingValue,CreatedBy,CreatedOn,Status,DepreciatedValue) values (?,?,?,?,?,?,?,?,?,?,?)', [$method, $percentage, $start_mydate, substr($session_get1->EndDate, 0, 10), $assetid, $cost_unit, $closing_value, username(), $update_dateddd, 'active', $deprec_value]);
                    $deprec_asset = DB::connection('sqlsrv3')->table('DepreciationAssets')->select('ID')->get();
                    foreach ($deprec_asset as $deprec_asset1) {
                    }
                    for ($z = 0; $z < $month1; $z++) {
                        $closed_mydate = (Carbon::parse($starting_date)->addMonths($z)->format('Y-m-d'));
                        DB::connection('sqlsrv3')->insert('INSERT INTO AssetBook(AssetsName,Age,AssetID,StartingDate,PurchaseDate,ClosingDate,AssetDepreciationID,OpeningValue,ClosingValue,AssetCategoryID,ChangeType,DepreciationDate,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$asset_name, $est_life, $assetid, $start_mydate, $purchase_date, substr($closed_mydate, 0, 10), $deprec_asset1->ID, $cost_unit, $closing_value, $category_id, $status, $updated_date, username(), $update_dateddd]);
                    }
                }


            } else {

                $total_val = ($cost_unit / 100) * $percentage;
                $total_val1 = ($total_val / 12) * $month1;
                $closing_value = $cost_unit - $total_val1;
                if ($closing_value < 0) {
                    $arr = 'Invalid Depreciation';
                    return request()->json(200, $arr);
                }
                $check = DB::connection('sqlsrv3')->insert('INSERT INTO DepreciationAssets(Methods,Percentage,StartingDate,ClosingDate,AssetId,StartingValue,ClosingValue,CreatedBy,CreatedOn,Status,DepreciatedValue) values (?,?,?,?,?,?,?,?,?,?,?)', [$method, $percentage, $start_mydate, substr($session_get1->EndDate, 0, 10), $assetid, $cost_unit, $closing_value, username(), $update_dateddd, 'active', $total_val1]);

                if ($check) {
                    $deprec_asset = DB::connection('sqlsrv3')->table('DepreciationAssets')->select('ID')->get();
                    foreach ($deprec_asset as $deprec_asset1) {
                    }
                    for ($z = 0; $z < $month1; $z++) {
                        $closed_mydate = (Carbon::parse($starting_date)->addMonths($z)->format('Y-m-d'));

                        DB::connection('sqlsrv3')->insert('INSERT INTO AssetBook(AssetsName,Age,AssetID,StartingDate,PurchaseDate,ClosingDate,OpeningValue,ClosingValue,AssetCategoryID,ChangeType,DepreciationDate,CreatedBy,CreatedOn,AssetDepreciationID) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$asset_name, $est_life, $assetid, $start_mydate, $purchase_date, substr($closed_mydate, 0, 10), $cost_unit, $closing_value, $category_id, $status, $updated_date, username(), $update_dateddd, $deprec_asset1->ID]);

                    }
                }


            }

            $arr = 'Submitted';
            return request()->json(200, $arr);
        }
    }

    public
    function assets_category1()
    {

        $arr = DB::connection('sqlsrv3')->table('ItemCategory')->where('CompanyID', '=', company_id())->select('CategoryName', 'ID')->orderby('ID', 'asc')->where('CategoryType', '=', 'Assets')->get();
        return request()->json(200, $arr);
    }

    public
    function depreciationmethods_detail($id)
    {
        $arr = DB::connection('sqlsrv3')->table('DepreciationCategory')->where('Status', '=', 'active')->where('CategoryId', '=', $id)->select('DepreciationCategory.Methods', 'DepreciationCategory.Percentage')->get();
        return request()->json(200, $arr);
    }

    public
    function assets_retirement_security($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("AssetDisposals")->where('AssetsUniqueID', '=', $id)->get();
        return request()->json(200, $find_config);
    }

    public
    function assets_depreciation_security($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("DepreciationAssets")->where('AssetId', '=', $id)->get();
        return request()->json(200, $find_config);
    }

    public
    function submit_depreciassion(Request $request)
    {
        $category = $request->get("categoty");
        $name = $request->get("name");
        $method = $request->get("method");
        $percentage = $request->get("percentage");
        $starting_date = $request->get("starting_date");
        $status = 'active';

        $update_date = long_date();
        $update_d = short_date();

        $check = DB::connection('sqlsrv3')->table('DepreciationCategory')->where('CategoryId', '=', $category)->exists();
        if ($check) {
            $arr = 'Depreciation Category Already exist';
            return request()->json(200, $arr);
        } else {
            $result = DB::connection('sqlsrv3')->insert("INSERT INTO DepreciationCategory(DeprName, Methods, Status, Percentage,CategoryId,StartingDate, CreatedBy, CreatedOn) values (?,?,?,?,?,?,?,?)", [$name, $method, $status, $percentage, $category, $starting_date, username(), $update_date]);
            if ($result) {
                $arr = 'Submitted';
                return request()->json(200, $arr);
            }
        }
    }

    public
    function assets_depreciasion_detail()
    {

        $arr = DB::connection('sqlsrv3')->table('DepreciationCategory')->join('ItemCategory', 'ItemCategory.ID', '=', 'DepreciationCategory.CategoryId')->where('DepreciationCategory.Status', '=', 'Active')->orderby('DepreciationCategory.ID', 'asc')->select('DepreciationCategory.DeprName', 'DepreciationCategory.Methods', 'DepreciationCategory.Percentage', 'ItemCategory.CategoryName')->paginate(20);
        return request()->json(200, $arr);
    }

    public
    function adddayin_date(Request $request)
    {

        $date = $request->get("date");
        $new_date = Carbon::parse($date)->addDays(1);
        return request()->json(200, substr($new_date, 0, 10));
    }

    public
    function search_depreciationbyname(Request $request)
    {
        // return $request->keyword1;
        $arr = DB::connection('sqlsrv3')->table('DepreciationCategory')->join('ItemCategory', 'ItemCategory.ID', '=', 'DepreciationCategory.CategoryId')->where('DepreciationCategory.Status', '=', 'Active')->where('DepreciationCategory.DeprName', 'like', '%' . $request->keyword1 . '%')->orderby('DepreciationCategory.ID', 'asc')->select('DepreciationCategory.DeprName', 'DepreciationCategory.Methods', 'DepreciationCategory.Percentage', 'ItemCategory.CategoryName')->paginate(20);
        return request()->json(200, $arr);
    }

    public
    function depreciationexisting_date($id, $catid)
    {
        $check11 = DB::connection('sqlsrv3')->table('DepreciationAssets')->where('AssetId', '=', $id)->exists();
        if ($check11) {
            $getassetbook = DB::connection('sqlsrv3')->table('DepreciationAssets')->where('AssetId', '=', $id)->select('ClosingValue', 'ClosingDate')->orderBy('ClosingDate', 'desc')->first();
            return request()->json(200, $getassetbook);
        }
    }

    public
    function search_units_cash_only($from, $to, $category, $all, $type)
    {
        if ($type == 'All') {
            $type = '';
        }
        if ($all == 'All') {
            if ($category == 'Both') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '>=', $from)->where('DateTime', '<=', $to)->where('Status', '=', null)->where('Type', '=', $type)->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            } elseif ($category == 'SAM') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '>=', $from)->where('DateTime', '<=', $to)->where('Status', '=', null)->where('Type', '=', $type)->where('Text', '=', 'SAM')->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            } elseif ($category == 'SAGardens') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '>=', $from)->where('DateTime', '<=', $to)->where('Status', '=', null)->where('Type', '=', $type)->where('Text', '!=', 'SAM')->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            }

        } else {
            if ($category == 'Both') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $all)->where('DateTime', '>=', $from)->where('DateTime', '<=', $to)->where('Type', '=', $type)->where('Status', '=', null)->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            } elseif ($category == 'SAM') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $all)->where('DateTime', '>=', $from)->where('DateTime', '<=', $to)->where('Type', '=', $type)->where('Text', '=', 'SAM')->where('Status', '=', null)->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            } elseif ($category == 'SAGardens') {
                $arr = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $all)->where('DateTime', '>=', $from)->where('DateTime', '<=', $to)->where('Type', '=', $type)->where('Text', '!=', 'SAM')->where('Status', '=', null)->orderby('Id', 'desc')->get();
                return request()->json(200, $arr);
            }
        }
    }

    public
    function search_units_cash_only_counter($from, $to, $category, $user, $type)
    {
        if ($type == 'All') {
            $type = '';
        }
        if ($user == 'All') {
            if ($category == 'Both') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '>=', $from)->where('DateTime', '<=', $to)->where('Type', '=', $type)->where('Status', '=', null)->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            } elseif ($category == 'SAM') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '>=', $from)->where('DateTime', '<=', $to)->where('Type', '=', $type)->where('Status', '=', null)->where('Text', '=', 'SAM')->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            } elseif ($category == 'SAGardens') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('DateTime', '>=', $from)->where('DateTime', '<=', $to)->where('Type', '=', $type)->where('Status', '=', null)->where('Text', '!=', 'SAM')->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            }

        } else {
            if ($category == 'Both') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $user)->where('DateTime', '>=', $from)->where('Type', '=', $type)->where('DateTime', '<=', $to)->where('Status', '=', null)->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            } elseif ($category == 'SAM') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $user)->where('DateTime', '>=', $from)->where('Type', '=', $type)->where('DateTime', '<=', $to)->where('Text', '=', 'SAM')->where('Status', '=', null)->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);
            } elseif ($category == 'SAGardens') {
                $cash_amount = DB::connection('sqlsrv3')->table('UnitsCashDetail')->where('Userid', '=', $user)->where('DateTime', '>=', $from)->where('Type', '=', $type)->where('DateTime', '<=', $to)->where('Text', '!=', 'SAM')->where('Status', '=', null)->where('PaymentType', '=', 'Cash')->sum('Amount');

                $myJSON = array(
                    'cash' => $cash_amount,
                );
                return request()->json(200, $myJSON);

            }

        }

    }

//udate petttycash
    public
    function get_petty_access1($id)
    {

        $find_access = DB::connection('sqlsrv3')->table("PettyCash")->where('CompanyID', '=', company_id())->where("ID", "=", $id)->get();

        return request()->json(200, $find_access);

    }

    public
    function submit_paid_cash1(Request $request)
    {
        $id = $request->get("id");
        $limit1 = $request->get("limit");
        $paid_amount = $request->get("paid_amount");
        $dept = $request->get("dept");
        if ($paid_amount > $limit1) {
            $arr = "Paid Amount cannot greater then limit";
            return request()->json(200, $arr);
        }
        $dept_check = DB::connection("sqlsrv3")->table("PettyCashAccess")->where("Department", '=', $dept)->exists();
        if (!$dept_check) {
            $arr = 'Department has no Access';
            return request()->json(200, $arr);
        }

        $final_PoCode = PVID();

        insert_sequencevoucher($final_PoCode, $id, 'Petty Cash');
        $find_pre_detail1 = DB::connection("sqlsrv3")->table("PettyCash")->where("ID", '=', $id)->first();
        $paid_total = $find_pre_detail1->TotalPaid + $paid_amount;
        $remaining_total = $find_pre_detail1->Remaining - $paid_amount;


        $result = DB::connection('sqlsrv3')->update('update PettyCash set PaidAmount=?,PVID=?,UpdatedBy=?,UpdatedOn=?,TotalPaid=?,Remaining=? where CompanyID=? and ID=?', [$paid_amount, $final_PoCode, username(), short_date(), $paid_total, $remaining_total, company_id(), $id]);

        if ($result) {
            $find_acc_head1 = DB::connection("sqlsrv3")->table("PettyCashAccess")->where("Department", '=', $dept)->first();
            $dept = $find_acc_head1->Department;
            $AccountID = $find_acc_head1->AccountID;
//            $limit = $limit1;

            $cashinhand_balance = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
@Datefrom = N'2000-01-01',
@DateTo = N'" . short_date() . "',
@id = " . 101001001001 . ",
@compid = N'" . company_id() . "'  ");
            foreach ($cashinhand_balance as $cashinhand_balance1) {
            }
            if ($cashinhand_balance1->am <= 0) {
                $find_config = 'Not Suficient Balance';
                return request()->json(200, $find_config);
            }

            $doc1 = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [short_date(), $final_PoCode, 'Paid Pettycash to ' . $dept, 'Petty Cash', long_date(), username(), company_id()]);

            if ($doc1) {
                $find_doc_id2 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode)->get();
                foreach ($find_doc_id2 as $find_doc_id21) {

                }
                DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id21->ID, short_date(), 'Paid Pettycash to ' . $dept, company_id()]);

                $find_tran_id2 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id21->ID)->get();
                foreach ($find_tran_id2 as $find_tran_id21) {

                }
                DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id21->ID, $AccountID, 'D', $paid_amount, company_id()]);
                $cash_hand = '101001001001';
                DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id21->ID, $cash_hand, 'C', $paid_amount, company_id()]);

            }
            $arr = 'Updated';
            return request()->json(200, $arr);
        }
    }

    public
    function getitems_issuanceReturn($id)
    {

        $checker = DB::connection('sqlsrv3')->table('IssuanceReturn')->where('CompanyID', '=', company_id())->where('IRtnID', '=', $id)->exists();
        if ($checker) {
            $find_config = DB::connection('sqlsrv3')->table('IssuanceReturn')->where('CompanyID', '=', company_id())->where('IRtnID', '=', $id)->select('IssuenceReturnID')->get();

            foreach ($find_config as $find_config1) {
            }

            $checker1 = DB::connection('sqlsrv3')->table('IssuanceReturnItem')->where('IssuanceReturnId', '=', $find_config1->IssuenceReturnID)->get();
            return request()->json(200, $checker1);

        }
    }

    public
    function return_issu_detail_report()
    {

        $find_config = DB::connection('sqlsrv3')->table("IssuanceReturn")->where('CompanyID', '=', company_id())->select('IRtnID')->get();
        return request()->json(200, $find_config);
    }

    public
    function petty_Cash_bill($id, $pid)
    {

        $check_security = DB::connection('sqlsrv3')->table('PettyCash')->where('CompanyID', '=', company_id())->where('ID', '=', $id)->where('PettyID', '=', $pid)->exists();
        if ($check_security) {
            $users = DB::connection('sqlsrv3')->table('PettyCash')->where('ID', '=', $id)->get();
            foreach ($users as $users57) {
            }
            $dept_check = DB::connection('sqlsrv3')->table('PettyCashAccess')->where('Department', '=', $users57->DeptName)->exists();
            $users1 = DB::connection('sqlsrv3')->table('PettyCashAccess')->where('Department', '=', $users57->DeptName)->get();
            //  return $users1;
            if ($dept_check) {
                foreach ($users1 as $users56) {
                }
            } else {
                $arr = "Department has no access";
                return request()->json(200, $arr);
            }
            $this->fpdf = new Fpdf;
            $this->fpdf->AddPage("L", ['280', '297']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {

            }
            $date = explode(" ", $users57->UpdatedOn);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 140, 15, 35, 17);
            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(105, 6, '', 0, 0, 'R', 0);
            $this->fpdf->SetTextColor(250, 248, 248);
            $this->fpdf->Cell(70, 12, 'PETTY CASH BILL', 0, 1, 'C', 1);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(40, 6, 'Department: ' . $users57->DeptName, 0, 0, 'L', 0);
            $this->fpdf->Cell(150, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Payment Voucher', 0, 1, 'R', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(40, 6, 'ID #: ' . $users57->PVID, 0, 0, 'L', 0);
            $this->fpdf->Cell(170, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Account ID: ' . $users56->AccountID, 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, 'Date: ' . $users57->PettyDate, 0, 0, 'L', 0);
            $this->fpdf->Cell(162, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Payment Date: ' . $date[0], 0, 1, 'R', 0);
            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(220, 6, 'Description', 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 6, 'Paid', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(220, 15, ('Petty Cash Bill of  ' . $users57->DeptName . ' use of Amount ' . number_format($users57->PaidAmount) . ' in Total Amount: ' . number_format($users57->TotalAmount)), 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 15, number_format($users57->PaidAmount), 1, 1, 'C', 0);
            $this->fpdf->Cell(220, 6, 'Remaining Amount:', 0, 0, 'R', 0);
            $this->fpdf->Cell(40, 6, number_format($users57->Remaining), 0, 1, 'C', 0);
            $this->fpdf->Output();
            exit;
        }
    }


    public
    function get_allissuance()
    {

        $find_config = DB::connection('sqlsrv3')->table("Issuances")->where('Issuances.CompanyID', '=', company_id())->orderby('Issuances.IssuanceId', 'desc')->select('Issuances.*')->get();
        return request()->json(200, $find_config);
    }

    public
    function insert_site_issuance(Request $request)
    {
        $session = ac_c_session();
        $item_name = $request->get('item_name');
        $unit = $request->get('unit');
        $est_cost = $request->get('est_cost');
        $qty = $request->get('qty');
        $date = $request->get('date');
        $dept_name = $request->get('dept_name');
        $project = $request->get('project');
        $dept_name1 = $request->get('dept_name1');
        $project1 = $request->get('project1');
        $narration = $request->get('narration');
        $req_id = $request->get('req_id');
        $status = $request->get('status');
        $update_date = long_date();
        $update_dated = short_date();
        $date_pref = $this->shiftformat();
        $req_prefix = 'SIS_' . $date_pref;
        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $qt = explode("|", $qty);
            $estcost = explode("|", $est_cost);
            $item_nam = explode("|", $item_name);

            if ($estcost[$x] < $qt[$x]) {
                $message = 'Issued quantity cannot be greater than Requisition quantity';
                return request()->json(200, $message);
            } else if ($qt[$x] < 0) {
                $message = 'Issued quantity cannot be negative';
                return request()->json(200, $message);
            }

            $find_inventory_amount = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC   [dbo].[Get_Item_AverageCostValue_ItemWise]
      @CompanyID = N'" . company_id() . "',
      @itemid = N'" . $item_name1[$x] . "' ");
            if ($find_inventory_amount) {
                foreach ($find_inventory_amount as $find_inventory_amount1) {

                }
                $t_iss_amount = $find_inventory_amount1->AVG * $qt[$x];
            } else {
                $t_iss_amount = 0;
            }
            if ($t_iss_amount < 0) {
                $message = 'Quantity cannot be negative';
                return request()->json(200, $message);
            }
        }
        $find_rid9 = DB::connection('sqlsrv3')->table("Issuances")->where('CompanyID', '=', company_id())->exists();
        if ($find_rid9) {
            $find_rid = DB::connection('sqlsrv3')->table("Issuances")->select('IssuanceCode')->where('CompanyID', '=', company_id())->get();
            foreach ($find_rid as $find_rid1) {

            }
            $pre_id = explode("-", $find_rid1->IssuanceCode);
            $rid = $pre_id[1] + 1;
        } else {
            $rid = 1;
        }
        $final_PoCode = $req_prefix . '-' . $rid;
        if ($status == 1) {
            $status1 = 'Fully Delivered';
        } else {
            $status1 = 'Partially Delivered';
        }
        $result = DB::connection('sqlsrv3')->insert('INSERT INTO Issuances(CompanyID,IssuanceCode,IssuanceDate,RequisitionId,DepartmentName,ProjectName,Status,Narration,CreatedBy,CreatedOn,Session,FProjectName,FDepartmentName) values (?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $final_PoCode, $date, $req_id, $dept_name, $project, $status1, $narration, username(), $update_date, $session, $project1, $dept_name1]);
        if ($result) {
            $find_reqid = DB::connection('sqlsrv3')->table("Issuances")->select('IssuanceId')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $req_id)->get();
            foreach ($find_reqid as $find_reqid1) {
            }
            $item_name1 = explode("|", $item_name);
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $ordrqt = explode("|", $est_cost);
                $uni = explode("|", $unit);
                $qt = explode("|", $qty);
                if ($qt[$x] != 0 || $qt[$x] != 0.00) {
                    $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                    foreach ($find_itemname as $find_itemname1) {

                    }
                    $check_invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $item_nam[$x])->exists();
                    $facevalue = '';
                    if ($check_invent) {
                        $invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $item_nam[$x])->select('FaceValue')->orderBy('ID', 'DESC')->first();
                        $facevalue = $invent->FaceValue;
                    } else {
                        $facevalue = 0;
                    }
                    DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,CreatedBy,CreatedOn,Reference,Dated,FaceValue) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $item_nam[$x], $qt[$x], $uni[$x], 7, username(), $update_date, 'Added stock through ' . $final_PoCode, $update_dated, $facevalue]);
                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO IssuanceItem(IssuanceId,itemId,ItemName,ReqQuantity,unit,IssuanceQuantity,RID) values (?,?,?,?,?,?,?)', [$find_reqid1->IssuanceId, $item_nam[$x], $find_itemname1->Name, $ordrqt[$x], $uni[$x], $qt[$x], $req_id]);
                    $result9 = DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,CreatedBy,CreatedOn,Reference,Dated,FaceValue) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $item_nam[$x], $qt[$x], $uni[$x], 2, username(), $update_date, 'Issued Item Through ' . $final_PoCode, $update_dated, $facevalue]);
                }
            }
            $find_dept_name = DB::connection('sqlsrv3')->table("Issuances")->where('CompanyID', '=', company_id())->where('IssuanceId', '=', $find_reqid1->IssuanceId)->get();
            foreach ($find_dept_name as $find_dept_name1) {

            }
            $dept_name9 = $find_dept_name1->FDepartmentName;
            $project9 = $find_dept_name1->FProjectName;
            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$update_dated, $final_PoCode, $final_PoCode . '/' . $dept_name9 . '/' . $project9, 'Issuance Return', $update_date, username(), company_id()]);
            if ($doc) {
                $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode)->get();
                foreach ($find_doc_id as $find_doc_id1) {

                }
                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $update_dated, $dept_name9 . '/' . $project9 . 'To Inventory', company_id()]);
                $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                foreach ($find_tran_id as $find_tran_id1) {

                }
                $item_name1 = explode("|", $item_name);
                for ($y = 1; $y < count($item_name1); $y++) {
                    $item_nam = explode("|", $item_name);
                    $ordrqt = explode("|", $est_cost);
                    $uni = explode("|", $unit);
                    $qt = explode("|", $qty);
                    $find_inventory_amount = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC   [dbo].[Get_Item_AverageCostValue_ItemWise]
        @CompanyID = N'" . company_id() . "',
        @itemid = N'" . $item_name1[$y] . "' ");
                    if ($find_inventory_amount) {
                        foreach ($find_inventory_amount as $find_inventory_amount1) {

                        }
                        $t_iss_amount = $find_inventory_amount1->AVG * $qt[$y];
                    } else {
                        $t_iss_amount = 0;
                    }
                    if ($qt[$y] != 0 || $qt[$y] != 0.00) {
                        $find_acc_code = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ItemId', '=', $item_nam[$y])->get();
                        foreach ($find_acc_code as $find_acc_code1) {

                        }
                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->CoaID, 'D', $t_iss_amount, company_id()]);
                        $find_acc_code9 = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ProjectName', '=', $project9)->get();
                        foreach ($find_acc_code9 as $find_acc_code91) {

                        }
                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'C', $t_iss_amount, company_id()]);
                    }
                }
            }
            $doc2 = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$update_dated, $final_PoCode, $final_PoCode . '/' . $dept_name . '/' . $project, 'Issuance', $update_date, username(), company_id()]);
            if ($doc2) {
                $find_doc_id2 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode)->get();
                foreach ($find_doc_id2 as $find_doc_id21) {

                }
                $transaction2 = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id21->ID, $update_dated, 'Inventory To ' . $dept_name . '/' . $project, company_id()]);
                $find_tran_id2 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id21->ID)->get();
                foreach ($find_tran_id2 as $find_tran_id21) {

                }
                $item_name1 = explode("|", $item_name);
                for ($y = 1; $y < count($item_name1); $y++) {
                    $item_nam = explode("|", $item_name);
                    $ordrqt = explode("|", $est_cost);
                    $uni = explode("|", $unit);
                    $qt = explode("|", $qty);
                    $find_inventory_amount = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC   [dbo].[Get_Item_AverageCostValue_ItemWise]
        @CompanyID = N'" . company_id() . "',
        @itemid = N'" . $item_name1[$y] . "' ");
                    if ($find_inventory_amount) {
                        foreach ($find_inventory_amount as $find_inventory_amount1) {

                        }
                        $t_iss_amount = $find_inventory_amount1->AVG * $qt[$y];
                    } else {
                        $t_iss_amount = 0;
                    }
                    if ($qt[$y] != 0 || $qt[$y] != 0.00) {
                        $find_acc_code2 = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ItemId', '=', $item_nam[$y])->get();
                        foreach ($find_acc_code2 as $find_acc_code21) {

                        }
                        $find_acc_code9 = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ProjectName', '=', $project)->get();
                        foreach ($find_acc_code9 as $find_acc_code91) {

                        }
                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id21->ID, $find_acc_code21->CoaID, 'C', $t_iss_amount, company_id()]);
                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id21->ID, $find_acc_code91->CoaID, 'D', $t_iss_amount, company_id()]);
                        //        $message = $find_tran_id21->ID.$find_acc_code91->CoaID.'D'.$t_iss_amount2.company_id();
                        // return request()->json(200, $message);
                        //$ledger_entry2=DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id21->ID,'502002009','D',$t_iss_amount2, company_id()]);
                    }
                }
            }
        }
        //DB::connection('sqlsrv3')->update('update Requisition set state=? where CompanyID=?  and RequisitionId=? ', [$status, company_id(), $req_id]);
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'New Site to Site Issuance Created', ' Site to Site Issuance | ' . $final_PoCode . ' | from Project | ' . $project1 . ' | to Project | ' . $project . ' | has been created ', $update_date]);
        $message = 'submitted';
        return request()->json(200, $message);
    }

    public
    function search_depart_access(Request $request)
    {


        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();

        $dept_Access = DB::connection('sqlsrv3')->table('DeptAccess')->select('DeptAccess.*')->where('DeptAccess.Email', 'LIKE', '%' . $request->keyword1 . '%')->where('DeptAccess.CompanyID', '=', company_id())->paginate(20);
        return response()->json($dept_Access);
    }

//New Purchase Process
    public
    function searchbydemandreqid_services($id, $page)
    {

        if ($page == 'All') {
            $arr = DB::connection("sqlsrv3")->table("DemandRequisition")->where("RId", 'like', '%' . $id . '%')->where("RequisitionType", "=", "Services")->get();
            return request()->json(200, $arr);
        } else {

            $arr = DB::connection("sqlsrv3")->table("DemandRequisition")->where("RId", 'like', '%' . $id . '%')->where("RequisitionType", "=", "Services")->paginate($page);
            return request()->json(200, $arr);
        }
    }

    public
    function get_demandrequisition_services(Request $request)
    {

        $dept = emp_department();

        $totalResult = $request->get("pages");


        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {

        }
        $session = $find_session1->SessionName;
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($totalResult == 'All') {
                $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Services")->get();
                return request()->json(200, $find_config);
            } else {
                $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Services")->paginate($totalResult);
                return request()->json(200, $find_config);
            }

        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {

                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')
                        ->table("DemandRequisition")
                        ->where('CompanyID', company_id())
                        ->where('Session', $session)
                        ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                            $query->where('DepartmentName', 'like', $d1 . '%')
                                ->orWhere('DepartmentName', 'like', $d2 . '%')
                                ->orWhere('DepartmentName', 'like', $d3 . '%')
                                ->orWhere('DepartmentName', 'like', $d4 . '%')
                                ->orWhere('DepartmentName', 'like', $d5 . '%')
                                ->orWhere('DepartmentName', 'like', $d6 . '%');
                        })
                        ->where("RequisitionType", "=", "Services")
                        ->orderBy('RequisitionId', 'desc')
                        ->get();

                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')
                        ->table("DemandRequisition")
                        ->where('CompanyID', company_id())
                        ->where('Session', $session)
                        ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                            $query->where('DepartmentName', 'like', $d1 . '%')
                                ->orWhere('DepartmentName', 'like', $d2 . '%')
                                ->orWhere('DepartmentName', 'like', $d3 . '%')
                                ->orWhere('DepartmentName', 'like', $d4 . '%')
                                ->orWhere('DepartmentName', 'like', $d5 . '%')
                                ->orWhere('DepartmentName', 'like', $d6 . '%');
                        })
                        ->where("RequisitionType", "=", "Services")
                        ->orderBy('RequisitionId', 'desc')
                        ->paginate($totalResult);

                    return request()->json(200, $find_config);
                }
            } else {
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('DepartmentName', '=', $dept)->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Services")->get();
                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('DepartmentName', '=', $dept)->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Services")->paginate($totalResult);
                    return request()->json(200, $find_config);
                }
            }


        }

    }

    public
    function accounts_fetch_demandreqBysts_services($sts, $depts, $proj, $startdate, $closedate, $page)
    {

        $dept = emp_department();

        if ($sts == "All") {
            $sts = "";
        }
        if ($depts == "All") {
            $depts = "";
        }
        if ($proj == "All") {
            $proj = "";
        }
        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {

        }
        $session = $find_session1->SessionName;
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($page == 'All') {
                $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')
                    // ->where('Session',$session)
                    ->where('DepartmentName', 'like', '%' . $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where("RequisitionType", "=", "Services")->get();
                return request()->json(200, $req);
            } else {
                $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')
                    // ->where('Session',$session)
                    ->where('DepartmentName', 'like', '%' . $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where("RequisitionType", "=", "Services")->paginate($page);
                return request()->json(200, $req);
            }

        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {

                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;

                if ($depts == $d1 || $depts == $d2 || $depts == $d3 || $depts == $d4 || $depts == $d5 || $depts == $d6) {
                    if ($page == 'All') {
                        $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', company_id())
                            // ->where('Session',$session)
                            ->where('DepartmentName', 'like', $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Services")->get();
                        return request()->json(200, $find_config);
                    } else {
                        $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', company_id())
                            // ->where('Session',$session)
                            ->where('DepartmentName', 'like', $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Services")->paginate($page);
                        return request()->json(200, $find_config);
                    }

                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }

            } else {
                if ($depts == $dept) {
                    if ($page == 'All') {

                        $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')->where('DepartmentName', '=', $dept)->where('ProjectName', 'like', '%' . $proj . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where("RequisitionType", "=", "Services")->get();
                        return request()->json(200, $req);
                    } else {

                        $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')->where('DepartmentName', '=', $dept)->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where("RequisitionType", "=", "Services")->paginate($page);
                        return request()->json(200, $req);
                    }
                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }

            }


        }


    }

    public
    function get_demandrequisition(Request $request)
    {

        $dept = emp_department();
        $totalResult = $request->get("pages");


        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {

        }
        $session = $find_session1->SessionName;
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($totalResult == 'All') {
                $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Goods")->get();
                return request()->json(200, $find_config);
            } else {
                $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Goods")->paginate($totalResult);
                return request()->json(200, $find_config);
            }

        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {

                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')
                        ->table("DemandRequisition")
                        ->where('CompanyID', company_id())
                        ->where('Session', $session)
                        ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                            $query->where('DepartmentName', 'like', $d1 . '%')
                                ->orWhere('DepartmentName', 'like', $d2 . '%')
                                ->orWhere('DepartmentName', 'like', $d3 . '%')
                                ->orWhere('DepartmentName', 'like', $d4 . '%')
                                ->orWhere('DepartmentName', 'like', $d5 . '%')
                                ->orWhere('DepartmentName', 'like', $d6 . '%');
                        })
                        ->where("RequisitionType", "=", "Goods")
                        ->orderBy('RequisitionId', 'desc')
                        ->get();

                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')
                        ->table("DemandRequisition")
                        ->where('CompanyID', company_id())
                        ->where('Session', $session)
                        ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                            $query->where('DepartmentName', 'like', $d1 . '%')
                                ->orWhere('DepartmentName', 'like', $d2 . '%')
                                ->orWhere('DepartmentName', 'like', $d3 . '%')
                                ->orWhere('DepartmentName', 'like', $d4 . '%')
                                ->orWhere('DepartmentName', 'like', $d5 . '%')
                                ->orWhere('DepartmentName', 'like', $d6 . '%');
                        })
                        ->where("RequisitionType", "=", "Goods")
                        ->orderBy('RequisitionId', 'desc')
                        ->paginate($totalResult);

                    return request()->json(200, $find_config);
                }
            } else {
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('DepartmentName', '=', $dept)->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Goods")->get();
                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('DepartmentName', '=', $dept)->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Goods")->paginate($totalResult);
                    return request()->json(200, $find_config);
                }
            }


        }
    }

    public
    function count_demandrequisitions()
    {
        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $session = $find_session1->SessionName;
        $dept = emp_department();
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            $total = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where("RequisitionType", "=", "Goods")->count();
            $approved = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 0)->where("RequisitionType", "=", "Goods")->count();
            $pending = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->where("RequisitionType", "=", "Goods")->count();
            $issued = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('state', '=', 1)->where('Status', '=', 'Approved')->where("RequisitionType", "=", "Goods")->count();
            $myJSON = array(
                'total' => $total,
                'approved' => $approved,
                'pending' => $pending,
                'issued' => $issued,
            );
            return request()->json(200, $myJSON);
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {

                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;

                $total = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where("RequisitionType", "=", "Goods")
                    ->count();


                $approved = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where("RequisitionType", "=", "Goods")
                    ->where('Status', '=', 'Approved')
                    ->where('state', '!=', 1)
                    ->count();


                $pending = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where('Status', '=', 'Pending')
                    ->where("RequisitionType", "=", "Goods")
                    ->count();

                $issued = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where('Status', '=', 'Approved')
                    ->where('state', '=', 1)
                    ->where("RequisitionType", "=", "Goods")
                    ->count();


                $myJSON = array(
                    'total' => $total,
                    'approved' => $approved,
                    'pending' => $pending,
                    'issued' => $issued,
                );
                return request()->json(200, $myJSON);

            } else {
                $total = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where("RequisitionType", "=", "Goods")->where('DepartmentName', '=', $dept)->count();

                $approved = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 0)->where("RequisitionType", "=", "Goods")->where('DepartmentName', '=', $dept)->count();

                $pending = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->where("RequisitionType", "=", "Goods")->where('DepartmentName', '=', $dept)->count();

                $issued = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('state', '=', 1)->where('Status', '=', 'Approved')->where("RequisitionType", "=", "Goods")->where('DepartmentName', '=', $dept)->count();

                $myJSON = array(
                    'total' => $total,
                    'approved' => $approved,
                    'pending' => $pending,
                    'issued' => $issued,
                );
                return request()->json(200, $myJSON);
            }


        }


    }


    public
    function count_demandrequisitions1()
    {

        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {

        }
        $session = $find_session1->SessionName;
        $total = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->count();
        $approved = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->count();
        $pending = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->count();
        $issued = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Issued')->count();

        $myJSON = array(
            'total' => $total,
            'approved' => $approved,
            'pending' => $pending,
            'issued' => $issued,
        );
        return request()->json(200, $myJSON);
    }

    public
    function count_demandrequisitions_assets()
    {

        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $session = $find_session1->SessionName;
        $dept = emp_department();
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            $total = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where("RequisitionType", "=", "Assets")->count();
            $approved = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where("RequisitionType", "=", "Assets")->count();
            $pending = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->where("RequisitionType", "=", "Assets")->count();
            $issued = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('state', '=', 1)->where("RequisitionType", "=", "Assets")->count();
            $myJSON = array(
                'total' => $total,
                'approved' => $approved,
                'pending' => $pending,
                'issued' => $issued,
            );
            return request()->json(200, $myJSON);
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {

                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;

                $total = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where("RequisitionType", "=", "Assets")
                    ->count();


                $approved = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where("RequisitionType", "=", "Assets")
                    ->where('Status', '=', 'Approved')
                    ->where('state', '!=', 1)
                    ->count();


                $pending = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where('Status', '=', 'Pending')
                    ->where("RequisitionType", "=", "Assets")
                    ->count();

                $issued = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where('Status', '=', 'Approved')
                    ->where('state', '=', 1)
                    ->where("RequisitionType", "=", "Assets")
                    ->count();


                $myJSON = array(
                    'total' => $total,
                    'approved' => $approved,
                    'pending' => $pending,
                    'issued' => $issued,
                );
                return request()->json(200, $myJSON);

            } else {
                $total = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where("RequisitionType", "=", "Assets")->where('DepartmentName', '=', $dept)->count();

                $approved = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 0)->where("RequisitionType", "=", "Assets")->where('DepartmentName', '=', $dept)->count();

                $pending = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->where("RequisitionType", "=", "Assets")->where('DepartmentName', '=', $dept)->count();

                $issued = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('state', '=', 1)->where('Status', '=', 'Approved')->where("RequisitionType", "=", "Assets")->where('DepartmentName', '=', $dept)->count();

                $myJSON = array(
                    'total' => $total,
                    'approved' => $approved,
                    'pending' => $pending,
                    'issued' => $issued,
                );
                return request()->json(200, $myJSON);
            }


        }


    }

    public
    function searchbydemandreqid_assets($id, $page)
    {

        if ($page == 'All') {
            $arr = DB::connection("sqlsrv3")->table("DemandRequisition")->where("RId", 'like', '%' . $id . '%')->where("RequisitionType", "=", "Assets")->get();
            return request()->json(200, $arr);
        } else {

            $arr = DB::connection("sqlsrv3")->table("DemandRequisition")->where("RId", 'like', '%' . $id . '%')->where("RequisitionType", "=", "Assets")->paginate($page);
            return request()->json(200, $arr);
        }
    }

    public
    function accounts_fetch_demandreqBysts_assets($sts, $depts, $proj, $startdate, $closedate, $page)
    {

        $dept = emp_department();

        if ($sts == "All") {
            $sts = "";
        }
        if ($depts == "All") {
            $depts = "";
        }
        if ($proj == "All") {
            $proj = "";
        }
        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {

        }
        $session = $find_session1->SessionName;
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($page == 'All') {
                $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')
                    // ->where('Session',$session)
                    ->where('DepartmentName', 'like', '%' . $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')
                    ->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where("RequisitionType", "=", "Assets")->get();
                return request()->json(200, $req);
            } else {
                $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')
                    // ->where('Session',$session)
                    ->where('DepartmentName', 'like', '%' . $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where("RequisitionType", "=", "Assets")->paginate($page);
                return request()->json(200, $req);
            }

        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {

                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;

                if ($depts == $d1 || $depts == $d2 || $depts == $d3 || $depts == $d4 || $depts == $d5 || $depts == $d6) {
                    if ($page == 'All') {
                        $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', company_id())
                            // ->where('Session',$session)
                            ->where('DepartmentName', 'like', $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Assets")->get();
                        return request()->json(200, $find_config);
                    } else {
                        $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', company_id())
                            // ->where('Session',$session)
                            ->where('DepartmentName', 'like', $depts . '%')->where('ProjectName', 'like', '%' . $proj . '%')->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Assets")->paginate($page);
                        return request()->json(200, $find_config);
                    }

                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }

            } else {
                if ($depts == $dept) {
                    if ($page == 'All') {

                        $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')->where('DepartmentName', '=', $dept)->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where("RequisitionType", "=", "Assets")->get();
                        return request()->json(200, $req);
                    } else {

                        $req = DB::connection('sqlsrv3')->table('DemandRequisition')->orderBy('RequisitionId', 'desc')->where('DepartmentName', '=', $dept)->where('ProjectName', 'like', '%' . $proj . '%')->where('CompanyID', '=', company_id())->where('Status', 'like', '%' . $sts . '%')->where('DemandRequisition.Dated', '>=', $startdate)->where('DemandRequisition.Dated', '<=', $closedate)->where("RequisitionType", "=", "Assets")->paginate($page);
                        return request()->json(200, $req);
                    }
                } else {
                    $req = "Invalid department";
                    return request()->json(200, $req);
                }

            }


        }


    }

    public
    function count_demandrequisitions_services()
    {

        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $session = $find_session1->SessionName;
        $dept = emp_department();
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            $total = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where("RequisitionType", "=", "Services")->count();
            $approved = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 0)->where("RequisitionType", "=", "Services")->count();
            $pending = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->where("RequisitionType", "=", "Services")->count();
            $issued = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('state', '=', 1)->where('Status', '=', 'Approved')->where("RequisitionType", "=", "Services")->count();
            $myJSON = array(
                'total' => $total,
                'approved' => $approved,
                'pending' => $pending,
                'issued' => $issued,
            );
            return request()->json(200, $myJSON);
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {

                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;

                $total = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where("RequisitionType", "=", "Services")
                    ->count();


                $approved = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where("RequisitionType", "=", "Services")
                    ->where('Status', '=', 'Approved')
                    ->where('state', '!=', 1)
                    ->count();


                $pending = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where('Status', '=', 'Pending')
                    ->where("RequisitionType", "=", "Services")
                    ->count();

                $issued = DB::connection('sqlsrv3')
                    ->table("DemandRequisition")
                    ->where('CompanyID', company_id())
                    ->where('Session', $session)
                    ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                        $query->where('DepartmentName', 'like', $d1 . '%')
                            ->orWhere('DepartmentName', 'like', $d2 . '%')
                            ->orWhere('DepartmentName', 'like', $d3 . '%')
                            ->orWhere('DepartmentName', 'like', $d4 . '%')
                            ->orWhere('DepartmentName', 'like', $d5 . '%')
                            ->orWhere('DepartmentName', 'like', $d6 . '%');
                    })
                    ->where('Status', '=', 'Approved')
                    ->where('state', '=', 1)
                    ->where("RequisitionType", "=", "Services")
                    ->count();


                $myJSON = array(
                    'total' => $total,
                    'approved' => $approved,
                    'pending' => $pending,
                    'issued' => $issued,
                );
                return request()->json(200, $myJSON);

            } else {
                $total = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where("RequisitionType", "=", "Services")->where('DepartmentName', '=', $dept)->count();

                $approved = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Approved')->where('state', '=', 0)->where("RequisitionType", "=", "Services")->where('DepartmentName', '=', $dept)->count();

                $pending = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('Status', '=', 'Pending')->where("RequisitionType", "=", "Services")->where('DepartmentName', '=', $dept)->count();

                $issued = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('state', '=', 1)->where('Status', '=', 'Approved')->where("RequisitionType", "=", "Services")->where('DepartmentName', '=', $dept)->count();

                $myJSON = array(
                    'total' => $total,
                    'approved' => $approved,
                    'pending' => $pending,
                    'issued' => $issued,
                );
                return request()->json(200, $myJSON);
            }


        }

    }

    public
    function searchbydemandreqid($id, $page)
    {

        if ($page == 'All') {
            $arr = DB::connection("sqlsrv3")->table("DemandRequisition")->where("RId", 'like', '%' . $id . '%')->where("RequisitionType", "=", "Goods")->get();
            return request()->json(200, $arr);
        } else {

            $arr = DB::connection("sqlsrv3")->table("DemandRequisition")->where("RId", 'like', '%' . $id . '%')->where("RequisitionType", "=", "Goods")->paginate($page);
            return request()->json(200, $arr);
        }
    }


    public
    function get_demandrequisition_assets(Request $request)
    {
        $dept = emp_department();
        $totalResult = $request->get("pages");


        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {

        }
        $session = $find_session1->SessionName;
        if ($dept == 'Procurement' || $dept == 'Software Development') {
            if ($totalResult == 'All') {
                $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Assets")->get();
                return request()->json(200, $find_config);
            } else {
                $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Assets")->paginate($totalResult);
                return request()->json(200, $find_config);
            }

        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', company_id())->where('Email', '=', username())->get();
                foreach ($find_user as $find_user1) {

                }
                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;

                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')
                        ->table("DemandRequisition")
                        ->where('CompanyID', company_id())
                        ->where('Session', $session)
                        ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                            $query->where('DepartmentName', 'like', $d1 . '%')
                                ->orWhere('DepartmentName', 'like', $d2 . '%')
                                ->orWhere('DepartmentName', 'like', $d3 . '%')
                                ->orWhere('DepartmentName', 'like', $d4 . '%')
                                ->orWhere('DepartmentName', 'like', $d5 . '%')
                                ->orWhere('DepartmentName', 'like', $d6 . '%');
                        })
                        ->where("RequisitionType", "=", "Assets")
                        ->orderBy('RequisitionId', 'desc')
                        ->get();
                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')
                        ->table("DemandRequisition")
                        ->where('CompanyID', company_id())
                        ->where('Session', $session)
                        ->where(function ($query) use ($d1, $d2, $d3, $d4, $d5, $d6) {
                            $query->where('DepartmentName', 'like', $d1 . '%')
                                ->orWhere('DepartmentName', 'like', $d2 . '%')
                                ->orWhere('DepartmentName', 'like', $d3 . '%')
                                ->orWhere('DepartmentName', 'like', $d4 . '%')
                                ->orWhere('DepartmentName', 'like', $d5 . '%')
                                ->orWhere('DepartmentName', 'like', $d6 . '%');
                        })
                        ->where("RequisitionType", "=", "Assets")
                        ->orderBy('RequisitionId', 'desc')
                        ->paginate($totalResult);

                    return request()->json(200, $find_config);
                }
            } else {
                if ($totalResult == 'All') {
                    $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('DepartmentName', '=', $dept)->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Assets")->get();
                    return request()->json(200, $find_config);
                } else {
                    $find_config = DB::connection('sqlsrv3')->table("DemandRequisition")->where('CompanyID', '=', company_id())->where('DepartmentName', '=', $dept)->where('Session', $session)->orderby('RequisitionId', 'desc')->where("RequisitionType", "=", "Assets")->paginate($totalResult);
                    return request()->json(200, $find_config);
                }
            }


        }
    }

    public
    function update_demandrequisition(Request $request)
    {
        $item_name = $request->get('item_name');
        $unit = $request->get('unit');
        $est_cost = $request->get('est_cost');
        $qty = $request->get('qty');
        $detail = $request->get('detail');
        $id = $request->get('id');
        $narration = $request->get('narration');
        $req_type = $request->get('req_type');
        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $item_nam = explode("|", $item_name);
            $qt = explode("|", $qty);
            $uni = explode("|", $unit);
            $est_cos = explode("|", $est_cost);
            $detai = explode("|", $detail);
            if ($req_type != 'Services' && ($item_nam[$x] == '' || $qt[$x] == '' || $est_cos[$x] == '' || $uni[$x] == '')) {
                $message = 'Empty field';
                return request()->json(200, $message);
            } elseif ($req_type == 'Services' && $detai[$x] == '') {
                $message = 'Empty field';
                return request()->json(200, $message);
            }
        }
        $demandData = [
            'Narration' => $narration,
            'UpdatedBy' => username(),
            'UpdatedOn' => long_date(),
        ];

        DB::connection('sqlsrv3')
            ->table('Requisition')
            ->where('CompanyID', company_id())
            ->where('DemandRID', $id)
            ->update($demandData);

        $reqId = DB::connection('sqlsrv3')
            ->table('Requisition')
            ->where('CompanyID', company_id())
            ->where('DemandRID', $id)
            ->select('RequisitionId')->first();
//return $reqId;
        $result = DB::connection('sqlsrv3')
            ->table('DemandRequisition')
            ->where('CompanyID', company_id())
            ->where('RequisitionId', $id)
            ->update($demandData);

//        $result = DB::connection('sqlsrv3')->update('update  DemandRequisition set Dated=?, DepartmentName=?, ProjectName=?, Narration=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and RequisitionId=?', [$date, $dept_name, $project_name, $narration, username(), long_date(), company_id(), $id]);
        if ($result) {
            for ($x = 1; $x < count($item_name1); $x++) {
                if ($req_type == 'Goods' || $req_type == 'Assets') {
                    $find_itemname1 = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'unit')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->first();
                    $reqItemsData[] = [
                        'ReqID' => $reqId->RequisitionId,
                        'itemId' => $item_nam[$x],
                        'ItemName' => $find_itemname1->Name,
                        'Quantity' => $qt[$x],
                        'unit' => $find_itemname1->unit,
                        'EstCost' => $est_cos[$x],
                        'Detail' => $detai[$x]
                    ];
                    $demandItemsData[] = [
                        'ReqID' => $id,
                        'itemId' => $item_nam[$x],
                        'ItemName' => $find_itemname1->Name,
                        'Quantity' => $qt[$x],
                        'unit' => $find_itemname1->unit,
                        'EstCost' => $est_cos[$x],
                        'Detail' => $detai[$x],
                        'PStatus' => 0
                    ];
                } elseif ($req_type == 'Services') {
                    $demandItemsData[] = [
                        'ReqID' => $id,
                        'itemId' => NULL,
                        'ItemName' => NULL,
                        'Quantity' => $qt[$x],
                        'unit' => 'NOS',
                        'EstCost' => $est_cos[$x],
                        'Detail' => $detai[$x]
                    ];
                    $reqItemsData[] = [
                        'ReqID' => $reqId->RequisitionId,
                        'itemId' => NULL,
                        'ItemName' => NULL,
                        'Quantity' => $qt[$x],
                        'unit' => 'NOS',
                        'EstCost' => $est_cos[$x],
                        'Detail' => $detai[$x]
                    ];
                }
            }
            if (DB::connection('sqlsrv3')->table('DemandRequisitionItem')->where('ReqID', $id)->delete() && DB::connection('sqlsrv3')->table('RequisitionItem')->where('ReqID', $reqId->RequisitionId)->delete()) {
                DB::connection('sqlsrv3')->table('DemandRequisitionItem')->insert($demandItemsData);
                DB::connection('sqlsrv3')->table('RequisitionItem')->insert($reqItemsData);
            }
        }
        $find_config = 'Updated';
        return request()->json(200, $find_config);
    }

    public
    function accounts_upd_demandreq_sts(Request $request)
    {
        $id = employee_id();
        $req_id = $request->get('reqId');
        $req_sts = $request->get('sts');

        $update_date = long_date();
        DB::connection('sqlsrv3')->update('update DemandRequisition set Status=?,ApprovedBy=?,ApprovedOn=? where CompanyID=? and RequisitionId=?', [$req_sts, username(), $update_date, company_id(), $req_id]);

        $service1 = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $req_id)->first();

        DB::connection('sqlsrv3')->update('update Requisition set Status=?,ApprovedBy=?,ApprovedOn=? where CompanyID=? and DemandRID=?', [$req_sts, username(), $update_date, company_id(), $req_id]);
        insertLog('Updating Status of Demand Req ', 'Status of Demand Req of Req Id | ' . $service1->RId . ' | is set to |' . $req_sts . ' ');

        $message = "Status updated!";
        return request()->json(200, $message);
    }

    public
    function get_demandreq_data($id)
    {
        $cand = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public
    function get_demandreq_data1($id)
    {

        $cand = DB::connection('sqlsrv3')->table('DemandRequisitionItem')->Join('ItemList', 'DemandRequisitionItem.itemId', '=', 'ItemList.ID')->where('DemandRequisitionItem.ReqID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public
    function get_reqns()
    {

        $all_reqns = DB::connection('sqlsrv3')->table("DemandRequisition")->where('state', '=', 0)->where('Status', '=', 'Approved')->where('RequisitionType', '=', 'Goods')->where('CompanyID', '=', company_id())->orderby('RequisitionId', 'desc')->get();
        return request()->json(200, $all_reqns);
    }

    public
    function get_reqns1()
    {

        $all_reqns = DB::connection('sqlsrv3')->table("DemandRequisition")->where('state', '=', 0)->where('Status', '=', 'Approved')->where('RequisitionType', '=', 'Goods')->where('CompanyID', '=', company_id())->orderby('RequisitionId', 'desc')->select('DemandRequisition.RequisitionId', 'DemandRequisition.RId', 'DemandRequisition.DepartmentName', 'DemandRequisition.ProjectName',)->get();
        return request()->json(200, $all_reqns);
    }

    public
    function insert_issuance(Request $request)
    {
        $Emp_id = employee_id();
//        $update_date = long_date();
        $session = ac_c_session();
//        $username = username();
        $item_name = $request->get('item_name');
        $unit = $request->get('unit');
        $est_cost = $request->get('est_cost');
        $qty = $request->get('qty');
        $date = $request->get('date');
        $dept_name = $request->get('dept_name');
        $project = $request->get('project');
        $Tamount = $request->get('Total');
        $narration = $request->get('narration');
        $req_id = $request->get('req_id');
        $status = $request->get('status');
        $UnitPrice = $request->get('UnitPrice');
        $update_date = long_date();
        $update_dated = short_date();
        $check_purchase = $request->get('check_purchase');
        $date_pref = $this->shiftformat();
        $req_prefix = 'IS_' . $date_pref;
        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $qt = explode("|", $qty);
//            $item_nam = explode("|", $item_name);
            $UnitCost = explode("|", $UnitPrice);
            if ($qt[$x] < 0) {
                $message = 'Requition quantity cannot be negative';
                return request()->json(200, $message);
            }
            $t_iss_amount = $UnitCost[$x] * $qt[$x];
            if ($t_iss_amount < 0) {
                $message = 'Amount cannot be negative';
                return request()->json(200, $message);
            }
        }
        $find_rid9 = DB::connection('sqlsrv3')->table("Issuances")->where('CompanyID', '=', company_id())->exists();
        if ($find_rid9) {
            $find_rid1 = DB::connection('sqlsrv3')->table("Issuances")->select('IssuanceCode')->where('CompanyID', '=', company_id())->orderBy('IssuanceId', 'desc')->first();

            $pre_id = explode("-", $find_rid1->IssuanceCode);
            $rid = $pre_id[1] + 1;
        } else {
            $rid = 1;
        }
        $final_PoCode = $req_prefix . '-' . $rid;
        if ($status == 1) {
            $status1 = 'Fully Delivered';
        } else {
            $status1 = 'Partially Delivered';
        }
        $item_name9 = explode("|", $item_name);
        for ($b = 1; $b < count($item_name9); $b++) {
            $item_nam91 = explode("|", $item_name);
            $qt9 = explode("|", $qty);
            $ordrqt9 = explode("|", $est_cost);
            if ($ordrqt9[$b] < $qt9[$b]) {
                $message = 'Your Requisition Quantity is ' . $ordrqt9[$b];
                return request()->json(200, $message);
            }
            $find_req_id_sum = DB::connection('sqlsrv3')->table("IssuanceItem")->where('RID', '=', $req_id)->where('itemId', '=', $item_nam91[$b])->sum('IssuanceQuantity');
            $final_qty = $qt9[$b] + $find_req_id_sum;

            $find_req_table_sum = DB::connection('sqlsrv3')->table("DemandRequisitionItem")->where('ReqID', '=', $req_id)->where('itemId', '=', $item_nam91[$b])->sum('Quantity');
            if ($final_qty > $find_req_table_sum) {
                $message = 'You have already issued full quantity against  this requisition';
                return request()->json(200, $message);
            }
        }
        $item_name10 = explode("|", $item_name);
        for ($a = 1; $a < count($item_name10); $a++) {
            $item_nam101 = explode("|", $item_name);
            $qt10 = explode("|", $qty);
            if ($qt10[$a] > 0) {
                $result99 = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[RemainingItem_companywise] @id = N'" . $item_nam101[$a] . "',@compID = N'" . company_id() . "' ");
                if ($result99) {
                    foreach ($result99 as $result101) {

                    }
                    $tot_stock = intval($result101->Remaining);

                    if (intval($qt10[$a]) > $tot_stock) {
                        $message = 'Your Remaining Quantity of ' . $result101->Name . ' is ' . intval($result101->Remaining);

                        return request()->json(200, $message);
                    }
                } else {
                    $message = 'Quantity is Not Available';
                    return request()->json(200, $message);
                }
            }

        }
        try {
//            dd($req_id);
            $result = DB::connection('sqlsrv3')->insert('INSERT INTO Issuances(CompanyID,IssuanceCode,IssuanceDate,RequisitionId,DepartmentName,ProjectName,Status,Narration,CreatedBy,CreatedOn,Session,TotalAmount) values (?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $final_PoCode, $date, $req_id, $dept_name, $project, $status1, $narration, username(), $update_date, $session, $Tamount]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json(['message' => 'Issuance Already Exists.'], 422);

            } else {
                throw $e;
            }
        }
        if ($result) {
            $find_reqid1 = DB::connection('sqlsrv3')->table("Issuances")->select('IssuanceId')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $req_id)->orderBy('IssuanceId', 'desc')->first();

            $item_name1 = explode("|", $item_name);
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $ordrqt = explode("|", $est_cost);
                $uni = explode("|", $unit);
                $qt = explode("|", $qty);
                $UnitCost = explode("|", $UnitPrice);
                $ucost = 0;

                if ($UnitCost[$x] == "") {
                    $ucost = 0;
                } else {
                    $ucost = $UnitCost[$x];
                }

                $SubTotal = $ucost * $qt[$x];


                $find_itemname1 = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->orderBy('ID', 'DESC')->first();

                if ($qt[$x] != 0 || $qt[$x] != 0.00) {
                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO IssuanceItem(IssuanceId,itemId,ItemName,ReqQuantity,unit,IssuanceQuantity,RID,Price,SubTotal) values (?,?,?,?,?,?,?,?,?)', [$find_reqid1->IssuanceId, $item_nam[$x], $find_itemname1->Name, $ordrqt[$x], $uni[$x], $qt[$x], $req_id, $UnitCost[$x], $SubTotal]);
                    $facevalue = '';
                    $check_invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $item_nam[$x])->exists();
                    if ($check_invent) {
                        $invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $item_nam[$x])->select('FaceValue')->orderBy('ID', 'DESC')->first();
                        $facevalue = $invent->FaceValue;
                    } else {
                        $facevalue = 0;
                    }
                    $result9 = DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,CreatedBy,CreatedOn,Reference,Dated,FaceValue) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $item_nam[$x], $qt[$x], $uni[$x], 2, username(), $update_date, 'Issued Item Through ' . $final_PoCode, $update_dated, $facevalue]);
                }
            }
            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$update_dated, $final_PoCode, $final_PoCode . '/' . $dept_name . '/' . $project, 'Issuance', $update_date, username(), company_id()]);
            if ($doc) {
                $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode)->orderBy('ID', 'DESC')->first();

                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $update_dated, 'Inventory to ' . $dept_name . '/' . $project, company_id()]);
                $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                $item_name1 = explode("|", $item_name);
                for ($y = 1; $y < count($item_name1); $y++) {
                    $item_nam = explode("|", $item_name);
                    $ordrqt = explode("|", $est_cost);
                    $uni = explode("|", $unit);
                    $qt = explode("|", $qty);
                    $UnitCost = explode("|", $UnitPrice);

                    if ($qt[$y] != 0 || $qt[$y] != 0.00) {
                        $t_iss_amount = $UnitCost[$y] * $qt[$y];

                        $find_acc_code1 = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ItemId', '=', $item_nam[$y])->orderBy('ID', 'DESC')->first();

                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->CoaID, 'C', $t_iss_amount, company_id()]);
                        $find_acc_code91 = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ProjectName', '=', $project)->orderBy('ID', 'DESC')->first();

                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'D', $t_iss_amount, company_id()]);

                    }
                }
            }
        }


        $check_purchas = explode("|", $check_purchase);

        if (str_contains($check_purchase, 'true')) {
            $find_prefix1 = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('Requisition')->where('CompanyID', '=', company_id())->orderBy('ConfigurationID', 'DESC')->first();

            $date_pref = $this->shiftformat();
            $req_prefix = $find_prefix1->Requisition . '_' . $date_pref;
            $find_rid9 = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', company_id())->exists();
            if ($find_rid9) {
                $find_rid1 = DB::connection('sqlsrv3')->table("Requisition")->select('RId')->where('CompanyID', '=', company_id())->orderBy('RequisitionId', 'desc')->first();

                $pre_id = explode("-", $find_rid1->RId);
                $rid = $pre_id[1] + 1;
            } else {
                $rid = 1;
            }
            $final_rid = $req_prefix . '-' . $rid;
            $status9 = "Approved";
            $find_req_id_type1 = DB::connection('sqlsrv3')->table("DemandRequisition")->where('RequisitionId', '=', $req_id)->where('CompanyID', '=', company_id())->orderBy('RequisitionId', 'DESC')->first();

            $req_type = $find_req_id_type1->RequisitionType;
            $demand_req_Id = $find_req_id_type1->RequisitionId;
            $result = DB::connection('sqlsrv3')->insert('INSERT INTO Requisition(CompanyID,RId,Dated,DepartmentName,ProjectName,Status,Narration,CreatedBy,CreatedOn,Session,RequisitionType,DemandRID) values (?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $final_rid, $update_dated, $dept_name, $project, $status9, $narration, username(), $update_date, $session, $req_type, $demand_req_Id]);

            if ($result) {
                $find_reqid1 = DB::connection('sqlsrv3')->table("Requisition")->select('RequisitionId')->where('CompanyID', '=', company_id())->orderBy('RequisitionId', 'desc')->first();

                $item_name9 = explode("|", $item_name);
                for ($b = 1; $b < count($item_name9); $b++) {
                    $item_nam91 = explode("|", $item_name);
                    $qt9 = explode("|", $qty);
                    $ordrqt9 = explode("|", $est_cost);
                    $check_purchas = explode("|", $check_purchase);
                    if ($check_purchas[$b] == 'true') {
                        $find_itemname1 = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam91[$b])->orderBy('ID', 'DESC')->first();

                        $find_req_id_sum = DB::connection('sqlsrv3')->table("IssuanceItem")->where('RID', '=', $req_id)->where('itemId', '=', $item_nam91[$b])->sum('IssuanceQuantity');
                        $final_qty = $find_req_id_sum;
                        $find_req_id_demand1 = DB::connection('sqlsrv3')->table("DemandRequisitionItem")->where('ReqID', '=', $req_id)->where('itemId', '=', $item_nam91[$b])->orderBy('RequisitionItemId', 'desc')->first();

                        $remaining_item_quantity = $find_req_id_demand1->Quantity - $final_qty;
                        $itemid = $item_nam91[$b];
                        $item_namepo = $find_itemname1->Name;
                        $item_units = $find_req_id_demand1->unit;
                        $item_estcost = $find_req_id_demand1->EstCost;
                        $item_detail = $find_req_id_demand1->Detail;
                        $result = DB::connection('sqlsrv3')->insert('INSERT INTO RequisitionItem(ReqID,itemId,ItemName,Quantity,unit,EstCost,Detail) values (?,?,?,?,?,?,?)', [$find_reqid1->RequisitionId, $itemid, $item_namepo, $remaining_item_quantity, $item_units, $item_estcost, $item_detail]);
                        DB::connection('sqlsrv3')->update('update DemandRequisitionItem set PStatus=? where ReqID=? AND itemId=?', [1, $req_id, $item_nam91[$b]]);
                    }
                }
            }
        }
        DB::connection('sqlsrv3')->update('update DemandRequisition set state=? where CompanyID=? AND RequisitionId=? ', [$status, company_id(), $req_id]);

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $Emp_id, 'New Issuance Created', 'New Issuance | ' . $final_PoCode . ' | against Department | ' . $dept_name . ' | Project Name | ' . $project . ' | has been  created', $update_date]);
        $message = 'submitted';
        return request()->json(200, $message);
    }

    public
    function stock_detailtotal()
    {


        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ; EXEC [dbo].[Stock_Value_Sum]");
        return request()->json(200, $result);
    }

    public
    function get_req_iss($id)
    {
        $company_id = Session::get('company_id');

        $get_requisition_check = DB::connection('sqlsrv3')->table('Requisition')->where('DemandRID', '=', $id)->exists();
        if ($get_requisition_check) {
            $get_requisition = DB::connection('sqlsrv3')->table('Requisition')->where('DemandRID', '=', $id)->orderBy('RequisitionId', 'desc')->first();
        }

        $cand = DB::connection('sqlsrv3')->table('DemandRequisitionItem')->where('ReqID', '=', $id)->get();

        foreach ($cand as $cand1) {
            if ($get_requisition_check) {
                $grn_check = DB::connection('sqlsrv3')->table('GrnOrder')->where('ReqID', '=', $get_requisition->RequisitionId)->join('GrnOrderItems', 'GrnOrderItems.GrnID', '=', 'GrnOrder.GrnOrderID')->where('GrnOrderItems.ItemId', '=', $cand1->itemId)->exists();
                if ($grn_check) {
                    $arr = DB::connection('sqlsrv3')->table('GrnOrder')->where('ReqID', '=', $get_requisition->RequisitionId)->join('GrnOrderItems', 'GrnOrderItems.GrnID', '=', 'GrnOrder.GrnOrderID')->where('GrnOrderItems.ItemId', '=', $cand1->itemId)->avg('Price');
                    $cand1->CostUnit = $arr;
                } else {
                    $arr = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $cand1->itemId)->avg('CostUnit');
                    $cand1->CostUnit = $arr;
                }
            } else {
                $arr = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $cand1->itemId)->avg('CostUnit');
                $cand1->CostUnit = $arr;
            }

        }

        return request()->json(200, $cand);
    }

    public
    function get_re_iss($id)
    {

        $cand = DB::connection('sqlsrv3')->table('DemandRequisition')->where('RequisitionId', '=', $id)->get();
        return request()->json(200, $cand);
    }

//    public
//    function get_issuance_detail()
//    {
//
//        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
//        foreach ($find_session as $find_session1) {
//
//        }
//        $session = $find_session1->SessionName;
//        $find_config = DB::connection('sqlsrv3')->table("Issuances")->join('DemandRequisition', 'Issuances.RequisitionId', '=', 'DemandRequisition.RequisitionId')->where('Issuances.CompanyID', '=', company_id())->where('Issuances.Session', '=', $session)->orderby('Issuances.IssuanceId', 'desc')->select('Issuances.*', 'DemandRequisition.RId')->paginate(20);
//        return request()->json(200, $find_config);
//    }

    public
    function get_requisition_items($id)
    {
        $arr = DB::connection('sqlsrv3')->table('Requisition')->where('RId', '=', $id)->select('RequisitionId')->get();
        foreach ($arr as $arr1) {
        }

        $cand = DB::connection('sqlsrv3')->table('RequisitionItem')->where('ReqID', '=', $arr1->RequisitionId)->get();
        return request()->json(200, $cand);
    }

    public
    function get_allrequisition1($id)
    {
        $arr = DB::connection('sqlsrv3')->table("Requisition")->where("RId", '=', $id)->select("RequisitionType", 'RequisitionId')->get();
        foreach ($arr as $arr1) {

        }


        $find_config = DB::connection('sqlsrv3')->select("SELECT * FROM Requisition WHERE (Status='Approved') AND (RequisitionType!='Services')  AND (q1 = 'Added' or q1 IS NULL) AND (q2 = 'Added' or q2 IS NULL) AND (q3 = 'Added' or q3 IS NULL) AND (q4 = 'Added' or q4 IS NULL) AND (q5 = 'Added' or q5 IS NULL) AND (q6 = 'Added' or q6 IS NULL) AND (RequisitionId !=" . $arr1->RequisitionId . ")AND (RequisitionType = '" . $arr1->RequisitionType . "') ORDER BY RequisitionId desc ");

        return request()->json(200, $find_config);
    }

    public
    function get_allrequisition()
    {


        $find_config = DB::connection('sqlsrv3')->select("SELECT * FROM Requisition WHERE (Status='Approved') AND (RequisitionType!='Services') AND (q1 = 'Added' or q1 IS NULL) AND (q2 = 'Added' or q2 IS NULL) AND (q3 = 'Added' or q3 IS NULL) AND (q4 = 'Added' or q4 IS NULL) AND (q5 = 'Added' or q5 IS NULL) AND (q6 = 'Added' or q6 IS NULL) ORDER BY RequisitionId desc");
        return request()->json(200, $find_config);
    }

    public
    function insert_mergerequisition(Request $request)
    {


        $id = employee_id();
        $session = ac_c_session();

        $item_name = $request->get('item_name');
        $unit = $request->get('unit');
        $est_cost = $request->get('est_cost');
        $qty = $request->get('qty');
        $detail = $request->get('detail');
        $date = $request->get('date');
        $dept_name = $request->get('dept_name');
        $project_name = $request->get('project_name');
        $narration = $request->get('narration');
        $primary_pr = $request->get('primary_pr');
        $secondary_pr = $request->get('secondary_pr');
        $sec_pr = explode("|", $secondary_pr);
        $status2 = $request->get('status');
        for ($y = 0; $y < count($sec_pr); $y++) {
            $data1 = DB::connection('sqlsrv3')->update('update  Requisition set Status=? where RId=? and RequisitionType !=?', ['merged', $sec_pr[$y], 'Services']);

        }
        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $item_nam = explode("|", $item_name);
            if ($status2 == 'Goods' || $status2 == 'Assets') {
                for ($y = $x + 1; $y <= (count($item_name1)) - 1; $y++) {
                    $item_nam = explode("|", $item_name);
                    if ($item_nam[$y] == $item_nam[$x]) {
                        $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'unit')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                        foreach ($find_itemname as $find_itemname1) {

                        }
                        $find_config = 'At index ' . $y . ' item ' . $find_itemname1->Name . ' could not be add more then once';
                        return request()->json(200, $find_config);
                    }
                }
            }
            $qt = explode("|", $qty);
            $uni = explode("|", $unit);
            $est_cos = explode("|", $est_cost);
            $detai = explode("|", $detail);
            if ($item_nam[$x] == '' || $qt[$x] == '' || $uni[$x] == '' || $est_cos[$x] == '') {
                $find_config = "Empty field";
                return request()->json(200, $find_config);
            }
        }
        $find_prefix = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('Requisition')->where('CompanyID', '=', company_id())->get();
        foreach ($find_prefix as $find_prefix1) {

        }
        $date_pref = $this->shiftformat();
        $req_prefix = $find_prefix1->Requisition . '_MR' . '_' . $date_pref;
        $find_rid9 = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', company_id())->exists();
        if ($find_rid9) {
            $find_rid = DB::connection('sqlsrv3')->table("Requisition")->select('RId')->where('CompanyID', '=', company_id())->get();
            foreach ($find_rid as $find_rid1) {

            }
            $pre_id = explode("-", $find_rid1->RId);
            $rid = $pre_id[1] + 1;
        } else {
            $rid = 1;
        }
        $final_rid = $req_prefix . '-' . $rid;
        $status = "Pending";

        $update_date = long_date();
        $find_rid2 = DB::connection('sqlsrv3')->table("Requisition")->select('RequisitionType', 'DemandRID')->where('RequisitionType', '!=', 'Services')->where('CompanyID', '=', company_id())->where('RId', '=', $primary_pr)->get();
        foreach ($find_rid2 as $find_rid21) {

        }
        $result = DB::connection('sqlsrv3')->insert('INSERT INTO Requisition(CompanyID,RId,Dated,DepartmentName,ProjectName,Status,Narration,CreatedBy,CreatedOn,Session,RequisitionType,DemandRID) values (?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $final_rid, $date, $dept_name, $project_name, $status2, $narration, username(), $update_date, $session, $find_rid21->RequisitionType, $find_rid21->DemandRID]);
        if ($result) {
            $find_reqid = DB::connection('sqlsrv3')->table("Requisition")->select('RequisitionId')->where('RequisitionType', '!=', 'Services')->where('RId', '=', $final_rid)->where('CompanyID', '=', company_id())->get();
            foreach ($find_reqid as $find_reqid1) {
            }
            $item_name1 = explode("|", $item_name);
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $qt = explode("|", $qty);
                $uni = explode("|", $unit);
                $est_cos = explode("|", $est_cost);
                $detai = explode("|", $detail);
                if ($qt[$x] < 0) {
                    $qt[$x] = 0;
                }
                if ($find_rid21->RequisitionType == 'Goods' || $find_rid21->RequisitionType == 'Assets') {
                    $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name', 'unit')->where('CompanyID', '=', company_id())->where('ID', '=', $item_nam[$x])->get();
                    foreach ($find_itemname as $find_itemname1) {

                    }
                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO RequisitionItem(ReqID,itemId,ItemName,Quantity,unit,EstCost,Detail) values (?,?,?,?,?,?,?)', [$find_reqid1->RequisitionId, $item_nam[$x], $find_itemname1->Name, $qt[$x], $find_itemname1->unit, $est_cos[$x], $detai[$x]]);
                } elseif ($find_rid21->RequisitionType == 'Services') {
                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO RequisitionItem(ReqID,Quantity,unit,EstCost,Detail) values (?,?,?,?,?)', [$find_reqid1->RequisitionId, $qt[$x], 'NOS', $est_cos[$x], $detai[$x]]);
                }
            }
        }
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $id, 'Purchase Requisiton Merged', 'Purchase Requsiition ' . $secondary_pr . ' | Merged with | Primary Purchase Requisition | ' . $primary_pr . ' | Project Name | ' . $project_name . '', $update_date]);
        $find_config = "submitted";
        return request()->json(200, $find_config);
    }


    public
    function get_requisition_multipleitems(Request $request)
    {
        $id = $request->get("id");
        $multiple = explode("|", $id);
        $mularr = [];

        for ($x = 1; $x < count($multiple); $x++) {
            $arr = DB::connection('sqlsrv3')->table('Requisition')->where('RId', '=', $multiple[$x])->select('RequisitionId')->where('RequisitionType', '!=', 'Services')->get();
            foreach ($arr as $arr1) {

                $cand = DB::connection('sqlsrv3')->table('RequisitionItem')->where('ReqID', '=', $arr1->RequisitionId)->get();
                array_push($mularr, $cand);
            }

        }
        $Array = Arr::flatten($mularr);
        return request()->json(200, $Array);
    }

    public
    function Get_req_Detail($id)
    {
        $ItemDetail = [];
        $Rdetail = [];

        $Data = DB::connection('sqlsrv3')->table('DemandRequisitionItem')->where('ReqID', '=', $id)->get();

        foreach ($Data as $data1) {
            $ItemId = $data1->itemId;
            $qty = $data1->Quantity;

            $result10 = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[RemainingItem_companywise] @id = " . $ItemId . ",@compID = N'" . company_id() . "' ");
            foreach ($result10 as $result101) {

            }

            array_push($ItemDetail, (object)$result101);
        }
        return request()->json(200, $ItemDetail);
    }


    public
    function get_itemIssDetail($id)
    {

        $find_iss_table_sum = DB::connection('sqlsrv3')->select("select sum(IssuanceQuantity) as Issuedquantity ,ItemName from IssuanceItem
where RID = '" . $id . "'
group by ItemName  ");
        return request()->json(200, $find_iss_table_sum);
    }

    public
    function demand_requisition_all()
    {

        $arr = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->select('RequisitionId', 'RId')->orderby('RequisitionId', 'desc')->get();
        return request()->json(200, $arr);

    }

    public
    function DemandReqTrackingReport($id)
    {

        $my_arr = DB::connection('sqlsrv3')->table('DemandRequisition')->where('CompanyID', '=', company_id())->where('RId', '=', $id)->select('RequisitionId')->get();
        foreach ($my_arr as $my_arr1) {
        }
        $rid = $my_arr1->RequisitionId;

        $this->fpdf->AddPage("L", ['280', '282']);
        $this->fpdf->SetFont('Times', 'B', 18);
        $this->fpdf->SetTextColor(41, 46, 46);

        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {

        }
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(80, 17, 'Demand Requisition Tracking Report');
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 220, 7, 43, 15);

        $Pur_Req = [];
        $purReq = DB::connection('sqlsrv3')->table('Requisition')->where('Requisition.RequisitionId', '=', $rid)->select('RequisitionId')->get();
        foreach ($purReq as $purReq1) {


        }

        //  return $Pur_Req1;


        //Purchase Demand Report **********************
        $array7 = [];
        $data = DB::connection('sqlsrv3')->table('DemandRequisition')->where('DemandRequisition.CompanyID', '=', company_id())->where('DemandRequisition.RequisitionId', '=', $rid)->select('DemandRequisition.*')->get();
        array_push($array7, $data);
        $array77 = Arr::flatten($array7);
        foreach ($array77 as $array771) {
            $a = $array771->RequisitionId;

            if ($a != null) {

                $this->fpdf->ln(30);
                $this->fpdf->SetFont('Times', 'B', 12);
                $this->fpdf->Cell(18, 6, 'Demand Requisition', 0, 0, 'L', 0);
                $this->fpdf->ln(7);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->SetTextColor(41, 46, 46);
                $this->fpdf->Cell(18, 6, 'Dated', 1, 0, 'C', 0);
                $this->fpdf->Cell(23, 6, 'DR ID', 1, 0, 'C', 0);
                $this->fpdf->Cell(60, 6, 'Department', 1, 0, 'C', 0);
                $this->fpdf->Cell(45, 6, 'Project', 1, 0, 'C', 0);
                $this->fpdf->SetX(165);
                $this->fpdf->Cell(58, 6, 'ItemName', 1, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, 'Req.Qty', 1, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, 'Unit', 1, 0, 'C', 0);
                $this->fpdf->Cell(18, 6, 'Item Code', 1, 0, 'C', 0);
            }
        }
        $find = '';
        $data = DB::connection('sqlsrv3')->table('DemandRequisition')->where('DemandRequisition.CompanyID', '=', company_id())->where('DemandRequisition.RequisitionId', '=', $rid)->select('DemandRequisition.*')->get();
        $find = $data;
        $arr = DB::connection('sqlsrv3')->table('DemandRequisitionItem')->where('DemandRequisitionItem.ReqID', '=', $rid)->join('ItemList', 'ItemList.ID', '=', 'DemandRequisitionItem.itemId')->select('DemandRequisitionItem.*', 'ItemList.ItemCode')->get();
        foreach ($find as $find_config1) {
            $this->fpdf->ln(10);
            $this->fpdf->Cell(18, 6, $find_config1->Dated, 0, 0, 'L', 0);
            $this->fpdf->Cell(23, 6, $find_config1->RId, 0, 0, 'L', 0);
            $this->fpdf->Cell(60, 6, Str::substr($find_config1->DepartmentName, 0, 35), 0, 0, 'L', 0);
            $this->fpdf->Cell(45, 6, Str::substr($find_config1->ProjectName, 0, 29), 0, 0, 'C', 0);
            $this->fpdf->ln(1);
            foreach ($arr as $arr1) {
                $this->fpdf->SetX(165);
                $this->fpdf->Cell(58, 6, (Str::substr($arr1->ItemName, 0, 40)), 0, 0, 'L', 0);
                $this->fpdf->Cell(15, 6, number_format($arr1->Quantity), 0, 0, 'L', 0);
                $this->fpdf->Cell(15, 6, $arr1->unit, 0, 0, 'L', 0);
                $this->fpdf->Cell(18, 6, $arr1->ItemCode, 0, 0, 'L', 0);
                $this->fpdf->ln(5);
            }
        }
        //Issuance Report**********************//
        $array6 = [];
        $checkPR = DB::connection('sqlsrv3')->table('Issuances')->where('Issuances.RequisitionId', '=', $rid)->select('IssuanceId')->get();
        array_push($array6, $checkPR);
        $array66 = Arr::flatten($array6);
        //  return $array66;
        if ($array66 != []) {
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(18, 6, 'Issuance Detail', 0, 0, 'L', 0);
            $this->fpdf->ln(7);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Cell(18, 6, 'Dated', 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, 'I ID', 1, 0, 'C', 0);
            $this->fpdf->Cell(45, 6, 'Department', 1, 0, 'C', 0);
            $this->fpdf->Cell(30, 6, 'Project', 1, 0, 'C', 0);
            $this->fpdf->Cell(28, 6, 'Status', 1, 0, 'C', 0);
            $this->fpdf->SetX(165);
            $this->fpdf->Cell(45, 6, 'ItemName', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Req.Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'I.Qty', 1, 0, 'C', 0);
        }
        $checkPR = DB::connection('sqlsrv3')->table('Issuances')->where('Issuances.RequisitionId', '=', $rid)->select('IssuanceId')->exists();
        if ($checkPR) {
            $issu_data = DB::connection('sqlsrv3')->table('Issuances')->where('Issuances.CompanyID', '=', company_id())->where('Issuances.RequisitionId', '=', $rid)->select('Issuances.*')->get();


            foreach ($issu_data as $find_config5) {
                $arr5 = DB::connection('sqlsrv3')->table('IssuanceItem')->where('IssuanceItem.IssuanceId', '=', $find_config5->IssuanceId)->select('IssuanceItem.*')->get();
                $this->fpdf->ln(10);
                $this->fpdf->Cell(18, 6, $find_config5->IssuanceDate, 0, 0, 'L', 0);
                $this->fpdf->Cell(25, 6, $find_config5->IssuanceCode, 0, 0, 'L', 0);
                $this->fpdf->Cell(45, 6, (Str::substr($find_config5->DepartmentName, 0, 22)), 0, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, (Str::substr($find_config5->ProjectName, 0, 15)), 0, 0, 'L', 0);
                $this->fpdf->Cell(28, 6, $find_config5->Status, 0, 0, 'L', 0);
                $this->fpdf->ln(1);
                foreach ($arr5 as $arr55) {
                    $this->fpdf->SetX(165);
                    $this->fpdf->Cell(45, 6, (Str::substr($arr55->ItemName, 0, 30)), 0, 0, 'L', 0);
                    $this->fpdf->Cell(20, 6, number_format($arr55->ReqQuantity), 0, 0, 'L', 0);
                    $this->fpdf->Cell(20, 6, $arr55->unit, 0, 0, 'L', 0);
                    $this->fpdf->Cell(20, 6, number_format($arr55->IssuanceQuantity), 0, 0, 'L', 0);
                    $this->fpdf->ln(5);
                }
            }
        }
//Purchase Requisition Report**********************//
        $array5 = [];
        $checkPR = DB::connection('sqlsrv3')->table('Requisition')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.DemandRID', '=', $rid)->select('Requisition.DemandRID')->get();
        array_push($array5, $checkPR);
        $array55 = Arr::flatten($array5);
        if ($array55 != []) {
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(18, 6, 'Purchase Requisition', 0, 0, 'L', 0);
            $this->fpdf->ln(7);
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Cell(18, 6, 'Dated', 1, 0, 'C', 0);
            $this->fpdf->Cell(28, 6, 'R ID', 1, 0, 'C', 0);
            $this->fpdf->Cell(55, 6, 'Department', 1, 0, 'C', 0);
            $this->fpdf->Cell(45, 6, 'Project', 1, 0, 'C', 0);

            $this->fpdf->SetX(165);
            $this->fpdf->Cell(45, 6, 'ItemName', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Qty', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Unit', 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, 'Per unit', 1, 0, 'C', 0);
        }
        if ($checkPR) {
            $dataPRtable = DB::connection('sqlsrv3')->table('Requisition')->where('Requisition.CompanyID', '=', company_id())->where('Requisition.DemandRID', '=', $rid)->get();
            $find11111 = $dataPRtable;
            array_push($Pur_Req, $dataPRtable);

            $Pur_Req1 = Arr::flatten($Pur_Req);

            foreach ($find11111 as $find_config5) {
                $arr5 = DB::connection('sqlsrv3')->table('RequisitionItem')->where('RequisitionItem.ReqID', '=', $find_config5->RequisitionId)->select('RequisitionItem.*')->get();
                $this->fpdf->ln(10);
                $this->fpdf->Cell(18, 6, $find_config5->Dated, 0, 0, 'L', 0);
                $this->fpdf->Cell(28, 6, $find_config5->RId, 0, 0, 'L', 0);
                $this->fpdf->Cell(55, 6, (Str::substr($find_config5->DepartmentName, 0, 37)), 0, 0, 'C', 0);
                $this->fpdf->Cell(45, 6, (Str::substr($find_config5->ProjectName, 0, 30)), 0, 0, 'L', 0);

                $this->fpdf->ln(1);
                foreach ($arr5 as $arr55) {
                    $this->fpdf->SetX(165);
                    $this->fpdf->Cell(45, 6, (Str::substr($arr55->ItemName, 0, 30)), 0, 0, 'L', 0);
                    $this->fpdf->Cell(20, 6, number_format($arr55->Quantity), 0, 0, 'L', 0);
                    $this->fpdf->Cell(20, 6, $arr55->unit, 0, 0, 'L', 0);
                    $this->fpdf->Cell(20, 6, number_format($arr55->EstCost), 0, 0, 'L', 0);
                    $this->fpdf->ln(5);
                }
            }
            //Quotation Report****************//
            $Q_data = [];

            foreach ($Pur_Req1 as $Pur_Req12) {
                $checkPR = DB::connection('sqlsrv3')->table('PQuotation')->where('PQuotation.CompanyID', '=', company_id())->where('PQuotation.RequisitionID', '=', $Pur_Req12->RequisitionId)->select('PQuotation.*')->get();
                array_push($Q_data, $checkPR);
            }
            $Q_data1 = Arr::flatten($Q_data);


            if ($Q_data1 != []) {
                $this->fpdf->ln(10);
                $this->fpdf->SetFont('Times', 'B', 12);
                $this->fpdf->Cell(18, 6, 'Quotation Detail', 0, 0, 'L', 0);
                $this->fpdf->ln(7);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->SetTextColor(41, 46, 46);
                $this->fpdf->Cell(20, 6, 'QDate', 1, 0, 'C', 0);
                $this->fpdf->Cell(80, 6, 'VendorName', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'Status', 1, 0, 'C', 0);
                $this->fpdf->Cell(21, 6, 'Amount', 1, 0, 'C', 0);
                $this->fpdf->SetX(165);
                $this->fpdf->Cell(57, 6, 'ItemName', 1, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, 'Qu.Qty', 1, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, 'Price', 1, 0, 'C', 0);
                $this->fpdf->Cell(18, 6, 'Total', 1, 0, 'C', 0);
            }
            if ($Q_data1 != []) {
                foreach ($Pur_Req1 as $Pur_Req12) {
                    $checkPR = DB::connection('sqlsrv3')->table('PQuotation')->where('PQuotation.CompanyID', '=', company_id())->where('PQuotation.RequisitionID', '=', $Pur_Req12->RequisitionId)->select('PQuotation.*')->get();
                    foreach ($checkPR as $find_config2) {
                        $arr2 = DB::connection('sqlsrv3')->table('PQuotationItems')->join('PQuotation', 'PQuotation.QuotationID', '=', 'PQuotationItems.QuotationID')->where('PQuotation.QuotationID', '=', $find_config2->QuotationID)->select('PQuotationItems.*')->get();
                        $this->fpdf->ln(10);
                        $this->fpdf->Cell(20, 6, $find_config2->QuotationDate, 0, 0, 'L', 0);
                        $this->fpdf->Cell(80, 6, substr($find_config2->VendorName, 0, 65), 0, 0, 'L', 0);
                        $this->fpdf->Cell(25, 6, $find_config2->Status, 0, 0, 'C', 0);
                        $this->fpdf->Cell(21, 6, number_format($find_config2->Total), 0, 0, 'L', 0);
                        $this->fpdf->ln(1);
                        foreach ($arr2 as $arr22) {
                            $this->fpdf->SetX(165);
                            $this->fpdf->Cell(57, 6, (Str::substr($arr22->ItemName, 0, 30)), 0, 0, 'L', 0);
                            $this->fpdf->Cell(15, 6, number_format($arr22->Quantity), 0, 0, 'L', 0);
                            $this->fpdf->Cell(15, 6, number_format($arr22->Price), 0, 0, 'L', 0);
                            $this->fpdf->Cell(18, 6, number_format($arr22->Total), 0, 0, 'L', 0);
                            $this->fpdf->ln(5);
                        }
                    }
                }
            }

            //PO Report****************//

            $Po_Id = [];
            foreach ($Q_data1 as $Q_data12) {
                $checkQu = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('PurchaseOrder.AgainstQuo', '=', $Q_data12->QuotationID)->get();
                array_push($Po_Id, $checkQu);
            }
            $Po_Id1 = Arr::flatten($Po_Id);
            //return $Po_Id1;
            if ($Po_Id1 != []) {
                $this->fpdf->ln(10);
                $this->fpdf->SetFont('Times', 'B', 12);
                $this->fpdf->Cell(18, 6, 'Purchase Order Detail', 0, 0, 'L', 0);
                $this->fpdf->ln(7);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->SetTextColor(41, 46, 46);
                $this->fpdf->Cell(18, 6, 'PODate', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'PO ID', 1, 0, 'C', 0);
                $this->fpdf->Cell(65, 6, 'VendorName', 1, 0, 'C', 0);
                $this->fpdf->Cell(18, 6, 'Status', 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, 'Amount', 1, 0, 'C', 0);
                $this->fpdf->SetX(165);
                $this->fpdf->Cell(43, 6, 'ItemName', 1, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, 'Order Qty', 1, 0, 'C', 0);
                $this->fpdf->Cell(14, 6, 'Unit', 1, 0, 'C', 0);
                $this->fpdf->Cell(13, 6, 'Price', 1, 0, 'C', 0);
                $this->fpdf->Cell(19, 6, 'Total', 1, 0, 'C', 0);

            }

            if ($Po_Id1 != []) {
                foreach ($Q_data1 as $Q_data12) {
                    $data11 = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('PurchaseOrder.CompanyID', '=', company_id())->where('PurchaseOrder.AgainstQuo', '=', $Q_data12->QuotationID)->select('PurchaseOrder.*')->get();
                    $find11 = $data11;
                    foreach ($find11 as $find_config3) {
                        $arr = DB::connection('sqlsrv3')->table('PurchaseOrderItems')->where('PurchaseOrderItems.POID', '=', $find_config3->PurchaseOrderID)->select('PurchaseOrderItems.*')->get();
                        $this->fpdf->ln(10);
                        $this->fpdf->Cell(18, 6, $find_config3->PoDate, 0, 0, 'L', 0);
                        $this->fpdf->Cell(25, 6, $find_config3->PoCode, 0, 0, 'L', 0);
                        $this->fpdf->Cell(65, 6, substr($find_config3->vendorName, 0, 60), 0, 0, 'L', 0);
                        $this->fpdf->Cell(18, 6, $find_config3->Status, 0, 0, 'C', 0);
                        $this->fpdf->Cell(20, 6, number_format($find_config3->TotalAmount), 0, 0, 'L', 0);
                        $this->fpdf->ln(1);
                        foreach ($arr as $arr1) {
                            $this->fpdf->SetX(165);
                            $this->fpdf->Cell(43, 6, (Str::substr($arr1->ItemName, 0, 25)), 0, 0, 'L', 0);
                            $this->fpdf->Cell(15, 6, number_format($arr1->Quantity), 0, 0, 'L', 0);
                            $this->fpdf->Cell(14, 6, $arr1->Unit, 0, 0, 'L', 0);
                            $this->fpdf->Cell(13, 6, number_format($arr1->Price), 0, 0, 'L', 0);
                            $this->fpdf->Cell(19, 6, number_format($arr1->SubTotal), 0, 0, 'L', 0);

                            $this->fpdf->ln(5);
                        }
                    }
                }
            }


//GRN Report****************

            $Grn_id = [];
            foreach ($Po_Id1 as $Po_Id12) {
                $checkgrn = DB::connection('sqlsrv3')->table('GrnOrder')->where('GrnOrder.CompanyID', '=', company_id())->where('GrnOrder.POID', '=', $Po_Id12->PurchaseOrderID)->select('GrnOrder.*')->get();
                array_push($Grn_id, $checkgrn);
            }
            $Grn_id1 = Arr::flatten($Grn_id);
            if ($Grn_id1 != []) {
                $this->fpdf->ln(10);
                $this->fpdf->SetFont('Times', 'B', 12);
                $this->fpdf->Cell(18, 6, 'GRN Detail', 0, 0, 'L', 0);
                $this->fpdf->ln(7);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->SetTextColor(41, 46, 46);
                $this->fpdf->Cell(21, 6, 'Dated', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'GRN ID', 1, 0, 'C', 0);
                $this->fpdf->Cell(50, 6, 'Vendor', 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, 'Status', 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, 'Status2', 1, 0, 'C', 0);
                $this->fpdf->SetX(165);
                $this->fpdf->Cell(39, 6, 'ItemName', 1, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, 'PO.Qty', 1, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, 'Rev.Qty', 1, 0, 'C', 0);
                $this->fpdf->Cell(17, 6, 'Price', 1, 0, 'C', 0);
                $this->fpdf->Cell(18, 6, 'Unit', 1, 0, 'C', 0);
            }
            if ($Grn_id1 != []) {
                foreach ($Po_Id1 as $Po_Id12) {
                    $data111 = DB::connection('sqlsrv3')->table('GrnOrder')->join('PurchaseOrder', 'GrnOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->where('GrnOrder.CompanyID', '=', company_id())->where('GrnOrder.POID', '=', $Po_Id12->PurchaseOrderID)->select('GrnOrder.*', 'PurchaseOrder.vendorName')->get();
                    $find111 = $data111;
                    foreach ($find111 as $find_config4) {
                        $arr4 = DB::connection('sqlsrv3')->table('GrnOrderItems')->where('GrnOrderItems.GrnID', '=', $find_config4->GrnOrderID)->select('GrnOrderItems.*')->get();
                        $this->fpdf->ln(10);
                        $this->fpdf->Cell(21, 6, $find_config4->Dated, 0, 0, 'L', 0);
                        $this->fpdf->Cell(25, 6, $find_config4->GrnID, 0, 0, 'L', 0);
                        $this->fpdf->Cell(50, 6, substr($find_config4->vendorName, 0, 35), 0, 0, 'L', 0);
                        $this->fpdf->Cell(30, 6, $find_config4->Status, 0, 0, 'L', 0);
                        $this->fpdf->Cell(20, 6, $find_config4->Status2, 0, 0, 'C', 0);
                        $this->fpdf->ln(1);
                        foreach ($arr4 as $arr44) {
                            $this->fpdf->SetX(165);
                            $this->fpdf->Cell(39, 6, (Str::substr($arr44->ItemName, 0, 21)), 0, 0, 'L', 0);
                            $this->fpdf->Cell(15, 6, number_format($arr44->PoQuantity), 0, 0, 'L', 0);
                            $this->fpdf->Cell(15, 6, number_format($arr44->RecvdQuantity), 0, 0, 'L', 0);
                            $this->fpdf->Cell(17, 6, number_format($arr44->Price), 0, 0, 'L', 0);
                            $this->fpdf->Cell(18, 6, $arr44->Unit, 0, 0, 'L', 0);
                            $this->fpdf->ln(5);
                        }
                    }
                }
            }

//Purchase Invoice(Receiving Order Table)

            $Pinv_Id = [];
            foreach ($Grn_id1 as $Grn_id12) {
                $checkGRN = DB::connection('sqlsrv3')->table('ReceivingOrder')->where('ReceivingOrder.GRNID', '=', $Grn_id12->GrnOrderID)->get();
                array_push($Pinv_Id, $checkGRN);
            }
            $Pinv_Id1 = Arr::flatten($Pinv_Id);

            if ($Pinv_Id1 != []) {
                $this->fpdf->ln(10);
                $this->fpdf->SetFont('Times', 'B', 12);
                $this->fpdf->Cell(18, 6, 'Purchase Invoice Detail', 0, 0, 'L', 0);
                $this->fpdf->ln(7);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->SetTextColor(41, 46, 46);
                $this->fpdf->Cell(20, 6, 'Dated', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'Inv ID', 1, 0, 'C', 0);
                $this->fpdf->Cell(51, 6, 'Vendor', 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, 'Status', 1, 0, 'C', 0);
                $this->fpdf->Cell(20, 6, 'Status2', 1, 0, 'C', 0);
                $this->fpdf->SetX(165);
                $this->fpdf->Cell(39, 6, 'ItemName', 1, 0, 'C', 0);
                $this->fpdf->Cell(16, 6, 'PO.Qty', 1, 0, 'C', 0);
                $this->fpdf->Cell(16, 6, 'Rec.Qty', 1, 0, 'C', 0);
                $this->fpdf->Cell(15, 6, 'Price', 1, 0, 'C', 0);
                $this->fpdf->Cell(17, 6, 'Total', 1, 0, 'C', 0);
            }

            if ($Pinv_Id1 != []) {
                foreach ($Grn_id1 as $Grn_id12) {
                    $data11111 = DB::connection('sqlsrv3')->table('ReceivingOrder')->where('ReceivingOrder.CompanyID', '=', company_id())->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'ReceivingOrder.POID')->where('ReceivingOrder.GRNID', '=', $Grn_id12->GrnOrderID)->select('ReceivingOrder.*', 'PurchaseOrder.vendorName')->get();
                    $findthis = $data11111;
                    foreach ($findthis as $find_config6) {
                        $arr4 = DB::connection('sqlsrv3')->table('ReceivingOrderItems')->where('ReceivingOrderItems.ROID', '=', $find_config6->ReceavingOrderID)->select('ReceivingOrderItems.*')->get();
                        $this->fpdf->ln(10);
                        $this->fpdf->Cell(20, 6, $find_config6->Dated, 0, 0, 'L', 0);
                        $this->fpdf->Cell(25, 6, $find_config6->FormID, 0, 0, 0, 0, 'L', 0);
                        $this->fpdf->Cell(51, 6, (Str::substr($find_config6->vendorName, 0, 35)), 0, 0, 'C', 0);
                        $this->fpdf->Cell(30, 6, $find_config6->Status, 0, 0, 0, 0, 'L', 0);
                        $this->fpdf->Cell(20, 6, (Str::substr($find_config6->Status2, 0, 25)), 0, 0, 'C', 0);
                        $this->fpdf->ln(1);
                        foreach ($arr4 as $arr44) {
                            $this->fpdf->SetX(165);
                            $this->fpdf->Cell(39, 6, (Str::substr($arr44->ItemName, 0, 21)), 0, 0, 'L', 0);
                            $this->fpdf->Cell(16, 6, number_format($arr44->PoQuantity), 0, 0, 'L', 0);
                            $this->fpdf->Cell(16, 6, number_format($arr44->RecvdQuantity), 0, 0, 'L', 0);
                            $this->fpdf->Cell(15, 6, number_format($arr44->Price), 0, 0, 'L', 0);
                            $this->fpdf->Cell(17, 6, number_format($arr44->SubTotal), 0, 0, 'L', 0);
                            $this->fpdf->ln(5);
                        }
                    }
                }
            }


//payment voucher
            $pv_Id = [];
            foreach ($Pinv_Id1 as $Pinv_Id12) {
                $checkInv = DB::connection('sqlsrv3')->table('PaymentVoucherDetail')->join('PaymentVoucher', 'PaymentVoucher.PaymentVoucherID', '=', 'PaymentVoucherDetail.PID')->where('PaymentVoucherDetail.AgainstINV', '=', $Pinv_Id12->FormID)->get();
                array_push($pv_Id, $checkInv);
            }
            $pv_Id1 = Arr::flatten($pv_Id);
            if ($pv_Id1 != []) {
                $this->fpdf->ln(10);
                $this->fpdf->SetFont('Times', 'B', 12);
                $this->fpdf->Cell(18, 6, 'Payment Voucher Detail', 0, 0, 'L', 0);
                $this->fpdf->ln(7);
                $this->fpdf->SetFont('Times', '', 10);
                $this->fpdf->SetTextColor(41, 46, 46);
                $this->fpdf->Cell(20, 6, 'Dated', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'PV ID', 1, 0, 'C', 0);
                $this->fpdf->Cell(69, 6, 'Payment To', 1, 0, 'C', 0);
                $this->fpdf->Cell(44, 6, 'AccountID', 1, 0, 'C', 0);
                $this->fpdf->Cell(35, 6, 'Status', 1, 0, 'C', 0);
                $this->fpdf->Cell(35, 6, 'Amount', 1, 0, 'C', 0);
                $this->fpdf->Cell(25, 6, 'Inv ID', 1, 0, 'C', 0);
            }


            if ($pv_Id1 != []) {

                foreach ($Pinv_Id1 as $Pinv_Id12) {

                    $data111111 = DB::connection('sqlsrv3')->table('PaymentVoucherDetail')->join('PaymentVoucher', 'PaymentVoucher.PaymentVoucherID', '=', 'PaymentVoucherDetail.PID')->where('PaymentVoucherDetail.AgainstINV', '=', $Pinv_Id12->FormID)->select('PaymentVoucher.*', 'PaymentVoucherDetail.AgainstINV as inv_id')->get();
                    $findthis = $data111111;
                    foreach ($findthis as $find_config6) {

                        $this->fpdf->ln(10);
                        $this->fpdf->Cell(20, 6, $find_config6->VoucherDate, 0, 0, 'L', 0);
                        $this->fpdf->Cell(25, 6, $find_config6->PVID, 0, 0, 'L', 0);
                        $this->fpdf->Cell(69, 6, (Str::substr($find_config6->PaymentAgainst, 0, 45)), 'C', 0);
                        $this->fpdf->Cell(44, 6, $find_config6->AccountID, 0, 0, 'C', 0);
                        $this->fpdf->Cell(35, 6, $find_config6->Status, 0, 0, 'L', 0);
                        $this->fpdf->Cell(35, 6, number_format($find_config6->Amount), 0, 0, 'L', 0);
                        $this->fpdf->Cell(25, 6, $find_config6->inv_id, 0, 30, 0, 0, 'L', 0);

                        $this->fpdf->ln(5);


                    }

                }
            }


            $this->fpdf->ln(2);
            $this->fpdf->Output();
            exit;
        }

    }

    public
    function IncomeStatment_GrossProfit($start_date, $end_date)
    {

        $result = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[IncomeStatment_GrossProfit]
  @date1  = N'" . $start_date . "',
  @date2  = N'" . $end_date . "'");

        return request()->json(200, $result);
    }

    public
    function get_demandreq_services($id)
    {

        $cand = DB::connection('sqlsrv3')->table('DemandRequisitionItem')->where('DemandRequisitionItem.ReqID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public
    function paid_units_cancelled_refund(Request $request)
    {

        $pv_id = $request->get('pv_id');
        $remaining = $request->get('remaining');
        $amount = $request->get('amount');
        $method = $request->get('method');
        $chq_date = $request->get('chq_date');
        $chq_number = $request->get('chq_number');
        $remaining_amount = $remaining - $amount;
        $method_type = explode("_", $method);

        $final_PoCode = PVID();

        $update_date = long_date();
        $doc_date = short_date();
        $cashinhand_balance = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
    @Datefrom = N'2000-01-01',
    @DateTo = N'" . $doc_date . "',
    @id = " . $method_type[0] . ",
    @compid = N'" . company_id() . "'  ");
        foreach ($cashinhand_balance as $cashinhand_balance1) {
        }
        if ($method == '101001001001_Cash in Hand' && $cashinhand_balance1->am <= 0) {
            $find_config = 'Not Suficient Balance';
            return request()->json(200, $find_config);
        }
        $find_detail001 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $pv_id)->orderBy('ID', 'DESC')->first();


        if ($amount > $find_detail001->RemainingAmount) {
            $find_config = 'Paid Amount cannot be greater then Remaining Amount';
            return request()->json(200, $find_config);
        }
        $result = DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set PaidAmount=?, RemainingAmount=?, AccountID=?,PVID=? where ID=?', [$amount, $remaining_amount, $method_type[0], $final_PoCode, $pv_id]);
        if ($result) {

            $find_pv1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->select('ID')->where('PVID', $final_PoCode)->orderBy('ID', 'DESC')->first();

            $result1 = insert_sequencevoucher($final_PoCode, $find_pv1->ID, 'Cancellation Receipt');
            $update_date = long_date();
            $doc_date = short_date();

            if ($result1) {
                $find_detail1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $find_pv1->ID)->orderBy('ID', 'DESC')->first();


                $final_PoCode0 = $find_detail1->PVID;

                $amount0 = $find_detail1->PaidAmount;
                $name = $find_detail1->Name;
                $accoun0 = $find_detail1->AccountID;


                if ($method == '101001001001_Cash in Hand') {
                    if (isLive()) {
                        DB::connection('sqlsrv4')->insert('INSERT INTO Voucher(VoucherNo,Name,Father_Name,Contact,Amount,PaymentType,Project,File_Plot_Id,Module,Type,Description,DateTime) values (?,?,?,?,?,?,?,?,?,?,?,?)', [$final_PoCode, $name, $find_detail1->Father_Name, $find_detail1->Contact, $amount0, 'Cash', $find_detail1->Project, $find_detail1->File_Plot_No, $find_detail1->Module, 'Cancellation', 'Against Cancellation the ' . $find_detail1->ReceiptNo . ' of Plot No ' . $find_detail1->File_Plot_No . ' and owner name is ' . $name . ' from New System', $update_date]);
                    }
                    $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode0, 'Payment To ' . $name . ' Against Unit No:' . $find_detail1->File_Plot_Number . ' and Block Name:' . $find_detail1->Block, 'Cancelled', $update_date, username(), company_id()]);

                    if ($doc) {
                        $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode0)->orderBy('ID', 'DESC')->first();


                        $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Payment To ' . $name . ' with account id ' . $accoun0 . ' Cancellation Receipt', company_id()]);

                        $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '201001007', 'D', $amount0, company_id()]);

                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $method_type[0], 'C', $amount0, company_id()]);
                    }
                } else {
                    $status2 = 'Chq Paid';

                    DB::connection('sqlsrv3')->insert('INSERT INTO TempBank(PVID,VendorId,VendorName,ChqNo,ChqDate,ChqAmount,ClearanceAccountID,ClearanceAccountName,Status,RefID,RefType) values (?,?,?,?,?,?,?,?,?,?,?)', [$final_PoCode, '201001007', 'Sale return - payables', $chq_number, $chq_date, $amount0, $method_type[0], $method_type[1], $status2, $pv_id, 'Cancellation Refund']);

                }
            }
        }


        $find_config = 'submitted';
        return request()->json(200, $find_config);
    }

    public
    function get_purchaseorder_createdlist()
    {

        $find_session = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('CompanyID', '=', company_id())->select('CreatedBy')->groupBy('CreatedBy')->get();
        return request()->json(200, $find_session);
    }

    public
    function paid_units_amount_refund(Request $request)
    {

        $pv_id = $request->get('pv_id');
        $remaining = $request->get('remaining');
        $amount = $request->get('amount');
        $method = $request->get('method');
        $chq_date = $request->get('chq_date');
        $chq_number = $request->get('chq_number');
        $remaining_amount = $remaining - $amount;
        $method_type = explode("_", $method);

        $final_PoCode = PVID();

        $update_date = long_date();
        $doc_date = short_date();
        $cashinhand_balance = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
    @Datefrom = N'2000-01-01',
    @DateTo = N'" . $doc_date . "',
    @id = " . $method_type[0] . ",
    @compid = N'" . company_id() . "'  ");
        foreach ($cashinhand_balance as $cashinhand_balance1) {
        }
        if ($method == '101001001001_Cash in Hand' && $cashinhand_balance1->am <= 0) {
            $find_config = 'Not Suficient Balance';
            return request()->json(200, $find_config);
        }
        $find_detail100 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $pv_id)->orderBy('ID', 'DESC')->first();


        if ($amount > $find_detail100->RemainingAmount) {
            $find_config = 'Paid Amount cannot be greater then Remaining Amount';
            return request()->json(200, $find_config);
        }
        $result = DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set PaidAmount=?, RemainingAmount=?, AccountID=?,PVID=? where ID=?', [$amount, $remaining_amount, $method_type[0], $final_PoCode, $pv_id]);
        if ($result) {

            $find_pv1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->select('ID')->where('PVID', $final_PoCode)->orderBy('ID', 'DESC')->first();

            $result1 = insert_sequencevoucher($final_PoCode, $find_pv1->ID, 'Amount Refund Receipt');
            $update_date = long_date();
            $doc_date = short_date();

            if ($result1) {

                $find_detail1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $pv_id)->orderBy('ID', 'DESC')->first();

                $final_PoCode0 = $find_detail1->PVID;

                $amount0 = $find_detail1->PaidAmount;
                $name = $find_detail1->Name;
                $accoun0 = $find_detail1->AccountID;


                if ($method == '101001001001_Cash in Hand') {
                    if ($find_detail1->Receipt_Type != 'Extra Amount Refund' && isLive()) {
                        DB::connection('sqlsrv4')->insert('INSERT INTO Voucher(VoucherNo,Name,Father_Name,Contact,Amount,PaymentType,Project,File_Plot_Id,Module,Type,Description,DateTime) values (?,?,?,?,?,?,?,?,?,?,?,?)', [$final_PoCode, $name, $find_detail1->Father_Name, $find_detail1->Contact, $amount0, 'Cash', $find_detail1->Project, $find_detail1->File_Plot_No, $find_detail1->Module, 'Receipt_Refund', 'Amount Refund Against the ' . $find_detail1->ReceiptNo . ' of Plot No ' . $find_detail1->File_Plot_No . ' and owner name is ' . $name . ' from New System', $update_date]);
                    }

                    $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode0, 'Payment To ' . $name . ' Against Unit No:' . $find_detail1->File_Plot_Number . ' and Block Name:' . $find_detail1->Block, 'Amount Refund', $update_date, username(), company_id()]);

                    if ($doc) {
                        $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode0)->orderBy('ID', 'DESC')->first();


                        $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Payment To ' . $name . ' with account id ' . $accoun0 . ' Amount Refund Receipt', company_id()]);

                        $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '201001006', 'D', $amount0, company_id()]);

                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $method_type[0], 'C', $amount0, company_id()]);
                    }
                } else {
                    $status2 = 'Chq Paid';

                    DB::connection('sqlsrv3')->insert('INSERT INTO TempBank(PVID,VendorId,VendorName,ChqNo,ChqDate,ChqAmount,ClearanceAccountID,ClearanceAccountName,Status,RefID,RefType) values (?,?,?,?,?,?,?,?,?,?,?)', [$final_PoCode, '201001006', 'Excess recovered refund - payables', $chq_number, $chq_date, $amount0, $method_type[0], $method_type[1], $status2, $pv_id, 'Recovery Refund']);


                }
            }
        }


        $find_config = 'submitted';
        return request()->json(200, $find_config);
    }

    public
    function fetch_payable_tax_head()
    {

        $find_config = DB::connection('sqlsrv3')->table("Accounts")->select('ID', 'AccountName')->where('CompanyID', '=', company_id())->where('CoaType', '=', 'Transaction')->Where('AccountCode', 'like', '201001002%')->orderby('ID', 'asc')->get();
        return request()->json(200, $find_config);
    }

    public
    function get_sam_sum()
    {
        $cash_amount = DB::connection('sqlsrv3')->table('TempPaymentTable')->where('status', '=', null)->sum('Amount');

        return request()->json(200, $cash_amount);
    }

    public
    function update_units_repurchased_amount(Request $request)
    {
        $id = $request->get("pv_id");
        $status = $request->get('sts');


        $update_date = long_date();
        $doc_date = short_date();


        $check_sec = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $id)->exists();
        if ($check_sec) {
            $save_ledger1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->leftjoin('UnitDiscounts', 'UnitDiscounts.Module_Id', '=', 'TempCancellation_Receipts.File_Plot_No')->where('TempCancellation_Receipts.ID', '=', $id)
                // ->where('TempCancellation_Receipts.Module','=','UnitDiscounts.Module')
                ->select('TempCancellation_Receipts.*', 'UnitDiscounts.Discount_Amount')->orderBy('TempCancellation_Receipts.ID', 'DESC')->first();
            //start accounts

            $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID7', '=', $save_ledger1->ID)->where('CompanyID', '=', company_id())->exists();
            if (!$find_vendor_id) {
                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $save_ledger1->ReceiptNo, 'Units Repurchased of Plot No:' . $save_ledger1->File_Plot_Number . ' Block No:' . $save_ledger1->Block . ' file', $save_ledger1->Receipt_Type, $update_date, username(), company_id()]);
                if ($doc) {
                    $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $save_ledger1->ReceiptNo)->orderBy('ID', 'DESC')->first();

                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Units Repurchased of Plot No:' . $save_ledger1->File_Plot_Number . ' Block No:' . $save_ledger1->Block . ' file', company_id()]);
                    $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                    if ($save_ledger1->Plot_Type == 'Apartment') {
                        $find_acc_code1 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Project . ' Receivables')->orderBy('ID', 'DESC')->first();

                    } else if ($save_ledger1->Block == 'Main G.T Road') {
                        $blo = 'Main GT road';
                        $find_acc_code1 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $blo . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->orderBy('ID', 'DESC')->first();

                    } else {
                        $find_acc_code1 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', company_id())->where('AccountType', '=', 'Assets')->where('AccountName', '=', $save_ledger1->Block . ' Block ' . $save_ledger1->Plot_Type . ' Receivables')->orderBy('ID', 'DESC')->first();

                        //end dynamic types
                    }

                    if ($save_ledger1->Plot_Type == 'Residential') {
                        $led_name = '101003017002';
                    } else if ($save_ledger1->Plot_Type == 'Commercial') {
                        $led_name = '101003017001';
                    }


                    if ($save_ledger1->Plot_Total_Amount == $save_ledger1->Amount) {
                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $led_name, 'D', $save_ledger1->Repurchased_Amt, $save_ledger1->ID, company_id()]);
                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, '201001008', 'C', $save_ledger1->Repurchased_Amt, $save_ledger1->ID, company_id()]);

                        DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set RemainingAmount=? where ID=?', [round($save_ledger1->Repurchased_Amt), $id]);

                    } else {
                        $discount = '';
                        if ($save_ledger1->Discount_Amount == NULL) {
                            $discount = 0;
                        }
                        $receivable_amount = ($save_ledger1->Plot_Total_Amount - $save_ledger1->Discount_Amount) - $save_ledger1->Amount;
                        $pay_amount = $save_ledger1->Repurchased_Amt - $receivable_amount;

                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $led_name, 'D', $save_ledger1->Repurchased_Amt, $save_ledger1->ID, company_id()]);
                        $ledger_entry1 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'C', $receivable_amount, $save_ledger1->ID, company_id()]);

                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,VendorID7,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, '201001008', 'C', $pay_amount, $save_ledger1->ID, company_id()]);

                        DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set RemainingAmount=? where ID=?', [round($pay_amount), $id]);

                    }

                }
            }
            $result1 = DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set Status=?,UpdatedBy=? where ID=?', [$status, username(), $id]);

        }

        $result = 'Status updated!';
        return request()->json(200, $result);
    }

    public
    function paid_units_amount_repurchased(Request $request)
    {

        $pv_id = $request->get('pv_id');
        $remaining = $request->get('remaining');
        $amount = $request->get('amount');
        $method = $request->get('method');
        $chq_date = $request->get('chq_date');
        $chq_number = $request->get('chq_number');
        $remaining_amount = $remaining - $amount;
        $method_type = explode("_", $method);

        $update_date = long_date();
        $doc_date = short_date();
        $cashinhand_balance = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
    @Datefrom = N'2000-01-01',
    @DateTo = N'" . $doc_date . "',
    @id = " . $method_type[0] . ",
    @compid = N'" . company_id() . "'  ");

        foreach ($cashinhand_balance as $cashinhand_balance1) {
        }
        if ($method == '101001001001_Cash in Hand' && $cashinhand_balance1->am <= 0) {
            $find_config = 'Not Suficient Balance';
            return request()->json(200, $find_config);
        }

        $final_PoCode = PVID();

        $find_detail100 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $pv_id)->orderBy('ID', 'DESC')->first();


        if ($amount > $find_detail100->RemainingAmount) {
            $find_config = 'Paid Amount cannot be greater then Remaining Amount';
            return request()->json(200, $find_config);
        }
        $result = DB::connection('sqlsrv3')->update('update TempCancellation_Receipts set PaidAmount=?, RemainingAmount=?, AccountID=?,PVID=? where ID=?', [$amount, $remaining_amount, $method_type[0], $final_PoCode, $pv_id]);
        if ($result) {

            $find_pv1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->select('ID')->where('PVID', $final_PoCode)->orderBy('ID', 'DESC')->first();

            //  $result1=DB::connection('sqlsrv3')->insert('INSERT INTO SequenceVoucher(PVID,RefID,RefType,CompanyID,MonthId) values (?,?,?,?,?)', [$final_PoCode,$find_pv1->ID,'Amount Repurchased Receipt', company_id(),$date_pref]);
            $result1 = insert_sequencevoucher($final_PoCode, $find_pv1->ID, 'Amount Repurchased Receipt');
            $update_date = long_date();
            $doc_date = short_date();

            if ($result1) {

                $find_detail1 = DB::connection('sqlsrv3')->table("TempCancellation_Receipts")->where('ID', '=', $pv_id)->orderBy('ID', 'DESC')->first();

                $final_PoCode0 = $find_detail1->PVID;

                $amount0 = $find_detail1->PaidAmount;
                $name = $find_detail1->Name;
                $accoun0 = $find_detail1->AccountID;


                if ($method == '101001001001_Cash in Hand') {
                    $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode0, 'Payment To ' . $name . ' Against Unit No:' . $find_detail1->File_Plot_Number . ' and Block Name:' . $find_detail1->Block, 'Amount Repurchased', $update_date, username(), company_id()]);

                    if ($doc) {
                        $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode0)->orderBy('ID', 'DESC')->first();


                        $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Payment To ' . $name . ' with account id ' . $accoun0 . ' Amount Repurchased Receipt', company_id()]);

                        $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '201001008', 'D', $amount0, company_id()]);

                        $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $method_type[0], 'C', $amount0, company_id()]);
                    }
                } else {
                    $status2 = 'Chq Paid';


                    DB::connection('sqlsrv3')->insert('INSERT INTO TempBank(PVID,VendorId,VendorName,ChqNo,ChqDate,ChqAmount,ClearanceAccountID,ClearanceAccountName,Status,RefID,RefType) values (?,?,?,?,?,?,?,?,?,?,?)', [$final_PoCode, '201001008', 'Repurchased Payable', $chq_number, $chq_date, $amount0, $method_type[0], $method_type[1], $status2, $pv_id, 'Repurchased Refund']);


                }
            }
        }

        $find_config = 'submitted';
        return request()->json(200, $find_config);
    }

    public
    function units_booking_report($start_date, $end_date)
    {
        $req = DB::connection('sqlsrv3')->table('TempBookingTable')->whereNotNull("Supervision")->where("Dated", '>=', $start_date)->where("Dated", '<=', $end_date)->orderBy('BID', 'desc')->get();
        return request()->json(200, $req);
    }

    public
    function submit_debit_notes(Request $request)
    {


        $item_name = $request->get('item_name');
        $sub_total = $request->get('sub_total');
        $debit_amount = $request->get('debit_amount');
        $vendor = $request->get('vendor');

        $vendor1 = explode("_", $vendor);
        $date = $request->get('date');
        $amount = $request->get('amount');
        $narration = $request->get('narration');
        $against_invoice = $request->get('against_invoice');


        $update_date = long_date();
        $doc_date = short_date();
        $item_name9 = explode("|", $item_name);
        for ($b = 1; $b < count($item_name9); $b++) {
            $sub_total1 = explode("|", $sub_total);
            $debit_amount1 = explode("|", $debit_amount);
            $item_name11 = explode("|", $item_name);

            if ($debit_amount1[$b] > $sub_total1[$b]) {
                $message = 'Debit Amount Canot be greater then Subtotal of' . $item_name11[$b] . $debit_amount1[$b] . $sub_total1[$b];
                return request()->json(200, $message);
            }
        }


        $find_debit_exists = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', company_id())->where('AgainstINV', '=', $against_invoice)->exists();
        if ($find_debit_exists) {

            $find_debit_pvpo = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', company_id())->where('AgainstINV', '=', $against_invoice)->get();
            foreach ($find_debit_pvpo as $find_debit_pvpo1) {
            }
            $remaini = $find_debit_pvpo1->Remaining;
            // if($amount > $remaini ){
            //   $message = 'Debit Amount Canot be greater then total of Remaining Invoice Value';
            //   return request()->json(200, $message);
            // }

        } else {
            $find_debit_pvpo = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('CompanyID', '=', company_id())->where('FormID', '=', $against_invoice)->get();
            foreach ($find_debit_pvpo as $find_debit_pvpo1) {
            }

            $find_poo = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('PoCode')->where('CompanyID', '=', company_id())->where('PurchaseOrderID', '=', $find_debit_pvpo1->POID)->get();
            foreach ($find_poo as $find_poo1) {

            }

            $remaini = $find_debit_pvpo1->TotalAmount;
            if ($amount > $remaini) {
                $message = 'Debit Amount Canot be greater then total of Remaining Invoice Value';
                return request()->json(200, $message);
            }
        }


        $find_prefix = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('DebitNote')->where('CompanyID', '=', company_id())->get();
        foreach ($find_prefix as $find_prefix1) {

        }
        $date_pref = $this->shiftformat();
        $req_prefix = $find_prefix1->DebitNote . '_' . $date_pref;

        $find_rid9 = DB::connection('sqlsrv3')->table("DebitNotes")->where('CompanyID', '=', company_id())->exists();
        if ($find_rid9) {
            $find_rid = DB::connection('sqlsrv3')->table("DebitNotes")->select('DebitNotesID')->where('CompanyID', '=', company_id())->get();
            foreach ($find_rid as $find_rid1) {

            }
            $pre_id = explode("-", $find_rid1->DebitNotesID);
            $rid = $pre_id[1] + 1;
        } else {
            $rid = 1;
        }
        $final_PoCode = $req_prefix . '-' . $rid;

        $result = DB::connection('sqlsrv3')->insert('INSERT INTO DebitNotes(CompanyID,Dated,VendorID,VendorName,TotalDebitAmount,Remarks,DebitNotesID,InvoiceID,CreatedBy,CreatedOn,Status) values (?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $date, $vendor1[0], $vendor1[1], $amount, $narration, $final_PoCode, $against_invoice, username(), $update_date, 'Approved']);
        if ($result) {

            $find_reqid = DB::connection('sqlsrv3')->table("DebitNotes")->select('ID')->where('CompanyID', '=', company_id())->where('DebitNotesID', '=', $final_PoCode)->get();
            foreach ($find_reqid as $find_reqid1) {
            }


            $item_name1 = explode("|", $item_name);


            for ($x = 1; $x < count($item_name1); $x++) {
                $sub_total1 = explode("|", $sub_total);
                $debit_amount1 = explode("|", $debit_amount);
                $item_name11 = explode("|", $item_name);
                if (is_int($item_name11[$x])) {
                    $check = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', company_id())->where('ID', '=', $item_name11[$x])->exists();
                    if ($check) {
                        $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', company_id())->where('ID', '=', $item_name11[$x])->get();
                        foreach ($find_itemname as $find_itemname1) {
                        }
                        $result3 = DB::connection('sqlsrv3')->insert('INSERT INTO DebitNotesItems(CompanyID,DNID,ItemId,ItemName,SubTotal,DebitAmount) values (?,?,?,?,?,?)', [company_id(), $find_reqid1->ID, $item_name11[$x], $find_itemname1->Name, $sub_total1[$x], $debit_amount1[$x]]);
                    }
                } else {
                    $result3 = DB::connection('sqlsrv3')->insert('INSERT INTO DebitNotesItems(CompanyID,DNID,Detail,SubTotal,DebitAmount) values (?,?,?,?,?)', [company_id(), $find_reqid1->ID, $item_name11[$x], $sub_total1[$x], $debit_amount1[$x]]);

                }
            }

            //accounting

            $find_pvpo_exists = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', company_id())->where('AgainstINV', '=', $against_invoice)->exists();
            if ($find_pvpo_exists) {
                $find_pvpo = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('CompanyID', '=', company_id())->where('FormID', '=', $against_invoice)->get();
                foreach ($find_pvpo as $find_pvpo1) {
                }
                DB::connection('sqlsrv3')->update('update PurchaseOrder set DebitState=? where CompanyID=? and PurchaseOrderID=?', [0, company_id(), $find_pvpo1->POID]);
                $find_pvpo = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', company_id())->where('AgainstINV', '=', $against_invoice)->get();
                foreach ($find_pvpo as $find_pvpo1) {
                }
                $remaining_amount = $find_pvpo1->Remaining - $amount;
                $result4 = DB::connection('sqlsrv3')->insert('INSERT INTO PaymentVoucherDetail(CompanyID,Date,AgainstPO,AgainstINV,Amount,PVNO,Remaining) values (?,?,?,?,?,?,?)', [company_id(), $date, $find_pvpo1->AgainstPO, $against_invoice, $amount, $final_PoCode, $remaining_amount]);
            } else {
                $find_pvpo = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('CompanyID', '=', company_id())->where('FormID', '=', $against_invoice)->get();
                foreach ($find_pvpo as $find_pvpo1) {
                }
                DB::connection('sqlsrv3')->update('update PurchaseOrder set DebitState=? where CompanyID=? and PurchaseOrderID=?', [0, company_id(), $find_pvpo1->POID]);
                $find_poo = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('PoCode')->where('CompanyID', '=', company_id())->where('PurchaseOrderID', '=', $find_pvpo1->POID)->get();
                foreach ($find_poo as $find_poo1) {

                }

                $remaining_amount = $find_pvpo1->TotalAmount - $amount;
                $result4 = DB::connection('sqlsrv3')->insert('INSERT INTO PaymentVoucherDetail(CompanyID,Date,AgainstPO,AgainstINV,Amount,PVNO,Remaining) values (?,?,?,?,?,?,?)', [company_id(), $date, $find_poo1->PoCode, $against_invoice, $amount, $final_PoCode, $remaining_amount]);
            }

        }


//account
        $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode, 'Debit Note:' . $final_PoCode . ' with Remarks:' . $narration, 'Debit Note', $update_date, username(), company_id()]);
        if ($doc) {
            $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode)->get();
            foreach ($find_doc_id as $find_doc_id1) {

            }


            $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Debit Note:' . $final_PoCode . ' with Remarks:' . $narration, company_id()]);

            $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
            foreach ($find_tran_id as $find_tran_id1) {

            }

            $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $vendor1[0], 'D', $amount, company_id()]);


            $find_pvpo = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('CompanyID', '=', company_id())->where('FormID', '=', $against_invoice)->get();
            foreach ($find_pvpo as $find_pvpo1) {
            }

            $find_poo = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('RequisitionType', 'AgainstReq')->where('CompanyID', '=', company_id())->where('PurchaseOrderID', '=', $find_pvpo1->POID)->get();
            foreach ($find_poo as $find_poo1) {

            }
            $req_type = $find_poo1->RequisitionType;
            $AgainstReq = $find_poo1->AgainstReq;

            $item_name1 = explode("|", $item_name);
            for ($y = 1; $y < count($item_name1); $y++) {
                $debit_amount1 = explode("|", $debit_amount);
                $item_nam = explode("|", $item_name);
                if ($req_type == 'Goods') {
                    $find_acc_code9 = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ItemId', '=', $item_nam[$y])->get();
                    foreach ($find_acc_code9 as $find_acc_code91) {

                    }

                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'C', $debit_amount1[$y], company_id()]);
                } elseif ($req_type == 'Assets') {
                    $find_acc_code9 = DB::connection('sqlsrv3')->table("AssetsLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('AssetId', '=', $item_nam[$y])->get();
                    foreach ($find_acc_code9 as $find_acc_code91) {

                    }
                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'C', $debit_amount1[$y], company_id()]);

                } else {
                    $find_pro_name = DB::connection('sqlsrv3')->table("Requisition")->select('ProjectName')->where('CompanyID', '=', company_id())->where('RequisitionId', '=', $AgainstReq)->get();
                    foreach ($find_pro_name as $find_pro_name1) {

                    }
                    $find_acc_code9 = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->select('CoaID')->where('CompanyID', '=', company_id())->where('ProjectName', '=', $find_pro_name1->ProjectName)->get();
                    foreach ($find_acc_code9 as $find_acc_code91) {

                    }

                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'C', $debit_amount1[$y], company_id()]);
                }

            }
        }


        $message = 'submitted';
        return request()->json(200, $message);
    }

    public
    function single_debit_notes($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("DebitNotes")->where('ID', '=', $id)->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $find_config);
    }

    public
    function single_debit_notesitems($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("DebitNotesItems")->where('DNID', '=', $id)->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $find_config);
    }

    public
    function search_debit_notes(Request $request)
    {

        $find_config = DB::connection('sqlsrv3')->table("DebitNotes")->where('VendorName', 'like', '%' . $request->keyword1 . '%')->orWhere('DebitNotesID', 'like', '%' . $request->keyword1 . '%')->orWhere('InvoiceID', 'like', '%' . $request->keyword1 . '%')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function debit_not_detail()
    {

        $find_config = DB::connection('sqlsrv3')->table("DebitNotes")->where('CompanyID', '=', company_id())->orderby('ID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }

    public
    function fetch_pi_itemsbycode($poid)
    {
        $arr = [];
        $get_items = DB::connection('sqlsrv3')->table('ReceivingOrder')->where('FormID', '=', $poid)->get();
        foreach ($get_items as $get_items1) {
        }
        $get_quo = DB::connection('sqlsrv3')->table('ReceivingOrderItems')->where('ROID', '=', $get_items1->ReceavingOrderID)->get();
        return request()->json(200, $get_quo);
    }

    function fetch_pi_taxbycode($poid)
    {
        $get_items = DB::connection('sqlsrv3')->table('ReceivingOrder')->where('FormID', '=', $poid)->get();
        return request()->json(200, $get_items);
    }

    public
    function get_purchase_value_department()
    {
        $data = DB::connection('sqlsrv3')
            ->table('Issuances AS I')
            ->join('IssuanceItem AS II', 'I.IssuanceId', '=', 'II.IssuanceId')
            ->join('GrnOrderItems AS G', 'II.itemId', '=', 'G.ItemId')
            ->select('I.DepartmentName', DB::raw('SUM(G.Price) AS TotalPrice'))
            ->groupBy('I.DepartmentName')
            ->get();

        return response()->json($data, 200);

    }

    public
    function grn_vs_pr()
    {

        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();
        foreach ($find_session as $find_session1) {

        }
        $session = $find_session1->SessionName;
        $totalRequisitions = DB::connection('sqlsrv3')->table('Requisition')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->count();
        $totalGrn = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', company_id())->where('Session', '=', $session)->where('ReqID', '!=', null)->count();
        $percentageGrn = ($totalGrn / $totalRequisitions) * 100;
        $formattedPercentageGrn = number_format($percentageGrn, 2) . '%';
        $myJSON = array(
            'total_req' => $totalRequisitions,
            'total_grn' => $totalGrn,
            'percentage' => $formattedPercentageGrn,
        );
        return request()->json(200, $myJSON);

    }

    public
    function procurement_cycle_days()
    {
        $dates = DB::connection('sqlsrv3')->table('GrnOrder')->join('Requisition', 'GrnOrder.ReqID', '=', 'Requisition.RequisitionId')->join('DemandRequisition', 'Requisition.DemandRID', '=', 'DemandRequisition.RequisitionId')->select('GrnOrder.Dated AS grndates', 'DemandRequisition.Dated AS demanddates')->get();
        $totalDays = 0;
        $count = 0;
        foreach ($dates as $date) {
            $diff = strtotime($date->grndates) - strtotime($date->demanddates);
            $totalDays += floor($diff / (60 * 60 * 24));
            $count++;
        }
        $averageDays = $count > 0 ? round($totalDays / $count) : 0;

        $result = [
            'average_days' => $averageDays,
        ];

        return response()->json($result, 200);
    }

    public
    function get_department_name()
    {
        $data = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[PurchaseReport_DepartmentWise]");

        return response()->json($data, 200);
    }

    public
    function get_purchaseReport_vendor()
    {
        $data = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[PurchaseReport_VendorWise]");

        return response()->json($data, 200);
    }

    public
    function get_purchaseReport_ItemCategory()
    {
        $data = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[PurchaseReport_ItemWise]");
        return response()->json($data, 200);
    }

    public
    function procurement_cycle_supplier()
    {

        $find_session = DB::connection('sqlsrv3')->table('Session')->where('CompanyID', '=', company_id())->where('Status', '=', 1)->get();

        foreach ($find_session as $find_session1) {
        }

        $session = $find_session1->SessionName;
        $po_data = DB::connection('sqlsrv3')->table('PurchaseOrder')->select('PurchaseOrderID', 'PoDate', 'vendorName')->where('Session', '=', $session)->get();
        $result = [];

        foreach ($po_data as $po_data1) {
            $grn_data = DB::connection('sqlsrv3')->table('GrnOrder')->select('Dated')->where('POID', '=', $po_data1->PurchaseOrderID)->get();

            foreach ($grn_data as $grn_data1) {
                // Calculate the time difference between PO date and GRN date for each vendor
                $po_date = strtotime($po_data1->PoDate);
                $grn_date = strtotime($grn_data1->Dated);
                $time_taken = $grn_date - $po_date;

                // Convert the time difference to days
                $days_taken = round($time_taken / (60 * 60 * 24));

                // Add the vendor name and time taken to the result array
                if (!isset($result[$po_data1->vendorName])) {
                    $result[$po_data1->vendorName] = [
                        'total_days' => $days_taken,
                        'count' => 1
                    ];
                } else {
                    $result[$po_data1->vendorName]['total_days'] += $days_taken;
                    $result[$po_data1->vendorName]['count']++;
                }
            }
        }

        // Calculate the average days taken for each vendor
        foreach ($result as $vendor => $data) {
            $average_days = round($data['total_days'] / $data['count']);
            $result[$vendor]['average_days'] = $average_days;
            unset($result[$vendor]['total_days']);
            $result[$vendor]['vendor_name'] = $vendor;
            unset($result[$vendor]['count']);
        }
        $result = array_values($result);
        return response()->json($result);
    }

    public
    function get_Issuance_value_project()
    {
        $data = DB::connection('sqlsrv3')
            ->table('Issuances AS I')
            ->join('IssuanceItem AS II', 'I.IssuanceId', '=', 'II.IssuanceId')
            ->join('GrnOrderItems AS G', 'II.itemId', '=', 'G.ItemId')
            ->select('I.ProjectName', DB::raw('SUM(G.Price) AS TotalPrice'))
            ->groupBy('I.ProjectName')
            ->get();
        return response()->json($data, 200);
    }

}
