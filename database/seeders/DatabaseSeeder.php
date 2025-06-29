<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin accounts that will always be available
        $this->createDefaultAdminAccounts();

        // Call other seeders
        $this->call([
            CourseBuilderSeeder::class,
        ]);
    }

    /**
     * Create default admin accounts for fresh installations
     */
    private function createDefaultAdminAccounts(): void
    {
        // Primary admin account
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'username' => 'testadmin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Secondary admin account
        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'username' => 'admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create a default student account for testing
        User::firstOrCreate(
            ['email' => 'student@test.com'],
            [
                'username' => 'student',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Create a default teacher account for testing
        User::firstOrCreate(
            ['email' => 'teacher@test.com'],
            [
                'username' => 'teacher',
                'password' => bcrypt('password'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Default user accounts created successfully!');
        $this->command->info('📧 Admin: test@example.com / password');
        $this->command->info('📧 Admin: admin@test.com / password');
        $this->command->info('📧 Student: student@test.com / password');
        $this->command->info('📧 Teacher: teacher@test.com / password');
    }
}
