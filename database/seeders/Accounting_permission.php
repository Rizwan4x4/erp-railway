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

class Accounting_permission extends Seeder
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
Permission::create(['name' => 'Accounting', 'type' => 'Accounting']);
    
        //permissions
        
        //journal voucher
        Permission::create(['name' => 'Accounting journal_voucher overall-view']);
        Permission::create(['name' => 'Accounting journal_voucher filter']);
        Permission::create(['name' => 'Accounting journal_voucher edit-jv']);
        Permission::create(['name' => 'Accounting journal_voucher create-jv']);

        //Receipt Voucher
        Permission::create(['name' => 'Accounting Receipt-voucher overall-view']);
        Permission::create(['name' => 'Accounting Receipt-voucher filter']);
        Permission::create(['name' => 'Accounting Receipt-voucher create-rv']);
        Permission::create(['name' => 'Accounting Receipt-voucher pdc']);

        //Payment Voucher
        Permission::create(['name' => 'Accounting Payment-voucher overall-view']);
        Permission::create(['name' => 'Accounting Payment-voucher filter']);
        Permission::create(['name' => 'Accounting Payment-voucher create-pv']); 
        Permission::create(['name' => 'Accounting Payment-voucher pdc']); 
        Permission::create(['name' => 'Accounting Payment-voucher actions']); 
        //Debit Notes
        Permission::create(['name' => 'Accounting debit-notes overall-view']);
        Permission::create(['name' => 'Accounting debit-notes filter']);
        Permission::create(['name' => 'Accounting debit-notes create-dn']);

        //Petty Cash Access
        Permission::create(['name' => 'Accounting pettycash_access overall-view']);
        Permission::create(['name' => 'Accounting pettycash_access filter']);
        Permission::create(['name' => 'Accounting pettycash_access edit-pettyaccess']);
        Permission::create(['name' => 'Accounting pettycash_access create-pettyaccess']);
        Permission::create(['name' => 'Accounting pettycash_access actions']);



        //Petty Cash
        Permission::create(['name' => 'Accounting petty-cash overall-view']);
        Permission::create(['name' => 'Accounting petty-cash filter']);
        Permission::create(['name' => 'Accounting petty-cash edit-pettycash']);
        Permission::create(['name' => 'Accounting petty-cash create-pettycash']);

          //configuraton
        //   Permission::create(['name' => 'Accounting Configuration procurement-configuration']);
        Permission::create(['name' => 'Accounts Configurations', 'type' => 'Accounts Configurations']);


        Permission::create(['name' => 'Accounts Configurations bank-detail']);
        Permission::create(['name' => 'Accounts Configurations  create-bank']);
        Permission::create(['name' => 'Accounts Configurations  bank-details actions']);



        Permission::create(['name' => 'Accounts Configurations COA']);
        Permission::create(['name' => 'Accounts Configurations  create-COA']);


        Permission::create(['name' => 'Accounts Configurations payment terms']);
        Permission::create(['name' => 'Accounts Configurations  create-payment-terms']);

        Permission::create(['name' => 'Accounts Configurations  taxes']);
        Permission::create(['name' => 'Accounts Configurations  create-tax']);

        Permission::create(['name' => 'Accounts Configurations Accounts heads']);
        Permission::create(['name' => 'Accounts Configurations Accounts-heads create-journal-heads']);

        Permission::create(['name' => 'Accounts Configurations  session']);
        Permission::create(['name' => 'Accounts Configurations  session create new']);
        Permission::create(['name' => 'Accounts Configurations  session delete']);
        Permission::create(['name' => 'Accounts Configurations  session close/open']);

        Permission::create(['name' => 'Accounts Configurations  session transfer receipt data']);


        Permission::create(['name' => 'Accounts Configurations  general']);
        Permission::create(['name' => 'Accounts Configurations  general Accounts Configuration']);
        Permission::create(['name' => 'Accounts Configurations  general Child Companies']);
        Permission::create(['name' => 'Accounts Configurations  general Departments']);
        Permission::create(['name' => 'Accounts Configurations  general Units']);
        Permission::create(['name' => 'Accounts Configurations  general Purchase Orders']);
        Permission::create(['name' => 'Accounts Configurations  general Link COA & Department']);


        Permission::create(['name' => 'Accounts Configurations  department access']);
        Permission::create(['name' => 'Accounts Configurations  allow-department-access']);




        // Roles 
           $backendSource = 'backend';
           $type = 'Accounting';
        $journalVoucher = Role::create(['name' => 'Journal Voucher', 'source' => $backendSource,'type' => $type]);
        $receiptVoucher = Role::create(['name' => 'Receipt Voucher', 'source' => $backendSource,'type' => $type]);
        $paymentVoucher = Role::create(['name' => 'Payment Voucher', 'source' => $backendSource,'type' => $type]);
        $debitNotes = Role::create(['name' => 'Debit Notes', 'source' => $backendSource,'type' => $type]);
        $pettyCashAccess = Role::create(['name' => 'Petty Cash Access', 'source' => $backendSource,'type' => $type]);
        $pettyCash = Role::create(['name' => 'Petty Cash', 'source' => $backendSource,'type' => $type]);
        // $procurementConfiguration = Role::create(['name' => 'ProcurementConfiguration', 'source' => $backendSource,'type' => $type]);
        $type = 'Accounts Configurations';
        $Bankdetails = Role::create(['name' => 'Bank Detail', 'source' => $backendSource,'type' => $type]);
        $COA = Role::create(['name' => 'COA', 'source' => $backendSource,'type' => $type]);
        $Paymentterms = Role::create(['name' => 'Payment terms', 'source' => $backendSource,'type' => $type]);
        $Taxes = Role::create(['name' => 'Taxes', 'source' => $backendSource,'type' => $type]);
        $Accheads = Role::create(['name' => 'Accounts Heads', 'source' => $backendSource,'type' => $type]);
        $Sessions = Role::create(['name' => 'Sessions', 'source' => $backendSource,'type' => $type]);

        $Gererals = Role::create(['name' => 'Generals', 'source' => $backendSource,'type' => $type]);
        $Departmentaccess = Role::create(['name' => 'Department Access', 'source' => $backendSource,'type' => $type]);



        $journalVoucherPermissions=[
            'Accounting journal_voucher overall-view',
            'Accounting journal_voucher filter',
            'Accounting journal_voucher edit-jv',
            'Accounting journal_voucher create-jv'
        ];
        $receiptVoucherPermissions=[
            'Accounting Receipt-voucher overall-view',
            'Accounting Receipt-voucher filter',
            'Accounting Receipt-voucher create-rv',
            'Accounting Receipt-voucher pdc'
        ];
        $paymentVoucherPermissions=[
            'Accounting Payment-voucher overall-view',
            'Accounting Payment-voucher filter',
            'Accounting Payment-voucher create-pv',
            'Accounting Payment-voucher pdc',
            'Accounting Payment-voucher actions'
        ];
        $debitNotesPermissions=[
            'Accounting debit-notes overall-view',
            'Accounting debit-notes filter',
            'Accounting debit-notes create-dn'
        ];
        $pettyCashAccessPermissions=[
            'Accounting pettycash_access overall-view',
            'Accounting pettycash_access filter',
            'Accounting pettycash_access edit-pettyaccess',
            'Accounting pettycash_access create-pettyaccess',
        ];
        $pettyCashPermissions=[
            'Accounting petty-cash overall-view',
            'Accounting petty-cash filter',
            'Accounting petty-cash edit-pettycash',
            'Accounting petty-cash create-pettycash',
            'Accounting pettycash_access actions'
        ];
        // $procurementConfigurationPermissions=[
        //     'Accounting Configuration procurement-configuration'
        // ];
        $bankdetails=[
         'Accounts Configurations bank-detail',
        'Accounts Configurations  create-bank',
           'Accounts Configurations  bank-details actions',
    ];

    $coa=[
      'Accounts Configurations COA',
    'Accounts Configurations  create-COA',
   ];
   $paymentterms=[
'Accounts Configurations payment terms',
    'Accounts Configurations  create-payment-terms',
 ];
 $taxes=[
  'Accounts Configurations  taxes',
  'Accounts Configurations  create-tax',
     ];
     $accheads=[
 'Accounts Configurations Accounts heads',
      'Accounts Configurations Accounts-heads create-journal-heads',
           ];
           $sessions=[
          'Accounts Configurations  session',
         'Accounts Configurations  session create new',
      'Accounts Configurations  session transfer receipt data',
      'Accounts Configurations  session close/open',
      'Accounts Configurations  session delete',
                      ];

                      $gererals=[
                        'Accounts Configurations  general',
                        'Accounts Configurations  general Accounts Configuration',
                      'Accounts Configurations  general Child Companies',
                       'Accounts Configurations  general Departments',
                        'Accounts Configurations  general Units',
                     'Accounts Configurations  general Purchase Orders',
                     'Accounts Configurations  general Link COA & Department',
                                    ];

                                    $departmentaccess=[
                                   'Accounts Configurations  department access',
                                     'Accounts Configurations  allow-department-access',
                                     ];
