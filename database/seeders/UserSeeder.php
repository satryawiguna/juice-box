<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Policy;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'admin',
            'email' => 'admin@juicebox.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_by' => 'system'
        ]);

        $profile = Profile::create([
            'profileable_id' => $user->id,
            'profileable_type' => get_class($user),
            'first_name' => 'Satrya',
            'last_name' => 'Wiguna',
            'mobile_phone' => '+62 8113808231',
            'created_by' => 'system'
        ]);
        $user->profile()->save($profile);

        $permissions = Permission::whereIn('slug', ['super-admin', 'user'])
            ->get();
        $user->permissions()->attach($permissions);

        $policy = Policy::where('slug', 'admin-group')->first();
        $user->policies()->attach($policy);
    }
}
