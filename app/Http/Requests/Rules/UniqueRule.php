<?php
namespace App\Http\Requests\Rules;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueRule implements Rule
{
    protected $table;
    protected $column;
    protected $connection;

    public function __construct($table, $column, $connection = 'sqlsrv2')
    {
        $this->table = $table;
        $this->column = $column;
        $this->connection = $connection;
    }

    public function passes($attribute, $value)
    {
        $result = DB::connection($this->connection)
            ->table($this->table)
            ->where($this->column, $value)
            ->exists();

        return !$result;
    }

    public function message()
    {
        return "The :attribute already exists in the {$this->table} table.";
    }
}

