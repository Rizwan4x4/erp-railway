<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use maliklibs\Zkteco\Lib\ZKTeco;

class PullAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:attendance';

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
            }
            else {
                continue;
            }
        }
        if (!empty($insertData)) {

            //dd('confirm insertion');
            DB::connection('sqlsrv2')->table('Machine_Attendance')->insert($insertData);
            DB::connection('sqlsrv2')->select("SET NOCOUNT ON; EXEC [dbo].[Insert_Into_Attdatas]; EXEC [dbo].[Add_PunchTime_Attdata]; EXEC [dbo].[AttendanceStatus]");
        }
    }
}
