<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $company_id = Session::get('company_id');
    date_default_timezone_set("Asia/Karachi");
    $update_date = date("Y-m-d h:i:s A");
    $start_date=date("Y-m-d");
	$end_date=date("Y-m-d");
    $username = Session::get('username');
    try {
      DB::connection('sqlsrv4')->getPdo();
      if (DB::connection('sqlsrv4')->getDatabaseName()) {
        $record0 =  DB::connection('sqlsrv4')->select("select * from Receipts
where Cancel=1 and DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");
        foreach ($record0 as $record00) {
          $record_d = DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId', '=', 'R1_' . $record00->Id)->where('status', null)->exists();
          if ($record_d) {
            DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId', '=', 'R1_' . $record00->Id)->where('status', null)->delete();
          }
        }
        $record =  DB::connection('sqlsrv4')->select("select * from Receipts
where Cancel is null and DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");
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
            ]);
          }
        }

        //SAM_RECIPT
        $record001 =  DB::connection('sqlsrv4')->select("select * from SAM_Receipts
        where Cancel=1 and DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '".$start_date."' and '".$end_date."'");
        foreach ($record0 as $record00) {
         $record_d=DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId','=','R2_'.$record00->Id)->where('status',null)->exists();
         if($record_d){
        DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId','=','R2_'.$record00->Id)->where('status',null)->delete();
         }

        }
                  $record22 =  DB::connection('sqlsrv4')->select("select * from SAM_Receipts
        where Cancel is null and DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '".$start_date."' and '".$end_date."'");



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




$record44 =  DB::connection('sqlsrv4')->select("select * from PropertyDeal_Receipts
where DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '".$start_date."' and '".$end_date."'");

           foreach ($record44 as $record441) {


            $record_exists44=DB::connection('sqlsrv3')->table('TempReceiptTable')->where('RId','=','R4_'.$record441->Id)->exists();
            if(!$record_exists44){
               $date44 = explode(" ",$record441->DateTime);
               $find_sam_already_exists=DB::connection('sqlsrv3')->table('TempReceiptTable')->where('ReceiptNo','=',$record441->ReceiptNo)->where('DateTime','=',$date44[0])->where('RId','like','R2_%')->exists();

               if(!$find_sam_already_exists){
                DB::connection('sqlsrv3')->table('TempReceiptTable')->insert([
                    'RId' => 'R4_'.$record441->Id,
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
                     'Userid'=> $record441->Userid,
                    'Block' => $record441->Block,
                    'File_Plot_Number' => $record441->File_Plot_Number,
                     'DateTime' => $date44[0],
                ]);

               }

           }

          }

        //SAM payment voucher


        $record55 =  DB::connection('sqlsrv4')->select("select * from PropertyDeal_Voucher
where DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");

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

        $record66 =  DB::connection('sqlsrv4')->select("select * from SAM_Voucher
where DATEADD(dd, 0, DATEDIFF(dd, 0, [DateTime])) between '" . $start_date . "' and '" . $end_date . "'");

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
        $record77 =  DB::connection('sqlsrv4')->select("select * from Cancellation_Receipts where Id > 1253 ");
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
      $arr = "Could not find the MIS DB. Please check your Network Connection1.";
      return request()->json(200, $arr);
    }
})->purpose('Display an inspiring quote');
