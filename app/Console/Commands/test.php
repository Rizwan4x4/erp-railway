<?php

namespace App\Console\Commands;

use Session;
use DB;
use Illuminate\Console\Command;


class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:HrSession';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return Command::SUCCESS;
        $company_id = '632462982ad6e';
        date_default_timezone_set("Asia/Karachi");
        $update_date = date("Y-m-d");
        $update_date_time = date("Y-m-d h:i:s A");
        $find_session1 = DB::connection('sqlsrv2')->table('HrSessions')->where('CompanyID','=',$company_id)->orderby('SessionID', 'desc')->first();
        
        $session_id = $find_session1->SessionID;
        $sesson_name = $find_session1->SessionName;
        $s_date = $find_session1->StartDate;
        $e_date = $find_session1->EndDate;
        
        if($e_date < $update_date){
            $newSdate = date('Y-m-d', strtotime($s_date. ' + 1 months'));
            $newEdate = date('Y-m-d', strtotime($e_date. ' + 1 months'));
            $year = date('Y', strtotime($newSdate));
            $month = date('F', strtotime($newEdate));
            $New_sesson_name = $month.'-'.$year;

            $update = DB::connection('sqlsrv2')->update('update HrSessions set CurrentSession=? where CompanyID=? and SessionID=?',[0, $company_id, $session_id]);
            if($update){
                DB::connection('sqlsrv2')->insert('INSERT INTO HrSessions(SessionName, StartDate, EndDate, CreateBy, CreateOn, CompanyID, AttClosedPayrollStart, DistState, CurrentSession) values (?,?,?,?,?,?,?,?,?)', [$New_sesson_name, $newSdate, $newEdate, 'By System', $update_date_time, $company_id, 'Open', 1, 1]);

                DB::insert("INSERT INTO Activity_Log(CompanyId, EmployeeName, EventStatus, Description, ActivityTime) values (?,?,?,?,?)", [$company_id, 'By System','Insert New Session','New session '.$New_sesson_name.' added as current and previous session '.$sesson_name.'\'s status changed to not current', $update_date_time]);
            }
        }
        
    }
}
