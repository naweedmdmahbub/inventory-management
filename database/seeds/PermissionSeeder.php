<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'view menu element ui', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu permission', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu components', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu charts', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu nested routes', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu table', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu administrator', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu theme', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu clipboard', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu excel', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu zip', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu pdf', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'view menu i18n', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'manage article', 'guard_name' => 'api', 'permission_prefix_id' => '1'],
            ['name' =>  'manage permission', 'guard_name' => 'api', 'permission_prefix_id' => '2'],
            //users permission
            ['name' =>  'manage user', 'guard_name' => 'api', 'permission_prefix_id' => '3'],
            ['name' =>  'view user list', 'guard_name' => 'api', 'permission_prefix_id' => '3'],
            ['name' =>  'add user', 'guard_name' => 'api', 'permission_prefix_id' => '3'],
            ['name' =>  'update user', 'guard_name' => 'api', 'permission_prefix_id' => '3'],
            ['name' =>  'view user', 'guard_name' => 'api', 'permission_prefix_id' => '3'],
            // clients permissions
            ['name' =>  'manage client', 'guard_name' => 'api', 'permission_prefix_id' => '4'],
            ['name' =>  'view client list', 'guard_name' => 'api', 'permission_prefix_id' => '4'],
            ['name' =>  'add client', 'guard_name' => 'api', 'permission_prefix_id' => '4'],
            ['name' =>  'update client', 'guard_name' => 'api', 'permission_prefix_id' => '4'],
            ['name' =>  'view client', 'guard_name' => 'api', 'permission_prefix_id' => '4'],
            // subcontractors permissions
            ['name' =>  'manage subcontractor', 'guard_name' => 'api', 'permission_prefix_id' => '5'],
            ['name' =>  'view subcontractor list', 'guard_name' => 'api', 'permission_prefix_id' => '5'],
            ['name' =>  'add subcontractor', 'guard_name' => 'api', 'permission_prefix_id' => '5'],
            ['name' =>  'update subcontractor', 'guard_name' => 'api', 'permission_prefix_id' => '5'],
            ['name' =>  'view subcontractor', 'guard_name' => 'api', 'permission_prefix_id' => '5'],
            // suppliers permissions
            ['name' =>  'manage supplier', 'guard_name' => 'api', 'permission_prefix_id' => '6'],
            ['name' =>  'view supplier list', 'guard_name' => 'api', 'permission_prefix_id' => '6'],
            ['name' =>  'add supplier', 'guard_name' => 'api', 'permission_prefix_id' => '6'],
            ['name' =>  'update supplier', 'guard_name' => 'api', 'permission_prefix_id' => '6'],
            ['name' =>  'view supplier', 'guard_name' => 'api', 'permission_prefix_id' => '6'],


            // brands permissions
            ['name' =>  'manage brand', 'guard_name' => 'api', 'permission_prefix_id' => '7'],
            ['name' =>  'view brand list', 'guard_name' => 'api', 'permission_prefix_id' => '7'],
            ['name' =>  'add brand', 'guard_name' => 'api', 'permission_prefix_id' => '7'],
            ['name' =>  'update brand', 'guard_name' => 'api', 'permission_prefix_id' => '7'],
            ['name' =>  'view brand', 'guard_name' => 'api', 'permission_prefix_id' => '7'],
            //categories permission
            ['name' =>  'manage category', 'guard_name' => 'api', 'permission_prefix_id' => '8'],
            ['name' =>  'view category list', 'guard_name' => 'api', 'permission_prefix_id' => '8'],
            ['name' =>  'add category', 'guard_name' => 'api', 'permission_prefix_id' => '8'],
            ['name' =>  'update category', 'guard_name' => 'api', 'permission_prefix_id' => '8'],
            ['name' =>  'view category', 'guard_name' => 'api', 'permission_prefix_id' => '8'],
            // units permissions
            ['name' =>  'manage unit', 'guard_name' => 'api', 'permission_prefix_id' => '9'],
            ['name' =>  'view unit list', 'guard_name' => 'api', 'permission_prefix_id' => '9'],
            ['name' =>  'add unit', 'guard_name' => 'api', 'permission_prefix_id' => '9'],
            ['name' =>  'update unit', 'guard_name' => 'api', 'permission_prefix_id' => '9'],
            ['name' =>  'view unit', 'guard_name' => 'api', 'permission_prefix_id' => '9'],

            // // products permissions
            // ['name' =>  'manage product', 'guard_name' => 'api', 'permission_prefix_id' => '10'],
            // ['name' =>  'view product list', 'guard_name' => 'api', 'permission_prefix_id' => '10'],
            // ['name' =>  'add product', 'guard_name' => 'api', 'permission_prefix_id' => '10'],
            // ['name' =>  'update product', 'guard_name' => 'api', 'permission_prefix_id' => '10'],
            // ['name' =>  'view product', 'guard_name' => 'api', 'permission_prefix_id' => '10'],
            // // purchases permissions
            // ['name' =>  'manage purchase', 'guard_name' => 'api', 'permission_prefix_id' => '11'],
            // ['name' =>  'view purchase list', 'guard_name' => 'api', 'permission_prefix_id' => '11'],
            // ['name' =>  'add purchase', 'guard_name' => 'api', 'permission_prefix_id' => '11'],
            // ['name' =>  'update purchase', 'guard_name' => 'api', 'permission_prefix_id' => '11'],
            // ['name' =>  'view purchase', 'guard_name' => 'api', 'permission_prefix_id' => '11'],
            // // projects permissions
            // ['name' =>  'manage project', 'guard_name' => 'api', 'permission_prefix_id' => '12'],
            // ['name' =>  'view project list', 'guard_name' => 'api', 'permission_prefix_id' => '12'],
            // ['name' =>  'add project', 'guard_name' => 'api', 'permission_prefix_id' => '12'],
            // ['name' =>  'update project', 'guard_name' => 'api', 'permission_prefix_id' => '12'],
            // ['name' =>  'view project', 'guard_name' => 'api', 'permission_prefix_id' => '12'],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
