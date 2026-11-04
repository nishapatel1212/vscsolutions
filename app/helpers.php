<?php

use App\Models\CompanySetting;

if (!function_exists('company')) {
    /**
     * Read a business-identity fact for this deployment from the
     * company_settings table (cached) — the DB-backed replacement for the
     * old config('latin.*') calls. Falls back to $default if unset, same
     * shape as Laravel's config() helper.
     *
     * Usage: company('company_name'), company('bank_bsb'), etc.
     */
    function company(string $key, $default = null)
    {
        return CompanySetting::current()->{$key} ?? $default;
    }
}
