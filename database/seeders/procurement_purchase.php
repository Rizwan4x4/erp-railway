<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\DB;


class procurement_purchase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission::query()->delete();

        // Role::query()->delete();
        //PROCUREMENT

        // DB::table('permissions')->delete();;
        // DB::table('roles')->delete();

        Permission::create(['name' => 'Purchase', 'type' => 'Purchase']);
//        Demand Requisition
        $procurementPermissions = [
                'Demand Requisition view',
            'Demand Requisition Create',
            'Demand Requisition Service View',
            'Demand Requisition Service Change Statuses',
            'Demand Requisition Inventory View',
            'Demand Requisition Inventory Change Statuses',
            'Demand Requisition Assets View',
            'Demand Requisition Asset Change Statuses'
        ];

        // Loop through permissions and create them
        foreach ($procurementPermissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }
        $type = 'Purchase';
        // Create role
        $demand_req = Role::create(['name' => 'Demand Requisition',  'source' => 'backend', 'type' => $type]);

        // Retrieve the created permissions
        $permissions = Permission::whereIn('name', $procurementPermissions)->get();


        // Assign the permissions to the role
        $demand_req->syncPermissions($permissions);




// Purchase Requisition
        $permissions = [
                'Purchase Requisition view',
            'Purchase Requisition Merge',
            'Purchase Requisition View Goods',
            'Purchase Requisition Goods Edit',
            'Purchase Requisition Goods Quotation',
//            'Purchase Requisition Change Goods Statuses',
            'Purchase Requisition View Assets',
            'Purchase Requisition Assets Item Detail',
            'Purchase Requisition Assets Item Quotation',
            'Purchase Requisition View Services',
            'Purchase Requisition View Services Item Quotation',
            'Purchase Requisition Change Services Statuses'
        ];
        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        $purchaseReqRole = Role::create(['name' => 'Purchase Requisition',  'source' => 'backend', 'type' => $type]);
        $createdPermissions = Permission::whereIn('name', $permissions)->get();
        $purchaseReqRole->syncPermissions($createdPermissions);




//Purchase Orders
        $purchaseOrdersPermissions = [
                'Purchase Orders View',
            'Purchase Orders Create',
        
            'Purchase Orders Item View',
            'Purchase Orders Actions',
        ];

        foreach ($purchaseOrdersPermissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }
        $purchaseOrdersRole = Role::create(['name' => 'Purchase Orders',  'source' => 'backend', 'type' => $type]);
        $createdPurchaseOrdersPermissions = Permission::whereIn('name', $purchaseOrdersPermissions)->get();
        $purchaseOrdersRole->syncPermissions($createdPurchaseOrdersPermissions);



////        Services Invoice
        $servicesInvoicePermissions = [
                'Services Invoice View',
            'Services Invoice Create',
           
            'Services Invoice Statuses',
            'Services Invoice Edit',
            'Services Invoice Print'
        ];

