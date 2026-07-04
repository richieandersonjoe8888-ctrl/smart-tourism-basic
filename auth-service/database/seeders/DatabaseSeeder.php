namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the system roles
        $userRole = Role::create(['name' => 'user']);
        $vendorRole = Role::create(['name' => 'vendor']);
        $adminRole = Role::create(['name' => 'admin']);

        // 2. Seed 10 random customer users and attach the 'user' role
        User::factory(10)->create()->each(function ($user) {
            $user->roles()->attach(1); // Attach 'user' role
        });

        // 3. Create a dedicated Admin account for testing
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        $admin->roles()->attach([$userRole->id, $adminRole->id]); // Admin is both a user and an admin

        // 4. Create a dedicated Vendor account for testing
        $vendor = User::factory()->create([
            'email' => 'vendor@test.com',
            'password' => bcrypt('password'),
        ]);
        $vendor->roles()->attach([$userRole->id, $vendorRole->id]); // Vendor is both a user and a vendor
    }
}