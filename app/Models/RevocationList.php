<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevocationList extends Model
{
    protected $fillable = [
        'license_id',
        'revoked_at',
    ];

    protected function casts(): array
    {
        return [
            'revoked_at' => 'datetime',
        ];
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
