<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\ExtendedPermission; // Update the namespace if necessary
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  DB::table('permissions')->delete();;
        //  DB::table('roles')->delete();

        //settings Permissions
        Permission::create(['name' => 'Settings', 'type' => 'Settings']);

        Permission::create(['name' => 'User Details oervall-view']);
        Permission::create(['name' => 'User Details AddUser']);
        Permission::create(['name' => 'User Details assignRole']);
        Permission::create(['name' => 'User Details actions']);

        Permission::create(['name' => 'AC Department oervall-view']);
        Permission::create(['name' => 'AC Department Add new Department']);


        Permission::create(['name' => 'Activity Log oervall-view']);











        //Club Management Permissions
        Permission::create(['name' => 'Admin', 'type' => 'Admin']);
        Permission::create(['name' => 'Admin Club Management View ClubManagement Tab']);
        //Create Club
        Permission::create(['name' => 'Admin Club Management View Create Club Tab']);
        Permission::create(['name' => 'Admin Club Management Create Club AddNewClub']);
        Permission::create(['name' => 'Admin Club Management Create Club EditClubDetails']);
        Permission::create(['name' => 'Admin Club Management Create Club DeleteClub']);
        //Register Member
        Permission::create(['name' => 'Admin Club Management View Register Member Tab']);
        Permission::create(['name' => 'Admin Club Management Register Member AddNewMember']);
        Permission::create(['name' => 'Admin Club Management Register Member ViewMemberReceiptDetails']);
        //Club Member Fees
        Permission::create(['name' => 'Admin Club Management View Club Member Fees Tab']);
        Permission::create(['name' => 'Admin Club Management Club Member Fees AddReceipts']);
        //Member Fees
        Permission::create(['name' => 'Admin Club Management View Member Fees Tab']);


        Permission::create(['name' => 'Admin Roles and Permission']);
        //roles and permission
        Permission::create(['name' => 'Admin Created Roles view']);

        Permission::create(['name' => 'Admin Created Roles Update']);
        Permission::create(['name' => 'Admin Created Roles Delete']);

        Permission::create(['name' => 'Admin Create Role view']);
        Permission::create(['name' => 'Admin Add Role']);


        $backendSource = 'backend';
        $type = 'Admin';

        // $Admin = Role::create(['name' => 'Admin', 'source' => $backendSource, 'type' => $type]);
        $ClubManagement = Role::create(['name' => 'Club Management', 'source' => $backendSource, 'type' => $type]);
        $Createclub = Role::create(['name' => 'Create Club', 'source' => $backendSource, 'type' => $type]);
        $RegisterMember = Role::create(['name' => 'Register Member', 'source' => $backendSource, 'type' => $type]);
        $Clubmembersfee = Role::create(['name' => 'Club Members Fee', 'source' => $backendSource, 'type' => $type]);
        $Membersfee = Role::create(['name' => 'Members Fee', 'source' => $backendSource, 'type' => $type]);

        $backendSource = 'backend';
        $type = 'Admin';


        $RolesandPermissions = Role::create(['name' => 'Roles and Permissions', 'source' => $backendSource, 'type' => $type]);
        $Createdroles = Role::create(['name' => 'Created Roles', 'source' => $backendSource, 'type' => $type]);
        $Createroles = Role::create(['name' => 'Create Roles', 'source' => $backendSource, 'type' => $type]);





        $backendSource = 'backend';
        $type = 'Settings';
        // $Settings = Role::create(['name' => 'Settings', 'source' => $backendSource, 'type' => $type]);
        $UserDetails = Role::create(['name' => 'UserDetails', 'source' => $backendSource, 'type' => $type]);
        $AcDepartment = Role::create(['name' => 'AcDepartment', 'source' => $backendSource, 'type' => $type]);
        $ActivityLog = Role::create(['name' => 'ActivityLog', 'source' => $backendSource, 'type' => $type]);



        // $settings = [
        // 'User Details oervall-view',
        // 'User Details AddUser',
        //  'User Details assignRole',
        //  'User Details actions',

        // 'AC Department oervall-view',
        // 'AC Department Add new Department',


        //  'Activity Log oervall-view',

        //   ];
        //   $Settings->syncPermissions($settings);

        $userdetail = [
            'User Details oervall-view',
            'User Details AddUser',
            'User Details assignRole',
            'User Details actions',

        ];
        $UserDetails->syncPermissions($userdetail);
        $acdepartment = [


            'AC Department oervall-view',
            'AC Department Add new Department',


        ];
        $AcDepartment->syncPermissions($acdepartment);
        $activitylog = [
            'Activity Log oervall-view',


        ];
        $ActivityLog->syncPermissions($activitylog);



        $rolesandpermissions = [
            'Admin Roles and Permission',

            'Admin Created Roles view',

            'Admin Created Roles Update',
            'Admin Created Roles Delete',

            'Admin Create Role view',
            'Admin Add Role',

        ];
        $RolesandPermissions->syncPermissions($rolesandpermissions);
        $createdroles = [
            'Admin Created Roles view',

            'Admin Created Roles Update',
            'Admin Created Roles Delete',

        ];
        $Createdroles->syncPermissions($createdroles);
        $createroles = [
            'Admin Create Role view',
            'Admin Add Role',

        ];
        $Createroles->syncPermissions($createroles);


        $clubManagement = [
            'Admin Club Management View ClubManagement Tab',
            'Admin Club Management View Create Club Tab',
            'Admin Club Management Create Club AddNewClub',
            'Admin Club Management Create Club EditClubDetails',
            'Admin Club Management Create Club DeleteClub',
            'Admin Club Management View Register Member Tab',
            'Admin Club Management Register Member AddNewMember',
            'Admin Club Management View Club Member Fees Tab',
            'Admin Club Management Club Member Fees AddReceipts',
            'Admin Club Management View Member Fees Tab',
        ];
        $ClubManagement->syncPermissions($clubManagement);


        $createclub = [

            'Admin Club Management View Create Club Tab',
            'Admin Club Management Create Club AddNewClub',
            'Admin Club Management Create Club EditClubDetails',
            'Admin Club Management Create Club DeleteClub',


        ];
        $Createclub->syncPermissions($createclub);



        $registermember = [

            'Admin Club Management View Register Member Tab',
            'Admin Club Management Register Member AddNewMember',
            'Admin Club Management Register Member ViewMemberReceiptDetails'

        ];
        $RegisterMember->syncPermissions($registermember);



        $clubmembersfee = [

            'Admin Club Management View Club Member Fees Tab',
            'Admin Club Management Club Member Fees AddReceipts',

        ];
        $Clubmembersfee->syncPermissions($clubmembersfee);



        $membersfee = [

            'Admin Club Management View Member Fees Tab',
        ];
        $Membersfee->syncPermissions($membersfee);



        $userEmail = env('USER_EMAIL');
        $user = User::where('email', $userEmail)->first();
        $adminpermission = Permission::findByName('Admin'); // Replace 'Admin' with the permission name you want to assign
        $settingpermission = Permission::findByName('Settings');
        if ($user) {
            $user->givePermissionTo($adminpermission);
            $user->givePermissionTo($settingpermission);
            $user->assignRole('Club Management');
            $user->assignRole('Create Club');
            $user->assignRole('Register Member');
            $user->assignRole('Club Members Fee');
            $user->assignRole('Members Fee');
            $user->assignRole('Roles and Permissions');

            // $user->assignRole('Settings');

            $user->assignRole('UserDetails');
            $user->assignRole('AcDepartment');
            $user->assignRole('ActivityLog');
        } else {
            // Handle the case when the user with the specified email is not found
            $this->command->info("User with email $userEmail not found.");
        }
    }
}
