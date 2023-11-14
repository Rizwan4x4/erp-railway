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

class Inventory_permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //  DB::table('permissions')->delete();;
        // DB::table('roles')->delete();
      
        Permission::create(['name' => 'Inventory'  ,'type' => 'Inventory']);
        // Stock Detail
        Permission::create(['name' => 'Inventory StockDetail overall-view']);
        Permission::create(['name' => 'Inventory StockDetail stock-adjustment']);

        // Grn Order
        Permission::create(['name' => 'Inventory Grn overall-view']);
        Permission::create(['name' => 'Inventory Grn filter']);
        Permission::create(['name' => 'Inventory Grn delete']);
        Permission::create(['name' => 'Inventory Grn status']);
        Permission::create(['name' => 'Inventory Grn create-grn']);

        // Purchase Invoice
        Permission::create(['name' => 'Inventory purchase-invoice overall-view']);
        Permission::create(['name' => 'Inventory purchase-invoice filter']);
        Permission::create(['name' => 'Inventory purchase-invoice delete']);
        Permission::create(['name' => 'Inventory purchase-invoice create-invoice']);

        // Inventory Reports
        Permission::create(['name' => 'Inventory Account-Reports overall']);
        Permission::create(['name' => 'Inventory Account-Reports accounting']);
        Permission::create(['name' => 'Inventory Account-Reports sales']);
        Permission::create(['name' => 'Inventory Account-Reports purchase']);
        Permission::create(['name' => 'Inventory Account-Reports inventory']);
        Permission::create(['name' => 'Inventory Account-Reports inventory-statements']);

        // Issuance 
        Permission::create(['name' => 'Inventory Issuance overall-view']);
        Permission::create(['name' => 'Inventory Issuance create-issuance']);
        Permission::create(['name' => 'Inventory Issuance create-issuance-site']);
        Permission::create(['name' => 'Inventory Issuance view-issuance']);
        Permission::create(['name' => 'Inventory Issuance print-issuance']);



        // Issuance Return 
        Permission::create(['name' => 'Inventory Issuance-return overall-view']);
        Permission::create(['name' => 'Inventory Issuance-return create-issuance-return']);
        Permission::create(['name' => 'Inventory Issuance-return view-issuance-return']);
        Permission::create(['name' => 'Inventory Issuance-return print-issuance-return']);




      // Depreciation 
      Permission::create(['name' => 'Inventory Depreciation Assets-Depreciation']);




      Permission::create(['name' => 'Inventory Depreciation Assets-Book']);

      Permission::create(['name' => 'Inventory Depreciation Assets-Retirement']);
      Permission::create(['name' => 'Inventory Depreciation create-Retirement']);


      // Product Categories 
      Permission::create(['name' => 'Inventory Product-Categories readyOnly']);
      Permission::create(['name' => 'Inventory Product-Categories create-category']);


      // Assets 
      Permission::create(['name' => 'Inventory Assets readyOnly']);
      Permission::create(['name' => 'Inventory Assets view-asset']);

      Permission::create(['name' => 'Inventory Assets actions']);

        // Product 
        Permission::create(['name' => 'Inventory Products readOnly']);
        Permission::create(['name' => 'Inventory Products create-product']);
        Permission::create(['name' => 'Inventory Products edit-product']);
        Permission::create(['name' => 'Inventory Products inventory-link']);
        Permission::create(['name' => 'Inventory Products asset-link']);

        $backendSource = 'backend';
        $type = 'Inventory';
        $stockDetail = Role::create(['name' => 'Stock Detail', 'source' => $backendSource,'type' => $type]);
        $accountReports = Role::create(['name' => 'Accounts Reports', 'source' => $backendSource,'type' => $type]);
        $grnorder = Role::create(['name' => 'Grn Order', 'source' => $backendSource,'type' => $type]);
        $issuance = Role::create(['name' => 'Issuance', 'source' => $backendSource,'type' => $type]);
        $Depreciation = Role::create(['name' => 'Depreciation', 'source' => $backendSource,'type' => $type]);
        $issuanceReturn = Role::create(['name' => 'Issuance Return', 'source' => $backendSource,'type' => $type]);
        $product = Role::create(['name' => 'Products', 'source' => $backendSource,'type' => $type]);
        $productCategory = Role::create(['name' => 'Product Category', 'source' => $backendSource,'type' => $type]);
        $asssts = Role::create(['name' => 'Assets Details', 'source' => $backendSource,'type' => $type]);

        $stockDetailPermissions=[
            'Inventory StockDetail overall-view',
            'Inventory StockDetail stock-adjustment'
        ];
        $accountReportsPermissions=[
            'Inventory Account-Reports overall',
            'Inventory Account-Reports accounting',
            'Inventory Account-Reports sales',
            'Inventory Account-Reports purchase',
            'Inventory Account-Reports inventory',
            'Inventory Account-Reports inventory-statements'
        ];
        $depreciationPermissions=[
            'Inventory Depreciation Assets-Depreciation',
            'Inventory Depreciation Assets-Book',
            'Inventory Depreciation Assets-Retirement'
        ];
        $issuancePermissions=[
            'Inventory Issuance overall-view',
            'Inventory Issuance create-issuance',
            'Inventory Issuance create-issuance-site',
            'Inventory Issuance print-issuance',
            'Inventory Issuance view-issuance',
        ];
        $issuancereturnPermissions=[
            'Inventory Issuance-return overall-view',
            'Inventory Issuance-return create-issuance-return',
            'Inventory Issuance-return view-issuance-return',
            'Inventory Issuance-return print-issuance-return'
        ];
        $categoryPermissions=[
            'Inventory Product-Categories readyOnly',
            'Inventory Product-Categories create-category',
        ];
        $assetsPermissions=[
            'Inventory Assets readyOnly',
            'Inventory Assets actions',
            'Inventory Assets view-asset'
        ];
        $grnOrderPermissions=[
            'Inventory Grn overall-view',
            'Inventory Grn filter',
            'Inventory Grn delete',
            'Inventory Grn create-grn',
            'Inventory Grn status'
        ];
        $productPermissions=[
            'Inventory Products readOnly',
            'Inventory Products create-product',
            'Inventory Products edit-product',
            'Inventory Products inventory-link',
            'Inventory Products asset-link'
        ];

$stockDetail->syncPermissions($stockDetailPermissions);
$accountReports->syncPermissions($accountReportsPermissions);
$grnorder->syncPermissions($grnOrderPermissions);
$issuance->syncPermissions($issuancePermissions);
$Depreciation->syncPermissions($depreciationPermissions);
$issuanceReturn->syncPermissions($issuancereturnPermissions);
$product->syncPermissions($productPermissions);
$productCategory->syncPermissions($categoryPermissions);
$asssts->syncPermissions($assetsPermissions);


$userEmail = env('USER_EMAIL');
$user = User::where('email', $userEmail)->first();
$Inventorypermission = Permission::findByName('Inventory');
if ($user) {
    $user->givePermissionTo($Inventorypermission);
    $user->assignRole('Stock Detail');
    $user->assignRole('Accounts Reports');
    $user->assignRole('Grn Order');
    $user->assignRole('Issuance');
    $user->assignRole('Depreciation');
    $user->assignRole('Issuance Return');
    $user->assignRole('Products');
    $user->assignRole('Product Category');
    $user->assignRole('Assets Details');

  
} else {
    // Handle the case when the user with the specified email is not found
    $this->command->info("User with email $userEmail not found.");
}



    }
}
