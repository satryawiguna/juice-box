<?php

namespace Database\Seeders;

use App\Enums\EntitySchema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('policies')->insert([
            ['title' => 'Admin Group', 'slug' => 'admin-group', 'created_by' => 'system', 'created_at' => Carbon::now()],
            ['title' => 'Human Resource Group', 'slug' => 'human-resource-group', 'created_by' => 'system', 'created_at' => Carbon::now()],
            ['title' => 'Finance Group', 'slug' => 'finance-group', 'created_by' => 'system', 'created_at' => Carbon::now()],
            ['title' => 'Marketing Group', 'slug' => 'marketing-group', 'created_by' => 'system', 'created_at' => Carbon::now()],
            ['title' => 'Member Group', 'slug' => 'member-group', 'created_by' => 'system', 'created_at' => Carbon::now()],
        ]);
    }
}