$journalVoucher->syncPermissions($journalVoucherPermissions);
$receiptVoucher->syncPermissions($receiptVoucherPermissions);
$paymentVoucher->syncPermissions($paymentVoucherPermissions);
$debitNotes->syncPermissions($debitNotesPermissions);
$pettyCashAccess->syncPermissions($pettyCashAccessPermissions);
$pettyCash->syncPermissions($pettyCashPermissions);
// $procurementConfiguration->syncPermissions($procurementConfigurationPermissions);
$Bankdetails->syncPermissions($bankdetails);
$COA->syncPermissions($coa);
$Paymentterms->syncPermissions($paymentterms);

$Taxes->syncPermissions($taxes);
$Accheads->syncPermissions($accheads);
$Sessions->syncPermissions($sessions);
$Gererals->syncPermissions($gererals);
$Departmentaccess->syncPermissions($departmentaccess);

$userEmail = env('USER_EMAIL');
$user = User::where('email', $userEmail)->first();
$accountingpermission = Permission::findByName('Accounting');
$accountingConfigurationpermission = Permission::findByName('Accounts Configurations');

if ($user) {
    $user->givePermissionTo($accountingpermission);

    $user->assignRole('Journal Voucher');
    $user->assignRole('Receipt Voucher');
    $user->assignRole('Payment Voucher');
    $user->assignRole('Debit Notes');
    $user->assignRole('Petty Cash Access');
    $user->assignRole('Petty Cash');

    $user->givePermissionTo($accountingConfigurationpermission);

    $user->assignRole('Bank Detail');
    $user->assignRole('COA');
    $user->assignRole('Payment terms');
    $user->assignRole('Taxes');
    $user->assignRole('Accounts Heads');
    $user->assignRole('Sessions');
    $user->assignRole('Generals');
    $user->assignRole('Department Access');


} else {
    // Handle the case when the user with the specified email is not found
    $this->command->info("User with email $userEmail not found.");
}

    }
}
