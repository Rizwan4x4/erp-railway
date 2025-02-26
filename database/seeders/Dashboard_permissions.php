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

class Dashboard_permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Remove foreign key constraints
        // Remove foreign key constraints
        //  DB::unprepared("EXEC sp_MSforeachtable 'ALTER TABLE ? NOCHECK CONSTRAINT ALL'");

        //  // Truncate the permissions table
        //  DB::table('permissions')->delete();
        //     DB::table('roles')->delete();

        //  // Enable foreign key constraints
        //  DB::unprepared("EXEC sp_MSforeachtable 'ALTER TABLE ? WITH CHECK CHECK CONSTRAINT ALL'");


        DB::table('permissions')->delete();;
        DB::table('roles')->delete();

        Permission::create(['name' => 'Dashboard', 'type' => 'Dashboard']);

        //permissions

        //journal voucher
        Permission::create(['name' => 'Recuriment Dashboard overall-view']);
        Permission::create(['name' => 'Human Resource Dashboard overall-view']);
        Permission::create(['name' => 'Payroll Dashboard overall-view']);
        Permission::create(['name' => 'Accounts Dashboard overall-view']);
        Permission::create(['name' => 'Procurement Dashboard overall-view']);



        // Roles
        $backendSource = 'backend';
        $type = 'Dashboard';
        $Dashboards = Role::create(['name' => 'All Dashboards', 'source' => $backendSource, 'type' => $type]);


        $dashboard = [
            'Recuriment Dashboard overall-view',
            'Human Resource Dashboard overall-view',
            'Payroll Dashboard overall-view',
            'Accounts Dashboard overall-view',
            'Procurement Dashboard overall-view'
        ];



        $Dashboards->syncPermissions($dashboard);


        $userEmail = env('USER_EMAIL');
        $user = User::where('email', $userEmail)->first();
        $dashboardpermission = Permission::findByName('Dashboard');
        if ($user) {
            $user->givePermissionTo($dashboardpermission);
            $user->assignRole('All Dashboards');
        } else {
            // Handle the case when the user with the specified email is not found
            $this->command->info("User with email $userEmail not found.");
        }
    }
}
