<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the system roles
        $userRole = Role::create(['name' => 'user']);
        $vendorRole = Role::create(['name' => 'vendor']);
        $adminRole = Role::create(['name' => 'admin']);

        // 2. Seed Default Smart Tourism / Shop Business Tags
        $defaultTags = ['museum', 'historical', 'cultural', 'food and beverage', 'nature', 'accommodation'];
        foreach ($defaultTags as $tagName) {
            Tag::create(['name' => $tagName]);
        }

        // 3. Seed 10 random customer users and attach the 'user' role
        User::factory(10)->create()->each(function ($user) {
            $user->roles()->attach(1); 
        });

        // 4. Create dedicated Admin account for testing
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $admin->roles()->attach([$userRole->id, $adminRole->id]);

        // 5. Create dedicated Vendor account for testing
        $vendor = User::factory()->create([
            'email' => 'vendor@test.com',
            'password' => bcrypt('password'),
        ]);
        $vendor->roles()->attach([$userRole->id, $vendorRole->id]);

        // Create approved VendorApplication record so they can be unbanned cleanly
        $vendor->vendorApplication()->create([
            'shop_name' => 'Seeded Vendor Shop',
            'physical_address' => 'Seeded Address',
            'business_license_number' => 'SEEDED-123',
            'status' => 'approved'
        ]);
    }
}