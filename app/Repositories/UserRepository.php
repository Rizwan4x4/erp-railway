<?php

namespace App\Repositories;

use App\Contracts\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    protected $table;

    public function __construct()
    {
        $this->table = 'tb_users';
    }

    public function all()
    {
        return DB::table($this->table)->get();
    }

    public function find($id)
    {
        return DB::table($this->table)->find($id);
    }

    public function create(array $data)
    {
        return DB::table($this->table)->insert($data);
    }

    public function update($id, array $data)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }
}
