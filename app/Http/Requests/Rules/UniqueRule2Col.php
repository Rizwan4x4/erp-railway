<?php
namespace App\Http\Requests\Rules;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueRule2Col implements Rule
{
    protected $table;
    protected $column1;
    protected $column2;
    protected $connection;
    protected $club_id;

    public function __construct($table, $column1,$column2,$club_id, $connection ='sqlsrv2')
    {
        $this->table = $table;
        $this->column1 = $column1;
        $this->column2 = $column2;
        $this->connection = $connection;
        $this->club_id = $club_id;
    }

    public function passes($attribute, $value)
    {
        // dd($this->column1,$this->column2,  $value, $this->club_id);
        $result = DB::connection($this->connection)
        ->table($this->table)
        ->where($this->column1, $value) // Assuming $this->column1 represents 'employee_code'
        ->where($this->column2, $this->club_id) // Assuming $this->column2 represents 'club_id'
        ->exists();
        // dd($result);

        return !$result;
    }

    public function message()
    {
        return "record already exists.";
    }
}

