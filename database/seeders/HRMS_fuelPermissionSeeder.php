<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class HRMS_fuelPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission::query()->delete();

    //   //AR 
    //   DB::table('permissions')->delete();;
    //   DB::table('roles')->delete();


    //   // Define permissions
Permission::create(['name' => 'Fuel', 'type' => 'Fuel']);
Permission::create(['name' => 'Fuel Setting']);
Permission::create(['name' => 'Fuel assign fuel allowance']);
Permission::create(['name' => 'Fuel setting update actions']);

Permission::create(['name' => 'Fuel bills']);
Permission::create(['name' => 'Fuel new bill']);
Permission::create(['name' => 'Fuel bill actions']);


Permission::create(['name' => 'HR Configuration', 'type' => 'HR Configuration']);

Permission::create(['name' => 'HR Controller overall-view']);

Permission::create(['name' => 'HR Controller Session Detail Status']);
Permission::create(['name' => 'HR Controller Session Detail delete action']);

Permission::create(['name' => 'HR Controller warning reason add new']);
Permission::create(['name' => 'HR Controller warning reason actions']);


Permission::create(['name' => 'HR Controller inchlude holiday']);
Permission::create(['name' => 'HR Controller delete holiday']);

Permission::create(['name' => 'HR Controller Add leave type']);
Permission::create(['name' => 'HR Controller delete leave type']);

Permission::create(['name' => 'HR Controller hr configuration update']);
Permission::create(['name' => 'HR Controller add new fine']);


Permission::create(['name' => 'Department overall-view']);
Permission::create(['name' => 'Add new department']);
Permission::create(['name' => 'Reset department']);
Permission::create(['name' => 'department actions']);
Permission::create(['name' => 'clear department']);


Permission::create(['name' => 'Designantion overall-view']);
Permission::create(['name' => 'Add new Designantion']);
Permission::create(['name' => 'Reset Designantion']);
Permission::create(['name' => 'Designantion actions']);


Permission::create(['name' => 'Work Location overall-view']);
Permission::create(['name' => 'Add new Location']);
Permission::create(['name' => 'Location actions']);
Permission::create(['name' => 'Add new city']);
Permission::create(['name' => 'Delete city']);


$backendSource = 'backend';
$type = 'Fuel';

// $fuel = Role::create(['name' => 'Fuel', 'source' => $backendSource, 'type' => $type]);
$fuelSetting = Role::create(['name' => 'Fuel Setting', 'source' => $backendSource, 'type' => $type]);
$fuelBills = Role::create(['name' => 'Fuel Bills', 'source' => $backendSource, 'type' => $type]);



$type = 'HR Configuration';
// $HrConfiguration = Role::create(['name' => 'HR Configuration','source' => $backendSource, 'type' => $type]);
$HrController = Role::create(['name' => 'HR Controller', 'source' => $backendSource, 'type' => $type]);
$Department = Role::create(['name' => 'Department', 'source' => $backendSource, 'type' => $type]);
$Designations = Role::create(['name' => 'Designations', 'source' => $backendSource, 'type' => $type]);
$WorkLocations = Role::create(['name' => 'Work Locations', 'source' => $backendSource, 'type' => $type]);





// $fuelPermissions = [
//     'Fuel overall-view',
//     'Fuel Setting',
//     'Fuel assign fuel allowance',
//     'Fuel setting update actions',
//     'Fuel bills',
//     'Fuel new bill',
//     'Fuel bill actions',
// ];

// $fuel->syncPermissions($fuelPermissions);
$fuelsetting = [
    'Fuel Setting',
    'Fuel assign fuel allowance',
    'Fuel setting update actions',
];
$fuelSetting->syncPermissions($fuelsetting);

$fuelbills = [
    'Fuel bills',
    'Fuel new bill',
    'Fuel bill actions',
];
$fuelBills->syncPermissions($fuelbills);

// Define an array of permission names
// $hrConfigurationPermissions = [
//     'HR Configurations overall-view',
//     'HR Controller overall-view',
//     'HR Controller Session Detail Status',
//     'HR Controller Session Detail delete action',
//     'HR Controller warning reason add new',
//     'HR Controller warning reason actions',
//     'HR Controller inchlude holiday',
//     'HR Controller Add leave type',
//     'HR Controller hr configuration update',
//     'HR Controller add new fine',
//     'Department overall-view',
//     'Add new department',
//     'Reset department',
//     'department actions',
//     'clear department',
//     'Designantion overall-view',
//     'Add new Designantion',
//     'Reset Designantion',
//     'Designantion actions',
//     'Work Location overall-view',
//     'Add new Location',
//     'Location actions',
//     'Add new city',
//     'Delete city',
// ];


// $HrConfiguration->syncPermissions($hrConfigurationPermissions);



$hrControllerPermissions = [
   
    'HR Controller overall-view',
    'HR Controller Session Detail Status',
    'HR Controller Session Detail delete action',
    'HR Controller warning reason add new',
    'HR Controller warning reason actions',
    'HR Controller inchlude holiday',
    'HR Controller Add leave type',
    'HR Controller hr configuration update',
    'HR Controller add new fine',

];
$HrController->syncPermissions($hrControllerPermissions);
$departmentPermissions = [

    'Department overall-view',
    'Add new department',
    'Reset department',
    'department actions',
    'clear department',

];
$Department->syncPermissions($departmentPermissions);

$designationPermissions = [

    'Designantion overall-view',
    'Add new Designantion',
    'Reset Designantion',
    'Designantion actions',

];
$Designations->syncPermissions($designationPermissions);
// Define an array of permission names
$worklocationPermissions = [

    'Work Location overall-view',
    'Add new Location',
    'Location actions',
    'Add new city',
    'Delete city',
];
$WorkLocations->syncPermissions($worklocationPermissions);


$userEmail = env('USER_EMAIL');
$user = User::where('email', $userEmail)->first();
$fuelpermission = Permission::findByName('Fuel');
$hrConfigurationpermission = Permission::findByName('HR Configuration');

if ($user) {
    $user->givePermissionTo($fuelpermission);
    $user->assignRole('Fuel Setting');
    $user->assignRole('Fuel Bills');
    // $user->assignRole('HR Configuration');
    $user->givePermissionTo($hrConfigurationpermission);

    $user->assignRole('HR Controller');
    $user->assignRole('Department');
    $user->assignRole('Designations');
    $user->assignRole('Work Locations');

  
} else {
    // Handle the case when the user with the specified email is not found
    $this->command->info("User with email $userEmail not found.");
}


}
}