// Create the permissions for Services Invoice
        foreach ($servicesInvoicePermissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

// Create the "Services Invoice" role
        $servicesInvoiceRole = Role::create(['name' => 'Services Invoice', 'source' => 'backend', 'type' => $type]);

// Get the permission models for the created permissions
        $createdServicesInvoicePermissions = Permission::whereIn('name', $servicesInvoicePermissions)->get();

// Assign permissions to the "Services Invoice" role
        $servicesInvoiceRole->syncPermissions($createdServicesInvoicePermissions);





// Create permissions for GRN Detail
        $grnDetailPermissions = [
                'GRN View',
            'GRN Detail Create',
            
            'GRN Actions',
            'GRN Detail Invoice Print',
            'GRN Detail Status',
            'GRN Detail Accounts Invoice(status)'
        ];

// Create the permissions for GRN Detail
        foreach ($grnDetailPermissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

// Create the "GRN Detail" role
        $grnDetailRole = Role::create(['name' => 'GRN Detail', 'source' => 'backend', 'type' => $type]);

// Get the permission models for the created permissions
        $createdGRNDetailPermissions = Permission::whereIn('name', $grnDetailPermissions)->get();

// Assign permissions to the "GRN Detail" role
        $grnDetailRole->syncPermissions($createdGRNDetailPermissions);





//        Purchase Returns
        $purchaseReturnsPermissions = [
            'Purchase Returns Create',
            'Purchase Returns View',
           'Purchase Returns Item View',
//            'Purchase Returns Edit',
            'Purchase Returns Print'
        ];

        foreach ($purchaseReturnsPermissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        $purchaseReturnsRole = Role::create(['name' => 'Purchase Returns', 'source' => 'backend', 'type' => $type]);
        $createdPurchaseReturnsPermissions = Permission::whereIn('name', $purchaseReturnsPermissions)->get();
        $purchaseReturnsRole->syncPermissions($createdPurchaseReturnsPermissions);

        $backendSource = 'backend';
     $type='Procurement Configurations';

     Permission::create(['name' => 'Procurement Configurations', 'type' => 'Procurement Configurations']);

       
        Permission::create(['name' => 'Accounting procurement-configuration Delivery' ]);
        Permission::create(['name' => 'Accounting procurement-configuration create-Delivery' ]);

        Permission::create(['name' => 'Accounting procurement-configuration general']);
        Permission::create(['name' => 'Accounting  general Accounts-configuration']);
        Permission::create(['name' => 'Accounting  general child-comapnies']);
        Permission::create(['name' => 'Accounting  general department']);
        Permission::create(['name' => 'Accounting  general units']);
        Permission::create(['name' => 'Accounting  general purchase-order']);
        Permission::create(['name' => 'Accounting  general link COA and department']);


        Permission::create(['name' => 'Accounting procurement-configuration vendors' ]);
        Permission::create(['name' => 'Accounting procurement-configuration create-vendors' ]);
        Permission::create(['name' => 'Accounting procurement-configuration actions']);




        $delivery = Role::create(['name' => 'Delivery', 'source' => $backendSource,'type' => $type]);
        $Devilery=[
                'Accounting procurement-configuration Delivery' ,
                    'Accounting procurement-configuration create-Delivery',
            ];
            $delivery->syncPermissions($Devilery);

            $general = Role::create(['name' => 'General', 'source' => $backendSource,'type' => $type]);
            $General=[
              
                 
         
                    'Accounting procurement-configuration general',
                    'Accounting  general Accounts-configuration',
                   'Accounting  general child-comapnies',
                     'Accounting  general department',
                     'Accounting  general units',
                    'Accounting  general purchase-order',
                     'Accounting  general link COA and department',
                    
                ];
                
                $general->syncPermissions($General);

                $vendors = Role::create(['name' => 'Vendors', 'source' => $backendSource,'type' => $type]);
                $Vendors=[
                  
                     
             
                        'Accounting procurement-configuration vendors' ,
         'Accounting procurement-configuration create-vendors' ,
     'Accounting procurement-configuration actions',
                        
                    ];
                    
                    $vendors->syncPermissions($Vendors);







        
$userEmail = env('USER_EMAIL');
$user = User::where('email', $userEmail)->first();
$Purchasepermission = Permission::findByName('Purchase');
$ProcurementConfigurationspermission = Permission::findByName('Procurement Configurations');

if ($user) {
    $user->givePermissionTo($Purchasepermission);
    $user->givePermissionTo($ProcurementConfigurationspermission);


//     $rolesToAssign = ['Demand Requisition', 'Purchase Requisition', 'Purchase Orders', 'Services Invoice', 'GRN Detail', 'Purchase Returns'];
//     $roleModels = Role::whereIn('name', $rolesToAssign)->get();
//     $user->syncRoles($roleModels);
$user->assignRole('Demand Requisition');
$user->assignRole('Purchase Requisition');
$user->assignRole('Purchase Orders');
$user->assignRole('Services Invoice');
$user->assignRole('GRN Detail');
$user->assignRole('Purchase Returns');






    $user->assignRole('Vendors');
    $user->assignRole('General');
    $user->assignRole('Delivery');



  
} else {
    // Handle the case when the user with the specified email is not found
    $this->command->info("User with email $userEmail not found.");
}
     
    }
}
