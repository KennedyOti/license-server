<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function licenses()
    {
        return $this->hasMany(License::class);
    }
}
