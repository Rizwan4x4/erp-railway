<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ExtendedPermission extends Permission
{
    use HasFactory;
    protected $fillable = ['name', 'guard_name', 'type'];
}
