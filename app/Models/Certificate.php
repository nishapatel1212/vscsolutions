<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use Auditable;

    protected $fillable = [
        'type',
        'certificate_number',
        'customer_id',
        'safety_check_report_id',
        'client_name',
        'address',
        'issued_date',
        'expiry_date',
        'electrician_name',
        'licence_number',
        'status',
        'notes',
        'signature_path',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function safetyCheckReport()
    {
        return $this->belongsTo(SafetyCheckReport::class);
    }

    public function items()
    {
        return $this->hasMany(CertificateItem::class);
    }

    public static function generateNumber(string $type): string
    {
        $prefix = $type === 'coes' ? 'COES' : 'TNT';
        $year = now()->year;

        $count = static::where('type', $type)
            ->whereYear('created_at', $year)
            ->count() + 1;

        return sprintf('%s-%d-%04d', $prefix, $year, $count);
    }
}
