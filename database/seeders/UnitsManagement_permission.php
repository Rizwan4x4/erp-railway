<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExtendedPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use App\Models\User;

class UnitsManagement_permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('permissions')->delete();;
        // DB::table('roles')->delete();

        Permission::create(['name' => 'UnitManagement readOnly']);
        Permission::create(['name' => 'UnitManagement supervision']);
        Permission::create(['name' => 'UnitManagement fetching-data']);
        $backendSource = 'backend';
        $type = 'UnitsManagement';
        $unitsManagement = Role::create(['name' => 'Units Management', 'source' => $backendSource,'type' => $type]);

        $unitsManagementPermissions=[
            'UnitManagement readOnly',
            'UnitManagement supervision',
            'UnitManagement fetching-data'
        ];

$unitsManagement->syncPermissions($unitsManagementPermissions);

$user = User::where('email', 'yasirsohail912@gmail.com')->first();
$user->assignRole('Units Management');

    }
}
