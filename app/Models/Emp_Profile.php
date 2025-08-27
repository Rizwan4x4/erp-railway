<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Emp_Profile extends Model
{
    use HasFactory;

    protected $table = 'Emp_Profile';
    protected $connection = 'sqlsrv2';
    protected $primaryKey = 'EmployeeID';
    public $timestamps = false;

    protected $fillable = [
    // 'EmployeeID',
    'Name',
    'FatherHusband',
    'Gender',
    'Religion',
    'Email',
    'Mobile',
    'Phone',
    'CNIC',
    'CnicExpiry',
    'MaritalStatus',
    'DOB',
    'BloodGroup',
    'City',
    'Address',
    'CreatedBy',
    'CreatedOn',
    'DeletedBy',
    'DeletedOn',
    'UpdatedBy',
    'UpdatedOn',
    'CompanyID',
    'Relation',
    'Employee_Code',
    'CompanyName',
    'Country'
];
}
