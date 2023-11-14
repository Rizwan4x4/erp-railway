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


class Unitsdata_permission extends Seeder
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
        Permission::create(['name' => 'Units-Management', 'type' => 'Units-Management']);

         //journal voucher
         Permission::create(['name' => 'Units-Management units-data readOnly']);
         Permission::create(['name' => 'Units-Management units-data supervision']);
         Permission::create(['name' => 'Units-Management units-data fetch-data']);

         $backendSource = 'backend';
         $type = 'Units-Management';
      $unitsdata = Role::create(['name' => 'Units-data', 'source' => $backendSource,'type' => $type]);

      $unitsdataPermissions=[
        'Units-Management units-data readOnly',
        'Units-Management units-data supervision',
        'Units-Management units-data fetch-data'
    ];
    $unitsdata->syncPermissions($unitsdataPermissions);



    
$userEmail = env('USER_EMAIL');
$user = User::where('email', $userEmail)->first();
$unitmanagementpermission = Permission::findByName('Units-Management');

if ($user) {
    $user->givePermissionTo($unitmanagementpermission);
    $user->assignRole('Units-data');


  
} else {
    // Handle the case when the user with the specified email is not found
    $this->command->info("User with email $userEmail not found.");
}


    }
}
