<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(procurement_purchase::class);

        $this->call(Dashboard_permissions::class);
        $this->call(hrms_permission_seeder::class);
        $this->call(HRMS_SalalryPermissionSeeder::class);


        $this->call(HRMS_fuelPermissionSeeder::class);
 
        $this->call(Inventory_permission::class);
        $this->call(Accounting_permission::class);
        $this->call(Unitsdata_permission::class);


        $this->call(PermissionSeeder::class);
        $this->call(procurement_purchase::class);
    

      
        
      
     
    
      

        
        // \App\Models\User::factory(10)->create();
//        $this->call(HRMS_SalalryPermissionSeeder::class);
        $this->call(procurement_purchase::class);
//        $this->call(hrms_permission_seeder::class);
    }
}
