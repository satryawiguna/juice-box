<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\EntitySchema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Model::unguard();

        ini_set('memory_limit', '512M');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('profiles')->truncate();
        DB::table('users')->truncate();
        DB::table('policies')->truncate();
        DB::table('permissions')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call(PermissionSeeder::class);
        $this->call(PolicySeeder::class);
        $this->call(UserSeeder::class);
    }
}
