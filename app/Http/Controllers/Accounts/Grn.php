<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\Validator;
use App\Rules\ImageExtension;

class Grn extends Controller
{

    //INsert Purchase Invoice
    public function insert_services_invoice(Request $request)
    {
        $item_name = $request->get('item_name');
        $ordrqty = $request->get('ordrqty');
        $qty = $request->get('qty');
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
        $select_pmterm = $request->get('select_pmterm');
        $total = $request->get('total');
        $ItemExist = false;

        $item_names = explode("|", $item_name);
        $ordrqt = explode("|", $ordrqty);
        $qt = explode("|", $qty);
        for ($x = 1; $x < count($item_names); $x++) {
            if ($qt[$x] > $ordrqt[$x]) {
                $message = 'Received Quantity Exceeded!';
                return request()->json(200, $message);
            } else if ($qt[$x] > 0) {
                $ItemExist = true;
            }
        }
        if (!$ItemExist) {
            $message = 'Please add at least 1 service!';
            return request()->json(200, $message);
        }
        $req_prefix = acc_config()->CustomerInvoice . '_' . shiftformat();

        $rid = 1;
        if (DB::connection('sqlsrv3')->table("ReceivingOrder")->where('CompanyID', '=', company_id())->exists()) {
            $find_rid1 = DB::connection('sqlsrv3')->table("ReceivingOrder")->select('FormId')->where('CompanyID', '=', company_id())->orderBy('ReceavingOrderID', 'desc')->first();
            $pre_id = explode("-", $find_rid1->FormId);
            $rid = $pre_id[1] + 1;
        }
        $final_PoCode = $req_prefix . '-' . $rid;

        $recordId = DB::connection('sqlsrv3')->table('ReceivingOrder')->insertGetId([
            'CompanyID' => company_id(),
            'Dated' => $date,
            'POID' => $poid,
            'ReqID' => $reqid,
            'FormID' => $final_PoCode,
            'InvoiceNo' => $invoice_no,
            'SubTotal' => $subtotal,
            'Discount' => $discount,
            'Tax' => $tax_amount,
            'ShippingCharges' => $delivery_amount,
            'TotalAmount' => $total,
            'Remarks' => $remarks,
            'Status' => $status,
            'CreatedBy' => username(),
            'CreatedOn' => long_date(),
            'Session' => ac_c_session(),
            'Status2' => 'Not Verified',
            'PaymentTerm' => $select_pmterm
        ]);

        if ($recordId) {
            $ordrqt_values = explode("|", $ordrqty);
            $uni_values = explode("|", $unit);
            $qt_values = explode("|", $qty);
            $cos_values = explode("|", $cost);

            for ($x = 1; $x < count($item_names); $x++) {
                $ordrqt = $ordrqt_values[$x];
                $uni = $uni_values[$x];
                $qt = $qt_values[$x];
                $cos = $cos_values[$x];
                $total1 = $qt * $cos;
                if ($qt != 0 || $qt != 0.00) {
                    $dataToInsert[] = [
                        'CompanyID' => company_id(),
                        'ROID' => $recordId,
                        'PoQuantity' => $ordrqt,
                        'Unit' => $uni,
                        'RecvdQuantity' => $qt,
                        'Price' => $cos,
                        'SubTotal' => $total1,
                        'Detail' => $item_names[$x]
                    ];
                }
            }
            if (!empty($dataToInsert)) {
                DB::connection('sqlsrv3')->table('ReceivingOrderItems')->insert($dataToInsert);
            }
            $find_pvpo1 = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('PoCode')->where('CompanyID', '=', company_id())->where('PurchaseOrderID', '=', $poid)->orderBy('PurchaseOrderID', 'desc')->first();
            $find_pv_exists = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', company_id())->where('AgainstPO', '=', $find_pvpo1->PoCode)->where('AgainstINV', '=', '')->exists();
            if ($find_pv_exists) {
                DB::connection('sqlsrv3')->table('PaymentVoucherDetail')
                    ->where('CompanyID', company_id())
                    ->where('AgainstPO', $find_pvpo1->PoCode)
                    ->where('AgainstINV', '')
                    ->update(['AgainstINV' => $final_PoCode]);
            }
        }

        if ($status != 'Partially Completed') {
            DB::connection('sqlsrv3')->table('PurchaseOrder')
                ->where('CompanyID', company_id())
                ->where('PurchaseOrderID', $poid)
                ->update([
                    'state' => 1,
                    'pinv_state' => 1,
                    'DebitState' => 1,
                ]);
        }
        $req1 = DB::connection('sqlsrv3')->table("Requisition")->select('RId')->where('RequisitionId', '=', $reqid)->first();
        insertLog('Purchase Invoice created', 'Purchase invoice against vendor: ' . $vendor . ' | Invoice ID: ' . $final_PoCode . ' | against ReqID: ' . $req1->RId . ' | with Invoice Number: ' . $invoice_no . ' | Total Amount:' . $total . ' | Status: ' . $status . ' | has been created ');

        $message = 'submitted';
        return request()->json(200, $message);
    }

//insert GRN
    public function insert_grn9(Request $request)
    {
        $company_id = company_id();
        $session = ac_c_session();
        $username = username();
        $UserFullName = User();
        $item_name = $request->get('item_name');
        $ordrqty = $request->get('ordrqty');
        $qty = $request->get('qty');
        $unit = $request->get('unit');
        $cost = $request->get('cost');
        $dateexpiry = $request->get('dateexpiry');
        $detail = $request->get('detail');
        $subtotal = $request->get('subtotal');
        $discount = $request->get('discount');
        $tax_amount = $request->get('tax_amount');
        $delivery_amount = $request->get('delivery_amount');
        $total = $request->get('total');
        $date = $request->get('date');
        $vendor = $request->get('vendor');
        $invoice_no = $request->get('invoice_no');
        $poid = $request->get('poid');
        $reqid = $request->get('reqid');
        $remarks = $request->get('remarks');
        $status = $request->get('status');

        $quantity_received = 'yes';
        $validator = Validator::make($request->all(), [
            'image_file' => ['required', 'file', new ImageExtension],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 200);
        }
        $item_name9 = explode("|", $item_name);
        $arr = [];
        for ($b = 1; $b < count($item_name9); $b++) {
            $item_nam91 = explode("|", $item_name);
            $qt9 = explode("|", $qty);

            $array1 = DB::connection('sqlsrv3')->table("GrnOrder")->where('POID', '=', $poid)->where('isDeleted', '=', 0)->where('CompanyID', '=', $company_id)->select('GrnOrderID')->get();
            $resultArray = [];

            foreach ($array1 as $array11) {
                $resultArray[] = (array)$array11;
            }

            $find_req_id_sum = DB::connection('sqlsrv3')->table("GrnOrderItems")->where('poid', '=', $poid)->where('ItemId', '=', $item_nam91[$b])->whereIN('GrnID', $resultArray)->sum('RecvdQuantity');


            $final_qty = intval($qt9[$b]) + $find_req_id_sum;

            $find_req_table_sum = DB::connection('sqlsrv3')->table("PurchaseOrderItems")->where('POID', '=', $poid)->where('ItemId', '=', $item_nam91[$b])->sum('Quantity');
            if ($final_qty > $find_req_table_sum) {
                $message = 'You exceed quantity against this PO';
                return request()->json(200, $message);
            }
            if ($status == 'Partially Completed') {
                if ($final_qty == $find_req_table_sum) {
                    array_push($arr, "yes");
                } else {
                    array_push($arr, "no");
                }
            }
        }
        $item_name1 = explode("|", $item_name);
        for ($y = 1; $y < count($item_name1); $y++) {
            $item_nam = explode("|", $item_name);
            $cos = explode("|", $cost);
            $ordrqt = explode("|", $ordrqty);
            $qt = explode("|", $qty);
            if ($cos[$y] == '' || $qt[$y] == '') {
                $message = 'Some fileds are empty at index ' . $y;
                return request()->json(200, $message);
            }
            $po_items1 = DB::connection('sqlsrv3')->table("PurchaseOrderItems")->where('POID', '=', $poid)->where('ItemId', '=', $item_nam[$y])->where('CompanyID', '=', $company_id)->orderBy('POItemID', 'desc')->first();

            if ($po_items1->Price < $cos[$y]) {
                $message = 'Unit cost of "' . $po_items1->ItemName . '" is larger then cost in Purchase order (It must me upto Rs.' . number_format($po_items1->Price) . ')';
                return request()->json(200, $message);
            }
            if ($ordrqt[$y] < $qt[$y]) {
                $message = 'Your Received Quantity is larger then Ordered Qty';
                return request()->json(200, $message);
            }
        }

        $update_date = long_date();
        $find_prefix1 = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('GoodReceivedNote')->where('CompanyID', '=', $company_id)->orderBy('ConfigurationID', 'desc')->first();

        $date_pref = shiftformat();
        $req_prefix = $find_prefix1->GoodReceivedNote . '_' . $date_pref;
        $find_rid9 = DB::connection('sqlsrv3')->table("GrnOrder")->where('CompanyID', '=', $company_id)->exists();
        if ($find_rid9) {
            $find_rid1 = DB::connection('sqlsrv3')->table("GrnOrder")->select('GrnID')->where('CompanyID', '=', $company_id)->orderBy('GrnOrderID', 'desc')->first();

            $pre_id = explode("-", $find_rid1->GrnID);
            $rid = $pre_id[1] + 1;
        } else {
            $rid = 1;
        }
        $final_PoCode = $req_prefix . '-' . $rid;
        //
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $name_image = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/images/grn_images/', $name_image);
            $result = DB::connection('sqlsrv3')->insert('INSERT INTO GrnOrder(CompanyID,Dated,POID,ReqID,GrnID,InvoiceNo,Remarks,Status,CreatedBy,CreatedOn,Session,Status2, Photo,isDeleted) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$company_id, $date, $poid, $reqid, $final_PoCode, $invoice_no, $remarks, $status, $username, $update_date, $session, 'Not Verified', $name_image, 0]);
        } else {
            $result = DB::connection('sqlsrv3')->insert('INSERT INTO GrnOrder(CompanyID, Dated, POID, ReqID, GrnID, InvoiceNo, Remarks, Status, CreatedBy, CreatedOn, Session, Status2.isDeleted) values (?,?,?,?,?,?,?,?,?,?,?,?,?)', [$company_id, $date, $poid, $reqid, $final_PoCode, $invoice_no, $remarks, $status, $username, $update_date, $session, 'Not Verified', 0]);
        }

        if ($result) {
            $find_reqid1 = DB::connection('sqlsrv3')->table("GrnOrder")->select('GrnOrderID')->where('CompanyID', '=', $company_id)->where('POID', '=', $poid)->where('ReqID', '=', $reqid)->where('GrnID', '=', $final_PoCode)->where('isDeleted', '!=', 1)->where('GrnID', '=', $final_PoCode)->orderBy('GrnOrderID', 'desc')->first();

            $item_name1 = explode("|", $item_name);
            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $ordrqt = explode("|", $ordrqty);
                $uni = explode("|", $unit);
                $qt = explode("|", $qty);
                $cos = explode("|", $cost);
                $detai = explode("|", $detail);
                $dateexpir = explode("|", $dateexpiry);
                if ($qt[$x] != 0 || $qt[$x] != 0.00) {
                    $find_itemname1 = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', $company_id)->where('ID', '=', $item_nam[$x])->orderBy('ID', 'desc')->first();

                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO GrnOrderItems(CompanyID,GrnID,ItemId,ItemName,PoQuantity,Unit,RecvdQuantity,ItemExpiry,Price,Detail,poid) values (?,?,?,?,?,?,?,?,?,?,?)', [$company_id, $find_reqid1->GrnOrderID, $item_nam[$x], $find_itemname1->Name, $ordrqt[$x], $uni[$x], $qt[$x], $dateexpir[$x], $cos[$x], $detai[$x], $poid]);
                }
            }
        }
        $allElementsAreYes = array_reduce($arr, function ($carry, $item) {
            return $carry && ($item === "yes");
        }, true);
        if ($status != 'Partially Completed' || $allElementsAreYes) {
            DB::connection('sqlsrv3')->update('update PurchaseOrder set state=? where CompanyID=?  and PurchaseOrderID=? ', [1, $company_id, $poid]);
            DB::connection('sqlsrv3')->update('update PurchaseOrder set pinv_state=?,DebitState=? where CompanyID=?  and PurchaseOrderID=? ', [1, 1, $company_id, $poid]);
        }
        DB::connection('sqlsrv3')->update('update PurchaseOrder set Status2=? where CompanyID=?  and PurchaseOrderID=? ', ['Received', $company_id, $poid]);
        //
        $find_req = DB::connection('sqlsrv3')->table("Requisition")->where('RequisitionType', '!=', 'Services')->where('RequisitionId', '=', $reqid)->where('CompanyID', '=', $company_id)->exists();
        if ($find_req) {
            $find_prefix1 = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('CustomerInvoice')->where('CompanyID', '=', $company_id)->orderBy('ConfigurationID', 'desc')->first();

            $date_pref = shiftformat();
            $req_prefix = $find_prefix1->CustomerInvoice . '_' . $date_pref;
            $find_rid9 = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('CompanyID', '=', $company_id)->exists();
            if ($find_rid9) {
                $find_rid1 = DB::connection('sqlsrv3')->table("ReceivingOrder")->select('FormId')->where('CompanyID', '=', $company_id)->orderBy('ReceavingOrderID', 'desc')->first();

                $pre_id = explode("-", $find_rid1->FormId);
                $rid = $pre_id[1] + 1;
            } else {
                $rid = 1;
            }
            $final_PoCode1 = $req_prefix . '-' . $rid;
            $find_gggg1 = DB::connection('sqlsrv3')->table("GrnOrder")->select('GrnOrderID')->where('CompanyID', '=', $company_id)->where('GrnID', '=', $final_PoCode)->where('isDeleted', '!=', 1)->orderBy('GrnOrderID', 'desc')->first();

            $result = DB::connection('sqlsrv3')->insert('INSERT INTO ReceivingOrder(CompanyID,Dated, POID,ReqID,FormID, InvoiceNo,SubTotal,Discount, Tax,ShippingCharges, TotalAmount, Remarks, Status, CreatedBy, CreatedOn, Session,Status2,GRNID,isDeleted) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$company_id, $date, $poid, $reqid, $final_PoCode1, $invoice_no, $subtotal, $discount, $tax_amount, $delivery_amount, $total, $remarks, $status, $username, $update_date, $session, 'Not Verified', $find_gggg1->GrnOrderID, 0]);
            //
            if ($result) {
                $find_reqid11 = DB::connection('sqlsrv3')->table("ReceivingOrder")->select('ReceavingOrderID')->where('CompanyID', '=', $company_id)->where('POID', '=', $poid)->where('ReqID', '=', $reqid)->where('FormID', '=', $final_PoCode1)->where('isDeleted', '!=', 1)->orderby('ReceavingOrderID', 'desc')->first();

                $item_name1 = explode("|", $item_name);
                for ($x = 1; $x < count($item_name1); $x++) {
                    $item_nam = explode("|", $item_name);
                    $ordrqt = explode("|", $ordrqty);
                    $uni = explode("|", $unit);
                    $qt = explode("|", $qty);
                    $cos = explode("|", $cost);
                    $detai = explode("|", $detail);
                    $dateexpir = explode("|", $dateexpiry);
                    $find_itemname = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', $company_id)->where('ID', '=', $item_nam[$x])->orderBy('ID', 'DESC')->first();

                    if ($qt[$x] != 0 || $qt[$x] != 0.00) {
                        $result3 = DB::connection('sqlsrv3')->insert('INSERT INTO ReceivingOrderItems(CompanyID, ItemId, ItemName, ROID, PoQuantity, Unit, RecvdQuantity, Price, SubTotal, ItemExpiry, Detail) values (?,?,?,?,?,?,?,?,?,?,?)', [$company_id, $item_nam[$x], $find_itemname1->Name, $find_reqid11->ReceavingOrderID, $ordrqt[$x], $uni[$x], $qt[$x], $cos[$x], $qt[$x] * $cos[$x], $dateexpir[$x], $detai[$x]]);
                    }

                }
            }
            $find_pvpo1 = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('PoCode')->where('CompanyID', '=', $company_id)->where('PurchaseOrderID', '=', $poid)->orderBy('PurchaseOrderID', 'desc')->first();
            //   if ($status != 'Partially Completed' || $quantity_received=='yes') {
            //     $find_pv_exists = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', $company_id)->where('AgainstPO', '=', $find_pvpo1->PoCode)->where('AgainstINV', '=', '')->exists();
            //     if ($find_pv_exists) {


            //       //for Partial Invoice Update in Payment Voucher


            //       DB::connection('sqlsrv3')->update('update PaymentVoucherDetail set AgainstINV=? where CompanyID=?  and AgainstPO=? and AgainstINV=?', [$final_PoCode1, $company_id, $find_pvpo1->PoCode, '']);


            //       $find_pv_invoice = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', $company_id)->where('AgainstPO', '=', $find_pvpo1->PoCode)->where('AgainstINV', '=', $final_PoCode1)->select('Remaining')->orderBy('DetailID','desc')->first();

            //       $find_reqid11_check = DB::connection('sqlsrv3')->table("ReceivingOrder")->select('FormID')->where('CompanyID', '=', $company_id)->where('POID', '=', $poid)->where('ReqID', '=', $reqid)->where('FormID', '!=', $final_PoCode1)->where('isDeleted', '!=', 1)->where('Status','=','Partially Completed')->orderby('ReceavingOrderID', 'desc')->exists();
            //       if($find_reqid11_check){
            //         $find_reqid11 = DB::connection('sqlsrv3')->table("ReceivingOrder")->select('FormID')->where('CompanyID', '=', $company_id)->where('POID', '=', $poid)->where('ReqID', '=', $reqid)->where('FormID', '!=', $final_PoCode1)->where('isDeleted', '!=', 1)->where('Status','=','Partially Completed')->orderby('ReceavingOrderID', 'desc')->get();
            //         foreach($find_reqid11 as $find_reqid111){
            //           DB::connection('sqlsrv3')->insert('INSERT INTO PaymentVoucherDetail(CompanyID, Date, AgainstPO, AgainstINV, Amount, PVNO, Remaining) values (?,?,?,?,?,?,?)', [company_id(), $date, $find_pvpo1->PoCode, $find_reqid111->FormID, 0, 'Partail Invoice',$find_pv_invoice->Remaining ]);
            //         }
            //       }

            //     }
            // }

        }
        $req1 = DB::connection('sqlsrv3')->table("Requisition")->select('RId')->where('RequisitionId', '=', $reqid)->orderBy('RequisitionId', 'desc')->first();


        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [$company_id, $username, $UserFullName, 'New GRN Created', '' . $final_PoCode . ' | against ReqID ' . $req1->RId . ' | with Invoice Number ' . $invoice_no . ' | against Vendor ' . $vendor . ' | has been Created ', $update_date]);

