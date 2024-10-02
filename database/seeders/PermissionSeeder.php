<?php

namespace Database\Seeders;

use App\Enums\EntitySchema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['title' => 'Super Admin', 'slug' => 'super-admin', 'created_by' => 'system', 'created_at' => Carbon::now()],
            ['title' => 'Admin', 'slug' => 'admin', 'created_by' => 'system', 'created_at' => Carbon::now()],
            ['title' => 'Executive', 'slug' => 'executive', 'created_by' => 'system', 'created_at' => Carbon::now()],
            ['title' => 'Manager', 'slug' => 'manager', 'created_by' => 'system', 'created_at' => Carbon::now()],
            ['title' => 'Staff', 'slug' => 'staff', 'created_by' => 'system', 'created_at' => Carbon::now()],
            ['title' => 'Member', 'slug' => 'member', 'created_by' => 'system', 'created_at' => Carbon::now()],
            ['title' => 'User', 'slug' => 'user', 'created_by' => 'system', 'created_at' => Carbon::now()],
        ]);
    }
}
