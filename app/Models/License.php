<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'product_id',
        'external_user_id',
        'status',
        'start_date',
        'end_date',
        'plan_id',
        'feature_overrides',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'feature_overrides' => 'array',
            'metadata' => 'array',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function getCombinedFeaturesAttribute()
    {
        $features = collect();

        if ($this->plan) {
            $features = $features->merge($this->plan->features->pluck('code'));
        }

        if ($this->feature_overrides) {
            // Handle overrides - this could be additions or removals
            $overrides = collect($this->feature_overrides);
            $additions = $overrides->get('add', []);
            $removals = $overrides->get('remove', []);

            $features = $features->merge($additions)->diff($removals);
        }

        return $features->unique();
    }
}
