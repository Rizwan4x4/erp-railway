<?php

namespace App\Http\Controllers\HRMS;

use Session;
use DB;

use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use maliklibs\Zkteco\Lib\ZKTeco;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailClass;
use Illuminate\Support\Facades\Log;

class HrController extends Controller
{
    use CommonTrait;

    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
        $this->fpdf->SetAutoPageBreak(true);
        $this->fpdf->SetLeftMargin(10);
    }


    public function get_machine_users($dept, $desig, $id, $name)
    {
        if ($id == '0') {
            $find_machines = DB::connection('sqlsrv2')->table('Devices')->where('CompanyID', '=', company_id())->get();
            //return request()->json(200, 'All');
        } else {
            $find_machines = DB::connection('sqlsrv2')->table('Devices')->where('Id', '=', $id)->where('CompanyID', '=', company_id())->get();
            //return request()->json(200, 'One');
        }

        foreach ($find_machines as $find_machines1) {
        }
        $ip = $find_machines1->DeviceIP;
        $zk = new ZKTeco($ip, 4370, null, '../storage/logs/laravel.log');
        $connect = $zk->connect();
        if ($connect == 1) {
            //$zk->removeUser(67);
            $getUser = $zk->getUser();
            $count = 1;
            $results = array();
            foreach ($getUser as $getUser1) {
                $get_req = DB::connection('sqlsrv2')->table("Emp_Profile")->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Emp_Register.EmployeeCode', '=', $getUser1['userid'])->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'Emp_Register.Status', 'Emp_Register.PostingCity', 'Emp_Register.EmployeeCode', 'Emp_Register.Designation', 'Emp_Register.Department')->get();

                $array = json_decode($get_req, true);
                $results = array_merge($results, $array);
                $count++;
            }
        } else {
            //continue;
        }
        return request()->json(200, $results);
    }

    public function pull_m_attendance($id)
    {
        $today_date_time = long_date();
        $find_machines1 = DB::connection('sqlsrv2')->table('Devices')->where('Id', '=', $id)->where('CompanyID', '=', company_id())->first();
        $zk = new ZKTeco($find_machines1->DeviceIP, 4370, null, '../storage/logs/laravel.log');
        $connect = $zk->connect();
        if ($connect == 1) {
            $device_attendance = $zk->getAttendance();

            $get_last_uid1 = DB::connection('sqlsrv2')->table('Machine_Attendance')->where('DeviceID', '=', $id)->orderBy('uid', 'desc')->where('CompanyID', '=', company_id())->first();
            $last_uid = $get_last_uid1->uid;

            foreach ($device_attendance as $device_attendance1) {
                if ($device_attendance1['uid'] > $last_uid) {
                    $attendanceData[] = [
                        'CompanyID' => company_id(),
                        'uid' => $device_attendance1['uid'],
                        'EmpCode' => $device_attendance1['id'],
                        'state' => $device_attendance1['state'],
                        'AttDate' => $device_attendance1['timestamp'],
                        'type' => $device_attendance1['type'],
                        'UploadedOn' => long_date(),
                        'DeviceID' => $id,
                    ];
                }
            }
            DB::connection('sqlsrv2')->table('Machine_Attendance')->insert($attendanceData);

            $result = DB::connection('sqlsrv2')->select("SET NOCOUNT ON; EXEC [dbo].[Insert_Into_Attdatas]; EXEC [dbo].[Add_PunchTime_Attdata]; EXEC [dbo].[AttendanceStatus]");

            if ($result) {
                //$clearAttendance = $zk->clearAttendance();
                $disconnect = $zk->disconnect();

                $data = 'attendance updated';
                return request()->json(200, $data);
            } else {
                $data = 'Attendance not updated';
                return request()->json(200, $data);
            }
        } else {
            return request()->json(200, 'Not connected');
        }
    }

    public function Salary_DistributionReport()
    {
        $detail = DB::connection('sqlsrv2')->select("EXEC  [dbo].[Salary_DistributionReport]");
        return request()->json(200, $detail);
    }

    public function Companywise_Salary()
    {
        $detail = DB::connection('sqlsrv2')->select("EXEC  [dbo].[Companywise_Salary]");
        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '!=', 1)->select('SessionName')->get();
        $C_name = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->select('CompanyName')->distinct()->get();
        $data[0] = $find_session;
        $data[1] = $C_name;
        $data[2] = $detail;
        return request()->json(200, $data);
    }

    public function AllowancesReport()
    {
        $detail = DB::connection('sqlsrv2')->select("EXEC  [dbo].[AllowancesReport]");
        return request()->json(200, $detail);
    }

    public function getLoan_C_Session()
    {
        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        // $session_name=date("m-Y", strtotime($find_session[0]->StartDate));

        $arr[0] = DB::connection('sqlsrv2')->table('LoanRequisition')->where('LoanSession', '=', $find_session[0]->SessionName)->sum("LoanAmount");
        $arr[1] = DB::connection('sqlsrv2')->table('LoanRequisition')->where('LoanType', '=', 'Loan')->where('LoanSession', '=', $find_session[0]->SessionName)->sum("LoanAmount");
        $arr[2] = DB::connection('sqlsrv2')->table('LoanRequisition')->where('LoanType', '=', 'Advance')->where('LoanSession', '=', $find_session[0]->SessionName)->sum("LoanAmount");

        $arr[3] = DB::connection('sqlsrv2')->table('LoanRequisition')->where('LoanType', '=', 'Advance')->where('LoanSession', '=', $find_session[0]->SessionName)->where('HrApproval', '=', 'App')->sum("LoanAmount");
        $arr[4] = DB::connection('sqlsrv2')->table('LoanRequisition')->where('LoanType', '=', 'Advance')->where('LoanSession', '=', $find_session[0]->SessionName)->where('HrApproval', '=', 'Pen')->sum("LoanAmount");
        $arr[5] = DB::connection('sqlsrv2')->table('LoanRequisition')->where('LoanType', '=', 'Advance')->where('LoanSession', '=', $find_session[0]->SessionName)->where('ManagerApproval', '=', 'Rej')->sum("LoanAmount");

        $arr[6] = DB::connection('sqlsrv2')->table('LoanRequisition')->where('LoanType', '=', 'Loan')->where('LoanSession', '=', $find_session[0]->SessionName)->where('HrApproval', '=', 'App')->sum("LoanAmount");
        $arr[7] = DB::connection('sqlsrv2')->table('LoanRequisition')->where('LoanType', '=', 'Loan')->where('LoanSession', '=', $find_session[0]->SessionName)->where('HrApproval', '=', 'Pen')->sum("LoanAmount");
        $arr[8] = DB::connection('sqlsrv2')->table('LoanRequisition')->where('LoanType', '=', 'Loan')->where('LoanSession', '=', $find_session[0]->SessionName)->where('ManagerApproval', '=', 'Rej')->sum("LoanAmount");
        return request()->json(200, $arr);
    }


    public function session_detail_dist()
    {
        $arr = DB::connection('sqlsrv2')->table("HrSessions")->where('CompanyID', '=', company_id())->orderBy('SessionID', 'desc')->select('SessionName')->get();
        return request()->json(200, $arr);
    }

    public function session_wise_cashdistribution($session, $location)
    {
        if ($location == 'All') {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')
                ->where('CompanyID', '=', company_id())->where('SessionName', '=', $session)->where('ReceivedThrough', '!=', null)->get();
            return request()->json(200, $emp_detail);
        } else {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')
                ->where('CompanyID', '=', company_id())->where('SessionName', '=', $session)->where('ReceivedThrough', 'like', '%' . $location . '%')->get();
            return request()->json(200, $emp_detail);
        }
    }

    public function session_wise_cashdistribution_count($session, $location)
    {

        if ($location == 'All') {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')
                ->where('CompanyID', '=', company_id())->where('SessionName', '=', $session)->where('ReceivedThrough', '!=', null)->sum("CashAmount");
            return request()->json(200, $emp_detail);
        } else {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')
                ->where('CompanyID', '=', company_id())->where('SessionName', '=', $session)->where('ReceivedThrough', 'like', '%' . $location . '%')->sum("CashAmount");
            return request()->json(200, $emp_detail);
        }
    }

    public function session_wise_bankdistribution_count($session, $location)
    {

        if ($location == 'All') {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')
                ->where('CompanyID', '=', company_id())->where('SessionName', '=', $session)->where('ReceivedThrough', '!=', null)->sum("BankAmount");
            return request()->json(200, $emp_detail);
        } else {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')
                ->where('CompanyID', '=', company_id())->where('SessionName', '=', $session)->where('ReceivedThrough', 'like', '%' . $location . '%')->sum("BankAmount");
            return request()->json(200, $emp_detail);
        }
    }

    public function cash_distribution_totalamount($date)
    {
        $emp_detail = DB::connection('sqlsrv2')->select("select CashAmount,BankAmount,CurrentCashPaid,CurrentBankPaid from Payroll_DistributionLogs
         where DATEADD(dd, 0, DATEDIFF(dd, 0, [ReceivedTime])) between '" . $date . "' and '" . $date . "'");
        return request()->json(200, $emp_detail);
    }

    public function cash_distributionlist_detail()
    {
        $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('ReceivedThrough', '!=', 'NULL')->where('MethodType', '=', 'Cash')->get();

        return request()->json(200, $emp_detail);
    }

    public function cash_distributionlist_detail_date()
    {

        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->get();
        foreach ($find_session_closed as $find_session1) {
        }
        $sesson_name = $find_session1->SessionName;
        $result = DB::connection('sqlsrv2')->table("Payroll_Distribution")->where('SessionName', '=', $sesson_name)->where('ReceivedThrough', '!=', 'NULL')->select('Payroll_Distribution.ReceivedTime')->groupBy('ReceivedTime')->orderBy('ReceivedTime', 'desc')->get();

        $arru = [];
        foreach ($result as $result1) {
            $resu = explode(" ", $result1->ReceivedTime);
            array_push($arru, $resu[0]);
        }
        return request()->json(200, $arru);
    }

    public function cash_distributionlist_detail1($date)
    {
        $emp_detail = DB::connection('sqlsrv2')->select("select * from Payroll_DistributionLogs
         where DATEADD(dd, 0, DATEDIFF(dd, 0, [ReceivedTime])) between '" . $date . "' and '" . $date . "'");

        return request()->json(200, $emp_detail);
    }

    public function employee_loan($id)
    {


        $update_date = date("Y-m-d");
        $result2 = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->exists();
        if ($result2) {
            $result = DB::connection('sqlsrv2')->table("LoanRequisition")->join('LoanDetail', 'LoanDetail.LoanId', '=', 'LoanRequisition.LoanId')->where("LoanDetail.CompanyID", '=', company_id())->where('LoanDetail.LoanId', '=', $id)->get();
            foreach ($result as $result1) {
            }
            //
            $pv_exist = DB::connection('sqlsrv2')->table("LoanRequisition")->where("CompanyID", '=', company_id())->where('PVID', '!=', null)->where('PVID', '!=', '')->where('LoanId', '=', $id)->exists();
            if ($pv_exist) {
                $pv_id = $result1->PVID;
            } else {
                $pv_id = '-';
            }
            //

            $check = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->exists();

            $this->fpdf->AddPage("P", ['250', '227']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {
            }
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 18);
            $this->fpdf->Text(95, 17, 'Loan Slip');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 170, 8, 43, 12);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->ln(20);

            $get_req = DB::connection('sqlsrv2')->table("Emp_Profile")->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Emp_Profile.EmployeeID', '=', $result1->EmployeeID)->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode', 'Emp_Register.Designation', 'Emp_Register.Department')->get();
            foreach ($get_req as $get_req1) {
            }

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(35, 6, 'Employee Code:', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(100, 6, $get_req1->EmployeeCode, 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(35, 6, 'Print Date:', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, $update_date, 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(35, 6, 'Employee Name:', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(100, 6, $get_req1->Name, 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(35, 6, 'Application Date:', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(30, 6, $result1->ApplyDate, 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(35, 6, 'Department:', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(100, 6, $get_req1->Department, 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(35, 6, 'Received By:', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(100, 6, $result1->ReceivedBy, 0, 1, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(35, 6, 'Designation:', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(100, 6, $get_req1->Designation, 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(35, 6, 'Voucher Number:', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(100, 6, $pv_id, 0, 1, 'L', 0);


            //Loan requisition
            $this->fpdf->ln(5);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(49, 6, '', 1, 0, 'C', 0);
            $this->fpdf->Cell(49, 6, 'Total', 1, 0, 'C', 0);
            $this->fpdf->Cell(49, 6, 'Paid', 1, 0, 'C', 0);
            $this->fpdf->Cell(49, 6, 'Remaining', 1, 1, 'C', 0);
            //
            $ret_amount = DB::connection('sqlsrv2')->table("LoanDetail")->where("InstallmentStatus", '=', 'Returned')->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->sum('InstallmentAmount');
            $ret_ins = DB::connection('sqlsrv2')->table("LoanDetail")->where("InstallmentStatus", '=', 'Returned')->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->count('InstallmentAmount');

            $rem_amount = DB::connection('sqlsrv2')->table("LoanDetail")->where("InstallmentStatus", '=', 'Unpaid')->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->sum('InstallmentAmount');
            $rem_ins = DB::connection('sqlsrv2')->table("LoanDetail")->where("InstallmentStatus", '=', 'Unpaid')->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->count('InstallmentAmount');

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(49, 6, 'Amount', 1, 0, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(49, 6, number_format($result1->LoanAmount), 1, 0, 'C', 0);
            $this->fpdf->Cell(49, 6, number_format($ret_amount), 1, 0, 'C', 0);
            $this->fpdf->Cell(49, 6, number_format($rem_amount), 1, 1, 'C', 0);
            //
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(49, 6, 'Installments', 1, 0, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(49, 6, number_format($result1->LoanInstallments), 1, 0, 'C', 0);
            $this->fpdf->Cell(49, 6, number_format($ret_ins), 1, 0, 'C', 0);
            $this->fpdf->Cell(49, 6, number_format($rem_ins), 1, 1, 'C', 0);
            //
            $this->fpdf->SetFont('Times', '', 12);
            $dot = '';

            //Loan detail
            $this->fpdf->ln(5);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(195, 6, 'Installments detail', 0, 1, 'C', 0);

            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->SetTextColor(250, 248, 248);
            $this->fpdf->Cell(40, 6, 'Installment No', 1, 0, 'C', 1);
            $this->fpdf->Cell(75, 6, 'Month', 1, 0, 'C', 1);
            $this->fpdf->Cell(50, 6, 'Amount', 1, 0, 'C', 1);
            $this->fpdf->Cell(30, 6, 'Status', 1, 1, 'C', 1);

            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->SetFont('Times', '', 10);
            foreach ($result as $index => $result1) {
                $this->fpdf->Cell(40, 6, $result1->InstallmentNo == 0 ? $index + 1 : $result1->InstallmentNo, 1, 0, 'C', 0);

                $this->fpdf->Cell(75, 6, $result1->InstallmentSession, 1, 0, 'C', 0);
                $this->fpdf->Cell(50, 6, number_format($result1->InstallmentAmount), 1, 0, 'C', 0);
                $this->fpdf->Cell(30, 6, $result1->InstallmentStatus, 1, 1, 'C', 0);
            }
            if (strlen($result1->LoanReason) >= 95) {
                $dot = '...';
            }

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(20, 6, 'Reason: ', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(175, 6, substr($result1->LoanReason, 0, 95) . $dot, 0, 0, 'L', 0);

            $this->fpdf->ln(10);

            $fetch_user_detail = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', username())->get();
            foreach ($fetch_user_detail as $fetch_user_detail1) {
            }

            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(30, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(85, 6, $fetch_user_detail1->first_name . ' ' . $fetch_user_detail1->last_name, 0, 0, 'L', 0);

            $this->fpdf->Output();
            exit;
        }
    }

    public function fetch_distribution_bank_payabale()
    {

        $if_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->orderby('SessionID', 'asc')->exists();
        if ($if_session_closed) {
            $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->orderby('SessionID', 'asc')->get();

            foreach ($find_session_closed as $find_session1) {
            }
            $sesson_name = $find_session1->SessionName;

            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'Payroll_Distribution.EmployeeID')->where('Payroll_Distribution.CompanyID', '=', company_id())->where('Payroll_Distribution.BankAmount', '!=', 0)->where('Payroll_Distribution.SessionName', '=', $sesson_name)->get();

            return request()->json(200, $emp_detail);
        }
    }

    public function employee_loan1($id)
    {

        $result = DB::connection('sqlsrv2')->table("LoanRequisition")->join('LoanDetail', 'LoanDetail.LoanId', '=', 'LoanRequisition.LoanId')->where("LoanDetail.CompanyID", '=', company_id())->where('LoanDetail.LoanId', '=', $id)->where('LoanRequisition.LoanType', '=', 'Advance')->select('LoanRequisition.*', 'LoanDetail.InstallmentAmount')->get();
        $check = DB::connection('sqlsrv2')->table("LoanRequisition")->join('LoanDetail', 'LoanDetail.LoanId', '=', 'LoanRequisition.LoanId')->where("LoanDetail.CompanyID", '=', company_id())->where('LoanDetail.LoanId', '=', $id)->where('LoanRequisition.LoanType', '=', 'Advance')->exists();
        if ($check) {


            foreach ($result as $result1) {
            }
            $get_req = DB::connection('sqlsrv2')->table("Emp_Profile")->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Emp_Profile.EmployeeID', '=', $result1->EmployeeID)->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode', 'Emp_Register.CompanyName', 'Emp_Register.Department')->get();
            foreach ($get_req as $get_req1) {
            }
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
            $this->fpdf->Cell(70, 12, 'EMPLOYEE ADVANCE LOAN', 0, 1, 'C', 1);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(40, 6, $get_req1->Name, 0, 0, 'L', 0);
            $this->fpdf->Cell(150, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Payment Voucher', 0, 1, 'R', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(40, 6, $get_req1->CompanyName, 0, 0, 'L', 0);
            $this->fpdf->Cell(155, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Voucher No: ' . $result1->PVID, 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, '2112137832', 0, 0, 'L', 0);
            $this->fpdf->Cell(155, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Payment Date: ' . explode(" ", $result1->ReceivedDate)[0], 0, 1, 'R', 0);
            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(220, 6, 'Description', 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 6, 'Total', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(220, 15, ('Loan for ' . $result1->LoanReason . ' use of Amount ' . number_format($result1->LoanAmount) . ' for Total ' . $result1->LoanInstallments . ' installments & ' . number_format($result1->InstallmentAmount) . ' monthly installment'), 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 15, number_format($result1->LoanAmount), 1, 1, 'C', 0);
            $this->fpdf->Cell(220, 6, 'Total Amount:', 0, 0, 'R', 0);
            $this->fpdf->Cell(40, 6, number_format($result1->LoanAmount), 0, 1, 'C', 0);
            $this->fpdf->Output();
            exit;
        }
    }

    public function search_payroll_distributiondept(Request $request)
    {
        // $dept=$request->get('keyword1');

        $arr = DB::table('tb_department')->where('company_id', '=', company_id())->where('department_name', 'like', '%' . $request->keyword1 . '%')->get();
        return request()->json(200, $arr);
    }

    public function getEmployeedetail()
    {


        // $emp_detail =DB::connection('sqlsrv2')->select('Emp_Profile.*')->table('Emp_Profile')->join('Emp_Register','Emp_Profile.EmployeeID','Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID','=', company_id())->paginate(5);
        $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('Emp_Profile.EmployeeID', 'desc')
            ->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Profile.CompanyID', '=', company_id())
            ->paginate(15);
        return request()->json(200, $emp_detail);
    }


    public function test_pull()
    {
        $machines = \Illuminate\Support\Facades\DB::connection('sqlsrv2')->table('Devices')->where('Is_Sync', '=', 1)->where('CompanyID', '=', company_id())->get();
        $machineIDs = $machines->pluck('Id')->toArray();
        //        dd($machineIDs);

        $lastUIDs = \Illuminate\Support\Facades\DB::connection('sqlsrv2')
            ->table('Machine_Attendance')
            ->whereIn('DeviceID', $machineIDs)
            ->where('CompanyID', company_id())
            ->orderBy('ID', 'asc')
            ->pluck('uid', 'DeviceID')
            ->toArray();
        //dd($lastUIDs);

        $insertData = [];
        foreach ($machines as $machines1) {
            //            dd($machines1->Id);
            $zk = new ZKTeco($machines1->DeviceIP, 4370, null, '../storage/logs/error.log');
            $connect = $zk->connect();
            //            dd($connect, $machines1->Id);
            if ($connect == 1) {
                $device_attendance = $zk->getAttendance();
                $lastUID = $lastUIDs[$machines1->Id] ?? 0;
                //                dd($lastUID);
                //                dd($device_attendance);
                foreach ($device_attendance as $device_attendance1) {
                    if ($device_attendance1['uid'] > $lastUID) {
                        $insertData[] = [
                            'CompanyID' => company_id(),
                            'uid' => $device_attendance1['uid'],
                            'EmpCode' => $device_attendance1['id'],
                            'state' => $device_attendance1['state'],
                            'AttDate' => $device_attendance1['timestamp'],
                            'type' => $device_attendance1['type'],
                            'UploadedOn' => long_date(),
                            'DeviceID' => $machines1->Id,
                        ];
                    }
                }
                //                dd($insertData);
                insertLog('Attendance fetched', count($insertData) . ' Attendance records fetched from machine "' . $machines1->DeviceName . '" automaticaly');
            } else {
                continue;
            }
        }
        if (!empty($insertData)) {

            //dd('confirm insertion');
            DB::connection('sqlsrv2')->table('Machine_Attendance')->insert($insertData);
            DB::connection('sqlsrv2')->select("SET NOCOUNT ON; EXEC [dbo].[Insert_Into_Attdatas]; EXEC [dbo].[Add_PunchTime_Attdata]; EXEC [dbo].[AttendanceStatus]");
        }
    }


    public function create_employee(Request $request)
    {
        $full_name = $request->get('full_name');
        $father_name = $request->get('father_name');
        $gender = $request->get('gender');
        $blood_group = $request->get('blood_group');
        $email = $request->get('email');
        $SelectedCountry = $request->get('Country');
        $cnic = $request->get('cnic');
        $phone_number = $request->get('phone_number');
        $phone_number2 = $request->get('phone_number2');
        $dob = $request->get('dob');

        $religion = $request->get('religion');
        $address = $request->get('address');
        $city = $request->get('city');
        $cnic_expiry = $request->get('cnic_expiry');
        $relation = $request->get('relation');
        $m_status = $request->get('m_status');

        $update_month = date("m");
        $update_day = date("d");

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $name_image = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('/images/profile_images/'), $name_image);
        } else {
            $name_image = null;
        }
        // dd($SelectedCountry);

        $lastEmployee = DB::connection('sqlsrv2')->table("Emp_Register")->where('CompanyID', '=', company_id())->orderBy('EmployeeID', 'desc')->first();
        $lastEmpCode = explode("-", $lastEmployee->EmployeeCode);
        $employeeCode = company_prefix()->company_prefix . '-0' . $lastEmpCode[1] + 1;

        $emp_id = DB::connection('sqlsrv2')->table('Emp_Profile')->insertGetId([
            'Name' => $full_name,
            'FatherHusband' => $father_name,
            'Gender' => $gender,
            'Religion' => $religion,
            'Email' => $email,
            'Mobile' => $phone_number,
            'Phone' => $phone_number2,
            'CNIC' => $cnic,
            'CnicExpiry' => $cnic_expiry,
            'MaritalStatus' => $m_status,
            'DOB' => $dob,
            'BloodGroup' => $blood_group,
            'Address' => $address,
            'Country' => $SelectedCountry,
            'City' => $city,
            'Photo' => $name_image,
            'CreatedBy' => username(),
            'CompanyID' => company_id(),
            'Relation' => $relation,
            'Employee_Code' => $employeeCode,
        ]);
        //
        $hr_conf = DB::connection('sqlsrv2')->table("HrCompanyConfig")->where('CompanyID', '=', company_id())->first();
        if ($hr_conf) {
            $total_sick = $hr_conf->SickLeaves;
            $given_sick = ceil(($total_sick / 12) * (12 - ($update_month + (floor($update_day / 15)) - 1)));

            $total_casual = $hr_conf->CasualLeaves;
            $given_casual = ceil(($total_casual / 12) * (12 - ($update_month + (floor($update_day / 15)) - 1)));

            $values = [
                [
                    'EmployeeID' => $emp_id,
                    'LeaveType' => 'Sick',
                    'TotalLeave' => $given_sick,
                    'RemainingLeave' => $given_sick,
                    'CreatedBy' => username(),
                    'CreatedOn' => long_date(),
                    'CompanyID' => company_id()
                ],
                [
                    'EmployeeID' => $emp_id,
                    'LeaveType' => 'Casual',
                    'TotalLeave' => $given_casual,
                    'RemainingLeave' => $given_casual,
                    'CreatedBy' => username(),
                    'CreatedOn' => long_date(),
                    'CompanyID' => company_id()
                ],
            ];
            DB::connection('sqlsrv2')->table('EmpLeave')->insert($values);
        }

        DB::connection('sqlsrv2')->table('Emp_Register')->insert([
            'EmployeeID' => $emp_id,
            'EmployeeCode' => $employeeCode,
            'CompanyID' => company_id(),
            'MethodType' => 'Cash',
        ]);
        DB::connection('sqlsrv2')->table('Emp_Documents')->insert([
            'EmployeeID' => $emp_id,
            'CompanyID' => company_id(),
            'Image1' => '',
            'Image2' => '',
            'Image3' => '',
            'Image4' => '',
            'Image5' => '',
            'Image6' => ''
        ]);

        DB::connection('sqlsrv2')->table('PayrollEmployeesDetail')->insert([
            'CompanyID' => company_id(),
            'EmployeeID' => $emp_id,
            'Statusd' => 'C'
        ]);

        DB::connection('sqlsrv2')->table('AttData')->insert([
            'CompanyID' => company_id(),
            'EmpID' => $emp_id,
            'EmpCode' => $employeeCode,
            'ATTDate' => short_date(),
            'Overtime' => 0,
            'GracePeriod' => 0,
        ]);
        insertLog('Insert New Employee', 'Add New Employee Profile of ' . $full_name);

        $message = "Employee added";
        return request()->json(200, $message);
    }

    public function getemployment_att_detail($id)
    {
        $company_id = Session::get('company_id');
        if ($id == 0) {
            $id = Session::get('employee_id');
        }
        $arr = DB::connection('sqlsrv2')->table('Att_Permission')->join('Emp_Register', 'Att_Permission.SubEmpID', '=', 'Emp_Register.EmployeeID')->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->orderBy('Emp_Profile.Name', 'asc')->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode')->where('Att_Permission.CompanyID', '=', $company_id)->where('Att_Permission.ChiefEmpID', '=', $id)->where('Att_Permission.IsMandatory', '=', 1)->get();
        return request()->json(200, $arr);
    }

    public function update_employment(Request $request)
    {
        $emp_att_machine = $request->emp_att_machine;
        $selected = $request->get('selected');
        $id = $request->get('id');
        $doj = $request->get('doj');
        $login_check = $request->get('login_check');
        $reporting_to = $request->get('reporting_to');
        $second_reporting = $request->get('second_reporting');
        $emp_currency = $request->get('emp_currency');
        $job_shift = $request->get('job_shift');
        $work_location = $request->get('work_location');
        $emp_salary = $request->get('emp_salary');
        $emp_stipend = $request->get('emp_stipend');
        $emp_status = $request->get('emp_status');
        $emp_job_status = $request->get('emp_job_status');
        $emp_pro_days = $request->get('emp_pro_days');
        $emp_pro_end = date('Y-m-d', strtotime($doj . " + {$emp_pro_days} days"));
        $job_description = $request->get('job_description');
        $remarks = $request->get('remarks');
        $child_company = $request->get('child_company');
        $emp_department = $request->get('emp_department');
        $emp_designation = $request->get('emp_designation');
        $hr_notifications = $request->get('hr_notifications');
        $user_email = $request->get('user_email');
        $user_password = $request->get('user_password');
        $emp_code = $request->get('emp_code');
        $company_email_id = $request->get('company_email_id');
        $att_check = $request->get('att_check');
        $methodtype = $request->get('methodtype');
        $bankaccount = $request->get('bankaccount');
        $bankname = $request->get('bankname');
        $accountname = $request->get('accountname');

        if (empty($child_company)) {
            $message = 'Child Company';
            return request()->json(200, $message);
        }
        if ($login_check == 1) {
            $check_user1 = DB::table('tb_users')->where('company_id', '=', company_id())->where('email', '=', $user_email)->exists();
            if ($check_user1) {
                $message = 'Email Id Already Exists';
                return request()->json(200, $message);
            } else {
                if ($user_email == '' || $user_password == '') {
                    $message = 'empty_username';
                    return request()->json(200, $message);
                } else if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                    $message = 'invalid email id';
                    return request()->json(200, $message);
                }
            }
        }
        if ($att_check == 1) {
            if ($selected == '' || $selected == null) {
                $message = 'Please Select Employees Attendace List';
                return request()->json(200, $message);
            }
        }

        $shift = null;
        if ($job_shift != null && $job_shift != '') {
            $check_shift1 = DB::connection('sqlsrv2')->table('Roasters')->select('RosterID')->where('CompanyID', '=', company_id())->where('RosterName', '=', $job_shift)->first();
            $shift = $check_shift1->RosterID;
        }

        DB::connection('sqlsrv2')->update('update  Emp_Register set  Department=?, Designation=?, PostingCity=?, CompanyEmail=?, JoiningDate=?, Status=?, ReportingTo=?, CreatedBy=?, ReportingTo2=?, JobShift=?, Salary=?,Salary_Currency=?,  Stipend=?, JobStatus=?, ProbationEnd=?, AttendanceMachine=?, JobDescription=?, CompanyName=?, SendNotification=?, AllowEmployeesAttendance=?, EportalAccess=?, MethodType=?, BankAccount=?, bank_name=?, account_name=?, remarks=? where EmployeeID=?', [$emp_department, $emp_designation, $work_location, $company_email_id, $doj, $emp_status, $reporting_to, username(), $second_reporting, $shift, $emp_salary, $emp_currency, $emp_stipend, $emp_job_status, $emp_pro_end, $emp_att_machine, $job_description, $child_company, $hr_notifications, $att_check, $login_check, $methodtype, $bankaccount, $bankname, $accountname, $remarks, $id]);

        $isInMachine = DB::connection('sqlsrv2')->table('MachineUsers')->where('EmployeeCode', '=', $emp_code)->where('MachineId', '=', $emp_att_machine)->where('CompanyID', '=', company_id())->exists();
        if (!$isInMachine) {
            $Employee = DB::connection('sqlsrv2')->table('Emp_Profile')->where('Employee_Code', '=', $emp_code)->select('Name')->first();
            //dd($name);
            DB::connection('sqlsrv2')->table('MachineUsers')->insert([
                'CompanyID' => company_id(),
                'EmployeeCode' => $emp_code,
                'EmployeeName' => $Employee->Name,
                'MachineId' => $emp_att_machine,
                'IsAdded' => 0,
            ]);
        }

        //        dd($isInMachine);

        $update_date3 = date("Y-m-d");
        $emp_day = intval($emp_salary / 30);
        $emp_hour = intval($emp_day / 8);

        DB::connection('sqlsrv2')->update('update PayrollEmployeesDetail set UpdatedSalary=?,UpdatedPerDay=?,UpdatedPerHours=?,UpdatedDate=? where Statusd=? and CompanyID=? AND EmployeeID=?', [$emp_salary, $emp_day, $emp_hour, $update_date3, 'C', company_id(), $id]);
        $check_grace = DB::connection('sqlsrv2')->table('EmpGraceHours')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->exists();
        if (!$check_grace) {
            DB::connection('sqlsrv2')->insert("INSERT INTO EmpGraceHours(CompanyID,EmployeeID,TotalGP,UsedGP) values (?,?,?,?)", [company_id(), $id, 0, 0]);
        }

        DB::insert("INSERT INTO Activity_Log(CompanyId,UserEmail,EmployeeName,EventStatus,Description,ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Employment Detail', 'Update Employment Detail of Employee Id: ' . $emp_code, long_date()]);

        if ($login_check == 1) {
            $check_user = DB::table('tb_users')->where('company_id', '=', company_id())->where('emp_code', '=', $emp_code)->exists();
            if ($check_user) {
                $result = DB::update('update tb_users set user_password=?,email=? where emp_code=? and company_id=?', [$user_password, $user_email, $emp_code, company_id()]);
            } else {
                $emp_detail1 = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Profile.EmployeeID', '=', $id)->where('Emp_Profile.CompanyID', '=', company_id())->first();

                $name = explode(" ", $emp_detail1->Name);
                $em_code = $emp_detail1->EmployeeCode;
                $ofc_loc = $emp_detail1->PostingCity;
                $gen = $emp_detail1->Gender;
                $add = $emp_detail1->Address;
                $us_des = $emp_detail1->Designation;
                $sta = 'Active';
                $us_dept = $emp_detail1->Department;
                DB::insert("INSERT INTO tb_users(first_name,last_name,emp_code,user_password,ofc_location,gender,user_address,created_by,created_time,email,user_role,company_id,u_status,department) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$name[0], $name[1], $em_code, $user_password, $ofc_loc, $gen, $add, username(), long_date(), $user_email, $us_des, company_id(), $sta, $us_dept]);
            }
        }
        if ($att_check == 1) {
            for ($x = 0; $x < count($selected); $x++) {
                $se = explode("_", $selected[$x]);
                //
                $find_employee_id1 = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeCode', '=', $se[1])->first();
                $sub_emp_id = $find_employee_id1->EmployeeID;
                $check_att_permission = DB::connection('sqlsrv2')->table('Att_Permission')->where('CompanyID', '=', company_id())->where('SubEmpID', '=', $sub_emp_id)->where('ChiefEmpID', '=', $id)->where('IsMandatory', '=', 1)->exists();
                if (!$check_att_permission) {
                    DB::connection('sqlsrv2')->insert("INSERT INTO Att_Permission(SubEmpID,ChiefEmpID,IsMandatory,CreatedBy,CompanyID) values (?,?,?,?,?)", [$sub_emp_id, $id, 1, username(), company_id()]);
                }
            }
        }
        if ($reporting_to != '') {
            $check_att_rep = DB::connection('sqlsrv2')->table('Att_Permission')->where('CompanyID', '=', company_id())->where('SubEmpID', '=', $id)->where('ChiefEmpID', '=', $reporting_to)->where('IsManager', '=', 1)->exists();
            if ($check_att_rep) {
                DB::connection('sqlsrv2')->update('update Att_Permission set ChiefEmpID=? where SubEmpID=? and CompanyID=? and IsManager=?', [$reporting_to, $id, company_id(), 1]);
            } else {
                DB::connection('sqlsrv2')->insert("INSERT INTO Att_Permission(SubEmpID,ChiefEmpID,IsManager,CreatedBy,CompanyID) values (?,?,?,?,?)", [$id, $reporting_to, 1, username(), company_id()]);
            }
        }
        $message = "Update Employee Record Successfully";
        return request()->json(200, $message);
    }


    public function department_detail()
    {

        $arr = DB::table('tb_department')->where('company_id', '=', company_id())->get();
        return request()->json(200, $arr);
    }

    public function fetch_warningdetail($subject)
    {
        $arr = DB::connection('sqlsrv2')->table('Warning_Reason')->select('ReasonContent')->where('ReasonName', '=', $subject)->first();
        return request()->json(200, $arr);
    }

    public function update_warning(Request $request)
    {
        $id = $request->get('warnReasonID');
        $warnReasonDesc = $request->get('warnReasonDesc');

        $result = DB::connection('sqlsrv2')->update('update  Warning_Reason set ReasonContent=? where ReasonID=?', [$warnReasonDesc, $id]);
        if ($result) {
            $data = "Warning Updated";
        } else {
            $data = "Warning Not Updated";
        }
        return request()->json(200, $data);
    }

    public function skip_education(Request $request)
    {
        $id = $request->get('id');
        $skip = "skip";
        DB::connection('sqlsrv2')->table('Employee_Qualification')->where('EmployeeID', $id)->delete();
        $result = DB::connection('sqlsrv2')->update('update  Emp_Register set EduStatus=? where EmployeeID=?', [$skip, $id]);


        $update_date = long_date();


        $arr = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->get();
        foreach ($arr as $arr1) {
        }
        $emp_code = $arr1->EmployeeCode;

        DB::insert("INSERT INTO Activity_Log(CompanyId,UserEmail,EmployeeName,EventStatus,Description,ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Education Detail', 'Skip Education Detail of Employee Code: ' . $emp_code, $update_date]);
        $message = "Skip the Education Step Successfully";
        return request()->json(200, $message);
    }

    public function insert_education(Request $request)
    {


        $degree_type = $request->get('first');
        $degree_name = $request->get('second');
        $inst_name = $request->get('third');
        $passing_year = $request->get('fourth');
        $id = $request->get('id');

        DB::connection('sqlsrv2')->table('Employee_Qualification')->where('EmployeeID', $id)->delete();
        $de_type1 = explode(",", $degree_type);
        for ($x = 1; $x < count($de_type1); $x++) {
            $de_type = explode(",", $degree_type);
            $de_name = explode(",", $degree_name);
            $ins_name = explode(",", $inst_name);
            $pas_year = explode(",", $passing_year);

            DB::connection('sqlsrv2')->insert("insert into Employee_Qualification(EmployeeID,DegreeType,DegreeName,InstituteName
            ,PassingYear,CreatedBy,CompanyID) values (?,?,?,?,?,?,?)", [$id, $de_type[$x], $de_name[$x], $ins_name[$x], $pas_year[$x], username(), company_id()]);
        }
        $skip = 'Added';
        $result = DB::connection('sqlsrv2')->update('update  Emp_Register set EduStatus=? where EmployeeID=?', [$skip, $id]);


        $update_date = long_date();


        $arr = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->get();
        foreach ($arr as $arr1) {
        }
        $emp_code = $arr1->EmployeeCode;

        DB::insert("INSERT INTO Activity_Log(CompanyId,UserEmail,EmployeeName,EventStatus,Description,ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Education Detail', 'Added Education Detail of Employee Code: ' . $emp_code, $update_date]);
        $message = 'Successfully Added';
        return request()->json(200, $message);
    }

    public function skip_experience(Request $request)
    {
        $id = $request->get('id');
        $skip = "skip";
        DB::connection('sqlsrv2')->table('Emp_Work_Experience')->where('EmployeeID', $id)->delete();
        $result = DB::connection('sqlsrv2')->update('update  Emp_Register set ExpStatus=? where EmployeeID=?', [$skip, $id]);


        $update_date = long_date();


        $arr = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->get();
        foreach ($arr as $arr1) {
        }
        $emp_code = $arr1->EmployeeCode;

        DB::insert("INSERT INTO Activity_Log(CompanyId,UserEmail,EmployeeName,EventStatus,Description,ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Experience Detail', 'Skipped Experience Detail of Employee Code: ' . $emp_code, $update_date]);
        $message = "Skip the Education Step Successfully";
        return request()->json(200, $message);
    }

    public function insert_experience(Request $request)
    {


        $position = $request->get('first');
        $company_name = $request->get('second');
        $starting_date = $request->get('third');
        $ending_date = $request->get('fourth');
        $reference = $request->get('fiveth');

        $id = $request->get('id');

        DB::connection('sqlsrv2')->table('Emp_Work_Experience')->where('EmployeeID', $id)->delete();
        $de_type1 = explode(",", $position);
        for ($x = 1; $x < count($de_type1); $x++) {
            $p_position = explode(",", $position);
            $p_company_name = explode(",", $company_name);
            $p_starting_date = explode(",", $starting_date);
            $p_ending_date = explode(",", $ending_date);
            $p_reference = explode(",", $reference);
            DB::connection('sqlsrv2')->insert("insert into Emp_Work_Experience(EmployeeID,CompanyID,JobTitle,CompanyName,StartingDate,LeavingDate,Refrence,CreatedBy) values (?,?,?,?,?,?,?,?)", [$id, company_id(), $p_position[$x], $p_company_name[$x], $p_starting_date[$x], $p_ending_date[$x], $p_reference[$x], username()]);
        }
        $skip = 'Added';
        $result = DB::connection('sqlsrv2')->update('update  Emp_Register set ExpStatus=? where EmployeeID=?', [$skip, $id]);


        $update_date = long_date();


        $arr = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->get();
        foreach ($arr as $arr1) {
        }
        $emp_code = $arr1->EmployeeCode;

        DB::insert("INSERT INTO Activity_Log(CompanyId,UserEmail,EmployeeName,EventStatus,Description,ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Experience Detail', 'Added Experience Detail of Employee Code: ' . $emp_code, $update_date]);
        $message = 'Successfully Added';
        return request()->json(200, $message);
    }

    public function geteducation_detail($id)
    {
        $arr = DB::connection('sqlsrv2')->table('Employee_Qualification')->where('EmployeeID', '=', $id)->get();
        return request()->json(200, $arr);
    }

    public function getemployee_detail123($id)
    {
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->where('EmployeeID', '=', $id)->get();
        return request()->json(200, $arr);
    }

    public function getemployment_detail($id)
    {
        $employeeDetail = DB::connection('sqlsrv2')->table('Emp_Register')->join('Roasters', 'Emp_Register.JobShift', 'Roasters.RosterID')->where('EmployeeID', '=', $id)->where('Emp_Register.CompanyID', '=', company_id());
        $employeeDetail1 = clone $employeeDetail;
        $employeeDetail2 = clone $employeeDetail;

        if ($employeeDetail1->exists()) {
            $arr = $employeeDetail2->select('Emp_Register.*', 'Roasters.RosterName')->get();
        } else {
            $arr = DB::connection('sqlsrv2')->table('Emp_Register')->where('EmployeeID', '=', $id)->where('Emp_Register.CompanyID', '=', company_id())->get();
        }

        return request()->json(200, $arr);
    }

    public function DepartmentWise_EmpStatus()
    {
        $all_users = DB::connection('sqlsrv2')->select("SELECT
      Department,
      ISNULL(SUM(CASE WHEN Status = 'Registered' THEN 1 ELSE 0 END), 0) AS RegisteredCount,
      ISNULL(SUM(CASE WHEN Status = 'Resigned' THEN 1 ELSE 0 END), 0) AS ResignedCount,
      ISNULL(SUM(CASE WHEN Status = 'Terminated' THEN 1 ELSE 0 END), 0) AS TerminatedCount,
      ISNULL(SUM(CASE WHEN Status = 'Suspended' THEN 1 ELSE 0 END), 0) AS TerminatedCount,
      ISNULL(SUM(CASE WHEN Status = 'Probation' THEN 1 ELSE 0 END), 0) AS ProbationCount,
      ISNULL(SUM(CASE WHEN Status = 'Contract' THEN 1 ELSE 0 END), 0) AS ContractsCount,
      ISNULL(COUNT(EmployeeID), 0) AS TotalEmp
  FROM
      Emp_Register
  GROUP BY
      Department;");

        return request()->json(200, $all_users);
    }

    public function update_employee(Request $request)
    {
        $full_name = $request->get('full_name');
        $father_name = $request->get('father_name');
        $gender = $request->get('gender');
        $blood_group = $request->get('blood_group');
        $email = $request->get('email');
        $id = $request->get('id');
        $cnic = $request->get('cnic');
        $phone_number = $request->get('phone_number');
        $phone_number2 = $request->get('phone_number2');
        $dob = $request->get('dob');
        $SelectedCountry = $request->get('Country');
        $religion = $request->get('religion');
        $address = $request->get('address');
        $city = $request->get('city');
        $cnic_expiry = $request->get('cnic_expiry');
        $relation = $request->get('relation');
        $m_status = $request->get('m_status');

        $update_date = long_date();

        $arr9 = DB::connection('sqlsrv2')->table('Emp_Profile')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->get();
        foreach ($arr9 as $arr91) {
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $name_image = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/images/profile_images/', $name_image);
            DB::connection('sqlsrv2')->update('
            UPDATE Emp_Profile
            SET Name = ?, FatherHusband = ?, Gender = ?, Religion = ?, Email = ?, Mobile = ?, Phone = ?, CNIC = ?, CnicExpiry = ?, MaritalStatus = ?, DOB = ?, BloodGroup = ?, Address = ?, Country = ?, City = ?, Photo = ?, UpdatedBy = ?, UpdatedOn = ?, Relation = ?
            WHERE EmployeeID = ?
        ', [
                $full_name,
                $father_name,
                $gender,
                $religion,
                $email,
                $phone_number,
                $phone_number2,
                $cnic,
                $cnic_expiry,
                $m_status,
                $dob,
                $blood_group,
                $address,
                $SelectedCountry,
                $city,
                $name_image,
                username(),
                $update_date,
                $relation,
                $id
            ]);

            // DB::connection('sqlsrv2')->update('update  Emp_Profile set Name=?,FatherHusband=?,Gender=?,Religion=?
            // ,Email=?,Mobile=?,Phone=?,CNIC=?,CnicExpiry=?,MaritalStatus=?,DOB=?,BloodGroup=?,Address=?,Country=?,City=?,Photo=?,UpdatedBy=?,UpdatedOn=?,Relation=? where EmployeeID=?',[$full_name,$father_name,$gender,$religion,$email,$phone_number,$phone_number2,$cnic,$cnic_expiry,$m_status,$dob,$blood_group,$address, $SelectedCountry,$city,$name_image,username(),$update_date,$relation,$id]);

        } else {
            DB::connection('sqlsrv2')->update('
    UPDATE Emp_Profile
    SET Name = ?, FatherHusband = ?, Gender = ?, Religion = ?, Email = ?, Mobile = ?, Phone = ?, CNIC = ?, CnicExpiry = ?, MaritalStatus = ?, DOB = ?, BloodGroup = ?, Address = ?, Country = ?, City = ?,  UpdatedBy = ?, UpdatedOn = ?, Relation = ?
    WHERE EmployeeID = ?
', [
                $full_name,
                $father_name,
                $gender,
                $religion,
                $email,
                $phone_number,
                $phone_number2,
                $cnic,
                $cnic_expiry,
                $m_status,
                $dob,
                $blood_group,
                $address,
                $SelectedCountry,
                $city,
                username(),
                $update_date,
                $relation,
                $id
            ]);

            // DB::connection('sqlsrv2')->update('update  Emp_Profile set Name=?,FatherHusband=?,Gender=?,Religion=?
            // ,Email=?,Mobile=?,Phone=?,CNIC=?,CnicExpiry=?,MaritalStatus=?,DOB=?,BloodGroup=?,Address=?,Country=?,City=?,UpdatedBy=?,UpdatedOn=?,Relation=? where EmployeeID=?',[$full_name,$father_name,$gender,$religion,$email,$phone_number,$phone_number2,$cnic,$cnic_expiry,$m_status,$dob,$blood_group,$address,$SelectedCountry,$city,username(),$update_date,$relation,$id]);
        }


        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Employee Updated', 'Profile details of ' . $full_name . ' updated', $update_date]);

        return request()->json(200, 'hello');
    }

    public function TotalFuelAmount()
    {


        $arr[0] = DB::connection('sqlsrv2')->table('FuelBill')->where('CompanyID', '=', company_id())->sum("FuelQuantity");
        return request()->json(200, $arr);
    }

    public function registered($id)
    {

        $result5 = DB::connection('sqlsrv2')->update('update Emp_Register set Status=?,RegDate=? where EmployeeID =?', ["Registered", '', $id]);

        if ($result5) {
            DB::connection('sqlsrv2')->table('FinalSettlement')->where('CompanyID', '=', company_id())->where('EmployeeID', $id)->where('Status', '!=', 'Approved')->delete();
            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())
                ->where('Emp_Profile.EmployeeID', '=', $id)->get();
            return request()->json(200, $emp_detail);
        }
    }

    public function resigned_emp($id, $resign_date)
    {
        $update_date = date("Y-m-d");
        $result5 = DB::connection('sqlsrv2')->update('update Emp_Register set Status=?, ResignDate=? where EmployeeID =?', ["Resigned", $resign_date, $id]);

        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session_closed as $find_session1) {
        }
        $sesson_name = $find_session1->SessionName;

        DB::connection('sqlsrv2')->insert("INSERT INTO FinalSettlement(CompanyID, EmployeeID, SessionName, ResignOn, DStatus, MStatus, HrStatus, Status, FStatus, CreatedBy, CreatedOn) values (?,?,?,?,?,?,?,?,?,?,?)", [company_id(), $id, $sesson_name, $resign_date, 'Pending', 'Pending', 'Pending', 'Pending', 'Pending', username(), $update_date]);
        if ($result5) {
            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())
                ->where('Emp_Profile.EmployeeID', '=', $id)->get();

            $update_date = long_date();
            $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $id)->get();
            foreach ($full_name_arr as $full_name_arr1) {
            }
            $full_name = $full_name_arr1->Name;
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Status', 'Update status of ' . $full_name . ' to Resigned', $update_date]);
            //-------------
            /*
            $find_session =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=', company_id())->where('CurrentSession','=',1)->get();
                foreach ($find_session as $find_session1) {}
                $e_date = $find_session1->EndDate;
            $x = 1;
            $var=strtotime($e_date);
            $effectiveDate = strtotime("-".$x." months",$var);
            $previous_session = date("F-Y", $effectiveDate);  //Its previous seission e.g. "May-2022"
            $is_exist = DB::connection('sqlsrv2')->table('SessionReport')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('DStatus','=','P')->exists();
            $is_exist = DB::connection('sqlsrv2')->table('PayrollHrApproval')->where("isDeleted", '=', '0')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('HrStatus','=','P')->exists();
            $is_exist = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('FStatus','=','P')->where('PayrollFinanceApproval.IsDeleted', '=' ,0)->exists();
            $is_exist = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('DStatus','=','P')->exists();
            if($is_exist)
            {
                $is_deleted = DB::connection('sqlsrv2')->table('SessionReport')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('DStatus','=','P')->delete();
                $is_deleted = DB::connection('sqlsrv2')->table('PayrollHrApproval')->where("isDeleted", '=', '0')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('HrStatus','=','P')->delete();
                $is_deleted = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->where('SessionName','=',$previous_session)->where('PayrollFinanceApproval.IsDeleted', '=' ,0)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('FStatus','=','P')->delete();
                $is_deleted = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('SessionName','=',$previous_session)->where('CompanyID','=', company_id())->where('EmployeeID','=',$id)->where('DStatus','=','P')->delete();
                if($is_deleted)
                {
                    $find_session_last =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=', company_id())->where('SessionName','=',$previous_session)->get();
                    foreach ($find_session_last as $find_session_last1) {}
                    $sname1 = $find_session_last1->SessionName;
                    $s_date = $find_session_last1->StartDate;
                    $find_session_this =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=', company_id())->where('CurrentSession','=',1)->get();
                    foreach ($find_session_this as $find_session_this1) {}
                    $sname2 = $find_session1->SessionName;
                    $sname = $sname1.' and '.$sname2;
                }
            }
            else
            {
                $find_session =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=', company_id())->where('CurrentSession','=',1)->get();
                foreach ($find_session as $find_session1) {}
                $sname = $find_session1->SessionName;
                $s_date = $find_session1->StartDate;
                //$session_end_date = $find_session1->EndDate;
            }
            $result_insert = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ; exec [dbo].[Get_FinalSettlement]
                @createdby = N'".username()."',
                @createdon = N'".$update_date."',
                @session = N'".$sname."',
                @id = N'".$id."',
                @STARTDATE = '".$s_date."',
                @ENDDATE = '".$resign_date."' ");
                */
            /*
                 DB::connection('sqlsrv2')->SELECT("SET NOCOUNT ON  EXEC [dbo].[Get_FinalSettlement] N'".username()."', N'".$update_date."', N'".$sname."', N'".$id."', N'".$s_date."', N'".$resign_date."' ");*/

            //---------------
            return request()->json(200, $emp_detail);
        }
    }

    public function suspend_emp($id, $date)
    {

        $update_date = date("Y-m-d");
        $result5 = DB::connection('sqlsrv2')->update('update Emp_Register set SuspensionEnd=?, Status=?,RegDate=? where EmployeeID =?', [$date, "Suspended", $update_date, $id]);

        if ($result5) {

            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())
                ->where('Emp_Profile.EmployeeID', '=', $id)->get();


            $update_date = long_date();

            $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $id)->get();
            foreach ($full_name_arr as $full_name_arr1) {
            }
            $full_name = $full_name_arr1->Name;
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Status', 'Update status of ' . $full_name . ' to Suspended', $update_date]);


            return request()->json(200, $emp_detail);
        }
    }

    //Terminate employee
    public function terminate_emp($id, $date)
    {


        $update_date = long_date();
        $result5 = DB::connection('sqlsrv2')->update('update Emp_Register set Status=?, TerminateDate=? where EmployeeID =?', ["Terminated", $date, $id]);

        if ($result5) {
            $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
            foreach ($find_session_closed as $find_session1) {
            }
            $sesson_name = $find_session1->SessionName;
            DB::connection('sqlsrv2')->insert("INSERT INTO FinalSettlement(CompanyID, EmployeeID, SessionName, ResignOn, DStatus, MStatus, HrStatus, Status, FStatus, CreatedBy, CreatedOn) values (?,?,?,?,?,?,?,?,?,?,?)", [company_id(), $id, $sesson_name, $date, 'Pending', 'Pending', 'Pending', 'Pending', 'Pending', username(), $update_date]);

            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Profile.EmployeeID', '=', $id)->get();
            $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $id)->get();
            foreach ($full_name_arr as $full_name_arr1) {
            }
            $full_name = $full_name_arr1->Name;
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Status', 'Update status of ' . $full_name . ' to Terminated', $update_date]);
            return request()->json(200, $emp_detail);
        }
    }

    public function getemployee_update_education($id)
    {
        $arr = DB::connection('sqlsrv2')->table('Employee_Qualification')->where('EmployeeID', '=', $id)->get();
        return request()->json(200, $arr);
    }

    public function getemployee_update_experience($id)
    {
        $arr = DB::connection('sqlsrv2')->table('Emp_Work_Experience')->where('EmployeeID', '=', $id)->get();
        return request()->json(200, $arr);
    }

    public function update_emp_docs(Request $request)
    {
        $id = $request->get('id');
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $name_image = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/images/documents/', $name_image);
            $result = DB::connection('sqlsrv2')->update('update  Emp_Documents set Image1=? where EmployeeID=?', [$name_image, $id]);
        } elseif ($request->hasFile('image_file2')) {
            $file = $request->file('image_file2');
            $name_image2 = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/images/documents/', $name_image2);
            $result = DB::connection('sqlsrv2')->update('update  Emp_Documents set Image2=? where EmployeeID=?', [$name_image2, $id]);
        } elseif ($request->hasFile('image_file3')) {
            $file = $request->file('image_file3');
            $name_image3 = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/images/documents/', $name_image3);
            $result = DB::connection('sqlsrv2')->update('update  Emp_Documents set Image3=? where EmployeeID=?', [$name_image3, $id]);
        } elseif ($request->hasFile('image_file4')) {
            $file = $request->file('image_file4');
            $name_image4 = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/images/documents/', $name_image4);
            $result = DB::connection('sqlsrv2')->update('update  Emp_Documents set Image4=? where EmployeeID=?', [$name_image4, $id]);
        } elseif ($request->hasFile('image_file5')) {
            $file = $request->file('image_file5');
            $name_image5 = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/images/documents/', $name_image5);
            $result = DB::connection('sqlsrv2')->update('update  Emp_Documents set Image5=? where EmployeeID=?', [$name_image5, $id]);
        } elseif ($request->hasFile('image_file6')) {
            $file = $request->file('image_file6');
            $name_image6 = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/images/documents/', $name_image6);
            $result = DB::connection('sqlsrv2')->update('update  Emp_Documents set Image6=? where EmployeeID=?', [$name_image6, $id]);
            $arr = DB::connection('sqlsrv2')->table('Emp_Documents')->where('EmployeeID', '=', $id)->get();


            return request()->json(200, $arr);
        }

        DB::connection('sqlsrv2')->update('update  Emp_Register set DocStatus=? where EmployeeID=?', ['Added', $id]);

        return request()->json(200, 'ok');
    }

    public function getemployee_documents($id)
    {
        $arr = DB::connection('sqlsrv2')->table('Emp_Documents')->where('EmployeeID', '=', $id)->get();
        return request()->json(200, $arr);
    }

    public function get_com_employee()
    {

        $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('Emp_Profile.Name', 'ASC')
            ->select('Emp_Profile.*', 'Emp_Register.*')
            // ->where('Emp_Profile.CompanyID','=', company_id())
            ->get();
        return response()->json($emp_detail);
    }

    public function cv_builder($id, $emp_code, $reg_id)
    {
        $this->fpdf->AddPage("P", ['210', '297']);


        $emp_detail9 = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Profile.EmployeeID', '=', $id)->where('Emp_Register.EmployeeCode', '=', $emp_code)->where('Emp_Register.RegisterID', '=', $reg_id)->exists();
        if ($emp_detail9) {
            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Profile.EmployeeID', '=', $id)->get();
            foreach ($emp_detail as $emp_detail1) {
            }


            // Section 1

            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(103, 159, 250);

            $this->fpdf->Text(75, 15, 'Curriculum Vitae');
            $this->fpdf->Image('public/images/profile_images/' . $emp_detail1->Photo, 172, 23, 30, 35);

            $this->fpdf->SetFont('Times', 'I', 12);
            $this->fpdf->SetTextColor(0, 0, 0);

            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(103, 159, 250);
            $this->fpdf->Text(30, 30, $emp_detail1->Name);
            $this->fpdf->Image('public/images/cv/phone.png', 15, 32, 5, 0);
            $this->fpdf->SetFont('Times', 'I', 12);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->Text(30, 38, $emp_detail1->Mobile);

            $this->fpdf->Image('public/images/cv/email.png', 12, 38, 10, 0);
            $this->fpdf->Text(30, 44, $emp_detail1->Email);
            $this->fpdf->Image('public/images/cv/gps.png', 15, 47, 5, 0);
            $this->fpdf->Text(30, 50, $emp_detail1->Address);
            $this->fpdf->SetDrawColor(103, 159, 250);
            $this->fpdf->SetLineWidth(1);
            $this->fpdf->Line(15, 61, 190, 61);


            //Section 2

            $this->fpdf->SetFont('Times', 'B', 16);
            $this->fpdf->SetTextColor(103, 159, 250);
            $this->fpdf->Text(15, 72, 'Objective');
            $this->fpdf->SetFont('Times', 'I', 14);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetY(77);
            $this->fpdf->SetX(15);
            $this->fpdf->MultiCell(0, 5, 'A highly creative thinker, grammar Nazi, and social media enthusiast seek the position of Social Media & Content Marketing Analyst to transform technical and digital information and processes into influencial stories.');

            $this->fpdf->Cell(267, 5, '_________________________________________________________________________');
            $this->fpdf->ln(7);

            // Section 3

            $this->fpdf->SetFont('Times', 'B', 18);
            $this->fpdf->SetTextColor(103, 159, 250);
            $this->fpdf->Cell(100, 15, 'Experience');
            $this->fpdf->ln(15);

            // $array = array(1,2,3,4,5,6,7,8);
            $array = DB::connection('sqlsrv2')->table('Emp_Work_Experience')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->orderBy('Id', 'desc')->get();

            foreach ($array as $num) {

                $this->fpdf->SetFont('Times', '', 14);
                $this->fpdf->SetTextColor(0, 0, 0);
                $this->fpdf->Cell(90, 7, "Job Position :" . $num->JobTitle, 0, 1, 'L');
                $this->fpdf->Cell(90, 7, "Company Name :" . $num->CompanyName, 0, 1, 'L');
                $this->fpdf->SetFont('Times', '', 14);
                $this->fpdf->SetTextColor(0, 0, 0);
                $this->fpdf->Cell(40, 7, "From: " . $num->StartingDate, 0, 0, 'L');
                $this->fpdf->Cell(40, 7, "To: " . $num->LeavingDate, 0, 1, 'L');
                $this->fpdf->ln(5);
            }

            $this->fpdf->ln(2);
            $this->fpdf->Cell(267, 5, '_________________________________________________________________________');
            $this->fpdf->ln(15);

            //Section 4

            $this->fpdf->SetFont('Times', 'B', 18);
            $this->fpdf->SetTextColor(103, 159, 250);
            $this->fpdf->Cell(100, 15, "Education", 0, 1, 'L');
            $array2 = DB::connection('sqlsrv2')->table('Employee_Qualification')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->orderBy('Id', 'desc')->get();


            foreach ($array2 as $num2) {

                $this->fpdf->SetFont('Times', '', 14);
                $this->fpdf->SetTextColor(0, 0, 0);
                $this->fpdf->Cell(90, 7, $num2->DegreeType . " : " . $num2->DegreeName, 0, 1, 'L');
                $this->fpdf->Cell(90, 7, "Institute Name : " . $num2->InstituteName, 0, 1, 'L');
                $this->fpdf->SetFont('Times', '', 14);
                $this->fpdf->SetTextColor(0, 0, 0);
                $this->fpdf->Cell(40, 7, "Passing Year: " . $num2->PassingYear, 0, 1, 'L');

                $this->fpdf->ln(5);
            }


            $this->fpdf->Cell(267, 5, '_________________________________________________________________________');
            $this->fpdf->ln(15);

            // Section 5

            $this->fpdf->SetFont('Times', 'B', 18);
            $this->fpdf->SetTextColor(103, 159, 250);
            $this->fpdf->Cell(100, 10, 'Employment Details');
            $this->fpdf->ln(15);

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->Cell(50, 8, 'Employee Code:', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->EmployeeCode, 0, 0, 'L');
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(50, 8, 'Designation:', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->Designation, 0, 1, 'L');

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->Cell(50, 8, 'Department:', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->Department, 0, 0, 'L');
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(40, 8, 'Email:', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 10);
            $this->fpdf->Cell(60, 8, $emp_detail1->CompanyEmail, 0, 1, 'L');

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->Cell(50, 8, 'Posting City:', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->PostingCity, 0, 0, 'L');
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(50, 8, 'Job Shift:', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 14);

            $this->fpdf->Cell(50, 8, $emp_detail1->JobShift, 0, 1, 'L');

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);

            $this->fpdf->Cell(50, 8, 'Reporting to:', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->ReportingTo, 0, 0, 'L');
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(50, 8, 'Joining Date:', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 14);

            $this->fpdf->Cell(50, 8, $emp_detail1->JoiningDate, 0, 1, 'L');


            $this->fpdf->SetFont('Times', 'B', 14);


            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);

            $this->fpdf->Cell(50, 8, 'Job Status:', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->Status, 0, 0, 'L');
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(50, 8, 'Team Attendance', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 14);
            if ($emp_detail1->AllowEmployeesAttendance == 1) {
                $this->fpdf->Cell(50, 8, 'Allow', 0, 1, 'L');
            } else {
                $this->fpdf->Cell(50, 8, 'Not Allow', 0, 1, 'L');
            }

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);

            $this->fpdf->Cell(50, 8, 'Probation End:', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->ProbationEnd, 0, 0, 'L');

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->Cell(50, 8, 'Eportal Access:', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            if ($emp_detail1->EportalAccess == 1) {
                $this->fpdf->Cell(50, 8, 'Yes', 0, 1, 'L');
            } else {
                $this->fpdf->Cell(50, 8, 'No', 0, 1, 'L');
            }
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(50, 8, 'SMS Notifications', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 14);
            if ($emp_detail1->SendNotification == 1) {
                $this->fpdf->Cell(50, 8, 'Allow', 0, 1, 'L');
            } else {
                $this->fpdf->Cell(50, 8, 'Not Allow', 0, 1, 'L');
            }


            $this->fpdf->Cell(267, 5, '_________________________________________________________________________');
            $this->fpdf->ln(7);

            //Section 6

            $this->fpdf->SetFont('Times', 'B', 18);
            $this->fpdf->SetTextColor(103, 159, 250);
            $this->fpdf->Cell(100, 10, 'Personal Details');
            $this->fpdf->ln(10);

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);

            $this->fpdf->Cell(50, 8, 'Father Name:', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->FatherHusband, 0, 0, 'L');
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(50, 8, 'Gender:', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->Gender, 0, 1, 'L');

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);

            $this->fpdf->Cell(50, 8, 'Date of Birth', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->DOB, 0, 0, 'L');
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(50, 8, 'Religion:', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 14);

            $this->fpdf->Cell(50, 8, $emp_detail1->Religion, 0, 1, 'L');

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);

            $this->fpdf->Cell(50, 8, 'City:', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->City, 0, 0, 'L');
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(50, 8, 'Country:', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 14);

            $this->fpdf->Cell(50, 8, 'Pakistan', 0, 1, 'L');

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);

            $this->fpdf->Cell(50, 8, 'CNIC', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->CNIC, 0, 0, 'L');
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(50, 8, 'CNIC Expiry:', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 14);

            $this->fpdf->Cell(50, 8, $emp_detail1->CnicExpiry, 0, 1, 'L');

            $this->fpdf->SetFont('Times', 'B', 14);
            $this->fpdf->SetTextColor(0, 0, 0);

            $this->fpdf->Cell(50, 8, 'Relation:', 0, 0, 'L');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->Cell(50, 8, $emp_detail1->Relation, 0, 0, 'L');
            $this->fpdf->SetFont('Times', 'B', 14);

            $this->fpdf->Cell(50, 8, 'Blood Group:', 0, 0, 'L');
            $this->fpdf->SetFont('Times', '', 14);

            $this->fpdf->Cell(50, 8, $emp_detail1->BloodGroup, 0, 1, 'L');

            $this->fpdf->Cell(267, 5, '_________________________________________________________________________');
            $this->fpdf->ln(7);

            // Section 7

            $this->fpdf->SetFont('Times', 'B', 18);
            $this->fpdf->SetTextColor(103, 159, 250);
            $this->fpdf->Cell(100, 10, 'Refrences');
            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'I', 14);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->Cell(100, 8, 'Refrences may provided on demand.', 0, 0, 'L');
            $this->fpdf->ln(5);


            $this->fpdf->Cell(267, 5, '_________________________________________________________________________');
            $this->fpdf->ln(7);

            $this->fpdf->Output();
            exit;
        } else {
            "Please Type Valid Information";
        }
    }

    public function get_emp_detail(Request $request)
    {


        $emp_id = $request->get('emp_id');
        $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Register.EmployeeCode', '=', $emp_id)->where('Emp_Profile.CompanyID', '=', company_id())->get();
        return request()->json(200, $emp_detail);
    }

    public function warning_reasons()
    {

        $warnings = DB::connection('sqlsrv2')->table('Warning_Reason')->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $warnings);
    }

    public function warning_reasonsbyId($id)
    {
        $warnings = DB::connection('sqlsrv2')->table('Warning_Reason')->where('CompanyID', '=', company_id())->where('ReasonID', '=', $id)->get();
        return request()->json(200, $warnings);
    }


    public function getwarnig_emp($id)
    {
        if ($id == 0) {
            $id = Session::get('employee_id');
        }
        $id_arr = DB::connection('sqlsrv2')->table('Warning_Letter')->where('EmployeeID', '=', $id)->get();
        return request()->json(200, $id_arr);
    }

    public function submit_warning(Request $request)
    {


        $dated = $request->get('dated');
        $emp_code = $request->get('emp_code');
        $emp_name = $request->get('emp_name');
        $department = $request->get('department');
        $designation = $request->get('designation');
        $location = $request->get('location');
        $subject = $request->get('subject');
        $warning_content = $request->get('warning_content');

        $update_date = long_date();

        $emp_rep1 = DB::connection('sqlsrv2')->table('Emp_Register')->select('EmployeeID')->where('EmployeeCode', '=', $emp_code)->where('CompanyID', '=', company_id())->get();
        foreach ($emp_rep1 as $emp_rep11) {
        }
        $emp_id = $emp_rep11->EmployeeID;

        $find_warning = DB::connection('sqlsrv2')->table('Warning_Letter')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $emp_id)->exists();
        if ($find_warning) {
            $find_warning1 = DB::connection('sqlsrv2')->table('Warning_Letter')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $emp_id)->get();
            foreach ($find_warning1 as $find_warning11) {
            }
            $warning_type2 = $find_warning11->WarningType;
            if ($warning_type2 == 'First') {
                $warning_type = 'Second';
            } elseif ($warning_type2 == 'Second') {
                $warning_type = 'Terminated';
            } elseif ($warning_type2 == 'Terminated') {
                $message = 'Employee is already terminated';
                return request()->json(200, $message);
            }
        } else {
            $warning_type = 'First';
        }

        DB::connection('sqlsrv2')->insert('INSERT INTO Warning_Letter(CompanyID, DateIssued, EmployeeID, EmployeeName, Department, Designation, Location, WarningType, ReasonSubject, CreatedBy, CreatedOn, WarningContent) values (?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $dated, $emp_id, $emp_name, $department, $designation, $location, $warning_type, $subject, username(), $update_date, $warning_content]);
        if ($warning_type == 'Terminated') {
            $result = DB::connection('sqlsrv2')->update('update Emp_Register set Status=? where EmployeeCode=? and CompanyID=?', [$warning_type, $emp_id, company_id()]);
        }

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Warning Issue', $warning_type . ' warning Issued to ' . $emp_name, $update_date]);

        $message = 'submitted';
        return request()->json(200, $message);
    }

    public function warning_detail()
    {

        $arr = DB::connection('sqlsrv2')->table('Warning_Letter')->join('Emp_Profile', 'Warning_Letter.EmployeeID', '=', 'Emp_Profile.EmployeeID')->where('Warning_Letter.CompanyID', '=', company_id())->select('Warning_Letter.*', 'Emp_Profile.Name')->get();
        return request()->json(200, $arr);
    }

    public function count_warnings()
    {

        $total = DB::connection('sqlsrv2')->table('Warning_Letter')->where('CompanyID', '=', company_id())->count();
        $first = DB::connection('sqlsrv2')->table('Warning_Letter')->where('CompanyID', '=', company_id())->where('WarningType', '=', 'First')->count();
        $second = DB::connection('sqlsrv2')->table('Warning_Letter')->where('CompanyID', '=', company_id())->where('WarningType', '=', 'Second')->count();
        $terminate = DB::connection('sqlsrv2')->table('Warning_Letter')->where('CompanyID', '=', company_id())->where('WarningType', '=', 'Terminate')->count();

        $myJSON = array(
            'total' => $total,
            'first' => $first,
            'second' => $second,
            'terminate' => $terminate,
        );
        return request()->json(200, $myJSON);
    }

    public function search_warnings(Request $request)
    {

        $check_conversation = DB::connection('sqlsrv2')->table('Warning_Letter')->join('Emp_Profile', 'Warning_Letter.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Warning_Letter.CompanyID', '=', company_id())->select('Warning_Letter.*', 'Emp_Profile.Name', 'Emp_Register.EmployeeCode', 'Emp_Register.PostingCity')->where('Emp_Profile.Name', 'LIKE', '%' . $request->keyword1 . '%')->paginate(20);

        return response()->json($check_conversation);
    }

    public function getwarnig_d($id)
    {

        $arr = DB::connection('sqlsrv2')->table('Warning_Letter')->join('Emp_Profile', 'Warning_Letter.EmployeeID', '=', 'Emp_Profile.EmployeeID')->where('Warning_Letter.LetterID', '=', $id)->where('Warning_Letter.CompanyID', '=', company_id())->select('Warning_Letter.*', 'Emp_Profile.Name')->get();
        return request()->json(200, $arr);
    }

    public function submit_roster(Request $request)
    {


        $roster_name = $request->get('roster_name');
        $monday_s = $request->get('monday_s');
        $monday_in = $request->get('monday_in');
        $monday_out = $request->get('monday_out');
        $tuesday_s = $request->get('tuesday_s');

        $tuesday_in = $request->get('tuesday_in');
        $tuesday_out = $request->get('tuesday_out');
        $wednesday_s = $request->get('wednesday_s');
        $wednesday_in = $request->get('wednesday_in');
        $wednesday_out = $request->get('wednesday_out');

        $thursday_s = $request->get('thursday_s');
        $thursday_in = $request->get('thursday_in');
        $thursday_out = $request->get('thursday_out');
        $friday_s = $request->get('friday_s');
        $friday_in = $request->get('friday_in');

        $friday_out = $request->get('friday_out');
        $saturday_s = $request->get('saturday_s');
        $saturday_in = $request->get('saturday_in');
        $saturday_out = $request->get('saturday_out');
        $sunday_s = $request->get('sunday_s');

        $sunday_in = $request->get('sunday_in');
        $sunday_out = $request->get('sunday_out');

        if ($monday_s != 1) {
            $monday_in = '';
            $monday_out = '';
        }
        if ($tuesday_s != 1) {
            $tuesday_in = '';
            $tuesday_out = '';
        }
        if ($wednesday_s != 1) {
            $wednesday_in = '';
            $wednesday_out = '';
        }
        if ($thursday_s != 1) {
            $thursday_in = '';
            $thursday_out = '';
        }
        if ($friday_s != 1) {
            $friday_in = '';
            $friday_out = '';
        }
        if ($saturday_s != 1) {
            $saturday_in = '';
            $saturday_out = '';
        }
        if ($sunday_s != 1) {
            $sunday_in = '';
            $sunday_out = '';
        }
        $find_name = DB::connection('sqlsrv2')->table('Roasters')->where('CompanyID', '=', company_id())->where('RosterName', '=', $roster_name)->exists();
        if ($find_name) {
            $arr = "Roster Name Already Exists";
            return request()->json(200, $arr);
        } else {
            DB::connection('sqlsrv2')->insert("INSERT INTO Roasters(RosterName,Mon,Tue,Wed,Thu,Fri,Sat,Sun,CreatedBy,CompanyID) values (?,?,?,?,?,?,?,?,?,?)", [$roster_name, $monday_in . '-' . $monday_out, $tuesday_in . '-' . $tuesday_out, $wednesday_in . '-' . $wednesday_out, $thursday_in . '-' . $thursday_out, $friday_in . '-' . $friday_out, $saturday_in . '-' . $saturday_out, $sunday_in . '-' . $sunday_out, username(), company_id()]);


            $update_date = long_date();
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Roaster Added', 'New roaster ' . $roster_name . ' added', $update_date]);

            $arr = DB::connection('sqlsrv2')->table('Roasters')->where('CompanyID', '=', company_id())->paginate();

            return request()->json(200, $arr);
        }
    }


    public function roster_detail()
    {

        $arr = DB::connection('sqlsrv2')->table('Roasters')->where('CompanyID', '=', company_id())->get();

        return request()->json(200, $arr);
    }

    public function overall_grace_period()
    {


        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('EmpGraceHours', 'Emp_Profile.EmployeeID', '=', 'EmpGraceHours.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('EmpGraceHours.EmployeeID', 'desc')
            ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'EmpGraceHours.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('EmpGraceHours.CompanyID', '=', company_id())
            ->paginate(15);


        return request()->json(200, $arr);
    }

    public function search_by_grace_period($id)
    {

        if ($id == 'Department') {
            $arr = DB::table('tb_department')->select('department_name as num')->where('company_id', '=', company_id())->get();
            return request()->json(200, $arr);
        } elseif ($id == "Designation") {
            $arr = DB::table('tb_designation')->select('designation_name as num')->where('company_id', '=', company_id())->orderBy('designation_name', 'asc')->get();
            return request()->json(200, $arr);
        } elseif ($id == "Location") {
            $arr = DB::table('tb_company_locations')->select('location_name as num')->where('company_id', '=', company_id())->orderBy('location_name', 'asc')->get();
            return request()->json(200, $arr);
        }
    }

    public function update_ind_grace(Request $request)
    {

        $grace_id = $request->get('grace_ids');
        $em_code = $request->get('em_code');
        $em_name = $request->get('em_name');
        $em_totalgp3 = $request->get('em_totalgp');
        $find_grace = DB::connection('sqlsrv2')->table('EmpGraceHours')->where('CompanyID', '=', company_id())->where('EmpGraceID', '=', $grace_id)->exists();
        if ($find_grace) {

            $update_date = long_date();
            $find_grace5 = DB::connection('sqlsrv2')->table('EmpGraceHours')->where('CompanyID', '=', company_id())->where('EmpGraceID', '=', $grace_id)->get();
            foreach ($find_grace5 as $find_grace51) {
            }
            $pre_grace = $find_grace51->TotalGP;
            $em_totalgp = $pre_grace + $em_totalgp3;


            $result = DB::connection('sqlsrv2')->update('update EmpGraceHours set TotalGP=? where EmpGraceID=?', [$em_totalgp, $grace_id]);
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('EmpGraceHours', 'Emp_Profile.EmployeeID', '=', 'EmpGraceHours.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('EmpGraceHours.EmployeeID', 'desc')
                ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'EmpGraceHours.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('EmpGraceHours.CompanyID', '=', company_id())
                ->paginate(15);


            return request()->json(200, $arr);
        }
    }

    public function update_overall_grace(Request $request)
    {


        $search_by = $request->get('search_by');
        $search_name = $request->get('search_name');
        $overall_totalgp3 = $request->get('overall_totalgp');

        if ($search_by == 'Department') {
            $GpTarget = "department " . $search_name;
            $find_dep_graceperiod = DB::connection('sqlsrv2')->table('Emp_Register')
                ->join('EmpGraceHours', 'Emp_Register.EmployeeID', '=', 'EmpGraceHours.EmployeeID')
                ->orderBy('EmpGraceHours.EmployeeID', 'desc')
                ->select('EmpGraceHours.EmployeeID')->where('EmpGraceHours.CompanyID', '=', company_id())->where('Emp_Register.Department', '=', $search_name)->get();

            for ($x = 0; $x < count($find_dep_graceperiod); $x++) {
                $find_grace5 = DB::connection('sqlsrv2')->table('EmpGraceHours')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $find_dep_graceperiod[$x]->EmployeeID)->get();
                foreach ($find_grace5 as $find_grace51) {
                }
                $pre_grace = $find_grace51->TotalGP;
                $overall_totalgp = $pre_grace + $overall_totalgp3;
                $result = DB::connection('sqlsrv2')->update('update EmpGraceHours set TotalGP=? where EmployeeID=?', [$overall_totalgp, $find_dep_graceperiod[$x]->EmployeeID]);
            }
        } elseif ($search_by == 'Location') {
            $GpTarget = "location " . $search_name;
            $find_dep_graceperiod = DB::connection('sqlsrv2')->table('Emp_Register')
                ->join('EmpGraceHours', 'Emp_Register.EmployeeID', '=', 'EmpGraceHours.EmployeeID')
                ->orderBy('EmpGraceHours.EmployeeID', 'desc')
                ->select('EmpGraceHours.EmployeeID')->where('EmpGraceHours.CompanyID', '=', company_id())->where('Emp_Register.PostingCity', '=', $search_name)->get();
            for ($x = 0; $x < count($find_dep_graceperiod); $x++) {
                $find_grace5 = DB::connection('sqlsrv2')->table('EmpGraceHours')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $find_dep_graceperiod[$x]->EmployeeID)->get();
                foreach ($find_grace5 as $find_grace51) {
                }
                $pre_grace = $find_grace51->TotalGP;
                $overall_totalgp = $pre_grace + $overall_totalgp3;
                //return request()->json(200, $find_dep_graceperiod[$x]->EmployeeID.$find_grace51->TotalGP);
                $result = DB::connection('sqlsrv2')->update('update EmpGraceHours set TotalGP=? where EmployeeID=?', [$overall_totalgp, $find_dep_graceperiod[$x]->EmployeeID]);
            }
        } elseif ($search_by == 'Designation') {
            $GpTarget = "designation " . $search_name;
            $find_dep_graceperiod = DB::connection('sqlsrv2')->table('Emp_Register')
                ->join('EmpGraceHours', 'Emp_Register.EmployeeID', '=', 'EmpGraceHours.EmployeeID')
                ->orderBy('EmpGraceHours.EmployeeID', 'desc')
                ->select('EmpGraceHours.EmployeeID')->where('EmpGraceHours.CompanyID', '=', company_id())->where('Emp_Register.Designation', '=', $search_name)->get();

            for ($x = 0; $x < count($find_dep_graceperiod); $x++) {
                $find_grace5 = DB::connection('sqlsrv2')->table('EmpGraceHours')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $find_dep_graceperiod[$x]->EmployeeID)->get();
                foreach ($find_grace5 as $find_grace51) {
                }
                $pre_grace = $find_grace51->TotalGP;
                $overall_totalgp = $pre_grace + $overall_totalgp3;
                //return request()->json(200, $find_dep_graceperiod[$x]->EmployeeID.$find_grace51->TotalGP);
                $result = DB::connection('sqlsrv2')->update('update EmpGraceHours set TotalGP=? where EmployeeID=?', [$overall_totalgp, $find_dep_graceperiod[$x]->EmployeeID]);
            }
        }


        $update_date = long_date();
        $full_name_id = $request->get('nameId');

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Grace Periods Updated', 'Grace periods of ' . $GpTarget . ' has updated', $update_date]);


        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('EmpGraceHours', 'Emp_Profile.EmployeeID', '=', 'EmpGraceHours.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('EmpGraceHours.EmployeeID', 'desc')
            ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'EmpGraceHours.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
            ->where('EmpGraceHours.CompanyID', '=', company_id())->paginate(15);
        return request()->json(200, $arr);
    }

    public function roster_detail1()
    {

        $arr = DB::connection('sqlsrv2')->table('Roasters')->select('RosterName')->where('CompanyID', '=', company_id())->orderBy('RosterName', 'asc')->get();
        return request()->json(200, $arr);
    }

    public function leaves_detail() {}

    public function getattendance_report($department, $location, $designation, $emp_id, $start, $close)
    {


        $update_date = long_date();
        DB::insert("INSERT INTO Activity_Log(CompanyId,UserEmail,EmployeeName,EventStatus,Description,ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), username(), 'Attendance report printed', 'Attendance report printed', $update_date]);

        if ($designation == 'All' && $department == 'All' && $location == 'All' && $emp_id == 'All') {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID', '=', company_id())->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)->get();
            return request()->json(200, $arr);
        } else {
            if ($department == 'All') {
                $department = '';
            }
            if ($designation == 'All') {
                $designation = '';
            }
            if ($location == 'All') {
                $location = '';
            }
            if ($emp_id == 'All') {
                $emp_id = '';
            }
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID', '=', company_id())->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)->where('Emp_Register.Department', 'like', '%' . $department . '%')->where('Emp_Register.Designation', 'like', '%' . $designation . '%')->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')->where('AttData.EmpID', 'like', '%' . $emp_id . '%')->get();


            return request()->json(200, $arr);
        }
    }

    public function getattendance_summary()
    {

        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;
        $rangArray = [];

        $startDate = strtotime($s_date);
        $endDate = strtotime($e_date);
        for (
            $currentDate = $startDate;
            $currentDate <= $endDate;
            $currentDate += (86400)
        ) {
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }
        //  print_r($rangArray);
        $count_range = count($rangArray);


        $result = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ; exec [dbo].[GetMonthltAttReport]  N'" . $s_date . "', N'" . $e_date . "' ");


        if ($count_range == 31) {

            $i = 0;
            $k = '';
            foreach ($result as $result1) {
                $i = $i + 1;
                $b[$i] = '<tr><td>' . $result1->Name . '</td>
  <td>' . $result1->Designation . '</td>
  <td>' . $result1->Department . '</td>
  <td>' . $result1->{$rangArray[0]} . '</td>
    <td>' . $result1->{$rangArray[1]} . '</td>
  <td>' . $result1->{$rangArray[2]} . '</td>
   <td>' . $result1->{$rangArray[3]} . '</td>
    <td>' . $result1->{$rangArray[4]} . '</td>
  <td>' . $result1->{$rangArray[5]} . '</td>
  <td>' . $result1->{$rangArray[6]} . '</td>
  <td>' . $result1->{$rangArray[7]} . '</td>
  <td>' . $result1->{$rangArray[8]} . '</td>
  <td>' . $result1->{$rangArray[9]} . '</td>
  <td>' . $result1->{$rangArray[10]} . '</td>
  <td>' . $result1->{$rangArray[11]} . '</td>
  <td>' . $result1->{$rangArray[12]} . '</td>
  <td>' . $result1->{$rangArray[13]} . '</td>
  <td>' . $result1->{$rangArray[14]} . '</td>
  <td>' . $result1->{$rangArray[15]} . '</td>
  <td>' . $result1->{$rangArray[16]} . '</td>
  <td>' . $result1->{$rangArray[17]} . '</td>
  <td>' . $result1->{$rangArray[18]} . '</td>
  <td>' . $result1->{$rangArray[19]} . '</td>
  <td>' . $result1->{$rangArray[20]} . '</td>
  <td>' . $result1->{$rangArray[21]} . '</td>
  <td>' . $result1->{$rangArray[22]} . '</td>
  <td>' . $result1->{$rangArray[23]} . '</td>
  <td>' . $result1->{$rangArray[24]} . '</td>
  <td>' . $result1->{$rangArray[25]} . '</td>
  <td>' . $result1->{$rangArray[26]} . '</td>
  <td>' . $result1->{$rangArray[27]} . '</td>
  <td>' . $result1->{$rangArray[28]} . '</td>
  <td>' . $result1->{$rangArray[29]} . '</td>
  <td>' . $result1->{$rangArray[30]} . '</td>
  </tr>';
                $k = $k . '' . $b[$i];
            }

            $d = $k;
        } elseif ($count_range == 30) {

            $i = 0;
            $k = '';
            foreach ($result as $result1) {
                $i = $i + 1;
                $b[$i] = '<tr><td>' . $result1->Name . '</td>
  <td>' . $result1->Designation . '</td>
  <td>' . $result1->Department . '</td>
  <td>' . $result1->{$rangArray[0]} . '</td>
    <td>' . $result1->{$rangArray[1]} . '</td>
  <td>' . $result1->{$rangArray[2]} . '</td>
   <td>' . $result1->{$rangArray[3]} . '</td>
    <td>' . $result1->{$rangArray[4]} . '</td>
  <td>' . $result1->{$rangArray[5]} . '</td>
  <td>' . $result1->{$rangArray[6]} . '</td>
  <td>' . $result1->{$rangArray[7]} . '</td>
  <td>' . $result1->{$rangArray[8]} . '</td>
  <td>' . $result1->{$rangArray[9]} . '</td>
  <td>' . $result1->{$rangArray[10]} . '</td>
  <td>' . $result1->{$rangArray[11]} . '</td>
  <td>' . $result1->{$rangArray[12]} . '</td>
  <td>' . $result1->{$rangArray[13]} . '</td>
  <td>' . $result1->{$rangArray[14]} . '</td>
  <td>' . $result1->{$rangArray[15]} . '</td>
  <td>' . $result1->{$rangArray[16]} . '</td>
  <td>' . $result1->{$rangArray[17]} . '</td>
  <td>' . $result1->{$rangArray[18]} . '</td>
  <td>' . $result1->{$rangArray[19]} . '</td>
  <td>' . $result1->{$rangArray[20]} . '</td>
  <td>' . $result1->{$rangArray[21]} . '</td>
  <td>' . $result1->{$rangArray[22]} . '</td>
  <td>' . $result1->{$rangArray[23]} . '</td>
  <td>' . $result1->{$rangArray[24]} . '</td>
  <td>' . $result1->{$rangArray[25]} . '</td>
  <td>' . $result1->{$rangArray[26]} . '</td>
  <td>' . $result1->{$rangArray[27]} . '</td>
  <td>' . $result1->{$rangArray[28]} . '</td>
  <td>' . $result1->{$rangArray[29]} . '</td>
  </tr>';
                $k = $k . '' . $b[$i];
            }

            $d = $k;
        } elseif ($count_range == 29) {

            $i = 0;
            $k = '';
            foreach ($result as $result1) {
                $i = $i + 1;
                $b[$i] = '<tr><td>' . $result1->Name . '</td>
  <td>' . $result1->Designation . '</td>
  <td>' . $result1->Department . '</td>
  <td>' . $result1->{$rangArray[0]} . '</td>
    <td>' . $result1->{$rangArray[1]} . '</td>
  <td>' . $result1->{$rangArray[2]} . '</td>
   <td>' . $result1->{$rangArray[3]} . '</td>
    <td>' . $result1->{$rangArray[4]} . '</td>
  <td>' . $result1->{$rangArray[5]} . '</td>
  <td>' . $result1->{$rangArray[6]} . '</td>
  <td>' . $result1->{$rangArray[7]} . '</td>
  <td>' . $result1->{$rangArray[8]} . '</td>
  <td>' . $result1->{$rangArray[9]} . '</td>
  <td>' . $result1->{$rangArray[10]} . '</td>
  <td>' . $result1->{$rangArray[11]} . '</td>
  <td>' . $result1->{$rangArray[12]} . '</td>
  <td>' . $result1->{$rangArray[13]} . '</td>
  <td>' . $result1->{$rangArray[14]} . '</td>
  <td>' . $result1->{$rangArray[15]} . '</td>
  <td>' . $result1->{$rangArray[16]} . '</td>
  <td>' . $result1->{$rangArray[17]} . '</td>
  <td>' . $result1->{$rangArray[18]} . '</td>
  <td>' . $result1->{$rangArray[19]} . '</td>
  <td>' . $result1->{$rangArray[20]} . '</td>
  <td>' . $result1->{$rangArray[21]} . '</td>
  <td>' . $result1->{$rangArray[22]} . '</td>
  <td>' . $result1->{$rangArray[23]} . '</td>
  <td>' . $result1->{$rangArray[24]} . '</td>
  <td>' . $result1->{$rangArray[25]} . '</td>
  <td>' . $result1->{$rangArray[26]} . '</td>
  <td>' . $result1->{$rangArray[27]} . '</td>
  <td>' . $result1->{$rangArray[28]} . '</td>
  </tr>';
                $k = $k . '' . $b[$i];
            }

            $d = $k;
        } elseif ($count_range == 28) {

            $i = 0;
            $k = '';
            foreach ($result as $result1) {
                $i = $i + 1;
                $b[$i] = '<tr><td>' . $result1->Name . '</td>
  <td>' . $result1->Designation . '</td>
  <td>' . $result1->Department . '</td>
  <td>' . $result1->{$rangArray[0]} . '</td>
    <td>' . $result1->{$rangArray[1]} . '</td>
  <td>' . $result1->{$rangArray[2]} . '</td>
   <td>' . $result1->{$rangArray[3]} . '</td>
    <td>' . $result1->{$rangArray[4]} . '</td>
  <td>' . $result1->{$rangArray[5]} . '</td>
  <td>' . $result1->{$rangArray[6]} . '</td>
  <td>' . $result1->{$rangArray[7]} . '</td>
  <td>' . $result1->{$rangArray[8]} . '</td>
  <td>' . $result1->{$rangArray[9]} . '</td>
  <td>' . $result1->{$rangArray[10]} . '</td>
  <td>' . $result1->{$rangArray[11]} . '</td>
  <td>' . $result1->{$rangArray[12]} . '</td>
  <td>' . $result1->{$rangArray[13]} . '</td>
  <td>' . $result1->{$rangArray[14]} . '</td>
  <td>' . $result1->{$rangArray[15]} . '</td>
  <td>' . $result1->{$rangArray[16]} . '</td>
  <td>' . $result1->{$rangArray[17]} . '</td>
  <td>' . $result1->{$rangArray[18]} . '</td>
  <td>' . $result1->{$rangArray[19]} . '</td>
  <td>' . $result1->{$rangArray[20]} . '</td>
  <td>' . $result1->{$rangArray[21]} . '</td>
  <td>' . $result1->{$rangArray[22]} . '</td>
  <td>' . $result1->{$rangArray[23]} . '</td>
  <td>' . $result1->{$rangArray[24]} . '</td>
  <td>' . $result1->{$rangArray[25]} . '</td>
  <td>' . $result1->{$rangArray[26]} . '</td>
  <td>' . $result1->{$rangArray[27]} . '</td>
  </tr>';
                $k = $k . '' . $b[$i];
            }

            $d = $k;
        }

        return request()->json(200, $d);
    }

    public function get_column_name()
    {
        // $table = 'cities';

        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;


        $table = DB::connection('sqlsrv2')->select("EXEC  [dbo].[GetDateList]
    @STARTDATE = '" . $s_date . "',
    @ENDDATE = '" . $e_date . "'");
        return request()->json(200, $table);
    }

    public function submit_session(Request $request)
    {
        $session_start = $request->get('session_start');
        $session_end = $request->get('session_end');
        $c_session = $request->get('c_session');
        $year = date('Y', strtotime($session_start));
        $month = date('F', strtotime($session_start));
        $session_name = $month . '-' . $year;
        if ($c_session == 1) {
            DB::connection('sqlsrv2')->update('update HrSessions set CurrentSession=? where CompanyID=?', [0, company_id()]);
        }
        $result = DB::connection('sqlsrv2')->insert('INSERT INTO HrSessions(SessionName,StartDate,EndDate,CreateBy,CreateOn,CompanyID,CurrentSession,AttClosedPayrollStart,DistState) values (?,?,?,?,?,?,?,?,?)', [$session_name, $session_start, $session_end, username(), long_date(), company_id(), $c_session, 'Open', 1]);
        if ($result) {
            $arr = DB::connection('sqlsrv2')->table("HrSessions")->where('CompanyID', '=', company_id())->orderBy('SessionID', 'desc')->paginate(5);
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Insert New Session', 'New session ' . $session_name . ' added', long_date()]);
            return request()->json(200, $arr);
        }
    }

    public function session_detail()
    {

        $arr = DB::connection('sqlsrv2')->table("HrSessions")->where('CompanyID', '=', company_id())->orderBy('SessionID', 'desc')->paginate(5);

        return request()->json(200, $arr);
    }

    public function delete_session($id)
    {


        $update_date = long_date();


        $session_name_arr = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('SessionID', '=', $id)->get();
        foreach ($session_name_arr as $session_name_arr1) {
        }
        $session_name = $session_name_arr1->SessionName;

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Delete Session', 'Session ' . $session_name . ' deleted', $update_date]);


        $result = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('SessionID', $id)->delete();


        if ($result) {
            $arr = DB::connection('sqlsrv2')->table("HrSessions")->where('CompanyID', '=', company_id())->orderBy('SessionID', 'desc')->paginate(5);
            return request()->json(200, $arr);
        }
    }

    public function find_emp_id()
    {

        $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('Emp_Profile.EmployeeID', 'desc')
            ->select('Emp_Profile.Name', 'Emp_Register.EmployeeID', 'Emp_Register.EmployeeCode')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Register.EmployeeCode', '!=', '')->get();

        return request()->json(200, $emp_detail);
    }

    public function getindatt_report($id)
    {


        if ($id == 0) {
            $id = employee_id();
        }
        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;

        $table = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '>=', $s_date)->where('ATTDate', '<=', $e_date)->where('EmpID', '=', $id)->orderBy('ATTDate', 'desc')->get();
        return request()->json(200, $table);
    }

    public function getindatt_count($id)
    {
        $totaldays = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '>=', date('Y-m-01'))->where('ATTDate', '<=', date('Y-m-t'))->where('EmpID', '=', $id)->count();
        $present = DB::connection('sqlsrv2')->select("select
          COUNT(AttStatus) as present
          from AttData
          where
          ATTDate between   '" . date('Y-m-01') . "'  and '" . date('Y-m-t') . "'
          and EmpID = " . $id . "
          and AttStatus in ('P','L')");

        $absent = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '>=', date('Y-m-01'))->where('ATTDate', '<=', date('Y-m-t'))->where('EmpID', '=', $id)->where('AttStatus', '=', 'A')->count();
        $leaves = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '>=', date('Y-m-01'))->where('ATTDate', '<=', date('Y-m-t'))->where('EmpID', '=', $id)->where('AttStatus', '=', 'LE')->count();
        $getdata1 = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.PostingCity')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Profile.EmployeeID', '=', $id)->first();

        $myJSON = array(
            'totaldays' => $totaldays,
            'present' => $present[0]->present,
            'absent' => $absent,
            'leaves' => $leaves,
            'Name' => $getdata1->Name,
            'EmployeeCode' => $getdata1->EmployeeCode,
            'Department' => $getdata1->Department,
            'Designation' => $getdata1->Designation,
            'PostingCity' => $getdata1->PostingCity,
        );
        return request()->json(200, $myJSON);
    }

    public function getemploydetail($emp_department, $emp_location, $emp_designation, $emp_emp_id, $emp_type, $emp_status)
    {

        if ($emp_department == 'All' && $emp_location == 'All' && $emp_designation == 'All' && $emp_emp_id == 'All' && $emp_type == 'All' && $emp_status == 'All') {

            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('Emp_Profile.EmployeeID', 'desc')
                ->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Profile.CompanyID', '=', company_id())
                ->get();
            return request()->json(200, $emp_detail);
        } else {
            if ($emp_department == 'All') {
                $emp_department = '';
            }
            if ($emp_designation == 'All') {
                $emp_designation = '';
            }
            if ($emp_location == 'All') {
                $emp_location = '';
            }
            if ($emp_emp_id == 'All') {
                $emp_emp_id = '';
            }
            if ($emp_type == 'All') {
                $emp_type = '';
            }
            if ($emp_status == 'All') {
                $emp_status = '';
            }

            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('Emp_Profile.EmployeeID', 'desc')
                ->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Register.Department', 'like', '%' . $emp_department . '%')->where('Emp_Register.Designation', 'like', '%' . $emp_designation . '%')->where('Emp_Register.PostingCity', 'like', '%' . $emp_location . '%')->where('Emp_Register.EmployeeID', 'like', '%' . $emp_emp_id . '%')->where('Emp_Register.Status', 'like', '%' . $emp_status . '%')->where('Emp_Register.JobStatus', 'like', '%' . $emp_type . '%')
                ->get();
            return request()->json(200, $emp_detail);
        }
    }

    public function gethireemploy($hire_department, $hire_location, $hire_designation, $hire_emp_id, $hire_start_date, $hire_end_date)
    {

        if ($hire_department == 'All' && $hire_location == 'All' && $hire_designation == 'All' && $hire_emp_id == 'All' && $hire_start_date != '' && $hire_end_date != '') {

            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('Emp_Profile.EmployeeID', 'desc')
                ->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Register.JoiningDate', '>=', $hire_start_date)->where('Emp_Register.JoiningDate', '<=', $hire_end_date)
                ->get();

            return request()->json(200, $emp_detail);
        } else {
            if ($hire_department == 'All') {
                $hire_department = '';
            }
            if ($hire_designation == 'All') {
                $hire_designation = '';
            }
            if ($hire_location == 'All') {
                $hire_location = '';
            }
            if ($hire_emp_id == 'All') {
                $hire_emp_id = '';
            }


            $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('Emp_Profile.EmployeeID', 'desc')
                ->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Register.JoiningDate', '>=', $hire_start_date)->where('Emp_Register.JoiningDate', '<=', $hire_end_date)->where('Emp_Register.Department', 'like', '%' . $hire_department . '%')->where('Emp_Register.Designation', 'like', '%' . $hire_designation . '%')->where('Emp_Register.PostingCity', 'like', '%' . $hire_location . '%')->where('Emp_Register.EmployeeID', 'like', '%' . $hire_emp_id . '%')->get();
            return request()->json(200, $emp_detail);
        }
    }

    public function gethireemploycount($hire_department, $hire_location, $hire_designation, $hire_emp_id, $hire_start_date, $hire_end_date)
    {

        if ($hire_department == 'All' && $hire_location == 'All' && $hire_designation == 'All' && $hire_emp_id == 'All' && $hire_start_date != '' && $hire_end_date != '') {
            $all_emp = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', '>=', $hire_start_date)->where('JoiningDate', '<=', $hire_end_date)->count();
            return request()->json(200, $all_emp);
        } else {
            if ($hire_department == 'All') {
                $hire_department = '';
            }
            if ($hire_designation == 'All') {
                $hire_designation = '';
            }
            if ($hire_location == 'All') {
                $hire_location = '';
            }
            if ($hire_emp_id == 'All') {
                $hire_emp_id = '';
            }
            $all_emp = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', '>=', $hire_start_date)->where('JoiningDate', '<=', $hire_end_date)->where('Department', 'like', '%' . $hire_department . '%')->where('Designation', 'like', '%' . $hire_designation . '%')->where('PostingCity', 'like', '%' . $hire_location . '%')->where('EmployeeID', 'like', '%' . $hire_emp_id . '%')->count();
            return request()->json(200, $all_emp);
        }
    }

    public function overall_leaves()
    {

        $all_emp = DB::connection('sqlsrv2')->table('leaves')->select('LeaveType')->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $all_emp);
    }

    public function getleaveemploy($department, $location, $designation, $emp_id, $date_from, $date_end, $leave_type)
    {
        if ($designation == 'All' && $department == 'All' && $location == 'All' && $emp_id == 'All' && $leave_type == 'All') {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('leave_Requisition', 'Emp_Profile.EmployeeID', '=', 'leave_Requisition.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('leave_Requisition.EmployeeID', 'desc')
                ->select('Emp_Profile.Name', 'leave_Requisition.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('leave_Requisition.CompanyID', '=', company_id())->where('leave_Requisition.StartDate', '>=', $date_from)->where('leave_Requisition.EndDate', '<=', $date_end)->get();
            return request()->json(200, $arr);
        } else {
            if ($department == 'All') {
                $department = '';
            }
            if ($designation == 'All') {
                $designation = '';
            }
            if ($location == 'All') {
                $location = '';
            }
            if ($emp_id == 'All') {
                $emp_id = '';
            }
            if ($leave_type == 'All') {
                $leave_type = '';
            }
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('leave_Requisition', 'Emp_Profile.EmployeeID', '=', 'leave_Requisition.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('leave_Requisition.EmployeeID', 'desc')
                ->select('Emp_Profile.Name', 'leave_Requisition.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('leave_Requisition.CompanyID', '=', company_id())->where('leave_Requisition.StartDate', '>=', $date_from)->where('leave_Requisition.EndDate', '<=', $date_end)->where('Emp_Register.Department', 'like', '%' . $department . '%')->where('Emp_Register.Designation', 'like', '%' . $designation . '%')->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')->where('Emp_Register.EmployeeCode', 'like', '%' . $emp_id . '%')->where('leave_Requisition.Leavetype', 'like', '%' . $leave_type . '%')->get();


            return request()->json(200, $arr);
        }
    }

    public function filter_leaves1($department, $location, $designation, $emp_id, $leave_type)
    {


        if ($designation == 'All' && $department == 'All' && $location == 'All' && $emp_id == 'All') {

            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('EmpLeave', 'Emp_Profile.EmployeeID', '=', 'EmpLeave.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('EmpLeave.EmployeeID', 'desc')
                ->select('Emp_Profile.Name', 'EmpLeave.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('EmpLeave.CompanyID', '=', company_id())->where('EmpLeave.LeaveType', '=', $leave_type)->get();


            return request()->json(200, $arr);
        } else {
            if ($department == 'All') {
                $department = '';
            }
            if ($designation == 'All') {
                $designation = '';
            }
            if ($location == 'All') {
                $location = '';
            }
            if ($emp_id == 'All') {
                $emp_id = '';
            }

            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('EmpLeave', 'Emp_Profile.EmployeeID', '=', 'EmpLeave.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('EmpLeave.EmployeeID', 'desc')
                ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'EmpLeave.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('EmpLeave.CompanyID', '=', company_id())->where('EmpLeave.LeaveType', '=', $leave_type)->where('Emp_Register.Department', 'like', '%' . $department . '%')->where('Emp_Register.Designation', 'like', '%' . $designation . '%')->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')->where('EmpLeave.EmployeeID', 'like', '%' . $emp_id . '%')->get();

            return request()->json(200, $arr);
        }
    }

    public function fetch_roster_detail($id)
    {

        $check_roster = DB::connection('sqlsrv2')->table('Roasters')->where('CompanyID', '=', company_id())->where('RosterID', '=', $id)->get();
        return request()->json(200, $check_roster);
    }

    public function submit_update_roster(Request $request)
    {

        $update_date = long_date();


        $roster_id = $request->get('uroster_id');
        $roster_name = $request->get('uroster_name');
        $monday_s = $request->get('umonday_s');
        $monday_in = $request->get('umonday_in');
        $monday_out = $request->get('umonday_out');

        $tuesday_s = $request->get('utuesday_s');
        $tuesday_in = $request->get('utuesday_in');
        $tuesday_out = $request->get('utuesday_out');
        $wednesday_s = $request->get('uwednesday_s');
        $wednesday_in = $request->get('uwednesday_in');

        $wednesday_out = $request->get('uwednesday_out');
        $thursday_s = $request->get('uthursday_s');
        $thursday_in = $request->get('uthursday_in');
        $thursday_out = $request->get('uthursday_out');
        $friday_s = $request->get('ufriday_s');

        $friday_in = $request->get('ufriday_in');
        $friday_out = $request->get('ufriday_out');
        $saturday_s = $request->get('usaturday_s');
        $saturday_in = $request->get('usaturday_in');
        $saturday_out = $request->get('usaturday_out');

        $sunday_s = $request->get('usunday_s');
        $sunday_in = $request->get('usunday_in');
        $sunday_out = $request->get('usunday_out');

        if ($monday_s != 1) {
            $monday_in = '';
            $monday_out = '';
        }
        if ($tuesday_s != 1) {
            $tuesday_in = '';
            $tuesday_out = '';
        }
        if ($wednesday_s != 1) {
            $wednesday_in = '';
            $wednesday_out = '';
        }
        if ($thursday_s != 1) {
            $thursday_in = '';
            $thursday_out = '';
        }
        if ($friday_s != 1) {
            $friday_in = '';
            $friday_out = '';
        }
        if ($saturday_s != 1) {
            $saturday_in = '';
            $saturday_out = '';
        }
        if ($sunday_s != 1) {
            $sunday_in = '';
            $sunday_out = '';
        }
        $result = DB::connection('sqlsrv2')->update('update Roasters set RosterName=?,Mon=?,Tue=?,Wed=?,Thu=?,Fri=?,Sat=?,Sun=?,DeletedBy=? where CompanyID=? and RosterID=?', [$roster_name, $monday_in . '-' . $monday_out, $tuesday_in . '-' . $tuesday_out, $wednesday_in . '-' . $wednesday_out, $thursday_in . '-' . $thursday_out, $friday_in . '-' . $friday_out, $saturday_in . '-' . $saturday_out, $sunday_in . '-' . $sunday_out, username(), company_id(), $roster_id]);


        $update_date = long_date();
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Roaster Updated', 'Roaster ' . $roster_name . ' updated', $update_date]);

        if ($result) {
            $arr = DB::connection('sqlsrv2')->table('Roasters')->where('CompanyID', '=', company_id())->get();
            return request()->json(200, $arr);
        }
    }

    public function submit_holidays(Request $request)
    {
        $isRepeat = $request->isRepeat;
        $holiday_name = $request->h_holiday_name;
        $h_date_from = $request->h_date_from;
        $h_date_to = $request->h_date_to;
        $h_description = $request->h_description;

        $datetime1 = new \DateTime($h_date_from);
        $datetime2 = new \DateTime($h_date_to);
        $interval = $datetime1->diff($datetime2);
        // Get the number of days
        $days = $interval->days + 1;

        if (DB::connection('sqlsrv2')->table('Holiday')->where('HolidayName', '=', $holiday_name)->where('IsDeleted', '=', 0)->where('CompanyID', '=', company_id())->exists()) {
            return 'Holiday with same name already exist!';
        }

        $result = DB::connection('sqlsrv2')->table('Holiday')->insert([
            'CompanyID' => company_id(),
            'HolidayName' => $holiday_name,
            'holidaystartDate' => $h_date_from,
            'HolidayEndDate' => $h_date_to,
            'HolidayDescription' => $h_description,
            'NoOfDays' => $days,
            'CreatedBy' => username(),
            'CreatedOn' => long_date(),
            'isRepeat' => $isRepeat,
        ]);

        if ($result) {
            insertLog('Insert New Holiday', 'New holiday ' . $holiday_name . ' added');
            return 'Holiday added';
        }
    }

    public function holiday_detail()
    {

        $arr = DB::connection('sqlsrv2')->table("Holiday")->where('IsDeleted', '=', 0)->where('CompanyID', '=', company_id())->orderBy('HolidayID', 'desc')->paginate(5);
        return request()->json(200, $arr);
    }

    public function submit_l(Request $request)
    {
        $leave_type = $request->get('l_type');
        $isLimited = $request->get('isLimited');

        $isExist = DB::connection('sqlsrv2')->table("leaves")->where('LeaveType', '=', $leave_type)->where('CompanyID', '=', company_id())->exists();
        if ($isExist) {
            return 'Leave type \"' . $leave_type . '\" already exist!';
        }
        $result = DB::connection('sqlsrv2')
            ->table('leaves')
            ->insert([
                'CompanyID' => company_id(),
                'LeaveType' => $leave_type,
                'IsLimited' => $isLimited,
                'CreatedBy' => username(),
                'CreatedOn' => long_date(),
            ]);
        if ($result) {
            insertLog('Insert Leave Type', 'New leave type ' . $leave_type . ' added');
            return 'Leave added';
        }
    }

    public function view_leave_type()
    {
        return DB::connection('sqlsrv2')->table("leaves")->where('CompanyID', '=', company_id())->orderBy('LeaveID', 'desc')->paginate(5);
    }

    public function submit_fine(Request $request)
    {
        $emp_emp_id = $request->get('emp_emp_id');
        $emp_amount = $request->get('emp_amount');
        $emp_reason = $request->get('emp_reason');
        $update_date = date("Y-m-d");
        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;
        $sessionname = $find_session1->SessionName;
        if ($update_date < $e_date) {
            $result = DB::connection('sqlsrv2')->insert("INSERT INTO FineDetail(CompanyID,EmployeeID,FineSession,FineAmount,FineDate,Remarks,CreatedBy) values (?,?,?,?,?,?,?)", [company_id(), $emp_emp_id, $sessionname, $emp_amount, $update_date, $emp_reason, username()]);
        } else {
            $var = strtotime($update_date);
            $effectiveDate = strtotime("+1 months", $var);
            $insSession = date("F-Y", $effectiveDate);
            $result = DB::connection('sqlsrv2')->insert("INSERT INTO FineDetail(CompanyID,EmployeeID,FineSession,FineAmount,FineDate,Remarks,CreatedBy,Status) values (?,?,?,?,?,?,?,?)", [company_id(), $emp_emp_id, $insSession, $emp_amount, $update_date, $emp_reason, username(), 'Unpaid']);
        }
        $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Register')->where('EmployeeID', '=', $emp_emp_id)->get();
        foreach ($full_name_arr as $full_name_arr1) {
        }
        $emp_code = $full_name_arr1->EmployeeCode;
        $update_date1 = long_date();
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Fine added', 'Fine of ' . $emp_code . ' added', $update_date1]);

        if ($result) {

            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('FineDetail', 'Emp_Profile.EmployeeID', '=', 'FineDetail.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('FineDetail.FineDate', 'desc')->select('Emp_Profile.Name', 'FineDetail.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('FineDetail.CompanyID', '=', company_id())->paginate(10);


            return request()->json(200, $arr);
        }
    }

    public function view_fine_detail()
    {


        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('FineDetail', 'Emp_Profile.EmployeeID', '=', 'FineDetail.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('FineDetail.FineDate', 'desc')->select('Emp_Profile.Name', 'FineDetail.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('FineDetail.CompanyID', '=', company_id())->paginate(10);

        return request()->json(200, $arr);
    }

    public function delete_fine($id)
    {

        $result = DB::connection('sqlsrv2')->table('FineDetail')->where('FineId', $id)->delete();
        if ($result) {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('FineDetail', 'Emp_Profile.EmployeeID', '=', 'FineDetail.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('FineDetail.FineDate', 'desc')->select('Emp_Profile.Name', 'FineDetail.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('FineDetail.CompanyID', '=', company_id())->paginate(10);

            return request()->json(200, $arr);
        }
    }

    public function delete_leave_type($id)
    {
        $update_date = long_date();
        $leave_name_arr = DB::connection('sqlsrv2')->table('leaves')->where('CompanyID', '=', company_id())->where('LeaveID', '=', $id)->get();
        foreach ($leave_name_arr as $leave_name_arr1) {
        }
        $leave_name = $leave_name_arr1->LeaveType;

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Delete Leave Type', 'Leave type ' . $leave_name . ' deleted', $update_date]);

        $result = DB::connection('sqlsrv2')->table('leaves')->where('LeaveID', $id)->delete();
        if ($result) {
            $arr = DB::connection('sqlsrv2')->table("leaves")->where('CompanyID', '=', company_id())->orderBy('LeaveID', 'desc')->paginate(5);
            return request()->json(200, $arr);
        }
    }

    public function delete_holiday($id)
    {
        $result = DB::connection('sqlsrv2')
            ->table('Holiday')
            ->where('HolidayID', $id)
            ->where('CompanyID', '=', company_id())
            ->update([
                'IsDeleted' => 1,
                'DeletedOn' => long_date(),
                'DeletedBy' => username()
            ]);

        if ($result) {
            $holiday_name_arr1 = DB::connection('sqlsrv2')->table('Holiday')->where('HolidayID', '=', $id)->where('CompanyID', '=', company_id())->first();
            insertLog('Delete Holiay', 'Holiday ' . $holiday_name_arr1->HolidayName . ' deleted');
            return 'Holiday deleted';
        }
    }

    public function getattendance_report9($department, $location, $designation, $start, $close)
    {
        if ($designation == 'All' && $department == 'All' && $location == 'All') {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID', '=', company_id())->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)->get();
            return request()->json(200, $arr);
        } else {
            if ($department == 'All') {
                $department = '';
            }
            if ($designation == 'All') {
                $designation = '';
            }
            if ($location == 'All') {
                $location = '';
            }

            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID', '=', company_id())->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)->where('Emp_Register.Department', 'like', '%' . $department . '%')->where('Emp_Register.Designation', 'like', '%' . $designation . '%')->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')->get();
            return request()->json(200, $arr);
        }
    }

    public function update_ind_att(Request $request)
    {
        $att_id = $request->get('att_id');
        $check_in = $request->get('check_in');
        $check_out = $request->get('check_out');


        $update_date = long_date();
        $arr = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('AttDataID', '=', $att_id)->get();
        foreach ($arr as $arr1) {
        }
        if ($check_in <= $arr1->OpeningTime) {
            $att_status = 'P';
        } elseif ($check_in > $arr1->OpeningTime) {
            $att_status = 'L';
        }

        $result = DB::connection('sqlsrv2')->update('update AttData set CheckIN=?,CheckOut=?,AttStatus=?,UpdatedBy=? where AttDataID=?', [$check_in . ':00.0000000', $check_out . ':00.0000000', $att_status, username(), $att_id]);
        $message = "submitted";


        $emp_id_arr = DB::connection('sqlsrv2')->table('AttData')->select('EmpID')->where('CompanyID', '=', company_id())->where('AttDataID', '=', $att_id)->get();
        foreach ($emp_id_arr as $emp_id_arr1) {
        }
        $emp_id = $emp_id_arr1->EmpID;
        $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $emp_id)->get();
        foreach ($full_name_arr as $full_name_arr1) {
        }
        $full_name = $full_name_arr1->Name;
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Attendace Updated', 'Attendace of ' . $full_name . ' updated', $update_date]);

        return request()->json(200, $message);
    }

    public function get_count_leave()
    {

        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;
        $sick = DB::connection('sqlsrv2')->table('leave_Requisition')->where('CompanyID', '=', company_id())->where('Leavetype', '=', 'Sick')->where('StartDate', '>=', $s_date)->where('StartDate', '<=', $e_date)->count();
        $casual = DB::connection('sqlsrv2')->table('leave_Requisition')->where('CompanyID', '=', company_id())->where('Leavetype', '=', 'Casual')->where('StartDate', '>=', $s_date)->where('StartDate', '<=', $e_date)->count();
        $annual = DB::connection('sqlsrv2')->table('leave_Requisition')->where('CompanyID', '=', company_id())->where('Leavetype', '=', 'Annual')->where('StartDate', '>=', $s_date)->where('StartDate', '<=', $e_date)->count();

        $myJSON = array(
            '0' => $sick,
            '1' => $casual,
            '2' => $annual,
        );
        return request()->json(200, $myJSON);
    }

    public function get_payroll_att_detail()
    {

        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;


        $result = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC  [dbo].[Get_TotalReport]  N'" . $s_date . "', N'" . $e_date . "' ");

        //$result=DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC  [dbo].[Get_TotalReport]' 2022-05-21','2022-06-20'");

        return request()->json(200, $result);
    }

    public function get_count_dailyatt()
    {


        $update_date = date("Y-m-d");


        $total = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '=', $update_date)->count();
        $present = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '=', $update_date)->where('AttStatus', '=', 'P')->count();
        $absent = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '=', $update_date)->where('AttStatus', '=', 'A')->count();
        $late = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '=', $update_date)->where('AttStatus', '=', 'L')->count();

        $myJSON = array(
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
        );
        return request()->json(200, $myJSON);
    }

    public function count_hiring_d()
    {


        $year = date("Y");
        //$count=DB::connection('sqlsrv2')->select("SELECT   COUNT(*) as num FROM      Emp_Register WHERE     YEAR(JoiningDate) = '2022' GROUP BY  MONTH(JoiningDate)");
        $jan = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-01-%')->count();
        $feb = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-02-%')->count();
        $mar = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-03-%')->count();
        $april = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-04-%')->count();
        $may = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-05-%')->count();
        $june = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-06-%')->count();
        $july = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-07-%')->count();
        $aug = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-08-%')->count();
        $sept = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-09-%')->count();
        $oct = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-10-%')->count();
        $nov = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-11-%')->count();
        $dec = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('JoiningDate', 'like', $year . '-12-%')->count();
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

    public function count_resign_d()
    {


        $year = date("Y");
        //$count=DB::connection('sqlsrv2')->select("SELECT   COUNT(*) as num FROM      Emp_Register WHERE     YEAR(ResignDate) = '2022' GROUP BY  MONTH(JoiningDate)");
        $jan = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-01-%')->count();
        $feb = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-02-%')->count();
        $mar = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-03-%')->count();
        $april = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-04-%')->count();
        $may = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-05-%')->count();
        $june = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-06-%')->count();
        $july = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-07-%')->count();
        $aug = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-08-%')->count();
        $sept = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-09-%')->count();
        $oct = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-10-%')->count();
        $nov = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-11-%')->count();
        $dec = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('ResignDate', 'like', $year . '-12-%')->count();
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
    public function count_firing_d()
    {


        $year = date("Y");
        //$count=DB::connection('sqlsrv2')->select("SELECT   COUNT(*) as num FROM      Emp_Register WHERE     YEAR(TerminateDate) = '2022' GROUP BY  MONTH(JoiningDate)");
        $jan = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-01-%')->count();
        $feb = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-02-%')->count();
        $mar = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-03-%')->count();
        $april = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-04-%')->count();
        $may = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-05-%')->count();
        $june = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-06-%')->count();
        $july = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-07-%')->count();
        $aug = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-08-%')->count();
        $sept = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-09-%')->count();
        $oct = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-10-%')->count();
        $nov = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-11-%')->count();
        $dec = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('TerminateDate', 'like', $year . '-12-%')->count();
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

    public function CompanyWise_EmpAge()
    {
        $ageGroups = DB::connection('sqlsrv2')
            ->table(DB::raw("(SELECT
            CASE
                WHEN DATEDIFF(YEAR, Emp_Profile.DOB, GETDATE()) BETWEEN 0 AND 20 THEN '0-20'
                WHEN DATEDIFF(YEAR, Emp_Profile.DOB, GETDATE()) BETWEEN 21 AND 30 THEN '21-30'
                WHEN DATEDIFF(YEAR, Emp_Profile.DOB, GETDATE()) BETWEEN 31 AND 40 THEN '31-40'
                WHEN DATEDIFF(YEAR, Emp_Profile.DOB, GETDATE()) BETWEEN 41 AND 50 THEN '41-50'
                ELSE '51+'
            END AS AgeGroup
        FROM Emp_Profile) AS age_subquery"))
            ->selectRaw("AgeGroup, COUNT(*) AS EmployeeCount")
            ->groupBy('AgeGroup')
            // ->orderByRaw("MIN(DATEDIFF(YEAR, DOB, GETDATE()))")
            ->get();


        return response()->json($ageGroups);
    }

    public function overall_cities()
    {
        $company = DB::connection('sqlsrv2')->table('cities')->get();
        return request()->json(200, $company);
    }


    public function cnt_tl_emp()
    {

        $emp_detail = DB::connection('sqlsrv2')
            ->table('Emp_Register')
            ->where('CompanyID', '=', company_id())
            ->orderBy('EmployeeID', 'ASC')
            ->get();
        $ct_emp_detail = Count($emp_detail);
        return response()->json($ct_emp_detail);
    }

    //Get my Attendace
    public function all_attendence()
    {

        $attandance = DB::connection('sqlsrv2')->table('AttData')
            ->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $attandance);
    }

    //Count current month attendence details
    public function Attendance_count($startDate, $endDate)
    {
        $commonQuery = DB::connection('sqlsrv2')->table('AttData')
            ->where('CompanyID', '=', company_id())
            ->where('EmpID', '=', employee_id())
            ->where('ATTDate', '>=', $startDate)
            ->where('ATTDate', '<=', $endDate);

        $l_ct = clone $commonQuery;
        $le_ct = clone $commonQuery;
        $p_ct = clone $commonQuery;
        $h_ct = clone $commonQuery;
        $a_ct = clone $commonQuery;
        $t_dys = clone $commonQuery;

        $l_ct = $l_ct->where('AttStatus', '=', 'L')->count();
        $le_ct = $le_ct->where('AttStatus', '=', 'LE')->count();
        $p_ct = $p_ct->where('AttStatus', '=', 'P')->count();
        $h_ct = $h_ct->where('AttStatus', '=', 'H')->count();
        $a_ct = $a_ct->where('AttStatus', '=', 'A')->count();
        $t_dys = $t_dys->count();

        $att_ct_arr = array(
            'totalDays' => $t_dys,
            'present' => $p_ct + $l_ct,
            'holiday' => $h_ct,
            'absent' => $a_ct,
            'late' => $l_ct,
            'leave' => $le_ct,
            'today_status' => $le_ct,
            'today_checkin' => $le_ct,
            'today_checkout' => $le_ct,
        );

        return request()->json(200, $att_ct_arr);
    }

    //Get leaves details
    public function m_lv_dtl($type)
    {
        $year = date("Y") - ($type == 'Annual' ? 1 : 0);
        $this_m_lvs = DB::connection('sqlsrv2')
            ->table('leave_Requisition')
            ->where('EmployeeID', employee_id())
            ->where('StartDate', '>=', "$year-01-01")
            ->where('CompanyID', company_id());
        if ($type == 'Other') {
            $this_m_lvs->whereNotIn('Leavetype', ['Annual', 'Sick', 'Casual']);
        } else {
            $this_m_lvs->where('Leavetype', $type);
        }
        $this_m_lvs = $this_m_lvs->get();
        return response()->json($this_m_lvs, 200);
    }


    public function currency_detail()
    {
        $currencyDetails = DB::connection('sqlsrv2')->table('currencies')->get();

        return response()->json($currencyDetails);
    }

    //View logged-in employee detail
    public function view_profile()
    {

        $emp_id = employee_id();


        $this_emp = DB::connection('sqlsrv2')->table('Emp_Register')
            ->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')
            ->join('Employee_Qualification', 'Emp_Profile.EmployeeID', '=', 'Employee_Qualification.EmployeeID')
            ->orderBy('Emp_Register.EmployeeID')
            ->select('Emp_Register.*', 'Emp_Profile.*', 'Employee_Qualification.*')
            ->where('Emp_Register.CompanyID', '=', company_id())
            ->where('Emp_Register.EmployeeID', '=', $emp_id)
            ->where('Employee_Qualification.EmployeeID', '=', $emp_id)
            ->get();
        return request()->json(200, $this_emp);
    }

    //View logged-in employee qualification
    public function view_profile_qual()
    {

        $emp_id = employee_id();

        $this_emp_qual = DB::connection('sqlsrv2')->table('Employee_Qualification')
            ->select('Employee_Qualification.*')
            ->where('CompanyID', '=', company_id())
            ->where('EmployeeID', '=', $emp_id)->get();
        return request()->json(200, $this_emp_qual);
    }

    //Get all team of logged in employee
    public function att_ind_team()
    {
        $company_id = Session::get('company_id');
        $emp_code = Session::get('employee_id');
        $name = '';
        $arr1 = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC   [dbo].[Get_reporting_tree]
  @id = N'" . $emp_code . "',
  @companyid = N'" . $company_id . "'
");
        $arr = DB::connection('sqlsrv2')->table('Att_Permission')->join('Emp_Register', 'Att_Permission.SubEmpID', '=', 'Emp_Register.EmployeeID')->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->select('Emp_Profile.*', 'Emp_Register.*')->orderBy('Emp_Profile.Name', 'asc')->where('Att_Permission.CompanyID', '=', $company_id)->where('Att_Permission.ChiefEmpID', '=', $emp_code)->where('Att_Permission.IsMandatory', '=', 1)->get();
        $arr2 = json_decode($arr, TRUE);
        $team = array_merge($arr1, $arr2);
        return request()->json(200, $team);
    }

    public function all_ind_team()
    {
        $company_id = Session::get('company_id');
        $emp_code = Session::get('employee_id');
        $name = '';
        $arr1 = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC   [dbo].[Get_reporting_tree]
  @id = N'" . $emp_code . "',
  @companyid = N'" . $company_id . "'
");
        $arr = DB::connection('sqlsrv2')->table('Att_Permission')->join('Emp_Register', 'Att_Permission.SubEmpID', '=', 'Emp_Register.EmployeeID')->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->select('Emp_Profile.*', 'Emp_Register.*')->orderBy('Emp_Profile.Name', 'asc')->where('Att_Permission.CompanyID', '=', $company_id)->where('Att_Permission.ChiefEmpID', '=', $emp_code)->where('Att_Permission.IsMandatory', '=', 1)->get();
        $arr2 = json_decode($arr, TRUE);
        $team = array_merge($arr1, $arr2);
        return request()->json(200, $team);
    }

    public function team_all_leaves()
    {

        $EmployeeID = employee_id();

        $team_leaves = DB::connection('sqlsrv2')->table('leave_Requisition')
            ->join('Emp_Profile', 'leave_Requisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('leave_Requisition.EmployeeID', 'asc')
            ->select('leave_Requisition.*', 'Emp_Profile.*', 'Emp_Register.*')
            ->where('leave_Requisition.CompanyID', '=', company_id())
            ->where('Emp_Register.ReportingTo', '=', $EmployeeID)
            ->orwhere('Emp_Register.ReportingTo2', '=', $EmployeeID)->where('leave_Requisition.CompanyID', '=', company_id())->get();
        return request()->json(200, $team_leaves);
    }


    //Mark team attandence
    public function mark_team_att(Request $request)
    {
        $date = $request->get('date');
        $cin = $request->get('cin');
        $cout = $request->get('cout');
        $emp_id = $request->get('cId');
        $AttStatus = $request->get('att_sts');

        $arr = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())
            ->where('ATTDate', '=', $date)->where('EmpID', '=', $emp_id)->get();
        foreach ($arr as $arr1) {
        }

        if ($cin < $arr1->OpeningTime && $cout > $arr1->ClosingTime) {
            $AttStatus = 'P';
        } elseif ($cin > $arr1->OpeningTime || $cout < $arr1->ClosingTime) {
            $AttStatus = 'L';
        }

        DB::connection('sqlsrv2')->update('update AttData set CheckIN=?, CheckOut=?, UpdatedBy=?, AttStatus=? where EmpID=? AND ATTDate=? AND CompanyID=?', [$cin . ':00.0000000', $cout . ':00.0000000', username(), $AttStatus, $emp_id, $date, company_id()]);

        $data = "Attendance marked";
        return request()->json(200, $data);
    }

    //view individule att detail
    public function ind_att_detail($id)
    {

        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;

        $job = DB::connection('sqlsrv2')->table('AttData')
            ->where('CompanyID', '=', company_id())
            ->where('ATTDate', '<=', $e_date)
            ->where('ATTDate', '>=', $s_date)
            ->where('EmpID', '=', $id)
            ->orderBy('ATTDate', 'desc')
            ->get();
        return request()->json(200, $job);
    }

    //fetch Attandence to edit
    public function fetch_att($id, $date)
    {

        $cand = DB::connection('sqlsrv2')->table('AttData')
            ->select('AttDataID', 'CompanyID', 'ATTDate', 'CheckIN', 'CheckOut', 'AttStatus')
            ->where('AttData.CompanyID', '=', company_id())->where('AttData.EmpID', '=', $id)->where('AttData.ATTDate', '=', $date)->get();
        return request()->json(200, $cand);
    }


    //Update attandence
    public function update_attandence(Request $request)
    {

        $Aid = $request->get('Aid');
        $cin = $request->get('cin');
        $cout = $request->get('cout');
        $AttStatus = $request->get('att_sts');
        $date = $request->get('date');
        $CheckoutBy = $request->get('CheckoutBy');

        if ($AttStatus == "A") {
            $cin = NULL;
            $cout = NULL;
        } else {
            $arr = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())
                ->where('ATTDate', '=', $date)->where('EmpID', '=', $Aid)->get();
            foreach ($arr as $arr1) {
            }

            if ($cin <= $arr1->OpeningTime && $cout >= $arr1->ClosingTime) {
                $AttStatus = 'P';
            } elseif ($cin > $arr1->OpeningTime || $cout < $arr1->ClosingTime) {
                $AttStatus = 'L';
            }
        }
        DB::connection('sqlsrv2')->update('update AttData set CheckIN=?, CheckOutBy=?, CheckOut=?, AttStatus=?  where EmpID=? AND ATTDate=? AND CompanyID=?', [$cin, $CheckoutBy, $cout, $AttStatus, $Aid, $date, company_id()]);

        // DB::connection('sqlsrv2')->update('update AttData set CheckIN=?, CheckOut=?, AttStatus=? where EmpID=? AND ATTDate=? AND CompanyID=?', [$cin . ':00.0000000', $cout . ':00.0000000', $AttStatus, $Aid, $date, company_id()]);
        $data = "Attendance updated Successfully!";
        return request()->json(200, $data);
    }

    //view individule name
    public function ind_name($id)
    {

        $name = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->select('Name')
            ->where('CompanyID', '=', company_id())
            ->where('EmployeeID', '=', $id)
            ->get();
        foreach ($name as $name1) {
        }
        $name = $name1->Name;
        return request()->json(200, $name);
    }

    public function view_hr_configuration()
    {

        $cand = DB::connection('sqlsrv2')->table('HrCompanyConfig')->where('CompanyID', '=', company_id())->get();
        return request()->json(200, $cand);
    }

    public function submit_config(Request $request)
    {


        $update_date = long_date();
        $gratuty_start = $request->get('gratuty_start');
        $max_loan = $request->get('max_loan');
        $days_deduction = $request->get('days_deduction');
        $max_installment = $request->get('max_installment');
        $annual_leaves = $request->get('annual_leaves');
        $sick_leaves = $request->get('sick_leaves');
        $casual_start = $request->get('casual_start');

        DB::connection('sqlsrv2')->update('update HrCompanyConfig set GratutyStart=?, MaxLoan=?,AnnualLeaves=?,SickLeaves=?,CasualLeaves=?,MinutesDeduction=?,MaxInstallment=? where CompanyID=?', [$gratuty_start, $max_loan, $annual_leaves, $sick_leaves, $casual_start, $days_deduction, $max_installment, company_id()]);


        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'HR configuration Update', 'HR configuration  updated', $update_date]);

        $data = "udpaded!";
        return request()->json(200, $data);
    }

    public function overall_payroll_employees()
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollEmployeesDetail', 'Emp_Profile.EmployeeID', '=', 'PayrollEmployeesDetail.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollEmployeesDetail.EmployeeID', 'desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollEmployeesDetail.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('PayrollEmployeesDetail.CompanyID', '=', company_id())->where('PayrollEmployeesDetail.Statusd', '=', 'C')->paginate(20);
        return request()->json(200, $arr);
    }

    public function fetch_emp_detail($id)
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollEmployeesDetail', 'Emp_Profile.EmployeeID', '=', 'PayrollEmployeesDetail.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollEmployeesDetail.EmployeeID', 'desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollEmployeesDetail.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('PayrollEmployeesDetail.CompanyID', '=', company_id())->where('PayrollEmployeesDetail.Statusd', '=', 'C')->where('PayrollEmployeesDetail.EmployeeID', '=', $id)->get();
        return request()->json(200, $arr);
    }

    public function submit_payroll_detail(Request $request)
    {
        $p_emp_id = $request->get('p_emp_id');
        $p_last_salary = $request->get('p_last_salary');
        $p_current_salary = intval($request->get('p_current_salary'));
        $p_current_day = intval($request->get('p_current_day'));
        $p_current_hour = intval($request->get('p_current_hour'));
        $p_current_remarks = $request->get('p_current_remarks');

        $current_increment = $p_current_salary - $p_last_salary;

        $update_date = date("Y-m-d");

        DB::connection('sqlsrv2')->update('update PayrollEmployeesDetail set Statusd=? where CompanyID=? and EmployeeID=? and Statusd=?', ['O', company_id(), $p_emp_id, 'C']);

        $result = DB::connection('sqlsrv2')->insert('INSERT INTO PayrollEmployeesDetail(CompanyID,EmployeeID,UpdatedSalary,UpdatedPerDay,UpdatedPerHours,UpdatedDate,Statusd,Remarks,UpdatedBy,UpdatedOn,LastIncrement) values (?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $p_emp_id, $p_current_salary, $p_current_day, $p_current_hour, $update_date, 'C', $p_current_remarks, username(), $update_date, $current_increment]);

        if ($result) {
            DB::connection('sqlsrv2')->update('update Emp_Register set Salary=? where CompanyID=? and EmployeeID=?', [$p_current_salary, company_id(), $p_emp_id]);


            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollEmployeesDetail', 'Emp_Profile.EmployeeID', '=', 'PayrollEmployeesDetail.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollEmployeesDetail.EmployeeID', 'desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollEmployeesDetail.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('PayrollEmployeesDetail.CompanyID', '=', company_id())->where('PayrollEmployeesDetail.Statusd', '=', 'C')->paginate(20);
            return request()->json(200, $arr);
        }
    }

    public function filter_employees($emp_id, $department, $location, $designation)
    {
        $query = DB::connection('sqlsrv2')
            ->table('Emp_Profile')
            ->join('PayrollEmployeesDetail', 'Emp_Profile.EmployeeID', '=', 'PayrollEmployeesDetail.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('PayrollEmployeesDetail.EmployeeID', 'desc')
            ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollEmployeesDetail.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
            ->where('PayrollEmployeesDetail.CompanyID', '=', company_id())
            ->where('PayrollEmployeesDetail.Statusd', '=', 'C')
            ->where('Emp_Register.Status', '!=', 'Resigned')
            ->where('Emp_Register.Status', '!=', 'Terminated');

        if ($department !== 'All') {
            $query->where('Emp_Register.Department', 'like', '%' . $department . '%');
        }

        if ($designation !== 'All') {
            $query->where('Emp_Register.Designation', 'like', '%' . $designation . '%');
        }

        if ($location !== 'All') {
            $query->where('Emp_Register.PostingCity', 'like', '%' . $location . '%');
        }

        if ($emp_id !== 'All') {
            $query->where('PayrollEmployeesDetail.EmployeeID', '=', $emp_id);
        }

        $arr = $query->paginate(20);
        return request()->json(200, $arr);
    }

    public function update_payroll_status($id)
    {
        $session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('SessionID', '=', $id)->first();

        $newSdate = date('Y-m-d', strtotime($session->StartDate . ' + 1 months'));
        $newEdate = date('Y-m-d', strtotime($session->EndDate . ' + 1 months'));
        $year = date('Y', strtotime($newSdate));
        $month = date('F', strtotime($newEdate));

        DB::connection('sqlsrv2')->table('HrSessions')
            ->where('SessionID', $id)
            ->where('CompanyID', company_id())
            ->update([
                'AttClosedPayrollStart' => 'Closed',
                'CurrentSession' => 0,
                'DistState' => 1,
            ]);

        $nextSession = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('SessionName', '=', $month . '-' . $year)->exists();
        if (!$nextSession) {
            DB::connection('sqlsrv2')->table('HrSessions')->insert([
                'SessionName' => $month . '-' . $year,
                'StartDate' => $newSdate,
                'EndDate' => $newEdate,
                'CreateBy' => username(),
                'CreateOn' => long_date(),
                'CompanyID' => company_id(),
                'AttClosedPayrollStart' => 'Open',
                'DistState' => 0,
                'CurrentSession' => 1,
            ]);
        }

        $results = DB::connection('sqlsrv2')
            ->select(
                'EXEC [dbo].[Get_TotalReport_Session] @session = ?, @startdate = ?, @enddate = ?',
                [$session->SessionName, $session->StartDate, $session->EndDate]
            );

        $insertData = collect($results)->map(function ($result) {
            return [
                'CompanyID' => $result->CompanyID,
                'EmployeeID' => $result->EmployeeID,
                'EmployeeCode' => $result->Employee_Code,
                'Name' => $result->Name,
                'Designation' => $result->Designation,
                'Department' => $result->Department,
                'Totaldays' => $result->TotalDays,
                'TotalPeresnt' => $result->TotalPresent,
                'TotalAbsent' => $result->TotalAbsent,
                'TotalLeave' => $result->TotalLeave,
                'GracePeriod' => $result->GP,
                'OverTime' => $result->OT,
                'Deduction' => $result->GPDeduction,
                'Salary' => $result->Salary,
                'SessionName' => $result->SessionName,
                'OAmount' => $result->OAmount,
                'DAmount' => $result->DAmount,
                'TAmount' => $result->TPayable,
                'loanAmount' => $result->loanAmount,
                'advanceAmount' => $result->advanceAmount,
                'DStatus' => 'P',
            ];
        })->toArray();

        $batchSize = 80;
        if (!empty($insertData)) {
            foreach (array_chunk($insertData, $batchSize) as $chunk) {
                DB::connection('sqlsrv2')->table('SessionReport')->insert($chunk);
            }
        }
        insertLog('Session Closed', 'Session of ' . $session->SessionName . ' has been closed');
        $message = 'session closed';
        return request()->json(200, $message);
    }

    public function getpayroll_gen_report($emp_id, $department, $designation, $status)
    {
        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->where('AttClosedPayrollStart', '=', 'Closed')->get();
        foreach ($find_session_closed as $find_session1) {
        }
        $sesson_name = $find_session1->SessionName;

        if ($emp_id == 'All' && $department == 'All' && $designation == 'All') {
            $result = DB::connection('sqlsrv2')->table('SessionReport')->where('CompanyID', '=', company_id())->where('SessionName', '=', $sesson_name)->where('IsDeleted', 0)->orderBy('Department', 'ASC')->get();
            return request()->json(200, $result);
        } else {
            if ($emp_id == 'All') {
                $emp_id = '';
            }
            if ($department == 'All') {
                $department = '';
            }
            if ($designation == 'All') {
                $department = '';
            }
            if ($status == 'All') {
                $status = '';
            }


            $result = DB::connection('sqlsrv2')->table('SessionReport')->where('CompanyID', '=', company_id())->where('SessionName', '=', $sesson_name)->where('EmployeeID', 'LIKE', '%' . $emp_id . '%')->where('Department', 'LIKE', '%' . $department . '%')->where('Designation', 'LIKE', '%' . $designation . '%')->where('DStatus', 'LIKE', '%' . $status . '%')->where('IsDeleted', 0)->get();
            return request()->json(200, $result);
        }
    }

    public function search_payroll(Request $request)
    {
        return DB::connection('sqlsrv2')
            ->table('SessionReport')
            ->where('CompanyID', '=', company_id())
            ->where(function ($query) use ($request) {
                $query->where('Name', 'LIKE', '%' . $request->keyword1 . '%')
                    ->orWhere('EmployeeCode', 'LIKE', '%' . $request->keyword1 . '%');
            })
            ->where('IsDeleted', 0)
            ->orderBy('Department', 'ASC')
            ->paginate(15);
    }

    public function search_payroll_bonus(Request $request)
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollBonuses', 'Emp_Profile.EmployeeID', '=', 'PayrollBonuses.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollBonuses.BonusDate', 'desc')->select('Emp_Profile.Name', 'PayrollBonuses.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollBonuses.CompanyID', '=', company_id())->where('Emp_Profile.Name', 'LIKE', '%' . $request->keyword1 . '%')->orwhere('Emp_Register.EmployeeCode', 'LIKE', '%' . $request->keyword1 . '%')->paginate(15);
        return request()->json(200, $arr);
    }

    public function search_EmpFuelAllowance(Request $request)
    {
        $arr = DB::connection('sqlsrv2')
            ->table('Emp_FuelAllowance')
            ->join('Emp_Profile', 'Emp_FuelAllowance.EmployeeID', '=', 'Emp_Profile.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->select(
                'Emp_Profile.Name',
                'Emp_FuelAllowance.FuelQuantity',
                'Emp_FuelAllowance.EmployeeID',
                'Emp_FuelAllowance.FuelQuantity',
                'Emp_Register.EmployeeCode',
                'Emp_Register.Department',
                'Emp_Register.Designation',
                'Emp_Register.Salary',
                'Emp_FuelAllowance.FuelType'
            )
            ->where('Emp_FuelAllowance.CompanyID', '=', company_id())
            ->where('Emp_FuelAllowance.isDeleted', '!=', '1')
            ->where(function ($query) use ($request) {
                $query->where('Emp_Profile.Name', 'LIKE', '%' . $request->keyword1 . '%')
                    ->orWhere('Emp_Register.EmployeeCode', 'LIKE', '%' . $request->keyword1 . '%');
            })
            ->orderBy('Emp_FuelAllowance.CreatedOn', 'desc')
            ->paginate(15);

        return response()->json($arr, 200);
    }

    public function find_session()
    {

        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session_closed as $find_session1) {
        }
        $sesson_name = $find_session1->SessionName;
        return request()->json(200, $sesson_name);
    }

    public function session_pre_dis()
    { //session who's salary is proceeding in payroll

        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->get();
        foreach ($find_session_closed as $find_session1) {
        }
        $sesson_name = $find_session1->SessionName;

        return request()->json(200, $sesson_name);
    }

    public function session_not_in_dist()
    { //session who's salary is not in distribution

        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->get();
        foreach ($find_session_closed as $find_session1) {
            $find_sessions = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('SessionName', '=', $find_session1->SessionName)->where('CompanyID', '=', company_id())->exists();
            if (!$find_sessions) {
                return request()->json(200, $find_session1->SessionName);
            }
        }
    }

    public function find_payroll_emp($id)
    {

        $find_payroll_e = DB::connection('sqlsrv2')->table('SessionReport')
            ->where('IsDeleted', 0)
            ->where('CompanyID', '=', company_id())
            ->where('SessionReportID', '=', $id)->get();
        return request()->json(200, $find_payroll_e);
    }

    public function update_payroll_ind_status(Request $request)
    {


        $m_session_reportID = $request->get('m_session_reportID');
        $m_deduction = $request->get('m_deduction');
        $m_overtime = $request->get('m_overtime');
        $m_salary_status = $request->get('m_salary_status');


        $find_salary1 = DB::connection('sqlsrv2')->table('SessionReport')->where('CompanyID', '=', company_id())->where('SessionReportID', '=', $m_session_reportID)->where('IsDeleted', 0)->first();
        $m_salary = $find_salary1->Salary;
        $t_amount = $find_salary1->TAmount;
        $damount = round($m_deduction * ($m_salary / 30));
        $perday = $m_salary / 30;
        $perhour = $perday / 8;
        $permint = $perhour / 60;
        $oamount = round($m_overtime * $permint);

        //$tpayable=round($t_amount+$oamount-$damount);


        //$result=DB::connection('sqlsrv2')->update('update SessionReport set Deduction=?,OverTime=?,OAmount=?, DAmount=?, TAmount=?, UpdatedBy=?, DStatus=? where SessionReportID=? and CompanyID=?',[$m_deduction,$m_overtime,$oamount,$damount,$tpayable,username(),$m_salary_status,$m_session_reportID, company_id()]);
        $result = DB::connection('sqlsrv2')->update('update SessionReport set Deduction=?,OverTime=?,OAmount=?,DAmount=?,UpdatedBy=?,DStatus=?  where SessionReportID=? and CompanyID=?', [$m_deduction, $m_overtime, $oamount, $damount, username(), $m_salary_status, $m_session_reportID, company_id()]);
        if ($result) {
            $find_pre_sa1 = DB::connection('sqlsrv2')->table('SessionReport')->where('CompanyID', '=', company_id())->where('SessionReportID', '=', $m_session_reportID)->where('IsDeleted', 0)->first();
            $TAmount = ($find_pre_sa1->Salary - $find_pre_sa1->DAmount) + $find_pre_sa1->OAmount;
            $result2 = DB::connection('sqlsrv2')->update('update SessionReport set TAmount=?  where SessionReportID=? and CompanyID=?', [$TAmount, $m_session_reportID, company_id()]);
        }

        $find_session1 = DB::connection('sqlsrv2')->table('HrSessions')->select('SessionName')->where('CompanyID', '=', company_id())->orderBy('SessionID', 'desc')->where('AttClosedPayrollStart', '=', 'Closed')->first();
        $sesson_name = $find_session1->SessionName;

        $result1 = DB::connection('sqlsrv2')->table('SessionReport')->where('CompanyID', '=', company_id())->where('SessionName', '=', $sesson_name)->where('IsDeleted', 0)->orderBy('Department', 'ASC')->get();

        return request()->json(200, $result1);
    }

    public function proceedhrapproval()
    {
        $find_sessions = DB::connection('sqlsrv2')->table('SessionReport')->select('SessionName')->where('DStatus', '=', 'P')->groupBy('SessionName')->where('CompanyID', '=', company_id())->where('IsDeleted', 0)->get();

        foreach ($find_sessions as $find_session1) {
            DB::connection('sqlsrv2')->table('PayrollHrApproval')->insertUsing(
                ['EmployeeID', 'CompanyID', 'SessionName', 'OverTime', 'Deduction', 'Salary', 'OAmount', 'DAmount', 'TAmount', 'DStatus', 'HrStatus'],
                function ($query) use ($find_session1) {
                    $query->select([
                        'EmployeeID',
                        'CompanyID',
                        'SessionName',
                        'OverTime',
                        'Deduction',
                        'Salary',
                        'OAmount',
                        'DAmount',
                        'TAmount',
                        DB::raw("'P' as DStatus"),
                        DB::raw("'P' as HrStatus"),
                    ])
                        ->from('SessionReport')
                        ->where('CompanyID', company_id())
                        ->where('DStatus', 'P')
                        ->where('IsDeleted', 0)
                        ->where('SessionName', $find_session1->SessionName);
                }
            );
        }
        foreach ($find_sessions as $find_session1) {
            DB::connection('sqlsrv2')->table('SessionReport')
                ->where('CompanyID', company_id())
                ->where('DStatus', 'P')
                ->where('IsDeleted', 0)
                ->where('SessionName', $find_session1->SessionName)
                ->update([
                    'IsDeleted' => 1,
                ]);
            insertLog('Salaries moved', 'Salaries of session ' . $find_session1->SessionName . ' moved for HR Manager approval');
        }
        return "Salaries proceded";
    }

    public function search_hr_approval(Request $request)
    {
        return DB::connection('sqlsrv2')
            ->table('Emp_Profile')
            ->join('PayrollHrApproval', 'Emp_Profile.EmployeeID', '=', 'PayrollHrApproval.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('Emp_Register.Department', 'Desc')
            ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollHrApproval.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
            ->where("PayrollHrApproval.isDeleted", '=', '0')
            ->where('PayrollHrApproval.CompanyID', '=', company_id())
            ->Where(function ($query) use ($request) {
                $query->where('Name', 'LIKE', '%' . $request->keyword1 . '%')
                    ->orWhere('EmployeeCode', 'LIKE', '%' . $request->keyword1 . '%');
            })
            ->paginate(15);
    }

    public function find_payroll_emp_hrapproval($id)
    {
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollHrApproval', 'Emp_Profile.EmployeeID', '=', 'PayrollHrApproval.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('Emp_Register.Department', 'Desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollHrApproval.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where("PayrollHrApproval.isDeleted", '=', '0')->where('PayrollHrApproval.CompanyID', '=', company_id())->where('PayrollHrApproval.ApprovalID', '=', $id)->get();

        return request()->json(200, $arr);
    }

    public function proceedfinanceapproval()
    {
        $sessions = DB::connection('sqlsrv2')->table("PayrollHrApproval")->where("HrStatus", '=', 'P')->where("isDeleted", '=', '0')->where("CompanyID", '=', company_id())->groupBy('SessionName')->pluck('SessionName');
        //$sessionBatches = array_chunk($sessions->toArray(), 500);
        $flatSessions = array_merge($sessions->toArray());
        $baseQuery = DB::connection('sqlsrv2')
            ->table('PayrollHrApproval')
            ->where("isDeleted", '=', '0')
            ->where('HrStatus', 'P')
            ->whereIn('SessionName', $flatSessions)
            ->where('CompanyID', company_id());
        $data = $baseQuery->select([
            'EmployeeID',
            'CompanyID',
            'SessionName',
            'Salary',
            'OAmount',
            DB::raw('CAST(DAmount AS INT) as DAmount'),
            'TAmount',
            DB::raw("'' as InstallmentNo"),
            DB::raw("0 as InstallmentAmount"),
            DB::raw("PayrollHrApproval.TAmount as PayableSalary"),
            'DStatus',
            DB::raw("'P' as FStatus")
        ])->get()->toArray();

        $insertData = array_map('get_object_vars', $data);

        if (!empty($insertData)) {
            $batchSize = 100; // Set the desired batch size
            $insertChunks = array_chunk($insertData, $batchSize);

            foreach ($insertChunks as $chunk) {
                DB::connection('sqlsrv2')
                    ->table('PayrollFinanceApproval')
                    ->insert($chunk);
            }
        }

        $baseQuery->update(['isDeleted' => 1]);
        foreach ($sessions as $sessions1) {
            insertLog('Salaries moved', 'Salaries of session ' . $sessions1 . ' proceeded for Finance approval');
        }
        return request()->json(200, "submitted");
    }

    //
    public function loan_report($id)
    {
        $update_date = date("Y-m-d");
        $result2 = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->exists();
        if ($result2) {
            $result = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->get();
            $check = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->exists();

            $this->fpdf->AddPage("P", ['250', '227']);
            $this->fpdf->SetFont('Times', 'B', 22);
            $this->fpdf->SetTextColor(41, 46, 46);
            $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
            foreach ($fetch_image as $fetch_image1) {
            }


            $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
            $this->fpdf->Text(75, 17, 'Loan Installment Plan');

            $this->fpdf->SetFont('Times', '', 14);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 170, 7, 43, 15);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->ln(20);
            foreach ($result as $result1) {
            }
            $get_req = DB::connection('sqlsrv2')->table("Emp_Profile")->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Emp_Profile.EmployeeID', '=', $result1->EmployeeID)->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode', 'Emp_Register.Designation', 'Emp_Register.Department')->get();
            foreach ($get_req as $get_req1) {
            }
            $this->fpdf->Cell(35, 6, 'Employee Code:', 0, 0, 'R', 0);
            $this->fpdf->Cell(100, 6, $get_req1->EmployeeCode, 0, 0, 'L', 0);
            $this->fpdf->Cell(35, 6, 'Print Date:', 0, 0, 'R', 0);
            $this->fpdf->Cell(300, 6, $update_date, 0, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Name:', 0, 0, 'C', 0);
            $this->fpdf->Cell(100, 6, $get_req1->Name, 0, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Department:', 0, 0, 'R', 0);
            $this->fpdf->Cell(100, 6, $get_req1->Department, 0, 1, 'L', 0);
            $this->fpdf->Cell(30, 6, 'Designation:', 0, 0, 'R', 0);
            $this->fpdf->Cell(100, 6, $get_req1->Designation, 0, 1, 'L', 0);


            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', '', 12);
            // $this->fpdf->ln(40);
            $this->fpdf->Cell(60, 6, 'Installment No', 1, 0, 'C', 0);
            $this->fpdf->Cell(65, 6, 'Installment Session', 1, 0, 'C', 0);
            $this->fpdf->Cell(60, 6, 'Installment Amount', 1, 1, 'C', 0);

            $this->fpdf->SetFont('Times', '', 10);
            foreach ($result as $index => $result1) {
                $this->fpdf->Cell(60, 6, $result1->InstallmentNo == 0 ? $index + 1 : $result1->InstallmentNo, 1, 0, 'C', 0);
                $this->fpdf->Cell(65, 6, $result1->InstallmentSession, 1, 0, 'C', 0);
                $this->fpdf->Cell(60, 6, number_format($result1->InstallmentAmount), 1, 1, 'C', 0);
            }

            $this->fpdf->ln(10);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(30, 6, 'Prepared By', 0, 0, 'L', 0);
            $this->fpdf->Cell(85, 6, '________________', 0, 0, 'L', 0);

            $this->fpdf->Cell(35, 6, 'Director HR', 0, 0, 'R', 0);
            $this->fpdf->Cell(80, 6, '________________', 0, 0, 'L', 0);

            $this->fpdf->Output();
            exit;
        }
    }

    //
    public function chech_installments()
    {
        $sesson_name = hr_closed_session()->SessionName;
        //dd($sesson_name);
        $result = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->where('CompanyID', '=', company_id())->where('SessionName', '=', $sesson_name)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->get();
        foreach ($result as $result1) {
            $employee_id = $result1->EmployeeID;
            $ses_name = $result1->SessionName;
            $tpayable = $result1->TAmount;

            $find_inst = DB::connection('sqlsrv2')->table('LoanDetail')->where('CompanyID', '=', company_id())->where('InstallmentSession', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->where('LoanType', '=', 'Loan')->where('InstallmentStatus', '=', 'Unpaid')->exists();

            if ($find_inst) {
                $find_inst2 = DB::connection('sqlsrv2')->table('LoanDetail')->where('CompanyID', '=', company_id())->where('InstallmentStatus', '=', 'Unpaid')->where('LoanType', '=', 'Loan')->where('InstallmentSession', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->sum('InstallmentAmount');
                DB::connection('sqlsrv2')->update('update PayrollFinanceApproval set  InstallmentAmount=? where CompanyID=? and EmployeeID=? and SessionName=?', [$find_inst2, company_id(), $employee_id, $ses_name]);
                $find_inst3 = DB::connection('sqlsrv2')->table('LoanDetail')->where('CompanyID', '=', company_id())->where('InstallmentStatus', '=', 'Unpaid')->where('LoanType', '=', 'Loan')->where('InstallmentSession', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->get();
                foreach ($find_inst3 as $find_inst31) {
                    DB::connection('sqlsrv2')->update('update LoanDetail set InstallmentStatus=? where DetailId=?', ['Returned', $find_inst31->DetailId]);
                }
            }

            $find_adv = DB::connection('sqlsrv2')->table('LoanDetail')->where('CompanyID', '=', company_id())->where('InstallmentSession', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->where('LoanType', '=', 'Advance')->where('InstallmentStatus', '=', 'Unpaid')->exists();
            if ($find_adv) {
                $find_adv2 = DB::connection('sqlsrv2')->table('LoanDetail')->where('CompanyID', '=', company_id())->where('InstallmentStatus', '=', 'Unpaid')->where('LoanType', '=', 'Advance')->where('InstallmentSession', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->get();
                foreach ($find_adv2 as $find_adv21) {
                }

                DB::connection('sqlsrv2')->update('update PayrollFinanceApproval set  AdvanceAmount=? where CompanyID=? and EmployeeID=? and SessionName=? and IsDeleted=?', [$find_adv21->InstallmentAmount, company_id(), $employee_id, $ses_name, 0]);
                DB::connection('sqlsrv2')->update('update LoanDetail set InstallmentStatus=? where DetailId=?', ['Returned', $find_adv21->DetailId]);
            }
            $find_fine = DB::connection('sqlsrv2')->table('FineDetail')->where('CompanyID', '=', company_id())->where('FineSession', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->exists();

            if ($find_fine) {
                $find_fine9 = DB::connection('sqlsrv2')->table('FineDetail')->where('CompanyID', '=', company_id())->where('FineSession', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->sum('FineAmount');


                DB::connection('sqlsrv2')->update('update PayrollFinanceApproval set Fine=? where CompanyID=? and EmployeeID=? and SessionName=? and IsDeleted=?', [$find_fine9, company_id(), $employee_id, $ses_name, 0]);
            }

            $find_dues = DB::connection('sqlsrv2')->table('PayrollDues')->where('CompanyID', '=', company_id())->where('SessionName', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->where('Status', '=', 'Approved')->exists();

            if ($find_dues) {
                $find_dues9 = DB::connection('sqlsrv2')->table('PayrollDues')->where('CompanyID', '=', company_id())->where('SessionName', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->where('Status', '=', 'Approved')->sum('DuesAmount');

                DB::connection('sqlsrv2')->update('update PayrollFinanceApproval set DuesAmount=? where CompanyID=? and EmployeeID=? and SessionName=? and IsDeleted=?', [$find_dues9, company_id(), $employee_id, $ses_name, 0]);
            }


            $current_date = date("Y-m-d");


            $find_tax = DB::connection('sqlsrv2')->table('PayrollTax')->where('CompanyID', '=', company_id())->where('SessionEndDate', '<=', $current_date)->where('EmployeeID', '=', $employee_id)->exists();

            if ($find_tax) {
                $find_tax9 = DB::connection('sqlsrv2')->table('PayrollTax')->where('CompanyID', '=', company_id())->where('SessionEndDate', '<=', $current_date)->where('EmployeeID', '=', $employee_id)->sum('TaxAmount');

                DB::connection('sqlsrv2')->update('update PayrollFinanceApproval set TaxAmount=? where CompanyID=? and EmployeeID=? and SessionName=? and IsDeleted=?', [$find_tax9, company_id(), $employee_id, $ses_name, 0]);
            }

            $find_fuel = DB::connection('sqlsrv2')->table('Fuel_Management')->where('CompanyID', '=', company_id())->where('Session', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->exists();
            if ($find_fuel) {
                $find_fuel2 = DB::connection('sqlsrv2')->table('Fuel_Management')->where('CompanyID', '=', company_id())->where('Session', '=', $ses_name)->where('EmployeeID', '=', $employee_id)->get();
                foreach ($find_fuel2 as $find_fuel21) {
                }
                DB::connection('sqlsrv2')->update('update PayrollFinanceApproval set  FuelReceivable=? where CompanyID=? and EmployeeID=? and SessionName=? and IsDeleted=?', [$find_fuel21->EccessAmount, company_id(), $employee_id, $ses_name, 0]);
            }
        }
        $result55 = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->where('CompanyID', '=', company_id())->where('SessionName', '=', $sesson_name)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->get();
        foreach ($result55 as $result551) {
            $employee_id5 = $result551->EmployeeID;
            $ses_name5 = $result551->SessionName;
            $tpayable5 = $result551->TAmount;

            $installment5 = $result551->InstallmentAmount;
            $fine5 = $result551->Fine;
            $AdvanceAmount5 = $result551->AdvanceAmount;
            $dues5 = $result551->DuesAmount;
            $fuelexcess5 = $result551->FuelReceivable;
            $TaxAmount5 = $result551->TaxAmount;

            $arrearsAmount5 = $result551->ArrearsAmount;
            $FuelAmount5 = $result551->FuelAmount;
            $bonus5 = $result551->BonusAmount;
            $allowance5 = $result551->AllowanceAmount;
            $stipend5 = $result551->StipendAmount;

            $total_deduction = $dues5 + $TaxAmount5 + $installment5 + $AdvanceAmount5;
            $total_arrears = $stipend5 + $allowance5 + $arrearsAmount5 + $FuelAmount5 + $bonus5;
            $salary_payable5 = $tpayable5 + $total_arrears - $total_deduction;


            DB::connection('sqlsrv2')->update('update PayrollFinanceApproval set PayableSalary=? where CompanyID=? and EmployeeID=? and SessionName=? and IsDeleted=?', [$salary_payable5, company_id(), $employee_id5, $ses_name5, 0]);
        }

        $update_date = long_date();
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Salaries processed', 'Fine and Installments deductions applied on salaries of session ' . $sesson_name, $update_date]);

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollFinanceApproval', 'Emp_Profile.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('Emp_Register.Department', 'Desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollFinanceApproval.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.MethodType')->where('PayrollFinanceApproval.CompanyID', '=', company_id())->where('PayrollFinanceApproval.SessionName', '=', $sesson_name)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->get();

        return request()->json(200, $arr);
    }

    public function get_dept_bycompany($comp)
    {

        $emp_detail = DB::connection('sqlsrv2')->table('Employee_Dep_Comp')
            ->where('CompanyID', '=', company_id())->where('Company', '=', $comp)->where('IsDeleted', '=', 0)->where('Status', '=', 'Active')->select('Department')->get();
        return request()->json(200, $emp_detail);
    }

    public function allowance_arrears()
    {
        $fuelRate = DB::connection('sqlsrv2')->table('FuelRate')->where('CompanyID', '=', company_id())->where('IsCurrent', '=', 1)->sum('PetrolRate'); //Get fuel rate
        //        dd($fuelRate);
        $basicQuery = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('CompanyID', '=', company_id());
        $result = $basicQuery->get();
        //        dd($result);
        foreach ($result as $result1) {
            //            dd($result1->SessionName);
            $totalArrears = DB::connection('sqlsrv2')->table('PayrollArrears')->where('CompanyID', '=', company_id())->where('SessionName', '=', $result1->SessionName)->where('EmployeeID', '=', $result1->EmployeeID)->where('Status', '=', 'Approved')->sum('ArrearsAmount');

            $totalBonus = DB::connection('sqlsrv2')->table('PayrollBonuses')->where('CompanyID', '=', company_id())->where('SessionName', '=', $result1->SessionName)->where('EmployeeID', '=', $result1->EmployeeID)->where('Status', '=', 'Approved')->sum('BonusAmount');

            $totalAllowance = DB::connection('sqlsrv2')->table('PayrollAllowance')->where('CompanyID', '=', company_id())->where('SessionEndDate', '<=', short_date())->where('EmployeeID', '=', $result1->EmployeeID)->where('Status', '=', 'Approved')->sum('AllowanceAmount');

            $totalStipend = DB::connection('sqlsrv2')->table('StipendDetail')->where('CompanyID', '=', company_id())->where('SessionEndDate', '<=', short_date())->where('EmpID', '=', $result1->EmployeeID)->where('Status', '=', 'Active')->sum('StipendAmount');

            $totalFuelBill = DB::connection('sqlsrv2')->table('FuelBill')->where('CompanyID', '=', company_id())->where('Session', '=', $result1->SessionName)->where('EmployeeID', '=', $result1->EmployeeID)->sum('BillAmount');

            $totalFuelQuantity = DB::connection('sqlsrv2')->table('Emp_FuelAllowance')->where('EmployeeID', '=', $result1->EmployeeID)->where('IsDeleted', '=', 0)->where('fuelQuantity', '>', 0)->where('CompanyID', '=', company_id())->sum('FuelQuantity');
            $fuelAmount = ($totalFuelQuantity * $fuelRate) + $totalFuelBill;

            $total_deduction = intval($result1->InstallmentAmount + $result1->Fine + $result1->DuesAmount + $result1->AdvanceAmount + $result1->TaxAmount + $result1->FuelReceivable);
            $salaryPayable = intval($result1->TAmount + ($totalArrears + $totalBonus + $totalAllowance + $fuelAmount + $totalStipend) - $total_deduction);

            $updateData = [
                'ArrearsAmount' => $totalArrears,
                'BonusAmount' => $totalBonus,
                'AllowanceAmount' => $totalAllowance,
                'StipendAmount' => $totalStipend,
                'FuelAmount' => $fuelAmount,
                'PayableSalary' => $salaryPayable,
            ];
            //dd($updateData);
            DB::connection('sqlsrv2')
                ->table('PayrollFinanceApproval')
                ->where('CompanyID', '=', company_id())
                ->where('EmployeeID', '=', $result1->EmployeeID)
                ->where('SessionName', '=', $result1->SessionName)
                ->where('IsDeleted', '=', 0)
                ->update($updateData);
        }
        insertLog('Salaries processed', 'Arrears and Allowances added in salaries of session ' . hr_closed_session()->SessionName);

        return request()->json(200, 'salaries updated');
    }

    public function fetch_payroll_finance_approval()
    {

        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->where('AttClosedPayrollStart', '=', 'Closed')->get();
        foreach ($find_session_closed as $find_session1) {
        }
        $sesson_name = $find_session1->SessionName;


        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollFinanceApproval', 'Emp_Profile.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('Emp_Register.Department', 'Desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollFinanceApproval.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.MethodType')->where('PayrollFinanceApproval.CompanyID', '=', company_id())->where('PayrollFinanceApproval.SessionName', '=', $sesson_name)->where('PayrollFinanceApproval.IsDeleted', '=', 0)->get();

        return request()->json(200, $arr);
    }

    public function fetchall_finance_approval()
    {
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('PayrollFinanceApproval', 'Emp_Profile.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('Emp_Register.Department', 'Desc')
            ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollFinanceApproval.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.MethodType')
            ->where('PayrollFinanceApproval.CompanyID', '=', company_id())
            ->where('PayrollFinanceApproval.IsDeleted', '=', 0)
            ->paginate(20);
        return $this->sendSuccess("Payroll Finance Data", $arr);
    }

    public function search_finance_approval(Request $request)
    {
        if (!Cache::has('FinanceData')) {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->join('PayrollFinanceApproval', 'Emp_Profile.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('Emp_Register.Department', 'Desc')
                ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollFinanceApproval.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.MethodType')
                ->where('PayrollFinanceApproval.CompanyID', '=', company_id())
                ->where('PayrollFinanceApproval.IsDeleted', '=', 0)
                ->get();

            Cache::forget('FinanceData');
            Cache::put('FinanceData', $arr);
            $collection = collect(Cache::get('FinanceData'));

            $filteredUsers = $collection->filter(function ($element) use ($request) {
                $keyword = $request->keyword1;
                return Str::contains($element->EmployeeCode, $keyword, true) || Str::contains($element->Name, $keyword, true);
            });
        } else {
            $collection = collect(Cache::get('FinanceData'));

            $filteredUsers = $collection->filter(function ($element) use ($request) {
                //                dd('2');
                $keyword = $request->keyword1;
                return Str::contains($element->EmployeeCode, $keyword, true) ||
                    Str::contains($element->Name, $keyword, true);
            });
        }
        $perPage = 20;
        $currentPage = 1;

        // Manually paginate the collection using the forPage method
        $paginatedData = $filteredUsers->forPage($currentPage, $perPage);

        // Create a LengthAwarePaginator instance for proper pagination metadata
        $paginatedCollection = new LengthAwarePaginator(
            $paginatedData,
            $filteredUsers->count(),
            $perPage,
            $currentPage
        );

        // Return the paginated data as a JSON response
        return response()->json($paginatedCollection);

        return response()->json(200, $paginatedData);
    }

    public function find_payroll_emp_financeapproval($id)
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollFinanceApproval', 'Emp_Profile.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('Emp_Register.Department', 'Desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollFinanceApproval.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.MethodType', 'Emp_Register.EmployeeCode')->where('PayrollFinanceApproval.CompanyID', '=', company_id())->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('PayrollFinanceApproval.FinanceApprovalID', '=', $id)->get();

        return request()->json(200, $arr);
    }

    public function update_payroll_ind_status_hrapproval(Request $request)
    {
        $m_ApprovalID = $request->get('m_ApprovalID');
        $m_salary_status = $request->get('m_salary_status');
        $m_name = $request->get('m_name');

        $result = DB::connection('sqlsrv2')->update('update PayrollHrApproval set HrStatus=?, UpdatedBy=?  where ApprovalID=? and CompanyID=?', [$m_salary_status, username(), $m_ApprovalID, company_id()]);
        if ($m_salary_status == "P") {
            $m_salary_status = "Proceed";
        } else if ($m_salary_status == "H") {
            $m_salary_status = "Hold";
        }
        $update_date = long_date();
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Salary Detail', 'Salary status for HR manager approval of ' . $m_name . ' changed to ' . $m_salary_status, $update_date]);
        $arr = 'Status updated';
        return request()->json(200, $arr);
    }

    public function update_payroll_ind_status_financeapproval(Request $request)
    {


        $m_ApprovalID = $request->get('m_ApprovalID');
        $m_salary_status = $request->get('m_salary_status');
        $m_name = $request->get('m_name');
        $m_bankpayable = $request->get('m_bankpayable');
        $m_cashpayable = $request->get('m_cashpayable');
        $result = DB::connection('sqlsrv2')->update('update PayrollFinanceApproval set FStatus=?, BankPayable=?, CashPayable=?, UpdatedBy=?  where FinanceApprovalID=? and CompanyID=? and IsDeleted=?', [$m_salary_status, $m_bankpayable, $m_cashpayable, username(), $m_ApprovalID, company_id(), 0]);

        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->get();
        foreach ($find_session_closed as $find_session1) {
        }
        $sesson_name = $find_session1->SessionName;
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollFinanceApproval', 'Emp_Profile.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('Emp_Register.Department', 'Desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'PayrollFinanceApproval.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.MethodType')->where('PayrollFinanceApproval.CompanyID', '=', company_id())->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('PayrollFinanceApproval.SessionName', '=', $sesson_name)->get();

        if ($m_salary_status == "P") {
            $m_salary_status = "Proceed";
        } else if ($m_salary_status == "H") {
            $m_salary_status = "Hold";
        }

        $update_date = long_date();
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Update Salary Detail', 'Salary status for Finance manager approval of ' . $m_name . ' changed to ' . $m_salary_status, $update_date]);
        Cache::forget('FinanceData');
        return request()->json(200, $arr);
    }

    public function fetch_distribution_cash_payabale($department_name)
    {

        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->orderby('SessionID', 'asc')->get();
        foreach ($find_session_closed as $find_session1) {
        }
        $sesson_name = $find_session1->SessionName;
        $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('CompanyID', '=', company_id())->where('Department', '=', $department_name)->where('SessionName', '=', $sesson_name)->where('RemainingAmount', '!=', 0)->get();
        return request()->json(200, $emp_detail);
    }

    public function proceeddistapproval()
    {
        Cache::forget('FinanceData');
        if (Session::get('company_accounts_plan') == 'true') {
            $financeData = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->join('Emp_Profile', 'Emp_Profile.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'PayrollFinanceApproval.EmployeeID')->select('PayrollFinanceApproval.*', 'Emp_Profile.Name', 'Emp_Register.EmployeeCode')->where('PayrollFinanceApproval.FStatus', '=', 'P')->where('PayrollFinanceApproval.IsDeleted', '=', 0)->where('PayrollFinanceApproval.CompanyID', '=', company_id())->get();

            $financeSessions = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->select('SessionName')->where('FStatus', '=', 'P')->where('IsDeleted', '=', 0)->groupBy('SessionName', 'FStatus', 'IsDeleted', 'CompanyID')->get();
            foreach ($financeData as $save_ledger1) {
                $docID = DB::connection('sqlsrv3')
                    ->table('Documents')
                    ->insertGetId([
                        'DocumentDate' => short_date(),
                        'DocumentNo' => $save_ledger1->SessionName . '_Salary_' . $save_ledger1->EmployeeCode,
                        'Description' => 'Salary of ' . $save_ledger1->EmployeeCode . ':' . $save_ledger1->Name . ' Against Session:' . $save_ledger1->SessionName,
                        'DocumentType' => 'Employee Salary',
                        'InsertedAt' => long_date(),
                        'InsertedBy' => username(),
                        'CompanyID' => company_id(),
                    ]);

                if ($docID) {
                    $transID = DB::connection('sqlsrv3')
                        ->table('Transactions')
                        ->insertGetId([
                            'DocumentID' => $docID,
                            'TransactionDate' => short_date(),
                            'Description' => 'Salary of ' . $save_ledger1->EmployeeCode . ':' . $save_ledger1->Name . ' Against Session:' . $save_ledger1->SessionName,
                            'CompanyID' => company_id(),
                        ]);
                    $ledgerEntries = []; //Let empty array
                    if ($save_ledger1->Salary != 0) {
                        $total_Sal = $save_ledger1->Salary - $save_ledger1->DAmount;
                        if ($total_Sal > 0) {
                            $ledgerEntries[] = [
                                'TransactionID' => $transID,
                                'AccountID' => '504001001',
                                'EntryType' => 'D',
                                'Amount' => intval($save_ledger1->Salary - $save_ledger1->DAmount),
                                'VendorID4' => $save_ledger1->FinanceApprovalID,
                                'CompanyID' => company_id(),
                            ];
                        }
                    }
                    if ($save_ledger1->StipendAmount != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '504002007',
                            'EntryType' => 'D',
                            'Amount' => intval($save_ledger1->StipendAmount),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($save_ledger1->AllowanceAmount != 0 || $save_ledger1->FuelAmount != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '504001002',
                            'EntryType' => 'D',
                            'Amount' => intval($save_ledger1->AllowanceAmount + $save_ledger1->FuelAmount),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($save_ledger1->BonusAmount != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '504001003',
                            'EntryType' => 'D',
                            'Amount' => intval($save_ledger1->BonusAmount),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($save_ledger1->OAmount != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '504001004',
                            'EntryType' => 'D',
                            'Amount' => intval($save_ledger1->OAmount),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($save_ledger1->ArrearsAmount != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '504001005',
                            'EntryType' => 'D',
                            'Amount' => intval($save_ledger1->ArrearsAmount),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($save_ledger1->InstallmentAmount != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '101002001001',
                            'EntryType' => 'C',
                            'Amount' => intval($save_ledger1->InstallmentAmount),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($save_ledger1->AdvanceAmount != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '101002001002',
                            'EntryType' => 'C',
                            'Amount' => intval($save_ledger1->AdvanceAmount),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($save_ledger1->FuelReceivable != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '101002001003',
                            'EntryType' => 'C',
                            'Amount' => intval($save_ledger1->FuelReceivable),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($save_ledger1->Fine != 0 || $save_ledger1->DuesAmount != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '101002001004',
                            'EntryType' => 'C',
                            'Amount' => intval($save_ledger1->Fine + $save_ledger1->DuesAmount),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($save_ledger1->TaxAmount != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '201001002001',
                            'EntryType' => 'C',
                            'Amount' => intval($save_ledger1->TaxAmount),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($save_ledger1->PayableSalary != 0) {
                        $ledgerEntries[] = [
                            'TransactionID' => $transID,
                            'AccountID' => '201002001001',
                            'EntryType' => 'C',
                            'Amount' => intval($save_ledger1->PayableSalary),
                            'VendorID4' => $save_ledger1->FinanceApprovalID,
                            'CompanyID' => company_id(),
                        ];
                    }
                }
                if (!empty($ledgerEntries)) {
                    DB::connection('sqlsrv3')
                        ->table('Ledger_Entries')
                        ->insert($ledgerEntries);
                }
            }
            foreach ($financeSessions as $financeSession) {
                insertLog('Salaries moved', 'Salaries of session ' . $financeSession->SessionName . ' moved for Distribution');
                try {
                    DB::connection('sqlsrv2')->select("SET NOCOUNT ON EXEC [dbo].[Add_Payroll_Distribution]
          @companyID = N'" . company_id() . "',
          @session = N'" . $financeSession->SessionName . "' update PayrollFinanceApproval set IsDeleted = 1 WHERE CompanyID='" . company_id() . "'  AND FStatus='P' AND SessionName='" . $financeSession->SessionName . "' ");
                } catch (\Throwable $e) {
                    $match = Str::contains($e, 'The active result for the query contains no fields');
                    if ($match) {
                        return response()->json(['message' => 'No Field'], 422);
                    } else {
                        throw $e;
                    }
                }
            }
        }
        return "salaries moved";
    }

    public function view_emp_salary_slip($id)
    {
        $emp_loan_dtl = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Payroll_Distribution', 'Payroll_Distribution.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->select('Emp_Profile.CNIC', 'Emp_Profile.Address', 'Emp_Profile.DOB', 'Emp_Register.JobStatus', 'Emp_Register.JoiningDate', 'Emp_Profile.Mobile', 'Payroll_Distribution.*')->where('Payroll_Distribution.DistributionID', '=', $id)->get();
        return request()->json(200, $emp_loan_dtl);
    }

    public function overall_child_companies_emp()
    {
        $emp_detail = DB::connection('sqlsrv2')->table('Employee_Dep_Comp')->where('CompanyID', '=', company_id())->groupBy('Company')->select('Company')->get();
        return request()->json(200, $emp_detail);
    }

    public function generate_slip1($emp_id, $slip_id, $emp_code, $session)
    {
        $test1 = DB::connection('sqlsrv2')->table('Payroll_Distribution')->join('Emp_Profile', 'Payroll_Distribution.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->select('Emp_Profile.CNIC', 'Emp_Profile.DOB', 'Emp_Register.JoiningDate', 'Emp_Register.JobStatus', 'Emp_Profile.Address', 'Emp_Profile.Mobile', 'Payroll_Distribution.*')->where('Payroll_Distribution.DistributionID', '=', $slip_id)->where('Payroll_Distribution.EmployeeID', '=', $emp_id)->first();
        //dd(company_detail());
        if (!empty($session) && $test1) {
            $this->fpdf->AddPage("P", ['210', '297']);
            if (strpos($test1->Photo, ".pdf") === false && strpos($test1->Photo, ".jfif") === false) {
                $this->fpdf->Image('public/images/profile_images/' . $test1->Photo, 10, 6, 35, 30);
                $this->fpdf->Image('public/images/profile_images/' . $test1->Photo, 10, 149, 35, 30);
            } else {
                $this->fpdf->Image('public/images/profile_images/pro.png', 10, 6, 35, 30);
                $this->fpdf->Image('public/images/profile_images/pro.png', 10, 149, 35, 30);
            }
            $this->fpdf->Image('public/images/' . company_detail()->company_logo, 170, 6, 30);
            $this->fpdf->Image('public/images/' . company_detail()->company_logo, 170, 150, 30);

            $this->fpdf->SetFont('Arial', 'B', 20);
            $this->fpdf->Text(80, 14, company_detail()->company_name);
            $this->fpdf->Text(80, 160, company_detail()->company_name);
            $this->fpdf->SetFont('', '', 14);
            $this->fpdf->Text(60, 20, company_detail()->company_address);
            $this->fpdf->Text(60, 166, company_detail()->company_address);
            $this->fpdf->SetFont('', 'B', 14);
            $this->fpdf->Ln(0);
            $space = 6;
            $this->fpdf->Text(92, 35, "Salary Slip");
            $this->fpdf->SetFont('Arial', '', 9);
            $this->fpdf->Text(92, 40, "(Employee Copy)");
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Ln(36);
            $this->fpdf->Cell(105, 0, "Salary Month: " . $test1->SessionName, 0, 0, 'L');

            $this->fpdf->Cell(85, 0, "Receiving Date: " . $test1->ReceivedTime, 0, 1, 'R');
            $this->fpdf->Ln(4);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell(25, 0, "Employee Code", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->EmpCode, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Basic Salary", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Salary) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(25, 0, "Employee Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Name, 0, 0, 'R');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Fuel Allowance", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->FuelAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Department Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Department, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Other Allowance(s)", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->AllowanceAmount + $test1->FuelAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Designation", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Designation, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Stipend", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->StipendAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Date of Joining", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JoiningDate, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Overtime", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . $test1->OAmount . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(25, 0, "Job Status", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JobStatus, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Arears", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . $test1->ArrearsAmount . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Posting City", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->PostingCity, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Bonus", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->BonusAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "CNIC Number", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->CNIC, 0, 0, 'R');
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Gross Pay:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->OAmount + $test1->AllowanceAmount + $test1->BonusAmount + $test1->ArrearsAmount + $test1->FuelAmount + $test1->StipendAmount + $test1->Salary) . "/-", 0, 1, 'R');
            $this->fpdf->SetFont('Arial', '', 10);

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Phone Number", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Mobile, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Loan & Advance", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->InstallmentAmount + $test1->AdvanceAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Prepared By", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, "HR Department", 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Tax", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->TaxAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, " ", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, " ", 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Fine & Dues", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Fine + $test1->DuesAmount + $test1->FuelReceivable) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(25, 0, "Total Paid", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->PaidAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Attendance Deduction", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->DAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(25, 0, "Cash Paid: ", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->CashAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Total Deduction:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Fine + $test1->DAmount + $test1->InstallmentAmount + $test1->DuesAmount + $test1->FuelReceivable + $test1->TaxAmount + $test1->AdvanceAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Bank Paid:", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->BankAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Net Pay:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->PayableSalary) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(3);
            $this->fpdf->SetFont('Arial', 'B', 12);
            $this->fpdf->setFillColor(185, 183, 183);
            $this->fpdf->Cell(30, 6, "Now Paying: ", 0, 0, 'L', 1);
            $this->fpdf->Cell(80, 6, number_format($test1->CurrentCashPaid) . '/-', 0, 0, 'R', 1);
            $this->fpdf->Cell($space, 6, "", 0, 0, 'C', 1);
            $this->fpdf->Cell(40, 6, "Total Remaining: ", 0, 0, 'L', 1);
            $this->fpdf->Cell(35, 6, number_format($test1->RemainingAmount) . '/-', 0, 0, 'R', 1);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Line(123, 48, 123, 117);

            $this->fpdf->Ln(14);
            $this->fpdf->Cell(95, 5, "Prepared By: " . user_detail()->first_name . " " . user_detail()->last_name, 0, 0, 'L');
            $this->fpdf->Cell(95, 5, "Received By: ________________________", 0, 1, 'R');
            $this->fpdf->Ln(8);
            $this->fpdf->Cell(170, 0, "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -", 0, 1, 'L');

            $this->fpdf->SetFont('Arial', 'B', 20);

            $this->fpdf->SetFont('Arial', '', 14);
            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->Text(92, 175, "Salary Slip");
            $this->fpdf->SetFont('Arial', '', 9);
            $this->fpdf->Text(93, 180, "(Accounts Copy)");
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Ln(46);
            $this->fpdf->Cell(105, 0, "Salary Month: " . $test1->SessionName, 0, 0, 'L');

            $this->fpdf->Cell(85, 0, "Receiving Date: " . $test1->ReceivedTime, 0, 1, 'R');
            $this->fpdf->Ln(4);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell(25, 0, "Employee Code", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->EmpCode, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Basic Salary", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Salary) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(25, 0, "Employee Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Name, 0, 0, 'R');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Fuel Allowance", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->FuelAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Department Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Department, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Other Allowance(s)", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->AllowanceAmount + $test1->FuelAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Designation", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Designation, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Stipend", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->StipendAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Date of Joining", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JoiningDate, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Overtime", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . $test1->OAmount . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(25, 0, "Job Status", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JobStatus, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Arears", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . $test1->ArrearsAmount . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Posting City", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->PostingCity, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Bonus", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->BonusAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "CNIC Number", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->CNIC, 0, 0, 'R');
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Gross Pay:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->OAmount + $test1->AllowanceAmount + $test1->BonusAmount + $test1->ArrearsAmount + $test1->FuelAmount + $test1->StipendAmount + $test1->Salary) . "/-", 0, 1, 'R');
            $this->fpdf->SetFont('Arial', '', 10);

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Phone Number", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Mobile, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Loan & Advance", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->InstallmentAmount + $test1->AdvanceAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Prepared By", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, "HR Department", 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Tax", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->TaxAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, " ", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, " ", 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Fine & Dues", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Fine + $test1->DuesAmount + $test1->FuelReceivable) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(25, 0, "Total Paid", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->PaidAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Attendance Deduction", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->DAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(25, 0, "Cash Paid: ", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->CashAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Total Deduction:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Fine + $test1->DAmount + $test1->InstallmentAmount + $test1->DuesAmount + $test1->FuelReceivable + $test1->TaxAmount + $test1->AdvanceAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Bank Paid:", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->BankAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Net Pay:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->PayableSalary) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(3);
            $this->fpdf->SetFont('Arial', 'B', 12);
            $this->fpdf->setFillColor(185, 183, 183);
            $this->fpdf->Cell(30, 6, "Now Paying: ", 0, 0, 'L', 1);
            $this->fpdf->Cell(80, 6, number_format($test1->CurrentCashPaid) . '/-', 0, 0, 'R', 1);
            $this->fpdf->Cell($space, 6, "", 0, 0, 'C', 1);
            $this->fpdf->Cell(40, 6, "Total Remaining: ", 0, 0, 'L', 1);
            $this->fpdf->Cell(35, 6, number_format($test1->RemainingAmount) . '/-', 0, 0, 'R', 1);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Line(123, 48, 123, 117);
            $this->fpdf->Ln(14);
            $this->fpdf->Cell(95, 5, "Prepared By: " . user_detail()->first_name . " " . user_detail()->last_name, 0, 0, 'L');
            $this->fpdf->Cell(95, 5, "Received By: ________________________", 0, 1, 'R');
            $this->fpdf->Output();
            exit;
        } else {
            echo "not exists";
        }
    }

    public function generate_slip($emp_id, $slip_id, $emp_code)
    {
        $this->fpdf->AddPage("P", ['210', '297']);
        $test1 = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('Payroll_Distribution', 'Payroll_Distribution.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')
            ->select('Payroll_Distribution.CNIC', 'Emp_Profile.DOB', 'Emp_Register.JoiningDate', 'Emp_Register.JobStatus', 'Payroll_Distribution.Address', 'Payroll_Distribution.Mobile', 'Payroll_Distribution.*')->where('Payroll_Distribution.DistributionID', '=', $slip_id)->where('Payroll_Distribution.EmployeeID', '=', $emp_id)
            ->where('Payroll_Distribution.CompanyID', '=', company_id())
            ->first();
        if ($test1) {
            $space = 6;
            if (strpos($test1->Photo, ".pdf") === false && strpos($test1->Photo, ".jfif") === false) {
                $this->fpdf->Image('public/images/profile_images/' . $test1->Photo, 10, 6, 35, 30);
                $this->fpdf->Image('public/images/profile_images/' . $test1->Photo, 10, 149, 35, 30);
            } else {
                $this->fpdf->Image('public/images/profile_images/pro.png', 10, 6, 35, 30);
                $this->fpdf->Image('public/images/profile_images/pro.png', 10, 149, 35, 30);
            }
            $this->fpdf->Image('public/images/' . company_detail()->company_logo, 170, 6, 30);
            $this->fpdf->Image('public/images/' . company_detail()->company_logo, 170, 149, 30);

            $this->fpdf->SetFont('Arial', 'B', 20);
            $this->fpdf->Text(85, 14, company_detail()->company_name);
            $this->fpdf->Text(85, 160, company_detail()->company_name);
            $this->fpdf->SetFont('Arial', '', 14);
            $this->fpdf->Text(65, 20, company_detail()->company_address);
            $this->fpdf->Text(65, 166, company_detail()->company_address);

            $this->fpdf->SetFont('Arial', 'B', 14);
            $this->fpdf->Text(92, 35, "Salary Slip");
            $this->fpdf->Text(92, 175, "Salary Slip");
            $this->fpdf->SetFont('Arial', '', 9);
            $this->fpdf->Text(92, 40, "(Employee Copy)");
            $this->fpdf->Text(93, 180, "(Accounts Copy)");

            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Ln(36);
            $this->fpdf->Cell(105, 0, "Salary Month: " . $test1->SessionName, 0, 0, 'L');

            $this->fpdf->Cell(85, 0, "Receiving Date: " . $test1->ReceivedTime, 0, 1, 'R');
            $this->fpdf->Ln(4);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell(25, 0, "Employee Code", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->EmpCode, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Basic Salary", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Salary) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(25, 0, "Employee Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Name, 0, 0, 'R');
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Fuel Allowance", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->FuelAmount) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Department Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Department, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Other Allowance(s)", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->AllowanceAmount + $test1->FuelAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Designation", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Designation, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Stipend", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->StipendAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Date of Joining", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JoiningDate, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Overtime", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . $test1->OAmount . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(25, 0, "Job Status", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JobStatus, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Arears", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . $test1->ArrearsAmount . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Posting City", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->PostingCity, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Bonus", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->BonusAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "CNIC Number", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->CNIC, 0, 0, 'R');
            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Gross Pay:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->OAmount + $test1->AllowanceAmount + $test1->BonusAmount + $test1->ArrearsAmount + $test1->FuelAmount + $test1->StipendAmount + $test1->Salary) . "/-", 0, 1, 'R');
            $this->fpdf->SetFont('Arial', '', 10);

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Phone Number", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Mobile, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Loan & Advance", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->InstallmentAmount + $test1->AdvanceAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Prepared By", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, "HR Department", 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Tax", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->TaxAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, " ", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, " ", 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Fine & Dues", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Fine + $test1->DuesAmount + $test1->FuelReceivable) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(25, 0, "Total Paid", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->PaidAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Attendance Deduction", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->DAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(25, 0, "Cash Paid: ", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->CashAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Total Deduction:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Fine + $test1->DAmount + $test1->InstallmentAmount + $test1->DuesAmount + $test1->FuelReceivable + $test1->TaxAmount + $test1->AdvanceAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Bank Paid:", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->BankAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Net Pay:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->PayableSalary) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(3);
            $this->fpdf->SetFont('Arial', 'B', 12);
            $this->fpdf->setFillColor(185, 183, 183);
            $this->fpdf->Cell(30, 6, "Now Paying: ", 0, 0, 'L', 1);
            $this->fpdf->Cell(80, 6, number_format($test1->CurrentCashPaid) . '/-', 0, 0, 'R', 1);
            $this->fpdf->Cell($space, 6, "", 0, 0, 'C', 1);
            $this->fpdf->Cell(40, 6, "Total Remaining: ", 0, 0, 'L', 1);
            $this->fpdf->Cell(35, 6, number_format($test1->RemainingAmount) . '/-', 0, 0, 'R', 1);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Line(123, 48, 123, 117);

            $this->fpdf->Ln(14);
            $this->fpdf->Cell(95, 5, "Prepared By: " . user_detail()->first_name . " " . user_detail()->last_name, 0, 0, 'L');
            $this->fpdf->Cell(95, 5, "Received By: ________________________", 0, 1, 'R');
            $this->fpdf->Ln(8);
            $this->fpdf->Cell(170, 0, "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -", 0, 1, 'L');
            $this->fpdf->Ln(46);

            $this->fpdf->SetFont('Arial', 'B', 10);
            $this->fpdf->Cell(105, 0, "Salary Month: " . $test1->SessionName, 0, 0, 'L');

            $this->fpdf->Cell(85, 0, "Receiving Date: " . $test1->ReceivedTime, 0, 1, 'R');
            $this->fpdf->Ln(4);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell(25, 0, "Employee Code", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->EmpCode, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Basic Salary", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Salary) . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(25, 0, "Employee Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Name, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Fuel Allowance", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->FuelAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Department Name", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Department, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Other Allowance(s)", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->AllowanceAmount + $test1->FuelAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Designation", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Designation, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Stipend", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->StipendAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Date of Joining", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JoiningDate, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Overtime", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . $test1->OAmount . "/-", 0, 1, 'R');
            $this->fpdf->Ln(5);

            $this->fpdf->Cell(25, 0, "Job Status", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->JobStatus, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Arears", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . $test1->ArrearsAmount . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Posting City", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->PostingCity, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Bonus", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->BonusAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "CNIC Number", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->CNIC, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(30, 0, "Gross Pay:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->OAmount + $test1->AllowanceAmount + $test1->BonusAmount + $test1->ArrearsAmount + $test1->FuelAmount + $test1->StipendAmount + $test1->Salary) . "/-", 0, 1, 'R');
            $this->fpdf->SetFont('', '', 10);

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Phone Number", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, $test1->Mobile, 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Loan & Advance", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->InstallmentAmount + $test1->AdvanceAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Prepared By", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, "HR Department", 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Tax", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->TaxAmount) . "/-", 0, 1, 'R');


            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, " ", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, " ", 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Fine & Dues", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Fine + $test1->DuesAmount + $test1->FuelReceivable) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(25, 0, "Total Paid", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->PaidAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Attendance Deduction", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->DAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('', 'B', 10);
            $this->fpdf->Cell(25, 0, "Cash Paid: ", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->CashAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Total Deduction:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->Fine + $test1->DAmount + $test1->InstallmentAmount + $test1->DuesAmount + $test1->FuelReceivable + $test1->TaxAmount + $test1->AdvanceAmount) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->Cell(25, 0, "Bank Paid:", 0, 0, 'L');
            $this->fpdf->Cell(85, 0, number_format($test1->BankAmount) . '/-', 0, 0, 'R');
            $this->fpdf->Cell($space);
            $this->fpdf->Cell(30, 0, "Net Pay:", 0, 0, 'L');
            $this->fpdf->Cell(45, 0, "Rs. " . number_format($test1->PayableSalary) . "/-", 0, 1, 'R');

            $this->fpdf->Ln(3);
            $this->fpdf->SetFont('Arial', 'B', 12);
            $this->fpdf->setFillColor(185, 183, 183);
            $this->fpdf->Cell(30, 6, "Now Paying: ", 0, 0, 'L', 1);
            $this->fpdf->Cell(80, 6, number_format($test1->CurrentCashPaid) . '/-', 0, 0, 'R', 1);
            $this->fpdf->Cell($space, 6, "", 0, 0, 'C', 1);
            $this->fpdf->Cell(40, 6, "Total Remaining: ", 0, 0, 'L', 1);
            $this->fpdf->Cell(35, 6, number_format($test1->RemainingAmount) . '/-', 0, 0, 'R', 1);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Line(123, 48, 123, 117);
            $this->fpdf->Ln(14);
            $this->fpdf->Cell(95, 5, "Prepared By: " . user_detail()->first_name . " " . user_detail()->last_name, 0, 0, 'L');
            $this->fpdf->Cell(95, 5, "Received By: ________________________", 0, 1, 'R');
            $this->fpdf->Output();
            exit;
        } else {
            echo "not exists";
        }
    }

    //payroll loans
    public function filter_loan_requisitions($date_from, $date_to, $dept, $desig, $name, $app, $pen, $rej)
    {
        $date_from = ($date_from == "All") ? '' : $date_from;
        $date_to = ($date_to == "All") ? '' : $date_to;
        $dept = ($dept == "All") ? '' : $dept;
        $desig = ($desig == "All") ? '' : $desig;
        $name = ($name == "All") ? '' : $name;
        $app = $app == 'true' ? 'Approved' : '';
        $paid = $app == 'Approved' ? 'Paid' : '';
        $pen = $pen == 'true' ? 'Pending' : '';
        $rej = $rej == 'true' ? 'Rejected' : '';

        $status = [$app, $pen, $paid, $rej];

        $loanQuery = DB::connection('sqlsrv2')
            ->table('LoanRequisition')
            ->join('Emp_Register', 'LoanRequisition.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')
            ->orderBy('LoanRequisition.LoanId', 'desc')
            ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeID', 'Emp_Register.EmployeeCode')
            ->where('LoanRequisition.ApplyDate', '>=', $date_from)
            ->where('LoanRequisition.ApplyDate', '<=', $date_to)
            ->where('Emp_Register.Department', 'like', '%' . $dept . '%')
            ->where('Emp_Register.Designation', 'like', '%' . $desig . '%')
            ->where('Emp_Profile.Name', 'like', '%' . $name . '%')
            ->where('LoanRequisition.IsDeleted', '=', 0)
            ->whereIn('LoanRequisition.ReqStatus', $status)
            ->where('Emp_Register.CompanyID', '=', company_id());

        //dd(Session::get('payroll_write'), Session::get('company_payroll_plan'));
        //v-if="session_detail.payroll_write=='true' && session_detail.company_payroll_plan=='true'"

        if (Session::get('payroll_write') == 'true' && Session::get('company_payroll_plan') == 'true') {
            return $loanQuery->paginate(15);
        } else {
            $employeeIDs = array_column(reporting_team(), 'EmployeeID');
            return $loanQuery->whereIn('Emp_Register.EmployeeID', $employeeIDs)->paginate(15);
        }
    }

    //fetch Employee detail for loan and advance
    public function fetch_employee_dtl($emp_id1)
    {
        if ($emp_id1 == '0') {
            $emp_id = employee_id();
        } else {
            $emp_id = $emp_id1;
        }
        $emp_loan_dtl = DB::connection('sqlsrv2')->table('Emp_Register')->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->orderBy('Emp_Register.EmployeeID', 'asc')->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Register.CompanyID', '=', company_id())->where('Emp_Register.EmployeeID', '=', $emp_id)->get();
        return request()->json(200, $emp_loan_dtl);
    }

    //Apply for loan

    public function add_loan_req(Request $request)
    {
        $type = $request->get('type1');
        $emp_id = $request->get('emp_id1');
        $emp_id1 = ($emp_id == '0') ? employee_id() : $emp_id;
        //dd('ok');
        if (username() != 'ahmadshahbazkz@gmail.com' && username() != 'umairahmad@sasystems.solutions' && username() != 'husnain@sasystems.solutions') {
            $alreadyappliedid = DB::connection('sqlsrv2')->table('LoanDetail')->join('LoanRequisition', 'LoanDetail.LoanId', '=', 'LoanRequisition.LoanId')->where('LoanDetail.InstallmentStatus', '=', "Unpaid")->where('LoanDetail.EmployeeID', '=', $emp_id1)->where('LoanDetail.CompanyID', '=', company_id())->where('LoanRequisition.LoanType', '=', $type)->exists();
            if ($alreadyappliedid) {
                return $type . ' already provided!';
            }
        }
        $wished_deduction = $request->get('wished_deduction');
        $loanSession = ($type != 'Advance') ? $wished_deduction : hr_current_session()->SessionName;

        $amount = $request->get('amount');
        $reason = $request->get('reason');
        // DB::connection('sqlsrv2')->table('LoanRequisition')->insert([
        //     'CompanyID' => company_id(),
        //     'EmployeeID' => $emp_id1,
        //     'LoanType' => $type,
        //     'LoanAmount' => $amount,
        //     'LoanReason' => $reason,
        //     'LoanInstallments' => ($type == "Loan") ? $request->get('installments') : 1,
        //     'LoanSession' => $loanSession,
        //     'ApplyDate' => date("Y-m-d"),
        //     'ManagerApproval' => 'Pen',
        //     'HrApproval' => 'Pen',
        //     'ReqStatus' => 'Pending',
        //     'CreatedOn' => long_date(),
        //     'CreatedBy' => username(),
        // ]);
        $result = DB::connection('sqlsrv2')->table('LoanRequisition')->insertGetId([
            'CompanyID' => company_id(),
            'EmployeeID' => $emp_id1,
            'LoanType' => $type,
            'LoanAmount' => $amount,
            'LoanReason' => $reason,
            'LoanInstallments' => ($type == "Loan") ? $request->get('installments') : 1,
            'LoanSession' => $loanSession,
            'ApplyDate' => date("Y-m-d"),
            'ManagerApproval' => 'Pen',
            'HrApproval' => 'Pen',
            'ReqStatus' => 'Pending',
            'CreatedOn' => long_date(),
            'CreatedBy' => username(),
        ]);
        $full_name_arr1 = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $emp_id1)->where('CompanyID', '=', company_id())->first();
        insertLog($type . ' Applied', $type . ' application received from ' . $full_name_arr1->Name);
        // return "Loan added Successfully!";
        $data = DB::connection('sqlsrv2')
            ->table('LoanRequisition')
            ->join('Emp_Register', 'LoanRequisition.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')
            ->where('LoanRequisition.LoanId', $result)
            ->orderBy('LoanRequisition.LoanId', 'desc')
            ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeID', 'Emp_Register.EmployeeCode')
            ->first();
        return [
            'message' => 'Loan added Successfully!',
            'data' => $data,
        ];
    }

    //View all loans
    public function fetch_all_loans()
    {

        $all_loans = DB::connection('sqlsrv2')->table('LoanRequisition')->select('LoanRequisition.*')->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('LoanRequisition.LoanId', 'desc')->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation')->where('LoanRequisition.ManagerApproval', 'like', '%' . 'App' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'App' . '%')->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.CompanyID', '=', company_id())->where('LoanRequisition.IsDeleted', '=', 0)->get();
        return request()->json(200, $all_loans);
    }

    //View filtered loans

    public function fetch_filtered_loans($check)
    {

        if ($check == 0) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 1) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', '=', 'App')
                ->where('LoanRequisition.HrApproval', '=', 'App')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 2) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', 'like', '%' . 'App' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'App' . '%')
                ->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 3) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', 'like', '%' . 'App' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'App' . '%')
                ->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'Pen' . '%')
                ->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 4) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', 'like', '%' . 'App' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'App' . '%')
                ->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 5) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'Pen' . '%')
                ->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 6) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('LoanRequisition.CompanyID', '=', company_id())->where('LoanRequisition.ManagerApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 7) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('LoanRequisition.LoanId', 'desc')->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('LoanRequisition.CompanyID', '=', company_id())->where('LoanRequisition.ManagerApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.HrApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        //Department manager
        if ($check == 10) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 11) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', '=', 'App')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 12) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', 'like', '%' . 'App' . '%')
                ->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 13) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', 'like', '%' . 'App' . '%')
                ->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Pen' . '%')
                ->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 14) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', 'like', '%' . 'App' . '%')
                ->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 15) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', 'like', '%' . 'Pen' . '%')
                ->orwhere('LoanRequisition.ManagerApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 16) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 17) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.ManagerApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        //HR manager
        if ($check == 20) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 21) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.HrApproval', '=', 'App')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 22) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.HrApproval', 'like', '%' . 'App' . '%')
                ->orwhere('LoanRequisition.HrApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 23) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.HrApproval', 'like', '%' . 'App' . '%')
                ->orwhere('LoanRequisition.HrApproval', 'like', '%' . 'Pen' . '%')
                ->orwhere('LoanRequisition.HrApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 24) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.HrApproval', 'like', '%' . 'App' . '%')
                ->orwhere('LoanRequisition.HrApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 25) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.HrApproval', 'like', '%' . 'Pen' . '%')
                ->orwhere('LoanRequisition.HrApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 26) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.HrApproval', 'like', '%' . 'Pen' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        if ($check == 27) {
            $filtered_loans = DB::connection('sqlsrv2')->table('LoanRequisition')
                ->join('Emp_Profile', 'LoanRequisition.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
                ->orderBy('LoanRequisition.LoanId', 'desc')
                ->select('Emp_Profile.Name', 'LoanRequisition.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')
                ->where('LoanRequisition.CompanyID', '=', company_id())
                ->where('LoanRequisition.HrApproval', 'like', '%' . 'Rej' . '%')->where('LoanRequisition.IsDeleted', '=', 0)->paginate(20);
        }
        return request()->json(200, $filtered_loans);
    }

    public function fetch_rel_loan($cid)
    {
        $rel_loan_dtl = DB::connection('sqlsrv2')->table('LoanRequisition')->join('Emp_Register', 'LoanRequisition.EmployeeID', '=', 'Emp_Register.EmployeeID')->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->select('Emp_Profile.Name', 'Emp_Register.Department', 'Emp_Register.Designation', 'LoanRequisition.*')->where('Emp_Register.CompanyID', '=', company_id())->where('LoanRequisition.LoanId', '=', $cid)->get()->toArray();

        $loan_amount = DB::connection('sqlsrv2')->table('LoanRequisition')->join('LoanDetail', 'LoanRequisition.LoanId', '=', 'LoanDetail.LoanId')->where('LoanRequisition.CompanyID', '=', company_id())->where('LoanDetail.InstallmentStatus', '=', 'Unpaid')->where('LoanRequisition.LoanId', '=', $cid)->sum('InstallmentAmount');
        $rem_ins = DB::connection('sqlsrv2')->table('LoanRequisition')->join('LoanDetail', 'LoanRequisition.LoanId', '=', 'LoanDetail.LoanId')->where('LoanRequisition.CompanyID', '=', company_id())->where('LoanDetail.InstallmentStatus', '=', 'Unpaid')->where('LoanRequisition.LoanId', '=', $cid)->count('InstallmentAmount');

        $rem_loan1 = array(
            'rem_loan' => $loan_amount,
            'rem_inst' => $rem_ins,
        );

        //$rem_loan = json_decode($rem_loan1, TRUE);
        $team = array_merge($rel_loan_dtl, $rem_loan1);

        return request()->json(200, $rel_loan_dtl);
    }

    //View all installments
    public function fetch_all_installments()
    {

        $all_inst = DB::connection('sqlsrv2')
            ->table('LoanDetail')->select('LoanDetail.*')
            ->where('LoanDetail.CompanyID', '=', company_id())
            ->orderby('LoanDetail.InstallmentNo', 'asc')->get();
        return request()->json(200, $all_inst);
    }

    //Update status
    public function update_loan_m_sts(Request $request)
    {
        $status = $request->get('status');
        $man_hr = $request->get('man_hr');
        $status1 = ($status == "Pen") ? "Pending" : (($status == "App") ? "Approved" : (($status == "Rej") ? "Rejected" : ""));
        $updateData = [
            'ReqStatus' => $status1,
            'UpdatedOn' => long_date(),
            'UpdatedBy' => username(),
        ];

        if ($man_hr == 'man') {
            $man_hr = 'Manager';
            $updateData['ManagerApproval'] = $status;
        } else if ($man_hr == 'hr') {
            $man_hr = 'HR';
            $updateData['HrApproval'] = $status;
        }

        DB::connection('sqlsrv2')
            ->table('LoanRequisition')
            ->where('LoanId', $request->usid)
            ->update($updateData);

        insertLog('Loan Status Updated', $man_hr . ' status of Loan Id: ' . $request->usid . ' updated to ' . $status1);
        return "Status updated!";
    }

    public function pay_loan(Request $request)
    {
        //        dd('ok');
        $pay_loanID = $request['pay_loanID'];
        $pay_amount = $request['cash_amount'];
        $bank_amount = $request['bank_amount'];
        $pay_installments = $request['pay_installments'];
        $pay_type = $request['pay_type'];
        $pvId = PVID();
        $cash_typ = explode("_", $request['cash_type']);
        $bank_typ = explode("_", $request['bank_type']);
        $total_amount = $pay_amount + $bank_amount;
        //        dd($pay_amount, $bank_amount, $total_amount);
        $cashinhand_balance = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
        @Datefrom = N'2000-01-01',
        @DateTo = N'" . short_date() . "',
        @id = " . $cash_typ[0] . ",
        @compid = N'" . company_id() . "'  ");

        if ($request['cash_type'] == '101001001001_Cash in Hand' && $cashinhand_balance[0]->am <= 0) {
            $find_config = 'Not Suficient Balance';
            return request()->json(200, $find_config);
        }
        if ($pay_type == "Loan") {
            $InstallmentAmount = intval(round((float)$total_amount / $pay_installments, 2));
            //            dd($InstallmentAmount);

            $thisLoan = DB::connection('sqlsrv2')->table("LoanRequisition")->where('LoanId', '=', $request['pay_loanID'])->where('CompanyID', '=', company_id())->first();
            //            dd($insSession);
            if ($thisLoan->LoanSession == '-1') {
                $lastInstallment = DB::connection('sqlsrv2')->table("LoanDetail")->where('EmployeeID', '=', $request['pay_emp_id'])->where('InstallmentStatus', '=', 'Unpaid')->where('CompanyID', '=', company_id())->orderByRaw("CONVERT(DATE, '01-' + InstallmentSession, 103) DESC")->first();
                $InstallmentSession = date("F-Y", strtotime("+" . 1 . " months", strtotime($lastInstallment->InstallmentSession)));
            } else {
                $InstallmentSession = $thisLoan->LoanSession;
            }
            //            dd($InstallmentSession);
            $installmentNumber = 0;
            $insData = [];
            for ($x = $request['ins_start']; $x < ($pay_installments + $request['ins_start']); $x++) {
                $insSession = date("F-Y", strtotime("+" . $installmentNumber . " months", strtotime($InstallmentSession)));
                $insDate = date('Y-m-', strtotime('+' . $installmentNumber . ' month', strtotime($InstallmentSession))) . substr(hr_current_session()->StartDate, 8, 10);

                $installmentNumber++;
                $insData[] = [
                    'CompanyID' => company_id(),
                    'EmployeeID' => $request['pay_emp_id'],
                    'LoanId' => $pay_loanID,
                    'InstallmentNo' => $installmentNumber,
                    'InstallmentAmount' => $InstallmentAmount,
                    'InstallmentSession' => $insSession,
                    'InstallmentStatus' => "Unpaid",
                    'CreatedBy' => username(),
                    'CreatedOn' => long_date(),
                    'LoanType' => $pay_type,
                    'InstallmentDate' => $insDate,
                ];
            }
            //            dd($insData);
            //Insert installments
            DB::connection('sqlsrv2')->table('LoanDetail')->insert($insData);
            //Update loan status
            DB::connection('sqlsrv2')->table('LoanRequisition')
                ->where('LoanId', $pay_loanID)
                ->update([
                    'ReqStatus' => 'Paid',
                    'UpdatedOn' => long_date(),
                    'UpdatedBy' => username(),
                    'ReceivedDate' => long_date(),
                    'ReceivedBy' => $request['rcvBy'],
                    'PVID' => $pvId,
                ]);

            if (Session::get('company_accounts_plan') == 'true') {
                insert_sequencevoucher($pvId, $pay_loanID, 'Loan');
                $documentId = DB::connection('sqlsrv3')->table('Documents')->insertGetId([
                    'DocumentDate' => short_date(),
                    'DocumentNo' => $pvId,
                    'Description' => 'Loan Paid to ' . $request['rcvBy'],
                    'DocumentType' => 'Employee Loan',
                    'InsertedAt' => long_date(),
                    'InsertedBy' => username(),
                    'CompanyID' => company_id(),
                ]);
                if ($documentId) {
                    $transactionId = DB::connection('sqlsrv3')->table('Transactions')->insertGetId([
                        'DocumentID' => $documentId,
                        'TransactionDate' => short_date(),
                        'Description' => 'Loan Paid to ' . $request['rcvBy'],
                        'CompanyID' => company_id(),
                    ]);
                    //find_Account id
                    $entries = [];
                    $entries[] = [
                        'TransactionID' => $transactionId,
                        'AccountID' => '101002001001',
                        'EntryType' => 'D',
                        'Amount' => $total_amount,
                        'CompanyID' => company_id(),
                    ];
                    if ($pay_amount > 0) {
                        $entries[] = [
                            'TransactionID' => $transactionId,
                            'AccountID' => $cash_typ[0],
                            'EntryType' => 'C',
                            'Amount' => $pay_amount,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($bank_amount > 0) {
                        $entries[] = [
                            'TransactionID' => $transactionId,
                            'AccountID' => $bank_typ[0],
                            'EntryType' => 'C',
                            'Amount' => $bank_amount,
                            'CompanyID' => company_id(),
                        ];
                    }
                    DB::connection('sqlsrv3')->table('Ledger_Entries')->insert($entries);
                }
            }
        } else if ($pay_type == "Advance") {
            $insSession = DB::connection('sqlsrv2')->table("LoanRequisition")->where('CompanyID', '=', company_id())->where('LoanId', '=', $request['pay_loanID'])->first();
            $inDistribution = DB::connection('sqlsrv2')->table("Payroll_Distribution")->where('SessionName', '=', $insSession->LoanSession)->where('EmployeeID', '=', $request['pay_emp_id'])->where('CompanyID', '=', company_id())->first();
            //            dd($inDistribution);
            if ($inDistribution && ($inDistribution->SalaryStatus == 'Not Received' || $inDistribution->SalaryStatus == 'Partially Received')) {
                return request()->json(200, "Since the salary is ready for distribution, the advance payment cannot be processed. Please pay the amount from the salary!");
            } else if ($inDistribution && $inDistribution->SalaryStatus == 'Fully Received') {
                return request()->json(200, "Since the salary of " . $insSession->LoanSession . " is already distributed, the advance payment cannot be processed!");
            }
            $insDate = date('Y-m-d', strtotime('-1 month', strtotime('21 ' . $insSession->LoanSession)));

            $insData = [
                'CompanyID' => company_id(),
                'EmployeeID' => $request['pay_emp_id'],
                'LoanId' => $pay_loanID,
                'InstallmentNo' => 1,
                'InstallmentAmount' => $total_amount,
                'InstallmentSession' => $insSession->LoanSession,
                'InstallmentStatus' => "Unpaid",
                'CreatedBy' => username(),
                'CreatedOn' => long_date(),
                'LoanType' => $pay_type,
                'InstallmentDate' => $insDate,
            ];
            //dd($insData);
            //Insert installment
            DB::connection('sqlsrv2')->table('LoanDetail')->insert($insData);
            //Update loan status
            DB::connection('sqlsrv2')->table('LoanRequisition')
                ->where('LoanId', $pay_loanID)
                ->update([
                    'ReqStatus' => 'Paid',
                    'UpdatedOn' => long_date(),
                    'UpdatedBy' => username(),
                    'ReceivedDate' => long_date(),
                    'ReceivedBy' => $request['rcvBy'],
                    'PVID' => $pvId,
                ]);

            if (Session::get('company_accounts_plan') == 'true') {
                insert_sequencevoucher($pvId, $pay_loanID, 'Advance');
                $documentId = DB::connection('sqlsrv3')->table('Documents')->insertGetId([
                    'DocumentDate' => short_date(),
                    'DocumentNo' => $pvId,
                    'Description' => 'Loan Paid to ' . $request['rcvBy'],
                    'DocumentType' => 'Employee Loan',
                    'InsertedAt' => long_date(),
                    'InsertedBy' => username(),
                    'CompanyID' => company_id(),
                ]);
                if ($documentId) {
                    $transactionId = DB::connection('sqlsrv3')->table('Transactions')
                        ->insertGetId([
                            'DocumentID' => $documentId,
                            'TransactionDate' => short_date(),
                            'Description' => 'Loan Paid to ' . $request['rcvBy'],
                            'CompanyID' => company_id(),
                        ]);
                    //dd($find_tran_id1->ID, $transactionId);
                    $entries = [
                        [
                            'TransactionID' => $transactionId,
                            'AccountID' => '101002001002',
                            'EntryType' => 'D',
                            'Amount' => $total_amount,
                            'CompanyID' => company_id(),
                        ],
                    ];
                    if ($pay_amount > 0) {
                        $entries[] = [
                            'TransactionID' => $transactionId,
                            'AccountID' => $cash_typ[0],
                            'EntryType' => 'C',
                            'Amount' => $pay_amount,
                            'CompanyID' => company_id(),
                        ];
                    }
                    if ($bank_amount > 0) {
                        $entries[] = [
                            'TransactionID' => $transactionId,
                            'AccountID' => $bank_typ[0],
                            'EntryType' => 'C',
                            'Amount' => $bank_amount,
                            'CompanyID' => company_id(),
                        ];
                    }
                    DB::connection('sqlsrv3')->table('Ledger_Entries')->insert($entries);
                }
            }
        }
        $full_name_arr1 = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $request['pay_emp_id'])->first();
        insertLog($pay_type . ' Paid', $pay_type . ' paid to ' . $full_name_arr1->Name);
        return request()->json(200, "Loan paid!");
    }

    //Fetch employees to apply loan
    public function overall_employees_payroll()
    {
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('Emp_Register.EmployeeCode')
            ->select('Emp_Profile.Name', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeCode')
            ->where('Emp_Profile.CompanyID', '=', company_id())->get();
        return request()->json(200, $arr);
    }

    public function search_member(Request $request)
    {
        $emp_code = employee_id();
        $srch_name = $request->get('srch_name');

        $team = DB::connection('sqlsrv2')->table('Emp_Register')
            ->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')
            ->orderBy('Emp_Register.EmployeeID', 'asc')
            ->select('Emp_Register.*', 'Emp_Profile.Name')
            ->where('Emp_Register.CompanyID', '=', company_id())
            ->where('Emp_Profile.Name', 'like', '%' . $srch_name . '%')
            ->where('Emp_Register.Status', '=', 'Registered')
            ->where('Emp_Register.ReportingTo', '=', $emp_code)->get();
        return request()->json(200, $team);
    }

    public function filter_team_leaves($leave_type, $department, $location, $designation)
    {

        $EmployeeID = employee_id();

        if ($leave_type == 'All') {
            $leave_type = '';
        }
        if ($department == 'All') {
            $department = '';
        }
        if ($designation == 'All') {
            $designation = '';
        }
        if ($location == 'All') {
            $location = '';
        }

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('leave_Requisition', 'Emp_Profile.EmployeeID', '=', 'leave_Requisition.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('leave_Requisition.StartDate', 'desc')
            ->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'leave_Requisition.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('leave_Requisition.Leavetype', 'like', '%' . $leave_type . '%')->where('Emp_Register.Department', 'like', '%' . $department . '%')->where('Emp_Register.Designation', 'like', '%' . $designation . '%')->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')->where('Emp_Register.ReportingTo', '=', $EmployeeID)->orWhere('Emp_Register.ReportingTo2', '=', $EmployeeID)->where('leave_Requisition.Leavetype', 'like', '%' . $leave_type . '%')->where('Emp_Register.Department', 'like', '%' . $department . '%')->where('Emp_Register.Designation', 'like', '%' . $designation . '%')->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')->where('leave_Requisition.CompanyID', '=', company_id())->paginate(20);
        return request()->json(200, $arr);
    }

    public function leaves_dtl()
    {
        $commonQuery = DB::connection('sqlsrv2')->table('EmpLeave')->where('EmployeeID', '=', employee_id())->where('CreatedOn', 'like', '%' . date("Y") . '%')->where('CompanyID', '=', company_id());

        $this_a_l = clone $commonQuery;
        $this_a_l = $this_a_l->where('LeaveType', '=', 'Annual')->sum('RemainingLeave');

        $ttl_annual = clone $commonQuery;
        $ttl_annual = $ttl_annual->where('LeaveType', '=', 'Annual')->sum('TotalLeave');

        $this_s_l = clone $commonQuery;
        $this_s_l = $this_s_l->where('LeaveType', '=', 'Sick')->sum('RemainingLeave');

        $ttl_sick = clone $commonQuery;
        $ttl_sick = $ttl_sick->where('LeaveType', '=', 'Sick')->sum('TotalLeave');

        $this_c_l = clone $commonQuery;
        $this_c_l = $this_c_l->where('LeaveType', '=', 'Casual')->sum('RemainingLeave');

        $ttl_casual = clone $commonQuery;
        $ttl_casual = $ttl_casual->where('LeaveType', '=', 'Casual')->sum('TotalLeave');

        $other_used = DB::connection('sqlsrv2')->table('leave_Requisition')->where('EmployeeID', '=', employee_id())->where('PendingLeaveStatus', '=', 'A')->whereNotIn('LeaveType', ['Casual', 'Sick', 'Annual'])->sum('NoOfDays');

        $ttl_other = DB::connection('sqlsrv2')->table('leave_Requisition')->where('EmployeeID', '=', employee_id())->whereNotIn('LeaveType', ['Casual', 'Sick', 'Annual'])->sum('NoOfDays');

        $leave_count = array(
            'rem_annual' => $this_a_l,
            'ttl_annual' => $ttl_annual,
            'rem_sick' => $this_s_l,
            'ttl_sick' => $ttl_sick,
            'rem_casual' => $this_c_l,
            'ttl_casual' => $ttl_casual,
            'ttl_other' => $ttl_other,
            'other_used' => $other_used,
        );
        return request()->json(200, $leave_count);
    }

    protected function getValidationRules()
    {
        return [
            'emp_emp_id' => 'required',
            'emp_amount' => 'required|numeric|gt:0|lt:1000',
        ];
    }

    public function submit_EmpFuelAllowance(Request $request)
    {
        try {
            $request->validate($this->getValidationRules());
            $resu = explode("_", $request->emp_emp_id);

            $status = DB::connection('sqlsrv2')->table("Emp_Register")->Select('Status', 'EmployeeID')->where('EmployeeCode', '=', $resu[1])->where('CompanyID', '=', company_id())->first();

            $allowance = DB::connection('sqlsrv2')->table('Emp_FuelAllowance')->where('CompanyID', '=', company_id())->where('isDeleted', '=', '0')->where('EmployeeID', '=', $status->EmployeeID)->exists();
            if ($allowance) {
                //return $this->sendSuccess("This Employee already exists");
                return $this->sendError("This Employee already exists");
            } else {
                $result = DB::connection('sqlsrv2')
                    ->table('Emp_FuelAllowance')
                    ->insert([
                        'CompanyID' => company_id(),
                        'EmployeeID' => $status->EmployeeID,
                        'FuelQuantity' => $request->emp_amount,
                        'FuelType' => $request->emp_FuelType,
                        'Status' => $status->Status,
                        'CreatedBy' => username(),
                        'CreatedOn' => short_date(),
                        'isDeleted' => '0'
                    ]);
                return $this->sendSuccess("Emp Fuel Allowance Added Successfully");
                insertLog('Emp Fuel Allowance Added', 'Fuel Allowance Added for new Employee');
            }
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    public function fetch_EmpFuelAllowance()
    {
        $arr = DB::connection('sqlsrv2')->table('Emp_FuelAllowance')->join('Emp_Profile', 'Emp_FuelAllowance.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('Emp_FuelAllowance.CreatedOn', 'desc')->select('Emp_FuelAllowance.ID', 'Emp_Profile.Name', 'Emp_FuelAllowance.FuelQuantity', 'Emp_FuelAllowance.FuelType', 'Emp_FuelAllowance.EmployeeID', 'Emp_FuelAllowance.FuelQuantity', 'Emp_Register.EmployeeCode', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.Salary')->where('Emp_FuelAllowance.CompanyID', '=', company_id())->where('Emp_FuelAllowance.isDeleted', '!=', '1')->paginate(15);
        return request()->json(200, $arr);
    }

    public function fetch_FuelRate()
    {
        $arr = DB::connection('sqlsrv2')
            ->table('FuelRate')
            ->latest('CreatedOn') // Order the results by 'CreatedOn' in descending order (most recent first)
            ->where('CompanyID', '=', company_id()) // Apply the 'CompanyID' condition
            ->take(3) // Limit the results to the last three records (most recent)
            ->get();
        return response()->json($arr, 200);
    }

    public function submit_arrears(Request $request)
    {
        $emp_id = $request->get('emp_emp_id');
        $emp_amount = $request->get('emp_amount');
        $emp_description = $request->get('emp_description');
        $emp_date = $request->get('emp_date');
        $session_name = $request->get('session_name');
        $update_date = long_date();
        $result = DB::connection('sqlsrv2')->insert("INSERT INTO PayrollArrears(CompanyID,EmployeeID,SessionName,ArrearDate,ArrearsAmount,Descriptions,Status,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?,?)", [company_id(), $emp_id, $session_name, $emp_date, $emp_amount, $emp_description, 'Pending', username(), $update_date]);

        $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $emp_id)->where('CompanyID', '=', company_id())->get();
        foreach ($full_name_arr as $full_name_arr1) {
        }
        $full_name = $full_name_arr1->Name;

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Arrears Applied', ' Arrears of ' . $full_name . ' applied', $update_date]);

        if ($result) {

            $arr = DB::connection('sqlsrv2')->table('PayrollArrears')->join('Emp_Profile', 'PayrollArrears.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollArrears.ArrearDate', 'desc')->select('Emp_Profile.Name', 'PayrollArrears.*', 'Emp_Register.EmployeeCode', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.Salary')->where('PayrollArrears.CompanyID', '=', company_id())->where('PayrollArrears.IsDeleted', '!=', '1')->paginate(15);

            return request()->json(200, $arr);
        }
    }

    public function fetch_payroll_arrears()
    {


        $arr = DB::connection('sqlsrv2')->table('PayrollArrears')->join('Emp_Profile', 'PayrollArrears.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollArrears.ArrearDate', 'desc')->select('Emp_Profile.Name', 'PayrollArrears.*', 'Emp_Register.EmployeeCode', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.Salary')->where('PayrollArrears.CompanyID', '=', company_id())->where('PayrollArrears.IsDeleted', '!=', '1')->paginate(15);

        return request()->json(200, $arr);
    }

    public function approve_arrears($id)
    {


        $update_date = long_date();

        $id_arr = DB::connection('sqlsrv2')->table('PayrollArrears')->select('EmployeeID')->where('ArrearsID', '=', $id)->where('CompanyID', '=', company_id())->get();
        foreach ($id_arr as $id_arr1) {
        }
        $emp_id = $id_arr1->EmployeeID;
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Arrears Status Changed', ' Arrears of ' . $emp_id . ' approved', $update_date]);

        $result = DB::connection('sqlsrv2')->update('update PayrollArrears set Status=?,ApprovedBy=? where ArrearsID=? and CompanyID=?', ['Approved', username(), $id, company_id()]);

        if ($result) {

            $arr = DB::connection('sqlsrv2')->table('PayrollArrears')->join('Emp_Profile', 'PayrollArrears.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollArrears.ArrearDate', 'desc')->select('Emp_Profile.Name', 'PayrollArrears.*', 'Emp_Register.EmployeeCode', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.Salary')->where('PayrollArrears.CompanyID', '=', company_id())->where('PayrollArrears.IsDeleted', '!=', '1')->paginate(15);

            return request()->json(200, $arr);
        }
    }


    public function find_payroll_arrear($id)
    {

        $result = DB::connection('sqlsrv2')->table('PayrollArrears')->where('CompanyID', '=', company_id())->where('ArrearsID', '=', $id)->get();
        return request()->json(200, $result);
    }

    public function update_ind_arrears(Request $request)
    {

        $emp_id = $request->get('edit_emp_id');
        $emp_amount = $request->get('edit_amount');
        $emp_description = $request->get('edit_description');
        $emp_date = $request->get('edit_date');
        $session_name = $request->get('edit_session_name');
        $edit_arrear_id = $request->get('edit_arrear_id');


        $update_date = long_date();

        $result = DB::connection('sqlsrv2')->update('update PayrollArrears set EmployeeID=?,ArrearDate=?,ArrearsAmount=?,Descriptions=? where ArrearsID=? and CompanyID=?', [$emp_id, $emp_date, $emp_amount, $emp_description, $edit_arrear_id, company_id()]);

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Arrears updated', 'Arrears of ' . $emp_id . ' updated', $update_date]);

        if ($result) {
            $arr = DB::connection('sqlsrv2')->table('PayrollArrears')->join('Emp_Profile', 'PayrollArrears.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollArrears.ArrearDate', 'desc')->select('Emp_Profile.Name', 'PayrollArrears.*', 'Emp_Register.EmployeeCode', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.Salary')->where('PayrollArrears.CompanyID', '=', company_id())->where('PayrollArrears.IsDeleted', '!=', '1')->paginate(15);

            return request()->json(200, $arr);
        }
    }

    public function search_arrears(Request $request)
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollArrears', 'Emp_Profile.EmployeeID', '=', 'PayrollArrears.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollArrears.ArrearDate', 'desc')->select('Emp_Profile.Name', 'PayrollArrears.*', 'Emp_Register.EmployeeCode', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.Salary')->where('PayrollArrears.CompanyID', '=', company_id())->where('Emp_Profile.Name', 'LIKE', '%' . $request->keyword1 . '%')->where('PayrollArrears.IsDeleted', '!=', '1')->orwhere('Emp_Register.EmployeeCode', 'LIKE', '%' . $request->keyword1 . '%')->where('PayrollArrears.IsDeleted', '!=', '1')->where('PayrollArrears.CompanyID', '=', company_id())->paginate(15);
        return response()->json($arr);
    }

    public function submit_bonus(Request $request)
    {
        $emp_id = $request->get('emp_emp_id');
        $emp_amount = $request->get('emp_amount');
        $emp_description = $request->get('emp_description');
        $emp_date = $request->get('emp_date');
        $session_name = $request->get('session_name');

        $update_date = long_date();

        for ($x = 0; $x < count($emp_id); $x++) {

            $se = explode("_", $emp_id[$x]);

            $find_employee_id = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeCode', '=', $se[1])->get();
            foreach ($find_employee_id as $find_employee_id1) {
            }

            $sub_emp_id = $find_employee_id1->EmployeeID;
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Bonuse Applied', ' Bonuse of ' . $sub_emp_id . ' applied', $update_date]);

            $result = DB::connection('sqlsrv2')->insert("INSERT INTO PayrollBonuses(CompanyID, EmployeeID, SessionName, BonusDate, BonusAmount, Descriptions,Status, CreatedBy, CreatedOn) values (?,?,?,?,?,?,?,?,?)", [company_id(), $sub_emp_id, $session_name, $emp_date, $emp_amount, $emp_description, 'Pending', username(), $update_date]);
        }
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollBonuses', 'Emp_Profile.EmployeeID', '=', 'PayrollBonuses.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollBonuses.BonusDate', 'desc')->select('Emp_Profile.Name', 'PayrollBonuses.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollBonuses.CompanyID', '=', company_id())->paginate(15);

        return request()->json(200, $arr);
    }

    public function fetch_payroll_bonus()
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollBonuses', 'Emp_Profile.EmployeeID', '=', 'PayrollBonuses.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollBonuses.BonusDate', 'desc')->select('Emp_Profile.Name', 'PayrollBonuses.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollBonuses.CompanyID', '=', company_id())->paginate(15);

        return request()->json(200, $arr);
    }

    public function approve_bonus($id)
    {
        $update_date = long_date();
        $id_arr = DB::connection('sqlsrv2')->table('PayrollBonuses')->select('EmployeeID')->where('BonusID', '=', $id)->where('CompanyID', '=', company_id())->get();
        foreach ($id_arr as $id_arr1) {
        }
        $emp_id = $id_arr1->EmployeeID;
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Bonuse Status Changed', ' Bonuse of ' . $emp_id . ' approved', $update_date]);

        $result = DB::connection('sqlsrv2')->update('update PayrollBonuses set Status=?, ApprovedBy=? where BonusID=? and CompanyID=?', ['Approved', username(), $id, company_id()]);
        if ($result) {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollBonuses', 'Emp_Profile.EmployeeID', '=', 'PayrollBonuses.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollBonuses.BonusDate', 'desc')->select('Emp_Profile.Name', 'PayrollBonuses.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollBonuses.CompanyID', '=', company_id())->paginate(15);

            return request()->json(200, $arr);
        }
    }

    public function find_payroll_bonus($id)
    {

        $result = DB::connection('sqlsrv2')->table('PayrollBonuses')->where('CompanyID', '=', company_id())->where('BonusID', '=', $id)->get();
        return request()->json(200, $result);
    }

    public function find_EmpFuelAllowance($id)
    {

        $result = DB::connection('sqlsrv2')->table('Emp_FuelAllowance')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $id)->where('isDeleted', '!=', '1')->get();
        return request()->json(200, $result);
    }

    protected function getValidationRules2()
    {
        return [
            'edit_amount' => 'required|numeric|gt:0|lt:1000',
            'edit_emp_id' => 'required',
        ];
    }

    public function update_EmpFuelAllowance(Request $request)
    {
        try {
            $request->validate($this->getValidationRules2());
            $result = DB::connection('sqlsrv2')
                ->table('Emp_FuelAllowance')
                ->where('EmployeeID', $request->edit_emp_id)
                ->where('CompanyID', company_id())
                ->update([
                    'FuelQuantity' => $request->edit_amount,
                    'FuelType' => $request->edit_emp_FuelType,
                    'UpdatedBy' => username(),
                    'UpdatedOn' => long_date()
                ]);
            if ($result) {

                return $this->sendSuccess('Employee Fuel Allowance Updated');
                insertLog('Emp Fuel Allowance updated  ', 'Emp Fuel Allowance of ' . $request->edit_emp_id . 'Deleted ');
            } else {
                return $this->sendError('Employee Fuel Allowance not Updated');
            }
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    protected function getValidationRules1()
    {
        return [
            'edit_PetrolRate' => 'required|numeric|gt:0|lt:1000',
            'edit_DieselRate' => 'required|numeric|gt:0|lt:1000',
            'edit_HOBCRate' => 'required|numeric|gt:0|lt:1000',
        ];
    }

    public function update_FuelRate(Request $request)
    {
        try {

            $request->validate($this->getValidationRules1());

            $fuelId = DB::connection('sqlsrv2')
                ->table('FuelRate')
                ->insertgetId([
                    'CompanyID' => company_id(),
                    'PetrolRate' => $request->get('edit_PetrolRate'),
                    'DieselRate' => $request->get('edit_DieselRate'),
                    'HOBCRate' => $request->get('edit_HOBCRate'),
                    'CreatedBy' => username(),
                    'CreatedOn' => long_date(),
                ]);
            $result = DB::connection('sqlsrv2')->update('update FuelRate set IsCurrent=? where ID != ? and CompanyID=?', [0, $fuelId, company_id()]);
            if ($result) {
                return $this->sendSuccess("Fuel Rate Updated");
            } else {
                return $this->sendError("Fuel Rate Not Updated");
            }
            insertLog('Fuel Rate Updated', 'New Fuel Rate with ID ' . $fuelId . 'Added');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    public function update_ind_bonus(Request $request)
    {
        $emp_id = $request->get('edit_emp_id');
        $emp_amount = $request->get('edit_amount');
        $emp_description = $request->get('edit_description');
        $emp_date = $request->get('edit_date');
        $session_name = $request->get('edit_session_name');
        $edit_arrear_id = $request->get('edit_arrear_id');

        $update_date = long_date();

        $result = DB::connection('sqlsrv2')->update('update PayrollBonuses set EmployeeID=?, BonusDate=?, BonusAmount=?, Descriptions=? where BonusID=? and CompanyID=?', [$emp_id, $emp_date, $emp_amount, $emp_description, $edit_arrear_id, company_id()]);

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Bonuse updated', 'Bonuse of ' . $emp_id . ' updated', $update_date]);

        if ($result) {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollBonuses', 'Emp_Profile.EmployeeID', '=', 'PayrollBonuses.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollBonuses.BonusDate', 'desc')->select('Emp_Profile.Name', 'PayrollBonuses.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollBonuses.CompanyID', '=', company_id())->paginate(15);

            return request()->json(200, $arr);
        }
    }


    public function submit_dues(Request $request)
    {


        $emp_id = $request->get('emp_emp_id');
        $emp_amount = $request->get('emp_amount');

        $emp_description = $request->get('emp_description');
        $emp_date = $request->get('emp_date');
        $session_name = $request->get('session_name');
        $dues_type = $request->get('dues_type');
        $insertedData = [];
        $update_date = long_date();

        for ($x = 0; $x < count($emp_id); $x++) {
            $se = explode("_", $emp_id[$x]);
            $find_employee_id = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeCode', '=', $se[1])->get();
            foreach ($find_employee_id as $find_employee_id1) {
            }

            $sub_emp_id = $find_employee_id1->EmployeeID;
            // $result = DB::connection('sqlsrv2')->insert("INSERT INTO PayrollDues(CompanyID,EmployeeID,SessionName,DuesType,DuesDate,DuesAmount,Descriptions,Status,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?,?,?)", [company_id(), $sub_emp_id, $session_name, $dues_type, $emp_date, $emp_amount, $emp_description, 'Pending', username(), $update_date]);
            $result = DB::connection('sqlsrv2')->table('PayrollDues')
                ->insertGetId([
                    'CompanyID' => company_id(),
                    'EmployeeID' => $sub_emp_id,
                    'SessionName' => $session_name,
                    'DuesType' => $dues_type,
                    'DuesDate' => $emp_date,
                    'DuesAmount' => $emp_amount,
                    'Descriptions' => $emp_description,
                    'Status' => 'Pending',
                    'CreatedBy' => username(),
                    'CreatedOn' => $update_date,
                ]);

            $insertedData[] = $result;

            $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')
                ->select('Name')->where('EmployeeID', '=', $sub_emp_id)->where('CompanyID', '=', company_id())->get();
            foreach ($full_name_arr as $full_name_arr1) {
            }
            $full_name = $full_name_arr1->Name;

            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Dues Applied', ' Dues of ' . $full_name . ' applied', $update_date]);
        }
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollDues', 'Emp_Profile.EmployeeID', '=', 'PayrollDues.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollDues.DuesDate', 'desc')->select('Emp_Profile.Name', 'PayrollDues.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollDues.CompanyID', '=', company_id())->paginate(100);
        // return request()->json(200, $arr);
        $arr = DB::connection('sqlsrv2')->table('PayrollDues')
            ->join('Emp_Profile', 'Emp_Profile.EmployeeID', '=', 'PayrollDues.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->whereIn('DuesID', $insertedData)
            ->select('Emp_Profile.Name', 'PayrollDues.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')
            ->get();

        return request()->json(200, $arr);
    }

    public function fetch_payroll_dues(Request $request)
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollDues', 'Emp_Profile.EmployeeID', '=', 'PayrollDues.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollDues.DuesDate', 'desc')->select('Emp_Profile.Name', 'PayrollDues.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollDues.CompanyID', '=', company_id())->where('Emp_Profile.Name', 'like', '%' . $request->keyword1 . '%')->paginate(15);
        return request()->json(200, $arr);
    }

    public function find_payroll_dues($id)
    {

        $result = DB::connection('sqlsrv2')->table('PayrollDues')->where('CompanyID', '=', company_id())->where('DuesID', '=', $id)->get();
        return request()->json(200, $result);
    }

    public function update_ind_dues(Request $request)
    {

        $emp_id = $request->get('edit_emp_id');
        $emp_amount = $request->get('edit_amount');
        $emp_description = $request->get('edit_description');
        $emp_date = $request->get('edit_date');
        $session_name = $request->get('edit_session_name');
        $edit_arrear_id = $request->get('edit_arrear_id');
        $edit_dues_type = $request->get('edit_dues_type');

        $update_date = long_date();

        $full_name_arr = DB::connection('sqlsrv2')->table('Emp_Profile')->select('Name')->where('EmployeeID', '=', $emp_id)->where('CompanyID', '=', company_id())->get();
        foreach ($full_name_arr as $full_name_arr1) {
        }
        $full_name = $full_name_arr1->Name;

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Dues updated', ' Dues of ' . $full_name . ' updated', $update_date]);

        $result = DB::connection('sqlsrv2')->update('update PayrollDues set EmployeeID=?,DuesType=?,DuesDate=?,DuesAmount=?,Descriptions=? where DuesID=? and CompanyID=?', [$emp_id, $edit_dues_type, $emp_date, $emp_amount, $emp_description, $edit_arrear_id, company_id()]);
        if ($result) {
            // $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollDues', 'Emp_Profile.EmployeeID', '=', 'PayrollDues.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollDues.DuesDate', 'desc')->select('Emp_Profile.Name', 'PayrollDues.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollDues.CompanyID', '=', company_id())->paginate(15);
            $arr = 'Arrears updated';
            return request()->json(200, $arr);
        }
    }

    public function approve_dues($id)
    {

        $update_date = long_date();
        $result = DB::connection('sqlsrv2')->update('update PayrollDues set Status=?,ApprovedBy=? where DuesID=? and CompanyID=?', ['Approved', username(), $id, company_id()]);
        if ($result) {
            $full_name_arr = DB::connection('sqlsrv2')->table('PayrollDues')
                ->join('Emp_Profile', 'PayrollDues.EmployeeID', '=', 'Emp_Profile.EmployeeID')
                ->select('Emp_Profile.Name')
                ->where('Emp_Profile.CompanyID', '=', company_id())->where('PayrollDues.DuesID', '=', $id)->get();
            foreach ($full_name_arr as $full_name_arr1) {
            }
            $full_name = $full_name_arr1->Name;
            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Dues Status Changed', ' Dues of ' . $full_name . ' approved', $update_date]);

            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollDues', 'Emp_Profile.EmployeeID', '=', 'PayrollDues.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollDues.DuesDate', 'desc')->select('Emp_Profile.Name', 'PayrollDues.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollDues.CompanyID', '=', company_id())->paginate(100);
            return request()->json(200, $arr);
        }
    }

    public function fetch_payroll_allowance()
    {
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollAllowance', 'Emp_Profile.EmployeeID', '=', 'PayrollAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollAllowance.ApplyDate', 'desc')->select('Emp_Profile.Name', 'PayrollAllowance.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollAllowance.CompanyID', '=', company_id())->paginate(350);
        return request()->json(200, $arr);
    }

    public function submit_allowance(Request $request)
    {

        $emp_id = $request->get('emp_emp_id');
        $emp_amount = $request->get('emp_amount');
        $emp_description = $request->get('emp_description');
        $emp_date = $request->get('emp_date');
        $session_name = $request->get('session_name');

        $update_date = long_date();
        $allowance_type = $request->get('allowance_type');

        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;

        for ($x = 0; $x < count($emp_id); $x++) {

            $se = explode("_", $emp_id[$x]);

            $find_employee_id = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeCode', '=', $se[1])->get();
            foreach ($find_employee_id as $find_employee_id1) {
            }

            $sub_emp_id = $find_employee_id1->EmployeeID;

            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Allowance Applied', ' Allowance of ' . $sub_emp_id . ' applied', $update_date]);

            $result = DB::connection('sqlsrv2')->insert("INSERT INTO PayrollAllowance(CompanyID,EmployeeID,StartSession,SessionEndDate,ApplyDate,AllowanceType,AllowanceAmount,Descriptions,Status,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?,?,?,?)", [company_id(), $sub_emp_id, $session_name, $e_date, $emp_date, $allowance_type, $emp_amount, $emp_description, 'Pending', username(), $update_date]);
        }
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollAllowance', 'Emp_Profile.EmployeeID', '=', 'PayrollAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollAllowance.ApplyDate', 'desc')->select('Emp_Profile.Name', 'PayrollAllowance.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollAllowance.CompanyID', '=', company_id())->paginate(350);
        return request()->json(200, $arr);
    }

    public function approve_allowance($id)
    {

        $update_date = long_date();
        $result = DB::connection('sqlsrv2')->update('update PayrollAllowance set Status=?,ApprovedBy=? where AllowanceID=? and CompanyID=?', ['Approved', username(), $id, company_id()]);
        $id_arr = DB::connection('sqlsrv2')->table('PayrollAllowance')->select('EmployeeID')->where('AllowanceID', '=', $id)->where('CompanyID', '=', company_id())->get();
        foreach ($id_arr as $id_arr1) {
        }
        $emp_id = $id_arr1->EmployeeID;
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Allowance Status Changed', ' Allowance of ' . $emp_id . ' approved', $update_date]);

        if ($result) {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollAllowance', 'Emp_Profile.EmployeeID', '=', 'PayrollAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollAllowance.ApplyDate', 'desc')->select('Emp_Profile.Name', 'PayrollAllowance.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollAllowance.CompanyID', '=', company_id())->paginate(350);
            return request()->json(200, $arr);
        }
    }

    public function find_payroll_allowance($id)
    {

        $result = DB::connection('sqlsrv2')->table('PayrollAllowance')->where('CompanyID', '=', company_id())->where('AllowanceID', '=', $id)->get();
        return request()->json(200, $result);
    }

    public function update_ind_allowance(Request $request)
    {

        $update_date = long_date();
        $emp_id = $request->get('edit_emp_id');
        $emp_amount = $request->get('edit_amount');
        $emp_description = $request->get('edit_description');
        $emp_date = $request->get('edit_date');
        $session_name = $request->get('edit_session_name');
        $edit_arrear_id = $request->get('edit_bonus_id');
        $edit_allowance_type = $request->get('edit_allowance_type');


        $result = DB::connection('sqlsrv2')->update('update PayrollAllowance set EmployeeID=?, ApplyDate=?, AllowanceType=?, AllowanceAmount=?, Descriptions=? where AllowanceID=? and CompanyID=?', [$emp_id, $emp_date, $edit_allowance_type, $emp_amount, $emp_description, $edit_arrear_id, company_id()]);

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Allowance updated', 'Allowance of ' . $emp_id . ' updated', $update_date]);

        if ($result) {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollAllowance', 'Emp_Profile.EmployeeID', '=', 'PayrollAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollAllowance.ApplyDate', 'desc')->select('Emp_Profile.Name', 'PayrollAllowance.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollAllowance.CompanyID', '=', company_id())->paginate(350);
            return request()->json(200, $arr);
        }
    }

    public function filter_leaves_byId(Request $request)
    {
        $leaveBalanceQuery = DB::connection('sqlsrv2')->table('Emp_Profile')->join('EmpLeave', 'Emp_Profile.EmployeeID', '=', 'EmpLeave.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('Emp_Register.EmployeeCode', 'asc')
            ->selectRaw("Emp_Register.EmployeeID, Emp_Register.employeecode, Emp_Profile.Name, Emp_Profile.Photo, Emp_Register.department, Emp_Register.Designation, SUM(CASE WHEN EmpLeave.LeaveType = 'casual' THEN TotalLeave ELSE 0 END) AS casualtotal, SUM(CASE WHEN LeaveType = 'casual' THEN RemainingLeave ELSE 0 END) AS casualremaining, SUM(CASE WHEN LeaveType = 'sick' THEN TotalLeave ELSE 0 END) AS sicktotal, SUM(CASE WHEN LeaveType = 'sick' THEN RemainingLeave ELSE 0 END) AS sickremaining, SUM(CASE WHEN LeaveType = 'Annual' THEN TotalLeave ELSE 0 END) AS Annualtotal, SUM(CASE WHEN LeaveType = 'Annual' THEN RemainingLeave ELSE 0 END) AS Annualremaining")
            ->whereRaw(
                "(Emp_Register.EmployeeCode like ? or Emp_Profile.Name like ?) and EmpLeave.CreatedOn like ? and EmpLeave.CompanyID = ?",
                ['%' . $request->emp_name_code . '%', '%' . $request->emp_name_code . '%', '%' . date("Y") . '%', company_id()]
            )->groupby('Emp_Register.EmployeeID', 'Emp_Register.employeecode', 'Emp_Profile.Name', 'Emp_Profile.Photo', 'Emp_Register.department', 'Emp_Register.Designation');


        if (emp_department() == 'Software Development' || emp_department() == 'Human Resource') {
            return $leaveBalanceQuery->paginate(20);
        } else {
            $employeeIDs = array_column(reporting_team(), 'EmployeeID');
            return $leaveBalanceQuery->whereIn('Emp_Register.EmployeeID', $employeeIDs)->paginate(20);
        }


        //        ->paginate(20);
        return request()->json(200, $arr);
    }

    //Functions
    public function session_att()
    {


        $today = date("Y-m-d");

        $p = 'P';
        $a = 'A';
        $l = 'L';
        $result = DB::connection('sqlsrv2')->select("select Department, count (Department) as TotalEmployee ,
                sum(case when AttStatus = '" . $p . "' then 1 else 0 end) AS Present,
                sum(case when AttStatus = '" . $a . "' then 1 else 0 end) AS Absent,
              sum(case when AttStatus = '" . $l . "' then 1 else 0 end) AS Leave
              from  Emp_Register er
              join Attdata ad  on  er.EmployeeCode = ad.EmpCode
              where ATTDate = '$today'
               group by Department");

        return request()->json(200, $result);
    }


    public function hrdb_employee_count(Request $request)
    {


        $date = date("Y-m-d");

        $male = DB::connection('sqlsrv2')->table('Emp_Profile')->where('Gender', '=', "Male")->where('CompanyID', '=', company_id())->count();
        $female = DB::connection('sqlsrv2')->table('Emp_Profile')->where('Gender', '=', "Female")->where('CompanyID', '=', company_id())->count();
        $all_emp = DB::connection('sqlsrv2')->table('Emp_Profile')->where('CompanyID', '=', company_id())->count();

        $sus_emp = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Emp_Register.Status', '=', "Suspended")->where('Emp_Register.RegDate', '<=', $date)->where('Emp_Profile.CompanyID', '=', company_id())->count();
        $sus_emp_percentage = round((float)($sus_emp / $all_emp) * 100, 1);

        $exp_date = date('Y-m-d', strtotime($date . " + 30 days"));
        $cnic_exp_emp = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Emp_Profile.CnicExpiry', '<=', $exp_date)->where('Emp_Profile.CompanyID', '=', company_id())->count();

        $status_exp_emp = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->where('Emp_Register.ProbationEnd', '<=', $exp_date)->where('Emp_Register.JobStatus', '=', 'Probation')->where('Emp_Profile.CompanyID', '=', company_id())->count();

        $myJSON = array(
            'males' => $male,
            'females' => $female,
            'all' => $all_emp,
            'suspended' => $sus_emp,
            'sus_per' => $sus_emp_percentage,
            'cnic_exp_cnt' => $cnic_exp_emp,
            'status_exp_cnt' => $status_exp_emp,
        );
        return request()->json(200, $myJSON);
    }

    public function job_exp_employee(Request $request)
    {
        $date = date("Y-m-d");

        $exp_date = date('Y-m-d', strtotime($date . " + 30 days"));

        $job_exp_emp = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('Emp_Register.ProbationEnd', 'desc')
            ->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode', 'Emp_Register.Status', 'Emp_Register.JobStatus', 'Emp_Register.Designation', 'Emp_Register.Department', 'Emp_Register.ProbationEnd')
            ->where('Emp_Register.ProbationEnd', '<=', $exp_date)
            ->where('Emp_Register.JobStatus', '=', 'Probation')
            ->where('Emp_Profile.CompanyID', '=', company_id())->get();
        return request()->json(200, $job_exp_emp);
    }

    public function get_gracePeriods($designation, $location, $department)
    {


        if ($designation == 'All' && $department == 'All' && $location == 'All') {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('EmpGraceHours', 'Emp_Profile.EmployeeID', '=', 'EmpGraceHours.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('EmpGraceHours.EmployeeID', 'desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'EmpGraceHours.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('EmpGraceHours.CompanyID', '=', company_id())->paginate(15);
            return request()->json(200, $arr);
        } else {
            if ($department == 'All') {
                $department = '';
            }
            if ($designation == 'All') {
                $designation = '';
            }
            if ($location == 'All') {
                $location = '';
            }
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('EmpGraceHours', 'Emp_Profile.EmployeeID', '=', 'EmpGraceHours.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('EmpGraceHours.EmployeeID', 'desc')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'EmpGraceHours.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('Emp_Register.Designation', 'like', '%' . $designation . '%')->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')->where('Emp_Register.Department', 'like', '%' . $department . '%')->where('EmpGraceHours.CompanyID', '=', company_id())->paginate(15);
            return request()->json(200, $arr);
        }
    }

    public function cnic_exp_employee(Request $request)
    {


        $date = date("Y-m-d");

        $exp_date = date('Y-m-d', strtotime($date . " + 30 days"));

        $cnic_exp_emp = DB::connection('sqlsrv2')
            ->table('Emp_Profile')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('Emp_Register.ProbationEnd', 'desc')
            ->select('Emp_Profile.Name', 'Emp_Register.EmployeeCode', 'Emp_Register.Status', 'Emp_Register.Designation', 'Emp_Register.Department', 'Emp_Profile.CnicExpiry')
            ->where('Emp_Profile.CnicExpiry', '<=', $exp_date)
            ->where('Emp_Profile.CompanyID', '=', company_id())->get();
        return request()->json(200, $cnic_exp_emp);
    }


    // getting annual leave data
    public function count_leaves_d()
    {
        $leaves = DB::connection('sqlsrv2')
            ->table('EmpLeave')
            ->selectRaw("
            SUM(CASE WHEN LeaveType = 'Annual' THEN TotalLeave ELSE 0 END) AS Annual,
            SUM(CASE WHEN LeaveType = 'Casual' THEN TotalLeave ELSE 0 END) AS Casual,
            SUM(CASE WHEN LeaveType = 'Sick' THEN TotalLeave ELSE 0 END) AS Sick,
            SUM(CASE WHEN LeaveType = 'Maternity' THEN TotalLeave ELSE 0 END) AS Maternity,
            SUM(CASE WHEN LeaveType = 'Paternity' THEN TotalLeave ELSE 0 END) AS Paternity,
            SUM(CASE WHEN LeaveType = 'Hajj/Ziarat' THEN TotalLeave ELSE 0 END) AS Hajj_Ziarat
        ")
            ->first();

        return response()->json([
            $leaves->Annual,
            $leaves->Casual,
            $leaves->Sick,
            $leaves->Maternity,
            $leaves->Paternity,
            $leaves->Hajj_Ziarat
        ]);
    }

    public function return_loan(Request $request)
    {
        $loanid = $request->get('loanid');
        $pay_emp_id = $request->get('pay_emp_id');
        $pay_type = $request->get('pay_type');
        $return_amount = $request->get('return_amount');
        $addreturn = $request->get('addreturn');

        $update_date = long_date();
        $doc_date = date("Y-m-d");
        $addreturn1 = explode("|", $addreturn);
        for ($x = 1; $x < count($addreturn1); $x++) {
            $addretur = explode("|", $addreturn);
        }
        $get_ins = DB::connection('sqlsrv2')->table('LoanDetail')->orderBy('DetailId', 'asc')->where('CompanyID', '=', company_id())->where('LoanId', '=', $loanid)->where('InstallmentStatus', '=', 'Unpaid')->get();
        $index = 0;
        foreach ($get_ins as $get_ins1) {
            $index++;
            if ($addretur[$index] == 'true') {
                DB::connection('sqlsrv2')->update('update LoanDetail set InstallmentStatus=?, UpdatedOn=?, UpdatedBy=? where LoanId=? AND CompanyID=? AND DetailId=?', ['Returned', $update_date, username(), $loanid, company_id(), $get_ins1->DetailId]);
            }
        }
        /*
        $amt_clt = DB::connection('sqlsrv2')->table('LoanDetail')->where('CompanyID','=', company_id())->where('LoanId','=', $loanid)->where('InstallmentStatus','=', 'Unpaid')->count();
        if($amt_clt == 0){
            DB::connection('sqlsrv2')->update('update LoanRequisition set  ReqStatus=?, UpdatedOn=?, UpdatedBy=? where LoanId=? AND CompanyID=?',['Returned', $update_date, username(), $loanid,company_id()]);
        }
        */
        if (Session::get('company_accounts_plan') == 'true') {
            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $loanid, 'Loan Return Against ' . $pay_emp_id . ' to ' . username(), 'Emplyee Loan', $update_date, username(), company_id()]);
            if ($doc) {

                $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', strval($loanid))->first();

                DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Loan Return Against ' . $pay_emp_id . ' to ' . username(), company_id()]);

                $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                foreach ($find_tran_id as $find_tran_id1) {
                }

                //find_Account id
                DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '101002001001', 'C', $return_amount, company_id()]);
                DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '101001001001', 'D', $return_amount, company_id()]);
            }
        }
        $emp_code_arr = DB::connection('sqlsrv2')->table('Emp_Register')->select('EmployeeCode')->where('EmployeeID', '=', $pay_emp_id)->where('CompanyID', '=', company_id())->get();
        foreach ($emp_code_arr as $emp_code_arr1) {
        }
        $emp_code = $emp_code_arr1->EmployeeCode;
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), $pay_type . ' Returned', $pay_type . ' of ' . $emp_code . ' Returned', $update_date]);
        $message = "Loan returned!";
        return request()->json(200, $message);
    }

    public function submit_warn_reas(Request $request)
    {
        $reason_name = $request->get('reason_name');
        $reason_desc = $request->get('reason_desc');

        $update_date = long_date();

        DB::connection('sqlsrv2')->insert("INSERT INTO Warning_Reason(ReasonName, ReasonContent, CreatedBy, CreatedOn, CompanyID) values (?,?,?,?,?)", [$reason_name, $reason_desc, username(), $update_date, company_id()]);
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Warning Reason added', 'Warning Reason ' . $reason_name . ' added', $update_date]);

        $arr = DB::connection('sqlsrv2')->table("Warning_Reason")->where('CompanyID', '=', company_id())->orderBy('ReasonID', 'desc')->paginate(5);
        return request()->json(200, $arr);
    }

    public function warning_Detail1($id)
    {
        $warning_reason_arr = DB::connection('sqlsrv2')->table('Warning_Reason')->Select('ReasonContent')->where('CompanyID', '=', company_id())->where('ReasonName', '=', $id)->get();
        return request()->json(200, $warning_reason_arr);
    }

    public function delete_warn_reas($id)
    {
        $update_date = long_date();
        $warning_reason_arr = DB::connection('sqlsrv2')->table('Warning_Reason')->where('CompanyID', '=', company_id())->where('ReasonID', '=', $id)->get();
        foreach ($warning_reason_arr as $warning_reason_arr1) {
        }
        $warning_reason = $warning_reason_arr1->ReasonName;

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Delete Warning Reason', 'Warning Reason ' . $warning_reason . ' deleted', $update_date]);


        $result = DB::connection('sqlsrv2')->table('Warning_Reason')->where('ReasonID', $id)->delete();

        if ($result) {


            $arr = DB::connection('sqlsrv2')->table("Warning_Reason")->where('CompanyID', '=', company_id())->orderBy('ReasonID', 'desc')->paginate(5);
            return request()->json(200, $arr);
        }
    }

    public function warning_reason()
    {

        $arr = DB::connection('sqlsrv2')->table("Warning_Reason")->where('CompanyID', '=', company_id())->orderBy('ReasonID', 'desc')->paginate(5);
        return request()->json(200, $arr);
    }

    public function update_set_sts(Request $request)
    {


        $update_date = long_date();
        $usid = $request->get('usid');
        $man = $request->get('man');
        $us_man = $request->get('us_man');
        $doc_date = date("Y-m-d");

        if ($man == 'hr') {
            DB::connection('sqlsrv2')->update('update FinalSettlement set HrStatus=?, UpdatedOn=?, UpdatedBy=? where ID=? and CompanyID=?', [$us_man, $update_date, username(), $usid, company_id()]);
            $data = "Final settlement " . $us_man . " successfully by HR Manager!";
        } else if ($man == 'finance') {
            if ($us_man == 'Approved') {
                $result = DB::connection('sqlsrv2')->update('update FinalSettlement set FStatus=?,Status=?, UpdatedOn=?, UpdatedBy=? where ID=? and CompanyID=?', [$us_man, $us_man, $update_date, username(), $usid, company_id()]);
                if ($result) {
                    if (Session::get('company_accounts_plan') == 'true') {
                        $save_ledger = DB::connection('sqlsrv2')->table('FinalSettlement')->join('Emp_Profile', 'Emp_Profile.EmployeeID', '=', 'FinalSettlement.EmployeeID')->join('Emp_Register', 'Emp_Register.EmployeeID', '=', 'FinalSettlement.EmployeeID')->select('FinalSettlement.*', 'Emp_Profile.Name', 'Emp_Register.EmployeeCode')->where('FinalSettlement.CompanyID', '=', company_id())->where('FinalSettlement.ID', '=', $usid)->get();
                        foreach ($save_ledger as $save_ledger1) {
                            $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, 'Final Settlement ' . $save_ledger1->EmployeeCode, 'Final Settlement of ' . $save_ledger1->EmployeeCode . ':' . $save_ledger1->Name . '', 'Final Settlement', $update_date, username(), company_id()]);
                            if ($doc) {
                                $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', 'Final Settlement ' . $save_ledger1->EmployeeCode)->get();
                                foreach ($find_doc_id as $find_doc_id1) {
                                }

                                $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Final Settlement of ' . $save_ledger1->EmployeeCode . ':' . $save_ledger1->Name . '', company_id()]);
                                $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                                foreach ($find_tran_id as $find_tran_id1) {
                                }

                                //find_Account id
                                if ($save_ledger1->SettlementAmount != 0) {
                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '504002009', 'D', $save_ledger1->SettlementAmount, company_id()]);
                                }

                                if ($save_ledger1->Gratuity != 0) {
                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '504002009', 'D', $save_ledger1->Gratuity, company_id()]);
                                }

                                if ($save_ledger1->AllowanceAmount != 0) {
                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '504001002', 'D', $save_ledger1->AllowanceAmount, company_id()]);
                                }
                                if ($save_ledger1->BonusAmount != 0) {
                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '504001003', 'D', $save_ledger1->BonusAmount, company_id()]);
                                }

                                if ($save_ledger1->ArrearsAmount != 0) {
                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '504001005', 'D', $save_ledger1->ArrearsAmount, company_id()]);
                                }
                                if ($save_ledger1->LoanAmount != 0) {
                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '101002001001', 'C', $save_ledger1->LoanAmount, company_id()]);
                                }


                                if ($save_ledger1->Fine != 0 || $save_ledger1->DuesAmount != 0) {
                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '101002001004', 'C', $save_ledger1->Fine + $save_ledger1->DuesAmount, company_id()]);
                                }


                                if ($save_ledger1->PayableSalary != 0) {
                                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '201002001002', 'C', $save_ledger1->PayableSalary, company_id()]);
                                }
                            }
                        }

                        //}


                    }
                } //result


                $data = "Final settlement " . $us_man . " successfully by Finance Manager!";
            } else {
                $result = DB::connection('sqlsrv2')->update('update FinalSettlement set FStatus=?,Status=?, UpdatedOn=?, UpdatedBy=? where ID=? and CompanyID=?', [$us_man, $us_man, $update_date, username(), $usid, company_id()]);

                $data = "Final settlement " . $us_man . " successfully by Finance Manager!";
            }
        } else if ($man == 'distribution') {
            DB::connection('sqlsrv2')->update('update FinalSettlement set DStatus=?, UpdatedOn=?, UpdatedBy=? where ID=? and CompanyID=?', [$us_man, $update_date, username(), $usid, company_id()]);
            if ($us_man == 'Approved') {
                DB::connection('sqlsrv2')->update('update FinalSettlement set Status=?, UpdatedOn=?, UpdatedBy=? where ID=? and CompanyID=?', ['Approved', $update_date, username(), $usid, company_id()]);
            }
            $data = "Final settlement " . $us_man . " successfully by Salary distribution department!";
        } else {
            $data = "Final settlement's status not updated!";
        }
        if ($us_man == "Rejected") {
            DB::connection('sqlsrv2')->update('update FinalSettlement set Status=?, UpdatedOn=?, UpdatedBy=? where ID=? and CompanyID=?', [$us_man, $update_date, username(), $usid, company_id()]);
        }
        return request()->json(200, $data);
    }


    //fetch rel settlement
    public function fetch_rel_settlement($cid)
    {


        $final_settlement = DB::connection('sqlsrv2')->table('FinalSettlement')->join('Emp_Profile', 'FinalSettlement.EmployeeID', '=', 'Emp_Profile.EmployeeID')->select('FinalSettlement.*', 'Emp_Profile.Name')->orderBy('FinalSettlement.ID', 'desc')->where('FinalSettlement.CompanyID', '=', company_id())->where('FinalSettlement.ID', '=', $cid)->get();
        return request()->json(200, $final_settlement);
    }

    public function emp_set_detail($id)
    {


        $emp_detail = DB::connection('sqlsrv2')->table('Emp_Profile')->join('FinalSettlement', 'Emp_Profile.EmployeeID', '=', 'FinalSettlement.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeID')->where('FinalSettlement.CompanyID', '=', company_id())->where('FinalSettlement.ID', '=', $id)->select('Emp_Profile.*', 'Emp_Register.*')->get();
        return request()->json(200, $emp_detail);
    }

    public function set_reporting($id1)
    {

        $id_arr = DB::connection('sqlsrv2')->table('FinalSettlement')->where('ID', '=', $id1)->select('EmployeeID')->get();
        foreach ($id_arr as $id_arr1) {
        }
        $id = $id_arr1->EmployeeID;

        $email_arr = DB::connection('sqlsrv2')->table('FinalSettlement')->join('Emp_Register', 'FinalSettlement.EmployeeID', '=', 'Emp_Register.EmployeeID')->join('Emp_Profile', 'Emp_Register.ReportingTo', '=', 'Emp_Profile.EmployeeID')->where('FinalSettlement.ID', '=', $id1)->select('Emp_Profile.Name')->get();
        foreach ($email_arr as $email_arr1) {
        }
        $name = $email_arr1->Name;

        $rep1ArrCheck = DB::connection('sqlsrv2')->table('Emp_Register')
            ->join('Emp_Profile', 'Emp_Register.ReportingTo', '=', 'Emp_Profile.EmployeeID')
            ->select('Emp_Profile.Name')->where('Emp_Register.CompanyID', '=', company_id())->where('Emp_Register.EmployeeID', '=', $id)->exists();
        if ($rep1ArrCheck) {
            $rep1Arr = DB::connection('sqlsrv2')->table('Emp_Register')->join('Emp_Profile', 'Emp_Register.ReportingTo', '=', 'Emp_Profile.EmployeeID')->select('Emp_Profile.Name')->where('Emp_Register.CompanyID', '=', company_id())->where('Emp_Register.EmployeeID', '=', $id)->get();
            foreach ($rep1Arr as $arr1) {
            }
            $rep1 = $arr1->Name;
        } else {
            $rep1 = "Not Assigned";
        }

        $rep2ArrCheck = DB::connection('sqlsrv2')->table('Emp_Register')->join('Emp_Profile', 'Emp_Register.ReportingTo2', '=', 'Emp_Profile.EmployeeID')->select('Emp_Profile.Name')->where('Emp_Register.CompanyID', '=', company_id())->where('Emp_Register.EmployeeID', '=', $id)->exists();

        if ($rep2ArrCheck) {
            $rep2Arr = DB::connection('sqlsrv2')->table('Emp_Register')->join('Emp_Profile', 'Emp_Register.ReportingTo2', '=', 'Emp_Profile.EmployeeID')->select('Emp_Profile.Name')->where('Emp_Register.CompanyID', '=', company_id())->where('Emp_Register.EmployeeID', '=', $id)->get();
            foreach ($rep2Arr as $arr2) {
            }
            $rep2 = $arr2->Name;
        } else {
            $rep2 = "Not Assigned";
        }

        $rep = array(
            'rep1' => $rep1,
            'rep2' => $rep2,
            'created_by' => $name,
        );
        return request()->json(200, $rep);
    }

    public function pay_settlement(Request $request)
    {
        $update_date = long_date();
        $doc_date = date("Y-m-d");
        $usid = $request->get('usid');
        $us_man = $request->get('us_man');
        $cash_amount = $request->get('cash_amount');
        $bank_amount = $request->get('bank_amount');
        $cash_type = $request->get('cash_type');
        $bank_type = $request->get('bank_type');

        $cash_ty = explode("_", $cash_type);
        $bank_typ = explode("_", $bank_type);
        $cashinhand_balance = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
        @Datefrom = N'2000-01-01',
        @DateTo = N'" . $doc_date . "',
        @id = " . $cash_ty[0] . ",
        @compid = N'" . company_id() . "'  ");
        foreach ($cashinhand_balance as $cashinhand_balance1) {
        }
        if ($cash_type == '101001001001_Cash in Hand' && $cashinhand_balance1->am <= 0) {
            $find_config = 'Not Suficient Balance';
            return request()->json(200, $find_config);
        }

        $final_PoCode = PVID();

        if ($us_man == 'Paid') {
            DB::connection('sqlsrv2')->update('update FinalSettlement set CashID=?, BankID=?, ReceivedThrough=?, ReceivedTime=?, CashAmount=?,  BankAmount=?, Status=?, UpdatedOn=?, UpdatedBy=?,PVID=? where ID=? and CompanyID=?', [$cash_ty[0], $bank_typ[0], username(), $update_date, $cash_amount, $bank_amount, 'Paid', $update_date, username(), $final_PoCode, $usid, company_id()]);

            if (Session::get('company_accounts_plan') == 'true') {
                $id_arr1 = DB::connection('sqlsrv2')->table('FinalSettlement')->where('ID', '=', $usid)->where('CompanyID', '=', company_id())->first();
                insert_sequencevoucher($final_PoCode, $usid, 'Final Settlement');

                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode, 'Final Settlement Against Employee ID: ' . $id_arr1->EmployeeID . '', 'Final Settlement', $update_date, username(), company_id()]);


                if ($doc) {
                    $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode)->first();
                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Final Settlement Against Employee ID: ' . $id_arr1->EmployeeID . '', company_id()]);
                    $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->first();

                    DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '201002001002', 'D', $id_arr1->PayableSalary, company_id()]);
                    if ($cash_amount > 0) {
                        DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $cash_ty[0], 'C', $cash_amount, company_id()]);
                    }
                    if ($bank_amount > 0) {
                        DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, $bank_typ[0], 'C', $bank_amount, company_id()]);
                    }
                    $Settlement = DB::connection('sqlsrv2')->table('FinalSettlement')->where('ID', '=', $usid)->where('CompanyID', '=', company_id())->first();
                    //                    dd($Settlement);
                    DB::connection('sqlsrv2')->table('Payroll_Distribution')
                        ->where('EmployeeID', $Settlement->EmployeeID)
                        ->where('CompanyID', company_id())
                        ->where('SalaryStatus', 'Not Received')
                        ->update([
                            'SalaryStatus' => 'Settled',
                            'UpdatedBy' => username(),
                            'UpdatedOn' => long_date()
                        ]);
                }
            } //accounts

            $data = "Final settlement has been paid successfully!";
            return request()->json(200, $data);
        } else {
            $data = "Final settlement has not been paid!";
            return request()->json(200, $data);
        }
    }

    public function settlement_by_filter($from_date, $to_date, $dept, $design, $name)
    {
        $dept = ($dept === 'All') ? '' : $dept;
        $design = ($design === 'All') ? '' : $design;
        $name = ($name === 'All') ? '' : $name;

        $result = DB::connection('sqlsrv2')->table('FinalSettlement')->join('Emp_Profile', 'FinalSettlement.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('Emp_Profile.Name', 'Emp_Profile.Photo', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'FinalSettlement.*')->orderBy('FinalSettlement.ID', 'desc')->where('FinalSettlement.ResignOn', '>=', $from_date)->where('FinalSettlement.ResignOn', '<=', $to_date)->where('Emp_Profile.Name', 'like', '%' . $name . '%')->where('Emp_Register.Department', 'like', '%' . $dept . '%')->where('Emp_Register.Designation', 'like', '%' . $design . '%')->where('FinalSettlement.IsDeleted', '!=', 1)->where('FinalSettlement.CompanyID', '=', company_id())->paginate(20);
        return request()->json(200, $result);
    }


    //PAYROLL
    public function fetch_payroll_tax()
    {

        $arr = DB::connection('sqlsrv2')->table('PayrollTax')->join('Emp_Profile', 'Emp_Profile.EmployeeID', '=', 'PayrollTax.EmployeeID')->join('Emp_Register', 'PayrollTax.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollTax.TaxID', 'desc')->select('Emp_Profile.Name', 'PayrollTax.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollTax.CompanyID', '=', company_id())->paginate(80);

        return request()->json(200, $arr);
    }

    public function search_payroll_tax(Request $request)
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollTax', 'Emp_Profile.EmployeeID', '=', 'PayrollTax.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollTax.ApplyDate', 'desc')->select('Emp_Profile.Name', 'PayrollTax.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollTax.CompanyID', '=', company_id())->where('Emp_Profile.Name', 'LIKE', '%' . $request->keyword1 . '%')->orwhere('Emp_Register.EmployeeCode', 'LIKE', '%' . $request->keyword1 . '%')->paginate(15);
        return request()->json(200, $arr);
    }

    public function submit_tax(Request $request)
    {


        $emp_id = $request->get('emp_emp_id');
        $emp_amount = $request->get('emp_amount');
        $emp_description = $request->get('emp_description');
        $emp_date = $request->get('emp_date');
        // $session_name=$request->get('session_name');


        $update_date = long_date();
        $allowance_type = 'Salary Tax';

        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;
        $session_name = $find_session1->SessionName;
        for ($x = 0; $x < count($emp_id); $x++) {

            $se = explode("_", $emp_id[$x]);

            $find_employee_id = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeCode', '=', $se[1])->get();
            foreach ($find_employee_id as $find_employee_id1) {
            }

            $sub_emp_id = $find_employee_id1->EmployeeID;

            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Tax Applied', ' Tax of ' . $sub_emp_id . ' applied', $update_date]);

            $result = DB::connection('sqlsrv2')->insert("INSERT INTO PayrollTax(CompanyID,EmployeeID,StartSession,SessionEndDate,ApplyDate,TaxType,TaxAmount,Descriptions,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?,?,?)", [company_id(), $sub_emp_id, $session_name, $e_date, $emp_date, $allowance_type, $emp_amount, $emp_description, username(), $update_date]);
        }
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollTax', 'Emp_Profile.EmployeeID', '=', 'PayrollTax.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollTax.ApplyDate', 'desc')->select('Emp_Profile.Name', 'PayrollTax.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollTax.CompanyID', '=', company_id())->paginate(15);
        return request()->json(200, $arr);
    }


    public function find_payroll_tax($id)
    {

        $result = DB::connection('sqlsrv2')->table('PayrollTax')->where('CompanyID', '=', company_id())->where('TaxID', '=', $id)->get();
        return request()->json(200, $result);
    }


    public function update_ind_tax(Request $request)
    {


        $update_date = long_date();

        $emp_id = $request->get('edit_emp_id');
        $emp_amount = $request->get('edit_amount');
        $emp_description = $request->get('edit_description');
        $emp_date = $request->get('edit_date');
        $session_name = $request->get('edit_session_name');
        $edit_arrear_id = $request->get('edit_bonus_id');


        $result = DB::connection('sqlsrv2')->update('update PayrollTax set EmployeeID=?, ApplyDate=?, TaxAmount=?, Descriptions=? where TaxID=? and CompanyID=?', [$emp_id, $emp_date, $emp_amount, $emp_description, $edit_arrear_id, company_id()]);

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Tax updated', 'Tax of ' . $emp_id . ' updated', $update_date]);

        if ($result) {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollTax', 'Emp_Profile.EmployeeID', '=', 'PayrollTax.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollTax.ApplyDate', 'desc')->select('Emp_Profile.Name', 'PayrollTax.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollTax.CompanyID', '=', company_id())->paginate(15);
            return request()->json(200, $arr);
        }
    }

    public function salary_report()
    {

        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $year = $find_session1->SessionName;


        $result = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC   [dbo].[Salary_Report_DepartmentWise]
        @SessionName = N'" . $year . "',
        @compid = N'" . company_id() . "'
      ");
        //  return request()->json(200,$result);
        $this->fpdf->AddPage("L", ['220', '297']);
        $this->fpdf->SetFont('Times', 'B', 22);
        $this->fpdf->SetTextColor(41, 46, 46);
        $fetch_image = DB::connection('sqlsrv3')->table('CompanyLogo')->where('CompanyID', '=', company_id())->get();
        foreach ($fetch_image as $fetch_image1) {
        }


        $this->fpdf->Image('public/images/logo/' . $fetch_image1->LeftLogo, 10, 7, 35, 17);
        $this->fpdf->Text(95, 17, 'All Companies Salary Report');
        $this->fpdf->Text(125, 27, $year);
        $this->fpdf->SetFont('Times', '', 14);
        $this->fpdf->SetTextColor(41, 46, 46);
        $this->fpdf->Image('public/images/logo/' . $fetch_image1->RightLogo, 233, 7, 43, 15);
        $this->fpdf->SetFont('Times', '', 10);
        $this->fpdf->ln(20);
        $this->fpdf->Cell(55, 6, 'Name', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Basic Salary', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Overtime', 1, 0, 'C', 0);
        $this->fpdf->Cell(18, 6, 'Allowance', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'i.Amount', 1, 0, 'C', 0);
        $this->fpdf->Cell(10, 6, 'Dues', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'TAmount', 1, 0, 'C', 0);
        $this->fpdf->Cell(15, 6, 'Advance', 1, 0, 'C', 0);
        $this->fpdf->Cell(12, 6, 'Arrears', 1, 0, 'C', 0);
        $this->fpdf->Cell(10, 6, 'Bonus', 1, 0, 'C', 0);
        $this->fpdf->Cell(10, 6, 'Fine', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Fuel Amount', 1, 0, 'C', 0);
        $this->fpdf->Cell(25, 6, 'Fuel Receivable', 1, 0, 'C', 0);
        $this->fpdf->Cell(20, 6, 'Payable', 1, 1, 'C', 0);

        foreach ($result as $get_req1) {
            $this->fpdf->Cell(55, 6, Str::substr($get_req1->Department, 0, 40), 1, 0, 'C', 0);

            $this->fpdf->Cell(20, 6, number_format($get_req1->Salary), 1, 0, 'C', 0);
            $this->fpdf->Cell(15, 6, number_format($get_req1->OAmount), 1, 0, 'C', 0);

            $this->fpdf->Cell(18, 6, number_format($get_req1->AllowanceAmount), 1, 0, 'C', 0);
            $this->fpdf->Cell(15, 6, number_format($get_req1->InstallmentAmount), 1, 0, 'C', 0);
            $this->fpdf->Cell(10, 6, number_format($get_req1->DuesAmount), 1, 0, 'C', 0);
            $this->fpdf->Cell(15, 6, number_format($get_req1->TAmount), 1, 0, 'C', 0);
            $this->fpdf->Cell(15, 6, number_format($get_req1->AdvanceAmount), 1, 0, 'C', 0);
            $this->fpdf->Cell(12, 6, number_format($get_req1->ArrearsAmount), 1, 0, 'C', 0);
            $this->fpdf->Cell(10, 6, number_format($get_req1->BonusAmount), 1, 0, 'C', 0);
            $this->fpdf->Cell(10, 6, number_format($get_req1->Fine), 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, number_format($get_req1->FuelAmount), 1, 0, 'C', 0);
            $this->fpdf->Cell(25, 6, number_format($get_req1->FuelReceivable), 1, 0, 'C', 0);
            $this->fpdf->Cell(20, 6, number_format($get_req1->PayableSalary), 1, 1, 'C', 0);
        }
        $this->fpdf->ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(30, 6, 'Prepared By', 0, 0, 'L', 0);
        $this->fpdf->Cell(30, 6, '________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Accounts', 0, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, '________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(35, 6, 'Director HR', 0, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, '________________', 0, 0, 'L', 0);
        $this->fpdf->Cell(30, 6, 'CEO', 0, 0, 'R', 0);
        $this->fpdf->Cell(30, 6, '________________', 0, 1, 'L', 0);
        $this->fpdf->ln(7);
        $this->fpdf->Cell(30, 6, 'Chairman', 0, 0, 'L', 0);
        $this->fpdf->Cell(30, 6, '________________', 0, 0, 'L', 0);
        $this->fpdf->Output();
        exit;
    }


    public function fetch_fuel_allowance()
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('FuelAllowance', 'Emp_Profile.EmployeeID', '=', 'FuelAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('FuelAllowance.AllowanceID', 'desc')->select('Emp_Profile.Name', 'FuelAllowance.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('FuelAllowance.CompanyID', '=', company_id())->paginate(15);
        return request()->json(200, $arr);
    }


    public function submit_fuel_allowance(Request $request)
    {


        $emp_id = $request->get('emp_emp_id');
        $fuel_quantity = $request->get('fuel_quantity');
        $emp_description = $request->get('emp_description');


        $update_date = long_date();
        for ($x = 0; $x < count($emp_id); $x++) {

            $se = explode("_", $emp_id[$x]);
            $find_employee_id = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeCode', '=', $se[1])->get();
            foreach ($find_employee_id as $find_employee_id1) {
            }
            $sub_emp_id = $find_employee_id1->EmployeeID;

            DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Fuel allowance applied', 'Fuel allowance of ' . $sub_emp_id . ' applied', $update_date]);

            $result = DB::connection('sqlsrv2')->insert("INSERT INTO FuelAllowance(CompanyID, EmployeeID, FuelType, FuelQuantity, Descriptions, FuelUnit, Status, CreatedBy, CreatedOn) values (?,?,?,?,?,?,?,?,?)", [company_id(), $sub_emp_id, 'Petrol', $fuel_quantity, $emp_description, 'Liter', 'Pending', username(), $update_date]);
        }
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('FuelAllowance', 'Emp_Profile.EmployeeID', '=', 'FuelAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('FuelAllowance.AllowanceID', 'desc')->select('Emp_Profile.Name', 'FuelAllowance.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('FuelAllowance.CompanyID', '=', company_id())->paginate(15);

        return request()->json(200, $arr);
    }

    public function insert_fuelbill(Request $request)
    {


        $bill_amount = $request->get('bill_amount');
        $qty = $request->get('qty');
        $detail = $request->get('detail');

        $liter_price = $request->get('liter_price');
        $date = $request->get('date');
        $employee_id = $request->get('employee_id');
        $fuel_type = $request->get('fuel_type');
        $narration = $request->get('narration');


        $update_date = long_date();


        $bill_amount1 = explode("|", $bill_amount);
        for ($x = 1; $x < count($bill_amount1); $x++) {
            $bill_amoun = explode("|", $bill_amount);
            $qt = explode("|", $qty);
            if ($bill_amoun[$x] == '' || $qt[$x] == '') {

                $find_config = "Empty field";
                return request()->json(200, $find_config);
            }
        }
        //
        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }

        //
        $find_session_closed = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->get();
        foreach ($find_session_closed as $find_session1) {
            $find_sessions = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('SessionName', '=', $find_session1->SessionName)->where('CompanyID', '=', company_id())->exists();
            if (!$find_sessions) {
                $session = $find_session1->SessionName;
                break;
            }
        }
        $sumamount = 0;
        $sumliter = 0;
        //
        $bill_amount1 = explode("|", $bill_amount);
        for ($x = 1; $x < count($bill_amount1); $x++) {
            $bill_amoun = explode("|", $bill_amount);
            $qt = explode("|", $qty);
            $detai = explode("|", $detail);

            $result = DB::connection('sqlsrv2')->insert('INSERT INTO FuelBill(CompanyID, EmployeeID, FuelType, BillAmount, FuelQuantity, Description, CreatedBy, CreatedOn, Session) values (?,?,?,?,?,?,?,?,?)', [company_id(), $employee_id, $fuel_type, intval($bill_amoun[$x]), $qt[$x], $detai[$x], username(), $update_date, $session]);
            $sumamount = $sumamount + $bill_amoun[$x];
            $sumliter = $sumliter + $qt[$x];
        }
        $get_liters = DB::connection('sqlsrv2')->table('FuelAllowance')->select('FuelQuantity')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $employee_id)->where('Status', '=', 'Approved')->get();
        foreach ($get_liters as $get_liters1) {
        }
        if (($get_liters1->FuelQuantity * $liter_price) < ($sumliter * $liter_price)) {
            $access_quantity = ($sumliter * $liter_price) - ($get_liters1->FuelQuantity * $liter_price);
        } else {
            $access_quantity = 0;
        }
        //check Exists
        $is_exist = DB::connection('sqlsrv2')->table('Fuel_Management')->where('Session', '=', $session)->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $employee_id)->exists();

        if ($is_exist) {
            $find_config = "Bills of employee already exist";
            return request()->json(200, $find_config);
        } else {
            $result1 = DB::connection('sqlsrv2')->insert('INSERT INTO Fuel_Management(CompanyID, EmployeeID, CreatedBy, CreatedOn, Session, AllowedAmount, FuelUnit, EccessAmount) values (?,?,?,?,?,?,?,?)', [company_id(), $employee_id, username(), $update_date, $session, round($get_liters1->FuelQuantity * $liter_price), 'Liter', $access_quantity]);
        }
        $find_config = "submitted";
        return request()->json(200, $find_config);
    }

    public function employee_fuelDetail($id)
    {
        if ($id == 0) {
            $id = employee_id();
        }


        $is_exist = DB::connection('sqlsrv2')->table('FuelAllowance')->join('Emp_Profile', 'FuelAllowance.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'FuelAllowance.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('FuelAllowance.*', 'Emp_Profile.Name', 'Emp_Register.Department')->where('Emp_Register.CompanyID', '=', company_id())->where('Emp_Register.EmployeeCode', '=', $id)->exists();
        if ($is_exist) {
            $emp_detail = DB::connection('sqlsrv2')->table('FuelAllowance')->join('Emp_Profile', 'FuelAllowance.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'FuelAllowance.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('FuelAllowance.*', 'Emp_Profile.Name', 'Emp_Register.Department')->where('Emp_Register.CompanyID', '=', company_id())->where('Emp_Register.EmployeeCode', '=', $id)->get();
        } else {
            $emp_detail = 'Error';
        }
        return request()->json(200, $emp_detail);
    }


    public function fuel_bills_detail()
    {

        $find_config = DB::connection('sqlsrv2')->table("FuelBill")->join('Emp_Profile', 'FuelBill.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('FuelBill.*', 'Emp_Profile.Name', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('Emp_Register.CompanyID', '=', company_id())->orderBy('FuelBill.ID', 'desc')->paginate(20);
        return request()->json(200, $find_config);
    }


    public function approve_fuel_allowance($id)
    {


        $update_date = long_date();

        $result = DB::connection('sqlsrv2')->update('update FuelAllowance set Status=?, ApprovedBy=? where AllowanceID=? and CompanyID=?', ['Approved', username(), $id, company_id()]);
        /*
        $id_arr = DB::connection('sqlsrv2')->table('PayrollAllowance')->select('EmployeeID')->where('AllowanceID','=', $id)->where('CompanyID','=',company_id())->get();
        foreach ($id_arr as $id_arr1) {

        }
        $emp_id = $id_arr1->EmployeeID;
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Allowance Status Changed', ' Allowance of '.$emp_id.' approved' , $update_date]);
        */
        if ($result) {
            $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('FuelAllowance', 'Emp_Profile.EmployeeID', '=', 'FuelAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('FuelAllowance.AllowanceID', 'desc')->select('Emp_Profile.Name', 'FuelAllowance.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('FuelAllowance.CompanyID', '=', company_id())->paginate(15);

            return request()->json(200, $arr);
        }
    }


    public function submit_stipend(Request $request)
    {


        $emp_code = $request->get('emp_emp_id');
        $emp_amount = $request->get('emp_amount');
        $emp_description = $request->get('emp_description');
        $emp_date = $request->get('emp_date');
        $session_name = $request->get('session_name');


        $update_date = long_date();
        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('SessionName', '=', $session_name)->get();
        foreach ($find_session as $find_session1) {
        }


        for ($x = 0; $x < count($emp_code); $x++) {
            $emp_id = explode("_", $emp_code[$x]);
            $emp_rep1 = DB::connection('sqlsrv2')->table('Emp_Register')->select('Emp_Profile.EmployeeID', 'Emp_Profile.Name')->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->where('Emp_Register.EmployeeCode', '=', $emp_id[1])->where('Emp_Register.CompanyID', '=', company_id())->get();

            foreach ($emp_rep1 as $emp_rep11) {
            }
            $stipend_exist = DB::connection('sqlsrv2')->table('StipendDetail')->where('EmpID', '=', $emp_rep11->EmployeeID)->where('CompanyID', '=', company_id())->exists();
            if ($stipend_exist) {
                $arr = 'Stipend of ' . $emp_rep11->Name . ' already exists';
                return request()->json(200, $arr);
            } else {
                $result = DB::connection('sqlsrv2')->insert("INSERT INTO StipendDetail(CompanyID, EmpID, Status, StipendAmount, CreatedBy, CreatedOn, StartSession, Description, SessionEndDate) values (?,?,?,?,?,?,?,?,?)", [company_id(), $emp_rep11->EmployeeID, 'Active', $emp_amount, username(), $update_date, $session_name, $emp_description, $find_session1->EndDate]);
            }
        }
        $arr = 'submit';
        return request()->json(200, $arr);
    }

    public function fetch_payroll_stipend()
    {

        $arr = DB::connection('sqlsrv2')->table('StipendDetail')->join('Emp_Profile', 'Emp_Profile.EmployeeID', '=', 'StipendDetail.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('StipendDetail.StipendID', 'desc')->select('Emp_Profile.Name', 'StipendDetail.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary')->where('StipendDetail.CompanyID', '=', company_id())->paginate(15);
        return request()->json(200, $arr);
    }

    public function update_stipend_status($id, $sts)
    {


        $update_date = long_date();

        if ($sts == 'Active') {
            $upSts = 'Disabled';
        } else if ($sts == 'Disabled') {
            $upSts = 'Active';
        } else {
            $arr = 'Status not updated';
            return request()->json(200, $arr);
        }
        $result = DB::connection('sqlsrv2')->update('update StipendDetail set Status=?, UpdatedBy=?, UpdatedOn=? where StipendID=? and CompanyID=?', [$upSts, username(), $update_date, $id, company_id()]);

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('StipendDetail', 'Emp_Profile.EmployeeID', '=', 'StipendDetail.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('StipendDetail.StipendID', 'desc')->select('Emp_Profile.Name', 'StipendDetail.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary')->where('StipendDetail.CompanyID', '=', company_id())->paginate(15);

        return request()->json(200, $arr);
    }

    public function update_stipend(Request $request)
    {


        $update_date = long_date();

        $stipend_id = $request->get('stipend_id');
        $edit_amount = $request->get('edit_amount');
        $edit_description = $request->get('edit_description');

        $result = DB::connection('sqlsrv2')->update('update StipendDetail set StipendAmount=?, Description=?, UpdatedBy=?, UpdatedOn=? where StipendID=? and CompanyID=?', [$edit_amount, $edit_description, username(), $update_date, $stipend_id, company_id()]);

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('StipendDetail', 'Emp_Profile.EmployeeID', '=', 'StipendDetail.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('StipendDetail.StipendID', 'desc')->select('Emp_Profile.Name', 'StipendDetail.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary')->where('StipendDetail.CompanyID', '=', company_id())->paginate(15);

        return request()->json(200, $arr);
    }

    public function search_stipend(Request $request)
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('StipendDetail', 'Emp_Profile.EmployeeID', '=', 'StipendDetail.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('StipendDetail.StipendID', 'desc')->select('Emp_Profile.Name', 'StipendDetail.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary')->where('Emp_Profile.Name', 'LIKE', '%' . $request->keyword1 . '%')->orwhere('Emp_Register.EmployeeCode', 'LIKE', '%' . $request->keyword1 . '%')->where('StipendDetail.CompanyID', '=', company_id())->paginate(15);
        return response()->json($arr);
    }


    public function att_time($id)
    {


        $add_date = date("Y-m-d");
        if ($id == 0) {
            $id = employee_id();
        }
        $arr = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('ATTDate', '=', $add_date)->get();
        return request()->json(200, $arr);
    }

    public function mark_attendance(Request $request)
    {
        //$check_in = $request -> get('check_in');
        //$check_out = $request -> get('check_out');
        $check_in = date("H:i");
        $att_status = NULL;
        $attendanceQuery = DB::connection('sqlsrv2')->table('AttData')->where('ATTDate', '=', short_date())->where('EmpID', '=', $request->emp_id)->where('CompanyID', '=', company_id());
        $attendance = $attendanceQuery->exists();
        if ($attendance) {
            $markedQuery = clone $attendanceQuery;
            $marked = $markedQuery->whereNotNull('CheckIn')->exists();
            if ($marked) {
                $data = 'You already has been marked your attendance!';
                return request()->json(200, $data);
            }
            $openingTime = $attendanceQuery->first()->OpeningTime;
            $att_status = ($check_in <= $openingTime) ? 'P' : 'L';
            try {
                $attendanceQuery->update([
                    'CheckIN' => $check_in . ':00.0000000',
                    'AttStatus' => $att_status,
                    'CheckInBy' => 'Manual_Attendance',
                    'CheckOutBy' => 'Manual_Attendance',
                    'UpdatedBy' => username()
                ]);
            } catch (\Exception $exception) {
                return $this->sendError($exception->getMessage());
            }
            //activitylog
            insertLog('Manual Attendance', UserFullName() . ' marked Attendance (' . $att_status . ') manually');
            $data = 'Done';
            return request()->json(200, $data);
        } else {
            $data = 'You cannot mark your attendance!';
            return request()->json(200, $data);
        }
    }

    public function totalEmp_SalaryCount()
    {
        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('AttClosedPayrollStart', '=', 'Closed')->where('DistState', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $SessionName = $find_session1->SessionName;

        $arr = DB::connection('sqlsrv2')->select("Select count(EmployeeID) as TotalEmployess ,sum(RemainingAmount) as TotalPayableSalary from Payroll_Distribution where SessionName ='" . $SessionName . "' and SalaryStatus != 'Fully Received'");
        return request()->json(200, $arr);
    }

    public function update_emp_dist_salary(Request $request)
    {
        $update_date = long_date();
        $doc_date = date("Y-m-d");
        $dist_id = $request->get('dist_id');
        $emp_payable = $request->get('emp_payable');
        $cash_type = $request->get('cash_type');
        $cash_amount = $request->get('cash_amount');
        $bank_amount = $request->get('bank_amount');
        $bank_type = $request->get('bank_type');
        $cash_ty = explode("_", $cash_type);
        $bank_typ = explode("_", $bank_type);
        $cashinhand_balance = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
  @Datefrom = N'2000-01-01',
  @DateTo = N'" . $doc_date . "',
  @id = " . $cash_ty[0] . ",
  @compid = N'" . company_id() . "'  ");
        foreach ($cashinhand_balance as $cashinhand_balance1) {
        }
        if ($cash_amount < 0) {
            $cash_amount = abs($cash_amount);
        }
        if ($bank_amount < 0) {
            $bank_amount = abs($bank_amount);
        }
        if ($bank_type == '101001001001_Cash in Hand' && $cashinhand_balance1->am <= 0) {
            $find_config = 'Not Suficient Balance';
            return request()->json(200, $find_config);
        }
        $emp_gave = $cash_amount + $bank_amount;
        if ($emp_gave > $emp_payable) {
            $message = "error";
            return response()->json($message);
        } else if ($bank_type != '' && $bank_amount <= 0) {
            $message = "error2";
            return response()->json($message);
        } else {
            $check1 = DB::connection('sqlsrv2')->table("Payroll_Distribution")->where('DistributionID', '=', $dist_id)->select('CashAmount', 'BankAmount', 'PNO', 'RemainingAmount')->where('CompanyID', '=', company_id())->orderBy('DistributionID', 'desc')->first();

            if ($emp_gave < 0) {
                $remaining_amount = $check1->RemainingAmount - abs($emp_gave);
            } else {
                $remaining_amount = $check1->RemainingAmount - $emp_gave;
            }
            $cash_amount1 = $cash_amount + $check1->CashAmount;
            $bank_amount1 = $bank_amount + $check1->BankAmount;
            $total_paidall = $cash_amount1 + $bank_amount1;
            $pno = $check1->PNO + 1;
            $final_PoCode = PVID();

            if ($emp_gave == $emp_payable) {
                $salary_status = "Fully Received";
            } else {
                $salary_status = "Partially Received";
            }
            $save_ledger1 = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('DistributionID', '=', $dist_id)->orderBy('DistributionID', 'desc')->first();

            if ($save_ledger1->RemainingAmount <= 0) {
                $find_config = 'Remaining Payable is Incorrect';
                return request()->json(200, $find_config);
            }
            if ($emp_gave > $save_ledger1->RemainingAmount) {
                $message = "error";
                return response()->json($message);
            }
            if (Session::get('company_accounts_plan') == 'true' && $save_ledger1->RemainingAmount > 0) {
                $find_vendor_id = DB::connection('sqlsrv3')->table("Ledger_Entries")->where('VendorID8', '=', $save_ledger1->DistributionID)->where('VendorID8b', '=', $save_ledger1->PNO + 1)->where('CompanyID', '=', company_id())->exists();
                if (!$find_vendor_id) {

                    try {
                        $result = DB::connection('sqlsrv2')->update('update Payroll_Distribution set ReceivedThrough=?,ReceivedTime=?,CashAmount=?,BankAmount=?,CashID=?,BankID=?,PVID=?,RemainingAmount=?,PaidAmount=?,SalaryStatus=?,PNO=?,CurrentCashPaid=?,CurrentBankPaid=? where DistributionID=?', [username(), $update_date, $cash_amount1, $bank_amount1, $cash_ty[0], $bank_typ[0], $final_PoCode, $remaining_amount, $total_paidall, $salary_status, $pno, $cash_amount, $bank_amount, $dist_id]);
                    } catch (\Illuminate\Database\QueryException $e) {
                        if ($e->getCode() == 23000) {
                            // return response()->json(['message' => 'Payroll Dist Already Exists.'], 200);
                            $message = "Payroll Dist Already Exists.";
                            return response()->json($message);
                            // return response()->json(['message' => 'Payroll Dist Already Exists.'], 200);
                            $message = "Payroll Dist Already Exists.";
                            return response()->json($message);
                        } else {
                            throw $e;
                        }
                    }
                    if ($result) {
                        insert_sequencevoucher($final_PoCode, $dist_id, 'Salary');
                        $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode, 'Salary Paid to ' . $save_ledger1->EmpCode . ':' . $save_ledger1->Name . '-' . $save_ledger1->Department . '-' . $save_ledger1->SessionName . 'Through Cash:' . $cash_amount1 . 'and Bank:' . $bank_amount1, 'Paid Salary', $update_date, username(), company_id()]);
                        if ($doc) {
                            $find_doc_id1 = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode)->orderBy('ID', 'DESC')->first();

                            DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, 'Salary Paid to ' . $save_ledger1->EmpCode . ':' . $save_ledger1->Name . '-' . $save_ledger1->Department . '-' . $save_ledger1->SessionName . 'Through Cash:' . $cash_amount1 . 'and Bank:' . $bank_amount1, company_id()]);
                            $find_tran_id1 = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->orderBy('ID', 'DESC')->first();

                            //find_Account id
                            if ($emp_gave != 0 || $emp_gave != 0.00) {

                                DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID,VendorID8,VendorID8b) values (?,?,?,?,?,?,?)', [$find_tran_id1->ID, '201002001001', 'D', $emp_gave, company_id(), $save_ledger1->DistributionID, $pno]);
                            }
                            if ($cash_amount != 0 || $cash_amount != 0.00) {
                                DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID,VendorID8,VendorID8b) values (?,?,?,?,?,?,?)', [$find_tran_id1->ID, $cash_ty[0], 'C', $cash_amount, company_id(), $save_ledger1->DistributionID, $pno]);
                            }
                            if ($bank_amount != 0 || $bank_amount != 0.00) {

                                if ($save_ledger1->BankID == 0) {
                                    DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID,VendorID8,VendorID8b) values (?,?,?,?,?,?,?)', [$find_tran_id1->ID, '101001002001007', 'C', $bank_amount, company_id(), $save_ledger1->DistributionID, $pno]);
                                } else {
                                    DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID,VendorID8,VendorID8b) values (?,?,?,?,?,?,?)', [$find_tran_id1->ID, $bank_typ[0], 'C', $bank_amount, company_id(), $save_ledger1->DistributionID, $pno]);
                                }
                            }
                            DB::connection('sqlsrv2')->insert('INSERT INTO Payroll_DistributionLogs(CompanyID,EmployeeID,Name,EmpCode,SessionName,Salary,PayableSalary,ReceivedThrough,ReceivedTime,CashAmount,BankAmount,CashID,BankID,PVID,RemainingAmount,PaidAmount,SalaryStatus,CurrentCashPaid,CurrentBankPaid,CurrentPaidAmount,DistributionID,Photo) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [company_id(), $save_ledger1->EmployeeID, $save_ledger1->Name, $save_ledger1->EmpCode, $save_ledger1->SessionName, $save_ledger1->Salary, $save_ledger1->PayableSalary, username(), $update_date, $cash_amount1, $bank_amount1, $cash_ty[0], $bank_typ[0], $final_PoCode, $remaining_amount, $total_paidall, $salary_status, $cash_amount, $bank_amount, $cash_amount + $bank_amount, $dist_id, $save_ledger1->Photo]);
                        }
                    }
                }
            } else {
                $message = "Salary Not Found";
                return response()->json($message);
            }
            if ($emp_gave < $emp_payable) {
                Cache::forget('SalaryData');
            } else if ($emp_gave == $save_ledger1->RemainingAmount) {
                if (Cache::has('SalaryData')) {
                    $collection = collect(Cache::get('SalaryData'));
                    $filteredUsers = $collection->filter(function ($element) use ($request, $dist_id) {
                        return $element->DistributionID != $dist_id;
                    });
                    Cache::forget('SalaryData');
                    Cache::put('SalaryData', $filteredUsers);
                }
            }
            $message = "submitted";
            return response()->json($message);
        }
    }

    public function dist_byName(Request $request)
    {
        if (!Cache::has('SalaryData')) {
            $find_session1 = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->orderby('SessionID', 'desc')->where('AttClosedPayrollStart', '=', 'Closed')->first();
            $sesson_name = $find_session1->SessionName;
            $arr1 = DB::connection('sqlsrv2')->table("Payroll_Distribution")->where("SessionName", '=', $sesson_name)->where('RemainingAmount', '!=', 0)->get();

            Cache::forget('SalaryData');
            Cache::put('SalaryData', $arr1);
            $collection = collect(Cache::get('SalaryData'));

            $filteredUsers = $collection->filter(function ($element) use ($request) {
                $keyword = $request->keyword4;

                return Str::contains($element->EmpCode, $keyword, true) ||
                    Str::contains($element->Name, $keyword, true) ||
                    Str::contains($element->CNIC, $keyword, true);
            });
        } else {
            $collection = collect(Cache::get('SalaryData'));

            $filteredUsers = $collection->filter(function ($element) use ($request) {
                $keyword = $request->keyword4;
                return Str::contains($element->EmpCode, $keyword, true) ||
                    Str::contains($element->Name, $keyword, true) ||
                    Str::contains($element->CNIC, $keyword, true);
            });
        }
        return request()->json(200, $filteredUsers);
    }

    public function getemployeebanksum($emp_department, $emp_username, $SessionName, $status)
    {

        if ($status == 'Unpaid' && $emp_department == 'All' && $emp_username == 'All') {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')->join("Emp_Register", "Payroll_Distribution.EmployeeID", "=", 'Emp_Register.EmployeeID')->where('Payroll_Distribution.CompanyID', '=', company_id())->where('Payroll_Distribution.SessionName', '=', $SessionName)->where('Payroll_Distribution.ReceivedThrough', '=', null)->sum('BankAmount');
            return request()->json(200, $emp_detail);
        }
        if ($status == 'Paid' && $emp_department == 'All' && $emp_username == 'All') {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')->join("Emp_Register", "Payroll_Distribution.EmployeeID", "=", 'Emp_Register.EmployeeID')->where('Payroll_Distribution.CompanyID', '=', company_id())->where('Payroll_Distribution.SessionName', '=', $SessionName)->where('Payroll_Distribution.ReceivedThrough', '!=', null)->sum('BankAmount');
            return request()->json(200, $emp_detail);
        }
        if ($status == 'All' && $emp_department == 'All' && $emp_username == 'All') {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')->join("Emp_Register", "Payroll_Distribution.EmployeeID", "=", 'Emp_Register.EmployeeID')->where('Payroll_Distribution.CompanyID', '=', company_id())->where('Payroll_Distribution.SessionName', '=', $SessionName)->sum('BankAmount');
            return request()->json(200, $emp_detail);
        }

        if ($emp_department == 'All') {
            $emp_department = '';
        }
        if ($emp_username == 'All') {
            $emp_username == '';
        }
        if ($status == 'All') {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('CompanyID', '=', company_id())->where('SessionName', '=', $SessionName)->where('Department', 'like', '%' . $emp_department . '%')->sum('BankAmount');
            return request()->json(200, $emp_detail);
        }

        if ($status == 'Unpaid') {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('CompanyID', '=', company_id())->where('SessionName', '=', $SessionName)->where('Payroll_Distribution.ReceivedThrough', 'like', '%' . $emp_username . '%')->where('Department', 'like', '%' . $emp_department . '%')->sum('BankAmount');
            return request()->json(200, $emp_detail);
        }
        if ($status == 'Paid') {
            $emp_detail = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('CompanyID', '=', company_id())->where('SessionName', '=', $SessionName)->where('Payroll_Distribution.ReceivedThrough', 'like', '%' . $emp_username . '%')->where('Department', 'like', '%' . $emp_department . '%')->sum('BankAmount');
            return request()->json(200, $emp_detail);
        }
    }

    public function getproemploy($department, $location, $designation, $emp_id, $start_date, $end_date)
    {


        if ($department == 'All') {
            $department = '';
        }
        if ($designation == 'All') {
            $designation = '';
        }
        if ($location == 'All') {
            $location = '';
        }
        if ($emp_id == 'All') {
            $emp_id = '';
        }
        $prob_end_emp = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Register.ProbationEnd', '<=', $end_date)->where('Emp_Register.ProbationEnd', '>=', $start_date)->where('Emp_Register.JobStatus', '=', 'Probation')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Register.Designation', 'like', '%' . $designation . '%')->where('PostingCity', 'like', '%' . $location . '%')->where('Emp_Register.EmployeeID', 'like', '%' . $emp_id . '%')->get();
        return request()->json(200, $prob_end_emp);
    }

    public function getproemploycount($department, $location, $designation, $emp_id, $start_date, $end_date)
    {

        if ($department == 'All') {
            $department = '';
        }
        if ($designation == 'All') {
            $designation = '';
        }
        if ($location == 'All') {
            $location = '';
        }
        if ($emp_id == 'All') {
            $emp_id = '';
        }
        $prob_end_emp = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Register.ProbationEnd', '<=', $end_date)->where('Emp_Register.ProbationEnd', '>=', $start_date)->where('Emp_Register.JobStatus', '=', 'Probation')->where('Emp_Profile.CompanyID', '=', company_id())->where('Emp_Register.Department', 'like', '%' . $department . '%')->where('Emp_Register.Designation', 'like', '%' . $designation . '%')->where('PostingCity', 'like', '%' . $location . '%')->where('Emp_Register.EmployeeID', 'like', '%' . $emp_id . '%')->count();
        return request()->json(200, $prob_end_emp);
    }

    public function update_loan(Request $request)
    {
        $update_date = long_date();
        $usid = $request->get('usid');
        $installments = $request->get('us_installments');
        $us_amount = $request->get('us_amount');
        $us_reason = $request->get('us_reason');
        $us_wished_deduction = $request->get('us_wished_deduction');
        //dd($us_wished_deduction);
        DB::connection('sqlsrv2')
            ->table('LoanRequisition')
            ->where('CompanyID', '=', company_id())
            ->where('LoanId', '=', $usid)
            ->update([
                'LoanInstallments' => $installments,
                'LoanAmount' => $us_amount,
                'LoanSession' => $us_wished_deduction,
                'LoanReason' => $us_reason,
                'UpdatedOn' => $update_date,
                'UpdatedBy' => username(),
            ]);

        return "Loan updated!";
    }

    public function pendingdist_byName(Request $request)
    {
        $sessionNames = DB::connection('sqlsrv2')
            ->table('HrSessions')
            ->where('CompanyID', '=', company_id())
            ->where('CurrentSession', '=', 0)
            ->where('AttClosedPayrollStart', '=', 'Closed')
            ->where('DistState', '=', 1)
            ->pluck('SessionName') // Use pluck to get an array of 'SessionName' values
            ->sortBy(function ($sessionName) {
                return Carbon::createFromFormat('F-Y', $sessionName);
            })->values()->toArray();
        $sessionNamesWithoutFirst = array_slice($sessionNames, 0, -1);

        return DB::connection('sqlsrv2')
            ->table('Payroll_Distribution')
            ->where('SalaryStatus', '!=', 'Fully Received')
            ->whereIn('SessionName', $sessionNamesWithoutFirst) // Use the array of 'SessionName' values
            ->where('CompanyID', '=', company_id())
            ->where(function ($query) use ($request) {
                $query->where('EmpCode', 'LIKE', '%' . $request->keyword1 . '%')
                    ->orWhere('Name', 'LIKE', '%' . $request->keyword1 . '%')
                    ->orWhere('CNIC', 'LIKE', '%' . $request->keyword1 . '%');
            })
            ->orderBy('SessionName', 'Desc')
            ->orderBy('EmployeeID', 'ASC')
            ->paginate('20');
    }


    public function pending_salariesdetail(Request $request)
    {

        /*
      $find_session =DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=', company_id())->where('CurrentSession','=',0)->where('AttClosedPayrollStart','=','Closed')->where('DistState','=',1)->get();
     $array=[];
      foreach ($find_session as $find_session1) {
        $SessionName = $find_session1->SessionName;
    $arr = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('SessionName','=',$SessionName)->where('CompanyID','=', company_id())->select('SessionName')->groupBy('SessionName')->get();
    foreach($arr as $arr1){
    $arr_items = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('RemainingAmount','!=',0)->where('SessionName','=',$arr1->SessionName)->where('CompanyID','=', company_id())->orderBy('SessionName','asc')->get();
    array_push($array,$arr_items);
    }
  }
  $flattened2 = Arr::flatten($array);
  */
        $flattened2 = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('RemainingAmount', '!=', 0)->where('CompanyID', '=', company_id())->where('Name', 'like', '%' . $request->keyword1 . '%')->orderBy('DistributionID', 'asc')->paginate(20);
        return request()->json(200, $flattened2);
    }

    public function fetch_distpending_salaries1($session)
    {


        $arr = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('SessionName', '=', $session)->where('SalaryStatus', '!=', 'Not Received')->where('CompanyID', '=', company_id())->select('EmpCode', 'Name')->get();

        return request()->json(200, $arr);
    }

    public function fetch_distpending_salaries2($code, $session)
    {


        $arr = DB::connection('sqlsrv2')->table('Payroll_Distribution')/*->whereNotNull('ReceivedThrough')*/->where('EmpCode', '=', $code)->where('SessionName', '=', $session)->where('CompanyID', '=', company_id())->select('EmpCode', 'EmployeeID', 'DistributionID')->get();

        return request()->json(200, $arr);
    }

    public function fetch_distpending_salaries()
    {

        $sessionNames = DB::connection('sqlsrv2')
            ->table('HrSessions')
            ->where('CompanyID', '=', company_id())
            ->where('CurrentSession', '=', 0)
            ->where('AttClosedPayrollStart', '=', 'Closed')
            ->where('DistState', '=', 1)
            ->get()
            ->sortByDesc(function ($sessionName) {
                return Carbon::createFromFormat('F-Y', $sessionName->SessionName);
            })
            ->values();
        return $sessionNames->splice(1);;
    }

    public function installments_detail($id)
    {

        $result2 = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->exists();
        if ($result2) {
            $result = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->orderBy('DetailId', 'asc')->get();
            return request()->json(200, $result);
        }
    }

    public function skip_installment(Request $request)
    {
        $id = $request->get("id");
        $installment_id = $request->get("installment_id");


        $update_date = long_date();
        $remarks = $request->get('remarks');

        $result = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->where('DetailId', '=', $installment_id)->exists();

        $arr = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->where('DetailId', '=', $installment_id)->get();
        foreach ($arr as $arr1) {
        }

        $arrall = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->orderby('InstallmentNo', 'asc')->get();
        foreach ($arrall as $arrall1) {
        }


        $var = strtotime($arrall1->InstallmentSession);
        $x = 1;
        $effectiveDate = strtotime("+" . $x . " months", $var);
        $insSession = date("F-Y", $effectiveDate);

        if ($result) {
            DB::connection('sqlsrv2')->update('update LoanDetail set InstallmentStatus=?, Remarks=?, UpdatedBy=?, UpdatedOn=? where CompanyID=? and LoanId=? and DetailId=?', ['Skipped', $remarks, username(), $update_date, company_id(), $id, $installment_id]);
            DB::connection('sqlsrv2')->insert('INSERT INTO LoanDetail(CompanyID, EmployeeID, LoanId, InstallmentNo, InstallmentSession, InstallmentAmount, InstallmentStatus, CreatedBy, CreatedOn, LoanType) values (?,?,?,?,?,?,?,?,?,?)', [company_id(), $arr1->EmployeeID, $arr1->LoanId, $arrall1->InstallmentNo + 1, $insSession, $arr1->InstallmentAmount, 'Unpaid', username(), $update_date, $arr1->LoanType]);
        }
        $result1 = 'Success';
        return request()->json(200, $result1);
    }

    public function waiveoff_installment(Request $request)
    {

        $id = $request->get("id");
        $installment_id = $request->get("installment_id");
        $remarks = $request->get('remarks');

        $result2 = DB::connection('sqlsrv2')->table("LoanDetail")->where("CompanyID", '=', company_id())->where('LoanId', '=', $id)->exists();
        $status = 'waivedoff';
        if ($result2) {
            DB::connection('sqlsrv2')->update('update LoanDetail set InstallmentStatus=?, Remarks=? where CompanyID=? and LoanId=? and DetailId=?', [$status, $remarks, company_id(), $id, $installment_id]);
        }
        $result = 'Success';
        return request()->json(200, $result);
    }

    public function delete_loan($id)
    {


        $update_date = long_date();

        $result = DB::connection('sqlsrv2')->update('update LoanRequisition set IsDeleted=?, DeletedOn=?, DeletedBy=? where CompanyID=? AND LoanId=?', [1, $update_date, username(), company_id(), $id]);
        $result1 = DB::connection('sqlsrv2')->update('update LoanDetail set InstallmentStatus=?, IsDeleted=?, DeletedOn=?, DeletedBy=? where CompanyID=? AND LoanId=? AND InstallmentStatus=?', ['Deleted', 1, $update_date, username(), company_id(), $id, 'Unpaid']);

        if ($result) {
            $arr = 'loan deleted';
        } else {
            $arr = 'loan not deleted';
        }
        return request()->json(200, $arr);
    }

    public function arrears_report($starting_date, $ending_date, $dept)
    {

        if ($dept == 'All') {
            $dept = '';
        }
        $result3 = DB::connection('sqlsrv2')->select("EXEC   [dbo].[Arrear_Report]
                 @date = N'" . $starting_date . "',
                 @date1 = N'" . $ending_date . "',
                 @Dep = N'" . $dept . "'
                 ");

        return response()->json($result3);
    }

    public function loan_advance_report($start_date, $end_date, $dept, $type, $status)
    {

        if ($dept == 'All') {
            $dept = '';
        }
        if ($type == 'All') {
            $type = '';
        }
        if ($status == 'All') {
            $status = '';
        }
        $result3 = DB::connection('sqlsrv2')->select("EXEC   [dbo].[Loan_Advances_Report]
                         @date = N'" . $start_date . "',
                         @date1 = N'" . $end_date . "',
                         @Dep = N'" . $dept . "',
                         @type = N'" . $type . "',
                         @ReqStatus = N'" . $status . "'
                         ");

        return response()->json($result3);
    }

    public function delete_EmpFuelAllowance($id)
    {
        $result = DB::connection('sqlsrv2')->table('Emp_FuelAllowance')->where('CompanyID', '=', company_id())->where('EmployeeID', $id)->exists();
        if ($result) {
            DB::connection('sqlsrv2')->update('update Emp_FuelAllowance set  isDeleted=?, UpdatedOn=?, UpdatedBy=? where CompanyID=? AND EmployeeID=?', ['1', long_date(), username(), company_id(), $id]);
            $arr = 'Fuel Allowance deleted';
            insertLog('Emp Fuel Allowance Deleted ', 'Emp Fuel Allowance deleted');
        } else {
            $arr = 'Fuel Allowance not deleted';
        }
        return request()->json(200, $arr);
    }

    public function delete_arrears($id)
    {


        $update_date = long_date();

        $result = DB::connection('sqlsrv2')->table('PayrollArrears')->where('CompanyID', '=', company_id())->where('ArrearsID', $id)->exists();
        if ($result) {
            DB::connection('sqlsrv2')->update('update PayrollArrears set Status=?, IsDeleted=?, DeletedOn=?, DeletedBy=? where CompanyID=? AND ArrearsID=?', ['Deleted', '1', $update_date, username(), company_id(), $id]);
            $arr = 'arrears deleted';
        } else {
            $arr = 'arrears not deleted';
        }
        return request()->json(200, $arr);
    }

    public function Time_Adjustment(Request $request)
    {

        $today = long_date();


        $id = $request->get('id');
        $att_date = $request->get('att_date');
        $adjustmentfor = $request->get('adjustmentfor');
        $Hours = $request->get('hours');
        $Minutes = $request->get('minutes');
        $attdate = $request->get('att_date');
        $reason = $request->get('Reason');
        $success = DB::connection('sqlsrv2')->insert("INSERT INTO TimeAdjustment(CompanyID,EmployeeID,TimeAdjFor,Hours,Minutes,att_date,ManagerApproval,HrApproval,ReqStatus,CreatedBy,CreatedOn, Reason) values (?,?,?,?,?,?,?,?,?,?,?,?)", [company_id(), $id, $adjustmentfor, $Hours, $Minutes, $attdate, 'Pending', 'Pending', 'Pending', username(), $today, $reason]);
        if ($success) {
            $data = "time adjustment submitted";
            return request()->json(200, $data);
        } else {
            $data = "Time adjustment not submitted!";
            return request()->json(200, $data);
        }
    }

    //
    public function fetch_emp_id()
    {

        $emp_id = employee_id();
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('Emp_Register.EmployeeCode')
            ->select('Emp_Profile.Name', 'Emp_Profile.EmployeeID', 'Emp_Register.EmployeeCode')
            ->where('Emp_Register.EmployeeID', '=', $emp_id)->get();
        return request()->json(200, $arr);
    }

    public function find_sess_date($id)
    {

        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('SessionName', '=', $id)->get();
        foreach ($find_session as $find_session1) {
        }
        $month = date('F-Y', strtotime($find_session1->EndDate));

        return request()->json(200, $month);
    }

    public function add_settlement(Request $request)
    {
        $emp_id = $request->get('emp_id'); //
        $set_id = $request->get('set_id'); //
        $loan = $request->get('loan'); //
        $fine = $request->get('fine'); //
        $arrears = $request->get('arrears'); //
        $allowance = $request->get('allowance'); //
        $graduaty = $request->get('graduaty'); //
        $bonus = $request->get('bonus'); //
        $set_amount = $request->get('set_amount');
        $remarks = $request->get('remarks');
        $TAmount = $arrears + $graduaty + $bonus + $set_amount + $allowance;
        $payable_Salary = $TAmount - ($loan + $fine);

        DB::connection('sqlsrv2')->update('update FinalSettlement set AllowanceAmount=?, LoanAmount=?, ArrearsAmount=?, BonusAmount=?, Gratuity=?, Remarks=?, PayableSalary=?, Fine=?, SettlementAmount=? where EmployeeID =? and ID=?', [$allowance, $loan, $arrears, $bonus, $graduaty, $remarks, $payable_Salary, $fine, $set_amount, $emp_id, $set_id]);

        $arr = 'Final settlement added';
        return request()->json(200, $arr);
    }

    //fetch Employee detail for loan and advance
    public function fetch_pending_loan($emp_id1)
    {
        if ($emp_id1 == '0') {
            $emp_id = employee_id();
        } else {
            $emp_id = $emp_id1;
        }
        $emp_loan_dtl = DB::connection('sqlsrv2')->table('LoanDetail')->where('InstallmentStatus', '=', 'Pending')->where('CompanyID', '=', company_id())->where('EmployeeID', '=', $emp_id)->sum('InstallmentAmount');
        return request()->json(200, $emp_loan_dtl);
    }

    //view Time Adjustment detail
    public function TimeAdjustment_detail(Request $request)
    {
        $job = DB::connection('sqlsrv2')->table('TimeAdjustment')->join('Emp_Profile', 'TimeAdjustment.EmployeeID', '=', 'Emp_Profile.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('TimeAdjustment.*', 'Emp_Profile.Name', 'Emp_Profile.Photo', 'Emp_Profile.Employee_Code', 'Emp_Register.Designation', 'Emp_Register.Department')->where('TimeAdjustment.CompanyID', '=', company_id())->where('Emp_Profile.Name', 'like', '%' . $request->keyword . '%')->orWhere('Emp_Register.EmployeeCode', 'like', '%' . $request->keyword . '%')->paginate(20);
        return request()->json(200, $job);
    }

    //update time adjustment status

    public function update_TM_sts(Request $request)
    {
        $update_date = long_date();
        $tmid = $request->get('tmid');
        $newstatus = $request->get('newstatus');
        $who = $request->get('who');

        $emp_id = $request->get('emp_id');
        $date = $request->get('date');
        $hours = $request->get('hours');
        $minuts = $request->get('minuts');

        if ($who == 'man') {
            DB::connection('sqlsrv2')->update('update TimeAdjustment set ManagerApproval=?, UpdatedOn=?, UpdatedBy=? where TimeAdjId=? and CompanyID=?', [$newstatus, $update_date, username(), $tmid, company_id()]);
            $data = "Status updated!";
            return request()->json(200, $data);
        } else if ($who == 'hr') {
            $attdata_exist = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('EmpID', '=', $emp_id)->where('ATTDate', '=', $date)->exists();
            if ($attdata_exist) {
                $attdata = DB::connection('sqlsrv2')->table('AttData')->where('CompanyID', '=', company_id())->where('EmpID', '=', $emp_id)->where('ATTDate', '=', $date)->get();
                foreach ($attdata as $attdata1) {
                }
                if ($attdata1->GracePeriod < 1) {
                    $data = "Employee is not late in system!";
                    return request()->json(200, $data);
                }
                $gp = $attdata1->GracePeriod + ($hours * 60) + $minuts;
                if ($gp < 1) {
                    $gp = 0;
                }
                $update_att = DB::connection('sqlsrv2')->update('update AttData set GracePeriod=?, UpdatedOn=?, UpdatedBy=? where AttDataID=? and CompanyID=?', [$gp, $update_date, username(), $attdata1->AttDataID, company_id()]);

                DB::connection('sqlsrv2')->update('update TimeAdjustment set HrApproval=?, UpdatedOn=?, UpdatedBy=? where TimeAdjId=? and CompanyID=?', [$newstatus, $update_date, username(), $tmid, company_id()]);
                $data = "Status updated!";
            } else {
                $data = 'Your attendance of ' . $date . ' not exist in system!';
                return request()->json(200, $data);
            }
        } else {
            $data = "Time adjustment not approved!";
            return request()->json(200, $data);
        }
    }

    public function shiftformat()
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

    //
    public function count_settlements()
    {

        $all_sets = DB::connection('sqlsrv2')->table('FinalSettlement')->where('CompanyID', '=', company_id())->count();
        $pen_sets = DB::connection('sqlsrv2')->table('FinalSettlement')->where('CompanyID', '=', company_id())->where('Status', '=', 'Pending')->where('IsDeleted', '=', '0')->count();
        $app_sets = DB::connection('sqlsrv2')->table('FinalSettlement')->where('CompanyID', '=', company_id())->where('Status', '=', 'Approved')->where('IsDeleted', '=', '0')->count();
        $paid_sets = DB::connection('sqlsrv2')->table('FinalSettlement')->where('CompanyID', '=', company_id())->where('Status', '=', 'Paid')->where('IsDeleted', '=', '0')->count();
        $deleted = DB::connection('sqlsrv2')->table('FinalSettlement')->where('CompanyID', '=', company_id())->where('IsDeleted', '=', '1')->count();
        $rejected = DB::connection('sqlsrv2')->table('FinalSettlement')->where('CompanyID', '=', company_id())->where('Status', '=', 'Rejected')->count();
        $myJSON = array(
            'settls' => $all_sets,
            'pend' => $pen_sets,
            'appr' => $app_sets,
            'paid' => $paid_sets,
            'deleted' => $deleted,
            'rejected' => $rejected,
        );
        return request()->json(200, $myJSON);
    }

    public function salary_state()
    {
        $gen = DB::connection('sqlsrv2')->table('SessionReport')->where('DStatus', '=', 'P')->where('IsDeleted', 0)->where('CompanyID', '=', company_id())->exists();
        $hr = DB::connection('sqlsrv2')->table('PayrollHrApproval')->where('HrStatus', '=', 'P')->where("IsDeleted", '=', '0')->where('CompanyID', '=', company_id())->exists();
        $fin = DB::connection('sqlsrv2')->table('PayrollFinanceApproval')->where('SessionName', '=', hr_closed_session()->SessionName)->where('IsDeleted', '=', 0)->where('FStatus', '=', 'P')->where('CompanyID', '=', company_id())->exists();
        $dis = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('SessionName', '=', hr_closed_session()->SessionName)->where('CompanyID', '=', company_id())->exists();
        $myJSON = array(
            'gen' => $gen,
            'hr' => $hr,
            'fin' => $fin,
            'dis' => $dis,
        );
        return request()->json(200, $myJSON);
    }

    public function welfare_allowanceslip($id)
    {

        $result = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollWelfareAllowance', 'Emp_Profile.EmployeeID', '=', 'PayrollWelfareAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollWelfareAllowance.ApplyDate', 'desc')->select('Emp_Profile.Name', 'PayrollWelfareAllowance.*', 'Emp_Register.Department', 'Emp_Profile.CompanyName', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollWelfareAllowance.AllowanceID', '=', $id)->where('PayrollWelfareAllowance.CompanyID', '=', company_id())->get();
        $allowance_amount = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollWelfareAllowance', 'Emp_Profile.EmployeeID', '=', 'PayrollWelfareAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollWelfareAllowance.ApplyDate', 'desc')->select('Emp_Profile.Name', 'PayrollWelfareAllowance.*', 'Emp_Register.Department', 'Emp_Profile.CompanyName', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollWelfareAllowance.AllowanceID', '=', $id)->where('PayrollWelfareAllowance.CompanyID', '=', company_id())->sum('PayrollWelfareAllowance.AllowanceAmount');
        $check = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollWelfareAllowance', 'Emp_Profile.EmployeeID', '=', 'PayrollWelfareAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollWelfareAllowance.ApplyDate', 'desc')->select('Emp_Profile.Name', 'PayrollWelfareAllowance.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollWelfareAllowance.AllowanceID', '=', $id)->where('PayrollWelfareAllowance.CompanyID', '=', company_id())->exists();
        if ($check) {


            foreach ($result as $result1) {
            }

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
            $this->fpdf->Cell(70, 12, 'EMPLOYEE ALLOWANCE SLIP', 0, 1, 'C', 1);
            $this->fpdf->SetTextColor(41, 46, 46);
            $this->fpdf->ln(10);
            $this->fpdf->Cell(40, 6, ('Name: ' . $result1->Name), 0, 0, 'L', 0);
            $this->fpdf->Cell(150, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Payment Voucher', 0, 1, 'R', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(40, 6, 'Employee Code: ' . $result1->EmployeeCode, 0, 0, 'L', 0);
            $this->fpdf->Cell(145, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Voucher No:-----', 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, 'Company: ' . $result1->CompanyName, 0, 0, 'L', 0);
            $this->fpdf->Cell(145, 6, '', 0, 0, 'L', 0);
            $this->fpdf->Cell(50, 6, 'Payment Date:-----', 0, 1, 'R', 0);
            $this->fpdf->Cell(40, 6, 'Department: ' . $result1->Department, 0, 1, 'L', 0);
            $this->fpdf->Cell(40, 6, 'Designation: ' . $result1->Designation, 0, 1, 'L', 0);
            $this->fpdf->Cell(40, 6, 'Paid Date: ' . $result1->PaidDate, 0, 1, 'L', 0);

            $this->fpdf->ln(25);
            $this->fpdf->SetFont('Times', 'B', 12);
            $this->fpdf->Cell(220, 6, 'Description', 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 6, 'Total', 1, 1, 'C', 0);
            $this->fpdf->SetFont('Times', '', 12);
            $this->fpdf->Cell(220, 15, ($result1->AllowanceType . ' Allowance for ' . $result1->Descriptions . ' use of Amount ' . number_format($result1->AllowanceAmount) . '. Paid Through ' . $result1->PaidThrough), 1, 0, 'C', 0);
            $this->fpdf->Cell(40, 15, number_format($result1->AllowanceAmount), 1, 1, 'C', 0);
            $this->fpdf->Cell(220, 6, 'Total Amount:', 0, 0, 'R', 0);
            $this->fpdf->Cell(40, 6, number_format($allowance_amount), 0, 1, 'C', 0);
            $this->fpdf->Output();
            exit;
        }
    }

    public function single_welfarepayroll($id)
    {


        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollWelfareAllowance', 'Emp_Profile.EmployeeID', '=', 'PayrollWelfareAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollWelfareAllowance.AllowanceID', 'desc')->select('Emp_Profile.Name', 'PayrollWelfareAllowance.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('PayrollWelfareAllowance.AllowanceID', '=', $id)->where('PayrollWelfareAllowance.CompanyID', '=', company_id())->get();

        return request()->json(200, $arr);
    }


    public function search_welfarepayroll(Request $request)
    {

        //return DB::connection('sqlsrv2')->table('Emp_Profile')->join('PayrollWelfareAllowance', 'Emp_Profile.EmployeeID', '=', 'PayrollWelfareAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('PayrollWelfareAllowance.AllowanceID', 'desc')->select('Emp_Profile.Name', 'PayrollWelfareAllowance.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode', 'Emp_Register.Salary', 'Emp_Register.JoiningDate')->where('Emp_Profile.Name', 'LIKE', '%' . $request->keyword1 . '%')->orwhere('Emp_Register.EmployeeCode', 'LIKE', '%' . $request->keyword1 . '%')->where('PayrollWelfareAllowance.IsDeleted', '=', 0)->where('PayrollWelfareAllowance.CompanyID', '=', company_id())->paginate(15);

        return DB::connection('sqlsrv2')
            ->table('Emp_Profile')
            ->join('PayrollWelfareAllowance', 'Emp_Profile.EmployeeID', '=', 'PayrollWelfareAllowance.EmployeeID')
            ->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')
            ->orderBy('PayrollWelfareAllowance.AllowanceID', 'desc')
            ->select(
                'Emp_Profile.Name',
                'PayrollWelfareAllowance.*',
                'Emp_Register.Department',
                'Emp_Register.Designation',
                'Emp_Register.EmployeeCode',
                'Emp_Register.Salary'
            )
            ->where(function ($query) use ($request) {
                $query->Where('Emp_Profile.Name', 'LIKE', '%' . $request->keyword1 . '%')
                    ->orWhere('Emp_Register.EmployeeCode', 'LIKE', '%' . $request->keyword1 . '%');
            })
            ->where('PayrollWelfareAllowance.IsDeleted', '=', 0)
            ->where('PayrollWelfareAllowance.CompanyID', '=', company_id())
            ->paginate(15);
    }

    public function submit_welfareallowance(Request $request)
    {


        $emp_id = $request->get('emp_emp_id');
        $emp_amount = $request->get('emp_amount');
        $emp_description = $request->get('emp_description');
        $emp_date = $request->get('emp_date');
        $session_name = $request->get('session_name');


        $update_date = long_date();
        $allowance_type = $request->get('allowance_type');

        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;


        $se = explode("_", $emp_id);

        $find_employee_id = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeCode', '=', $se[1])->get();
        foreach ($find_employee_id as $find_employee_id1) {
        }

        $sub_emp_id = $find_employee_id1->EmployeeID;

        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Welfare Allowance Applied', ' Allowance of ' . $sub_emp_id . ' applied', $update_date]);

        $result = DB::connection('sqlsrv2')->insert("INSERT INTO PayrollWelfareAllowance(CompanyID,EmployeeID,Session,ApplyDate,AllowanceType,AllowanceAmount,Descriptions,Status,CreatedBy,CreatedOn) values (?,?,?,?,?,?,?,?,?,?)", [company_id(), $sub_emp_id, $session_name, $emp_date, $allowance_type, $emp_amount, $emp_description, 'Pending', username(), $update_date]);

        $arr = 'Allowance Applied!';
        return request()->json(200, $arr);
    }

    public function approve_welfareallowance($id)
    {


        $update_date = long_date();

        $result = DB::connection('sqlsrv2')->update('update PayrollWelfareAllowance set Status=?,ApprovedBy=? where AllowanceID=? and CompanyID=?', ['Approved', username(), $id, company_id()]);

        $id_arr = DB::connection('sqlsrv2')->table('PayrollWelfareAllowance')->select('EmployeeID')->where('AllowanceID', '=', $id)->where('CompanyID', '=', company_id())->get();
        foreach ($id_arr as $id_arr1) {
        }
        $emp_id = $id_arr1->EmployeeID;
        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Welfare Allowance Status Changed', ' Allowance of ' . $emp_id . ' approved', $update_date]);

        if ($result) {
            $arr = 'Updated';
            return request()->json(200, $arr);
        }
    }

    public function pay_welfareallowance(Request $request)
    {
        $update_date = long_date();
        $allowance_id = $request->get("id");
        $paid_date = $request->get("date");
        $doc_date = date("Y-m-d");
        $paid_through = $request->get("paid_through");
        $cashinhand_balance = DB::connection('sqlsrv3')->select("SET NOCOUNT ON ;EXEC  [dbo].[dashboard]
       @Datefrom = N'2000-01-01',
       @DateTo = N'" . $doc_date . "',
       @id = " . 101001001001 . ",
       @compid = N'" . company_id() . "'  ");
        foreach ($cashinhand_balance as $cashinhand_balance1) {
        }
        if ($cashinhand_balance1->am <= 0) {
            $find_config = 'Not Suficient Balance';
            return request()->json(200, $find_config);
        }

        $final_PoCode = PVID();

        $result = DB::connection('sqlsrv2')->update('update PayrollWelfareAllowance set Status=?,PaidThrough=?,PaidDate=?,UpdatedBy=?,UpdatedOn=?,PVID=? where AllowanceID=? and CompanyID=?', ['Paid', $paid_through, $paid_date, username(), $update_date, $final_PoCode, $allowance_id, company_id()]);
        $id_arr1 = DB::connection('sqlsrv2')->table('PayrollWelfareAllowance')->where('AllowanceID', '=', $allowance_id)->where('CompanyID', '=', company_id())->first();
        //            foreach ($id_arr as $id_arr1) {
        //
        //            }
        $emp_id = $id_arr1->EmployeeID;
        if ($result) {
            if (Session::get('company_accounts_plan') == 'true') {
                // DB::connection('sqlsrv3')->insert('INSERT INTO SequenceVoucher(PVID,RefID,RefType,CompanyID,MonthId) values (?,?,?,?,?)', [$final_PoCode,$allowance_id,'Welfare Allowance',company_id(),$date_pref]);
                insert_sequencevoucher($final_PoCode, $allowance_id, 'Welfare Allowance');

                $doc = DB::connection('sqlsrv3')->insert('INSERT INTO Documents(DocumentDate,DocumentNo,Description,DocumentType,InsertedAt,InsertedBy,CompanyID) values (?,?,?,?,?,?,?)', [$doc_date, $final_PoCode, $id_arr1->AllowanceType . ' Allowance Paid : ' . $id_arr1->PaidThrough, 'Welfare Allowance', $update_date, username(), company_id()]);


                if ($doc) {
                    $find_doc_id = DB::connection('sqlsrv3')->table("Documents")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentNo', '=', $final_PoCode)->get();
                    foreach ($find_doc_id as $find_doc_id1) {
                    }

                    $transaction = DB::connection('sqlsrv3')->insert('INSERT INTO Transactions(DocumentID,TransactionDate,Description,CompanyID) values (?,?,?,?)', [$find_doc_id1->ID, $doc_date, $id_arr1->AllowanceType . ' Allowance Paid : ' . $id_arr1->PaidThrough, company_id()]);
                    $find_tran_id = DB::connection('sqlsrv3')->table("Transactions")->select('ID')->where('CompanyID', '=', company_id())->where('DocumentID', '=', $find_doc_id1->ID)->get();
                    foreach ($find_tran_id as $find_tran_id1) {
                    }


                    //find_Account id


                    $ledger_entry = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '504002008', 'D', $id_arr1->AllowanceAmount, company_id()]);
                    $ledger_entry2 = DB::connection('sqlsrv3')->insert('INSERT INTO Ledger_Entries(TransactionID,AccountID,EntryType,Amount,CompanyID) values (?,?,?,?,?)', [$find_tran_id1->ID, '101001001001', 'C', $id_arr1->AllowanceAmount, company_id()]);
                }
            }
        }


        DB::insert("INSERT INTO Activity_Log(CompanyId, UserEmail, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?,?)", [company_id(), username(), UserFullName(), 'Welfare Allowance Paid', ' Allowance of ' . $emp_id . ' Paid', $update_date]);

        if ($result) {
            $arr = 'Paid';
            return request()->json(200, $arr);
        }
    }

    public function delete_settlement($id)
    {


        $update_date = long_date();

        $result = DB::connection('sqlsrv2')->update('update FinalSettlement set IsDeleted=?, DeletedOn=?, DeletedBy=? where CompanyID=? AND ID=?', ['1', $update_date, username(), company_id(), $id]);

        if ($result) {
            $arr = 'settlement deleted';
            return request()->json(200, $arr);
        } else {
            $arr = 'Final settlement not deleted!';
            return request()->json(200, $arr);
        }
    }

    public function getemployee_Saldetails($id)
    {
        if ($id == 0) {
            $id = employee_id();
        }
        $arr = DB::connection('sqlsrv2')->table('Payroll_Distribution')->where('EmployeeID', '=', $id)->get();
        return request()->json(200, $arr);
    }


    public function getemployee_Loandetails($id)
    {
        if ($id == 0) {
            $id = employee_id();
        }
        $arr = DB::connection('sqlsrv2')->table('LoanRequisition')->where('EmployeeID', '=', $id)->get();
        return request()->json(200, $arr);
    }

    public function getattendance($department, $location, $designation, $start, $close, $code)
    {
        $company_id = Session::get('company_id');
        $username = Session::get('username');
        $dept = Session::get('employee_department');
        $emp_code = Session::get('employee_id');
        $name = '';
        $arr1 = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC   [dbo].[Get_reporting_tree]
      @id = N'" . $emp_code . "',
      @companyid = N'" . $company_id . "'
    ");
        $arr = DB::connection('sqlsrv2')->table('Att_Permission')->join('Emp_Register', 'Att_Permission.SubEmpID', '=', 'Emp_Register.EmployeeID')->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->select('Emp_Profile.*', 'Emp_Register.*')->orderBy('Emp_Profile.Name', 'asc')->where('Att_Permission.CompanyID', '=', $company_id)->where('Att_Permission.ChiefEmpID', '=', $emp_code)->where('Att_Permission.IsMandatory', '=', 1)->get();
        $arr2 = json_decode(json_encode($arr), FALSE);
        $team = array_merge($arr1, $arr2);
        $EmpCode = [];
        foreach ($team as $team1) {
            if (is_object($team1)) {
                $EmpCode[] = $team1->EmployeeCode;
            }
        }
        if ($dept == 'Software Development' || $dept == 'Human Resource') {
            // return request()->json(200,$code.'  '. $start);
            if ($designation == 'All' && $department == 'All' && $location == 'All') {
                $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID', '=', $company_id)->where('Emp_Register.EmployeeCode', 'like', '%' . $code . '%')->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)->paginate(20);
                return request()->json(200, $arr);
            } else {
                if ($department == 'All') {
                    $department = '';
                }
                if ($designation == 'All') {
                    $designation = '';
                }
                if ($location == 'All') {
                    $location = '';
                }
                $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID', '=', $company_id)->where('Emp_Register.EmployeeCode', 'like', '%' . $code . '%')->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)->where('Emp_Register.Department', 'like', '%' . $department . '%')->where('Emp_Register.Designation', 'like', '%' . $designation . '%')->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')->paginate(30);
                return request()->json(200, $arr);
            }
        } else {
            if ($designation == 'All' && $location == 'All') {
                $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID', '=', $company_id)->whereIn('Emp_Register.EmployeeCode', $EmpCode)->where('Emp_Register.EmployeeCode', 'like', '%' . $code . '%')->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)->paginate(20);
                return request()->json(200, $arr);
            } else {
                if ($designation == 'All') {
                    $designation = '';
                }
                if ($location == 'All') {
                    $location = '';
                }
                $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('AttData', 'Emp_Profile.EmployeeID', '=', 'AttData.EmpID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('AttData.EmpID', 'desc')->select('Emp_Profile.Name', 'AttData.*', 'Emp_Register.Department', 'Emp_Register.PostingCity', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('AttData.CompanyID', '=', $company_id)->whereIn('Emp_Register.EmployeeCode', $EmpCode)->where('Emp_Register.EmployeeCode', 'like', '%' . $code . '%')->where('AttData.ATTDate', '>=', $start)->where('AttData.ATTDate', '<=', $close)
                    ->where('Emp_Register.Designation', 'like', '%' . $designation . '%')
                    ->where('Emp_Register.PostingCity', 'like', '%' . $location . '%')->paginate(20);
                return response()->json($arr, 200);
            }
        }
    }


    public function organization_chart()
    {
        $company_id = "632462982ad6e";
        $team = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC [dbo].[Get_reporting_tree] @id = '1', @companyid = N'" . company_id() . "'");
        return request()->json(200, $team);
    }


    //fetch Employee detail for loan and advance
    public function employee_dtl_bycode($emp_code1)
    {
        $emp_loan_dtl = DB::connection('sqlsrv2')->table('Emp_Register')->join('Emp_Profile', 'Emp_Register.EmployeeID', '=', 'Emp_Profile.EmployeeID')->orderBy('Emp_Register.EmployeeID', 'asc')->select('Emp_Profile.*', 'Emp_Register.*')->where('Emp_Register.CompanyID', '=', company_id())->where('Emp_Register.EmployeeCode', '=', $emp_code1)->get();
        return request()->json(200, $emp_loan_dtl);
    }

    //
    public function avg_attendance_times($id)
    {

        if ($id == 0) {
            $id = employee_id();
        }
        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }


        $time = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ;EXEC   [dbo].[Employee_AVG_Time]
        @Id = '" . $id . "',
        @STARTDATE = N'" . $find_session1->StartDate . "',
        @ENDDATE = N'" . $find_session1->EndDate . "'
      ");
        return request()->json(200, $time);
    }

    public function overall_employees()
    {
        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->select('Emp_Profile.EmployeeID', 'Emp_Profile.Name', 'Emp_Register.EmployeeCode',)->where('Emp_Profile.CompanyID', '=', company_id())->get();
        return request()->json(200, $arr);
    }

    public function department_byName(Request $request)
    {
        $check_conversation = DB::connection('sqlsrv2')->table('Employee_Dep_Comp')->where('IsDeleted', '=', 0)->orderby('Company', 'asc')->where('Department', 'LIKE', '%' . $request->keyword1 . '%')->where('Company', 'LIKE', '%' . $request->keyword2 . '%')->where('CompanyID', '=', company_id())->paginate(10);
        return response()->json($check_conversation);
    }

    public function disable_department($id)
    {
        $result5 = DB::connection('sqlsrv2')->update('update Employee_Dep_Comp set Status=? where id =?', ["Disabled", $id]);
        if ($result5) {
            $message = 'Disabled';
            return request()->json(200, $message);
        }
    }

    public function active_department($id)
    {

        $result5 = DB::connection('sqlsrv2')->update('update Employee_Dep_Comp set Status=? where id =?', ["Active", $id]);
        if ($result5) {
            $message = 'Activated';
            return request()->json(200, $message);
        }
    }

    public function submit_hr_department(Request $request)
    {


        $department_name = $request->get('department_name');
        $company_name = $request->get('company_name');

        $update_date = long_date();

        $if_exist = DB::connection('sqlsrv2')->table('Employee_Dep_Comp')->where('Department', '=', $department_name)->where('IsDeleted', '=', 0)->where('Company', '=', $company_name)->where('CompanyID', '=', company_id())->exists();
        if ($if_exist) {
            $message = 'Already Exist';
        } else {
            $insertedId = DB::connection('sqlsrv2')
                ->table('Employee_Dep_Comp')
                ->insertGetId([
                    'Department' => $department_name,
                    'Company' => $company_name,
                    'CreatedBy' => username(),
                    'CreatedOn' => $update_date,
                    'CompanyID' => company_id(),
                ]);

            // Retrieve the inserted data by querying the table with the ID
            $insertedData = DB::connection('sqlsrv2')
                ->table('Employee_Dep_Comp')
                ->find($insertedId);

            $message = 'Department added';
        }

        return response()->json(['message' => $message, 'data' => $insertedData], 200);
    }

    public function delete_hr_department($id)
    {


        $update_date = long_date();

        $result = DB::connection('sqlsrv2')->update("UPDATE Employee_Dep_Comp SET IsDeleted=?, DeletedBy=?, DeletedOn=? WHERE ID=? and CompanyID=?", [1, username(), $update_date, $id, company_id()]);

        if ($result) {
            $message = 'Department deleted';
        }
        return request()->json(200, $message);
    }

    //
    //fetch department to edit
    public function fetch_hr_department($id)
    {

        $dept = DB::connection('sqlsrv2')->table('Employee_Dep_Comp')->where('CompanyID', '=', company_id())->where('ID', '=', $id)->get();
        return request()->json(200, $dept);
    }

    //Update department
    public function update_hr_department(Request $request)
    {


        $dep_id = $request->get('dep_id');
        $ed_department_name = $request->get('ed_department_name');
        $ed_company_name = $request->get('ed_company_name');
        $old_department = $request->get('old_department');
        $old_company = $request->get('old_company');

        $update_date = long_date();

        $result = DB::connection('sqlsrv2')->table('Employee_Dep_Comp')->where('Department', '=', $ed_department_name)->where('Company', '=', $ed_company_name)->where('ID', '!=', $dep_id)->where('CompanyID', '=', company_id())->exists();
        if ($result) {
            $data = "Department exist";
            return request()->json(200, $data);
        } else {
            DB::connection('sqlsrv2')->update("UPDATE Employee_Dep_Comp SET Department=?, Company=?, UpdatedBy=?, UpdatedOn=? WHERE ID=? and CompanyID=?", [$ed_department_name, $ed_company_name, username(), $update_date, $dep_id, company_id()]);
            DB::connection('sqlsrv2')->update("UPDATE Emp_Register SET Department=? WHERE Department=? and CompanyName=? and CompanyID=?", [$ed_department_name, $old_department, $old_company, company_id()]);
            $data = "Department updated";
            return request()->json(200, $data);
        }
    }

    public function id_by_code($code)
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Register')->where('CompanyID', '=', company_id())->where('EmployeeCode', '=', $code)->get();
        foreach ($arr as $arr1) {
        }
        return request()->json(200, $arr1->EmployeeID);
    }

    //
    public function users_overtime($department)
    {


        $find_session = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID', '=', company_id())->where('CurrentSession', '=', 1)->get();
        foreach ($find_session as $find_session1) {
        }
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;
        $i = 0;
        $k = '';
        $rangArray = [];
        $startDate = strtotime($s_date);
        $endDate = strtotime($e_date);
        for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }
        $count_range = count($rangArray);
        $result = DB::connection('sqlsrv2')->select("SET NOCOUNT ON ; exec [dbo].[GetMonthlyOvertimeReport]  N'" . $s_date . "', N'" . $e_date . "', N'" . $department . "' ");

        foreach ($result as $result1) {
            $i++;
            $b[$i] =
                '<tr><td><span class="td-left fw-bolder">' . $result1->Name . '</span><br/>' . $result1->EmpCode . '</td>
                <td class="td-left"">' . $result1->Department . '</td>
                <td class="td-center">
                    <input type="checkbox" name="selected[]">
                    <input type="hidden" name="first[]" value="' . $result1->EmpID . '" />
                </td>
                <td class="td-center">' . $result1->{$rangArray[0]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[1]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[2]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[3]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[4]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[5]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[6]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[7]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[8]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[9]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[10]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[11]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[12]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[13]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[14]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[15]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[16]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[17]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[18]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[19]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[20]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[21]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[22]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[23]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[24]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[25]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[26]} . '</td>
                <td class="td-center">' . $result1->{$rangArray[27]} . '</td>';
            if ($count_range == 29) {
                $b[$i] = $b[$i] .
                    '<td class="td-center">' . $result1->{$rangArray[28]} . '</td>
                    </tr>';
            } else if ($count_range == 30) {
                $b[$i] = $b[$i] .
                    '<td class="td-center">' . $result1->{$rangArray[28]} . '</td>
                    <td class="td-center">' . $result1->{$rangArray[29]} . '</td>
                    </tr>';
            } else if ($count_range == 31) {
                $b[$i] = $b[$i] .
                    '<td class="td-center">' . $result1->{$rangArray[28]} . '</td>
                    <td class="td-center">' . $result1->{$rangArray[29]} . '</td>
                    <td class="td-center">' . $result1->{$rangArray[30]} . '</td>
                    </tr>';
            }
            $k = $k . '' . $b[$i];
        }
        $d = $k;
        return request()->json(200, $d);
    }

    public function fetch_fuel_limit($id)
    {

        $arr = DB::connection('sqlsrv2')->table('Emp_Profile')->join('FuelAllowance', 'Emp_Profile.EmployeeID', '=', 'FuelAllowance.EmployeeID')->join('Emp_Register', 'Emp_Profile.EmployeeID', '=', 'Emp_Register.EmployeeID')->orderBy('FuelAllowance.AllowanceID', 'desc')->select('Emp_Profile.Name', 'FuelAllowance.*', 'Emp_Register.Department', 'Emp_Register.Designation', 'Emp_Register.EmployeeCode')->where('FuelAllowance.CompanyID', '=', company_id())->where('FuelAllowance.AllowanceID', '=', $id)->get();
        return request()->json(200, $arr);
    }

    public function update_fuel_limit(Request $request)
    {


        $today_date_time = long_date();

        $allowance_id = $request->get('allowance_id');
        $emp_limit = $request->get('emp_limit');

        DB::connection('sqlsrv2')->update('update FuelAllowance set FuelQuantity=?, UpdatedBy=?, UpdatedOn=? where AllowanceID=? and CompanyID=?', [$emp_limit, username(), $today_date_time, $allowance_id, company_id()]);
        return request()->json(200, 'updated');
    }

    public function sendEmail()
    {
        //Log::info('Attempting to send email');
        $email = new EmailClass();
        $isSend1 = Mail::to('ahmadshahbazkz@gmail.com')->send($email);
        //        $isSend = Mail::to('dashboard@sasystems.solutions')->send($email);
        dd($isSend1, $isSend1);

        return 'Email sent successfully';
    }
}
