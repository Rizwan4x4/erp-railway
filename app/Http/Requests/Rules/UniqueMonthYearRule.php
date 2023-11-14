<?php
namespace App\Http\Requests\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueMonthYearRule implements Rule
{
    protected $table;
    protected $column;
    protected $column2;
    protected $connection;
    protected $member_id;

    public function __construct($table, $column,$column2,$member_id ,$connection = 'sqlsrv2')
    {
        $this->table = $table;
        $this->column = $column;
        $this->column2 = $column2;
        $this->member_id = $member_id;
        $this->connection = $connection;
    }

    public function passes($attribute, $value)
    {
       // dd($this->column1,$this->column2, $value, $this->club_id);
        // Extract month and year from the date string
        $dateComponents = explode('-', $value);
        $year = $dateComponents[0];
        $month = $dateComponents[1];

        $result = DB::connection($this->connection)
            ->table($this->table)
            ->where($this->column, $value)
            ->where($this->column2, $this->member_id)
            ->whereRaw("YEAR(FeeDate) = $year")
            ->whereRaw("MONTH(FeeDate) = $month")
            ->exists();

        return !$result;
    }

    public function message()
    {
        return "record already exists.";
    }
}
