<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', 'type', 'name', 'standard', 'unit', 'value'
    ];
    
    public function product() {
        return $this->belongsTo(Product::class);
    }
    

}
