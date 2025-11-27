<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'industry',
        'api_key',
        'webhook_url',
        'webhook_secret',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function setApiKeyAttribute($value)
    {
        $this->attributes['api_key'] = encrypt($value);
    }

    public function getApiKeyAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // If decryption fails, assume it's plain text (for backward compatibility)
            return $value;
        }
    }

    public function setWebhookSecretAttribute($value)
    {
        $this->attributes['webhook_secret'] = $value ? encrypt($value) : null;
    }

    public function getWebhookSecretAttribute($value)
    {
        if (!$value) {
            return null;
        }
        try {
            return decrypt($value);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // If decryption fails, assume it's plain text
            return $value;
        }
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function webhookDeliveryLogs()
    {
        return $this->hasMany(WebhookDeliveryLog::class);
    }
}
