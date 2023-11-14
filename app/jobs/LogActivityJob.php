<?php

namespace App\jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogActivityJob implements ShouldQueue
{
    use InteractsWithQueue;

    protected $status;
    protected $description;

    public function __construct($status, $description)
    {
        $this->status = $status;
        $this->description = $description;
    }

    public function handle()
    {
        $this->insertLog($this->status, $this->description);
    }

    protected function insertLog($status, $description)
    {
        return DB::table('Activity_Log')->insert([
            'CompanyId' => company_id(),
            'UserEmail' => username(),
            'EmployeeName' => UserFullName(),
            'EmployeeID' => employee_id(),
            'EventStatus' => $status,
            'Description' => $description,
            'ActivityTime' => long_date(),
        ]);
    }
}