        $message = 'submitted';
        return request()->json(200, $message);
    }

    public function count_grn9()
    {
        $company_id = company_id();

        $session = ac_c_session();
        $total = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', $company_id)->where('Session', '=', $session)->count();
        $Partially = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', $company_id)->where('Session', '=', $session)->where('Status', '=', 'Partially Completed')->count();
        $fully = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', $company_id)->where('Session', '=', $session)->where('Status', '=', 'Fully Completed')->count();
        $verified = DB::connection('sqlsrv3')->table('GrnOrder')->where('CompanyID', '=', $company_id)->where('Session', '=', $session)->where('Status2', '=', 'Verified')->count();

        $myJSON = array(
            'total' => $total,
            'partially' => $Partially,
            'fully' => $fully,
            'verified' => $verified,
        );
        return request()->json(200, $myJSON);
    }

    public function update_pinvoice(Request $request)
    {
        $company_id = company_id();
        $username = username();

        $update_date = long_date();

        $invoice_id = $request->get('invoice_id');
        $date = $request->get('date');
        $remarks = $request->get('remarks');
        $item_name = $request->get('item_name');
        $ordrqty = $request->get('ordrqty');
        $qty = $request->get('qty');
        $unit = $request->get('unit');
        $cost = $request->get('cost');
        $message = "";
        $subtotal = $request->get('subtotal');
        $tax_amount = $request->get('tax_amount');
        $discount = $request->get('discount');
        $delivery_amount = $request->get('delivery_amount');
        $total = $request->get('total');

        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $quoteqty1 = explode("|", $qty);
            $orderedqty1 = explode("|", $ordrqty);
            if ($orderedqty1[$x] < $quoteqty1[$x] || $orderedqty1[$x] == NULL) {
                $message = "Quantity error";
                return request()->json(200, $message);
            }
        }
        if ($message != "No quantity error") {
            $result = DB::connection('sqlsrv3')->update('update ReceivingOrder set SubTotal=?, Tax=?, ShippingCharges=?, Discount=?, TotalAmount=?, Dated=?, Remarks=?, UpdatedBy=?, UpdatedOn=? where CompanyID=?  and ReceavingOrderID=? ', [$subtotal, $tax_amount, $delivery_amount, $discount, $total, $date, $remarks, $username, $update_date, $company_id, $invoice_id]);
            if ($result) {
                DB::connection('sqlsrv3')->table('ReceivingOrderItems')->where('CompanyID', '=', $company_id)->where('ROID', $invoice_id)->delete();
                $find_reqid1 = DB::connection('sqlsrv3')->table("ReceivingOrder")->select('ReceavingOrderID')->where('CompanyID', '=', $company_id)->where('ReceavingOrderID', '=', $invoice_id)->orderBy('ReceavingOrderID', 'desc')->first();

                $item_name1 = explode("|", $item_name);
                for ($x = 1; $x < count($item_name1); $x++) {
                    $item_nam = explode("|", $item_name);
                    $ordrqt = explode("|", $ordrqty);
                    $uni = explode("|", $unit);
                    $qt = explode("|", $qty);
                    $cos = explode("|", $cost);

                    $find_itemname1 = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', $company_id)->where('ID', '=', $item_nam[$x])->orderBy('ID', 'DESC')->first();


                    $total1 = $qt[$x] * $cos[$x];

                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO ReceivingOrderItems(CompanyID, ROID, ItemId, ItemName, PoQuantity, Unit, RecvdQuantity, Price, SubTotal) values (?,?,?,?,?,?,?,?,?)', [$company_id, $find_reqid1->ReceavingOrderID, $item_nam[$x], $find_itemname1->Name, $ordrqt[$x], $uni[$x], $qt[$x], $cos[$x], $total1]);
                }
            }
            $message = "updated";
        }
        return request()->json(200, $message);
    }

    public function edit_grn1(Request $request)
    {
        $ReceavingOrderID = $request->get('ReceavingOrderID');
        $UserFullName = User();
        $Emp_id = Session::get('employee_id');
        $company_id = company_id();
        $username = username();
        $item_name = $request->get('item_name');
        $ordrqty = $request->get('ordrqty');
        $qty = $request->get('qty');
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
        $select_pmterm = $request->get('select_pmterm');
        $total = $request->get('total');

        $select_tax = $request->get('select_tax');
        $select_delivery = $request->get('select_delivery');

        $session = ac_c_session();
        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $ordrqt = explode("|", $ordrqty);
            $qt = explode("|", $qty);
            if ($qt[$x] > $ordrqt[$x]) {
                $message = 'Received Quantity Exceeded';
                return request()->json(200, $message);

            }
        }
        $find_req_type1 = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', $company_id)->where('RequisitionId', '=', $reqid)->orderBy('RequisitionId', 'desc')->first();

        $req_type = $find_req_type1->RequisitionType;
        $pro_name = $find_req_type1->ProjectName;

        $update_date = long_date();
        $doc_date = short_date();
        $find_prefix1 = DB::connection('sqlsrv3')->table("AccountsConfiguration")->select('CustomerInvoice')->where('CompanyID', '=', $company_id)->orderBy('ConfigurationID', 'desc')->first();

        $date_pref = shiftformat();
        $req_prefix = $find_prefix1->CustomerInvoice . '_' . $date_pref;

        $find_rid9 = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('CompanyID', '=', $company_id)->exists();
        if ($find_rid9) {
            $find_rid1 = DB::connection('sqlsrv3')->table("ReceivingOrder")->select('FormId')->where('CompanyID', '=', $company_id)->orderBy('ReceavingOrderID', 'desc')->first();

            $pre_id = explode("-", $find_rid1->FormId);
            $rid = $pre_id[1] + 1;
        } else {
            $rid = 1;
        }
        $final_PoCode = $req_prefix . '-' . $rid;

        $result = DB::connection('sqlsrv3')->update('Update ReceivingOrder set  InvoiceNo=? , SubTotal=? , Discount=? , Tax=?,ShippingCharges=?, TotalAmount=?,Remarks=?, Status=? ,UpdatedBy=? ,UpdatedOn=?, Session=?,Status2=?,PaymentTerm=? where ReceavingOrderID=? and CompanyID=? ', [$invoice_no, $subtotal, $discount, $tax_amount, $delivery_amount, $total, $remarks, $status, $username, $update_date, $session, 'Not Verified', $select_pmterm, $ReceavingOrderID, $company_id]);
        if ($result) {
            $cosfind = explode("|", $cost);
            $d_value = count($cosfind) - 1;
            $find_ex_amount = $total - $subtotal;
            $item_wise_value = $find_ex_amount / $d_value;


            $item_name1 = explode("|", $item_name);


            for ($x = 1; $x < count($item_name1); $x++) {
                $item_nam = explode("|", $item_name);
                $ordrqt = explode("|", $ordrqty);
                $uni = explode("|", $unit);
                $qt = explode("|", $qty);
                $cos = explode("|", $cost);
                $total1 = $qt[$x] * $cos[$x];

                if ($req_type == 'Goods' || $req_type == 'Assets') {
                    $find_itemname1 = DB::connection('sqlsrv3')->table("ItemList")->select('Name')->where('CompanyID', '=', $company_id)->where('ID', '=', $item_nam[$x])->orderBy('ID', 'DESC')->first();

                    $result = DB::connection('sqlsrv3')->update('update ReceivingOrderItems set CompanyID=?,ItemId=?,ItemName=?,PoQuantity=?,Unit=?,RecvdQuantity=?,Price=?,SubTotal=? where ROID=?', [$company_id, $item_nam[$x], $find_itemname1->Name, $ordrqt[$x], $uni[$x], $qt[$x], $cos[$x], $total1, $ReceavingOrderID]);
                } else {
                    $result3 = DB::connection('sqlsrv3')->update('update ReceivingOrderItems set CompanyID=?,PoQuantity=?,Unit=?,RecvdQuantity=?,Price=?,SubTotal=?,Detail=? where ROID=?', [$company_id, $ordrqt[$x], $uni[$x], $qt[$x], $cos[$x], $total1, $item_nam[$x], $ReceavingOrderID]);
                }
            }


        }
        if ($status == 'Partially Completed') {
            DB::connection('sqlsrv3')->update('update PurchaseOrder set state=?,pinv_state=?,DebitState=? where CompanyID=?  and PurchaseOrderID=? ', [0, 0, 0, $company_id, $poid]);
        }
        $message = 'submitted';
        return request()->json(200, $message);
    }

    public function grn_byname9(Request $request)
    {
        $company_id = company_id();

        $session = ac_c_session();

        $find_config = DB::connection('sqlsrv3')->table("GrnOrder")
            ->join('PurchaseOrder', 'GrnOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')
            ->join('Requisition', 'GrnOrder.ReqID', '=', 'Requisition.RequisitionId')
            ->join('ReceivingOrder', 'ReceivingOrder.GRNID', '=', 'GrnOrder.GrnOrderID')
            ->select('GrnOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'ReceivingOrder.ReceavingOrderID', 'ReceivingOrder.FormID', 'ReceivingOrder.Status2 as status8')
            ->where('GrnOrder.CompanyID', $company_id)
            // ->where('GrnOrder.Session', $session)
            ->where('ReceivingOrder.isDeleted', '!=', 1)
            ->where(function ($query) use ($request) {
                $query->where('GrnOrder.GrnID', 'like', '%' . $request->name . '%')
                    ->orWhere('PurchaseOrder.vendorName', 'like', '%' . $request->name . '%')
                    ->orWhere('ReceivingOrder.FormID', 'like', '%' . $request->name . '%')
                    ->orWhere('PurchaseOrder.PoCode', 'like', '%' . $request->name . '%');
            })
            ->orderBy('GrnOrder.GrnOrderID', 'desc')
            ->paginate(50);
        return request()->json(200, $find_config);
    }

    public function update_v_inv(Request $request)
    {
        $company_id = company_id();
        $pv_id = $request->get('get_id');
        $sts = $request->get('sts');

        $update_date = long_date();
        $doc_date = short_date();
        $username = username();
        $find_inv_data1 = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'ReceivingOrder.POID')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('ReceivingOrder.ReceavingOrderID', '=', $pv_id)->select('ReceivingOrder.*', 'PurchaseOrder.RequisitionType')->orderBy('ReceivingOrder.ReceavingOrderID', 'desc')->first();

        $total = $find_inv_data1->TotalAmount;
        $subtotal = $find_inv_data1->SubTotal;

        $find_inv_items = DB::connection('sqlsrv3')->table("ReceivingOrderItems")->where('CompanyID', '=', $company_id)->where('ROID', '=', $pv_id)->get();
        $d_value = count($find_inv_items);
        $find_ex_amount = ($find_inv_data1->Tax + $find_inv_data1->ShippingCharges) - $find_inv_data1->Discount;

        foreach ($find_inv_items as $find_inv_items1) {
            $item_nam = $find_inv_items1->ItemId;
            $cos = $find_inv_items1->Price;
            $qt = $find_inv_items1->RecvdQuantity;
            $amountt = ($qt * $cos) + (($find_ex_amount * $qt * $cos) / $subtotal);
            if ($amountt < 0 || $total < 0) {
                $message = "Amount cannot be Negative";
                return request()->json(200, $message);
            }
        }

        $result = DB::connection('sqlsrv3')->update('update ReceivingOrder set Status2=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and ReceavingOrderID=?', [$sts, $username, $update_date, $company_id, $pv_id]);
        if ($result) {


            $final_PoCode = $find_inv_data1->FormID;
            $invoice_no = $find_inv_data1->InvoiceNo;
            $remarks = $find_inv_data1->Remarks;
            $poid = $find_inv_data1->POID;
            $req_type = $find_inv_data1->RequisitionType;
            $delivery_amount = $find_inv_data1->ShippingCharges;
            $tax_amount = $find_inv_data1->Tax;

            $reqid = $find_inv_data1->ReqID;

            $find_req_type1 = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', $company_id)->where('RequisitionId', '=', $reqid)->orderBy('RequisitionId', 'desc')->first();

            $pro_name = $find_req_type1->ProjectName;
            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode, $final_PoCode . '/Invoice #' . $invoice_no . '/' . $remarks, 'Purchase Invoice', $update_date, $username, $company_id]);
            if ($doc) {
                $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', $company_id)->where('DocumentNo', '=', $final_PoCode)->orderBy('ID', 'DESC')->first();

                $find_vendor1 = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('vendorName')->where('CompanyID', '=', $company_id)->where('PurchaseOrderID', '=', $poid)->orderBy('PurchaseOrderID', 'desc')->first();

                $find_acc_code1 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', $company_id)->where('AccountHead', '=', 'Trade Creditors')->where('AccountName', '=', $find_vendor1->vendorName)->orderBy('ID', 'DESC')->first();

                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, $find_vendor1->vendorName . ' to Inventory with narration:' . $remarks, $company_id]);

                $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', $company_id)->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'C', $total, $company_id]);


                foreach ($find_inv_items as $find_inv_items1) {
                    $item_nam = $find_inv_items1->ItemId;
                    $cos = $find_inv_items1->Price;
                    $qt = $find_inv_items1->RecvdQuantity;
                    $amountt = ($qt * $cos) + (($find_ex_amount * $qt * $cos) / $subtotal);
                    if ($req_type == 'Goods') {

                        $find_acc_code91 = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('CoaID')->where('CompanyID', '=', $company_id)->where('ItemId', '=', $item_nam)->orderBy('ID', 'DESC')->first();


                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'D', $amountt, $company_id]);
                    } elseif ($req_type == 'Assets') {

                        $find_acc_code91 = DB::connection('sqlsrv3')->table("AssetsLinkCoa")->select('CoaID')->where('CompanyID', '=', $company_id)->where('AssetId', '=', $item_nam)->orderBy('ID', 'DESC')->first();

                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'D', $amountt, $company_id]);
                    } else {

                        $find_acc_code91 = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->select('CoaID')->where('CompanyID', '=', $company_id)->where('ProjectName', '=', $pro_name)->orderBy('ID', 'DESC')->first();


                        $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'D', $amountt, $company_id]);
                    }
                }

                if ($delivery_amount != 0) {

                    $ledger_delivery3 = DB::connection('sqlsrv3')->insert('INSERT INTO DeliveryDetail(CompanyID,DeliveryType,DeliveryAmount,ReferenceAccount,CreatedBy,CreatedOn) values (?,?,?,?,?,?)', [$company_id, 'Purchase', $delivery_amount, $final_PoCode, $username, $update_date]);
                }
                if ($tax_amount != 0) {

                    $ledger_tax4 = DB::connection('sqlsrv3')->insert('INSERT INTO TaxDetail(CompanyID,TaxType,TaxAmount,ReferenceAccount,CreatedBy,CreatedOn) values (?,?,?,?,?,?)', [$company_id, 'Purchase', $tax_amount, $final_PoCode, $username, $update_date]);
                }
            }
            $message = "Status updated!";
            return request()->json(200, $message);
        }
    }

    public function update_v_inv_grn(Request $request)
    {
        $company_id = company_id();
        $pv_id = $request->get('get_id');
        $sts = $request->get('sts');

        $update_date = long_date();
        $doc_date = short_date();
        $username = username();
        $find_inv_data1 = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'ReceivingOrder.POID')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('ReceivingOrder.ReceavingOrderID', '=', $pv_id)->select('ReceivingOrder.*', 'PurchaseOrder.RequisitionType')->orderBy('ReceivingOrder.ReceavingOrderID', 'desc')->first();

        $total = $find_inv_data1->TotalAmount;
        if ($total < 0) {
            $message = "Amount can not be Negative";
            return request()->json(200, $message);
        }

        $result = DB::connection('sqlsrv3')->update('update ReceivingOrder set Status2=?,UpdatedBy=?,UpdatedOn=? where CompanyID=? and ReceavingOrderID=?', [$sts, $username, $update_date, $company_id, $pv_id]);
        if ($result) {
            $status = $find_inv_data1->Status;
            $final_PoCode = $find_inv_data1->FormID;
            $invoice_no = $find_inv_data1->InvoiceNo;
            $remarks = $find_inv_data1->Remarks;
            $poid = $find_inv_data1->POID;
            $req_type = $find_inv_data1->RequisitionType;
            $delivery_amount = $find_inv_data1->ShippingCharges;
            $tax_amount = $find_inv_data1->Tax;
            $subtotal = $find_inv_data1->SubTotal;
            $reqid = $find_inv_data1->ReqID;
            $find_req_type1 = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', $company_id)->where('RequisitionId', '=', $reqid)->orderBy('RequisitionId', 'desc')->first();


            $pro_name = $find_req_type1->ProjectName;
            $find_ledger = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('CompanyID', '=', $company_id)->where('InvAfterVerify', '=', $find_inv_data1->ReceavingOrderID)->exists();


            //Accounts
            if (!$find_ledger) {

                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode, $final_PoCode . '/Invoice #' . $invoice_no . '/' . $remarks, 'Purchase Invoice', $update_date, $username, $company_id]);
                if ($doc) {
                    $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', $company_id)->where('DocumentNo', '=', $final_PoCode)->orderBy('ID', 'DESC')->first();


                    $find_vendor1 = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('vendorName')->where('CompanyID', '=', $company_id)->where('PurchaseOrderID', '=', $poid)->orderBy('PurchaseOrderID', 'desc')->first();

                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, $find_vendor1->vendorName . ' to Inventory with narration:' . $remarks, $company_id]);

                    $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', $company_id)->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                    $find_acc_code1 = DB::connection('sqlsrv3')->table("Accounts")->select('ID')->where('CompanyID', '=', $company_id)->where('AccountHead', '=', 'Trade Creditors')->where('AccountName', '=', $find_vendor1->vendorName)->orderBy('ID', 'DESC')->first();

                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,InvAfterVerify,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code1->ID, 'C', $total, $find_inv_data1->ReceavingOrderID, $company_id]);

                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,InvAfterVerify,CompanyID) values (?,?,?,?,?,?)', [$find_tran_id1->ID, '201001001432', 'D', $total, $find_inv_data1->ReceavingOrderID, $company_id]);
                    if ($delivery_amount != 0) {

                        $ledger_delivery3 = DB::connection('sqlsrv3')->insert('INSERT INTO DeliveryDetail(CompanyID,DeliveryType,DeliveryAmount,ReferenceAccount,CreatedBy,CreatedOn) values (?,?,?,?,?,?)', [$company_id, 'Purchase', $delivery_amount, $final_PoCode, $username, $update_date]);
                    }
                    if ($tax_amount != 0) {

                        $ledger_tax4 = DB::connection('sqlsrv3')->insert('INSERT INTO TaxDetail(CompanyID,TaxType,TaxAmount,ReferenceAccount,CreatedBy,CreatedOn) values (?,?,?,?,?,?)', [$company_id, 'Purchase', $tax_amount, $final_PoCode, $username, $update_date]);
                    }

                }
            }
            $grn_items = DB::connection('sqlsrv3')->table("ReceivingOrderItems")->where('ROID', '=', $pv_id)->where('CompanyID', '=', $company_id)->get();
            $arr = [];
            foreach ($grn_items as $grn_items1) {
                $item_nam91 = $grn_items1->ItemId;
                $qt9 = explode("|", $grn_items1->RecvdQuantity);

                $resultArray = [];
                $array1 = DB::connection('sqlsrv3')->table("ReceivingOrder")->where('POID', '=', $find_inv_data1->POID)->where("ReceavingOrderID", '!=', $pv_id)->where('isDeleted', '=', 0)->where('CompanyID', '=', $company_id)->select('ReceavingOrderID')->get();

                foreach ($array1 as $array11) {
                    $resultArray[] = (array)$array11;
                }
                $find_req_id_sum = DB::connection('sqlsrv3')->table("ReceivingOrderItems")->where('ItemId', '=', $grn_items1->ItemId)->whereIN('ROID', $resultArray)->sum('RecvdQuantity');


                $final_qty = intval($grn_items1->RecvdQuantity) + $find_req_id_sum;

                $find_req_table_sum = DB::connection('sqlsrv3')->table("PurchaseOrderItems")->where('POID', '=', $find_inv_data1->POID)->where('ItemId', '=', $grn_items1->ItemId)->sum('Quantity');

                if ($status == 'Partially Completed') {
                    if ($final_qty == $find_req_table_sum) {
                        array_push($arr, "yes");
                    } else {
                        array_push($arr, "no");
                    }
                }
            }

            $allElementsAreYes = array_reduce($arr, function ($carry, $item) {
                return $carry && ($item === "yes");
            }, true);

            $find_pvpo1 = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('PoCode')->where('CompanyID', '=', $company_id)->where('PurchaseOrderID', '=', $find_inv_data1->POID)->orderBy('PurchaseOrderID', 'desc')->first();
            if ($status != 'Partially Completed' || $allElementsAreYes) {
                $find_pv_exists = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', $company_id)->where('AgainstPO', '=', $find_pvpo1->PoCode)->where('AgainstINV', '=', '')->exists();
                if ($find_pv_exists) {


                    //for Partial Invoice Update in Payment Voucher


                    DB::connection('sqlsrv3')->update('update PaymentVoucherDetail set AgainstINV=? where CompanyID=?  and AgainstPO=? and AgainstINV=?', [$final_PoCode, $company_id, $find_pvpo1->PoCode, '']);


                    $find_pv_invoice = DB::connection('sqlsrv3')->table("PaymentVoucherDetail")->where('CompanyID', '=', $company_id)->where('AgainstPO', '=', $find_pvpo1->PoCode)->where('AgainstINV', '=', $final_PoCode)->select('Remaining')->orderBy('DetailID', 'desc')->first();

                    $find_reqid11_check = DB::connection('sqlsrv3')->table("ReceivingOrder")->select('FormID')->where('CompanyID', '=', $company_id)->where('POID', '=', $find_inv_data1->POID)->where('ReqID', '=', $reqid)->where('FormID', '!=', $final_PoCode)->where('isDeleted', '!=', 1)->where('Status', '=', 'Partially Completed')->orderby('ReceavingOrderID', 'desc')->exists();
                    if ($find_reqid11_check) {
                        $find_reqid11 = DB::connection('sqlsrv3')->table("ReceivingOrder")->select('FormID')->where('CompanyID', '=', $company_id)->where('POID', '=', $find_inv_data1->POID)->where('ReqID', '=', $reqid)->where('FormID', '!=', $final_PoCode)->where('isDeleted', '!=', 1)->where('Status', '=', 'Partially Completed')->orderby('ReceavingOrderID', 'desc')->get();
                        foreach ($find_reqid11 as $find_reqid111) {
                            DB::connection('sqlsrv3')->insert('INSERT INTO PaymentVoucherDetail(CompanyID, Date, AgainstPO, AgainstINV, Amount, PVNO, Remaining) values (?,?,?,?,?,?,?)', [company_id(), short_date(), $find_pvpo1->PoCode, $find_reqid111->FormID, 0, 'Partail Invoice', $find_pv_invoice->Remaining]);
                        }
                    }

                }
            }
            $message = "Status updated!";
            return request()->json(200, $message);

        }
    }

    public function get_grn_data1($id)
    {
        $cand = DB::connection('sqlsrv3')->table('ReceivingOrderItems')->where('ROID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public function count_grn()
    {
        $company_id = company_id();
        $dept = Session::get('employee_department');

        $session = ac_c_session();
        if ($dept == 'Software Development' || $dept == 'Audit' || $dept == 'Procurement' || $dept == 'Accounts') {
            $total = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('ReceivingOrder.Session', '=', $session)->count();
            $Partially = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('ReceivingOrder.Session', '=', $session)->where('ReceivingOrder.Status', '=', 'Partially Completed')->count();
            $fully = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('ReceivingOrder.Session', '=', $session)->where('ReceivingOrder.Status', '=', 'Fully Completed')->count();
            $verified = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('ReceivingOrder.Session', '=', $session)->where('ReceivingOrder.Status2', '=', 'Verified')->count();
        } else {
            $total = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('Requisition.DepartmentName', '=', $dept)->where('ReceivingOrder.Session', '=', $session)->count();
            $Partially = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('Requisition.DepartmentName', '=', $dept)->where('ReceivingOrder.Session', '=', $session)->where('ReceivingOrder.Status', '=', 'Partially Completed')->count();
            $fully = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('Requisition.DepartmentName', '=', $dept)->where('ReceivingOrder.Session', '=', $session)->where('ReceivingOrder.Status', '=', 'Fully Completed')->count();
            $verified = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('Requisition.DepartmentName', '=', $dept)->where('ReceivingOrder.Session', '=', $session)->where('ReceivingOrder.Status2', '=', 'Verified')->count();
        }

        $myJSON = array(
            'total' => $total,
            'partially' => $Partially,
            'fully' => $fully,
            'verified' => $verified,
        );
        return request()->json(200, $myJSON);
    }

    public function update_grn($id, $status)
    {
        $company_id = company_id();
        $result = DB::connection('sqlsrv3')->update('update ReceivingOrder set Status2=? where CompanyID=? and ReceavingOrderID=?', [$status, $company_id, $id]);
        if ($result) {
            if ($status == 'Verified') {

                $update_date = long_date();
                $update_dated = short_date();
                $username = username();
                $find_grn1 = DB::connection('sqlsrv3')->table('ReceivingOrder')->where('ReceavingOrderID', '=', $id)->orderBy('ReceavingOrderID', 'desc')->first();


                $find_recvd_items = DB::connection('sqlsrv3')->table('ReceivingOrderItems')->where('ROID', '=', $id)->get();
                foreach ($find_recvd_items as $find_recvd_items1) {

                    $itemid = $find_recvd_items1->ItemId;
                    $ItemName = $find_recvd_items1->ItemName;
                    $Unit = $find_recvd_items1->Unit;
                    $RecvdQuantity = $find_recvd_items1->RecvdQuantity;
                    $ItemExpiry = $find_recvd_items1->ItemExpiry;
                    $CostUnit = $find_recvd_items1->Price;
                    $check_invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $itemid)->exists();
                    $facevalue;
                    if ($check_invent) {
                        $invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $itemid)->select('FaceValue')->orderBy('ID', 'DESC')->first();
                        $facevalue = $invent->FaceValue;
                    } else {
                        $facevalue = 0;
                    }
                    $result = DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,CreatedBy,CreatedOn,Reference,ItemExpiry,CostUnit,Dated,FaceValue) values (?,?,?,?,?,?,?,?,?,?,?,?)', [$company_id, $itemid, $RecvdQuantity, $Unit, 1, $username, $update_date, 'Added stock through ' . $find_grn1->FormID, $ItemExpiry, $CostUnit, $update_dated, $facevalue]);
                }
            }


            $session = ac_c_session();
            $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('ReceivingOrder.Session', '=', $session)->orderby('ReceivingOrder.ReceavingOrderID', 'desc')->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->paginate(20);
            return request()->json(200, $find_config);
        }
    }

    public function get_grn_data9($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("GrnOrder")->join('PurchaseOrder', 'GrnOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'GrnOrder.ReqID', '=', 'Requisition.RequisitionId')->where('GrnOrder.CompanyID', '=', company_id())->where('GrnOrderID', '=', $id)->select('GrnOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->get();
        return request()->json(200, $find_config);
    }

    public function get_grn_data19($id)
    {
        $cand = DB::connection('sqlsrv3')->table('GrnOrderItems')->where('GrnID', '=', $id)->get();
        return request()->json(200, $cand);
    }

    public function update_grn9($id, $status)
    {
        $company_id = company_id();
        $Emp_id = Session::get('employee_id');
        $UserFullName = User();

        $update_date = long_date();
        $update_d = short_date();
        $username = username();
        $find_inv91 = DB::connection('sqlsrv3')->table('ReceivingOrder')->where('GRNID', '=', $id)->orderBy('ReceavingOrderID', 'desc')->first();


        $pv_id = $find_inv91->ReceavingOrderID;
        $find_inv_data1 = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'PurchaseOrder.PurchaseOrderID', '=', 'ReceivingOrder.POID')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('ReceivingOrder.ReceavingOrderID', '=', $pv_id)->select('ReceivingOrder.*', 'PurchaseOrder.RequisitionType')->orderBy('ReceavingOrderID', 'desc')->first();


        $total = $find_inv_data1->TotalAmount;
        $subtotal = $find_inv_data1->SubTotal;
        $find_ex_amount = ($find_inv_data1->Tax + $find_inv_data1->ShippingCharges) - $find_inv_data1->Discount;
        $find_inv_items = DB::connection('sqlsrv3')->table("ReceivingOrderItems")->where('CompanyID', '=', $company_id)->where('ROID', '=', $pv_id)->get();
        foreach ($find_inv_items as $find_inv_items1) {
            $item_nam = $find_inv_items1->ItemId;
            $cos = $find_inv_items1->Price;
            $qt = $find_inv_items1->RecvdQuantity;
            $amountt = ($qt * $cos) + (($find_ex_amount * $qt * $cos) / $subtotal);
            if ($qt > 0) {
                if ($total < 0 || $amountt < 0) {
                    $findconfig = 'Total Amount cannot be negative';
                    return request()->json(200, $findconfig);
                }
            }

        }


        $result = DB::connection('sqlsrv3')->update('update GrnOrder set Status2=?,SupervisedBy=?,SupervisedOn=? where CompanyID=? and GrnOrderID=?', [$status, $username, $update_date, $company_id, $id]);
        if ($result) {
            if ($status == 'Verified') {

                $find_grn1 = DB::connection('sqlsrv3')->table('GrnOrder')->where('GrnOrderID', '=', $id)->orderBy('GrnOrderID', 'desc')->first();

                $find_req_type1 = DB::connection('sqlsrv3')->table('PurchaseOrder')->where('PurchaseOrderID', '=', $find_grn1->POID)->orderBy('PurchaseOrderID', 'desc')->first();

                if ($find_req_type1->RequisitionType == 'Goods') {
                    $find_recvd_items = DB::connection('sqlsrv3')->table('GrnOrderItems')->where('GrnID', '=', $id)->get();
                    foreach ($find_recvd_items as $find_recvd_items1) {
                        $itemid = $find_recvd_items1->ItemId;
                        $ItemName = $find_recvd_items1->ItemName;
                        $Unit = $find_recvd_items1->Unit;
                        $RecvdQuantity = $find_recvd_items1->RecvdQuantity;
                        $ItemExpiry = $find_recvd_items1->ItemExpiry;
                        $CostUnit = $find_recvd_items1->Price;
                        $check_invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $itemid)->exists();
                        $facevalue;
                        if ($check_invent) {
                            $invent = DB::connection('sqlsrv3')->table('Inventory')->where('ItemID', '=', $itemid)->select('FaceValue')->orderBy('ID', 'DESC')->first();
                            $facevalue = $invent->FaceValue;
                        } else {
                            $facevalue = 0;
                        }
                        $result = DB::connection('sqlsrv3')->insert('INSERT INTO Inventory(CompanyID,ItemID,Quantity,Unit,Type,CreatedBy,CreatedOn,Reference,ItemExpiry,CostUnit,Dated,FaceValue) values (?,?,?,?,?,?,?,?,?,?,?,?)', [$company_id, $itemid, $RecvdQuantity, $Unit, 1, $username, $update_date, 'Added stock through ' . $find_grn1->GrnID, $ItemExpiry, $CostUnit, $update_d, $facevalue]);

                    }
                } elseif ($find_req_type1->RequisitionType == 'Assets') {
                    $find_recvd_items = DB::connection('sqlsrv3')->table('GrnOrderItems')->where('GrnID', '=', $id)->get();
                    foreach ($find_recvd_items as $find_recvd_items1) {

                        $itemid = $find_recvd_items1->ItemId;
                        $find_ass_id9 = DB::connection('sqlsrv3')->table('Assets')->where('CompanyID', '=', $company_id)->where('AssetID', '=', $itemid)->where('AssetType', '=', 1)->exists();
                        if ($find_ass_id9) {
                            $find_ass_id1 = DB::connection('sqlsrv3')->table('Assets')->where('CompanyID', '=', $company_id)->where('AssetID', '=', $itemid)->where('AssetType', '=', 1)->orderBy('ID', 'DESC')->first();

                            $pre_uniq_id = $find_ass_id1->AssetsUniqueID;
                            $pre_id = explode("-", $pre_uniq_id);
                            $rid = $pre_id[1] + 1;
                            $ass_unique_id = $itemid . '-' . $rid;
                        } else {
                            $ass_unique_id = $itemid . '-1';
                        }
                        $ItemName = $find_recvd_items1->ItemName;
                        $Unit = $find_recvd_items1->Unit;
                        $RecvdQuantity = $find_recvd_items1->RecvdQuantity;
                        $ItemExpiry = $find_recvd_items1->ItemExpiry;
                        $CostUnit = $find_recvd_items1->Price;
                        for ($x = 0; $x < $RecvdQuantity; $x++) {
                            $ex_ass_uniq = explode("-", $ass_unique_id);
                            $cu_uniq = $ex_ass_uniq[1] + $x;
                            $act_uni = $ex_ass_uniq[0] . '-' . $cu_uniq;
                            $resu = DB::connection('sqlsrv3')->insert('INSERT INTO Assets(CompanyID,AssetID,AssetsUniqueID,Quantity,Unit,AssetType,CreatedBy,CreatedOn,Reference,ItemExpiry,CostUnit,Dated) values (?,?,?,?,?,?,?,?,?,?,?,?)', [$company_id, $itemid, $act_uni, 0, $Unit, 0, $username, $update_date, 'Added Assets through ' . $find_grn1->GrnID, $ItemExpiry, $CostUnit, $update_d]);

                            $result = DB::connection('sqlsrv3')->insert('INSERT INTO Assets(CompanyID,AssetID,AssetsUniqueID,Quantity,Unit,AssetType,CreatedBy,CreatedOn,Reference,ItemExpiry,CostUnit,Dated) values (?,?,?,?,?,?,?,?,?,?,?,?)', [$company_id, $itemid, $act_uni, 1, $Unit, 1, $username, $update_date, 'Added Assets through ' . $find_grn1->GrnID, $ItemExpiry, $CostUnit, $update_d]);
                        }

                    }

                }

                $sts = $status;

                $doc_date = short_date();

                $final_PoCode = $find_inv_data1->FormID;
                $invoice_no = $find_inv_data1->InvoiceNo;
                $remarks = $find_inv_data1->Remarks;
                $poid = $find_inv_data1->POID;
                $req_type = $find_inv_data1->RequisitionType;
                $delivery_amount = $find_inv_data1->ShippingCharges;
                $tax_amount = $find_inv_data1->Tax;

                $reqid = $find_inv_data1->ReqID;
                //         $cosfind = explode("|" , $cost);
                //

                $find_req_type1 = DB::connection('sqlsrv3')->table("Requisition")->where('CompanyID', '=', $company_id)->where('RequisitionId', '=', $reqid)->orderBy('RequisitionId', 'desc')->first();


                $pro_name = $find_req_type1->ProjectName;

                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode, $final_PoCode . '/Invoice #' . $invoice_no . '/' . $remarks, 'Purchase Invoice', $update_date, $username, $company_id]);
                if ($doc) {
                    $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', $company_id)->where('DocumentNo', '=', $final_PoCode)->orderBy('ID', 'DESC')->first();

                    $find_vendor1 = DB::connection('sqlsrv3')->table("PurchaseOrder")->select('vendorName')->where('CompanyID', '=', $company_id)->where('PurchaseOrderID', '=', $poid)->orderBy('PurchaseOrderID', 'desc')->first();

                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Inventory To ' . $find_vendor1->vendorName . ' with narration:' . $remarks, $company_id]);

                    $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', $company_id)->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '201001001432', 'C', $total, $company_id]);


                    foreach ($find_inv_items as $find_inv_items1) {
                        $item_nam = $find_inv_items1->ItemId;
                        $cos = $find_inv_items1->Price;
                        $qt = $find_inv_items1->RecvdQuantity;
                        $amountt = ($qt * $cos) + (($find_ex_amount * $qt * $cos) / $subtotal);
                        if ($req_type == 'Goods') {

                            $find_acc_code91 = DB::connection('sqlsrv3')->table("ItemLinkCoa")->select('CoaID')->where('CompanyID', '=', $company_id)->where('ItemId', '=', $item_nam)->orderBy('ID', 'DESC')->first();


                            $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'D', $amountt, $company_id]);
                        } elseif ($req_type == 'Assets') {

                            $find_acc_code91 = DB::connection('sqlsrv3')->table("AssetsLinkCoa")->select('CoaID')->where('CompanyID', '=', $company_id)->where('AssetId', '=', $item_nam)->orderBy('ID', 'DESC')->first();

                            $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'D', $amountt, $company_id]);

                        } else {

                            $find_acc_code91 = DB::connection('sqlsrv3')->table("ProjectLinkCoa")->select('CoaID')->where('CompanyID', '=', $company_id)->where('ProjectName', '=', $pro_name)->orderBy('ID', 'DESC')->first();

                            $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $find_acc_code91->CoaID, 'D', $amountt, $company_id]);

                        }
                    }
                }
            }

            $session = ac_c_session();

            $req1 = DB::connection('sqlsrv3')->table('GrnOrder')->where('GrnOrderID', '=', $id)->orderBy('GrnOrderID', 'desc')->first();

            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EmployeeID, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?,?)", [$company_id, $username, $UserFullName, $Emp_id, 'Document Status For GRN Updated', '' . $req1->GrnID . ' Status | Updated to | ' . $status . '', $update_date]);

            $findconfig = 'Status Updated';
            return request()->json(200, $findconfig);

        }
    }

    public function edit_grn(Request $request)
    {
        /*Note: Update if another function exists with same name update that's name from "update_grn" to "update_grn_status" */
        $company_id = company_id();
        $username = username();

        $update_date = long_date();

        $get_id = $request->get('get_id');
        $item_name = $request->get('item_name');
        $orderedqty = $request->get('orderedqty');
        $pro_unit = $request->get('pro_unit');
        $rcvdqty = $request->get('rcvdqty');
        $expdate = $request->get('expdate');
        $status = $request->get('status');
        $date = $request->get('date');
        $vendor = $request->get('vendor');
        $invoice_no = $request->get('invoice_no');
        $grn_po = $request->get('grn_po');
        $narration = $request->get('ed_narration');
        $find_config = "";
        $item_name1 = explode("|", $item_name);
        for ($x = 1; $x < count($item_name1); $x++) {
            $rcvdqty1 = explode("|", $rcvdqty);
            $orderedqty1 = explode("|", $orderedqty);
            $expdate1 = explode("|", $expdate);
            if ($orderedqty1[$x] < $rcvdqty1[$x] || $rcvdqty1[$x] == null || $expdate1[$x] == null) {
                if ($expdate1[$x] == null) {
                    $find_config = "Select date";
                    return request()->json(200, $find_config);
                } else if ($orderedqty1[$x] < $rcvdqty1[$x] || $rcvdqty1[$x] == null) {
                    $find_config = "Quantity error";
                    return request()->json(200, $find_config);
                } else {
                    $find_config = "Not updated";
                    return request()->json(200, $find_config);
                }
            }
        }

        if ($find_config != "Quantity error") {
            $result = DB::connection('sqlsrv3')->update('update GrnOrder set Dated=?, Remarks=?, UpdatedBy=?, UpdatedOn=? where CompanyID=?  and GrnOrderID=? ', [$date, $narration, $username, $update_date, $company_id, $get_id]);

            if ($result) {
                DB::connection('sqlsrv3')->table('GrnOrderItems')->where('CompanyID', '=', $company_id)->where('GrnID', $get_id)->delete();

                $item_name1 = explode("|", $item_name);
                for ($x = 1; $x < count($item_name1); $x++) {
                    $item_nam = explode("|", $item_name);
                    $orderedqty1 = explode("|", $orderedqty);
                    $pro_unit1 = explode("|", $pro_unit);
                    $rcvdqty1 = explode("|", $rcvdqty);
                    $expdate1 = explode("|", $expdate);

                    $find_itemname1 = DB::connection('sqlsrv3')->table("PurchaseOrderItems")->select('ItemName', 'ItemId', 'Price')->where('CompanyID', '=', $company_id)->where('POID', '=', $grn_po)->where('ItemId', '=', $item_nam[$x])->orderBy('POItemID', 'desc')->first();

                    DB::connection('sqlsrv3')->insert('INSERT INTO GrnOrderItems(CompanyID, GrnID, ItemId, ItemName, Unit, PoQuantity, RecvdQuantity, ItemExpiry, Price) values (?,?,?,?,?,?,?,?,?)', [$company_id, $get_id, $find_itemname1->ItemId, $find_itemname1->ItemName, $pro_unit1[$x], $orderedqty1[$x], $rcvdqty1[$x], $expdate1[$x], $find_itemname1->Price]);
                }
            }

            $find_config = "GRN updated";
        }
        return request()->json(200, $find_config);
    }

    public function searchgrn($datefrom, $dateto)
    {
        $company_id = company_id();
        $username = username();

        $dept = Session::get('employee_department');
        if ($dept == 'Software Development' || $dept == 'Audit' || $dept == 'Procurement' || $dept == 'Accounts') {
            $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('Requisition.RequisitionType', '=', 'Services')
                // ->where('ReceivingOrder.Session', '=', ac_c_session())
                ->where('ReceivingOrder.Dated', '>=', $datefrom)->where('ReceivingOrder.Dated', '<=', $dateto)->orderby('ReceivingOrder.ReceavingOrderID', 'desc')->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->paginate(20);
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', $company_id)->where('Email', '=', $username)->exists();
            if ($find_useraccess) {
                $find_user1 = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', $company_id)->where('Email', '=', $username)->orderBy('ID', 'DESC')->first();

                $d1 = $find_user1->d1;
                $d2 = $find_user1->d2;
                $d3 = $find_user1->d3;
                $d4 = $find_user1->d4;
                $d5 = $find_user1->d5;
                $d6 = $find_user1->d6;
                $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('Requisition.DepartmentName', '=', $d1)->orwhere('Requisition.DepartmentName', '=', $d2)->orwhere('Requisition.DepartmentName', '=', $d3)->orwhere('Requisition.DepartmentName', '=', $d4)->orwhere('Requisition.DepartmentName', '=', $d5)->orwhere('Requisition.DepartmentName', '=', $d6)->where('Requisition.RequisitionType', '=', 'Services')
                    // ->where('ReceivingOrder.Session', '=', ac_c_session())
                    ->where('ReceivingOrder.Dated', '>=', $datefrom)->where('ReceivingOrder.Dated', '<=', $dateto)->orderby('ReceivingOrder.ReceavingOrderID', 'desc')->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->paginate(20);
            } else {
                $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('Requisition.DepartmentName', '=', $dept)->where('Requisition.RequisitionType', '=', 'Services')
                    // ->where('ReceivingOrder.Session', '=', ac_c_session())
                    ->where('ReceivingOrder.Dated', '>=', $datefrom)->where('ReceivingOrder.Dated', '<=', $dateto)->orderby('ReceivingOrder.ReceavingOrderID', 'desc')->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->paginate(20);
            }
        }
        return request()->json(200, $find_config);
    }

    public function grn_detail(Request $request)
    {

        $company_id = company_id();
        $dept = Session::get('employee_department');
        $username = username();

        $session = ac_c_session();

        if ($dept == 'Software Development' || $dept == 'Audit' || $dept == 'Procurement' || $dept == 'Accounts') {
            $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('Requisition.RequisitionType', '=', 'Services')->where('ReceivingOrder.CompanyID', '=', $company_id)->where('ReceivingOrder.Session', '=', $session)->orderby('ReceivingOrder.ReceavingOrderID', 'desc')->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->paginate(20);
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', $company_id)->where('Email', '=', $username)->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', $company_id)->where('Email', '=', $username)->first();
                $departments = [$find_user->d1, $find_user->d2, $find_user->d3, $find_user->d4, $find_user->d5, $find_user->d6, $dept];

                $find_config = DB::connection('sqlsrv3')->table('ReceivingOrder')->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.Session', $session)->where('Requisition.RequisitionType', 'Services')->where(function ($query) use ($request) {
                    $query->where('PurchaseOrder.vendorName', 'like', '%' . $request->name . '%')->orWhere('ReceivingOrder.FormID', 'like', '%' . $request->name . '%');
                })->whereIn('Requisition.DepartmentName', $departments)->where('ReceivingOrder.CompanyID', $company_id)->orderBy('ReceivingOrder.ReceavingOrderID', 'desc')->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->paginate(20);
            } else {
                $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.Session', '=', $session)->where('Requisition.RequisitionType', '=', 'Services')->whereRaw("(PurchaseOrder.vendorName like '%{$request->name}%' or ReceivingOrder.FormID like '%{$request->name}%') and Requisition.DepartmentName = '{$dept}'")->where('ReceivingOrder.CompanyID', '=', $company_id)->orderby('ReceivingOrder.ReceavingOrderID', 'desc')->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->paginate(20);
            }
        }
        return request()->json(200, $find_config);
    }

    public function grn_byname(Request $request)
    {
        $company_id = company_id();
        $dept = Session::get('employee_department');
        $username = username();

        $session = ac_c_session();

        if ($dept == 'Software Development' || $dept == 'Audit' || $dept == 'Procurement' || $dept == 'Accounts') {
            $find_config = DB::connection('sqlsrv3')
            ->table('ReceivingOrder')
            ->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')
            ->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')
            ->where('Requisition.RequisitionType', '=', 'Services')
            ->where('ReceivingOrder.CompanyID', '=', $company_id)
            ->where(function ($query) use ($request) {
                $query->where('PurchaseOrder.vendorName', 'like', '%' . $request->name . '%')
                    ->orWhere('ReceivingOrder.FormID', 'like', '%' . $request->name . '%')
                    ->orWhere('PurchaseOrder.PoCode', 'like', '%' . $request->name . '%');
            })
            ->orderBy('ReceivingOrder.ReceavingOrderID', 'desc')
            ->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')
            ->paginate(20);
        } else {
            $find_useraccess = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', $company_id)->where('Email', '=', $username)->exists();
            if ($find_useraccess) {
                $find_user = DB::connection('sqlsrv3')->table('DeptAccess')->where('CompanyID', '=', $company_id)->where('Email', '=', $username)->first();
                $departments = [$find_user->d1, $find_user->d2, $find_user->d3, $find_user->d4, $find_user->d5, $find_user->d6];

                $find_config = DB::connection('sqlsrv3')
                ->table('ReceivingOrder')
                ->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')
                ->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')
                ->where('Requisition.RequisitionType', 'Services')
                ->where(function ($query) use ($request) {
                    $query->where('PurchaseOrder.vendorName', 'like', '%' . $request->name . '%')
                        ->orWhere('ReceivingOrder.FormID', 'like', '%' . $request->name . '%')
                        ->orWhere('PurchaseOrder.PoCode', 'like', '%' . $request->name . '%');
                })
                ->whereIn('Requisition.DepartmentName', $departments)
                ->where('ReceivingOrder.CompanyID', $company_id)
                ->orderBy('ReceivingOrder.ReceavingOrderID', 'desc')
                ->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')
                ->paginate(20);

            } else {
                $find_config = DB::connection('sqlsrv3')
                ->table('ReceivingOrder')
                ->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')
                ->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')
                ->where('Requisition.RequisitionType', 'Services')
                ->where(function ($query) use ($request) {
                    $query->whereRaw("PurchaseOrder.vendorName like '%{$request->name}%'")
                        ->orWhereRaw("PurchaseOrder.PoCode like '%{$request->name}%'")
                        ->orWhereRaw("ReceivingOrder.FormID like '%{$request->name}%'");
                })
                ->where('Requisition.DepartmentName', $dept)
                ->where('ReceivingOrder.CompanyID', $company_id)
                ->orderBy('ReceivingOrder.ReceavingOrderID', 'desc')
                ->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')
                ->paginate(20);

            }
        }
        return request()->json(200, $find_config);
    }

    public function searchgrn9($sts1, $sts2, $datefrom, $dateto)
    {
        $company_id = company_id();

        if ($sts1 == "All") {
            $sts1 = "";
        }
        if ($sts2 == "All") {
            $sts2 = "";
        }

        $find_config = DB::connection('sqlsrv3')->table("GrnOrder")
            ->join('PurchaseOrder', 'GrnOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')
            ->join('Requisition', 'GrnOrder.ReqID', '=', 'Requisition.RequisitionId')
            ->join('ReceivingOrder', 'ReceivingOrder.GRNID', '=', 'GrnOrder.GrnOrderID')
            ->select('GrnOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'ReceivingOrder.ReceavingOrderID', 'ReceivingOrder.FormID', 'ReceivingOrder.Status2 as status8')
            ->where('GrnOrder.CompanyID', $company_id)
            // ->where('GrnOrder.Session', $session)
            ->where('ReceivingOrder.isDeleted', '!=', 1)
            ->where('GrnOrder.Status', 'LIKE', '%' . $sts1 . '%')->where('GrnOrder.Status2', 'LIKE', $sts2 . '%')->where('GrnOrder.Dated', '>=', $datefrom)->where('GrnOrder.Dated', '<=', $dateto)
            ->orderBy('GrnOrder.GrnOrderID', 'desc')
            ->paginate(50);
        return request()->json(200, $find_config);
        // $find_config = DB::connection('sqlsrv3')->table("GrnOrder")->join('PurchaseOrder', 'GrnOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'GrnOrder.ReqID', '=', 'Requisition.RequisitionId')->where('GrnOrder.CompanyID', '=', $company_id)
        // // ->where('GrnOrder.Session', '=', $session)
        // ->where('PurchaseOrder.vendorName', 'LIKE', '%' . $vendor . '%')->where('GrnOrder.Status', 'LIKE', '%' . $sts1 . '%')->where('GrnOrder.Status2', 'LIKE', $sts2 . '%')->where('GrnOrder.Dated', '>=', $datefrom)->where('GrnOrder.Dated', '<=', $dateto)->orderby('GrnOrder.GrnOrderID', 'desc')->select('GrnOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->paginate(20);
        // return request()->json(200, $find_config);
    }

    public function grn_detail9()
    {
        $find_config = DB::connection('sqlsrv3')->table("GrnOrder")
            ->join('PurchaseOrder', 'GrnOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')
            ->join('Requisition', 'GrnOrder.ReqID', '=', 'Requisition.RequisitionId')
            ->join('ReceivingOrder', 'ReceivingOrder.GRNID', '=', 'GrnOrder.GrnOrderID')
            ->select('GrnOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName', 'ReceivingOrder.ReceavingOrderID', 'ReceivingOrder.FormID', 'ReceivingOrder.Status2 as status8')
            ->where('GrnOrder.CompanyID', company_id())
            ->where('GrnOrder.Session', ac_c_session())
            ->where('ReceivingOrder.isDeleted', '!=', 1)
            ->orderBy('GrnOrder.GrnOrderID', 'desc')
            ->paginate(50);
        return request()->json(200, $find_config);
    }

    public function get_grn_data($id)
    {

        $find_config = DB::connection('sqlsrv3')->table("ReceivingOrder")->join('PurchaseOrder', 'ReceivingOrder.POID', '=', 'PurchaseOrder.PurchaseOrderID')->join('Requisition', 'ReceivingOrder.ReqID', '=', 'Requisition.RequisitionId')->where('ReceivingOrder.CompanyID', '=', company_id())->where('ReceavingOrderID', '=', $id)->select('ReceivingOrder.*', 'PurchaseOrder.vendorName', 'Requisition.DepartmentName', 'Requisition.ProjectName')->get();
        return request()->json(200, $find_config);
    }

    public function delete_grn($id)
    {
        $company_id = company_id();
        $username = username();
        $message = DB::connection('sqlsrv3')->update('update GrnOrder set isDeleted=?,DeletedBy=? where CompanyID=? and GrnOrderID=?', [1, $username, $company_id, $id]);
        $message1 = DB::connection('sqlsrv3')->update('update ReceivingOrder set isDeleted=?,DeletedBy=? where CompanyID=? and GRNID=?', [1, $username, $company_id, $id]);

        $find_company1 = DB::connection('sqlsrv3')->table("GrnOrderItems")->where('CompanyID', '=', $company_id)->where('GrnID', '=', $id)->orderBy('GrnOrderItemID', 'desc')->first();

        $id1 = $find_company1->poid;

        $message2 = DB::connection('sqlsrv3')->update('update PurchaseOrder set state=?,DebitState=?,pinv_state=?,Status2=? where CompanyID=? and PurchaseOrderID=?', [0, 0, 0, "Not Delivered", $company_id, $id1]);


        if ($message && $message1 && $message2) {
            $data = 'GRN deleted';
        } else {
            $data = 'GRN Not Deleted';
        }
        return request()->json(200, $data);
    }
}
