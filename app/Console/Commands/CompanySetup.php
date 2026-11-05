<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CompanySetup extends Command
{
    /**
     * php artisan company:setup
     *
     * One-step onboarding for a new client deployment of this codebase.
     * Run this after creating the client's database and filling in their
     * .env (see .env.example) — it migrates, then seeds roles/permissions,
     * the first super-admin account, and generic starter data (job
     * keywords, price list, email/SMS template wording). Business-identity
     * facts (company name, ABN, bank details, logo, etc.) are NOT seeded
     * from .env — those live in the database and are filled in afterward
     * via Settings > Company Profile.
     */
    protected $signature = 'company:setup {--fresh : Drop all tables and re-migrate before seeding}';

    protected $description = 'Set up a new client deployment: migrate + seed roles, admin user, and starter data';

    public function handle(): int
    {
        $required = ['ADMIN_NAME', 'ADMIN_EMAIL', 'ADMIN_PASSWORD'];
        $missing = array_filter($required, fn ($key) => empty(env($key)));

        if (!empty($missing)) {
            $this->error('Missing required .env values: ' . implode(', ', $missing));
            $this->line('Fill these in .env (see .env.example) before running company:setup.');

            return self::FAILURE;
        }

        if (strlen(env('ADMIN_PASSWORD')) < 12) {
            $this->error('ADMIN_PASSWORD must be at least 12 characters. Set a strong password in .env before running company:setup.');

            return self::FAILURE;
        }

        $this->info('Setting up ' . env('CLIENT_NAME', 'this client') . '...');

        if ($this->option('fresh')) {
            $this->warn('Dropping all tables and re-migrating (--fresh)...');
            $this->call('migrate:fresh');
        } else {
            $this->call('migrate');
        }

        $this->call('db:seed');

        $this->newLine();
        $this->info('Done. Log in with:');
        $this->line('  Email:    ' . env('ADMIN_EMAIL'));
        $this->line('  Password: the ADMIN_PASSWORD you set in .env');
        $this->newLine();
        $this->line('Next steps:');
        $this->line('  1. Log in, then go to Settings > Company Profile and fill in the business details (name, ABN, REC number, bank details, logo paths, etc.) — nothing is pre-filled for a new client.');
        $this->line('  2. Review the seeded Quote Price List and Job Type Keywords under Settings — they\'re a generic electrical starting point, adjust pricing per client.');
        $this->line('  3. Configure a real mail driver and (optionally) an SMS provider in .env before going live — both default to logging only.');

        return self::SUCCESS;
    }
}
