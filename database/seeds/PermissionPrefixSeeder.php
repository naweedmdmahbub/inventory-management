<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionPrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_prefixes = [
            ['name' => 'administrator'],
            ['name' => 'permission'],
            ['name' => 'user'],
            ['name' => 'client'],
            ['name' => 'subcontractor'],
            ['name' => 'supplier'],
            ['name' => 'brand'],
            ['name' => 'category'],
            ['name' => 'unit'],
            
            ['name' => 'project'],
            ['name' => 'structure'],
            ['name' => 'work'],
        ];


        // $permission_prefixes = [

        //     ['name' => 'product'],
        //     ['name' => 'purchase'],


        //     ['name' => 'inventory'],
        //     ['name' => 'settings'],
        //     ['name' => 'export'],

        //     ['name' => 'activity'],
        // ];

        DB::table('permission_prefixes')->insert($permission_prefixes);
    }
}
