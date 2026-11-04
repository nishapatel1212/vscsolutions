<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CompanySetting extends Model
{
    use Auditable;

    protected $fillable = [
        'company_name',
        'abn',
        'rec_number',
        'address',
        'service_area',
        'email',
        'phone',
        'electrician_name',
        'insurance_line',
        'bank_name',
        'bank_account_name',
        'bank_bsb',
        'bank_account_number',
        'payment_reference_note',
        'logo_path',
        'logo_dark_path',
        'favicon_path',
    ];

    const CACHE_KEY = 'company_settings.current';

    /**
     * The one settings row for this deployment, cached so every page that
     * calls company() doesn't hit the database. Falls back to an empty
     * (unsaved) instance if the row doesn't exist yet, so company('x')
     * never throws before setup has run.
     */
    public static function current(): self
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return self::first() ?? new self();
        });
    }

    public static function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected static function booted(): void
    {
        static::saved(fn () => self::forgetCache());
        static::deleted(fn () => self::forgetCache());
    }

    public function auditLabel(): ?string
    {
        return $this->company_name ?? 'Company Settings';
    }
}
