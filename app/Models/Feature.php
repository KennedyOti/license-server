<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'code',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_features');
    }
}
