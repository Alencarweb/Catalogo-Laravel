<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['code', 'color','enabled','typical_applications','resin', 'image_url', 'description', 'observations'];

    public function automotiveSpecifications()
    {
        return $this->hasMany(AutomotiveSpecification::class);
    }
    
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function physicalProperties()
    {
        return $this->properties()->where('type', 'Physical');
    }

    public function mechanicalProperties()
    {
        return $this->properties()->where('type', 'Mechanical');
    }

    public function impactProperties()
    {
        return $this->properties()->where('type', 'Impact');
    }

    public function thermalProperties()
    {
        return $this->properties()->where('type', 'Thermal');
    }

    public function otherProperties()
    {
        return $this->properties()->where('type', 'Other');
    }

}

