<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Creates the first super-admin account for this deployment from .env
     * (ADMIN_NAME / ADMIN_EMAIL / ADMIN_PASSWORD) — per-client values, not
     * hardcoded, so this same seeder works for every client. Additional
     * staff accounts (e.g. electricians) are added afterward through the
     * Users page in the UI, not seeded.
     */
    public function run(): void
    {
        $name = env('ADMIN_NAME');
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$name || !$email || !$password) {
            $this->command?->warn('Skipped UserSeeder — set ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD in .env first.');

            return;
        }

        if (strlen($password) < 12) {
            throw new \RuntimeException('ADMIN_PASSWORD must be at least 12 characters — set a strong password in .env before seeding.');
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        $user->syncRoles(['super-admin']);
    }
}
