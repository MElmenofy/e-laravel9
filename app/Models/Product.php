<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $with = ['translations'];
    protected $guarded = [];

    protected $casts = [
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
        ];

    protected $dates = [
        'special_price_start',
        'special_price_end',
        'start_date',
        'end_date',
        'deleted_at',
        ];

    protected $translatedAttributes = [
        'name',
        'description',
        'short_description',
        ];

    public function brand(){
        return $this->belongsTo(Brand::class)->withDefault(); // عشان لو ب null متعملش ايرور ؟؟ ''
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'product_categories'); // many to many
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'product_tags'); // many to many
    }


}
