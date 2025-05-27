<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutomotiveSpecification extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'specification',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
